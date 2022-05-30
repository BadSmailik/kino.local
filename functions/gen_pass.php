<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    echo password_hash($_POST['pass'], PASSWORD_BCRYPT);
}
?>

<form method="POST" class="form-control text-center">
    <input class="form-control" type="text" name="pass" placeholder="Введите ключевое слово">
    <div class="d-grid gap-2 col-6 mx-auto">
        <button class="btn btn-success mt-2" type="submit">Сгенерировать</button>
    </div>
</form>