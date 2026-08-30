<?php
$this->breadcrumbs = array(
    'Retur Penerimaan Persediaan Bahan Makanan' => Yii::app()->request->getUrlReferrer(),
);

$arrMenu = array();

$this->menu = $arrMenu;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-briefcase"></i> Retur Penerimaan <b>Persediaan Bahan Makanan</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial('_form', array('model' => $model, 'modDetails' => $modDetails, 'modTerima' => $modTerima, 'id' => $id)); ?>
            </div>
        </div>
    </div>
</div>