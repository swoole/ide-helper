# Swoole IDE Helper

[![Latest Stable Version](https://poser.pugx.org/swoole/ide-helper/v/stable.svg)](https://packagist.org/packages/swoole/ide-helper)
[![License](https://poser.pugx.org/swoole/ide-helper/license)](LICENSE)

[Swoole](https://github.com/swoole/swoole-src) is a PHP extension written in C/C++, so its classes, functions, and
constants don't exist as PHP source code anywhere in your project. Without help, your IDE can't see them: no
autocompletion, no parameter hints, no inline documentation, and plenty of "undefined class" warnings.

This package fixes that. It provides fully documented stub files for everything Swoole exposes — every class,
method, function, and constant, with accurate signatures, native type declarations, and PHPDoc descriptions. Once
it's installed, IDEs like PhpStorm and VS Code (with a PHP language server such as Intelephense) pick up the stubs
automatically and give you the same editing experience you'd get with a pure-PHP library.

The stubs contain no executable logic — every method body is empty — so the package has zero runtime footprint.

## Installation

Install it with [Composer](https://getcomposer.org) as a dev dependency:

```bash
composer require --dev swoole/ide-helper
```

Since the package is only there to assist your IDE, it doesn't belong in production; `--dev` keeps it out of
`composer install --no-dev` deployments.

### Match the version to your Swoole extension

Releases of this package mirror Swoole releases: version `6.0.2` of this package documents Swoole `v6.0.2`. For the
most accurate results, pin the package to the Swoole version you actually run. You can check your installed version
with:

```bash
php --ri swoole | grep Version
```

Then require the matching release, e.g.:

```bash
composer require --dev swoole/ide-helper:~6.0.2
```

To use the latest unreleased stubs from the `master` branch instead:

```bash
composer require --dev swoole/ide-helper:@dev
```

## Best practices

* **Keep it a dev dependency.** The stubs are for your editor only. They declare no autoloading and execute
  nothing, but there's still no reason to ship them to production.
* **Upgrade the helper when you upgrade Swoole.** Signatures and available symbols change between Swoole releases;
  a mismatched helper version means your IDE may suggest methods that don't exist in your runtime (or miss ones
  that do).
* **PhpStorm users: disable the bundled Swoole stubs.** PhpStorm ships its own (less complete) Swoole stubs, which
  conflict with this package and cause "multiple definitions exist" warnings. Go to **Settings → PHP → Stubs** and
  deselect `swoole`, so this package becomes the single source of truth.
* **Don't `require`/`include` the stub files.** If the Swoole extension is loaded, redefining its classes would
  fail; if it isn't, empty method bodies would do nothing useful anyway. Just let Composer install the package and
  let your IDE index it.

## What's included

* `src/swoole/` — stubs for everything implemented in C/C++ by the Swoole extension:
  * all classes under the `Swoole\` namespace (one file per class, e.g. `Swoole\Coroutine\Http\Client`);
  * global `swoole_*()` functions;
  * `SWOOLE_*` constants;
  * short class aliases like `Co\Channel` (active when the `swoole.use_shortname` ini directive is on).
* `src/swoole_library/` — the PHP source of [Swoole Library](https://github.com/swoole/library), the userland
  companion code that ships inside the extension (loaded when `swoole.enable_library` is on). Included so your IDE
  can index these classes too.

## PHP configuration settings

Swoole's behavior can be tuned with the following ini directives:

* `swoole.display_errors`: Boolean. Default `On`. Display/hide error information from Swoole.
* `swoole.enable_coroutine`: Boolean. Default `On`. Turn on/off coroutine support.
* `swoole.enable_library`: Boolean. Default `On`. Load the source code from [Swoole Library](https://github.com/swoole/library) or not.
* `swoole.enable_preemptive_scheduler`: Boolean. Default `Off`. Enable preemptive scheduler or not. To understand how it works, please check examples under section "CPU-intensive job scheduling" of repository [deminy/swoole-by-examples](https://github.com/deminy/swoole-by-examples).
* `swoole.unixsock_buffer_size`: Integer (in bytes). By default, it's 256 KiB on Macintosh or FreeBSD, otherwise 8 MiB. The total buffer sizes for the socket connections between the master process and the worker processes in Swoole.
* `swoole.use_shortname`: Boolean. Default `On`. Support short names or not. Short names are all the aliases listed in file [src/swoole/shortnames.php](src/swoole/shortnames.php).

All the directives can be set anywhere except `swoole.use_shortname`, which can only be set in `php.ini` files.

## Contributing with Claude Code

This repository includes three [Claude Code](https://claude.com/claude-code) agents under `.claude/agents/` to help
maintain the stubs. They're repository-maintenance tooling only — end users installing this package via Composer
never see them (`.claude/` and `CLAUDE.md` are excluded from the published package archive).
`prepare-swoole-release` and `deep-review-swoole-stubs` are useful to any contributor; `publish-swoole-release` is
for project maintainers only, since it publishes a live GitHub release.

* **`prepare-swoole-release`** — prepares this project's stub changes for a new, stable Swoole release. Give it the
  target version; it diffs [swoole-src](https://github.com/swoole/swoole-src) between the version this project
  currently supports and the target version, updates only the stubs affected by that diff, replaces
  `src/swoole_library/` with the matching [swoole/library](https://github.com/swoole/library) release, and leaves
  the result as a local commit (it never tags or pushes anything).

  > Prepare the stubs for Swoole 6.1.0.

* **`publish-swoole-release`** — tags and publishes a GitHub release for a version already prepared with the agent
  above. It never marks a release as a pre-release, and never marks it as this project's "latest" release. This
  agent pushes a tag and publishes a live release, so only invoke it once you're ready to make the release public.
  **For project maintainers only** — regular contributors shouldn't need (or be able) to publish a release.

  > Publish the 6.1.0 release.

* **`deep-review-swoole-stubs`** — a full, symbol-by-symbol accuracy audit of the stubs against the Swoole version
  this project *currently* supports (not a version bump). It walks every constant, function, class, and method in
  the matching swoole-src release, fixing anything missing, incomplete, incorrect, or hard to read, following the
  conventions documented in `CLAUDE.md`. Given the scope (60+ class files), it tracks progress across multiple
  invocations and works alone unless you explicitly ask it to use a team of agents.

  > Do a deep review of the Swoole stubs.
  >
  > Do a deep review of the Swoole stubs, using a team of agents.

Just describe the task in a prompt to Claude Code (as in the examples above) and it will pick the matching agent, or
name one explicitly, e.g. `Use the prepare-swoole-release agent to prepare the stubs for Swoole 6.1.0.`
