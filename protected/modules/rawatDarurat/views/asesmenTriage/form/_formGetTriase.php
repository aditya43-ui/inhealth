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
    <td><?php echo CHtml::activeHiddenField($modAsesTriDet,'[triase]['.$i.']triase_id', array('value'=>!empty($modAsesTriDet->triase_id)?$modAsesTriDet->triase_id:'#')) ?></td>
</tr>
