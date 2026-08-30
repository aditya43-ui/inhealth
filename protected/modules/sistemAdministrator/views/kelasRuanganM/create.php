<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Kelas Ruangan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php // $this->renderPartial('_tab'); 
        ?>
        <?php
        $this->breadcrumbs = array(
            'Kelas Ruangan' => array('admin'),
            'Create',
        );

        $arrMenu = array();
        array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Kelas Ruangan ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
        //array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kelas Ruangan', 'icon'=>'list', 'url'=>array('index'))) ;
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Kelas Ruangan', 'icon' => 'folder-open', 'url' => array('Admin'))) :  '';

        //$this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model, 'modRuangan' => $modPelayanan)); ?>
        <?php //$this->widget('UserTips',array('type'=>'create'));
        ?>
    </div>
</div>