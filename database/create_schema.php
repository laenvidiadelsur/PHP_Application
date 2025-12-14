<?php

$host = getenv('DB_HOST') ?: 'db';
$port = getenv('DB_PORT') ?: '5432';
$db   = getenv('DB_DATABASE') ?: 'marketplace_db';
$user = getenv('DB_USERNAME') ?: 'admin';
$pass = getenv('DB_PASSWORD') ?: 'admin123';
$schema = getenv('DB_SCHEMA') ?: 'test';

try {
    echo "🔌 Connecting to PostgreSQL ($host:$port)...\n";
    $dsn = "pgsql:host=$host;port=$port;dbname=$db";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    echo "⚙️  Ensuring schema '$schema' exists...\n";
    $pdo->exec("CREATE SCHEMA IF NOT EXISTS \"$schema\"");
    
    echo "✅ Schema '$schema' is ready.\n";

} catch (PDOException $e) {
    echo "❌ Error ensuring schema: " . $e->getMessage() . "\n";
    // We don't exit with 1 because we want the container to keep trying or fail later at migration if critical
    // But for this purpose, failure here is critical for the next step.
    exit(1);
}
