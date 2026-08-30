<?php
$i = !empty($i)?$i:0;
?>
<div class="control-group pengelompokkan baris">
    <label class="control-label">Teknisi <span class="nomor"><?= $i=1 ?></span></label>
    <div class="controls">
        <?php
            $this->widget('ext.select2.ESelect2', array(
                'model'=>$model,
                'attribute' => '['.$i.']pegawai_id',
                'data' => $look,
                'options' => array(
                    'placeholder' =>'-- Pilih --',
                    'allowClear' => true,       
                    'width'=>'200px;',                        
                ),
                'htmlOptions' => [
                    'class' => 'pegawai_id required',  
                    'onchange'=> 'setNamaTeknisi(this)'
                ]
            ));
        ?>
        <?= CHtml::activeHiddenField($model, '['.$i.']nama_teknisi',['class'=>'nama_teknisi'])?>
        <?= CHtml::activeHiddenField($model, '['.$i.']teknisipemeliharaanaset_id',['class'=>'det_id teknisipemeliharaanaset_id'])?>
    </div>
    <div class="controls">
        <?= CHtml::link("<i class='".MyIcon::getIcons('tambah-baris')."'></i>",'javascript:;',['onclick'=>'set_action(this,"tambah")','class'=>'btn btn-primary btn-tambah','style'=>'padding:5px;color:#fff;']) ?>                
        <?= CHtml::link("<i class='".MyIcon::getIcons('hapus-baris')."'></i>",'javascript:;',['onclick'=>'set_action(this,"hapus")','class'=>'btn btn-danger btn-hapus','style'=>'padding:5px;color:#fff;']) ?>
    </div>
</div>