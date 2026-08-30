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
                                        'attribute' => 'jam_masukruangan_geriatri',
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
                       <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'caratibadiruangan', array('class'=>'control-label','label'=>'Tiba di Ruangan dengan cara')) ?>
                       <div class="controls">
                           <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'caratibadiruangan',LookupM::getItems('caratibadiruangan'), array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'caratibadiruangan')); ?>
                       </div>
                   </div>
                     <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT, 'tgl_assesmen_awal', array('class' => 'control-label')) ?>
                        <div class="controls">
                                <?php
                                        $this->widget('MyDateTimePicker', array(
                                                'model' => $modAsesmenawalkeperawatanT,
                                                'attribute' => 'tgl_assesmen_awal_geriatri',
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
                                                    'attribute'=>'keluhanutama_geriatri',
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
                                    <?php echo $form->error($modAsesmenawalkeperawatanT, 'keluhanutama'); ?>
                            </div>
                    </div>
                            <div class="control-group ">
                                    <?php echo $form->labelEx($modAsesmenawalkeperawatanT, 'keluhantambahan', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                            <?php
                                                    $this->widget('application.extensions.FCBKcomplete.FCBKcomplete',array(
                                                            'model'=>$modAsesmenawalkeperawatanT,
                                                            'attribute'=>'keluhantambahan_geriatri',
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
                                            <?php echo $form->error($modAsesmenawalkeperawatanT, 'keluhantambahan'); ?>
                                    </div>
                            </div>
                     <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'sumberdata', array('class'=>'control-label required','label'=>'Sumber Data <span class="required">*</span>')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'sumberdata',array('Pasien'=>'Pasien','Keluarga'=>'Keluarga','Lainnya'=>'Lainnya') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'sumberdata','onclick'=>'setSumberData();')); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                       <?php echo CHtml::label('','', array('class'=>'control-label')) ?>
                       <div class="controls">
                           <?php echo $form->textField($modAsesmenawalkeperawatanT, 'sumberdata_lainnya', array('class' => 'span3 disabledinputan', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                       </div>
                   </div>
                   <div class="control-group ">
                      <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'namapasien_verifikator', array('class'=>'control-label required','label'=>'Nama Pasien/ Keluarga Verifikator <span class="required">*</span>')) ?>
                      <div class="controls">
                          <?php echo $form->textField($modAsesmenawalkeperawatanT, 'namapasien_verifikator', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                      </div>
                  </div>
                  <div class="control-group ">
                      <?php echo $form->labelEx($modAsesmenawalkeperawatanT, 'riwayatperjalanan_penyakitpasien', array('class' => 'control-label')) ?>
                      <div class="controls">
                          <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'riwayatperjalanan_penyakitpasien', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                          <?php echo $form->error($modAsesmenawalkeperawatanT, 'riwayatperjalanan_penyakitpasien'); ?>
                      </div>
                  </div>
                  <div class="control-group ">
                    <?php echo $form->labelEx($modAsesmenawalkeperawatanT, 'riwayatpenyakitkeluarga', array('class' => 'control-label')) ?>
                    <div class="controls">
                      <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'riwayatpenyakitkeluarga', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                      <?php
                      echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array('class' => 'btn btn-primary', 'onclick' => "$('#dialogDiagnosa').dialog('open');$('#formDiagnosa').val('formGeriatri');refreshGridDiagnosa();",
                        'id' => 'btnAddRiwayatPenyakitKeluarga', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modAsesmenawalkeperawatanT->getAttributeLabel('riwayatpenyakitkeluarga')))
                      ?>
                      <?php echo $form->error($modAsesmenawalkeperawatanT, 'riwayatpenyakitkeluarga'); ?>
                    </div>
                  </div>
                  <div class="control-group ">
                      <?php echo $form->labelEx($modAskepgeriatriT, 'kegiatan_sekarang', array('class' => 'control-label')) ?>
                      <div class="controls">
                          <?php echo $form->textArea($modAskepgeriatriT, 'kegiatan_sekarang', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                      </div>
                  </div>
                  <div class="control-group ">
                     <?php echo $form->labelEx($modAskepgeriatriT,'orangterdekat_nama', array('class'=>'control-label','label'=>'Nama orang terdekat')) ?>
                     <div class="controls">
                         <?php echo $form->textField($modAskepgeriatriT, 'orangterdekat_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                     </div>
                 </div>
                 <div class="control-group ">
                     <?php echo $form->labelEx($modAskepgeriatriT, 'orangygtinggal_serumah', array('class' => 'control-label','label'=>'Orang yang tinggal serumah')) ?>
                     <div class="controls">
                         <?php echo $form->textArea($modAskepgeriatriT, 'orangygtinggal_serumah', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                     </div>
                 </div>
                 <div class="control-group ">
                    <?php echo $form->labelEx($modAskepgeriatriT,'jmlanak_seluruh', array('class'=>'control-label','label'=>'Jumlah Anak')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modAskepgeriatriT, 'jmlanak_seluruh', array('class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Orang</label>
                    </div>
                </div>
                <div class="control-group" style="padding-left: 60px">
                   <?php echo $form->labelEx($modAskepgeriatriT,'jmlanak_lakilaki', array('class'=>'control-label','label'=>'Laki-Laki')) ?>
                   <div class="controls">
                       <?php echo $form->textField($modAskepgeriatriT, 'jmlanak_lakilaki', array('class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Orang</label>
                   </div>
               </div>
               <div class="control-group" style="padding-left: 60px">
                  <?php echo $form->labelEx($modAskepgeriatriT,'jmlanak_perempuan', array('class'=>'control-label','label'=>'Perempuan')) ?>
                  <div class="controls">
                      <?php echo $form->textField($modAskepgeriatriT, 'jmlanak_perempuan', array('class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Orang</label>
                  </div>
              </div>

              <div class="control-group ">
                 <?php echo $form->labelEx($modAskepgeriatriT,'jmlcucu_seluruh', array('class'=>'control-label','label'=>'Jumlah Cucu')) ?>
                 <div class="controls">
                     <?php echo $form->textField($modAskepgeriatriT, 'jmlcucu_seluruh', array('class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Orang</label>
                 </div>
             </div>
             <div class="control-group" style="padding-left: 60px">
                <?php echo $form->labelEx($modAskepgeriatriT,'jmlcucu_lakilaki', array('class'=>'control-label','label'=>'Laki-Laki')) ?>
                <div class="controls">
                    <?php echo $form->textField($modAskepgeriatriT, 'jmlcucu_lakilaki', array('class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Orang</label>
                </div>
            </div>
            <div class="control-group" style="padding-left: 60px">
               <?php echo $form->labelEx($modAskepgeriatriT,'jmlcucu_perempuan', array('class'=>'control-label','label'=>'Perempuan')) ?>
               <div class="controls">
                   <?php echo $form->textField($modAskepgeriatriT, 'jmlcucu_perempuan', array('class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Orang</label>
               </div>
           </div>

                 <div class="control-group ">
                    <?php echo $form->labelEx($modAskepgeriatriT,'jmlcicit_seluruh', array('class'=>'control-label','label'=>'Jumlah Cicit')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modAskepgeriatriT, 'jmlcicit_seluruh', array('class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Orang</label>
                    </div>
                </div>
                <div class="control-group" style="padding-left: 60px">
                   <?php echo $form->labelEx($modAskepgeriatriT,'jmlcicit_lakilaki', array('class'=>'control-label','label'=>'Laki-Laki')) ?>
                   <div class="controls">
                       <?php echo $form->textField($modAskepgeriatriT, 'jmlcicit_lakilaki', array('class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Orang</label>
                   </div>
               </div>
               <div class="control-group" style="padding-left: 60px">
                  <?php echo $form->labelEx($modAskepgeriatriT,'jmlcicit_perempuan', array('class'=>'control-label','label'=>'Perempuan')) ?>
                  <div class="controls">
                      <?php echo $form->textField($modAskepgeriatriT, 'jmlcicit_perempuan', array('class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Orang</label>
                  </div>
              </div>

           </div>
                 <div class="col-sm-6">
                   <div class="control-group ">
                      <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'statusalergipasien', array('class'=>'control-label')) ?>
                      <div class="controls">
                          <!--<div class="radio">-->
                                  <div class="controls">
                                          <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'statusalergipasien',array(1=>'Tidak Ada',2=>'Tidak Tahu',3=>'Ada') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'statusalergipasien','onclick'=>'setStatusAlergi_geriatri();')); ?>
                                  </div>
                          <!--</div>-->
                          <?php echo $form->error($modAsesmenawalkeperawatanT, 'statusalergipasien'); ?>
                      </div>
                  </div>

                      <?php echo $form->textAreaRow($modAsesmenawalkeperawatanT, 'riwayatalergiobat', array('class' => 'span3 disabledinputan', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                   <?php echo $form->textAreaRow($modAsesmenawalkeperawatanT, 'riwayatalergimakanan', array('class' => 'span3 disabledinputan', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                     <?php echo $form->textAreaRow($modAsesmenawalkeperawatanT, 'riwayatalergilainnya', array('class' => 'span3 disabledinputan', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                     <div class="control-group ">
                         <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'riwayatpembedahan_status', array('class'=>'control-label','label'=>'Riwayat Operasi')) ?>
                         <div class="controls">
                             <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'riwayatpembedahan_status',array('Tidak Pernah'=>'Tidak Pernah','Pernah'=>'Pernah') , array('class'=>'riwayatpembedahan_status','onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setStatusPembedahanAnastesi_geriatri();')); ?>
                         </div>
                     </div>
                     <div class="control-group">
                         <label class="control-label"></label>
                         <div class="controls">
                            Jenis dan kapan <br/>
                             <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'riwayatpembedahan_keterangan', array('class' => 'span3 disabledinputan', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                         </div>
                     </div>
                     <div class="control-group ">
                         <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'riwayattransfusi_status', array('class'=>'control-label','label'=>'Riwayat Transfusi')) ?>
                         <div class="controls">
                             <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'riwayattransfusi_status',array('Tidak'=>'Tidak','Ya'=>'Ya') , array('class'=>'riwayattransfusi_status','onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setStatusRiwayattransfusi_geriatri();')); ?>
                         </div>
                     </div>
                     <div class="control-group">
                         <label class="control-label"></label>
                         <div class="controls">
                           <div class="control-group ">
                               <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'riwayattransfusi_isreaksi', array('class'=>'control-label','label'=>'Reaksi Transfusi')) ?>
                               <div class="controls">
                                   <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'riwayattransfusi_isreaksi',array('Tidak'=>'Tidak','Ya'=>'Ya') , array('class'=>'riwayattransfusi_isreaksi disabledinputan','onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setReaksiRiwayattransfusi_geriatri();')); ?>
                               </div>
                           </div>
                           <div class="control-group">
                               <label class="control-label"></label>
                               <div class="controls">
                                  Reaksi yang timbul <br/>
                                   <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'riwayattransfusi_reaksiygtimbul', array('class' => 'span3 disabledinputan', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                               </div>
                           </div>
                         </div>
                     </div>
                     <div class="control-group formGeriatriPenyakitTerdahulu">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT, 'riwayatpenyakitterdahulu', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'riwayatpenyakitterdahulu', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            <?php
                            echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array('class' => 'btn btn-primary', 'onclick' => "$('#dialogDiagnosa').dialog('open');$('#formDiagnosa').val('formGeriatriPenyakitTerdahulu');refreshGridDiagnosa();",
                                'id' => 'btnAddRiwayatPenyakitTerdahulu_geriatri', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modAsesmenawalkeperawatanT->getAttributeLabel('riwayatpenyakitterdahulu')))
                            ?>
                            <?php echo $form->error($modAsesmenawalkeperawatanT, 'riwayatpenyakitterdahulu'); ?>
                        </div>
                    </div>
                     <div class="control-group ">
                       <div class="controls">
                         <span style="color:black"><u>Ekonomi</u></span>
                       </div>
                     </div>
                     <div class="control-group">
                         <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'neonatus_pekerjaanortu', array('class'=>'control-label')) ?>
                         <div class="controls">
                             <?php echo $form->dropDownList($modAsesmenawalkeperawatanT,'neonatus_pekerjaanortu_dws', CHtml::listdata(PekerjaanM::model()->findAll('pekerjaan_aktif = true'),'pekerjaan_nama','pekerjaan_nama'),array('class'=>'span3', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                         </div>
                     </div>
                     <div class="control-group ">
                        <label class="control-label">Pembiayaan Kesehatan</label>
                        <div class="controls">
                            <?php echo CHtml::textField('carabayar_nama', (isset($modPendaftaran->carabayar)? $modPendaftaran->carabayar->carabayar_nama:""), array('class' => 'span3','readonly'=>true)); ?>
                        </div>
                    </div>

                 </div>
             </div>
         </div>
     </div>
</div>
