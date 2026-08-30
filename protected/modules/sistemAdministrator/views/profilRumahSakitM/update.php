<?php
$this->breadcrumbs = array(
    'Profil Rumah Sakit' => array('update'),
    $model->profilrs_id => array('update', 'id' => $model->profilrs_id),
    'Ubah',
);

//$arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Profile Rumah Sakit ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Profile RS', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Profile RS', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Profile RS', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->profilrs_id))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Profile Rumah Sakit', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

//$this->menu=$arrMenu;
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate', array('model' => $model, 'modMisiRS' => $modMisiRS, 'modProfilPict' => $modProfilPict)); ?>
<?php //$this->widget('UserTips',array('type'=>'update'));
?>
