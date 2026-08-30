<?php 
$a = 'lain-lain';
$b = '';
$id = '';
$val= 'LAIN_LAIN'; 
?>
<div id="lain-lain" class="parent">
    <div class="control-group lookup">
        <label class="control-label">Lain-lain</label>
        <div class="controls">
            <?php echo CHtml::activeHiddenField($model,'[LAIN_LAIN]['.$i.']inputintraanastesi_id',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
            <?php echo CHtml::activeTextField($model,'[LAIN_LAIN]['.$i.']nama_input',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
            <?php echo CHtml::activeHiddenField($model,'[LAIN_LAIN]['.$i.']jenis_input',array('value'=>$val,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
            <?php echo CHtml::activeHiddenField($model,'[LAIN_LAIN]['.$i.']ukuran',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200,'style'=>'width:80px;')); ?>
        </div>
        <div class="controls row-button">
            <?php echo CHtml::link("<i class='".MyIcon::getIcons('tambah-baris')."'></i>","javascript:;",array('class' => 'buttontambah','onclick' => 'tambahBaris2(this,\''.$a.'\',\''.$b.'\')', 'style' => 'background:#333;border-radius:70%;color:#fff;font-size:20px;', 'rel'=>'tooltip','data-original-title'=>'Klik untuk menambahkan data '.$val));
                  echo CHtml::link("<i class='".MyIcon::getIcons('hapus-baris')."'></i>","javascript:;",array('class' => 'hide buttonhapus','onclick' => 'hapusBaris2(this,\''.$a.'\',\''.$b.'\')', 'style' => 'background:#db1111;border-radius:70%;color:#fff;font-size:20px;', 'rel'=>'tooltip','data-original-title'=>'Klik untuk menghapus data '.$val));
            ?>
        </div>
    </div>
</div>