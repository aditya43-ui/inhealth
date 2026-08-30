<tr id-row="<?php echo $i ?>">
    <td>        
        <span class="menit-ke">
            <?php echo $model->menit_ke; ?>
        </span>
        <?php 
            echo CHtml::activeHiddenField($model, '[det]['.$i.']menit_ke',array('readonly'=>true, 'class' => 'menitke'));
            echo CHtml::activeHiddenField($model, '[det]['.$i.']temperature',array('readonly'=>true, 'class' => 'temperature')); 
            echo CHtml::activeHiddenField($model, '[det]['.$i.']respiration_rate',array('readonly'=>true, 'class' => 'respiration')); 
            echo CHtml::activeHiddenField($model, '[det]['.$i.']nadi',array('readonly'=>true, 'class' => 'nadi')); 
            echo CHtml::activeHiddenField($model, '[det]['.$i.']tekanandarah_sistolik',array('readonly'=>true, 'class' => 'sistolik')); 
            echo CHtml::activeHiddenField($model, '[det]['.$i.']tekanandarah_diastolik',array('readonly'=>true, 'class' => 'diastolik')); 
            echo CHtml::activeHiddenField($model, '[det]['.$i.']monitoringpascaanastesi_id',array('readonly'=>true, 'class' => 'id'));             
        ?>
    </td>
    <td>
        <span class="temperature">
            <?php echo $model->temperature; ?>
        </span>
    </td>
    <td>
        <span class="respiration-rate">
            <?php echo $model->respiration_rate; ?>
        </span>
    </td>
    <td>
        <span class="nadi">
            <?php echo $model->nadi; ?>
        </span>
    </td>
    <td>
        <span class="sistolik">
            <?php echo $model->tekanandarah_sistolik; ?>
        </span>
    </td>
    <td>
        <span class="Diastolik">
            <?php echo $model->tekanandarah_diastolik; ?>
        </span>
    </td>
    <td style="text-align: center;">
        <?php 
            echo CHtml::link("<span style='font-size:15px;'><i class='".MyIcon::getIcons('ubah')."'></i></span>","javascript:;",array('onclick'=>'loadFormMonitor(this);'));
        ?>
    </td>
    <td style="text-align: center;">
        <?php 
            echo CHtml::link("<span style='font-size:15px;'><i class='".MyIcon::getIcons('hapus')."'></i></span>","javascript:;",array('onclick'=>'hapusBaris(this);'));
        ?>
    </td>
</tr>
