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
                <div class="panel panel-primary panel-success" id="panelresikojatuh_rj">
                    <div class="panel-heading">
                        <div class="panel-title"><strong>Skrinning Resiko Jatuh Rawat Jalan (Metode Get Up and Go)</strong></div>
                    </div>
                    <div class="panel-body">
                        <div id="resikojatuhdewasa">
                            <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'jenisresikojatuh', array('value'=>'dewasa')); ?>
                            <div class="table-responsive" style="overflow-x:auto;">
                                <div class='block-tabel'>
                                <table class="items table table-bordered table-striped table-condensed" id="tblResikojatuhRj">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Pengkajian</th>
                                            <th>Penilaian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr>
                                            <th>a.</th>
                                            <th>Perhatikan cara berjalan pasien saat akan duduk di kursi (salah satu atau lebih)<br/>1. Tidak seimbang/ sempoyongan/ limbung <br/>2. Jalan dengan menggunakan alat bantu (kruk, tripad, kursi roda, orang lain)</th>
                                            <th>
                                                <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'resikojatuhkhususrj_hasilpenilaian_a', array(1=>'Ya',0=>'Tidak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'resikojatuhrj_penilaian_dws()'));
                                                ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>b.</th>
                                            <th>Menopang saat akan duduk: tampak memegang pinggiran kursi atau meja/ benda lain sebagai penopang saat akan duduk</th>
                                            <th>
                                                <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'resikojatuhkhususrj_hasilpenilaian_b', array(1=>'Ya',0=>'Tidak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'resikojatuhrj_penilaian_dws()'));
                                                ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Hasil Pengkajian</th>
                                            <th> <?php echo  $form->textField($modAsesmenawalkeperawatanT,'resikojatuhkhususrj_hasilpengkajian', array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?> </th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Tindakan</th>
                                            <th> <?php echo $form->textArea($modAsesmenawalkeperawatanT,'resikojatuhkhususrj_tindakanygdiperlukan', array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?> </th>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <!-- <div class="table-responsive" style="overflow-x:auto;">
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
                                                    <?php //echo $form->hiddenField($modAsesmenawalkeperawatanT, 'riwayatjatuh_penilaian'); ?>
                                                    <?php //echo $form->dropDownList($modAsesmenawalkeperawatanT, 'riwayatjatuh_penilaian_text', array('Ya'=>'Ya','Tidak'=>'Tidak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'resikojatuhdewasa_penilaian_dws(this)'));
                                                    ?>
                                                </th>
                                                <th><?php //echo $form->textField($modAsesmenawalkeperawatanT, 'riwayatjatuh_skor', array('class' => 'span1 integer numbersOnly resikojatuhdewasa_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                            </tr>
                                            <tr>
                                                <th>2</th>
                                                <th>Diagnosa Sekunder, Apakah pasien memiliki lebih dari satu penyakit?</th>
                                                <th>
                                                    <?php //echo $form->hiddenField($modAsesmenawalkeperawatanT, 'diagnosismedis_penilaian'); ?>
                                                    <?php //echo $form->dropDownList($modAsesmenawalkeperawatanT, 'diagnosismedis_penilaian_text', array('Ya'=>'Ya','Tidak'=>'Tidak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'resikojatuhdewasa_diagnosa_dws(this)'));
                                                    ?>
                                                </th>
                                                <th><?php //echo $form->textField($modAsesmenawalkeperawatanT, 'diagnosismedis_skor', array('class'=>'span1 integer numberOnly resikojatuhdewasa_skor',  'onkeypress'=>"return $(this).focusNextInputField(event);",'maxlength'=>10,'readonly'=>true)).' '; ?></th>
                                            </tr>
                                            <tr>
                                                <th>3</th>
                                                <th>Alat Bantu Jalan</th>
                                                <th>
                                                    <?php //echo $form->hiddenField($modAsesmenawalkeperawatanT, 'alatbantujalan_penilaian'); ?>
                                                    <?php //echo $form->dropDownList($modAsesmenawalkeperawatanT, 'alatbantujalan_penilaian_text',LookupM::getItems('resikojatuhlansia_alatbantu'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'resikojatuhdewasa_alatbantu_dws(this)'));
                                                    ?>  
                                                </th>
                                                <th>
                                                    <?php //echo $form->textField($modAsesmenawalkeperawatanT, 'alatbantujalan_skor', array('class'=>'span1 integer numberOnly resikojatuhdewasa_skor',  'onkeypress'=>"return $(this).focusNextInputField(event);",'maxlength'=>10,'readonly'=>true)).''; ?>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>4</th>
                                                <th>Terapi Intrevena, Apakah saat ini pasien terpasang infus?</th>
                                                <th>
                                                    <?php //echo $form->hiddenField($modAsesmenawalkeperawatanT, 'memakaiterapiheparin_penilaian'); ?>
                                                    <?php //echo $form->dropDownList($modAsesmenawalkeperawatanT, 'memakaiterapiheparin_penilaian_text', array('Ya'=>'Ya','Tidak'=>'Tidak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'resikojatuhdewasa_terapi_dws(this)'));?>  
                                                </th>
                                                <th>
                                                    <?php //echo $form->textField($modAsesmenawalkeperawatanT,'memakaiterapiheparin_skor', array('class'=>'span1 integer numberOnly resikojatuhdewasa_skor', 'onkeypress'=>"return $(this).focusNextInputField(event);",'maxlength'=>10,'readonly'=>true)).''; ?> 
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>5</th>
                                                <th>Cara Berjalan/ Berpindah</th>
                                                <th>
                                                    <?php //cho $form->hiddenField($modAsesmenawalkeperawatanT, 'caraberjalan_penilaian'); ?>
                                                    <?php //echo $form->dropDownList($modAsesmenawalkeperawatanT, 'caraberjalan_penilaian_text',LookupM::getItems('resikojatuhlansia_caraberjalan'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'resikojatuhdewasa_berjalan_dws(this)'));
                                                ?>
                                                </th>
                                                <th> 
                                                    <?php //echo $form->textField($modAsesmenawalkeperawatanT,'caraberjalan_skor', array('class'=>'span1 integer numberOnly resikojatuhdewasa_skor', 'onkeypress'=>"return $(this).focusNextInputField(event);",'maxlength'=>10,'readonly'=>true)).''; ?> 
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>6</th>
                                                <th>Status Mental</th>
                                                <th>
                                                    <?php //echo $form->hiddenField($modAsesmenawalkeperawatanT, 'statusmental_penilaian'); ?>
                                                    <?php //echo $form->dropDownList($modAsesmenawalkeperawatanT, 'statusmental_penilaian_text',LookupM::getItems('resikojatuhlansia_statusmental'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'resikojatuhdewasa_mental_dws(this)'));?>
                                                </th>
                                                <th> 
                                                    <?php //echo  $form->textField($modAsesmenawalkeperawatanT,'statusmental_skor', array('class'=>'span1 integer numberOnly resikojatuhdewasa_skor', 'onkeypress'=>"return $(this).focusNextInputField(event);",'maxlength'=>10,'readonly'=>true)).''; ?> 
                                                </th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th>Total Score</th>
                                                <th> <?php //echo  $form->textField($modAsesmenawalkeperawatanT,'resikojatuh_skor', array('class'=>'span1 integer numberOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);",'maxlength'=>10,'readonly'=>true)).''; ?> </th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th>Hasil Resiko Jatuh</th>
                                                <th> <?php //echo $form->textField($modAsesmenawalkeperawatanT,'resikojatuh_keterangan', array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true,)).''; ?> </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div> -->

                        </div>
                    </div>
                </div>

         </div>
     </div>

</div>
