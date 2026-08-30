<div class="panel panel-gradient">
    <div class="panel-heading">
        <?php if ($this->hasTab) : ?>
            <div class="panel-title">
                <i class="far fa-plus-square"></i> Tambah <b>Golongan Gaji</b>
            </div>
        <?php else : ?>
            <div class="panel-title">
                <i class="far fa-plus-square"></i> Tambah <b>Golongan Gaji</b>
            </div>
        <?php endif; ?>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Golongan Gaji' => array('admin'),
            'Create',
        );

        $arrMenu = array();
        //array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Golongan Gaji ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //(Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Golongan Gaji', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>
    </div>
</div>