<?php
    $i = !empty($i)?$i:0;
?>
<tr>
    <td class="cpis-nama"><?= $model->label ?></td>
    <td>
        <?php               
            $model->skorpenilaian = ($model->skorpenilaian=='')?0:$model->skorpenilaian;
            if ($model->input == 'dropdown'){
                $drop = LookupM::getItemsUrutan([$model->type]);
                $options = [];
                $skor = 0;
                foreach($drop as $key => $val){
                    $options[$key] = [
                        'skor'=>$skor
                    ];
                    $skor++;
                }
                echo CHtml::activeDropDownList($model, '['.$i.']hasipenilaian', $drop,['empty'=>'-- Pilih --', 'onchange'=>'cekNilai("'.$model->input.'", this)','options'=>$options]);
            }else{
                echo CHtml::activeTextField($model, '['.$i.']hasipenilaian',['onchange'=>'cekNilai("'.$model->label.'", this)', 'class'=>$model->rule]);
            }
        ?>
    </td>
    <td>
        <?php
            echo CHtml::activeTextField($model, '['.$i.']skorpenilaian', ['class'=>'skorpenilaian', 'readonly'=>true]);
            echo CHtml::activeHiddenField($model, '['.$i.']nourut');
            echo CHtml::activeHiddenField($model, '['.$i.']cpispasiendet_id',['class'=>'open-field']);
        ?>
    </td>
</tr>