<?php
    $this->breadcrumbs=array(
            'Matauang Ms'=>array('index'),
            $model->bank_id=>array('view','id'=>$model->bank_id),
            'Update',
    );

    $arrMenu = array();
                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').'Bank', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').'Bank ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); 
?>

<?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model)); ?>