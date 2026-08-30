<div class="col-md-6">
    <div class="control-group">
        <?php echo CHtml::label("Tanggal Pelaporan <i style='color: red'> * </i>", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            if (!empty($_GET['is_edit']) || !empty($_GET['is_detail'])) {
                echo CHtml::activeTextField($model, 'tgl_pelaporan', array('class' => 'span4', 'readonly' => true));
            } else {
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_pelaporan',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:180px;'
                    ),
                ));
              
            }
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Mengetahui <span class="required">*</span>', 'mengetahui_pegawai_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo CHtml::activeHiddenField($model, 'mengetahui_pegawai_id', array('class' => 'span4', 'readonly' => true));
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'mengetahui_pegawai_nama',
                'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('getPegawai') . '",
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
                    'focus' => 'js:function(event, ui ) {
                            return false;
                        }',
                    'select' => 'js:function(event, ui ) {
                            $(this).val(ui.item.nama_pegawai);
                            $("#YKMPemantauankawasantanparokokT_mengetahui_pegawai_id").val( ui.item.value );
                            return false;
                        }',
                ),
                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)",  'class' => 'span4', 'placeholder' => 'Pilih Nama Pegawai',
                ),
                 'tombolDialog'=>array('idDialog'=>'dialogPegawai','idTombol'=>'tombolDialogPenelitian'),
            ));?>
        </div>
    </div>

</div>
<div class="col-md-6">
    <?php echo $form->textFieldRow($model, 'pelapor_nama', array('readonly' => true, 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nama Pelapor')); ?>
</div>
