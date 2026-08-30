<?php
$i = !empty($i)?$i:0;
?>
<tr class="baris">
    <td><label class="nomor"><?= ($i+1) ?></label></td>
    <td>
        <?= CHtml::activeDropDownList($model, '['.$i.']jenis_teknisi', $look_tek,['onchange'=>'cekJenisTeknisi(this);','class'=>'jenis_teknisi required']) ?>
        <?=        CHtml::activeHiddenField($model, '['.$i.']teknisipemeliharaanaset_id',['class'=>'det_id teknisipemeliharaanaset_id']) ?>
    </td>
    <td>
        <?= CHtml::activeHiddenField($model, '['.$i.']nama_teknisi',['class'=>'nama_teknisi required']) ?>
        <div class="pegawai-ins hide">
            <?php
                $this->widget('ext.select2.ESelect2', array(
                    'model'=>$model,
                    'attribute' => '['.$i.']pegawai_id',
                    'data' => $drop_ins,
                    'options' => array(
                        'placeholder' =>'-- Pilih --',
                        'allowClear' => true,       
                        'width'=>'200px;',                        
                    ),
                    'htmlOptions' => [
                        'class' => 'internal_id required',  
                        'onchange'=> 'setNama(this)'
                    ]
                ));
            ?>
        </div>
        <div class="pegawai-eks hide">
            <?php
                $this->widget('ext.select2.ESelect2', array(
                    'model'=>$model,
                    'attribute' => '['.$i.']teknisiperalatan_id',
                    'data' => $drop_eks,
                    'options' => array(
                            'placeholder' =>'-- Pilih --',
                            'allowClear' => true,       
                            'width'=>'200px;',                            
                    ),
                    'htmlOptions' => [
                        'class' => 'eksternal_id required',                    
                        'onchange'=> 'setNama(this)'
                    ]
                ));
            ?>
        </div>
    </td>
    <td style="text-align:center;">
        <?= CHtml::link("<i class='".MyIcon::getIcons('tambah-baris')."'></i>",'javascript:;',['onclick'=>'set_action(this,"tambah")','class'=>'btn btn-primary btn-tambah','style'=>'padding:5px;color:#fff;']) ?>                        
        <?= '&nbsp;' ?>
        <?= CHtml::link("<i class='".MyIcon::getIcons('hapus-baris')."'></i>",'javascript:;',['onclick'=>'set_action(this,"hapus")','class'=>'btn btn-danger btn-hapus','style'=>'padding:5px;color:#fff;']) ?>
    </td>
</tr>