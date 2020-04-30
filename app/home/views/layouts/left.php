<?php
use yii\bootstrap\Collapse;
?>
<?if(Yii::$app->user->getId()):?>
    <div class="col-sm-2">
        <div id="manager-menu" class="list-group">
            <?php
            $lsItemConf = Yii::$app->params['menuList'];

            $lsItem = [];
            foreach($lsItemConf as $k => $v){
                $lsItem[$k]['label'] = $v['label'];
                foreach($v['content'] as $k2 => $v2){
                    $lsItem[$k]['content'][] = '<a href="'. $v2['url'] . '">' . $v2['name'] . '</a>';
                }
            }
            echo Collapse::widget(['items' => $lsItem,]);
            ?>
        </div>
    </div>
<?endif;?>