<?php
$users = R::findAll('users');
$data = $_POST;
if (isset($data['seach'])) {
	$res = R::load('users', $data['seach_id']);
	if ($res->name == '') {
		$msg .= '<b class="text-danger">Нет такого пользователя</b>';
	} else {
		$msg .= "<div class='text-success'>$res->name</div>";
	}
}
?>
<div class="">
	<div class="mb-3">
		<form class="form-control" method="POST">
			<div class="d-flex flex-column">
				<label for="floatingInput">Поиск пользователя по (id)</label>
				<input class="form-control" type="text" name="seach_id">
				<?= @$msg ?>
				<input class="btn btn-primary mt-2" type="submit" name="seach" value="Найти">
			</div>
		</form>
	</div>
	<table class="table table-striped table-hover bg-light">
		<thead>
			<tr>
				<th scope="col">id</th>
				<th scope="col">Имя пользователя</th>
				<th scope="col">Действие</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($users as $user) : ?>
				<tr>
					<th scope="row"><?= $user->id ?></th>
					<td><?= $user->name ?></td>
					<td>
						<form action="functions/delete.php" method="post">
							<input type="hidden" name="id" value="<?= $user->id ?>">
							<button class="btn btn-danger" type="submit" name="delete" value="del_user"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;Удалить</button>
						</form>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>