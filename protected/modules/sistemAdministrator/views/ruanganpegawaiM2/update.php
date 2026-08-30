<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Ruangan Pegawai</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pegawai Ruangan' => array('admin'),
            $model->ruangan_id => array('view', 'id' => $model->ruangan_id),
            'Ubah',
        );

        $arrMenu = array();
        array_push($arrMenu, array('label' => Yii::t('mds', 'Update') . ' Kelas Ruangan ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Kelas Ruangan ', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

        //$this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_formUpdate', array('model' => $model, 'modDetails' => $modDetails)); ?>
    </div>
</div>