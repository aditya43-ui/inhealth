<div class="col-md-6">
    <div class="control-group ">
        <label class="control-label"> Pegawai Mengetahui <span class="required"> * </span> </label>
        <div class="controls">
            <?php
            echo $form->hiddenField($model, 'pegawai_mengetahui_id', array('readonly' => true, 'class' => 'required'));
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'pegawai_mengetahui_nama',
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
                                                $("#BJSterilisasibatanT_petugasberangkat_id").val(ui.item.value);
                                                $("#BJSterilisasibatanT_petugasberangkat_nama").val(ui.item.label);
                                                return false;
                                            }',
                ),
                'htmlOptions' => array(
                    'readonly' => false,
                    'placeholder' => 'Ketik Nama Pegawai',
                    'size' => 20,
                    'class' => 'span3',
                    'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'petugasberangkat_id') . '").val(""); ',
                    'onkeypress' => "return $(this).focusNextInputField(event);",
                ),
                'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
            ));
            ?>
        </div>
    </div>

    <div class="control-group ">
        <label class="control-label"> Pegawai Menyetujui I <span class="required"> * </span> </label>
        <div class="controls">
            <?php
            echo $form->hiddenField($model, 'pegawai_menyetujui1_id', array('readonly' => true, 'class' => 'required'));
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'pegawai_menyetujui1_nama',
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
                                                $("#BJSterilisasibatanT_petugasberangkat_id").val(ui.item.value);
                                                $("#BJSterilisasibatanT_petugasberangkat_nama").val(ui.item.label);
                                                return false;
                                            }',
                ),
                'htmlOptions' => array(
                    'readonly' => false,
                    'placeholder' => 'Ketik Nama Pegawai',
                    'size' => 20,
                    'class' => 'span3',
                    'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'petugasberangkat_id') . '").val(""); ',
                    'onkeypress' => "return $(this).focusNextInputField(event);",
                ),
                'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui'),
            ));
            ?>
        </div>
    </div>
</div>
<div class="col-md-6">

    <div class="control-group ">
        <label class="control-label"> Pegawai Menyetujui II <span class="required"> * </span> </label>
        <div class="controls">
            <?php
            echo $form->hiddenField($model, 'pegawai_menyetujui2_id', array('readonly' => true, 'class' => 'required'));
          //  echo $form->textField($model, 'pegawai_menyetujui2_nama', array('readonly' => true));
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'pegawai_menyetujui2_nama',
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
                                                $("#BJSterilisasibatanT_petugasberangkat_id").val(ui.item.value);
                                                $("#BJSterilisasibatanT_petugasberangkat_nama").val(ui.item.label);
                                                return false;
                                            }',
                ),
                'htmlOptions' => array(
                    'readonly' => false,
                    'placeholder' => 'Ketik Nama Pegawai',
                    'size' => 20,
                    'class' => 'span3',
                    'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'petugasberangkat_id') . '").val(""); ',
                    'onkeypress' => "return $(this).focusNextInputField(event);",
                ),
                'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui2'),
            ));
            ?>
        </div>
    </div>
</div>