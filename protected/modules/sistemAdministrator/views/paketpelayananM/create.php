<div class="panel panel-gradient">
    <div class="panel-heading">    
        <div class="panel-title">
<i class="far fa-plus-square"></i> <?php echo ($this->action->id == 'update') ? 'Ubah' : 'Tambah'; ?> Paket Pelayanan</div>
    </div>
    <div class="panel-body"> 
    <?php
    $this->breadcrumbs=array(
            'Paket Pelayanan'=>array('admin'),
             ($this->action->id == 'update') ? 'Ubah' : 'Tambah',
    );

    $arrMenu = array();
    //	array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Paket Pelayanan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    $this->menu=$arrMenu;
    $totaltarif = 0;
    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model, 'dataPaketPelayanan'=>$modPaket, 'totaltarif'=>$totaltarif, 'modPaket'=>$modPaket, 'kelas'=>$kelas)); ?>
</div>
</div>