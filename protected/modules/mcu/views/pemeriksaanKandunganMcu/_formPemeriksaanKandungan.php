<div class="panel panel-dark">
    <span class="group-title">
        <b></b>
    </span>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Anamnesis', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($ModPemeriksaankandungan, 'anamnesis', array()); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Haid', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($ModPemeriksaankandungan, 'haid', array()); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. Haid Terakhir', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $ModPemeriksaankandungan->tgl_haid_terakhir = $format->formatDateTimeForUser($ModPemeriksaankandungan->tgl_haid_terakhir);
                        $this->widget('MyDateTimePicker', array(
                            'model' => $ModPemeriksaankandungan,
                            'attribute' => 'tgl_haid_terakhir',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,

                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'span2',
                                'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Siklus', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($ModPemeriksaankandungan, 'siklus_haid', array('class' => 'span1')); ?>
                        <label>Hari</label>
                    </div>
                    <div class="controls">
                        <?php echo $form->textField($ModPemeriksaankandungan, 'periode_siklus_haid', array('class' => 'numbers-only span1')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Menarch Umur', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($ModPemeriksaankandungan, 'menarehe_umur', array('class' => 'span3 numbers-only')); ?>
                        <label>Tahun</label>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Lamanya Haid', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($ModPemeriksaankandungan, 'lama_haid', array('class' => 'numbers-only span3')); ?>
                        <label>Hari</label>
                    </div>
                </div>
                <?php echo $form->radioButtonListRow($ModPemeriksaankandungan, 'banyak_haid', array('Banyak' => 'Banyak', 'Sedikit' => 'Sedikit', 'Encer' => 'Encer', 'Gumpal' => 'Gumpal'), array('class' => 'rd_reaksi')); ?>
                <?php echo $form->radioButtonListRow($ModPemeriksaankandungan, 'haid_sakit', array('Sebelum' => 'Sebelum', 'Selama' => 'Selama', 'Sesudah' => 'Sesudah'), array('class' => 'rd_reaksi')); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Warna', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($ModPemeriksaankandungan, 'warna_haid', array('class' => 'span3')); ?>

                    </div>
                </div>
                <?php echo $form->radioButtonListRow($ModPemeriksaankandungan, 'bau_haid', array('Berbau' => 'Berbau'), array('class' => 'rd_reaksi')); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Partus y.l (sectio,forceo dll)', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($ModPemeriksaankandungan, 'partus', array('class' => 'span3')); ?>

                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Abortus', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($ModPemeriksaankandungan, 'abortus', array('class' => 'span3')); ?>

                    </div>
                </div>
                <div class="kb">
                    <div class="control-group">
                        <?php echo CHtml::label('KB', '', array('class' => 'control-label')); ?>
                        <div class='controls'>
                            <?php echo $form->checkBox($ModPemeriksaankandungan, 'kb_positif', array()); ?> <label><B class='simbol-plus'>+</B></label>
                            <?php echo $form->checkBox($ModPemeriksaankandungan, 'kb_negatif', array('class' => 'negatif-kepala')); ?> <label><B class='simbol-plus'>-</B></label>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
                        <div class='controls'>
                            <?php echo $form->textField($ModPemeriksaankandungan, 'kb_keterangan', array('placeholder' => 'Kb dengan apa', 'class' => 'span3', 'readonly' => false)) ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Status Lokalis', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($ModPemeriksaankandungan, 'status_lokalis', array('class' => 'span3')); ?>

                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Genitalis', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($ModPemeriksaankandungan, 'genitalis', array('class' => 'span3')); ?>

                    </div>
                </div>

            </div>
            <div class="col-sm-6">
                <div class="suami">
                    <div class="control-group">
                        <?php echo CHtml::label('Bersuami', '', array('class' => 'control-label')); ?>
                        <div class='controls'>
                            <?php echo $form->checkBox($ModPemeriksaankandungan, 'suami_ya', array()); ?> <label>Ya</label>
                            <?php echo $form->checkBox($ModPemeriksaankandungan, 'suami_tidak', array('class' => 'negatif-kepala')); ?> <label>Tidak</label>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Berapa Lama', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($ModPemeriksaankandungan, 'lama_pernikahan', array('class' => 'span3')); ?>
                        <label>TH</label>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Berapa Kali', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($ModPemeriksaankandungan, 'berapakali_pernikahan', array('class' => 'span3')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Fluor', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($ModPemeriksaankandungan, 'fluor', array('class' => 'span3')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Berapa Lama', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($ModPemeriksaankandungan, 'berapa_lama', array('placeholder' => 'berapa lama flour', 'class' => 'numbers-only span3')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Warna', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($ModPemeriksaankandungan, 'warna_fluor', array('placeholder' => 'warna flour', 'class' => 'span3')); ?>
                    </div>
                </div>
                <?php echo $form->radioButtonListRow($ModPemeriksaankandungan, 'banyak_fluor', array('Banyak' => 'Banyak', 'Sedikit' => 'Sedikit'), array('class' => 'rd_reaksi')); ?>
                <?php echo $form->radioButtonListRow($ModPemeriksaankandungan, 'bau_fluor', array('Berbau' => 'Berbau'), array('class' => 'rd_reaksi')); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Jumlah Anak', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($ModPemeriksaankandungan, 'jumlah_anak', array('class' => 'numbers-only')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Jumlah Anak Hidup', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($ModPemeriksaankandungan, 'jumlah_anak_hidup', array('class' => 'numbers-only')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Jumlah Anak Mati', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($ModPemeriksaankandungan, 'jumlah_anak_mati', array('class' => 'numbers-only')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Umur Anak Paling Kecil', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($ModPemeriksaankandungan, 'umur_anak_kecil', array('placeholder' => 'umur', 'class' => 'span3 numbers-only')); ?>
                        <label>Tahun</label>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Penyakit Lama Yang diderita', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($ModPemeriksaankandungan, 'nama_penyakit_lama', array('class' => 'span3')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Anamnesa Keluarga(tumor dsb nya)', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($ModPemeriksaankandungan, 'anamnesia_keluarga', array('class' => 'span3')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Abdomen', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($ModPemeriksaankandungan, 'abdomen', array('class' => 'span3')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Diagnosis', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($ModPemeriksaankandungan, 'diagnosis', array('class' => 'span3')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>