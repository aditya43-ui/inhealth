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
    <td height="50px" class="daftarPegwai"><?php 
	echo CHtml::activeHiddenField($det,'[pegawai]['.$i.']pegawai_id', array('class' => 'daftarPegawailist')); 
		
			echo $det->nama_pegawai;
		?>
		
	</td>
	<td>
		<?php 
			echo CHtml::link("<i class='".MyIcon::getIcons('hapus-baris')."'></i>",'javascript:;',array('class' => 'btn btn-default','onclick'=>'hapusBaris2(this)'));
		?>
	</td>
</tr>
