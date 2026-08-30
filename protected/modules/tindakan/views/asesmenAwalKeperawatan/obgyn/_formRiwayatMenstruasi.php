<div class="row-fluid">
  <div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><strong>Riwayat Kehamilan</strong></div>
    </div>
     <div class="panel-body">
       <div class="panel panel-primary panel-success">
          <div class="panel-heading">
              <div class="panel-title"><strong>Riwayat Kehamilan</strong></div>
          </div>
           <div class="panel-body">
             <table width="100%" class="tabledosis">
               <tr>
                 <td width="width: 30%" valign="top" style="border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding-left: 20px;">
                   <table width="100%" class="tablecustom">
                     <tr>
                       <td width="150px"> Hamil ke-</td>
                       <td width="100px">
                         <?php echo CHtml::textField('hamilke',0,array('class'=>'span1 integer2')); ?>
                       </td>
                     </tr>
                     <tr>
                       <td width="150px">Umur Kehamilan</td>
                       <td width="100px">
                         <?php echo CHtml::textField('umurkehamilan',0,array('class'=>'span1 integer2')); ?>
                       </td>
                     </tr>
                     <tr>
                       <td width="150px">Berat Badan Lahir</td>
                       <td width="100px">
                         <?php echo CHtml::textField('beratbadan','',array('class'=>'span1 float2')); ?>
                         <?php echo CHtml::dropDownList('beratbadan_status', 'Kg', array('Gr'=>'Gr', 'Kg'=>'Kg'), array('class'=>'span1')); ?>
                       </td>
                     </tr>
                     <tr>
                       <td width="150px">Jenis Kelamin Anak</td>
                       <td width="100px">
                         <?php echo CHtml::radioButtonList('jeniskelamin','',array('Laki-laki'=>'Laki-laki','Perempuan'=>'Perempuan') , array('class'=>'jeniskelamin')); ?>
                       </td>
                     </tr>
                   </table>
                 </td>
                 <td width="width: 30%" valign="top" style="border-top: 1px solid black; border-bottom: 1px solid black;">
                   <table width="100%" class="tablecustom">
                     <tr>
                       <td width="150px">Cara Persalinan</td>
                       <td>
                         <?php
                             echo CHtml::dropDownList('carapersalinan', '',CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type'=>'carapersalinan'),array('order'=>'lookup_name ASC')), 'lookup_value', 'lookup_name'), array('empty'=>'-- Pilih --', 'class'=>'span2'));
                         ?>
                       </td>
                     </tr>
                     <tr>
                       <td width="150px">Penolong Persalinan</td>
                       <td>
                         <?php echo CHtml::textField('penolongpersalinan','',array('class'=>'span2')); ?>
                       </td>
                     </tr>
                     <tr>
                       <td width="150px">Tempat Persalinan</td>
                       <td>
                         <?php echo CHtml::textField('tempatpersalinan','',array('class'=>'span2')); ?>
                       </td>
                     </tr>
                     <tr>
                       <td width="150px">Abortus</td>
                       <td>
                         <?php echo CHtml::radioButtonList('abortus','',array('Ya'=>'Ya','Tidak'=>'Tidak') , array('class'=>'abortus')); ?>
                       </td>
                     </tr>
                   </table>
                 </td>
                 <td width="width: 30%" valign="top" style="border-top: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black;">
                   <table width="100%" class="tablecustom">
                     <tr>
                       <td width="150px">Komplikasi/ Keterangan</td>
                       <td>
                         <?php echo CHtml::textArea('keterangan','',array('class'=>'span3')); ?>
                       </td>
                     </tr>
                   </table>
                 </td>
                 <td width="width: 10%" valign="middle" style="padding-left: 20px;">
                   <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                           array('onclick'=>'tambahKehamilan(this);return false;',
                                 'class'=>'btn btn-primary',
                                 'id'=>'tomboltambah',
                                 'onkeypress'=>"tambahKehamilan(this);return false;",
                                 'rel'=>"tooltip",
                                 'title'=>"Klik untuk menambahkan ke tabel Riwayat Kehamilamn")); ?>
                 </td>
               </tr>
             </table>
             <br/>
             <table class="table table-striped table-bordered table-condensed" style="width: 100%" id="tblRiwayatKehamilan">
               <thead>
                 <tr>
                     <th rowspan="2">Hamil Ke-</th>
                     <th rowspan="2">Umur Kehamilan <b/>(Minggu)</th>
                     <th colspan="2">Sex</th>
                     <th rowspan="2">Cara Persalinan</th>
                     <th rowspan="2">Penolong Persalinan</th>
                     <th rowspan="2">Tempat Persalinan</th>
                     <th colspan="2">Abortus</th>
                     <th rowspan="2">Komplikasi/ Keterangan</th>
                     <th rowspan="2">Batal</th>
                 </tr>
                 <tr>
                     <th width="50px">L</th>
                     <th width="50px">P</th>
                     <th width="50px">Ya</th>
                     <th width="50px">Tidak</th>
                 </tr>
               </thead>
               <tbody>
                  <?php
                      if(!empty($modRiwayatObstetrikPasien)){
                        foreach($modRiwayatObstetrikPasien as $i => $dataRiwayat){
                          ?>
                            <tr>
                              <td>
                                  <?php CHtml::hiddenField('RiwayatKehamilan['.$i.'][hamilke]',$dataRiwayat->kehamilan_hamilke,array('class'=>'hamilke')); ?>
                                  <?php CHtml::hiddenField('RiwayatKehamilan['.$i.'][umurkehamilan]',$dataRiwayat->kehamilan_umur,array('class'=>'umurkehamilan')); ?>
                                  <?php CHtml::hiddenField('RiwayatKehamilan['.$i.'][beratbadan]',$dataRiwayat->anak_beratbadanlahir,array('class'=>'beratbadan')); ?>
                                  <?php CHtml::hiddenField('RiwayatKehamilan['.$i.'][beratbadan_status]',$dataRiwayat->anak_satuanberatbadan,array('class'=>'beratbadan_status')); ?>
                                  <?php CHtml::hiddenField('RiwayatKehamilan['.$i.'][jeniskelamin]',$dataRiwayat->anak_jeniskelamin,array('class'=>'jeniskelamin')); ?>
                                  <?php CHtml::hiddenField('RiwayatKehamilan['.$i.'][carapersalinan]',$dataRiwayat->persalinan_cara,array('class'=>'carapersalinan')); ?>
                                  <?php CHtml::hiddenField('RiwayatKehamilan['.$i.'][penolongpersalinan]',$dataRiwayat->persalinan_penolong,array('class'=>'penolongpersalinan')); ?>
                                  <?php CHtml::hiddenField('RiwayatKehamilan['.$i.'][tempatpersalinan]',$dataRiwayat->persalinan_tempat,array('class'=>'tempatpersalinan')); ?>
                                  <?php CHtml::hiddenField('RiwayatKehamilan['.$i.'][abortus]',$dataRiwayat->isabortur,array('class'=>'abortus')); ?>
                                  <?php CHtml::hiddenField('RiwayatKehamilan['.$i.'][keterangan]',$dataRiwayat->persalinan_komplikasiket,array('class'=>'keterangan')); ?>
                                  <?php echo $dataRiwayat->kehamilan_hamilke; ?>
                              </td>
                              <td style='text-align: center'>
                                <?php echo $dataRiwayat->kehamilan_umur; ?>
                              </td>
                              <td>
                                <span class="<?php echo ((!empty($dataRiwayat->anak_jeniskelamin) && $dataRiwayat->anak_jeniskelamin == 'Laki-laki') ? "icon-form-check" : ""); ?>"></span>
                              </td>
                              <td>
                              <span class="<?php echo ((!empty($dataRiwayat->anak_jeniskelamin) && $dataRiwayat->anak_jeniskelamin == 'Perempuan') ? "icon-form-check" : ""); ?>"></span>
                              </td>
                              <td>
                                <?php echo $dataRiwayat->persalinan_cara; ?>
                              </td>
                              <td>
                                <?php echo $dataRiwayat->persalinan_penolong; ?>
                              </td>
                              <td>
                                <?php echo $dataRiwayat->persalinan_tempat; ?>
                              </td>
                              <td>
                              <span class="<?php echo (($dataRiwayat->isabortur == true) ? "icon-form-check" : ""); ?>"></span>
                                </td>
                              <td>
                              <span class="<?php echo (($dataRiwayat->isabortur == false) ? "icon-form-check" : ""); ?>"></span>
                              </td>
                              <td>
                                <?php echo $dataRiwayat->persalinan_komplikasiket; ?>
                              </td>
                              <td>
                              <a onclick='batalKehamilan(this);return false;' rel='tooltip' href='javascript:void(0);' title='Klik untuk membatalkan Riwayat Kehamilan'><i class='icon-remove'></i></a>
                              </td>
                            </tr>
                          <?php
                        }
                      }
                  ?>
               </tbody>
             </table>

           </div>
       </div>
       <div class="panel panel-primary panel-success">
          <div class="panel-heading">
              <div class="panel-title"><strong>Riwayat Hamil Ini</strong></div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="control-group ">
                   <?php echo CHtml::label('Gravid','', array('class'=>'control-label', 'style'=>'width: 50px')) ?>
                   <div class="controls">
                       <?php echo $form->textField($modAsesmenawalkeperawatanT,'khususanak_gravida_g',array('class'=>'span1 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                   </div>
                   <?php echo CHtml::label('Pratus','', array('class'=>'control-label', 'style'=>'width: 50px')) ?>
                   <div class="controls">
                       <?php echo $form->textField($modAsesmenawalkeperawatanT,'khususanak_gravida_p',array('class'=>'span1 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                   </div>
                 </div>
                 <div class="control-group ">
                    <?php echo CHtml::label('Abortus','', array('class'=>'control-label', 'style'=>'width: 50px')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modAsesmenawalkeperawatanT,'khususanak_gravida_a',array('class'=>'span1 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    </div>
                    <?php echo CHtml::label('Hidup','', array('class'=>'control-label', 'style'=>'width: 50px')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modAsesmenawalkeperawatanT,'khususanak_gravida_h',array('class'=>'span1 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    </div>
                  </div>
                <div class="control-group ">
                   <?php echo CHtml::label('Ante Natal Care','', array('class'=>'control-label')) ?>
                   <div class="controls">
                     <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'obgyn_antenatalcare_status',array('Tidak'=>'Tidak','Ya'=>'Ya') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'obgyn_antenatalcare_status','onclick'=>'setStatusAnteCare_obgyn();')); ?>
                   </div>
                 </div>
                 <div class="control-group ">
                    <?php echo CHtml::label('','', array('class'=>'control-label')) ?>
                    <div class="controls">
                      <div class="control-group ">
                         <?php echo CHtml::label('Di','', array('class'=>'control-label','style'=>'width: 50px')) ?>
                         <div class="controls">
                           <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'obgyn_antenatalcare_tempat',array('Dokter Kandungan'=>'Dokter Kandungan','Dokter Umum'=>'Dokter Umum','Dokter Bidan'=>'Dokter Bidan','Lainnya'=>'Lainnya') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'obgyn_antenatalcare_tempat disabledinputan','onclick'=>'setTempatAnteCare_obgyn();')); ?>
                           <br/>
                           <?php  echo $form->textField($modAsesmenawalkeperawatanT,'obgyn_antenatalcare_tempatlainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                         </div>
                     </div>

                     <div class="control-group ">
                        <?php echo CHtml::label('Frekuensi','', array('class'=>'control-label','style'=>'width: 80px')) ?>
                        <div class="controls">
                          <div class="radio inline">
                            <div class="form-inline">
                              <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'obgyn_antenatalcare_frekuensi',array('1x'=>'1x','2x'=>'2x','3x'=>'3x','> 3x'=>'> 3x') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'obgyn_antenatalcare_frekuensi disabledinputan','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                            </div>
                          </div>

                        </div>
                    </div>
                    </div>
                </div>

              </div>
              <div class="col-sm-6">
                <div class="control-group ">
                   <?php echo CHtml::label('Imunisasi TT','', array('class'=>'control-label')) ?>
                   <div class="controls">
                     <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'obgyn_imunisasittstatus',array('Tidak'=>'Tidak','Ya'=>'Ya') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'obgyn_imunisasittstatus','onclick'=>'setImunisasiStatus_obgyn();')); ?>
                     &nbsp; <?php  echo $form->textArea($modAsesmenawalkeperawatanT,'obgyn_imunisasittket',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                   </div>
                 </div>
                 <div class="control-group ">
                    <?php echo CHtml::label('Keluhan saat hamil','', array('class'=>'control-label')) ?>
                    <div class="controls">
                      <?php echo CHtml::hiddenField('KeluhanHamil[0][keluhanhamil]','Mual'); ?>
                      <?php echo CHtml::checkBox('KeluhanHamil[0][iskeluhanhamil]',false, array('datavalue'=>'Mual','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'keluhanhamil','onclick'=>'setKeluhanSaatHamil_obgyn();')); ?> <label>Mual</label>
                      &nbsp;&nbsp;&nbsp;
                      <?php echo CHtml::hiddenField('KeluhanHamil[1][keluhanhamil]','Sakit Kepala'); ?>
                      <?php echo CHtml::checkBox('KeluhanHamil[1][iskeluhanhamil]',false, array('datavalue'=>'Sakit Kepala','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'keluhanhamil','onclick'=>'setKeluhanSaatHamil_obgyn();')); ?> <label>Sakit Kepala</label>
                      <br/>
                      <?php echo CHtml::hiddenField('KeluhanHamil[2][keluhanhamil]','Muntah'); ?>
                      <?php echo CHtml::checkBox('KeluhanHamil[2][iskeluhanhamil]',false, array('datavalue'=>'Muntah','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'keluhanhamil','onclick'=>'setKeluhanSaatHamil_obgyn();')); ?> <label>Muntah</label>
                      &nbsp;&nbsp;&nbsp;
                      <?php echo CHtml::hiddenField('KeluhanHamil[3][keluhanhamil]','Lainnya'); ?>
                      <?php echo CHtml::checkBox('KeluhanHamil[3][iskeluhanhamil]',false, array('datavalue'=>'Lainnya','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'keluhanhamil','onclick'=>'setKeluhanSaatHamil_obgyn();')); ?> <label>Lainnya</label>
                      <br/>
                      <?php echo CHtml::hiddenField('KeluhanHamil[4][keluhanhamil]','Pendarahaan'); ?>
                      <?php echo CHtml::checkBox('KeluhanHamil[4][iskeluhanhamil]',false, array('datavalue'=>'Pendarahaan','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'keluhanhamil','onclick'=>'setKeluhanSaatHamil_obgyn();')); ?> <label>Pendarahan</label>
                      &nbsp;&nbsp;&nbsp;&nbsp;
                      <?php  echo $form->textField($modAsesmenawalkeperawatanT,'obgyn_keluhansaathamillainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    </div>
                  </div>
                  <div class="control-group ">
                     <?php echo CHtml::label('','', array('class'=>'control-label')) ?>
                     <div class="controls">
                       Jelaskan &nbsp;
                       <?php echo $form->textArea($modAsesmenawalkeperawatanT,'obgyn_penjelasankeluhan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                     </div>
                   </div>
              </div>
            </div>
          </div>
       </div>
   </div>
 </div>
</div>
