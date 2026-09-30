<?php

class Migration
{
    public static $command = 'migration';

    public static $description = 'Run database migrations';

    public static $arguments = [
        '[action]' => 'Action: run, create-migration, rollback, rollback-all, refresh, status',
        '[name]'   => 'Migration class name for create-migration',
    ];

    protected static $route_map = [
        'run'              => 'migrate',
        'create-migration' => 'create-migration',
        'rollback'         => 'rollback',
        'rollback-all'     => 'rollback-all',
        'refresh'          => 'refresh',
        'status'           => 'status',
    ];

    public function handle(...$params)
    {
        // Read the raw terminal input, e.g.
        // php lava migration create-migration create_products_table
        // argv = [lava, migration, create-migration, create_products_table]
        $argv = $_SERVER['argv'] ?? [];
        $pos  = array_search(static::$command, $argv, true);

        $args = [];
        if ($pos !== false) {
            foreach (array_slice($argv, $pos + 1) as $a) {
                if ($a !== '' && $a[0] !== '-') {   // skip --flags
                    $args[] = $a;
                }
            }
        }

        // Fallback: use whatever strings the CLI passed in, if argv was empty
        if (!$args) {
            array_walk_recursive($params, function ($v) use (&$args) {
                if (is_string($v) && $v !== '' && $v[0] !== '-') $args[] = $v;
            });
        }

        $action = $args[0] ?? 'run';
        $name   = $args[1] ?? null;

        if (!isset(static::$route_map[$action])) {
            echo danger("Unknown migration action: \"{$action}\"");
            echo "Available actions: "
                . implode(', ', array_keys(static::$route_map))
                . PHP_EOL;
            exit(1);
        }

        if ($action === 'create-migration') {
            if (!$name) {
                echo danger("Migration name is required.");
                echo "Example: php lava migration create-migration create_users_table"
                    . PHP_EOL;
                exit(1);
            }
            $route = 'create-migration/' . $name;
        } else {
            $route = static::$route_map[$action];
        }

        $index = PUBLIC_DIR . 'index.php';

        if (!file_exists($index)) {
            echo danger("index.php not found at: {$index}");
            exit(1);
        }

        $command = sprintf(
            'php %s %s',
            escapeshellarg($index),
            escapeshellarg($route)
        );

        passthru($command);
    }
}