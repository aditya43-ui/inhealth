<tr>   
    <td><?php 
    
        $golongan = "";
        $bidang = "";
        $kelompok = "";
        $subkelompok = "";
        $subsubkelompok = "";
        
        $jenis = JenisbarangM::model()->findByPk($modBarang->jenisbarang_id);
        $modDetail->namabarangmaster = $modBarang->barang_nama;
        $modDetail->hargasatuanmaster = $modBarang->barang_harganetto;
    
        echo CHtml::activeHiddenField($modDetail, '['.$key.']barang_id', array('class'=>'barang cancel')); 
        echo CHtml::activeHiddenField($modDetail, '['.$key.']terimapersdetail_id'); 
        echo CHtml::activeHiddenField($modDetail, '['.$key.']hargasatuanmaster'); 
        echo CHtml::activeHiddenField($modDetail, '['.$key.']namabarangmaster');
        echo CHtml::activeHiddenField($modDetail, '['.$key.']hppcheck');
        echo $modBarang->barang_type;
        $modDetail->hargabeli = number_format($modDetail->hargabeli,2,",",".");
        $modDetail->hargasatuan = number_format($modDetail->hargasatuan,2,",",".");
        $modDetail->jmlterima = number_format($modDetail->jmlterima,2,",",".");
        $modDetail->persendiscount = number_format($modDetail->persendiscount,2,",",".");
        $modDetail->persenpph = number_format($modDetail->persenpph,2,",",".");
        ?>
    </td>
	<td><?php echo empty($jenis) ? "-" : $jenis->jenisbarang_nama; ?></td>
    <td><?php echo $modBarang->barang_kode."/<br>".$modBarang->barang_nama; ?></td>
	<td><?php echo CHtml::activeTextField($modDetail, '['.$key.']jmlterima', array('class'=>'span1 integer-decimal qty', 'onblur'=>'setTotalHarga();','readonly'=>true)); ?></td>
	<td><?php echo CHtml::activeDropDownList($modDetail, '['.$key.']satuanbeli', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2','readonly'=>true)); ?></td>
	<td><?php echo CHtml::activeTextField($modDetail, '['.$key.']jmldalamkemasan', array('class'=>'span1 jml', 'style'=>'text-align: right;', 'readonly'=>true)); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '['.$key.']hargasatuan', array('class'=>'span2 integer-decimal satuan', 'onblur'=>'setTotalHarga();', 'readonly'=>true)); ?></td>
    <td>
        <?php echo CHtml::activeTextField($modDetail, '['.$key.']persendiscount', array('class'=>'span1 integer-decimal persendiscount', 'onblur'=>'setTotalHarga();', 'style'=>'text-align: right;','readonly'=>true)); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail, '['.$key.']jmldiscount', array('class'=>'span2 integer-decimal jmldiscount', 'onblur'=>'setTotalHarga();', 'readonly'=>true, 'style'=>'text-align: right;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail, '['.$key.']persenppn', array('class'=>'span1 integer2 persenppn', 'onblur'=>'setTotalHarga();', 'style'=>'text-align: right;','readonly'=>true)); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail, '['.$key.']jmlppn', array('class'=>'span2 integer-decimal jmlppn', 'readonly'=>true, 'style'=>'text-align: right;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail, '['.$key.']persenpph', array('class'=>'span1 integer-decimal persenpph', 'onblur'=>'setTotalHarga();', 'style'=>'text-align: right;','readonly'=>true)); ?>
    </td>
    <td>
    <?php echo CHtml::activeTextField($modDetail, '['.$key.']jmlpph', array('class'=>'span2 integer-decimal jmlpph', 'readonly'=>true, 'style'=>'text-align: right;')); ?>
    </td>
    <td><?php echo CHtml::activeTextField($modDetail, '['.$key.']hargabeli', array('class'=>'span2 integer-decimal beli text-right', 'onblur'=>'setTotalHarga();', 'readonly'=>true)); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '['.$key.']kondisibarang', array('class'=>'span2','readonly'=>true)); ?></td>
</tr>        
