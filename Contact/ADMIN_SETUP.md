# Admin System Setup 🔐

## Overview
This application now has a role-based authentication system with **Admin** and **User** roles.

---

## Admin Login Credentials

**Email:** `admin@connecthub.com`  
**Password:** `Admin@2026`

---

## How It Works

### 1. **User Roles**
- **Admin**: Full access to all admin features (Dashboard, Contacts, Cities)
- **User**: Default role for new registrations (currently limited access)

### 2. **Middleware Protection**
The `IsAdmin` middleware protects all admin routes:
- Located at: `app/Http/Middleware/IsAdmin.php`
- Checks if the authenticated user has `role = 'admin'`
- Redirects non-admin users to home page with error message

### 3. **Protected Routes**
All routes under `/admin/*` require both authentication AND admin role:
```php
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::resource('contacts', ContactController::class);
    Route::resource('cities', CityController::class);
});
```

### 4. **Visual Indicators**
- **Sidebar**: Shows user profile with role badge (Admin/User)
- **Error Messages**: Non-admin users see "Access denied" message when trying to access admin areas

---

## Creating Additional Admin Users

### Option 1: Using the Seeder
Run the admin seeder again (will create duplicate if email exists):
```bash
php artisan db:seed --class=AdminSeeder
```

### Option 2: Manually via Database
Update an existing user's role:
```sql
UPDATE users SET role = 'admin' WHERE email = 'user@example.com';
```

### Option 3: Via Tinker
```bash
php artisan tinker
```
Then:
```php
$user = User::where('email', 'user@example.com')->first();
$user->role = 'admin';
$user->save();
```

---

## Testing the System

1. **Test Admin Access:**
   - Login with: `admin@connecthub.com` / `Admin@2026`
   - You should see the admin dashboard with full access
   - Sidebar shows "Admin" badge

2. **Test Normal User:**
   - Register a new account (will have `role = 'user'`)
   - Try to access `/admin/dashboard`
   - You should be redirected to home with error message

---

## Database Structure

The `users` table has a `role` column:
- Type: `string`
- Default: `'user'`
- Values: `'admin'` or `'user'`

Migration file: `database/migrations/2026_01_07_082317_add_role_to_users_table.php`

---

## Files Modified

1. ✅ `app/Http/Middleware/IsAdmin.php` - Admin middleware
2. ✅ `bootstrap/app.php` - Middleware registration
3. ✅ `routes/web.php` - Protected admin routes
4. ✅ `database/seeders/AdminSeeder.php` - Admin user creation
5. ✅ `resources/views/layouts/admin.blade.php` - Role badge display
6. ✅ `resources/views/welcome.blade.php` - Error message display

---

## Security Notes

⚠️ **Important:**
- Change the default admin password after first login
- Never commit credentials to version control
- Consider using environment variables for default admin credentials
- Implement password reset functionality for production

---

## Next Steps (Optional Enhancements)

- [ ] Add password change functionality
- [ ] Create separate dashboards for admin vs user
- [ ] Add more granular permissions (CRUD permissions)
- [ ] Implement user management (admin can promote/demote users)
- [ ] Add activity logging for admin actions

---

**Created:** 2026-01-07  
**Version:** 1.0
