<div class = "col-sm-6">
    <div class="control-group">
        <label class="control-label">Tanggal</label>
        <?php $modPenilaian->tanggal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenilaian->tanggal, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $modPenilaian,
                'attribute' => 'tanggal',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'minDate' => 'd',
                ),
                'htmlOptions' => array('readonly' => true, 'class' => ' span3'),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Spesimen <span class='required'>*</span>", 'manajerpelayanan_id', array('class' => 'control-label required')) ?>
        <div class = "controls">
            <div class="input-append">
                <?php 
                
                $dataKirimSpesimen->samplelab_nama = !empty($dataKirimSpesimen->samplelab->samplelab_nama) ? $dataKirimSpesimen->samplelab->samplelab_nama : ''; ?>
                <?php echo $form->textField($dataKirimSpesimen, 'samplelab_nama', array('class' => 'span3', 'placeholder' => 'Pilih Spesimen')); ?>
                <span class="add-on"><a onclick="setDialogSampleLab(this);" id="" href="javascript:void(0);"><i class="icon-list"></i><i class="icon-search"></i></a></span>
            </div>
            <?php echo $form->hiddenField($dataKirimSpesimen, 'samplelab_id', array('class' => 'span3', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Spesimen ID</label>
        <div class="controls">
            <?php echo CHtml::activeTextField($modSpesimen2, 'no_spesimen', array('class' => 'span3', 'readonly'=>true, 'placeholder'=>'-Otomatis-')); ?>
        </div>
    </div>
</div>
<div class = "col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("Manajer Pelayanan <span class='required'>*</span>", 'manajerpelayanan_id', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php echo $form->hiddenField($modPenilaian, 'manajerpelayanan_id', array('class' => 'span3 required', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modPenilaian,
                'attribute' => 'manajerpelayanan_nama',
                'source' => 'js: function(request, response) {
                    $.ajax({
                        url: "' . $this->createUrl('autoCompletePegawai') . '",
                        dataType: "json",
                        data: {
                            term: request.term,
                        },
                        success: function (data) {
                            response(data);
                        }
                    })
                }',
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'select' => 'js:function( event, ui ) {
                        $(this).val( ui.item.nama_pegawai );
                        $("#'.CHtml::activeId($modPenilaian, 'manajerpelayanan_id').'").val( ui.item.pegawai_id );
                        return false;
                    }',
                ),
                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Ketikkan Nama Pegawai'),
                'tombolDialog' => array('idDialog' => 'dialogManajerPelayanan', 'idTombol' => 'tombol1'),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("DPJTM <span class='required'>*</span>", 'dpjtm_id', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php echo $form->hiddenField($modPenilaian, 'dpjtm_id', array('class' => 'span3 required', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modPenilaian,
                'attribute' => 'dpjtm_nama',
                'source' => 'js: function(request, response) {
                    $.ajax({
                        url: "' . $this->createUrl('autoCompletePegawai') . '",
                        dataType: "json",
                        data: {
                            term: request.term,
                        },
                        success: function (data) {
                            response(data);
                        }
                    })
                }',
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'select' => 'js:function( event, ui ) {
                        $(this).val( ui.item.nama_pegawai );
                        $("#'.CHtml::activeId($modPenilaian, 'dpjtm_id').'").val( ui.item.pegawai_id );
                        return false;
                    }',
                ),
                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Ketikkan Nama Pegawai'),
                'tombolDialog' => array('idDialog' => 'dialogDpjtm', 'idTombol' => 'tombol2'),
            ));
            ?>
        </div>
    </div>
    <?php /*
    <div class="control-group">
        <?php echo CHtml::label("PPDS <span class='required'>*</span>", 'ppds_id', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php echo $form->hiddenField($modPenilaian, 'ppds_id', array('class' => 'span3 required', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modPenilaian,
                'attribute' => 'ppds_nama',
                'source' => 'js: function(request, response) {
                    $.ajax({
                        url: "' . $this->createUrl('autocompletePpds') . '",
                        dataType: "json",
                        data: {
                            term: request.term,
                        },
                        success: function (data) {
                            response(data);
                        }
                    })
                }',
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'select' => 'js:function( event, ui ) {
                        $(this).val( ui.item.ppds_nama );
                        $("#'.CHtml::activeId($modPenilaian, 'ppds_id').'").val( ui.item.ppds_id );
                        return false;
                    }',
                ),
                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Ketikkan Nama PPDS'),
                'tombolDialog' => array('idDialog' => 'dialogPpds', 'idTombol' => 'tombol3'),
            ));
            ?>
        </div>
    </div>
     */ ?>
</div>