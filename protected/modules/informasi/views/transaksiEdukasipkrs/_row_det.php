<?php
$i = isset($i)?$i:0;
$modDok = new UploadedukasiT();
?>

<tr>
    <td>
        <div class="controls">
            <?php echo $form->fileField($modDok, '['.$i.']namafile', array()); ?>
        </div>
    </td>
    <td>        
        <?= CHtml::link("<i class='".MyIcon::getIcons('tambah-baris')."'></i>",'javascript:;',['onclick'=>'addRow(this)','class'=>'btn btn-primary btn-tambah','style'=>'padding:5px;']) ?>
        <?= '&nbsp;' ?>
        <?= CHtml::link("<i class='".MyIcon::getIcons('hapus-baris')."'></i>",'javascript:;',['onclick'=>'hapusRow(this)','class'=>'btn btn-danger btn-hapus','style'=>'padding:5px;']) ?>
    </td>
</tr>