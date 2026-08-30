<tr> 
    <td>
        <?php echo CHtml::activeTextField($modObat,'['.$modBarang->brg_id.']no',array('readonly'=>true,'class'=>'span1 no','value'=>1)) ?>
    </td>
    <td><?php 
        echo Chtml::hiddenField("stok",$data["stok"], array('class'=>'stok span1', 'readonly'=>true));
        echo CHtml::activeHiddenField($modObat, '['.$modBarang->brg_id.']obatalkes_id', array('class'=>'barang span1', 'readonly'=>true));
        echo CHtml::hiddenField("hargajual",$data["sub"], array("readonly"=>true, "class"=>"span2 harga"));
        echo CHtml::hiddenField("harganetto",$data["netto"], array("readonly"=>true, "class"=>"span2 netto"));
        echo CHtml::hiddenField("mintransaksi",$modBarang->mintransaksi, array("readonly"=>true, "class"=>"span2 mintransaksi"));
        echo CHtml::activeHiddenField($modObat, '['.$modBarang->brg_id.']sumberdana_id', array('class'=>'span1', 'readonly'=>true));
        echo CHtml::activeHiddenField($modObat, '['.$modBarang->brg_id.']biayaadministrasi', array('class'=>'span1 administrasi', 'readonly'=>true));
        echo CHtml::activeHiddenField($modBarang, 'ppn_persen', array('class'=>'span1 ppn', 'readonly'=>true));
        echo CHtml::activeHiddenField($modObat,'['.$modBarang->brg_id.']discount',array('class'=>'disc_rp numbersOnly span1', 'onkeyup'=>'getTotal(this);','onblur'=>'getTotal(this);'));
        echo CHtml::hiddenField('discount_rp',$data["disc"], array('class'=>'disc numbersOnly2 span1', 'onkeyup'=>'getDiscount(this);','onblur'=>'getDiscount(this);'));
//         echo CHtml::activeHiddenField($modDetail, '[]supplier_id', array('class'=>'barang'));
        echo $modBarang->stock_code; 
        ?>
    </td>
    <td><?php echo $modBarang->stock_name; ?></td>
    <td><?php echo $modBarang->hargajual; ?></td>
    <td><?php echo CHtml::activeTextField($modObat,'['.$modBarang->brg_id.']qty_oa',array('class'=>'qty '.(($modBarang->mintransaksi) ? "numbersOnly" : "numbersOnly2").' span1', 'onkeyup'=>'getSubTotal(this);','onblur'=>'getSubTotal(this);','onkeypress'=>'if (event.keyCode == 13){$("#barang_barcode").focus();}')) ?></td>
<!--    <td>-->
        
<!--</td>-->
<!--    <td>-->
        
<!--</td>-->
    <td><?php 
    echo CHtml::activeHiddenField($modObat, '['.$modBarang->brg_id.']hargajual_oa', array('class'=>'sub span2', 'readonly'=>true));
    echo CHtml::activeHiddenField($modObat, '['.$modBarang->brg_id.']harganetto_oa', array('class'=>' subnetto span2', 'readonly'=>true));
    ?>
        <div class="text_sub" style="text-align:right"><?php echo number_format($modObat->hargajual_oa);?></div>
  </td>
    <td><?php echo Chtml::link('<icon class="icon-remove"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
</tr>        