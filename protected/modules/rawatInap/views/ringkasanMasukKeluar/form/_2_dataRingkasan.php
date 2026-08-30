<div class="control-group ">
    <?php echo $form->labelEx($model, 'tanggal_penginputan', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $model,
            'attribute' => 'tanggal_penginputan',
            'mode' => 'datetime',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
            ),
            'htmlOptions' => array('readonly' => true, 'class' => 'span3', 'style' => 'width:150px;'),
        )); ?>
    </div>
</div>

<div class="control-group ">
    <?php //echo $form->labelEx($model, 'dokter_yangmerawat_id', array('class' => 'control-label')) ?>
        <?php echo $form->hiddenField($model,'dokter_yangmerawat_id'); ?>
        <?php echo $form->labelEx($model, 'dokter_yangmerawat_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'dokter_yangmerawat_nama',
                'value' => $model->dokter_yangmerawat_nama,
                'source' => 'js: function(request, response) {
                                           $.ajax({
                                               url: "' . $this->createUrl('AutocompleteNamaDokter') . '",
                                               dataType: "json",
                                               data: {
                                                nama_pegawai: request.term,
                                               },
                                               success: function (data) {
                                                       response(data);
                                               }
                                           })
                                        }',
                'options' => array(
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                                         $(this).val("");
                                         return false;
                                     }',
                    'select' => 'js:function( event, ui ) {
                                        $(this).val(ui.item.label);
                                        $("#RingkasanmasukdankeluarT_dokter_yangmerawat_id").val(ui.item.value);
                                        return false;
                                    }',
                ),
                // 'tombolDialog' => array('idDialog' => 'dialogDokter'),
                'htmlOptions' => array(
                    'placeholder' => 'Nama Dokter', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'onblur' => 'if(this.value===""){ $("#' . CHtml::activeId($model, 'dokter_yangmerawat_id') . '").val(""); }',
                    'class' => 'span3 nama_dokter',
                ),
            ));
            // $dokter_rawat_nama = empty($model->dokteryangmerawat) ? "" : $model->dokteryangmerawat->namaLengkap;
            // $model->dokter_yangmerawat_id = Yii::app()->user->getState('pegawai_id');
            // // echo Yii::app()->user->getState('pegawai_id');
            // echo $form->dropDownList($model, 'dokter_yangmerawat_id', CHtml::listData(DokterV::model()->findAll('instalasi_id = 4'), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event);", 'class' => 'span4'));
            // echo $form->hiddenField($model, 'dokter_yangmerawat_id', array('onkeypress' => "return $(this).focusNextInputField(event);", 'class' => 'dokter_yangmerawat_id'));
            // echo $form->textField($model, 'dokter_yangmerawat_nama', array('onkeypress' => "return $(this).focusNextInputField(event);", 'class' => 'dokter_yangmerawat_nama', 'disabled' => true));
            echo $form->error($model, 'dokter_yangmerawat_nama');
            ?>
            <div class="errorMessage"><span style="color: red;">Dokter yang merawat tidak boleh kosong</span></div>
        </div>
    </div>

    <?= $form->textAreaRow($model, 'indikasiri', ['rows' => 4]) ?>
    <?= $form->textAreaRow($model, 'ringkasanriwayatpenyakit', ['rows' => 4]) ?>