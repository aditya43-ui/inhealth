<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Pangkat Pegawai</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Sapangkat Ms' => array('index'),
            $model->pangkat_id,
        );

        $arrMenu = array();
        array_push($arrMenu, array('label' => Yii::t('mds', 'View') . ' Pangkat #' . $model->pangkat_id, 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
        array_push($arrMenu, array('label' => Yii::t('mds', 'List') . ' Pangkat', 'icon' => 'list', 'url' => array('index')));
        (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Pangkat', 'icon' => 'file', 'url' => array('create'))) :  '';
        (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Update') . ' Pangkat', 'icon' => 'pencil', 'url' => array('update', 'id' => $model->pangkat_id))) :  '';
        array_push($arrMenu, array('label' => Yii::t('mds', 'Delete') . ' Pangkat', 'icon' => 'trash', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->pangkat_id), 'confirm' => Yii::t('mds', 'Are you sure you want to delete this item?'))));
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Pangkat', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

        //$this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'pangkat_id',
                'golonganpegawai_id',
                'pangkat_nama',
                'pangkat_namalainnya',
                array(               // related city displayed as a link
                    'name' => 'pangkat_aktif',
                    'type' => 'raw',
                    'value' => (($model->pangkat_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
            ),
        )); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Pangkat', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
        ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>