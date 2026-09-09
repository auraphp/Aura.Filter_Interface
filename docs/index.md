# Aura.Filter_Interface

This package defines the contracts that let validation and sanitizing systems be
swapped for one another. It contains no filtering logic of its own — only the
interfaces an implementation must satisfy, plus one shared value object,
_FilterResult_, whose presence is explained under
[Package Scope](../README.md#package-scope).

Two first-party packages implement these contracts: [aura/filter][], a rule-based
filter for arrays and objects, and [aura/input][], whose closure-based filter
applies rules to form fieldsets.

## The Contracts

| Interface | Role |
| --- | --- |
| `FilterInterface` | Applies rules to a subject and returns a result. |
| `SubjectFilterInterface` | A `FilterInterface` that also filters nested fields. |
| `FilterResultInterface` | What `apply()` returns: outcome, values, failures. |
| `FailuresInterface` | Read-only view of the failures. What consumers type against. |
| `FailureCollectionInterface` | The write side, used while a filter run builds the collection. |
| `FailureInterface` | A single failure: field, message, rule arguments. |

## FilterInterface

The entire contract is one method:

```php
public function apply(array|object $values): FilterResultInterface;
```

`apply()` takes an array or an object and returns a result. It does not return a
boolean, and it does not take the subject by reference.

```php
$result = $filter->apply($data);

if ($result->isSuccess()) {
    $clean = $result->getValues();
} else {
    foreach ($result->getFailures()->getMessages() as $field => $messages) {
        echo "{$field}: " . implode(', ', $messages) . PHP_EOL;
    }
}
```

Read the filtered data from `$result->getValues()`, never from the variable you
passed in. See [Mutation Semantics](#mutation-semantics) for why that matters.

## FilterResultInterface

```php
public function isSuccess(): bool;
public function getValues(): array|object;
public function getFailures(): FailuresInterface;
```

`getValues()` returns the subject after sanitizing rules have run, typed to match
what went in: an array in yields an array out, an object in yields an object out.
When no sanitizing rules ran, it is equivalent to the input.

`getFailures()` always returns a collection, never `null`. On success that
collection is empty, so `isSuccess()` and `getFailures()->isEmpty()` agree.

The package ships a concrete _FilterResult_ implementing this interface, so
implementations need not write their own:

```php
use Aura\Filter_Interface\FilterResult;

return new FilterResult($failures->isEmpty(), $values, $failures);
```

It is immutable — its three properties are `readonly` — but it is not `final`.
An implementation needing genuinely different behavior should implement
`FilterResultInterface` rather than extend _FilterResult_.

## Failures

The failure contracts are split by direction. Consumers read; implementations
write.

### Reading: FailuresInterface

```php
public function isEmpty(): bool;
public function forField(string $field): array;      // FailureInterface[]
public function forPath(string $path): array;        // FailureInterface[]
public function getMessages(): array;                // ['field' => ['msg', ...]]
public function getNestedMessages(): array;          // ['address' => ['city' => [...]]]
```

Type your application code against this interface. It is what
`FilterResultInterface::getFailures()` returns.

`getMessages()` gives a flat map of message strings, keyed by field name or
dot-notation path. `getNestedMessages()` returns the same information shaped like
the input data, which is usually what you want when rendering a nested form:

```php
// getMessages()
['address.city' => ['City is required.']]

// getNestedMessages()
['address' => ['city' => ['City is required.']]]
```

`forField()` and `forPath()` return _FailureInterface_ objects rather than
strings, for when you need the rule arguments as well as the message. They are
the same operation — failures are stored under their full path, so `forPath()` is
the name to reach for when that path is nested.

### Dot-notation paths

Failures from nested subjects are keyed by their full path, joined with `.`:

```
address.city
phone_numbers.2.number
```

Numeric segments are collection offsets. The full path is used rather than the
leaf field name so that failures from two different sub-filters sharing a child
name — `address.city` and `shipping.city` — stay distinguishable instead of
collapsing onto `city`.

### Writing: FailureCollectionInterface

```php
interface FailureCollectionInterface extends FailuresInterface
{
    public function add(string $field, string $message, array $args = []): FailureInterface;
    public function set(string $field, string $message, array $args = []): FailureInterface;
}
```

`add()` appends a failure, so a field may carry several. `set()` replaces every
failure previously recorded for that field. Both return the _FailureInterface_
they created.

Because it extends `FailuresInterface`, a collection satisfies both sides at
once: a filter builds it through `add()`/`set()` during a run, then hands it to
the caller as a read-only `FailuresInterface`.

This package deliberately ships no concrete collection — see
[Package Scope](../README.md#package-scope). Implementations provide their own,
and their storage legitimately differs.

### FailureInterface

```php
public function getField(): string;
public function getMessage(): string;
public function getArgs(): array;
```

It also extends `JsonSerializable`, so failures can be serialized directly for an
API response.

`getArgs()` returns the arguments the rule was configured with. Implementations
whose rules take no arguments — closure-based filters, typically — return an
empty array.

## SubjectFilterInterface

For filters that understand nested subjects:

```php
public function subfilter(string $field, string $subClass = ''): SubjectFilterInterface;
```

`subfilter()` registers a filter for the value of `$field` and returns it, so
rules can be configured fluently on the sub-filter. Passing `$subClass` selects a
specific filter class; omitting it uses the same concrete class as the parent.

Failures raised by a sub-filter surface on the parent result under the dot-notation
path described above.

## Mutation Semantics

**Always read filtered data from `$result->getValues()`.** Whether the object you
passed to `apply()` was also modified is not something this interface guarantees,
and the two first-party implementations genuinely differ:

- [aura/filter][] treats the subject as immutable. Objects are filtered on a
  clone and arrays are copied by value, so the variable you passed in is
  unchanged. Note the clone is shallow — objects nested inside the subject are
  still shared with the original.
- [aura/input][] filters a _Fieldset_ in place. The fieldset *is* the subject,
  and its rules write back through the object handle, so the fieldset you passed
  in is modified and `getValues()` returns that same instance.

Both satisfy the contract, because the contract is about the result rather than
about the input. Code that reads from `getValues()` is correct against either;
code that assumes one mutation behavior is not portable.

## Implementing the Interfaces

A minimal implementation needs to do three things: build a collection satisfying
`FailureCollectionInterface`, record failures into it, and return a
`FilterResultInterface`.

```php
use Aura\Filter_Interface\FilterInterface;
use Aura\Filter_Interface\FilterResult;
use Aura\Filter_Interface\FilterResultInterface;

class MyFilter implements FilterInterface
{
    public function apply(array|object $values): FilterResultInterface
    {
        $failures = new MyFailureCollection();
        $subject  = is_object($values) ? clone $values : $values;

        // ... apply rules to $subject, calling $failures->add() on each failure

        return new FilterResult($failures->isEmpty(), $subject, $failures);
    }
}
```

Reuse the shipped _FilterResult_; write your own failure collection.

[aura/filter]: https://github.com/auraphp/Aura.Filter
[aura/input]: https://github.com/auraphp/Aura.Input
