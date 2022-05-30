<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user = R::findOne('users', 'email = ?', [$_POST['email']]);
    $errors = [];
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $errors[] = "Заполните все поля\n";
    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "не верный email или пароль\n";
    }
    if ($user->email != $_POST['email']) {
        $errors[] = "не верный email или пароль\n";
    }
    if (password_verify($_POST['password'], $user->password)) {
        $_SESSION['user'] = [
            'email' => $user->email,
            'name' => $user->name,
            'id' => $user->id,
            'avatar' => $user->avatar,
            'role' => $user->role,
        ];
        header("Location: /");
    } else {
        $errors[] = "не верный email или пароль\n";
    }
}
?>

<form class="form-control m-auto" method="POST">
    <div>
        <h5 class="text-center">Войти в аккаунт</h5>
        <?php if (!empty($errors)) : ?>
            <?php foreach (array_unique($errors) as $error) : ?>
                <div class="text-danger text-center"><?= nl2br($error) ?></div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" required>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Пароль</label>
        <input type="password" class="form-control" name="password" required>
    </div>
    <div class="d-grid gap-2 mb-3">
        <button type="submit" class="btn btn-primary">Войти</button>
    </div>
    <div class="form-text">Нет аккаунта? тогда <a href="register">зарегестрируйся</a></div>
</form>