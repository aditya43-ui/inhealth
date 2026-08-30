<!--div class="white-container"-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Kelompok Sebab Abortus</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pskelsebababortus Ms' => array('index'),
            'Create',
        );
        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelompok Sebab Abortus ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAKelsebababortusM', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kelompok Sebab Abortus', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;
        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>
        <?php //$this->widget('UserTips',array('type'=>'create'));
        ?>
    </div>
</div>
<!--/div-->