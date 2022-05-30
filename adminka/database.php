<?php
if (isset($_POST['delete'])) {
	custom_delete('content');
}
$contents = R::findAll('content');
?>
<table class="table table-striped table-hover bg-light">
	<thead>
		<tr>
			<th scope="col">id</th>
			<th scope="col">Заголовок статьи</th>
		</tr>
	</thead>
	<tbody>
		<?= (empty($contents)) ? 'Нет статей' : '' ?>
		<?php foreach ($contents as $content) : ?>
			<tr>
				<th scope="row"><?= $content->id ?></th>
				<td><?= $content->title ?></td>
				<td>
					<form method="post">
						<input type="hidden" name="id" value="<?= $content->id ?>">
						<button class="btn btn-danger" type="submit" name="delete" value="del_post"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;удалить</button>
					</form>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>