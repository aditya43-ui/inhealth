<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Sub Kelompok</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Sasubkelompok Ms' => array('index'),
            $model->subkelompok_id,
        );

        $arrMenu = array();

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'subkelompok_id',
                'kelompok_id',
                'subkelompok_kode',
                'subkelompok_nama',
                'subkelompok_namalainnya',
                'subkelompok_aktif',
            ),
        )); ?>

        <div class="form-actions">
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Sub Kelompok', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
            $this->widget('UserTips', array('type' => 'view'));
            ?>
        </div>
    </div>
</div>