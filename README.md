
# 🐒 Apes Booking System (Single DB Multi-Tenant) – Laravel

A modular, multi-tenant booking platform built with Laravel, using a **single database** strategy with logical tenant isolation via `tenant_id`.

---

## 🧩 Core Features

- ✅ **Single Database, Multi-Tenant**  
  Tenancy is scoped logically by `tenant_id`, ensuring all bookings, teams, and availabilities are isolated per tenant.

- 🧱 **Modular Laravel Architecture**  
  Developed using [nWidart/laravel-modules](https://github.com/nWidart/laravel-modules) for clean separation of features.

- ⏱️ **Team Availability**  
  Define recurring weekly availability (e.g., Mon–Fri, 09:00–17:00) per team using the `TeamAvailability` model.

- 📆 **Dynamic Slot Generation**  
  Generate 1-hour time slots on-the-fly for a given date range, excluding:
  - Non-available hours
  - Already booked slots

- 📚 **Booking System**  
  Bookings store `start_time`, `end_time`, and `date`, and ensure:
  - Team is available
  - No overlapping bookings for the same team

- 📖 **Swagger API Docs**  
  Fully documented API with Swagger available at:  
  **[`/api/documentation`](http://apes.localhost/api/documentation)**

---

## 🚀 Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/your-username/apes-booking.git
   cd apes-booking
   ```

2. **Install dependencies**:
   ```bash
   composer install
   ```

3. **Configure environment**:
   - Copy `.env.example` → `.env`
   - Set `APP_URL=http://apes.localhost`

4. **Serve the app locally** (Apache or Valet recommended):
   - Configure wildcard DNS for `*.apes.localhost`  
     (Valet: `valet link apes && valet secure && valet tld localhost`)

5. **Run migrations**:
   ```bash
   php artisan migrate
   ```

6. **Register a new user** at:
   ```
   POST /api/v1/auth/register
   ```
   - The `name` will act as the tenant's **subdomain**
   - Example: registering with `name: acme` means all future requests go to `http://acme.apes.localhost`

---

## 🧪 API Usage Flow

1. **Register a user (tenant)**
2. **Login and receive a Bearer token**
3. **Use your subdomain (e.g., `acme.apes.localhost`)**
4. **Attach token to all requests**:
   ```
   Authorization: Bearer <token>
   ```

---

## 📁 Swagger Schema Highlights

- `TeamAvailabilityRequest`
- `BookingRequest`
- `RegisterRequest`, `LoginRequest`
- Real-time slot generation:  
  ```
  GET /api/teams/{id}/generate-slots?from=2025-06-01&to=2025-06-07
  ```

---

## 🛠 Tech Stack

- Laravel 12+
- Laravel Modules
- Swagger (OpenAPI v3)
- Carbon
- Spatie Multi Tenant
- MySQL (Single DB, multi-tenant)

---

## 📬 Contact

Feel free to submit issues or feature requests.  
Contributions are welcome! 🍌
