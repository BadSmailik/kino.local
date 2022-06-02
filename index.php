<?php
session_start();
error_reporting(E_ALL);
require_once __DIR__ . "/functions/function.php";
connectDB();
quest();
require_once __DIR__ . "/pages/header.php";
userInfo();
?>
<div class="container d-flex justify-content-between pt-3">
	<div class="col me-3">
		<main>
			<?php require_once __DIR__ . "/functions/core.php" ?>
		</main>
	</div>
	<div class="col-3">
		<div class="card">
			<div class="card-header h5">
				Поиск по сайту
			</div>
			<form action="search" class="d-flex p-2" role="search" method="GET">
				<input class="form-control me-2" type="search" aria-label="Search" name="q" placeholder="Введите запрос...">
				<button class="btn btn-outline-success" type="submit">Искать</button>
			</form>
		</div>
		<?php if (@$_SESSION['user'] !== NULL) : ?>
			<div class="card mt-3">
				<div class="card-header h5">
					<?= $_SESSION['user']['name'] ?>
				</div>
				<div class="list-group">
					<img src="<?= $_SESSION['user']['avatar'] ?>" alt="">
					<a class="list-group-item" href="profile?id=<?= $_SESSION['user']['id'] ?>"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;
						Профиль</a>
					<a class="list-group-item" href="update_profile?id=<?= $_SESSION['user']['id'] ?>"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i>&nbsp; Изменить профиль</a>
					<?php if (is_admin()) : ?>
						<a class="list-group-item" href="admin"><i class="fa fa-user-secret" aria-hidden="true"></i>&nbsp;
							Админка</a>
					<?php endif ?>
					<a href="exit" class="list-group-item text-danger"><i class="fa fa-sign-out fa-rotate-180" aria-hidden="true"></i>&nbsp;&nbsp;Выйти</a>
				</div>
			<?php else : ?>
				<div class="list-group d-flex justify-content-between mt-3">
					<a class="btn btn-primary" href="login">Войти</a>
					<div class="form-text text-center">или</div>
					<a class="btn btn-success" href="register">Зарегестрироваться</a>
				</div>
			<?php endif ?>
			</div>
	</div>
	<?php require_once __DIR__ . "/pages/footer.php" ?>