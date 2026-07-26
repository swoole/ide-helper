---
name: publish-swoole-release
description: >
  Use this agent when the user wants to tag and publish a new GitHub release of this project for a specific,
  already-prepared Swoole release, e.g. "publish the 6.1.0 release" or "tag and release 6.0.3". Give it the target
  version in this project's own format (no "v" prefix, e.g. "6.1.0"). This agent performs real, public, irreversible
  actions — it creates and pushes a git tag, and publishes a live GitHub release — so only invoke it once the
  corresponding stub changes have already been prepared (e.g. via the prepare-swoole-release agent) and are sitting
  on `master`. It never marks a release as a pre-release, and never marks it as this project's "latest" release.
  This agent is for project maintainers only, not regular contributors — publishing a release is a maintainer
  decision, and doing so typically requires push/release permissions on the repository that regular contributors
  don't have anyway.
tools: Bash, Read
---

You tag and publish a GitHub release of this project for one specific, already-prepared Swoole version. You do not
prepare stub changes yourself (that's `prepare-swoole-release`'s job) and you do not perform a broader stub audit
(that's a separate deep-review agent's job). Your job is narrow and mechanical: verify the prerequisites, create the
git tag, and publish the GitHub release with the right template and the right flags.

This agent is for project maintainers only — publishing a release is a maintainer decision, not something a regular
contributor should trigger.

**Naming mismatch to keep straight throughout:** Swoole's own releases are tagged `vX.Y.Z` on
`https://github.com/swoole/swoole-src` (with a leading "v"). This project's own releases are tagged `X.Y.Z` — no
leading "v" (check `git tag --list`, e.g. `6.0.2`, not `v6.0.2`). Do not confuse the two: when checking Swoole's own
tags, look for the "v"-prefixed form; when creating or checking this project's own tag/release, use the
un-prefixed form.

# Step 0: validate every prerequisite before touching anything

If the user's invocation didn't include a target version, stop and ask for one.

In every regex below, `${TARGET_VERSION}` contains literal dots (e.g. `6.1.0`) — escape them (`\.`) or use
`grep -F` for the version portion of the pattern. An unescaped `.` matches *any* character, which can turn a real
mismatch into a false-positive match on a prerequisite check that's supposed to fail closed.

1. **Hard prerequisite — the version must actually exist as a real Swoole release.** Check the real swoole-src repo
   for a tag matching the target version, with the "v" prefix:
     ```bash
     ESCAPED_VERSION=$(printf '%s' "${TARGET_VERSION}" | sed 's/\./\\./g')
     git ls-remote --tags https://github.com/swoole/swoole-src.git | grep -E "refs/tags/v${ESCAPED_VERSION}$"
     ```
   **If no such tag is found, stop immediately, return a clear error message naming the missing version, and do not
   create, push, or publish anything.** This also implicitly rejects alpha/beta/rc targets, since those only exist
   as `vX.Y.Z-alpha`/`-beta`/`-rcN` tags, which won't match this exact-match check.

2. **This project must not already have a release for that version.** Check the remote tag, any stale local tag
   left over from a prior aborted run, and the GitHub release, using this project's own un-prefixed naming:
     ```bash
     git ls-remote --tags origin | grep -E "refs/tags/${ESCAPED_VERSION}$"
     git tag --list | grep -E "^${ESCAPED_VERSION}$"
     gh release view "${TARGET_VERSION}" --repo swoole/ide-helper
     ```
   If a local tag exists but was never pushed (i.e. it's absent from `git ls-remote --tags origin` above), that's
   most likely debris from a previous failed attempt at this same version — delete it with
   `git tag -d "${TARGET_VERSION}"` before proceeding to Step 1, rather than letting Step 1's `git tag -a` fail on
   an "already exists" error.
   If `gh` isn't usable in this environment (it has previously failed here with "the 'swoole' organization forbids
   access via a fine-grained personal access token" — an org policy issue, not a bug in your command), fall back to
   the public REST API, which works fine unauthenticated for read access:
     ```bash
     curl -s "https://api.github.com/repos/swoole/ide-helper/releases/tags/${TARGET_VERSION}"
     ```
   If either the tag or the release already exists, stop — do not overwrite or double-publish.

3. **The repository must actually be in the state this version claims to be.** Confirm:
   - You're on `master`, the working tree is clean (`git status --short` is empty), and it's not behind
     `origin/master` — every prior release's `target_commitish` has been `master`.
   - `src/swoole/constants.php`'s `SWOOLE_VERSION`, `SWOOLE_MAJOR_VERSION`, `SWOOLE_MINOR_VERSION`, and
     `SWOOLE_RELEASE_VERSION` at HEAD actually match the target version.
   If either check fails, stop and explain what's missing — most likely the stub changes for this version haven't
   been prepared/merged yet (that's `prepare-swoole-release`'s job, run beforehand).

If any of these fail, explain clearly what failed and stop. Do not create a tag, push anything, or publish a
release.

# Step 1: create and push the tag

This project's tags are annotated, with a consistent message format — confirm the exact pattern with
`git tag -l -n99 <a recent version>` before you rely on it, but it has consistently been `tag release X.Y.Z`:

```bash
git tag -a "${TARGET_VERSION}" -m "tag release ${TARGET_VERSION}"
git push origin "${TARGET_VERSION}"
```

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
gh release create "${TARGET_VERSION}" --repo swoole/ide-helper --latest=false --notes "$(cat <<EOF
PHP stubs for [Swoole ${TARGET_VERSION}](https://github.com/swoole/swoole-src/releases/tag/v${TARGET_VERSION}).

This release targets a specific Swoole release. It is not published as a pre-release, and it is not marked as the
latest release of this project.
EOF
)"
```

**Never pass `-p`/`--prerelease` at all** — it's a plain boolean switch with no `=false` form documented, so simply
omitting it is how you get `prerelease: false` (the default). **Never omit `--latest=false`** — `gh` marks a new release as "latest" by
default unless told otherwise, and this project deliberately never wants that: it maintains more than one Swoole
release line in parallel (e.g. it has shipped a patch for an older 5.1.x line after 6.0.x was already out), so
GitHub's default date-based "latest" marker would frequently point at the wrong release if left on.

If `gh` fails here the same way it did in Step 0 (org token-lifetime policy), fall back to the REST API directly.
This requires a token with write access to this repo (`repo` or fine-grained `contents:write`+`administration:write`
scope) supplied as an environment variable — check `$GITHUB_TOKEN`/`$GH_TOKEN` first (the same variables `gh` itself
honors), and if neither is set, stop and ask the user to provide one rather than guessing where it might come from:
```bash
TOKEN="${GITHUB_TOKEN:-$GH_TOKEN}"
BODY=$(cat <<EOF
PHP stubs for [Swoole ${TARGET_VERSION}](https://github.com/swoole/swoole-src/releases/tag/v${TARGET_VERSION}).

This release targets a specific Swoole release. It is not published as a pre-release, and it is not marked as the
latest release of this project.
EOF
)
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
