<?php

require_once "controller/LoginController.php";
require_once "controller/RegisterController.php";
require_once "controller/HomeController.php";
require_once "controller/BerkasController.php";

$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'login';

if ($aksi == 'login') {
    $controller = new LoginController();
    $controller->login();

} elseif ($aksi == 'prosesLogin') {
    $controller = new LoginController();
    $controller->prosesLogin();

} elseif ($aksi == 'register') {
    $controller = new RegisterController();
    $controller->register();

} elseif ($aksi == 'prosesRegister') {
    $controller = new RegisterController();
    $controller->prosesRegister();

} elseif ($aksi == 'home') {
    $controller = new HomeController();
    $controller->index();

} elseif ($aksi == 'logout') {
    $controller = new HomeController();
    $controller->logout();

} elseif ($aksi == 'berkas') {
    $controller = new BerkasController();
    $controller->index();

} elseif ($aksi == 'tambah') {
    $controller = new BerkasController();
    $controller->tambah();

} elseif ($aksi == 'prosesTambah') {
    $controller = new BerkasController();
    $controller->prosesTambah();

} elseif ($aksi == 'edit') {
    $controller = new BerkasController();
    $controller->edit();

} elseif ($aksi == 'prosesEdit') {
    $controller = new BerkasController();
    $controller->prosesEdit();

} elseif ($aksi == 'hapus') {
    $controller = new BerkasController();
    $controller->hapus();

} elseif ($aksi == 'terima') {
    $controller = new BerkasController();
    $controller->terima();
}

?>