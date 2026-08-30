<?php
$this->breadcrumbs = array(
    'Tindakan Ruangan' => Yii::app()->request->getUrlReferrer(),
    'Lihat'
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Tindakan Ruangan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $arrMenu = array();
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Tindakan Ruangan', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';
        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'ruangan_nama',
                array(
                    'label' => 'Daftar Tindakan',
                    'type' => 'raw',
                    'value' => $this->renderPartial($this->path_view . '_daftarTindakan', array('ruangan_id' => $model->ruangan_id), true),
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Tindakan Ruangan', array('{icon}' => '<i class="entypo-folder"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>