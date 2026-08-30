<style>
.judul-ab {
    font-weight: bold;
}

.inp-ab {
    margin-left: 20px;
}

.space-ab1 {
    margin-left: 20px;
    margin-right: 20px;
}

.space-ab2 {
    margin-left: 20px;
    margin-right: 20px;
}
</style>

<?php echo $form->errorSummary($pcr); ?>


<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-book"></i> &nbsp;<b>Pemeriksaan PCR</b>
            <?php // echo $form->hiddenField($pcr, 'pemeriksaanpcr_id', array('class' => '', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
        </div>
    </div>
    <div class="panel-body" id="">
        <div class="row-fluid">
            <div class="col-sm-6">
                <div class="control-group">
                <label class="control-label">Dokter Lab 1 <span class="required">*</span></label>
                    <div class="controls">
                        <?php
                            echo $form->dropDownList($pcr, 'pegawai_id', CHtml::listData(PegawairuanganV::model()->findAll(' ruangan_id = 1131 and kelompokpegawai_id = 1 '), 'pegawai_id', 'namaLengkap'), array(
                                'empty' => '-- Pilih --', 'class' => 'span4 required',
                            ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Dokter Lab 2</label>
                    <div class="controls">
                        <?php
                            echo $form->dropDownList($pcr, 'dpjp_id', CHtml::listData(PegawairuanganV::model()->findAll(' ruangan_id = 1131 and kelompokpegawai_id = 1 '), 'pegawai_id', 'namaLengkap'), array(
                                'empty' => '-- Pilih --', 'class' => 'span4',
                            ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Analis</label>
                    <div class="controls">
                        <?php
                            echo $form->dropDownList($pcr, 'perawat_id', CHtml::listData(PegawairuanganV::model()->findAll(' ruangan_id = 1131 and kelompokpegawai_id in (2, 20) '), 'pegawai_id', 'namaLengkap'), array(
                                'empty' => '-- Pilih --', 'class' => 'span4',
                            ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Tanggal Pemeriksaan <span class="required">*</span></label>
                    <div class="controls">
                        <?php
                    
                            $this->widget('MyDateTimePicker', array(
                                'model' => $pcr,
                                'attribute' => 'tgl_pemeriksaan',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('class' => 'dtPicker3 span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));

                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Sampel PCR </label>
                    <div class="controls">
                        <?php echo $form->textField($pcr, 'jenis_pemeriksaan', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="col-sm-12">
                <div class="control-group">
                    <label class="control-label">Hasil Pemeriksaan </label>
                    <div class="controls">
                        <?php echo $form->radioButtonList($pcr, 'is_negative', array('1' => 'NEGATIVE', '0'=>'POSITIVE'), array('uncheckValue'=>null)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>