<!--div class="white-container"-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Master Formularium Obat</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Formulasi Obat' => array('index'),
            $model->formulariumobat_id => array('view', 'id' => $model->formulariumobat_id),
            'Update',
        );

        $arrMenu = array();

        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view . '_formUpdate', array('model' => $model)); ?>
    </div>
</div>