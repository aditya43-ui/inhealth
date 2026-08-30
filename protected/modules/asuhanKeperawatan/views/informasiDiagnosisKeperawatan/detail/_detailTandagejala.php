<tr>   
    <td style="text-align: left; ">
        <span id="tandagejaladet" class="hide">
            <?php echo CHtml::activeCheckBox($modDetail, '[0]tandagejala_id[' . $no++ . ']', array('value' => $modTandaGejala['tandagejala_id'], 'checked' => true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'class' => 'tandagejala_idnya', 'disabled' => true)); ?>
        </span>
        - &nbsp;
        <?php echo $modTandaGejala['tandagejala_daftar_nama']; ?>
    </td>
</tr>        