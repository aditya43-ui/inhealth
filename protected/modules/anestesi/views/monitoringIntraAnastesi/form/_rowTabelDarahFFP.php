<?php 
$a = 'ffp';
$b = '';
$id = 'FFP';
$val= 'DARAH'; 
?>
<div id="ffp" class="parent">
    <div class="control-group lookup">
        <label class="control-label"><?php echo CHtml::activeCheckBox($model,'[FFP]['.$i.']sub_jenis_input',array('value' => $id)).'&nbsp;'.$id; ?></label>
        <div class="controls">
            <?php echo CHtml::activeHiddenField($model,'[FFP]['.$i.']inputintraanastesi_id',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200,'style'=>'border:1px solid #333;')); ?>
            <?php echo CHtml::activeTextField($model,'[FFP]['.$i.']nama_input',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200,'style'=>'border:1px solid #333;')); ?>
            <?php echo CHtml::activeHiddenField($model,'[FFP]['.$i.']jenis_input',array('value'=>$val,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
            <?php echo CHtml::activeTextField($model,'[FFP]['.$i.']ukuran',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200,'style'=>'width:80px;border:1px solid #333;')); ?>
        CC
        </div>
        <div class="controls row-button">
            <?php echo CHtml::link("<i class='".MyIcon::getIcons('tambah-baris')."'></i>","javascript:;",array('class' => 'buttontambah','onclick' => 'tambahBaris2(this,\''.$a.'\',\''.$b.'\')', 'style' => 'background:#333;border-radius:70%;color:#fff;font-size:20px;', 'rel'=>'tooltip','data-original-title'=>'Klik untuk menambahkan data '.$val));
                  echo CHtml::link("<i class='".MyIcon::getIcons('hapus-baris')."'></i>","javascript:;",array('class' => 'hide buttonhapus','onclick' => 'hapusBaris2(this,\''.$a.'\',\''.$b.'\')', 'style' => 'background:#db1111;border-radius:70%;color:#fff;font-size:20px;', 'rel'=>'tooltip','data-original-title'=>'Klik untuk menghapus data '.$val));
            ?>
        </div>
    </div>
</div>