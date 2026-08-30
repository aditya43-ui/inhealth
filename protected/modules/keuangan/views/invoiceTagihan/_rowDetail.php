<?php 
if(count((array)$modInvoiceTagDetail)>0){
foreach ($modInvoiceTagDetail as $i => $detail) { ?>
<tr>
    <td>
        <?php echo $form->textField($detail,"[$i]uraian_tagdetail",array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
    </td>
    <td>
        <?php echo $form->textField($detail,"[$i]total_tagdetail",array('onblur'=>'hitungTotalTagihan()','class'=>'inputFormTabel lebar3 total_tagdetail integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo $form->textField($detail,"[$i]ket_tagdetail", array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php 
			if(!isset($removeButton)){
                $removeButton = false;
            }
			
            if($removeButton || $i>0){
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowDetail(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah uraian')); 
                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalDetail(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan uraian'));
            } else {
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowDetail(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah uraian'));
            }
        ?>
    </td>
</tr>
<?php } 
    }else{
	$detail = new KUInvoicetagdetailT;
?>
<tr>
    <td>
        <?php echo $form->textField($detail,"[0]uraian_tagdetail",array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
    </td>
    <td>
        <?php echo $form->textField($detail,"[0]total_tagdetail",array('onblur'=>'hitungTotalTagihan(this)','class'=>'inputFormTabel lebar3 total_tagdetail integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo $form->textField($detail,"[0]ket_tagdetail", array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php 
			if(!isset($removeButton)){
                $removeButton = false;
            }
            if($removeButton){
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowDetail(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah uraian')); 
                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalDetail(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan uraian'));
            } else {
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowDetail(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah uraian'));
            }
        ?>
    </td>
</tr>
<?php } ?>

