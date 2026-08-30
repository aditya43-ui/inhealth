<tr> 
<!--    <td>
        <?php //echo $form->textField($model,'['.$i.']no',array('readonly'=>true,'style'=>'width:20px;','value'=>$no,'id'=>'REBarangsupplierM_no')) ?>
    </td>-->
    <td><?php 
        echo CHtml::activeHiddenField($modDetail,'[]obatalkes_id', array('class'=>'barang'));
        echo CHtml::activeHiddenField($modDetail,'[]supplier_id', array('class'=>'barang'));
        echo $modBarang->jenisobatalkes->jenisobatalkes_nama; 
        ?>
    </td>
    <td><?php echo $modBarang->subjenis->subjenis_nama; ?></td>
    <td><?php echo $modBarang->obatalkes_kode; ?></td>
    <td><?php echo $modBarang->obatalkes_nama; ?></td>
    <td><?php echo $modBarang->satuanbesar->satuanbesar_nama; ?></td>
    <td><?php echo CHtml::activeTextField($modDetail,'[]belinonppn',array('id'=>'belinonppn','onkeyup'=>'hitungbeliplusdisc(this);','class'=>'span1 currency barang','style'=>'width:60px;')); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail,'[]disc1',array('id'=>'disc1','onblur'=>'hitungbeliplusdisc(this);','class'=>'span1 currency barang','style'=>'width:60px;')); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail,'[]disc2',array('id'=>'disc2','onblur'=>'hitungbeliplusdisc(this);','class'=>'span1 currency barang','style'=>'width:60px;')); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail,'[]beliplusdisc',array('id'=>'beliplusdisc','onblur'=>'hitungbeliplusdisc(this);','span1 class'=>'currency barang','style'=>'width:60px;')); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail,'[]ppn',array('onblur'=>'hitungbeliplusdisc(this);','id'=>'ppn','class'=>'span1 currency barang','style'=>'width:60px;')); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail,'[]othercost',array('id'=>'othercost','class'=>'span1 currency barang','style'=>'width:60px;')); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail,'[]totalbeliplusppn',array('onblur'=>'hitungbeliplusdisc(this);','id'=>'totalbeliplusppn','class'=>'span1 currency barang','style'=>'width:60px;')); ?></td>
    <td><?php echo Chtml::link('<icon class="icon-remove"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
</tr>  
