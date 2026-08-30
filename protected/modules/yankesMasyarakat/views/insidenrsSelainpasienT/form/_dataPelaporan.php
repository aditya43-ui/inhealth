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
    <?php echo $form->textFieldRow($model, 'pelapor_nama', array('readonly' => true, 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nama Pelapor')); ?>

</div>
<div class="col-md-6">
    <?php echo $form->textFieldRow($model, 'no_kejadian', array('readonly' => true, 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nomor Kejadian')); ?>

    <div class="control-group">
        <?php echo CHtml::label('Satuan Kerja <span class="required">*</span>', 'unitkerjapenyebab_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo CHtml::activeHiddenField($model, 'unitkerja_pelapor_id', array('class' => 'span4', 'readonly' => true));
            if (empty($_GET['is_edit'])) {
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'unitkerja_pelapor_nama',
                    'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('AutocompleteUnitKerja') . '",
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
                                $(this).val(ui.item.label);
                                $("#YKMInsidenrsSelainpasienT_unitkerja_pelapor_id").val( ui.item.value );
                                return false;
                            }',
                    ),
                    'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 required', 'placeholder' => 'Pilih Nama Unit Kerja Penyebab',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogUnit', 'idTombol' => 'tombolDialogPenelitian'),
                ));
            } else {
                echo CHtml::activeTextField($model, 'unitkerja_pelapor_nama', array('class' => 'span4', 'readonly' => true));
            }
            ?>
        </div>
    </div>
</div>
