<div class='col-sm-6'>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'tgllowongan', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $model->tgllowongan = (!empty($model->tgllowongan) ? date("d/m/Y", strtotime($model->tgllowongan)) : null);
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tgllowongan',
                'mode' => 'date',
                'options' => array(
                    //                                            'dateFormat'=>Params::DATE_FORMAT,
                    'showOn' => false,
                    'maxDate' => 'd',
                    'yearRange' => "-150:+0",
                ),
                'htmlOptions' => array(
                    'placeholder' => '00/00/0000', 'class' => 'span2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
            <?php echo $form->error($model, 'tgllowongan'); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tanggal Lamaran Masuk <span class="required">*</span>', 'tglmelamar', array('class' => 'control-label required')); ?>
        <div class="controls">
            <?php
            $model->tglmelamar = (!empty($model->tglmelamar) ? date("d/m/Y", strtotime($model->tglmelamar)) : null);
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tglmelamar',
                'mode' => 'date',
                'options' => array(                              
                    'dateFormat'=>Params::DATE_FORMAT,
                    'showOn' => false,
                    'maxDate' => 'd',
                    'yearRange' => "-150:+0",
                ),
                'htmlOptions' => array(
                    'placeholder' => '00/00/0000', 'class' => 'span2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
    <?php echo CHtml::label('Sumber Informasi Lowongan', 'asalpelamar', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'asalpelamar',  CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type'=>'sumberinformasilowongan')), 'lookup_name', 'lookup_name'), array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'empty' => ' -- Pilih -- ')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('No. Identitas <span class="required">*</span>', 'noidentitas', array('class' => 'control-label required')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'jenisidentitas',  CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type'=>'noidentitaspelamar')), 'lookup_name', 'lookup_name'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            <?php echo $form->textField($model, 'noidentitas', array('placeholder' => 'No. Identitas', 'class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 16)); ?></div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'nama_pelamar', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($model, 'nama_pelamar', array('placeholder' => 'Nama Pelamar', 'class' => 'span3 isRequired', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 100)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'nama_keluarga', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($model, 'nama_keluarga', array('placeholder' => 'Nama Keluarga', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'jeniskelamin', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'jeniskelamin',  CHtml::listData($model->JenisKelamin, 'lookup_name', 'lookup_name'), array('class' => 'span2 isRequired', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 20, 'empty' => '-- Jenis Kelamin --')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'agama', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'agama',  CHtml::listData($model->Agama, 'lookup_name', 'lookup_name'), array('class' => 'span2 isRequired', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 20, 'empty' => '-- Pilih Agama --')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'tempatlahir_pelamar', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($model, 'tempatlahir_pelamar', array('placeholder' => 'Tempat Lahir', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 30)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'tgl_lahirpelamar', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $model->tgl_lahirpelamar = (!empty($model->tgl_lahirpelamar) ? date("d/m/Y", strtotime($model->tgl_lahirpelamar)) : null);
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tgl_lahirpelamar',
                'mode' => 'date',
                'options' => array(
                    //                                            'dateFormat'=>Params::DATE_FORMAT,
                    'showOn' => false,
                    'maxDate' => 'd',
                    'yearRange' => "-150:+0",
                ),
                'htmlOptions' => array(
                    'placeholder' => '00/00/0000', 'class' => 'span2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'statusperkawinan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'statusperkawinan',  CHtml::listData($model->StatusPerkawinan, 'lookup_name', 'lookup_name'), array('class' => 'span2 isRequired', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 20, 'empty' => ' -- Status -- ')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'jmlanak', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($model, 'jmlanak', array('placeholder' => '00', 'class' => 'span1 integer', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'alamat_pelamar', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'alamat_pelamar', array('placeholder' => 'Alamat Pelamar', 'rows' => 3, 'cols' => 30, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'kodepos', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($model, 'kodepos', array('placeholder' => 'Kode Pos', 'class' => 'span2 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('No. Telepon <span class="required">*</span>', 'notelp_pelamar', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($model, 'notelp_pelamar', array('placeholder' => 'No. Tlp Rumah', 'class' => 'span2 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
            <?php echo $form->textField($model, 'nomobile_pelamar', array('placeholder' => 'No. Handphone', 'class' => 'span2 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Email <span class="required">*</span>', 'alamatemail', array('class' => 'control-label required')) ?>
        <div class="controls">
            <?php echo $form->textField($model, 'alamatemail', array('class' => 'span3', 'placeholder' => 'contoh: info@.com', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Pendidikan <span class="required">*</span>', 'pendidikan_id', array('class' => 'control-label required')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'pendidikan_id',  CHtml::listData($model->PendidikanItems, 'pendidikan_id', 'pendidikan_nama'), array('class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event)", 'empty' => ' -- Pendidikan -- ')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'pendkualifikasi_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'pendkualifikasi_id',  CHtml::listData($model->PendkualifikasiItems, 'pendkualifikasi_id', 'pendkualifikasi_nama'), array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'empty' => ' -- Kualifikasi Pendidikan -- ')); ?>
        </div>
    </div>
</div>
<div class='col-sm-6'>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'minatpekerjaan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'minatpekerjaan',  CHtml::listData($model->MinatPekerjaan, 'lookup_name', 'lookup_name'), array('class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 100, 'empty' => ' -- Pilih Minat -- ')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'warganegara_pelamar', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'warganegara_pelamar', CHtml::listData($model->WargaNegara, 'lookup_name', 'lookup_name'), array('class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 25)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'suku_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'suku_id',  CHtml::listData($model->Suku, 'suku_id', 'suku_nama'), array('class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih Suku -- ')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'profilrs_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'profilrs_id',  CHtml::listData($model->ProfilRS, 'profilrs_id', 'nama_rumahsakit'), array('class' => 'span3 isRequired', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'gajiygdiharapkan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($model, 'gajiygdiharapkan', array('placeholder' => '00', 'class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'ingintunjangan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'ingintunjangan', array('placeholder' => 'Tunjangan yang diinginkan', 'rows' => 3, 'cols' => 30, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'keterangan_pelamar', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'keterangan_pelamar', array('placeholder' => 'Keterangan Pelamar', 'rows' => 3, 'cols' => 30, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'tglmulaibekerja', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $model->tglmulaibekerja = (!empty($model->tglmulaibekerja) ? date("d/m/Y", strtotime($model->tglmulaibekerja)) : null);
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tglmulaibekerja',
                'mode' => 'date',
                'options' => array(
                    //                                            'dateFormat'=>Params::DATE_FORMAT,
                    'showOn' => false,
                    'maxDate' => '+3Y',
                    'yearRange' => "-150:0",
                ),
                'htmlOptions' => array(
                    'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
            <?php echo $form->error($model, 'tglmulaibekerja'); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'berlaku_s_d', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $model->berlaku_s_d = (!empty($model->berlaku_s_d) ? date("d/m/Y H:i:s", strtotime($model->berlaku_s_d)) : null);
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'berlaku_s_d',
                'mode' => 'datetime',
                'options' => array(
                    //                                            'dateFormat'=>Params::DATE_FORMAT,
                    'showOn' => false,
                    'maxDate' => '+3Y',
                    'yearRange' => "-150:0",
                ),
                'htmlOptions' => array(
                    'placeholder' => '00/00/0000 00:00:00', 'class' => 'dtPicker2 datetimemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
            <?php echo $form->error($model, 'tgllowongan'); ?>
        </div>
    </div>
    <div id="divCaraAmbilPhotoFile" style="display: block;">
        <div class="fileupload fileupload-new" data-provides="fileupload">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'photopelamar', array('class' => 'control-label', 'onkeyup' => "return $(this).focusNextInputField(event)")) ?>
                <div class="controls">
                    <?php echo Chtml::activeFileField($model, 'photopelamar', array('maxlength' => 254, 'Hint' => 'Isi Jika Akan Menambahkan Logo', 'class' => 'fileupload-new')); ?>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <?php
                    $url_photopegawai = (!empty($model->photopelamar) ? Params::urlPelamarThumbsDirectory() . "kecil_" . $model->photopelamar : Params::urlPelamarThumbsDirectory() . "no_photo.jpeg");
                    ?>
                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"><img src="<?php echo $url_photopegawai; ?>" /></div>
                </div>
            </div>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'filelamaran', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo Chtml::activeFileField($model, 'filelamaran', array('maxlength' => 254, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>

    <!-- new  -->
    <div class='control-group'>
        <?php echo $form->labelEx($model, 'masa_str', array('class' => ' control-label')) ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'masa_str',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    //'maxDate' => 'd',
                ),
                'clearable' => true,
                'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onclick' => "return $(this).focusNextInputField(event)"),
            ));
            ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($model, 'surattandaregistrasi', array('onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 100)); ?>
    
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Surat Izin Praktek
            </div>
        </div>
        <div class="panel-body">
            <div class="block-tabel" style="overflow: auto;">
                <table class="items table table-bordered table-striped table-condensed" id="tblInputLingkunganKerja">
                    <thead>
                        <th>No.</th>
                        <th>No. SIP</th>
                        <th>Instansi</th>
                        <th>Masa Berlaku SIP</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <?php echo $form->textField($model, 'suratizinpraktek', array('onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 100,'class'=>'span2')); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($model, 'instansi_sip', array('onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 100,'class'=>'span2')); ?>
                            </td>
                            <td class="td_date">
                                <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $model,
                                        'attribute' => 'masa_sip',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            //'maxDate' => 'd',
                                        ),
                                        'clearable' => true,
                                        'htmlOptions' => array('readonly' => true, 'class' => 'span2', 'onclick' => "return $(this).focusNextInputField(event)"),
                                    ));
                                    ?>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>
                                <?php echo $form->textField($model, 'suratizinpraktek_2', array('onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 100,'class'=>'span2')); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($model, 'instansi_sip_2', array('onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 100,'class'=>'span2')); ?>
                            </td>
                            <td class="td_date">
                                <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $model,
                                        'attribute' => 'masa_sip_2',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            //'maxDate' => 'd',
                                        ),
                                        'clearable' => true,
                                        'htmlOptions' => array('readonly' => true, 'class' => 'span2', 'onclick' => "return $(this).focusNextInputField(event)"),
                                    ));
                                    ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    

</div>