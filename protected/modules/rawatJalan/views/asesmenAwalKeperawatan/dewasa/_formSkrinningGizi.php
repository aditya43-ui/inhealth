<?php if(Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RJ){
  $modAsesmenawalkeperawatanT->isskrinninggizidewasa = 1;
} ?>
<div class="row-fluid">
     <div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title"><?php echo $form->radioButton($modAsesmenawalkeperawatanT, 'isskrinninggizidewasa', array('onclick' => 'choiseSkrinningGizi_dws(this)', 'value' => 1, 'class'=>'pilih_SkrinningGizi', 'uncheckValue'=>null)); ?> <strong>Skrinning Gizi Dewasa (Metode Malnutrition Skrinning Tools/ MST)</strong></div>
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
                                    <select id="<?php echo get_class($modAsesmenawalkeperawatanT); ?>skrinninggizi_jwb_penurunanbb_dewasa_text" name="<?php echo get_class($modAsesmenawalkeperawatanT); ?>[skrinninggizi_jwb_penurunanbb_dewasa_text]" class="span3" onkeypress="return $(this).focusNextInputField(event);" onchange="skrinninggizidewasa_penurunbb_dws(this);">
                                        <?php echo LookupM::getDropManual('skrininggizi_penurunanbb',$modAsesmenawalkeperawatanT->skrinninggizi_jwb_penurunanbb_dewasa) ?>
                                    </select>
                                    <?php //echo $form->dropDownList($modAsesmenawalkeperawatanT, 'skrinninggizi_jwb_penurunanbb_dewasa_text', CHtml::listData(LookupM::model()->findAll("lookup_type = 'skrininggizi_penurunanbb'"), 'lookup_value', 'lookup_name'), array('empty' => '-- Pilih --', 'class' => 'span3','onchange' => 'skrinninggizidewasa_penurunbb_dws(this)')); ?>
                                </th>
                                <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinninggizi_skor_penurunanbb_dewasa', array('class' => 'span1 integer numberOnly skrinninggizidewasa_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                            </tr>
                            <tr>
                                <th>2</th>
                                <th>Apakah asuhan makan pasien berkurang karena penurunan nafsu makan/kesulitan menerima makan?</th>
                                <th>
                                    <?php echo $form->hiddenField($modAsesmenawalkeperawatanT, 'skrinninggizi_jwb_asupanmakanan_dewasa'); ?>
                                    <?php echo $form->dropDownList($modAsesmenawalkeperawatanT,'skrinninggizi_jwb_asupanmakanan_dewasa_text',array('0'=>'Ya','1'=>'Tidak'), array('empty' => '-- Pilih --', 'class' => 'jeniskelaminAnak span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'skrinninggizidewasa_asupan_dws(this)'));?>
                                </th>
                                <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinninggizi_skor_asupanmakanan_dewasa', array('class' => 'span1 integer numbersOnly skrinninggizidewasa_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>Total</th>
                                <th></th>
                                <th> <?php echo  $form->textField($modAsesmenawalkeperawatanT,'skrinninggizi_skor_totaldewasa', array('value'=>'0','class'=>'span1 integer numberOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);",'maxlength'=>10,'readonly'=>true)).''; ?> </th>
                            </tr>
                         </tbody>
                    </table>
                     <br>
                    <p>Catatan: <br>Skor ≥ 2 dilakukan pengkajian lanjut oleh ahli gizi<p>
                </div>
             </div>
         </div>
     </div>

   <div class="panel panel-primary panel-success">
      <div class="panel-heading">
          <div class="panel-title"><strong>Nutrisi</strong></div>
      </div>
       <div class="panel-body">
         <div class="row">
           <div class="col-sm-6">
             <div class="control-group">
                 <label class="control-label">Diet saat ini</label>
                 <div class="controls">
                   <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'nutrisi_dietsaatini', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                 </div>
             </div>
           </div>
           <div class="col-sm-6">
             <div class="control-group">
                 <label class="control-label">Penurunan/Kenaikan berat badan selama 6 bulan terakhir</label>
                 <div class="controls">
                     <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'nutrisi_perubahanbb6blnterakhir', array('Tidak'=>'Tidak','Ya'=>'Ya'), array('class'=>'nutrisi_perubahanbb6blnterakhir','onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>'setNutrisiPerubahanBB();')); ?>
                 </div>
             </div>
             <div class="control-group">
                 <label class="control-label"></label>
                 <div class="controls">
                   Jelaskan <br />
                   <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'nutrisi_perubahanbb6blnterakhirket', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                 </div>
             </div>
           </div>
         </div>
       </div>
   </div>

</div>
