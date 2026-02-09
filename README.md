# bizflow

A modern business management platform built with **Laravel 12**, **Filament v5**, and **Tailwind CSS 4**.

## 🛠 Tech Stack

- **Framework:** Laravel 12
- **Admin Panel:** Filament v5 (Panel Builder)
- **Styling:** Tailwind CSS 4 (Vite-based)
- **Package Manager:** pnpm
- **Development Environment:** Laravel Sail (Docker)

---

## 🎨 Customizing the Theme

In Filament v5, if you want to use custom Tailwind classes (like gradients or custom layouts) within your Blade views or PHP Schemas, you must use a **Custom Theme**.

### Creating a pnpm-based Theme

Since this project uses **pnpm**, avoid the default `npm` behavior of the Filament generator. Use the `--pm` flag to ensure the theme is initialized with the correct package manager and avoids peer dependency conflicts:

```bash
# Generate a custom theme for the 'admin' panel using pnpm
sail artisan make:filament-theme --pm=pnpm
```

### Setup Steps

After running the command, follow these steps to activate your theme:

1.  **Vite Configuration:** Add the new theme file to your `vite.config.js` input array:
    ```javascript
    laravel({
        input: [
            'resources/css/app.css',
            'resources/js/app.js',
            'resources/css/filament/admin/theme.css', // Add this line
        ],
        refresh: true,
    }),
    ```

2.  **Panel Provider:** Register the theme in `app/Providers/Filament/AdminPanelProvider.php`:
    ```php
    public function panel(Panel $panel): Panel
    {
        return $panel
            // ...
            ->viteTheme('resources/css/filament/admin/theme.css');
    }
    ```

3.  **Tailwind 4 Configuration:** Ensure your theme file (`theme.css`) correctly imports Tailwind 4 and scans your custom widget/schema directories using the `@source` directive:
    ```css
    @import "tailwindcss";
    
    @source "../../../../app/Filament/**/*.php";
    @source "../../../../resources/views/filament/**/*.blade.php";
    
    @theme {
        --color-primary-500: var(--primary-500);
        --color-primary-600: var(--primary-600);
    }
    ```

4.  **Build Assets:**
    ```bash
    sail pnpm run build
    ```

---

## 🚀 Getting Started

1.  **Clone & Install:**
    ```bash
    git clone https://github.com/your-username/bizflow.git
    cd bizflow
    composer install
    sail pnpm install
    ```

2.  **Environment Setup:**
    ```bash
    cp .env.example .env
    sail artisan key:generate
    ```

3.  **Database & Migrations:**
    ```bash
    sail artisan migrate --seed
    ```

4.  **Launch Dev Server:**
    ```bash
    sail pnpm run dev
    ```

---

## 🏗 Key Architecture

### Custom Banner Widget
Located in `App\Filament\Resources\TenantBusinesses\Widgets\BusinessBanner`. To ensure it spans the full width of the view page, the `ViewRecord` page overrides:
```php
protected function getHeaderWidgetsColumns(): int | array
{
    return 1;
}
```

### Grid Layouts
The project uses the v5 `Filament\Schemas\Components\Grid` component to build complex 12-column layouts, moving away from the deprecated `Split` component.
