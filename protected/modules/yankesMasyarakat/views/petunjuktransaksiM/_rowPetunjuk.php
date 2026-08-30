<tr>
    <td>
        <?php echo CHtml::hiddenField('id_count', ''); ?>
        <?php echo CHtml::activeHiddenField($model, '[0]petunjuktransaksi_id',array('class'=>'span3'));?>	
        <?php echo CHtml::activeTextField($model, '[0]petunjuktransaksi_nama',array('class'=>'span3 required'));?>	
    </td>
    <td>
        <?php echo CHtml::activeTextArea($model, '[0]petunjuktransaksi_deskripsi',array('class'=>'span3'));?>	
    </td>
    <td>
        <?php echo CHtml::activeHiddenField($model, '[0]temp_file',array('class'=>'span3'));?>	
        <?php echo CHtml::activeFileField($model, '[0]petunjuktransaksi_image',array('class'=>'span3', 'onchange' => 'checkGambar(this);'));?>
        <br>
        <?php
        $img = "";
        if (empty($model->temp_file)) {
            $img = "";
        } else {
            if (file_exists(Params::pathPetunjukTransaksiDirectory() . $model->petunjuktransaksi_image)) {
                $img = Params::urlPetunjukTransaksiDirectory() . $model->petunjuktransaksi_image;
            } else {
                $img = Params::urlPetunjukTransaksiDirectory() . "no_photo.jpeg";
            }
        }
        ?>
        <img class="gambar-prev" id="output_1" src="<?= $img ?>" height="200" width="200">
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[0]petunjuktransaksi_urutan',array('class'=>'span1 numbers-only'));?>	
    </td>
    <td style="text-align: center">
        <?php echo CHtml::activeCheckBox($model, '[0]petunjuktransaksi_aktif',array('class'=>'span1')); ?>
    </td>
    <td style="text-align: center;" class="rowbutton span3">
        <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class'=>'btn btn-primary','onclick'=>'tambahLookup()')); ?>
        <?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'hapusLookup(this)')); ?>
    </td>
</tr>