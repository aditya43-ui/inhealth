<div id="<?php echo $id; ?>" class="parent">    
    <div class="control-group lookup">
        <label class="control-label"><?php echo ($count == 0)?$val:''; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <div class="controls">
            <?php 
                echo CHtml::activeHiddenField($model, '[det]['.$i.']inputintraanastesi_id', array('class' => 'span1'));
                echo CHtml::activeTextField($model, '[det]['.$i.']nama_input',array('placeholder' => 'ketikkan nilai '.$val,'class' => 'span4 nama_input'));
                echo CHtml::activeHiddenField($model, '[det]['.$i.']jenis_input',array('class' => 'span4', 'readonly' => true)); 
                echo CHtml::activeHiddenField($model, '[det]['.$i.']sub_jenis_input',array('class' => 'span4', 'readonly' => true)); 
                echo CHtml::activeHiddenField($model, '[det]['.$i.']ukuran',array('class' => 'span4', 'readonly' => true));
            ?>
        </div> 
        <div class="controls row-button">
            <?php
                echo CHtml::link("<i class='".MyIcon::getIcons('tambah-baris')."'></i>","javascript:;",array('class' => 'buttontambah','onclick' => 'tambahBaris(this,\''.$id.'\')', 'style' => 'background:#333;border-radius:70%;color:#fff;font-size:20px;', 'rel'=>'tooltip','data-original-title'=>'Klik untuk menambahkan data '.$val));
                
                echo CHtml::link("<i class='".MyIcon::getIcons('hapus-baris')."'></i>","javascript:;",array('class' => 'hide buttonhapus','onclick' => 'hapusBaris(this,\''.$id.'\')', 'style' => 'background:#db1111;border-radius:70%;color:#fff;font-size:20px;', 'rel'=>'tooltip','data-original-title'=>'Klik untuk menghapus data '.$val));
            ?>
        </div>
    </div>
</div>