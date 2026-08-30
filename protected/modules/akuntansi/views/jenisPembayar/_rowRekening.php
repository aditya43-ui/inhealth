<?php

if (empty($i)) {
    $i = "iii";
}

$bankD = BankM::model()->findByPk($rekD->bank_id);
$rekDM = Rekening5M::model()->findByPk($rekD->rekening5_id);

$bankK = BankM::model()->findByPk($rekK->bank_id);
$rekKM = Rekening5M::model()->findByPk($rekK->rekening5_id);

?>

<tr>
    <td>
        <?php echo CHtml::activeHiddenField($rekD, '[detail]['.$i.'][D]rekening1_id', array('class'=>'detail_d_rekening1_id')); ?>
        <?php echo CHtml::activeHiddenField($rekD, '[detail]['.$i.'][D]rekening2_id', array('class'=>'detail_d_rekening2_id')); ?>
        <?php echo CHtml::activeHiddenField($rekD, '[detail]['.$i.'][D]rekening3_id', array('class'=>'detail_d_rekening3_id')); ?>
        <?php echo CHtml::activeHiddenField($rekD, '[detail]['.$i.'][D]rekening4_id', array('class'=>'detail_d_rekening4_id')); ?>
        <?php echo CHtml::activeHiddenField($rekD, '[detail]['.$i.'][D]rekening5_id', array('class'=>'detail_d_rekening5_id')); ?>

        <?php echo CHtml::activeHiddenField($rekK, '[detail]['.$i.'][K]rekening1_id', array('class'=>'detail_k_rekening1_id')); ?>
        <?php echo CHtml::activeHiddenField($rekK, '[detail]['.$i.'][K]rekening2_id', array('class'=>'detail_k_rekening2_id')); ?>
        <?php echo CHtml::activeHiddenField($rekK, '[detail]['.$i.'][K]rekening3_id', array('class'=>'detail_k_rekening3_id')); ?>
        <?php echo CHtml::activeHiddenField($rekK, '[detail]['.$i.'][K]rekening4_id', array('class'=>'detail_k_rekening4_id')); ?>
        <?php echo CHtml::activeHiddenField($rekK, '[detail]['.$i.'][K]rekening5_id', array('class'=>'detail_k_rekening5_id')); ?>

        <?php echo CHtml::activeHiddenField($rekD->isNewRecord ? $rekK : $rekD, '[detail]['.$i.']bank_id', array('class'=>'detail_bank_id')); ?>
        <span class="label_bank"><?php echo empty($bankD) ? (empty($bankK) ? "-" : $bankK->bankDanAtasNama) : $bankD->bankDanAtasNama; ?></bank>
    </td>
    <td class="label_rekening_debit">
        <?php echo empty($rekDM) ? "" : $rekDM->kdrekening5." - ".$rekDM->nmrekening5; ?>
    </td>
    <td class="label_rekening_kredit">
        <?php echo empty($rekKM) ? "" : $rekDM->kdrekening5." - ".$rekKM->nmrekening5; ?>
    </td>
    <td>
        <?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array(
            'onclick'=>'hapusItemRekeningBank(this); return false;'
        )); ?>
    </td>

</tr>
