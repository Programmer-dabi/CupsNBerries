# Administrator access

Open `/admin/login` to sign in. Successful sign-in redirects to `/admin`.

An administrator needs an account in `users` with `role = 'admin'`, its registered email address, and the correct password. Passwords are verified against the stored hash. Customer sign-in does not start an administrator session, even for an account which has administrator access.

The role migration is `database/migrations/20261026_user_roles.sql`. Apply it once when setting up another existing database. It was applied to this local database. Existing users start as customers; public registration always creates a customer.

From the project root, run:

```bash
php bin/create-admin.php
```

- For an existing account, enter its email to grant administrator access; its password is preserved.
- For a new account, enter a name, email, contact number, and password, then confirm the password. The name allows up to 100 characters, the email up to 150 characters, and the phone number 7–15 digits (up to 20 characters with formatting). A new administrator password must contain at least 12 characters and at most 72 bytes. Password entry is hidden in a terminal and the password is stored as a hash.

There is no default administrator email or password. The setup command runs only from the local command line; there is no public administrator registration form.

All admin pages and write routes check the current database role on every request. Removing the `admin` role immediately blocks further administration. The legacy `/addproduct` and `/add` routes are protected as well. Use the admin sidebar's Sign out button to end administrator access; the customer shopping session remains separate.
