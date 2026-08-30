<?php
if(isset($modPengpegdets) && count((array)$modPengpegdets) > 0) {
    $this->renderPartial('_daftarAddPengcal',array('modPengpegdets'=>$modPengpegdets,'id'=>$id,'removeButton'=>true));
} else {
?>

<tr>
    <td><?php echo CHtml::activeTextField($modPengpegdet,'[0]nourut',array('class'=>'span1 isDetailReq', 'readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)", 'style'=>'text-align:right')); ?></td>
        <td><?php echo CHtml::activeTextField($modPengpegdet,'[0]jmlorang',array('class'=>'numbers-only span1 required', 'onkeyup'=>"return $(this).focusNextInputField(event)",'maxlength'=>3, 'style'=>'text-align:right')); ?></td>
        <td><?php echo CHtml::activeTextArea($modPengpegdet,'[0]untukkeperluan', array('style'=>'resize:none;','rows'=>2, 'cols'=>20, 'class'=>'span3 isDetailReq','onkeyup'=>"return $(this).focusNextInputField(event)"))?></td>
        <td><?php echo CHtml::activeTextArea($modPengpegdet,'[0]keterangan', array('style'=>'resize:none;','rows'=>2, 'cols'=>20, 'class'=>'span3 isDetailReq','onkeyup'=>"return $(this).focusNextInputField(event)"))?></td>
        <td><?php echo CHtml::activeCheckBox($modPengpegdet,'[0]disetujui', array('checked'=>true,'class'=>'span1 isDetailReq','onkeyup'=>"return $(this).focusNextInputField(event)"))?></td>
        <td>
            <?php 
            $removeButton = (isset($removeButton)) ? $removeButton : false;
            if($removeButton){
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah tindakan')); 
                echo "<br><br>";
                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan tindakan'));
            } 
            else {
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah tindakan'));
            }
        ?>
        </td>
    </tr>
            
            
<?php } ?>