<tr row-choc="0">
    <?php 
        if (!empty($modChocGambar->temp_file)) {
            if(file_exists(Params::pathDokChocAgarDirectory().$modChocGambar->chocagar_gambar)){
                $img = Params::urlDokChocAgarDirectory().$modChocGambar->chocagar_gambar;
            }else{
                $img = Params::urlDokChocAgarDirectory()."no_photo.jpeg";
            }
        } else {
            $img = "";
        }
    ?>
    <td>
        <?php echo CHtml::hiddenField('id_count', ($i+1));?>
        <?php echo CHtml::activeHiddenField($modChocGambar,'[detail]['.$idx.']['.$i.']choc_agar_id', array('class'=>'span3 bloodagar_gambar')); ?>
        <?php echo CHtml::activeHiddenField($modChocGambar,'[detail]['.$idx.']['.$i.']chocagar_gambar_id', array('class'=>'span3 bloodagar_gambar')); ?>
        <?php echo CHtml::activeHiddenField($modChocGambar,'[detail]['.$idx.']['.$i.']temp_file', array('class'=>'span3 bloodagar_gambar')); ?>
        <?php echo CHtml::activeFileField($modChocGambar,'[detail]['.$idx.']['.$i.']chocagar_gambar', array('class'=>'span3 bloodagar_gambar', 'onchange'=>'checkGambarBlood(this)',)); ?>
    </td>
    <td colspan="2">
        <img class='gambar-prev' id="output_<?=($i+1)?>" src="<?=$img?>" height="300" width="300"/>
    <td/>

    <td>
        <?php                
            echo CHtml::link('<i class="glyphicon glyphicon-minus"></i>', "javascript:;", array('class'=>'btnhapus hide','onclick'=>'hapusBarisChoc(this); return false;'));        
            echo CHtml::link('<i class="glyphicon glyphicon-plus"></i>', "javascript:;", array('class'=>'btntambah ','onclick'=>'tambahBarisChoc(this); return false;'));                
        ?>
    </td>
</tr>