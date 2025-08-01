<?php

return [
    // Navigation
    'navigation' => [
        'geography' => 'Geography',
        'admins' => 'Administrators',
    ],
    
    'admins' => [
        'singular' => 'Administrator',
        'plural' => 'Administrators',
        'fields' => [
            'name' => 'Full Name',
            'email' => 'Email',
            'password' => 'Password',
            'password_confirmation' => 'Confirm Password',
            'email_verified_at' => 'Email Verified At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ],
        'chart' => [
            'heading' => 'Admin Registration Chart',
            'total' => 'Total Admins',
            'active' => 'Active Admins',
            'inactive' => 'Inactive Admins',
        ],
    ],
    
    // Actions
    'actions' => [
        'export_excel' => 'Export Excel (.xlsx)',
        'export_csv' => 'Export CSV (.csv)',
        'create' => 'Create',
        'edit' => 'Edit',
        'view' => 'View',
        'delete' => 'Delete',
    ],
    
    // Common
    'common' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'yes' => 'Yes',
        'no' => 'No',
        'search' => 'Search',
    ],
]; 
