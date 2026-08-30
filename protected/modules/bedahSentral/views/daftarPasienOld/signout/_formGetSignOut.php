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
		<?php echo CHtml::activeHiddenField($modDet,'[signout]['.$i.']identifier', array('class' => 'identifier')) ?>
		<?php echo CHtml::activeHiddenField($modDet,'[signout]['.$i.']operasisignoutdet_id', array('class' => 'id')) ?>
		<?php echo CHtml::activeHiddenField($modDet,'[signout]['.$i.']formsignout_id', array('class' => 'form_id')) ?>
		<?php echo CHtml::activeHiddenField($modDet,'[signout]['.$i.']checklistsignout_id', array('class' => 'check_id')) ?>
		<?php echo CHtml::activeHiddenField($modDet,'[signout]['.$i.']signoutdet_hasil', array('class' => 'hasil')) ?>
		<?php echo CHtml::activeHiddenField($modDet,'[signout]['.$i.']signoutdet_isian', array('class' => 'hasil')) ?>
	</td>
</tr>
