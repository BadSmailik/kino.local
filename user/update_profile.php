<?php
require_once 'inc/image_type_list.php';
$query_users = R::findOne('users', $_GET['id']);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (strlen($_POST['name']) < 2 && strlen($_POST['name'] > 15)) {
        $errors[] .= 'Не допустимая длина имя';
    }
    // if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $errors[] .= 'Не коректный email';
    // $countEmail = R::findOne('users', 'email = ?', [$_POST['email']]);
    // if ($countEmail) {
    //     $errors[] .= 'email' . "\n$users->email\n" . 'уже есть в базе';
    // }
    // if ($_POST['email'] == '') {
    //     $errors[] .= 'Не допустимая длина email';
    // }
    // if ($_FILES['avatar'] == NULL) {
    //     $errors[] .= 'Выбирите изображение';
    // }
    if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
        $image = getimagesize($_FILES['avatar']['tmp_name']);
        if ($image != true) {
            $errors[] .= 'файл не является изображением';
        }
        if (file_exists($_FILES['avatar']['tmp_name'])) {
            $path_file = pathinfo('user/images/' . round(microtime(true)). $_FILES['avatar']['name']);
            $type_img = mime_content_type($_FILES['avatar']['tmp_name']);
            foreach ($image_type as $k => $v) {
                if ($image_type[$k] == true) {
                    $image_type_on[$k] = $v;
                }
            }
            if (array_key_exists($type_img, $image_type_on)) {
                $file = move_uploaded_file($_FILES['avatar']['tmp_name'], $path_file['dirname'] . '/' . $path_file['basename']);
            } else {
                $errors[] .= 'не верный формат файла';
            }
        } else {
            $errors[] .= 'файл не существует';
        }
    }
    if (!empty($errors)) {
        for ($i = 0; $i < count($errors); $i++) {
            echo '<div class="alert alert-danger text-center m-auto mb-3" role="alert">' . $errors[$i] . '</div>';
        }
    } else {
        // debug($path_file);
        // print_r($path_file['dirname'] . '/' . $path_file['filename'] . '.' . $path_file['extension']);
        $up_user = R::load('users', $_SESSION['user']['id']);
        $up_user->name = $_POST['name'];
        $up_user->avatar = $path_file['dirname'] . '/' . $path_file['filename'] . '.' . $path_file['extension'];
        R::store($up_user);
    }
}
?>
<form class="form-control" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="formTextInput" class="form-label">Имя</label>
        <input class="form-control" type="text" name="name" value="<?= $query_users->name ?>">
    </div>
    <div class="mb-3">
        <label for="formFile" class="form-label">Выбирите cover:</label>
        <input class="form-control" type="file" id="formFile" name="bg_profile">
    </div>
    <div class="mb-3">
        <label for="formFile" class="form-label">Выбирите аватар:</label>
        <input class="form-control" type="file" id="formFile" name="avatar">
    </div>
    <div class="mb-3">
        <button class="btn btn-success" type="submit">Изменить данные</button>
    </div>
</form>