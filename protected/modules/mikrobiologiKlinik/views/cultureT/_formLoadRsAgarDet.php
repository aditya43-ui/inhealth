<tr row-mc="0">
    <?php 
        if (!empty($modBrucellaGambar->temp_file)) {
            if(file_exists(Params::pathDokRosellaAgarDirectory().$modBrucellaGambar->rosellaagar_gambar)){
                $img = Params::urlDokRosellaAgarDirectory().$modBrucellaGambar->rosellaagar_gambar;
            }else{
                $img = Params::urlDokRosellaAgarDirectory()."no_photo.jpeg";
            }
        } else {
            $img = "";
        }
    ?>
    <td>
        <?php echo CHtml::hiddenField('id_count', ($i+1));?>
        <?php echo CHtml::activeHiddenField($modBrucellaGambar,'[detail]['.$idx.']['.$i.']rosella_agar_id', array('class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modBrucellaGambar,'[detail]['.$idx.']['.$i.']rosellaagar_gambar_id', array('class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modBrucellaGambar,'[detail]['.$idx.']['.$i.']temp_file', array('class'=>'span1')); ?>
        <?php echo CHtml::activeFileField($modBrucellaGambar,'[detail]['.$idx.']['.$i.']rosellaagar_gambar', array('class'=>'span3', 'onchange'=>'checkGambarBlood(this)')); ?>
    </td>
    <td colspan="2">
        <img class='gambar-prev' id="output_<?=($i+1)?>" src="<?=$img?>" height="300" width="300"/>
    <td/>
    <td>
        <?php
            echo CHtml::link('<i class="glyphicon glyphicon-minus"></i>', "javascript:;", array('class'=>'btnhapus hide','onclick'=>'hapusBarisRs(this); return false;'));        
            echo CHtml::link('<i class="glyphicon glyphicon-plus"></i>', "javascript:;", array('class'=>'btntambah ','onclick'=>'tambahBarisRs(this); return false;'));                
        ?>
    </td>
</tr>