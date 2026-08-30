<tr>   
    <td><?php 
        echo CHtml::activeHiddenField($modDetail, '[]barang_id', array('class'=>'barang')); 
        echo !empty($modBarang->bidang_id)?$modBarang->bidang->subkelompok->kelompok->golongan->golongan_nama:null; 
        ?>
    </td>
    <td><?php echo !empty($modBarang->bidang_id)? $modBarang->bidang->subkelompok->kelompok->kelompok_nama:null; ?></td>
    <td><?php echo !empty($modBarang->bidang_id)?$modBarang->bidang->subkelompok->subkelompok_nama:null; ?></td>
    <td><?php echo !empty($modBarang->bidang_id)?$modBarang->bidang->bidang_nama:null; ?></td>
    <td><?php echo $modBarang->barang_nama; ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '[]hargabeli', array('class'=>'span1 numbersOnly beli',)); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '[]hargasatuan', array('class'=>'span1 numbersOnly satuan', )); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '[]jmlbeli', array('class'=>'span1 numbersOnly qty', )); ?></td>
    <td><?php echo CHtml::activeDropDownList($modDetail, '[]satuanbeli', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '[]jmldlmkemasan', array('class'=>'span1 numbersOnly')); ?></td>
    <td><?php echo Chtml::link('<icon class="icon-form-silang"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
</tr>        