<?php $modAsesmenawalkeperawatanT->isskrinninggizidewasa = 0; ?>
<div class="row-fluid">
  <div class="panel panel-primary panel-success">
     <div class="panel-heading">
         <div class="panel-title"><?php echo $form->radioButton($modAsesmenawalkeperawatanT, 'isskrinninggizidewasa', array('onclick' => 'choiseSkrinningGizi_neonatus(this)', 'value' => 1, 'class'=>'pilih_SkrinningGizi', 'uncheckValue'=>null)); ?> <strong>Skrinning Gizi (Metode Malnutrition Skrinning Tools/ MST)</strong></div>
     </div>
      <div class="panel-body">
          <div class="table-responsive" style="overflow-x:auto;" id="skrinninggizi_dewasa_panel">
              <div class='block-tabel'>
                 <table class="items table table-bordered table-striped table-condensed" id="tblInputSkrinningGiziDewasa">
                     <thead>
                         <tr>
                             <th style="width: 10px">No</th>
                             <th>Parameter</th>
                             <th>Jawaban</th>
                             <th>Nilai</th>
                         </tr>
                      </thead>
                      <tbody>
                         <tr>
                             <th>1</th>
                             <th>Apakah pasien mengalami penurunan berat badan yang tidak direncanakan/tidak diinginkan dalam 6 bulan terakhir?</th>
                             <th>
                                 <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'skrinninggizi_jwb_penurunanbb_dewasa'); ?>
                                 <select id="<?php echo get_class($modAsesmenawalkeperawatanT); ?>skrinninggizi_jwb_penurunanbb_dewasa_text" name="<?php echo get_class($modAsesmenawalkeperawatanT); ?>[skrinninggizi_jwb_penurunanbb_dewasa_text]" class="span3" onkeypress="return $(this).focusNextInputField(event);" onchange="skrinninggizidewasa_penurunbb_neonatus(this);">
                                     <?php echo LookupM::getDropManual('skrininggizi_penurunanbb',$modAsesmenawalkeperawatanT->skrinninggizi_jwb_penurunanbb_dewasa) ?>
                                 </select>
                                 <?php //echo $form->dropDownList($modAsesmenawalkeperawatanT, 'skrinninggizi_jwb_penurunanbb_dewasa_text', CHtml::listData(LookupM::model()->findAll("lookup_type = 'skrininggizi_penurunanbb'"), 'lookup_value', 'lookup_name'), array('empty' => '-- Pilih --', 'class' => 'span3','onchange' => 'skrinninggizidewasa_penurunbb(this)')); ?>
                             </th>
                             <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinninggizi_skor_penurunanbb_dewasa', array('class' => 'span1 integer numberOnly skrinninggizidewasa_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                         </tr>
                         <tr>
                             <th>2</th>
                             <th>Apakah asuhan makan pasien berkurang karena penurunan nafsu makan/kesulitan menerima makan?</th>
                             <th>
                                 <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'skrinninggizi_jwb_asupanmakanan_dewasa'); ?>
                                 <?php echo $form->dropDownList($modAsesmenawalkeperawatanT,'skrinninggizi_jwb_asupanmakanan_dewasa_text',array('1'=>'Ya','0'=>'Tidak'), array('empty' => '-- Pilih --', 'class' => 'jeniskelaminAnak span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'skrinninggizidewasa_asupan_neonatus(this)'));?>
                             </th>
                             <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinninggizi_skor_asupanmakanan_dewasa', array('class' => 'span1 integer numbersOnly skrinninggizidewasa_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                         </tr>
                         <tr>
                             <th></th>
                             <th>Total</th>
                             <th></th>
                             <th> <?php echo  $form->textField($modAsesmenawalkeperawatanT,'skrinninggizi_skor_totaldewasa', array('value'=>'0','class'=>'span1 integer numberOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);",'maxlength'=>10,'readonly'=>true)).''; ?> </th>
                         </tr>
                         <tr>
                             <th colspan="2">Resiko</th>
                             <th colspan="2"> <?php echo  $form->textField($modAsesmenawalkeperawatanT,'skrininggizidewasa_resiko', array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)).''; ?> </th>
                         </tr>
                         <tr>
                             <th colspan="2">Tindakan yang dilakukan</th>
                             <th colspan="2"> <?php echo  $form->textField($modAsesmenawalkeperawatanT,'skrininggizidewasa_tindakanygdilakukan', array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)).''; ?> </th>
                         </tr>
                      </tbody>
                 </table>
             </div>
          </div>
      </div>
  </div>

    <div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title"><?php echo $form->radioButton($modAsesmenawalkeperawatanT, 'isskrinninggizidewasa', array('onclick' => 'choiseSkrinningGizi_neonatus(this)', 'value' => 0, 'class'=>'pilih_SkrinningGizi', 'uncheckValue'=>null)); ?> <strong>Skrinning Gizi (Metode Strong Kids)</strong></div>
        </div>
         <div class="panel-body">
             <div class="table-responsive" style="overflow-x:auto;" id="skrinninggizi_anak_panel">
                 <div class='block-tabel'>
                    <table class="items table table-bordered table-striped table-condensed" id="tblInputSkrinningGiziAnak">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th>Parameter</th>
                                <th>Jawaban</th>
                                <th>Nilai</th>
                            </tr>
                         </thead>
                         <tbody>
                            <tr>
                                <th>1</th>
                                <th>Apakah pasien tampak kurus?</th>
                                <th>
                                    <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'skrinninggizi_jwb_tampakkurus'); ?>
                                    <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'skrinninggizi_jwb_tampakkurus_text', array('Ya'=>'Ya','Tidak'=>'Tidak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'skrininggizianak_tampakkurus_neonatus(this)')); ?>
                                </th>
                                <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinninggizi_skor_tampakkurus', array('class' => 'span1 integer numberOnly skrinninggizianak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                            </tr>
                            <tr>
                                <th>2</th>
                                <th>Apakah terdapat penurunan BB selama 1 bulan terakhir? (Berdasarkan penilaian objektif)</th>
                                <th>
                                    <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'skrinninggizi_jwb_penurunanbb'); ?>
                                    <?php echo $form->dropDownList($modAsesmenawalkeperawatanT,'skrinninggizi_jwb_penurunanbb_text',array('Ya'=>'Ya','Tidak'=>'Tidak'), array('empty' => '-- Pilih --', 'class' => 'jeniskelaminAnak span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'skrininggizianak_bb_neonatus(this)'));?>
                                </th>
                                <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinninggizi_skor_penurunanbb', array('class' => 'span1 integer numbersOnly skrinninggizianak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                            </tr>
                            <tr>
                                <th>3</th>
                                <th>Apakah terdapat salah satu kodisi tersebut?</th>
                                <th>
                                    <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'skrinninggizi_jwb_kondisi'); ?>
                                    <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'skrinninggizi_jwb_kondisi_text', array('Ya'=>'Ya','Tidak'=>'Tidak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'skrininggizianak_kondisi_neonatus(this)')); ?>
                                </th>
                                <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinninggizi_skor_kondisi', array('class' => 'span1 integer numbersOnly skrinninggizianak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                            </tr>
                            <tr>
                                 <th></th>
                                <th>a. Diare ≥ 5 kali/hari dan atau muntah > 3 kali/hari dalam seminggu terakhir</th>
                                <th>
                                </th>
                                <th></th>
                            </tr>
                            <tr>
                                 <th></th>
                                <th>b. Asupan Makanan kurang selama 1 minggu terakhir</th>
                                <th>
                                </th>
                                <th></th>
                            </tr>
                            <tr>
                                <th>4</th>
                                <th>Apakah terdapat penyakit atau keadaan yang mengakibatkan pasien beresiko malnutrisi dan sudah malnutrisi? (Gizi Buruk)</th>
                                <th>
                                    <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'skrinninggizi_jwb_penyakit'); ?>
                                    <?php echo $form->dropDownList($modAsesmenawalkeperawatanT, 'skrinninggizi_jwb_penyakit_text', array('Ya'=>'Ya','Tidak'=>'Tidak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'skrininggizianak_penyakit_neonatus(this)')); ?>
                                </th>
                                <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinninggizi_skor_penyakit', array('class' => 'span1 integer numbersOnly skrinninggizianak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>Total</th>
                                <th></th>
                                <th> <?php echo  $form->textField($modAsesmenawalkeperawatanT,'skrinninggizi_skor_totalanak', array('class'=>'span1 integer numberOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);",'maxlength'=>10,'readonly'=>true)).''; ?> </th>
                            </tr>
                         </tbody>
                    </table>
                </div>
             </div>
         </div>
     </div>

   <div class="panel panel-primary panel-success">
      <div class="panel-heading">
          <div class="panel-title"><strong>Status Nutrisi</strong></div>
      </div>
       <div class="panel-body">
         <div class="row">
           <div class="col-sm-6">
             <div class="control-group ">
                     <?php echo CHtml::Label('Tinggi Badan / Panjang Badan','',array('class'=>'control-label'));?>
                     <div class="controls">
                             <div class="groupUkurans">
                                     <?php echo $form->textField($modAsesmenawalkeperawatanT,'tinggibadan_cm',array('class'=>'span1 numbersOnly tinggibadan', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3,'size'=>3, 'style'=>'text-align:right;'));?>
                                     <?php echo $form->hiddenField($modAsesmenawalkeperawatanT,'tinggibadan_cm',array('class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3,'size'=>3));?>
                                     <?php echo CHtml::dropDownList('meter', '100', array('100'=>'Cm', '0.01'=>'M'), array('style'=>'width:50px;','class'=>'span1', 'onchange'=>'gantiJumlah_neonatus(this)')); ?>
                             </div>
                     </div>
             </div>
             <div class="control-group ">
                     <?php echo CHtml::Label('Berat Badan','',array('class'=>'control-label'));?>
                     <div class="controls">
                             <div class="groupUkurans">
                                     <?php echo $form->textField($modAsesmenawalkeperawatanT,'beratbadan_kg',array('class'=>'span1 numbersOnly beratbadan', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10,'size'=>3, 'style'=>'text-align:right;'));?>
                                     <?php echo $form->hiddenField($modAsesmenawalkeperawatanT,'beratbadan_kg',array('class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10,'size'=>3));?>
                                     <?php echo CHtml::dropDownList('gram', '0.001', array('1000'=>'Gr', '0.001'=>'Kg'), array('class'=>'span1', 'onchange'=>'gantiJumlah_neonatus(this)')); ?>
                             </div>
                     </div>
             </div>
             <div class="control-group ">
                     <?php echo $form->LabelEx($modAsesmenawalkeperawatanT,'bb_ideal',array('class'=>'control-label'));?>
                     <div class="controls">
                             <?php echo $form->textField($modAsesmenawalkeperawatanT,'bb_ideal',array('class'=>'span2 integer numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10, 'readonly'=>true)).' ';?>Kg
                     </div>
             </div>
             <div class="control-group ">
                     <label class='control-label'>Index Masa Tubuh</label>
                     <div class="controls">
                             <?php echo CHtml::textField('imtValue', '', array('readonly'=>true, 'class'=>'span1'));?>
                             <?php echo CHtml::textField('imt', '', array('readonly'=>true, 'class'=>'span2'));?>
                     </div>
             </div>

           </div>
           <div class="col-sm-6">
             <div class="control-group ">
                     <?php echo $form->LabelEx($modAsesmenawalkeperawatanT,'beratbadan_biasanya',array('class'=>'control-label','label'=>'Berat Badan Biasanya'));?>
                     <div class="controls">
                             <?php echo $form->textField($modAsesmenawalkeperawatanT,'beratbadan_biasanya',array('class'=>'span2 float', 'maxlength'=>5, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align:right;'));?>
                      Kg
                     </div>
             </div>
           </div>
         </div>
       </div>
   </div>
</div>
