<?php
    $this->breadcrumbs=array(
            'Matauang Ms'=>array('index'),
            $model->jenispenerimaan_id=>array('view','id'=>$model->jenispenerimaan_id),
            'Update',
    );

    $arrMenu = array();
                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Jurnal Rek Penerimaan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jurnal Rek Penerimaan ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); 
?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>