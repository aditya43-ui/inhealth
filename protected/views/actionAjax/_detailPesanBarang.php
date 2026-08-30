<tr>   
    <td><?php 
        echo CHtml::activeHiddenField($modDetail, '[]barang_id', array('class'=>'barang')); 
        echo $modBarang->bidang->subkelompok->kelompok->golongan->golongan_nama; 
        ?>
    </td>
    <td><?php echo $modBarang->bidang->subkelompok->kelompok->kelompok_nama; ?></td>
    <td><?php echo $modBarang->bidang->subkelompok->subkelompok_nama; ?></td>
    <td><?php echo $modBarang->bidang->bidang_nama; ?></td>
    <td><?php echo $modBarang->barang_nama; ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '[]qty_pesan', array('class'=>'span1 numbersOnly pesan')); ?></td>
    <td><?php echo CHtml::activeDropDownList($modDetail, '[]satuanbarang', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>
    <td><?php echo $modBarang->barang_ukuran; ?><br/><?php echo $modBarang->barang_bahan; ?></td>
    <td><?php echo Chtml::link('<icon class="icon-remove"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
</tr>        