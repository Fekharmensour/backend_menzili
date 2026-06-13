<?php

require __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;

$serviceAccountPath = __DIR__ . '/storage/app/firebase/firebase.json';
if (!file_exists($serviceAccountPath)) {
    echo "File not found: $serviceAccountPath\n";
    exit(1);
}

// Token from the database
$token = 'c7Dm6tfBRnOzgOrzoY0OO-:APA91bGhT44MYcXDb82IaOxTPnjSKHCHLJXVV2D_q61y8klvSBr-FUjKxaMh4Csu_9oNE1vY7ymmcYW950n2b5vUXavcOZ6xF5KgoNLDoaD4K-OLPd2J71A';

try {
    $factory = (new Factory())->withServiceAccount($serviceAccountPath);
    $messaging = $factory->createMessaging();
    
    echo "Sending to token: $token\n";
    
    $messaging->send([
        'token' => $token,
        'notification' => [
            'title' => 'Test Direct',
            'body' => 'This is a test notification sent directly to your token.',
        ],
        'data' => [
            'type' => 'test',
            'time' => (string) time(),
        ],
    ]);
    echo "Message sent successfully!\n";
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
