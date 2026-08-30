<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Bidang</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Sabidang Ms' => array('index'),
            $model->bidang_id => array('view', 'id' => $model->golongan_id),
            'Update',
        );
        $arrMenu = array();
        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view . '_formUpdate', array('model' => $model)); ?>
    </div>
</div>