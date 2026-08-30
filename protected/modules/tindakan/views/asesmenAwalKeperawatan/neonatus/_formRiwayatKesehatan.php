<div class="row-fluid">
     <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Riwayat Kesehatan</strong></div>
        </div>
         <div class="panel-body">
             <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
             <div class="row-fluid">
                 <div class="col-sm-6">
                     <?php CHtml::activeHiddenField($model, 'pendaftaran_id'); ?>
                     <?php CHtml::activeHiddenField($model, 'pasienadmisi_id'); ?>
                     <?php CHtml::activeHiddenField($model, 'pasien_id'); ?>

                     <div class="control-group ">
                            <?php echo CHtml::label('Perawat Pengkaji <span class="required">*</span>', 'paramedis_nama', array('class' => 'control-label required')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model,'paramedis_nama', CHtml::listData($dropPerawat, 'nama_pegawai', 'NamaLengkap'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            </div>
                     </div>
                     <?php echo $form->dropDownListRow($model, 'dokterpemeriksa_id', CHtml::listData($dropDokter, 'pegawai_id', 'NamaLengkap'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                 </div>
                 <div class="col-sm-6">
                   <div class="control-group ">
                      <?php echo $form->labelEx($model, 'jam_masukruangan', array('class' => 'control-label')) ?>
                      <div class="controls">
                              <?php
                                      $this->widget('MyDateTimePicker', array(
                                              'model' => $model,
                                              'attribute' => 'jam_masukruangan',
                                              'mode' => 'time',
                                              'options' => array(
                                              ),
                                              'htmlOptions' => array('readonly' => true, 'class'=>'span3',
                                                      'onkeypress' => "return $(this).focusNextInputField(event)"),
                                      ));
                              ?>
                      </div>
                   </div>
                   <div class="control-group ">
                      <?php echo $form->labelEx($model, 'tgl_assesmen_awal', array('class' => 'control-label')) ?>
                      <div class="controls">
                              <?php
                                      $this->widget('MyDateTimePicker', array(
                                              'model' => $model,
                                              'attribute' => 'tgl_assesmen_awal',
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
                 </div>
             </div>
             <div class="row">
               <div class="col-sm-12">
                 <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title"><strong>Riwayat Prenatal</strong></div>
                    </div>
                     <div class="panel-body">
                       <div class="row-fluid">
                           <div class="col-sm-6">
                             <div class="control-group ">
                                 <?php echo $form->LabelEx($model,'neonatus_anakke',array('class'=>'control-label'));?>
                                 <div class="controls">
                                  <?php  echo $form->textField($model,'neonatus_anakke',array('class'=>'span1 numbersOnly integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;'));?>
                                 </div>
                             </div>
                             <div class="control-group ">
                                 <?php echo $form->LabelEx($model,'neonatus_umurkehamilan',array('class'=>'control-label'));?>
                                 <div class="controls">
                                  <?php  echo $form->textField($model,'neonatus_umurkehamilan',array('class'=>'span1 numbersOnly integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;'));?> Minggu
                                 </div>
                             </div>
                             <div class="control-group ">
                                 <?php echo CHtml::label('Riwayat Penyakit Ibu','',array('class'=>'control-label'));?>
                                 <div class="controls">
                                   <table width="100%">
                                      <tr>
                                        <td width="50%">
                                          <table width="100%">
                                             <tr>
                                               <td>
                                                  <?php echo $form->checkbox($model,'neonatus_ispenyakitibudm',array()); ?>     <label>DM</label>
                                               </td>
                                             </tr>
                                             <tr>
                                               <td>
                                                  <?php echo $form->checkbox($model,'neonatus_ispenyakitibuhipertensi',array()); ?>     <label>Hipertensi</label>
                                               </td>
                                             </tr>
                                             <tr>
                                               <td>
                                                  <?php echo $form->checkbox($model,'neonatus_ispenyakitibujantung',array()); ?>     <label>Jantung</label>
                                               </td>
                                             </tr>
                                             <tr>
                                               <td>
                                                  <?php echo $form->checkbox($model,'neonatus_ispenyakitibutbc',array()); ?>     <label>TBC</label>
                                               </td>
                                             </tr>
                                             <tr>
                                               <td>
                                                  <?php echo $form->checkbox($model,'neonatus_ispenyakitibuhepatitisb',array()); ?>     <label>Hepatitis B</label>
                                               </td>
                                             </tr>
                                          </table>
                                        </td>
                                        <td width="50%" valign="top" style="padding-left: 5px;">
                                          <table width="100%">
                                             <tr>
                                               <td>
                                                  <?php echo $form->checkbox($model,'neonatus_ispenyakitibuasma',array()); ?>     <label>Asma</label>
                                               </td>
                                             </tr>
                                             <tr>
                                               <td>
                                                  <?php echo $form->checkbox($model,'neonatus_ispenyakitibupms',array()); ?>     <label>PMS</label>
                                               </td>
                                             </tr>
                                             <tr>
                                               <td>
                                                  <?php echo $form->checkbox($model,'neonatus_ispenyakitibulainnya',array()); ?>     <label>Lainnya</label>
                                               </td>
                                             </tr>
                                             <tr>
                                               <td>
                                                  <?php echo $form->textArea($model, 'neonatus_penyakitibu_lainnyaket', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                                  <?php
                                      						echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array('class' => 'btn btn-primary', 'onclick' => "$('#dialogAddRiwayatPenyakitIbu').dialog('open');",
                                      							'id' => 'btnAddPenyakitIbu', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                      							'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $model->getAttributeLabel('neonatus_penyakitibu_lainnyaket')))
                                      						?>
                                               </td>
                                             </tr>

                                          </table>
                                        </td>
                                      </tr>
                                   </table>
                                 </div>
                             </div>
                           </div>
                           <div class="col-sm-6">
                              <?php echo $form->textAreaRow($model, 'neonatus_riwayatpengobatanibu', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                           </div>
                         </div>
                     </div>
                 </div>

                 <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title"><strong>Riwayat Intranatal</strong></div>
                    </div>
                     <div class="panel-body">
                       <div class="row-fluid">
                           <div class="col-sm-6">
                             <div class="control-group ">
                               <?php echo $form->labelEx($model, 'neonatus_diagnosaibu', array('class' => 'control-label')) ?>
                               <div class="controls">
                                 <?php echo $form->textArea($model, 'neonatus_diagnosaibu', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                 <?php
                                 echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array('class' => 'btn btn-primary', 'onclick' => "$('#dialogAddPenyakitIbu').dialog('open');",
                                   'id' => 'btnAddRiwayatPenyakitKeluarga', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                   'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $model->getAttributeLabel('neonatus_diagnosaibu')))
                                 ?>
                               </div>
                             </div>
                             <div class="control-group ">
                                <?php echo $form->labelEx($model, 'neonatus_tgllahirbayi', array('class' => 'control-label')) ?>
                                <div class="controls">
                                        <?php
                                                $this->widget('MyDateTimePicker', array(
                                                        'model' => $model,
                                                        'attribute' => 'neonatus_tgllahirbayi',
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
                                <?php echo $form->labelEx($model, 'neonatus_jamlahir', array('class' => 'control-label')) ?>
                                <div class="controls">
                                        <?php
                                                $this->widget('MyDateTimePicker', array(
                                                        'model' => $model,
                                                        'attribute' => 'neonatus_jamlahir',
                                                        'mode' => 'time',
                                                        'options' => array(
                                                        ),
                                                        'htmlOptions' => array('readonly' => true, 'class'=>'span3',
                                                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                                                ));
                                        ?>
                                </div>
                             </div>
                             <?php echo $form->textAreaRow($model, 'neonatus_kondisisaatlahir', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                           </div>
                           <div class="col-sm-6">
                             <div class="control-group ">
                                <?php echo $form->labelEx($model,'neonatus_carapersalinan', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->radioButtonList($model,'neonatus_carapersalinan', LookupM::getItems("carapersalinan"), array('class'=>'riwayatpembedahan_status','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>
                            <div class="control-group ">
                                <?php echo $form->LabelEx($model,'neonatus_apgarscore',array('class'=>'control-label'));?>
                                <div class="controls">
                                 <?php  echo $form->textField($model,'neonatus_apgarscore',array('class'=>'span1 numbersOnly integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;'));?>
                                </div>
                            </div>
                            <div class="control-group ">
                                <?php echo $form->LabelEx($model,'neonatus_letak',array('class'=>'control-label'));?>
                                <div class="controls">
                                 <?php  echo $form->textField($model,'neonatus_letak',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                                </div>
                            </div>
                            <div class="control-group ">
                               <?php echo $form->labelEx($model,'neonatus_talipusat', array('class'=>'control-label')) ?>
                               <div class="controls">
                                   <?php echo $form->radioButtonList($model,'neonatus_talipusat', array('Segar'=>'Segar','Layu'=>'Layu','Simpul'=>'Simpul'), array('class'=>'riwayatpembedahan_status','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                               </div>
                           </div>
                           </div>
                         </div>
                     </div>
                 </div>

                 <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title"><strong>Faktor Risiko Infeksi</strong></div>
                    </div>
                     <div class="panel-body">
                       <div class="row-fluid">
                           <div class="col-sm-6">
                             <div class="control-group ">
                                 <?php echo CHtml::label('Mayor','',array('class'=>'control-label'));?>
                                 <div class="controls">
                                   <?php echo $form->checkbox($model,'neonatus_faktorinfeksimayor_ibudemam',array()); ?>     <label>Ibu Demam ≥ 38 &#176; C</label>
                                 </div>
                             </div>
                             <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                   <?php echo $form->checkbox($model,'neonatus_faktorinfeksimayor_kpdlebihdr24jam',array()); ?>     <label>KPD > 24 JAM</label>
                                 </div>
                             </div>
                             <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                   <?php echo $form->checkbox($model,'neonatus_faktorinfeksimayor_ketubanhijau',array()); ?>     <label>Ketuban Hijau</label>
                                 </div>
                             </div>
                             <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                   <?php echo $form->checkbox($model,'neonatus_faktorinfeksimayor_korioamnionitis',array()); ?>     <label>Korioamnionitis</label>
                                 </div>
                             </div>
                             <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                   <?php echo $form->checkbox($model,'neonatus_faktorinfeksimayor_fetaldistress',array()); ?>     <label>Fetal Distress</label>
                                 </div>
                             </div>
                           </div>
                           <div class="col-sm-6">
                             <div class="control-group ">
                                 <?php echo CHtml::label('Minor','',array('class'=>'control-label'));?>
                                 <div class="controls">
                                   <?php echo $form->checkbox($model,'neonatus_faktorinfeksiminor_kpdkurangdr12jam',array()); ?>     <label>KPD < 12 Jam</label>
                                 </div>
                             </div>
                             <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                   <?php echo $form->checkbox($model,'neonatus_faktorinfeksiminor_asfiksia',array()); ?>     <label>Asfiksia</label>
                                 </div>
                             </div>
                             <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                   <?php echo $form->checkbox($model,'neonatus_faktorinfeksiminor_bblr',array()); ?>     <label>BBLR</label>
                                 </div>
                             </div>
                             <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                   <?php echo $form->checkbox($model,'neonatus_faktorinfeksiminor_isk',array()); ?>     <label>ISK</label>
                                 </div>
                             </div>
                             <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                   <?php echo $form->checkbox($model,'neonatus_faktorinfeksiminor_ukkurangdr37minggu',array()); ?>     <label>UK < 37 Minggu</label>
                                 </div>
                             </div>
                             <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                   <?php echo $form->checkbox($model,'neonatus_faktorinfeksiminor_gemeli',array()); ?>     <label>Gemeli</label>
                                 </div>
                             </div>
                             <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                   <?php echo $form->checkbox($model,'neonatus_faktorinfeksiminor_keputihan',array()); ?>     <label>Keputihan</label>
                                 </div>
                             </div>
                             <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                   <?php echo $form->checkbox($model,'neonatus_faktorinfeksiminor_ibutemplebihdr37',array()); ?>     <label>Ibu Temp > 37 &#176; C</label>
                                 </div>
                             </div>
                           </div>
                         </div>
                     </div>
                 </div>

                 <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title"><strong>Kebutuhan Biologis</strong></div>
                    </div>
                     <div class="panel-body">
                       <div class="row-fluid">
                           <div class="col-sm-6">
                             <div class="control-group ">
                                 <?php echo CHtml::Label('Nutrisi','neonatus_anakke',array('class'=>'control-label'));?>
                                 <div class="controls">
                                  <?php echo $form->checkbox($model,'neonatus_ispenyakitibudm',array('onclick'=>'changeIsPenyakit(this);')); ?>     <label>ASI</label>
                                 </div>
                             </div>
                             <div class="control-group ">
                                 <label class="control-label"></label>
                                 <label class="control-label" style="width:100px">Frekuensi</label>
                                 <div class="controls">
                                    <?php  echo $form->textField($model,'neonatus_nutrisiasi_frekuensijml',array('class'=>'span1 numbersOnly integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;', 'readonly'=>true));?> Cc/
                                    <?php  echo $form->textField($model,'neonatus_nutrisiasi_frekuensikali',array('class'=>'span1 numbersOnly integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;', 'readonly'=>true));?> Kali
                                 </div>
                             </div>
                             <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                  <?php echo $form->checkbox($model,'neonatus_nutrisilainnya',array('onclick'=>'changeNurtrisiLainnya(this);')); ?>     <label>Lainnya</label>
                                 </div>
                             </div>
                             <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                  <?php echo $form->textArea($model, 'neonatus_nutrisilainnyaket', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
                                 </div>
                             </div>
                           </div>
                           <div class="col-sm-6">
                             <h4><b>Eliminasi</b></h4>
                             <div class="control-group ">
                                <?php echo $form->labelEx($model,'keb_eliminasi_bab_keluhanstatus', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->radioButtonList($model,'keb_eliminasi_bab_keluhanstatus_neonatus',array(0=>'Tidak Ada',1=>'Ada') , array('class'=>'keb_eliminasi_bab_keluhanstatus','onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setKebEliminasiBab_neonatus(this);')); ?>
                                </div>
                            </div>
                             <div class="control-group ">
                                 <label class="control-label">&nbsp;</label>
                                <div class="controls">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->checkbox($model,'keb_eliminasi_bab_ispendarahan_neonatus',array('class'=>'kebEliminasiBab','disabled'=>true)); ?>   <label>Pendarahan</label>
                                </div>
                            </div>
                             <div class="control-group">
                                 <label class="control-label">&nbsp;</label>
                                <div class="controls">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->checkbox($model,'keb_eliminasi_bab_ishemorroid_neonatus',array('class'=>'kebEliminasiBab','disabled'=>true)); ?>    <label>Hemorroid</label>
                                </div>
                            </div>
                             <div class="control-group">
                                 <label class="control-label"></label>
                                <div class="controls">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->checkbox($model,'keb_eliminasi_bab_iskonstipasi_neonatus',array('class'=>'kebEliminasiBab','disabled'=>true)); ?>     <label>Konstipasi</label>
                                </div>
                            </div>
                             <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->checkbox($model,'keb_eliminasi_bab_iskeluhanlainnya_neonatus',array('class'=>'kebEliminasiBab','disabled'=>true,'onchange'=>'setKebEliminasiKeluhanLainBab_neonatus(this);')); ?>   <label>Lainnya</label>
                                        <?php echo $form->textField($model, 'keb_eliminasi_bab_jeniskeluhanlainnya_neonatus', array('class' => 'span3','readonly'=>true)); ?>
                                </div>
                            </div>
                            <div class="control-group ">
                               <?php echo $form->labelEx($model,'keb_eliminasi_bak_keluhanstatus', array('class'=>'control-label')) ?>
                               <div class="controls">
                                   <?php echo $form->radioButtonList($model,'keb_eliminasi_bak_keluhanstatus_neonatus',array(0=>'Tidak Ada',1=>'Ada') , array('class'=>'keb_eliminasi_bak_keluhanstatus','onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setKebEliminasiBak_neonatus(this);')); ?>
                               </div>
                           </div>
                            <div class="control-group">
                                <label class="control-label"></label>
                               <div class="controls">
                                   &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->checkbox($model,'keb_eliminasi_bak_isnyeri_neonatus',array('class'=>'kebEliminasiBak','disabled'=>true)); ?>     <label>Nyeri</label>
                               </div>
                           </div>
                            <div class="control-group">
                                <label class="control-label"></label>
                               <div class="controls">
                                   &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->checkbox($model,'keb_eliminasi_bak_ispendarahan_neonatus',array('class'=>'kebEliminasiBak','disabled'=>true)); ?>     <label>Pendarahan</label>
                               </div>
                           </div>
                            <div class="control-group">
                                <label class="control-label"></label>
                               <div class="controls">
                                   &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->checkbox($model,'keb_eliminasi_bak_iskeluhanlainnya_neonatus',array('class'=>'kebEliminasiBak','disabled'=>true,'onchange'=>'setKebEliminasiKeluhanLainBak_neonatus(this);')); ?>     <label>Lainnya</label>
                                   <?php echo $form->textField($model, 'keb_eliminasi_bak_jeniskeluhanlainnya_neonatus', array('class' => 'span3','readonly'=>true)); ?>
                               </div>
                           </div>
                           </div>
                         </div>
                     </div>
                 </div>

                 <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title"><strong>Alergi/ Reaksi</strong></div>
                    </div>
                     <div class="panel-body">
                       <div class="row-fluid">
                           <div class="col-sm-6">
                             <div class="control-group ">
                                <?php echo $form->labelEx($model,'neonatus_alergidikajikpd', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->radioButtonList($model,'neonatus_alergidikajikpd',array('Ayah'=>'Ayah','Ibu'=>'Ibu') , array('class'=>'neonatus_alergidikajikpd','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>
                            <div class="control-group ">
                               <?php echo $form->labelEx($model,'statusalergipasien', array('class'=>'control-label')) ?>
                               <div class="controls">
                                   <!--<div class="radio">-->
                                           <div class="controls">
                                                   <?php echo $form->radioButtonList($model,'statusalergipasien_neonatus',array(1=>'Tidak Ada',2=>'Tidak Tahu',3=>'Ada') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'statusAlergi','onclick'=>'setStatusAlergi_neonatus(this);')); ?>
                                           </div>
                                   <!--</div>-->
                               </div>
                           </div>
                           <div class="control-group ">
                              <?php echo $form->labelEx($model,'riwayatalergiobat', array('class'=>'control-label')) ?>
                              <div class="controls">
                                  <?php echo $form->textArea($model, 'riwayatalergiobat_neonatus', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
                              </div>
                          </div>

                           </div>
                           <div class="col-sm-6">
                             <div class="control-group ">
                                <?php echo $form->labelEx($model,'riwayatalergimakanan', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textArea($model, 'riwayatalergimakanan_neonatus', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
                                </div>
                            </div>
                            <div class="control-group ">
                               <?php echo $form->labelEx($model,'riwayatalergilainnya', array('class'=>'control-label')) ?>
                               <div class="controls">
                                   <?php echo $form->textArea($model, 'riwayatalergilainnya_neonatus', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
                               </div>
                           </div>
                           <div class="control-group ">
                              <div class="controls">
                                  <label class="checkbox inline">
                                      <?php echo $form->checkbox($model,'ispasangtandaalergi_neonatus',array('readonly'=>true,'disabled'=>true)); ?><label>Dipasang stiker tanda alergi (<span class="dotRed"></span>)</label>
                                  </label>
                              </div>
                          </div>
                         </div>
                       </div>
                     </div>
                 </div>
               </div>
             </div>
         </div>
     </div>
</div>

<?php
//========= Dialog buat Pemesanan obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAddPenyakitIbu',
    'options' => array(
        'title' => 'Pencarian Data Diagnosa Ibu',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 440,
        'resizable' => false,
    ),
));

$modDataDiagnosa = new RJDiagnosaM('searchDiagnosaAnamnesa');
$modDataDiagnosa->unsetAttributes();
if(isset($_GET['RJDiagnosaM']))
    $modDataDiagnosa->attributes = $_GET['RJDiagnosaM'];
    $modDataDiagnosa->diagnosa_nama = (isset($_GET['RJDiagnosaM']['diagnosa_nama']) ? $_GET['RJDiagnosaM']['diagnosa_nama'] : "");
    $modDataDiagnosa->diagnosa_namalainnya = (isset($_GET['RJDiagnosaM']['diagnosa_namalainnya']) ? $_GET['RJDiagnosaM']['diagnosa_namalainnya'] : "");
    $modDataDiagnosa->diagnosa_kode = (isset($_GET['RJDiagnosaM']['diagnosa_kode']) ? $_GET['RJDiagnosaM']['diagnosa_kode'] : "");


$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosa-m-grid',
    'dataProvider' => $modDataDiagnosa->searchDiagnosaAnamnesa(),
    'filter' => $modDataDiagnosa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectDiagnosa",
                                    "onClick" => "
                                                var data = $(\"#' . CHtml::activeId($model, 'neonatus_diagnosaibu') . '\").val();
                                                if (data == \"\"){
                                                    $(\"#' . CHtml::activeId($model, 'neonatus_diagnosaibu') . '\").val(\"$data->diagnosa_nama\");
                                                } else {
                                                    $(\"#' . CHtml::activeId($model, 'neonatus_diagnosaibu') . '\").val(data+\", $data->diagnosa_nama\");
                                                }
                                                  $(\"#dialogAddPenyakitIbu\").dialog(\"close\");
                                        "))',
        ),
        'diagnosa_kode',
        'diagnosa_nama',
        'diagnosa_namalainnya',

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
//========= Dialog buat Pemesanan obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAddRiwayatPenyakitIbu',
    'options' => array(
        'title' => 'Pencarian Data Riwayat Penyakit Ibu',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 440,
        'resizable' => false,
    ),
));

$modDataDiagnosaRw = new RJDiagnosaM('searchDiagnosaAnamnesa');
$modDataDiagnosaRw->unsetAttributes();
if(isset($_GET['RJDiagnosaM']))
    $modDataDiagnosaRw->attributes = $_GET['RJDiagnosaM'];
    $modDataDiagnosaRw->diagnosa_nama = (isset($_GET['RJDiagnosaM']['diagnosa_nama']) ? $_GET['RJDiagnosaM']['diagnosa_nama'] : "");
    $modDataDiagnosaRw->diagnosa_namalainnya = (isset($_GET['RJDiagnosaM']['diagnosa_namalainnya']) ? $_GET['RJDiagnosaM']['diagnosa_namalainnya'] : "");
    $modDataDiagnosaRw->diagnosa_kode = (isset($_GET['RJDiagnosaM']['diagnosa_kode']) ? $_GET['RJDiagnosaM']['diagnosa_kode'] : "");


$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosa-m-grid',
    'dataProvider' => $modDataDiagnosaRw->searchDiagnosaAnamnesa(),
    'filter' => $modDataDiagnosaRw,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectDiagnosa",
                                    "onClick" => "
                                                var data = $(\"#' . CHtml::activeId($model, 'neonatus_penyakitibu_lainnyaket') . '\").val();
                                                if (data == \"\"){
                                                    $(\"#' . CHtml::activeId($model, 'neonatus_penyakitibu_lainnyaket') . '\").val(\"$data->diagnosa_nama\");
                                                } else {
                                                    $(\"#' . CHtml::activeId($model, 'neonatus_penyakitibu_lainnyaket') . '\").val(data+\", $data->diagnosa_nama\");
                                                }
                                                  $(\"#dialogAddRiwayatPenyakitIbu\").dialog(\"close\");
                                        "))',
        ),
        'diagnosa_kode',
        'diagnosa_nama',
        'diagnosa_namalainnya',

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
