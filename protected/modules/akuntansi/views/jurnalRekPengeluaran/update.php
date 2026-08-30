<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Jurnal Rekening Pengeluaran</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Jenispengeluaran Ms' => array('index'),
            $model->jenispengeluaran_id => array('view', 'id' => $model->jenispengeluaran_id),
            'Update',
        );

        $arrMenu = array();
        array_push($arrMenu, array('label' => Yii::t('mds', 'Update') . ' Jurnal Rek Pengeluaran ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Jurnal Rek Pengeluaran ', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

        // $this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php echo $this->renderPartial('_formUpdateBaru', array('model' => $model)); ?>
    </div>
</div>