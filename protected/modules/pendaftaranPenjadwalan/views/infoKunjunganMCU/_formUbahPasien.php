<?php echo $form->errorSummary($model); ?>
<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<table border="1">
    <tr>
        <td widht="50%">
            <table>
                <tr>
                    <td><?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 6, 'readonly' => TRUE)); ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->textFieldRow($model, 'tgl_rekam_medik', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 6, 'readonly' => TRUE)); ?></td>
                </tr>
                <tr>
                    <td>
                        <div class="control-group">
                            <div class="control-label">
                                Foto Pasien
                            </div>
                            <div class="controls">
                                <?php echo $form->fileField($model, 'photopasien', array('onchange' => "readURL(this);", 'maxlength' => 254, 'hint' => 'Isi jika akan mengganti photo', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <p class="help-block">Isi jika akan mengganti photo</p>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
        <td valign="top" align="center">
            <?php
            if (!empty($model->photopasien)) {
                echo CHtml::image(Params::urlPasienTumbsDirectory() . 'kecil_' . $model->photopasien, 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
            } else {
                echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
            }
            ?>
        </td>
    </tr>
</table>
<table class="table">
    <tr>
        <td>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'no_identitas_pasien', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList(
                        $model,
                        'jenisidentitas',
                        LookupM::getItems('jenisidentitas'),
                        array(
                            'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2'
                        )
                    ); ?>
                    <?php echo $form->textField($model, 'no_identitas_pasien', array('placeholder' => 'No. Identitas', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>
                    <?php echo $form->error($model, 'jenisidentitas'); ?><?php echo $form->error($model, 'no_identitas'); ?>
                </div>
            </div>
            <?php //echo $form->textFieldRow($model,'no_identitas_pasien',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); 
            ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'nama_pasien', array('class' => 'control-label')) ?>
                <div class="controls inline">

                    <?php echo $form->dropDownList(
                        $model,
                        'namadepan',
                        LookupM::getItems('namadepan'),
                        array(
                            'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2'
                        )
                    ); ?>
                    <?php echo $form->textField($model, 'nama_pasien', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>

                    <?php echo $form->error($model, 'namadepan'); ?><?php echo $form->error($model, 'nama_pasien'); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'nama_bin', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model, 'tempat_lahir', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'tanggal_lahir', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tanggal_lahir',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                    )); ?>
                    <?php echo $form->error($model, 'tanggal_lahir'); ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($model, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->dropDownListRow($model, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'golongandarah', array('class' => 'control-label')) ?>

                <div class="controls">

                    <?php echo $form->dropDownList(
                        $model,
                        'golongandarah',
                        LookupM::getItems('golongandarah'),
                        array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')
                    ); ?>
                    <div class="radio inline">
                        <div class="form-inline">
                            <?php echo $form->radioButtonList($model, 'rhesus', LookupM::getItems('rhesus'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <?php echo $form->error($model, 'golongandarah'); ?>
                    <?php echo $form->error($model, 'rhesus'); ?>
                </div>
            </div>
            <?php
            echo $form->textFieldRow(
                $model,
                'nama_ibu',
                array(
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'placeholder' => 'Nama Ibu'
                )
            );
            ?>
            <?php
            echo $form->textFieldRow(
                $model,
                'nama_ayah',
                array(
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'placeholder' => 'Nama Ayah'
                )
            );
            ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model, 'alamat_pasien', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'rt', array('class' => 'control-label inline')) ?>

                <div class="controls">
                    <?php echo $form->textField($model, 'rt', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1', 'maxlength' => 3)); ?> /
                    <?php echo $form->textField($model, 'rw', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1', 'maxlength' => 3)); ?>
                    <?php echo $form->error($model, 'rt'); ?>
                    <?php echo $form->error($model, 'rw'); ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow(
                $model,
                'propinsi_id',
                CHtml::listData(PropinsiM::model()->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'),
                array(
                    'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => get_class($model))),
                        'update' => '#PPPasienM_kabupaten_id'
                    )
                )
            ); ?>
            <?php echo $form->dropDownListRow(
                $model,
                'kabupaten_id',
                CHtml::listData(KabupatenM::model()->getKabupatenItemsProp($model->propinsi_id), 'kabupaten_id', 'kabupaten_nama'),
                array(
                    'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('SetDropdownKecamatan', array('encode' => false, 'model_nama' => get_class($model))),
                        'update' => '#PPPasienM_kecamatan_id'
                    )
                )
            ); ?>
            <?php echo $form->dropDownListRow(
                $model,
                'kecamatan_id',
                CHtml::listData(KecamatanM::model()->getKecamatanItemsKab($model->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'),
                array(
                    'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('SetDropdownKelurahan', array('encode' => false, 'model_nama' => get_class($model))),
                        'update' => '#PPPasienM_kelurahan_id',
                    )
                )
            ); ?>
            <?php echo $form->dropDownListRow($model, 'kelurahan_id', CHtml::listData(KelurahanM::model()->getKelurahanItemsKec($model->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>

            <?php echo $form->textFieldRow($model, 'no_telepon_pasien', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model, 'no_mobile_pasien', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </td>
    </tr>
</table>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#photo_pasien')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>