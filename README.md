# Swoole IDE Helper

[![Twitter](https://badgen.net/badge/icon/twitter?icon=twitter&label)](https://twitter.com/phpswoole)
[![Discord](https://badgen.net/badge/icon/discord?icon=discord&label)](https://discord.swoole.dev)
[![Latest Stable Version](https://poser.pugx.org/swoole/ide-helper/v/stable.svg)](https://packagist.org/packages/swoole/ide-helper)
[![License](https://poser.pugx.org/swoole/ide-helper/license)](LICENSE)

This package contains IDE help files for [Swoole](https://github.com/swoole/swoole-src). You may use it in your IDE to provide accurate autocompletion. 

## Install

You can add this package to your project using [Composer](https://getcomposer.org):

```bash
composer require swoole/ide-helper:~5.0.0
# or
composer require --dev swoole/ide-helper:~5.0.0
```

To use the latest stubs from the `master` branch:

```bash
composer require swoole/ide-helper:@dev
# or
composer require --dev swoole/ide-helper:@dev
```

## PHP Configuration Settings

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
