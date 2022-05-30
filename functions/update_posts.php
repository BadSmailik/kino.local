<?php
if (!is_admin()) {
    header("Location: /");
}
$update = R::load('content', $_GET['id']);

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['update']) {
    $update->title = $_POST['title'];
    $update->category = $_POST['category'];
    $update->text = $_POST['text'];
    R::store($update);
    R::close();
}

?>
<form class="form-control" method="post">
    <div class="mb-3">
        <label for="formTextInput" class="form-label">Заголовок</label>
        <input class="form-control" type="text" name="title" value="<?= $update->title ?>">
    </div>
    <div class="mb-3">
    <label for="formTextInput" class="form-label">Категории</label>
        <select class="form-select" aria-label="Default select example" name="category" required>
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
    <label for="formTextarea" class="form-label">Текст</label>
        <textarea class="form-control" rows="3" name="text" placeholder="Текст"><?= $update->text ?></textarea>
        <script>
            tinymce.init({
                selector: 'textarea',
                plugins: 'a11ychecker advcode casechange export formatpainter image editimage linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tableofcontents tinycomments tinymcespellchecker',
                toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter image editimage pageembed permanentpen table tableofcontents',
                toolbar_mode: 'floating',
                tinycomments_mode: 'embedded',
                tinycomments_author: 'Author name',
            });
        </script>
    </div>
    <div class="">
        <button class="btn btn-primary" type="submit" name="update">Изменить</button>
    </div>
</form>