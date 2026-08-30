<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'detail-pelatihan-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)'
    ),
));
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Detail <b>Pelatihan dan Workshop</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $pegawailogin = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));

        $criteria = new CDbCriteria;
        //        $criteria->addCondition("t.kepalaunitpeg_id IS NOT NULL");
        $criteria->addCondition("t.unitkerja_aktif IS TRUE");
        $cekKepalaUnit = UnitkerjaM::model()->findAll($criteria);
        $kepalaunit = array();

        foreach ($cekKepalaUnit as $value) :
            $kepalaunit[] = $value->kepalaunitpeg_id;
        endforeach;

        $criteria2 = new CDbCriteria;
        //        $criteria2->addInCondition("t.pegawai_id", $kepalaunit);
        $criteria2->addCondition("t.pegawai_id = " . $pegawailogin->pegawai_id);
        $modPegawai = PegawaiM::model()->find($criteria2);

        if (!empty($modPegawai)) {
            $is_kepalaunit = 1;
            $unitkerja_id = $modPegawai->unitkerja_id;
            $unitkerja_nama = $modPegawai->unitkerja->namaunitkerja;
            $pegawai_id = $modPegawai->pegawai_id;
            $pegawai_nama = $modPegawai->nama_pegawai;
        } else {
            $is_kepalaunit = 0;
            $unitkerja_id = "";
            $unitkerja_nama = "";
            $pegawai_id = "";
            $pegawai_nama = "";
        }
        echo CHtml::hiddenField('is_kepalaunit', $is_kepalaunit);
        ?>
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo CHtml::label('Ka. Unit Kerja', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::hiddenField('unitkerja_id', $unitkerja_id, array('readonly' => true, 'class' => 'span3')); ?>
                    <?php echo CHtml::textField('unitkerja_nama', $unitkerja_nama, array('readonly' => true, 'class' => 'span3')); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Nama Ka. Unit', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::hiddenField('pegawai_id', $pegawai_id, array('readonly' => true, 'class' => 'span3')); ?>
                    <?php echo CHtml::textField('pegawai_nama', $pegawai_nama, array('readonly' => true, 'class' => 'span3')); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Bulan Pelatihan', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <div class="input-append">
                        <?php echo $form->textField($model, 'bulan_pelatihan', array('disabled' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                    </div>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Nama Perawat', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true, 'class' => 'span3 pegawai_id')); ?>
                    <?php echo $form->textField($model, 'nama_perawat', array('readonly' => true, 'class' => 'span3')); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('NIP Perawat', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'nip_perawat', array('readonly' => true, 'class' => 'span3')); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Nama Unit Kerja', '', array('class' => 'control-label')); ?>
                <div class="controls">

                    <?php
                    echo $form->hiddenField($model, 'perawat_unitkerja_id', array('readonly' => true));
                    $unitKerjaPerawat = UnitkerjaM::model()->findByPk($model->perawat_unitkerja_id);
                    echo $form->textField($model, 'namaunitkerja', array('readonly' => true, 'value' => $unitKerjaPerawat->namaunitkerja)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Nama Indikator', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $form->hiddenField($model, 'indikatoroppekeperawatan_id', array('readonly' => true));
                    $indikator = IndikatoroppekeperawatanM::model()->findByPk($model->indikatoroppekeperawatan_id);
                    echo $form->textField($model, 'nama_indikator', array('readonly' => true, 'value' => $indikator->nama_indikator)); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Nama Pelatihan', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'nama_pelatihan', array('readonly' => true, 'class' => 'span3')); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('No. Sertifikat', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'no_sertifikat', array('readonly' => true, 'class' => 'span3')); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Penyelenggara', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'penyelenggara', array('readonly' => true, 'class' => 'span3')); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Jumlah SKP', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'jml_skp', array('readonly' => true, 'class' => 'span3 numbers-only')); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Skor', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'skor', array('readonly' => true, 'class' => 'span3 numbers-only')); ?><label> %</label>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>