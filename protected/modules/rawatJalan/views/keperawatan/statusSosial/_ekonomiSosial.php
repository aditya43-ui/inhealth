<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Status Sosial Ekonomi</div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <?php
                        $modPasien->pendidikan_nama = !empty($modPasien->pendidikan_id) ? $modPasien->pendidikan->pendidikan_nama : "";
                        $modPasien->suku_nama = !empty($modPasien->suku_id) ? $modPasien->suku->suku_nama : "";
                    ?>
                    <div class="control-group">
                        <?php echo CHtml::label("Alamat", "", array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textArea($modPasien, 'alamat_pasien', array('readonly' => true, 'class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);"));?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("No. Telp", "", array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modPasien, 'no_mobile_pasien', array('readonly' => true, 'class' => 'span5 numbers-only')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Pendidikan", "", array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modPasien, 'pendidikan_nama', array('readonly' => true, 'class' => 'span5')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Kewarganegaraan", "", array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modPasien, 'warga_negara', array('readonly' => true, 'class' => 'span5')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Suku Bangsa", "", array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modPasien, 'suku_nama' , array('readonly' => true, 'class' => 'span5')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Bahasa yang digunakan", "", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'is_bahasaindonesia') . CHtml::label("Indonesia", ""); ?>
                            </div> 
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'is_bahasadaerah', array('readonly' => false, 'class' => 'istempattinggallain', 'value' => true , 'uncheckValue' => '0', 'onclick'=> "lainnya(this, 'bahasa')")) . CHtml::label("Daerah", ""); ?>
                            </div>
                            <div class="controls">
                                <?php echo $form->textField($model, 'keterangan_bahasa', array('class' => 'bahasa', 'readonly' => true)); ?>
                            </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label("Status Pernikahan", "", array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modPasien, 'statusperkawinan', array('readonly' => true, 'class' => 'span4')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Pasien Tinggal Bersama", "", array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'is_tinggalbersamasuami') . CHtml::label("Suami", "") ; ?>
                            </div>
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'is_tinggalbersamaistri') . CHtml::label("Istri", ""); ?>
                            </div>
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'is_tinggalbersamaanak') . CHtml::label("Anak Kandung", ""); ?>
                            </div>
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'is_tinggalbersamakakek') .CHtml::label("Kakek", ""); ?>
                            </div>
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'is_tinggalbersamanenek') . CHtml::label("Nenek", ""); ?>
                            </div>
                            <br>
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'is_tinggalbersamalain', array('readonly' => false, 'class' => 'istempattinggallain', 'value' => true , 'uncheckValue' => '0', 'onclick'=> "lainnya(this, 'ispasientinggallain')")) . CHtml::label("Lain-lain", ""); ?>
                            </div>
                            <div class="controls">
                                <?php echo $form->textField($model, 'keterangan_tinggalbersama', array('class' => 'ispasientinggallain', 'readonly' => true)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Keluarga Terdekat", "", array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'keluargaterdekat', array('class' => 'span4')); ?>
                        </div>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'hubungankeluarga', LookupM::getItems('hubungankeluarga'), array('empty'=>'-- Pilih --', 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Tempat Tinggal", "", array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->checkBox($model, 'isrumahsendiri', array('onclick' => 'checklistOnlyOne();', 'class' => 'rumah')) . CHtml::label("Rumah Sendiri", "") ; ?>
                        </div>
                        <div class="controls">
                            <?php echo $form->checkBox($model, 'iskontrak', array('onclick' => 'checklistOnlyOne();', 'class' => 'rumah')) . CHtml::label("Kontrak", ""); ?>
                        </div>
                        <div class="controls">
                            <?php echo $form->checkBox($model, 'islainlain', array('readonly' => false, 'class' => 'islainlain rumah', 'value' => true , 'uncheckValue' => '0', 'onclick'=> "lainnya(this, 'rumahlainlain'); checklistOnlyOne();")) . CHtml::label("Lain-lain", ""); ?>
                        </div>
                        <div class="controls">
                            <?php echo $form->textField($model, 'rumahlainlain', array('class' => 'rumahlainlain', 'readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Pembiayaan", "", array('class' => 'control-label')) ?>
                        <div style="float: left;">
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'is_pembiayaanasuransi', array('readonly' => false, 'class' => 'pembiayaan', 'value' => true , 'uncheckValue' => '0', 'onclick'=> "lainnya(this, 'asuransinama'); checklistPembiayaan();")) . CHtml::label("Asuransi", ""); ?>
                                <?php echo $form->textField($model, 'asuransinama', array('class' => 'asuransinama', 'readonly' => true)); ?>
                            </div>
                            <br>
                            <div class="controls" style="margin-top: 9px;">
                                <?php echo $form->checkBox($model, 'is_pembiayaanperusahaan', array('readonly' => false, 'class' => 'pembiayaan', 'value' => true , 'uncheckValue' => '0', 'onclick'=> "lainnya(this, 'perusahaannama'); checklistPembiayaan();")) . CHtml::label("Perusahaan", ""); ?>
                                <?php echo $form->textField($model, 'perusahaannama', array('class' => 'perusahaannama', 'readonly' => true)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="clear"></div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Status Spiritual</div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo CHtml::label("Agama", "", array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modPasien, 'agama', array('readonly' => true, 'class' => 'span4')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Pendampingan Spiritual", "", array('class' => 'control-label')) ?>
                    <div class="controls">
                        <label class="radio">
                            <?php echo $form->radioButton($model, 'pendampingspiritual', array('value' => 1)) . CHtml::label(" Ya", ''); ?>
                        </label>
                        <label class="radio">
                            <?php echo $form->radioButton($model, 'pendampingspiritual', array('value' => 0)) . CHtml::label(" Tidak, ", ''); ?>
                        </label>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Nilai Kepercayaan & budaya yang diyakini", "", array('class' => 'control-label')) ?>
                    <div class="controls">
                        <label class="radio">
                            <?php echo $form->radioButton($model, 'is_nilaikepercayaan', array('value' => 0, 'onClick' => 'nilaiKepercayaan(this)', 'data-value' => 0)) . CHtml::label(" Tidak Ada", ''); ?>
                        </label>
                        <label class="radio">
                            <?php echo $form->radioButton($model, 'is_nilaikepercayaan', array('value' => 1, 'onClick' => 'nilaiKepercayaan(this)', 'data-value' => 1)) . CHtml::label(" Ya", ''); ?>
                        </label>
                    </div>
                    <div class="controls">
                        <div class="checkbox">
                            <?php echo $form->checkBox($model, 'is_tidakpulangdarirs', array('disabled' => true, 'class' => 'kepercayaan')) . CHtml::label(" Tidak", "") ; ?>
                        </div>
                        <br>
                        <div class="checkbox">
                            <?php echo $form->checkBox($model, 'is_tidakdilakukanoperasi', array('disabled' => true, 'class' => 'kepercayaan')) . CHtml::label(" Tidak dilakukan tindakan operasi pada hari raya tahun baru", ""); ?>
                        </div>
                        <br>
                        <div class="checkbox">
                            <?php echo $form->checkBox($model, 'is_tidakmakandaging', array('disabled' => true, 'class' => 'kepercayaan')) . CHtml::label(" Tidak makan daging sapi", ""); ?>
                        </div>
                        <br>
                        <div class="controls">
                            <?php echo $form->checkBox($model, 'is_nilaikepercayaanlainnya', array('disabled' => true, 'class' => 'kepercayaan islainlainnya', 'value' => true , 'uncheckValue' => '0', 'onclick'=> "lainnya(this, 'islainnya')")) . CHtml::label(" Lainnya", ""); ?>
                        </div>
                        <div class="controls">
                            <?php echo $form->textField($model, 'ket_nilaikepercayaanlainnya', array('class' => 'islainnya', 'readonly' => true)); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>