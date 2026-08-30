<div class="white-container">
    <legend class="rim2">Ubah <b>Konfigurasi Farmasi</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sakonfigfarmasi Ks'=>array('index'),
            $model->konfigfarmasi_id=>array('view','id'=>$model->konfigfarmasi_id),
            'Update',
    );

    $arrMenu = array();
    //    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Konfigurasi Farmasi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
</div>