<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pasienpulang-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onsubmit' => 'return cekValidasi(this);return false;', 'onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#' . CHtml::activeId($modelPulang, 'penerimapasien'),
));
?>
<?php
$this->breadcrumbs = array(
    'Pasien Pulang'
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data pasien pulang berhasil disimpan!");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
//    if(empty($modTariftindakan->harga_tariftindakan)){
//        echo "<script>
//                    myAlert('Maaf, Harga Tarif Kamar Rawat Inap Belum Ada. Silakan Hubungi Bagian Administrasi');
//                    window.location.href(".Yii::app()->createUrl('/PasienRawatInap/index').");
//                </script>";
//    }else{
//        echo "<script>
//                    myAlert('Harga Tarif Kamar Rawat Inap Ada');
//                </script>";
//    }
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Pasien <b><?php

                                                    if (isset($_GET['melarikandiri']) && $_GET['melarikandiri'] == 1) {
                                                        echo "Melarikan Diri";
                                                    } else if (isset($_GET['meninggal']) && $_GET['meninggal'] == 1) {
                                                        echo "Meninggal";
                                                    } else {
                                                        echo "Pulang";
                                                    }

                                                    ?></b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"></div>
            </div>
            <div class="panel-body">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td><?php echo CHtml::label('Tgl. Pendaftaran', 'tgl_pendaftaran', array('class' => 'control-label')); ?></td>
                        <td><?php
                            $modPasienRIV->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modPasienRIV->tgl_pendaftaran);
                            echo CHtml::activeTextField($modPasienRIV, 'tgl_pendaftaran', array('readonly' => true));
                            ?></td>

                        <td>
                            <div class="control-label"> <?php echo CHtml::activeLabel($modPasienRIV, 'no_rekam_medik', array('class' => 'no_rek')); ?> </div>
                        </td>
                        <td>
                            <?php
                            if (!isset($_GET['pendaftaran_id'])) {
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $modPasienRIV,
                                    'attribute' => 'no_rekam_medik',
                                    'value' => '',
                                    'source' => 'js: function(request, response) {
													   $.ajax({
														   url: "' . Yii::app()->createUrl('ActionAutoComplete/PasienRawatInap2') . '",
														   dataType: "json",
														   data: {
															   term: request.term,
														   },
														   success: function (data) {
																   response(data);
														   }
													   })
													}',
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 2,
                                        'focus' => 'js:function( event, ui ) {
														$(this).val( ui.item.label);
														return false;
													}',
                                        'select' => 'js:function( event, ui ) {
														  $("#' . CHtml::activeId($modPasienRIV, 'tgl_pendaftaran') . '").val(ui.item.tgl_pendaftaran);
														  $("#' . CHtml::activeId($modPasienRIV, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);   
														  $("#' . CHtml::activeId($modPasienRIV, 'umur') . '").val(ui.item.umur);     
														  $("#' . CHtml::activeId($modPasienRIV, 'jeniskasuspenyakit_nama') . '").val(ui.item.jeniskasuspenyakit_nama);
														  $("#' . CHtml::activeId($modPasienRIV, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);   
														  $("#' . CHtml::activeId($modPasienRIV, 'nama_pasien') . '").val(ui.item.nama_pasien);     
														  $("#' . CHtml::activeId($modPasienRIV, 'jeniskelamin') . '").val(ui.item.jeniskelamin);  
														  $("#' . CHtml::activeId($modPasienRIV, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);  
														  $("#' . CHtml::activeId($modPasienRIV, 'nama_bin') . '").val(ui.item.nama_bin);   
														  $("#' . CHtml::activeId($modelPulang, 'pendaftaran_id') . '").val(ui.item.pendaftaran_id);     
														  $("#' . CHtml::activeId($modelPulang, 'pasien_id') . '").val(ui.item.pasien_id);    
														  $("#' . CHtml::activeId($modelPulang, 'pasienadmisi_id') . '").val(ui.item.pasienadmisi_id);
														  $("#' . CHtml::activeId($modMasukKamar, 'masukkamar_id') . '").val(ui.item.masukkamar_id); 
														  $("#' . CHtml::activeId($modMasukKamar, 'tglmasukkamar') . '").val(ui.item.tglmasukkamar); 
															  }'
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => false,
                                        'placeholder' => 'No. Rekam Medik',
                                        'size' => 20,
                                        'class' => 'span3',
                                        'onkeypress' => "return $(this).focusNextInputField(event);",
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogDaftarPasien', 'idTombol' => 'tombolPasienDialog'),
                                ));
                            } else {
                                echo CHtml::activeTextField($modPasienRIV, 'no_rekam_medik', array('readonly' => true));
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label class="control-label">No. Pendaftaran</label></td>
                        <td>
                            <?php echo CHtml::activeTextField($modPasienRIV, 'no_pendaftaran', array('readonly' => true, 'class' => 'span2')); ?>
                        </td>

                        <td><?php echo CHtml::activeLabel($modPasienRIV, 'jeniskelamin', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::activeTextField($modPasienRIV, 'jeniskelamin', array('readonly' => true)); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo CHtml::activeLabel($modPasienRIV, 'umur', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::activeTextField($modPasienRIV, 'umur', array('readonly' => true)); ?></td>

                        <td><?php echo CHtml::activeLabel($modPasienRIV, 'nama_pasien', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::activeTextField($modPasienRIV, 'nama_pasien', array('readonly' => true)); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo CHtml::activeLabel($modPasienRIV, 'jeniskasuspenyakit_nama', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::activeTextField($modPasienRIV, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?></td>

                        <td><?php echo CHtml::activeLabel($modPasienRIV, 'nama_alias', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::activeTextField($modPasienRIV, 'nama_bin', array('readonly' => true)); ?></td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            if (!empty($modPendaftaran->pendaftaran_id)) {
                                echo CHtml::hiddenField("pegawaiPemeriksa", $modPendaftaran->pegawai_id);
                                echo CHtml::hiddenField("ruanganAsal", $modPendaftaran->ruangan_id);
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"></div>
            </div>
            <div class="panel-body">
                <?php
                $is_meninggal = false;

                if (isset($_GET['meninggal']) && $_GET['meninggal'] == 1) {
                    $is_meninggal = true;
                }
                ?>

                <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                            ?></p>-->
                <?php echo $form->errorSummary(array($modelPulang)); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?php echo $form->hiddenField($modelPulang, 'pasienadmisi_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                        <?php echo $form->hiddenField($modelPulang, 'pendaftaran_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                        <?php echo $form->hiddenField($modelPulang, 'pasien_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>

                        <div class="control-group">
                            <?php
                            echo $form->labelEx($modelPulang, 'tglpasienpulang', array(
                                'class' => 'control-label',
                                'label' => ($is_meninggal ? "Tanggal Pasien ke Pemulasaran Jenazah" : "Tanggal Pasien Pulang"),
                            ))
                            ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modelPulang,
                                    'attribute' => 'tglpasienpulang',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onchange' => 'setHitungLamaRawat();'),
                                ));
                                ?>
                                <?php echo $form->error($modelPulang, 'tglpasienpulang'); ?>
                            </div>
                        </div>
                        <div class="control-group " <?php echo $is_meninggal ? "hidden" : "" ?>>
                            <?php echo $form->labelEx($modelPulang, 'carakeluar_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                if ((isset($_GET['melarikandiri']) && $_GET['melarikandiri'] == 1) || (isset($_GET['meninggal']) && $_GET['meninggal'] == 1)) {
                                    echo $form->hiddenField($modelPulang, 'carakeluar_id');
                                    echo $form->dropDownList($modelPulang, 'carakeluar_id', CHtml::listData($modelPulang->getCarakeluarItems(), 'carakeluar_id', 'carakeluar_nama'), array(
                                        'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onclick' => 'carakeluar(this.value);', 'disabled' => true,
                                        'ajax' => array(
                                            'type' => 'POST',
                                            'url' => $this->createUrl('SetDropDownKondisiKeluar', array('encode' => false, 'model_nama' => get_class($modelPulang))),
                                            'update' => "#" . CHtml::activeId($modelPulang, 'kondisikeluar_id'),
                                        ),
                                    ));
                                } else {
                                    echo $form->hiddenField($modelPulang, 'carakeluar_id');
                                    echo $form->dropDownList($modelPulang, 'carakeluar_id', CHtml::listData($modelPulang->getCarakeluarItems(), 'carakeluar_id', 'carakeluar_nama'), array(
                                        'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onclick' => 'carakeluar(this.value);',
                                        'disabled' => true,
                                        'ajax' => array(
                                            'type' => 'POST',
                                            'url' => $this->createUrl('SetDropDownKondisiKeluar', array('encode' => false, 'model_nama' => get_class($modelPulang))),
                                            'update' => "#" . CHtml::activeId($modelPulang, 'kondisikeluar_id'),
                                        ),
                                    ));
                                }
                                ?>
                                <?php echo $form->error($modelPulang, 'carakeluar_id'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label((($is_meninggal ? "Kondisi Meninggal" : "Kondisi Pulang")) . "<span class='required'>*</span>", 'kondisikeluar_id', array('class' => 'control-label required')) ?>
                            <?php //echo $form->labelEx($modelPulang,'kondisikeluar_id', array('class'=>'control-label'))   
                            ?>
                            <div class="controls">
                                
                                <?php 
                                echo $form->hiddenField($modelPulang, 'kondisikeluar_id');
                                echo $form->dropDownList($modelPulang, 'kondisikeluar_id', CHtml::listData($modelPulang->getKondisikeluarItems($modelPulang->carakeluar_id), 'kondisikeluar_id', 'kondisikeluar_nama'), array('disabled' => true,'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onclick' => 'pasienmeninggal(this.value);'));
                                ?>
                                <?php echo $form->error($modelPulang, 'kondisikeluar_id'); ?>
                            </div>
                        </div>
                        <div <?php echo $is_meninggal ? "hidden" : "" ?>>
                            <?php echo $form->textFieldRow($modelPulang, 'penerimapasien', array('placeholder' => 'Penerima Pasien', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            <div class="control-group">
                                <?php echo CHtml::label('Tgl. Masuk Kamar', 'tglmasukkamar', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($modMasukKamar, 'tglmasukkamar', array('class' => 'span3', 'readonly' => true)) ?>
                                    <?php
                                    echo $form->hiddenField($modMasukKamar, 'masukkamar_id', array(
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'span2', 'readonly' => TRUE
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php //echo $form->labelEx($modMasukKamar,'tglkeluarkamar', array('class'=>'control-label'))  
                                ?>
                                <?php echo CHtml::label('Tgl. Pulang Kamar', 'tglkeluarkamar', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modMasukKamar,
                                        'attribute' => 'tglkeluarkamar',
                                        'mode' => 'datetime',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions' => array(
                                            'readonly' => true,
                                            'class' => 'span3 dtPicker3',
                                            'onkeypress' => "return $(this).focusNextInputField(event);",
                                        ),
                                    ));
                                    ?>
                                    <?php echo $form->error($modMasukKamar, 'tglkeluarkamar'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php //echo $form->labelEx($modMasukKamar,'jamkeluarkamar', array('class'=>'control-label'));  
                                ?>
                                <?php echo CHtml::label('Jam Pulang Kamar', 'jamkeluarkamar', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modMasukKamar,
                                        'attribute' => 'jamkeluarkamar',
                                        'mode' => 'time',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions' => array(
                                            'readonly' => true,
                                            'class' => 'span3 dtPicker3',
                                            'onkeypress' => "return $(this).focusNextInputField(event);",
                                        ),
                                    ));
                                    ?>
                                    <?php echo $form->error($modMasukKamar, 'jamkeluarkamar'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modMasukKamar, 'lamadirawat_kamar', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modMasukKamar, 'lamadirawat_kamar', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> Hari
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modelPulang, 'hariperawatan', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modelPulang, 'hariperawatan', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> Hari
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modelPulang, 'keterangankeluar', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textArea($modelPulang, 'keterangankeluar', array('placeholder' => 'Keterangan Pasien Pulang', 'class' => 'span3', 'cols' => 50, 'rows' => 3)); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $is_hidden = "";

                    if (isset($_GET['melarikandiri']) && $_GET['melarikandiri'] == 1) {
                        $is_hidden = "hidden";
                    }
                    ?>
                    <!-- <div class="col-sm-6">
                        <div class="control-group">
                            <label class="control-label">Kirim pesan WhatsApp kepada pasien ?</label>
                            <div class="controls">
                                <?php
                                //echo CHtml::radioButtonList('is_whatsapp', 'Tidak', array(
                                //    'Ya'=>'Ya', 'Tidak'=>'Tidak'
                                //));
                                ?>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-sm-6" <?php echo $is_hidden; ?>>
                        <div class="control-group hide">
                            <!--fieldset class="box"-->
                            <legend class="rim" <?php echo $is_meninggal ? "hidden" : "" ?>>
                                <?php echo CHtml::checkBox('isDead', $modelPulang->isDead, array('onkeypress' => "return $(this).focusNextInputField(event)")) ?>
                                Pasien Meninggal
                            </legend>
                            <div class="control-group">
                                <?php echo $form->labelEx($modelPulang, 'tgl_meninggal', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modelPulang,
                                        'attribute' => 'tgl_meninggal',
                                        'mode' => 'datetime',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                            // 'maxTime' => '11:00',
                                            // 'hourMax' => date('H'),
                                            // 'minuteMax' => date('i'),
                                            // 'secondMax' => date('s'),
                                        ),
                                        'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'disabled' => true),
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="box-diagnosameninggal" hidden>
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            Tabel Diagnosa Kematian (ICD 10)
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <?php 
                                            echo CHtml::htmlButton(
                                                '<i class="icon-plus icon-white"></i> Tambah Diagnosa ICD 10',
                                                array(
                                                    'onclick' => '$("#dialogDiagnosa").dialog("open")',
                                                    'class' => 'btn btn-primary',
                                                    'rel' => "tooltip",
                                                    'title' => "Klik untuk menambahkan Diagnosa 10 Pasien",
                                                )
                                            );
                                        ?>

                                        <div class="div-table-diagnosameninggal table-responsive">
                                            <table class="table table-striped table-condensed" id="table-diagnosameninggal">
                                                <thead>
                                                    <th>No</th>
                                                    <th>Kode Diagnosa</th>
                                                    <th>Nama Diagnosa</th>
                                                    <th>Nama Lain</th>
                                                    <th>Hapus</th>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <!--</fieldset>-->
                            <!--fieldset class="box"-->
                            <?php /*
                                      <legend class="rim">
                                      <?php echo CHtml::checkBox('isKontrol', $modelPulang->isKontrol, array('onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
                                      Rencana Kontrol Pasien
                                      </legend>
                                      <?php
                                      $ruangan = RuanganM::model()->findAllByAttributes(array(
                                      'instalasi_id'=>Params::INSTALASI_ID_RJ,
                                      'ruangan_aktif'=>true,
                                      ), array(
                                      'order'=>'ruangan_nama',
                                      ));

                                      echo $form->dropDownListRow($modPendaftaran, 'ruangankontrol_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'), array(
                                      'empty'=>'-- Pilih --', 'disabled'=>true, 'onchange' => 'openTglKontrol(this)'
                                      ));
                                      ?>
                                      <div class="control-group " id="tanggal_kontrol" hidden>
                                      <?php echo CHtml::label('Tgl. Rencana Kontrol', 'tglrenkontrol', array('class' => 'control-label')) ?>
                                      <div class="controls">
                                      <?php
                                      $this->widget('MyDateTimePicker', array(
                                      'model' => $modPendaftaran,
                                      'attribute' => 'tglrenkontrol',
                                      'mode' => 'datetime',
                                      'options' => array(
                                      'dateFormat' => Params::DATE_FORMAT,
                                      'onSelect'=> 'js: function(date) {
                                      cekJadwalPoli(date);
                                      }',
                                      'minDate' => 'd+1'
                                      ),
                                      'htmlOptions' => array(
                                      //'onchange' => 'cekJadwalPoli(this)',
                                      //'onblur' => 'cekJadwalPoli(this)',
                                      'readonly' => true,
                                      'class' => 'span3 dtPicker3',
                                      'disabled' => true),
                                      ));
                                      ?>
                                      </div>
                                      </div>
                                     */ ?>
                            <!--</fieldset>-->
                        </div>

                        <div class="panel panel-success boxkirimdokumen" hidden>
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Form Kirim Dokumen Rekam Medik
                                </div>
                            </div>
                            <div class="panel-body">
                                <?php echo CHtml::hiddenField('statusdokrm', $modUbahStatus->statusdokrm); ?>
                                <?php echo $this->renderPartial('_formStatusDokPP', array('form' => $form, 'modUbahStatus' => $modUbahStatus), true); ?>
                            </div>
                        </div>

                        <?php
                        if (!$is_meninggal) {
                            echo $this->renderPartial('_formRencanaKontrol', array('form' => $form, 'model' => $modRenKontrol), true);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success box-diagnosameninggal" hidden>
            <div class="panel-heading">
                <div class="panel-title">
                    Surat Kematian Pasien
                </div>
            </div>
            <div class="panel-body">
                    <?php 
                        $this->renderPartial($this->path_view . '_formSuratKematian', ['form' => $form, 'modKematian' => $modKematian]);
                    ?>      
            </div>
        </div>
        <?php
        /*
                  <div class="panel panel-success">
                  <div class="panel-heading">
                  <div class="panel-title"> <?php echo CHtml::checkBox('pakeRujukan', $modelPulang->pakeRujukan, array('onkeypress'=>"return $(this).focusNextInputField(event)")) ?> Rujukan Keluar</div>
                  </div>
                  <div class="panel-body">
                  <?php
                  // echo $this->renderPartial('_formUpdateMasukKamar',array('form'=>$form,'modMasukKamar'=>$modMasukKamar));
                  echo $this->renderPartial('_formRujukanKeluar', array('form' => $form, 'modelPulang' => $modelPulang, 'modRujukanKeluar' => $modRujukanKeluar))
                  ?>
                  </div>
                  </div>
                 */
        ?>
        <div class="form-actions">
            <?php
            $disableSave = false;
            $disableSave = (!empty($_GET['id'])) ? true : (($tersimpan == 'Ya') ? true : false);
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php
            echo CHtml::htmlButton($modelPulang->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('id' => 'btn_submit_simpan', 'title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
            ?>
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            if (!(isset($_GET['meninggal']) && $_GET['meninggal'] == 1)) {
                $punyaPoliKontrol = !empty($modelPulang->pendaftaran->ruangankontrol_id);
                echo " " . CHtml::htmlButton(Yii::t('mds', '{icon} Print Kontrol', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => !$punyaPoliKontrol, 'type' => 'button', 'onclick' => 'printKontrol(\'PRINT\')'));
            }

            if (isset($_GET['pendaftaran_id'])) {
                $criteria = new CDbCriteria;
                $criteria->addCondition("pendaftaran_id=" . $_GET['pendaftaran_id']);
                $criteria->addCondition("nomorsurat_bpjs is not null");
                $criteria->order = "suratketerangan_id desc";
                $modSurat = SuratketeranganR::model()->find($criteria);
                if (empty($modSurat)) {
                    $disable = true;
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print SRK BPJS', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'disabled' => $disable));
                } else {
                    $disable = false;
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print SRK BPJS', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => "printSRK('$modSurat->pendaftaran_id')", 'disabled' => $disable));
                }
               
            }
            ?>
            <span class="box-resume">
                <?php 
                    echo CHtml::htmlButton(
                    
                        Yii::t('mds', '{icon} Print Resume', array('{icon}' => '<i class="entypo-print"></i>')),
                        array('class' => 'btn btn-success', 'type' => 'button', 'onclick' => 'printResume(' .$modPendaftaran->pendaftaran_id .')', 'disabled' => ($tersimpan != 'Ya') ? true : false)
                    );
                ?>
            
            </span>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->module->id . '/TindakLanjutDrTransaksi'), array(
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('TindakLanjutDrTransaksi') . '";} ); return false;'
            ));
            ?>
            <?php
            $content = $this->renderPartial('../tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php 
// dialog dignosa
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDiagnosa',
    'options' => array(
        'title' => 'Daftar Diagnosa',
        'autoOpen' => false,        
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'resizable' => false,
    ),
));

$this->renderPartial($this->path_view . 'diagnosaMeninggal/_dignosa');

$this->endWidget();
?>
<script type="text/javascript">
    function printSuratKematian(pendaftaran_id, suratketerangan_id) {
        window.open('<?php echo $this->createUrl('/pemulasaranJenazah/suratKeterangan/PrintSuratMeninggal') ?>' + '&pendaftaran_id=' + pendaftaran_id + '&suratketerangan_id=' + suratketerangan_id, 'printwin', 'left=100,top=100,width=700,height=450,scrollbars=1');
    }

    function printResume(pendaftaran_id) {
        window.open('<?php echo $this->createUrl('/rekamMedis/resumeMedis/print'); ?>&pendaftaran_id=' + pendaftaran_id, 'printwin', 'left=100,top=100,width=480,height=640');
    }
    
    function hapusDiagnosa(obj) {
        $(obj).parents('tr').detach();
    }

    function addRowDiagnosa(diagnosa_id, diagnosa_kode, diagnosa_nama, diagnosa_namalainnya) {
        var jumlahtr = $('#table-diagnosameninggal tbody tr').length;
        $.post('<?= $this->createUrl('addRowDiagnosa') ?>', {
            jumlahtr:jumlahtr,
            diagnosa_id:diagnosa_id,
            diagnosa_kode:diagnosa_kode,
            diagnosa_nama:diagnosa_nama,
            diagnosa_namalainnya:diagnosa_namalainnya
        }, function(data){
            $('#table-diagnosameninggal tbody').append(data.html)
        }, 'json');
    }

    $(document).ready(function() {
        // Notifikasi Pasien
        <?php
        if (isset($smspasien)) {
            if ($smspasien == 0) {
        ?>
                var params = [];
                params = {
                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                    modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                    judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                    isinotifikasi: 'Pasien <?php echo $modelPulang->pasien->nama_pasien; ?> tidak memiliki nomor mobile'
                }; // 16 
                insert_notifikasi(params);
        <?php
            }
        }
        ?>

        <?php
        if (isset($_GET['smspasien'])) {
            if ($_GET['smspasien'] == 0) {
        ?>
                var params = [];
                params = {
                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                    modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                    judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                    isinotifikasi: 'Pasien <?php echo $modelPulang->pasien->nama_pasien; ?> tidak memiliki nomor mobile'
                }; // 16 
                insert_notifikasi(params);
        <?php
            }
        }
        ?>

        <?php
        if (isset($modelPulang->pasienpulang_id)) {
        ?>
            //  var params = [];
            //  params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi: 'Pasien Pulang', isinotifikasi: '<?php echo $modelPulang->pasien->nama_pasien; ?> dengan <?php echo $modelPulang->pasien->no_rekam_medik; ?> telah pulang pada <?php echo $modelPulang->tglpasienpulang ?> dari <?php echo $modelPulang->ruangan_nama ?>'}; // 16 
            //        insert_notifikasi(params);
        <?php
        }
        ?>

        //if ('<?php //echo $cekPembayaran   
                ?>' == 'ada'){
        //	myAlert("Sisa tagihan pasien ini belum dibayarkan","Perhatian!");
        //}
    });
</script>
<?php $this->endWidget(); ?>
<?php
if ($tersimpan == 'Ya') {
?>
    <script>
        //parent.location.reload(); RND-6894
    </script>
<?php
}
?>
<script>
    function cekSebelumSubmit() {
        var carakeluar_id = $('#RIPasienPulangT_carakeluar_id').val();
        if(carakeluar_id == 4) {
            // jika cara keluar meninggal
            var jumlahtr = $('#table-diagnosameninggal tbody tr').length;
            if(jumlahtr < 1) {
                myAlert('Diagnosa kematian wajib ditambahkan!');
                return false;
            } else {
                // $('#pasienpulang-t-form').submit();
            }
        } else {
            // $('#pasienpulang-t-form').submit();
        }
    }

    function carakeluar(value) {
        if (value == "<?php echo Params::CARAKELUAR_ID_DIRUJUK ?>") {

            $('#divRujukan input').removeAttr('disabled');
            $('#divRujukan select').removeAttr('disabled');
            $('#divRujukan').slideToggle(500);
            $('#isDead').prop('checked', false);
            $('#isKontrol').prop('checked', false);
            $('#pakeRujukan').attr('checked', true);
            $('#pakeRujukan').attr('disabled', false);
            $('#isDead').attr('disabled', true);
            $('#isKontrol').attr('disabled', true);
            $("#<?php echo CHtml::activeId($modRujukanKeluar, 'pegawai_id') ?>").val($("#pegawaiPemeriksa").val());
            $("#<?php echo CHtml::activeId($modRujukanKeluar, 'ruanganasal_id') ?>").val($("#ruanganAsal").val());

        } else if (value == "<?php echo Params::CARAKELUAR_ID_MENINGGAL ?>") {
            var date = new Date();
            $('#pakeRujukan').removeAttr('checked');
            $('#divRujukan input').attr('disabled', 'true');
            $('#divRujukan select').attr('disabled', 'true');
            $('#divRujukan input').attr('value', '');
            $('#divRujukan select').attr('value', '');
            $('#divRujukan').hide(500);
            $('#RIPasienPulangT_tgl_meninggal').val('<?php echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-MM-dd HH:ii:ss'));?>');
            $('#isKontrol').attr('disabled', true);
            $('#isDead').prop('checked', true);
            $('#isDead').attr('disabled', false);
            $('#pakeRujukan').attr('disabled', true);
            $('#pakeRujukan').prop('checked', false);
            $('#isKontrol').prop('checked', false);
            $('.box-diagnosameninggal').show();
        } else if (value == "<?php echo Params::CARAKELUAR_ID_DIPULANGKAN ?>") {
            var date = new Date();
            $('#pakeRujukan').removeAttr('checked');
            $('#divRujukan input').attr('disabled', 'true');
            $('#divRujukan select').attr('disabled', 'true');
            $('#divRujukan input').attr('value', '');
            $('#divRujukan select').attr('value', '');
            $('#divRujukan').hide(500);
            $('#isKontrol').attr('disabled', false);
            $('#isDead').attr('disabled', true);
            $('#pakeRujukan').attr('disabled', true);
            $('#isDead').prop('checked', false);
            $('#pakeRujukan').prop('checked', false);
        } else {
            $('#pakeRujukan').removeAttr('checked');
            $('#divRujukan input').attr('disabled', 'true');
            $('#divRujukan select').attr('disabled', 'true');
            $('#divRujukan input').attr('value', '');
            $('#divRujukan select').attr('value', '');
            $('#divRujukan').hide(500);
            $('#isKontrol').attr('disabled', true);
            $('#isDead').attr('disabled', true);
            $('#pakeRujukan').attr('disabled', true);
            $('#isDead').prop('checked', false);
            $('#pakeRujukan').prop('checked', false);
            $('#isKontrol').prop('checked', false);
        }

        if(value != "<?php echo Params::CARAKELUAR_ID_MENINGGAL ?>") {
            $('.box-diagnosameninggal').hide();
        }

        if ($("#statusdokrm").val() == 'belum-dikembalikan') {
            $("#formKirimDok").val('ada');
            $(".boxkirimdokumen").show();
            $(".boxkirimdokumen").find("input, textarea, select").each(function() {
                $(this).attr("disabled", false);
            });
        } else {
            $("#formKirimDok").val('');
            $(".boxkirimdokumen").hide();
            $(".boxkirimdokumen").find("input, textarea, select").each(function() {
                $(this).attr("disabled", true);
            });
        }
    }

    function pasienmeninggal(value) {
        if (value == "<?php echo Params::KONDISIKELUAR_ID_MENINGGAL_1 ?>" || value == "<?php echo Params::KONDISIKELUAR_ID_MENINGGAL_2 ?>") {
            $('#isDead').attr('checked', true);
            $('#RIPasienPulangT_tgl_meninggal').removeAttr('disabled');
        } else {
            // $('#isDead').removeAttr('checked');
            //$('#RIPasienPulangT_tgl_meninggal').attr('disabled', 'true');
            $('#RIPasienPulangT_tgl_meninggal').removeAttr('disabled');
        }
    }
    $('#isDead').change(function() {
        if ($(this).is(':checked')) {
            $('#RIPasienPulangT_tgl_meninggal').removeAttr('disabled');
            $('#RIPasienPulangT_kondisipulang_id').val('<?php echo Params::KONDISIPULANG_MENINGGAL_1 ?>');
            $('#RIPasienPulangT_tgl_meninggal').val('<?php
                                                        echo Yii::app()->dateFormatter->formatDateTime(
                                                            CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-MM-dd HH:ii:ss')
                                                        );
                                                        ?>');
        } else {
            $('#RIPasienPulangT_tgl_meninggal').attr('disabled', 'true');
            $('#RIPasienPulangT_kondisipulang_id').val('');
            $('#RIPasienPulangT_tgl_meninggal').val('');

        }
    });

    function konfirmasi() {
        myConfirm("<?php echo Yii::t('mds', 'Do You want to cancel?') ?>", "Perhatian!", function(r) {
            if (r) {
                $('#dialogPasienPulang').dialog('close');
            } else {
                $('#RIPasienPulangT_carakeluar_id').focus();
                return false;
            }
        });
    }
    $('#isKontrol').change(function() {
        if ($(this).is(':checked')) {
            $('#RIPendaftaranT_tglrenkontrol, #RIPendaftaranT_ruangankontrol_id').removeAttr('disabled');
            //$('#RIPendaftaranT_tglrenkontrol').val('<?php //echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-MM-dd HH:ii:ss'));  
                                                        ?>');
            $("#RIPendaftaranT_ruangankontrol_id").addClass('required');
            $("#RIPendaftaranT_ruangankontrol_id").val('');
        } else {
            $('#RIPendaftaranT_tglrenkontrol, #RIPendaftaranT_ruangankontrol_id').attr('disabled', 'true');
            $('#RIPendaftaranT_tglrenkontrol').val('');
            $("#RIPendaftaranT_ruangankontrol_id").val('');
            $("#RIPendaftaranT_ruangankontrol_id").removeClass('required');
        }
    });

    function cekValidasi(obj) {
        var kontrol = $('#isKontrol');
        var rujukan = $('#pakeRujukan');
        var tglren = $("#RIPendaftaranT_tglrenkontrol");
        var ruren = $("#RIPendaftaranT_ruangankontrol_id");

        var carakeluar = $("#RIPasienPulangT_carakeluar_id");
        var kondisikeluar = $("#RIPasienPulangT_kondisikeluar_id");

        var insdok = $("#PengirimanrmT_instalasi_id").val();
        var rudok = $("#PengirimanrmT_ruangan_id").val();
        var adadok = $("#formKirimDok").val();

        if (kontrol.is(':checked')) {
            if (ruren.val() == '') {
                ruren.attr('style', 'border:red 1px solid');
                myAlert("Maaf, polik kontrol belum diisi", 'Perhatian!');
                return false;
            } else {
                ruren.attr('style', '');
                //$(obj).submit();
            }

            if (tglren.val() == '') {
                tglren.attr('style', 'border:red 1px solid');
                myAlert("Maaf, tanggal rencana kontrol belum diisi", 'Perhatian!');
                return false;
            } else {
                tglren.attr('style', '');
                //$(obj).submit();
            }
        } else {
            //$(obj).submit();
        }

        var jumlahtr = $('#table-diagnosameninggal tbody tr').length;
        if(jumlahtr < 1 && carakeluar.val() == 4) {
            myAlert('Diagnosa kematian wajib ditambahkan!');
            return false;
        }


        if (carakeluar.val() == '') {
            carakeluar.attr('style', 'border:red 1px solid');
        } else {
            carakeluar.attr('style', '');
        }

        if (kondisikeluar.val() == '') {
            kondisikeluar.attr('style', 'border:red 1px solid');
        } else {
            kondisikeluar.attr('style', '');
        }

        if (adadok == 'ada') {
            if (insdok === "") {
                myAlert("Instalasi Tujuan Dokumen Rekam Medis harus diisi ");
                return false;
            }

            if (rudok === "") {
                myAlert("Ruangan Tujuan Dokumen Rekam Medis harus diisi ");
                return false;
            }
        }

        if (carakeluar.val() == '' || kondisikeluar.val() == '') {
            myAlert("Maaf, Cara Keluar dan Kondisi Keluar wajib diisi", 'Perhatian!')

            return false;
        } else {
            if (rujukan.is(':checked')) {
                if (requiredCheck($("#pasienpulang-t-form"))) {

                } else {
                    return false;
                }
            } else {
                $("#btn_submit_simpan").prop("disabled", true);
                $(obj).submit();
            }

            //$(obj).submit();
        }
    }

    /**
     * untuk print pasien pulang
     */
    function print(caraPrint) {
        var pasienpulang_id = '<?php echo isset($modelPulang->pasienpulang_id) ? $modelPulang->pasienpulang_id : null ?>';
        window.open('<?php echo $this->createUrl('printPasienPulang'); ?>&pasienpulang_id=' + pasienpulang_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    // function printKontrol(caraPrint) {
    //     var pasienpulang_id = '<?php //echo isset($modelPulang->pasienpulang_id) ? $modelPulang->pasienpulang_id : null 
                                    ?>';
    //     window.open('<?php //echo $this->createUrl('printPasienKontrol'); 
                        ?>&pasienpulang_id=' + pasienpulang_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    // }

    function printKontrol(caraPrint) {
        var pasienadmisi_id = '<?php echo isset($admisi->pasienadmisi_id) ? $admisi->pasienadmisi_id : null ?>';

        window.open('<?php echo $this->createUrl('printPasienKontrolRencana'); ?>&pasienadmisi_id=' + pasienadmisi_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    /**
     * 
     * @param {type} obj
     * @returns {menampilkan field tanggal kontrol}
     */

    function openTglKontrol(obj) {
        var ruangan = $(obj).val();

        if (ruangan == '') {
            $("#tanggal_kontrol").attr('style', 'display:none;');
            $("#<?php echo CHtml::activeId($modPendaftaran, 'tglrenkontrol') ?>").val('');
        } else {
            $("#tanggal_kontrol").attr('style', 'display:block;');
            $("#<?php echo CHtml::activeId($modPendaftaran, 'tglrenkontrol') ?>").val('');
        }
    }

    /**
     * - digunakan untuk memeriksa jam buka jadwal Poli
     * @param {type} obj
     * @returns {cek validasi, jika tanggal lebih dari hari ini, dan jam buka poli tidak lebih dari jam akhir buka dan tidak kurang dari jam awal buka}
     */
    function cekJadwalPoli(tanggal) {
        //function cekJadwalPoli(obj){
        var waktu = tanggal;
        var ruangan = $("#<?php echo CHtml::activeId($modPendaftaran, 'ruangankontrol_id') ?>").val();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('cekJadwalPoli'); ?>',
            data: {
                waktu: waktu,
                ruangan_id: ruangan
            },
            dataType: "json",
            success: function(data) {
                if (data.sukses == 0) {
                    $("#<?php echo CHtml::activeId($modPendaftaran, 'tglrenkontrol') ?>").val('');
                    //myAlert(data.pesan);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setHitungLamaRawat() {
        var pasienadmisi_id = $("#<?php echo CHtml::activeId($modelPulang, 'pasienadmisi_id') ?>").val();
        var tglpasienpulang = $("#<?php echo CHtml::activeId($modelPulang, 'tglpasienpulang') ?>").val();

        if (pasienadmisi_id != '' && tglpasienpulang != '') {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('setHitungLamaRawat'); ?>',
                data: {
                    pasienadmisi_id: pasienadmisi_id,
                    tglpasienpulang: tglpasienpulang
                },
                dataType: "json",
                success: function(data) {
                    if (data.sukses > 0) {
                        $("#<?php echo CHtml::activeId($modMasukKamar, 'lamadirawat_kamar') ?>").val(data.lamadirawat_kamar);
                        $("#<?php echo CHtml::activeId($modelPulang, 'hariperawatan') ?>").val(data.hariperawatan);
                    } else {
                        $("#<?php echo CHtml::activeId($modMasukKamar, 'lamadirawat_kamar') ?>").val(0);
                        $("#<?php echo CHtml::activeId($modelPulang, 'hariperawatan') ?>").val(0);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    $(document).ready(function() {
        $('#isDead').attr('disabled', true);
        $('#isKontrol').attr('disabled', true);
        $('#pakeRujukan').attr('disabled', true);
    });

    $('#isDead').change(function() {
        if ($(this).is(':checked')) {
            $('#RIPasienPulangT_carakeluar_id').val('<?php echo Params::CARAKELUAR_ID_MENINGGAL ?>');
        } else {
            $('#RIPasienPulangT_carakeluar_id').val('');
        }
    });

    function printSRK(id) {
        window.open('<?php echo $this->createUrl('/rawatJalan/daftarPasien/printRencanaKontrolBpjs'); ?>&pendaftaran_id=' + id + '&caraPrint=PRINT', 'printwin', 'left=100,top=100,width=860,height=480');
    }
</script>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDaftarPasien',
    'options' => array(
        'title' => 'Daftar Pasien',
        'autoOpen' => false,
        'resizable' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
    ),
));

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarpasien-v-grid',
    'dataProvider' => $modPasienRIV->searchRIDialog(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed',
    'filter' => $modPasienRIV,
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            $(\"#dialogDaftarPasien\").dialog(\"close\");

                                            $(\"#RIInfopasienmasukkamarV_tgl_pendaftaran\").val(\"$data->tgl_pendaftaran\");
                                            $(\"#RIInfopasienmasukkamarV_no_pendaftaran\").val(\"$data->no_pendaftaran\");
                                            $(\"#RIInfopasienmasukkamarV_umur\").val(\"$data->umur\");

                                            $(\"#RIInfopasienmasukkamarV_jeniskasuspenyakit_nama\").val(\"$data->jeniskasuspenyakit_nama\");

                                            $(\"#RIInfopasienmasukkamarV_jeniskelamin\").val(\"$data->jeniskelamin\");
                                            $(\"#RIInfopasienmasukkamarV_no_rekam_medik\").val(\"$data->no_rekam_medik\");
                                            $(\"#RIInfopasienmasukkamarV_nama_pasien\").val(\"$data->nama_pasien\"); 
                                            $(\"#RIInfopasienmasukkamarV_nama_bin\").val(\"$data->nama_bin\");
                                            $(\"#RIMasukKamarT_tglmasukkamar\").val(\"$data->tglmasukkamar\");
                                            $(\"#RIMasukKamarT_masukkamar_id\").val(\"$data->masukkamar_id \");
                                            $(\"#RIMasukKamarT_lamadirawat_kamar\").val(\"$data->LamaRawat\");
                                            $(\"#RIPasienPulangT_pendaftaran_id\").val(\"$data->pendaftaran_id \");
                                            $(\"#RIPasienPulangT_pasien_id\").val(\"$data->pasien_id \");
                                            $(\"#RIPasienPulangT_pasienadmisi_id\").val(\"$data->pasienadmisi_id \");

                                        "))',
        ),
        'no_rekam_medik',
        'tgl_pendaftaran',
        'no_pendaftaran',
        'nama_pasien',
        array(
            'header' => 'Alias',
            'type' => 'raw',
            'value' => '"$data->nama_bin"',
        ),
        array(
            'header' => 'Penjamin' . '/<br>' . 'Jenis Penjamin',
            'type' => 'raw',
            'value' => '"$data->penjamin_nama"."<br>"."$data->carabayar_nama"',
        ),
        array(
            'header' => 'Nama Dokter',
            'type' => 'raw',
            'name' => 'nama_pegawai',
            'value' => '"$data->nama_pegawai"',
        ),
        // 'ruangan_nama',
        'jeniskasuspenyakit_nama',
        // 'statusperiksa',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>