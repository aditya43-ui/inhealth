
<tr>
    <td>
    
        <?php echo CHtml::textField("Riwayatobat[ii][nama_obat]", isset($modRiwayatobatsebelumnya->nama_obat) ? $modRiwayatobatsebelumnya->nama_obat : '',array('class'=>'span3', 'readonly'=>$readonly)); ?>
	
    </td>
     <td>
    
        <?php echo CHtml::textField("Riwayatobat[ii][dosis_obat]", isset($modRiwayatobatsebelumnya->dosis_obat) ? $modRiwayatobatsebelumnya->dosis_obat : '',array('class'=>'span3', 'readonly'=>$readonly)); ?>
	
    </td>
     <td>
    
        <?php echo CHtml::textField("Riwayatobat[ii][carapemberian]", isset($modRiwayatobatsebelumnya->carapemberian) ? $modRiwayatobatsebelumnya->carapemberian : '',array('class'=>'span3', 'readonly'=>$readonly)); ?>
	
    </td>
     <td>
    
        <?php echo CHtml::textField("Riwayatobat[ii][tglpemberian]", isset($modRiwayatobatsebelumnya->tglpemberian) ? $modRiwayatobatsebelumnya->tglpemberian : '',array('class'=>'span3', 'readonly'=>$readonly)); ?>
	
    </td>
    <td>
        <a onclick="removeObat(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Obat"><i class="icon-remove"></i></a>
    </td>
  
</tr>