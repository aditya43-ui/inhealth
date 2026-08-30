<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Ruangan Pegawai</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pengaturan Ruangan Pegawai' => Yii::app()->request->getUrlReferrer(),
            'Create',
        );

        $arrMenu = array();
        array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Ruangan Pegawai ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
        //array_push($arrMenu,array('label'=>Yii::t('mds','List').' SANapzaM', 'icon'=>'list', 'url'=>array('index'))) ;
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Ruangan Pegawai ', 'icon' => 'folder-open', 'url' => array('Admin'))) :  '';

        //$this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_form', array('ruangan_id'=>$ruangan_id,'model' => $model, 'modDetails' => $modDetails)); ?>
        <?php //$this->widget('UserTips',array('type'=>'create'));
        ?>
    </div>
</div>