<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Jadwal Makanan</b>
        </div>
    </div>
    <div class="panel-body">
        <!--<div class="white-container">
            <legend class="rim2">Tambah <b>Jadwal Makan</b></legend>-->
        <?php
        $this->breadcrumbs = array(
            'Gzjadwalmakan Ms' => array('index'),
            'Create',
        );

        $arrMenu = array();
        //                    array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jadwal Makan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jadwal Makan', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jadwal Makan', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
        <?php //$this->widget('UserTips',array('type'=>'create')); 
        ?>
    </div>
</div>