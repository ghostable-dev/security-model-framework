# Cashier Security

Use when the app uses Laravel Cashier for Stripe or Paddle billing.

## Check

- Billing routes require explicit billing permission such as `billing.manage`.
- Provider customer IDs, subscription IDs, price IDs, invoice IDs, and payment method IDs are scoped to the current billable model.
- Webhooks verify provider signatures.
- Webhook handlers are idempotent.
- Raw provider payloads are not exposed to normal users.
- Invoice downloads are authorized.
- Subscription creation, cancellation, resume, swap, and payment method updates are authorized and audited.
- Trial and coupon manipulation cannot be performed by unauthorized users.
- Billing portal redirects are generated only for the authorized billable model.

## Fail If

- A user can access invoices or portal sessions for another team/account/customer.
- Webhook signature verification is missing or disabled.
- Billing actions rely only on hidden UI controls.
- Raw Stripe/Paddle payloads are returned in browser or API responses.

## Tests

- User without billing permission is forbidden.
- User cannot access another account's invoice or portal.
- Invalid webhook signature is rejected.
- Subscription mutation routes require authorization.

