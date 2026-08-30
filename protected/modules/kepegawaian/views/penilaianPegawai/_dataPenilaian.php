<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->labelEx($model, 'tglpenilaian', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tglpenilaian',
                'mode' => 'date',
                'options' => array(
                    'showOn' => false,
                    // 'maxDate' => 'd',
                    'yearRange' => "-150:+0",
                ),
                'htmlOptions' => array('placeholder' => '00/00/0000', 'class' => 'dtPicker3 datemask span3', 'onkeyup' => "return $(this).focusNextInputField(event)")
                //									'htmlOptions'=>(isset($_GET['id'])? array('placeholder'=>'00/00/0000','class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"):array('placeholder'=>'00/00/0000','class'=>'dtPicker3 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"))
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tanggapan Pejabat', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tanggal_tanggapanpejabat',
                'mode' => 'date',
                'options' => array(
                    'showOn' => false,
                    // 'maxDate' => 'd',
                    'yearRange' => "-150:+0",
                ),
                'htmlOptions' => array(
                    'placeholder' => '00/00/0000', 'class' => 'dtPicker3 datemask span3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'tanggapanpejabat', array('rows' => 2, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Tanggapan Pejabat', 'style' => 'width:200px')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Keputusan Atasan', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tanggal_keputusanatasan',
                'mode' => 'date',
                'options' => array(
                    'showOn' => false,
                    // 'maxDate' => 'd',
                    'yearRange' => "-150:+0",
                ),
                'htmlOptions' => array(
                    'placeholder' => '00/00/0000', 'class' => 'dtPicker3 datemask span3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'keputusanatasan', array('rows' => 2, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Keputusan Atasan', 'style' => 'width:200px')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Keberatan Pegawai', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tanggal_keberatanpegawai',
                'mode' => 'date',
                'options' => array(
                    'showOn' => false,
                    // 'maxDate' => 'd',
                    'yearRange' => "-150:+0",
                ),
                'htmlOptions' => array(
                    'placeholder' => '00/00/0000', 'class' => 'dtPicker3 datemask span3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'keberatanpegawai', array('rows' => 2, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Keberatan Pegawai', 'style' => 'width:200px')); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <?php /*
    <div class="control-group">
        <?php echo CHtml::label('Keterangan Penilaian Pegawai','',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textArea($model,'penilaianpegawai_keterangan',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'style'=>'width:200px')); ?>
        </div>
    </div>
	 * 
	 */ ?>
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Diterima Pegawai', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'diterimatanggalpegawai',
                'mode' => 'date',
                'options' => array(
                    'showOn' => false,
                    // 'maxDate' => 'd',
                    'yearRange' => "-150:+0",
                ),
                'htmlOptions' => array(
                    'placeholder' => '00/00/0000', 'class' => 'dtPicker3 datemask span3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Diterima Atasan', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'diterimatanggalatasan',
                'mode' => 'date',
                'options' => array(
                    'showOn' => false,
                    // 'maxDate' => 'd',
                    'yearRange' => "-150:+0",
                ),
                'htmlOptions' => array(
                    'placeholder' => '00/00/0000', 'class' => 'dtPicker3 datemask span3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
    <div id="form-datapenilai">
        <div class="control-group">
            <label class="control-label">
                <span class='tombol' style='display:none;'>
                    <?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPenilaiReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data penilai')); ?>
                </span> &nbsp;
                Nama Penilai
          </label>
            <div class="controls">
                <?php $this->widget('MyJuiAutoComplete', array(
                    'name' => 'penilainama',
                    'value' => $model->penilainama,
                    'sourceUrl' => $this->createUrl('Pegawairiwayat'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            setDataPenilai(ui.item.value);
                            return false;
                        }',

                    ),
                    'htmlOptions' => array('placeholder' => 'Nama Penilai', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'style' => 'width:200px'),
                    'tombolDialog' => array('idDialog' => 'dialogPenilai'),
                )); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'penilainip', array('readonly' => true, 'style' => 'width:200px')); ?>
        <?php echo $form->textFieldRow($model, 'penilaijabatan', array('readonly' => true, 'style' => 'width:200px')); ?>
        <?php echo $form->textFieldRow($model, 'penilaiunitorganisasi', array('readonly' => true, 'style' => 'width:200px')); ?>
    </div>
</div>
<div class="col-sm-6">
    <div id="form-datapimpinan">
        <div class="control-group">
            <label class="control-label">
                <span class='tombol' style='display:none;'>
                    <?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPimpinanReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data pimpinan')); ?>
                </span> &nbsp;
                Nama Pimpinan
          </label>
            <div class="controls">
                <?php $this->widget('MyJuiAutoComplete', array(
                    'name' => 'pimpinannama',
                    'value' => $model->pimpinannama,
                    'sourceUrl' => $this->createUrl('Pegawairiwayat'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            setDataPimpinan(ui.item.value);
                            return false;
                        }',

                    ),
                    'htmlOptions' => array('placeholder' => 'Nama Pimpinan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'style' => 'width:200px'),
                    'tombolDialog' => array('idDialog' => 'dialogPimpinan'),
                )); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'pimpinannip', array('readonly' => true, 'style' => 'width:200px')); ?>
        <?php echo $form->textFieldRow($model, 'pimpinanjabatan', array('readonly' => true, 'style' => 'width:200px')); ?>
        <?php echo $form->textFieldRow($model, 'pimpinanunitorganisasi', array('readonly' => true, 'style' => 'width:200px')); ?>
    </div>
</div>