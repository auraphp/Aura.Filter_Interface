# Aura.Filter_Interface

An interface package for wrapping different implementations of validation and sanitizing systems.

## Package Scope

This package defines contracts. It ships exactly one concrete class,
`FilterResult`, and that is a deliberate, bounded exception rather than a
precedent.

`FilterInterface::apply()` is declared to return a `FilterResultInterface`, so
every implementation must return *something*. `FilterResult` is a tuple — three
readonly properties, three accessors, no decisions — and there is no such thing
as a legitimately different implementation of it. Shipping it here does not
prescribe how anyone filters; it only names the shape of a value the interface
already requires. The alternative was an identical twenty-line class duplicated
in every implementing package.

Anything with real behavior stays out. Concrete `Failure` and
`FailureCollection` classes in particular belong to the implementing packages:
`aura/filter` stores `FailureInterface` objects and retains rule arguments,
while `aura/input`'s closure-based filter stores plain message strings and has
no arguments to record. That divergence is genuine, so those classes are not
shared.

The test for adding another concrete class here is therefore: **can it vary?**
If two reasonable implementations could differ, it does not belong in this
package.

Note also that `FilterResult` is not `final`. Its immutability comes from
`readonly` properties, and callers wanting different behavior should implement
`FilterResultInterface` directly.

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
