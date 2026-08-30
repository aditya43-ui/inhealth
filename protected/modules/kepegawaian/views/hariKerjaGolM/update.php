<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Hari Kerja Golongan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Hari Kerja Golongan' => array('admin'),
            $model->harikerjagol_id => array('view', 'id' => $model->harikerjagol_id),
            'Update',
        );

        $arrMenu = array();
        array_push($arrMenu, array('label' => Yii::t('mds', 'Update') . ' Hari Kerja Golongan', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
        (Yii::app()->user->checkAccess('Admin')) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Hari Kerja Golongan', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_formUpdate', array('model' => $model)); ?>
        <?php //$this->widget('TipsMasterData',array('type'=>'update'));
        ?>
    </div>
</div>