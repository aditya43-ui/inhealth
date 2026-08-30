<?php
foreach ($modInformasiVisite as $i=>$detail): 
?>
<tr>
    <td>
		<?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modTindakans,'['.$i.']pasienadmisi_id',array('readonly'=>true,'class'=>'span1','value'=>  isset($detail->pasienadmisi_id) ? $detail->pasienadmisi_id : null )); ?>
        <?php echo CHtml::activeHiddenField($modTindakans,'['.$i.']pasien_id',array('readonly'=>true,'class'=>'span1','value'=>  isset($detail->pasien_id) ? $detail->pasien_id : null )); ?>
        <?php echo CHtml::activeHiddenField($modTindakans,'['.$i.']pendaftaran_id',array('readonly'=>true,'class'=>'span1','value'=>  isset($detail->pendaftaran_id) ? $detail->pendaftaran_id : null )); ?>
        <?php echo CHtml::activeHiddenField($modTindakans,'['.$i.']carabayar_id',array('readonly'=>true,'class'=>'span1','value'=>  isset($detail->carabayar_id) ? $detail->carabayar_id : null )); ?>
        <?php echo CHtml::activeHiddenField($modTindakans,'['.$i.']jeniskasuspenyakit_id',array('readonly'=>true,'class'=>'span1','value'=>  isset($detail->jeniskasuspenyakit_id) ? $detail->jeniskasuspenyakit_id : null )); ?>
        <?php echo CHtml::activeHiddenField($modTindakans,'['.$i.']penjamin_id',array('readonly'=>true,'class'=>'span1','value'=>  isset($detail->penjamin_id) ? $detail->penjamin_id : null )); ?>		
        <?php echo CHtml::activeHiddenField($detail,'['.$i.']kelaspelayanan_id',array('readonly'=>true,'class'=>'span1','value'=>  isset($detail->kelaspelayanan_id) ? $detail->kelaspelayanan_id : null )); ?>
        <?php echo CHtml::activeHiddenField($detail,'['.$i.']pegawai_id',array('readonly'=>true,'class'=>'span1','value'=>  isset($pegawai_id) ? $pegawai_id : null )); ?>
        <?php echo (!empty($detail->tglAdmisiMasukKamar) ? $detail->tglAdmisiMasukKamar : "") ?>
    </td>
    <td>
        <?php echo (!empty($detail->no_pendaftaran) ? MyFormatter::formatDateTimeForUser($detail->tgl_pendaftaran)."/<br>".$detail->no_pendaftaran : "") ?>
    </td>
    <td>
        <?php echo (!empty($detail->no_rekam_medik) ? $detail->no_rekam_medik : "") ?>
    </td>
    <td>
        <?php echo (!empty($detail->nama_pasien) ? $detail->namadepan.$detail->nama_pasien : "") ?>
    </td>
    <td>
        <?php echo (!empty($detail->jeniskelamin) ? $detail->jeniskelamin : "") ?>
    </td>
    <td>
        <?php echo (!empty($detail->caraBayarPenjamin) ? $detail->caraBayarPenjamin : "") ?>
    </td>
	<td>
        <?php echo (!empty($detail->kamarruangan_id)) ? $detail->kamarruangan_nokamar.":".$detail->kamarruangan_nobed : ""; ?>/<br>
        <?php echo (!empty($detail->kelaspelayanan_nama) ? $detail->kelaspelayanan_nama : "") ?>
    </td>
	<td>
        <?php echo (!empty($detail->jeniskasuspenyakit_nama) ? $detail->jeniskasuspenyakit_nama : "") ?>
    </td>
	<td>
        <?php echo (!empty($detail->nama_pegawai) ? $detail->gelardepan." ".$detail->nama_pegawai." ".$detail->gelarbelakang_nama : "") ?>
    </td>
	<td>
		<?php
                
			echo CHtml::dropDownList("RITindakanPelayananT[".$i."][daftartindakan_id]",$jenis_visite,
				CHtml::listdata(RIDaftarTindakanM::model()->findAll('daftartindakan_visite=TRUE AND daftartindakan_aktif = TRUE ORDER BY daftartindakan_nama ASC'),"daftartindakan_id","daftartindakan_nama"),array('id'=>"RITindakanPelayananT_".$i."_daftartindakan_id", "style"=>"width:100px;font-size:11px;","empty"=>"- Pilih -",
				"onkeypress"=>"return $(this).focusNextInputField(event)","class"=>"idVisite",
                                    'onchange'=>'cekDokter(this,\'change\');',                                    ));		
		?>
    </td>
	<td>
            
		<?php                
                    echo "<span class='required' id='dokterDPJP' style='display:none;'>Sudah di visite</span>";
                    echo CHtml::checkBox("RITindakanPelayananT[".$i."][ceklist]",false,array('id'=>"RITindakanPelayananT_".$i."_[ceklist]", "class"=>"ceklist","onclick"=>"dipilih(this)","onkeypress"=>"return $(this).focusNextInputField(event)"))
                    .CHtml::hiddenField("RITindakanPelayananT[".$i."][dipilih]","Tidak",array('id'=>"RITindakanPelayananT_".$i."_[dipilih]", "readonly"=>TRUE,"class"=>"span1 dipilih"));
                
			
		?>
	</td>	
</tr>
<script>
    
        cekDokter(jQuery("#RITindakanPelayananT_<?php echo $i; ?>_daftartindakan_id"));
    
</script>
<?php endforeach; ?>	

