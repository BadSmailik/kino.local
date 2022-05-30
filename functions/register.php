<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $errors = [];
    if (strlen($_POST['name']) < 3) $errors[] .= 'Не допустимая длина имя';
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $errors[] .= 'Не коректный email';
    $countEmail = R::findOne('users', 'email = ?', [$_POST['email']]);
    if ($countEmail) {
        $errors[] .= 'email' . "\n$users->email\n" . 'уже есть в базе';
    }
    if ($_POST['email'] == '') {
        $errors[] .= 'Не допустимая длина email';
    }
    if (is_numeric($_POST['name'])) {
        $errors[] .= 'не коректные данные';
    }
    if (empty($_POST['sex'])) {
        $errors[] .= 'выбирите пол';
    }
    if ($_POST['password'] == '') {
        $errors[] .= 'пароль не может быть пустым';
    }
    if (!empty($errors)) {
        for ($i = 0; $i < count($errors); $i++) {
            echo '<div class="alert alert-danger text-center m-auto mb-3" role="alert">' . $errors[$i] . '</div>';
        }
    } else {
        // $errors = [];
        $agent = get_browser($_SERVER['HTTP_USER_AGENT'], true);
        $users = R::dispense('users');
        $users->name = $_POST['name'];
        $users->email = $_POST['email'];
        $users->password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $users->ip = $_SERVER['REMOTE_ADDR'];
        $users->sex = $_POST['sex'];
        $users->avatar = null;
        $users->bg_profile = null;
        $users->date = date('d.m.Y H:i');
        $users->role = 0;
        $users->ban = 0;
        // $users->browser = $agent['browser'];
        // $users->oc = $agent['platform'];
        // $users->device = $agent['device_type'];
        // $users->agent = $agent['browser_name_pattern'];
        R::store($users);
        if (R::store($users) == true) {
            session_start();
            $_SESSION['user'] = [
                'name' => $users->name,
                'email' => $users->email,
                'ip' => $users->ip,
            ];
            R::close();
            header("Location: /");
        }
    }
}
?>
<form class="form-control m-auto" method="POST">
    <div class="mb-3">
        <h5 class="text-center">Регистрация</h5>
    </div>
    <div class="mb-3">
        <label for="exampleInputText1" class="form-label">Имя&nbsp;<span class="form-text text-danger">*</span></label>
        <input type="text" class="form-control" id="exampleInputText1" aria-describedby="textHelp" name="name" value="<?= (!empty($_POST['name'])) ? $_POST['name'] : '' ?>" required>
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email адрес&nbsp;<span class="form-text text-danger">*</span></label>
        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" value="<?= (!empty($_POST['email'])) ? $_POST['email'] : '' ?>" required>
        <div id="emailHelp" class="form-text">
            Мы никогда не будем делиться вашей электронной почтой с кем-либо еще.</div>
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Выбирите пол&nbsp;<span class="form-text text-danger">*</span></label>
        <select class="form-select" aria-label="Default select example" name="sex" required>
            <option disabled selected>Выбирите пол</option>
            <option value="Мужской">Мужской</option>
            <option value="Женский">Женский</option>
        </select>
    </div>
    <div class="mt-3">
        <label for="exampleInputPassword1" class="form-label">Пароль&nbsp;<span class="form-text text-danger">*</span></label>
        <input type="password" class="form-control" id="exampleInputPassword1" name="password">
    </div>
    <div class="form-text mb-3">
        поля с красной&nbsp;<span class="form-text text-danger"><b>*</b></span>&nbsp;обязательны
    </div>
    <div class="mb-3 d-grid gap-2">
        <button type="submit" class="btn btn-success">Зарегестрироваться</button>
    </div>
    <div class="form-text">Есть аккаунт? тогда тебе <i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;<a class="" href="login">войти</a></div>
</form>