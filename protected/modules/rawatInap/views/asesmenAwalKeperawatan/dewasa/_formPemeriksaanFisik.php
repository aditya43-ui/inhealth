<div class="panel panel-primary panel-gradient">
   <div class="panel-heading">
       <div class="panel-title"><strong>Pemeriksaan Fisik (Body System)</strong></div>
   </div>
    <div class="panel-body">
      <br/>
      <div class="panel panel-darkk">
          <span class="group-title">
              B1 (Breathing)/ Pernapasan
          </span>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo $form->LabelEx($modAsesmenawalkeperawatanT,'b1_rr',array('class'=>'control-label','label'=>'RR'));?>
                    <div class="controls">
                      <?php echo $form->textField($modAsesmenawalkeperawatanT,'b1_rr',array('class'=>'span2 integer numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3));?>
                            /Menit
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->LabelEx($modAsesmenawalkeperawatanT,'b1_spo2',array('class'=>'control-label','label'=>'SpO2'));?>
                    <div class="controls">
                      <?php echo $form->textField($modAsesmenawalkeperawatanT,'b1_spo2',array('class'=>'span2 integer numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3));?>
                            %
                    </div>
                </div>
                <div class="control-group">
                   <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b1_iramapernapasan', array('class'=>'control-label','label'=>'Irama')) ?>
                   <div class="controls">
                       <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b1_iramapernapasan',array('Teratur'=>'Teratur','Tidak Teratur'=>'Tidak Teratur') , array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                   </div>
               </div>
               <div class="control-group">
                  <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b1_jenispernapasan', array('class'=>'control-label','label'=>'Jenis')) ?>
                  <div class="controls">
                    <?php
                         $lookupJenisPernapasan = array(0=>'Dispenia',1=>'Cheyne Stoke',2=>'Kusmaul',3=>'Lain-Lain');

                         if(count((array)$lookupJenisPernapasan) > 0){
                           $htmlJenisP = "";
                           foreach($lookupJenisPernapasan as $i => $look_jenis){
                             $isJenis = false;
                             if($i > 0){
                               $htmlJenisP .= "<br/>";
                             }

                             if(count((array)$modAsesmenawalkeperawatanT->b1_jenispernapasan) > 0){
                               $arrOriJenisPernapasan = json_decode($modAsesmenawalkeperawatanT->b1_jenispernapasan);
                               foreach ($arrOriJenisPernapasan as $oriPernapasan) {
                                 if($oriPernapasan == $look_jenis){
                                   $isJenis = true;
                                 }
                               }
                             }

                            $htmlJenisP .= CHtml::hiddenField('Jenispernapasan['.$i.'][jenis]',$look_jenis);
                             if($look_jenis == 'Lain-Lain'){
                               $htmlJenisP .= CHtml::checkBox('Jenispernapasan['.$i.'][isJenis]',$isJenis , array('class'=>'isJenis disabledinputan','onchange'=>'setJenisPernapasan_dws(this)')).' <label>'.$look_jenis.'</label>';
                               $htmlJenisP .= "<br/>".CHtml::activeTextField($modAsesmenawalkeperawatanT,'b1jenispernapasan_lainnya',array('class'=>'span3','disabled'=>true));
                             }else{
                               $htmlJenisP .= CHtml::checkBox('Jenispernapasan['.$i.'][isJenis]',$isJenis,array('class'=>'isJenis disabledinputan')).' <label>'.$look_jenis.'</label>';
                             }
                           }
                           echo $htmlJenisP;
                         }
                     ?>
                  </div>
              </div>
              <div class="control-group">
                 <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b1_polapernapasan', array('class'=>'control-label','label'=>'Pola')) ?>
                 <div class="controls">
                   <?php
                        $lookupPola = array(0=>'Cuping hidung',1=>'Thorakal',2=>'Abdominal');

                        if(count((array)$lookupPola) > 0){
                          $htmlPola = "";
                          foreach($lookupPola as $i => $look_pola){
                            $isPola = false;
                            if($i > 0){
                              $htmlPola .= "<br/>";
                            }

                            if(count((array)$modAsesmenawalkeperawatanT->b1_polapernapasan) > 0){
                              $arrOriPola = json_decode($modAsesmenawalkeperawatanT->b1_polapernapasan);
                              foreach ($arrOriPola as $oriPola) {
                                if($oriPola == $look_pola){
                                  $isPola = true;
                                }
                              }
                            }

                           $htmlPola .= CHtml::hiddenField('Polapernapasan['.$i.'][pola]',$look_pola);
                           $htmlPola .= CHtml::checkBox('Polapernapasan['.$i.'][isPola]',$isPola,array('class'=>'isPola disabledinputan')).' <label>'.$look_pola.'</label>';
                          }
                          echo $htmlPola;
                        }
                    ?>
                 </div>
            </div>
            <br>
            <div class="control-group">
                   <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b1_jalannapas', array('class'=>'control-label','label'=>'Jalan Napas')) ?>
                   <div class="controls">
                       <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b1_jalannapas',array('Paten'=>'Paten','Snoring'=>'Snoring','Gurgling'=>'Gurgling','Stridor'=>'Stridor') , array('class'=>'col-sm-5','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                   </div>
               </div>
          </div>
    
            <div class="col-sm-6">
              <div class="control-group">
                 <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b1_suaranafas', array('class'=>'control-label','label'=>'Suara Nafas')) ?>
                 <div class="controls">
                   <?php
                        $lookupSuaraNafas = array(0=>'Bronchial',1=>'Sesak',2=>'Vesikuler',3=>'Batuk',4=>'Wheezing',5=>'Sputum',6=>'Ronchi');

                        if(count((array)$lookupSuaraNafas) > 0){
                          $htmlSuaraNafas = "";
                          $indexSuara = 0;
                          foreach($lookupSuaraNafas as $i => $look_suaranafas){
                            $isSuara = false;

                            if($indexSuara == 2){
                              $htmlSuaraNafas .= "<br/>";
                              $indexSuara = 0;
                            }
                            $indexSuara++;
                            if(count((array)$modAsesmenawalkeperawatanT->b1_suaranafas) > 0){
                              $arrOriSuaraNafas = json_decode($modAsesmenawalkeperawatanT->b1_suaranafas);
                              foreach ($arrOriSuaraNafas as $oriSuaraNafas) {
                                if($oriSuaraNafas == $look_suaranafas){
                                  $isSuara = true;
                                }
                              }
                            }

                           $htmlSuaraNafas .= CHtml::hiddenField('Suaranafas['.$i.'][suaranafas]',$look_suaranafas);
                           $htmlSuaraNafas .= CHtml::checkBox('Suaranafas['.$i.'][isSuaranafas]',$isSuara,array('class'=>'isSuaranafas disabledinputan')).' <label>'.$look_suaranafas.'</label> &nbsp;&nbsp;';
                          }
                          echo $htmlSuaraNafas;
                        }
                    ?>
                 </div>
             </div>
              <div class="control-group">
                 <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b1_pernapasan', array('class'=>'control-label','label'=>'Pernafasan')) ?>
                 <div class="controls">
                   <?php
                        $lookupPernafasan = array(0=>'Normal adequate',1=>'Sesak cepat dan dangkal',2=>'Gasping',3=>'Tidak Bernafas');

                        if(count((array)$lookupPernafasan) > 0){
                          $htmlPernafasan = "";
                          $indexSuara = 0;
                          foreach($lookupPernafasan as $i => $look_pernafasan){
                            $isNafas = false;

                            if($indexSuara == 2){
                              $htmlPernafasan .= "";
                              $indexSuara = 0;
                            }
                            $indexSuara++;
                            if(count((array)$modAsesmenawalkeperawatanT->b1_pernapasan) > 0){
                              $arrOriPernapasan = json_decode($modAsesmenawalkeperawatanT->b1_pernapasan);
                              foreach ($arrOriPernapasan as $oriPernapasan) {
                                if($oriPernapasan == $look_pernafasan){
                                  $isNafas = true;
                                }
                              }
                            }

                           $htmlPernafasan .= CHtml::hiddenField('Pernapasan['.$i.'][pernapasan]',$look_pernafasan);
                           $htmlPernafasan .='&nbsp;&nbsp;'.CHtml::checkBox('Pernapasan['.$i.'][isPernapasan]',$isNafas,array('class'=>'isNafas disabledinputan')).' <label>'.$look_pernafasan.'</label> ';
                          }
                          echo $htmlPernafasan;
                        }
                    ?>
                 </div>
           
             <div class="control-group">
                <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b1_kesulitanbernafas', array('class'=>'control-label','label'=>'Kesulitan Bernafas')) ?>
                <div class="controls">
                    <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b1_kesulitanbernafas',array('Tidak'=>'Tidak','Ya'=>'Ya') , array('class'=>'b1_kesulitanbernafas','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'setKesulitanbernafas_dws()')); ?>
                </div>
            </div>
            <div class="control-group">
              <label class="control-label"></label>
               <div class="controls">
                 <div class="control-group ">
                     <?php echo $form->LabelEx($modAsesmenawalkeperawatanT,'b1_jmloksigenperliter',array('class'=>'control-label','label'=>'Memakai O2'));?>
                     <div class="controls">
                       <?php echo $form->textField($modAsesmenawalkeperawatanT,'b1_jmloksigenperliter',array('class'=>'span2 float disabledinputan', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3));?>
                          liter/menit
                     </div>
                 </div>
                 <div class="control-group">
                    <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b1_jenisterapioksigen', array('class'=>'control-label','label'=>'Dengan')) ?>
                    <div class="controls">
                        <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b1_jenisterapioksigen',array('Nasal Kanul'=>'Nasal Kanul','Sangkup'=>'Sangkup','Re-Breathing'=>'Re-Breathing') , array('class'=>'b1_jenisterapioksigen disabledinputan','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>

               </div>
           </div>
           <div class="control-group">
              <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b1_keluhanlain', array('class'=>'control-label','label'=>'Keluhan Lain')) ?>
              <div class="controls">
                  <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'b1_keluhanlain', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
              </div>
          </div>

          </div>
        </div>
      </div>
    </div>
    <br/>
    <div class="panel panel-darkk">
        <span class="group-title">
            B2 (Blood)/ Cardiovasculer
        </span>
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b2_td_systolic', array('class'=>'control-label','label'=>'Tensi')) ?>
                  <div class="controls">
                   <?php  echo $form->textField($modAsesmenawalkeperawatanT,'b2_td_systolic',array('class'=>'span1 integer numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3,  'style'=>'text-align: right;'));?> /
                   <?php echo $form->textField($modAsesmenawalkeperawatanT,'b2_td_diastolic',array('class'=>'span1 integer numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'style'=>'text-align: right;')); ?>mmHg
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b2_nadi', array('class'=>'control-label','label'=>'Nadi')) ?>
                  <div class="controls">
                          <?php echo $form->textField($modAsesmenawalkeperawatanT,'b2_nadi',array('class'=>'span2  integer numbersOnly', 'maxlength'=>3, 'onkeypress'=>"return $(this).focusNextInputField(event)"));?>
                   /Menit
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b2_denyutjantung', array('class'=>'control-label','label'=>'Irama Jantung')) ?>
                  <div class="controls">
                      <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'b2_denyutjantung', CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type'=>Params::LOOKUPTYPE_DENYUTJANTUNG),array('order'=>'lookup_name ASC')), 'lookup_value', 'lookup_name'), array('empty'=>'-- Pilih --')); ?>
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b2_akral', array('class'=>'control-label','label'=>'Akral')) ?>
                  <div class="controls">
                    <div class="radio inline">
                      <div class="form-inline">
                        <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b2_akral',array('Hangat'=>'Hangat','Dingin'=>'Dingin') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>' disabledinputan','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b2_crt', array('class'=>'control-label','label'=>'CRT')) ?>
                  <div class="controls">
                    <div class="radio inline">
                      <div class="form-inline">
                        <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b2_crt',array('< 3 Detik'=>'< 3 Detik','> 3 Detik'=>'> 3 Detik') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'disabledinputan','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b2_isnyerdada', array('class'=>'control-label','label'=>'Nyeri Dada')) ?>
                  <div class="controls">
                    <div class="radio inline">
                      <div class="form-inline">
                        <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b2_isnyerdada',array('Ya'=>'Ya','Tidak'=>'Tidak') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'disabledinputan','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b2_sirkulasinadi', array('class'=>'control-label','label'=>'Sirkulasi Nadi')) ?>
                  <div class="controls">
                    <div class="radio inline">
                      <div class="form-inline">
                        <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b2_sirkulasinadi',array('nadi kuat dan reguler'=>'nadi kuat dan reguler','nadi cepat dan lemah'=>'nadi cepat dan lemah','nadi tidak teraba'=>'nadi tidak teraba') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'disabledinputan','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                      </div>
                    </div>
                  </div>
              </div>
              
            </div>
            <div class="col-sm-6">
              <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b2_ispendarahan', array('class'=>'control-label','label'=>'Pendarahan')) ?>
                  <div class="controls">
                    <div class="radio inline">
                      <div class="form-inline">
                        <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b2_ispendarahan',array(1=>'Ya',0=>'Tidak') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'disabledinputan','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="control-group">
                 <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b2_isoedem', array('class'=>'control-label','label'=>'Oedem')) ?>
                 <div class="controls">
                     <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b2_isoedem',array(0=>"Tidak",1=>'Ya') , array('class'=>'b2_isoedem','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'setB2isoedem_dws()')); ?>
                 </div>
             </div>

             <div class="control-group">
               <label class="control-label"></label>
                <div class="controls">
                  <div class="control-group ">
                      <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b2_lokasioedem', array('class'=>'control-label','label'=>'Pada')) ?>
                      <div class="controls">
                              <?php echo $form->textField($modAsesmenawalkeperawatanT,'b2_lokasioedem',array('class'=>'span3 disabledinputan', 'onkeypress'=>"return $(this).focusNextInputField(event)"));?>
                      </div>
                  </div>
                </div>
            </div>
            <div class="control-group">
               <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b2_keluhanlain', array('class'=>'control-label','label'=>'Keluhan Lain')) ?>
               <div class="controls">
                   <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'b2_keluhanlain', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
               </div>
           </div>
          </div>
        </div>
      </div>
    </div>
    <br/>
    <div class="panel panel-darkk">
        <span class="group-title">
            B3 (Brain)/ Persarafan
        </span>
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="control-group ">
                 <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b3_kesadaran', array('class'=>'control-label','label'=>'Kesadaran')) ?>
                 <div class="controls">
                     <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b3_kesadaran',array('Alert'=>'Alert','Verbal'=>'Verbal','Pain'=>'Pain','Unresponsif'=>'Unresponsif'), array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'b3_kesadaran')); ?>
                 </div>
             </div>
             <div class="control-group">
               <label class="control-label">GCS</label>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b3_gcseye_nilai', array('class'=>'control-label','label'=>'E')) ?>
                <div class="controls">
                    <?php echo $form->textField($modAsesmenawalkeperawatanT,'b3_gcseye_nilai',array('class'=>'span2  integer numbersOnly', 'maxlength'=>3, 'onkeypress'=>"return $(this).focusNextInputField(event)"));?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b3_gcsverbal_nilai', array('class'=>'control-label','label'=>'V')) ?>
                <div class="controls">
                    <?php echo $form->textField($modAsesmenawalkeperawatanT,'b3_gcsverbal_nilai',array('class'=>'span2  integer numbersOnly', 'maxlength'=>3, 'onkeypress'=>"return $(this).focusNextInputField(event)"));?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b3_gcsmotoric_nilai', array('class'=>'control-label','label'=>'M')) ?>
                <div class="controls">
                    <?php echo $form->textField($modAsesmenawalkeperawatanT,'b3_gcsmotoric_nilai',array('class'=>'span2  integer numbersOnly', 'maxlength'=>3, 'onkeypress'=>"return $(this).focusNextInputField(event)"));?>
                </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b3_kesimetrisanpupil', array('class'=>'control-label','label'=>'Reflek Cahaya')) ?>
                <div class="controls">
                  <div class="radio inline">
                    <div class="form-inline">
                      Pupil &nbsp;&nbsp;&nbsp;<?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b3_kesimetrisanpupil',array('Isokor'=>'Isokor','Anisokor'=>'Anisokor') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'disabledinputan','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                      <br/>
                      Pupil Kanan &nbsp;&nbsp;&nbsp;<?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b3_ukuranreflek_pupilkanan',array('< 3 mm'=>'< 3 mm','> 3 mm'=>'> 3 mm') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'disabledinputan','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                      <br/>
                      Pupil Kiri &nbsp;&nbsp;&nbsp;<?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b3_ukuranreflek_pupilkiri',array('< 3 mm'=>'< 3 mm','> 3 mm'=>'> 3 mm') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'disabledinputan','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                    </div>
                  </div>
                </div>
            </div>
            <div class="control-group">
               <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b3_paresa', array('class'=>'control-label','label'=>'Paresa')) ?>
               <div class="controls">
                   <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'b3_paresa', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
               </div>
           </div>
           <div class="control-group">
              <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b3_kejang', array('class'=>'control-label','label'=>'Kejang')) ?>
              <div class="controls">
                <?php
                     $lookupKejang = array(0=>'Klonik',1=>'Umum',2=>'Tonik',3=>'Twiching',4=>'Koma');

                     if(count((array)$lookupKejang) > 0){
                       $htmlKejang = "";
                       $indexKejang = 0;
                       foreach($lookupKejang as $i => $look_kejang){
                         $isKejang = false;

                         if($indexKejang == 2){
                           $htmlKejang .= "<br/>";
                           $indexKejang = 0;
                         }
                         $indexKejang++;
                         if(count((array)$modAsesmenawalkeperawatanT->b3_kejang) > 0){
                           $arrOriKejang = json_decode($modAsesmenawalkeperawatanT->b3_kejang);
                           foreach ($arrOriKejang as $oriKejang) {
                             if($oriKejang == $look_kejang){
                               $isKejang = true;
                             }
                           }
                         }

                        $htmlKejang .= CHtml::hiddenField('B3Kejang['.$i.'][kejang]',$look_kejang);
                        $htmlKejang .= CHtml::checkBox('B3Kejang['.$i.'][isKejang]',$isKejang,array('class'=>'isKejang disabledinputan')).' <label>'.$look_kejang.'</label> &nbsp;&nbsp;';
                       }
                       echo $htmlKejang;
                     }
                 ?>
              </div>
          </div>
          <div class="control-group">
             <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b3_keluhanlain', array('class'=>'control-label','label'=>'Keluhan Lain')) ?>
             <div class="controls">
                 <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'b3_keluhanlain', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
             </div>
         </div>
        </div>
      </div>
    </div>
    </div>
    <br/>
    <div class="panel panel-darkk">
        <span class="group-title">
            B4 (Bleader)/ Perkemihan/ Eliminasi Urin
        </span>
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b4_bakfrekuensi', array('class'=>'control-label','label'=>'BAK')) ?>
                  <div class="controls">
                          <?php echo $form->textField($modAsesmenawalkeperawatanT,'b4_bakfrekuensi',array('class'=>'span2  integer numbersOnly', 'maxlength'=>3, 'onkeypress'=>"return $(this).focusNextInputField(event)"));?>
                   x / hari
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b4_bakwarnaurin', array('class'=>'control-label','label'=>'Warna Urin')) ?>
                  <div class="controls">
                      <?php echo $form->textField($modAsesmenawalkeperawatanT,'b4_bakwarnaurin',array('class'=>'span3', 'maxlength'=>20, 'onkeypress'=>"return $(this).focusNextInputField(event)"));?>
                  </div>
              </div>
              <div class="control-group ">
                 <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b4_isnyeritekankandungkemih', array('class'=>'control-label','label'=>'Nyeri Tekan Kandung Kemih')) ?>
                 <div class="controls">
                     <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b4_isnyeritekankandungkemih',array('Tidak'=>'Tidak','Ya'=>'Ya') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'b3_kesadaran')); ?>
                 </div>
             </div>
            </div>
            <div class="col-sm-6">
              <div class="control-group">
                 <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b4_gangguan', array('class'=>'control-label','label'=>'Pola')) ?>
                 <div class="controls">
                   <?php
                        $lookupGangguan = array(0=>'Anuri',1=>'Oliguria',2=>'Gross Hematuria');

                        if(count((array)$lookupGangguan) > 0){
                          $htmlGanguan = "";
                          foreach($lookupGangguan as $i => $look_gangguan){
                            $isGangguan = false;
                            if($i > 0){
                              $htmlGanguan .= "<br/>";
                            }

                            if(count((array)$modAsesmenawalkeperawatanT->b4_gangguan) > 0){
                              $arrOriGangguan = json_decode($modAsesmenawalkeperawatanT->b4_gangguan);
                              foreach ($arrOriGangguan as $oriGangguan) {
                                if($oriGangguan == $look_gangguan){
                                  $isGangguan = true;
                                }
                              }
                            }

                           $htmlGanguan .= CHtml::hiddenField('B4Gangguan['.$i.'][gangguan]',$look_gangguan);
                           $htmlGanguan .= CHtml::checkBox('B4Gangguan['.$i.'][isGangguan]',$isGangguan,array('class'=>'isGangguan disabledinputan')).' <label>'.$look_gangguan.'</label>';
                          }
                          echo $htmlGanguan;
                        }
                    ?>
                 </div>
             </div>
             <div class="control-group">
                <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b4_keluhanlain', array('class'=>'control-label','label'=>'Keluhan Lain')) ?>
                <div class="controls">
                    <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'b4_keluhanlain', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br/>
    <div class="panel panel-darkk">
        <span class="group-title">
            B5 (Bowel)/ Pencernaan/ Eliminasi Alvi
        </span>
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b5_statusnafasumakan', array('class'=>'control-label','label'=>'Nafsu Makan')) ?>
                  <div class="controls">
                    <div class="radio inline">
                      <div class="form-inline">
                        <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b5_statusnafasumakan',array('Baik'=>'Baik','Menurun'=>'Menurun') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="control-group ">
                 <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b5_mukosamulut', array('class'=>'control-label','label'=>'Mukosa')) ?>
                 <div class="controls">
                     <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b5_mukosamulut',array('Lembab'=>'Lembab','Kering'=>'Kering','Stomatitis'=>'Stomatitis') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'b5_mukosamulut')); ?>
                 </div>
             </div>
             <div class="control-group">
               <label class="control-label">Abdomen</label>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b5_abdomen_kesimetrisan', array('class'=>'control-label','label'=>'Kesimetrisan')) ?>
                <div class="controls">
                  <div class="radio inline">
                    <div class="form-inline">
                      <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b5_abdomen_kesimetrisan',array('Simetris'=>'Simetris','Asimetris'=>'Asimetris') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                    </div>
                  </div>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b5_abdomen_istegang', array('class'=>'control-label','label'=>'Tegang')) ?>
                <div class="controls">
                  <div class="radio inline">
                    <div class="form-inline">
                      <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b5_abdomen_istegang',array(0=>'Tidak',1=>'Ya') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                    </div>
                  </div>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b5_abdomen_isascites', array('class'=>'control-label','label'=>'Ascites')) ?>
                <div class="controls">
                  <div class="radio inline">
                    <div class="form-inline">
                      <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b5_abdomen_isascites',array(0=>'Tidak',1=>'Ya') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                    </div>
                  </div>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b5_abdomen_isnyeritekan', array('class'=>'control-label','label'=>'Nyeri Tekan')) ?>
                <div class="controls">
                  <div class="radio inline">
                    <div class="form-inline">
                      <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b5_abdomen_isnyeritekan',array(0=>'Tidak',1=>'Ya') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'b5_abdomen_isnyeritekan','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'),'onchange'=>'setB5Nyeritekan_dws()')); ?>
                    </div>
                  </div>
                </div>
            </div>
            <div class="control-group">
              <label class="control-label"></label>
               <div class="controls">
                 <div class="control-group ">
                     <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b5_abdomen_nyeritekanlokasi', array('class'=>'control-label','label'=>'Lokasi')) ?>
                     <div class="controls">
                        <?php echo $form->textField($modAsesmenawalkeperawatanT,'b5_abdomen_nyeritekanlokasi',array('class'=>'span3 disabledinputan', 'onkeypress'=>"return $(this).focusNextInputField(event)"));?>
                     </div>
                 </div>
               </div>
           </div>

          </div>
          <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b5_babfrekuensi', array('class'=>'control-label','label'=>'BAB')) ?>
                <div class="controls">
                        <?php echo $form->textField($modAsesmenawalkeperawatanT,'b5_babfrekuensi',array('class'=>'span2  integer numbersOnly', 'maxlength'=>3, 'onkeypress'=>"return $(this).focusNextInputField(event)"));?>
                 x / hari
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b5_warnafeces', array('class'=>'control-label','label'=>'Warna')) ?>
                <div class="controls">
                    <?php echo $form->textField($modAsesmenawalkeperawatanT,'b5_warnafeces',array('class'=>'span3', 'maxlength'=>50, 'onkeypress'=>"return $(this).focusNextInputField(event)"));?>
                </div>
            </div>
            <div class="control-group">
               <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b5_keluhanlain', array('class'=>'control-label','label'=>'Keluhan Lain')) ?>
               <div class="controls">
                   <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'b5_keluhanlain', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
               </div>
           </div>
          </div>
        </div>
      </div>
    </div>
    <br/>
    <div class="panel panel-darkk">
        <span class="group-title">
            B6 (Bone)/ Tulang, Otot dan Itegumen
        </span>
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="control-group ">
                  <?php echo $form->LabelEx($modAsesmenawalkeperawatanT,'b6_suhutubuh',array('class'=>'control-label','label'=>'Suhu Tubuh'));?>
                  <div class="controls">
                          <?php echo $form->textField($modAsesmenawalkeperawatanT,'b6_suhutubuh',array('class'=>'span2 float', 'maxlength'=>5, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align:right;'));?>
                   &#176; C
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b6_caraukursuhutubuh', array('class'=>'control-label','label'=>'Kesimetrisan')) ?>
                  <div class="controls">
                    <div class="radio inline">
                      <div class="form-inline">
                        <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b6_caraukursuhutubuh',array('Axilla'=>'Axilla','Rektal'=>'Rektal','Oral'=>'Oral') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b6_pergerakan', array('class'=>'control-label','label'=>'Pergerakan')) ?>
                  <div class="controls">
                    <div class="radio inline">
                      <div class="form-inline">
                        <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b6_pergerakan',array('Bebas'=>'Bebas','Terbatas'=>'Terbatas') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b6_isfraktur', array('class'=>'control-label','label'=>'Fraktur')) ?>
                  <div class="controls">
                      <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b6_isfraktur',array('Tidak'=>'Tidak','Ya'=>'Ya') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'b6_isfraktur','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'),'onchange'=>'setB6Fraktur_dws()')); ?>
                  </div>
              </div>
              <div class="control-group">
                <label class="control-label"></label>
                 <div class="controls">
                   <div class="control-group ">
                       <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b6_jenisfraktur', array('class'=>'control-label','label'=>'Jenis Fraktur')) ?>
                       <div class="controls">
                         <div class="radio inline">
                           <div class="form-inline">
                             <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b6_jenisfraktur',array('Terbuka'=>'Terbuka','Tertutup'=>'Tertutup') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'b6_jenisfraktur disabledinputan','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                           </div>
                         </div>
                       </div>
                   </div>
                   <div class="control-group ">
                       <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b6_lokasifraktur', array('class'=>'control-label','label'=>'Lokasi Fraktur')) ?>
                       <div class="controls">
                          <?php echo $form->textField($modAsesmenawalkeperawatanT,'b6_lokasifraktur',array('class'=>'span3 disabledinputan', 'onkeypress'=>"return $(this).focusNextInputField(event)"));?>
                       </div>
                   </div>
                 </div>
             </div>
             <div class="control-group">
                <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b6_warnakulit', array('class'=>'control-label','label'=>'Warna Kulit')) ?>
                <div class="controls">
                  <?php
                       $lookupWarnaKulit = LookupM::model()->findAll("lookup_type = 'asesmen_warnakulit' order by lookup_urutan ASC");

                       if(count((array)$lookupWarnaKulit) > 0){
                         $htmlWarnaKulit = "";
                         $indexWarnaKulit = 0;
                         foreach($lookupWarnaKulit as $i => $look_warnakulit){
                           $isWarnaKulit = false;

                           if($indexWarnaKulit == 2){
                             $htmlWarnaKulit .= "<br/>";
                             $indexWarnaKulit = 0;
                           }
                           $indexWarnaKulit++;
                           if(count((array)$modAsesmenawalkeperawatanT->b6_warnakulit) > 0){
                             $arrOriWarnaKulit = json_decode($modAsesmenawalkeperawatanT->b6_warnakulit);
                             foreach ($arrOriWarnaKulit as $oriWarnaKulit) {
                               if($oriWarnaKulit == $look_warnakulit->lookup_value){
                                 $isWarnaKulit = true;
                               }
                             }
                           }

                          $htmlWarnaKulit .= CHtml::hiddenField('B6Warnakulit['.$i.'][warnakulit]',$look_warnakulit->lookup_value);
                          $htmlWarnaKulit .= CHtml::checkBox('B6Warnakulit['.$i.'][iswarnakulit]',$isWarnaKulit,array('class'=>'iswarnakulit disabledinputan')).' <label>'.$look_warnakulit->lookup_name.'</label> &nbsp;&nbsp;';
                         }
                         echo $htmlWarnaKulit;
                       }
                   ?>
                </div>
            </div>
            <div class="control-group">
               <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b6_otot', array('class'=>'control-label','label'=>'Otot')) ?>
               <div class="controls">
                 <?php
                      $lookupOtot = array(0=>'Artopi',1=>'Hipertropi',2=>'Kontraktur');

                      if(count((array)$lookupOtot) > 0){
                        $htmlOtot = "";
                        foreach($lookupOtot as $i => $look_otot){
                          $isOtot = false;
                          if($i > 0){
                            $htmlOtot .= "<br/>";
                          }

                          if(count((array)$modAsesmenawalkeperawatanT->b6_otot) > 0){
                            $arrOriOtot = json_decode($modAsesmenawalkeperawatanT->b6_otot);
                            foreach ($arrOriOtot as $oriOtot) {
                              if($oriOtot == $look_otot){
                                $isOtot = true;
                              }
                            }
                          }

                         $htmlOtot .= CHtml::hiddenField('B6Otot['.$i.'][otot]',$look_otot);
                         $htmlOtot .= CHtml::checkBox('B6Otot['.$i.'][isOtot]',$isOtot,array('class'=>'isOtot disabledinputan')).' <label>'.$look_otot.'</label>';
                        }
                        echo $htmlOtot;
                      }
                  ?>
               </div>
           </div>

          </div>
          <div class="col-sm-6">
            <div class="control-group">
               <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b6_turgorkulit', array('class'=>'control-label','label'=>'Turgor Kulit')) ?>
               <div class="controls">
                   <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'b6_turgorkulit', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'maxlength'=>200)); ?>
               </div>
           </div>
           <div class="control-group">
              <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b6_lokasioedema', array('class'=>'control-label','label'=>'Oedema Pada')) ?>
              <div class="controls">
                  <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'b6_lokasioedema', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'maxlength'=>100)); ?>
              </div>
          </div>
          <div class="control-group ">
              <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b6_berkeringatbanyak', array('class'=>'control-label','label'=>'Berkeringet Banyak')) ?>
              <div class="controls">
                 <?php echo $form->textField($modAsesmenawalkeperawatanT,'b6_berkeringatbanyak',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'maxlength'=>100));?>
              </div>
          </div>
          <div class="control-group ">
              <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b6_isresikodekubitus', array('class'=>'control-label','label'=>'Resiko Dekubitus')) ?>
              <div class="controls">
                  <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b6_isresikodekubitus',array(0=>'Tidak',1=>'Ya') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'b6_isresikodekubitus','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'),'onchange'=>'setB6ResikoDekubitus_dws()')); ?>
              </div>
          </div>
          <div class="control-group">
            <label class="control-label"></label>
             <div class="controls">
               <div class="control-group ">
                   <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b6_skorbraden', array('class'=>'control-label','label'=>'(Pengisian form pengkajian risiko dekubitus) Skor Braden')) ?>
                   <div class="controls">
                      <?php echo $form->textField($modAsesmenawalkeperawatanT,'b6_skorbraden',array('class'=>'span1 integer numbersOnly disabledinputan', 'onkeypress'=>"return $(this).focusNextInputField(event)"));?>
                   </div>
               </div>
             </div>
         </div>
         <div class="control-group ">
             <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b6_isluka', array('class'=>'control-label','label'=>'Luka')) ?>
             <div class="controls">
                 <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'b6_isluka',array(0=>'Tidak',1=>'Ya') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'b6_isluka','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'),'onchange'=>'setB6Luka_dws()')); ?>
             </div>
         </div>
         <div class="control-group">
           <label class="control-label"></label>
            <div class="controls">
              <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b6_lokasiluka', array('class'=>'control-label','label'=>'Lokasi')) ?>
                  <div class="controls">
                     <?php echo $form->textField($modAsesmenawalkeperawatanT,'b6_lokasiluka',array('class'=>'span3 disabledinputan', 'onkeypress'=>"return $(this).focusNextInputField(event)",'maxlength'=>100));?>
                  </div>
              </div>
            </div>
        </div>
        <div class="control-group">
           <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'b6_keluhanlain', array('class'=>'control-label','label'=>'Keluhan Lain')) ?>
           <div class="controls">
               <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'b6_keluhanlain', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
           </div>
       </div>
      </div>
    </div>
  </div>
  </div>
    <br/>
    <div class="panel panel-darkk">
        <span class="group-title">
            Psikososial Spiritual
        </span>
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'istaatberibadah', array('class'=>'control-label','label'=>'Taat Beribadah')) ?>
                  <div class="controls">
                    <div class="radio inline">
                      <div class="form-inline">
                        <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'istaatberibadah',array(0=>'Tidak',1=>'Ya') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'orangterdekat', array('class'=>'control-label','label'=>'Orang Terdekat')) ?>
                  <div class="controls">
                     <?php echo $form->textField($modAsesmenawalkeperawatanT,'orangterdekat',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'maxlength'=>100));?>
                  </div>
              </div>
              <div class="control-group ">
                 <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'perasaansaatini', array('class'=>'control-label','label'=>'Perasaan saat ini')) ?>
                 <div class="controls">
                     <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'perasaansaatini',array('Cemas'=>'Cemas','Tenang'=>'Tenang') , array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                 </div>
             </div>
            </div>
            <div class="control-group ">
                 <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'psikososialspiritual_keadaanumum', array('class'=>'control-label','label'=>'Keadaan Umum')) ?>
                 <div class="controls">
                     <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'psikososialspiritual_keadaanumum',array('Cukup dan kooperatif'=>'Cukup dan kooperatif','gelisah tidak kooperatif'=>'gelisah tidak kooperatif','lemah dan letargic' => 'lemah dan letargic','tidak sadar'=>'tidak sadar') , array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                 </div>
             </div>
            </div>
            <div class="col-sm-6">
              <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'gangguanorientasi_terhadap', array('class'=>'control-label','label'=>'Gangguan Orientasi Terhadap')) ?>
                  <div class="controls">
                     <?php echo $form->textField($modAsesmenawalkeperawatanT,'gangguanorientasi_terhadap',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'maxlength'=>200));?>
                  </div>
              </div>
              <div class="control-group">
                 <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'psikososialspriritual_keluhanlain', array('class'=>'control-label','label'=>'Keluhan Lain')) ?>
                 <div class="controls">
                     <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'psikososialspriritual_keluhanlain', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                 </div>
             </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
