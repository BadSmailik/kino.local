<?php
require_once "../functions/function.php";
require_once "../functions/rb.php";
connectDB();
$id = $_POST['id'];

if (isset($_POST['delete'])) {
    switch ($_POST['delete']) {
        case 'del_user':
            $user = R::load('users', $id);
            R::trash($user);
            header("Location: {$_SERVER['HTTP_REFERER']}");
            break;
        case 'del_post':
            $content = R::load('content', $id);
            R::trash($content);
            header("Location: {$_SERVER['HTTP_REFERER']}");
            break;
        case 'del_comment':
            $comment = R::load('comments', $id);
            R::trash($comment);
            header("Location: {$_SERVER['HTTP_REFERER']}");
            break;
        default:
            echo 'всё пропало ШЕФ';
            break;
    }
}
