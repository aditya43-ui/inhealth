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
    <td>
		<?php echo CHtml::activeHiddenField($modDet,'[timeout]['.$i.']identifier', array('class' => 'identifier')) ?>
		<?php echo CHtml::activeHiddenField($modDet,'[timeout]['.$i.']operasitimeoutdet_id', array('class' => 'id')) ?>
		<?php echo CHtml::activeHiddenField($modDet,'[timeout]['.$i.']formtimeout_id', array('class' => 'form_id')) ?>
		<?php echo CHtml::activeHiddenField($modDet,'[timeout]['.$i.']checklisttimeout_id', array('class' => 'check_id')) ?>
		<?php echo CHtml::activeHiddenField($modDet,'[timeout]['.$i.']timeoutdet_hasil', array('class' => 'hasil')) ?>
		<?php echo CHtml::activeHiddenField($modDet,'[timeout]['.$i.']timeoutdet_isian', array('class' => 'hasil')) ?>
	</td>
</tr>
