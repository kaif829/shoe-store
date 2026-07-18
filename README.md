# AI-Powered Shoe Store Management System

Laravel 12 + MySQL + Bootstrap 5/jQuery/AJAX full-stack e-commerce app, built from the project SRS.
Includes customer storefront, AJAX cart/wishlist, COD checkout, reviews, a rule-based AI recommendation
engine, and a full admin panel (products, categories, orders, reviews, users, reports with charts).

## Setup (XAMPP / local)

1. Unzip the project, open a terminal inside the folder.
2. Install dependencies (needs internet access to packagist.org):
   ```
   composer install
   ```
3. Copy the env file and generate an app key:
   ```
   cp .env.example .env
   php artisan key:generate
   ```
4. In `.env`, set your MySQL credentials (defaults match XAMPP: `root` / empty password).
   Create an empty database named `shoe_store` in phpMyAdmin first.
5. Run migrations + seed sample data (categories, 12 demo shoes, admin + customer accounts):
   ```
   php artisan migrate --seed
   ```
6. Link the public storage disk (needed for product images you upload via the admin panel):
   ```
   php artisan storage:link
   ```
7. Start the server:
   ```
   php artisan serve
   ```
   Visit http://localhost:8000

## Demo accounts (created by the seeder)

| Role     | Email                      | Password     |
|----------|-----------------------------|---------------|
| Admin    | admin@aishoestore.test      | Admin@123     |
| Customer | customer@aishoestore.test   | Customer@123  |

## What's implemented (mapped to the SRS)

- **FR-01/02**: Registration, login, forgot/reset password, email verification, profile + password change
- **FR-03/04/05**: Product catalog, live AJAX search & multi-filter (brand/gender/activity/price/category), pagination
- **Feature 5**: Cart — add/update/remove via AJAX, live subtotal/total updates
- **Feature 6**: COD checkout (no payment gateway yet, per your request) — shipping form → order creation → stock decrement
- **Feature 7**: Order history + order detail/tracking pages
- **Feature 8**: Reviews & ratings (1 review per user per product, auto-recalculated average rating)
- **Chapter 4 — AI Recommendation Engine**: `app/Http/Controllers/RecommendationController.php`
  implements the rule-based logic from the SRS (activity type hard filter → gender filter → budget
  range with graceful fallback → ranked by featured/rating/review count). Every submission is logged
  to the `recommendations` table.
- **Admin panel**: dashboard with live stats + 7-day sales chart (Chart.js), full product/category CRUD
  with image upload, order management with status updates, review moderation, user management with
  role toggling, and a sales/best-sellers report page.
- **Security**: CSRF on every form, bcrypt password hashing, role middleware (`admin`) guarding
  `/admin/*`, ownership checks on cart/order/review actions, Laravel's built-in validation + Eloquent
  query binding (SQL-injection safe).
- **UI**: Bootstrap 5, custom dark/orange theme (`public/css/app.css`), SweetAlert2 confirmations,
  Toastr notifications, hover/fade animations on product cards.

## Database

7 migrations covering: `users` (+role), `categories`, `products`, `orders` + `order_details`,
`reviews`, `recommendations` (AI engine log), `cart_items`, `wishlists`. All foreign keys cascade
or null-on-delete appropriately; see `database/migrations/`.

## Not included (flagged so you know what's left)

- Real payment gateways (Stripe/PayPal/JazzCash/EasyPaisa) — checkout is COD-only per your choice.
  `payment_method` column on `orders` is already there if you want to add gateways later.
- AR try-on, ML-based (vs rule-based) recommendations, chatbot, mobile app — these are explicitly
  "Future Enhancements" in the SRS (Chapter 13), not part of this build.
- Email isn't wired to a real SMTP provider — set `MAIL_*` in `.env` for verification/reset emails to
  actually send (works fine with Mailtrap for testing).

## Folder structure

```
app/Http/Controllers/        Customer + Admin controllers
app/Http/Controllers/Auth/    Full auth flow (Breeze-style, hand-written)
app/Http/Middleware/          EnsureUserIsAdmin (role-based access)
app/Models/                   9 Eloquent models with relationships + scopes
database/migrations/          7 migration files
database/seeders/             DatabaseSeeder (admin/customer + categories + 12 shoes)
resources/views/              Blade views: layouts, auth, products, cart, orders, recommendation, admin/*
routes/web.php                All routes, grouped by guest/auth/admin
public/css/app.css            Theme
public/js/app.js              AJAX cart/wishlist/filter helpers
```
