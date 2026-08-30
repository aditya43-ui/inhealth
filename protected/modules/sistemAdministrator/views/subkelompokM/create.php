<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Sub Kelompok</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Sasubkelompok Ms' => array('index'),
            'Create',
        );

        $arrMenu = array();
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Sub Kelompok', 'icon' => 'folder-open', 'url' => array('Admin'))) :  '';

        $this->menu = $arrMenu;

        //$this->widget('bootstrap.widgets.BootAlert'); 
        ?>

        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>
    </div>
</div>