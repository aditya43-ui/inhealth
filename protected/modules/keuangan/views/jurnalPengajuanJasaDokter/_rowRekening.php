<?php

if (!empty($rekening)) {
    $rek = Rekening5M::model()->findByPk($rekening->rekening5_id);
    $nilai = MyFormatter::formatNumberForPrint($nilai);
?>
<tr>
    <td>
        <?php echo $rek->kdrekening5; ?>
    </td>
    <td><?php echo $rek->nmrekening5; ?></td>
    <td><?php echo CHtml::textField('form_cari[rekening]['.$rek->rekening5_id.'][debit]', $debitkredit == "D" ? $nilai : 0, array('class'=>'span3 integer2 saldodebit', 'readonly'=>true)); ?></td>
    <td><?php echo CHtml::textField('form_cari[rekening]['.$rek->rekening5_id.'][kredit]', $debitkredit == "K" ? $nilai : 0, array('class'=>'span3 integer2 saldokredit', 'readonly'=>true)); ?></td>
</tr>


<?php } ?>
