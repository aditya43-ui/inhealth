<?php 
if(count((array)$modInvoiceDisposisi)>0){
foreach ($modInvoiceDisposisi as $i => $disposisi) { ?>
<tr>
    <td>
        <?php echo $form->textField($disposisi,"[$i]uraian_disoposisi",array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
    </td>
    <td>
        <?php echo $form->textField($disposisi,"[$i]total_disposisi",array('class'=>'inputFormTabel lebar3 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo $form->textField($disposisi,"[$i]ket_disposisi", array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php 
			if(!isset($removeButton)){
                $removeButton = false;
            }
			
            if($removeButton || $i>0){
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowDisposisi(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah uraian')); 
                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalDisposisi(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan uraian'));
            } else {
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowDisposisi(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah uraian'));
            }
        ?>
    </td>
</tr>
<?php } 
    }else{
	$disposisi = new KUInvoicedisposisiT;
?>
<tr>
    <td>
        <?php echo $form->textField($disposisi,"[0]uraian_disoposisi",array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
    </td>
    <td>
        <?php echo $form->textField($disposisi,"[0]total_disposisi",array('class'=>'inputFormTabel lebar3 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo $form->textField($disposisi,"[0]ket_disposisi", array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php 
			if(!isset($removeButton)){
                $removeButton = false;
            }
            if($removeButton){
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowDisposisi(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah uraian')); 
                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalDisposisi(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan uraian'));
            } else {
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowDisposisi(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah uraian'));
            }
        ?>
    </td>
</tr>
<?php } ?>

