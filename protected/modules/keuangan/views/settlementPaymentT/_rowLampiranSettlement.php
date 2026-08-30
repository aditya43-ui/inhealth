<?php 

if(!empty($modSettlementPaymentLamps)) {
    // $this->renderPartial($this->path_view.'_cekvalidTindakanPasien',array('modTindakans'=>$modTindakans,'catatan'=>$catatan,'removeButton'=>true));
} else {
    
?>
<tr>
    
    <td>
      <?php echo Chtml::activeFileField($modSettlementPaymentLamp, '[0]lampiran', array('maxlength' => 254, 'hint' => 'Isi Jika Akan Menambahkan Lampiran')); ?>
    </td>
    <td>
    <?php echo CHtml::activeTextField($modSettlementPaymentLamp, '[0]noreferensi', array('class'=>'inputFormTabel')) ?>

    </td>
    <td>
    <?php echo CHtml::activeTextArea($modSettlementPaymentLamp, '[0]keterangan', array('class'=>'inputFormTabel')) ?>

    </td>
  
    <td>
        <?php 
            if(!isset($removeButton)){
                $removeButton = false;
            }
            if($removeButton){
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowLamp(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah lampiran SAP', 'data-placement'=>'right')); 
                echo "&nbsp;&nbsp;";
                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalLamp(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan lampiran SAP', 'data-placement'=>'right'));
            } else {
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowLamp(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah lampiran', 'data-placement'=>'right'));
            }
        ?>
    </td>
</tr>
<?php } ?>
 




