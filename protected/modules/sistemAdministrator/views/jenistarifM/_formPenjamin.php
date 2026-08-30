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
		echo CHtml::activeHiddenField($det,'[penjamin]['.$i.']penjamin_id', array('class' => 'penjaminTarif')); 
			
			echo $det->penjamin_nama;
		?>
		
		
	</td>
	<td>
		<?php 
			echo CHtml::link("<i class='".MyIcon::getIcons('hapus-baris')."'></i>",'javascript:;',array('class' => 'btn btn-default','onclick'=>'hapusBaris(this)'));
		?>
	</td>
</tr>
