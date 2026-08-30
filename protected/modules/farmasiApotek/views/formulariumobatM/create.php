<!--div class="white-container"-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Master Formularium Obat</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pengaturan Master Formularium Obat' => Yii::app()->request->getUrlReferrer(),
            'Create',
        );

        $arrMenu = array();

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model, 'modDetails' => $modDetails)); ?>
    </div>
</div>