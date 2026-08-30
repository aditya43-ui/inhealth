<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Kelompok Tanda dan Gejala</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Lookup Ms' => array('index'),
            $model->kelompoktandagejaladaftar_id,
        );

        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php
        $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'label' => 'Jenis Tanda dan Gejala',
                    'value' => !empty($model->jenistandagejala_id) ? $model->jenistandagejala->jenistandagejala_nama . ' - ' . $model->jenistandagejala->subjenistandagejala_nama : '',
                ),
                array(
                    'label' => 'Tanda dan Gejala',
                    'value' => $model->tandagejalaDaftar->tandagejala_daftar_nama,
                ),
                array(
                    'label' => 'Status',
                    'type' => 'raw',
                    'value' => ($model->jenistandagejaladaftar_aktif == 1) ? "Aktif" : "Tidak Aktif",
                ),
            ),
        ));
        ?>
        <?php //echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->tandagejala_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')).'&nbsp;'; 
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelompok Tanda dan Gejala', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/index', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success'));
        $this->widget('UserTips', array('type' => 'view'));
        ?>
    </div>
</div>