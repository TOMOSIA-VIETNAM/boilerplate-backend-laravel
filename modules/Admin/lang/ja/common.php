<?php

return [
    // Navigation
    'navigation' => [
        'geography' => '地理',
        'admins' => '管理者',
    ],
    
    'admins' => [
        'singular' => '管理者',
        'plural' => '管理者一覧',
        'fields' => [
            'name' => '氏名',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
            'password_confirmation' => 'パスワード確認',
            'email_verified_at' => 'メール認証日時',
            'created_at' => '作成日時',
            'updated_at' => '更新日時',
        ],
        'chart' => [
            'heading' => '管理者登録チャート',
            'total' => '管理者総数',
            'active' => 'アクティブ管理者',
            'inactive' => '非アクティブ管理者',
        ],
    ],
    
    // Actions
    'actions' => [
        'export_excel' => 'Excelエクスポート (.xlsx)',
        'export_csv' => 'CSVエクスポート (.csv)',
        'create' => '新規作成',
        'edit' => '編集',
        'view' => '表示',
        'delete' => '削除',
    ],
    
    // Common
    'common' => [
        'active' => 'アクティブ',
        'inactive' => '無効',
        'yes' => 'はい',
        'no' => 'いいえ',
        'search' => '検索',
    ],
];
