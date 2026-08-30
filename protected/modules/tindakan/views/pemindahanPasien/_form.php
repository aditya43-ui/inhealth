<div class="form-allpemindahanpasien">
  <div class="panel panel-success panel-shadow">
      <div class="panel-heading">
          <div class="panel-title">Situation</div>
      </div>
      <div class="panel-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="control-group ">
                  <?php echo $form->labelEx($model,'ruanganasal_id', array('class'=>'control-label')); ?>
                  <div class="controls">
                     <?php echo $form->hiddenField($model, 'ruanganasal_id'); ?>
                     <?php echo $form->textField($model, 'ruanganasal_nama',array('readonly'=>true,'class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo $form->labelEx($model,'jenispemindahan', array('class'=>'control-label')); ?>
                  <div class="controls">
                    <?php echo $form->dropDownList($model, 'jenispemindahan', LookupM::getItems('jenispemindahan'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);", 'class'=>'span3')); ?>
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo $form->labelEx($model,'instalasitujuan_id', array('class'=>'control-label')); ?>
                  <div class="controls">
                    <?php
                    echo $form->dropDownList($model, 'instalasitujuan_id', CHtml::listData(RuangantransferpasienV::model()->findAll(), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
                        'ajax' => array('type' => 'POST',
                            'url' => $this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($model))),
                            'update' => '#' . CHtml::activeId($model, 'ruangantujuan_id') . ''),));
                    ?>
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo $form->labelEx($model,'ruangantujuan_id', array('class'=>'control-label')); ?>
                  <div class="controls">
                    <?php echo $form->dropDownList($model, 'ruangantujuan_id', CHtml::listData(RuangantransferpasienV::model()->findAllByAttributes(array('instalasi_id'=>$model->instalasitujuan_id)), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo $form->labelEx($model,'tanggal_pemindahan', array('class'=>'control-label')); ?>
                  <div class="controls">
                      <?php
                          $this->widget('MyDateTimePicker',array(
                          'model'=>$model,
                          'attribute'=>'tanggal_pemindahan',
                          'mode'=>'date',
                          'options'=> array(
                                  'dateFormat'=>Params::DATE_FORMAT,
                                  'maxDate' => 'd',
                          ),
                          'htmlOptions'=>array('readonly'=>true,'class'=>'span3','style'=>'width:150px;'),
                      )); ?>
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo $form->labelEx($model, 'jam_pemindahan', array('class' => 'control-label')); ?>
                  <div class="controls">
                      <?php
                          $this->widget('MyDateTimePicker', array(
                              'model' => $model,
                              'attribute' => 'jam_pemindahan',
                              'mode' => 'time',
                              'options' => array(
                              ),
                              'htmlOptions' => array('class'=>'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                          ));
                      ?>
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo $form->labelEx($model,'dokterperegawat_id', array('class'=>'control-label')); ?>
                  <div class="controls">
                    <?php echo $form->dropDownList($model, 'dokterperegawat_id', CHtml::listData(DokterV::model()->findAll('ruangan_id = '.Yii::app()->user->getState("ruangan_id")),'pegawai_id','namaLengkap'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                  </div>
              </div>
            </div>
            <div class="col-sm-6">
              <?php echo $form->textAreaRow($model, 'diagnosa', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true, 'style'=>'height: 100px')); ?>
              <div class="control-group ">
                  <?php echo $form->labelEx($model,'ispemberitahudiagnosa', array('class'=>'control-label')); ?>
                  <div class="controls">
                    <div class="form-inline">
                        <div class="radio inline">
                            <?php echo CHtml::activeRadioButtonList($model,'ispemberitahudiagnosa',array(1=>'Ya',0=>'Tidak') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;')); ?>
                        </div>
                    </div>
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo $form->labelEx($model,'prosedurinvasif', array('class'=>'control-label')); ?>
                  <div class="controls">
                     <?php echo $form->textField($model, 'prosedurinvasif',array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo $form->labelEx($model,'tanggal_prosedur', array('class'=>'control-label')); ?>
                  <div class="controls">
                      <?php
                          $this->widget('MyDateTimePicker',array(
                          'model'=>$model,
                          'attribute'=>'tanggal_prosedur',
                          'mode'=>'date',
                          'options'=> array(
                                  'dateFormat'=>Params::DATE_FORMAT,
                                  'maxDate' => 'd',
                          ),
                          'htmlOptions'=>array('readonly'=>true,'class'=>'span3','style'=>'width:150px;'),
                      )); ?>
                  </div>
              </div>
              <?php echo $form->textAreaRow($model, 'masalahkeperawatan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
          </div>
      </div>
  </div>
  <div class="panel panel-success panel-shadow">
      <div class="panel-heading">
          <div class="panel-title">Background</div>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($model,'isriwayatalergi', array('class'=>'control-label')); ?>
                <div class="controls">
                  <div class="form-inline">
                      <div class="radio inline">
                          <?php echo CHtml::activeRadioButtonList($model,'isriwayatalergi',array(1=>'Ya',0=>'Tidak') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;')); ?>
                      </div>
                  </div>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('','', array('class'=>'control-label')); ?>
                <div class="controls">
                  <?php echo $form->textArea($model, 'riwayat_ket', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'riwayatreaksi', array('class'=>'control-label')); ?>
                <div class="controls">
                  <?php echo $form->textArea($model, 'riwayatreaksi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'intervensimedik', array('class'=>'control-label')); ?>
                <div class="controls">
                  <?php echo $form->textArea($model, 'intervensimedik', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>

          </div>
          <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($model,'investigasiabnormal', array('class'=>'control-label')); ?>
                <div class="controls">
                  <?php echo $form->textArea($model, 'investigasiabnormal', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Kewaspadaan','', array('class'=>'control-label')); ?>
                <div class="controls">
                  <?php echo $form->dropDownList($model, 'kewaspadaan', LookupM::getItems('kewaspadaan'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                </div>
            </div>

          </div>
        </div>
      </div>
  </div>

  <div class="panel panel-success panel-shadow">
      <div class="panel-heading">
          <div class="panel-title">Assesment</div>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($model,'observasiterakhir', array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php
                        $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'observasiterakhir',
                        'mode'=>'date',
                        'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate' => 'd',
                        ),
                        'htmlOptions'=>array('readonly'=>true,'class'=>'span3','style'=>'width:150px;'),
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('GCS Eye','', array('class'=>'control-label')); ?>
                <div class="controls">
                  <?php $crit = new CDbCriteria();
  								$crit->compare('LOWER(metodegcs_singkatan)',"e");
  								$crit->addCondition('metodegcs_nilai is not null');
  								$crit->order = 'metodegcs_nilai ASC'; ?>
                  <?php echo $form->dropDownList($model, 'gcs_eye', CHtml::listData(RJMetodeGCSM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3','onchange'=>'hitungGcs()')); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('GCS Verbal','', array('class'=>'control-label')); ?>
                <div class="controls">
                  <?php
                  $crit3 = new CDbCriteria();
                  $crit3->compare('LOWER(metodegcs_singkatan)',"v");
                  $crit3->addCondition('metodegcs_nilai is not null');
                  $crit3->order = 'metodegcs_nilai ASC';
                   ?>
                  <?php echo $form->dropDownList($model, 'gcs_verbal', CHtml::listData(RJMetodeGCSM::model()->findAll($crit3), 'metodegcs_nilai', 'textMetodeGCSM'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3','onchange'=>'hitungGcs()')); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('GCS Motorik','', array('class'=>'control-label')); ?>
                <div class="controls">
                  <?php $crit2 = new CDbCriteria();
  								$crit2->compare('LOWER(metodegcs_singkatan)',"m");
  								$crit2->addCondition('metodegcs_nilai is not null');
  								$crit2->order = 'metodegcs_nilai ASC'; ?>
                  <?php echo $form->dropDownList($model, 'gcs_motorik', CHtml::listData(RJMetodeGCSM::model()->findAll($crit2), 'metodegcs_nilai', 'textMetodeGCSM'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3','onchange'=>'hitungGcs()')); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Nilai GCS','', array('class'=>'control-label')); ?>
                <div class="controls">
                   <?php echo $form->textField($model, 'nilai_gcs',array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label" style="width: 80px">Reflek Pupil</label>
                <div class="controls">
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'reflekpupilkanan', array('class'=>'control-label')); ?>
                <div class="controls">
                   <?php echo $form->textField($model, 'reflekpupilkanan',array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'reflekpupilkiri', array('class'=>'control-label')); ?>
                <div class="controls">
                   <?php echo $form->textField($model, 'reflekpupilkiri',array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Takanan Darah','', array('class'=>'control-label')); ?>
                <div class="controls">
                 <?php  echo $form->textField($model,'td_systolic',array('class'=>'span1 numbersOnly systolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'getTekananDarah()', 'style'=>'text-align: right;'));?>Mm
                 <?php echo $form->textField($model,'td_diastolic',array('onblur'=>'','readonly'=>false,'class'=>'span1 numbersOnly diastolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'getTekananDarah();', 'style'=>'text-align: right;')); ?>Hg
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('','',array('class'=>'control-label'));?>
                <div class="controls">
                        <?php
                              echo CHtml::textField('tekanandarah','',array('readonly'=>true, 'class'=>'span2', 'style'=>'width:60px;','onkeypress'=>"return $(this).focusNextInputField(event)"));
                        ?> Mm/Hg
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'nadi',array('label'=>'Nadi','class'=>'control-label'));?>
                <div class="controls">
                        <?php echo $form->textField($model,'nadi',array('class'=>'span2  integer numbersOnly', 'maxlength'=>3, 'onkeypress'=>"return $(this).focusNextInputField(event)"));?>
                 /Menit
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'pernapasan',array('class'=>'control-label'));?>
                <div class="controls">
                        <?php echo $form->textField($model,'pernapasan',array('class'=>'span2 integer numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>2));?>
                        /Menit
                </div>
            </div>
            <div class="control-group ">
                <label class='control-label'>SPO2</label>
                <div class="controls">
                    <?php echo $form->textField($model,'tandavital_spo2',array('class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;', 'maxlength'=>2)); ?> <label>%</label>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'suhutubuh',array('class'=>'control-label'));?>
                <div class="controls">
                    <?php echo $form->textField($model,'suhutubuh',array('class'=>'span2 float', 'maxlength'=>5, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align:right;'));?>
                 &#176; C
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('BAB','', array('class'=>'control-label')); ?>
                <div class="controls">
                  <?php echo $form->dropDownList($model, 'pemindahan_bab', LookupM::getItems('pemindahan_bab'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'isbak', array('class'=>'control-label')); ?>
                <div class="controls">
                  <div class="form-inline">
                      <div class="radio inline">
                          <?php echo CHtml::activeRadioButtonList($model,'isbak',array(0=>'Normal',1=>'Kateter') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','class'=>'isbak', 'onchange'=>'changeBak()')); ?>
                      </div>
                  </div>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Jenis Kateter','', array('class'=>'control-label')); ?>
                <div class="controls">
                   <?php echo $form->textField($model, 'jeniskateter',array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('No Kateter','', array('class'=>'control-label')); ?>
                <div class="controls">
                   <?php echo $form->textField($model, 'no_kateter',array('class'=>'span3 integer','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Tanggal Pemasangan','', array('class'=>'control-label')); ?>
                <div class="controls">
                  <?php
                      $this->widget('MyDateTimePicker',array(
                      'model'=>$model,
                      'attribute'=>'tglpemasangan_kateter',
                      'mode'=>'date',
                      'options'=> array(
                              'dateFormat'=>Params::DATE_FORMAT,
                              'maxDate' => 'd',
                      ),
                      'htmlOptions'=>array('readonly'=>true,'class'=>'span3','style'=>'width:150px;'),
                  )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Mobilisasi','', array('class'=>'control-label')); ?>
                <div class="controls">
                  <?php echo $form->dropDownList($model, 'mobilisasi', LookupM::getItems('pemindahan_mobilisasi'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Transfer / Mobilisasi','', array('class'=>'control-label')); ?>
                <div class="controls">
                  <?php echo $form->dropDownList($model, 'transfermobilisasi', LookupM::getItems('transfer_mobilisasi'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Gangguan Indra','', array('class'=>'control-label')); ?>
                <div class="controls">
                  <?php echo $form->dropDownList($model, 'gangguanindra', LookupM::getItems('gangguanindera'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Alat Bantu yang dipakai','', array('class'=>'control-label')); ?>
                <div class="controls">
                  <?php echo $form->dropDownList($model, 'alatabantudiapakai', LookupM::getItems('alatbantudipakai'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Tindakan Kebutuhan Khusus','', array('class'=>'control-label')); ?>
                <div class="controls">
                  <?php echo $form->dropDownList($model, 'tindakankebutuhan_khusus', LookupM::getItems('tindakankebutuhankhusus'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($model,'islukaperawatan', array('class'=>'control-label')); ?>
                <div class="controls">
                  <div class="form-inline">
                      <div class="radio inline">
                          <?php echo CHtml::activeRadioButtonList($model,'islukaperawatan',array(1=>'Ya',0=>'Tidak') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','class'=>'islukaperawatan', 'onchange'=>'changeLukaPerawatan()')); ?>
                      </div>
                  </div>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Kondisi','', array('class'=>'control-label')); ?>
                <div class="controls">
                   <?php echo $form->textField($model, 'kondisiperawatan',array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Lokasi','', array('class'=>'control-label')); ?>
                <div class="controls">
                   <?php echo $form->textField($model, 'lokasiperawatan',array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Ukuran','', array('class'=>'control-label')); ?>
                <div class="controls">
                   <?php echo $form->textField($model, 'ukuranperawatan',array('class'=>'span3 integer numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <div class="controls">
                    <?php echo CHtml::activeCheckBox($model,'isinfus',array()); ?> <label>Invus / CVC</label>
                </div>
            </div>
            <div class="control-group ">
                <div class="controls" style="padding-left: 10px">
                   <?php echo $form->textField($model, 'infuscvc',array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <div class="controls">
                    <?php echo CHtml::activeCheckBox($model,'isvasscore',array()); ?> <label>VAS Score</label>
                </div>
            </div>
            <div class="control-group ">
                <div class="controls" style="padding-left: 10px">
                   <?php echo $form->textField($model, 'vasscore',array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Tanggal Pemasangan','', array('class'=>'control-label')); ?>
                <div class="controls">
                  <?php
                      $this->widget('MyDateTimePicker',array(
                      'model'=>$model,
                      'attribute'=>'tglpemasangan_perawatan',
                      'mode'=>'date',
                      'options'=> array(
                              'dateFormat'=>Params::DATE_FORMAT,
                              'maxDate' => 'd',
                      ),
                      'htmlOptions'=>array('readonly'=>true,'class'=>'span3','style'=>'width:150px;'),
                  )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Peralatan khusus yang diperlukan','', array('class'=>'control-label','style'=>'width: 200px')); ?>
            </div>
            <?php
              if(!empty($model->peralatanyangdigunakan)){
                $arrPeralatan = explode('|',$model->peralatanyangdigunakan);

                if(count($arrPeralatan) > 0){
                  $model->alat1_ket = (isset($arrPeralatan[0])?$arrPeralatan[0]:"");
                  $model->isalat1 = (!empty($model->alat1_ket)?true:false);
                  $model->alat2_ket = (isset($arrPeralatan[1])?$arrPeralatan[1]:"");
                  $model->isalat2 = (!empty($model->alat2_ket)?true:false);
                  $model->alat3_ket = (isset($arrPeralatan[2])?$arrPeralatan[2]:"");
                  $model->isalat3 = (!empty($model->alat3_ket)?true:false);
                }
              }
             ?>
            <div class="control-group ">
                <div class="controls">
                    <?php echo CHtml::activeCheckBox($model,'isalat1',array()); ?> <label>Alat 1</label>
                    <?php echo $form->textField($model, 'alat1_ket',array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <div class="controls">
                    <?php echo CHtml::activeCheckBox($model,'isalat2',array()); ?> <label>Alat 2</label>
                    <?php echo $form->textField($model, 'alat2_ket',array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <div class="controls">
                    <?php echo CHtml::activeCheckBox($model,'isalat3',array()); ?> <label>Alat 3</label>
                    <?php echo $form->textField($model, 'alat3_ket',array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Tindakan yang sudah dilakukan','', array('class'=>'control-label','style'=>'width: 350px')); ?>
            </div>
            <div class="control-group ">
                <div class="controls" style="width: 80%">
                  <?php echo $form->textArea($model, 'investigasiabnormal', array('style' => 'width: 100%; height: 200px', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Diagnosa Keperawatan','', array('class'=>'control-label','style'=>'width: 150px')); ?>
            </div>
            <div class="control-group ">
                <div class="controls">
                    <?php echo CHtml::textField('diagnosakkep', '',array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo CHtml::dropDownList('statusdiagnosa', '', array('Sudah'=>'Sudah','Belum'=>'Belum'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span2')); ?>
                    <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                            array('onclick'=>'tambahDiagnosaKep();return false;',
                            'class'=>'btn btn-primary btndiagnosaKep',
                            'onkeyup'=>"tambahDiagnosaKep();",
                            'rel'=>"tooltip",
                            'title'=>"Klik untuk menambahkan Diagnosa Keperawatan")); ?>
                </div>
            </div>
            <br/>
            <table width="100%" class="table table-bordered" id="tbldiagnosakep">
              <thead>
                <tr>
                  <th width="50px">No</th>
                  <th>Diagnosa Keperawatan</th>
                  <th width="100px">Sudah Teratasi</th>
                  <th width="80px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  if(!empty($model->pemindahanpasien_id)){
                    $diagnosaKep = DiagnosakeperawatanT::model()->findAllByAttributes(array('pemindahanpasien_id'=>$model->pemindahanpasien_id));
                      if(count($diagnosaKep) >0){
                          $no = 0;
                          foreach($diagnosaKep as $i=> $diagnosaKep){
                            $no++;

                            ?>
                            <tr>
                              <td>
                                <?php echo CHtml::hiddenField('DiagnosakeperawatanT['.$i.'][nama_diagnosa]',$diagnosaKep->nama_diagnosa); ?>
                                <?php echo CHtml::hiddenField('DiagnosakeperawatanT['.$i.'][statusdiagnosa]',$diagnosaKep->statusdiagnosa); ?>
                                <?php echo $no; ?>
                              </td>
                              <td><?php echo $diagnosaKep->nama_diagnosa; ?></td>
                              <td><?php echo $diagnosaKep->statusdiagnosa; ?></td>
                              <td><a class="cl_diagnosakep" onclick="deleteDiagnosaKep(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan Diagnosa Keperawatan"><i class="icon-remove"></i></a></td>
                            </tr>
                            <?php
                          }
                      }
                  }
                 ?>
              </tbody>
            </table>

          </div>
        </div>
      </div>
  </div>

  <div class="panel panel-success panel-shadow">
      <div class="panel-heading">
          <div class="panel-title">Kondisi Pasien</div>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-sm-6">
            <div class="control-group ">
                <?php echo CHtml::label('Waktu Keadaan','', array('class'=>'control-label')); //Konsultasi ?> 
                <div class="controls">
                  <?php echo $form->dropDownList($model, 'waktukeadaan', array('Sebelum Transfer'=>'Sebelum Transfer', 'Selama Transfer'=>'Selama Transfer', 'Setelah Transfer'=>'Setelah Transfer'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                  <?php //echo $form->textField($model, 'konsultasi',array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Keadaan Umum','', array('class'=>'control-label')); //Konsultasi ?> 
                <div class="controls">
                  <?php echo $form->textField($model, 'keadaanumum',array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                  <?php //echo $form->textField($model, 'konsultasi',array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Kesadaran','', array('class'=>'control-label')); //Konsultasi ?> 
                <div class="controls">
                  <?php echo $form->textField($model, 'kesadaran',array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                  <?php //echo $form->textField($model, 'konsultasi',array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <!-- <div class="control-group "> -->
                <?php //echo CHtml::label('Terapi Oral / Enteral','', array('class'=>'control-label', 'style'=>'width: 120px')); ?>
            <!-- </div> -->
            <!-- <div class="control-group "> -->
                <!-- <div class="controls" style="width: 80%"> -->
                  <?php //echo $form->textArea($model, 'terapioral', array('style' => 'width: 100%; height: 100px', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <!-- </div> -->
            <!-- </div> -->
            <!-- <div class="control-group "> -->
                <?php //echo CHtml::label('Fisioterapi / Mobilisasi','', array('class'=>'control-label', 'style'=>'width: 135px')); ?>
            <!-- </div> -->
            <!-- <div class="control-group "> -->
                <!-- <div class="controls" style="width: 80%"> -->
                  <!-- <?php //echo $form->textArea($model, 'fisioterapi_mobilisasi', array('style' => 'width: 100%; height: 100px', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> -->
                <!-- </div> -->
            <!-- </div> -->

          </div>
          <div class="col-sm-6">
            <div class="control-group ">
                <?php echo CHtml::label('Catatan Penting','', array('class'=>'control-label')); //Rencana Pemeriksaan lab / Radiologi ?>
                <div class="controls">
                  <?php echo $form->textArea($model, 'catatan_penting', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                  <?php //echo $form->textField($model, 'rencanapemeriksaan',array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <!-- <div class="control-group "> -->
                <?php //echo CHtml::label('Terapi Parenteral','', array('class'=>'control-label', 'style'=>'width: 100px')); ?>
            <!-- </div> -->
            <!-- <div class="control-group "> -->
                <!-- <div class="controls" style="width: 80%"> -->
                  <?php //echo $form->textArea($model, 'terapiparental', array('style' => 'width: 100%; height: 100px', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <!-- </div> -->
            <!-- </div> -->
            <!-- <div class="control-group "> -->
                <?php //echo CHtml::label('Rencana tindakan lebih lanjut','', array('class'=>'control-label', 'style'=>'width: 170px')); ?>
            <!-- </div> -->
            <!-- <div class="control-group "> -->
                <!-- <div class="controls" style="width: 80%"> -->
                  <?php //echo $form->textArea($model, 'rencanatindakan', array('style' => 'width: 100%; height: 100px', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <!-- </div> -->
            <!-- </div> -->
          </div>
          <div class="clear"></div>
          <div class="col-sm-12">
            <div class="panel panel-default panel-shadow">
                <div class="panel-heading">
                    <div class="panel-title">Kelengkapan Dokumen</div>
                </div>
                <div class="panel-body">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th width="80px">Check</th>
                        <th>Data Kelengkapan</th>
                        <th>Keterangan Kelengkapan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $arrMateri = array();
                        if(!empty($model->kelengkapan_dokumen)){
                          $oriMateri = json_decode($model->kelengkapan_dokumen);

                          if(count($oriMateri) >0){
                            foreach($oriMateri as $dataMateri){
                              if($dataMateri->nama == 'Obat - Obatan'){
                                $arrMateri[0] = array('iskelengkapan'=>true,'keterangan'=>$dataMateri->keterangan);
                              }
                              else if($dataMateri->nama == 'Hasil Laboratorium'){
                                $arrMateri[1] = array('iskelengkapan'=>true,'keterangan'=>$dataMateri->keterangan);
                              }
                              else if($dataMateri->nama == 'X - Ray Regio'){
                                $arrMateri[2] = array('iskelengkapan'=>true,'keterangan'=>$dataMateri->keterangan);
                              }
                              else if($dataMateri->nama == 'CT Scan Regio'){
                                $arrMateri[3] = array('iskelengkapan'=>true,'keterangan'=>$dataMateri->keterangan);
                              }
                              else if($dataMateri->nama == 'USG Regio'){
                                $arrMateri[4] = array('iskelengkapan'=>true,'keterangan'=>$dataMateri->keterangan);
                              }
                              else if($dataMateri->nama == 'Penunjang Radiologi lain (MRI / MRA / Lainnya)'){
                                $arrMateri[5] = array('iskelengkapan'=>true,'keterangan'=>$dataMateri->keterangan);
                              }
                              else if($dataMateri->nama == 'Echocardiografi'){
                                $arrMateri[6] = array('iskelengkapan'=>true,'keterangan'=>$dataMateri->keterangan);
                              }
                              else if($dataMateri->nama == 'Gigi Palsu'){
                                $arrMateri[7] = array('iskelengkapan'=>true,'keterangan'=>$dataMateri->keterangan);
                              }
                              else if($dataMateri->nama == 'Kaca Mata'){
                                $arrMateri[8] = array('iskelengkapan'=>true,'keterangan'=>$dataMateri->keterangan);
                              }
                              else if($dataMateri->nama == 'Alat Bantu Dengan'){
                                $arrMateri[9] = array('iskelengkapan'=>true,'keterangan'=>$dataMateri->keterangan);
                              }
                            }
                          }
                        }
                       ?>
                      <tr>
                        <td>
                          <?php echo CHtml::hiddenField('Kelengkapandok[0][datakelengkapan_nama]','Obat - Obatan', array('class'=>'datakelengkapan_nama')); ?>
                          <?php echo CHtml::checkBox('Kelengkapandok[0][iskelengkapan]',(isset($arrMateri[0]['iskelengkapan']) ?$arrMateri[0]['iskelengkapan'] : false ), array('class'=>'iskelengkapan','onchange'=>'changeKelengkapan(this);','index_urut'=>0)); ?>
                        </td>
                        <td>
                          Obat - Obatan
                        </td>
                        <td>
                          <div class="keterangan">
                            <?php echo CHtml::radioButtonList('Kelengkapandok[0][keterangan]',(isset($arrMateri[0]['keterangan']) ?$arrMateri[0]['keterangan'] : '' ),array('Lengkap'=>'Lengkap','Tidak Lengkap'=>'Tidak Lengkap'), array('class'=>'radio_ket','separator'=>'&nbsp;&nbsp;&nbsp;')); ?>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <?php echo CHtml::hiddenField('Kelengkapandok[1][datakelengkapan_nama]','Hasil Laboratorium', array('class'=>'datakelengkapan_nama')); ?>
                          <?php echo CHtml::checkBox('Kelengkapandok[1][iskelengkapan]',(isset($arrMateri[1]['iskelengkapan']) ?$arrMateri[1]['iskelengkapan'] : false ), array('class'=>'iskelengkapan','onchange'=>'changeKelengkapan(this);','index_urut'=>1)); ?>
                        </td>
                        <td>
                          Hasil Laboratorium
                        </td>
                        <td>
                          <label>Jumlah : </label>&nbsp;&nbsp;
                          <?php echo CHtml::textField('Kelengkapandok[1][keterangan]',(isset($arrMateri[1]['keterangan']) ?$arrMateri[1]['keterangan'] : '' ),array('class'=>'integer numbersOnly span1 keterangan')) ?>
                          &nbsp;&nbsp;<label>Lembar</label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <?php echo CHtml::hiddenField('Kelengkapandok[2][datakelengkapan_nama]','X - Ray Regio', array('class'=>'datakelengkapan_nama')); ?>
                          <?php echo CHtml::checkBox('Kelengkapandok[2][iskelengkapan]',(isset($arrMateri[2]['iskelengkapan']) ?$arrMateri[2]['iskelengkapan'] : false ), array('class'=>'iskelengkapan','onchange'=>'changeKelengkapan(this);','index_urut'=>2)); ?>
                        </td>
                        <td>
                          X - Ray Regio
                        </td>
                        <td>
                          <label>Jumlah : </label>&nbsp;&nbsp;
                          <?php echo CHtml::textField('Kelengkapandok[2][keterangan]',(isset($arrMateri[2]['keterangan']) ?$arrMateri[2]['keterangan'] : '' ),array('class'=>'integer numbersOnly span1 keterangan')) ?>
                          &nbsp;&nbsp;<label>Lembar</label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <?php echo CHtml::hiddenField('Kelengkapandok[3][datakelengkapan_nama]','CT Scan Regio', array('class'=>'datakelengkapan_nama')); ?>
                          <?php echo CHtml::checkBox('Kelengkapandok[3][iskelengkapan]',(isset($arrMateri[3]['iskelengkapan']) ?$arrMateri[3]['iskelengkapan'] : false ), array('class'=>'iskelengkapan','onchange'=>'changeKelengkapan(this);','index_urut'=>3)); ?>
                        </td>
                        <td>
                          CT Scan Regio
                        </td>
                        <td>
                          <label>Jumlah : </label>&nbsp;&nbsp;
                          <?php echo CHtml::textField('Kelengkapandok[3][keterangan]',(isset($arrMateri[3]['keterangan']) ?$arrMateri[3]['keterangan'] : '' ),array('class'=>'integer numbersOnly span1 keterangan')) ?>
                          &nbsp;&nbsp;<label>Lembar</label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <?php echo CHtml::hiddenField('Kelengkapandok[4][datakelengkapan_nama]','USG Regio', array('class'=>'datakelengkapan_nama')); ?>
                          <?php echo CHtml::checkBox('Kelengkapandok[4][iskelengkapan]',(isset($arrMateri[4]['iskelengkapan']) ?$arrMateri[4]['iskelengkapan'] : false ), array('class'=>'iskelengkapan','onchange'=>'changeKelengkapan(this);','index_urut'=>4)); ?>
                        </td>
                        <td>
                          USG Regio
                        </td>
                        <td>
                          <label>Jumlah : </label>&nbsp;&nbsp;
                          <?php echo CHtml::textField('Kelengkapandok[4][keterangan]',(isset($arrMateri[4]['keterangan']) ?$arrMateri[4]['keterangan'] : '' ),array('class'=>'integer numbersOnly span1 keterangan')) ?>
                          &nbsp;&nbsp;<label>Lembar</label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <?php echo CHtml::hiddenField('Kelengkapandok[5][datakelengkapan_nama]','Penunjang Radiologi lain (MRI / MRA / Lainnya)', array('class'=>'datakelengkapan_nama')); ?>
                          <?php echo CHtml::checkBox('Kelengkapandok[5][iskelengkapan]',(isset($arrMateri[5]['iskelengkapan']) ?$arrMateri[5]['iskelengkapan'] : false ), array('class'=>'iskelengkapan','onchange'=>'changeKelengkapan(this);','index_urut'=>5)); ?>
                        </td>
                        <td>
                          Penunjang Radiologi lain (MRI / MRA / Lainnya)
                        </td>
                        <td>
                          <label>Jumlah : </label>&nbsp;&nbsp;
                          <?php echo CHtml::textField('Kelengkapandok[5][keterangan]',(isset($arrMateri[5]['keterangan']) ?$arrMateri[5]['keterangan'] : '' ),array('class'=>'integer numbersOnly span1 keterangan')) ?>
                          &nbsp;&nbsp;<label>Lembar</label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <?php echo CHtml::hiddenField('Kelengkapandok[6][datakelengkapan_nama]','Echocardiografi', array('class'=>'datakelengkapan_nama')); ?>
                          <?php echo CHtml::checkBox('Kelengkapandok[6][iskelengkapan]',(isset($arrMateri[6]['iskelengkapan']) ?$arrMateri[6]['iskelengkapan'] : false ), array('class'=>'iskelengkapan','onchange'=>'changeKelengkapan(this);','index_urut'=>6)); ?>
                        </td>
                        <td>
                          Echocardiografi
                        </td>
                        <td>
                          <label>Jumlah : </label>&nbsp;&nbsp;
                          <?php echo CHtml::textField('Kelengkapandok[6][keterangan]',(isset($arrMateri[6]['keterangan']) ?$arrMateri[6]['keterangan'] : '' ),array('class'=>'integer numbersOnly span1 keterangan')) ?>
                          &nbsp;&nbsp;<label>Lembar</label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <?php echo CHtml::hiddenField('Kelengkapandok[7][datakelengkapan_nama]','Gigi Palsu', array('class'=>'datakelengkapan_nama')); ?>
                          <?php echo CHtml::checkBox('Kelengkapandok[7][iskelengkapan]',(isset($arrMateri[7]['iskelengkapan']) ?$arrMateri[7]['iskelengkapan'] : false ), array('class'=>'iskelengkapan','onchange'=>'changeKelengkapan(this);','index_urut'=>7)); ?>
                        </td>
                        <td>
                          Gigi Palsu
                        </td>
                        <td>
                          <label>Jumlah : </label>&nbsp;&nbsp;
                          <?php echo CHtml::textField('Kelengkapandok[7][keterangan]',(isset($arrMateri[7]['keterangan']) ?$arrMateri[7]['keterangan'] : '' ),array('class'=>'integer numbersOnly span1 keterangan')) ?>
                          &nbsp;&nbsp;<label>Lembar</label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <?php echo CHtml::hiddenField('Kelengkapandok[8][datakelengkapan_nama]','Kaca Mata', array('class'=>'datakelengkapan_nama')); ?>
                          <?php echo CHtml::checkBox('Kelengkapandok[8][iskelengkapan]',(isset($arrMateri[8]['iskelengkapan']) ?$arrMateri[8]['iskelengkapan'] : false ), array('class'=>'iskelengkapan','onchange'=>'changeKelengkapan(this);','index_urut'=>8)); ?>
                        </td>
                        <td>
                          Kaca Mata
                        </td>
                        <td>
                          <label>Jumlah : </label>&nbsp;&nbsp;
                          <?php echo CHtml::textField('Kelengkapandok[8][keterangan]',(isset($arrMateri[8]['keterangan']) ?$arrMateri[8]['keterangan'] : '' ),array('class'=>'integer numbersOnly span1 keterangan')) ?>
                          &nbsp;&nbsp;<label>Lembar</label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <?php echo CHtml::hiddenField('Kelengkapandok[9][datakelengkapan_nama]','Alat Bantu Dengan', array('class'=>'datakelengkapan_nama')); ?>
                          <?php echo CHtml::checkBox('Kelengkapandok[9][iskelengkapan]',(isset($arrMateri[9]['iskelengkapan']) ?$arrMateri[9]['iskelengkapan'] : false ), array('class'=>'iskelengkapan','onchange'=>'changeKelengkapan(this);','index_urut'=>9)); ?>
                        </td>
                        <td>
                          Alat Bantu Dengan
                        </td>
                        <td>
                          <?php echo CHtml::textField('Kelengkapandok[9][keterangan]',(isset($arrMateri[9]['keterangan']) ?$arrMateri[9]['keterangan'] : '' ),array('class'=>'span3 keterangan')) ?>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  <div class="panel panel-success panel-shadow">
      <div class="panel-heading">
          <div class="panel-title"><?php echo $labelheaderDataIsi; ?></div>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-sm-6">
            <div class="control-group ">
                <?php echo CHtml::label('Disetujui <span class="required">*</span>','', array('class'=>'control-label required')); ?>
                <div class="controls">
                  <?php echo $form->dropDownList($model, 'tipedisetujui', array('Pasien'=>'Pasien','Penanggung Jawab'=>'Penanggung Jawab'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3','onchange'=>'changeDisetujui(this);')); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Pasien/ Penanggung Jawab','', array('class'=>'control-label disetujui')); ?>
                <div class="controls">
                  <?php echo $form->textField($model, 'disetujui_oleh',array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="control-group ">
                <?php echo CHtml::label('Mengetahui <span class="required">*</span>','', array('class'=>'control-label required')); ?>
                <div class="controls">
                  <?php echo $form->dropDownList($model, 'pegawai_mengetahui', CHtml::listData(PegawairuanganV::model()->findAll('ruangan_id = '.$model->ruanganasal_id),'pegawai_id','namaLengkap'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Diserahkan oleh <span class="required">*</span>','', array('class'=>'control-label required')); ?>
                <div class="controls">
                  <?php echo $form->dropDownList($model, 'tipediserahkan', array('Perawat'=>'Perawat','Incharge'=>'Incharge'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3','onchange'=>'changeDiserahkan(this);')); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Perawat / Incharge','', array('class'=>'control-label diserahkan')); ?>
                <div class="controls">
                  <?php echo $form->dropDownList($model, 'perawatpengirim_id', CHtml::listData(PegawairuanganV::model()->findAll('ruangan_id = '.$model->ruanganasal_id.' and kelompokpegawai_id = '.Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN),'pegawai_id','namaLengkap'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
<?php if(isset($_GET['pasienditerima']) && ($_GET['pasienditerima'] == 'diterima')){ ?>
<div class="row">
  <div class="col-sm-6">
    <div class="panel panel-success panel-shadow">
        <div class="panel-heading">
            <div class="panel-title">Data Pegawai Penerima</div>
        </div>
        <div class="panel-body">
          <?php echo $form->hiddenField($model, 'ispasienditerima'); ?>

          <div class="row">
            <div class="col-sm-12">
              <div class="control-group ">
                  <?php echo CHtml::label('Tanggal Penerimaan <span class="required">*</span>','', array('class'=>'control-label required')); ?>
                  <div class="controls">
                    <?php
                        $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'tanggal_penerimaan',
                        'mode'=>'datetime',
                        'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate' => 'd',
                        ),
                        'htmlOptions'=>array('readonly'=>true,'class'=>'span3','style'=>'width:150px;'),
                    )); ?>
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo CHtml::label('Diterima oleh <span class="required">*</span>','', array('class'=>'control-label required')); ?>
                  <div class="controls">
                    <?php echo $form->dropDownList($model, 'tipepenerima', array('Perawat'=>'Perawat','Incharge'=>'Incharge'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3','onchange'=>'changeDiterima(this);')); ?>
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo CHtml::label('Perawat / Incharge','', array('class'=>'control-label penerimaan')); ?>
                  <div class="controls">
                    <?php echo $form->dropDownList($model, 'perawatpenerima_id', CHtml::listData(PegawairuanganV::model()->findAll('ruangan_id = '.Yii::app()->user->getState("ruangan_id").' and kelompokpegawai_id in(2,3) '),'pegawai_id','namaLengkap'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                  </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
<?php } ?>
