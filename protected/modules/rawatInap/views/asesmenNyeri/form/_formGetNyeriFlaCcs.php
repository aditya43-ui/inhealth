<?php
/**
* - digunakan untuk menambahkan data nyeri flaccs pada tabel
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
?>
<tr>
    <td><?php echo CHtml::activeHiddenField($modFlaCcs,'[flaccs]['.$i.']skalanyeriflaccs_id', array('value'=>!empty($modFlaCcs->skalanyeriflaccs_id)?$modFlaCcs->skalanyeriflaccs_id:'#')) ?></td>
</tr>
