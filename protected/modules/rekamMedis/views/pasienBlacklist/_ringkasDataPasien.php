<div class="row">
    <div class="col-sm-6">
        <div class="control-group no_rek">
            <?php echo CHtml::label('No. Pendaftaran', 'no_pendaftaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                    if (!empty($modPendaftaran->no_pendaftaran)) {
                            echo CHtml::textField('RKPendaftaranT[no_pendaftaran]', $modPendaftaran->no_pendaftaran, array(
                                    'readonly' => true));
                    } else {
                            echo CHtml::hiddenField('RKPendaftaranT[pendaftaran_id]', $modPendaftaran->pendaftaran_id, array(
                                    'readonly' => true));
                            echo CHtml::hiddenField('RKPendaftaranT[pasien_id]', $modPendaftaran->pasien_id, array(
                                    'readonly' => true));
                            $this->widget('MyJuiAutoComplete', array(
                                    'name'			 => 'RKPendaftaranT[no_pendaftaran]',
                                    'value'			 => $modPendaftaran->no_pendaftaran,
                                    'source'		 => 'js: function(request, response) {
                                       $.ajax({
                                           url: "' . $this->createUrl('AutocompleteKunjungan') . '",
                                           dataType: "json",
                                           data: {
                                               no_pendaftaran: request.term,
                                               instalasiId: $("#RKPendaftaranT_instalasi_id").val(),
                                           },
                                           success: function (data) {
                                                   response(data);
                                           }
                                       })
                                    }',
                                    'options'		 => array(
                                            'showAnim'	 => 'fold',
                                            'minLength'	 => 2,
                                            'focus'		 => 'js:function( event, ui ) {
                                    $(this).val(ui.item.value);
                                    return false;
                                }',
                                            'select'	 => 'js:function( event, ui ) {
                                                    isiDataPasien(ui.item);
                                                    loadPasienBerhutang(ui.item.pendaftaran_id);
                                                    return false;
                                            }',
                                    ),
                                    'tombolDialog'	 => array('idDialog' => 'dialogPasien', 'idTombol' => 'tombolPasienDialog'),
                                    'htmlOptions'	 => array('class'			 => 'span2',
                                            'placeholder'	 => 'No. Pendaftaran', 'onkeypress'	 => "return $(this).focusNextInputField(event)"),
                            ));
                    }
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPendaftaran, 'tempat_lahir', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                    echo CHtml::textField('RKPendaftaranT[tempat_lahir]', $modPendaftaran->tempat_lahir, array(
                            'readonly' => true));
                    ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Jenis Kelamin', 'jeniskelamin', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo CHtml::textField('RKPendaftaranT[jeniskelamin]', $modPendaftaran->jeniskelamin, array(
                        'readonly' => true));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo CHtml::textField('tgl_pendaftaran', $modPendaftaran->tgl_pendaftaran, array(
                        'readonly' => true));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPendaftaran, 'tanggal_lahir', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                    echo CHtml::textField('RKPendaftaranT[tanggal_lahir]', $modPendaftaran->tanggal_lahir, array(
                            'readonly' => true));
                    ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPendaftaran, 'pekerjaan_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                    echo CHtml::textField('RKPendaftaranT[pekerjaan_nama]', $modPendaftaran->pekerjaan_nama, array(
                            'readonly' => true));
                    ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPendaftaran, 'no_rekam_medik', array('class' => 'control-label ')); ?>
            <div class="controls">
                <?php
                    $this->widget('MyJuiAutoComplete', array(
                            'name'		 => 'RKPendaftaranT[no_rekam_medik]',
                            'value'		 => $modPendaftaran->no_rekam_medik,
                            'source'	 => 'js: function(request, response) {
                                              $.ajax({
                                                  url: "' . $this->createUrl('AutocompleteKunjungan') . '",
                                                  dataType: "json",
                                                  data: {
                                                      daftarpasien:true,
                                                      no_rekam_medik: request.term,
                                                  },
                                                  success: function (data) {
                                                          response(data);
                                                  }
                                              })
                                           }',
                            'options'	 => array(
                                    'showAnim'	 => 'fold',
                                    'minLength'	 => 2,
                                    'focus'		 => 'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            return false;
                                    }',
                                    'select'	 => 'js:function( event, ui ) {
                                            isiDataPasien(ui.item);
                                            loadPasienBerhutang(ui.item.pendaftaran_id);
                                            return false;
                                    }',
                            ),
                    ));
                    ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                    echo CHtml::textField('RKPendaftaranT[umur]', isset($modPendaftaran->umur) ? $modPendaftaran->umur : '-', array(
                            'readonly' => true));
                    ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPendaftaran, 'pendidikan_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                    echo CHtml::textField('RKPendaftaranT[pendidikan_nama]', isset($modPendaftaran->pendidikan_nama) ? $modPendaftaran->pendidikan_nama : '-', array(
                            'readonly' => true));
                    ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPendaftaran, 'nama_pasien', array('class' => 'control-label ')); ?>
            <div class="controls">
                <?php
                    $this->widget('MyJuiAutoComplete', array(
                            'name'		 => 'RKPendaftaranT[nama_pasien]',
                            'value'		 => $modPendaftaran->nama_pasien,
                            'source'	 => 'js: function(request, response) {
                                              $.ajax({
                                                  url: "' . $this->createUrl('AutocompleteKunjungan') . '",
                                                  dataType: "json",
                                                  data: {
                                                      daftarpasien:true,
                                                      nama_pasien: request.term,
                                                  },
                                                  success: function (data) {
                                                          response(data);
                                                  }
                                              })
                                           }',
                            'options'	 => array(
                                    'showAnim'	 => 'fold',
                                    'minLength'	 => 2,
                                    'focus'		 => 'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            return false;
                                    }',
                                    'select'	 => 'js:function( event, ui ) {
                                            isiDataPasien(ui.item);
                                            loadPasienBerhutang(ui.item.pendaftaran_id);
                                            return false;
                                    }',
                            ),
                    ));
                    ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPendaftaran, 'agama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                        echo CHtml::textField('RKPendaftaranT[agama]', isset($modPendaftaran->agama) ? $modPendaftaran->agama : '-', array(
                                'readonly' => true));
                        ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPendaftaran, 'alamat_pasien', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                    echo CHtml::textArea('RKPendaftaranT[alamat_pasien]', isset($modPendaftaran->alamat_pasien) ? $modPendaftaran->alamat_pasien : '-', array(
                            'readonly' => true));
                    ?>
            </div>
        </div>
<!--<div class="control-group">
            
            <div class="controls">
                
            </div>
        </div>-->
    </div>
</div>

<?php
//========= Dialog buat cari data pendaftaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id'		 => 'dialogPasien',
	'options'	 => array(
		'title'		 => 'Pencarian Data Pasien',
		'autoOpen'	 => false,
		'modal'		 => true,
		'width'		 => 900,
		'height'	 => 540,
		'resizable'	 => false,
	),
));
$modDialogPasien = new RKPendaftaranT('searchDialog');
$modDialogPasien->unsetAttributes();
//$modDialogPasien->tgl_pendaftaran_cari = date('d M Y');
$modDialogPasien->tgl_pendaftaran = date('m/d/Y') . ' - ' . date('m/d/Y');
if (isset($_GET['RKPendaftaranT'])) {
	$modDialogPasien->attributes = $_GET['RKPendaftaranT'];
	$modDialogPasien->no_rekam_medik = $_GET['RKPendaftaranT']['no_rekam_medik'];
	$modDialogPasien->nama_pasien = $_GET['RKPendaftaranT']['nama_pasien'];
	$modDialogPasien->jeniskelamin = $_GET['RKPendaftaranT']['jeniskelamin'];
	$modDialogPasien->instalasi_nama = $_GET['RKPendaftaranT']['instalasi_nama'];
	$modDialogPasien->ruangan_nama = $_GET['RKPendaftaranT']['ruangan_nama'];
	$modDialogPasien->carabayar_nama = $_GET['RKPendaftaranT']['carabayar_nama'];
	$modDialogPasien->tgl_pendaftaran = isset($_GET['RKPendaftaranT']['tgl_pendaftaran'])?$_GET['RKPendaftaranT']['tgl_pendaftaran']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id'				 => 'pendaftaran-t-grid',
	'dataProvider'		 => $modDialogPasien->searchDialog(),
	'filter'			 => $modDialogPasien,
	'template'			 => "{summary}\n{items}\n{pager}",
	'itemsCssClass'		 => 'table table-striped table-bordered table-condensed',
	'columns'			 => array(
		array(
			'header' => 'Pilih',
			'type'	 => 'raw',
			'value'	 => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            $(\"#dialogPasien\").dialog(\"close\");
											 $(\"#RKPendaftaranT_pendaftaran_id\").val(\"$data->pendaftaran_id\");
											 $(\"#RKPendaftaranT_pasien_id\").val(\"$data->pasien_id\");
                                            $(\"#tgl_pendaftaran\").val(\"$data->tgl_pendaftaran\");
                                            $(\"#RKPendaftaranT_no_pendaftaran\").val(\"$data->no_pendaftaran\");
                                            $(\"#RKPendaftaranT_umur\").val(\"$data->umur\");
                                            $(\"#RKPendaftaranT_jeniskasuspenyakit_nama\").val(\"$data->jeniskasuspenyakit_nama\");
                                            $(\"#RKPendaftaranT_instalasi_id\").val(\"$data->instalasi_id\");
                                            $(\"#RKPendaftaranT_instalasi_nama\").val(\"$data->instalasi_nama\");
                                            $(\"#RKPendaftaranT_ruangan_nama\").val(\"$data->ruangan_nama\");
                                            $(\"#RKPendaftaranT_pendaftaran_id\").val(\"$data->pendaftaran_id\");
                                            $(\"#RKPendaftaranT_carabayar_id\").val(\"$data->carabayar_id\");
                                            $(\"#RKPendaftaranT_penjamin_id\").val(\"$data->penjamin_id\");
                                            $(\"#RKPendaftaranT_kelaspelayanan_id\").val(\"$data->kelaspelayanan_id\");
											$(\"#RKPendaftaranT_kelaspelayanan_nama\").val(\"$data->kelaspelayanan_nama\");
                                            $(\"#RKPendaftaranT_pasien_id\").val(\"$data->pasien_id\");
											$(\"#RKPendaftaranT_tempat_lahir\").val(\"$data->tempat_lahir\");
											$(\"#RKPendaftaranT_tanggal_lahir\").val(\"$data->tanggal_lahir\");
                                            $(\"#RKTandabuktibayarUangMukaT_darinama_bkm\").val(\"$data->nama_pasien\");

                                            $(\"#RKPendaftaranT_jeniskelamin\").val(\"$data->jeniskelamin\");
                                            $(\"#RKPendaftaranT_no_rekam_medik\").val(\"$data->no_rekam_medik\");
                                            $(\"#RKPendaftaranT_nama_pasien\").val(\"$data->nama_pasien\");
                                            $(\"#RKPendaftaranT_pekerjaan_nama\").val(\"$data->pekerjaan_nama\");
											$(\"#RKPendaftaranT_pendidikan_nama\").val(\"$data->pendidikan_nama\");
											$(\"#RKPendaftaranT_alamat_pasien\").val(\"$data->alamat_pasien\");
											$(\"#RKPendaftaranT_agama\").val(\"$data->agama\");
											$(\"#RKPendaftaranT_statusperkawinan\").val(\"$data->statusperkawinan\");
                                            $(\"#RKPendaftaranT_carabayar_nama\").val(\"$data->carabayar_nama\");
                                            $(\"#RKPendaftaranT_penjamin_nama\").val(\"$data->penjamin_nama\");
											$(\"#RKPendaftaranT_no_kamarbed\").val(\"$data->kamarruangan_nokamar\" + \" / \" + \"$data->kamarruangan_nobed\");
											loadPasienBerhutang($data->pendaftaran_id);
                                        "))',
		),
		array(
			'name'	 => 'no_rekam_medik',
			'type'	 => 'raw',
			'value'	 => '$data->no_rekam_medik',
		),
		array(
			'name'	 => 'nama_pasien',
			'type'	 => 'raw',
			'value'	 => '$data->nama_pasien',
		),
		array(
			'header' => 'Jenis Kelamin',
			'name'	 => 'jeniskelamin',
			'type'	 => 'raw',
			'filter' => LookupM::model()->getItems('jeniskelamin'),
			'value'	 => '$data->jeniskelamin',
		),
		'no_pendaftaran',
//		array(
//			'name'			 => 'tgl_pendaftaran',
//			'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)
//								.(isset($data->tglmasukkamar) ? "<br>".MyFormatter::formatDateTimeForUser($data->tglmasukkamar) : "")',
//			'filter'		 => $this->widget('MyDateTimePicker', array(
//				'model'			 => $modDialogPasien,
//				'attribute'		 => 'tgl_pendaftaran_cari',
//				'mode'			 => 'date',
//				'options'		 => array(
//					'dateFormat' => Params::DATE_FORMAT,
//                    'maxDate'    => 'd',
//				),
//				'htmlOptions'	 => array('readonly' => false, 'class' => 'span3 dtPicker3',
//					'placeholder' => '23 Jan 1993'),
//					), true
//			),
//			'htmlOptions'	 => array('width' => '80', 'style' => 'text-align:center'),
//		),
					array(
                            'header' => 'Tanggal Pendaftaran',
                            'name' => 'tgl_pendaftaran',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:center;width:150px;'),
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                        ),
		array(
			'header' => 'Instalasi',
			'name'	 => 'instalasi_nama',
			'type'	 => 'raw',
			'value'	 => '$data->instalasi_nama',
		),
		array(
			'header' => 'Ruangan',
			'name'	 => 'ruangan_nama',
			'type'	 => 'raw',
			'value'	 => '$data->ruangan_nama',
		),
		array(
			'header' => 'Jenis Penjamin',
			'name'	 => 'carabayar_nama',
			'type'	 => 'raw',
			'value'	 => '$data->carabayar_nama',
		),
	),
	'afterAjaxUpdate'=>'function(id, data){
				jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
//				jQuery("#'.CHtml::activeId($modDialogPasien, 'tgl_pendaftaran_cari').'").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"dateFormat":"dd M yy","maxDate":"d","timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"changeMonth":true,"showAnim":"fold","yearRange":"-80y:+20y"}));
//				jQuery("#'.CHtml::activeId($modDialogPasien, 'tgl_pendaftaran_cari').'_date").on("click", function(){jQuery("#'.CHtml::activeId($modDialogPasien, 'tgl_pendaftaran_cari').'").datepicker("show");});
				$(\'input[name="RKPendaftaranT[tgl_pendaftaran]"]\').daterangepicker({
                        "maxDate": "' . date('m/d/Y') . '",
                        "showDropdowns": true,
                    });
			}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>