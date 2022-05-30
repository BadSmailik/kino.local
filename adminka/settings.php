<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['btn_action'])) {
    $image_type = R::dispense('imagetype');
    $image_type->mime_type = $_POST['mime_type'];
    $image_type->format = $_POST['format'];
    $image_type->action = $_POST['action'];
    R::store($image_type);
}
?>
<form class="form-control m-auto" method="post" style="width: 400px;">
    <div class="mb-3">
        <label for="formTextInput" class="form-label">MIME type пример:&nbsp;(image/gif)</label>
        <input class="form-control" type="text" name="mime_type">
    </div>
    <div class="mb-3">
        <label for="formTextInput" class="form-label">Формат приимер:&nbsp;(gif)</label>
        <input class="form-control" type="text" name="format">
    </div>
    <div class="mb-3">
        <label for="formTextInput" class="form-label">Заголовок статьи</label>
        <select class="form-select" aria-label="Default select example" name="action">
            <option disabled selected>Выбирите действие</option>
            <option value="true">вкл</option>
            <option value="false">выкл</option>
        </select>
    </div>
    <div class="mb-3">
        <button class="btn btn-success" name="btn_action" type="submit">Добавить настройку</button>
    </div>
</form>