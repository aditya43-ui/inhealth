<tr>   
    <td style="text-align: left; background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;">
        <span id="tandagejaladet" class="hide">
            <?php echo CHtml::activeTextField($modDetail, '[0]kelompoktandagejaladaftar_id['.$no++.']', array('value'=>$modTandaGejala['kelompoktandagejaladaftar_id'], 'checked'=>true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'class' => 'kelompoktandagejaladaftar_idnya')); ?>
        </span>
        &nbsp;
        - <?php echo $modTandaGejala['tandagejala_daftar_nama']; ?>
    </td>
</tr>        