<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("No. Pasien Anestesi <span class='required'>*</span>", 'noanestesi', array('class'=>'control-label required')); ?>
            <div class="controls">
                <?php echo CHtml::activeHiddenField($modKunjungan, 'pasienanastesi_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::activeHiddenField($modKunjungan, 'pendaftaran_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::activeHiddenField($modKunjungan, 'pasien_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::activeHiddenField($modKunjungan, 'pasienmasukpenunjang_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <?php 
                    $this->widget('MyJuiAutoComplete', array(
                                            'model'=>$modKunjungan,
                                            'attribute'=>'noanestesi',
                                            'source'=>'js: function(request, response) {
                                                    $.ajax({
                                                            url: "'.$this->createUrl('AutocompleteKunjungan').'",
                                                            dataType: "json",
                                                            data: {
                                                                    noanestesi: request.term,
                                                            },
                                                            success: function (data) {
                                                                    response(data);
                                                            }
                                                    })
                                            }',
                                            'options'=>array(
                                                    'minLength' => 3,
                                                     'focus'=> 'js:function( event, ui ) {
                                                              $(this).val( "");
                                                              return false;
                                                      }',
                                                    'select'=>'js:function( event, ui ) {
                                                             $(this).val( ui.item.noanestesi);
                                                             cekKunjungan(ui.item.pasienanastesi_id,ui.item.pendaftaran_id,ui.item.pasienmasukpenunjang_id);
                                                             return false;
                                                    }',
                                            ),
                                            'tombolDialog'=>array('idDialog'=>'dialogKunjungan'),
                                            'htmlOptions'=>array('placeholder'=>'Ketik No. Anestesi','class'=>'all-caps','rel'=>'tooltip','title'=>'Ketik No. Anestesi',
                                                    'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
                                            ),
                                    )); 
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Pasien Anestesi <span class='required'>*</span>", 'tglanastesi', array('class'=>'control-label required')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modKunjungan,'tglanastesi',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Umur', 'umur', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modKunjungan, 'umur',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Jenis Kasus Penyakit", 'instalasiasal_nama', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeHiddenField($modKunjungan, 'jeniskasuspenyakit_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::activeTextField($modKunjungan, 'jeniskasuspenyakit_nama',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);"));  ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Dokter Pemeriksa", 'nama_pegawai', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeHiddenField($modKunjungan, 'pegawai_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::activeTextField($modKunjungan, 'nama_pegawai',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);"));  ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Alamat Pasien", 'alamat_pasien', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextArea($modKunjungan, 'alamat_pasien',array('readonly'=>true,'class'=>'span3', 'placeholder'=>'Ketik Alamat Pasien', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("No. Rekam Medik", 'no_rekam_medik', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php 
                    $this->widget('MyJuiAutoComplete', array(
                                            'model'=>$modKunjungan,
                                            'attribute'=>'no_rekam_medik',
                                            'source'=>'js: function(request, response) {
                                                    $.ajax({
                                                            url: "'.$this->createUrl('AutocompleteKunjungan').'",
                                                            dataType: "json",
                                                            data: {
                                                                    no_rekam_medik: request.term,
                                                            },
                                                            success: function (data) {
                                                                            response(data);
                                                            }
                                                    })
                                             }',
                                            'options'=>array(
                                                    'minLength' => 3,
                                                     'focus'=> 'js:function( event, ui ) {
                                                              $(this).val( "");
                                                              return false;
                                                      }',
                                                    'select'=>'js:function( event, ui ) {
                                                             $(this).val( ui.item.no_rekam_medik);
                                                             cekKunjungan(ui.item.pasienanastesi_id,ui.item.pendaftaran_id,ui.item.pasienmasukpenunjang_id);
                                                             return false;
                                                     }',
                                            ),
                                            'htmlOptions'=>array('placeholder'=>'Ketik No. Rekam Medik','class'=>'all-caps','rel'=>'tooltip','title'=>'Ketik no. rekam medik untuk mencari data kunjungan',
                                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                            ),
                                    )); 
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Nama Pasien", 'nama_pasien', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php 
                    $this->widget('MyJuiAutoComplete', array(
                                            'model'=>$modKunjungan,
                                            'attribute'=>'nama_pasien',
                                            'source'=>'js: function(request, response) {
                                                    $.ajax({
                                                            url: "'.$this->createUrl('AutocompleteKunjungan').'",
                                                            dataType: "json",
                                                            data: {
                                                                    nama_pasien: request.term,
                                                            },
                                                            success: function (data) {
                                                                            response(data);
                                                            }
                                                    })
                                            }',
                                            'options'=>array(
                                                    'minLength' => 3,
                                                     'focus'=> 'js:function( event, ui ) {
                                                              $(this).val( "");
                                                              return false;
                                                      }',
                                                    'select'=>'js:function( event, ui ) {
                                                             $(this).val( ui.item.nama_pasien);
                                                             cekKunjungan(ui.item.pasienanastesi_id,ui.item.pendaftaran_id,ui.item.pasienmasukpenunjang_id);
                                                             return false;
                                                     }',
                                            ),
                                            'htmlOptions'=>array('placeholder'=>'Ketik Nama Pasien','rel'=>'tooltip','title'=>'Ketik nama pasien untuk mencari data kunjungan',
                                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                            ),
                                    )); 
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Jenis Kelamin", 'jeniskelamin', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modKunjungan, 'jeniskelamin',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Pekerjaan", 'pekerjaan_nama', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeHiddenField($modKunjungan, 'pekerjaan_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::activeTextField($modKunjungan, 'pekerjaan_nama',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>    
        <div class="control-group">
            <?php echo CHtml::label("Kelas Pelayanan", 'kelaspelayanan_nama', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeHiddenField($modKunjungan, 'kelaspelayanan_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::activeTextField($modKunjungan, 'kelaspelayanan_nama',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div align="center">
            <?php 
            $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory()."kecil_".$modPasien->photopasien : Params::urlPhotoPasienDirectory()."no_photo.jpeg");
            ?>
            <img id="photo-preview" src="<?php echo $url_photopasien?>"width="128px"/> 
        </div>
    </div>
</div>


<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogKunjungan',
    'options'=>array(
        'title'=>'Pencarian Data Kunjungan Pasien Anestesi',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>480,
        'resizable'=>false,
    ),
));
    $modDialogKunjungan = new ATInformasipasienanestesiV('search');
    $modDialogKunjungan->unsetAttributes();
//    $modDialogKunjungan->tgl_masuk_cari = date('d M Y');
    $modDialogKunjungan->tgl_masuk_cari = date('m/d/Y') . ' - ' . date('m/d/Y');
    if(isset($_GET['ATInformasipasienanestesiV'])) {
        $modDialogKunjungan->attributes = $_GET['ATInformasipasienanestesiV'];
		$modDialogKunjungan->tgl_masuk_cari = (isset($_GET['ATInformasipasienanestesiV']['tgl_masuk_cari']) ? $_GET['ATInformasipasienanestesiV']['tgl_masuk_cari'] : null);
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'datakunjungan-grid',
		'dataProvider'=>$modDialogKunjungan->searchDialog(),
		'filter'=>$modDialogKunjungan,
		'template'=>"{summaryNonPage}\n{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
					"id" => "selectKunjungan",
					"onClick" => "
						cekKunjungan($data->pasienanastesi_id,$data->pendaftaran_id,$data->pasienmasukpenunjang_id);
						$(\"#dialogKunjungan\").dialog(\"close\");
					"))',
			),
			'no_pendaftaran',
			'no_masukpenunjang',
			array(
				'name'=>'tglmasukpenunjang',
				'type'=>'raw',
				'value'=>'MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)',
				'filter'=>false,
//                                    CHtml::activeTextField($modDialogKunjungan, 'tgl_masuk_cari', array('class'=>'span3','readonly'=>true)),
                                    /*$this->widget('MyDateTimePicker',array(
                                    'model'=>$modDialogKunjungan,
                                    'attribute'=>'tgl_masuk_cari',
                                    'mode'=>'date',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        'maxDate'=>'d',
                                    ),
                                    'htmlOptions'=>array('readonly'=>false, 'class'=>'dtPicker3','id'=>'tgl_masuk_cari','placeholder'=>date('d M Y H:i:s')),
                                    ),true
                                    ),*/
			),
			'no_rekam_medik',
			'nama_pasien',
			array(
				'name'=>'jeniskelamin',
				'type'=>'raw',
//				'filter'=>LookupM::model()->getItems('jeniskelamin'),
                                 'filter'=>CHtml::dropDownList('SAPasienM[jeniskelamin]',$modDialogKunjungan->jeniskelamin,LookupM::getItems("jeniskelamin"),array('empty'=>'-- Pilih --')),
			),
			array(
				'name'=>'carabayar_id',
//				'type'=>'raw',
//				'value'=>'$data->carabayar_nama',
//				'filter'=>CHtml::listData(CarabayarM::model()->findAll("carabayar_aktif IS TRUE"),'carabayar_id','carabayar_nama',array('empty'=>'Pilih')),
                                'filter'=> CHtml::dropDownList('CarabayarM[carabayar_id]',$modDialogKunjungan->carabayar_id,CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif IS TRUE'), 'carabayar_id', 'carabayar_nama'),array('empty'=>'-- Pilih --')),
                                'value'=>'$data->carabayar_nama',
                                'htmlOptions' => array('style'=>'width:80px;'),
                            
                            ),
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
//			jQuery(\'#tgl_masuk_cari\').datepicker(jQuery.extend({
//                        showMonthAfterYear:false}, 
//                        jQuery.datepicker.regional[\'id\'], 
//                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
//                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
//                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
//                jQuery(\'#tgl_masuk_cari_date\').on(\'click\', function(){jQuery(\'#tgl_masuk_cari\').datepicker(\'show\');});
                jQuery("#'.CHtml::activeId($modDialogKunjungan, 'tgl_masuk_cari').'").daterangepicker({
                    "maxDate": "' . date('m/d/Y') . '",
                    "showDropdowns": true,
                });
                }',
    ));
$this->endWidget();
?>
<script>
    $(document).ready(function(){
        $('input[name="ATInformasipasienanestesiV[tgl_masuk_cari]"]').daterangepicker({
            "maxDate": "<?php echo date('m/d/Y') ?>",
            "showDropdowns": true,
        });
    });
</script>