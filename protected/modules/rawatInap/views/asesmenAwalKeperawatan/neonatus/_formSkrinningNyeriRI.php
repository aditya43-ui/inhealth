<div class="row-fluid">
     <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Skrinning Nyeri</strong></div>
        </div>
         <div class="panel-body">
           <div class="row">
             <div class="col-sm-12">
               <div class="control-group ">
                   <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'kesadaranpasien_pengkajiannyeri', array('class'=>'control-label','label'=>'Kesadaran Pasien yang Dikaji')) ?>
                   <div class="controls">
                     <div class="radio inline">
                       <div class="form-inline">
                         <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'kesadaranpasien_pengkajiannyeri',array('Sadar'=>'Sadar','Tidak Sadar'=>'Tidak Sadar'), array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'kesadaranpasien_pengkajiannyeri','onclick'=>'setKesadaranNyeri_neonatus(this);','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                       </div>
                     </div>
                   </div>
               </div>
             </div>
           </div>

           <div class="panel panel-success panel_nyeri panelsadar" id="nyeri_dewasa" >
              <div class="panel-heading">
                  <div class="panel-title"><?php echo $form->radioButton($modAsesmenawalkeperawatanT, 'is_keluhannyeri_dewasa', array('onclick' => 'pilihNyeri_neonatus(this)', 'value' => 1, 'class'=>'pilih_nyeri', 'uncheckValue'=>null)); ?> Asesmen Nyeri Anak > 3 Tahun</div>
              </div>
              <div class="panel-body" >

                  <h2 style="text-align:center;">Intensitas "WONG BAKER FACE SCALE"</h2>
                  <br/>
                  <?php
                  echo $this->renderPartial($this->path_view . 'neonatus/_formAsesmenDewasa', array(
                      'form' => $form,
                      'model' => $modAsesmenawalkeperawatanT
                          ), true);
                  ?>


              </div>
          </div>

          <div class="panel panel-success panel_nyeri panelsadar" id="nyeri_anak" >
              <div class="panel-heading">
                  <div class="panel-title"><?php echo $form->radioButton($modAsesmenawalkeperawatanT, 'is_keluhannyeri_dewasa', array('onclick' => 'pilihNyeri_neonatus(this)', 'value' => 0, 'class'=>'pilih_nyeri', 'uncheckValue'=>null)); ?> Asesmen Nyeri Anak < 3 Tahun</div>
              </div>
              <div class="panel-body">

                  <?php

                  echo $this->renderPartial($this->path_view . 'neonatus/_formAsesmenAnak', array(
                      'form' => $form,
                      'model' => $modAsesmenawalkeperawatanT,
                      'dataFlaCcs' => $dataFlaCcs,
                      'getFlaCcs' => $getFlaCcs,
                      'modNyeriAnakDet'=>$modSkrinningnyerianakdetT
                          ), true);
                  ?>


              </div>
          </div>

          <div class="panel panel-success panel_nyeri panelsadar" id="nyeri_cries" >
              <div class="panel-heading">
                  <div class="panel-title"><?php echo $form->radioButton($modAsesmenawalkeperawatanT, 'is_keluhannyeri_dewasa', array('onclick' => 'pilihNyeri_neonatus(this)', 'value' => 2, 'class'=>'pilih_nyeri', 'uncheckValue'=>null)); ?> Asesmen Nyeri Metode CRIES</div>
              </div>
              <div class="panel-body">

                <table class="items table table-bordered table-striped table-condensed" width="100%" id="tblSkrining">
                    <thead>
                        <tr>
                            <th width="50px">No</th>
                            <th>Penilaian</th>
                            <th width="250px">Nilai 0</th>
                            <th width="250px">Nilai 1</th>
                            <th width="250px">Nilai 2</th>
                            <th width="80px">Nilai</th>
                       </tr>
                     </thead>
                     <tbody>
                         <tr>
                           <td><label>1</label></td>
                           <td style="font-style: italic;"><label>Crying</label></td>
                           <td>
                             <?php echo CHtml::activeRadioButton($modAsesmenawalkeperawatanT,'isneonatus_cries_crying',array('class'=>'isneonatus_cries_crying','value'=>'0','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesCrying(this)','labelradio'=>"Tidak ada tangisan/ tangisan tidak melengking")); ?>
                             <label>Tidak ada tangisan/ tangisan tidak melengking</label>
                           </td>
                           <td>
                             <?php echo CHtml::activeRadioButton($modAsesmenawalkeperawatanT,'isneonatus_cries_crying',array('class'=>'isneonatus_cries_crying','value'=>'1','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesCrying(this)','labelradio'=>"Tangisan melengking tetapi bayi mudah dihibur")); ?>
                             <label>Tangisan melengking tetapi bayi mudah dihibur</label>
                           </td>
                           <td>
                             <?php echo CHtml::activeRadioButton($modAsesmenawalkeperawatanT,'isneonatus_cries_crying',array('class'=>'isneonatus_cries_crying','value'=>'2','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesCrying(this)','labelradio'=>"Tangisan melengking tetapi bayi tidak mudah dihibur")); ?>
                             <label>Tangisan melengking tetapi bayi tidak mudah dihibur</label>
                           </td>
                           <td>
                             <?php echo CHtml::activeHiddenField($modAsesmenawalkeperawatanT,'neonatus_cries_cryingket') ?>
                             <?php echo CHtml::activeTextField($modAsesmenawalkeperawatanT,'neonatus_cries_cryingnilai', array('class'=>'span1 totalcries','readonly'=>true)); ?>
                           </td>
                         </tr>
                         <tr>
                           <td><label>2</label></td>
                           <td style="font-style: italic;"><label>Requires</label></td>
                           <td>
                             <?php echo CHtml::activeRadioButton($modAsesmenawalkeperawatanT,'isneonatus_cries_requires',array('class'=>'isneonatus_cries_requires','value'=>'0','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesRequires(this)','labelradio'=>"Tidak perlu oksigen")); ?>
                             <label>Tidak perlu oksigen</label>
                           </td>
                           <td>
                             <?php echo CHtml::activeRadioButton($modAsesmenawalkeperawatanT,'isneonatus_cries_requires',array('class'=>'isneonatus_cries_requires','value'=>'1','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesRequires(this)','labelradio'=>"perlu oksigen ≤ 30%")); ?>
                             <label>perlu oksigen ≤ 30%</label>
                           </td>
                           <td>
                             <?php echo CHtml::activeRadioButton($modAsesmenawalkeperawatanT,'isneonatus_cries_requires',array('class'=>'isneonatus_cries_requires','value'=>'2','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesRequires(this)','labelradio'=>"perlu oksigen ≥ 30%")); ?>
                             <label>perlu oksigen ≥ 30%</label>
                           </td>
                           <td>
                             <?php echo CHtml::activeHiddenField($modAsesmenawalkeperawatanT,'neonatus_cries_requiresket') ?>
                             <?php echo CHtml::activeTextField($modAsesmenawalkeperawatanT,'neonatus_cries_requiresnilai', array('class'=>'span1 totalcries','readonly'=>true)); ?>
                           </td>
                         </tr>
                         <tr>
                           <td><label>3</label></td>
                           <td style="font-style: italic;"><label>Increased</label></td>
                           <td>
                             <?php echo CHtml::activeRadioButton($modAsesmenawalkeperawatanT,'isneonatus_cries_increased',array('class'=>'isneonatus_cries_increased','value'=>'0','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesIncreased(this)','labelradio'=>"Detak jantung dan tekanan darah tidak berubah atau kurang dari nilai base line")); ?>
                             <label>Detak jantung dan tekanan darah tidak berubah atau kurang dari nilai base line</label>
                           </td>
                           <td>
                             <?php echo CHtml::activeRadioButton($modAsesmenawalkeperawatanT,'isneonatus_cries_increased',array('class'=>'isneonatus_cries_increased','value'=>'1','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesIncreased(this)','labelradio'=>"Detak jantung atau tekanan darah meningkat, tetapi peningkatan ≤ 20%")); ?>
                             <label>Detak jantung atau tekanan darah meningkat, tetapi peningkatan ≤ 20%</label>
                           </td>
                           <td>
                             <?php echo CHtml::activeRadioButton($modAsesmenawalkeperawatanT,'isneonatus_cries_increased',array('class'=>'isneonatus_cries_increased','value'=>'2','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesIncreased(this)','labelradio'=>"Detak jantung atau tekanan darah meningkat ≥ 20% dari nilai base line")); ?>
                             <label>Detak jantung atau tekanan darah meningkat ≥ 20% dari nilai base line</label>
                           </td>
                           <td>
                             <?php echo CHtml::activeHiddenField($modAsesmenawalkeperawatanT,'neonatus_cries_increasedket') ?>
                             <?php echo CHtml::activeTextField($modAsesmenawalkeperawatanT,'neonatus_cries_increasednilai', array('class'=>'span1 totalcries','readonly'=>true)); ?>
                           </td>
                         </tr>
                         <tr>
                           <td><label>4</label></td>
                           <td style="font-style: italic;"><label>Expression</label></td>
                           <td>
                             <?php echo CHtml::activeRadioButton($modAsesmenawalkeperawatanT,'isneonatus_cries_expression',array('class'=>'isneonatus_cries_expression','value'=>'0','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesExpression(this)','labelradio'=>"Tidak ada seringai")); ?>
                             <label>Tidak ada seringai</label>
                           </td>
                           <td>
                             <?php echo CHtml::activeRadioButton($modAsesmenawalkeperawatanT,'isneonatus_cries_expression',array('class'=>'isneonatus_cries_expression','value'=>'1','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesExpression(this)','labelradio'=>"Seringai ada")); ?>
                             <label>Seringai ada</label>
                           </td>
                           <td>
                             <?php echo CHtml::activeRadioButton($modAsesmenawalkeperawatanT,'isneonatus_cries_expression',array('class'=>'isneonatus_cries_expression','value'=>'2','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesExpression(this)','labelradio'=>"Seringai ada dan tidak ada suara tangisan dengkur")); ?>
                             <label>Seringai ada dan tidak ada suara tangisan dengkur</label>
                           </td>
                           <td>
                             <?php echo CHtml::activeHiddenField($modAsesmenawalkeperawatanT,'neonatus_cries_expressionket') ?>
                             <?php echo CHtml::activeTextField($modAsesmenawalkeperawatanT,'neonatus_cries_expressionnilai', array('class'=>'span1 totalcries','readonly'=>true)); ?>
                           </td>
                         </tr>
                         <tr>
                           <td><label>5</label></td>
                           <td style="font-style: italic;"><label>Sleepless</label></td>
                           <td>
                             <?php echo CHtml::activeRadioButton($modAsesmenawalkeperawatanT,'isneonatus_cries_sleepless',array('class'=>'isneonatus_cries_sleepless','value'=>'0','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesSleepless(this)','labelradio'=>"Bayi terus menerus tidur")); ?>
                             <label>Bayi terus menerus tidur</label>
                           </td>
                           <td>
                             <?php echo CHtml::activeRadioButton($modAsesmenawalkeperawatanT,'isneonatus_cries_sleepless',array('class'=>'isneonatus_cries_sleepless','value'=>'1','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesSleepless(this)','labelradio'=>"Bayi terbangung pada interval berulang")); ?>
                             <label>Bayi terbangung pada interval berulang</label>
                           </td>
                           <td>
                             <?php echo CHtml::activeRadioButton($modAsesmenawalkeperawatanT,'isneonatus_cries_sleepless',array('class'=>'isneonatus_cries_sleepless','value'=>'2','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesSleepless(this)','labelradio'=>"Bayi terjaga, terbangun secara terus menerus")); ?>
                             <label>Bayi terjaga, terbangun secara terus menerus</label>
                           </td>
                           <td>
                             <?php echo CHtml::activeHiddenField($modAsesmenawalkeperawatanT,'neonatus_cries_sleeplessket') ?>
                             <?php echo CHtml::activeTextField($modAsesmenawalkeperawatanT,'neonatus_cries_sleeplessnilai', array('class'=>'span1 totalcries','readonly'=>true)); ?>
                           </td>
                         </tr>
                     </tbody>
                     <tfoot>
                       <tr>
                         <td colspan="5"><label>Total Nilai</label></td>
                         <td>
                           <?php echo CHtml::activeTextField($modAsesmenawalkeperawatanT,'neonatus_cries_totalnilai', array('class'=>'span1','readonly'=>true)); ?>
                         </td>
                       </tr>
                     </tfoot>
                 </table>

              </div>
          </div>




            <div class="panel panel-primary panel-default panelsadar">
              <div class="panel-heading">
                  <div class="panel-title"><strong>Penilaian Nyeri</strong></div>
              </div>
              <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                      <div class="control-group">
                          <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'isadakeluhannyeri', array('class'=>'control-label','label'=>'Nyeri')) ?>
                          <div class="controls">
                              <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'isadakeluhannyeri', array('Tidak'=>'Tidak','Ya'=>'Ya'), array('class'=>'isadakeluhannyeri','onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>'setAdaNyeri_neonatus();')); ?>
                          </div>
                      </div>
                      <div class="control-group">
                          <?php echo CHtml::label('','', array('class'=>'control-label')) ?>
                          <div class="controls">
                            <div class="control-group">
                                <?php echo CHtml::label('Jenis','', array('class'=>'control-label','style'=>'width:60px;')) ?>
                                <div class="controls">
                                    <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'jenisnyeri', array('Akut'=>'Akut','Kronis'=>'Kronis'), array('class'=>'jenisnyeri disabledinputan','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>
                          </div>
                      </div>

                    </div>
                    <div class="col-sm-6">
                      <div class="control-group ">
                          <?php echo $form->LabelEx($modAsesmenawalkeperawatanT,'deskripsinyeri_lokasiskalanyeri',array('class'=>'control-label'));?>
                          <div class="controls">
                              <?php echo $form->textField($modAsesmenawalkeperawatanT,'deskripsinyeri_lokasiskalanyeri',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                          </div>
                      </div>
                    </div>
                </div>
              </div>
            </div>
              <div class="panel panel-primary panel-default panelsadar">
                <div class="panel-heading">
                    <div class="panel-title"><strong>Deskripsi Nyeri</strong></div>
                </div>
                <div class="panel-body">
                    <div class="row-fluid">
                        <div class="col-md-6">
                          <div class="control-group ">
                  					<?php echo $form->labelEx($modAsesmenawalkeperawatanT, 'deskripsinyeri_onset', array('class' => 'control-label','label'=>'Onset')) ?>
                  					<div class="controls">
                  					<?php echo $form->textField($modAsesmenawalkeperawatanT, 'deskripsinyeri_onset', array('class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", "maxlength"=>2)); ?>
                  					<?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'deskripsinyeri_onsetsatuan', array('Hari'=>'Hari', 'Minggu'=>'Minggu', 'Bulan'=>'Bulan', 'Tahun'=>'Tahun'), array('class'=>'span2', 'empty'=>'-- Pilih --')); ?>
                  					</div>
                  				</div>
                          <div class="control-group ">
                             <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'deskripsinyeri_penyebabtimbul',array('class'=>'control-label','label'=>'Pencetus'));?>
                             <div class="controls">
                                 <?php echo $form->textField($modAsesmenawalkeperawatanT,'deskripsinyeri_penyebabtimbul',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                             </div>
                         </div>
                         <div class="control-group ">
                            <?php echo CHtml::label('Kualitas','', array('class'=>'control-label')) ?>
                            <div class="controls">
                              <?php
                                   $lookupKualitas = LookupM::model()->findAll("lookup_type = 'kualitasnyeri'");

                                   if(count((array)$lookupKualitas) >0 ){
                                     $htmlKualitas = "";
                                     foreach($lookupKualitas as $i => $look_risiko){
                                       if($i > 0){
                                         $htmlKualitas .= "<br/>";
                                       }
                                      $htmlKualitas .= CHtml::hiddenField('KualitasNyeri['.$i.'][nama]',$look_risiko->lookup_value);
                                       if($look_risiko->lookup_value == 'Lainnya'){
                                         $htmlKualitas .= CHtml::checkBox('KualitasNyeri['.$i.'][isKualitas]',false , array('datavalue'=>$look_risiko->lookup_value,'class'=>'kualitasnyeri disabledinputan','onchange'=>'setKualitasNyeri_neonatus()')).' <label>'.$look_risiko->lookup_name.'</label>';
                                         $htmlKualitas .= "<br/>".CHtml::activeTextField($modAsesmenawalkeperawatanT,'kualitasnyeri_lainnya',array('class'=>'span3'));
                                       }else{
                                         $htmlKualitas .= CHtml::checkBox('KualitasNyeri['.$i.'][isKualitas]',false,array('datavalue'=>$look_risiko->lookup_value,'class'=>'kualitasnyeri disabledinputan')).' <label>'.$look_risiko->lookup_name.'</label>';
                                       }
                                     }
                                     echo $htmlKualitas;
                                   }
                               ?>
                            </div>
                        </div>


                            <div class="control-group ">
                                <?php echo $form->LabelEx($modAsesmenawalkeperawatanT,'deskripsinyeri_karakteristik',array('class'=>'control-label'));?>
                                <div class="controls">
                                    <?php echo $form->textField($modAsesmenawalkeperawatanT,'deskripsinyeri_karakteristik',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                                </div>
                            </div>

                            <div class="control-group ">
                                <?php echo $form->LabelEx($modAsesmenawalkeperawatanT,'deskripsinyeri_durasinyeri',array('class'=>'control-label'));?>
                                <div class="controls">
                                    <?php echo $form->textField($modAsesmenawalkeperawatanT,'deskripsinyeri_durasinyeri',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <table width="100%">
                                <tr>
                                    <td class="fontColor" valign="top">
                                        Menjalar
                                    </td>
                                    <td colspan="3">
                                        <div class="controls">
                                            <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'deskripsinyeri_ismenjalar',array(0=>'Tidak',1=>'Ya') , array('class'=>'deskripsinyeri_ismenjalar','onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'changeDeskripsinyeri_ismenjalar_neonatus();')); ?>
                                       </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td valign="top" class="fontColor" width="100px">
                                        Lokasi Penjalaran
                                    </td>
                                    <td>
                                        <div class="controls">
                                            <?php echo  $form->textField($modAsesmenawalkeperawatanT,'deskripsinyeri_lokasipenjalaran', array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                            </table>
                            <div class="control-group">
                                <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'tingkatannyeri', array('class'=>'control-label','label'=>'Tingkatan')) ?>
                                <div class="controls">
                                    <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'tingkatannyeri', array('Ringan'=>'Ringan','Sedang'=>'Sedang','Berat'=>'Berat'), array('class'=>'tingkatannyeri','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>
                            <div class="control-group ">
                               <?php echo CHtml::label('Kualitas','', array('class'=>'control-label')) ?>
                               <div class="controls">
                                 <?php
                                      $lookupFrekuensi = LookupM::model()->findAll("lookup_type = 'frekuensinyeri'");

                                      if(count((array)$lookupFrekuensi) >0 ){
                                        $htmlFrekuensi = "";
                                        foreach($lookupFrekuensi as $i => $look_risiko){
                                          if($i > 0){
                                            $htmlFrekuensi .= "<br/>";
                                          }
                                         $htmlFrekuensi .= CHtml::hiddenField('FrekuensiNyeri['.$i.'][nama]',$look_risiko->lookup_value);
                                          if($look_risiko->lookup_value == 'Lainnya'){
                                            $htmlFrekuensi .= CHtml::checkBox('FrekuensiNyeri['.$i.'][isFrekuensi]',false , array('datavalue'=>$look_risiko->lookup_value,'class'=>'frekuensinyeri','onchange'=>'setFrekuensiNyeri_neonatus()')).' <label>'.$look_risiko->lookup_name.'</label>';
                                            $htmlFrekuensi .= "<br/>".CHtml::activeTextField($modAsesmenawalkeperawatanT,'deskripsinyeri_frekuensinyerilainnya',array('class'=>'span3'));
                                          }else{
                                            $htmlFrekuensi .= CHtml::checkBox('FrekuensiNyeri['.$i.'][isFrekuensi]',false,array('datavalue'=>$look_risiko->lookup_value,'class'=>'frekuensinyeri')).' <label>'.$look_risiko->lookup_name.'</label>';
                                          }
                                        }
                                        echo $htmlFrekuensi;
                                      }
                                  ?>
                               </div>
                           </div>

                            <div class="control-group ">
                                <label class="control-label">Nyeri Hilang Dengan</label>
                               <div class="controls">
                                   <label class="checkbox inline">
                                       <?php echo $form->checkboxRow($modAsesmenawalkeperawatanT,'isnyerihilangdgn_minumobat',array()); ?>
                                       <?php echo $form->checkboxRow($modAsesmenawalkeperawatanT,'isnyerihilangdgn_berubahposisi',array()); ?>
                                       <?php echo $form->checkboxRow($modAsesmenawalkeperawatanT,'isnyerihilangdgn_istirahat',array()); ?>
                                       <?php echo $form->checkboxRow($modAsesmenawalkeperawatanT,'isnyerihilangdgn_dengarmusik',array()); ?>
                                       <div class="form-inline">
                                           <?php echo $form->checkboxRow($modAsesmenawalkeperawatanT,'isnyerihilangdgn_lainlain',array('onChange'=>'changeNyeriHilangLain_neonatus();')); ?>
                                           <?php echo  $form->textField($modAsesmenawalkeperawatanT,'nyerihilangdgn_lainlainjenis', array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
                                       </div>
                                   </label>
                               </div>
                           </div>
                        </div>
                    </div>
                </div>
              </div>

              <div class="panel panel-primary panel-default paneltidaksadar">
                <div class="panel-heading">
                    <div class="panel-title"><strong>Behaviour Pain Scale Ventilator</strong> <i class='<?php echo MyIcon::getIcons('info2'); ?> txthitam'  data-toggle='tooltip' data-placement='top' title='' data-original-title='Pilih Penilaian untuk setiap Parameter Pengkajian Nyeri' data-html='true'></i></div>
                </div>
                <div class="panel-body">
                  <div class="table-responsive" style="overflow-x:auto;" id="ventilator_panel">
                      <div class='block-tabel'>
                         <table class="items table table-bordered table-striped table-condensed" id="tbl_ventilator">
                             <thead>
                                 <tr>
                                     <th>Parameter</th>
                                     <th>Penilaian</th>
                                     <th width="20%">Skor</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr>
                                     <th>Ekpresi Wajah</th>
                                     <th>
                                         <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'skriningnyeribps_ekspresiwajahpenilaian'); ?>
                                         <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'skriningnyeribps_ekspresiwajahpenilaian_text', CHtml::listData(LookupM::model()->findAll("lookup_type = 'bps_ekspresiwajah'"), 'lookup_value', 'lookup_name'), array('empty' => '-- Pilih --', 'class' => 'span3','onchange' => 'venekpresi_neonatus(this)')); ?>
                                     </th>
                                     <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skriningnyeribps_ekspresiwajahskor', array('class' => 'span1 integer numberOnly skor_ventilator', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </th>
                                 </tr>
                                 <tr>
                                     <th>Ekstremitas Atas</th>
                                     <th>
                                         <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'skriningnyeribps_ekstremitasataspenilaian'); ?>
                                         <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'skriningnyeribps_ekstremitasataspenilaian_text', CHtml::listData(LookupM::model()->findAll("lookup_type = 'bps_ekstremitasatas'"), 'lookup_value', 'lookup_name'), array('empty' => '-- Pilih --', 'class' => 'span3','onchange' => 'venekstremitas_neonatus(this)')); ?>
                                     </th>
                                     <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skriningnyeribps_ekstremitasatasskor', array('class' => 'span1 integer numberOnly skor_ventilator', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </th>
                                 </tr>
                                 <tr>
                                     <th>Kepatuhan dengan Ventilator</th>
                                     <th>
                                         <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'skriningnyeribps_kepatuhanventilatorpenilaian'); ?>
                                         <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'skriningnyeribps_kepatuhanventilatorpenilaian_text', CHtml::listData(LookupM::model()->findAll("lookup_type = 'bps_kepatuhanventilator'"), 'lookup_value', 'lookup_name'), array('empty' => '-- Pilih --', 'class' => 'span3','onchange' => 'venpatuh_neonatus(this)')); ?>
                                     </th>
                                     <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skriningnyeribps_kepatuhanventilatorskor', array('class' => 'span1 integer numberOnly skor_ventilator', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </th>
                                 </tr>
                                 <tr>
                                     <th colspan="2">Total Skor</th>
                                     <th> <?php echo  $form->textField($modAsesmenawalkeperawatanT,'score_skalanyeri_anak', array('value'=>'0','class'=>'span1 integer numberOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);",'maxlength'=>10,'readonly'=>true)).''; ?> </th>
                                 </tr>
                                 <tr>
                                     <th colspan="2">Kriteria Skor Nyeri</th>
                                     <th> <?php echo  $form->textField($modAsesmenawalkeperawatanT,'keteranganskala_nyeri_anak', array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)).''; ?> </th>
                                 </tr>
                              </tbody>
                         </table>
                     </div>
                  </div>
                </div>
              </div>
         </div>
     </div>
</div>
