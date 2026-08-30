<div class="row-fluid">
    <div class="col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading">
            <div class="panel-title"> Pernapasan  </div>
            </div>            
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-md-4">
                        <div class="control-group">
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'pernafasan_asma', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Asma </label> <br>
                                <?php echo $form->checkBox($model, 'pernafasan_bronkitis', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Bronkitis </label> <br>
                                <?php echo $form->checkBox($model, 'pernafasan_dyspnea', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Dyspnea </label> <br>
                                <?php echo $form->checkBox($model, 'pernafasan_ppok', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> PPOK </label> <br>
                                <?php echo $form->checkBox($model, 'pernafasan_orthopnea', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Orthopnea </label> <br>
                                <?php echo $form->checkBox($model, 'pernafasan_pneumonia', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Pneumonia </label> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <?php echo $form->checkBox($model, 'pernafasan_batukproduktif', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Batuk Produktif </label> <br>
                        <?php echo $form->checkBox($model, 'pernafasan_ispa', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> ISPA </label> <br>
                        <?php echo $form->checkBox($model, 'pernafasan_sop', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> SOP </label> <br>
                        <?php echo $form->checkBox($model, 'pernafasan_tuberkulosis', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Tuberkulosis </label> <br>
                        <?php echo $form->checkBox($model, 'pernafasan_efusipleura', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Efusipleura </label> <br>
                    </div>
                    <div class="col-md-4" style="float: right">
                        <?php echo $form->checkBox($model, 'pernafasan_dbn', array('onClick' => 'pernafasanDbn();','onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> DBN </label> <br>
                    </div>
                </div>
                <div class="row-fluid" style="margin-left: 25%; margin-right: 25%">
                    <label> Keterangan </label>
                    <?php echo $form->textArea($model, 'pernafasan_keterangan', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> 
                </div>
            </div>
        </div>
        <br>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"> Neuro / Muskulosketal  </div>
            </div>
                <div class="panel-body">
                    <div class="row-fluid">
                        <div class="col-md-5">
                            <div class="control-group">
                                <div class="controls">
                                    <?php echo $form->checkBox($model, 'neura_arthritis', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Arthritis </label> <br>
                                    <?php echo $form->checkBox($model, 'neura_backproblem', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Back Problem</label> <br>
                                    <?php echo $form->checkBox($model, 'neura_stoke', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> CVA / Stroke / TIA </label> <br>
                                    <?php echo $form->checkBox($model, 'neura_nyerikepala', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Nyeri Kepala / ICP </label> <br>
                                    <?php echo $form->checkBox($model, 'neura_penurunankesadaran', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Penurunan Kesadaran </label> <br>
                                    <?php echo $form->checkBox($model, 'neura_kejang', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Kejang </label> <br>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="control-group">
                                <div class="controls">
                                    <?php echo $form->checkBox($model, 'neura_kelemahanotot', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Kelemahan Otot </label> <br>
                                    <?php echo $form->checkBox($model, 'neura_neuromuscular', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Neuromuscular Dis. </label> <br>
                                    <?php echo $form->checkBox($model, 'neura_paralis', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Paralis </label> <br>
                                    <?php echo $form->checkBox($model, 'neura_parestesia', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Parastesia </label> <br>
                                    <?php echo $form->checkBox($model, 'neura_pingsan', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Pingsan </label> <br>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                                <?php echo $form->checkBox($model, 'neura_dbn', array('onClick' => 'neuraDbn();', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> DBN </label> <br>
                            </div>
                    </div>
                    <div class="row-fluid" style="margin-left: 25%; margin-right: 25%">
                        <label> Keterangan </label>
                        <?php echo $form->textArea($model, 'neura_keterangan', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> 
                    </div>
                </div>
        </div>
        <br>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"> Hepato / Gastrointestinal  </div>
            </div>
                <div class="panel-body">
                    <div class="row-fluid">
                        <div class="col-md-5">
                            <div class="control-group">
                                <div class="controls">
                                    <?php echo $form->checkBox($model, 'hepato_obstruksiusus', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Obstruksi Usus </label> <br>
                                    <?php echo $form->checkBox($model, 'hepato_sirosis', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Sirosis </label> <br>
                                    <?php echo $form->checkBox($model, 'hepato_hepatitis', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Hepatitis </label> <br>
                                    <?php echo $form->checkBox($model, 'hepato_haitalhernia', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Haital Hernia / Reflux </label> <br>
                                    <?php echo $form->checkBox($model, 'hepato_mualmuntah', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Mual dan Muntah </label> <br>
                                    <?php echo $form->checkBox($model, 'hepato_tukakpeptik', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Tukak Peptik / Ulkus </label> <br>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                                <?php echo $form->checkBox($model, 'hepato_dbn', array('onClick' => 'hepatoDbn();', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> DBN </label> <br>
                        </div>
                    </div>
                    <div class="row-fluid" style="margin-left: 25%; margin-right: 25%">
                        <label> Keterangan </label>
                        <?php echo $form->textArea($model, 'hepato_keterangan', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> 
                    </div>
                </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"> Kardiovaskular  </div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-md-5">
                        <div class="control-group">
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'kardiovaskular_ekgabnormal', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> EKG Abnormal </label> <br>
                                <?php echo $form->checkBox($model, 'kardiovaskular_angina', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> EKG Abnormal </label> <br>
                                <?php echo $form->checkBox($model, 'kardiovaskular_artero_shd', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Artero Scerotic Heart Dis </label> <br>
                                <?php echo $form->checkBox($model, 'kardiovaskular_gagaljantungkongesif', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Gagal Jantung Kongesif </label> <br>
                                <?php echo $form->checkBox($model, 'kardiovaskular_disritmia', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Disritmia </label> <br>
                                <?php echo $form->checkBox($model, 'kardiovaskular_limitasiaktifitas', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Limitasi Aktifitas </label> <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="control-group">
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'kardiovaskular_hipertensi', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Hipertensi </label> <br>
                                <?php echo $form->checkBox($model, 'kardiovaskular_infarkmyokard', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Infark Myokard </label> <br>
                                <?php echo $form->checkBox($model, 'kardiovaskular_murmur', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Murmur </label> <br>
                                <?php echo $form->checkBox($model, 'kardiovaskular_pacemaker', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Pacemaker </label> <br>
                                <?php echo $form->checkBox($model, 'kardiovaskular_dememrheuma', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Demam Rheuma </label> <br>
                                <?php echo $form->checkBox($model, 'kardiovaskular_penyakitkatub', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Penyakit Katub</label> <br>                        
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <?php echo $form->checkBox($model, 'kardiovaskular_dbn', array('onClick' => 'kardiovaskularDbn();', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> DBN </label> <br>                        
                    </div>
                </div>
                <div class="row-fluid" style="margin-left: 25%; margin-right: 25%">
                    <label> Keterangan </label>
                    <?php echo $form->textArea($model, 'kardiovaskular_keterangan', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> 
                </div>
            </div>
        </div>
        <br>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"> Renal / Endokrin  </div>
            </div>
                <div class="panel-body">
                    <div class="row-fluid">
                        <div class="col-md-4">
                            <div class="control-group">
                                <div class="controls">
                                    <?php echo $form->checkBox($model, 'renal_diebetmelitus', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Diabetes Melitus </label> <br>
                                    <?php echo $form->checkBox($model, 'renal_gagalginjal', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Gagal Ginjal </label> <br>
                                    <?php echo $form->checkBox($model, 'renal_penyakitthyroid', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Penyakit Thyroid </label> <br>
                                    <?php echo $form->checkBox($model, 'renal_retensiurine', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Retensi Urine </label> <br>
                                    <?php echo $form->checkBox($model, 'renal_isk', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> ISK </label> <br>
                                    <?php echo $form->checkBox($model, 'renal_bb_turun', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Berat Badan Turun </label> <br>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="control-group">
                                <div class="controls">
                                    <?php echo $form->checkBox($model, 'renal_dbn', array('onClick' => 'renalDbn();', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> DBN </label> <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid" style="margin-left: 25%; margin-right: 25%">
                        <label> Keterangan </label>
                        <?php echo $form->textArea($model, 'renal_keterangan', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> 
                    </div>
                </div>
        </div>
        <br>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"> Lain-lain  </div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-md-5">
                        <div class="control-group">
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'lainlain_anemia', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> EKG Abnormal </label> <br>
                                <?php echo $form->checkBox($model, 'lainlain_bleeding', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> EKG Abnormal </label> <br>
                                <?php echo $form->checkBox($model, 'lainlain_kanker', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Artero Scerotic Heart Dis </label> <br>
                                <?php echo $form->checkBox($model, 'lainlain_dehidrasi', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Gagal Jantung Kongesif </label> <br>
                                <?php echo $form->checkBox($model, 'lainlain_hemofilia', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Disritmia </label> <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="control-group">
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'lainlain_immunosupresan', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Hipertensi </label> <br>
                                <?php echo $form->checkBox($model, 'lainlain_kehamilan', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Infark Myokard </label> <br>
                                <?php echo $form->checkBox($model, 'lainlain_sicklescelldis', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Murmur </label> <br>
                                <?php echo $form->checkBox($model, 'lainlain_riwayattransfusi', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Riwayat Transfusi </label> <br>
                                <?php echo $form->checkBox($model, 'lainlain_antikogulan', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Demam Rheuma </label> <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="control-group">
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'lainlain_dbn', array('onClick' => 'lainDbn();', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> DBN </label> <br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid" style="margin-left: 25%; margin-right: 25%">
                    <label> Keterangan </label>
                    <?php echo $form->textArea($model, 'lainlain_keterangan', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> 
                </div>
            </div>
        </div>
    </div>
</div>