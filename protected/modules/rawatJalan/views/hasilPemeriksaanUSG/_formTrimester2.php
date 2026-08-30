<div class="row">
    <div class="col-sm-12">
        <div class="control-group" >
            <label class="control-label required jumlahjaninLabel">Jumlah Janin <span class="required">*</span><i class="<?php echo MyIcon::getIcons('info2') ?> txthitam"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Sebagai acuan jumlah pemeriksaan janin" data-html="true"></i></label>
            <div class="controls">
               <?php echo $form->hiddenField($model, 'jumlahjanin', array('class' => 'span1 integer')); ?> 
               <?php echo $form->radioButton($model, 'jumlahjanin_ket', array('onclick' => 'pilihJumlahJaninTrs2(this)', 'value' => 'Tunggal', 'class'=>'pilih_trs', 'uncheckValue'=>null)); ?> <label>Tunggal</label>
            </div>
        </div> 
        <div class="control-group" >
            <label class="control-label"></label>
            <div class="controls">
               <?php echo $form->radioButton($model, 'jumlahjanin_ket', array('onclick' => 'pilihJumlahJaninTrs2(this)', 'value' => 'Gemeli', 'class'=>'pilih_trs', 'uncheckValue'=>null)); ?> <label>Gemeli</label>
            </div>
        </div> 
        <div class="control-group" >
            <label class="control-label"></label>
            <div class="controls">
               <?php echo $form->radioButton($model, 'jumlahjanin_ket', array('onclick' => 'pilihJumlahJaninTrs2(this)', 'value' => 'Triple', 'class'=>'pilih_trs', 'uncheckValue'=>null)); ?> <label>Triple</label>
            </div>
        </div> 
        <div class="control-group" >
            <label class="control-label"></label>
            <div class="controls">
               <?php echo $form->radioButton($model, 'jumlahjanin_ket', array('onclick' => 'pilihJumlahJaninTrs2(this)', 'value' => 'Lainnya', 'class'=>'pilih_trs', 'uncheckValue'=>null)); ?> <label>Lainnya</label>
            </div>
            <div class="controls">
               <?php echo $form->textField($model, 'jumlahjaninlain', array('class' => 'span1 integer','readonly'=>true,'onkeyup'=>'addJumlahjaninTrs2()')); ?> 
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
            <table class="items table table-bordered" id="tbltrimester_2" style="width:2500px !important">
                <thead>
                    <tr>
                        <th class="text-center" rowspan="2" style="width:50px">Janin Ke-</th>  
                        <th class="text-center" rowspan="2" style="width:100px">Presentasi</th>
                        <th class="text-center" rowspan="2" style="width:100px !important;">Bunyi Jantung</th>
                        <th class="text-center" rowspan="2" style="width:200px !important;">Jenis Kelamin</th>
                        <th class="text-center" colspan="3">Biometri</th>
                        <th class="text-center" rowspan="2" style="width:200px">Taksiran Berat Janin (gram)</th>
                        <th class="text-center" rowspan="2" style="width:200px">Jumlah Air Ketuban</th>
                        <th class="text-center" rowspan="2" style="width:200px">Insertio Plasenta</th>
                        <th class="text-center" rowspan="2" style="width:200px">Tali Pusat</th>
                        <th class="text-center" rowspan="2" style="width:200px">PATOLOGI</th>
                        <th class="text-center" colspan="4">Kesimpulan</th>
                    </tr>
                    <tr>
                        <th class="text-center" style="width:100px">AC (Abdominal Cirumferencial)</th>
                        <th class="text-center" style="width:100px">BPD (Biparietal Diameter)</th>
                        <th class="text-center" style="width:100px">FL (Femur Length)</th>
                   
                        <th class="text-center" style="width:150px">Denyut Jantung Janin (Kali/Menit)</th>
                        <th class="text-center" style="width:15px">Gravid (Minggu)</th>
                        <th class="text-center" style="width:150px">Taksiran Melahirkan</th>
                        <th class="text-center" style="width:200px">Secara Keseluruhan Janin dalam Kondisi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(count($modDetailUsg) > 0){
                            foreach ($modDetailUsg as $i => $dataDet){
                                $dataDet->biometri_ac = (isset($dataDet->biometri_ac)?MyFormatter::formatNumberForPrint($dataDet->biometri_ac,2):0);
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
                                        <?php echo CHtml::activeDropDownList($dataDet,'['.$i.']presentasi_janin', LookupM::getItems('pemeriksaanusg_presentasijanin'), array('empty'=>'-Pilih-','class'=>'presentasi_janin span2')) ?>
                                    </td>
                                    <td>
                                        <div class="radio_mainbunyijantung" style="width:80px !important">
                                            <?php echo CHtml::activeRadioButtonList($dataDet,'['.$i.']bunyijantung', array('Ada'=>'Ada','Tidak Ada'=>'Tidak Ada'), array('class'=>'bunyijantung')) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="radio_mainjeniskelamin" style="width:80px !important">
                                            <?php echo CHtml::radioButton('RJPemeriksaanusgpasiendetT['.$i.'][jeniskelamin]', (($dataDet->jeniskelamin=='Laki-laki')?true:false), array('name'=>'RJPemeriksaanusgpasiendetT['.$i.'][jeniskelamin]','class'=>'jeniskelamin','value'=>'Laki-laki', 'uncheckValue'=>null)) ?> <label>Laki-laki</label><br/>
                                            <?php echo CHtml::radioButton('RJPemeriksaanusgpasiendetT['.$i.'][jeniskelamin]', (($dataDet->jeniskelamin=='Perempuan')?true:false), array('name'=>'RJPemeriksaanusgpasiendetT['.$i.'][jeniskelamin]','class'=>'jeniskelamin','value'=>'Perempuan', 'uncheckValue'=>null)) ?> <label>Perempuan</label>
                                            <?php echo CHtml::radioButton('RJPemeriksaanusgpasiendetT['.$i.'][jeniskelamin]', (($dataDet->jeniskelamin=='Lainnya')?true:false), array('name'=>'RJPemeriksaanusgpasiendetT['.$i.'][jeniskelamin]','class'=>'jeniskelamin','value'=>'Lainnya', 'uncheckValue'=>null)) ?> <label>Lainnya</label>
                                        </div>
                                        <?php echo CHtml::activeTextField($dataDet,'['.$i.']jeniskelamin_lainnya',array('class'=>'jeniskelamin_lainnya span2','readonly'=>false)) ?>
                                    </td>
                                    <td>
                                        <?php echo CHtml::activeTextField($dataDet,'['.$i.']biometri_ac',array('class'=>'biometri_ac span1 integer-decimal')) ?> cm
                                    </td>
                                    <td>
                                        <?php echo CHtml::activeTextField($dataDet,'['.$i.']biometri_bpd',array('class'=>'biometri_bpd span1 integer-decimal')) ?> cm
                                    </td>
                                    <td>
                                        <?php echo CHtml::activeTextField($dataDet,'['.$i.']biometri_fl',array('class'=>'biometri_fl span1 integer-decimal')) ?> cm
                                    </td>
                                    <td>
                                        <?php echo CHtml::activeTextField($dataDet,'['.$i.']taksiranberatjanin',array('class'=>'taksiranberatjanin span1 integer-decimal')) ?>
                                    </td>
                                    <td>
                                        <div class="radio_mainjml_air_ketuban" style="width:80px !important">
                                            <?php echo CHtml::activeRadioButtonList($dataDet,'['.$i.']jml_air_ketuban', array('< 5 cm'=>'< 5 cm','> 5 cm'=>'> 5 cm'), array('class'=>'jml_air_ketuban')) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="radio_maininsertio_plasenta" style="width:200px !important">
                                            <?php echo CHtml::activeRadioButtonList($dataDet,'['.$i.']insertio_plasenta', array('Karpus'=>'Karpus','SBR (Segmen Bawah Rahim)'=>'SBR (Segmen Bawah Rahim)'), array('class'=>'insertio_plasenta')) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo CHtml::activeTextArea($dataDet,'['.$i.']talipusat',array('class'=>'talipusat span2')) ?>
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