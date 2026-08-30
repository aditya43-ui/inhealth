<?php
/**
* - digunakan untuk untuk generate data petugas triase pada tabel
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
?>
<tr>
    <td>				
        <div class="control-group">
            <?php echo CHtml::label("Petugas Triage",'pegawai_id',array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($modTriPeg,'['.$i.']asesmentriase_id',array('empty' => '-- Pilih --','class'=>'id')); ?>
                <?php echo $form->dropDownList($modTriPeg,'['.$i.']pegawai_id', PegawaiM::model()->dropDokterParamedisItems(),array('empty' => '-- Pilih --','class'=>'pegawai')); ?>
            </div>
            <div class="controls">
                <div  class="tambahRow">
                    <?php echo CHtml::link("<i class='".MyIcon::getIcons('tambah-baris')."'></i>", '#', array('onclick'=>'addRow(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambahkan petugas triase yang lain', 'class' => 'btn btn-danger',)); ?>
		</div>		
            </div>
            <div class="controls">
                <div style="display:none;" class="hapusRow">
                    <?php echo CHtml::link("<i class='".MyIcon::getIcons('hapus-baris')."'></i>", '#', array('onclick'=>'hapusRow(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan rencana pelatihan', 'class'=>'btn btn-danger')); ?>
		</div>                
            </div>
        </div>
    </td>  
</tr>
	