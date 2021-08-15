<?php

declare(strict_types=1);

defined('ROOT_PATH') or define('ROOT_PATH', realpath(dirname(dirname(__FILE__))));


$composer = ROOT_PATH . '/vendor/autoload.php';

if (is_file($composer))
{
    require $composer;
}

use Tahir\Core\Router\Router;
use Tahir\Core\Database\DatabaseConnection;
use Tahir\Core\Database\PDOManager;
use Tahir\Core\Database\EntityManager;
use Tahir\Core\Database\RepositoryManager;

$routes = require_once( ROOT_PATH . '/routes/routes.php');

$router = new Router();

$router->dispatch($routes,'/'.$_SERVER['QUERY_STRING'],$_SERVER['REQUEST_METHOD']);

/*$cred = [
    'dsn' => 'mysql:host=localhost;port=3306;dbname=framework;charset=utf8mb4',
    'username' => 'root',
    'password' => '',
];*/

//$db = new DatabaseConnection($cred);
//$pdo = new PDOManager($db);
/*
$rr = $db->open()->prepare('SELECT * FROM users');
$rr->execute();
$rr->fetchAll(PDO::FETCH_OBJ);*/
//$pdo->persist('INSERT INTO users (lastname) VALUES (:lastname)',['lastname'=> 'grdddd']);
//var_dump($pdo->resultSet());
//$pdo->persist('UPDATE users SET lastname = :lastname WHERE id = :id',['lastname'=> 'updated', 'id' => 4 ]);
//$pdo->persist('DELETE FROM users WHERE id = :id AND lastname = :lastname',['id' => 4, 'lastname'=> 'updated']);

//$pdo->persist('SELECT id,lastname FROM users WHERE id = :id AND lastname = :lastname',['id' => 3, 'lastname'=> 'fdgfdgdgdgdfg']);
//var_dump($pdo->resultSet());

//$em = new EntityManager('users','5');
//var_dump($em->rawQuery('SELECT * FROM users')->rawFirst());
//var_dump($em->select()->where('id','=',2)->andWhere('lastname','=','bbbbbbbbb')->get());
//$em->insert(['lastname' => 'one tow'])->execute();
//$em->update(['lastname' => 'tereafffffff'])->where('id','=',1)->execute();
//$em->delete()->where('id','=',3)->execute();
/*
$rm = new RepositoryManager('users','5');
var_dump($rm->Update([
    'lastname' => 'zazazazaz'
],9));*/
?>
