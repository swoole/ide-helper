# Swoole IDE Helper

[![Latest Stable Version](https://poser.pugx.org/swoole/ide-helper/v/stable.svg)](https://packagist.org/packages/swoole/ide-helper)
[![License](https://poser.pugx.org/swoole/ide-helper/license)](LICENSE)
[![Syntax Checks](https://github.com/swoole/ide-helper/actions/workflows/syntax_checks.yml/badge.svg?branch=6.1.x)](https://github.com/swoole/ide-helper/actions/workflows/syntax_checks.yml?query=branch%3A6.1.x)

[Swoole](https://github.com/swoole/swoole-src) is a PHP extension written in C/C++, so its classes, functions, and
constants don't exist as PHP source code anywhere in your project. Without help, your IDE can't see them: no
autocompletion, no parameter hints, no inline documentation, and plenty of "undefined class" warnings.

This package fixes that. It provides fully documented stub files for everything Swoole exposes — every class,
method, function, and constant, with accurate signatures, native type declarations, and PHPDoc descriptions. Once
it's installed, IDEs like PhpStorm and VS Code (with a PHP language server such as Intelephense) pick up the stubs
automatically and give you the same editing experience you'd get with a pure-PHP library.

The stubs under `src/swoole/` contain no real logic: method bodies are empty, or hold a few lines of explanatory
pseudocode (see [Reading the docblocks](#reading-the-docblocks)). Nothing is autoloaded, so the package has zero
runtime footprint.

## Table of contents

* [Installation](#installation)
  * [Choosing a version](#choosing-a-version)
* [Requirements](#requirements)
* [IDE and tool setup](#ide-and-tool-setup)
* [Best practices](#best-practices)
* [What's included](#whats-included)
  * [Features that depend on build options](#features-that-depend-on-build-options)
* [Reading the docblocks](#reading-the-docblocks)
* [PHP configuration settings](#php-configuration-settings)
* [Contributing](#contributing)
* [License](#license)

## Installation

Install it with [Composer](https://getcomposer.org) as a dev dependency:

```bash
composer require --dev swoole/ide-helper
```

Since the package is only there to assist your IDE, it doesn't belong in production; `--dev` keeps it out of
`composer install --no-dev` deployments.

### Choosing a version

<!-- BEGIN: version-examples -->
Releases of this package mirror Swoole releases: version `6.1.11` of this package documents Swoole `v6.1.11`. Note
that this package's tags have no `v` prefix, while Swoole's do. For the most accurate results, use the release that
matches the Swoole version you actually run. You can check your installed version with:

```bash
php --ri swoole | grep Version
```

Then require the matching release, e.g.:

```bash
composer require --dev swoole/ide-helper:~6.1.11
```

The `~6.1.11` constraint installs the newest `6.1.x` release that is `6.1.11` or later, so you pick up documentation
fixes made in later patch releases while staying on the same minor line as your Swoole extension. To pin one exact
release instead, drop the `~` (`swoole/ide-helper:6.1.11`).

Releases for the Swoole 6.1 line (currently `6.1.11`) are made from this package's `6.1.x` maintenance branch, while
the `master` branch tracks the latest Swoole minor line. To use the latest unreleased 6.1 stubs from the `6.1.x`
branch instead:

```bash
composer require --dev swoole/ide-helper:6.1.x-dev
```
<!-- END: version-examples -->

## Requirements

<!-- BEGIN: php-requirements -->
Swoole 6.1 supports PHP 8.1 through 8.4, and so do these stubs: they use PHP 8.1 syntax in their declarations and are
checked against PHP 8.1 through 8.4 in CI. Set your IDE's or static analyzer's PHP language level to 8.1 or later so
it can parse them.

If you're on PHP 8.0 or older (and therefore on Swoole 5.1 or older), use the matching older release line of this
package instead, e.g. `composer require --dev swoole/ide-helper:~5.1.8`. If you're on a newer Swoole version, use
the release line matching it instead; the `master` branch's README describes the latest one.
<!-- END: php-requirements -->

## IDE and tool setup

* **PhpStorm:** PhpStorm ships its own (less complete) Swoole stubs, which conflict with this package and cause
  "multiple definitions exist" warnings. Go to **Settings → PHP**, open the **PHP Runtime** tab, expand **PECL**, and
  uncheck `swoole`, so this package becomes the single source of truth.
* **VS Code (Intelephense):** Intelephense indexes `vendor/` automatically, so no setup is needed. Its own Swoole stubs
  are off by default; if you added `swoole` to the `intelephense.stubs` setting, remove it to avoid duplicate
  definitions.
* **PHPStan / Psalm:** when the Swoole extension isn't loaded in the PHP process that runs the analyzer, point the
  analyzer at `vendor/swoole/ide-helper/src/swoole` (PHPStan's `scanDirectories` option, or Psalm's `<stubs>`
  element), so it knows the Swoole symbols exist.

## Best practices

* **Keep it a dev dependency.** The stubs are for your editor only. They declare no autoloading and execute
  nothing, but there's still no reason to ship them to production.
* **Upgrade the helper when you upgrade Swoole.** Signatures and available symbols change between Swoole releases;
  a mismatched helper version means your IDE may suggest methods that don't exist in your runtime (or miss ones
  that do).
* **Don't `require`/`include` the stub files**, and don't add them to an autoloader or a preload script. If the
  Swoole extension is loaded, redefining its classes would fail; if it isn't, empty method bodies would do nothing
  useful anyway. Just let Composer install the package and let your IDE index it.

## What's included

* `src/swoole/` — stubs for everything implemented in C/C++ by the Swoole extension:
  * all classes under the `Swoole\` namespace (one file per class, e.g. `Swoole\Coroutine\Http\Client`);
  * global `swoole_*()` functions;
  * `SWOOLE_*` constants;
  * short class aliases like `Co\Channel` (active when the `swoole.use_shortname` ini directive is on).
* `src/swoole_library/` — the PHP source of [Swoole Library](https://github.com/swoole/library), the userland
  companion code that ships inside the extension (loaded when `swoole.enable_library` is on). Unlike the stubs, this
  is real, runnable code: a verbatim copy of the Swoole Library release bundled with the matching Swoole version,
  included so your IDE can index these classes too.

### Features that depend on build options

Some Swoole features exist only when the extension is built with a particular configuration option. The stubs declare
them unconditionally, so your IDE offers them even if your Swoole build doesn't include them; each one's docblock says
what it needs. For example:

* `Swoole\Thread` and the rest of the `Swoole\Thread\` namespace: PHP compiled with Zend Thread Safety (ZTS) enabled,
  and Swoole installed with `--enable-swoole-thread`.
* The `swoole_native_curl_*()` functions and the `SWOOLE_HOOK_NATIVE_CURL` hook flag: `--enable-swoole-curl`.
* The coroutine-friendly PDO hook flags (`SWOOLE_HOOK_PDO_PGSQL`, `SWOOLE_HOOK_PDO_ODBC`, `SWOOLE_HOOK_PDO_ORACLE`,
  `SWOOLE_HOOK_PDO_SQLITE`): `--enable-swoole-pgsql`, `--with-swoole-odbc`, `--with-swoole-oracle`, and
  `--enable-swoole-sqlite` respectively.
* Running file operations through io_uring (a Linux facility for asynchronous I/O), and the `SWOOLE_IOURING_*`
  constants: `--enable-iouring`.
* The experimental "stdext" module (calling methods directly on plain strings, arrays, and streams, plus functions
  such as `swoole_typed_array()`): `--enable-swoole-stdext`.

## Reading the docblocks

Besides the standard PHPDoc tags, the stubs use a few conventions you'll see in your IDE's hover popups:

* `@since X.Y.Z` — the Swoole version that added the symbol.
* `@deprecated X.Y.Z <replacement>` — still available, but deprecated since that version; a `@see` tag points at what
  to use instead.
* `@alias` — the symbol is an alias of another one (or has one), e.g. `Swoole\Table::del()` and
  `Swoole\Table::delete()`. Short class names such as `Co\Channel` are noted on the real class, and only exist when
  the `swoole.use_shortname` ini directive is on.
* `@readonly` — the property can be read but not written.
* `@not-serializable` — objects of the class can't be serialized.
* `@pseudocode-included` — the method body contains PHP code that explains what the built-in method does. It's for
  reading only; the real implementation is in C/C++.
* When a method's or function's signature changed between Swoole versions, its docblock shows the old and new
  signatures.
* Usage examples are written as fenced ` ```php ` code blocks inside the description, so IDEs render them with syntax
  highlighting.

## PHP configuration settings

<!-- BEGIN: ini-directives -->
Swoole's behavior can be tuned with the following ini directives (as of Swoole 6.1.11):

| Directive                            | Type    | Default           | Where it can be set |
|--------------------------------------|---------|-------------------|---------------------|
| `swoole.enable_library`              | Boolean | `On`              | Anywhere            |
| `swoole.enable_fiber_mock`           | Boolean | `Off`             | Anywhere            |
| `swoole.enable_preemptive_scheduler` | Boolean | `Off`             | Anywhere            |
| `swoole.display_errors`              | Boolean | `On`              | Anywhere            |
| `swoole.use_shortname`               | Boolean | `On`              | `php.ini` only      |
| `swoole.unixsock_buffer_size`        | Integer | `8388608` (8 MiB) | Anywhere            |

"`php.ini` only" directives can't be changed with `ini_set()` at runtime; set them in a `php.ini` file, or with
`php -d` on the command line.

* `swoole.enable_library`: Load [Swoole Library](https://github.com/swoole/library) (the PHP code under
  `src/swoole_library/`) or not.
* `swoole.enable_fiber_mock`: Make each coroutine look like a PHP Fiber to tools that watch Fibers (e.g. debuggers and
  profilers), so they can follow coroutine switches.
* `swoole.enable_preemptive_scheduler`: Enable the preemptive scheduler or not, which stops a CPU-intensive coroutine
  from running forever without letting others run. It can also be turned on at runtime through the
  `enable_preemptive_scheduler` option of `Swoole\Coroutine::set()`. To understand how it works, please check examples
  under section "CPU-intensive job scheduling" of repository
  [deminy/swoole-by-examples](https://github.com/deminy/swoole-by-examples).
* `swoole.display_errors`: Display/hide error information from Swoole.
* `swoole.use_shortname`: Support short names or not. Short names are all the aliases listed in file
  [src/swoole/shortnames.php](src/swoole/shortnames.php).
* `swoole.unixsock_buffer_size`: Despite its name, the default buffer size (in bytes) of all the sockets Swoole
  creates, including the ones between the master process and the worker processes of a Swoole server.
<!-- END: ini-directives -->

## Contributing

Bug reports and pull requests are welcome. If a stub doesn't match Swoole, please cite the relevant code in
[swoole-src](https://github.com/swoole/swoole-src) at the matching release tag (e.g. `v6.1.11`). A few rules:

* Compare against swoole-src's actual C/C++ source. Don't use the `.stub.php` files shipped in swoole-src as a source;
  they aren't reliable for this work.
* Don't hand-edit `src/swoole_library/`; it's copied from the matching [swoole/library](https://github.com/swoole/library)
  release.
* Inline declarations must be valid PHP 8.1 syntax (the minimum PHP version Swoole 6.1 supports).
* Before submitting, run the same checks as CI:

  ```bash
  # Coding style.
  docker run -q --rm -v "$(pwd):/project" -w /project -i jakzal/phpqa:php8.5-alpine php-cs-fixer fix --dry-run
  # Syntax, under the oldest supported PHP version (newer versions accept syntax that PHP 8.1 rejects).
  docker run -q --rm -v "$(pwd):/project" -w /project -i jakzal/phpqa:php8.1-alpine phplint src
  ```

The full set of stub-writing conventions is in
[CLAUDE.md](https://github.com/swoole/ide-helper/blob/6.1.x/CLAUDE.md).

## License

This package is licensed under the [Apache License 2.0](LICENSE).
