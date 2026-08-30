<div class="white-container">
    <legend class="rim2">Ubah <b>Nominal Tarif</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Nominal Tarif Ms'=>array('index'),
            $model->tariftindakan_id=>array('view','id'=>$model->tariftindakan_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Tarif Tindakan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Tarif Tindakan', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Tarif Tindakan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Tarif Tindakan', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->tariftindakan_id))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tarif Tindakan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;
    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_formTarifTindakanUpdate',array(
                                                                                        'modDaftarTindakan'=>$modDaftarTindakan,
                                                                                        'model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'update','content'=>'Ubah Harga Tindakan yang akan diupdate'));?>
</div>