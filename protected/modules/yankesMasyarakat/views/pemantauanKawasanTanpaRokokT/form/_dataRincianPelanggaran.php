<div class="col-md-6">
    <div class="control-group">
        <?php echo CHtml::label("Tanggal Inspeksi <i style='color: red'> * </i>", "", array( 'class' => 'control-label required' )); ?>
        <div class="controls">
            <?php
            if (!empty($_GET['is_detail'])) {
                echo CHtml::activeTextField($model, 'tgl_inspeksi', array('class' => 'span4', 'readonly' => true));
            } else {
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_inspeksi',
                    'mode' => 'datetime',
                    'options' => array(
                        'maxDate' => 'D',
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:180px;'
                    ),
                ));
            }
            ?>
        </div>
    </div>
    
    <?php echo $form->textFieldRow($model, 'lokasi_pemantauan', array('class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Lokasi Kejadian')); ?>
    
    <div class="control-group">
        <?php echo CHtml::label('Unit Kerja', '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo CHtml::activeHiddenField($model, 'unitkerja_pemantauan_id', array('class' => 'span4', 'readonly' => true));
            if (empty($_GET['is_edit'])) {
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'unitkerja_pemantauan_nama',
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
                                $("#YKMPemantauankawasantanparokokT_unitkerja_pemantauan_id").val( ui.item.value );
                                return false;
                            }',
                    ),
                    'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 required', 'placeholder' => 'Pilih Nama Unit Kerja',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogUnit', 'idTombol' => 'tombolDialogPenelitian'),
                ));
            } else {
                echo CHtml::activeTextField($model, 'unitkerja_pemantauan_nama', array('class' => 'span4', 'readonly' => true));
            }
            ?>
        </div>
    </div>
        
    <?php echo $form->textFieldRow($model, 'namapelanggar', array('class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Nama Pelanggar')); ?>
    <?php echo $form->dropDownListRow($model,'jenisidentitas', LookupM::getItems('jenisidentitas'), array('empty'=>'-- Pilih Jenis Identitas--', 'class' => 'span4')); ?>
    <?php echo $form->textFieldRow($model, 'no_identitas', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'No.Identitas')); ?>
</div>
<div class="col-md-6">
    <?php echo $form->dropDownListRow($model, 'tempatkejadian_perkara', LookupM::getItems('kejadianperkara'), array('empty'=>'-- Pilih Tempat Kejadian--', 'class' => 'span4')); ?>
    <?php echo $form->textFieldRow($model, 'jenispelanggaran', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Jenis Pelanggaran')); ?>
    <?php echo $form->textAreaRow($model, 'tindakanyangdiambil', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Tindakan Yang Diambil')); ?>
</div>