<fieldset class="box">
    <legend class="rim">Ubah Kelompok Remunerasi</legend>
<!--<div class="white-container">
    <legend class="rim2">Ubah <b>Kelompok Remunerasi</b></legend>-->
    <?php
    $this->breadcrumbs=array(
            'Kelrem Ms'=>array('index'),
            $model->kelrem_id=>array('view','id'=>$model->kelrem_id),
            'Update',
    );

    $arrMenu = array();
//                  array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kelompok Remunerasi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAGelarBelakangM', 'icon'=>'list', 'url'=>array('index'))) ;
                    (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kelompok Remunerasi', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;
    ?>
    <?php //echo $this->renderPartial('_tabMenu',array()); ?>
    <!--<div class="biru">
        <div class="white">-->
            <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        <!--</div>
    </div>
</div>-->
</fieldset>