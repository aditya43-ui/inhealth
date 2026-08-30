<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Paket Pelayanan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Paket Pelayanan' => array('admin'),
            $model->paketpelayanan_id => array('view', 'id' => $model->paketpelayanan_id),
            'Ubah',
        );

        $arrMenu = array();
        //	array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Paket Pelayanan #'.$model->paketpelayanan_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_formUpdate', array('model' => $model)); ?>
    </div>
</div>