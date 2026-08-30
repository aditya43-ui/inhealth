<div class="col-sm-4">
    <div class="control-group">
        <?php echo CHtml::label("Barcode", 'cari_pendaftaran_id', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('instalasi_id',$modPasien->instalasi_id,array('onchange'=>"if($(this).val()=='') setKunjunganReset(); else setKunjungan(this.value,'','','')",'class'=>'span3', 'placeholder'=>'Scan Barcode pada Print Status','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('cari_pendaftaran_id',$modPasien->pendaftaran_id,array('onchange'=>"if($(this).val()=='') setKunjunganReset(); else setKunjungan(this.value,'','','')",'class'=>'span3', 'placeholder'=>'Scan Barcode pada Print Status','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("No. Pendaftaran <span style='color:red;'> *</span>", 'no_pendaftaran', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php echo CHtml::activeHiddenField($model,'pendaftaran_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::activeHiddenField($model,'pasien_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php 
                $this->widget('MyJuiAutoComplete', array(
					'name'=>'no_pendaftaran',
					'value'=>$modPasien->no_pendaftaran,
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
						   'minLength' => 4,
							'focus'=> 'js:function( event, ui ) {
								 $(this).val( "");
								 return false;
							 }',
						   'select'=>'js:function( event, ui ) {
								$(this).val( ui.item.value);
								setKunjungan(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
								return false;
							}',
					),
					'tombolDialog'=>array('idDialog'=>'dialogPasien'),
					'htmlOptions'=>array('placeholder'=>'No. Pendaftaran','class'=>'all-caps','rel'=>'tooltip','title'=>'No. pendaftaran / klik icon untuk mencari data kunjungan',
						'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
						),
				)); 
			 ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Pendaftaran', 'tgl_pendaftaran', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tgl_pendaftaran',$modPasien->tgl_pendaftaran,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::hiddenField('tglselesaiperiksa',MyFormatter::formatDateTimeForUser(date("Y-m-d H:i:s")),array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Poliklinik / Ruangan Terakhir", 'ruangan_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('ruangan_id',$modPasien->ruangan_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('ruangan_nama',$modPasien->ruangan_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Kelas Pelayanan Terakhir", 'kelaspelayanan_id', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('kelaspelayanan_id',$modPasien->kelaspelayanan_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('kelaspelayanan_nama',$modPasien->kelaspelayanan_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Kasus Penyakit", 'jeniskasuspenyakit_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('jeniskasuspenyakit_id',$modPasien->jeniskasuspenyakit_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('jeniskasuspenyakit_nama',$modPasien->jeniskasuspenyakit_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Penjamin Terakhir", 'carabayar_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('carabayar_id',$modPasien->carabayar_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('carabayar_nama',$modPasien->carabayar_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Penjamin Terakhir", 'penjamin_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('penjamin_id',$modPasien->penjamin_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('penjamin_nama',$modPasien->penjamin_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class="col-sm-4">
    <div class="control-group">
        <?php echo CHtml::label("No. Rekam Medik", 'no_rekam_medik', array('class'=>'control-label')); ?>
        <div class="controls">            
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'name'=>'no_rekam_medik',
                                'value'=>$modPasien->no_rekam_medik,
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
                                       'minLength' => 4,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            setKunjungan(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array('placeholder'=>'No. Rekam Medik','rel'=>'tooltip','title'=>'No. rekam medik untuk mencari data kunjungan',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    'class'=>'numbers-only',
                                    ),
                            )); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nama Pasien", 'nama_pasien', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('namadepan',$modPasien->namadepan,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'name'=>'nama_pasien',
                                'value'=>$modPasien->nama_pasien,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteKunjungan').'",
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
                                 'options'=>array(
                                       'minLength' => 2,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            setKunjungan(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array('placeholder'=>'Nama Pasien','rel'=>'tooltip','title'=>'Ketik nama pasien untuk mencari data kunjungan',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    ),
                            )); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Alias', 'nama_bin', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('nama_bin',$modPasien->nama_bin,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Lahir', 'tanggal_lahir', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tanggal_lahir',$modPasien->tanggal_lahir,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Umur", 'umur', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('umur',$modPasien->umur,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Kelamin", 'jeniskelamin', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('jeniskelamin',$modPasien->jeniskelamin,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nama Penanggung Jawab", 'nama_pj', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('penanggungjawab_id',$modPasien->penanggungjawab_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('nama_pj',$modPasien->nama_pj,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>    
</div>
<div class="col-sm-4">
    <div style="text-align: center;">
        <?php 
        $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory()."kecil_".$modPasien->photopasien : Params::urlPhotoPasienDirectory()."no_photo.jpeg");
        ?>
        <img id="photo-preview" src="<?php echo $url_photopasien?>"width="128px"/> 
    </div><br>
    <div class="control-group">
        <?php echo CHtml::label("Alamat Pasien", 'alamat_pasien', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textArea('alamat_pasien',$modPasien->alamat_pasien,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>

<?php 
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPasien',
    'options'=>array(
        'title'=>'Pencarian Data Kunjungan Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>480,
        'resizable'=>false,
    ),
));
    $modPasien = new RJInfokunjunganrjV('searchDialogKunjungan');
    $modPasien->unsetAttributes();
    if(isset($_GET['RJInfokunjunganrjV'])) {
        $modPasien->attributes = $_GET['RJInfokunjunganrjV'];
        $modPasien->no_pendaftaran = (isset($_GET['RJInfokunjunganrjV']['no_pendaftaran']) ? $_GET['RJInfokunjunganrjV']['no_pendaftaran'] : "");
        $modPasien->no_rekam_medik = (isset($_GET['RJInfokunjunganrjV']['no_rekam_medik']) ? $_GET['RJInfokunjunganrjV']['no_rekam_medik'] : "");
        $modPasien->nama_pasien = (isset($_GET['RJInfokunjunganrjV']['nama_pasien']) ? $_GET['RJInfokunjunganrjV']['nama_pasien'] : "");
        $modPasien->carabayar_nama = (isset($_GET['RJInfokunjunganrjV']['carabayar_nama']) ? $_GET['RJInfokunjunganrjV']['carabayar_nama'] : "");
        $modPasien->ruangan_nama = (isset($_GET['RJInfokunjunganrjV']['ruangan_nama']) ? $_GET['RJInfokunjunganrjV']['ruangan_nama'] : "");
        $modPasien->jeniskelamin = (isset($_GET['RJInfokunjunganrjV']['jeniskelamin']) ? $_GET['RJInfokunjunganrjV']['jeniskelamin'] : "");
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'datakunjungan-grid',
		'dataProvider'=>$modPasien->searchDialogKunjungan(),
		'filter'=>$modPasien,
		'template'=>"{summary}\n{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
				array(
					'header'=>'Pilih',
					'type'=>'raw',
					'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
									"id" => "selectPendaftaran",
									"onClick" => "
										setKunjungan($data->pendaftaran_id, \"\", \"\");
										$(\"#dialogPasien\").dialog(\"close\");
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
				array(
					'name'=>'jeniskelamin',
					'type'=>'raw',
					'filter'=>LookupM::model()->getItems('jeniskelamin'),
				),
				array(
					'name'=>'instalasi_id',
					'value'=>'$data->instalasi_nama',
					'type'=>'raw',
					'filter'=>CHtml::activeHiddenField($modPasien,'instalasi_id'),
				),
				array(
					'name'=>'ruangan_nama',
					'type'=>'raw',
				),
				array(
					'name'=>'carabayar_nama',
					'type'=>'raw',
					'value'=>'$data->carabayar_nama',
				),
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

$this->endWidget();
////======= end pendaftaran dialog =============
?>