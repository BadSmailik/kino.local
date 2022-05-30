<?php
$id = $_GET['id'];
$all_comments = R::findAll('comments', 'id_content = ?', [$id]);
$content = R::load('content', $id);
grade($id);
// if ($query = R::getAll('SELECT * FROM grade WHERE id_content = :id AND login = :login', [':id' => $id, ':login' => $_SESSION['user']['name']]) > 1) {
//     R::trashAll($query);
// }
// debug($query);
if (isset($_POST['delete'])) {
    custom_delete('comments');
}
?>
<title><?= $content->title ?></title>
<?php if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['actionComment'])) actionComment($id) ?>
<div class="card mb-3">
    <div class="card-header">
        <h5><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;<?= $content->category ?></h5>
        <div class="form-text"><i class="fa fa-calendar text-primary" aria-hidden="true"></i>&nbsp; <?= $content['date'] ?></div>
        <div class="mt-2"><a href="profile?id=<?= $content->user_id ?>"><?= $content->login ?></a></div>
    </div>
    <div class="card-body">
        <h2 class="card-title"><b><?= $content->title ?></b></h2>
        <div class="text"><?= $content->hash ?></div>
        <p class="card-text">
            <?= $content->text ?>
        </p>
        <?php if (!empty($_SESSION['user'])) : ?>
            <form class="d-flex justify-content-end m-3" method="POST">
                <button class="btn btn-outline-success" type="submit" name="like" <?= is_like($id) ?>><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;<?= countLike($id) ?></button>&nbsp;
                <button class="btn btn-outline-danger" type="submit" name="dislike" <?= is_like($id) ?>><i class="fa fa-thumbs-o-down" aria-hidden="true"></i>&nbsp;<?= countDisLike($id) ?></button>
            </form>
        <?php endif ?>
    </div>
</div>
<div class="mb-3">
    <form class="form-control" method="POST">
        <h5 class="text">Комментарии&nbsp;<?= countComments($id) ?></h5>
        <div class="form-text text-danger mb-2">
            <?php
            if (!empty($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
        </div>
        <textarea class="form-control" name="comment" placeholder="Комментарий..."></textarea>
        <div class="mt-3">
            <button class="btn btn-primary" type="submit" name="actionComment">Комментировать</button>
        </div>
    </form>
</div>
<?php if (!empty($all_comments)) : ?>
    <?php foreach (array_reverse($all_comments) as $comment) : ?>
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <div>
                    <i class="fa fa-user-o" aria-hidden="true" style="color: blue;"></i>&nbsp;<b><?= $comment['login'] ?></b>
                    <i class="fa fa-calendar-o" aria-hidden="true" style="color: blue;"></i>&nbsp;<?= $comment->date_post ?>
                </div>
                <div>
                    <?php if ($comment['id_login'] == @$_SESSION['user']['id'] || @$_SESSION['user']['role'] >= 2) : ?>
                        <div class="btn-group dropstart">
                            <a type="button" class="" data-bs-toggle="dropdown" aria-expanded="false" style="border: none;">
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <form method="post">
                                    <input type="hidden" name="id" value="<?= $comment['id'] ?>">
                                    <li><button type="submit" name="delete" value="del_comment" class="dropdown-item"><i class="fa fa-trash-o" aria-hidden="true" style="color: brown;"></i>&nbsp;Удалить</button></li>
                                </form>
                                <li><a class="dropdown-item" href="update?id=<?= $id ?>"><i class="fa fa-pencil-square-o" style="color: blue;"></i>&nbsp;Изменить</a></li>
                            </ul>
                        </div>
                    <?php endif ?>
                </div>
            </div>
            <div class="form-text"></div>
            <div class="card-text p-3">
                <?= $comment['comment'] ?>
            </div>
        </div>
    <?php endforeach ?>
<?php else : ?>
    <div class="alert alert-primary text-center" role="alert">Нет комментариев,&nbsp;<b>Вы</b>&nbsp;можете стать первым&nbsp;<i class="fa fa-smile-o fa-2x fa-spin" aria-hidden="true"></i></div>
<?php endif ?>
<?php if (is_admin()) : ?>
    <div class="dropdown">
        <a class="btn btn-primary dropdown-toggle" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-cog fa-spin fa-fw" aria-hidden="true"></i> Действия
        </a>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <form action="/functions/delete.php" method="post">
                <input type="hidden" name="id" value="<?= $id ?>">
                <li><button type="submit" name="delete" value="del_post" class="dropdown-item"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i>&nbsp; Удалить</button></li>
            </form>
            <li><a class="dropdown-item" href="update?id=<?= $id ?>"><i class="fa fa-pencil-square-o text-primary"></i>&nbsp; Изменить</a></li>
        </ul>
    </div>
<?php endif ?>