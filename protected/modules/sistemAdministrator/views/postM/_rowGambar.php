<tr>
    <td>
        <?php echo CHtml::hiddenField('id_count', ''); ?>
        <?php echo CHtml::activeHiddenField($model, '[0]postgambar_id',array('class'=>'span3'));?>	
       
        <?php echo CHtml::activeFileField($model, '[0]pathgambar',array('class'=>'span3', 'onchange' => 'checkGambar(this);'));?>
        <br>
        <?php  echo '<b style="color:red">Catatan Image:</b>Minimal Ukuran Image Width min 400 px dan Height min 200px';  ?>
        <?php
        $img = "";
        if (empty($model->pathgambar)) {
            $img = "";
        } else {
            if (file_exists(Params::pathBeritaGambar() . $model->pathgambar)) {
                $img = Params::urlBeritaGambar() . $model->pathgambar;
            } else {
                $img = Params::urlBeritaGambar() . "no_photo.jpeg";
            }
        }
        ?>
        <img class="gambar-prev" id="output_1" src="<?= $img ?>" height="200" width="200">
    </td>
    
    <td style="text-align: center;" class="rowbutton span3">
        <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class'=>'btn btn-primary','onclick'=>'tambahLookup()')); ?>
        <?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'hapusBaris(this)')); ?>
    </td>
</tr>