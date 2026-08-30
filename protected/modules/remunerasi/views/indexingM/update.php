<!--<div class="white-container">
    <legend class="rim2"><b>Indexing</b></legend>-->
<fieldset class="box">
    <legend class="rim">Ubah Indexing</legend>
    <?php
    $this->breadcrumbs=array(
            'Indexing Ms'=>array('index'),
            $model->indexing_id=>array('view','id'=>$model->indexing_id),
            'Update',
    );

    $arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Indexing ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAGelarBelakangM', 'icon'=>'list', 'url'=>array('index'))) ;
                    (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Indexing', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

   // $this->menu=$arrMenu;
    ?>
    <?php //echo $this->renderPartial('_tabMenu',array()); ?>
    <!--<div class="biru">
        <div class="white">-->
            <?php echo $this->renderPartial('_form', array('model'=>$model, 'det'=>$det)); ?>
        <!--</div>
    </div>
</div>-->
</fieldset>