<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'user.activateExpire' => 3 * 24 * 3600,
    'user.rememberMeDuration' => 3 * 24 * 3600,
    'dee.migration.path' => [
        '@mdm/upload/migrations',
        '@mdm/admin/migrations/',
    ],
];
