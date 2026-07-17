<?php

declare(strict_types=1);

chdir(dirname(__DIR__));

$logFile = __DIR__ . '/../storage/logs/laravel.log';

if (! is_file($logFile)) {
    touch($logFile);
}

$processes = [
    ['name' => 'server', 'cmd' => 'php artisan serve', 'color' => '#93c5fd'],
    ['name' => 'queue', 'cmd' => 'php artisan queue:listen --tries=1 --timeout=0', 'color' => '#c4b5fd'],
];

if (function_exists('pcntl_fork')) {
    $processes[] = ['name' => 'logs', 'cmd' => 'php artisan pail --timeout=0', 'color' => '#fb7185'];
} elseif (PHP_OS_FAMILY === 'Windows') {
    $processes[] = [
        'name' => 'logs',
        'cmd' => 'powershell -NoProfile -ExecutionPolicy Bypass -File scripts/tail-log.ps1',
        'color' => '#fb7185',
    ];
}

$processes[] = ['name' => 'vite', 'cmd' => 'npm run dev', 'color' => '#fdba74'];

$colors = implode(',', array_column($processes, 'color'));
$names = implode(',', array_column($processes, 'name'));
$quotedCommands = implode(' ', array_map(
    static fn (array $process): string => '"' . str_replace('"', '\\"', $process['cmd']) . '"',
    $processes
));

$command = sprintf(
    'npx concurrently -c "%s" %s --names=%s --kill-others',
    $colors,
    $quotedCommands,
    $names
);

passthru($command, $exitCode);

exit($exitCode);
