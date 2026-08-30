<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Tambah <b>List KIE</b></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'List KIE'=>array('admin'),
                'Tambah',
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Cara Pembayaran ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Cara Pembayaran', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Cara Pembayaran', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

        $this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        <?php //$this->widget('UserTips',array('type'=>'create'));?>
        
        
    </div>
</div>

