<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Kasus Penyakit Ruangan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Kasus Penyakit Ruangan' => array('admin'),
            $_GET['id'] => array('view', 'id' => $_GET['id']),
            'Ubah',
        );
        $arrMenu = array();
        array_push($arrMenu, array('label' => Yii::t('mds', 'Update') . ' Kasus Penyakit Ruangan ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Kasus Penyakit Ruangan ', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';
        //$this->menu=$arrMenu;		
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php echo $this->renderPartial($this->path_view . '_formUpdate', array('model' => $model, 'modDetails' => $modDetails)); ?>
    </div>
</div>