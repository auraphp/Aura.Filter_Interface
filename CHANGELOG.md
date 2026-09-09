# CHANGELOG

## 7.0.0

### Breaking Changes

- PHP 8.4+ is now required (up from PHP >= 5.3.0 in 3.x).
- `FilterInterface::apply()` signature changed from `apply(&$values): bool` to `apply(array|object $values): FilterResultInterface`. The method no longer takes `$values` by reference and no longer returns `bool`; it returns a `FilterResultInterface` value object carrying the success flag, the sanitized values, and a `FailuresInterface`. Implementations must never mutate the caller's original subject.
- `FilterInterface::getFailures()` has been removed. Failures are now retrieved from the `FilterResultInterface` returned by `apply()`.
- `FailureCollectionInterface` has been redesigned and now `extends FailuresInterface`. It is the write-side interface used internally by filter implementations while building the collection during a filter run.
  - REMOVED: `isEmpty()` — moved to `FailuresInterface` (read side).
  - REMOVED: `addMessagesForField($field, $messages)` — replaced by `add(string $field, string $message, array $args = []): FailureInterface`.
  - REMOVED: `getMessagesForField($field)` — replaced by `forField(string $field)` on `FailuresInterface`.
  - REMOVED: `getMessages()` — moved to `FailuresInterface` and now returns `array<string, string[]>` keyed with dot-notation paths.
  - ADDED: `add(string $field, string $message, array $args = []): FailureInterface` — adds an additional failure on a field.
  - ADDED: `set(string $field, string $message, array $args = []): FailureInterface` — sets a failure on a field, replacing all previous failures for that field.
- All interfaces now declare `strict_types=1` and use full PHP 8.4 type declarations (typed parameters and return types) throughout.
- Package `description` in `composer.json` updated to "Interfaces and shared value objects for validation and sanitization libraries".

### New Features

- ADD: `FailureInterface` — represents a single rule-specification failure. Exposes `getField(): string`, `getMessage(): string`, and `getArgs(): array`. Extends `JsonSerializable`.
- ADD: `FailuresInterface` — read-only view of a failure collection that consumers are typed against. Methods:
  - `isEmpty(): bool`
  - `forField(string $field): array` — failures for a flat field name (`FailureInterface[]`).
  - `forPath(string $path): array` — failures at a dot-notation path (e.g. `address.city`, `items.0.name`).
  - `getMessages(): array` — flat map of field/path → `string[]` of messages, dot-notation keyed.
  - `getNestedMessages(): array` — nested map mirroring the original input structure (e.g. `['address' => ['city' => ['City is required']]]`).
- ADD: `FilterResultInterface` — value object returned by `FilterInterface::apply()`. Methods: `isSuccess(): bool`, `getValues(): array|object`, `getFailures(): FailuresInterface`. The original subject passed to `apply()` is never mutated.
- ADD: `FilterResult` — shared concrete `final` implementation of `FilterResultInterface`, using PHP 8 readonly constructor-promoted properties. Used by `aura/filter` and `aura/input` so both libraries return the same value object.
- ADD: `SubjectFilterInterface` — extends `FilterInterface` and adds `subfilter(string $field, string $subClass = ''): SubjectFilterInterface` for composing nested filters over sub-objects / sub-arrays (multidimensional support). Returns the sub-filter for fluent configuration.

## 3.0.0

- Update license year.

## 3.0.0-alpha1

- Initial release.
