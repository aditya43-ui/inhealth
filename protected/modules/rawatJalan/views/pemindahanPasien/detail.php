<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php
$modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTImeForUser($modPendaftaran->tgl_pendaftaran);
$modPasien->nama_pasien = $modPasien->namadepan.$modPasien->nama_pasien;
$modPasien->tanggal_lahir = MyFormatter::formatDateTImeForUser($modPasien->tanggal_lahir);

if(isset($modPendaftaran->jeniskasuspenyakit)){
    $modPendaftaran->jeniskasuspenyakit_nama = $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama;
}
if(isset($modPendaftaran->carabayar)){
    $modPendaftaran->carabayar_nama = $modPendaftaran->carabayar->carabayar_nama;
}

if(isset($modPendaftaran->penjamin)){
    $modPendaftaran->penjamin_nama = $modPendaftaran->penjamin->penjamin_nama;
}
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data Pasien</div>
    </div>
    <div class="panel-body">
      <table width="100%" style="border: none;">
          <tr>
              <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran',array('class'=>'control-label')); ?>
              </td>
              <td><?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('disabled'=>true)); ?></td>

              <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); ?></td>
              <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('disabled'=>true)); ?></td>
          </tr>
          <tr>
              <td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran',array('class'=>'control-label')); ?></td>
              <td><?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('disabled'=>true)); ?></td>

              <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien',array('class'=>'control-label')); ?></td>
              <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('disabled'=>true)); ?></td>
          </tr>
          <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id',array('class'=>'control-label')); ?></td>
            <td>
                <?php echo CHtml::activeTextField($modPendaftaran, 'jeniskasuspenyakit_nama', array('disabled'=>true)); ?>
            </td>

            <td><?php echo CHtml::activeLabel($modPasien, 'tanggal_lahir',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'tanggal_lahir', array('disabled'=>true)); ?></td>
          </tr>
          <tr>
              <td><?php echo CHtml::activeLabel($modPendaftaran, 'cara bayar',array('class'=>'control-label')); ?></td>
              <td><?php echo CHtml::activeTextField($modPendaftaran, 'carabayar_nama', array('disabled'=>true)); ?></td>

              <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur',array('class'=>'control-label')); ?></td>
              <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly'=>true)); ?></td>
          </tr>
          <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'penjamin', array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'penjamin_nama', array('disabled'=>true)); ?></td>

            <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('disabled'=>true)); ?></td>

          </tr>
      </table>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Assesment</div>
    </div>
    <div class="panel-body">
      <table width="100%" style="border: none;">
        <tr>
          <td width="50%" valign="top">
            <table width="100%" style="border: none;">
              <tr>
                <td width="150px">
                  <?php echo CHtml::activeLabel($model,'observasiterakhir', array('class'=>'control-label')); ?>
                </td>
                <td>
                  <?php echo CHtml::activeTextField($model, 'observasiterakhir', array('disabled'=>true, 'class'=>'span3')); ?>
                </td>
              </tr>
              <tr>
                <td width="150px">
                  <?php echo CHtml::label('GCS Eye','', array('class'=>'control-label')); ?>
                </td>
                <td>
                  <?php $crit = new CDbCriteria();
  								$crit->compare('LOWER(metodegcs_singkatan)',"e");
  								$crit->addCondition('metodegcs_nilai is not null');
  								$crit->order = 'metodegcs_nilai ASC'; ?>
                  <?php echo CHtml::activeDropDownList($model, 'gcs_eye', CHtml::listData(RJMetodeGCSM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM'), array('disabled'=>true,'empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                </td>
              </tr>
              <tr>
                <td width="150px">
                  <?php echo CHtml::label('GCS Verbal','', array('class'=>'control-label')); ?>
                </td>
                <td>
                  <?php
                  $crit3 = new CDbCriteria();
                  $crit3->compare('LOWER(metodegcs_singkatan)',"v");
                  $crit3->addCondition('metodegcs_nilai is not null');
                  $crit3->order = 'metodegcs_nilai ASC';
                   ?>
                  <?php echo CHtml::activeDropDownList($model, 'gcs_verbal', CHtml::listData(RJMetodeGCSM::model()->findAll($crit3), 'metodegcs_nilai', 'textMetodeGCSM'), array('disabled'=>true,'empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                </td>
              </tr>
              <tr>
                <td width="150px">
                  <?php echo CHtml::label('GCS Motorik','', array('class'=>'control-label')); ?>
                </td>
                <td>
                  <?php $crit2 = new CDbCriteria();
  								$crit2->compare('LOWER(metodegcs_singkatan)',"m");
  								$crit2->addCondition('metodegcs_nilai is not null');
  								$crit2->order = 'metodegcs_nilai ASC'; ?>
                  <?php echo CHtml::activeDropDownList($model, 'gcs_motorik', CHtml::listData(RJMetodeGCSM::model()->findAll($crit2), 'metodegcs_nilai', 'textMetodeGCSM'), array('disabled'=>true,'empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                </td>
              </tr>
              <tr>
                <td width="150px">
                  <?php echo CHtml::label('Nilai GCS','', array('class'=>'control-label')); ?>
                </td>
                <td>
                  <?php echo CHtml::activeTextField($model, 'nilai_gcs',array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'disabled'=>true)); ?>
                </td>
              </tr>
              <tr>
                <td>
                  <label class="control-label" style="width: 80px">Reflek Pupil</label>
                </td>
                <td></td>
              </tr>
              <tr>
                <td style="padding-left: 10px">
                  <?php echo CHtml::activeLabel($model,'reflekpupilkanan', array('class'=>'control-label')); ?>
                </td>
                <td>
                  <?php echo CHtml::activeTextField($model, 'reflekpupilkanan',array('disabled'=>true,'class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </td>
              </tr>
              <tr>
                <td style="padding-left: 10px">
                  <?php echo CHtml::activeLabel($model,'reflekpupilkiri', array('class'=>'control-label')); ?>
                </td>
                <td>
                     <?php echo CHtml::activeTextField($model, 'reflekpupilkiri',array('disabled'=>true,'class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                 </td>
               </tr>
               <tr>
                 <td>
                  <?php echo CHtml::label('Takanan Darah','', array('class'=>'control-label')); ?>
                </td>
                <td>
                   <?php  echo CHtml::activeTextField($model,'td_systolic',array('disabled'=>true,'class'=>'span1 numbersOnly systolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'getTekananDarah()', 'style'=>'text-align: right;'));?>Mm
                   <?php echo CHtml::activeTextField($model,'td_diastolic',array('disabled'=>true,'onblur'=>'','readonly'=>false,'class'=>'span1 numbersOnly diastolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'getTekananDarah();', 'style'=>'text-align: right;')); ?>Hg
                </td>
              </tr>

              <tr>
                <td>
                  <?php echo CHtml::label('','',array('class'=>'control-label'));?>
                </td>
                <td>
                          <?php
                                echo CHtml::textField('tekanandarah','',array('disabled'=>true,'readonly'=>true, 'class'=>'span2', 'style'=>'width:60px; text-align: right;','onkeypress'=>"return $(this).focusNextInputField(event)"));
                          ?> Mm/Hg
                        </td>
                      </tr>
                      <tr>
                        <td>
                  <?php echo CHtml::activeLabel($model,'nadi',array('label'=>'Nadi','class'=>'control-label'));?>
                </td>
                <td>
                          <?php echo CHtml::activeTextField($model,'nadi',array('disabled'=>true,'class'=>'span2  integer numbersOnly', 'maxlength'=>3, 'onkeypress'=>"return $(this).focusNextInputField(event)"));?>
                   /Menit
                 </td>
               </tr>
               <tr>
                 <td>
                  <?php echo CHtml::activeLabel($model,'pernapasan',array('class'=>'control-label'));?>
                </td>
                <td>
                          <?php echo CHtml::activeTextField($model,'pernapasan',array('disabled'=>true,'class'=>'span2 integer numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>2));?>
                          /Menit
                        </td>
                      </tr>
                      <tr>
                        <td>
                  <label class='control-label'>SPO2</label>
                </td>
                <td>
                      <?php echo CHtml::activeTextField($model,'tandavital_spo2',array('disabled'=>true,'class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;', 'maxlength'=>2)); ?> <label>%</label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                  <?php echo CHtml::activeLabel($model,'suhutubuh',array('class'=>'control-label'));?>
                </td>
                <td>
                      <?php echo CHtml::activeTextField($model,'suhutubuh',array('disabled'=>true,'class'=>'span2 float', 'maxlength'=>5, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align:right;'));?>
                   &#176; C
                 </td>
               </tr>
               <tr>
                 <td>
                  <?php echo CHtml::label('BAB','', array('class'=>'control-label')); ?>
                </td>
                <td>
                    <?php echo CHtml::activeDropDownList($model, 'pemindahan_bab', LookupM::getItems('pemindahan_bab'), array('disabled'=>true,'empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                  </td>
                </tr>
                <tr>
                  <td>
                  <?php echo CHtml::activeLabel($model,'isbak', array('class'=>'control-label')); ?>
                </td>
                <td>
                    <div class="form-inline">
                        <div class="radio inline">
                            <?php echo CHtml::activeRadioButtonList($model,'isbak',array(0=>'Normal',1=>'Kateter') , array('disabled'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','class'=>'isbak', 'onchange'=>'changeBak()')); ?>
                        </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                  <?php echo CHtml::label('Jenis Kateter','', array('class'=>'control-label')); ?>
                </td>
                <td>
                     <?php echo CHtml::activeTextField($model, 'jeniskateter',array('disabled'=>true,'class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                   </td>
                 </tr>
                 <tr>
                   <td>
                  <?php echo CHtml::label('No Kateter','', array('class'=>'control-label')); ?>
                </td>
                <td>
                     <?php echo CHtml::activeTextField($model, 'no_kateter',array('disabled'=>true,'class'=>'span3 integer','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                   </td>
                 </tr>
                 <tr>
                   <td>
                  <?php echo CHtml::label('Tanggal Pemasangan','', array('class'=>'control-label')); ?>
                </td>
                <td>
                  <?php $model->tglpemasangan_kateter = (!empty($model->tglpemasangan_kateter)? MyFormatter::formatDateTimeForUser($model->tglpemasangan_kateter) :"") ?>
                  <?php echo CHtml::activeTextField($model, 'tglpemasangan_kateter',array('disabled'=>true,'class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                  </td>
                </tr>
                <tr>
                  <td>
                  <?php echo CHtml::label('Mobilisasi','', array('class'=>'control-label')); ?>
                </td>
                <td>
                    <?php echo CHtml::activeDropDownList($model, 'mobilisasi', LookupM::getItems('pemindahan_mobilisasi'), array('disabled'=>true,'empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                  </td>
                </tr>
                <tr>
                  <td>
                  <?php echo CHtml::label('Transfer / Mobilisasi','', array('class'=>'control-label')); ?>
                </td>
                <td>
                    <?php echo CHtml::activeDropDownList($model, 'transfermobilisasi', LookupM::getItems('transfer_mobilisasi'), array('disabled'=>true,'empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                  </td>
                </tr>
                <tr>
                  <td>
                  <?php echo CHtml::label('Gangguan Indra','', array('class'=>'control-label')); ?>
                </td>
                <td>
                    <?php echo CHtml::activeDropDownList($model, 'gangguanindra', LookupM::getItems('gangguanindera'), array('disabled'=>true,'empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                  </td>
                </tr>
                <tr>
                  <td>
                  <?php echo CHtml::label('Alat Bantu yang dipakai','', array('class'=>'control-label')); ?>
                </td>
                <td>
                    <?php echo CHtml::activeDropDownList($model, 'alatabantudiapakai', LookupM::getItems('alatbantudipakai'), array('disabled'=>true,'empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                  </td>
                </tr>
                <tr>
                  <td>
                  <?php echo CHtml::label('Tindakan Kebutuhan Khusus','', array('class'=>'control-label')); ?>
                </td>
                <td>
                    <?php echo CHtml::activeDropDownList($model, 'tindakankebutuhan_khusus', LookupM::getItems('tindakankebutuhankhusus'), array('disabled'=>true,'empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                  </td>
                </tr>

            </table>
          </td>
          <td width="50%" valign="top">
            <table width="100%" style="border: none;">
              <tr>
                <td width="150px">
                  <?php echo CHtml::activeLabel($model,'islukaperawatan', array('class'=>'control-label')); ?>
                </td>
                <td>
                  <div class="form-inline">
                      <div class="radio inline">
                          <?php echo CHtml::activeRadioButtonList($model,'islukaperawatan',array(1=>'Ya',0=>'Tidak') , array('disabled'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','class'=>'islukaperawatan', 'onchange'=>'changeLukaPerawatan()')); ?>
                      </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <?php echo CHtml::label('Kondisi','', array('class'=>'control-label')); ?>
                </td>
                <td>
                     <?php echo CHtml::activeTextField($model, 'kondisiperawatan',array('disabled'=>true,'class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                   </td>
                 </tr>
                 <tr>
                   <td>
                  <?php echo CHtml::label('Lokasi','', array('class'=>'control-label')); ?>
                </td>
                <td>
                     <?php echo CHtml::activeTextField($model, 'lokasiperawatan',array('disabled'=>true,'class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                   </td>
                 </tr>
                 <tr>
                   <td>
                  <?php echo CHtml::label('Ukuran','', array('class'=>'control-label')); ?>
                </td>
                <td>
                     <?php echo CHtml::activeTextField($model, 'ukuranperawatan',array('disabled'=>true,'class'=>'span3 integer numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                   </td>
                 </tr>
                 <tr>
                   <td>
                   </td>
                   <td>
                      <?php echo CHtml::activeCheckBox($model,'isinfus',array('disabled'=>true)); ?> <label>Invus / CVC</label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                    </td>
                    <td style="padding-left: 10px">
                     <?php echo CHtml::activeTextField($model, 'infuscvc',array('disabled'=>true,'class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                   </td>
                 </tr>
                 <tr>
                   <td>
                   </td>
                   <td>
                      <?php echo CHtml::activeCheckBox($model,'isvasscore',array('disabled'=>true)); ?> <label>VAS Score</label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                    </td>
                    <td style="padding-left: 10px">
                     <?php echo CHtml::activeTextField($model, 'vasscore',array('disabled'=>true,'class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                   </td>
                 </tr>
                 <tr>
                   <td>
                  <?php echo CHtml::label('Tanggal Pemasangan','', array('class'=>'control-label')); ?>
                </td>
                <td>
                  <?php $model->tglpemasangan_perawatan = (!empty($model->tglpemasangan_perawatan) ? MyFormatter::formatDateTimeForUser($model->tglpemasangan_perawatan) : "") ?>
                  <?php echo CHtml::activeTextField($model, 'tglpemasangan_perawatan',array('disabled'=>true,'class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                  <?php echo CHtml::label('Peralatan khusus yang diperlukan','', array('class'=>'control-label','style'=>'width: 200px')); ?>
                </td>
              </tr>
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
              <tr>
                <td colspan="2">
                      <?php echo CHtml::activeCheckBox($model,'isalat1',array('disabled'=>true)); ?> <label>Alat 1</label>
                      <?php echo CHtml::activeTextField($model, 'alat1_ket',array('disabled'=>true,'class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <?php echo CHtml::activeCheckBox($model,'isalat2',array('disabled'=>true)); ?> <label>Alat 2</label>
                      <?php echo CHtml::activeTextField($model, 'alat2_ket',array('disabled'=>true,'class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <?php echo CHtml::activeCheckBox($model,'isalat3',array('disabled'=>true)); ?> <label>Alat 3</label>
                      <?php echo CHtml::activeTextField($model, 'alat3_ket',array('disabled'=>true,'class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                  <?php echo CHtml::label('Hal - hal istimewa yang berhubungan dengan kondisi pasien','', array('class'=>'control-label','style'=>'width: 350px')); ?>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                    <?php echo CHtml::activeTextArea($model, 'investigasiabnormal', array('disabled'=>true,'style' => 'width: 100%; height: 200px', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                  </td>
                </tr>
            </table>
            <br/>
            <table width="100%" class="table table-bordered" id="tbldiagnosakep">
              <thead>
                <tr>
                  <th width="50px">No</th>
                  <th>Diagnosa Keperawatan</th>
                  <th width="100px">Sudah Teratasi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $diagnosaKep = DiagnosakeperawatanT::model()->findAllByAttributes(array('pemindahanpasien_id'=>$model->pemindahanpasien_id));
                  if(count($diagnosaKep) >0){
                      $no = 0;
                      foreach($diagnosaKep as $diagnosaKep){
                        $no++;

                        ?>
                        <tr>
                          <td><?php echo $no; ?></td>
                          <td><?php echo $diagnosaKep->nama_diagnosa; ?></td>
                          <td><?php echo $diagnosaKep->statusdiagnosa; ?></td>
                        </tr>
                        <?php
                      }
                  }
                 ?>
              </tbody>
            </table>
          </td>
        </tr>
      </table>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Kondisi Pasien</div>
    </div>
    <div class="panel-body">
      <table width="100%" style="border: none;">
        <tr>
          <td width="50%" valign="top">
            <table width="100%" style="border: none;">
              <tr>
                <td width="150px">
                  <?php echo CHtml::label('Waktu Kesadaran','', array('class'=>'control-label')); ?>
                </td>
                <td>
                  <?php echo CHtml::activeTextField($model, 'waktukeadaan',array('disabled'=>true,'class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </td>
              </tr>
              <tr>
                <td>
                  <?php echo CHtml::label('Keadaan Umum','', array('class'=>'control-label')); ?>
                </td>
                <td>
                  <?php echo CHtml::activeTextField($model, 'keadaanumum',array('disabled'=>true,'class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </td>
              </tr>
              <tr>
                <td>
                  <?php echo CHtml::label('Kesadaran','', array('class'=>'control-label')); ?>
                </td>
                <td>
                  <?php echo CHtml::activeTextField($model, 'kesadaran',array('disabled'=>true,'class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </td>
              </tr>
            </table>
          </td>
          <td width="50%" valign="top">
            <table width="100%" style="border: none;">
              <tr>
                <td width="150px">
                  <?php echo CHtml::label('Catatan Penting','', array('class'=>'control-label')); ?>
                </td>
                <td>
                  <?php echo CHtml::activeTextArea($model, 'catatan_penting',array('disabled'=>true,'class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br/>
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
              <?php echo CHtml::checkBox('Kelengkapandok[0][iskelengkapan]',(isset($arrMateri[0]['iskelengkapan']) ?$arrMateri[0]['iskelengkapan'] : false ), array('disabled'=>true,'class'=>'iskelengkapan','onchange'=>'changeKelengkapan(this);','index_urut'=>0)); ?>
            </td>
            <td>
              Obat - Obatan
            </td>
            <td>
              <div class="keterangan">
                <?php echo CHtml::radioButtonList('Kelengkapandok[0][keterangan]',(isset($arrMateri[0]['keterangan']) ?$arrMateri[0]['keterangan'] : false ),array('Lengkap'=>'Lengkap','Tidak Lengkap'=>'Tidak Lengkap'), array('disabled'=>true,'class'=>'radio_ket','separator'=>'&nbsp;&nbsp;&nbsp;')); ?>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo CHtml::checkBox('Kelengkapandok[1][iskelengkapan]',(isset($arrMateri[1]['iskelengkapan']) ?$arrMateri[1]['iskelengkapan'] : false ), array('disabled'=>true,'class'=>'iskelengkapan','onchange'=>'changeKelengkapan(this);','index_urut'=>1)); ?>
            </td>
            <td>
              Hasil Laboratorium
            </td>
            <td>
              <label>Jumlah : </label>&nbsp;&nbsp;
              <?php echo CHtml::textField('Kelengkapandok[1][keterangan]',(isset($arrMateri[1]['keterangan']) ?$arrMateri[1]['keterangan'] : '' ),array('disabled'=>true,'class'=>'integer numbersOnly span1 keterangan')) ?>
              &nbsp;&nbsp;<label>Lembar</label>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo CHtml::checkBox('Kelengkapandok[2][iskelengkapan]',(isset($arrMateri[2]['iskelengkapan']) ?$arrMateri[2]['iskelengkapan'] : false ), array('disabled'=>true,'class'=>'iskelengkapan','onchange'=>'changeKelengkapan(this);','index_urut'=>2)); ?>
            </td>
            <td>
              X - Ray Regio
            </td>
            <td>
              <label>Jumlah : </label>&nbsp;&nbsp;
              <?php echo CHtml::textField('Kelengkapandok[2][keterangan]',(isset($arrMateri[2]['keterangan']) ?$arrMateri[2]['keterangan'] : '' ),array('disabled'=>true,'class'=>'integer numbersOnly span1 keterangan')) ?>
              &nbsp;&nbsp;<label>Lembar</label>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo CHtml::checkBox('Kelengkapandok[3][iskelengkapan]',(isset($arrMateri[3]['iskelengkapan']) ?$arrMateri[3]['iskelengkapan'] : false ), array('disabled'=>true,'class'=>'iskelengkapan','onchange'=>'changeKelengkapan(this);','index_urut'=>3)); ?>
            </td>
            <td>
              CT Scan Regio
            </td>
            <td>
              <label>Jumlah : </label>&nbsp;&nbsp;
              <?php echo CHtml::textField('Kelengkapandok[3][keterangan]',(isset($arrMateri[3]['keterangan']) ?$arrMateri[3]['keterangan'] : '' ),array('disabled'=>true,'class'=>'integer numbersOnly span1 keterangan')) ?>
              &nbsp;&nbsp;<label>Lembar</label>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo CHtml::checkBox('Kelengkapandok[4][iskelengkapan]',(isset($arrMateri[4]['iskelengkapan']) ?$arrMateri[4]['iskelengkapan'] : false ), array('disabled'=>true,'class'=>'iskelengkapan','onchange'=>'changeKelengkapan(this);','index_urut'=>4)); ?>
            </td>
            <td>
              USG Regio
            </td>
            <td>
              <label>Jumlah : </label>&nbsp;&nbsp;
              <?php echo CHtml::textField('Kelengkapandok[4][keterangan]',(isset($arrMateri[4]['keterangan']) ?$arrMateri[4]['keterangan'] : '' ),array('disabled'=>true,'class'=>'integer numbersOnly span1 keterangan')) ?>
              &nbsp;&nbsp;<label>Lembar</label>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo CHtml::checkBox('Kelengkapandok[5][iskelengkapan]',(isset($arrMateri[5]['iskelengkapan']) ?$arrMateri[5]['iskelengkapan'] : false ), array('disabled'=>true,'class'=>'iskelengkapan','onchange'=>'changeKelengkapan(this);','index_urut'=>5)); ?>
            </td>
            <td>
              Penunjang Radiologi lain (MRI / MRA / Lainnya)
            </td>
            <td>
              <label>Jumlah : </label>&nbsp;&nbsp;
              <?php echo CHtml::textField('Kelengkapandok[5][keterangan]',(isset($arrMateri[5]['keterangan']) ?$arrMateri[5]['keterangan'] : '' ),array('disabled'=>true,'class'=>'integer numbersOnly span1 keterangan')) ?>
              &nbsp;&nbsp;<label>Lembar</label>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo CHtml::checkBox('Kelengkapandok[6][iskelengkapan]',(isset($arrMateri[6]['iskelengkapan']) ?$arrMateri[6]['iskelengkapan'] : false ), array('disabled'=>true,'class'=>'iskelengkapan','onchange'=>'changeKelengkapan(this);','index_urut'=>6)); ?>
            </td>
            <td>
              Echocardiografi
            </td>
            <td>
              <label>Jumlah : </label>&nbsp;&nbsp;
              <?php echo CHtml::textField('Kelengkapandok[6][keterangan]',(isset($arrMateri[6]['keterangan']) ?$arrMateri[6]['keterangan'] : '' ),array('disabled'=>true,'class'=>'integer numbersOnly span1 keterangan')) ?>
              &nbsp;&nbsp;<label>Lembar</label>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo CHtml::checkBox('Kelengkapandok[7][iskelengkapan]',(isset($arrMateri[7]['iskelengkapan']) ?$arrMateri[7]['iskelengkapan'] : false ), array('disabled'=>true,'class'=>'iskelengkapan','onchange'=>'changeKelengkapan(this);','index_urut'=>7)); ?>
            </td>
            <td>
              Gigi Palsu
            </td>
            <td>
              <label>Jumlah : </label>&nbsp;&nbsp;
              <?php echo CHtml::textField('Kelengkapandok[7][keterangan]',(isset($arrMateri[7]['keterangan']) ?$arrMateri[7]['keterangan'] : '' ),array('disabled'=>true,'class'=>'integer numbersOnly span1 keterangan')) ?>
              &nbsp;&nbsp;<label>Lembar</label>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo CHtml::checkBox('Kelengkapandok[8][iskelengkapan]',(isset($arrMateri[8]['iskelengkapan']) ?$arrMateri[8]['iskelengkapan'] : false ), array('disabled'=>true,'class'=>'iskelengkapan','onchange'=>'changeKelengkapan(this);','index_urut'=>8)); ?>
            </td>
            <td>
              Kaca Mata
            </td>
            <td>
              <label>Jumlah : </label>&nbsp;&nbsp;
              <?php echo CHtml::textField('Kelengkapandok[8][keterangan]',(isset($arrMateri[8]['keterangan']) ?$arrMateri[8]['keterangan'] : '' ),array('disabled'=>true,'class'=>'integer numbersOnly span1 keterangan')) ?>
              &nbsp;&nbsp;<label>Lembar</label>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo CHtml::checkBox('Kelengkapandok[9][iskelengkapan]',(isset($arrMateri[9]['iskelengkapan']) ?$arrMateri[9]['iskelengkapan'] : false ), array('disabled'=>true,'class'=>'iskelengkapan','onchange'=>'changeKelengkapan(this);','index_urut'=>9)); ?>
            </td>
            <td>
              Alat Bantu Dengan
            </td>
            <td>
              <?php echo CHtml::textField('Kelengkapandok[9][keterangan]',(isset($arrMateri[9]['keterangan']) ?$arrMateri[9]['keterangan'] : '' ),array('disabled'=>true,'class'=>'span3 keterangan')) ?>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data Pengisi</div>
    </div>
    <div class="panel-body">
      <table width="100%" style="border: none;">
        <tr>
          <td width="50%" valign="top">
            <table width="100%" style="border: none;">
              <tr>
                <td width="150px">
                  <?php echo CHtml::label('Disetujui','', array('class'=>'control-label')); ?>
                </td>
                <td>
                  <?php echo CHtml::activeDropDownList($model, 'tipedisetujui', array('Pasien'=>'Pasien','Penanggung Jawab'=>'Penanggung Jawab'), array('disabled'=>true,'empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3','onchange'=>'changeDisetujui(this);')); ?>
                </td>
              </tr>

              <tr>
                <td>
                  <?php echo CHtml::label($model->tipedisetujui,'', array('class'=>'control-label disetujui')); ?>
                </td>
                <td>
                    <?php echo CHtml::activeTextField($model, 'disetujui_oleh',array('disabled'=>true,'class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                  </td>
                </tr>
            </table>
          </td>
          <td width="50%" valign="top">
            <table width="100%" style="border: none;">
              <tr>
                <td width="150px">
                  <?php echo CHtml::label('Mengetahui','', array('class'=>'control-label')); ?>
                </td>
                <td>
                  <?php $peg_mengetahui = !empty($model->pegawai_mengetahui) ? $model->pegawai_mengetahui : 0; ?>
                  <?php echo CHtml::activeDropDownList($model, 'pegawai_mengetahui', CHtml::listData(PegawaiM::model()->findAll('pegawai_id = ' . $peg_mengetahui),'pegawai_id','namaLengkap'), array('disabled'=>true,'empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                </td>
              </tr>
              <tr>
                <td>
                  <?php echo CHtml::label('Diserahkan oleh','', array('class'=>'control-label')); ?>
                </td>
                <td>
                    <?php echo CHtml::activeDropDownList($model, 'tipediserahkan', array('Perawat'=>'Perawat','Incharge'=>'Incharge'), array('disabled'=>true,'empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3','onchange'=>'changeDiserahkan(this);')); ?>
                  </td>
                </tr>
                <tr>
                  <td>
                  <?php echo CHtml::label($model->tipediserahkan,'', array('class'=>'control-label diserahkan')); ?>
                </td>
                <td>
                <?php $per_pengirim = !empty($model->perawatpengirim_id) ? $model->perawatpengirim_id : 0; ?>
                <?php echo CHtml::activeDropDownList($model, 'perawatpengirim_id', CHtml::listData(PegawaiM::model()->findAll('pegawai_id = ' . $per_pengirim),'pegawai_id','namaLengkap'), array('disabled'=>true,'empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                  </td>
                </tr>
            </table>
          </td>
        </tr>
      </table>
    </div>
</div>

<script type="text/javascript">

function hitungGcs(){
    var gcsEye = parseInt($('#<?php echo CHtml::activeId($model, 'gcs_eye'); ?>').val());
    var gcsVerbal = parseInt($('#<?php echo CHtml::activeId($model, 'gcs_verbal'); ?>').val());
    var gcsMotorik = parseInt($('#<?php echo CHtml::activeId($model, 'gcs_motorik'); ?>').val());

    if(isNaN(gcsEye)){
      gcsEye = 0;
    }

    if(isNaN(gcsVerbal)){
      gcsVerbal = 0;
    }

    if(isNaN(gcsMotorik)){
      gcsMotorik = 0;
    }

    var hitungAll = (gcsEye + gcsVerbal + gcsMotorik);
    $('#<?php echo CHtml::activeId($model, 'nilai_gcs'); ?>').val(hitungAll);
  }

  function getTekananDarah(){
    var td_systolic = parseInt($('#<?php echo CHtml::activeId($model, 'td_systolic'); ?>').val());
    var td_diastolic = parseInt($('#<?php echo CHtml::activeId($model, 'td_diastolic'); ?>').val());

    if(isNaN(td_systolic)){
      td_systolic = 0;
    }

    if(isNaN(td_diastolic)){
      td_diastolic = 0;
    }
    var hasil = (td_systolic+'/'+td_diastolic);
    $('#tekanandarah').val(hasil);
  }

  
$(document).ready(function(){
  hitungGcs();
  formatNumberSemua();
  getTekananDarah();
});
</script>
