<?php
$data = $_POST;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $categories = R::dispense('categories');
    $categories->name = $data['name'];
    $categories->uri = $data['uri'];
    $categories->date = date('d.m.Y H:i');
    R::store($categories);
    header("Location: {$_SERVER['REQUEST_URI']}");
    R::close();
}
?>
<!-- <a class="btn btn-info" href="<?= $_SERVER['HTTP_REFERER'] ?>">НАЗАД</a> -->
<form method="post">
    <div class="mb-3">
        <label for="" class="floatingInput mb-2">Имя категории в шапке(header) сайта</label>
        <input class="form-control" type="text" name="name" placeholder="Имя категории">
    </div>
    <div class="mb-3">
        <input class="form-control" type="text" name="uri" placeholder="URI">
    </div>
    <div class="mb-3">
        <button class="btn btn-primary" type="submit">Добавить</button>
    </div>
</form>