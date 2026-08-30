<div class="panel panel-gradient">
    <div class="panel-heading">
<<<<<<< HEAD
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Re-Evaluasi Aset</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Gupemakaianbarang Ts' => array('index'),
=======
        <div class="panel-title"><i class="glyphicon glyphicon-briefcase"></i>Transaksi Re-Evaluasi Aset</div>
    </div>
    <div class="panel-body">
    
    <?php
    $this->breadcrumbs=array(
            'Re-Evaluasi'=>array('index'),
>>>>>>> 152b37e85d299dbd8eb1b7ff84973d587254cd55
            'Create',
        );

<<<<<<< HEAD
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
        if (!empty($_GET['id'])) {
        ?>
            <?php echo Yii::app()->user->setFlash('success', "Data Pemakaian Barang berhasil disimpan!"); ?>
        <?php } ?>
=======
    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php 
        if(!empty($_GET['id'])){        
    ?>
	<?php echo Yii::app()->user->setFlash('success',"Data Pemakaian Barang berhasil disimpan !"); ?>
    <?php } ?>
>>>>>>> 152b37e85d299dbd8eb1b7ff84973d587254cd55

        <?php echo $this->renderPartial('_form', array(
            'model' => $model
        )); ?>

        <?php $this->renderPartial('manajemenAset.views._jsFunction', array()); ?>
    </div>
</div>