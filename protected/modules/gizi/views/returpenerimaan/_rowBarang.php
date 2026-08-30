<?php 
if (isset($modDetails)){
    $no = 1;
foreach ($modDetails as $i=>$detail){?>
<?php 
$modBahan = BahanmakananM::model()->findByPk($detail->terimabahandetail->bahanmakanan_id); ?>
    <tr>   
        <td class="noUrut"><?php echo $no++; ?></td>
        <td><?php  
                echo CHtml::activeHiddenField($detail, '['.$i.']terimabahandetail_id');
                echo CHtml::activeHiddenField($detail, '['.$i.']satuanbeli');
                echo CHtml::activeHiddenField($detail, '['.$i.']persendiscount',array('class'=>'persendiscount'));
                echo CHtml::activeHiddenField($detail, '['.$i.']persenppn',array('class'=>'persenppn'));
                echo CHtml::activeHiddenField($detail, '['.$i.']persenpph',array('class'=>'persenpph'));
                echo $modBahan->kelbahanmakanan;
            ?>
        </td>
        <td><?php echo $modBahan->namabahanmakanan; ?></td>
        <td>
        <?php 
            $detail->harganetto = MyFormatter::formatNumberForPrint($modBahan->harganettobahan);
            echo  CHtml::activeTextField($detail, '['.$i.']harganetto', array('class'=>'span2 float2 harganetto', 'readonly'=>true, 'style'=>'text-align: right;'));
        ?>
        </td>
        <td>
        <?php 
            echo  CHtml::activeTextField($detail, '['.$i.']jmldiscount', array('class'=>'span2 float2 jmldiscount', 'readonly'=>true, 'style'=>'text-align: right;'));
        ?>
        </td>
        <td>
        <?php 
            echo  CHtml::activeTextField($detail, '['.$i.']jmlppn', array('class'=>'span2 float2 jmlppn', 'readonly'=>true, 'style'=>'text-align: right;'));
        ?>
        </td>
        <td>
        <?php 
            echo  CHtml::activeTextField($detail, '['.$i.']jmlpph', array('class'=>'span2 float2 jmlpph', 'readonly'=>true, 'style'=>'text-align: right;'));
        ?>
        </td>
        
        <td>
        <?php 
            echo CHtml::activeTextField($detail, '['.$i.']jmlterima', array('class'=>'span1 numbersOnly terima', 'readonly'=>true, 'style'=>'text-align: right;')).' '.$detail->satuanbeli;
        ?>
        </td>
        <td>
        <?php 
            echo CHtml::activeTextField($detail, '['.$i.']jmlretur', array('class'=>'span1 numbersOnly retur', 'onblur'=>'hitungRetur();', 'style'=>'text-align: right;')).' '.$detail->satuanbeli;
            echo '<br>';
            echo CHtml::error($detail, '['.$i.']jmlterima');
        ?>
        </td>
        <td>
        <?php 
            echo  CHtml::activeTextField($detail, '['.$i.']hargasatuan', array('class'=>'span2 float2 hargasatuan', 'readonly'=>true, 'style'=>'text-align: right;'));
        ?>
        </td>
        <td>
        <?php 
            echo  CHtml::activeTextField($detail, '['.$i.']subtotal', array('class'=>'span2 float2 subtotal', 'readonly'=>true, 'style'=>'text-align: right;'));
        ?>
        </td>
        <td><?php echo CHtml::activeDropDownList($detail, '['.$i.']kondisibahanmakan', LookupM::getItems('inventariskeadaan'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?>
         <?php echo '<br>';
            echo CHtml::error($detail, '['.$i.']kondisibahanmakan'); ?>
        </td>
                    
        <td style="text-align: center; width: 60px;"><?php echo Chtml::link('<icon class="icon-form-silang"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
    </tr>   
<?php }
}
?>