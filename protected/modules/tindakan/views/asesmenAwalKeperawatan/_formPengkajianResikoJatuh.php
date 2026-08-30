<div class="row-fluid">
     <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Pengkajian Resiko Jatuh</strong></div>
        </div>
         <div class="panel-body">
             <table width="100%">
                 <tr>
                     <td width="120px">
                         <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'isadaresikojatuh', array('class'=>'control-label')) ?>
                     </td>
                     <td width="100px">
                         <div class="controls">
                            <div class="form-inline">
                                <div class="radio inline">
                                    <?php echo CHtml::activeRadioButtonList($modAsesmenawalkeperawatanT,'isadaresikojatuh',array(0=>'Tidak',1=>'Ya') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;')); ?>
                                </div>
                            </div>
                         </div>
                     </td>
                     <td width="60px" class="fontColor">
                         , Resiko
                     </td>
                     <td>
                         <div class="controls">
                             <?php echo $form->textField($modAsesmenawalkeperawatanT, 'resikojatuh_tingkat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
                         </div>
                     </td>
                 </tr>
             </table>
             <br>
             <?php if(Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RJ){ ?>
                <div class="panel panel-primary panel-success" id="panelresikojatuh_rj">
                   <div class="panel-heading">
                       <div class="panel-title"><strong>Skrinning Resiko Jatuh Anak (Humpty Dumpty)</strong></div>
                   </div>
                    <div class="panel-body">
                        <div id="resikojatuhdewasa">
                          <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'jenisresikojatuh', array('value'=>'anak')); ?>
                           <div class="table-responsive" style="overflow-x:auto;">
                               <div class='block-tabel'>
                                  <table class="items table table-bordered table-striped table-condensed" id="tblResikojatuhAnak">
                                      <thead>
                                          <tr>
                                              <th>Parameter</th>
                                              <th>Kriteria</th>
                                              <th>Skor</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <tr>
                                              <th>Usia</th>
                                              <th>
                                                  <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'usia_anak'); ?>
                                                  <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'usia_anak_text', LookupM::getItems('resikojatuh_usia_anak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'resikojatuhanak_usia(this)')); ?>
                                              </th>
                                              <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skor_usia_anak', array('class' => 'span1 integer numberOnly resikojatuhanak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                          </tr>
                                          <tr>
                                              <th>Jenis Kelamin</th>
                                              <th>
                                                  <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'jeniskelamin_anak'); ?>
                                                  <?php echo $form->dropDownList($modAsesmenawalkeperawatanT,'jeniskelamin_anak_text',LookupM::getItems('jeniskelamin_skrining'), array('empty' => '-- Pilih --', 'class' => 'jeniskelaminAnak span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'resikojatuhanak_jeniskelamin(this)'));?>
                                              </th>
                                              <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skor_jeniskelamin_anak', array('class' => 'span1 integer numbersOnly resikojatuhanak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                          </tr>
                                          <tr>
                                              <th>Diagnose</th>
                                              <th>
                                                  <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'diagnosa_asessment_anak'); ?>
                                                  <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'diagnosa_asessment_anak_text', LookupM::getItems('resikojatuh_diagnose_anak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'resikojatuhanak_diagnosa(this)')); ?>
                                              </th>
                                              <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skor_diagnosa_anak', array('class' => 'span1 integer numbersOnly resikojatuhanak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                          </tr>
                                          <tr>
                                              <th>Gangguan Kognitif</th>
                                              <th>
                                                  <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'gangguan_kognitif_anak'); ?>
                                                  <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'gangguan_kognitif_anak_text', LookupM::getItems('resikojatuh_gangguan_kognitif_anak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'resikojatuhanak_gangguan(this)')); ?>
                                              </th>
                                              <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skor_gangguan_kognitif_anak', array('class' => 'span1 integer numbersOnly resikojatuhanak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                          </tr>
                                          <tr>
                                              <th>Faktor Lingkungan</th>
                                              <th>
                                                  <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'faktor_lingkungan_anak'); ?>
                                                  <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'faktor_lingkungan_anak_text', LookupM::getItems('resikojatuh_faktor_lingkungan_anak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'resikojatuhanak_faktor(this)')); ?>
                                              </th>
                                              <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skor_faktor_lingkungan_anak', array('class' => 'span1 integer numbersOnly resikojatuhanak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                          </tr>
                                          <tr>
                                              <th>Respon Terhadap: Pembedahan, sedasi, anestesi</th>
                                              <th>
                                                  <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'responterhadap_pembedahan_anak'); ?>
                                                  <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'responterhadap_pembedahan_anak_text', LookupM::getItems('resikojatuh_responterhadap_pembedahan_anak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'resikojatuhanak_respon(this)')); ?>
                                              </th>
                                              <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skor_responterhadap_pembedahan_anak', array('class' => 'span1 integer numbersOnly resikojatuhanak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                          </tr>
                                          <tr>
                                              <th>Penggunaan Medikamentosa</th>
                                              <th>
                                                  <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'penggunaan_medikamentosa'); ?>
                                                  <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'penggunaan_medikamentosa_text', LookupM::getItems('resikojatuh_pembedahan_medikamentosa_anak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'resikojatuhanak_bedah(this)')); ?>
                                              </th>
                                              <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skor_medikamentosa_anak', array('class' => 'span1 integer numbersOnly resikojatuhanak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                          </tr>
                                          <tr>
                                              <th></th>
                                              <th>Total Score</th>
                                              <th> <?php echo  $form->textField($modAsesmenawalkeperawatanT,'jumlah_skor_anak', array('class'=>'span1 integer numberOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);",'maxlength'=>10,'readonly'=>true)).''; ?> </th>
                                              <th></th>
                                          </tr>
                                          <tr>
                                              <th></th>
                                              <th>Hasil Resiko Jatuh</th>
                                              <th> <?php echo $form->textField($modAsesmenawalkeperawatanT,'keterangan_resiko_jatuh_anak', array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true,)).''; ?> </th>
                                          </tr>
                                       </tbody>
                                  </table>
                              </div>
                           </div>
                        </div>
                    </div>
                </div>
             <?php }else{ ?>
             <div class="panel panel-primary panel-success" id="panelresikojatuh_dewasa">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo $form->radioButton($modAsesmenawalkeperawatanT, 'isresikojatuh', array('onclick' => 'choiseResikoJatuh(this)', 'value' => 0, 'class'=>'pilih_resikoJatuh', 'uncheckValue'=>null)); ?> <strong>Skrinning Resiko Jatuh Dewasa (Morse Falls Scale)</strong></div>
                </div>
                 <div class="panel-body">
                     <div id="resikojatuhdewasa">
                        <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'jenisresikojatuh', array('value'=>'dewasa')); ?>
                        <div class="table-responsive" style="overflow-x:auto;">
                            <div class='block-tabel'>
                               <table class="items table table-bordered table-striped table-condensed" id="tblResikojatuhDewasa">
                                   <thead>
                                       <tr>
                                           <th>No</th>
                                           <th>Resiko</th>
                                           <th>Penilaian</th>
                                           <th>Skor</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                           <th>1</th>
                                           <th>Riwayat Jatuh, Apakah pasien pernah jatuh dalam 3 bulan terakhir</th>
                                           <th>
                                               <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'riwayatjatuh_penilaian'); ?>
                                            <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'riwayatjatuh_penilaian_text', array('Ya'=>'Ya','Tidak'=>'Tidak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'resikojatuhdewasa_penilaian(this)'));
                                            ?>
                                           </th>
                                           <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'riwayatjatuh_skor', array('class' => 'span1 integer numbersOnly resikojatuhdewasa_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                       </tr>
                                        <tr>
                                           <th>2</th>
                                           <th>Diagnosa Sekunder, Apakah pasien memiliki lebih dari satu penyakit?</th>
                                           <th>
                                               <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'diagnosismedis_penilaian'); ?>
                                            <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'diagnosismedis_penilaian_text', array('Ya'=>'Ya','Tidak'=>'Tidak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'resikojatuhdewasa_diagnosa(this)'));
                                            ?>
                                           </th>
                                           <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'diagnosismedis_skor', array('class'=>'span1 integer numberOnly resikojatuhdewasa_skor',  'onkeypress'=>"return $(this).focusNextInputField(event);",'maxlength'=>10,'readonly'=>true)).' '; ?></th>
                                       </tr>
                                        <tr>
                                           <th>3</th>
                                           <th>Alat Bantu Jalan</th>
                                           <th>
                                               <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'alatbantujalan_penilaian'); ?>
                                            <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'alatbantujalan_penilaian_text',LookupM::getItems('resikojatuhlansia_alatbantu'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'resikojatuhdewasa_alatbantu(this)'));
                                            ?>  </th>
                                           <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'alatbantujalan_skor', array('class'=>'span1 integer numberOnly resikojatuhdewasa_skor',  'onkeypress'=>"return $(this).focusNextInputField(event);",'maxlength'=>10,'readonly'=>true)).''; ?></th>
                                       </tr>
                                        <tr>
                                           <th>4</th>
                                           <th>Terapi Intrevena, Apakah saat ini pasien terpasang infus?</th>
                                           <th>
                                               <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'memakaiterapiheparin_penilaian'); ?>
                                            <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'memakaiterapiheparin_penilaian_text', array('Ya'=>'Ya','Tidak'=>'Tidak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'resikojatuhdewasa_terapi(this)'));
                                            ?>  </th>
                                           <th><?php echo $form->textField($modAsesmenawalkeperawatanT,'memakaiterapiheparin_skor', array('class'=>'span1 integer numberOnly resikojatuhdewasa_skor', 'onkeypress'=>"return $(this).focusNextInputField(event);",'maxlength'=>10,'readonly'=>true)).''; ?> </th>
                                       </tr>
                                        <tr>
                                           <th>5</th>
                                           <th>Cara Berjalan/ Berpindah</th>
                                           <th>
                                               <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'caraberjalan_penilaian'); ?>
                                            <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'caraberjalan_penilaian_text',LookupM::getItems('resikojatuhlansia_caraberjalan'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'resikojatuhdewasa_berjalan(this)'));
                                            ?>
                                           </th>
                                           <th> <?php echo $form->textField($modAsesmenawalkeperawatanT,'caraberjalan_skor', array('class'=>'span1 integer numberOnly resikojatuhdewasa_skor', 'onkeypress'=>"return $(this).focusNextInputField(event);",'maxlength'=>10,'readonly'=>true)).''; ?> </th>
                                       </tr>
                                        <tr>
                                           <th>6</th>
                                           <th>Status Mental</th>
                                           <th>
                                               <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'statusmental_penilaian'); ?>
                                             <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'statusmental_penilaian_text',LookupM::getItems('resikojatuhlansia_statusmental'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'resikojatuhdewasa_mental(this)'));
                                            ?>
                                           </th>
                                           <th> <?php echo  $form->textField($modAsesmenawalkeperawatanT,'statusmental_skor', array('class'=>'span1 integer numberOnly resikojatuhdewasa_skor', 'onkeypress'=>"return $(this).focusNextInputField(event);",'maxlength'=>10,'readonly'=>true)).''; ?> </th>
                                       </tr>
                                       <tr>
                                           <th></th>
                                           <th></th>
                                           <th>Total Score</th>
                                           <th> <?php echo  $form->textField($modAsesmenawalkeperawatanT,'resikojatuh_skor', array('class'=>'span1 integer numberOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);",'maxlength'=>10,'readonly'=>true)).''; ?> </th>
                                           <th></th>
                                       </tr>
                                       <tr>
                                           <th></th>
                                           <th></th>
                                           <th>Hasil Resiko Jatuh</th>
                                           <th> <?php echo $form->textField($modAsesmenawalkeperawatanT,'resikojatuh_keterangan', array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true,)).''; ?> </th>
                                       </tr>
                                    </tbody>
                               </table>
                           </div>
                        </div>
                     </div>
                 </div>
             </div>

             <div class="panel panel-primary panel-success" id="panelresikojatuh_anak">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo $form->radioButton($modAsesmenawalkeperawatanT, 'isresikojatuh', array('onclick' => 'choiseResikoJatuh(this)', 'value' => 1, 'class'=>'pilih_resikoJatuh', 'uncheckValue'=>null)); ?> <strong>Skrinning Resiko Jatuh Anak (Humpty Dumpty)</strong></div>
                </div>
                 <div class="panel-body">
                    <div id="resikojatuhanak">
                       <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'jenisresikojatuh', array('value'=>'anak')); ?>
                        <div class="table-responsive" style="overflow-x:auto;">
                            <div class='block-tabel'>
                               <table class="items table table-bordered table-striped table-condensed" id="tblResikojatuhAnak">
                                   <thead>
                                       <tr>
                                           <th>Parameter</th>
                                           <th>Kriteria</th>
                                           <th>Skor</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                           <th>Usia</th>
                                           <th>
                                               <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'usia_anak'); ?>
                                               <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'usia_anak_text', LookupM::getItems('resikojatuh_usia_anak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'resikojatuhanak_usia(this)')); ?>
                                           </th>
                                           <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skor_usia_anak', array('class' => 'span1 integer numberOnly resikojatuhanak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                       </tr>
                                       <tr>
                                           <th>Jenis Kelamin</th>
                                           <th>
                                               <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'jeniskelamin_anak'); ?>
                                               <?php echo $form->dropDownList($modAsesmenawalkeperawatanT,'jeniskelamin_anak_text',LookupM::getItems('jeniskelamin_skrining'), array('empty' => '-- Pilih --', 'class' => 'jeniskelaminAnak span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'resikojatuhanak_jeniskelamin(this)'));?>
                                           </th>
                                           <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skor_jeniskelamin_anak', array('class' => 'span1 integer numbersOnly resikojatuhanak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                       </tr>
                                       <tr>
                                           <th>Diagnose</th>
                                           <th>
                                               <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'diagnosa_asessment_anak'); ?>
                                               <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'diagnosa_asessment_anak_text', LookupM::getItems('resikojatuh_diagnose_anak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'resikojatuhanak_diagnosa(this)')); ?>
                                           </th>
                                           <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skor_diagnosa_anak', array('class' => 'span1 integer numbersOnly resikojatuhanak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                       </tr>
                                       <tr>
                                           <th>Gangguan Kognitif</th>
                                           <th>
                                               <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'gangguan_kognitif_anak'); ?>
                                               <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'gangguan_kognitif_anak_text', LookupM::getItems('resikojatuh_gangguan_kognitif_anak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'resikojatuhanak_gangguan(this)')); ?>
                                           </th>
                                           <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skor_gangguan_kognitif_anak', array('class' => 'span1 integer numbersOnly resikojatuhanak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                       </tr>
                                       <tr>
                                           <th>Faktor Lingkungan</th>
                                           <th>
                                               <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'faktor_lingkungan_anak'); ?>
                                               <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'faktor_lingkungan_anak_text', LookupM::getItems('resikojatuh_faktor_lingkungan_anak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'resikojatuhanak_faktor(this)')); ?>
                                           </th>
                                           <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skor_faktor_lingkungan_anak', array('class' => 'span1 integer numbersOnly resikojatuhanak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                       </tr>
                                       <tr>
                                           <th>Respon Terhadap: Pembedahan, sedasi, anestesi</th>
                                           <th>
                                               <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'responterhadap_pembedahan_anak'); ?>
                                               <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'responterhadap_pembedahan_anak_text', LookupM::getItems('resikojatuh_responterhadap_pembedahan_anak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'resikojatuhanak_respon(this)')); ?>
                                           </th>
                                           <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skor_responterhadap_pembedahan_anak', array('class' => 'span1 integer numbersOnly resikojatuhanak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                       </tr>
                                       <tr>
                                           <th>Penggunaan Medikamentosa</th>
                                           <th>
                                               <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'penggunaan_medikamentosa'); ?>
                                               <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'penggunaan_medikamentosa_text', LookupM::getItems('resikojatuh_pembedahan_medikamentosa_anak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'resikojatuhanak_bedah(this)')); ?>
                                           </th>
                                           <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skor_medikamentosa_anak', array('class' => 'span1 integer numbersOnly resikojatuhanak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                       </tr>
                                       <tr>
                                           <th></th>
                                           <th>Total Score</th>
                                           <th> <?php echo  $form->textField($modAsesmenawalkeperawatanT,'jumlah_skor_anak', array('class'=>'span1 integer numberOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);",'maxlength'=>10,'readonly'=>true)).''; ?> </th>
                                           <th></th>
                                       </tr>
                                       <tr>
                                           <th></th>
                                           <th>Hasil Resiko Jatuh</th>
                                           <th> <?php echo $form->textField($modAsesmenawalkeperawatanT,'keterangan_resiko_jatuh_anak', array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true,)).''; ?> </th>
                                       </tr>
                                    </tbody>
                               </table>
                           </div>
                        </div>
                    </div>
                 </div>
             </div>

             <div class="panel panel-primary panel-success" id="panelresikojatuh_lansia">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo $form->radioButton($modAsesmenawalkeperawatanT, 'isresikojatuh', array('onclick' => 'choiseResikoJatuh(this)', 'value' => 2, 'class'=>'pilih_resikoJatuh', 'uncheckValue'=>null)); ?> <strong>Skrinning Resiko Lansia (Sidney Scoring)</strong></div>
                </div>
                 <div class="panel-body">
                    <div id="resikojatuhlansia">
                      <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'jenisresikojatuh', array('value'=>'lansia')); ?>
                        <div class="table-responsive" style="overflow-x:auto;">
                            <div class='block-tabel'>
                               <table class="items table table-bordered table-striped table-condensed" id="tblResikojatuhLansia">
                                   <thead>
                                       <tr>
                                           <th style="width: 10px">No</th>
                                           <th style="width: 25px">Parameter</th>
                                           <th style="width: 200px">Skrining</th>
                                           <th style="width: 80px">Jawaban</th>
                                           <th style="width: 50px">Skor</th>
                                       </tr>
                                   </thead>
                                   <tr>
                                       <th rowspan="2">1</th>
                                       <th rowspan="2">Riwayat jatuh</th>
                                       <th>Apakah pasien datang kerumah sakit karena jatuh?</th>
                                       <th>
                                           <?php echo $form->hiddenField($modAsesmenawalkeperawatanT,'resiko_jatuh_lansia',array('class'=>'resiko_jatuh_lansia')); ?>
                                           <div class="form-inline">
                                               <?php echo CHtml::radioButtonList('riwayatJatuhRSLansia','',array("1"=>"<h5>YA</h5>","0"=>"<h5>TIDAK</h5>"), array('class'=>'riwayatJatuh','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','onchange'=>'setRiwayatJatuh(this)'));?>
                                           </div>
                                       </th>
                                       <th rowspan="2"><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skor_resiko_jatuh_lansia', array('class' => 'span1 integer numbersOnly skor_resiko_jatuh_lansia resikojatuhlansia_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                   </tr>
                                   <tr>
                                       <th>Jika tidak, apakah pasien mengalami jatuh dalam 2 bulan</th>
                                       <th>
                                           <div class="form-inline">
                                               <?php echo CHtml::radioButtonList('riwayatJatuhBulanLansia','',array("1"=>"<h5>YA</h5>","0"=>"<h5>TIDAK</h5>"), array('class'=>'riwayatJatuh','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','onchange'=>'setRiwayatJatuh(this)'));?>
                                           </div>
                                       </th>
                                   </tr>
                                   <tr>
                                       <th rowspan="3">2</th>
                                       <th rowspan="3">Status Mental</th>
                                       <th>Apakah pasien delirium? (tidak membuat keputusan, pola piker tidak terorganisir, gangguan daya ingat)</th>
                                       <th>
                                           <?php echo $form->hiddenField($modAsesmenawalkeperawatanT,'status_mental_lansia', array('class'=>'status_mental_lansia')); ?>
                                           <div class="form-inline">
                                               <?php echo CHtml::radioButtonList('statusMentalDeliriumLansia','',array("1"=>"<h5>YA</h5>","0"=>"<h5>TIDAK</h5>"), array('class'=>'statusMentalLansia','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','onchange'=>'setStatusMental(this)'));?>
                                           </div>
                                       </th>
                                       <th rowspan="3"><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skor_status_mental_lansia', array('value'=>'0','class' => 'span1 integer numbersOnly skor_status_mental_lansia resikojatuhlansia_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                   </tr>
                                   <tr>
                                       <th>Apakah pasien disorientasi? (salah menyebut waktu, tempat atau orang)</th>
                                       <th>
                                           <div class="form-inline">
                                               <?php echo CHtml::radioButtonList('statusMentalDisorientasiLansia','',array("1"=>"<h5>YA</h5>","0"=>"<h5>TIDAK</h5>"), array('class'=>'statusMentalLansia','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','onchange'=>'setStatusMental(this)'));?>
                                           </div>
                                       </th>
                                   </tr>
                                   <tr>
                                       <th>Apakah pasien mengalami agitasi? (ketakutan, kecemasan, gelisah)</th>
                                       <th>
                                           <div class="form-inline">
                                               <?php echo CHtml::radioButtonList('statusMentalAgitasiLansia','',array("1"=>"<h5>YA</h5>","0"=>"<h5>TIDAK</h5>"), array('class'=>'statusMentalLansia','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','onchange'=>'setStatusMental(this)'));?>
                                           </div>
                                       </th>
                                   </tr>
                                   <tr>
                                       <th rowspan="3">3</th>
                                       <th rowspan="3">Penglihatan</th>
                                       <th>Apakah pasien memakai kaca mata?</th>
                                       <th>
                                           <?php echo $form->hiddenField($modAsesmenawalkeperawatanT,'penglihatan_lansia', array('class'=>'penglihatan_lansia')); ?>
                                           <div class="form-inline">
                                               <?php echo CHtml::radioButtonList('penglihatanKacamataLansia','',array("1"=>"<h5>YA</h5>","0"=>"<h5>TIDAK</h5>"), array('class'=>'penglihatanLansia','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','onchange'=>'setPengelihatan(this)'));?>
                                           </div>
                                       </th>
                                       <th rowspan="3"><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skor_penglihatan_lansia', array('value'=>'0','class' => 'skor_penglihatan_lansia span1 integer numbersOnly resikojatuhlansia_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                   </tr>
                                   <tr>
                                       <th>Apakah pasien mengeluhkan penglihatan buram?</th>
                                       <th>
                                           <div class="form-inline">
                                               <?php echo CHtml::radioButtonList('penglihatanBuramLansia','',array("1"=>"<h5>YA</h5>","0"=>"<h5>TIDAK</h5>"), array('class'=>'penglihatanLansia','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','onchange'=>'setPengelihatan(this)'));?>
                                           </div>
                                       </th>
                                   </tr>
                                   <tr>
                                       <th>Apakah pasien mengalami glaucoma, katarak, degenerasi macula?</th>
                                       <th>
                                           <div class="form-inline">
                                               <?php echo CHtml::radioButtonList('penglihatanKatarakLansia','',array("1"=>"<h5>YA</h5>","0"=>"<h5>TIDAK</h5>"), array('class'=>'penglihatanLansia','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','onchange'=>'setPengelihatan(this)'));?>
                                           </div>
                                       </th>
                                   </tr>
                                   <tr>
                                       <th>4</th>
                                       <th>Kebiasaan berkemih</th>
                                       <th>Apakah terdapat perubahan prilaku berkemih? (frekuensi, urgensi, inkotenensia, nokturia)</th>
                                       <th>
                                           <div class="form-inline">
                                               <?php echo CHtml::activeRadioButtonList($modAsesmenawalkeperawatanT,'kebiasaan_berkemih_lansia',array("1"=>"<h5>YA</h5>","0"=>"<h5>TIDAK</h5>"), array('class'=>'kebiasaanBerkemihLansia','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','onchange'=>'setKebiasaanBerkemih(this)'));?>
                                           </div>
                                       </th>
                                       <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skor_berkemih_lansia', array('value'=>'0','class' => 'skor_berkemih_lansia span1 integer numbersOnly resikojatuhlansia_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                   </tr>
                                   <tr>
                                       <th>5</th>
                                       <th>Transfer (dari tempat tidur ke kursi dan kembali ke tempat tidur)</th>
                                       <th colspan="2">
                                           <?php echo $form->hiddenField($modAsesmenawalkeperawatanT,'transfer_mobilitas_lansia',array('class'=>'transfer_mobilitas_lansia')); ?>
                                           <?php echo CHtml::hiddenField('transferLansiaHidden',''); ?>
                                           <?php echo CHtml::dropDownList('transferLansia', '',LookupM::getItems('resikojatuh_transfer_lansia'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'getTransferLansia()'));?>
                                       </th>
                                       <th rowspan="2"><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skor_transfer_mobilitas_lansia', array('value'=>'0','class' => 'skor_transfer_mobilitas_lansia span1 integer numbersOnly resikojatuhlansia_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                   </tr>
                                   <tr>
                                       <th>6</th>
                                       <th>Mobilitas</th>
                                       <th colspan="2">
                                           <?php echo $form->hiddenField($modAsesmenawalkeperawatanT,'mobilitas_lansia',array('class'=>'mobilitas_lansia')); ?>
                                           <?php echo CHtml::hiddenField('mobilitasLansiaHidden',''); ?>
                                           <?php echo CHtml::dropDownList('mobilitasLansia', '',LookupM::getItems('resikojatuh_mobilitas_lansia'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'getMobilitasLansia()'));?>
                                       </th>
                                   </tr>
                                   <tr>
                                       <th colspan="4">Total Score</th>
                                       <th> <?php echo $form->textField($modAsesmenawalkeperawatanT,'jumlah_skor_lansia', array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true,)).''; ?> </th>
                                   </tr>
                                   <tr>
                                       <th colspan="3">Keterangan Skor</th>
                                       <th colspan="1"> <?php echo $form->textField($modAsesmenawalkeperawatanT,'keterangan_skor_lansia', array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true,)).''; ?> </th>
                                   </tr>
                               </table>
                           </div>
                        </div>
                    </div>

                 </div>
             </div>
             <?php } ?>
             <?php if(Yii::app()->user->getState("instalasi_id") != Params::INSTALASI_ID_RJ){ ?>
             <table width="100%">
                 <tr>
                     <td width="70%">
                         <table width="100%">
                            <tr>
                                <td class="fontColor">
                                    1. Apakah pernah jatuh dalam 3 bulan terakhir ?
                                </td>
                                <td colspan="3">
                                    <div class="controls">
                                        <div class="form-inline">
                                           <div class="radio inline">
                                               <?php echo CHtml::activeRadioButtonList($modAsesmenawalkeperawatanT,'riwayatjatuh_3bln_terakhir',array(1=>'Ya',0=>'Tidak') , array('class'=>'riwayatjatuh_3bln_terakhir','onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'changeInformasiResikoJatuh(this);','separator'=>'&nbsp;&nbsp;&nbsp;')); ?>
                                           </div>
                                       </div>
                                   </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="fontColor" valign="top">
                                    2. Apakah menggunakan alat bantu
                                </td>
                                <td colspan="3">
                                    <div class="controls">
                                        <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'riwayatjatuh_alatbantu',array(0=>'Tidak',1=>'Ya') , array('class'=>'riwayatjatuh_alatbantu','onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'changeInformasiResikoJatuh(this);')); ?>
                                   </div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td valign="top" class="fontColor">
                                    Jenis Alat Bantu
                                </td>
                                <td>
                                    <div class="controls">
                                        <?php echo $form->radioButton($modAsesmenawalkeperawatanT,'riwayatjatuh_jenisalatbantu', array('value'=>'Tongkat', 'uncheckValue'=>null,'class'=>'jenisalatbantu','onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'changeInformasiResikoJatuh(this);', 'disabled'=>true)); ?> <label>Tongkat</lable>
                                   </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td valign="top" class="fontColor">
                                </td>
                                <td>
                                    <div class="controls">
                                      <?php echo $form->radioButton($modAsesmenawalkeperawatanT,'riwayatjatuh_jenisalatbantu', array('value'=>'Kursi Roda', 'uncheckValue'=>null,'class'=>'jenisalatbantu','onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'changeInformasiResikoJatuh(this);', 'disabled'=>true)); ?> <label>Kursi Roda</lable>
                                   </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td valign="top" class="fontColor">
                                </td>
                                <td>
                                    <div class="controls">
                                        <?php echo $form->radioButton($modAsesmenawalkeperawatanT,'riwayatjatuh_jenisalatbantu', array('value'=>'Walker', 'uncheckValue'=>null,'class'=>'jenisalatbantu','onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'changeInformasiResikoJatuh(this);', 'disabled'=>true)); ?> <label>Walker</lable>
                                   </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td valign="top" class="fontColor">
                                </td>
                                <td>
                                    <div class="controls">
                                        <div class="form-inline">
                                            <?php echo $form->radioButton($modAsesmenawalkeperawatanT,'riwayatjatuh_jenisalatbantu', array('value'=>'Lainnya', 'uncheckValue'=>null,'class'=>'jenisalatbantu','onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'changeInformasiResikoJatuh(this);', 'disabled'=>true)); ?> <label>Lainnya</lable>
                                            <?php echo  $form->textField($modAsesmenawalkeperawatanT,'riwayatjatuh_jenisalatbantulainnya', array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
                                        </div>

                                    </div>
                                </td>
                                <td></td>
                            </tr>
                        </table>
                     </td>
                     <td width="30%" valign="top">
                         <div id="informasiResikoJatuh" style="border: 1px solid #b4e8a8; background-color: #bdedbc; color: #045702; font-size: 14px; padding: 10px">Lakukan intervensi pencegahan resiko jatuh</div>
                     </td>
                 </tr>
             </table>
             <?php } ?>
         </div>
     </div>

</div>
