<div id="<?php echo $id; ?>" class="parent">
    <div class="control-group komponendarah">
        <label class="control-label" style="text-align:left;">
            <?php echo CHtml::activeHiddenField($model,'[det]['.$i.'][det]['.$j.']inputintraanastesi_id', array('class' => 'span1')); ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php echo CHtml::activeCheckBox($model, '[det]['.$i.'][det]['.$j.']sub_jenis_input',array('value' => $kom->singkatan_komp)).'&nbsp;'.$kom->singkatan_komp ?></label>
        <div class="controls">
            <?php
                echo CHtml::activeTextField($model, '[det]['.$i.'][det]['.$j.']nama_input',array('placeholder' => 'No. Kantong Darah','class' => 'span2'));
                echo CHtml::activeHiddenField($model, '[det]['.$i.'][det]['.$j.']jenis_input',array('class' => 'span2', 'readonly' => true)); 
                //echo CHtml::activeHiddenField($model, '[det]['.$i.'][det]['.$j.']sub_jenis_input',array('class' => 'span4', 'readonly' => true));                                         
            ?>
        </div>                        
        <div class="controls">
            <?php 
                echo CHtml::activeTextField($model, '[det]['.$i.'][det]['.$j.']ukuran',array('placeholder' => 'Volume','class' => 'numbers-only', 'style' => 'width:80px;'));
            ?>
        </div>  
        <div class="controls">
            <label>CC</label>
        </div>
        <div class="controls rowbutton" style="padding-right:15px;">
            <?php
                echo '&nbsp;'.CHtml::link("<i class='".MyIcon::getIcons('tambah-baris')."'></i>","javascript:;",array('class' => 'buttontambah','onclick' => 'tambahBaris(this,\''.$id.'\',\'kantongdarah\')', 'style' => 'background:#333;border-radius:70%;color:#fff;font-size:20px;', 'rel'=>'tooltip','data-original-title'=>'Klik untuk menambahkan komponen darah '.$kom->singkatan_komp));
                
                echo '&nbsp;'.CHtml::link("<i class='".MyIcon::getIcons('hapus-baris')."'></i>","javascript:;",array('class'=>'hide buttonhapus','onclick' => 'hapusBaris(this,\''.$id.'\',\'kantongdarah\')', 'style' => 'background:#db1111;border-radius:70%;color:#fff;font-size:20px;', 'rel'=>'tooltip','data-original-title'=>'Klik untuk menghapus komponen darah '.$kom->singkatan_komp));
            ?>
        </div>
    </div>    
</div>