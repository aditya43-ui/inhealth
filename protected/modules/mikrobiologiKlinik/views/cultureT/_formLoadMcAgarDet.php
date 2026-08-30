<tr row-mc="0">
    <?php 
        if (!empty($modMcConceyGambar->temp_file)) {
            if(file_exists(Params::pathDokMcconceyAgarDirectory().$modMcConceyGambar->mcconceyagar_gambar)){
                $img = Params::urlDokMcconceyAgarDirectory().$modMcConceyGambar->mcconceyagar_gambar;
            }else{
                $img = Params::urlDokMcconceyAgarDirectory()."no_photo.jpeg";
            }
        } else {
            $img = "";
        }
    ?>
    <td>
        <?php echo CHtml::hiddenField('id_count', ($i+1));?>
        <?php echo CHtml::activeHiddenField($modMcConceyGambar,'[detail]['.$idx.']['.$i.']mcconcey_agar_id', array('class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modMcConceyGambar,'[detail]['.$idx.']['.$i.']mcconceyagar_gambar_id', array('class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modMcConceyGambar,'[detail]['.$idx.']['.$i.']temp_file', array('class'=>'span1')); ?>
        <?php echo CHtml::activeFileField($modMcConceyGambar,'[detail]['.$idx.']['.$i.']mcconceyagar_gambar', array('class'=>'span3', 'onchange'=>'checkGambarBlood(this)')); ?>
    </td>
    <td colspan="2">
        <img class='gambar-prev' id="output_<?=($i+1)?>" src="<?=$img?>" height="300" width="300"/>
    <td/>
    <td>
        <?php
            echo CHtml::link('<i class="glyphicon glyphicon-minus"></i>', "javascript:;", array('class'=>'btnhapus hide','onclick'=>'hapusBarisMc(this); return false;'));        
            echo CHtml::link('<i class="glyphicon glyphicon-plus"></i>', "javascript:;", array('class'=>'btntambah ','onclick'=>'tambahBarisMc(this); return false;'));                
        ?>
    </td>
</tr>