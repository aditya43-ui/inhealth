<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Kelompok Faktor Risiko</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'KelompokFaktorResiko Ms' => array('index'),
            $model->kelompokfaktorrisikodaftar_id,
        );

        $this->menu = array(
            //        array('label'=>Yii::t('mds','View').' Lookup ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
        );
        $cekJenisFaktor = JenisfaktorrisikoM::model()->findByPk($model->jenisfaktorrisiko_id);
        if (!empty($cekJenisFaktor)) {
            $namaJenisFaktor = $cekJenisFaktor->jenisfaktorrisiko_nama;
        } else {
            $namaJenisFaktor = '-';
        }
        $cekFaktorResiko = FaktorrisikoDaftarM::model()->findByPk($model->faktorrisiko_daftar_id);
        if (!empty($cekFaktorResiko)) {
            $namaFaktorResiko = $cekFaktorResiko->faktorrisiko_daftar_nama;
        } else {
            $namaFaktorResiko = '-';
        }
        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php
        $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'label' => 'Jenis faktor risiko',
                    'value' => $namaJenisFaktor,
                ),
                array(
                    'label' => 'Faktor Risiko',
                    'value' => $namaFaktorResiko,
                ),
                array(
                    'label' => 'Status',
                    'value' => ($model->kelompokfaktorrisikodaftar_aktif == 1) ? "Aktif" : "Tidak Aktif",
                    'filter' => array(1 => 'Aktif', 0 => 'Tidak Aktif'),
                    'htmlOptions' => array('style' => 'text-align:left;'),
                ),

            ),
        ));
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->kelompokfaktorrisikodaftar_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelompok Faktor Risiko', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>