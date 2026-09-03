# Expense Manager — Backend

Laravel REST API for storing and viewing expenses.

## Setup
1. `composer install`
2. `cp .env.example .env` then set `DB_CONNECTION=sqlite`
3. `touch database/database.sqlite`
4. `php artisan key:generate`
5. `php artisan migrate --seed`
6. `php artisan serve` (runs on http://localhost:8000)

## Endpoints
- `GET /api/expenses` — list all expenses
- `POST /api/expenses` — create an expense
- `GET /api/expenses/{id}` — view one expense

## Testing
`php artisan test`

See `openapi.json` for the full API specification and the appendix of changes made to the original spec.
