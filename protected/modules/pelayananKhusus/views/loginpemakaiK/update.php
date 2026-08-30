<?php if (Yii::app()->user->checkAccess('Update')) { ?>
<?php
$this->breadcrumbs=array(
	'Loginpemakai Ks'=>array('index'),
	$model->loginpemakai_id=>array('view','id'=>$model->loginpemakai_id),
	'Update',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Login Pemakai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Login Pemakai', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Login Pemakai', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Login Pemakai', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->loginpemakai_id))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Login Pemakai', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model,'modRuanganPemakai'=>$modRuanganPemakai,'modModulPemakai'=>$modModulPemakai,)); ?>
<?php $this->widget('UserTips',array('type'=>'update','content'=>'<ol><strong>Ganti Password</strong><li>Isi Kolom Password lama, password baru apabila ingin mengganti password Anda.</li></ol>'));?>
<?php }else{ 
                throw new CHttpException(404,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));
             }
?>