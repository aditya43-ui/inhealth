

<table width="100%" class="">
	<tr>
		<td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran',array('class'=>'control-label')); ?></td>
		<td><?php echo CHtml::textField('BKPendaftaranT[tgl_pendaftaran]', $modPendaftaran->tgl_pendaftaran, array('readonly'=>true)); ?></td>

		<td>
			<?php //echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); ?>
			<label class="control-label required">No. Rekam Medik <span class="required">*</span></label>
		</td>
		<td>
			<?php 
            if (isset($_GET['idBayarUangMuka'])) {
                echo CHtml::textField('BKPasienM[no_rekam_medik]', $modPasien->no_rekam_medik, array('readonly'=>true));
            } else {
				$this->widget('MyJuiAutoComplete', array(
								'name'=>'BKPasienM[no_rekam_medik]',
								'value'=>$modPasien->no_rekam_medik,
								'source'=>'js: function(request, response) {
											   $.ajax({
												   url: "'.$this->createUrl('DaftarPasienBatalUangMuka').'",
												   dataType: "json",
												   data: {
													   term: request.term,
													   cari:"norekammedik",
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
											return false;
										}',
								),
									'htmlOptions'=>array('class'=>'required numbers-only','maxlength'=>6),
							)); 
            }
			?>
		</td>
		<td rowspan="5">
			<?php 
				if(!empty($modPasien->photopasien)){
					echo CHtml::image(Params::urlPhotoPasienDirectory().$modPasien->photopasien, 'photo pasien', array('width'=>120));
				} else {
					echo CHtml::image(Params::urlPhotoPasienDirectory().'no_photo.jpeg', 'photo pasien', array('width'=>120));
				}
			?> 
		</td>
	</tr>
	<tr>
		<td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran',array('class'=>'required control-label')); ?></td>
		<td><?php echo CHtml::textField('BKPendaftaranT[no_pendaftaran]', $modPendaftaran->no_pendaftaran, array('readonly'=>true,'class'=>'required')); ?></td>

		<td><?php echo CHtml::Label("Nama Pasien <font style = 'color:red'>*</font>", 'nama_pasien',array('class'=>'control-label required')); ?></td>
		<td><?php 
        if (isset($_GET['idBayarUangMuka'])) {
            echo CHtml::textField('BKPasienM[nama_pasien]', $modPasien->nama_pasien, array('readonly'=>true)); 
        } else {
		$this->widget('MyJuiAutoComplete', array(
									   'name'=>'BKPasienM[nama_pasien]',
									   'value'=>$modPasien->nama_pasien,
									   'source'=>'js: function(request, response) {
													  $.ajax({
														  url: "'.$this->createUrl('DaftarPasienBatalUangMuka').'",
														  dataType: "json",
														  data: {
															  bataluangmuka:true,
															  cari:"nama",
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
//                                                       loadPembayaran(ui.item.pendaftaran_id);
												   return false;
											   }',
									   ),
												'htmlOptions'=>array('class'=>'required hurufs-only'),
								   )); 
        }
			   ?></td>
	</tr>
	<tr>
		<td><?php echo CHtml::activeLabel($modPendaftaran, 'umur',array('class'=>'control-label')); ?></td>
		<td><?php echo CHtml::textField('BKPendaftaranT[umur]', $modPendaftaran->umur, array('readonly'=>true)); ?></td>

		<td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin',array('class'=>'control-label')); ?></td>
		<td><?php echo CHtml::textField('BKPasienM[jeniskelamin]', $modPasien->jeniskelamin, array('readonly'=>true)); ?></td>
	</tr>
	<tr>
		<td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id',array('class'=>'control-label')); ?></td>
		<td><?php echo CHtml::textField('BKPendaftaranT[jeniskasuspenyakit_nama]',isset($modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama)?$modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama:'-', array('readonly'=>true)); ?></td>

		<td><?php echo CHtml::activeLabel($modPasien, 'nama_bin',array('class'=>'control-label')); ?></td>
		<td><?php echo CHtml::textField('BKPasienM[nama_bin]', $modPasien->nama_bin, array('readonly'=>true)); ?></td>
	</tr>
	<tr>
		<td><?php echo CHtml::activeLabel($modPendaftaran, 'instalasi_id',array('class'=>'control-label')); ?></td>
		<td>
			<?php echo CHtml::textField('BKPendaftaranT[instalasi_nama]',isset($modPendaftaran->instalasi->instalasi_nama)?$modPendaftaran->instalasi->instalasi_nama:'-', array('readonly'=>true)); ?>
			<?php echo CHtml::hiddenField('BKPendaftaranT[pendaftaran_id]',$modPendaftaran->pendaftaran_id, array('readonly'=>true)); ?>
			<?php echo CHtml::hiddenField('BKPendaftaranT[pasien_id]',$modPendaftaran->pasien_id, array('readonly'=>true)); ?>
			<?php echo CHtml::hiddenField('BKPendaftaranT[pasienadmisi_id]',$modPendaftaran->pasienadmisi_id, array('readonly'=>true)); ?>
		</td>

		<td><?php echo CHtml::activeLabel($modPendaftaran, 'ruangan_id',array('class'=>'control-label')); ?></td>
	   <td><?php echo CHtml::textField('BKPendaftaranT[ruangan_nama]', isset($modPendaftaran->ruangan->ruangan_nama)?$modPendaftaran->ruangan->ruangan_nama:'-', array('readonly'=>true)); ?></td>
	</tr>
</table>

<script type="text/javascript">
function isiDataPasien(data)
{
    $('#BKPendaftaranT_tgl_pendaftaran').val(data.tglpendaftaran);
    $('#BKPendaftaranT_no_pendaftaran').val(data.nopendaftaran);
    $('#BKPendaftaranT_umur').val(data.umur);
    $('#BKPendaftaranT_jeniskasuspenyakit_nama').val(data.jeniskasuspenyakit);
    $('#BKPendaftaranT_instalasi_nama').val(data.namainstalasi);
    $('#BKPendaftaranT_ruangan_nama').val(data.namaruangan);
    $('#BKPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
    $('#BKPendaftaranT_pasien_id').val(data.pasien_id);
    $('#BKPendaftaranT_pasienadmisi_id').val(data.pasienadmisi_id);
    
    $('#BKPasienM_jeniskelamin').val(data.jeniskelamin);
    $('#BKPasienM_no_rekam_medik').val(data.norekammedik);
    $('#BKPasienM_nama_pasien').val(data.namapasien);
    $('#BKPasienM_nama_bin').val(data.namabin);
    
    $('#BKPembatalanUangmukaT_bayaruangmuka_id').val(data.bayaruangmuka_id);
    $('#BKTandabuktikeluarT_jmlkaskeluar').val(formatNumber(data.jumlahuangmuka));
    $('#BKPembatalanUangmukaT_total_uangmuka').val(formatNumber(data.total_uangmuka));
    $('#BKPembatalanUangmukaT_tandabuktibayar_id').val(data.tandabuktibayar_id);
    
    
    $('#BKTandabuktikeluarT_namapenerima').val(data.namapasien);
    $('#BKTandabuktikeluarT_alamatpenerima').val(data.alamatpasien);
    
    $('#BKTandabuktikeluarT_jmlkaskeluar').focus();
    $('#BKTandabuktikeluarT_jmlkaskeluar').select();
    
}
</script>
