<!--div class="white-container"-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Kelompok Sebab Abortus</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Pskelsebababortus Ms' => array('index'),
            $model->kelsebababortus_id,
        );
        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Kelompok Sebab Abortus ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAKelsebababortusM', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SAKelsebababortusM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SAKelsebababortusM', 'icon'=>'pencil','url'=>array('update','id'=>$model->kelsebababortus_id))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SAKelsebababortusM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->kelsebababortus_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kelompok Sebab Abortus', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;
        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'kelsebababortus_id',
                'kelsebababortus_nama',
                'kelsebababortus_namalain',
                'kelsebababortus_aktif',
            ),
        ));
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelompok Sebab Abortus', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
        $this->widget('UserTips', array('type' => 'view'));
        ?>
    </div>
</div>
<!--/div-->