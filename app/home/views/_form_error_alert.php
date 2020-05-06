<?php
use yii\bootstrap\Alert;
?>
<div class="row">
        <div class="col-lg-12  col-md-offset">
        <?php foreach ($formValidate->getErrorSummary($formValidate) as $message): ?>
            <?= Alert::widget([
                'options' => ['class' => 'alert-dismissible alert-danger'],
                'body' => $message
            ]) ?>
        <?php endforeach ?>
    </div>
</div>