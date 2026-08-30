<?php
    $this->breadcrumbs=array(
            'Jenispengeluaran Ms'=>array('index'),
                $model->jenispengeluaran_id=>array('view','id'=>$model->jenispengeluaran_id),
            'Update',
    );

    $arrMenu = array();
                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Jurnal Rek Pengeluaran ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jurnal Rek Pengeluaran ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); 
?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>