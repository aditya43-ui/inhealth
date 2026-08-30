<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Ubah <strong>Master Paket Obat</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Paket Obat' => array('admin'),
            $model->paketobat_id => array('view', 'id' => $model->paketobat_id),
            'Ubah',
        );

                ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model,'modDetail'=> $modDetail, 'loadDetail'=>$loadDetail, 'racikan' => $racikan, 'nonRacikan' => $nonRacikan, 'racikanDetail' => $racikanDetail)); ?>
    </div>
</div>