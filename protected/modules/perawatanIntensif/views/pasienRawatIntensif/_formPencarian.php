<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'daftarPasien-form',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'no_pendaftaran'),
    'htmlOptions' => array(),
)); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <label for="namaPasien" class="control-label">
                        <?php echo CHtml::activecheckBox($model, 'ceklisAdmisi', array('uncheckValue' => 0, 'rel' => 'tooltip', 'onClick' => 'cekTanggal()', 'data-original-title' => 'Cek untuk pencarian berdasarkan tanggal admisi')); ?>
                        <label for="PIInfopasienmasukkamarV_ceklisAdmisi">Tgl. Masuk/Admisi</label>
                    </label>
                    <div class="controls">
                    <?php $format = new MyFormatter; ?>
                        <?php 
                        $model2 = clone $model;
                        $model2->tgl_awal = $format->formatDateTimeForUser($model2->tgl_awal); ?>
                        <?php 
                        // $model2 = clone $model;
                        // $model2->tgl_awal = $format->formatDateTimeForUser($model2->tgl_awal); ?>
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model2,
                            'attribute' => 'tgl_awal',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span2 dtPicker3'),
                        )); ?> </div>
                </div>
                <div class="control-group">
                    <label for="namaPasien" class="control-label">
                        Sampai dengan
                    </label>
                    <div class="controls">
                        <?php $model2->tgl_akhir = $format->formatDateTimeForUser($model2->tgl_akhir); ?>
                        <?php $this->widget('MyDateTimePicker', array(
                            'model' => $model2,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span2 dtPicker3'),
                        )); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                <div class="control-group">
                    <label for="namaPasien" class="control-label">
                        Alias
                    </label>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nama_bin', array('placeholder' => 'Alias / Nama Panggilan', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                <div class="control-group">
                    <?php echo Chtml::label("NIK", 'no_identitas_pasien', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'no_identitas_pasien', array('class' => 'span4 custom-only', 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'NIK')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php $model->tgl_awall = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awall, 'yyyy-MM-dd'), 'medium', null); ?>
                    <?php // echo CHtml::label(CHtml::activeCheckBox($model, 'ceklis') . " Tanggal Lahir", 'tanggal_lahir', array('class' => 'control-label')) 
                    ?>
                    <label for="ceklis" class="control-label">
                        <?php echo CHtml::activecheckBox($model, 'ceklis', array('uncheckValue' => 0, 'rel' => 'tooltip', 'data-original-title' => 'Cek untuk pencarian berdasarkan tanggal lahir')); ?>
                        <label for="PIInfopasienmasukkamarV_ceklis">Tanggal Lahir</label>
                    </label>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_awall',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php $model->tgl_akhirl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhirl, 'yyyy-MM-dd'), 'medium', null); ?>
                    <?php echo CHtml::label('Sampai Dengan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_akhirl',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <?php echo $form->dropDownListRow($model, 'caramasuk_id', CHtml::listData($model->getCaraMasukItems(), 'caramasuk_id', 'caramasuk_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->dropDownListRow($model, 'shift_id', CHtml::listData(ShiftM::model()->findAllByAttributes(array('shift_aktif' => true), array('order' => 'shift_nama')), 'shift_id', 'shift_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                    'class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien', array('encode' => false, 'namaModel' => 'RDPendaftaran')),
                        'update' => '#' . CHtml::activeId($model, 'penjamin_id') . ''  //selector to update
                    ),
                )); ?>
                <?php echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                <div class="control-group">
                    <label for="namaPasien" class="control-label">
                        Dokter PJP
                    </label>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'nama_pegawai', CHtml::listData(DokterV::model()->findAll(), 'nama_pegawai', 'nama_pegawai'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="namaPasien" class="control-label">
                    </label>
                    <div class="controls">
                        <?php echo CHtml::activecheckBox($model, 'is_nursestation', array('uncheckValue' => 0, 'rel' => 'tooltip', 'data-original-title' => 'Cek untuk pencarian berdasarkan nurse station')); ?>
                        <label for="PIInfopasienmasukkamarV_is_nursestation">Tampilkan berdasarkan Nurse Station</label>
                    </div>
                </div>
            </div>
        </div>
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onclick' => 'cekNurseStation()')
        );
        echo CHtml::hiddenField('pendaftaran_id');
        echo CHtml::hiddenField('pasien_id');
        ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'window.parent.myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        ); ?>
        <?php
        $content = $this->renderPartial('../tips/informasi', array(), true);
        $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
        ?>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script>
    //document.getElementById('PIInfopasienmasukkamarV_tgl_awal_date').setAttribute("style","display:none;");
    //document.getElementById('PIInfopasienmasukkamarV_tgl_akhir_date').setAttribute("style","display:none;");
    function cekTanggal() {
        var checklist = $('#PIInfopasienmasukkamarV_ceklisAdmisi');
        var pilih = checklist.attr('checked');
        if (pilih) {
            document.getElementById('PIInfopasienmasukkamarV_tgl_awal_date').setAttribute("style", "display:block;");
            document.getElementById('PIInfopasienmasukkamarV_tgl_akhir_date').setAttribute("style", "display:block;");
        } else {
            document.getElementById('PIInfopasienmasukkamarV_tgl_awal_date').setAttribute("style", "display:none;");
            document.getElementById('PIInfopasienmasukkamarV_tgl_akhir_date').setAttribute("style", "display:none;");
        }
    }

    function cekTanggalLahir() {
        var checklistTgl = $('#PIInfopasienmasukkamarV_ceklis');
        var pilih = checklistTgl.attr('checked');
        if (pilih) {
            document.getElementById('PIInfopasienmasukkamarV_tgl_awall_date').setAttribute("style", "display:block;");
            document.getElementById('PIInfopasienmasukkamarV_tgl_akhirl_date').setAttribute("style", "display:block;");
        } else {
            document.getElementById('PIInfopasienmasukkamarV_tgl_awall_date').setAttribute("style", "display:none;");
            document.getElementById('PIInfopasienmasukkamarV_tgl_akhirl_date').setAttribute("style", "display:none;");
        }
    }
</script>