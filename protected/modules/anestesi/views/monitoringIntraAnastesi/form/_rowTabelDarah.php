<?php 
$a = 'darah';
$b = '';
$val= 'DARAH'; 
?>
<div id="darah" class="parent">
    <div class="control-group lookup">
        <label class="control-label">Darah</label>
        <div class="controls">
            <?php echo CHtml::activeDropDownList($model, '[DARAH]['.$i.']sub_jenis_input', CHtml::listData(JeniskomponendarahM::model()->findAllByAttributes(array('jeniskantongdarah_aktif'=>true)),'jeniskantongdarah_singkatan','jeniskantongdarah_singkatan'),array('class'=>'span1','empty'=>'-Pilih-')) ?>
            <?php echo CHtml::activeHiddenField($model,'[DARAH]['.$i.']inputintraanastesi_id',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
            <?php echo CHtml::activeTextField($model,'[DARAH]['.$i.']nama_input',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200,'style'=>'width:105px;', 'placeholder'=>'No. Kantong')); ?>
            <?php echo CHtml::activeHiddenField($model,'[DARAH]['.$i.']jenis_input',array('value'=>$val,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
            <?php echo CHtml::activeTextField($model,'[DARAH]['.$i.']ukuran',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200,'placeholder'=>'Volume')); ?>
        CC
        </div>
        <div class="controls row-button">
            <?php echo CHtml::link("<i class='".MyIcon::getIcons('tambah-baris')."'></i>","javascript:;",array('class' => 'buttontambah','onclick' => 'tambahBaris2(this,\''.$a.'\',\''.$b.'\')', 'style' => 'background:#333;border-radius:70%;color:#fff;font-size:20px;', 'rel'=>'tooltip','data-original-title'=>'Klik untuk menambahkan data '.$val));
                  echo CHtml::link("<i class='".MyIcon::getIcons('hapus-baris')."'></i>","javascript:;",array('class' => 'hide buttonhapus','onclick' => 'hapusBaris2(this,\''.$a.'\',\''.$b.'\')', 'style' => 'background:#db1111;border-radius:70%;color:#fff;font-size:20px;', 'rel'=>'tooltip','data-original-title'=>'Klik untuk menghapus data '.$val));
            ?>
        </div>
    </div>
</div>