<?php 
if(isset($modBahasas)){
     foreach ($modBahasas as $i => $modBahasa) {
         $no=$i+1;
        ?> <tr>
            <td><?php echo $form->textField($modBahasa,"[$i]no_urut",array('class'=>'span1', 'readonly'=>true, 'value'=>"$no"))?></td>
            <td><?php echo $form->textField($modBahasa,"[$i]bahasa",array('class'=>'span3 isDetailReq', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?></td>
            <td><?php echo $form->dropDownList($modBahasa,"[$i]mengerti", CHtml::listData($modBahasa->MengertiBahasa, 'lookup_name', 'lookup_name'), array('class'=>'span2 isDetailReq', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20, 'empty'=>' -- Pilih -- ',)); ?></td>
            <td><?php echo $form->dropDownList($modBahasa,"[$i]berbicara", CHtml::listData($modBahasa->BerbicaraBahasa, 'lookup_name', 'lookup_name'), array('class'=>'span2 isDetailReq', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20, 'empty'=>' -- Pilih -- ')); ?></td>
            <td><?php echo $form->dropDownList($modBahasa,"[$i]menulis", CHtml::listData($modBahasa->MenulisBahasa, 'lookup_name', 'lookup_name'), array('class'=>'span2 isDetailReq', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20, 'empty'=>' -- Pilih -- ')); ?></td>
            <td width="5%">
                
            </td>

        </tr>
    <?php }
} else {
?>
<tr>
    <td><?php echo $form->textField($modBahasa,'[0]no_urut',array('class'=>'span1', 'readonly'=>true))?></td>
    <td><?php echo $form->textField($modBahasa,'[0]bahasa',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?></td>
    <td><?php echo $form->dropDownList($modBahasa,'[0]mengerti', CHtml::listData($modBahasa->MengertiBahasa, 'lookup_name', 'lookup_name'), array('class'=>'span2 isDetailReq', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20, 'empty'=>' -- Pilih -- ',)); ?></td>
    <td><?php echo $form->dropDownList($modBahasa,'[0]berbicara', CHtml::listData($modBahasa->BerbicaraBahasa, 'lookup_name', 'lookup_name'), array('class'=>'span2 isDetailReq', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20, 'empty'=>' -- Pilih -- ')); ?></td>
    <td><?php echo $form->dropDownList($modBahasa,'[0]menulis', CHtml::listData($modBahasa->MenulisBahasa, 'lookup_name', 'lookup_name'), array('class'=>'span2 isDetailReq', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20, 'empty'=>' -- Pilih -- ')); ?></td>
    <td width="5%">
        <?php 
            echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowBahasa(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah tindakan'));
            if($btnHapus == true){
                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalBahasa(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan tindakan'));
            }
        ?>
    </td>

</tr>
<?php } ?>