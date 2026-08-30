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
        <?php echo CHtml::activeHiddenField($modTindakans,'['.$i.']pegawai_id',array('readonly'=>true,'class'=>'span1','value'=>  isset($detail->pegawai_id) ? $detail->pegawai_id : null )); ?>		
        <?php echo CHtml::activeHiddenField($detail,'['.$i.']kelaspelayanan_id',array('readonly'=>true,'class'=>'span1','value'=>  isset($detail->kelaspelayanan_id) ? $detail->kelaspelayanan_id : null )); ?>
		<?php echo CHtml::activeHiddenField($detail,'['.$i.']ruangan_id',array('readonly'=>true,'class'=>'span1','value'=>  isset($detail->ruangan_id) ? $detail->ruangan_id : null )); ?>
        <?php echo (!empty($detail->tglAdmisiMasukKamar) ? $detail->tglAdmisiMasukKamar : "") ?>
    </td>
    <td>
        <?php echo (!empty($detail->noRmNoPend) ? $detail->noRmNoPend : "") ?>
    </td>
    <td>
        <?php echo (!empty($detail->namaPasienNamaBin) ? $detail->namaPasienNamaBin : "") ?>
    </td>
    <td>
        <?php echo (!empty($detail->jeniskelamin) ? $detail->jeniskelamin : "") ?>
    </td>
    <td>
        <?php echo (!empty($detail->caraBayarPenjamin) ? $detail->caraBayarPenjamin : "") ?>
    </td>
	<td>
        <?php echo !empty($detail->ruangan_nama)? $detail->ruangan_nama. " / " : ""; echo (!empty($detail->kelaspelayanan_nama) ? $detail->kelaspelayanan_nama : "") ?>
    </td>
	<td>
        <?php echo (!empty($detail->jeniskasuspenyakit_nama) ? $detail->jeniskasuspenyakit_nama : "") ?>
    </td>
	<td>
        <?php echo (!empty($detail->jeniskasuspenyakit_nama) ? $detail->gelardepan." ".$detail->nama_pegawai." ".$detail->gelarbelakang_nama : "") ?>
    </td>
	<td>
		<?php
			echo CHtml::dropDownList("PITindakanPelayananT[".$i."][daftartindakan_id]",$daftartindakan_id,
				CHtml::listdata(PIDaftarTindakanM::model()->findAll('daftartindakan_visite=TRUE'),"daftartindakan_id","daftartindakan_nama"),array('id'=>"PITindakanPelayananT_".$i."_daftartindakan_id", "style"=>"width:100px;font-size:11px;","empty"=>"- Pilih -",
				"onkeypress"=>"return $(this).focusNextInputField(event)","class"=>"idVisite"));		
		?>
    </td>
	<td>
		<?php
			echo CHtml::checkBox("PITindakanPelayananT[".$i."][ceklist]",false,array('id'=>"PITindakanPelayananT_".$i."_[ceklist]", "class"=>"ceklist","onclick"=>"dipilih(this)","onkeypress"=>"return $(this).focusNextInputField(event)"))
            .CHtml::hiddenField("PITindakanPelayananT[".$i."][dipilih]","Tidak",array('id'=>"PITindakanPelayananT_".$i."_[dipilih]", "readonly"=>TRUE,"class"=>"span1 dipilih"));
		?>
	</td>	
</tr>
<?php endforeach; ?>	