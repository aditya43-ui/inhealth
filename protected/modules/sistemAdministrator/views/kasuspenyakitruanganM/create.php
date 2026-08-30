<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Kasus Penyakit Ruangan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Kasus Penyakit Ruangan' => array('index'),
            'Tambah',
        );

        $arrMenu = array();
        array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Kasus Penyakit Ruangan ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
        //array_push($arrMenu,array('label'=>Yii::t('mds','List').' SANapzaM', 'icon'=>'list', 'url'=>array('index'))) ;
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Kasus Penyakit Ruangan', 'icon' => 'folder-open', 'url' => array('Admin'))) :  '';

        //$this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model, 'modDetails' => $modDetails)); ?>
    </div>
</div>