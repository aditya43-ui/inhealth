<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Golongan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Sagolongan Ms' => array('index'),
            $model->golongan_id,
        );
        $arrMenu = array();
        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'golongan_id',
                'golongan_kode',
                'golongan_nama',
                'golongan_namalainnya',
                'golongan_aktif',
            ),
        )); ?>
        <div class="form-actions">
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Golongan', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
            $this->widget('UserTips', array('type' => 'view'));
            ?>
        </div>
    </div>
</div>