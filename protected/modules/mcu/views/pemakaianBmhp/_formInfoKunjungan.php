<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("No. Pendaftaran <span class='required'>*</span>", 'no_pendaftaran', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('pendaftaran_id',$modKunjungan->pendaftaran_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
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
								ruangan_id: $("#ruangan_id").val(),
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
							$(this).val( ui.item.no_pendaftaran);
							setKunjungan(ui.item.pasienmasukpenunjang_id);
							return false;
						}',
					),
					'tombolDialog'=>array('idDialog'=>'dialogKunjungan'),
					'htmlOptions'=>array('placeholder'=>'No. Pendaftaran','class'=>'all-caps alphanumeric-only','rel'=>'tooltip','title'=>'No. Pendaftaran',
						'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
					),
				)); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Tgl. Pendaftaran <span class='required'>*</span>", 'tgl_pendaftaran', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tgl_pendaftaran',$modKunjungan->tgl_pendaftaran,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Kelas Pelayanan", 'kelaspelayanan_id', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('kelaspelayanan_id',$modKunjungan->kelaspelayanan_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('kelaspelayanan_nama',$modKunjungan->kelaspelayanan_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Kasus Penyakit", 'jeniskasuspenyakit_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('jeniskasuspenyakit_id',$modKunjungan->jeniskasuspenyakit_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('jeniskasuspenyakit_nama',$modKunjungan->jeniskasuspenyakit_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <?php echo CHtml::label('Jenis Penjamin', 'carabayar_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('carabayar_id',$modKunjungan->carabayar_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('carabayar_nama',$modKunjungan->carabayar_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Penjamin", 'penjamin_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('penjamin_id',$modKunjungan->penjamin_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('penjamin_nama',$modKunjungan->penjamin_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("No. Rekam Medik", 'no_rekam_medik', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('pasien_id',$modKunjungan->pasien_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
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
								ruangan_id: $("#ruangan_id").val(),
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
							$(this).val( ui.item.no_rekam_medik);
							setKunjungan(ui.item.pasienmasukpenunjang_id);
							return false;
						}',
					),
					'htmlOptions'=>array('placeholder'=>'No. Rekam Medik','class'=>'all-caps numbers-only','rel'=>'tooltip','title'=>'No. rekam medik untuk mencari data kunjungan',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
					),
				)); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nama Pasien", 'nama_pasien', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('namadepan',$modKunjungan->namadepan,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php 
                $this->widget('MyJuiAutoComplete', array(
					'name'=>'nama_pasien',
					'value'=>$modKunjungan->nama_pasien,
					'source'=>'js: function(request, response) {
						$.ajax({
							url: "'.$this->createUrl('AutocompleteKunjungan').'",
							dataType: "json",
							data: {
								nama_pasien: request.term,
								ruangan_id: $("#ruangan_id").val(),
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
							$(this).val( ui.item.nama_pasien);
							setKunjungan(ui.item.pasienmasukpenunjang_id);
							return false;
						}',
					),
					'htmlOptions'=>array('class' => 'hurufs-only', 'placeholder'=>'Nama Pasien','rel'=>'tooltip','title'=>'Ketik nama pasien untuk mencari data kunjungan',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
					),
				)); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Alias', 'nama_bin', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('nama_bin',$modKunjungan->nama_bin,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Lahir', 'tanggal_lahir', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tanggal_lahir',$modKunjungan->tanggal_lahir,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Umur", 'umur', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('umur',$modKunjungan->umur,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Kelamin", 'jeniskelamin', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('jeniskelamin',$modKunjungan->jeniskelamin,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    
<!--<div class="control-group">
        <?php echo CHtml::label("Nama Penanggung Jawab", 'nama_pj', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('penanggungjawab_id',$modKunjungan->penanggungjawab_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('nama_pj',$modKunjungan->nama_pj,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Status Penanggung Jawab", 'pengantar', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('pengantar',$modKunjungan->pengantar,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>-->
    <div class="control-group">
        <?php echo CHtml::label("Alamat Pasien", 'alamat_pasien', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textArea('alamat_pasien',$modKunjungan->alamat_pasien,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div style="text-align: center;">
        <?php 
        $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory()."kecil_".$modPasien->photopasien : Params::urlPhotoPasienDirectory()."no_photo.jpeg");
        ?>
        <img id="photo-preview" src="<?php echo $url_photopasien?>"width="128px"/> 
    </div><br>    
</div>

<?php 
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogKunjungan',
    'options'=>array(
        'title'=>'Pencarian Data Kunjungan Pasien '.Yii::app()->user->getState('ruangan_nama'),
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>1100,
        'height'=>620,
        'resizable'=>false,
    ),
));
    $modDialogKunjungan = new MCInfokunjunganmcuV();
    $modDialogKunjungan->unsetAttributes();
    $modKunjungan2 = clone $modDialogKunjungan;
    if(isset($_GET['MCInfokunjunganmcuV'])) {
        $modDialogKunjungan->attributes = $_GET['MCInfokunjunganmcuV'];
        if (!empty($_GET['MCInfokunjunganmcuV']['tgl_pendaftaran'])) {
            $tanggal = explode(" - ",$_GET['MCInfokunjunganmcuV']['tgl_pendaftaran'] );
            $modDialogKunjungan->tgl_awal = MyFormatter::formatDateTimeForDb(trim($tanggal[0]));
            $modDialogKunjungan->tgl_akhir = MyFormatter::formatDateTimeForDb(trim($tanggal[1]));
            $modKunjungan2->tgl_pendaftaran = $_GET['MCInfokunjunganmcuV']['tgl_pendaftaran'];
        }
    }
    
    
    $cri = new CDbCriteria();
        $ruangan = array();
    

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'datakunjungan-grid',
            'dataProvider'=>$modDialogKunjungan->searchDaftarPasienMCUDialog(),
            'filter'=>$modDialogKunjungan,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectKunjungan",
                                        "onClick" => "
                                            setKunjungan($data->pendaftaran_id);
                                            $(\"#dialogKunjungan\").dialog(\"close\");
                                        "))',
                    ),
                    array(
                        'header' => 'No. Pendaftaran',
                        'name' => 'no_pendaftaran',
                        'value' => '$data->no_pendaftaran',
                        'filter' => Chtml::activeTextField($modDialogKunjungan, 'no_pendaftaran', array('class' => 'alphanumeric-only'))
                    ),                        
                    array(
                        'name'=>'tgl_pendaftaran',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                        'filter'=>CHtml::activeTextField($modKunjungan2, 'tgl_pendaftaran', array('style' => 'text-align:center','readonly'=>true)),
                    ),
                    array(
                        'header' => 'No. Rekam Medik',
                        'name' => 'no_rekam_medik',
                        'value' => '$data->no_rekam_medik',
                        'filter' => Chtml::activeTextField($modDialogKunjungan, 'no_rekam_medik', array('class' => 'numbers-only'))
                    ),                    
                    array(
                        'header' => 'Nama Pasien',
                        'name' => 'nama_pasien',
                        'value' => '$data->namadepan." ".$data->nama_pasien',
                        'filter' => Chtml::activeTextField($modDialogKunjungan, 'nama_pasien', array('class' => 'hurufs-only'))
                    ),                      
                    array(
                        'header' => 'Jenis Kelamin',
                        'name'=>'jeniskelamin',
                        'type'=>'raw',
                        'filter'=> CHtml::dropDownList('MCInfokunjunganmcuV[jeniskelamin]',$modDialogKunjungan->jeniskelamin,LookupM::model()->getItems('jeniskelamin'), array('empty'=>'-- Pilih --')),
                    ),                       
                    array(
                        'header'=>'Jenis Penjamin',
                        'name'=>'carabayar_id',
                        'type'=>'raw',
                        'value'=>'$data->carabayar_nama',
                        'filter'=> CHtml::dropDownList('MCInfokunjunganmcuV[carabayar_id]',$modDialogKunjungan->carabayar_id, CHtml::listData(CarabayarM::model()->findAll("carabayar_aktif = TRUE ORDER BY carabayar_nama ASC"),'carabayar_id','carabayar_nama'), array('empty'=>'-- Pilih --')),
                    ),
                    array(
                        'header' => 'Status Periksa',
                        'name' => 'statusperiksa',
                        'filter' => Chtml::activeDropDownList($modDialogKunjungan, 'statusperiksa', LookupM::getItems('statusperiksa'), array('empty' => '-- Pilih -- '))
                    ),

            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
                . '$(".alphanumeric-only").keyup(function(){'
                . ' setAlphaNumericOnly(this);'
                . '});'
                . '$(".numbers-only-only").keyup(function(){'
                . ' setNumbersOnly(this);'
                . '});'
                . '$(".hurufs-only").keyup(function(){'
                . ' setHurufsOnly(this);'
                . '});'
                . 'setPickerRangeTanggal();'
        . '}',
    ));

$this->endWidget();
////======= end pendaftaran dialog =============
?>