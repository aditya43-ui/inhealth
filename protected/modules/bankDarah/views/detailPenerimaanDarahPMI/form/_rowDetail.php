<tr>
    <?php
        $no_urut =$key+1 ;
    ?>
    <td><?=($no_urut)?></td>
    <td style="text-align: center">
        <?php 
        $komponendarah_id = '';
        if(!empty($value->jeniskomponendarah_id)){
            $mod = JeniskomponendarahM::model()->findByPk($value->jeniskomponendarah_id);
            if($mod->jeniskantongdarah_singkatan == Params::KOMPONEN_DARAH_WB ){
                $komponendarah_id = Params::ID_KOMPONEN_DARAH_WB;
            }else if($mod->jeniskantongdarah_singkatan == Params::KOMPONEN_DARAH_PRC ){
                $komponendarah_id = Params::ID_KOMPONEN_DARAH_PRC;
            }else if($mod->jeniskantongdarah_singkatan == Params::KOMPONEN_DARAH_PCR ){
                $komponendarah_id = Params::ID_KOMPONEN_DARAH_PCR;
            }else if($mod->jeniskantongdarah_singkatan == Params::KOMPONEN_DARAH_FFP ){
                $komponendarah_id = Params::ID_KOMPONEN_DARAH_FFP;
            }else if($mod->jeniskantongdarah_singkatan == Params::KOMPONEN_DARAH_TC ){
                $komponendarah_id = Params::ID_KOMPONEN_DARAH_TC;
            }
            echo $mod->jeniskomponenedarah_nama;
        }else{
            echo "-";
        }
        ?>
    </td>
    <td style="text-align: center"><?=$value->golongandarah?></td>
    <td style="text-align: center"><?=$value->rhesus?></td>
    <td style="text-align: center">
        <?php echo CHtml::activeHiddenField($model, '['.$key.']no_urut' ,array('value'=>$no_urut, 'readonly'=>true, 'class'=>'no_urut'))?>
        <?php echo CHtml::activeHiddenField($model, '['.$key.']komponendarah_id' ,array('value'=>$komponendarah_id, 'readonly'=>true, 'class'=>'komponendarah_id'))?>
        <?php echo CHtml::activeHiddenField($model, '['.$key.']jeniskomponendarah_id' ,array('value'=>$value->jeniskomponendarah_id, 'readonly'=>true, 'class'=>'jeniskomponendarah_id'))?>
        <?php echo CHtml::activeHiddenField($model, '['.$key.']penerimaandarahpmidet_id' ,array('value'=>$value->penerimaandarahpmidet_id, 'readonly'=>true))?>
        <?php echo CHtml::activeHiddenField($model, '['.$key.']rhesus' ,array('value'=>$value->rhesus, 'readonly'=>true))?>
        <?php echo CHtml::activeHiddenField($model, '['.$key.']gol_darah' ,array('value'=>$value->golongandarah, 'readonly'=>true))?>
        <?php echo CHtml::activeTextField($model, '['.$key.']no_kantongdarah', array('class'=>'span3 required no_kantongdarah', 'style'=>'width:160px;', 'placeholder'=>'No. Kantong Darah', 'onblur' => 'cekNoKantongDarah(this);'))?>
    </td>
    <td style="text-align: center">
        <?php
        $this->widget('MyDateTimePicker',array(
            'model'=>$model,
            'attribute'=>'['.$key.']tgl_aftap',
            'mode'=>'date',
            'options'=> array(
                'dateFormat'=>Params::DATE_FORMAT,
                'showOn' => false,
            ),
            'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'tgl_aftap dtPicker2', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'readonly'=>true, 'style'=>'width:120px;'
            ),
        ));
        ?>
    </td>
    <td style="text-align: center">
        <?php
        $this->widget('MyDateTimePicker',array(
            'model'=>$model,
            'attribute'=>'['.$key.']tgl_kadaluarsa',
            'mode'=>'date',
            'options'=> array(
                'dateFormat'=>Params::DATE_FORMAT,
                'showOn' => false,
            ),
            'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'tgl_kadaluarsa dtPicker2 required', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'readonly'=>true, 'style'=>'width:120px;'
            ),
        ));
        ?>
    </td>
</tr>