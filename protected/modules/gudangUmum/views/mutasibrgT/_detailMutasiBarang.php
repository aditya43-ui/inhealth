<tr>   
    <!--<td><?php 
        //echo CHtml::activeHiddenField($modDetail, '[]barang_id', array('class'=>'barang')); 
       // echo !empty($modBarang->bidang_id)?$modBarang->bidang->subkelompok->kelompok->golongan->golongan_nama:null; 
        ?>
    </td>
    <td><?php //echo !empty($modBarang->bidang_id)? $modBarang->bidang->subkelompok->kelompok->kelompok_nama:null; ?></td>
	<td><?php //echo !empty($modBarang->bidang_id)?$modBarang->bidang->subkelompok->subkelompok_nama:null; ?></td>
	<td><?php //echo !empty($modBarang->bidang_id)?$modBarang->bidang->bidang_nama:null; ?></td>-->
    <td><?php 
    echo CHtml::activeHiddenField($modDetail, '[]barang_id', array('class'=>'barang'));
    echo CHtml::activeHiddenField($modDetail, '[]satuanbrg', array());
	echo CHtml::activeHiddenField($modDetail, '[]pesanbarangdetail_id', array('class' => 'id'));
    //echo CHtml::activeTextField($modBarang, '[]barang_type', array('class'=>'span1','readonly'=>true));
    echo $modBarang->barang_type; ?></td>
    <td><?php echo $modBarang->barang_kode; ?></td>
    <td><?php echo $modBarang->barang_nama; ?></td>
    <td><?php echo $modBarang->barang_merk; ?></td>
    <td><?php echo $modBarang->barang_ukuran; ?></td>
    <td><?php echo $modBarang->barang_ekonomis_thn; ?></td>
    <?php //if (isset($_GET['id'])){ ?>
	<td style="text-align:right;"><?php echo CHtml::activeTextField($modDetail, '[]qty_stok', array('class'=>'span1 stok','readonly'=>true, 'style'=>'text-align:right;')).' '.$modDetail->satuanbrg; ?></td>
    <td style="text-align:right;"><?php echo CHtml::activeTextField($modDetail, '[]qty_pesan', array('class'=>'span1 pesan','readonly'=>true, 'style'=>'text-align:right;')).' '.$modDetail->satuanbrg; ?></td>
    <?php //} ?>
    <td style="text-align:right;"><?php echo CHtml::activeTextField($modDetail, '[]qty_mutasi', array('class'=>'span1 numbersOnly mutasi', 'onblur'=>'', 'style'=>'text-align:right;')).' '.$modDetail->satuanbrg; ?></td>
    <!--<td><?php //echo CHtml::activeDropDownList($modDetail, '[]satuanbrg', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>-->
    <td><?php echo Chtml::link('<icon class="icon-form-silang"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
</tr>        