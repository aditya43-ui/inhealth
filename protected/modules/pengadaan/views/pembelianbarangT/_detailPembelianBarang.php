<tr>   
    <!--<td><?php 
        //echo CHtml::activeHiddenField($modDetail, '[]barang_id', array('class'=>'barang')); 
        //echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->kelompok->bidang->golongan->golongan_nama:null; 
        ?>
    </td>
    <td><?php //echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->kelompok->bidang->bidang_nama:null; ?></td>
    <td><?php //echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->kelompok->kelompok_nama:null; ?></td>
    <td><?php //echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->subkelompok_nama:null; ?></td>
    <td><?php //echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subsubkelompok_nama:null; ?></td>-->
    <td>
        <?php echo CHtml::activeHiddenField($modDetail, '[]barang_id', array('class'=>'barang')); ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[]hpp', array('class'=>'integer-decimal hpp')); ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[]satuanbeli'); ?>
        <?php echo $modBarang->barang_type; ?>
    </td>
    <td><?php echo $modBarang->barang_kode; ?></td>
    <td><?php echo $modBarang->barang_nama; ?></td>
<!--    <td><?php // echo $modBarang->barang_merk; ?></td>        
    <td><?php // echo $modBarang->barang_ukuran; ?></td>
    <td><?php // echo $modBarang->barang_ekonomis_thn; ?></td>-->
    <td><?php echo CHtml::activeTextField($modDetail, '[]jmldlmkemasan', array('class'=>'span1 integer2', 'style'=>'text-align: right;')); ?></td>    
    <td><?php echo CHtml::activeTextField($modDetail, '[]jmlbeli', array('class'=>'span1 integer-decimal qty', 'style'=>'text-align: right;', 'onblur'=>'hitungAllTotal()')).' '.$modBarang->barang_satuan; ?></td>
    <td><?php echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($modDetail, '[]hargasatuan', array('class'=>'span2 integer-decimal satuan', 'style'=>'text-align: right;', 'onblur'=>'hitungAllTotal()')):CHtml::activePasswordField($modDetail, '[]hargasatuan', array('class'=>'span2 integer-decimal satuan', 'style'=>'text-align: right;', 'onblur'=>'hitungAllTotal()')); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '[]persendiscount', array('class'=>'span1 integer-decimal persendiscount', 'style'=>'text-align: right;', 'onblur'=>'hitungAllTotal()')); ?></td>
    <td><?php echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($modDetail, '[]jmldiscount', array('readonly'=>true,'class'=>'span2 integer-decimal jmldiscount', 'style'=>'text-align: right;')):CHtml::activePasswordField($modDetail, '[]jmldiscount', array('class'=>'span2 integer-decimal jmldiscount', 'style'=>'text-align: right;', 'onblur'=>true)); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '[]persen_ppn', array('class'=>'span1 integer2 ppn', 'style'=>'text-align: right;', 'onblur'=>'hitungAllTotal()')); ?></td>
    <td><?php echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($modDetail, '[]ppn', array('readonly'=>true,'class'=>'span2 integer-decimal ppn_nilai', 'style'=>'text-align: right;')):CHtml::activePasswordField($modDetail, '[]ppn', array('class'=>'span2 integer-decimal ppn_nilai', 'style'=>'text-align: right;', 'onblur'=>true)); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '[]persenpph', array('class'=>'span1 integer-decimal persenpph', 'style'=>'text-align: right;', 'onblur'=>'hitungAllTotal()')); ?></td>
    <td><?php echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($modDetail, '[]jmlpph', array('readonly'=>true,'class'=>'span2 integer-decimal jmlpph', 'style'=>'text-align: right;')):CHtml::activePasswordField($modDetail, '[]jmlpph', array('class'=>'span2 integer-decimal jmlpph', 'style'=>'text-align: right;', 'onblur'=>true)); ?></td>
<!--<td><?php // echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($modDetail, '[]hpp', array('readonly'=>true,'class'=>'span2 integer-decimal hpp', 'style'=>'text-align: right;', 'onblur'=>true)):CHtml::activePasswordField($modDetail, '[]hpp', array('class'=>'span2 integer2 hpp', 'style'=>'text-align: right;', 'onblur'=>true)); ?></td>-->
    <td><?php echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($modDetail, '[]hargabeli', array('readonly'=>true,'class'=>'span2 integer-decimal beli', 'style'=>'text-align: right;', 'onblur'=>true)):CHtml::activePasswordField($modDetail, '[]hargabeli', array('class'=>'span2 integer-decimal beli', 'style'=>'text-align: right;', 'onblur'=>true)); ?></td>
    <!--<td><?php //echo CHtml::activeDropDownList($modDetail, '[]satuanbeli', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>    -->
    <td><?php echo Chtml::link('<icon class="icon-remove"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
</tr>        