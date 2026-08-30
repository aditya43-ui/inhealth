<div class="row">
    <div class="col-sm-12">
        <div class="control-group" >
            <label class="control-label required jumlahjaninLabel">Jumlah Janin <span class="required">*</span><i class="<?php echo MyIcon::getIcons('info2') ?> txthitam"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Sebagai acuan jumlah pemeriksaan janin" data-html="true"></i></label>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'jumlahjanin', array('class' => 'span1 integer')); ?> 
               <?php echo $form->radioButton($model, 'jumlahjanin_ket', array('onclick' => 'pilihJumlahJaninTrs1(this)', 'value' => 'Tunggal', 'class'=>'pilih_trs', 'uncheckValue'=>null)); ?> <label>Tunggal</label>
            </div>
        </div> 
        <div class="control-group" >
            <label class="control-label"></label>
            <div class="controls">
               <?php echo $form->radioButton($model, 'jumlahjanin_ket', array('onclick' => 'pilihJumlahJaninTrs1(this)', 'value' => 'Gemeli', 'class'=>'pilih_trs', 'uncheckValue'=>null)); ?> <label>Gemeli</label>
            </div>
        </div> 
        <div class="control-group" >
            <label class="control-label"></label>
            <div class="controls">
               <?php echo $form->radioButton($model, 'jumlahjanin_ket', array('onclick' => 'pilihJumlahJaninTrs1(this)', 'value' => 'Triple', 'class'=>'pilih_trs', 'uncheckValue'=>null)); ?> <label>Triple</label>
            </div>
        </div> 
        <div class="control-group" >
            <label class="control-label"></label>
            <div class="controls">
               <?php echo $form->radioButton($model, 'jumlahjanin_ket', array('onclick' => 'pilihJumlahJaninTrs1(this)', 'value' => 'Lainnya', 'class'=>'pilih_trs', 'uncheckValue'=>null)); ?> <label>Lainnya</label>
            </div>
            <div class="controls">
               <?php echo $form->textField($model, 'jumlahjaninlain', array('class' => 'span1 integer','readonly'=>true,'onkeyup'=>'addJumlahjaninTrs1()')); ?> 
            </div>
            
        </div> 
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Input Hasil Pemeriksaan Janin</div>
    </div>
    <div class="panel-body">
        <div style="overflow-x: auto;">
            <table class="items table table-bordered" id="tbltrimester_1">
                <thead>
                    <tr>
                        <th class="text-center" rowspan="2" style="width:50px">Janin Ke-</th>  
                        <th class="text-center" rowspan="2" style="width:100px">Kantong Kehamilan</th>
                        <th class="text-center" rowspan="2" style="width:200px !important">Fetal Echo</th>
                        <th class="text-center" rowspan="2" style="width:100px">Letak Kehamilan</th>
                        <th class="text-center" rowspan="2" style="width:100px">Pulsasi</th>
                        <th class="text-center" colspan="4"  style="width:400px">Biometri</th>
                        <th class="text-center" rowspan="2" style="width:200px">PATOLOGI</th>
                        <th class="text-center" colspan="4">Kesimpulan</th>
                    </tr>
                    <tr>
                        <th class="text-center" style="width:80px">GS (Gestational Sac)</th>
                        <th class="text-center" style="width:80px">CRL (Crown Rump Length)</th>
                        <th class="text-center" style="width:100px">BPD (Biparietal Diameter)</th>
                        <th class="text-center" style="width:100px">FL (Femur Length)</th>
                        
                        <th class="text-center" rowspan="2" style="width:150px">Denyut Jantung Janin (Kali/Menit)</th>
                        <th class="text-center" rowspan="2" style="width:15px">Gravid (Minggu)</th>
                        <th class="text-center" rowspan="2" style="width:150px">Taksiran Melahirkan</th>
                        <th class="text-center" rowspan="2" style="width:200px">Secara Keseluruhan Janin dalam Kondisi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(count($modDetailUsg) > 0){
                            foreach ($modDetailUsg as $i => $dataDet){
                                $dataDet->biometri_gs = (isset($dataDet->biometri_gs)?MyFormatter::formatNumberForPrint($dataDet->biometri_gs,2):0);
                                $dataDet->biometri_crl = (isset($dataDet->biometri_crl)?MyFormatter::formatNumberForPrint($dataDet->biometri_crl,2):0);
                                $dataDet->biometri_bpd = (isset($dataDet->biometri_bpd)?MyFormatter::formatNumberForPrint($dataDet->biometri_bpd,2):0);
                                $dataDet->biometri_fl = (isset($dataDet->biometri_fl)?MyFormatter::formatNumberForPrint($dataDet->biometri_fl,2):0);
                                $dataDet->taksiranmelahirkan = (isset($dataDet->taksiranmelahirkan)?MyFormatter::formatDateTimeForUser($dataDet->taksiranmelahirkan,2):null);
                            ?>
                                <tr>
                                    <td>
                                        <?php echo CHtml::activeHiddenField($dataDet,'['.$i.']janinke',array('class'=>'janinke')) ?>
                                        <span class="janinkeSpan"><?php echo $dataDet->janinke; ?></span>
                                    </td>
                                    <td>
                                        <div class="radio_mainkantongkehamilan" style="width:80px !important">
                                            <?php echo CHtml::activeRadioButtonList($dataDet,'['.$i.']kantongkehamilan', array('Ada'=>'Ada','Tidak Ada'=>'Tidak Ada'), array('class'=>'kantongkehamilan')) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="radio_mainfetalecho" style="width:80px !important">
                                            <?php echo CHtml::activeRadioButtonList($dataDet,'['.$i.']fetalecho', array('Ada'=>'Ada','Tidak Ada'=>'Tidak Ada'), array('class'=>'fetalecho')) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="radio_mainletakkantong" style="width:80px !important">
                                            <?php echo CHtml::activeRadioButtonList($dataDet,'['.$i.']letakkehamilan', array('Intra Uteri'=>'Intra Uteri','Ektra Uteri'=>'Ektra Uteri'), array('class'=>'letakkehamilan')) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="radio_mainpulsasi" style="width:80px !important">
                                            <?php echo CHtml::activeRadioButtonList($dataDet,'['.$i.']pulsasi', array('Ada'=>'Ada','Tidak Ada'=>'Tidak Ada'), array('class'=>'pulsasi')) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo CHtml::activeTextField($dataDet,'['.$i.']biometri_gs',array('class'=>'biometri_gs span1 integer-decimal')) ?> cm
                                    </td>
                                    <td>
                                        <?php echo CHtml::activeTextField($dataDet,'['.$i.']biometri_crl',array('class'=>'biometri_crl span1 integer-decimal')) ?> cm
                                    </td>
                                    <td>
                                        <?php echo CHtml::activeTextField($dataDet,'['.$i.']biometri_bpd',array('class'=>'biometri_bpd span1 integer-decimal')) ?> cm
                                    </td>
                                    <td>
                                        <?php echo CHtml::activeTextField($dataDet,'['.$i.']biometri_fl',array('class'=>'biometri_fl span1 integer-decimal')) ?> cm
                                    </td>
                                    <td>
                                        <?php echo CHtml::activeTextArea($dataDet,'['.$i.']patologi',array('class'=>'patologi span2')) ?>
                                    </td>
                                    <td>
                                        <?php echo CHtml::activeTextField($dataDet,'['.$i.']denyutjantungjanin',array('class'=>'denyutjantungjanin span1 integer2')) ?>
                                    </td>
                                    <td>
                                        <?php echo CHtml::activeTextField($dataDet,'['.$i.']gravid',array('class'=>'gravid span2')) ?>
                                    </td>
                                    <td>
                                        <div class="controls">
                                            <?php $this->widget('MyDateTimePicker',array(
                                                'model'=>$dataDet,
                                                'attribute'=>'['.$i.']taksiranmelahirkan',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>PARAMS::DATE_FORMAT,
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'span2 taksiranmelahirkan', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                                        )); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo CHtml::activeTextArea($dataDet,'['.$i.']kondisijaninkeseluruhan',array('class'=>'kondisijaninkeseluruhan span2')) ?>
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
</div>