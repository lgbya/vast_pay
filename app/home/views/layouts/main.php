<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\widgets\Alert;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use home\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap" >
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => '主页', 'url' => ['/site/index']],

            Yii::$app->user->isGuest ? (
            ['label' => '登录', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    '注销 (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            ),

            Yii::$app->user->isGuest ? (
            ['label' => '注册', 'url' => ['/site/register']]
            ) : '',
        ],
    ]);
    NavBar::end();
    ?>


    <div class="container" >
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
            <? if (Yii::$app->controller->action->id !== 'login' && Yii::$app->controller->action->id !== 'register' && Yii::$app->controller->action->id !== 'email-activate'):?>
                <?= $this->render('left.php') ?>
                <div class="col-sm-10">
                    <div class = "box">
                        <div class="box-body">
                            <?= $content ?>
                        </div>
                    </div>
                </div>
            <?else:?>
                <div class = "box">
                    <div class="box-body">
                        <?= $content ?>
                    </div>
                </div>
            <? endif; ?>

    </div>
</div>
<?= $this->render('footer.php') ?>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
