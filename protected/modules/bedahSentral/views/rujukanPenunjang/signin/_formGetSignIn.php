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
		<?php echo CHtml::activeHiddenField($modDet,'[signin]['.$i.']identifier', array('class' => 'identifier')) ?>
		<?php echo CHtml::activeHiddenField($modDet,'[signin]['.$i.']operasisignindet_id', array('class' => 'id')) ?>
		<?php echo CHtml::activeHiddenField($modDet,'[signin]['.$i.']formsignin_id', array('class' => 'form_id')) ?>
		<?php echo CHtml::activeHiddenField($modDet,'[signin]['.$i.']checklistsignin_id', array('class' => 'check_id')) ?>
		<?php echo CHtml::activeHiddenField($modDet,'[signin]['.$i.']signindet_hasil', array('class' => 'hasil')) ?>
	</td>
</tr>
