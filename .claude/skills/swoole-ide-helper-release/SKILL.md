---
name: swoole-ide-helper-release
description: >
  Use when the user wants to tag and publish a new GitHub release of this project for a specific, already-prepared
  Swoole release, e.g. "publish the 6.1.0 release" or "tag and release 6.0.3". Give it the target version in this
  project's own format (no "v" prefix, e.g. "6.1.0"). This performs real, public, irreversible actions — it creates
  and pushes a git tag, and publishes a live GitHub release — so only run it once the corresponding stub changes have
  already been prepared (e.g. via the prepare-swoole-release agent) and are sitting on `master`. It never marks a
  release as a pre-release, and never marks it as this project's "latest" release. This is for project maintainers
  only, not regular contributors — publishing a release is a maintainer decision, and doing so typically requires
  push/release permissions on the repository that regular contributors don't have anyway.
argument-hint: [target-version]
disable-model-invocation: true
allowed-tools: Bash(git:*), Bash(curl:*), Bash(env -u GH_TOKEN gh:*), Bash(grep:*), Bash(head:*), Bash(sort:*), Bash(jq:*), Read
---

You tag and publish a GitHub release of this project for one specific, already-prepared Swoole version. You do not
prepare stub changes yourself (that's `prepare-swoole-release`'s job) and you do not perform a broader stub audit
(that's a separate deep-review agent's job). Your job is narrow and mechanical: verify the prerequisites, create the
git tag, and publish the GitHub release with the right template and the right flags.

This is for project maintainers only — publishing a release is a maintainer decision, not something a regular
contributor should trigger.

**This is a high-stakes, irreversible workflow — stay visible, don't run ahead.** Unlike a background agent, you're
running inline in this conversation specifically so the user can see each step before it happens. Do not chain
Step 0 → Step 1 → Step 2 without pausing. After Step 0, show the user a short summary of what you verified and what
you're about to do (the exact tag name, the exact release body), and wait for explicit confirmation before running
anything in Step 1. Do the same again before Step 2 — pushing the tag and publishing the release are two separately
irreversible actions and each deserves its own go-ahead.

**Naming mismatch to keep straight throughout:** Swoole's own releases are tagged `vX.Y.Z` on
`https://github.com/swoole/swoole-src` (with a leading "v"). This project's own releases are tagged `X.Y.Z` — no
leading "v" (check `git tag --list`, e.g. `6.0.2`, not `v6.0.2`). Do not confuse the two: when checking Swoole's own
tags, look for the "v"-prefixed form; when creating or checking this project's own tag/release, use the
un-prefixed form.

# Input

This skill takes a single argument, the target version — the Swoole version whose already-prepared stubs are being
published as a release of this project:

```
/swoole-ide-helper-release 6.1.0
```

It must be written in this project's own release format: a plain `X.Y.Z`, with no leading "v" and no prerelease
suffix (Step 0 validates this and stops on anything else). Throughout the steps below, this argument is what the
shell variable `TARGET_VERSION` gets assigned to — every code block starts by re-assigning it with a `6.1.0`
placeholder, and you substitute the version you were actually given.

# Step 0: validate every prerequisite before touching anything

If the user's invocation didn't include a target version, stop and ask for one. Accept only a plain `X.Y.Z` — if the
target carries a suffix like `-alpha`, `-beta`, or `-rcN`, stop and say so. Those tags really do exist upstream
(`v6.0.0-rc1`, for instance), so check 1 below would find one and wave it through, and this workflow has no way to
publish it correctly: it always publishes with `prerelease: false`.

None of the checks below match the version with a regex, so nothing here needs the dots in `6.1.0` escaped. Keep it
that way: an unescaped `.` in a regex matches *any* character, which is how a check meant to fail closed turns into
a false-positive match instead.

**Every Bash call runs in its own fresh shell — variables do not survive from one command to the next.** That's why
each block below re-assigns `TARGET_VERSION`; substitute the real version for the `6.1.0` placeholder, and keep that
line when you run the block. A missing or empty version must halt the run rather than
sail past: the refspec in check 1 matches no tag, `grep -F "refs/tags/"` matches every tag in check 2, and
`git tag -a ""` is a fatal error in Step 1. Not every command shares that fail-closed property — check 2's `curl`
fallback, handed an empty version, returns "Not Found" and reads as "all clear" — which is exactly why the up-front
"stop and ask for a version" gate and check 1 come first and must stay first. Keep all of that as it is — don't
"simplify" a fail-closed check into one that would report "nothing found, all clear" when the version it was handed
was blank, and don't reorder the checks so a fail-open one runs before check 1.

1. **Hard prerequisite — the version must actually exist as a real Swoole release.** Check the real swoole-src repo
   for a tag matching the target version, with the "v" prefix. Pass the ref as a pattern and let git do the exact
   matching, rather than filtering the full tag list through `grep`:
     ```bash
     TARGET_VERSION=6.1.0 # substitute the version you were given
     git ls-remote --tags https://github.com/swoole/swoole-src.git "refs/tags/v${TARGET_VERSION}"
     ```
   The pattern is glob-matched against the whole ref, so a dot is a literal dot and no escaping is involved.
   **If no such tag is found, stop immediately, explain clearly which version is missing, and do not create, push,
   or publish anything.** Because the match is exact, a plain `X.Y.Z` target can never be satisfied by a
   `vX.Y.Z-alpha`/`-beta`/`-rcN` tag — but note that this cuts only one way: it stops a stable target from latching
   onto a prerelease tag, and does nothing about a prerelease target, which is why that's rejected up front instead.

2. **This project must not already have a release for that version.** Check the remote tag, any stale local tag
   left over from a prior aborted run, and the GitHub release, using this project's own un-prefixed naming:
     ```bash
     TARGET_VERSION=6.1.0 # substitute the version you were given
     git ls-remote --tags origin | grep -F "refs/tags/${TARGET_VERSION}"
     git tag --list | grep -Fx "${TARGET_VERSION}"
     env -u GH_TOKEN gh release view "${TARGET_VERSION}" --repo swoole/ide-helper
     ```
   These two deliberately use fixed-string `grep` instead of check 1's exact refspec, because here an exact match
   would fail in the *wrong* direction: `git ls-remote --tags origin "refs/tags/${TARGET_VERSION}"` with an empty
   version matches nothing and reports "not released yet" for a version that may well be released already. With
   `grep -F`, an empty version collapses the pattern to `refs/tags/`, which matches every tag and stops the run —
   the harmless direction to be wrong in. Being a substring match, the remote check also picks up the
   `refs/tags/X.Y.Z^{}` line git prints for an annotated tag (same tag, no problem), and would flag a longer tag
   starting with the same digits (`6.1.1` against a hypothetical `6.1.10`) — so read the output before concluding a
   release exists, but err toward stopping.
   For a version that genuinely hasn't been released yet, all three are supposed to come up empty-handed: both
   `grep`s exit `1` printing nothing, and `gh release view` exits non-zero with "release not found". No output is
   the pass condition here, not a sign the check failed to run.
   If a local tag exists but was never pushed (i.e. it's absent from `git ls-remote --tags origin` above), that's
   most likely debris from a previous failed attempt at this same version — tell the user and confirm before
   deleting it with `git tag -d "${TARGET_VERSION}"`, rather than letting Step 1's `git tag -a` fail on an
   "already exists" error.
   Always run `gh` through `env -u GH_TOKEN`, as shown above: a fine-grained personal access token sitting in
   `$GH_TOKEN` would otherwise override `gh`'s own stored login, and the swoole organization rejects such tokens
   ("the 'swoole' organization forbids access via a fine-grained personal access token" — an org policy issue, not
   a bug in your command; an env token is exactly how a prior run here hit it). Stripping the variable lets `gh`
   fall back to the keyring credentials from `gh auth login`. If `gh` still isn't usable even then, fall back to
   the public REST API, which works fine unauthenticated for read access:
     ```bash
     TARGET_VERSION=6.1.0 # substitute the version you were given
     curl -s "https://api.github.com/repos/swoole/ide-helper/releases/tags/${TARGET_VERSION}"
     ```
   A `{"message": "Not Found", ...}` response is the *good* outcome — it means no release exists for that tag yet.
   A JSON object carrying a real `tag_name`/`html_url` means the release already exists, so stop.
   If either the tag or the release already exists, stop — do not overwrite or double-publish, and never reach for
   `--force` on a push or a release update to work around an "already exists" failure. If a push is ever rejected,
   stop and report it rather than retrying with `--force` — that's exactly the kind of "fix" that can overwrite
   history or a release someone else is relying on.

3. **The repository must actually be in the state this version claims to be.** Confirm:
   - You're on `master` and the working tree is clean (`git status --short` is empty).
   - Local `master` matches `origin/master` exactly — neither behind nor ahead:
     ```bash
     git fetch origin master
     git rev-list --left-right --count origin/master...master
     ```
     Both counts must be `0`. If local is ahead, the tag would point at commits `origin/master` doesn't have yet
     (every prior release's `target_commitish` has been `master` on the remote) — stop and tell the user to push
     first. If local is behind, stop and tell the user to pull first.
   - `src/swoole/constants.php`'s `SWOOLE_VERSION`, `SWOOLE_MAJOR_VERSION`, `SWOOLE_MINOR_VERSION`, and
     `SWOOLE_RELEASE_VERSION` at HEAD actually match the target version.
   If any check fails, stop and explain what's missing — most likely the stub changes for this version haven't
   been prepared/merged yet (that's `prepare-swoole-release`'s job, run beforehand).

If any of Step 0's checks fail, explain clearly what failed and stop. Do not create a tag, push anything, or
publish a release. If all checks pass, summarize what you found and what you're about to do next, and wait for the
user's go-ahead before Step 1.

# Step 1: create and push the tag

This project's tags are annotated, with a consistent message format — confirm the exact pattern with
`git tag -l -n99 <a recent version>` before you rely on it, but it has consistently been `tag release X.Y.Z`:

```bash
TARGET_VERSION=6.1.0 # substitute the version you were given
git tag -a "${TARGET_VERSION}" -m "tag release ${TARGET_VERSION}"
git push origin "${TARGET_VERSION}"
```

Once the tag is pushed, pause again and confirm with the user before Step 2 — publishing the release is a second,
separately irreversible action.

If Step 2 then fails for any reason, the pushed tag is left behind on the remote with no release attached. That
state is harmless — a tag without a release breaks nothing, and it's exactly what Step 0's "stale tag" check is
written to notice on a later run. Leave it in place, report it, and let the user decide; a retry should re-run
Step 2 only. Do not delete the remote tag (`git push --delete`) to "clean up" without the user explicitly asking
for that.

# Step 2: publish the GitHub release

Every existing release on this project follows one fixed body template — confirm it still holds by checking a
couple of recent releases (`curl -s "https://api.github.com/repos/swoole/ide-helper/releases?per_page=5"`) before
you rely on it, but it has consistently been:

```
PHP stubs for [Swoole ${TARGET_VERSION}](https://github.com/swoole/swoole-src/releases/tag/v${TARGET_VERSION}).
```

Leave the release title/name empty — that's the convention the most recent releases (checked above) follow. Publish
against the tag you already pushed in Step 1 (don't let the tool create its own tag, since that wouldn't get the
annotated message from Step 1):

```bash
TARGET_VERSION=6.1.0 # substitute the version you were given
env -u GH_TOKEN gh release create "${TARGET_VERSION}" --repo swoole/ide-helper --verify-tag --latest=false \
  --notes "PHP stubs for [Swoole ${TARGET_VERSION}](https://github.com/swoole/swoole-src/releases/tag/v${TARGET_VERSION})."
```

The body is exactly that one line, with nothing appended — that's what every published release to date contains
verbatim. `--verify-tag` is what actually enforces "publish against the tag from Step 1": without it, `gh` silently
creates its own lightweight tag if the one you expect isn't on the remote, and you'd lose the annotated message.

**Never pass `-p`/`--prerelease` at all** — it's a plain boolean switch with no `=false` form documented, so simply
omitting it is how you get `prerelease: false` (the default). **Never omit `--latest=false`** — `gh` marks a new
release as "latest" by default unless told otherwise, and this project deliberately never wants that: it maintains
more than one Swoole release line in parallel (e.g. it has shipped a patch for an older 5.1.x line after 6.0.x was
already out), so GitHub's default date-based "latest" marker would frequently point at the wrong release if left on.

If `gh` fails here the same way it did in Step 0 (the org policy rejecting fine-grained personal access tokens),
fall back to the REST API directly. This requires a token with write access to this repo, supplied as an environment
variable — and since the very policy that broke `gh` is the one blocking fine-grained tokens, that effectively means
a *classic* token with the `repo` scope. Check `$GITHUB_TOKEN`/`$GH_TOKEN` first (the same variables `gh` itself
honors), and if neither is set, stop and ask the user to provide one rather than guessing where it might come from.
Build the JSON body with `jq` rather than hand-written string interpolation, so the Markdown body is escaped
correctly:
```bash
TARGET_VERSION=6.1.0 # substitute the version you were given
TOKEN="${GITHUB_TOKEN:-$GH_TOKEN}"
BODY="PHP stubs for [Swoole ${TARGET_VERSION}](https://github.com/swoole/swoole-src/releases/tag/v${TARGET_VERSION})."
curl -X POST -H "Authorization: Bearer $TOKEN" -H "Accept: application/vnd.github+json" \
  https://api.github.com/repos/swoole/ide-helper/releases \
  -d "$(jq -n --arg tag "${TARGET_VERSION}" --arg body "$BODY" \
    '{tag_name:$tag,target_commitish:"master",name:"",body:$body,draft:false,prerelease:false,make_latest:"false"}')"
```
If neither path works, stop and ask the user for a working token rather than silently giving up, or worse, falling
back to defaults that would mark the release as a pre-release or as latest.

# Report back

Confirm: the tag created and pushed, the release URL published, and explicitly restate that `prerelease` is `false`
and `make_latest` is `false` on the published release. Flag anything that didn't match the expected historical
convention (e.g. if the body template or empty title convention has since changed) rather than silently overriding
it.
