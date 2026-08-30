<?php
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
    }
    $this->widget('bootstrap.widgets.BootAlert');
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'observasiigd-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
));
?>
<?php echo $form->hiddenField($model, 'pendaftaran_id'); ?>

<div class="panel panel-gradient">
  <div class="panel-heading">
      <div class="panel-title">
          <strong>Transaksi Asesmen Geriatri</strong>
      </div>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model,'tanggal_catat', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php
                    $this->widget('MyDateTimePicker',array(
                    'model'=>$model,
                    'attribute'=>'tanggal_catat',
                    'mode'=>'datetime',
                    'options'=> array(
                            'dateFormat'=>Params::DATE_FORMAT,
                    ),
                    'htmlOptions'=>array('readonly'=>true,'class'=>'span3','style'=>'width:150px;'),
                )); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'jam_pengisian', array('class' => 'control-label')) ?>
            <div class="controls">
              <?php
                  $this->widget('MyDateTimePicker', array(
                          'model' => $model,
                          'attribute' => 'jam_pengisian',
                          'mode' => 'time',
                          'options' => array(
                          ),
                          'htmlOptions' => array('class'=>'span3',
                            'onkeypress' => "return $(this).focusNextInputField(event)",'style'=>'width:150px;'),
                  ));
              ?>
            </div>
        </div>
      </div>
      <div class="col-sm-6">
          <?php echo $form->dropDownListRow($model, 'pegawai_id', CHtml::listData(PegawairuanganV::model()->findAll('ruangan_id = '.Yii::app()->user->getState("ruangan_id").' ORDER BY nama_pegawai ASC'), 'pegawai_id', 'NamaLengkap'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
      </div>
      <div class="clear"></div>
      <div class="col-sm-12">
        <div style="margin-top: 20px !important;" class="panel panel-darkk">
            <span class="group-title">
              Data Medis RS
            </span>
            <div class="panel-body" style="padding-top:5px !important;">
              <div class="row">
                <div class="col-sm-6">
                  <div class="control-group ">
                      <?php echo $form->label($model, 'diagnosa_id', array('class' => 'control-label')) ?>
                      <div class="controls">
                        <?php echo $form->textArea($model,'diagnosa_nama',array('cols'=>20,'rows'=>4,'readonly'=>true)) ?>
                      </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="control-group ">
                      <?php echo CHtml::label('Penunjang Diagnosa', '', array('class' => 'control-label')) ?>
                  </div>
                  <div class="control-group">
                      <div class="controls">
                        <?php echo $form->radioButton($model,'diagnosis_penunjang',array('class'=>'diagnosis_penunjang','value'=>'Rontgen','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> <label>Rontgen</label>
                        <span style='padding-left: 20px'></span><?php echo $form->radioButton($model,'diagnosis_penunjang',array('class'=>'diagnosis_penunjang','value'=>'Lab','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> <label>Lab</label>
                        <span style='padding-left: 20px'></span><?php echo $form->radioButton($model,'diagnosis_penunjang',array('class'=>'diagnosis_penunjang','value'=>'CT Scan','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> <label>CT Scan</label>
                        <br/>
                        <?php echo $form->radioButton($model,'diagnosis_penunjang',array('class'=>'diagnosis_penunjang','value'=>'MRI','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> <label>MRI</label>
                        <span style='padding-left: 20px'></span><?php echo $form->radioButton($model,'diagnosis_penunjang',array('class'=>'diagnosis_penunjang','value'=>'ENMG','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> <label>ENMG</label>
                        <span style='padding-left: 20px'></span><?php echo $form->radioButton($model,'diagnosis_penunjang',array('class'=>'diagnosis_penunjang','value'=>'EEG','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> <label>EEG</label>
                      </div>
                  </div>
                  <div class="control-group ">
                      <?php echo $form->label($model, 'resume', array('class' => 'control-label','style'=>'width: 65px')) ?>
                      <div class="controls">
                        <?php echo $form->textArea($model,'resume',array('cols'=>20,'rows'=>4)) ?>
                      </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="clear"></div>
      <div class="col-sm-12">
        <div style="margin-top: 20px !important;" class="panel panel-darkk">
            <span class="group-title">
              Data Anamnesa
            </span>
            <div class="panel-body" style="padding-top:5px !important;">
              <div class="row">
                <div class="col-sm-6">
                  <div class="control-group ">
                      <?php echo CHtml::label('1. Keluhan', '', array('class' => 'control-label','style'=>'width: 60px')) ?>
                  </div>
                  <div class="control-group ">
                      <div class="controls" style="padding-left: 10px">
                        <?php echo $form->textArea($model,'keluhanutama',array('cols'=>20,'rows'=>4,'readonly'=>false)) ?>
                      </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="control-group ">
                      <?php echo CHtml::label('2. Riwayat Penyakit', '', array('class' => 'control-label','style'=>'width: 110px')) ?>
                  </div>
                  <div class="control-group " style="padding-left: 10px">
                      <div class="controls">
                        <?php echo $form->textArea($model,'riwayatpenyakit',array('cols'=>20,'rows'=>4,'readonly'=>false)) ?>
                      </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="clear"></div>
      <div class="col-sm-12">
        <div style="margin-top: 20px !important;" class="panel panel-darkk">
            <span class="group-title">
              Data Pemeriksaan Umum
            </span>
            <div class="panel-body" style="padding-top:5px !important;">
              <div class="row">
                <div class="col-sm-6">
                  <div class="control-group ">
                      <?php echo CHtml::label('1. Tanda Vital', '', array('class' => 'control-label','style'=>'width: 100px')) ?>
                  </div>
                  <div class="control-group ">
                      <?php echo CHtml::label('Tekanan Darah', '', array('class' => 'control-label')) ?>
                      <div class="controls">
                        <?php  echo $form->textField($model,'td_systolic',array('class'=>'span1 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'getTekananDarah();', 'style'=>'text-align: right;'));?>Mm
                        <?php echo $form->textField($model,'td_dyastolic',array('class'=>'span1 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'getTekananDarah();', 'style'=>'text-align: right;')); ?>Hg
                      </div>
                  </div>
                  <div class="control-group ">
                      <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                      <div class="controls">
                        <?php  echo CHtml::textField('tekanandarah','000/000',array('readonly'=>true,'class'=>'span2 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>MmHg
                      </div>
                  </div>
                  <div class="control-group ">
                      <?php echo CHtml::label('Detak Nadi', '', array('class' => 'control-label')) ?>
                      <div class="controls">
                        <?php echo $form->textField($model,'nadi',array('class'=>'span2  integer numbersOnly', 'maxlength'=>3, 'onkeypress'=>"return $(this).focusNextInputField(event)"));?> /Menit
                      </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="control-group ">
                      <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                  </div>
                  <div class="control-group ">
                      <?php echo CHtml::label('Pernapasan', '', array('class' => 'control-label')) ?>
                      <div class="controls">
                        <?php echo $form->textField($model,'pernapasan',array('class'=>'span2  integer numbersOnly', 'maxlength'=>3, 'onkeypress'=>"return $(this).focusNextInputField(event)"));?> /Menit
                      </div>
                  </div>
                  <div class="control-group ">
                      <?php echo CHtml::label('Suhu Tubuh', '', array('class' => 'control-label')) ?>
                      <div class="controls">
                        <?php echo $form->textField($model,'suhutubuh',array('class'=>'span2 float', 'maxlength'=>5, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align:right;'));?> &#176; Celcius
                      </div>
                  </div>
                </div>
                <div class="clear"></div>
                <div class="col-sm-12">
                  <div class="control-group ">
                      <?php echo CHtml::label('2. Inspeksi', '', array('class' => 'control-label','style'=>'width: 90px')) ?>
                  </div>
                  <div class="control-group ">
                      <?php echo CHtml::label('Statik', '', array('class' => 'control-label','style'=>'width: 90px')) ?>
                  </div>
                  <div class="control-group ">
                     <?php echo CHtml::label('','', array('class'=>'control-label','style'=>'width: 30px')) ?>
                     <div class="controls">
                       <div class="radio inline">
                         <div class="form-inline">
                           <?php //echo $form->radioButtonList($model,'statik',array('Kelemahan Sebelah Tubuh'=>'Kelemahan Sebelah Tubuh','Kontraktur'=>'Kontraktur','Wajah Asimetris'=>'Wajah Asimetris','Lainnya'=>'Lainnya') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'statik','onchange'=>'setStatik();','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                           <?php //echo $form->textField($model,'static_lainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                           <?php
                                $htmlSpasme = "";
                                $look_spasme = array('0'=>'Kelemahan Sebelah Tubuh','1'=>'Kontraktur','2'=>'Wajah Asimetris','3'=>'Lainnya');

                                if(count($look_spasme) > 0){
                                  foreach ($look_spasme as $i => $lookp) {
                                    $ischeck = false;
                                    if(!empty($model->statik)){
                                      $arrOriSpasme = json_decode($model->statik);
                                      
                                      if(count($arrOriSpasme) > 0){
                                        foreach ($arrOriSpasme as $dt=>$dataSpasme) {
                                          
                                          if($lookp == $dataSpasme){
                                              
                                              $ischeck = true;
                                          }
                                        }
                                      }
                                    }
                                    $htmlSpasme .= CHtml::hiddenField('statik['.$i.']',$lookp);
                                    if ($lookp == 'Lainnya'){
                                        $htmlSpasme .= CHtml::activecheckBox($model,'statik['.$i.']',array('class'=>'statik','onClick'=>'setStatik();','value'=>$lookp,'checked'=>$ischeck)) .' '."<label>".$lookp."</label>&nbsp;";
                                        $htmlSpasme .= $form->textField($model,'static_lainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));
                                    }else{
                                        $htmlSpasme .= CHtml::activecheckBox($model,'statik['.$i.']',array('class'=>'statik','value'=>$lookp,'checked'=>$ischeck)) .' '."<label>".$lookp."</label>&nbsp;";
                                    }
                                  }
                                }
                                echo $htmlSpasme;
                              ?>
                         </div>
                       </div>

                     </div>
                 </div>
                 <div class="control-group ">
                     <?php echo CHtml::label('Dinamis (Adanya Perubahan dalam)', '', array('class' => 'control-label','style'=>'width: 250px')) ?>
                 </div>
                 <div class="control-group ">
                    <?php echo CHtml::label('','', array('class'=>'control-label','style'=>'width: 30px')) ?>
                    <div class="controls">
                      <div class="radio inline">
                        <div class="form-inline">
                          <?php //echo $form->radioButtonList($model,'dinamis',array('Pola Jalan'=>'Pola Jalan','Sikap Tubuh'=>'Sikap Tubuh','Pola Aktivitas Lain'=>'Pola Aktivitas Lain','Lainnya'=>'Lainnya') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'dinamis','onchange'=>'setDinamis();','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                          <?php //echo $form->textField($model,'dinamis_lainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                          <?php
                                $htmlSpasme = "";
                                $look_spasme = array('0'=>'Pola Jalan','1'=>'Sikap Tubuh','2'=>'Pola Aktivitas Lain','3'=>'Lainnya');

                                if(count($look_spasme) > 0){
                                  foreach ($look_spasme as $i => $lookp) {
                                    $ischeck = false;
                                    if(!empty($model->dinamis)){
                                      $arrOriSpasme = json_decode($model->dinamis);
                                      
                                      if(count($arrOriSpasme) > 0){
                                        foreach ($arrOriSpasme as $dt=>$dataSpasme) {
                                          
                                          if($lookp == $dataSpasme){
                                              
                                              $ischeck = true;
                                          }
                                        }
                                      }
                                    }
                                    $htmlSpasme .= CHtml::hiddenField('dinamis['.$i.']',$lookp);
                                    if ($lookp == 'Lainnya'){
                                        $htmlSpasme .= CHtml::activecheckBox($model,'dinamis['.$i.']',array('class'=>'dinamis','onClick'=>'setDinamis();','value'=>$lookp,'checked'=>$ischeck)) .' '."<label>".$lookp."</label>&nbsp;";
                                        $htmlSpasme .= $form->textField($model,'dinamis_lainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));
                                    }else{
                                        $htmlSpasme .= CHtml::activecheckBox($model,'dinamis['.$i.']',array('class'=>'dinamis','value'=>$lookp,'checked'=>$ischeck)) .' '."<label>".$lookp."</label>&nbsp;";
                                    }
                                  }
                                }
                                echo $htmlSpasme;
                              ?>
                        </div>
                      </div>

                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('3. Palpasi', '', array('class' => 'control-label','style'=>'width: 90px')) ?>
                </div>
                <div class="control-group ">
                   <?php echo CHtml::label('','', array('class'=>'control-label','style'=>'width: 30px')) ?>
                   <div class="controls">
                     <div class="radio inline">
                       <div class="form-inline">
                         <?php //echo $form->radioButtonList($model,'palpasi',array('Peningkatan Suhu Lokal'=>'Peningkatan Suhu Lokal','Nyeri Tekan'=>'Nyeri Tekan','Spasme'=>'Spasme','Pitting Oedema'=>'Pitting Oedema') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'uncheckValue'=>null,'class'=>'palpasi','onchange'=>'setPalpasi();','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                         <?php
                                $htmlSpasme = "";
                                $look_spasme = array('0'=>'Peningkatan Suhu Lokal','1'=>'Nyeri Tekan','2'=>'Spasme','3'=>'Pitting Oedema','4'=>'Lainnya');

                                if(count($look_spasme) > 0){
                                  foreach ($look_spasme as $i => $lookp) {
                                    $ischeck = false;
                                    if(!empty($model->palpasi)){
                                      $arrOriSpasme = json_decode($model->palpasi);
                                      
                                      if(count($arrOriSpasme) > 0){
                                        foreach ($arrOriSpasme as $dt=>$dataSpasme) {
                                          
                                          if($lookp == $dataSpasme){
                                              
                                              $ischeck = true;
                                          }
                                        }
                                      }
                                    }
                                    $htmlSpasme .= CHtml::hiddenField('palpasi['.$i.']',$lookp);
                                    if ($lookp == 'Lainnya'){
                                        $htmlSpasme .= '<br>';
                                        $htmlSpasme .= CHtml::activecheckBox($model,'palpasi['.$i.']',array('class'=>'palpasi','onClick'=>'setPalpasi();','value'=>$lookp,'checked'=>$ischeck)) .' '."<label>".$lookp."</label>&nbsp;";
                                        $htmlSpasme .= $form->textField($model,'palpasi_lainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));
                                    }else{
                                        $htmlSpasme .= CHtml::activecheckBox($model,'palpasi['.$i.']',array('class'=>'palpasi','value'=>$lookp,'checked'=>$ischeck)) .' '."<label>".$lookp."</label>&nbsp;";
                                    }
                                  }
                                }
                                echo $htmlSpasme;
                          ?>
                       </div>

                     </div>
                     <br/>
                    <!-- <span style='padding-left: 20px'></span><?php //echo $form->radioButton($model,'palpasi',array('class'=>'palpasi','value'=>'Lainnya','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'setPalpasi();')); ?> <label>Lainnya</label> -->
                    <?php //echo $form->textField($model,'palpasi_lainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                   </div>
               </div>
               <div class="control-group">
                 <label class="control-label">Pilih Pemeriksaan</label>
                 <div class="controls">
                     <?php echo CHtml::dropDownList('pemeriksaanFungsiGerak','',CHtml::listData(PeriksafungsigerakdasarM::model()->findAll('periksafungsigerakdasar_aktif = true order by periksafungsigerakdasar_urutan asc'),'periksafungsigerakdasar_id','periksafungsigerakdasar_nama'),array('empty'=>'Pilih', 'class'=>'span3')); ?>
                 </div>
                 <div class="controls">
                     <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i> Tambah',
                             array('onclick'=>'tambahPemeriksaan(); return false;',
                             'class'=>'btn btn-primary',
                             'onkeyup'=>"tambahPemeriksaan();",
                             'rel'=>"tooltip",
                             'title'=>"Klik untuk menambahkan Pemeriksaan")); ?>
                 </div>
               </div>
               <br/>
               <div class="rowPemeriksaanFungsiGerakDasar">
                 <?php
                      if(count($oriPeriksaExtra) > 0){
                        foreach ($oriPeriksaExtra as $i => $oriExtra) {
                          $this->renderPartial($this->path_view.'_rowPeriksaFungsiGerakDasar',array(
                            'namaPemeriksaan'=>$oriExtra->periksafungsigerakdasar->periksafungsigerakdasar_nama,
                            'pemeriksaan_id'=>$oriExtra->periksafungsigerakdasar->periksafungsigerakdasar_id,
                            'oriPeriksaSinistra'=>$oriPeriksaSinistra,
                            'oriPeriksaDextra'=>$oriPeriksaDextra,
                            'oriExtra'=>$oriExtra,
                            'urutIndex'=>$i
                          ));
                        }
                      }
                  ?>
               </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="clear"></div>
      <div class="col-sm-12">
        <div style="margin-top: 20px !important;" class="panel panel-darkk">
            <span class="group-title">
              Data Pemeriksaan Khusus
            </span>
            <div class="panel-body" style="padding-top:5px !important;">
              <div class="row">
                <div class="col-sm-12">
                  <div class="panel panel-success">
                      <div class="panel-heading">
                          <div class="panel-title">Data Nyeri</div>
                      </div>
                      <div class="panel-body">
                          <?php echo $this->renderPartial($this->path_view.'_formNyeri',array('form'=>$form,'model'=>$model),true); ?>
                      </div>
                  </div>
                  <div class="control-group ">
                      <?php echo CHtml::label('2. MMT', '', array('class' => 'control-label','style'=>'width: 40px')) ?>
                  </div>
                  <div class="control-group">
                    <?php echo CHtml::label('','', array('class'=>'control-label','style'=>'width: 5px')) ?>
                    <div class="controls">
                        <?php echo $this->renderPartial($this->path_view.'_formMMT',array('model'=>$model,'modAsesmenmmtT'=>$modAsesmenmmtT)); ?>
                    </div>
                  </div>
                </div>
                <div class="clear"></div>
                <div class="col-sm-12">
                  <div class="control-group ">
                      <?php echo CHtml::label('3. Penilaian ADL dengan Indeks Barthel', '', array('class' => 'control-label','style'=>'width: 210px')) ?>
                  </div>
                  <div class="control-group">
                    <?php echo CHtml::label('','', array('class'=>'control-label','style'=>'width: 5px')) ?>
                    <div class="controls">
                      <?php echo $this->renderPartial($this->path_view.'tabel/_tabelPenilaian',array('model'=>$model, 'form'=>$form, 'loadMaster' => $loadMaster)) ?>
                    </div>
                  </div>

                </div>

                <div class="clear"></div>
                <div class="col-sm-6">
                  <div class="control-group ">
                      <?php echo CHtml::label('4. Test Khusus Sesuai Kelainan/Penyakit/Gangguan', '', array('class' => 'control-label','style'=>'width: 275px')) ?>
                  </div>
                  <div class="control-group ">
                      <div class="controls">
                        <?php echo $form->textArea($model,'test_khusus',array('style'=>'width: 300px','rows'=>4)) ?>
                      </div>
                  </div>
                </div>
                <div class="col-sm-6">
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="clear"></div>
      <div class="col-sm-6">
        <div style="margin-top: 20px !important;" class="panel panel-darkk">
            <span class="group-title">
              Kemampuan Fungsional
            </span>
          <div class="panel-body" style="padding-top:5px !important;">
              <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model,'attribute'=>'kemampuan_fungsional','name'=>'AsesmenFisioterapiGeriatriT[kemampuan_fungsional]','toolbar'=>'mini','height'=>'200px'));?>
              <?php //echo $form->textArea($model,'kemampuan_fungsional', array('style'=>'height: 200px; width: 100%')) ?>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div style="margin-top: 20px !important;" class="panel panel-darkk">
            <span class="group-title">
              Diagnosa Fisioterapi
            </span>
          <div class="panel-body" style="padding-top:5px !important;">
              <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model,'attribute'=>'diagnosis_fisioterapi','name'=>'AsesmenFisioterapiGeriatriT[diagnosis_fisioterapi]','toolbar'=>'mini','height'=>'200px'));?>
              <?php //echo $form->textArea($model,'diagnosis_fisioterapi', array('style'=>'height: 200px; width: 100%')) ?>
          </div>
        </div>
      </div>
      <div class="clear"></div>
      <div class="col-sm-6">
        <div style="margin-top: 20px !important;" class="panel panel-darkk">
            <span class="group-title">
              Program Fisioterapi
            </span>
          <div class="panel-body" style="padding-top:5px !important;">
              <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model,'attribute'=>'program_fisioterapi','name'=>'AsesmenFisioterapiGeriatriT[program_fisioterapi]','toolbar'=>'mini','height'=>'200px'));?>
              <?php //echo $form->textArea($model,'program_fisioterapi', array('style'=>'height: 200px; width: 100%')) ?>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div style="margin-top: 20px !important;" class="panel panel-darkk">
            <span class="group-title">
              Evaluasi dan Tindak Lanjut
            </span>
          <div class="panel-body" style="padding-top:5px !important;">
              <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model,'attribute'=>'evaluasidantindaklanjut','name'=>'AsesmenFisioterapiGeriatriT[evaluasidantindaklanjut]','toolbar'=>'mini','height'=>'200px'));?>
              <?php //echo $form->textArea($model,'evaluasidantindaklanjut', array('style'=>'height: 200px; width: 100%')) ?>
          </div>
        </div>
      </div>

    </div>
    <div class="row-fluid">
        <div class="form-actions">
            <?php
            $disabledSukses = (isset($_GET['sukses'])?false:true);
                echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan', 'disabled'=>(($disabledSukses==true)?false:true)));
                echo "&nbsp;";
                echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                    $this->createUrl($this->id.'/index/&pendaftaran_id='.$_GET['pendaftaran_id']),
                    array('class'=>'btn btn-danger',
                        'onclick'=>'return refreshForm(this);'));

                echo "&nbsp&nbsp". CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print("'.$_GET['pendaftaran_id'].'","'.$_GET['pasienmasukpenunjang_id'].'")', 'disabled'=>$disabledSukses));
            ?>
            <?php
                $content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
                $this->widget('UserTips',array('type'=>'admin','content'=>$content));
            ?>
        </div>
    </div>

  </div>
</div>
<?php $this->endWidget(); ?>

<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model)); ?>
