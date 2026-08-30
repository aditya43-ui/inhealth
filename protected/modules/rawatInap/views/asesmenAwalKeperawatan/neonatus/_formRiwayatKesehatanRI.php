<div class="row-fluid">
     <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Riwayat Kesehatan</strong></div>
        </div>
         <div class="panel-body">
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
                                               <td class="formNeonatusIbuAnak">
                                                  <?php echo $form->textArea($model, 'neonatus_penyakitibu_lainnyaket', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                                  <?php
                                      						echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array('class' => 'btn btn-primary', 'onclick' => "$('#dialogDiagnosa').dialog('open');$('#formDiagnosa').val('formNeonatusIbuAnak');refreshGridDiagnosa();",
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
                             <div class="control-group">
                                <?php echo $form->labelEx($model,'neonatus_kompilkasikehamilan', array('class'=>'control-label','label'=>'Komplikasi Kehamilan')) ?>
                                <div class="controls">
                                  <?php
                                       $lookupKomplikasi = LookupM::model()->findAll("lookup_type = 'komplikasikehamilan_asesmen' order by lookup_urutan ASC");

                                       if(count((array)$lookupKomplikasi) > 0){
                                         $htmlKomplikasi = "";
                                         $indexKomplikasi = 0;
                                         foreach($lookupKomplikasi as $i => $look_komplikasi){
                                           $isKomplikasi = false;

                                           if($indexKomplikasi == 2){
                                             $htmlKomplikasi .= "<br/>";
                                             $indexKomplikasi = 0;
                                           }
                                           $indexKomplikasi++;
                                           if(!empty($model->neonatus_kompilkasikehamilan)){
                                             $arrOriKomplikasi = json_decode($model->neonatus_kompilkasikehamilan);
                                             foreach ($arrOriKomplikasi as $oriKomplikasi) {
                                               if($oriKomplikasi == $look_komplikasi->lookup_value){
                                                 $isKomplikasi = true;
                                               }
                                             }
                                           }

                                           $htmlKomplikasi .= CHtml::hiddenField('KomplikasiKehamilan['.$i.'][komplikasi]',$look_komplikasi->lookup_value);
                                           if($look_komplikasi->lookup_value == 'Lain-lain'){
                                             $htmlKomplikasi .= CHtml::checkBox('KomplikasiKehamilan['.$i.'][iskomplikasi]',$isKomplikasi,array('class'=>'iskomplikasi disabledinputan','onchange'=>'setKomplikasiKehamilan(this)')).' <label>'.$look_komplikasi->lookup_name.'</label> &nbsp;&nbsp;';
                                             $htmlKomplikasi .= "<br/>".CHtml::activeTextField($model,'neonatus_kompilkasikehamilanlainnya',array('class'=>'span3','disabled'=>true));
                                           }else{
                                             $htmlKomplikasi .= CHtml::checkBox('KomplikasiKehamilan['.$i.'][iskomplikasi]',$isKomplikasi,array('class'=>'iskomplikasi disabledinputan')).' <label>'.$look_komplikasi->lookup_name.'</label> &nbsp;&nbsp;';
                                           }



                                         }
                                         echo $htmlKomplikasi;
                                       }
                                   ?>
                                </div>
                            </div>
                           </div>
                           <div class="col-sm-6">
                              <?php echo $form->textAreaRow($model, 'neonatus_riwayatpengobatanibu', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                              <div class="control-group">
                                 <?php echo $form->labelEx($model,'neonatus_kebiasaansaathamil', array('class'=>'control-label','label'=>'Kebiasaaan saat hamil')) ?>
                                 <div class="controls">
                                   <?php
                                        $lookupKebiasaan = array(0=>'Rokok',1=>'Jamu', 2=>'Lainnya');

                                        if(count((array)$lookupKebiasaan) > 0){
                                          $htmlKebiasaan = "";
                                          foreach($lookupKebiasaan as $i => $look_kebiasaan){
                                            $isKebiasaan = false;

                                            if($i >0){
                                              $htmlKebiasaan .= "<br/>";
                                            }
                                            if(!empty($model->neonatus_kebiasaansaathamil)){
                                              $arrOriKebiasaan = json_decode($model->neonatus_kebiasaansaathamil);
                                              foreach ($arrOriKebiasaan as $oriKebiasaan) {
                                                if($oriKebiasaan == $look_kebiasaan){
                                                  $isKebiasaan = true;
                                                }
                                              }
                                            }

                                            $htmlKebiasaan .= CHtml::hiddenField('KebiasaanKehamilan['.$i.'][kebiasaan]',$look_kebiasaan);
                                            if($look_kebiasaan == 'Lainnya'){
                                              $htmlKebiasaan .= CHtml::checkBox('KebiasaanKehamilan['.$i.'][iskebiasaan]',$isKebiasaan,array('class'=>'iskebiasaan disabledinputan','onchange'=>'setKebiasaanKehamilan(this)')).' <label>'.$look_kebiasaan.'</label> &nbsp;&nbsp;';
                                              $htmlKebiasaan .= "<br/>".CHtml::activeTextField($model,'neonatus_kebiasaansaathamillainnya',array('class'=>'span3','disabled'=>true));
                                            }else{
                                              $htmlKebiasaan .= CHtml::checkBox('KebiasaanKehamilan['.$i.'][iskebiasaan]',$isKebiasaan,array('class'=>'iskebiasaan disabledinputan')).' <label>'.$look_kebiasaan.'</label> &nbsp;&nbsp;';
                                            }
                                          }
                                          echo $htmlKebiasaan;
                                        }
                                    ?>
                                 </div>
                             </div>
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
                             <div class="control-group">
                                <?php echo $form->labelEx($model,'neonatus_kebiasaansaathamil', array('class'=>'control-label','label'=>'G')) ?>
                                <div class="controls">
                                  <?php  echo $form->textField($model,'khususanak_gravida_g',array('class'=>'span1 numbersOnly integer', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;'));?>
                                  <label>P</label>
                                  <?php  echo $form->textField($model,'khususanak_gravida_p',array('class'=>'span1 numbersOnly integer', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;'));?>
                                  <label>A</label> <?php  echo $form->textField($model,'khususanak_gravida_a',array('class'=>'span1 numbersOnly integer', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;'));?>
                                </div>
                            </div>
                            <div class="control-group ">
                               <?php echo $form->labelEx($model, 'neonatus_tglpersalinan', array('class' => 'control-label','label'=>'Tanggal Persalinan')) ?>
                               <div class="controls">
                                       <?php
                                           $this->widget('MyDateTimePicker', array(
                                               'model' => $model,
                                               'attribute' => 'neonatus_tglpersalinan',
                                               'mode' => 'datetime',
                                               'options' => array(
                                                       'dateFormat' => Params::DATE_FORMAT,
                                               ),
                                               'htmlOptions' => array('readonly' => true, 'class'=>'span3',
                                                       'onkeypress' => "return $(this).focusNextInputField(event)"),
                                           ));
                                       ?>
                               </div>
                            </div>
                            <div class="control-group ">
                               <?php echo $form->labelEx($model, 'neonatus_jampersalinan', array('class' => 'control-label','label'=>'Jam Persalinan')) ?>
                               <div class="controls">
                                       <?php
                                               $this->widget('MyDateTimePicker', array(
                                                       'model' => $model,
                                                       'attribute' => 'neonatus_jampersalinan',
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
                                 <?php echo $form->LabelEx($model,'neonatus_umurkehamilan',array('class'=>'control-label'));?>
                                 <div class="controls">
                                  <?php  echo $form->textField($model,'neonatus_umurkehamilan',array('class'=>'span1 numbersOnly integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;'));?> Minggu
                                 </div>
                             </div>
                             <div class="control-group ">
                                 <?php echo $form->LabelEx($model,'neonatus_presentasibayi',array('class'=>'control-label','label'=>'Presentasi Bayi'));?>
                                 <div class="controls">
                                  <?php  echo $form->textField($model,'neonatus_presentasibayi',array('class'=>'span3 float', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;'));?>
                                 </div>
                             </div>
                           </div>
                           <div class="col-sm-6">
                             <div class="control-group ">
                                <?php echo $form->labelEx($model,'neonatus_carapersalinan', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->radioButtonList($model,'neonatus_carapersalinan', LookupM::getItems("carapersalinan"), array('class'=>'riwayatpembedahan_status','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                                </div>
                            </div>
                            <div class="control-group">
                               <?php echo $form->labelEx($model,'neonatus_isketubanpecah', array('class'=>'control-label','label'=>'Ketuban Pecah')) ?>
                               <div class="controls">
                                   <?php echo $form->radioButtonList($model,'neonatus_isketubanpecah',array(0=>"Tidak",1=>'Ya') , array('class'=>'neonatus_isketubanpecah','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'setKetubanpecah()')); ?>
                               </div>
                           </div>

                           <div class="control-group">
                             <label class="control-label"></label>
                              <div class="controls">
                                <div class="control-group ">
                                    <?php echo $form->labelEx($model,'neonatus_jamketubanpecah', array('class'=>'control-label','label'=>'Jam')) ?>
                                    <div class="controls">
                                      <?php
                                          $this->widget('MyDateTimePicker', array(
                                                  'model' => $model,
                                                  'attribute' => 'neonatus_jamketubanpecah',
                                                  'mode' => 'time',
                                                  'options' => array(
                                                  ),
                                                  'htmlOptions' => array('readonly' => true, 'class'=>'span3',
                                                          'onkeypress' => "return $(this).focusNextInputField(event)"),
                                          ));
                                      ?>
                                    </div>
                                </div>
                              </div>
                          </div>
                          <div class="control-group">
                             <?php echo $form->labelEx($model,'neonatus_warnaketuban', array('class'=>'control-label','label'=>'Ketuban Pecah')) ?>
                             <div class="controls">
                               <?php echo $form->radioButton($model,'neonatus_warnaketuban',array('class'=>'neonatus_warnaketuban','value'=>'Jernih','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> <label>Jernih</label>
                             </div>
                             <div class="controls">
                               <?php echo $form->radioButton($model,'neonatus_warnaketuban',array('class'=>'neonatus_warnaketuban','value'=>'Merah','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> <label>Merah</label>
                             </div>
                         </div>
                         <div class="control-group">
                            <label class="control-label"></label>
                            <div class="controls">
                              <?php echo $form->radioButton($model,'neonatus_warnaketuban',array('class'=>'neonatus_warnaketuban','value'=>'Hijau','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> <label>Hijau</label>
                            </div>
                            <div class="controls">
                              <?php echo $form->radioButton($model,'neonatus_warnaketuban',array('class'=>'neonatus_warnaketuban','value'=>'Keruh','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> <label>Keruh</label>
                            </div>
                        </div>
                        <div class="control-group">
                           <?php echo $form->labelEx($model,'neonatus_placenta', array('class'=>'control-label','label'=>'Ketuban Pecah')) ?>
                           <div class="controls">
                               <?php echo $form->radioButtonList($model,'neonatus_placenta',array('Komplit'=>"Komplit",'Klasifikasi'=>'Klasifikasi','Kelainan'=>'Kelainan') , array('class'=>'neonatus_placenta','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
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
                        <div class="panel-title"><strong>Keadaan Bayi Saat Lahir</strong></div>
                    </div>
                     <div class="panel-body">
                       <div class="row-fluid">
                         <div class="col-sm-6">
                           <div class="control-group ">
                              <?php echo $form->labelEx($model, 'neonatus_tglpersalinan', array('class' => 'control-label','label'=>'Tanggal Lahir')) ?>
                              <div class="controls">
                                      <?php
                                          $this->widget('MyDateTimePicker', array(
                                              'model' => $model,
                                              'attribute' => 'neonatus_tgllahirbayi',
                                              'mode' => 'datetime',
                                              'options' => array(
                                                      'dateFormat' => Params::DATE_FORMAT,
                                              ),
                                              'htmlOptions' => array('readonly' => true, 'class'=>'span3',
                                                      'onkeypress' => "return $(this).focusNextInputField(event)"),
                                          ));
                                      ?>
                              </div>
                           </div>
                           <div class="control-group ">
                              <?php echo $form->labelEx($model, 'neonatus_jampersalinan', array('class' => 'control-label','label'=>'Jam Lahir')) ?>
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
                           <div class="control-group ">
                              <?php echo $form->labelEx($model,'neonatus_jeniskelamin', array('class'=>'control-label','label'=>'Jenis Kelamin')) ?>
                              <div class="controls">
                                  <?php echo $form->radioButtonList($model,'neonatus_jeniskelamin', array('LAKI-LAKI'=>'LAKI-LAKI','PEREMPUAN'=>'PEREMPUAN'), array('class'=>'neonatus_jeniskelamin','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                              </div>
                            </div>
                            <div class="control-group ">
                               <?php echo $form->labelEx($model,'neonatus_jeniskelahiran', array('class'=>'control-label','label'=>'Jenis Kelahiran')) ?>
                               <div class="controls">
                                   <?php echo $form->radioButtonList($model,'neonatus_jeniskelahiran', array('Kelahiran Tunggal'=>'Kelahiran Tunggal','Kelahiran Kembar/ Multiple'=>'Kelahiran Kembar/ Multiple'), array('class'=>'neonatus_jeniskelahiran','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                               </div>
                             </div>
                             <div class="control-group ">
                                <?php echo $form->labelEx($model,'neonatus_kondisisaatlahir', array('class'=>'control-label','label'=>'Jenis Kelahiran')) ?>
                                <div class="controls">
                                    <?php echo $form->radioButtonList($model,'neonatus_kondisisaatlahir', array('Hidup'=>'Hidup','Mati'=>'Mati'), array('class'=>'neonatus_kondisisaatlahir','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'setKondisisaatlahir()')); ?>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label"></label>
                                 <div class="controls">
                                   <div class="control-group ">
                                     <label class="control-label" style="width: 20px"></label>
                                      <div class="controls">
                                          <?php echo $form->radioButtonList($model,'neonatus_statuskelahiranmati', array('Sebelum Persalinan'=>'Sebelum Persalinan','Dalam Persalinan'=>'Dalam Persalinan'), array('class'=>'neonatus_statuskelahiranmati disabledinputan','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                                      </div>
                                    </div>
                                 </div>
                             </div>
                             <div class="control-group">
                                <?php echo $form->labelEx($model,'neonatus_sebabkematian', array('class'=>'control-label','label'=>'Sebab Kematian')) ?>
                                <div class="controls">
                                    <?php echo $form->textArea($model, 'neonatus_sebabkematian', array('class' => 'span3 disabledinputan', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                            <div class="control-group ">
                                <?php echo $form->labelEx($model,'neonatus_saatlahir_hr', array('class'=>'control-label','label'=>'HR')) ?>
                                <div class="controls">
                                        <?php echo $form->textField($model,'neonatus_saatlahir_hr',array('class'=>'span2  integer numbersOnly', 'maxlength'=>3, 'onkeypress'=>"return $(this).focusNextInputField(event)", 'style'=>'text-align:right;'));?>
                                 x/Menit
                                </div>
                            </div>
                            <div class="control-group ">
                                <?php echo $form->LabelEx($model,'neonatus_saatlahir_suhutubuh',array('class'=>'control-label','label'=>'Suhu Tubuh'));?>
                                <div class="controls">
                                        <?php echo $form->textField($model,'neonatus_saatlahir_suhutubuh',array('class'=>'span2 float', 'maxlength'=>5, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align:right;'));?>
                                 &#176; C
                                </div>
                            </div>
                            <div class="control-group ">
                                <?php echo $form->labelEx($model,'neonatus_saatlahir_rr', array('class'=>'control-label','label'=>'RR')) ?>
                                <div class="controls">
                                        <?php echo $form->textField($model,'neonatus_saatlahir_rr',array('class'=>'span2  integer numbersOnly', 'maxlength'=>3, 'onkeypress'=>"return $(this).focusNextInputField(event)", 'style'=>'text-align:right;'));?>
                                 x/Menit
                                </div>
                            </div>
                            <div class="control-group ">
                                <?php echo $form->labelEx($model,'neonatus_saatlahir_spo2', array('class'=>'control-label','label'=>'SpO2')) ?>
                                <div class="controls">
                                        <?php echo $form->textField($model,'neonatus_saatlahir_spo2',array('class'=>'span2 integer numbersOnly', 'maxlength'=>3, 'onkeypress'=>"return $(this).focusNextInputField(event)", 'style'=>'text-align:right;'));?>
                                 %
                                </div>
                            </div>

                         </div>
                         <div class="col-sm-6">
                           <div class="control-group ">
                               <?php echo $form->labelEx($model,'khususanak_beratbadanlahir', array('class'=>'control-label','label'=>'Berat Badan Lahir')) ?>
                               <div class="controls">
                                       <?php echo $form->textField($model,'khususanak_beratbadanlahir',array('class'=>'span2 integer numbersOnly', 'maxlength'=>3, 'onkeypress'=>"return $(this).focusNextInputField(event)", 'style'=>'text-align:right;'));?>
                                gram
                               </div>
                           </div>
                           <div class="control-group ">
                               <?php echo $form->LabelEx($model,'khususanak_tinggibadan',array('class'=>'control-label','label'=>'Panjang Badan (PB)'));?>
                               <div class="controls">
                                       <?php echo $form->textField($model,'khususanak_tinggibadan',array('class'=>'span2 integer numbersOnly', 'maxlength'=>5, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align:right;'));?>
                                cm
                               </div>
                           </div>
                           <div class="control-group ">
                               <?php echo $form->LabelEx($model,'neonatus_saatlahir_lingkarkepala',array('class'=>'control-label','label'=>'Lingkar Kepala (LK)'));?>
                               <div class="controls">
                                       <?php echo $form->textField($model,'neonatus_saatlahir_lingkarkepala',array('class'=>'span2 float', 'maxlength'=>5, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align:right;'));?>
                                cm
                               </div>
                           </div>
                           <div class="control-group ">
                               <?php echo $form->LabelEx($model,'neonatus_saatlahir_lingkardada',array('class'=>'control-label','label'=>'Lingkar Dada (LD)'));?>
                               <div class="controls">
                                       <?php echo $form->textField($model,'neonatus_saatlahir_lingkardada',array('class'=>'span2 float', 'maxlength'=>5, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align:right;'));?>
                                cm
                               </div>
                           </div>
                           <div class="control-group">
                              <?php echo $form->labelEx($model,'neonatus_saatlahir_anus', array('class'=>'control-label','label'=>'Anus')) ?>
                              <div class="controls">
                                  <?php echo $form->textArea($model, 'neonatus_saatlahir_anus', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'maxlength'=>255)); ?>
                              </div>
                          </div>
                          <div class="control-group">
                             <?php echo $form->labelEx($model,'neonatus_saatlahir_kelahiran', array('class'=>'control-label','label'=>'Kelahiran')) ?>
                             <div class="controls">
                                 <?php echo $form->textArea($model, 'neonatus_saatlahir_kelahiran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'maxlength'=>255)); ?>
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
