<?php
$contents = R::findAll('content', 'ORDER BY `content`.`id` DESC');
?>
<?php if (empty($contents)) : ?>
    <div class="alert alert-danger" role="alert" style="text-align: center;font-size: 20px;">нет новостей&nbsp;<i class="fa fa-frown-o fa-spin" aria-hidden="true"></i></div>
<?php else : ?>
    <?php foreach ($contents as $content) : ?>
        <div class="card d-flex mb-3">
            <div class="card-body">
                <div class="card-title h4"><a href="view?id=<?= $content->id ?>" class="main_link"><?= $content->title ?></a></div>
                <div class="card-text"><?= sumStr($content->text) ?></div>
                <div>
                </div>
                <div class="text-secondary">
                    <i class="fa fa-calendar" aria-hidden="true" style="color: blue;" title="Дата"></i>&nbsp;<?= $content['date'] ?>&nbsp;
                    <i class="fa fa-comments-o" aria-hidden="true" style="color: blue;" title="Комминтарии"></i>&nbsp;комминтариев(<?= countComments($content->id) ?>)&nbsp;
                    <i class="fa fa-thumbs-o-up text-success" aria-hidden="true" title="like"></i>&nbsp;<?= countLike($content->id) ?>&nbsp;
                    <i class="fa fa-thumbs-o-down text-danger" aria-hidden="true" title="dislike"></i>&nbsp;<?= countDisLike($content->id) ?>
                </div>
            </div>
        </div>
    <?php endforeach ?>
<?php endif ?>