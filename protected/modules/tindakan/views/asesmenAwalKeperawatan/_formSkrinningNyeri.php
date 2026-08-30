<div class="row-fluid">
     <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Skrinning Nyeri</strong></div>
        </div>
         <div class="panel-body">
             <div class="panel panel-success panel_nyeri" id="nyeri_dewasa" >
                <div class="panel-heading">
                    <div class="panel-title"><?php echo $form->radioButton($modAsesmenawalkeperawatanT, 'is_keluhannyeri_dewasa', array('onclick' => 'pilihNyeri(this)', 'value' => 1, 'class'=>'pilih_nyeri', 'uncheckValue'=>null)); ?> Asesmen Nyeri Anak > 3 Tahun</div>
                </div>
                <div class="panel-body" >

                    <h2 style="text-align:center;">Intensitas "WONG BAKER FACE SCALE"</h2>
                    <br/>
                    <?php
                    echo $this->renderPartial($this->path_view . '_formAsesmenDewasa', array(
                        'form' => $form,
                        'model' => $modAsesmenawalkeperawatanT
                            ), true);
                    ?>


                </div>
            </div>

            <div class="panel panel-success panel_nyeri" id="nyeri_anak" >
                <div class="panel-heading">
                    <div class="panel-title"><?php echo $form->radioButton($modAsesmenawalkeperawatanT, 'is_keluhannyeri_dewasa', array('onclick' => 'pilihNyeri(this)', 'value' => 0, 'class'=>'pilih_nyeri', 'uncheckValue'=>null)); ?> Asesmen Nyeri Anak < 3 Tahun</div>
                </div>
                <div class="panel-body">

                    <?php

                    echo $this->renderPartial($this->path_view . '_formAsesmenAnak', array(
                        'form' => $form,
                        'model' => $modAsesmenawalkeperawatanT,
                        'dataFlaCcs' => $dataFlaCcs,
                        'getFlaCcs' => $getFlaCcs,
                        'modNyeriAnakDet'=>$modSkrinningnyerianakdetT
                            ), true);
                    ?>


                </div>
            </div>
            <div class="panel panel-primary panel-default">
              <div class="panel-heading">
                  <div class="panel-title"><strong>Penilaian Nyeri</strong></div>
              </div>
              <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                      <div class="control-group">
                          <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'isadakeluhannyeri', array('class'=>'control-label','label'=>'Nyeri')) ?>
                          <div class="controls">
                              <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'isadakeluhannyeri', array('Tidak'=>'Tidak','Ya'=>'Ya'), array('class'=>'isadakeluhannyeri','onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>'setAdaNyeri_anak();')); ?>
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

            <div class="panel panel-primary panel-default">
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

                                 if(count($lookupKualitas) >0 ){
                                   $htmlKualitas = "";
                                   foreach($lookupKualitas as $i => $look_risiko){
                                     if($i > 0){
                                       $htmlKualitas .= "<br/>";
                                     }
                                    $htmlKualitas .= CHtml::hiddenField('KualitasNyeri['.$i.'][nama]',$look_risiko->lookup_value);
                                     if($look_risiko->lookup_value == 'Lainnya'){
                                       $htmlKualitas .= CHtml::checkBox('KualitasNyeri['.$i.'][isKualitas]',false , array('datavalue'=>$look_risiko->lookup_value,'class'=>'kualitasnyeri disabledinputan','onchange'=>'setKualitasNyeri_anak()')).' <label>'.$look_risiko->lookup_name.'</label>';
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

                      </div>
                      <div class="col-md-6">
                          <table width="100%">
                              <tr>
                                  <td class="fontColor" valign="top">
                                      Menjalar
                                  </td>
                                  <td colspan="3">
                                      <div class="controls">
                                          <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'deskripsinyeri_ismenjalar',array(0=>'Tidak',1=>'Ya') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'changeDeskripsinyeri_ismenjalar(this);')); ?>
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

                                    if(count($lookupFrekuensi) >0 ){
                                      $htmlFrekuensi = "";
                                      foreach($lookupFrekuensi as $i => $look_risiko){
                                        if($i > 0){
                                          $htmlFrekuensi .= "<br/>";
                                        }
                                       $htmlFrekuensi .= CHtml::hiddenField('FrekuensiNyeri['.$i.'][nama]',$look_risiko->lookup_value);
                                        if($look_risiko->lookup_value == 'Lainnya'){
                                          $htmlFrekuensi .= CHtml::checkBox('FrekuensiNyeri['.$i.'][isFrekuensi]',false , array('datavalue'=>$look_risiko->lookup_value,'class'=>'frekuensinyeri','onchange'=>'setFrekuensiNyeri_anak()')).' <label>'.$look_risiko->lookup_name.'</label>';
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

                      </div>
                  </div>
              </div>
            </div>
         </div>
     </div>
</div>
