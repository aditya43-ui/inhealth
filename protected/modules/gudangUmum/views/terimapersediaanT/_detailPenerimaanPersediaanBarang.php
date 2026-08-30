<tr>
    <td><?php
        echo CHtml::activeHiddenField($modDetail, '[]barang_id',array('class'=>'barang'));
        echo CHtml::activeHiddenField($modDetail, '[]satuanbeli',array());
        echo CHtml::activeHiddenField($modDetail, '[]hargasatuanmaster',array('class'=>'integer-decimal')); 
        echo CHtml::activeHiddenField($modDetail, '[]namabarangmaster');
        echo CHtml::activeHiddenField($modDetail, '[]hppcheck');
        echo $modBarang->barang_type;
        ?>
    </td>
    <td><?php echo $modBarang->barang_kode; ?></td>
    <td><?php echo $modBarang->barang_nama; ?></td>
    <td><?php echo CHtml::activeTextField($modDetail, '[]jmldalamkemasan', array( 'class'=>'span1','readonly'=>true)); ?></td>
    <td>
    <?php
        echo CHtml::activeTextField($modDetail, '[]jmlbeli', array('class'=>'span1 integer-decimal jmlbeli', 'readonly'=>true, 'style'=>'text-align: right;'));
    ?>
    </td>
    <td>
    <?php
        echo CHtml::activeTextField($modDetail, '[]jmlterima', array('class'=>'span1 integer-decimal qty', 'onblur'=>'setTotalHarga(); '.((isset($modBeli)) ?'cekTerima(this)':''), 'style'=>'text-align: right;','readonly'=>true)).' '.$modBarang->barang_satuan;
    ?>
    </td>
    <td>
    <?php
        echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($modDetail, '[]hargasatuan', array('class'=>'span2 integer-decimal satuan', 'onblur'=>'setTotalHarga();', 'readonly'=>true, 'style'=>'text-align: right;')):CHtml::activePasswordField($modDetail, '[]hargasatuan', array('class'=>'span2 integer-decimal satuan', 'onblur'=>'setTotalHarga();', 'readonly'=>true, 'style'=>'text-align: right;'));
    ?>
    </td>
        <td>
    <?php
        echo CHtml::activeTextField($modDetail, '[]persendiscount', array('class'=>'span1 integer-decimal persendiscount', 'onblur'=>'setTotalHarga();', 'readonly'=>true, 'style'=>'text-align: right;'));
    ?>
    </td>
        <td>
    <?php
        echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($modDetail, '[]jmldiscount', array('class'=>'span2 integer-decimal jmldiscount', 'onblur'=>'setTotalHarga();', 'readonly'=>true, 'style'=>'text-align: right;')):CHtml::activePasswordField($modDetail, '[]jmldiscount', array('class'=>'span2 integer-decimal jmldiscount', 'onblur'=>'setTotalHarga();', 'readonly'=>true, 'style'=>'text-align: right;'));
    ?>
    </td>
        <td>
    <?php
        echo CHtml::activeTextField($modDetail, '[]persenppn', array('class'=>'span1 numbersOnly persenppn', 'onblur'=>'setTotalHarga();', 'readonly'=>true, 'style'=>'text-align: right;'));
    ?>
    </td>
        <td>
    <?php
        echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($modDetail, '[]jmlppn', array('class'=>'span2 integer-decimal jmlppn', 'readonly'=>true, 'style'=>'text-align: right;')):CHtml::activePasswordField($modDetail, '[]jmlppn', array('class'=>'span2 integer-decimal jmlppn', 'readonly'=>true, 'style'=>'text-align: right;'));
    ?>
    </td>
        <td>
    <?php
        echo CHtml::activeTextField($modDetail, '[]persenpph', array('class'=>'span1 integer-decimal persenpph', 'onblur'=>'setTotalHarga();', 'readonly'=>true, 'style'=>'text-align: right;'));
    ?>
    </td>
        <td>
    <?php
        echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($modDetail, '[]jmlpph', array('class'=>'span2 integer-decimal jmlpph', 'readonly'=>true, 'style'=>'text-align: right;')):CHtml::activePasswordField($modDetail, '[]jmlpph', array('class'=>'span2 integer-decimal jmlpph', 'readonly'=>true, 'style'=>'text-align: right;'));
    ?>
    </td>
    <td>
    <?php
        echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($modDetail, '[]hargabeli', array('class'=>'span2 integer-decimal hargabeli', 'onblur'=>'setTotalHarga();',  'readonly'=>true, 'style'=>'text-align: right;')):CHtml::activePasswordField($modDetail, '[]hargabeli', array('class'=>'span2 hargabeli integer-decimal', 'onblur'=>'setTotalHarga();',  'readonly'=>true, 'style'=>'text-align: right;'));
    ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail, '[]kondisibarang',array('class'=>'span2','readonly'=>true));  ?>
    <td><?php echo Chtml::link('<icon class="icon-remove"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
</tr>