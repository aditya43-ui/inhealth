<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Penerimaan Darah dari PMI</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php
                    echo $form->label($modelPenerimaan, 'No. Penerimaan <span class="required">*</span>', array(
                        'class' => 'control-label required', 'readonly' => true
                    ));
                    ?>
                    <div class="controls">
                        <?php
                        echo $form->hiddenField($modelPenerimaan, 'penerimaandarahpmi_id', array(
                            'class' => 'penerimaandarahpmi_id',
                        ));

                        if (!empty($modelPenerimaan->penerimaandarahpmi_id)) {
                            echo $form->textField($modelPenerimaan, 'no_penerimaan', array(
                                'readonly' => true,
                                'class' => 'span3 no_penerimaan',
                                'onblur' => 'return false;',
                            ));
                        } else {
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modelPenerimaan,
                                'attribute' => 'no_penerimaan',
                                'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('AutoCompletePenerimaanDarah') . '",
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
                                    $(this).val(ui.item.no_penerimaan);
                                    $(this).parents(".controls").find(".penerimaandarahpmi_id").val(ui.item.penerimaandarahpmi_id);
                                    $(".petugas_penerima_nama").val(ui.item.petugas_penerima_nama);
                                    $(".petugas_mengetahui_nama").val(ui.item.petugas_mengetahui_nama);
                                    $(".tgl_penerimaan").val(ui.item.tgl_penerimaan);
                                    $(".keterangan_penerimaan").val(ui.item.keterangan_penerimaan);
                                    setDetailPenerimaan(ui.item.penerimaandarahpmi_id);
                                    return false;
                                }',
                                ),
                                'htmlOptions' => array(
                                    'disabled' => false,
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'class' => 'span3 no_penerimaan',
                                    'placeholder' => 'No Penerimaan'
                                ),
                                'tombolDialog' => array('idDialog' => 'dialog_penerimaan'),
                            ));
                        }
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->label($modelPenerimaan, 'Petugas Penerima', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modelPenerimaan, 'petugas_penerima_nama', array(
                            'readonly' => true,
                            'class' => 'span3 petugas_penerima_nama',
                            'onblur' => 'return false;',
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->label($modelPenerimaan, 'Mengetahui', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modelPenerimaan, 'petugas_mengetahui_nama', array(
                            'readonly' => true,
                            'class' => 'span3 petugas_mengetahui_nama',
                            'onblur' => 'return false;',
                        )); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->label($modelPenerimaan, 'tgl_penerimaan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modelPenerimaan, 'tgl_penerimaan', array(
                            'readonly' => true,
                            'class' => 'span3 tgl_penerimaan',
                            'onblur' => 'return false;',
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modelPenerimaan, 'keterangan_penerimaan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($modelPenerimaan, 'keterangan_penerimaan', array(
                            'rows' => 3,
                            'readonly' => true,
                            'class' => 'span3 keterangan_penerimaan',
                            'onblur' => 'return false;',
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>