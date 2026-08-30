<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><i class="glyphicon glyphicon-briefcase"></i> Register Inventarisasi Peralatan dan Mesin</div>
    </div>
    <div class="panel-body">
        
    <?php
    $this->breadcrumbs=array(
            'Guinvperalatan Ts'=>array('index'),
            'Create',
    );
    $this->widget('bootstrap.widgets.BootAlert');
    // $this->renderPartial('/_dataBarang', array('modBarang' => $modBarang ));

    $arrMenu = array();
                 //   array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Inventarisasi Peralatan dan Mesin ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    //array_push($arrMenu,array('label'=>Yii::t('mds','List').' MAInvperalatanT', 'icon'=>'list', 'url'=>array('index'))) ;
                    //(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Inventarisasi Peralatan dan Mesin', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model,'modelDetail' => $modelDetail,'modBarang' => $modBarang)); ?>
    <?php $this->renderPartial('manajemenAset.views._jsFunction', array()); ?>
    </div>
</div>