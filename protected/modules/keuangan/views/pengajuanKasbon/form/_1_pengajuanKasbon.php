<div class="col-sm-6">
    <div class="control-group">
        <?= $form->labelEx($model, 'tgl_pengajuan', ['class' => 'control-label']) ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tgl_pengajuan',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array(
                    'readonly' => true,
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'class' => 'span3'
                ),
            ));
            ?>
        </div>
    </div>
    
    <?= $form->textFieldRow($model, 'no_pengajuan', ['class' => 'span3', 'readonly' => true]) ?>
    
    <div class="control-group">
        <?= $form->labelEx($model, 'keperluan', ['class' => 'control-label']) ?>

        <div class="controls">
            <?php
            $this->widget('ext.redactorjs.Redactor', array(
                'model' => $model,
                'attribute' => 'keperluan',
                'toolbar' => 'mini',
                'height' => '150px',
            )); ?>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class="control-group">
        <?= $form->labelEx($model, 'pegawai_mengajukan_nama', ['class' => 'control-label']) ?>
        <div class="controls">
        <?php
            echo $form->hiddenField($model, 'pegawai_mengajukan_id', array('readonly' => true, 'class' => 'required'));
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'pegawai_mengajukan_nama',
                'source' => 'js: function(request, response) {
                                            $.ajax({
                                                url: "' . $this->createUrl('/ActionAutoComplete/GetPegawaiRuanganLogin') . '",
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
                    'focus' => 'js:function( event, ui ) {
                                                $(this).val("");
                                                return false;
                                            }',
                    'select' => 'js:function( event, ui ) {
                                                $(this).val(ui.item.label);
                                                $("#'.CHtml::activeId($model, 'pegawai_mengajukan_id').'").val(ui.item.value);
                                                return false;
                                            }',
                ),
                'htmlOptions' => array(
                    'readonly' => false,
                    'placeholder' => 'Ketik Nama Pegawai',
                    'size' => 20,
                    'class' => 'span3',
                    'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'pegawai_mengajukan_id') . '").val(""); ',
                    'onkeypress' => "return $(this).focusNextInputField(event);",
                ),
                'tombolDialog' => array('idDialog' => 'dialogPegawaiPengajuan'),
            ));
            ?>
        </div>
    </div>
    <?php //$form->hiddenField($model, 'pegawai_mengajukan_id', ['class' => 'span3']) ?>
    <?php //$form->textFieldRow($model, 'pegawai_mengajukan_nama', ['class' => 'span3']) ?>
    <?php //echo $form->textFieldRow($model, 'nip', ['class' => 'span3', 'readonly' => true]) ?>
    <?= $form->textFieldRow($model, 'unitkerja_nama', ['class' => 'span3']) ?>
    <?= $form->textFieldRow($model, 'nominal_kasbon', ['class' => 'span3 integer2', 'readonly' => false]) ?>



</div>