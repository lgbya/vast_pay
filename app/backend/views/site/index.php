<?php

/* @var $this yii\web\View */

$this->title = '服务器信息';
?>



<div class="row">
    <div class="col-xs-12">

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">服务器信息</h3>
            </div>
            <div class="box-body">
                <div class="product-view">

                    <div class="login-info-box">
                        <div class="login-info-box1">
                            <p class="f-20 text-success">欢迎回来
                                <span class="f-14"><?= $oqAdmin->username; ?></span>!
                            </p>
                            <p>上次登录IP：<?= $oqAdmin->pre_login_ip; ?></p>
                            <p>上次登录时间：<?= date('Y-m-d H:i:s', $oqAdmin->pre_login_at); ?></p>
                        </div>
                    </div>
                    <table id="w0" class="table table-striped table-bordered detail-view">
                        <thear></thear>
                        <tbody>
                        <? foreach($lAppInfo as $k=>$v):?>
                            <tr>
                                <th width="45%"><?= $k ?></th>
                                <td><?= $v?></td>
                            </tr>
                        <? endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

