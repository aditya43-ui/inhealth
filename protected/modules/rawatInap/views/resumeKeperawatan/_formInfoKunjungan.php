<style>
.ui-autocomplete {
    max-height: 300px;
    overflow-y: auto;
}
</style>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("No. Pendaftaran", 'no_pendaftaran', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('pendaftaran_id',$modKunjungan->pendaftaran_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php
                echo CHtml::hiddenField('pasien_id',$modKunjungan->pasien_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
            ?>
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                    'name'=>'no_pendaftaran',
                    'value'=>$modKunjungan->no_pendaftaran,
                    'source'=>'js: function(request, response) {
                        $.ajax({
                            url: "'.$this->createUrl('AutocompleteKunjungan').'",
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
                    'options'=>array(
                        'minLength' => 2,
                        'focus'=> 'js:function( event, ui ) {
                            $(this).val( "");
                            return false;
                        }',
                        'select'=>'js:function( event, ui ) {
                            $(this).val( ui.item.value);
                            setKunjungan(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
                            setResumeKeperawatan(ui.item.pendaftaran_id);
                            return false;
                        }',
                    ),
                    'tombolDialog'=>array('idDialog'=>'dialogKunjungan'),
                    'htmlOptions'=>array('placeholder'=>'No. Pendaftaran','class'=>'span3','rel'=>'tooltip','title'=>'No. pendaftaran / klik icon untuk mencari data kunjungan',
                        'onkeyup'=>"if($(this).val() == ''){ $(no_pendaftaran).focus() }else{return $(this).focusNextInputField(event)}", 'onchange'=>"if($(this).val() == '') setKunjunganReset();"	                                  
                    ),
                )); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("No. Rekam Medis", 'no_rekam_medik', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                    'name'=>'no_rekam_medik',
                    'value'=>$modKunjungan->no_rekam_medik,
                    'source'=>'js: function(request, response) {
                        $.ajax({
                            url: "'.$this->createUrl('AutocompleteKunjungan').'",
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
                    'options'=>array(
                        'minLength' => 2,
                        'focus'=> 'js:function( event, ui ) {
                            $(this).val( "");
                            return false;
                        }',
                        'select'=>'js:function( event, ui ) {
                            $(this).val( ui.item.value);
                            setKunjungan(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
                            setResumeKeperawatan(ui.item.pendaftaran_id);
                            return false;
                        }',
                    ),
                    'tombolDialog'=>array('idDialog'=>'dialogKunjungan'),
                    'htmlOptions'=>array('placeholder'=>'No. Pendaftaran','class'=>'span3','rel'=>'tooltip','title'=>'No. pendaftaran / klik icon untuk mencari data kunjungan',
                        'onkeyup'=>"if($(this).val() == ''){ $(no_pendaftaran).focus() }else{return $(this).focusNextInputField(event)}", 'onchange'=>"if($(this).val() == '') setKunjunganReset();"	                                  
                    ),
                )); 
            ?>
        </div>
    </div>
    <div class="control-group">
    <?php echo CHtml::label("NIP", 'nomorindukpegawai', array('class'=>'span2 control-label'))?>
        <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                    'name'=>'cari_nomorindukpegawai',
                    'value'=>$modPegawai->nomorindukpegawai,
                    'source'=>'js: function(request, response) {
                        $.ajax({
                            url: "'.$this->createUrl('AutocompleteKunjungan').'",
                            dataType: "json",
                            data: {
                                nomorindukpegawai: request.term,
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
                            $(this).val( ui.item.value);
                            setKunjungan(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
                            setResumeKeperawatan(ui.item.pendaftaran_id);
                            return false;
                        }',
                    ),
                    'tombolDialog'=>array('idDialog'=>'dialogPasienBadak'),
                    'htmlOptions'=>array('placeholder'=>'NIP','rel'=>'tooltip','title'=>'Ketik NIP untuk mencari pasien',
                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                        'class'=>'span3 numbers-only'
                    ),
                )); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Nama', 'nama_pasien', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('namadepan',$modKunjungan->namadepan,array('placeholder'=>'Nama Depan','class'=>'span1', 'onblur'=>'','onkeyup'=>"return $(this).focusNextInputField(event);",'readonly'=>true, 'maxlength'=>20)); ?>
            <?php echo CHtml::textField('nama_pasien',$modKunjungan->nama_pasien,array('placeholder'=>'Nama Lengkap Pasien','class'=>'span2', 'onblur'=>'','onkeyup'=>"return $(this).focusNextInputField(event);",'readonly'=>true, 'maxlength'=>20)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Umur', 'umur', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('umur',$modKunjungan->umur,array('placeholder'=>'00 Thn 00 Bln 00 Hr','class'=>'span3 umur', 'onblur'=>'','onkeyup'=>"return $(this).focusNextInputField(event);",'readonly'=>true, 'maxlength'=>20)); ?>
        </div>
    </div>	    
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Jenis Kelamin', 'jeniskelamin', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('jeniskelamin',$modKunjungan->jeniskelamin,array('placeholder'=>'Jenis Kelamin Pasien','class'=>'span3', 'onblur'=>'','onkeyup'=>"return $(this).focusNextInputField(event);",'readonly'=>true, 'maxlength'=>20)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Dokter Pemeriksa', 'nama_pegawai', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('nama_pegawai',$modKunjungan->nama_pegawai,array('placeholder'=>'Dokter Pemeriksa','class'=>'span3', 'onblur'=>'','onkeyup'=>"return $(this).focusNextInputField(event);",'readonly'=>true, 'maxlength'=>20)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Jenis Penjamin', 'carabayar_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('carabayar_nama',$modKunjungan->carabayar_nama,array('placeholder'=>'Jenis Penjamin Pasien','class'=>'span3', 'onblur'=>'','onkeyup'=>"return $(this).focusNextInputField(event);",'readonly'=>true, 'maxlength'=>20)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Penjamin', 'penjamin_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('penjamin_nama',$modKunjungan->penjamin_nama,array('placeholder'=>'Penjamin Pasien','class'=>'span3', 'onblur'=>'','onkeyup'=>"return $(this).focusNextInputField(event);",'readonly'=>true, 'maxlength'=>20)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Masuk', 'tglmasukkamar', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo !empty($modPasienMasukKamar->tglmasukkamar) ? CHtml::textField('tglmasukkamar',$modPasienMasukKamar->tglmasukkamar,array('placeholder'=>'Tanggal Masuk Kamar','class'=>'span3', 'onblur'=>'','onkeyup'=>"return $(this).focusNextInputField(event);",'readonly'=>true, 'maxlength'=>20)):" - "; ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Keluar', 'tglpulang', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo !empty($modPasienMasukKamar->tglpulang) ? CHtml::textField('tglpulang',$modPasienMasukKamar->tglpulang,array('placeholder'=>'Tanggal Pulang','class'=>'span3', 'onblur'=>'','onkeyup'=>"return $(this).focusNextInputField(event);",'readonly'=>true, 'maxlength'=>20)):' - '; ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Kelas Pelayanan', 'kelaspelayanan_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo !empty($modPasienMasukKamar->kelaspelayanan_nama) ? CHtml::textField('kelaspelayanan_nama',$modPasienMasukKamar->kelaspelayanan_nama,array('placeholder'=>'Kelas Pelayanan','class'=>'span3', 'onblur'=>'','onkeyup'=>"return $(this).focusNextInputField(event);",'readonly'=>true, 'maxlength'=>20)) : " - "; ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('No. Kamar', 'kamarruangan_nokamar', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo !empty($modPasienMasukKamar->kamarruangan_nokamar) ? CHtml::textField('kamarruangan_nokamar',$modPasienMasukKamar->kamarruangan_nokamar,array('placeholder'=>'No. Kamar Pasien','class'=>'span3', 'onblur'=>'','onkeyup'=>"return $(this).focusNextInputField(event);",'readonly'=>true, 'maxlength'=>20)) : " - "; ?>
        </div>
    </div>            
</div>

<?php
// ================== DIALOG PASIEN BADAK =====================

    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogKunjungan',
        'options'=>array(
            'title'=>'Pencarian Data Pasien',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>1060,
            'height'=>480,
            'resizable'=>false,
        ),
    ));
	
    $modDataPasien = new RIInfokunjunganriV();
    $modDataPasien->unsetAttributes();
    $modDataPasien->ruangan_nama = Yii::app()->user->getState('ruangan_nama');
            
    $format = new MyFormatter();
    if(isset($_GET['RIInfokunjunganriV'])) {
        $modDataPasien->attributes = $_GET['RIInfokunjunganriV'];
		$modDataPasien->no_pendaftaran = (isset($_GET['RIInfokunjunganriV']['no_pendaftaran']) ? $_GET['RIInfokunjunganriV']['no_pendaftaran'] : "");
        if(isset($_GET['RIInfokunjunganriV']['nomorindukpegawai'])){
			$modDataPasien->nomorindukpegawai = $_GET['RIInfokunjunganriV']['nomorindukpegawai'];
		}
    }
	
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'datakunjungan-grid',
            'dataProvider'=>$modDataPasien->searchDialog(),
            'filter'=>$modDataPasien,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            setKunjungan($data->pendaftaran_id, \"\", \"\", \"\");
											setResumeKeperawatan($data->pendaftaran_id);
                                            $(\"#dialogKunjungan\").dialog(\"close\");
                                        "))',
                    ),
                    'no_pendaftaran',
                    array(
                        'name'=>'tgl_pendaftaran',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                        'filter'=> false,
                    ),
                    array(
                        'name'=>'no_rekam_medik',
                        'type'=>'raw',
                        'value'=>'$data->no_rekam_medik',
                    ),
                    'nama_pasien',
//                    'jeniskelamin',
                    array(
                        'name'=>'jeniskelamin',
                        'type'=>'raw',
                        'filter'=> Chtml::dropDownList('RIInfokunjunganriV[jeniskelamin]',$modDataPasien->jeniskelamin,LookupM::model()->getItems('jeniskelamin'),array('empty'=>'-- Pilih --')),
                    ),
                    array(
                        'name'=>'instalasi_id',
                        'value'=>'$data->instalasi_nama',
                        'type'=>'raw',
                        'filter'=>CHtml::activeHiddenField($modDataPasien,'instalasi_id'),
                    ),
                    array(
                        'name'=>'ruangan_nama',
                        'type'=>'raw',
                        'filter'=>CHtml::activeTextField($modDataPasien,'ruangan_nama',array('readonly'=>TRUE)),
                    ),
                    array(
                        'name'=>'carabayar_nama',
                        'type'=>'raw',
                        'value'=>'$data->carabayar_nama',
                        'filter'=>Chtml::dropDownList('RIInfokunjunganriV[carabayar_nama]',$modDataPasien->carabayar_nama,  CHtml::listData(CarabayarM::model()->findAll("carabayar_aktif = TRUE ORDER BY carabayar_nama ASC"), 'carabayar_nama', 'carabayar_nama'),array('empty'=>'-- Pilih --'))
                    ),

            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
    $this->endWidget();
    
	
	
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogPasienBadak',
        'options'=>array(
            'title'=>'Pencarian Data Pasien',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>1060,
            'height'=>480,
            'resizable'=>false,
        ),
    ));
	
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pasienbadak-m-grid',
            'dataProvider'=>$modDataPasien->searchDialogBadak(),
            'filter'=>$modDataPasien,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPasien",
                                        "onClick" => "
                                            setKunjungan($data->pendaftaran_id, \"\", \"\", \"\");
                                            $(\"#dialogPasienBadak\").dialog(\"close\");
                                        "))',
                    ),
                    array(
                        'header'=>'NIP',
						'name'=> 'nomorindukpegawai',
                        'type'=>'raw',
                        'value'=>'$data->pasien->pegawai->nomorindukpegawai',
                    ),
                    'no_pendaftaran',
                    array(
                        'name'=>'tgl_pendaftaran',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                        'filter'=> false,
                    ),
                    array(
                        'name'=>'no_rekam_medik',
                        'type'=>'raw',
                        'value'=>'$data->no_rekam_medik',
                    ),
                    'nama_pasien',
//                    'jeniskelamin',
                    array(
                        'name'=>'jeniskelamin',
                        'type'=>'raw',
                        'filter'=> Chtml::dropDownList('RIInfokunjunganriV[jeniskelamin]',$modDataPasien->jeniskelamin,LookupM::model()->getItems('jeniskelamin'),array('empty'=>'-- Pilih --')),
                    ),
                    array(
                        'name'=>'instalasi_id',
                        'value'=>'$data->instalasi_nama',
                        'type'=>'raw',
                        'filter'=>CHtml::activeHiddenField($modDataPasien,'instalasi_id'),
                    ),
                    array(
                        'name'=>'ruangan_nama',
                        'filter'=>CHtml::activeTextField($modDataPasien,'ruangan_nama',array('readonly'=>TRUE)),
                    ),
                    array(
                        'name'=>'carabayar_nama',
                        'type'=>'raw',
                        'value'=>'$data->carabayar_nama',
                        'filter'=>Chtml::dropDownList('RIInfokunjunganriV[carabayar_nama]',$modDataPasien->carabayar_nama,  CHtml::listData(CarabayarM::model()->findAll("carabayar_aktif = TRUE ORDER BY carabayar_nama ASC"), 'carabayar_nama', 'carabayar_nama'),array('empty'=>'-- Pilih --'))
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){
                 jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                 jQuery(\'#tanggal_lahir\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tanggal_lahir_date\').on(\'click\', function(){jQuery(\'#tanggal_lahir\').datepicker(\'show\');});
                
            
            }',
    ));
    $this->endWidget();
    ?>