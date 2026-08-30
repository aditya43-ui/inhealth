<?php $linkHalaman = CustomFunction::getUrlByMenuID(1210); ?>
<?php
$this->breadcrumbs = array(
    'Retur Penerimaan Persediaan Barang' => Yii::app()->request->getUrlReferrer(),
);
$arrMenu = array();
// array_push($arrMenu,array('label'=>Yii::t('mds','Create').' GUReturpenerimaanT ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
// array_push($arrMenu,array('label'=>Yii::t('mds','List').' GUReturpenerimaanT', 'icon'=>'list', 'url'=>array('index'))) ;
// (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' GUReturpenerimaanT', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;
$this->menu = $arrMenu;
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fab fa-rev"></i> Retur Penerimaan <b>Persediaan Barang</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form', array('model' => $model, 'modDetails' => $modDetails, 'modTerima' => $modTerima, 'id' => $id)); ?>
    </div>
</div>