<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Pengiriman Kantong Darah</div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
            'Pengiriman Kantong Darah'=>array('index'),
            'Tambah',
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php 
            if(!empty($_GET['id'])){        
        ?>
            <?php echo Yii::app()->user->setFlash('success',"Data Pengiriman Kantong Darah Berhasil Disimpan !"); ?>
        <?php } ?>

        <?php echo $this->renderPartial($this->path_view.'_form', array(
                'modKirimKantong'=>$modKirimKantong, 
                'modKirimKantongDetail'=>$modKirimKantongDetail,
                'modMonitoringKantong'=>$modMonitoringKantong,
                'format'=>$format
                )); ?>
    </div>
</div>
