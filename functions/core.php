<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
switch ($uri) {
    case '/':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/pages/main.php";
        break;
    case '/profile':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/user/profile.php";
        break;
    case '/update_profile':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/user/update_profile.php";
        break;
    case '/users':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/adminka/users.php";
        break;
    case '/base':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/adminka/database.php";
        break;
    case '/header':
        require_once  $_SERVER['DOCUMENT_ROOT'] . "/adminka/header.php";
        break;
    case '/settings':
        require_once  $_SERVER['DOCUMENT_ROOT'] . "/adminka/settings.php";
        break;
    case '/table':
        require_once  $_SERVER['DOCUMENT_ROOT'] . "/adminka/table.php";
        break;
    case '/register':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/register.php";
        break;
    case '/search':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/pages/search.php";
        break;
    case '/gen_pass':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/gen_pass.php";
        break;
    case '/admin':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/adminka/index.php";
        break;
    case '/new':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/new.php";
        break;
    case '/ban':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/ban.php";
        break;
    case '/update':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/update_posts.php";
        break;
    case '/delete':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/delete.php";
        break;
    case '/view':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/pages/view.php";
        break;
    case '/login':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/user/login.php";
        break;
    case '/exit':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/user/exit.php";
        break;
    default:
        require_once $_SERVER['DOCUMENT_ROOT'] . "/404.php";
        break;
}