<tr row-detail="0">
    <?php 
        if (empty($modBloodGambar->temp_file)) {
            $img = "";
        } else {
            if(file_exists(Params::pathDokBloodAgarDirectory().$modBloodGambar->bloodagar_gambar)){
                $img = Params::urlDokBloodAgarDirectory().$modBloodGambar->bloodagar_gambar;
            }else{
                $img = Params::urlDokBloodAgarDirectory()."no_photo.jpeg";
            }
        }
    ?>
    <td>
        <?php echo CHtml::hiddenField('id_count', ($i+1));?>
        <?php echo CHtml::activeHiddenField($modBloodGambar,'[detail]['.$idx.']['.$i.']blood_agar_id', array('class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modBloodGambar,'[detail]['.$idx.']['.$i.']bloodagar_gambar_id', array('class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modBloodGambar,'[detail]['.$idx.']['.$i.']temp_file', array('class'=>'span1')); ?>
        <?php echo CHtml::activeFileField($modBloodGambar,'[detail]['.$idx.']['.$i.']bloodagar_gambar', array('class'=>'span3 bloodagar_gambar', 'onchange'=>'checkGambarBlood(this)', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </td>
    <td colspan="2">
        <img class='gambar-prev' id="output_<?=($i+1)?>" src="<?=$img?>" height="300" width="300"/>
    <td/>
    <td>
        <?php                
            echo CHtml::link('<i class="glyphicon glyphicon-minus"></i>', "javascript:;", array('class'=>'btnhapus hide','onclick'=>'hapusBarisBlood(this); return false;'));        
            echo CHtml::link('<i class="glyphicon glyphicon-plus"></i>', "javascript:;", array('class'=>'btntambah ','onclick'=>'tambahBaris(this); return false;'));                
        ?>
    </td>
</tr>