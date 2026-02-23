<?php

namespace CollinFlickTasus\Progress;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Connection;

class ProgressServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Register the custom connection resolver
        Connection::resolverFor('progress', function ($connection, $database, $prefix, $config) {
            $connector = new ProgressConnector();
            $pdo = $connector->connect($config);

            return new ProgressConnection($pdo, $database, $prefix, $config);
        });
    }
}