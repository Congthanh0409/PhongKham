# Tai Mui Hong MVC - Dual Login Solution

## Problem
The original system had a conflict where both admin and user logins used the same session variables (`$_SESSION['user_id']`, `$_SESSION['role']`, etc.), causing errors when trying to login as both admin and user simultaneously.

## Solution Overview
We implemented a **separate session variable system** that allows both admin and user to be logged in simultaneously without conflicts.

## Key Changes Made

### 1. Separate Session Variables

**Before:**
```php
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];
$_SESSION['email'] = $user['email'];
```

**After:**
```php
// Admin login
$_SESSION['admin_user_id'] = $user['id'];
$_SESSION['admin_username'] = $user['username'];
$_SESSION['admin_role'] = $user['role'];
$_SESSION['admin_email'] = $user['email'];

// User login
$_SESSION['user_user_id'] = $user['id'];
$_SESSION['user_username'] = $user['username'];
$_SESSION['user_role'] = $user['role'];
$_SESSION['user_email'] = $user['email'];
```

### 2. SessionHelper Class

Created `helpers/SessionHelper.php` to provide unified access to user data:

```php
class SessionHelper {
    public static function getCurrentUser() {
        // Prioritizes admin over user
        if (isset($_SESSION['admin_user_id'])) {
            return [
                'id' => $_SESSION['admin_user_id'],
                'username' => $_SESSION['admin_username'],
                'role' => $_SESSION['admin_role'],
                'email' => $_SESSION['admin_email'],
                'type' => 'admin'
            ];
        }
        
        if (isset($_SESSION['user_user_id'])) {
            return [
                'id' => $_SESSION['user_user_id'],
                'username' => $_SESSION['user_username'],
                'role' => $_SESSION['user_role'],
                'email' => $_SESSION['user_email'],
                'type' => 'user'
            ];
        }
        
        return null;
    }
    
    public static function isAdminLoggedIn() {
        return isset($_SESSION['admin_user_id']) && $_SESSION['admin_role'] === 'admin';
    }
    
    public static function isUserLoggedIn() {
        return isset($_SESSION['user_user_id']);
    }
}
```

### 3. Updated Controllers

**AuthController.php:**
- Modified `login()` method to use `user_*` session variables
- Modified `adminLogin()` method to use `admin_*` session variables
- Updated logout methods to clear only relevant session variables

**UserController.php:**
- Updated to use `SessionHelper::getCurrentUser()` instead of direct session access

### 4. Updated Views

**Header (views/partials/header.php):**
- Now uses `SessionHelper::getCurrentUser()` to check authentication
- Shows admin badge when admin is logged in
- Provides admin dashboard link for admin users

### 5. Updated Routing

**index.php:**
- Admin route protection now checks `$_SESSION['admin_role']` instead of `$_SESSION['role']`

## How It Works

### 1. Separate Login Systems
- **Admin Login**: Uses `admin_*` session variables
- **User Login**: Uses `user_*` session variables
- **Independent**: Each can login/logout without affecting the other

### 2. Priority System
- Admin session takes priority over user session
- When both are logged in, `SessionHelper::getCurrentUser()` returns admin data
- This prevents conflicts in the UI

### 3. Independent Logout
- Admin logout only clears `admin_*` variables
- User logout only clears `user_*` variables
- Both can logout independently

## Testing

### Test Script
Run `test_dual_login.php` to test the dual login functionality:

```bash
http://localhost/TaiMuiHong_MVC/test_dual_login.php
```

### Manual Testing
1. **Login as Admin**: Go to `index.php?action=admin_login`
2. **Login as User**: Go to `index.php?action=login` (in another tab/window)
3. **Verify Both Work**: Both sessions should be active simultaneously
4. **Test Logout**: Each logout should only affect its respective session

### Test Credentials
- **Admin**: `admin` / `admin123`
- **User**: `user` / `user123`

## Benefits

1. **No Conflicts**: Admin and user can be logged in simultaneously
2. **Independent Sessions**: Each type can login/logout independently
3. **Backward Compatibility**: Existing code can be gradually updated
4. **Clear Separation**: Easy to distinguish between admin and user sessions
5. **Flexible**: Can easily add more user types in the future

## Migration Guide

### For Existing Controllers
Replace direct session access with SessionHelper:

```php
// Old way
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?action=login");
    exit();
}
$user_id = $_SESSION['user_id'];

// New way
$currentUser = SessionHelper::getCurrentUser();
if (!$currentUser) {
    header("Location: index.php?action=login");
    exit();
}
$user_id = $currentUser['id'];
```

### For Views
Replace session checks with SessionHelper:

```php
// Old way
<?php if(isset($_SESSION['user_id'])): ?>
    Welcome, <?php echo $_SESSION['username']; ?>
<?php endif; ?>

// New way
<?php 
$currentUser = SessionHelper::getCurrentUser();
if($currentUser): ?>
    Welcome, <?php echo $currentUser['username']; ?>
    <?php if($currentUser['type'] === 'admin'): ?>
        <span class="badge">Admin</span>
    <?php endif; ?>
<?php endif; ?>
```

## Files Modified

1. `controllers/AuthController.php` - Updated session handling
2. `controllers/UserController.php` - Updated to use SessionHelper
3. `views/partials/header.php` - Updated authentication checks
4. `index.php` - Updated admin route protection
5. `helpers/SessionHelper.php` - New helper class
6. `test_dual_login.php` - Test script

## Future Enhancements

1. **Role-Based Access Control**: Add more granular permissions
2. **Session Timeout**: Implement different timeout periods for admin/user
3. **Remember Me**: Separate remember me functionality for each type
4. **Audit Logging**: Track login/logout events for each session type 