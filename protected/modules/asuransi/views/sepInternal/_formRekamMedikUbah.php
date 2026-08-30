<?php
$readonly = FALSE;
?>
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <?php echo CHtml::label("Instalasi <font style=color:red;> * </font>", 'instalasi_id', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php
                if (!empty($modInfoKunjungan->pendaftaran_id)) {
                    echo CHtml::hiddenField('instalasi_id', $modInfoKunjungan->instalasi_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                    echo CHtml::textField('instalasi_nama', $modInfoKunjungan->instalasi_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                } else {
                    echo CHtml::dropDownList('instalasi_id', $modInfoKunjungan->instalasi_id, CHtml::listData(ARInstalasiM::model()->getInstalasiPelayanans(), 'instalasi_id', 'instalasi_nama'), array('onchange' => 'setInfoPasienReset();refreshDialogInfoPasien();', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)",));
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::hiddenField('pendaftaran_id', $modInfoKunjungan->pendaftaran_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::hiddenField('instalasiasal_id', $modInfoKunjungan->pendaftaran_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php
            $pasienadmisi_id = (isset($modInfoKunjungan->pasienadmisi_id) ? $modInfoKunjungan->pasienadmisi_id : null);
            echo CHtml::hiddenField('pasienadmisi_id', $pasienadmisi_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
            ?>
            <?php echo CHtml::label("Barcode", 'cari_pendaftaran_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('cari_pendaftaran_id', $modInfoKunjungan->pendaftaran_id, array('onchange' => "if($(this).val()=='') setKunjunganReset(); else setKunjungan(this.value,'','','')", 'class' => 'span3', 'placeholder' => 'Scan Barcode Pada Print Status', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => $readonly)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Nama Pasien <font style=color:red;> * </font>", 'nama_pasien', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('namadepan', $modInfoKunjungan->namadepan, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php
                if ($readonly) {
                    echo CHtml::textField('nama_pasien', $modInfoKunjungan->nama_pasien, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => $readonly));
                } else {
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'nama_pasien',
                        'value' => $modInfoKunjungan->nama_pasien,
                        'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompleteInfoPasien') . '",
										   dataType: "json",
										   data: {
											   nama_pasien: request.term,
											   instalasi_id: $("#instalasi_id").val(),
										   },
										   success: function (data) {
												   response(data);
										   }
									   })
									}',
                        'options' => array(
                            'minLength' => 3,
                            'focus' => 'js:function( event, ui ) {
									 $(this).val( "");
									 return false;
								 }',
                            'select' => 'js:function( event, ui ) {
									$(this).val( ui.item.value);
									setInfoPasien(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
									return false;
								}',
                        ),
                        'htmlOptions' => array(
                            'class' => 'span3', 'placeholder' => 'Ketik Nama Pasien', 'rel' => 'tooltip', 'title' => 'Ketik nama pasien untuk mencari data kunjungan',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                        ),
                    ));
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tanggal Lahir', 'tanggal_lahir', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('tanggal_lahir', $modInfoKunjungan->tanggal_lahir, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Umur", 'umur', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('umur', $modInfoKunjungan->umur, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Jenis Kelamin", 'jeniskelamin', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('jeniskelamin', $modInfoKunjungan->jeniskelamin, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Alamat Pasien", 'alamat_pasien', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textArea('alamat_pasien', $modInfoKunjungan->alamat_pasien, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group no_pendaftaran">
            <?php echo CHtml::label("No. Pendaftaran <font style=color:red;> * </font>", 'no_pendaftaran', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php
                if ($readonly) {
                    echo CHtml::textField('no_pendaftaran', $modInfoKunjungan->no_pendaftaran, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => $readonly));
                } else {
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'no_pendaftaran',
                        'value' => $modInfoKunjungan->no_pendaftaran,
                        'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompleteInfoPasien') . '",
										   dataType: "json",
										   data: {
											   no_pendaftaran: request.term,
											   instalasi_id: $("#instalasi_id").val(),
										   },
										   success: function (data) {
												   response(data);
										   }
									   })
									}',
                        'options' => array(
                            'minLength' => 3,
                            'focus' => 'js:function( event, ui ) {
									 $(this).val( "");
									 return false;
								 }',
                            'select' => 'js:function( event, ui ) {
									$(this).val( ui.item.value);
									setInfoPasien(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
									return false;
								}',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPasien'),
                        'htmlOptions' => array(
                            'placeholder' => 'Ketik No. Pendaftaran', 'class' => 'span3 all-caps', 'rel' => 'tooltip', 'title' => 'Ketik no. pendaftaran / klik icon untuk mencari data kunjungan',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                        ),
                    ));
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("No. Rekam Medik <font style=color:red;> * </font>", 'no_rekam_medik', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('pasien_id', $modInfoKunjungan->pasien_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php // echo CHtml::textField('no_rekam_medik',$modInfoKunjungan->no_rekam_medik,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php
                if ($readonly) {
                    echo CHtml::textField('no_rekam_medik', $modInfoKunjungan->no_rekam_medik, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => $readonly));
                } else {
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'no_rekam_medik',
                        'value' => $modInfoKunjungan->no_rekam_medik,
                        'source' => 'js: function(request, response) {
								   $.ajax({
									   url: "' . $this->createUrl('AutocompleteInfoPasien') . '",
									   dataType: "json",
									   data: {
										   no_rekam_medik: request.term,
										   instalasi_id: $("#instalasi_id").val(),
									   },
									   success: function (data) {
											   response(data);
									   }
								   })
								}',
                        'options' => array(
                            'minLength' => 3,
                            'focus' => 'js:function( event, ui ) {
								 $(this).val( "");
								 return false;
							 }',
                            'select' => 'js:function( event, ui ) {
								$(this).val( ui.item.value);
								setInfoPasien(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
								return false;
							}',
                        ),
                        'htmlOptions' => array(
                            'placeholder' => 'Ketik No. Rekam Medik', 'rel' => 'tooltip', 'title' => 'Ketik no. rekam medik untuk mencari data kunjungan',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'class' => 'numbers-only span3',
                        ),
                    ));
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tgl. Pendaftaran', 'tgl_pendaftaran', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('tgl_pendaftaran', $modInfoKunjungan->tgl_pendaftaran, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php //echo CHtml::hiddenField('tglselesaiperiksa',$modInfoKunjungan->tglselesaiperiksa,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Poliklinik / Ruangan", 'ruangan_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $ruangan_id = null;
                if (isset($modInfoKunjungan->ruangan_id)) {
                    $ruangan_id = $modInfoKunjungan->ruangan_id;
                }

                echo CHtml::hiddenField('ruangan_id', $ruangan_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
                <?php echo CHtml::textField('ruangan_nama', $modInfoKunjungan->ruangan_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Kelas Pelayanan", 'kelaspelayanan_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('kelaspelayanan_id', $modInfoKunjungan->kelaspelayanan_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::textField('kelaspelayanan_nama', $modInfoKunjungan->kelaspelayanan_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::hiddenField('carabayar_id', Params::CARABAYAR_ID_BPJS, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->labelEx($model, 'Jenis Penjamin', array('class' => 'control-label refreshable')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                    'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('SetDropdownPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                        'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data);}',
                    ),
                    'class' => 'span3', 'disabled' => 'disabled',
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::hiddenField('penjamin_id', Params::CARABAYAR_ID_BPJS, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->labelEx($model, 'Penjamin', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array(
                    'empty' => '-- Pilih --',
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    'class' => 'span3', 'disabled' => 'disabled',
                ));
                ?>
            </div>
        </div>
        <div align="center">
            <?php
            $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory() . "kecil_" . $modPasien->photopasien : Params::urlPhotoPasienDirectory() . "no_photo.jpeg");
            ?>
            <img id="photo-preview" src="<?php echo $url_photopasien ?>" width="128px" />
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Data Kunjungan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 480,
        'resizable' => false,
    ),
));
$modDialogKunjungan = new ARPasienM('searchDialogKunjungan');
$modDialogKunjungan->unsetAttributes();

$modDialogKunjungan->instalasi_id = Params::INSTALASI_ID_RJ;
// $modDialogKunjungan->tgl_pendaftaran = date('m/d/Y') . ' - ' . date('m/d/Y');

if (isset($_GET['ARPasienM'])) {
    $modDialogKunjungan->attributes = $_GET['ARPasienM'];
    $modDialogKunjungan->instalasi_id = (isset($_GET['ARPasienM']['instalasi_id']) ? $_GET['ARPasienM']['instalasi_id'] : null);
    $modDialogKunjungan->no_pendaftaran = (isset($_GET['ARPasienM']['no_pendaftaran']) ? $_GET['ARPasienM']['no_pendaftaran'] : "");
    $modDialogKunjungan->tgl_pendaftaran = (isset($_GET['ARPasienM']['tgl_pendaftaran']) ? $_GET['ARPasienM']['tgl_pendaftaran'] : "");
    $modDialogKunjungan->instalasi_nama = (isset($_GET['ARPasienM']['instalasi_nama']) ? $_GET['ARPasienM']['instalasi_nama'] : "");
    $modDialogKunjungan->carabayar_nama = (isset($_GET['ARPasienM']['carabayar_nama']) ? $_GET['ARPasienM']['carabayar_nama'] : "");
    $modDialogKunjungan->ruangan_nama = (isset($_GET['ARPasienM']['ruangan_nama']) ? $_GET['ARPasienM']['ruangan_nama'] : "");
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'datakunjungan-grid',
    'dataProvider' => $modDialogKunjungan->searchDialogKunjungan(),
    'filter' => $modDialogKunjungan,
    'template' => "{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            setInfoPasien($data->pendaftaran_id, \"\", \"\", \"\");
                                            $(\"#dialogPasien\").dialog(\"close\");
                                        "))',
        ),
        'no_pendaftaran',
        array(
            'header' => 'Tanggal Pendaftaran / Masuk Kamar',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)
								.(isset($data->tglmasukkamar) ? "<br>".MyFormatter::formatDateTimeForUser($data->tglmasukkamar) : "")',
            'filter' =>
            CHtml::activeTextField($modDialogKunjungan, 'tgl_pendaftaran', array('class' => 'span3', 'readonly' => true)),
            /*$this->widget('MyDateTimePicker', array(
                'model' => $modDialogKunjungan,
                'attribute' => 'tgl_pendaftaran',
                'mode' => 'date', //date / datetime
                'gridFilter' => true,
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array('readonly' => true, 'class' => "span2",
                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ), true),*/
        ),
        array(
            'name' => 'no_rekam_medik',
            'type' => 'raw',
            'value' => '$data->no_rekam_medik',
        ),
        'nama_pasien',
        array(
            'name' => 'jeniskelamin',
            'type' => 'raw',
            'filter' => LookupM::model()->getItems('jeniskelamin'),
        ),
        array(
            'name' => 'instalasi_id',
            'value' => '$data->instalasi_nama',
            'type' => 'raw',
            'filter' => CHtml::activeHiddenField($modDialogKunjungan, 'instalasi_id') . CHtml::activeTextField($modDialogKunjungan, 'instalasi_nama'),
        ),
        array(
            'name' => 'ruangan_nama',
            'type' => 'raw',
        ),
        array(
            'name' => 'carabayar_nama',
            'type' => 'raw',
            'value' => '$data->carabayar_nama',
        ),
        array(
            'name' => 'alamat_pasien',
            'type' => 'raw',
            'value' => '$data->alamat_pasien',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
				jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
//				jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tgl_pendaftaran') . '").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"dateFormat":"dd M yy","maxDate":"d","timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"changeMonth":true,"showAnim":"fold","yearRange":"-80y:+20y"}));
//				jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tgl_pendaftaran') . '_date").on("click", function(){jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tgl_pendaftaran') . '").datepicker("show");});
                                jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tgl_pendaftaran') . '").daterangepicker({
                                    "maxDate": "' . date('m/d/Y') . '",
                                    "showDropdowns": true,
                                });
			}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>
<script>
    $(document).ready(function() {
        $('input[name="ARPasienM[tgl_pendaftaran]"]').daterangepicker({
            // "maxDate": "<?php echo date('m/d/Y') ?>",
            "showDropdowns": true,
        });
    });
</script>