<?php
require_once 'inc/image_type_list.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = $_POST;
    $errors = [];
    if (strlen($data['title']) < 2 && $data['title'] == '') {
        $errors[] .= 'не коректно заполнено поле title';
    }
    if ($data['text'] == '' && strlen($data['text']) < 2) {
        $errors[] .= 'не коректно заполнено поле text';
    }
    if (is_uploaded_file($_FILES['img_file']['tmp_name'])) {
        $image = getimagesize($_FILES['img_file']['tmp_name']);
        if ($image != true) {
            $errors[] .= 'файл не является изображением';
        }
        if (file_exists($_FILES['img_file']['tmp_name'])) {
            $path_file = pathinfo('uploads/img_post\/' . time() . $_FILES['img_file']['name']);
            $type_img = mime_content_type($_FILES['img_file']['tmp_name']);
            foreach ($image_type as $k => $v) {
                if ($image_type[$k] == true) {
                    $image_type_on[$k] = $v;
                }
            }
            if (array_key_exists($type_img, $image_type_on)) {
                move_uploaded_file($_FILES['img_file']['tmp_name'], $path_file['dirname'] . '/' . $path_file['basename']);
            } else {
                $errors[] .= 'не верный формат файла';
            }
        } else {
            $errors[] .= 'файл не существует';
        }
    }
    if (empty($errors)) {
        $content = R::dispense('content');
        $content->title = $data['title'];
        $content->hash = $data['hash'];
        $content->img_file = @$path_file['dirname'] . '/' . @$path_file['filename'] . '.' . @$path_file['extension'];
        $content->category = $data['category'];
        $content->text = nl2br($data['text']);
        $content->login = $_SESSION['user']['name'];
        $content->user_id = $_SESSION['user']['id'];
        $content->date_action = date('d.m.Y H:i');
        R::store($content);
        header("Location: {$_SERVER['REQUEST_URI']}");
    } else {
        for ($i = 0; $i < count($errors); $i++) {
            echo '<div class="alert alert-danger text-center" role="alert"><b>' . $errors[$i] . '</b></div><br>';
        }
    }
}
// $api_key = 'e1lg6rzpq17mvmwyrplee0lbega4ezbafjibjd0quye1yqft';
?>
<form class="form-control" method="POST" enctype="multipart/form-data">
    <h5 class="text-center">Добавление статьи</h5>
    <div class="mb-3">
        <label for="formTextInput" class="form-label">Заголовок статьи</label>
        <input class="form-control" type="text" name="title">
    </div>
    <div class="mb-3">
        <label for="formTextInput" class="form-label">Хеш теги</label>
        <input class="form-control" type="text" name="hash">
    </div>
    <div class="mb-3">
        <label for="formFile" class="form-label">Выбирите изображение:</label>
        <div class="mb-2">Доступные форматы(
            <?php foreach ($image_type_list_on as $list_on => $val) : $exp = explode('/', $list_on) ?>
                <?= $exp[1] . ',' ?>
            <?php endforeach ?>
            )</div>
        <input class="form-control" type="file" id="formFile" name="img_file">
    </div>
    <div class="mb-3">
        <label for="formTextInput" class="form-label">Категория</label>
        <select class="form-select" aria-label="Default select example" name="category">
            <option disabled selected>Выбирите категорию</option>
            <option value="Программирование">Программирование</option>
            <option value="Кулинария">Кулинария</option>
            <option value="Фильмы">Фильмы</option>
            <option value="Спорт">Спорт</option>
            <option value="Хобби">Хобби</option>
            <option value="Анимэ">Анимэ</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="formTextInput" class="form-label">Текст статьи</label>
        <textarea class="form-control" rows="3" name="text"></textarea>
        <script>
            tinymce.init({
                selector: 'textarea',
                plugins: 'a11ychecker advcode casechange export formatpainter image editimage linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tableofcontents tinycomments tinymcespellchecker',
                toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter image editimage pageembed permanentpen table tableofcontents media mediaembed',
                toolbar_mode: 'floating',
                tinycomments_mode: 'embedded',
                tinycomments_author: 'Author name',
            });
        </script>
    </div>
    <div class="mb-3">
        <button class="btn btn-success" type="submit">Добавить статью</button>
    </div>
</form>