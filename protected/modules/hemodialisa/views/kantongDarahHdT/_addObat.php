<tr>
    <td>        
        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
                <?= CHtml::activeTextField($modObat, '['.$key.']nama_obat', array('readonly' => true, 'style' => 'width:175px;')); ?>
            </div>
            <div class="controls">
                <?= CHtml::link('<span style="font-size:20px;color:red;"><i class="fa fa-minus"></i></span>', 'javascript:void(0);', array('class'=>'','onclick'=>"batalObat(this);return false", 'title'=>'Klik untuk membatalkan obat'))."&nbsp;"; ?>
            </div>
        </div>
    </td>
</tr>
    