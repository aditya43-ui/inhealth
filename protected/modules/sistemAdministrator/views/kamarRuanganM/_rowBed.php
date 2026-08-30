<?php
/**
* - digunakan untuk menambahkan data triase pada tabel
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
?>
<tr>
    <td><?php 
		echo CHtml::activeHiddenField($det,'[banyakbed]['.$i.']kamarruangan_id', array('class' => 'penjaminTarif')); 			
		echo CHtml::activeTextField($det,'[banyakbed]['.$i.']kamarruangan_nobed', array('class' => 'required')); 				
		?>				
	</td>
	<td>
		<?php 		
		echo CHtml::activeDropDownList($det,'[banyakbed]['.$i.']keterangan_kamar',CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type'=>'keterangankamar', 'lookup_aktif'=>true),array('order'=>'lookup_urutan')), 'lookup_value', 'lookup_name'), array('empty'=>'-- Pilih Keterangan Kamar --','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'required'));
		?>	
	</td>
        <?php if ($this->module->id == 'hemodialisa'){ ?>
        <th>
            <?php
                echo CHtml::activeDropDownList($det,'[banyakbed]['.$i.']kamarruangan_nokamar',LookupM::getItems('lantai_ruangan_hd'), array('empty'=>'-- Pilih Lantai --','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'required'));
            ?>
        </th>
        <?php } ?>
	<td>
		<?php echo CHtml::activeCheckBox($det,'[banyakbed]['.$i.']kamarTerpakai',array()); ?> <label>Terpakai</label>
	</td>
	<td>
		<?php echo CHtml::activeCheckBox($det,'[banyakbed]['.$i.']kamarruangan_aktif',array()); ?> <label>Aktif</label>
	</td>
	<td>
		<?php echo CHtml::activeCheckBox($det,'[banyakbed]['.$i.']is_bedbayangan',array()); ?> <label>Bed Bayangan</label>
	</td>
	<td>
		<?php 
		if (empty($det->kamarruangan_id)){
			echo CHtml::link('<i class="'.MyIcon::getIcons('hapus-baris').'"></i>','javascript:;',array('class' => 'btn btn-default','onclick'=>'hapusBaris(this)'));
		}
		?>
	</td>
</tr>
