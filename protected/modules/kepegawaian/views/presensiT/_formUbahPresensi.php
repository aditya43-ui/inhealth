<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pengirimanrm-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
));
$this->widget('bootstrap.widgets.BootAlert');

$status = empty($modUbahStatus->verifikasi) ? false : $modUbahStatus->verifikasi
?>

<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<?php echo $form->errorSummary(array($modUbahStatus)); ?>

<div class="row">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-file"></i> Data <b>Pegawai</b>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Nomor Fingerprint", '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPegawai, 'no_fingerprint', array('readonly' => true)) ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::label("NIP", '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPegawai, 'nomorindukpegawai', array('readonly' => true)) ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::label("Nama Pegawai", '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPegawai, 'nama_pegawai', array('readonly' => true)) ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Kelompok Pegawai", '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPegawai, 'kelompokpegawai_nama', array('readonly' => true)) ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::label("Jabatan", '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPegawai, 'jabatan_nama', array('readonly' => true)) ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php /*
		<div class="col-sm-6">
			<div class="control-group">
				<?php echo $form->labelEx($modUbahStatus,'tglpengirimanrm', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php   
						$this->widget('MyDateTimePicker',array(
							'model'=>$modUbahStatus,
							'attribute'=>'tglpresensi',
							'mode'=>'datetime',
							'options'=> array(
							),
							'htmlOptions'=>array('class'=>'dtPicker3 datetimemask','placeholder'=>'00:00:0000 00:00:00'),
						));
					?>
					<?php echo $form->error($modUbahStatus, 'tglpengirimanrm'); ?> 
				</div>
			</div>
			
			<div class="control-group">
				<?php echo CHtml::label('Instalasi Tujuan <span style ="color:red;">*</span>', 'instalasi_id', array('class'=>'control-label')); ?>
				 <div class="controls">
					 <?php
                        echo $form->dropDownList($modUbahStatus, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll(" instalasi_aktif = TRUE ORDER BY instalasi_nama ASC "), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span2 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style'=>'width:200px;',
                            'ajax' => array('type' => 'POST',
                                'url' => $this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($modUbahStatus))),
                                'update' => '#' . CHtml::activeId($modUbahStatus, 'ruangan_id') . ''),));
                        ?>
				 </div>
			 </div>
			
			<div class="control-group">
				<?php echo CHtml::label('Ruangan Tujuan <span style ="color:red;">*</span>', 'ruangan_id', array('class'=>'control-label')); ?>
				 <div class="controls">
					 <?php echo $form->dropDownList($modUbahStatus, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$modUbahStatus->instalasi_id,'ruangan_aktif'=>true)), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span2 required', 'style'=>'width:200px;','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>				 
					 <?php echo $form->error($modUbahStatus, 'ruangan_id'); ?>
				 </div>
			 </div>
			
			<div class="control-group">
                <?php echo CHtml::label('Petugas Pengirim', 'petugaspengirim_id', array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php //echo CHtml::textField('petugaspengirim_id','',array('onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
                    <?php echo $form->hiddenField($modUbahStatus,'petugaspengirim_id','',array('onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
                    <?php //echo CHtml::activeHiddenField($modUbahStatus,'petugaspengirim','',array('onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
                     <?php echo $form->textField($modUbahStatus,'petugaspengirim',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
                
                </div>
            </div>
		</div>
		<div class="col-sm-6">
			
		</div>
		 * 
		 */ ?>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Presensi (Tanggal <?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($modUbahStatus->tglpresensi))); ?>)</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group datanonaktif_presensi">
                <?php echo CHtml::label("Shift Kerja <span class='required'>*</span>", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $shift_a = CHtml::listData(ShiftM::model()->findAllByAttributes(array('shift_id' => $modUbahStatus->shift_id)), 'shift_id', 'shiftJam');

                    $shift_b = CHtml::listData(ShiftpegawaiM::model()->getShiftPegawai($modUbahStatus->pegawai_id), 'shift_id', 'shiftPegawaiJam');

                    foreach ($shift_a as $idx => $item) {
                        $shift_b[$idx] = $item;
                    }

                    echo $form->dropDownList($modUbahStatus, 'shift_id', $shift_b, array('empty' => '--Pilih --', 'class' => 'required', 'onchange' => 'generatePerhitungan();')) ?>
                    <?php echo $form->hiddenField($modUbahStatus, 'tglpresensi', array('readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group datanonaktif_presensi">
                <?php echo CHtml::label("Jam Kerja Masuk", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modUbahStatus, 'jamkerjamasuk', array('readonly' => true, 'class' => 'span2')); ?>
                </div>
            </div>
            <div class="control-group datanonaktif_presensi">
                <?php echo CHtml::label("Jam Scan Masuk <span class='required'>*</span>", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modUbahStatus,
                        'attribute' => '[masuk]tgl_jammasuk',
                        'mode' => 'time',
                        'options' => array(
                            'onSelect' => 'js:function(){generatePerhitungan();}',
                        ),
                        'htmlOptions' => array(
                            'readonly' => true, 'style' => 'width:100px;'
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group datanonaktif_presensi">
                <?php echo CHtml::label("Jam Scan Pulang <span class='required'>*</span>", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modUbahStatus,
                        'attribute' => '[pulang]tgl_jampulang',
                        'mode' => 'time',
                        'options' => array(
                            'onSelect' => 'js:function(){generatePerhitungan();}',
                        ),
                        'htmlOptions' => array(
                            'readonly' => true, 'style' => 'width:100px;'
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Keterangan <span class='required'>*</span>", '', array('class' => 'control-label required')); ?>
                <div class="controls">
                    <?php
                    echo $form->textArea($modUbahStatus, 'keterangan', array('class' => 'required autogrow'));
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Status Kehadiran <span class='required'>*</span>", '', array('class' => 'control-label required')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modUbahStatus, 'statuskehadiran_id',  CHtml::listData(StatuskehadiranM::model()->findAll("statuskehadiran_aktif = TRUE ORDER BY statuskehadiran_nama ASC"), 'statuskehadiran_id', 'statuskehadiran_nama'), array('empty' => '--Pilih --', 'class' => 'required', 'onChange' => 'nonAktifKolom();')) ?>
                </div>
            </div>
            <div class="control-group datanonaktif_presensi">
                <?php echo CHtml::label("Jam Kerja Pulang", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modUbahStatus, 'jamkerjapulang', array('readonly' => true, 'class' => 'span2')); ?>
                </div>
            </div>
            <div class="control-group datanonaktif_presensi">
                <?php //echo CHtml::label("Terlambat <span class='required'>*</span>",'',array('class' => 'control-label')); 
                ?>
                <label class='control-label' data-toggle="tooltip" data-placement="top" title="" data-original-title="Perhitungan terlambat dimulai dari jam scan masuk sudah melewati 15 menit dari jam kerja masuk">Terlambat <i class="<?php echo MyIcon::getIcons('info2') ?>"></i> <span class='required'>*</span></label>
                <div class="controls">
                    <?php
                    echo $form->hiddenField($modUbahStatus, '[masuk]presensimasuk_id', array('class' => ' span2', 'readonly' => true, 'style' => 'text-align:right;'));
                    echo $form->textField($modUbahStatus, '[masuk]terlambat_mnt', array('class' => 'required span2', 'readonly' => true, 'style' => 'text-align:right;')) . ' menit';
                    ?>
                </div>
            </div>
            <div class="control-group datanonaktif_presensi">
                <?php echo CHtml::label("Pulang Awal <span class='required'>*</span>", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $form->hiddenField($modUbahStatus, '[pulang]presensipulang_id', array('class' => ' span2', 'readonly' => true, 'style' => 'text-align:right;'));
                    echo $form->textField($modUbahStatus, '[pulang]pulangawal_mnt', array('class' => 'required span2', 'readonly' => true, 'style' => 'text-align:right;')) . ' menit';
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
    if ($status != true) {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
        );
    } else {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true)
        );
    }
    ?>

    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('class' => 'btn btn-default', 'onclick' => "window.parent.$('#dialogUbahPresensi').dialog('close');")
    ); ?>
</div>
<?php $this->endWidget(); ?>

<script>
    $(document).ready(function() {
        if (<?php echo empty($modUbahStatus->verifikasi) ? 'null' : $modUbahStatus->verifikasi; ?> == true) {
            myAlert("Data Presensi pada tanggal <?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($modUbahStatus->tglpresensi))); ?> sudah diubah !", "Perhatian !")
            setTimeout("window.parent.$('#dialogUbahPresensi').dialog('close');", 500);
        }
        generatePerhitungan();
        nonAktifKolom();
    });

    function generatePerhitungan() {
        var shift = $("#<?php echo CHtml::activeId($modUbahStatus, 'shift_id') ?>").val();
        var jammasuk = $("#<?php echo CHtml::activeId($modUbahStatus, '[masuk]tgl_jammasuk') ?>").val();
        var jampulang = $("#<?php echo CHtml::activeId($modUbahStatus, '[pulang]tgl_jampulang') ?>").val();

        if (shift != '' && jammasuk != '' && jampulang != '') {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('generateHitungPresensi'); ?>',
                data: {
                    shift: shift,
                    jammasuk: jammasuk,
                    jampulang: jampulang
                },
                dataType: "json",
                success: function(data) {
                    if (data.sukses == 1) {
                        $("#<?php echo CHtml::activeId($modUbahStatus, 'jamkerjamasuk') ?>").val(data.jamkerjamasuk);
                        $("#<?php echo CHtml::activeId($modUbahStatus, 'jamkerjapulang') ?>").val(data.jamkerjapulang);
                        $("#<?php echo CHtml::activeId($modUbahStatus, '[masuk]terlambat_mnt') ?>").val(data.terlambat);
                        $("#<?php echo CHtml::activeId($modUbahStatus, '[pulang]pulangawal_mnt') ?>").val(data.pulangawal);
                    } else {
                        //						alert(data.pesan);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            //			myAlert("Shift, Jam Masuk dan Jam Pulang harus diisi");
            return false;
        }
    }

    function nonAktifKolom() {
        if ($('#<?php echo CHtml::activeId($modUbahStatus, 'statuskehadiran_id'); ?>').val() != <?php echo Params::STATUSKEHADIRAN_HADIR; ?>) {
            $('.datanonaktif_presensi').hide();
            $('#<?php echo CHtml::activeId($modUbahStatus, 'shift_id'); ?>').val('');
            $('#<?php echo CHtml::activeId($modUbahStatus, 'jamkerjamasuk'); ?>').val('');
            $('#<?php echo CHtml::activeId($modUbahStatus, 'jamkerjapulang'); ?>').val('');
            $('#<?php echo CHtml::activeId($modUbahStatus, '[masuk]tgl_jammasuk'); ?>').val('');
            $('#<?php echo CHtml::activeId($modUbahStatus, '[pulang]tgl_jampulang'); ?>').val('');
            $('#<?php echo CHtml::activeId($modUbahStatus, '[masuk]terlambat_mnt'); ?>').val('');
            $('#<?php echo CHtml::activeId($modUbahStatus, '[pulang]presensipulang_id'); ?>').val('');
            $('#<?php echo CHtml::activeId($modUbahStatus, '[pulang]pulangawal_mnt'); ?>').val('');
            $('#<?php echo CHtml::activeId($modUbahStatus, '[pulang]pulangawal_mnt'); ?>').removeClass('required');
            $('#<?php echo CHtml::activeId($modUbahStatus, 'shift_id'); ?>').removeClass('required');
            $('#<?php echo CHtml::activeId($modUbahStatus, '[masuk]tgl_jammasuk'); ?>').removeClass('required');
            $('#<?php echo CHtml::activeId($modUbahStatus, '[pulang]tgl_jampulang'); ?>').removeClass('required');
            $('#<?php echo CHtml::activeId($modUbahStatus, '[pulang]pulangawal_mnt'); ?>').removeClass('required');
            $('#<?php echo CHtml::activeId($modUbahStatus, '[masuk]terlambat_mnt'); ?>').removeClass('required');
        } else {
            $('#<?php echo CHtml::activeId($modUbahStatus, '[pulang]pulangawal_mnt'); ?>').addClass('required');
            $('#<?php echo CHtml::activeId($modUbahStatus, 'shift_id'); ?>').addClass('required');
            $('#<?php echo CHtml::activeId($modUbahStatus, '[masuk]tgl_jammasuk'); ?>').addClass('required');
            $('#<?php echo CHtml::activeId($modUbahStatus, '[pulang]tgl_jampulang'); ?>').addClass('required');
            $('#<?php echo CHtml::activeId($modUbahStatus, '[pulang]pulangawal_mnt'); ?>').addClass('required');
            $('#<?php echo CHtml::activeId($modUbahStatus, '[masuk]terlambat_mnt'); ?>').addClass('required');
            $('.datanonaktif_presensi').show();
        }

    }
</script>