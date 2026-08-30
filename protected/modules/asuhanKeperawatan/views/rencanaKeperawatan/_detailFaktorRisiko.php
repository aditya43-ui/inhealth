<tr>   
    <td style="text-align: left; background-color:<?php echo $warna; ?>; border: 1px solid <?php echo $warna; ?> !important;">
        <span id="faktorrisikodet" class="hide">
            <?php echo CHtml::activeTextField($modDetail, '[0]kelompokfaktorrisikodaftar_id['.$no++.']', array('value'=>$modFaktorRisiko['kelompokfaktorrisikodaftar_id'], 'onkeyup' => "return $(this).focusNextInputField(event);", 'class' => 'kelompokfaktorrisikodaftar_idnya')); ?>
        </span>
        &nbsp;
        - <?php echo $modFaktorRisiko['faktorrisiko_daftar_nama']; ?>
    </td>
</tr>        