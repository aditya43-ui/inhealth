<tr id-data="<?php echo $modKirimKantongDetail->nomorbarcode_utama; ?>">   
    <?php if ($a == 1){ ?>
        <td><?= CHtml::activeCheckBox($modKirimKantongDetail, '[ii]pilih', ['class' => 'pilih']) ?></td>
        <td rowspan="<?php echo $modKirimKantongDetail->count_sampel; ?>">
            <?php echo CHtml::textField('no_urut','',array('class'=>'span1','readonly'=>true)); ?>
        </td>
        <td rowspan="<?php echo $modKirimKantongDetail->count_sampel; ?>">
            <?php echo $modKirimKantongDetail->nomorbarcode_utama; ?>
        </td>
        <td rowspan="<?php echo $modKirimKantongDetail->count_sampel; ?>">
            <?php echo $modKirimKantongDetail->nama_jenis; ?>
        </td>
        <td rowspan="<?php echo $modKirimKantongDetail->count_sampel; ?>">
            <?php echo $modKirimKantongDetail->no_kantongpabrik; ?>
        </td>
    <?php } ?>            
    <td>
        <?php echo $modKantong['gol_darah']; ?>          
    </td>     
    <td>
        <?php echo $modKantong['rhesus']; ?> 
    </td> 
    <td>
        <?= CHtml::activeCheckBox($modKirimKantongDetail, '[ii]ada_samplekonfirmasi', ['class' => 'ada_samplekonfirmasi']) ?>
    </td>
    <td>
        <?= CHtml::activeCheckBox($modKirimKantongDetail, '[ii]ada_sampleimltd', ['class' => 'ada_sampleimltd']) ?>
    </td>
    <td> 
        <?php 
            echo  CHtml::activeCheckBox($modKirimKantongDetail, '[ii]ada_kantongdarah', ['class' => 'ada_kantongdarah']);
            echo CHtml::activeHiddenField($modKirimKantongDetail, '[ii]jeniskantongdarah_id', array('readonly'=>true,'class'=>'kantongdarah')); 
            echo CHtml::activeHiddenField($modKirimKantongDetail, '[ii]nomorbarcode_utama', array('class'=>'nomorbarcode_utama')); 
            echo CHtml::activeHiddenField($modKirimKantongDetail, '[ii]no_penggunaan_coolbox', array('class'=>'no_penggunaan_coolbox')); 
            echo CHtml::activeHiddenField($modKirimKantongDetail, '[ii]komponendarah_id', array('class'=>'komponendarah_id')); 
            echo CHtml::activeHiddenField($modKirimKantongDetail, '[ii]kantongdarah_id', array('class'=>'kantongdarah_id')); 
        ?>         
    </td>    
     
    <?php if ($a == 1){ ?>
    <td rowspan="<?php echo $modKirimKantongDetail->count_sampel; ?>"><?php echo Chtml::link('<span style="font-size:15px;"><icon class="glyphicon glyphicon-remove"></icon></span>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel','id-data'=>$modKirimKantongDetail->nomorbarcode_utama)); ?></td>
    <?php } ?>
</tr>        