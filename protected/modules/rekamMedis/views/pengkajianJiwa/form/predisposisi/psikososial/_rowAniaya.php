<tr>
    <td>
        <?php echo CHtml::activeDropDownList($mod, '['.$jenisaniaya.']['.$i.']pasiensebagai', array(
            'pelaku'=>'Pelaku',
            'korban'=>'Korban',
            'saksi'=>'Saksi',
        ),array('class'=>'pasiensebagai span2')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($mod, '['.$jenisaniaya.']['.$i.']usiatext', array('class'=>'usia span3')); ?>
    </td>
    <td>
        <?php echo CHtml::htmlButton('-', array('class'=>'btn btn-danger', 'onclick'=>'hapusItemRiwayatAniaya(this);')); ?>
    </td>
</tr>