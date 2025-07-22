<?php

class SessionHelper {
    
    /**
     * Get current user session data (prioritizes admin over user)
     */
    public static function getCurrentUser() {
        // Check if admin is logged in
        if (isset($_SESSION['admin_user_id'])) {
            return [
                'id' => $_SESSION['admin_user_id'],
                'username' => $_SESSION['admin_username'],
                'role' => $_SESSION['admin_role'],
                'email' => $_SESSION['admin_email'],
                'type' => 'admin'
            ];
        }
        
        // Check if user is logged in
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
    
    /**
     * Get current user ID
     */
    public static function getCurrentUserId() {
        $user = self::getCurrentUser();
        return $user ? $user['id'] : null;
    }
    
    /**
     * Get current username
     */
    public static function getCurrentUsername() {
        $user = self::getCurrentUser();
        return $user ? $user['username'] : null;
    }
    
    /**
     * Get current user role
     */
    public static function getCurrentUserRole() {
        $user = self::getCurrentUser();
        return $user ? $user['role'] : null;
    }
    
    /**
     * Check if user is logged in (any type)
     */
    public static function isLoggedIn() {
        return self::getCurrentUser() !== null;
    }
    
    /**
     * Check if admin is logged in
     */
    public static function isAdminLoggedIn() {
        return isset($_SESSION['admin_user_id']) && isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === 'admin';
    }
    
    /**
     * Check if regular user is logged in
     */
    public static function isUserLoggedIn() {
        return isset($_SESSION['user_user_id']) && isset($_SESSION['user_role']);
    }
    
    /**
     * Check if current user has specific role
     */
    public static function hasRole($role) {
        $user = self::getCurrentUser();
        return $user && $user['role'] === $role;
    }
    
    /**
     * Require authentication (redirect if not logged in)
     */
    public static function requireAuth($redirectUrl = 'index.php?action=login') {
        if (!self::isLoggedIn()) {
            header("Location: $redirectUrl");
            exit;
        }
    }
    
    /**
     * Require admin authentication
     */
    public static function requireAdminAuth($redirectUrl = 'index.php?action=admin_login') {
        if (!self::isAdminLoggedIn()) {
            header("Location: $redirectUrl");
            exit;
        }
    }
    
    /**
     * Require user authentication
     */
    public static function requireUserAuth($redirectUrl = 'index.php?action=login') {
        if (!self::isUserLoggedIn()) {
            header("Location: $redirectUrl");
            exit;
        }
    }
} 