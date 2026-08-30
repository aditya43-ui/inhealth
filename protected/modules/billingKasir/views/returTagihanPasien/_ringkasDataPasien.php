<?php $this->widget('bootstrap.widgets.BootAlert'); ?> 

<table style="width: 100%; border: none;">
	<tr>
		<td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran',array('class'=>'control-label')); ?></td>
		<td><?php echo CHtml::textField('BKPendaftaranT[tgl_pendaftaran]', $modPendaftaran->tgl_pendaftaran, array('readonly'=>true)); ?></td>
		<td><div class=" control-label"><?php echo CHtml::Label("Instalasi <span style='color:red'>*</span>", 'instalasi_id',array('class'=>'')); ?></div></td>
		<td>
			<?php
			if(!empty($modPendaftaran->instalasi_id)){
				echo CHtml::textField('BKPendaftaranT[instalasi_id]', $modPendaftaran->instalasi->instalasi_nama, array('readonly'=>true));
			}else{
				echo CHtml::dropDownList('BKPendaftaranT[instalasi_id]', NULL, CHtml::listData($modPendaftaran->Instalasis, 'instalasi_id', 'instalasi_nama'), array('class'=>'required','empty'=>'-- Pilih --', 'onchange'=>'refreshDialogPendaftaran();', 'onkeypress'=>"return $(this).focusNextInputField(event)"));
			}
			?>
		</td>            
		<td rowspan="5">
			<?php echo CHtml::activeHiddenField($modPasien,'photopasien', array('readonly'=>true)); ?>
			<?php 
				 $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory()."kecil_".$modPasien->photopasien : Params::urlPhotoPasienDirectory()."no_photo.jpeg");
			?>
			<img id="photo-preview" src="<?php echo $url_photopasien?>"width="84px"/> 
		</td>
	</tr>
	<tr>
		<td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran',array('class'=>'control-label')); ?></td>
		<td><?php echo CHtml::textField('BKPendaftaranT[no_pendaftaran]', $modPendaftaran->no_pendaftaran, array('readonly'=>true)); ?></td>

		<td>
			<?php //echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); ?>
			<label class="control-label">No. Rekam Medik <span style="color:red">*</span></label>
		</td>
		<td>
			<?php //echo CHtml::textField('BKPasienM[no_rekam_medik]', $modPasien->no_rekam_medik, array('readonly'=>true)); ?>
			<?php 
				if (!empty($modPasien->no_rekam_medik)) { 
				echo CHtml::textField('BKPasienM[no_rekam_medik]', $modPasien->no_rekam_medik, array('readonly'=>true));
				}else{
				$this->widget('MyJuiAutoComplete', array(
								'name'=>'BKPasienM[no_rekam_medik]',
								'value'=>$modPasien->no_rekam_medik,
								'source'=>'js: function(request, response) {
											   $.ajax({
												   url: "'.Yii::app()->createUrl('billingKasir/ActionAutoComplete/daftarPasienInstalasi').'",
												   dataType: "json",
												   data: {
													   term: request.term,
													   instalasiId: $("#BKPendaftaranT_instalasi_id").val(),
												   },
												   success: function (data) {
														   response(data);
												   }
											   })
											}',
								 'options'=>array(
									   'showAnim'=>'fold',
									   'minLength' => 2,
									   'focus'=> 'js:function( event, ui ) {
											$(this).val(ui.item.value);
											return false;
										}',
									   'select'=>'js:function( event, ui ) {
											isiDataPasien(ui.item);
											loadPembayaran(ui.item.pendaftaran_id);
											return false;
										}',
								),
								'tombolDialog'=>array('idDialog'=>'dialogPasien','idTombol'=>'tombolPasienDialog'),
								'htmlOptions'=>array('onfocus'=>'return cekInstalasi();','class'=>'numbers-only span2 required', 
													'placeholder'=>'No. Rekam Medik','onkeypress'=>"return $(this).focusNextInputField(event)"),
							)); 
				}
			?>
		</td>
	</tr>
	<tr>
		<td><?php echo CHtml::activeLabel($modPendaftaran, 'umur',array('class'=>'control-label')); ?></td>
		<td><?php echo CHtml::textField('BKPendaftaranT[umur]', $modPendaftaran->umur, array('readonly'=>true)); ?></td>

		<td><?php echo CHtml::Label("Nama Pasien <span style='color:red;'>*</span>", 'nama_pasien',array('class'=>'control-label')); ?></td>
		<td><?php //echo CHtml::textField('BKPasienM[nama_pasien]', $modPasien->nama_pasien, array('readonly'=>true)); 
				$this->widget('MyJuiAutoComplete', array(
									   'name'=>'BKPasienM[nama_pasien]',
									   'value'=>$modPasien->nama_pasien,
									   'source'=>'js: function(request, response) {
													  $.ajax({
														  url: "'.Yii::app()->createUrl('billingKasir/ActionAutoComplete/daftarPasienberdasarkanNama').'",
														  dataType: "json",
														  data: {
															  daftarpasien:true,
															  term: request.term,
														  },
														  success: function (data) {
																  response(data);
														  }
													  })
												   }',
										'options'=>array(
											  'showAnim'=>'fold',
											  'minLength' => 2,
											  'focus'=> 'js:function( event, ui ) {
												   $(this).val(ui.item.value);
												   return false;
											   }',
											  'select'=>'js:function( event, ui ) {
												   isiDataPasien(ui.item);
												   loadPembayaran(ui.item.pendaftaran_id);
												   return false;
											   }',
									   ),
									   'htmlOptions'=>array('class'=>'required hurufs-only','onfocus'=>'return cekInstalasi();',)
								   )); 
		?></td>
	</tr>
	<tr>
		<td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id',array('class'=>'control-label')); ?></td>
		<td><?php echo CHtml::textField('BKPendaftaranT[jeniskasuspenyakit_nama]',isset($modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama)?$modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama:'-', array('readonly'=>true)); ?></td>

		<td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin',array('class'=>'control-label')); ?></td>
		<td><?php echo CHtml::textField('BKPasienM[jeniskelamin]', $modPasien->jeniskelamin, array('readonly'=>true)); ?></td>   
	</tr>
	<tr>
		<td><?php echo CHtml::activeLabel($modPendaftaran, 'instalasi_id',array('class'=>'control-label')); ?></td>
		<td>
			<?php echo CHtml::textField('BKPendaftaranT[instalasi_nama]',isset($modPendaftaran->instalasi->instalasi_nama)?$modPendaftaran->instalasi->instalasi_nama:'-', array('readonly'=>true)); ?>
			<?php echo CHtml::hiddenField('BKPendaftaranT[pendaftaran_id]',$modPendaftaran->pendaftaran_id, array('readonly'=>true)); ?>
			<?php echo CHtml::hiddenField('BKPendaftaranT[pasien_id]',$modPendaftaran->pasien_id, array('readonly'=>true)); ?>
			<?php echo CHtml::hiddenField('BKPendaftaranT[pasienadmisi_id]',$modPendaftaran->pasienadmisi_id, array('readonly'=>true)); ?>
		</td>

		<td><?php echo CHtml::activeLabel($modPasien, 'nama_bin',array('class'=>'control-label')); ?></td>
		<td><?php echo CHtml::textField('BKPasienM[nama_bin]', $modPasien->nama_bin, array('readonly'=>true)); ?></td>
	</tr>
	<tr>
        <td><?php echo CHtml::activeLabel($modPendaftaran, 'penjamin_id',array('class'=>'control-label')); ?></td>
		<td><?php echo CHtml::textField('BKPendaftaranT[penjamin_nama]', isset($modPendaftaran->penjamin->penjamin_nama)?$modPendaftaran->penjamin->penjamin_nama:'-', array('readonly'=>true)); ?></td>

		<td><?php echo CHtml::activeLabel($modPendaftaran, 'ruangan_id',array('class'=>'control-label')); ?></td>
		<td><?php echo CHtml::textField('BKPendaftaranT[ruangan_nama]', isset($modPendaftaran->ruangan->ruangan_nama)?$modPendaftaran->ruangan->ruangan_nama:'-', array('readonly'=>true)); ?></td>
	</tr>
    <tr>
        <td><?php echo CHtml::activeLabel($modPendaftaran, 'carabayar_id',array('class'=>'control-label')); ?></td>
		<td><?php echo CHtml::textField('BKPendaftaranT[carabayar_nama]', isset($modPendaftaran->carabayar->carabayar_nama)?$modPendaftaran->carabayar->carabayar_nama:'-', array('readonly'=>true)); ?></td>
		<td></td>
		<td></td>
	</tr>
</table>
<?php 
//========= Dialog buat cari data pendaftaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPasien',
    'options'=>array(
        'title'=>'Pencarian Data Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>1000,
        'height'=>700,
        'resizable'=>false,
    ),
));
    $modDialogPasien = new BKPasienM('searchPasienRumahsakitV');
    $modDialogPasien->unsetAttributes();
    if(isset($_GET['BKPasienM'])) {
        $modDialogPasien->attributes = $_GET['BKPasienM'];
        $modDialogPasien->idInstalasi = isset($_GET['BKPasienM']['idInstalasi'])?$_GET['BKPasienM']['idInstalasi']:'';
        $modDialogPasien->no_pendaftaran = isset($_GET['BKPasienM']['no_pendaftaran'])?$_GET['BKPasienM']['no_pendaftaran']:'';
        $modDialogPasien->tgl_pendaftaran_cari = isset($_GET['BKPasienM']['tgl_pendaftaran_cari'])?$_GET['BKPasienM']['tgl_pendaftaran_cari']:'';
        $modDialogPasien->instalasi_nama = isset($_GET['BKPasienM']['instalasi_nama'])?$_GET['BKPasienM']['instalasi_nama']:'';
        $modDialogPasien->carabayar_nama = isset($_GET['BKPasienM']['carabayar_nama'])?$_GET['BKPasienM']['carabayar_nama']:'';
        $modDialogPasien->ruangan_nama = isset($_GET['BKPasienM']['ruangan_nama'])?$_GET['BKPasienM']['ruangan_nama']:'';
        $modDialogPasien->nopembayaran = isset($_GET['BKPasienM']['nopembayaran'])?$_GET['BKPasienM']['nopembayaran']:'';
        $modDialogPasien->nobuktibayar = isset($_GET['BKPasienM']['nobuktibayar'])?$_GET['BKPasienM']['nobuktibayar']:'';
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pendaftaran-t-grid',
            'dataProvider'=>$modDialogPasien->searchPasienSudahBayar(),
            'filter'=>$modDialogPasien,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            $(\"#dialogPasien\").dialog(\"close\");
                                            $(\"#BKPendaftaranT_tgl_pendaftaran\").val(\"".MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."\");
                                            $(\"#BKPendaftaranT_no_pendaftaran\").val(\"$data->no_pendaftaran\");
                                            $(\"#BKPendaftaranT_umur\").val(\"$data->umur\");
                                            $(\"#BKPendaftaranT_jeniskasuspenyakit_nama\").val(\"$data->jeniskasuspenyakit_nama\");
                                            $(\"#BKPendaftaranT_instalasi_id\").val(\"$data->instalasi_id\");
                                            $(\"#BKPendaftaranT_instalasi_nama\").val(\"$data->instalasi_nama\");
                                            $(\"#BKPendaftaranT_ruangan_nama\").val(\"$data->ruangan_nama\");
                                            $(\"#BKPendaftaranT_pendaftaran_id\").val(\"$data->pendaftaran_id\");
                                            $(\"#BKPendaftaranT_carabayar_id\").val(\"$data->carabayar_id\");
                                            $(\"#BKPendaftaranT_penjamin_id\").val(\"$data->penjamin_id\");
                                            $(\"#BKPendaftaranT_kelaspelayanan_id\").val(\"$data->kelaspelayanan_id\");
                                            $(\"#BKPendaftaranT_pasien_id\").val(\"$data->pasien_id\");
                                            $(\"#BKTandabuktibayarUangMukaT_darinama_bkm\").val(\"$data->nama_pasien\");

                                            $(\"#BKPasienM_jeniskelamin\").val(\"$data->jeniskelamin\");
                                            $(\"#BKPasienM_no_rekam_medik\").val(\"$data->no_rekam_medik\");
                                            $(\"#BKPasienM_nama_pasien\").val(\"$data->nama_pasien\");
                                            $(\"#BKPasienM_nama_bin\").val(\"$data->nama_bin\");
                                            $(\"#BKPendaftaranT_carabayar_nama\").val(\"$data->carabayar_nama\");
                                            $(\"#BKPendaftaranT_penjamin_nama\").val(\"$data->penjamin_nama\");
                                            loadPembayaran($data->pembayaran_id);

                                        "))',
                    ),
                    array(
                        'header'=>'Tgl. Pembayaran',
                        'name'=>'tglpembayaran',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglpembayaran)',
                        'filter'=>CHtml::activeHiddenField($modDialogPasien, 'idInstalasi'),
                    ),
                    array(
                        'header'=>'No. Pembayaran',
                        'name'=>'nopembayaran',
                        'filter'=>Chtml::activeTextField($modDialogPasien, 'nopembayaran', array('class'=>'angkahuruf-only'))
                    ),
                    array(
                        'header'=>'No.Kuitansi',
                        'name'=>'nobuktibayar',
                        'filter'=>Chtml::activeTextField($modDialogPasien, 'nobuktibayar', array('class'=>'angkahuruf-only'))
                    ),
                    array(
                        'name'=>'tgl_pendaftaran',
                        'filter'=>false,
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                        //CHtml::activeTextField($modDialogPasien, 'tgl_pendaftaran_cari', array('placeholder'=>'contoh: 15 Jan 2013')),
                    ),
                     array(
                        'name'=>'no_pendaftaran',
                        'type'=>'raw',
                        'value'=>'$data->no_pendaftaran',
                        'filter'=>Chtml::activeTextField($modDialogPasien, 'no_pendaftaran', array('class'=>'angkahuruf-only'))
                    ),
                   array(
                        'name'=>'no_rekam_medik',
                        'type'=>'raw',
                        'value'=>'$data->no_rekam_medik',
                        'filter'=>Chtml::activeTextField($modDialogPasien, 'no_rekam_medik', array('class'=>'numbers-only'))
                    ),
                    array(
                        'name'=>'nama_pasien',
                        'type'=>'raw',
                        'value'=>'$data->namadepan." ".$data->nama_pasien',
                        'filter'=>Chtml::activeTextField($modDialogPasien, 'nama_pasien', array('class'=>'hurufs-only'))
                    ),
                    array(
                        'name'=>'jeniskelamin',
                        'filter'=>  CHtml::activeDropDownList($modDialogPasien, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('empty'=>'-- Pilih --')),
                    ), /*
                    array(
                        'name'=>'instalasi_nama',
                        'type'=>'raw',
                    ), */
                    array(
                        'name'=>'ruangan_nama',
                        'type'=>'raw',
                    ), 
                    array(
                        'name'=>'carabayar_nama',
                        'type'=>'raw',
                        'value'=>'$data->carabayar_nama',
                        'filter'=>CHtml::activeDropDownList($modDialogPasien, 'carabayar_nama', CHtml::listData(CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true)), 'carabayar_nama', 'carabayar_nama'),array('empty'=>'-- Pilih --')),
                    ),

            ),
              'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
        . '$(".numbers-only").keyup(function() {
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

<script type="text/javascript">
function isiDataPasien(data)
{
    // console.log(data);
    $('#BKPendaftaranT_tgl_pendaftaran').val(data.tgl_pendaftaran);
    $('#BKPendaftaranT_no_pendaftaran').val(data.no_pendaftaran);
    $('#BKPendaftaranT_umur').val(data.umur);
    $('#BKPendaftaranT_jeniskasuspenyakit_nama').val(data.jeniskasuspenyakit);
    $('#BKPendaftaranT_instalasi_nama').val(data.namainstalasi);
    $('#BKPendaftaranT_ruangan_nama').val(data.namaruangan);
    $('#BKPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
    $('#BKPendaftaranT_pasien_id').val(data.pasien_id);
    $('#BKPendaftaranT_pasienadmisi_id').val(data.pasienadmisi_id);
    if (typeof data.norekammedik !=  'undefined'){
        $('#BKPasienM_no_rekam_medik').val(data.norekammedik);
    }
    $('#BKPasienM_jeniskelamin').val(data.jeniskelamin);
    $('#BKPasienM_nama_pasien').val(data.namapasien);
    $('#BKPasienM_nama_bin').val(data.namabin);
    
    //$('#BKTandabuktibayarUangMukaT_jmlpembayaran').focus();
    //$('#BKTandabuktibayarUangMukaT_jmlpembayaran').select();    
}

function loadPembayaran(idPembayaran)
{
    $.get('<?php echo $this->createUrl('index');?>', {idPembayaran:idPembayaran, ajax_retur: 1}, function(data){
        $("#BKReturbayarpelayananT_totaloaretur, #oa_limit").val(formatNumber(data.retur.totaloaretur));
        // $("#BKReturbayarpelayananT_totaltindakanretur, #tindakan_limit").val(formatNumber(data.retur.totaltindakanretur));
        $("#BKReturbayarpelayananT_totaltindakanretur, #tindakan_limit").val(formatNumber(data.pembebasan.jmlpembebasan));
        $("#BKReturbayarpelayananT_tandabuktibayar_id").val(data.retur.tandabuktibayar_id);
        $("#BKTandabuktikeluarT_namapenerima").val(data.pasien.no_rekam_medik + " - " + data.pasien.namadepan + data.pasien.nama_pasien);
        $("#BKTandabuktikeluarT_alamatpenerima").val(data.pasien.alamat_pasien);
        $("#BKPasienM_tanggal_lahir").val(data.pasien.tanggal_lahir);
        $("#BKPasienM_alamat_pasien").val(data.pasien.alamat_pasien);
        $("#BKPendaftaranT_penjamin_id").val(data.pendaftaran.penjamin_id);
        $("#BKPendaftaranT_carabayar_id").val(data.pendaftaran.carabayar_id);
        
        hitungTotalRetur();
        
        if(data.photopasien != ""){ //set photo
            $("#<?php echo CHtml::activeId($modPasien,"photopasien");?>").val(data.photopasien);            
            $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
        }else{
            $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
        }
    }, 'json');
}

function refreshDialogPendaftaran(){
    var instalasiId = $("#BKPendaftaranT_instalasi_id").val();
    var instalasiNama = $("#BKPendaftaranT_instalasi_id option:selected").text();
    $.fn.yiiGridView.update('pendaftaran-t-grid', {
        data: {
            "BKPasienM[idInstalasi]":instalasiId,
            "BKPasienM[instalasi_nama]":instalasiNama,
        }
    });
}
    
function cekInstalasi(){
    var instalasiId = $("#BKPendaftaranT_instalasi_id").val();
    if(instalasiId.length > 0){
        return true;
    }else{
        myAlert("Silakan pilih instalasi ! ");
        $("#BKPendaftaranT_instalasi_id").focus();
        return false;
    }
}

</script>