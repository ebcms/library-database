<?php

declare(strict_types=1);

namespace Ebcms\Database;

use Ebcms\App;
use Medoo\Medoo;

class Db
{

    private $master_config = [];
    private $slave_configs = [];

    public function __construct(
        App $app
    ) {
        $cfg_file = $app->getAppPath() . '/config/database.php';
        if (file_exists($cfg_file)) {
            $configs = (array)include $app->getAppPath() . '/config/database.php';
            if (isset($configs['master'])) {
                $this->master_config = $configs['master'];
            }
            if (isset($configs['slaves'])) {
                $this->slave_configs = (array)$configs['slaves'];
            }
        }
    }

    public function master(): Medoo
    {
        static $db;
        if (!$db) {

            $db = $this->instance($this->master_config);
        }
        return $db;
    }

    public function slave(): Medoo
    {
        static $db;
        if (!$db) {
            $db = $this->slave_configs ? $this->instance(array_rand($this->slave_configs)) : $this->master();
        }
        return $db;
    }

    public function instance(array $config = []): Medoo
    {
        return new Medoo(array_merge([
            'database_type' => 'mysql',
            'database_name' => 'test',
            'server' => '127.0.0.1',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8mb4',
            'prefix' => 'prefix_',
            'option' => [
                \PDO::ATTR_CASE => \PDO::CASE_NATURAL,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_STRINGIFY_FETCHES => false,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ],
            'command' => ['SET SQL_MODE=ANSI_QUOTES'],
        ], $config));
    }
}
