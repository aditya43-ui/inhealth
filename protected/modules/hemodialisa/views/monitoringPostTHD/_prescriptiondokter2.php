<div class="panel panel-success pres_2" hidden> 
    <div class="panel-heading">
        <div class="panel-title">Prescription Dokter</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid" >
                <div class="col-sm-6">

                    <div class="control-group">
                        <label class="control-label">Prescription Dokter</label>
                        <div class="controls">
                            <?= CHtml::activeHiddenField($modPrescription, 'prescription_hd_id', []); ?>
                            <?= $form->radioButton($modPrescription, 'prescription_dokter', array('value' => 'akut', 'uncheckValue' => null)) ?><label>Akut</label> &nbsp;
                            <?= $form->radioButton($modPrescription, 'prescription_dokter', array('value' => 'kronis', 'uncheckValue' => null)) ?><label>Kronis</label> &nbsp;
                            <?= $form->radioButton($modPrescription, 'prescription_dokter', array('value' => 'pirrt', 'uncheckValue' => null)) ?><label>PIRRT</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Time</label>
                        <div class="controls"><?= $form->textField($modPrescription, 'durasi_time', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 integer')); ?>
                            <?= $form->dropDownList($modPrescription, 'time_satuan', CHtml::listData(LookupM::model()->findAll("lookup_type='satuanlamanyeri' AND lookup_aktif=TRUE"), 'lookup_name', 'lookup_name'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'empty' => '--Pilih--')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Blood Flow</label>
                        <div class="controls"><?= $form->textField($modPrescription, 'blood_flow', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 float')); ?><label>mL/menit</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Dialysate Flow</label>
                        <div class="controls"><?= $form->textField($modPrescription, 'dialysate_flow', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 float',)); ?><label>mL/menit</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Dialysate</label>
                        <div class="controls">
                            <?php echo $form->checkBox($modPrescription, 'dialysate_bicarbonat', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkDialysate("bicarbonat")')) ?> <label>Bicarbonat</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">&nbsp;</label>
                        <div class="controls">
                            <?php echo $form->checkBox($modPrescription, 'dialysate_lainnya', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkDialysateLain()')) ?> <label>Lainnya</label>
                            <?php echo $form->textField($modPrescription, 'dialysate_lainnya_keterangan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'disabled' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Dialyser</label>
                        <div class="controls"><?= $form->textField($modPrescription, 'diayser', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Dialyser Temperature</label>
                        <div class="controls"><?= $form->textField($modPrescription, 'dialyser_temperature', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 float')); ?><label>&#8451;</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Ultra Filtration Goal</label>
                        <div class="controls"><?= $form->textField($modPrescription, 'uf_goal', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 float')); ?></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Akses Vaskuler</label>
                        <div class="controls">
                            <?= CHtml::activeHiddenField($modPrescription, 'akses_vaskular', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
                            <?php
                                if(!empty($modPrescription->akses_vaskular)){
                                    $str = substr($modPrescription->akses_vaskular,0,-1);
                                    $str1 = explode(",", $str);
//                                    print_r($str1); die;
                                    foreach ($str1 as $no=>$row){
                                        echo CHtml::textField('akses_vaskular', $row, array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3', 'style'=>'margin-bottom: 10px;', 'disabled'=>true))."<br>";
                                    }
                                }else{
                                    echo CHtml::textField('akses_vaskular', '', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3', 'disabled'=>true));
                                }
                            ?>
                            
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Catatan Lain</label>
                        <div class="controls"><?= $form->textArea($modPrescription, 'catatan_lain', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '', 'style' => 'width: 200px; height: 100px')); ?></div>
                    </div>
                </div>


                <div class="col-sm-6">

                    <div class="control-group">
                        <label class="control-label">Heparinisasi</label>
                        <div class="controls">
                            <?php echo $form->checkBox($modPrescription, 'heparinisasi_standar', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column')) ?> <label>Standar</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">&nbsp;</label>
                        <div class="controls">
                            <?php echo $form->checkBox($modPrescription, 'heparinisasi_minimal', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column')) ?> <label>Minimal</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">&nbsp;</label>
                        <div class="controls">
                            <?php echo $form->checkBox($modPrescription, 'heparinisasi_tanpaheparin', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'cekHeparinisasiTanpaHeparin()')) ?> <label>Tanpa Heparin</label>
                            <?php echo $form->textField($modPrescription, 'heparinisasi_tanpaheparin_penyebab', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'disabled' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">&nbsp;</label>
                        <div class="controls">
                            <?php echo $form->checkBox($modPrescription, 'heparinisasi_lmwh', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column')) ?> <label>LMWH</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">&nbsp;</label>
                        <div class="controls">
                            <?php echo $form->checkBox($modPrescription, 'heparinisasi_lainnya', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'cekHeparinisasiLainnya()')) ?> <label>lainnya</label>
                            <?php echo $form->textField($modPrescription, 'heparinisasi_lainnya_penyebab', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'disabled' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Selisih BB</label>
                        <div class="controls"><?= $form->textField($modPrescription, 'selisih_berat_badan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 float')); ?> <label>Kg</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Infus</label>
                        <div class="controls"><?= $form->textField($modPrescription, 'infus', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 float')); ?> <label>mL</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <?php echo $form->checkBox($modPrescription, 'transfusi_darah', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column')) ?> <label>Transfusi Darah</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <?php echo $form->checkBox($modPrescription, 'penggunaan_elektropetin', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column')) ?> <label>Penggunaan Elektropetin</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <?php echo $form->checkBox($modPrescription, 'penggunaan_zatbesi', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column')) ?> <label>Penggunaan Zat Besi</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
