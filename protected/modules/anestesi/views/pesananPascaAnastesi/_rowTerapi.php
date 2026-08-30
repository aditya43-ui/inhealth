<?php 
if(count($arrTerapi) > 0){
    foreach ($arrTerapi as $key => $value) {
    ?>
        <tr data-row="0">
            <td>
                <?php echo $form->textField($value,'['.$key.']nama_terapi',array('onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'nama_terapi span3')); ?>
            </td>
            <td>
                <?php echo CHtml::link('<span style="font-size:20px;"><i class="'.MyIcon::getIcons('tambah-baris').'"></i></span>', 'javascript:;', array('style'=>'border-radius:100%;padding:0px;','class'=>'btn btn-primary tambah','onclick'=>'tambahBaris()', "rel"=>"tooltip" ,"data-original-title"=>"Klik untuk menambahkan baris baru",'data-placement'=>'left')); ?>            
                <?php 
                echo CHtml::link('<span style="font-size:20px;"><i class="'.MyIcon::getIcons('hapus-baris').'"></i></span>', 'javascript:;', array('style'=>'border-radius:100%;padding:0px;display:none;','class'=>'btn btn-danger hapus','onclick'=>'hapusBaris(this)', "rel"=>"tooltip" ,"data-original-title"=>"Klik untuk menghapus baris",'data-placement'=>'left'));               
                ?>            
            </td>
        </tr>
    <?php
    }
}else{
?>
<tr data-row="0">
    <td>
        <?php echo $form->textField($modTerapi,'[0]nama_terapi',array('onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'nama_terapi span3')); ?>
    </td>
    <td>
        <?php echo CHtml::link('<span style="font-size:20px;"><i class="'.MyIcon::getIcons('tambah-baris').'"></i></span>', 'javascript:;', array('style'=>'border-radius:100%;padding:0px;','class'=>'btn btn-primary tambah','onclick'=>'tambahBaris()', "rel"=>"tooltip" ,"data-original-title"=>"Klik untuk menambahkan baris baru",'data-placement'=>'left')); ?>            
        <?php 
        echo CHtml::link('<span style="font-size:20px;"><i class="'.MyIcon::getIcons('hapus-baris').'"></i></span>', 'javascript:;', array('style'=>'border-radius:100%;padding:0px;display:none;','class'=>'btn btn-danger hapus','onclick'=>'hapusBaris(this)', "rel"=>"tooltip" ,"data-original-title"=>"Klik untuk menghapus baris",'data-placement'=>'left'));               
        ?>            
    </td>
</tr>
<?php } ?>