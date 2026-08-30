<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Inventarisasi Peralatan dan Mesin</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Guinvperalatan Ts' => array('index'),
            $model->invperalatan_id => array('view', 'id' => $model->invperalatan_id),
            'Update',
        );
        $arrMenu = array();
      
        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_formUpdate', array('model' => $model, 'data' => $data, 'dataAsalAset' => $dataAsalAset, 'dataLokasi' => $dataLokasi, 'modBarang' => $modBarang, 'modelDetail' => $modelDetail,)); ?>
        <?php $this->renderPartial('manajemenAset.views._jsFunction', array()); ?>
    </div>
</div>