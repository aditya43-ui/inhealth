<style>
    .row+.row {
        margin-top: 17px;
    }

    .isian-misi {
        width: calc(100% - 110px);
    }

    img.preview {
        display: block;
        max-width: 100%;
        max-height: 180px;
        margin-bottom: 5px;
        padding: 5px;
        background-color: #fafafa;
        border: solid 1px #ddd;
        border-radius: 5px;
    }

    .no-image {
        display: block;
        width: 215px;
        max-width: 100%;
        height: 180px;
        margin-bottom: 5px;
        padding: 110px 15px 0;
        background: url('<?php echo Yii::app()->request->baseUrl; ?>/images/icon_modul/thumb.png') no-repeat #000;
        background-position: center 45px;
        background-size: 110px;
        font-size: 12px;
        color: #fff;
        text-align: center;
        border: solid 1px #ddd;
        border-radius: 5px;
        user-select: none;
    }

    a.help {
        cursor: pointer;
        color: #737881;
    }

    a.help:hover a.help:focus {
        color: #737881;
    }
</style>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Profil Rumah Sakit
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'saprofil-rumah-sakit-m-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#SAProfilRumahSakitM_tahunprofilrs',
            'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
        )); ?>

        <?php echo $form->errorSummary($model); ?>
        <?php 
        $nama_kapital = ((Yii::app()->user->getState('nama_huruf_capital') == true) ? "all-caps" : "");
        $alamat_kapital = ((Yii::app()->user->getState('alamat_huruf_capital') == true) ? "all-caps" : "");
        ?>

        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fas fa-clinic-medical"></i> Identitas Rumah Sakit
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="control-group">
                            <?php echo CHtml::label('Tahun Profil', 'Tahun Profil', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'tahunprofilrs', array('placeholder' => 'Tahun Profil', 'class' => 'span3 numbers-only',  'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 4)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Tahun', 'Tahun', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'tahun_diresmikan', array('placeholder' => 'Tahun', 'class' => 'span3 numbers-only',  'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 4)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Kode Rumah Sakit <span class="required">*</span>', 'Kode Rumah Sakit', array('class' => 'control-label required')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'nokode_rumahsakit', array('placeholder' => 'Kode Rumah Sakit', 'class' => 'span3',  'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 10)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Tgl. Registrasi', 'Tanggal Registrasi', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tglregistrasi',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width: 155px;'
                                    ),
                                )); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'npwp', array('placeholder' => 'NPWP', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 25)); ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Nama Rumah Sakit <span class="required">*</span>', 'Kode Rumah Sakit', array('class' => 'control-label required')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'nama_rumahsakit', array('placeholder' => 'Nama Rumah Sakit', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 100)); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'namapendek_rumahsakit', array('placeholder' => 'Nama Pendek Rumah Sakit', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 100)); ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Kode / Jenis Rumah Sakit <span class="required">*</span>', 'Kode / Jenis Rumah Sakit', array('class' => 'control-label required')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'kodejenisrs_profilrs', array('style' => 'float: left; width: 30px;', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 10, 'readonly' => true)); ?>
                            </div>
                            <?php echo $form->dropDownList(
                                $model,
                                'jenisrs_profilrs',
                                LookupM::getItems('jenisrs_profilrs'),
                                array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'float: left; width: 152px;', 'onchange' => 'setKodeJenisRs(this.value);')
                            ); ?>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Kode / Nama Penyelenggara', 'Kode / Nama Penyelenggara', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'kodestatuskepemilikanrs', array('style' => 'float: left; width:30px', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 10, 'readonly' => true)); ?>
                            </div>
                            <?php echo $form->dropDownList(
                                $model,
                                'namakepemilikanrs',
                                LookupM::getItems('namakepemilikanrs'),
                                array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'float: left; width: 152px;', 'onchange' => 'setKodePemilikRs(this.value); setDropdownKelasRS(this.value);')
                            ); ?>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Kelas Rumah Sakit', 'Kelas Rumah Sakit', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList(
                                    $model,
                                    'kelas_rumahsakit',
                                    SALookupM::getItemsKelasRS($model->namakepemilikanrs),
                                    array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')
                                ); ?>
                                <?php // echo $form->dropDownList($model,'kelas_rumahsakit', CHtml::listData(SALookupM::getItemsKelasRS($model->namakepemilikanrs), 'lookup_name', 'lookup_name') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3'));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Nama Dirtektur Rumah Sakit', 'Nama Dirtektur Rumah Sakit', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $model,
                                    'attribute' => 'namadirektur_rumahsakit',
                                    'source' => 'js: function(request, response) {
														   $.ajax({
															   url: "' . $this->createUrl('AutocompleteNamaDirektur') . '",
															   dataType: "json",
															   data: {
																   nama_pegawai: request.term,
																   tanggal_lahir: $("#' . CHtml::activeId($model, 'tanggal_lahir') . '").val(),
															   },
															   success: function (data) {
																	   response(data);
															   }
														   })
														}',
                                    'options' => array(
                                        'minLength' => 2,
                                        'focus' => 'js:function( event, ui ) {
														 $(this).val( "");
														 return false;
													 }',
                                        'select' => 'js:function( event, ui ) {
														$("#' . CHtml::activeId($model, 'namadirektur_rumahsakit') . '").val(ui.item.nama_pegawai);
														return false;
													}',
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                                    'htmlOptions' => array('placeholder' => 'Nama Dirtektur Rumah Sakit', 'rel' => 'tooltip', 'title' => 'Ketik Nama untuk masukan data / mencari pasien', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 '),
                                ));
                                ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'npwp_pt', array('placeholder' => 'NPWP PT', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 25)); ?>
                        <?php echo $form->textFieldRow($model, 'nama_pt', array('placeholder' => 'Nama PT', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 100)); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-location"></i> Alamat / Lokasi Rumah Sakit
                        </div>
                    </div>
                    <div class="panel-body" style="min-height: 534px;">
                        <div class="control-group">
                            <?php echo CHtml::label('Alamat dan Kode Pos', 'Kode Rumah Sakit', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'alamatlokasi_rumahsakit', array('placeholder' => 'Alamat dan Kode Pos', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Negara', 'Negara', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'negara', array('placeholder' => 'Negara', 'class' => 'span3 ' . $nama_kapital, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'propinsi_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->dropDownList(
                                    $model,
                                    'propinsi_id',
                                    CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'),
                                    array(
                                        'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3',
                                        'ajax' => array(
                                            'type' => 'POST',
                                            'url' => $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => get_class($model))),
                                            'update' => "#" . CHtml::activeId($model, 'kabupaten_id'),
                                        ),
                                        'onchange' => "setClearDropdownKelurahan();setClearDropdownKecamatan();",
                                    )
                                ); ?>
                                <?php echo $form->error($model, 'propinsi_id'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'kabupaten_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo $form->dropDownList($model, 'kabupaten_id', CHtml::listData($model->getKabupatenItems($model->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), array(
                                    'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3',
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => $this->createUrl('SetDropdownKecamatan', array('encode' => false, 'model_nama' => get_class($model))),
                                        'update' => '#' . CHtml::activeId($model, 'kecamatan_id')
                                    ),
                                    'onchange' => "setClearDropdownKelurahan();"
                                ));
                                ?>
                                <?php echo $form->error($model, 'kabupaten_id'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'Kecamatan <span class=required>*</span> ', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo $form->dropDownList($model, 'kecamatan_id', CHtml::listData($model->getKecamatanItems($model->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'), array(
                                    'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3',
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => $this->createUrl('SetDropdownKelurahan', array('encode' => false, 'model_nama' => get_class($model))),
                                        'update' => "#" . CHtml::activeId($model, 'kelurahan_id')
                                    )
                                ));
                                ?>
                                <?php echo $form->error($model, 'kecamatan_id'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'Kelurahan <span class=required>*</span> ', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo $form->dropDownList($model, 'kelurahan_id', CHtml::listData($model->getKelurahanItems($model->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'), array(
                                    'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3',
                                    'empty' => '-- Pilih --',
                                ));
                                ?>
                                <?php echo $form->error($model, 'kelurahan_id'); ?></td>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'kodepos', array('placeholder' => 'Kode Pos', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 15)); ?>
                        <?php echo $form->textFieldRow($model, 'no_telp_profilrs', array('placeholder' => 'No. Telepon', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 15)); ?>
                        <?php echo $form->textFieldRow($model, 'no_faksimili', array('placeholder' => 'No. Faksimili', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 15)); ?>
                        <?php echo $form->textFieldRow($model, 'email', array('placeholder' => 'Email', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                        <?php echo $form->textFieldRow($model, 'website', array('placeholder' => 'Website', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                        <div class="control-group">
                            <?php echo CHtml::label('No. Telpon Humas', 'No. Telpon Humas', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'notelphumas', array('placeholder' => 'No. Telpon Humas', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 15)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-picture"></i> Logo Rumah Sakit
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'logo_rumahsakit', array('class' => 'control-label', 'onkeypress' => "return nextFocus(this,event,'SAProfilRumahSakitM_tgl_suratizin','SAProfilRumahSakitM_visi')")) ?>
                            <?php if (!empty($model->logo_rumahsakit)) { ?>
                                <img src="<?php echo Params::urlProfilRSDirectory() . $model->logo_rumahsakit ?> " style="width: 20%;padding:10px;display: block;">
                            <?php } else {
                                echo "<span style='padding:10px 25px;'> Logo Rumah Sakit belum di-set</span>";
                            } ?>
                            <div class="controls">
                                <?php echo Chtml::activeFileField($model, 'logo_rumahsakit', array('maxlength' => 254, 'hint' => 'Isi Jika Akan Menambahkan Logo')); ?>
                            </div>

                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'logo_rumahsakit_2', array('class' => 'control-label', 'onkeypress' => "return nextFocus(this,event,'SAProfilRumahSakitM_tgl_suratizin','SAProfilRumahSakitM_visi')")) ?>
                            <?php if (!empty($model->logo_rumahsakit_2)) { ?>
                                <img src="<?php echo Params::urlProfilRSDirectory() . $model->logo_rumahsakit_2 ?> " style="width: 20%;padding:10px;display: block;">
                            <?php } else {
                                echo "<span style='padding:10px 25px;'> Logo Rumah Sakit 2 belum di-set</span>";
                            } ?>
                            <div class="controls">
                                <?php echo Chtml::activeFileField($model, 'logo_rumahsakit_2', array('maxlength' => 254, 'hint' => 'Isi Jika Akan Menambahkan Logo 2')); ?>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Luas Rumah Sakit
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $form->textFieldRow($model, 'luastanah', array('placeholder' => 'Tanah', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php echo $form->textFieldRow($model, 'luasbangunan', array('placeholder' => 'Bangunan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> PPK Pelayanan
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $form->textFieldRow($model, 'ppkpelayanan', array('placeholder' => 'No. PPK', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Tarif INACBG
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $form->textFieldRow($model, 'kode_tarifinacbgs_1', array('placeholder' => 'Kode Tarif INACBG', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength'=>10)); ?>
                        <?php echo $form->textFieldRow($model, 'nama_tarifinacbgs_1', array('placeholder' => 'Nama Tarif INACBG 1', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength'=>100)); ?>
                        <?php echo $form->textFieldRow($model, 'nama_tarifinacbg_2', array('placeholder' => 'Nama Tarif INACBG 2', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength'=>100)); ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Surat Izin / Penetapan
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $form->textFieldRow($model, 'nomor_suratizin', array('placeholder' => 'Nomor', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 20)); ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tgl_suratizin', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_suratizin',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width: 155px;'
                                    ),
                                )); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'oleh_suratizin', array('placeholder' => 'Oleh', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 30)); ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Sifat Surat Izin', 'Sifat Surat Izin', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'sifat_suratizin', array('placeholder' => 'Sifat Surat Izin', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'masaberlakutahun_suratizin', array('placeholder' => 'Masa Berlaku s/d Tahun', 'class' => 'span3 numbers-only',  'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Kode / Status Penyelenggara Swasta', 'Kode / Status Penyelenggara Swasta', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'khususuntukswasta', array('style' => 'float:left; width:30px', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 10, 'readonly' => true)); ?>
                            </div>
                            <?php echo $form->dropDownList(
                                $model,
                                'statusrsswasta',
                                LookupM::getItems('statusrsswasta'),
                                array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width: 152px;', 'onchange' => 'setKodeStatusSwasta(this.value);')
                            ); ?>
                        </div>
                    </div>
                </div>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-monitor"></i> Layar Antrian
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'noimagelayarantrian', array('class' => 'control-label', 'onkeypress' => "return nextFocus(this,event,'','')")) ?>
                            <?php if (!empty($model->noimagelayarantrian)) { ?>
                                <img src="<?php echo Params::urlProfilRSDirectory() . $model->noimagelayarantrian ?> " style="width: 20%;padding:10px;display: block; background-color: #eee;">
                            <?php } else {
                                echo "<span style='padding:10px 25px;'> No. Display Antrian belum di-set</span>";
                            } ?>
                            <div class="controls">
                                <?php echo Chtml::activeFileField($model, 'noimagelayarantrian', array('maxlength' => 500, 'hint' => 'Isi Jika Akan Menambahkan Gambar')); ?>
                            </div>
                        </div><br/>
                        <hr/><br/>
                        <?php /*
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'videoprofil', array('class' => 'control-label', 'onkeypress' => "return nextFocus(this,event,'SAProfilRumahSakitM_tgl_suratizin','SAProfilRumahSakitM_visi')")) ?>
                            <?php if (!empty($model->videoprofil)) { ?>
                                <video src="<?php echo Params::urlVideoAntrian() . $model->videoprofil ?> " style="width: 20%;padding:10px;display: block;"></video>
                            <?php } else {
                                echo "<span style='padding:10px 25px;'> Video belum di-set</span>";
                            } ?>
                            <div class="controls">
                                <?php echo Chtml::activeFileField($model, 'videoprofil', array('hint' => 'Isi Jika Akan Menambahkan Video')); ?>
                            </div>

                        </div>
                         *
                         */ ?>
                        <?php echo $this->renderPartial('_videoAntrian', array(), true); ?>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Akreditasi Rumah Sakit
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="control-group">
                            <?php echo CHtml::label('Pentahapan Akreditasi', 'Pentahapan Akreditasi', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::dropDownList('SAProfilRumahSakitM[pentahapanakreditasrs]', $model->pentahapanakreditasrs, LookupM::getItems('pentahapanakreditasrs'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Status Akreditasi', 'Status Akreditasi', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::dropDownList('SAProfilRumahSakitM[statusakreditasrs]', $model->statusakreditasrs, LookupM::getItems('statusakreditasrs'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tglakreditasi', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tglakreditasi',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width: 155px;'
                                    ),
                                )); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Motto
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $form->textAreaRow($model, 'motto', array('placeholder' => 'Motto', 'rows' => 6, 'cols' => 50, 'class' => 'span6 autogrow', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fas fa-clinic-medical"></i> Visi Rumah Sakit
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $form->textAreaRow($model, 'visi', array('placeholder' => 'Visi', 'rows' => 4, 'cols' => 50, 'class' => 'span6 autogrow',  'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-picture"></i> Gambar Rumah Sakit
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <!--fitur pengelolaan gambar2 rumah sakit akan dilakukan riset lebih lanjut. hal ini mengenai widget gallery yang digunakan. kegiatan riset dilakukan di-->
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fas fa-clinic-medical"></i> Misi Rumah Sakit
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table id="tbl-misi" class="table-striped datatable" style="width: 100%;">
                            <tbody>
                                <?php if (count((array)$modMisiRS) > 0) //Jika Misi Sudah Diisi
                                {
                                    $i = 1;
                                    foreach ($modMisiRS as $data) : ?>
                                        <tr>
                                            <td style="padding: 10px;">
                                                <?php // echo CHtml::textField('SAMisirsM['.$i.'][misi]',$data['misi'],array('class'=>'col-sm-6',  'onkeypress'=>"return $(this).focusNextInputField(event)"));
                                                ?>
                                                <?php echo CHtml::textArea('SAMisirsM[' . $i . '][misi]', empty($data['misi']) ? "" : $data['misi'], array('placeholder' => 'Misi', 'rows' => 2, 'class' => 'isian-misi',  'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                                <?php echo CHtml::link('<i class="icon-plus icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => 'addRow(this);$(this).nextFocus()', 'id' => 'row1-plus')); ?>
                                                <?php if ($i != 1) echo CHtml::link('<i class="entypo-minus"></i>', '#', array('class' => 'btn btn-default', 'onclick' => 'delRow(this); return false;')); ?>
                                            </td>
                                        </tr>
                                    <?php
                                        $i++;
                                    endforeach;
                                } else //Jika Misi Belum Diisi
                                {
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="control-group">
                                                <?php echo CHtml::label('Misi', 'Misi', array('class' => 'control-label')); ?>
                                                <div class="controls">
                                                    <?php // echo CHtml::textField('SAMisirsM[1][misi]','',array('class'=>'span3',  'onkeypress'=>"return $(this).focusNextInputField(event)"));
                                                    ?>
                                                    <?php echo CHtml::textArea('SAMisirsM[1][misi]', '', array('rows' => 2, 'class' => 'span7',  'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                                    <?php echo CHtml::link('<i class="icon-plus icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onkeypress' => "addRow(this);return $(this).focusNextInputField(event);", 'onclick' => 'addRow(this);$(this).nextFocus()', 'id' => 'row1-plus')); ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-picture"></i> Ganti Gambar Tema
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label>
                                    Bagian Navbar
                                    <?php echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-help-circled"></i>')), '', array('class' => 'help', 'title' => 'Navbar merupakan area navigasi utama di bagian paling atas halaman', 'rel' => 'tooltip',)); ?>
                                </label>
                                <?php
                                if ($model->logo_navbar) {
                                    echo '<img src="' . Params::urlProfilRSDirectory() . $model->logo_navbar . '" style="height: 100px; max-width: 80%; padding: 10px; display: block;">';
                                    echo Chtml::activeFileField($model, 'logo_navbar', array('maxlength' => 254,));
                                    echo CHtml::link(Yii::t('mds', '{icon} Hapus', array('{icon}' => '<i class="entypo-trash"></i>')), $this->createUrl('update'), array('class' => 'btn btn-primary', 'onclick' => 'return refreshForm(this);'));
                                } else {
                                    echo '<span class="no-image">Belum ada gambar</span>';
                                    echo Chtml::activeFileField($model, 'logo_navbar', array('maxlength' => 254,));
                                }
                                ?>
                            </div>
                            <div class="col-sm-4">
                                <label>
                                    Bagian Sidebar
                                    <?php echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-help-circled"></i>')), '', array('class' => 'help', 'title' => 'Sidebar merupakan area navigasi yang terletak di samping halaman', 'rel' => 'tooltip',)); ?>
                                </label>
                                <?php
                                if ($model->logo_sidebar) {
                                    echo '<img src="' . Params::urlProfilRSDirectory() . $model->logo_sidebar . '" style="height: 100px; max-width: 80%; padding: 10px; display: block;">';
                                    echo Chtml::activeFileField($model, 'logo_sidebar', array('maxlength' => 254,));
                                    echo CHtml::link(Yii::t('mds', '{icon} Hapus', array('{icon}' => '<i class="entypo-trash"></i>')), $this->createUrl('update'), array('class' => 'btn btn-primary', 'onclick' => 'return refreshForm(this);'));
                                } else {
                                    echo '<span class="no-image">Belum ada gambar</span>';
                                    echo Chtml::activeFileField($model, 'logo_sidebar', array('maxlength' => 254,));
                                }
                                ?>
                            </div>
                            <div class="col-sm-4">
                                <label>
                                    Bagian Footer Kiri
                                    <?php echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-help-circled"></i>')), '', array('class' => 'help', 'title' => 'Footer merupakan area di bagian paling bawah halaman', 'rel' => 'tooltip',)); ?>
                                </label>
                                <?php
                                if ($model->logo_footer) {
                                    echo '<img src="' . Params::urlProfilRSDirectory() . $model->logo_footer . '" style="height: 100px; max-width: 80%; padding: 10px; display: block;">';
                                    echo Chtml::activeFileField($model, 'logo_footer', array('maxlength' => 254,));
                                    echo CHtml::link(Yii::t('mds', '{icon} Hapus', array('{icon}' => '<i class="entypo-trash"></i>')), $this->createUrl('update'), array('class' => 'btn btn-primary', 'onclick' => 'return refreshForm(this);'));
                                } else {
                                    echo '<span class="no-image">Belum ada gambar</span>';
                                    echo Chtml::activeFileField($model, 'logo_footer', array('maxlength' => 254,));
                                }
                                ?>
                            </div>
                            <div class="col-sm-4">
                                <label>
                                    Bagian Footer Kanan
                                    <?php echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-help-circled"></i>')), '', array('class' => 'help', 'title' => 'Footer merupakan area di bagian paling bawah halaman', 'rel' => 'tooltip',)); ?>
                                </label>
                                <?php
                                if ($model->logo_footer_2) {
                                    echo '<img src="' . Params::urlProfilRSDirectory() . $model->logo_footer_2 . '" style="height: 100px; max-width: 80%; padding: 10px; display: block;">';
                                    echo Chtml::activeFileField($model, 'logo_footer_2', array('maxlength' => 254,));
                                    echo CHtml::link(Yii::t('mds', '{icon} Hapus', array('{icon}' => '<i class="entypo-trash"></i>')), $this->createUrl('update'), array('class' => 'btn btn-primary', 'onclick' => 'return refreshForm(this);'));
                                } else {
                                    echo '<span class="no-image">Belum ada gambar</span>';
                                    echo Chtml::activeFileField($model, 'logo_footer_2', array('maxlength' => 254,));
                                }
                                ?>
                            </div>
                            <!-- <div class="col-sm-4">
                                <label>
                                    Bagian Footer
                                    <?php //echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-help-circled"></i>')), '', array('class' => 'help', 'title' => 'Footer merupakan area di bagian paling bawah halaman', 'rel' => 'tooltip',)); ?>
                                </label>
                                <?php
                                // if ($model->logo_footer) {
                                //     echo '<img src="' . Params::urlProfilRSDirectory() . $model->logo_footer . '" style="height: 100px; max-width: 80%; padding: 10px; display: block;">';
                                //     echo Chtml::activeFileField($model, 'logo_footer', array('maxlength' => 254,));
                                //     echo CHtml::link(Yii::t('mds', '{icon} Hapus', array('{icon}' => '<i class="entypo-trash"></i>')), $this->createUrl('update'), array('class' => 'btn btn-primary', 'onclick' => 'return refreshForm(this);'));
                                // } else {
                                //     echo '<span class="no-image">Belum ada gambar</span>';
                                //     echo Chtml::activeFileField($model, 'logo_footer', array('maxlength' => 254,));
                                // }
                                ?>
                            </div> -->
                            <div class="clear"></div>
                            <div class="col-sm-12">
                                <p style="margin-top: 15px; font-style: italic;"><b>Catatan :</b><br>Gambar disarankan untuk menggunakan resolusi maksimal 250x250 px.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php // $this->renderPartial('_profilpict', array('model'=>$modProfilPict, 'form'=>$form));
        ?>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeypress' => 'return formSubmit(this,event)')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('update'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>


<?php
//========= Dialog buat cari data pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian Data Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 480,
        'resizable' => false,
    ),
));
$modDialogPegawai = new PegawaiV('search');
$modDialogPegawai->unsetAttributes();
if (isset($_GET['PegawaiV'])) {
    $modDialogPegawai->attributes = $_GET['PegawaiV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'datakunjungan-grid',
    'dataProvider' => $modDialogPegawai->search(),
    'filter' => $modDialogPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","javascript:void(0);",array("class"=>"btn-small",
                    "id" => "selectPegawai",
                    "onClick" => "
						$(\"#' . CHtml::activeId($model, 'namadirektur_rumahsakit') . '\").val(\"$data->nama_pegawai\");
                        $(\"#dialogPegawai\").dialog(\"close\");
                    "))',
        ),
        'gelardepan',
        'nomorindukpegawai',
        'nama_pegawai',
        'jeniskelamin',
        'alamat_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>

<?php
$buttonMinus = CHtml::link('<i class="entypo-minus"></i>', '#', array('class' => 'btn btn-default', 'onclick' => 'delRow(this); return false;'));
$confimMessage = Yii::t('mds', 'Do You want to remove?');
$js = <<< JSCRIPT

function addRow(obj)
{
    var tableId = $(obj).parents('table').attr('id');
    var objName = $(obj).attr('name');
    var tr = $('#'+tableId+' tbody tr:first').html();
    $('#'+tableId+' tbody tr:last').after('<tr>'+tr+'</tr>');
    $('#'+tableId+' tbody tr:last div:last').append('$buttonMinus');
    $('#'+tableId+' tbody tr:last').find('input[name$="[profilpicture_id]"]').remove();

    if (tableId == 'tbl-misi'){
        renameInput(tableId, 'SAMisirsM','misi', 'Tambah');
    }else if (tableId == 'tbl_profilpicture'){
        renameInput(tableId, 'SAProfilpictureM','profilpicture_nama', 'Tambah');
        renameInput(tableId, 'SAProfilpictureM','profilpicture_desc', 'Tambah');
        renameInput(tableId, 'SAProfilpictureM','profilpicture_path', 'Tambah');
        renameInput(tableId, 'SAProfilpictureM','profilpicture_id', 'Tambah');
        renameInput(tableId, 'SAProfilpictureM','display_antrian', 'Tambah');
        renameInput(tableId, 'SAProfilpictureM','temp_gambar', 'Tambah');
    }
}

function addRowGambar(obj)
{
    var tableId = $(obj).parents('table').attr('id');
    var objName = $(obj).attr('name');
    var tr = $('#'+tableId+' tbody tr:first').html();
    $('#'+tableId+' tbody tr:last').after('<tr>'+tr+'</tr>');
    $('#'+tableId+' tbody tr:last td:last').append('$buttonMinus');
    $('#'+tableId+' tbody tr:last').find('input[name$="[profilpicture_id]"]').remove();

    if (tableId == 'tbl-misi'){
        renameInput(tableId, 'SAMisirsM','misi', 'Tambah');
    }else if (tableId == 'tbl_profilpicture'){
        renameInput(tableId, 'SAProfilpictureM','profilpicture_nama', 'Tambah');
        renameInput(tableId, 'SAProfilpictureM','profilpicture_desc', 'Tambah');
        renameInput(tableId, 'SAProfilpictureM','profilpicture_path', 'Tambah');
        renameInput(tableId, 'SAProfilpictureM','profilpicture_id', 'Tambah');
        renameInput(tableId, 'SAProfilpictureM','display_antrian', 'Tambah');
        renameInput(tableId, 'SAProfilpictureM','temp_gambar', 'Tambah');
    }
}

function renameInput(table, modelName,attributeName,proses)
{
    var trLength = $('#'+table+' tbody tr').length;
    var proses = proses;
    var i = 1;
    $('#'+table+' tbody tr').each(function(){
        if(i==trLength && proses=='Tambah')
            {
                $(this).find('textarea[name$="['+attributeName+']"], input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
                $(this).find('textarea[name$="['+attributeName+']"], input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName);
                $(this).find('textarea[name$="['+attributeName+']"], input[name$="['+attributeName+']"]').not(':hidden').attr('value','');
                $(this).find('textarea').html('');
                $(this).find('checkbox').attr('checked','');

            }
        else
            {
                $(this).find('textarea[name$="['+attributeName+']"], input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
                $(this).find('textarea[name$="['+attributeName+']"], input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName);
            }
        i++;
    });
}

function delRow(obj)
{
    var tableId = $(obj).parents('table').attr('id');
    if(!confirm("$confimMessage")) return false;
    else {
        $(obj).parent().parent().remove();
        if (tableId == 'tbl-misi'){
            renameInput(tableId, 'SAMisirsM','misi', 'hapus');
        }else if (tableId == 'tbl_profilpicture'){
            renameInput(tableId, 'SAProfilpictureM','profilpicture_nama', 'hapus');
            renameInput(tableId, 'SAProfilpictureM','profilpicture_desc', 'hapus');
            renameInput(tableId, 'SAProfilpictureM','profilpicture_path', 'hapus');
            renameInput(tableId, 'SAProfilpictureM','display_antrian', 'hapus');
        }
    }
}
JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input', $js, CClientScript::POS_HEAD);
?>
<script type="text/javascript">
    /** bersihkan dropdown kelurahan */
    function setClearDropdownKelurahan() {
        $("#<?php echo CHtml::activeId($model, "kelurahan_id"); ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    }

    /** bersihkan dropdown kecamatan */
    function setClearDropdownKecamatan() {
        $("#<?php echo CHtml::activeId($model, "kecamatan_id"); ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    }

    function setKodeJenisRs(jenisrs) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetKodeJenisRs'); ?>',
            data: {
                jenisrs: jenisrs
            }, //
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($model, "kodejenisrs_profilrs"); ?>").val(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setKodePemilikRs(pemilikrs) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetKodePemilikRs'); ?>',
            data: {
                pemilikrs: pemilikrs
            }, //
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($model, "kodestatuskepemilikanrs"); ?>").val(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setKodeStatusSwasta(statusswasta) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetKodeStatusSwasta'); ?>',
            data: {
                statusswasta: statusswasta
            }, //
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($model, "khususuntukswasta"); ?>").val(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setDropdownKelasRS(pemilik) {
        $("#SAProfilRumahSakitM_kelas_rumahsakit").addClass("animation-loading-1");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownKelasRS'); ?>',
            data: {
                pemilik: pemilik
            }, //
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($model, "kelas_rumahsakit"); ?>").html(data.listKelas);
                $("#SAProfilRumahSakitM_kelas_rumahsakit").removeClass("animation-loading-1");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
</script>