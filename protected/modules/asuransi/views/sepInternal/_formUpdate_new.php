<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'assep-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    //	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'),
    'focus' => '#',
));
?>
<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "SEP berhasil disimpan !");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row-fluid" id="content-bpjs">
    <div class="span6">

        <?php echo $form->hiddenField($modAsuransiPasien, 'nokartuasuransi', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'no_rekam_medik', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($modAsuransiPasien, 'nopeserta', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($modAsuransiPasien, 'tglcetakkartuasuransi', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($modAsuransiPasien, 'kelastanggunganasuransi_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($modAsuransiPasien, 'jenispeserta_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'namaasuransi_cob', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'no_asuransi_cob', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'hakkelas_kode', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'nama_diagnosaawal', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php 
        if (!empty($modPendaftaran->pasienadmisi_id)) {
            $kelas = $modPendaftaran->admisi->kelaspelayanan_id;
        } else {
            $kelas = $modPendaftaran->kelaspelayanan_id;
        }
        echo CHtml::hiddenField('kelaspelayanan_id', $kelas); 
        ?>


        <?php
        if ($modPendaftaran->instalasi_id == Params::INSTALASI_ID_RD && empty($modPendaftaran->pasienadmisi_id)) {
            $display = 'none';
            $required = "";
        } else {
            $display = 'block';
            $required = "required";
        }
        ?>
        <div class="control-group ">
            <?php echo $form->labelEx($model,'tglsep', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'tglsep', array('class'=>'span3', 'readonly'=>true)); ?>

            </div>
        </div>

        <div id="rujukanBpjs" style="display:<?= $display ?>">
            <div class="control-group ">
                <?php echo CHtml::label("Jenis/Asal Rujukan", 'no_rujukan', array('class' => 'control-label')) ?>
                <div class="controls form-inline">
                    <?php
                    echo $form->radioButtonList($model, 'jenispeserta_id', array("1" => "PCare&nbsp;&nbsp;", "2" => "Rumah Sakit"), array('onkeyup' => "return $(this).focusNextInputField(event)"));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("No.Rujukan Faskes <span class='required'>*</span>", 'no_rujukan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modRujukanBpjs, 'no_rujukan', array('placeholder' => 'No. Rujukan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo CHtml::link("<i class='icon-search'></i>", 'javascript:void(0)', array("rel" => "tooltip", "title" => "klik untuk mengecek rujukan", "onclick" => "getRujukanNoRujukan($('#" . CHtml::activeId($modRujukanBpjs, "no_rujukan") . "').val());return true;")); ?>
                    <?php echo $form->error($modRujukanBpjs, 'no_rujukan'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label <?= $required ?>">
                    Tanggal Rujukan
                    <span class="required">*</span>
                </label>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modRujukanBpjs,
                        'attribute' => 'tanggal_rujukan',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'showOn' => false,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('class' => 'dtPicker2 span3', 'onkeyup' => "return $(this).focusNextInputField(event)",),
                    ));
                    ?>
                    <?php echo $form->error($modRujukanBpjs, 'tanggal_rujukan'); ?>
                </div>
            </div>
        </div>
        <?php echo $form->dropDownListRow($model, 'jnspelayanan', array('2' => 'Rawat Jalan', '1' => 'Rawat Inap'), array('empty' => '--Pilih--', 'class' => 'span3', 'disabled' => true)); ?>
        

        <div class="control-group">
            <?php echo CHtml::label("No. Kartu BPJS <span class='required'>*</span> ", 'nopeserta', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nopeserta', array('readonly' => true, 'placeholder' => 'Ketik No. Peserta', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->error($model, 'nopeserta'); ?>
                <?php echo $form->hiddenField($model, 'asuransipasien_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
            </div>
        </div>


        <div class="control-group ">
            <label class="control-label">
                No. SEP
            </label>
            <div class="controls">
                <?php echo $form->textField($model, 'nosep', array('placeholder' => 'No. SEP Otomatis', 'class' => 'span3', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->error($model, 'nosep'); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modAsuransiPasien, 'namapemilikasuransi', array('placeholder' => 'Nama Lengkap Pemilik Asuransi', 'class' => 'span3', 'readonly' => empty($modAsuransiPasien->namapemilikasuransi) ? false : true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <div class="control-group ">
            <?php echo $form->labelEx($modAsuransiPasien,'jenispeserta_id', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($modAsuransiPasien,'jenispersertakode_bpjs'); ?>
                <?php echo $form->textField($modAsuransiPasien,'jenispeserta_bpjs', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php // echo $form->dropDownList($modAsuransiPasien,'jenispeserta_id', CHtml::listData($modAsuransiPasien->getJenisPesertaItems(), 'jenispeserta_id', 'jenispeserta_nama'), 
        //                                      array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",
        //                                            )); ?>

                <?php // echo $form->error($modAsuransiPasien, 'jenispeserta_id'); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label("Kelas Tanggungan Asuransi <span class='required'>*</span>", 'kelastanggungan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'klsrawat', array('1' => 'Kelas I', '2' => 'Kelas II', '3' => 'Kelas III'), array(
                    'empty' => '-Pilih-', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)",
                ));
                ?>
            </div>
        </div>

        <?php echo $form->hiddenField($model, 'klsrawat', array()); ?>
        <?php 
            echo $form->hiddenField($model, 'klsRawatNaik');
            echo $form->dropDownListRow($model,'penanggungjwb_naikkls_id', CHtml::listData(PenjaminpasienM::model()->findAllByAttributes(array(
                'is_penanggungjwbnaikklsbpjs'=>true,
            ), array(
                'order'=>'penjamin_nama'
            )), 'penjamin_id', 'penjamin_nama') ,array('disabled'=>true,'empty'=>'-- Pilih --','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        <div class="control-group">
            <label class="control-label">Prolanis PRB</label>
            <div class="controls">
                <?php echo CHtml::textField("bpjs_prolanis", "-", array('readonly'=>true, 'class'=>'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Dinsos</label>
            <div class="controls">
                <?php echo CHtml::textField("bpjs_dinsos", "-", array('readonly'=>true, 'class'=>'span3')); ?>
            </div>
        </div>
        <div class="control-group " hidden>
            <?php echo CHtml::label("Kode PPK Pelayanan", 'ppkpelayanan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'ppkpelayanan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'maxlength' => 50)); ?>
            </div>
        </div>
        
        <div class="control-group " hidden>
            <?php echo CHtml::label("Nama PPK Pelayanan", 'ppkpelayanan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'ppkpelayanan_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'maxlength' => 50)); ?>
            </div>
        </div>
        

        <div class="control-group">
            <?php echo CHtml::label("Kode PPK Rujukan <span class='required'>*</span>", 'no_rujukan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'ppkrujukan',
                    'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('AutocompleteItemSEP') . '",
                                    dataType: "json",
                                    data: {
                                        term: request.term,
                                        item: "ppk",
                                    },
                                    success: function (data) {
                                        response(data);
                                    }
                                })
                            }',
                    'options' => array(
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.kode);
                                    return false;
                                }',
                        'select' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.kode);
                                    $("#' . CHtml::activeId($model, 'ppkrujukan_nama') . '").val(ui.item.nama);
                                    return false;
                                }',
                    ),
                    'htmlOptions' => array(
                        'readonly'=>true, 'placeholder' => 'Ketik Kode PPK', 'rel' => 'tooltip', 'title' => 'Ketik kode ppk untuk mencari data ppk', 'class' => 'span3 required',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Nama PPK Rujukan <span class='required'>*</span>", 'no_rujukan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'ppkrujukan_nama',
                    'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('AutocompleteItemSEP') . '",
                                    dataType: "json",
                                    data: {
                                        term: request.term,
                                        item: "ppk",
                                    },
                                    success: function (data) {
                                        response(data);
                                    }
                                })
                            }',
                    'options' => array(
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.nama);
                                    return false;
                                }',
                        'select' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.nama);
                                    $("#' . CHtml::activeId($model, 'ppkrujukan') . '").val(ui.item.kode);
                                    return false;
                                }',
                    ),
                    'htmlOptions' => array(
                        'readonly'=>true, 'placeholder' => 'Ketik Nama PPK', 'rel' => 'tooltip', 'title' => 'Ketik nama ppk untuk mencari data ppk', 'class' => 'span3 required',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="span6">

        <div class="control-group">
            <?php echo CHtml::label("Diagnosa Awal <span class='required'>*</span>", 'no_rujukan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'diagnosaawal',
                    'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('AutocompleteItemSEP') . '",
                                dataType: "json",
                                data: {
                                    term: request.term,
                                    item: "diagnosa",
                                },
                                success: function (data) {
                                    response(data);
                                }
                            })
                        }',
                    'options' => array(
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                                $(this).val(ui.item.kode);
                                return false;
                            }',
                        'select' => 'js:function( event, ui ) {
                                $(this).val(ui.item.kode);
                                $("#' . CHtml::activeId($model, 'nama_diagnosaawal') . '").val(ui.item.nama);
                                return false;
                            }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Ketik Nama Diagnosa', 'rel' => 'tooltip', 'title' => 'Ketik diagnosa untuk mencari data diagnosa', 'class' => 'span3 required',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                ));
                ?>
                <?php echo $form->hiddenField($model, 'nama_diagnosaawal', array('placeholder' => 'Diagnosa Awal', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Spesialis/Subspesialis</label>
            <div class="controls">
                <?php echo $form->textField($model, 'politujuan', array('readonly'=>true, 'class'=>'span3')); ?>
                <?php 
                $model->poli_eksekutif = $model->poli_eksekutif ?? "0";
                echo $form->radioButtonListRow($model, 'poli_eksekutif', array(
                    "1" => 'Ya', "0" => 'Tidak'
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'jenis_kunjungan', array('class'=>'control-label', 'label'=>'Jenis Kunjungan <span class="required">*</span>')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jenis_kunjungan', LookupM::getItemsUrutan('bpjs_jnskunjungan'), array(
                    'empty'=>'-- Pilih --', 'class'=>'span3', 'onchange'=>'pilihJenisKunjunganBPJS();'
                )); ?>
                <?php echo $form->dropDownListRow($model, 'flag_procedure', LookupM::getItemsUrutan('bpjs_flagprocedure'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?>
                <?php echo $form->dropDownListRow($model, 'kode_penunjang', LookupM::getItemsUrutan('bpjs_kdpenunjang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'asesmen_pelayanan', array('class'=>'control-label', 'label'=>'Asesmen Pelayanan')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'asesmen_pelayanan', LookupM::getItemsUrutan('bpjs_asesmenpelayanan'), array('empty'=>'-- Pilih --', 'class'=>'span3')); ?>
            </div>
        </div>
        <div id="skdp">
            <?php 
            $act = strtolower($this->id);
            if($modPendaftaran->instalasi_id != Params::INSTALASI_ID_RD) { 
                
                $act = strtolower($this->id);
                $judul = "";
                $label_no_surat = "Nomor Surat Kontrol";
                $label_dpjp_kontrol = "DPJP Pemberi Surat Kontrol";


                if (in_array($act, array("pendaftaranrawatinapdarirjrd", "pendaftaranbayibarulahir"))) {
                    $judul = "SPRI";
                    $label_no_surat = "No. SPRI";
                    $label_dpjp_kontrol = "DPJP Pemberi SPRI";
                }

                echo "<strong>".$judul."</strong>";
                
                ?>
            <div class="control-group">
                <?php echo CHtml::label($label_no_surat, 'Nomor Surat Kontrol', array('class'=>'control-label'))?>
                <div class="controls">
                        <?php echo $form->textField($model,'no_surat',array('readonly'=>true,'placeholder'=>$label_no_surat,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30, 'rel'=>'tooltip', 'title'=>'Isi jika pasien dengan surat kontrol')); ?>
                        <?php //echo CHtml::link("<i class='icon-search'></i>",'javascript:void(0)',array("rel"=>"tooltip","title"=>"klik untuk car Surat Kontrol Pasien","onclick"=>"cariSuratKontrol(); return true;"));?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label($label_dpjp_kontrol, 'nama_dpjp', array('class'=>'control-label'))?>
                <div class="controls">
                    <?php echo $form->textField($model,'nama_dpjp',array('readonly'=>true,'placeholder'=>$label_dpjp_kontrol,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'rel'=>'tooltip', 'title'=>'Isi jika pasien dengan surat kontrol','onblur'=>"if($(this).val()=='') $('#".CHtml::activeId($model, 'kode_dpjp')."').val('')")); ?>
                    <?php //echo CHtml::link("<i class='icon-search'></i>",'javascript:void(0)',array("rel"=>"tooltip","title"=>"klik untuk cari DPJP","onclick"=>"$('#dialogDpjp').dialog('open');return true;"));?>
                    <?php echo $form->hiddenField($model,'kode_dpjp',array('placeholder'=>'Dokter DPJP','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="control-group">
                <?php 
                $dpjp_req = "";
                if (in_array($act, array("pendaftaranrawatjalan", "pendaftaranrawatdarurat"))) { //, 'pendaftaranpersalinan'))) {
                    echo CHtml::label('DPJP yang Melayani <span class="required">*</span>', 'nama_dpjp', array('class'=>'control-label'));
                    $dpjp_req = "required";
                } else {
                    echo CHtml::label("DPJP yang Melayani", 'nama_dpjp', array('class'=>'control-label'));
                }
                ?>
                <div class="controls">
                    <?php echo $form->textField($model,'dpjpygmelayani_nama',array('placeholder'=>'Dokter DPJP','class'=>'span3 '.$dpjp_req, 'onkeyup'=>"return $(this).focusNextInputField(event);", 'rel'=>'tooltip', 'title'=>'Isi jika pasien dengan surat kontrol','onblur'=>"if($(this).val()=='') $('#".CHtml::activeId($model, 'kode_dpjp')."').val('')")); ?>
                    <?php echo CHtml::link("<i class='icon-search'></i>",'javascript:void(0)',array("rel"=>"tooltip","title"=>"klik untuk cari DPJP","onclick"=>"$('#dialogDpjpMelayani').dialog('open');return true;"));?>
                    <?php echo $form->hiddenField($model,'dpjpygmelayani_kode',array('placeholder'=>'Dokter DPJP','class'=>'span3 '.$dpjp_req, 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                </div>
        </div>
        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
                <?php echo $form->checkBox($model,'cob').CHtml::label('COB', ''); ?>
            </div>
	    </div>
        <div class="control-group form-inline">
            <?php echo CHtml::label("Katarak", 'Katarak', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->radioButtonList($model, 'katarak', array("1" => "YA&nbsp;&nbsp;", "0" => "TIDAK"), array('onkeyup' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("No. Telepon Peserta <span class='required'>*</span>", 'no_telpon_peserta', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'no_telpon_peserta', array('placeholder' => 'Telepon peserta', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("User Pembuat SEP", 'pembuat_sep', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pembuat_sep', array('readonly' => true, 'placeholder' => 'Pembuat SEP', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <?php echo $form->textAreaRow($model, 'catatansep', array('placeholder' => '', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        <div class="control-group">
            <?php echo CHtml::label('Status Kecelakaan <span class="required">*</span>', '', array('class'=>'control-label'))?>
            <div class="controls">
                <?php 
                echo $form->dropDownList($model,'statuskecelakaan_kode',LookupM::getItemsUrutan('bpjs_statuskecelakaan'), array('empty'=>'-- Pilih --','class'=>'span3')); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php
    $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
    $disabledSave = isset($_GET['id']) ? true : (($sukses == 1) ? true : false);
    ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disabledSave, 'onclick' => 'cekInput(this,14);return false;')); ?>

</div>
<?php $this->endWidget(); ?>
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs)); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPoli',
    'options' => array(
        'title' => 'Referensi Poli BPJS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial($this->path_view . '_pencarianPoli');
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDiagnosaBpjs',
    'options' => array(
        'title' => 'Referensi Diagnosa BPJS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial($this->path_view . '_pencarianDiagnosa');
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPpk',
    'options' => array(
        'title' => 'Referensi PPK Rujukan/Faskes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial($this->path_view . '_pencarianPpk');
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSuplesi',
    'options' => array(
        'title' => 'Pencarian Suplesi Jasa Raharja',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial($this->path_view . '_pencarianSuplesi');
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDpjp',
    'options' => array(
        'title' => 'Pencarian Dokter DPJP',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial($this->path_view . '_pencarianDpjp');
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDpjpMelayani',
    'options' => array(
        'title' => 'Pencarian Dokter DPJP yang Melayani',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial($this->path_view . '_pencarianDpjpMelayani');
$this->endWidget();
?>

<script>


    function setKodeRuanganBPJS() {
        var ruangan_id = $("#PPPendaftaranT_ruangan_id").val();

        $.post('<?php echo $this->createUrl('getRuanganSpesialisBPJS') ?>', {
            ruangan_id: $(this).val(),
        }, function(data) {
            if (data.ok == 1) {
                $("#ARSepT_politujuan").val(data.kode);
            }
        }, 'json');
    }

    function pilihJenisKunjunganBPJS() {
        var jenis = $("#ARSepT_jenis_kunjungan").val();

        if (jenis == "0") {
            $("#ARSepT_flag_procedure").val(null).prop("readonly", true).prop("disabled", true);
            $("#ARSepT_kode_penunjang").val(null).prop("readonly", true).prop("disabled", true);
        } else {
            $("#ARSepT_flag_procedure").prop("readonly", false).prop("disabled", false);
            $("#ARSepT_kode_penunjang").prop("readonly", false).prop("disabled", false);
        }

        if (jenis == "2" || jenis == "0") {
            $("#ARSepT_asesmen_pelayanan").val(4);
        }
    }

    $(document).ready(function() {
        pilihJenisKunjunganBPJS();
    });

</script>