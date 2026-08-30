<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"> <b> Data Kontrak </b></div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'nosuratperjanjiankerja', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->hiddenField($model, 'persiapanpengadaan_id', array('readonly'=>true, 'class'=>'span3','value'=>isset($_GET['id'])?$_GET['id']:$model->persiapanpengadaan_id)); ?>
                    <?php echo $form->textField($model, 'nosuratperjanjiankerja', array('readonly'=>true, 'class'=>'span3')); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'nomor_dokumen', array('class' => 'control-label','label'=>'Nomor Surat')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'nomor_dokumen', array(
                    'readonly'=>false, 
                    'class'=>'span3 required'
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'tglsuratperjanjian', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tglsuratperjanjian',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            // 'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('class'=>'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                    <?php echo $form->error($model, 'tglsuratperjanjian'); ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label"> Jenis Kontrak </label>
                <div class="controls">
                    <?php echo CHtml::activeDropDownList($model,'kontrakcarapembayaran', LookupM::getItems('kontrakcarapembayaran'), array('onchange' => 'hitungTotalSeluruhnya()', 'empty' => '-- Pilih --', 'class' => 'span3'));?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($modPengadaan, 'pelaksanaankontrak_tglawal', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modPengadaan,
                        'attribute' => 'pelaksanaankontrak_tglawal',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            // 'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('class'=>'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                    <?php echo $form->error($modPengadaan, 'pelaksanaankontrak_tglawal'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($modPengadaan, 'pelaksanaankontrak_tglakhir', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modPengadaan,
                        'attribute' => 'pelaksanaankontrak_tglakhir',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'onClose'=>'js:function(){hitungjangkawaktu();}',
                            // 'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('class'=>'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                    <?php echo $form->error($modPengadaan, 'pelaksanaankontrak_tglakhir'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'namapekerjaan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textArea($model, 'namapekerjaan', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'rows'=>3,
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">      
            <div class="control-group ">
                <label class="control-label">Unit Kerja</label>
                <div class="controls">
                    <?php echo $form->hiddenField($modPengadaan, 'instalasi_nama', array('readonly'=>true, 'class'=>'span3')); ?>
                    <?php echo $form->hiddenField($modPengadaan, 'instalasi_id', array('readonly'=>true, 'class'=>'span3')); ?>
                    <?php echo $form->textField($modPengadaan, 'namaunitkerja', array('readonly'=>true, 'class'=>'span3')); ?>
                    <?php echo $form->hiddenField($modPengadaan, 'unitkerja_id', array('readonly'=>true, 'class'=>'span3')); ?>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">Metode Pengadaan</label>
                <div class="controls">
                    <?php echo $form->textField($modPengadaan, 'metodepengadaan_nama', array('readonly'=>true, 'class'=>'span3')); ?>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">Jangka Waktu</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'jangka_waktu', array('readonly'=>true, 'class'=>'span3')); ?> <label>Hari</label>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">No. Surat Pengadaan Langsung</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'suratundanganpl_nomor', array('class'=>'span3')); ?>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">Tanggal Surat Pengadaan Langsung</label>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'suratundanganpl_tanggal',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                    <?php echo $form->error($model, 'suratundanganpl_tanggal'); ?>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">No. BA Hasil Pengadaan Langsung</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'bahasilpl_nomor', array('class'=>'span3')); ?>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">Tanggal BA Hasil Pengadaan Langsung</label>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'bahasilpl_tanggal',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('class'=>'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                    <?php echo $form->error($model, 'bahasilpl_tanggal'); ?>
                </div>
            </div>

        </div>
        <div class="clear"></div>
    </div>
</div>