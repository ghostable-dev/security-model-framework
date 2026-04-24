#!/usr/bin/env php
<?php

declare(strict_types=1);

$root = getcwd();
$checks = [
    'route_files' => ['routes/web.php', 'routes/api.php', 'routes/channels.php'],
    'middleware' => ['app/Http/Middleware', 'bootstrap/app.php', 'app/Http/Kernel.php'],
    'models' => ['app/Models'],
    'policies' => ['app/Policies'],
    'requests' => ['app/Http/Requests'],
    'resources' => ['app/Http/Resources'],
    'livewire' => ['app/Livewire', 'app/Http/Livewire'],
    'jobs' => ['app/Jobs'],
    'events' => ['app/Events'],
    'notifications' => ['app/Notifications', 'app/Mail'],
    'config' => ['config'],
    'tests' => ['tests'],
];

echo "# Laravel Security Hotspots\n\n";
echo "Root: {$root}\n\n";

foreach ($checks as $label => $paths) {
    $found = [];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            $found[] = $path;
        }
    }

    echo "- {$label}: " . ($found ? implode(', ', $found) : 'missing') . "\n";
}

echo "\n# High-Risk Pattern Search\n\n";

$patterns = [
    'auth bypass keywords' => '/withoutMiddleware|skipAuthorization|authorize\\(\\)\\s*:\\s*bool\\s*\\{\\s*return\\s+true|return\\s+true;\\s*\\/\\/.*authorize/i',
    'secret-like names' => '/api[_-]?key|client[_-]?secret|private[_-]?key|access[_-]?token|webhook[_-]?secret|deploy[_-]?token/i',
    'debug/config risk' => '/APP_DEBUG\\s*=\\s*true|debug\\s*=>\\s*true|allowed_origins\\s*=>\\s*\\[\\s*[\'"]\\*[\'"]/i',
    'raw model responses' => '/return\\s+\\$[a-zA-Z_][a-zA-Z0-9_]*;|response\\(\\)->json\\(\\$[a-zA-Z_][a-zA-Z0-9_]*\\)/',
];

$scanDirs = ['app', 'routes', 'config', 'tests', 'database', 'resources'];

foreach ($patterns as $label => $pattern) {
    $matches = [];

    foreach (iterFiles($scanDirs) as $file) {
        $contents = @file_get_contents($file);

        if ($contents !== false && preg_match($pattern, $contents)) {
            $matches[] = $file;
        }
    }

    echo "- {$label}: " . ($matches ? implode(', ', array_slice($matches, 0, 20)) : 'none found') . "\n";

    if (count($matches) > 20) {
        echo "  - plus " . (count($matches) - 20) . " more\n";
    }
}

echo "\n# Policy Coverage Heuristic\n\n";

$models = basenames(glob('app/Models/*.php') ?: []);
$policies = basenames(glob('app/Policies/*Policy.php') ?: []);

if (!$models) {
    echo "- models: none found\n";
} else {
    foreach ($models as $model) {
        $expected = $model . 'Policy';
        echo "- {$model}: " . (in_array($expected, $policies, true) ? "policy found ({$expected})" : 'policy not found') . "\n";
    }
}

function iterFiles(array $dirs): Generator
{
    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            continue;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if (!$file->isFile()) {
                continue;
            }

            $path = $file->getPathname();

            if (preg_match('/\\.(php|blade\\.php|env|js|ts|tsx|vue|yml|yaml|json|md)$/', $path)) {
                yield $path;
            }
        }
    }
}

function basenames(array $paths): array
{
    return array_map(
        static fn (string $path): string => pathinfo($path, PATHINFO_FILENAME),
        $paths
    );
}

