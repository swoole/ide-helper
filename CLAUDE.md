# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this repository is

This package provides IDE helper ("stub") files for [Swoole](https://github.com/swoole/swoole-src), the PHP
coroutine/async C extension. It contains no executable logic of its own — every method body is empty. The sole
purpose of each file is to give IDEs (PhpStorm, VS Code, etc.) accurate autocompletion, type hints, and inline
documentation for classes/functions/constants that are actually implemented in C by the Swoole extension (and, for
one subtree, in the companion `swoole/library` PHP package).

There are two distinct kinds of source under `src/`, and they are maintained very differently:

- `src/swoole/` — pure stubs for the Swoole C extension. Every class/method/function here mirrors a symbol exported
  by the extension. Method/function bodies are always empty (`{ }`); all information lives in PHPDoc blocks.
- `src/swoole_library/` — a verbatim copy of the PHP userland source from https://github.com/swoole/library (the
  `swoole/library` package that ships inside the Swoole extension via `swoole.enable_library`). This is real,
  runnable PHP code, not stubs. It gets updated by copying files over from that upstream repo, not by hand-editing
  individual signatures.

Layout inside `src/swoole/`:
- `constants.php` — all `SWOOLE_*` constant definitions.
- `functions.php` — global `swoole_*()` procedural functions.
- `shortnames.php` — `class_alias()` calls for short names (e.g. `Co\Channel` → `Swoole\Coroutine\Channel`), active
  only when the `swoole.use_shortname` ini directive is on.
- `Swoole/**` — one file per class, in a directory structure mirroring the `Swoole\...` namespace (e.g.
  `Swoole/Coroutine/Http/Client.php` defines `Swoole\Coroutine\Http\Client`).

## Commands

There is no local PHP toolchain expected to be installed (`composer.json` declares no dependencies). CI and local
checks both run through the `jakzal/phpqa` Docker image.

Check coding style (dry run, matches CI):
```bash
docker run -q --rm -v "$(pwd):/project" -w /project -i jakzal/phpqa:php8.5-alpine php-cs-fixer fix --dry-run
```

Auto-fix coding style:
```bash
docker run -q --rm -v "$(pwd):/project" -w /project -i jakzal/phpqa:php8.5-alpine php-cs-fixer fix
```

Check PHP syntax across supported versions (CI runs this for 8.1, 8.2, 8.3, 8.4, and 8.5):
```bash
docker run -q --rm -v "$(pwd):/project" -w /project -i jakzal/phpqa:php8.5-alpine phplint src
```

There is no test suite — correctness here means "the stub's signature/docblock matches upstream Swoole," not
behavior, since no method body ever executes.

`php-cs-fixer` rules are defined in `.php-cs-fixer.dist.php` and explicitly exclude `swoole_library/` (that
directory keeps upstream's own formatting since it's copied verbatim).

## Stub-writing conventions

This is the main recurring task in this repository. When bringing the stubs up to date with a Swoole release,
compare against the actual C source/headers in https://github.com/swoole/swoole-src for that release, and examine
the actual implementation and changes of that PHP class/method/function in the release (and
https://github.com/swoole/library for anything under `src/swoole_library/`). **Never ever** use or trust the
`.stub.php` files shipped in a Swoole release — they are not a reliable source for this work. Then apply these
conventions consistently — they are what every existing file already follows and what reviewers expect:

- **Above all, write for a PHP developer, not a C developer.** Comments/stubs are meant to be easy to understand,
  unless the technical detail being documented genuinely can't be explained accurately in plain, simple words —
  don't reach for jargon or low-level precision the reader didn't ask for.
- **Stay at the PHP level whenever possible.** When accuracy requires mentioning a system call or another piece of
  the underlying implementation (e.g., `msgget(2)`, `ftok(3)`, `mmap()`, a row/hashtable struct layout), phrase it in
  plain language a PHP developer can follow without prior C/POSIX knowledge, and add a `@see` link to a man page or
  other reference so a reader who wants the full technical depth can dig further on their own — the docblock itself
  should not require that background to be understood.
- **Completeness and typing is the baseline, not a special case.** A symbol existing in the stub isn't enough —
  every public property must carry a native PHP type declaration that accurately reflects what swoole-src actually
  stores there (nullable/union types where applicable; never leave a bare, untyped `public $x;` just because the
  underlying C property is loosely typed or populated dynamically), and every property, class constant, method, and
  function needs at least a one-line docblock description, even when nothing else about it warrants a special tag —
  this description requirement applies regardless of visibility (`public`, `protected`, or `private`); only the
  native-type requirement above is scoped to public properties. A docblock made up of only `@tag` lines (`@param`,
  `@return`, `@see`, `@alias`, `@readonly`, `@since`, etc.) and/or a bare `{@inheritDoc}` does **not** satisfy this
  requirement — `{@inheritDoc}` tells a reader nothing without also opening the parent, so there must be an actual
  descriptive sentence of the symbol's own, even when `{@inheritDoc}` or other tags are present too. Likewise, every
  method/function parameter needs a matching `@param` tag (type + description) and every non-`void` return needs an
  `@return` tag (type + description) — a native type declaration on the signature is not a substitute for the
  PHPDoc tag, since the tag is what carries the description. When reviewing a file, treat an undocumented,
  annotations-only, or untyped-but-present member exactly like a missing one: it still needs to be fixed, not
  skipped because "it's already there."
- **Inline type declarations must be valid PHP 8.1 syntax.** This project supports PHP 8.1+ (see the syntax-check
  command above, run against 8.1 through 8.5), so a native type declaration that only PHP 8.2+ understands — a
  standalone `true`/`false`/`null` type, or a DNF (disjunctive normal form) type like `(A&B)|C` — would break on the
  oldest supported version and must never be used inline. When swoole-src's real, fully-accurate type needs one of
  those constructs, fall back to the closest PHP-8.1-compatible native type instead (e.g., `bool` in place of a
  standalone `false`), or omit the native type declaration entirely if nothing 8.1-compatible fits, and document the
  precise type via a `@param`/`@return` tag instead — PHPDoc's type syntax isn't constrained by what a given PHP
  version can parse inline.
- **New class/method/function/constant**: add an `@since X.Y.Z` tag (see existing usage in `functions.php` and
  `constants.php` for the exact placement — as a PHPDoc tag for methods/functions/classes, or as a trailing
  `// @since X.Y.Z` line comment for `define()` constants).
- **Deprecated but still-present class/method/function/constant**: when swoole-src still exports a symbol but flags
  it as deprecated (e.g., it triggers an `E_DEPRECATED` notice at runtime, or upstream's own docs/changelog call it
  deprecated), add a `@deprecated X.Y.Z <what to use instead>` tag — same placement rule as `@since` (a PHPDoc tag
  for classes/methods/functions, or a trailing `// @deprecated X.Y.Z ...` line comment for `define()` constants) —
  plus a `@see` tag pointing at the replacement, so a reader lands on the alternative regardless of which symbol they
  open first (see `Swoole\Event::rshutdown()` for an existing example). Use the PHPDoc tag, not PHP 8.4's native
  `#[\Deprecated]` attribute: like the standalone-type/DNF constructs above, that attribute isn't understood by this
  project's minimum supported version (PHP 8.1), while the PHPDoc tag is version-independent and already understood
  by every IDE/tool this project targets. This is distinct from the "Removed" rule below: only mark something
  `@deprecated` while swoole-src still exports it — once swoole-src actually removes the symbol, delete the stub
  outright instead of leaving a deprecated stub behind.
- **Changed method/function arguments**: don't just silently update the signature — add a comment documenting what
  the signature looked like before and what it looks like now, so readers can see the history at a glance.
- **Non-serializable classes**: add `@not-serializable Objects of this class cannot be serialized.` in the class-level
  docblock (see `Swoole\Table` for an example).
- **Readonly properties**: add a `@readonly` tag in the property's docblock (see `Swoole\Process::$pid` or
  `Swoole\Coroutine\Socket::$fd` for examples).
- **Methods/functions explainable via pseudocode**: include a PHP implementation in the body annotated with
  `@pseudocode-included This is a built-in method in Swoole. The PHP code included inside this method is for
  explanation purpose only.` (see `Swoole\Runtime::enableCoroutine()`).
- **Sample/usage code in a docblock**: use a Markdown fenced code block (` ```php ... ``` `) inline in the
  description, not the `@example` tag. `@example` is meant to point at a separate example *file* (phpDocumentor's
  documented meaning for the tag), which this repo doesn't have; a fenced block, by contrast, is the convention that
  actually renders with syntax highlighting in PhpStorm/VS Code hover tooltips and in phpDocumentor output, since
  both parse the description as Markdown. Lead into it with a short clause ending in "e.g.,", and place it as part
  of the flowing description (before any tags), not off to the side after `@return`/`@since`/etc. (see
  `Swoole\Http\Cookie` or `Swoole\Http\Request::$cookie` for examples).
- **Removed class/method/function/constant**: delete it outright — do not deprecate or leave stale stubs behind.
- **Symbols gated behind a build option**: document the requirement plainly in the header/docblock, e.g. for
  `\Swoole\Thread\Atomic`: "This class is available only when PHP is compiled with Zend Thread Safety (ZTS) enabled
  and Swoole is installed with the `--enable-swoole-thread` configuration option." Follow the same phrasing pattern
  for other `--enable-*`/`--with-*` gated features (see the `SWOOLE_HOOK_PDO_*` constants in `constants.php` for
  more examples of build-flag-gated symbols).
- **Aliases**: when a method/function/class is an alias of another one (or has one), add both an `@alias` tag and a
  `@see` tag to the docblocks of *both* sides of the pair, so a reader lands on the same information regardless of
  which one they open first. The `@alias` wording differs depending on which side is being documented (e.g., "This
  method has an alias of ..." vs. "Alias of method ..."; see `Swoole\Table::del()`/`Swoole\Table::delete()` for a
  method pair, and `swoole_mime_type_get()`/`swoole_get_mime_type()` in `functions.php` for a function pair). For a
  class that is aliased via `class_alias()` in `shortnames.php`, add `@alias`/`@see` only on the real class, worded
  as conditional on the `swoole.use_shortname` ini directive (see `Swoole\Coroutine\Channel` for an example, since it
  has two shortname aliases).
- Cross-reference other related symbols with `@see` tags too (interface methods being implemented, related
  classes/constants, etc.) — this is used heavily throughout the codebase and helps IDE users navigate.
- **Inherited methods explicitly re-listed in a child class**: if a method is inherited from a parent class but the
  child class explicitly lists it too, add a `{@inheritDoc}` line in its docblock.
- **Group same-type PHPDoc tags together within a comment block**, rather than interleaving different tag types line
  by line. For example, change:
  ```text
  /**
   * @see classA
   * @alias Alias of function functionA.
   * @see classB
   * @alias Alias of function functionB.
   */
  ```
  to:
  ```text
  /**
   * @see classA
   * @see classB
   * @alias Alias of function functionA.
   * @alias Alias of function functionB.
   */
  ```
- **`@see` tags pointing at a line of code in a tagged swoole-src release** (e.g.
  `@see https://github.com/swoole/swoole-src/blob/v6.0.2/ext-src/swoole_server.cc#L53`, as used in
  `Swoole\Server::on()`): when bringing stubs up to date with a new release, re-verify every such link against that
  release's tag and update both the version segment of the URL and the line number — the referenced code routinely
  moves to a different line even when it hasn't changed conceptually, so don't just bump the tag without checking
  the line still points at the right place.
- After editing, run the coding style and syntax check commands above before committing.
