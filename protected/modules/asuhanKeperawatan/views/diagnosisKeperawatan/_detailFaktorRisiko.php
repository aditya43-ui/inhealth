<tr>   
    <td style="text-align: left; background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;">
        <span id="faktorrisikodet" class="hide">
            <?php echo CHtml::activeTextField($modDetail, '[0]kelompokfaktorrisikodaftar_id['.$no++.']', array('value'=>$modFaktorRisiko['kelompokfaktorrisikodaftar_id'], 'onkeyup' => "return $(this).focusNextInputField(event);", 'class' => 'kelompokfaktorrisikodaftar_idnya')); ?>
        </span>
        &nbsp;
        - <?php echo $modFaktorRisiko['faktorrisiko_daftar_nama']; ?>
    </td>
</tr>        