<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("Instalasi <span style = 'color:red;'>*</span>", 'instalasi_id', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php 
            if(!empty($modKunjungan->pendaftaran_id)){
                echo CHtml::hiddenField('instalasi_id',$modKunjungan->instalasi_id,array('readonly'=>true,'class'=>'span3 required', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                echo CHtml::textField('instalasi_nama',$modKunjungan->instalasi_nama,array('readonly'=>true,'class'=>'span3 required', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
            }else{
                echo CHtml::dropDownList('instalasi_id',$modKunjungan->instalasi_id,CHtml::listData(BKInstalasiM::model()->getInstalasiPenunjangs(),'instalasi_id','instalasi_nama'),array('empty'=>'-- Pilih --','onchange'=>'setKunjunganReset();refreshDialogKunjungan();','class'=>'span3 required','onkeyup'=>"return $(this).focusNextInputField(event)",)); 
            }
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Barcode", 'cari_pendaftaran_id', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('cari_pendaftaran_id',$modKunjungan->pendaftaran_id,array('onchange'=>"if($(this).val()=='') setKunjunganReset(); else setKunjungan(this.value,'','','')",'class'=>'span3', 'placeholder'=>'Scan Barcode pada Print Status','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("No. Pendaftaran", 'no_pendaftaran', array('class'=>'control-label')); ?>
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
							setKunjungan(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, "");
							return false;
						}',
					),
					'tombolDialog'=>array('idDialog'=>'dialogKunjungan'),
					'htmlOptions'=>array('placeholder'=>'No. Pendaftaran','class'=>'all-caps angkahuruf-only','rel'=>'tooltip','title'=>'No. pendaftaran / klik icon untuk mencari data kunjungan',
						'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
					),
				)); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Pendaftaran', 'tgl_pendaftaran', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tgl_pendaftaran',$modKunjungan->tgl_pendaftaran,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::hiddenField('tglselesaiperiksa',$modKunjungan->tglselesaiperiksa,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Ruangan Terakhir", 'ruangan_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('ruangan_id',$modKunjungan->getPenunjangAkhir()->ruangan_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('ruangan_nama',$modKunjungan->getPenunjangAkhir()->ruangan_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
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
	<div class="control-group">
        <?php echo CHtml::label("Alamat Pasien", 'alamat_pasien', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textArea('alamat_pasien',$modKunjungan->alamat_pasien,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>    
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("No. Rekam Medik", 'no_rekam_medik', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('pasien_id',$modKunjungan->pasien_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php // echo CHtml::textField('no_rekam_medik',$modKunjungan->no_rekam_medik,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
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
						'minLength' => 4,
						'focus'=> 'js:function( event, ui ) {
							$(this).val( "");
							return false;
						}',
						'select'=>'js:function( event, ui ) {
							$(this).val( ui.item.value);
							setKunjungan(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, "");
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
								setKunjungan(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, "");
								return false;
							}',
					),
					'htmlOptions'=>array('class'=>'hurufs-only','placeholder'=>'Nama Pasien','rel'=>'tooltip','title'=>'Ketik nama pasien untuk mencari data kunjungan',
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
    <div class="control-group">
        <?php echo CHtml::label("Nama Penanggung Jawab", 'nama_pj', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('penanggungjawab_id',$modKunjungan->penanggungjawab_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('nama_pj',$modKunjungan->nama_pj,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
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
        'title'=>'Pencarian Data Pasien Penunjang',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>480,
        'resizable'=>false,
    ),
));
    $modDialogKunjungan = new BKRinciantagihanpasienpenunjangV();
    $modDialogKunjungan->unsetAttributes();
    $modDialogKunjungan->instalasi_id = $modKunjungan->instalasi_id;
    if(isset($_GET['BKRinciantagihanpasienpenunjangV'])) {
        $modDialogKunjungan->attributes = $_GET['BKRinciantagihanpasienpenunjangV'];
        $modDialogKunjungan->instalasi_id = $_GET['BKRinciantagihanpasienpenunjangV']['instalasi_id'];
		if (isset($_GET['BKRinciantagihanpasienpenunjangV']['statusperiksa'])) 
			$modDialogKunjungan->statusperiksa = $_GET['BKRinciantagihanpasienpenunjangV']['statusperiksa'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'datakunjungan-grid',
		'dataProvider'=>$modDialogKunjungan->searchRincianTagihan(),
		'filter'=>$modDialogKunjungan,
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
						$(\"#dialogKunjungan\").dialog(\"close\");
					")
				)',
			),                    
			array(
				'header' => 'No. Pendaftaran',
				'name' => 'no_pendaftaran',
				'filter' => Chtml::activeTextField($modDialogKunjungan, 'no_pendaftaran', array('class'=>'angkahuruf-only'))
			),
			array(
				'name'=>'tgl_pendaftaran',
				'type'=>'raw',
				'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
				'filter'=>CHtml::activeHiddenField($modDialogKunjungan,'instalasi_id', array('readonly'=>true)),//instalasi_id untuk pencarian ruangan_id
			),
			array(
				'header'=>'No. Rekam Medik',
				'name'=>'no_rekam_medik',
				'type'=>'raw',
				'value'=>'$data->no_rekam_medik',
				'filter' => Chtml::activeTextField($modDialogKunjungan, 'no_rekam_medik', array('class'=>'numbers-only'))
			),
			array(
				'header' => 'Nama Pasien',
				'name' => 'nama_pasien',
				'value' => '$data->namadepan." ".$data->nama_pasien',
				'filter' => Chtml::activeTextField($modDialogKunjungan, 'nama_pasien', array('class'=>'hurufs-only'))
			),
		   /* array(
				'name'=>'jeniskelamin',
				'type'=>'raw',
				'filter'=>LookupM::model()->getItems('jeniskelamin'),
			),*/
			array(
				'header'=>'Jenis Penjamin',
				'name'=>'carabayar_nama',
				'filter'=>  CHtml::activeDropDownList($modDialogKunjungan, 'carabayar_nama', CHtml::listData(
			   CarabayarM::model()->findAll(array(
				   'condition' => 'carabayar_aktif = true',
				   'order' => 'carabayar_nama',
			   )), 'carabayar_nama', 'carabayar_nama'
			   ), array('empty'=>'-- Pilih --')),
			),
			array(
				'header'=>'Penjamin',
				'name'=>'penjamin_nama',
				'filter'=>false,
			),
			array(
				'header'=>'Status Periksa',
				'name'=>'statusperiksa',
				'filter'=>CHtml::activeDropDownList($modDialogKunjungan, 'statusperiksa', Params::statusPeriksa(), array('empty'=>'-- Pilih --')),
			),
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
	. ' $(".numbers-only").keyup(function() {
			setNumbersOnly(this);
		});
		$(".hurufs-only").keyup(function() {
			setHurufsOnly(this);
		});
		$(".angkahuruf-only").keyup(function() {
			setAngkaHurufOnly(this);
		});'
	. '}',
    ));

$this->endWidget();
////======= end pendaftaran dialog =============
?>