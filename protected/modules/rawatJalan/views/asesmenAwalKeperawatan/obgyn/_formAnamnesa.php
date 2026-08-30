<div class="row-fluid">
     <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Pemeriksaam Anamnesa</strong></div>
        </div>
         <div class="panel-body">
             <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
             <div class="row-fluid">
                 <div class="col-sm-6">
                     <div class="control-group ">
                            <?php echo CHtml::label('Perawat Pengkaji <span class="required">*</span>', 'paramedis_nama', array('class' => 'control-label required')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($modAsesmenawalkeperawatanT,'paramedis_nama', CHtml::listData($dropPerawat, 'nama_pegawai', 'NamaLengkap'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            </div>
                    </div>
                     <?php echo $form->dropDownListRow($modAsesmenawalkeperawatanT, 'dokterpemeriksa_id', CHtml::listData($dropDokter, 'pegawai_id', 'NamaLengkap'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT, 'jam_masukruangan', array('class' => 'control-label')) ?>
                        <div class="controls">
                                <?php
                                        $this->widget('MyDateTimePicker', array(
                                                'model' => $modAsesmenawalkeperawatanT,
                                                'attribute' => 'jam_masukruangan_obgyn',
                                                'mode' => 'time',
                                                'options' => array(
                                                ),
                                                'htmlOptions' => array('class'=>'span3',
                                                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                                        ));
                                ?>
                        </div>
                    </div>
                     <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT, 'tgl_assesmen_awal', array('class' => 'control-label')) ?>
                        <div class="controls">
                                <?php
                                        $this->widget('MyDateTimePicker', array(
                                                'model' => $modAsesmenawalkeperawatanT,
                                                'attribute' => 'tgl_assesmen_awal_obgyn',
                                                'mode' => 'datetime',
                                                'options' => array(
                                                        'dateFormat' => Params::DATE_FORMAT,
//                                                        'maxDate' => 'd',
                                                ),
                                                'htmlOptions' => array('readonly' => true, 'class'=>'span3',
                                                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                                        ));
                                ?>
                        </div>
                    </div>

                   <div class="control-group ">
                      <?php echo $form->labelEx($modAsesmenawalkeperawatanT, 'keluhanutama', array('class' => 'control-label')) ?>
                      <div class="controls">
                        <?php
                            $this->widget('application.extensions.FCBKcomplete.FCBKcomplete',array(
                                    'model'=>$modAsesmenawalkeperawatanT,
                                    'attribute'=>'keluhanutama_obgyn',
                                    'data'=> explode(',', $modAsesmenawalkeperawatanT->keluhanutama),
                                    'debugMode'=>true,
                                    'options'=>array(
                                            //'bricket'=>false,
                                            'json_url'=>$this->createUrl('MasterKeluhan'),
                                            'addontab'=> true,
                                            'maxitems'=> 10,
                                            'input_min_size'=> 0,
                                            'cache'=> true,
                                            'newel'=> true,
                                            'addoncomma'=>true,
                                            'select_all_text'=> "",
                                            'autoFocus'=>true,
                                    ),
                            ));
                        ?>
                      </div>
                  </div>
                  <div class="control-group ">
                    <?php echo $form->labelEx($modAsesmenawalkeperawatanT, 'keluhantambahan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                          $this->widget('application.extensions.FCBKcomplete.FCBKcomplete',array(
                                  'model'=>$modAsesmenawalkeperawatanT,
                                  'attribute'=>'keluhantambahan_obgyn',
                                  'data'=> explode(',', $modAsesmenawalkeperawatanT->keluhantambahan),
                                  'debugMode'=>true,
                                  'options'=>array(
                                          //'bricket'=>false,
                                          'json_url'=>$this->createUrl('MasterKeluhan'),
                                          'addontab'=> true,
                                          'maxitems'=> 10,
                                          'input_min_size'=> 0,
                                          'cache'=> true,
                                          'newel'=> true,
                                          'addoncomma'=>true,
                                          'select_all_text'=> "",
                                  ),
                          ));
                        ?>
                    </div>
                  </div>
                   <div class="control-group ">
                      <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'sumberdata', array('class'=>'control-label required','label'=>'Sumber Data <span class="required">*</span>')) ?>
                      <div class="controls">
                          <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'sumberdata',array('Pasien'=>'Pasien','Keluarga'=>'Keluarga','Lainnya'=>'Lainnya') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'sumberdata','onclick'=>'setSumberData_obgyn();')); ?>
                      </div>
                  </div>
                  <div class="control-group ">
                     <?php echo CHtml::label('','', array('class'=>'control-label')) ?>
                     <div class="controls">
                         <?php echo $form->textField($modAsesmenawalkeperawatanT, 'sumberdata_lainnya', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                     </div>
                 </div>
                 <div class="control-group ">
                    <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'namapasien_verifikator', array('class'=>'control-label required','label'=>'Nama Pasien/ Keluarga Verifikator <span class="required">*</span>')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modAsesmenawalkeperawatanT, 'namapasien_verifikator', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>

             </div>
                 <div class="col-sm-6">
                   <div class="control-group ">
                      <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'statusalergipasien', array('class'=>'control-label')) ?>
                      <div class="controls">
                          <div class="controls">
                              <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'statusalergipasien',array(1=>'Tidak Ada',2=>'Tidak Tahu',3=>'Ada') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'statusalergipasien','onclick'=>'setStatusAlergi_obgyn(this);')); ?>
                          </div>
                          <?php echo $form->error($modAsesmenawalkeperawatanT, 'statusalergipasien'); ?>
                      </div>
                  </div>

                  <?php echo $form->textAreaRow($modAsesmenawalkeperawatanT, 'riwayatalergiobat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
                   <?php echo $form->textAreaRow($modAsesmenawalkeperawatanT, 'riwayatalergimakanan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
                   <?php echo $form->textAreaRow($modAsesmenawalkeperawatanT, 'riwayatalergilainnya', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
                 </div>
             </div>
         </div>
     </div>
</div>
