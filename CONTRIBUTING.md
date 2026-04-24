# Contributing

Thanks for helping improve Security Model Framework.

This project is intentionally practical. Contributions should make `SECURITY_MODEL.md` easier for real teams and AI coding agents to use during code review and implementation.

## Good Contributions

- New framework sections for common web application security risks.
- More precise Laravel security checks.
- Examples for other stacks.
- Better structured audit output.
- Clearer wording that reduces ambiguity for AI agents.
- Fixes for inaccurate, weak, or misleading security guidance.

## Contribution Principles

- Prefer specific, testable expectations over broad advice.
- Keep agent instructions action-oriented.
- Require evidence for pass/fail audit claims.
- Mark uncertainty as `Unknown` instead of hiding it.
- Avoid vendor-specific assumptions in the generic template.
- Put framework-specific guidance in a framework-specific template.

## Adding A Template

New templates should:

1. Use `SECURITY_MODEL.<stack>.md` naming.
2. Explain authentication, authorization, public routes, sensitive data, secret handling, and tests.
3. Include structured AI agent audit output.
4. Avoid requiring paid services or proprietary tooling.

## Pull Requests

Before opening a pull request:

1. Check spelling and Markdown formatting.
2. Make sure links are relative and valid.
3. Keep examples generic unless the file is explicitly framework-specific.
4. Explain why the change improves practical security review.

