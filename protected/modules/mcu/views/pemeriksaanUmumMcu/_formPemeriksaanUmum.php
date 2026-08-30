<style type="text/css">
    .simbol-plus {
        font-size: 20px;
    }
</style>
<div class="panel panel-dark">
    <span class="group-title">
        <b>Pemeriksaan Umum Check-Up</b>
    </span>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo Chtml::label('Jenis Keperluan <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modpemeriksaanumum, 'jeniskeperluanmcu', LookupM::getItems('jeniskeperluanmcu'), array('empty' => '-- Pilih --', 'class' => 'required span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo Chtml::label('Keperluan MCU <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modpemeriksaanumum, 'diagnosis', array('class' => 'required', 'onkeyup' => "nama(this)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo Chtml::label('Tekanan Darah', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modpemeriksaanumum, 'tekanandarah_sistolik', array('class' => 'numbers-only span1')); ?>
                        <label>/</label>
                    </div>
                    <div class="controls">
                        <?php echo $form->textField($modpemeriksaanumum, 'tekanandarah_diastolik', array('class' => 'numbers-only span1')); ?>
                        <label>mmHg</label>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo Chtml::label('Nadi', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modpemeriksaanumum, 'nadi', array('class' => 'span3 numbers-only')); ?>
                        <label>x/menit</label>
                    </div>
                </div>
                <div class="anemia">
                    <div class="control-group">
                        <?php echo CHtml::label('Anemia', '', array('class' => 'control-label')); ?>
                        <div class='controls'>
                            <?php echo $form->checkBox($modpemeriksaanumum, 'anemia_positif', array()); ?> <label><B class='simbol-plus'>+</B></label>
                        </div>
                        <div class='controls'>
                            <?php echo $form->checkBox($modpemeriksaanumum, 'anemia_negatif', array('class' => 'negatif-anemia')); ?> <label><B class='simbol-plus'>-</B></label>
                        </div>
                    </div>
                </div>
                <div class="ikterus">
                    <div class="control-group">
                        <?php echo CHtml::label('Ikterus', '', array('class' => 'control-label')); ?>
                        <div class='controls'>
                            <?php echo $form->checkBox($modpemeriksaanumum, 'ikterus_positif', array()); ?> <label><B class='simbol-plus'>+</B></label>
                        </div>
                        <div class='controls'>
                            <?php echo $form->checkBox($modpemeriksaanumum, 'ikterus_negatif', array('class' => 'negatif-ikterus')); ?> <label><B class='simbol-plus'>-</B></label>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Pemeriksaan Semua Normal</label>
                    <div class="controls">
                        <?php echo CHtml::checkBox("pilihSemuaNormal", false, array('onclick' => 'pilihNormal(this);')); ?>
                    </div>
                </div>
                <div class="control-group">
                        <?php echo CHtml::label('Mata', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modpemeriksaanumum, 'mata', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'mata',)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modpemeriksaanumum, 'mata_virus_kanan', array('placeholder' => 'Virus Kanan', 'class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                        <div class="controls">
                            <?php echo $form->textField($modpemeriksaanumum, 'mata_virus_kiri', array('placeholder' => 'Virus Kiri', 'class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modpemeriksaanumum, 'mata_persepsi_warna', array('placeholder' => 'Persepsi Warna', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                <div class="pemeriksaanumum-normal">
                    <div class="kepala">
                        <div class="control-group">
                            <?php echo CHtml::label('Kepala', '', array('class' => 'control-label')); ?>
                            <div class='controls'>
                                <?php echo $form->checkBox($modpemeriksaanumum, 'kepala_normal', array(($modpemeriksaanumum->kepala_normal != "") ? ' ' : 'checked' => false, 'class' => 'pilih-normal')); ?> <label>Normal</label>
                                <?php echo $form->checkBox($modpemeriksaanumum, 'kepala_abnormal', array('class' => 'negatif-kepala')); ?> <label>Abnormal</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
                            <div class='controls'>
                                <?php echo $form->textField($modpemeriksaanumum, 'kepala_keterangan', array('placeholder' => 'Penyebab', 'class' => 'span3', 'readonly' => false)) ?>
                            </div>
                        </div>
                    </div>

                    <div class="jantung">
                        <div class="control-group">
                            <?php echo CHtml::label('Jantung', '', array('class' => 'control-label')); ?>
                            <div class='controls'>
                                <?php echo $form->checkBox($modpemeriksaanumum, 'jantung_normal', array(($modpemeriksaanumum->jantung_normal != "") ? ' ' : 'checked' => false, 'class' => 'pilih-normal')); ?> <label>Normal</label>
                                <?php echo $form->checkBox($modpemeriksaanumum, 'jantung_abnormal', array('class' => 'negatif-jantung')); ?> <label>Abnormal</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
                            <div class='controls'>
                                <?php echo $form->textField($modpemeriksaanumum, 'jantung_keterangan', array('placeholder' => 'Penyebab', 'class' => 'span3', 'readonly' => false)) ?>
                            </div>
                        </div>
                    </div>

                    <div class="hepar">
                        <div class="control-group">
                            <?php echo CHtml::label('Hepar', '', array('class' => 'control-label')); ?>
                            <div class='controls'>
                                <?php echo $form->checkBox($modpemeriksaanumum, 'hepar_normal', array(($modpemeriksaanumum->hepar_normal != "") ? ' ' : 'checked' => false, 'class' => 'pilih-normal')); ?> <label>Normal</label>
                                <?php echo $form->checkBox($modpemeriksaanumum, 'hepar_abnormal', array('class' => 'negatif-hepar')); ?> <label>Abnormal</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
                            <div class='controls'>
                                <?php echo $form->textField($modpemeriksaanumum, 'hepar_keterangan', array('placeholder' => 'Penyebab', 'class' => 'span3', 'readonly' => false)) ?>
                            </div>
                        </div>
                    </div>

                    <div class="limpa">
                        <div class="control-group">
                            <?php echo CHtml::label('Limpa', '', array('class' => 'control-label')); ?>
                            <div class='controls'>
                                <?php echo $form->checkBox($modpemeriksaanumum, 'limpa_takteraba', array(($modpemeriksaanumum->limpa_takteraba != "") ? ' ' : 'checked' => false, 'class' => 'pilih-normal')); ?> <label>Tak Teraba</label>
                                <?php echo $form->checkBox($modpemeriksaanumum, 'limpa_teraba', array('class' => 'negatif-limpa')); ?> <label>Teraba</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
                            <div class='controls'>
                                <?php echo $form->textField($modpemeriksaanumum, 'limpa_keterangan', array('placeholder' => 'Penyebab', 'class' => 'span3', 'readonly' => false)) ?>
                            </div>
                        </div>
                    </div>

                    <div class="extremitas">
                        <div class="control-group">
                            <?php echo CHtml::label('Extremitas', '', array('class' => 'control-label')); ?>
                            <div class='controls'>
                                <?php echo $form->checkBox($modpemeriksaanumum, 'extremitas_normal', array(($modpemeriksaanumum->extremitas_normal != "") ? ' ' : 'checked' => false, 'class' => 'pilih-normal')); ?> <label>Normal</label>
                                <?php echo $form->checkBox($modpemeriksaanumum, 'extremitas_abnormal', array('class' => 'negatif-extremitas')); ?> <label>Abnormal</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
                            <div class='controls'>
                                <?php echo $form->textField($modpemeriksaanumum, 'extremitas_keterangan', array('placeholder' => 'Penyebab', 'class' => 'span3', 'readonly' => false)) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo Chtml::label('Berat Badan', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modpemeriksaanumum, 'beratbadan', array('maxlength' => 3, 'class' => 'span3 numbers-only', 'onkeyup' => 'jumlah()')); ?>
                        <label>Kg</label>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo Chtml::label('TInggi Badan', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modpemeriksaanumum, 'tinggibadan', array('maxlength' => 3, 'class' => 'span3 numbers-only', 'onkeyup' => 'jumlah()')); ?>
                        <label>Cm</label>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo Chtml::label('BMI', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modpemeriksaanumum, 'nilai_bmi', array('class' => 'span3 float2')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo Chtml::label('', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modpemeriksaanumum, 'bmi_kategori', array('placeholder' => 'Kategori', 'class' => 'span3')); ?>
                    </div>
                </div>
                <div class="gizi">
                    <div class="control-group">
                        <?php echo CHtml::label('Gizi', '', array('class' => 'control-label')); ?>
                        <div class='controls'>
                            <?php echo $form->checkBox($modpemeriksaanumum, 'gizi_baik', array()); ?> <label>Baik</label>
                        </div>
                        <div class='controls'>
                            <?php echo $form->checkBox($modpemeriksaanumum, 'gizi_kurang', array('class' => 'negatif-gizi')); ?> <label>Kurang</label>
                        </div>
                    </div>
                </div>
                <div class="sesak">
                    <div class="control-group">
                        <?php echo CHtml::label('Sesak', '', array('class' => 'control-label')); ?>
                        <div class='controls'>
                            <?php echo $form->checkBox($modpemeriksaanumum, 'sesak_positif', array()); ?> <label><B class='simbol-plus'>+</B></label>
                        </div>
                        <div class='controls'>
                            <?php echo $form->checkBox($modpemeriksaanumum, 'sesak_negatif', array('class' => 'negatif-sesak')); ?> <label><B class='simbol-plus'>-</B></label>
                        </div>
                    </div>
                </div>
                <div class="sembab">
                    <div class="control-group">
                        <?php echo CHtml::label('Sembab', '', array('class' => 'control-label')); ?>
                        <div class='controls'>
                            <?php echo $form->checkBox($modpemeriksaanumum, 'sembab_positif', array()); ?> <label><B class='simbol-plus'>+</B></label>
                            <?php echo $form->checkBox($modpemeriksaanumum, 'sembab_negatif', array('class' => 'negatif-sembab')); ?> <label><B class='simbol-plus'>-</B></label>
                            <?php echo $form->textField($modpemeriksaanumum, 'sembab_keterangan', array('placeholder' => 'Penyebab', 'class' => 'span3', 'readonly' => false)) ?>
                        </div>
                    </div>
                </div>
                <div class="pemeriksaanumum-normal2">
                    <div class="leher">
                        <div class="control-group">
                            <?php echo CHtml::label('Leher', '', array('class' => 'control-label')); ?>
                            <div class='controls'>
                                <?php echo $form->checkBox($modpemeriksaanumum, 'leher_normal', array(($modpemeriksaanumum->leher_normal != "") ? ' ' : 'checked' => false, 'class' => 'pilih-normal')); ?> <label>Normal</label>
                                <?php echo $form->checkBox($modpemeriksaanumum, 'leher_abnormal', array('class' => 'negatif-leher')); ?> <label>Abnormal</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
                            <div class='controls'>
                                <?php echo $form->textField($modpemeriksaanumum, 'leher_keterangan', array('placeholder' => 'Penyebab', 'class' => 'span3', 'readonly' => false)) ?>
                            </div>
                        </div>
                    </div>

                    <div class="paru">
                        <div class="control-group">
                            <?php echo CHtml::label('Paru', '', array('class' => 'control-label')); ?>
                            <div class='controls'>
                                <?php echo $form->checkBox($modpemeriksaanumum, 'paru_normal', array(($modpemeriksaanumum->paru_normal != "") ? ' ' : 'checked' => false, 'class' => 'pilih-normal')); ?> <label>Normal</label>
                                <?php echo $form->checkBox($modpemeriksaanumum, 'paru_abnormal', array('class' => 'negatif-paru')); ?> <label>Abnormal</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
                            <div class='controls'>
                                <?php echo $form->textField($modpemeriksaanumum, 'paru_keterangan', array('placeholder' => 'Penyebab', 'class' => 'span3', 'readonly' => false)) ?>
                            </div>
                        </div>
                    </div>

                    <div class="abdomen">
                        <div class="control-group">
                            <?php echo CHtml::label('Abdomen', '', array('class' => 'control-label')); ?>
                            <div class='controls'>
                                <?php echo $form->checkBox($modpemeriksaanumum, 'abdomen_normal', array(($modpemeriksaanumum->abdomen_normal != "") ? ' ' : 'checked' => false, 'class' => 'pilih-normal')); ?> <label>Normal</label>
                                <?php echo $form->checkBox($modpemeriksaanumum, 'abdomen_abnormal', array('class' => 'negatif-abdomen')); ?> <label>Abnormal</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
                            <div class='controls'>
                                <?php echo $form->textField($modpemeriksaanumum, 'abdomen_keterangan', array('placeholder' => 'Penyebab', 'class' => 'span3', 'readonly' => false)) ?>
                            </div>
                        </div>
                    </div>

                    <div class="tulang">
                        <div class="control-group">
                            <?php echo CHtml::label('Tulang/Persendian', '', array('class' => 'control-label')); ?>
                            <div class='controls'>
                                <?php echo $form->checkBox($modpemeriksaanumum, 'tulangpersendian_normal', array(($modpemeriksaanumum->tulangpersendian_normal != "") ? ' ' : 'checked' => false, 'class' => 'pilih-normal')); ?> <label>Normal</label>
                                <?php echo $form->checkBox($modpemeriksaanumum, 'tulangpersendian_abnormal', array('class' => 'negatif-tulang')); ?> <label>Abnormal</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
                            <div class='controls'>
                                <?php echo $form->textField($modpemeriksaanumum, 'tulangpersendian_keterangan', array('placeholder' => 'Penyebab', 'class' => 'span3', 'readonly' => false)) ?>
                            </div>
                        </div>
                    </div>

                    <div class="fotothorax">
                        <div class="control-group">
                            <?php echo CHtml::label('Foto/Thorax', '', array('class' => 'control-label')); ?>
                            <div class='controls'>
                                <?php echo $form->checkBox($modpemeriksaanumum, 'fotothorax_normal', array(($modpemeriksaanumum->fotothorax_normal != "") ? ' ' : 'checked' => false, 'class' => 'pilih-normal')); ?> <label>Normal</label>
                                <?php echo $form->checkBox($modpemeriksaanumum, 'fotothorax_abnormal', array('class' => 'negatif-fotothorax')); ?> <label>Abnormal</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
                            <div class='controls'>
                                <?php echo $form->textField($modpemeriksaanumum, 'fotothorax_keterangan', array('placeholder' => 'Penyebab', 'class' => 'span3', 'readonly' => false)) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>