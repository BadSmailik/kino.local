<?php
$user = R::load('users', $_GET['id']);
if ($user->id == 0) {
    header("refresh: 3; /");
}
?>
<title><?= $user->name ?></title>
<div class="card mb-3">
    <img src="<?= $user->avatar ?>" class="card-img-top avatar" alt="<?= $user->name ?>">
    <img src="<?= $user->bg_profile ?>" class="card-img-top bg_profile" alt="<?= $user->name ?>">
    <div class="card-body p-0">
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;<b>Имя:</b>&nbsp; <?= $user->name ?><?= ($user->id == 1) ? '<div class="text-danger"> <img src="user/images/crown.webp" alt="" style="weight: 40px;height: 40px;"> <b>Создатель</b></div>' : '' ?></li>
            <li class="list-group-item"><i class="fa fa-at" aria-hidden="true"></i>&nbsp;<b>Email:</b>&nbsp; <?= $user->email ?></li>
            <li class="list-group-item"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;<b>Пол:</b>&nbsp; <?= $user->sex ?></li>
            <li class="list-group-item"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;<b>Дата регистрации:</b>&nbsp;<?= $user['date'] ?></li>
            <?php if (@$_SESSION['user']['role'] >= 2) : ?>
                <li class="list-group-item"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;<b>ip:</b>&nbsp;<?= $user->ip ?></li>
                <li class="list-group-item"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;<b>Браузер:</b>&nbsp;<?= $user->browser ?></li>
                <li class="list-group-item"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;<b>Операционная система(OC):</b>&nbsp;<?= $user->oc ?></li>
                <li class="list-group-item"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;<b>Устройство:</b>&nbsp;<?= $user->device ?></li>
                <li class="list-group-item"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;<b>User Agent:</b>&nbsp;<?= $user->agent ?></li>
            <?php endif ?>
        </ul>
    </div>
</div>