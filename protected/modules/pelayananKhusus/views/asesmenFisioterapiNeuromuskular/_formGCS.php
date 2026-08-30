<div class="panel panel-success">
  <div class="panel-heading">
    <div class="panel-title">Glasgow Coma Scale <?php echo CHtml::link('<i class="icon-chevron-right" style="cursor:pointer;"></i>', '', array('onclick'=>"$('#dialogGCS').dialog('open')", 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?></div>
  </div>
  <div class="panel-body">
    <div id="divGlowComoScale" style="display: block">
      <div class="control-group ">
      <?php echo $form->labelEx($model,'gcs_eye', array('class'=>'control-label')) ?>
        <div class="controls">
          <?php $crit = new CDbCriteria();
          $crit->compare('LOWER(metodegcs_singkatan)',"e");
          $crit->addCondition('metodegcs_nilai is not null');
          $crit->order = 'metodegcs_nilai ASC';
          echo $form->dropDownList($model,'gcs_eye',
          CHtml::listData(RMMetodeGCSM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM'),array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'hitungCGS()')); ?>
        </div>
      </div>
      <div class="control-group ">
        <?php echo $form->labelEx($model,'gcs_verbal', array('class'=>'control-label')) ?>
        <div class="controls">
          <?php
          $crit3 = new CDbCriteria();
          $crit3->compare('LOWER(metodegcs_singkatan)',"v");
          $crit3->addCondition('metodegcs_nilai is not null');
          $crit3->order = 'metodegcs_nilai ASC';
          echo $form->dropDownList($model,'gcs_verbal',
          CHtml::listData(RMMetodeGCSM::model()->findAll($crit3), 'metodegcs_nilai', 'textMetodeGCSM'),array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'hitungCGS()')); ?>
        </div>
      </div>
      <div class="control-group ">
        <?php echo $form->labelEx($model,'gcs_motorik', array('class'=>'control-label')) ?>
        <div class="controls">
          <?php
          $crit2 = new CDbCriteria();
          $crit2->compare('LOWER(metodegcs_singkatan)',"m");
          $crit2->addCondition('metodegcs_nilai is not null');
          $crit2->order = 'metodegcs_nilai ASC';
          echo $form->dropDownList($model,'gcs_motorik',
          CHtml::listData(RMMetodeGCSM::model()->findAll($crit2), 'metodegcs_nilai', 'textMetodeGCSM'),array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'hitungCGS()')); ?>
        </div>
      </div>
      <div class="control-group ">
        <?php echo $form->labelEx($model,'namaGCS', array('class'=>'control-label')) ?>
        <div class="controls">
          <?php echo $form->hiddenField($model,'gcs_id',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
          <?php // echo CHtml::textField('namaGCS',(isset($modPemeriksaanFisik->gcs->gcs_nama) ? $modPemeriksaanFisik->gcs->gcs_nama : "-"),array('disabled'=>true,'class'=>'span1')); ?>
          <?php echo $form->textField($model,'namaGCS',array('class'=>'span1 integer numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)).' ';?>
        </div>
      </div>
      <?php  $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'dialogGCS',
        'options'=>array(
          'title'=>'',
          'autoOpen'=>false,
          'width'=>600,
          'height'=>650,
          'modal'=>false,
          //'hide'=>'explode',
          'resizelable'=>false,
        ),
      ));
      ?>
      <table>
        <?php
        $modMetodeGSCM = RMMetodeGCSM::model()->findAll('metodegcs_aktif=TRUE ORDER BY metodegcs_id');
        foreach ($modMetodeGSCM AS $i=>$item):
        if($item->metodegcs_nilai==''){
          echo "<tr bgcolor='#E5ECF9'>
              <td>".$item->metodegcs_nama."</td>
              <td>&nbsp;</td>
            </tr>";
        }else{
          echo "<tr>
              <td>".$item->metodegcs_nama."</td>
              <td><div id=\"divTombol\">".CHtml::button($item->metodegcs_nilai,array('class'=>'btn btn-prymari',
                'onclick'=>'SetNilai(this)',
                'id'=>$item->metodegcs_singkatan,
                ))."</div>
              </td>
            </tr>";
        }
        endforeach;?>
      </table>
      <?php $this->endWidget();?>
    </div>
  </div>
</div>
