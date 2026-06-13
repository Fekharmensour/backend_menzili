<?php

require __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Log;

// We need to bootstrap Laravel minimal to use storage_path or just use hardcoded path
$serviceAccountPath = __DIR__ . '/storage/app/firebase/firebase.json';

if (!file_exists($serviceAccountPath)) {
    echo "File not found: $serviceAccountPath\n";
    exit(1);
}

try {
    $factory = (new Factory())->withServiceAccount($serviceAccountPath);
    $messaging = $factory->createMessaging();
    
    // Try to send a dummy message to a non-existent topic to check authentication
    // Sending to a topic usually doesn't fail immediately unless auth is wrong
    $messaging->send([
        'topic' => 'test-connection',
        'notification' => [
            'title' => 'Test',
            'body' => 'Test',
        ],
    ]);
    echo "Connection successful (or at least no auth error yet)\n";
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    if (method_exists($e, 'getResponse')) {
        echo "Response: " . $e->getResponse()->getBody()->getContents() . "\n";
    }
}
