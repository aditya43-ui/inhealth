<div id="<?php echo $id; ?>" class="parent">
    <div class="control-group komponendarah">
        <label class="control-label">Darah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <div class="controls">
            <?php echo CHtml::activeHiddenField($model,'[det]['.$id.']inputintraanastesi_id', array('class' => '')); ?>
            <?php echo CHtml::activeDropDownList($model, '[det]['.$id.']sub_jenis_input', CHtml::listData(JeniskomponendarahM::model()->findAllByAttributes(array('jeniskantongdarah_aktif'=>true)),'jeniskantongdarah_singkatan','jeniskantongdarah_singkatan'),array('class'=>'span1','empty'=>'--Pilih--')) ?>
        </div>
        <div class="controls">
            <?php
                echo CHtml::activeTextField($model, '[det]['.$id.']nama_input',array('placeholder' => 'No. Kantong Darah','class' => '', 'style' => 'width:82px;'));
                echo CHtml::activeHiddenField($model, '[det]['.$id.']jenis_input',array('class' => 'span2', 'readonly' => true)); 
            ?>
        </div>                        
        <div class="controls">
            <?php 
                echo CHtml::activeTextField($model, '[det]['.$id.']ukuran',array('placeholder' => 'Volume','class' => 'numbers-only', 'style' => 'width:50px;'));
            ?>
        </div>  
        <div class="controls">
            <label>CC</label>
        </div>
        <div class="controls rowbutton" style="padding-right:15px;">
            <?php
                echo '&nbsp;'.CHtml::link("<i class='".MyIcon::getIcons('tambah-baris')."'></i>","javascript:;",array('class' => 'buttontambah','onclick' => 'tambahBaris(this,\''.$id.'\',\'kantongdarah\')', 'style' => 'background:#333;border-radius:70%;color:#fff;font-size:20px;', 'rel'=>'tooltip','data-original-title'=>'Klik untuk menambahkan komponen darah '));
                
                echo '&nbsp;'.CHtml::link("<i class='".MyIcon::getIcons('hapus-baris')."'></i>","javascript:;",array('class'=>'hide buttonhapus','onclick' => 'hapusBaris(this,\''.$id.'\',\'kantongdarah\')', 'style' => 'background:#db1111;border-radius:70%;color:#fff;font-size:20px;', 'rel'=>'tooltip','data-original-title'=>'Klik untuk menghapus komponen darah '));
            ?>
        </div>
    </div>    
</div>