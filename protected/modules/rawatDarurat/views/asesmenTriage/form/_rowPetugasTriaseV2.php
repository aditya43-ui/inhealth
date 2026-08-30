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
            <?php echo CHtml::label("",'pegawai_id',array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($modTriPeg,'['.$i.']asesmentriase_id',array('empty' => '-- Pilih --','class'=>'id')); ?>				
                <?php 
					if (!empty($modTriPeg->pegawai_id)){
						$peg = PegawaiM::model()->findByPk($modTriPeg->pegawai_id);
						
						$modTriPeg->nama_pegawai = $peg->namaLengkap;
					}
					//$modTriPeg->nama_pegawai = $modTriPeg->pegawai->namaLengkap;
					echo $form->textField($modTriPeg,'['.$i.']nama_pegawai',array('class'=>'pegawai','readonly'=>true)); 
				?>
            </div>                       
        </div>
    </td>  
</tr>
	