<tr>
    <td>
        <?php 
            echo CHtml::activeHiddenField($model, '['.$i.']asesmen_fisioterapi_geriatridet_id'); 
            echo CHtml::activeHiddenField($model, '['.$i.']asesmen_fisioterapi_geriatri_id'); 
            echo CHtml::activeHiddenField($model, '['.$i.']activitydailyliving_id'); 
            echo "<label class='no-urut'>".($i+1)."</label>"; 
        ?>
    </td>
    <td>
        <?php 
            echo "<label>".$master['fungsi']."</label>";
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($model, '['.$i.']skor',array('class' => 'span1 numbers-only skor', 'skor-max'=>$master['skormax'], 'skor-min'=>$master['skormin'], 'onblur'=>'cekSkor(this);','onkeyup'=>"return $(this).focusNextInputField(event)"));
        ?>
    </td>
    <td>
        <?php 
            echo "<label>".$master['keterangan']."</label>";
        ?>
    </td>
</tr>


