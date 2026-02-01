# 🛠 BizFlow Platform - Developer Guide

Welcome to the development guide for the BizFlow Platform. This document outlines the standards, workflows, and security protocols used in this project.

---

## 🚀 Commands & Aliases

This project uses **Laravel Sail**. For convenience, use the following alias:
- `sa` → `sail artisan`

### Common Workflow Commands:
- **Starting Dev:** `./vendor/bin/sail up -d`
- **Migrations:** `sa migrate`
- **Seeding:** `sa db:seed`

---

## 🛡️ Security & Permissions (Filament Shield)

We use `bezhansalleh/filament-shield` to manage granular access control.

### Adding New Resources
Whenever you create a new Filament Resource (e.g., `sa make:filament-resource Product`), you **MUST** generate its permissions and policies to enforce security:

> 🚀 **Recommendation:**
> Whenever you create a new Resource in the future, run:
> `sa shield:generate --all`

This command will: 
1. Scan your resources, pages, and widgets.
2. Create corresponding permissions (e.g., `ViewAny:Product`).
3. Generate a Policy file in `app/Policies/`.

---

## 🏗 Architecture Standards

### 1. Data Identity
- All primary keys use **ULIDs** for better distributed system compatibility and security.
- Use the `HasUlids` trait in your models.
- Use `$table->ulid('id')->primary();` in migrations.

### 2. Multi-Tenancy
- Tenancy is scoped by `brand_id`.
- Always ensure global scopes are applied or respected when querying data in the `AppPanel`.

### 3. Enums
- Use Backed Enums for all fixed sets of data (Roles, Statuses, Types).
- Locations: `app/Enums/`.

---

## 🎨 UI/UX Standards
- **Framework:** Filament 5.
- **Icons:** Use `Heroicon::Outlined` for navigation and actions.
- **Navigation:** Group related resources (e.g., `Settings`) to keep the sidebar clean.