<tr>   
    <td hidden><?php 
        echo CHtml::activeHiddenField($modDetail, '[]barang_id', array('class'=>'barang')); 
        echo CHtml::activeHiddenField($modDetail, '[]satuanbarang'); 
        // echo !empty($modBarang->bidang_id)?$modBarang->bidang->subkelompok->kelompok->golongan->golongan_nama:null; 
        ?>
    </td>
  <!--<td><?php //echo !empty($modBarang->bidang_id)? $modBarang->bidang->subkelompok->kelompok->kelompok_nama:null; ?></td>
	<td><?php //echo !empty($modBarang->bidang_id)?$modBarang->bidang->subkelompok->subkelompok_nama:null; ?></td>
	<td><?php //echo !empty($modBarang->bidang_id)?$modBarang->bidang->bidang_nama:null; ?></td>-->
    <td><?php echo $modBarang->barang_type; //echo CHtml::activeTextField($modDetail, '[]barang_id', array('class'=>'barang')); ?></td>
    <td><?php echo $modBarang->barang_kode; ?></td>
    <td><?php echo $modBarang->barang_nama; ?></td>
    <td><?php echo $modBarang->barang_merk; ?></td>
    <td><?php echo $modBarang->barang_ukuran; ?></td>
    <td><?php echo $modBarang->barang_ekonomis_thn; ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '[]qty_pesan', array('class'=>'span1 numbersOnly pesan', 'style' => 'text-align:right;')).' '.$modDetail->satuanbarang; ?></td>
   <!--<td><?php //echo CHtml::activeDropDownList($modDetail, '[]satuanbarang', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>-->
    
    <!--<td><?php //echo $modBarang->barang_ukuran; ?><br><?php //echo $modBarang->barang_bahan; ?></td>-->
    <td><?php echo Chtml::link('<icon class="icon-form-silang"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', "rel"=>'tooltip','name'=>'yt0','title'=>'Klik untuk menghapus list barang','class'=>'cancel')); ?></td>
</tr>