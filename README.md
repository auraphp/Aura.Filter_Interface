# Aura.Filter_Interface

An interface package for wrapping different implementations of validation and sanitizing systems.

## Package Scope

This package defines contracts. It ships exactly one concrete class,
`FilterResult`, and that is a deliberate, bounded exception rather than a
precedent.

The boundary is set by [Aura's core principles][about]. The base rule is that
library packages are "decoupled, not only from any particular framework, but
also from each other". Aura 3.x relaxes it only so far:

> Under the relaxed rule, an Aura library may depend on an interface package,
> but not on an implementation.

That exception exists to preserve the decoupling, not to create a back door
around it. So the test for shipping a concrete class here is **does it carry
behavior?** A tuple carries none. A data structure with algorithms in it is an
implementation, and libraries may not depend on one — no matter which package
it is published from.

`FilterResult` passes. `FilterInterface::apply()` is declared to return a
`FilterResultInterface`, so every implementation must return *something*, and
that something is three readonly properties behind three accessors, with no
branching and nothing to decide. Shipping it prescribes nothing about how
anyone filters; it only names the shape of a value the interface already
requires.

`FailureCollection` does not pass, and this is worth stating plainly because
the two implementations in `aura/filter` and `aura/input` are very nearly
identical — near enough that sharing them looks like obvious cleanup. It is
not. Such a class holds real logic: dot-notation path splitting, nested-message
construction, storage decisions. `getNestedMessages()` does not describe a
shape, it *decides* one. Publishing that here would make both packages depend
on a shared implementation of failure storage, coupling them to each other's
semantics through this package — precisely the coupling the base rule exists to
prevent. It would also nudge every third-party implementation toward the same
class, which is how an interface package quietly becomes the framework that
[3.x set out not to provide][about].

Concrete `Failure` classes stay with the implementing packages for the weaker
but sufficient reason that nothing forces them here: implementations mint their
own failures and return them behind `FailureInterface`.

Note also that `FilterResult` is not `final`. Its immutability comes from
`readonly` properties, and callers wanting different behavior should implement
`FilterResultInterface` directly.

[about]: https://github.com/auraphp/auraphp.github.io/blob/master/about.md

## Installation and Autoloading

This package is installable and PSR-4 autoloadable via Composer as
[aura/filter-interface][].

Alternatively, [download a release][], or clone this repository, then map the
`Aura\Filter_Interface\` namespace to the package `src/` directory.

## Dependencies

This package requires PHP 8.4 or later, and has no other dependencies. We
recommend using the latest available version of PHP as a matter of principle.

## Quality

This project adheres to [Semantic Versioning](http://semver.org/).

This package attempts to comply with [PSR-1][], [PSR-2][], and [PSR-4][]. If
you notice compliance oversights, please send a patch via pull request.

## Community

To ask questions, provide feedback, or otherwise communicate with other Aura
users, please join our [Google Group][], follow [@auraphp][], or chat with us
on Freenode in the #auraphp channel.

## Documentation

This package is fully documented [here](./docs/index.md).

[PSR-1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[PSR-2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[PSR-4]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md
[Google Group]: http://groups.google.com/group/auraphp
[@auraphp]: http://twitter.com/auraphp
[download a release]: https://github.com/auraphp/Aura.Filter_Interface/releases
[aura/Filter-interface]: https://packagist.org/packages/aura/filter-interface
[composer.json]: ./composer.json
