<?php
namespace App\Repositories;

use PDOException;
use PDO;
use App\Helpers\FlashHelper;

class Repository
{
    protected $connection;
    protected $dbName;

    protected FlashHelper $flashHelper;

    public function __construct()
    {
        require __DIR__ . '/../config/dbconfig.php';
        $this->flashHelper = new FlashHelper();

        try {
            $this->connection = new PDO("$type:host=$servername;dbname=$database", $username, $password);
            // set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbName = $database;
        } catch (PDOException $e) {
            $this->flashHelper->setFlashMessage('error', 'Connection failed: ' . $e->getMessage());
            header('Location: /');
        }
    }
}
