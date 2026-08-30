<tr class="tr-reaksi" baris="<?= $key; ?>">
    <td>
        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
                <?= CHtml::TextField('['.$key.']reaksi_transfusi', ''.$reaksi_transfusi.'', array('readonly' => true, 'class' => 'span3 reaksi_transfusi','style'=>'width:175px;',)); ?>
            </div>
            <div class="controls">
                <?= CHtml::link('<span style="font-size:20px;color:red;"><i class="fa fa-minus"></i></span>', 'javascript:void(0);', array('onclick'=>"batalReaksi(this);return false", 'title'=>'Klik untuk membatalkan reaksi transfusi'))."&nbsp;"; ?>
            </div>
        </div>
    </td>
</tr>
    