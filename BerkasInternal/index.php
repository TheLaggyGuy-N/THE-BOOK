<?php
session_start();

require_once "controller/BerkasController.php";

$controller = new BerkasController();
$page = isset($_GET['page']) ? $_GET['page'] : 'login';

if (!isset($_SESSION['user']) && $page != 'login' && $page != 'prosesLogin' && $page != 'signIn' && $page != 'prosesSignIn') {
    header("Location: index.php?page=login");
    exit;
}

switch ($page) {
    case 'login':
        $controller->login();
        break;
    case 'prosesLogin':
        $controller->prosesLogin();
        break;
    case 'signIn':
        $controller->signIn();
        break;
    case 'prosesSignIn':
        $controller->prosesSignIn();
        break;
    case 'logout':
        $controller->logout();
        break;
    case 'beranda':
        $controller->beranda();
        break;
    case 'berkasInternal':
        $controller->berkasInternal();
        break;
    case 'listBerkas':
        $controller->listBerkas();
        break;
    case 'tambah':
        $controller->tambah();
        break;
    case 'prosesTambah':
        $controller->prosesTambah();
        break;
    case 'edit':
        $controller->edit();
        break;
    case 'prosesEdit':
        $controller->prosesEdit();
        break;
    case 'hapus':
        $controller->hapus();
        break;
    case 'terima':
        $controller->terima();
        break;
    case 'profile':
        $controller->profile();
        break;
    case 'prosesProfile':
        $controller->prosesProfile();
        break;
    default:
        $controller->login();
        break;
}
?>
