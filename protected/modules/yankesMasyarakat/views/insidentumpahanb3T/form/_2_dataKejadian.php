<div class="row-fluid">
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label("Tanggal Kejadian <i style='color: red'> * </i>", "", array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                if (!empty($_GET['is_detail'])) {
                    echo CHtml::activeTextField($model, 'tgl_kejadian', array('class' => 'span4', 'readonly' => true));
                } else {
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_kejadian',
                        'mode' => 'datetime',
                        'options' => array(
                            'maxDate' => 'D', 
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:200px;'
                        ),
                    ));
                }
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label('Unit Kerja Kejadian <span class="required">*</span>', 'unitkerjapenyebab_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo CHtml::activeHiddenField($model, 'unitkerja_kejadian_id', array('class' => 'span4', 'readonly' => true));
                if (empty($_GET['is_edit'])) {
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'unitkerja_kejadian_nama',
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
                    echo CHtml::activeTextField($model, 'unitkerja_kejadian_nama', array('class' => 'span4', 'readonly' => true));
                }
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'lokasikejadian', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Lokasi Kejadian')); ?>
    </div>
</div>
<div class="row-fluid">
    <div class="panel panel-success">
        <span class="group-title"> Rincian Kejadian </span>
        <div class="panel-body">
            <?php echo $form->textAreaRow($model, 'kronologistumpahanb3', array('class' => 'span8', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Kronologis Tumpahan B3')); ?>
            <?php echo $form->textAreaRow($model, 'penyebabtumpahanb3', array('class' => 'span8', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Penyebab Tumpahan B3')); ?>
            <?php echo $form->textAreaRow($model, 'kerugiantumpahanb3', array('class' => 'span8', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Kerugian/Akibat Tumpahan B3')); ?>
            <?php echo $form->textAreaRow($model, 'upayayangdilakukan', array('class' => 'span8', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Upaya yang Sudah Dilakukan')); ?>
            <?php echo $form->textAreaRow($model, 'usulanperbaikan', array('class' => 'span8', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Usulan Perbaikan')); ?>
        </div>
    </div>
</div>