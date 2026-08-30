<div class="col-md-6">
    <div class="control-group">
        <label class="control-label">Tanggal</label>
        <?php $modStaining->tanggal_staining = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modStaining->tanggal_staining, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $modStaining,
                'attribute' => 'tanggal_staining',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array('readonly' => true, 'class' => ' span3'),
            ));
            ?>
        </div>
    </div>
</div>
<div class = "col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("Analis <span class='required'>*</span>", 'manajerpelayanan_id', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php echo $form->hiddenField($modStaining, 'analis_id', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modStaining,
                'attribute' => 'analis_nama',
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
                        $("#' . CHtml::activeId($modStaining, 'analis_id') . '").val( ui.item.pegawai_id );
                        $("#analis_nip").val( ui.item.nomorindukpegawai );
                        return false;
                    }',
                ),
                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'placeholder' => 'Ketikkan Nama Pegawai'),
                'tombolDialog' => array('idDialog' => 'dialogAnalis', 'idTombol' => 'tombol1'),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("NIM / NIP", 'analis_nip', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('analis_nip', $modStaining->analis_nip, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
