<tr>
	<td>
		<div class="panel panel-warning">
			<div class="panel-heading">
					<div class="panel-title">
						Poli Tujuan Ke-<span name="[ii][judul]"></span>
					</div>
			</div>
			<div class="panel-body">
				<?php echo CHtml::hiddenField('nourut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;','disabled'=>'disabled')); ?>
				<div class='control-group'>
					<?php echo CHtml::label("Poliklinik <span class='not-required'>*</span>", CHtml::activeId($modPendaftaranMultiPoli,'[ii]ruangan_id'),array('class'=>'control-label not-required'))?>                                   
					<div class='controls'>
						<?php echo CHtml::activeDropDownList($modPendaftaranMultiPoli,'[ii]ruangan_id', CHtml::listData($modPendaftaranMultiPoli->getRuanganItems(Params::INSTALASI_ID_RJ), 'ruangan_id', 'ruangan_nama') ,
												array('empty'=>'-- Pilih --','onchange'=>'setDropdownJeniskasuspenyakitMultiPoli(this); setDropdownDokterMultiPoli(this);',
											'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3'
											)); ?>  
					</div>
				</div>
				<div class="control-group">
					<label class="control-label not-required">
						Jenis Kasus Penyakit <span class="not-required">*</span>
					</label>
					<div class="controls">
						<?php echo CHtml::activeDropDownList($modPendaftaranMultiPoli,'[ii]jeniskasuspenyakit_id', CHtml::listData($modPendaftaranMultiPoli->getJenisKasusPenyakitItems(), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama') ,
											array('empty'=>'-- Pilih --',
												'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3'
											)); ?>
					</div>
				</div>
				<div class="control-group">
					<label for="PPPendaftaranT_pegawai_id" class="control-label not-required">
						Dokter <span class="not-required">*</span>
					</label>
					<div class="controls">
						<?php echo CHtml::activeDropDownList($modPendaftaranMultiPoli,'[ii]pegawai_id', CHtml::listData($modPendaftaranMultiPoli->getDokterItems($modPendaftaranMultiPoli->ruangan_id), 'pegawai_id', 'nama_pegawai') ,array('onchange'=>'setAntrianDokter();','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
					</div>
				</div>
				<div class="control-group ">
					<label class="control-label" for=""></label>
					<div class="controls">
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
						<?php echo ($removeButton==false)?"&nbsp; &nbsp; &nbsp; &nbsp;":""; ?>
						<?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
								array('onclick'=>'addRowMultipoli(this);return false;',
										'class'=>'btn btn-primary',
										'onkeypress'=>"addRowMultipoli(this);return false;",
										'rel'=>"tooltip")); ?>
					
						
						<?php echo ($removeButton==true)?
								CHtml::htmlButton('<i class="icon-minus icon-white"></i>',
								array('onclick'=>'delRowMultipoli(this);return false;',
										'class'=>'btn btn-danger',
										'onkeypress'=>"delRowMultipoli(this);return false;",
										'rel'=>"tooltip")):"";?>
					</div>
				</div>
			</div>	
		</div>
		<br>
	</td>
</tr>