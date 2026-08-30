
<div class="row-fluid">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title"> Catatan </div>
        </div>
        <div class="panel-body">
            <div class="col-md-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Merokok", 'merokok_ya', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::activeRadioButtonList($model, 'merokok_ya', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ', 'onclick' => 'setMerokok();')); ?>       
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Jumlah", 'jumlahrokok', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'jumlahrokok', array('class' => 'span3 numbersOnly', 'placeholder' => 'Jumlah Rokok dalam Sehari', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> 
                                <label> / hari </label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Selama", 'lamamerokok', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'lamamerokok', array('class' => 'span3', 'placeholder' => 'Lama Merokok', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                
                            </div>
                        </div>

            </div>
            <div class="col-md-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Alkohol", 'merokok_ya', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::activeRadioButtonList($model, 'alkohol_ya', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ', 'onclick' => 'setAlkohol();')); ?>       
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Selama", 'lamaminumalkohol', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'lamaminumalkohol', array('class' => 'span3', 'placeholder' => 'Lama Konsumsi Alkohol', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                
                            </div>
                        </div>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title"> Evaluasi Jalan Napas </div>
        </div>
        <div class="panel-body">
            <div class="col-md-6">
                <div class="control-group">
                    <?php echo CHtml::label("Bebas", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($model, 'evaluasijalannafas_bebas_ya', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>       
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Alat Jalan Napas", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'evaluasijalannafas_alat_jalan_nafas', array('class' => 'span3', 'placeholder' => 'Lainnya', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Potrusi Mandibula", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($model, 'evaluasijalannafas_potrusimandibula_ya', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>       
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Buka Mulut 3 Jari ", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($model, 'evaluasijalannafas_bukamulut3jari_ya', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>       
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Buka Mulut 2 Jari ", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($model, 'evaluasijalannafas_bukamulut2jari_ya', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>       
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Malamphaty", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($model, 'evaluasijalannafas_malaphaty_satu', array('1' => 'I', '2' => 'II', '3' => 'III', '4' => 'IV'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>       
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Leher Pendek", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($model, 'evaluasijalannafas_leherpendek_ya', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>       
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="control-group">
                    <?php echo CHtml::label("Gerak Leher", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($model, 'evaluasijalannafas_gerakleher_bebas', array('Ya' => 'Bebas', 'Tidak' => 'Terbatas'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>       
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Obesitas", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($model, 'evaluasijalannafas_obesitas_ya', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>       
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Massa", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($model, 'evaluasijalannafas_massa_ya', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>       
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Gigi Geligi", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'evaluasijalannafas_gigigeligi_keterangan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("<b>  Jalan Nafas Sulit </b>", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($model, 'evaluasijalannafas_jalannafassulit_ya', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>       
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("<b> Ventilasi Sulit </b>", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($model, 'evaluasijalannafas_ventilasisulit_ya', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title"> Pemeriksaan Laboratorium </div>
        </div>
        <div class="panel-body">
            <div class="col-md-6">
                <div class="control-group">
                    <?php echo CHtml::label("Hb / HctCBC", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'pemeriksaanlab_hb', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Fungsi Ginjal", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'pemeriksaanlab_fungsiginjal', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Fungsi Hati", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'pemeriksaanlab_fungsihati', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="control-group">
                    <?php echo CHtml::label("Serum Elektrolit", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'pemeriksaanlab_serumelektrolit', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Faal Hemostatis", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'pemeriksaanlab_faalhemostatis', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Lain-lain", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'pemeriksaanlab_lainlain', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title"> Pemeriksaan Penunjang </div>
        </div>
        <div class="panel-body">
            <div class="col-md-6">
                <div class="control-group">
                    <?php echo CHtml::label("Echocardiografi", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'pemeriksaanpenunjang_echocardiografi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("EKG", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'pemeriksaanpenunjang_ekg', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Pencitraan", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'pemeriksaanpenunjang_pencitraan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="control-group">
                    <?php echo CHtml::label("Faal Paru", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'pemeriksaanpenunjang_evaluasifaalparu', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Lain-lain", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'pemeriksaanpenunjang_lainlain', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title"> Simpulan Evaluasi Pra-Anestesi / Pra Sedasi </div>
        </div>
        <div class="panel-body">
            <div class="col-md-6">
                <div class="control-group">
                    <?php echo CHtml::label("PS ASA", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'kesimpulanevaluasi_psasa', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Penyulit", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($model, 'kesimpulanevaluasi_penyulit', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="control-group">
                    <?php echo CHtml::label("Cardiac Risk Index", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'kesimpulanevaluasi_cardiacriskindex', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Komplikasi", ' ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($model, 'kesimpulanevaluasi_komplikasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>