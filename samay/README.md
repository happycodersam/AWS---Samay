## Local database setup (important)

1. Open `db.php` and set `$password` to the password for your local MySQL `root` account. The shared copy intentionally does not contain the database password.
2. The website uses the existing database named `samay`; import `samay_backup.sql` only into a test database if you need to restore the provided snapshot. Do not import it over your live database without first backing up your data.
3. Start Apache and your existing MySQL 8.0 service, then open `http://localhost/samay-main/samay/`.

The saved-items fix aligns `wishlist.php` with the actual table schema: `wishlist` uses the composite key `(username, product_id)` and does not have an `id` column.

---

# Samay — Luxury Watch Store

A responsive PHP + MySQL watch storefront with a champagne/ivory/black visual system, database-backed catalog, product detail pages, search/filter/sort, session cart, registration/login/logout, account overview, and persistent wishlists for signed-in users.

## Requirements
- PHP 8.0+ with `mysqli` enabled
- MySQL 8+ (or compatible MariaDB)

## Setup on Windows
1. Start the MySQL Windows service if it is stopped: `Start-Service MySQL80`.
2. Create the `samay` database and import `database.sql` using MySQL Workbench, or run these commands from the repository root (enter your MySQL password when prompted):

   ```powershell
   mysql --host=127.0.0.1 --port=3306 --user=root --password --execute="CREATE DATABASE IF NOT EXISTS samay CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
   Get-Content .\samay\database.sql -Raw | mysql --host=127.0.0.1 --port=3306 --user=root --password samay
   ```

   The script creates any missing tables and adds 68 starter watches only if the `products` table is empty. It does not delete or overwrite existing catalog data.
3. From the repository root, start the built-in PHP development server:

   ```powershell
   $env:SAMAY_DB_HOST = "127.0.0.1"
   $env:SAMAY_DB_PORT = "3306"
   $env:SAMAY_DB_NAME = "samay"
   $env:SAMAY_DB_USER = "root"
   $env:SAMAY_DB_PASS = "your-MySQL-password"
   $php = (Get-Command php).Source
   $phpExt = Join-Path (Split-Path $php) "ext"
   & $php -d "extension_dir=$phpExt" -d extension=mysqli -S 127.0.0.1:8000 -t .
   ```

   Replace `your-MySQL-password` with the password for the MySQL account. If
   the account has no password, set `$env:SAMAY_DB_PASS = ""`. Keep the
   terminal open and visit <http://127.0.0.1:8000/samay/>.

## Important notes
- Catalog pages query MySQL; products are not hardcoded into page templates. Active catalog products are shown and can be filtered by category.
- Registration uses password hashing; login uses prepared statements and session ID regeneration. Wishlist items are stored in MySQL for logged-in users. Cart is stored in the browser's PHP session.
- Cart pricing is resolved from the database when a product is added; the browser does not submit a price.
- PayPal initiation is deliberately disabled until you add your own sandbox credentials and server-side payment verification. A redirect alone must never be treated as proof of payment. No live payment credentials are included.
- Existing unrelated files such as `seo_project/` are retained from the supplied archive. Newsletter submission still depends on that separate folder being deployed at the same URL path; it is not required for shopping, accounts, wishlist, or cart.

## Environment configuration (optional)
Set `SAMAY_DB_HOST`, `SAMAY_DB_USER`, `SAMAY_DB_PASS`, `SAMAY_DB_NAME`, and `SAMAY_DB_PORT` before starting PHP. `SAMAY_DB_PASSWORD` is also accepted as a password variable for compatibility. Defaults are `127.0.0.1`, `root`, an empty password, `samay`, and port `3306`. Never commit production passwords or payment secrets.
