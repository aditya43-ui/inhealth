<?php 
if (isset($modDetails)){
foreach ($modDetails as $i=>$detail){?>
<?php $modBarang = BarangM::model()->findByPk($detail->terimapersdetail->barang->barang_id); ?>
    <tr>   
        <td><?php  
            echo CHtml::activeHiddenField($detail, '['.$i.']terimapersdetail_id');
            echo CHtml::activeHiddenField($detail, '['.$i.']satuanbeli');
            echo CHtml::activeHiddenField($detail, '['.$i.']persendiscount',array('class'=>'persendiscount'));
            echo CHtml::activeHiddenField($detail, '['.$i.']persenppn',array('class'=>'persenppn'));
            echo CHtml::activeHiddenField($detail, '['.$i.']persenpph',array('class'=>'persenpph'));
           // $gol = empty($modBarang->subsubkelompok->subkelompok->kelompok)?"-":$modBarang->subsubkelompok->subkelompok->kelompok;
           // echo empty($modBarang->subsubkelompok->subkelompok->kelompok->bidang)?"-":$gol->bidang->bidang_nama;
        echo             $modBarang->barang_type;
            ?>
        </td>
       <!--<td><?php //echo empty($modBarang->subsubkelompok->subkelompok->kelompok)?"-":$modBarang->subsubkelompok->subkelompok->kelompok->kelompok_nama; ?></td>
        <td><?php //echo empty($modBarang->subsubkelompok->subkelompok)?"-":$modBarang->subsubkelompok->subkelompok->subkelompok_nama; ?></td>
        <td><?php //echo empty($modBarang->subsubkelompok)?"-":$modBarang->subsubkelompok->subsubkelompok_nama; ?></td>-->
        <td><?php echo $modBarang->barang_kode; ?></td>
        <td><?php echo $modBarang->barang_nama; ?></td>
        <td style="text-align: center;"><?php echo $modBarang->barang_jmldlmkemasan ; ?></td>
        <td>
        <?php 
            echo CHtml::activeTextField($detail, '['.$i.']jmlterima', array('class'=>'span1 numbersOnly terima', 'readonly'=>true, 'style'=>'text-align: right;')).' '.$detail->satuanbeli;
            echo '<br>';
            echo CHtml::error($detail, '['.$i.']jmlterima');
        ?>
        </td>
        <td>
        <?php 
            echo CHtml::activeTextField($detail, '['.$i.']jmlretur', array('class'=>'span1 numbersOnly retur', 'onblur'=>'cekRetur(this);', 'style'=>'text-align: right;')).' '.$detail->satuanbeli;
            echo '<br>';
            echo CHtml::error($detail, '['.$i.']jmlterima');
        ?>
        </td>
        <td>
        <?php 
            $detail->hargasatuan = MyFormatter::formatNumberForPrint($detail->hargasatuan);

            echo CHtml::activeTextField($detail, '['.$i.']hargasatuan', array('class'=>'span2 integer2 satuan', 'readonly'=>true, 'style'=>'text-align: right;'));
            echo '<br>';
            echo CHtml::error($detail, '['.$i.']hargasatuan');
        ?>
        </td>
        <td>
        <?php 
            echo CHtml::activeTextField($detail, '['.$i.']jmldiscount', array('class'=>'span2 integer2 jmldiscount', 'readonly'=>true, 'style'=>'text-align: right;'));
        ?>
        </td>
        <td>
        <?php 
            echo CHtml::activeTextField($detail, '['.$i.']jmlppn', array('class'=>'span2 integer2 jmlppn', 'readonly'=>true, 'style'=>'text-align: right;'));
        ?>
        </td>
        <td>
        <?php 
            echo CHtml::activeTextField($detail, '['.$i.']jmlpph', array('class'=>'span2 integer2 jmlpph', 'readonly'=>true, 'style'=>'text-align: right;'));
        ?>
        </td>
        <td>
        <?php 
            echo CHtml::activeTextField($detail, '['.$i.']hargaretur', array('class'=>'span2 integer2 hargaretur', 'readonly'=>true, 'style'=>'text-align: right;'));
        ?>
        </td>
        
       <!--<td><?php //echo CHtml::activeDropDownList($detail, '['.$i.']satuanbeli', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>-->
                    
            <td><?php echo CHtml::activeDropDownList($detail, '['.$i.']kondisibarang', LookupM::getItems('inventariskeadaan'),array('class'=>'span2')); ?></td>
        <td><?php echo Chtml::link('<icon class="icon-form-silang"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
    </tr>   
<?php }
}
?>