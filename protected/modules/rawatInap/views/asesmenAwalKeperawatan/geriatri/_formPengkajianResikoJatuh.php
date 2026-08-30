<style>
    #tblResikojatuhLansia tr th div h5{
        color:black;
        font-weight: bold;
    }
</style>
<div class="row-fluid">
     <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Pengkajian Resiko Jatuh</strong></div>
        </div>
         <div class="panel-body">
             <table width="100%">
                 <tr>
                     <td width="120px">
                         <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'isadaresikojatuh', array('class'=>'control-label')) ?>ssss
                     </td>
                     <td width="100px">
                         <div class="controls">
                            <div class="form-inline">
                                <div class="radio inline">
                                    <?php echo CHtml::activeRadioButtonList($modAsesmenawalkeperawatanT,'isadaresikojatuh',array(0=>'Tidak',1=>'Ya') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','class'=>'isadaresikojatuh', 'onclick'=>'cekInput(this)')); ?>
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

             <div class="panel panel-primary panel-success" id="panelresikojatuh_lansia">
                <div class="panel-heading">
                    <div class="panel-title"><strong>Skrinning Resiko Lansia (Ontario Modified-Sidney Scoring)</strong></div>
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
                                               <?php echo CHtml::radioButtonList('riwayatJatuhRSLansia','',array("1"=>"<h5>YA</h5>","0"=>"<h5>TIDAK</h5>"), array('class'=>'riwayatJatuh','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','onchange'=>'setRiwayatJatuh_geriatri(this)'));?>
                                           </div>
                                       </th>
                                       <th rowspan="2"><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skor_resiko_jatuh_lansia', array('class' => 'span1 integer numbersOnly skor_resiko_jatuh_lansia resikojatuhlansia_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                   </tr>
                                   <tr>
                                       <th>Jika tidak, apakah pasien mengalami jatuh dalam 2 bulan</th>
                                       <th>
                                           <div class="form-inline">
                                               <?php echo CHtml::radioButtonList('riwayatJatuhBulanLansia','',array("1"=>"<h5>YA</h5>","0"=>"<h5>TIDAK</h5>"), array('class'=>'riwayatJatuh','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','onchange'=>'setRiwayatJatuh_geriatri(this)'));?>
                                           </div>
                                       </th>
                                   </tr>
                                   <tr>
                                       <th rowspan="3">2</th>
                                       <th rowspan="3">Status Mental</th>
                                       <th>Apakah pasien delirium? (tidak dapat membuat keputusan, pola pikir tidak terorganisir, gangguan daya ingat)</th>
                                       <th>
                                           <?php echo $form->hiddenField($modAsesmenawalkeperawatanT,'status_mental_lansia', array('class'=>'status_mental_lansia')); ?>
                                           <div class=>
                                               <?php echo CHtml::radioButtonList('statusMentalDeliriumLansia','',array("1"=>"<h5>YA</h5>","0"=>"<h5>TIDAK</h5>"), array('class'=>'statusMentalLansia','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','onchange'=>'setStatusMental_geriatri(this)'));?>
                                           </div>
                                       </th>
                                       <th rowspan="3"><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skor_status_mental_lansia', array('value'=>'0','class' => 'span1 integer numbersOnly skor_status_mental_lansia resikojatuhlansia_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                   </tr>
                                   <tr>
                                       <th>Apakah pasien disorientasi? (salah menyebut waktu, tempat atau orang)</th>
                                       <th>
                                           <div class="form-inline">
                                               <?php echo CHtml::radioButtonList('statusMentalDisorientasiLansia','',array("1"=>"<h5>YA</h5>","0"=>"<h5>TIDAK</h5>"), array('class'=>'statusMentalLansia','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','onchange'=>'setStatusMental_geriatri(this)'));?>
                                           </div>
                                       </th>
                                   </tr>
                                   <tr>
                                       <th>Apakah pasien mengalami agitasi? (ketakutan, kecemasan, gelisah)</th>
                                       <th>
                                           <div class="form-inline">
                                               <?php echo CHtml::radioButtonList('statusMentalAgitasiLansia','',array("1"=>"<h5>YA</h5>","0"=>"<h5>TIDAK</h5>"), array('class'=>'statusMentalLansia','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','onchange'=>'setStatusMental_geriatri(this)'));?>
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
                                               <?php echo CHtml::radioButtonList('penglihatanKacamataLansia','',array("1"=>"<h5>YA</h5>","0"=>"<h5>TIDAK</h5>"), array('class'=>'penglihatanLansia','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','onchange'=>'setPengelihatan_geriatri(this)'));?>
                                           </div>
                                       </th>
                                       <th rowspan="3"><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skor_penglihatan_lansia', array('value'=>'0','class' => 'skor_penglihatan_lansia span1 integer numbersOnly resikojatuhlansia_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                   </tr>
                                   <tr>
                                       <th>Apakah pasien mengeluhkan penglihatan buram?</th>
                                       <th>
                                           <div class="form-inline">
                                               <?php echo CHtml::radioButtonList('penglihatanBuramLansia','',array("1"=>"<h5>YA</h5>","0"=>"<h5>TIDAK</h5>"), array('class'=>'penglihatanLansia','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','onchange'=>'setPengelihatan_geriatri(this)'));?>
                                           </div>
                                       </th>
                                   </tr>
                                   <tr>
                                       <th>Apakah pasien mengalami glaucoma, katarak, degenerasi macula?</th>
                                       <th>
                                           <div class="form-inline">
                                               <?php echo CHtml::radioButtonList('penglihatanKatarakLansia','',array("1"=>"<h5>YA</h5>","0"=>"<h5>TIDAK</h5>"), array('class'=>'penglihatanLansia','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','onchange'=>'setPengelihatan_geriatri(this)'));?>
                                           </div>
                                       </th>
                                   </tr>
                                   <tr>
                                       <th>4</th>
                                       <th>Kebiasaan berkemih</th>
                                       <th>Apakah terdapat perubahan prilaku berkemih? (frekuensi, urgensi, inkotenensia, nokturia)</th>
                                       <th>
                                           <div class="form-inline">
                                               <?php echo CHtml::activeRadioButtonList($modAsesmenawalkeperawatanT,'kebiasaan_berkemih_lansia',array("1"=>"<h5>YA</h5>","0"=>"<h5>TIDAK</h5>"), array('class'=>'kebiasaanBerkemihLansia','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;','onchange'=>'setKebiasaanBerkemih_geriatri(this)'));?>
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
                                           <?php echo CHtml::dropDownList('transferLansia', '',LookupM::getItems('resikojatuh_transfer_lansia'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'getTransferLansia_geriatri()'));?>
                                       </th>
                                       <th rowspan="2"><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skor_transfer_mobilitas_lansia', array('value'=>'0','class' => 'skor_transfer_mobilitas_lansia span1 integer numbersOnly resikojatuhlansia_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                   </tr>
                                   <tr>
                                       <th>6</th>
                                       <th>Mobilitas</th>
                                       <th colspan="2">
                                           <?php echo $form->hiddenField($modAsesmenawalkeperawatanT,'mobilitas_lansia',array('class'=>'mobilitas_lansia')); ?>
                                           <?php echo CHtml::hiddenField('mobilitasLansiaHidden',''); ?>
                                           <?php echo CHtml::dropDownList('mobilitasLansia', '',LookupM::getItems('resikojatuh_mobilitas_lansia'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'getMobilitasLansia_geriatri()'));?>
                                       </th>
                                   </tr>
                                   <tr>
                                       <th colspan="4">Total Score</th>
                                       <th> <?php echo $form->textField($modAsesmenawalkeperawatanT,'jumlah_skor_lansia', array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true,)).''; ?> </th>
                                   </tr>
                                   <tr>
                                       <th colspan="3">Keterangan Skor</th>
                                       <th colspan="2"> <?php echo $form->textField($modAsesmenawalkeperawatanT,'keterangan_skor_lansia', array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true,)).''; ?> </th>
                                   </tr>
                               </table>
                           </div>
                        </div>
                    </div>

                 </div>
             </div>

         </div>
     </div>

</div>
