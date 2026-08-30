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
                                    <?php echo CHtml::activeRadioButtonList($modAsesmenawalkeperawatanT,'isadaresikojatuh',array(0=>'Tidak',1=>'Ya') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','onclick'=>'cekInput(this)')); ?>
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
                     </td>formAnak
                 </tr>
             </table>
             <br>
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
         </div>
     </div>

</div>

<script type='text/javascript'>
    const cekInput = (obj) => {
        var cek = $("#RIAsesmenawalkeperawatanT_isadaresikojatuh:checked").val();
        if(cek == 1){
            $(".RIAsesmenawalkeperawatanT_resikojatuh_tingkat").removeAttr('readonly');
        }else{
            $(".RIAsesmenawalkeperawatanT_resikojatuh_tingkat").attr('readonly',true);
        }
    }
</script>
