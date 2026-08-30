<div class="col-md-6">
    <div class="control-group">
        <?php echo CHtml::label("Tanggal Kejadian <i style='color: red'> * </i>", "", array( 'class' => 'control-label' )); ?>
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
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:180px;'
                    ),
                ));
            }
            ?>
        </div>
    </div>
    
    <?php echo $form->textFieldRow($model, 'lokasikejadian', array('class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Lokasi Kejadian')); ?>
    <?php echo $form->textFieldRow($model, 'namakorban', array('class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Nama Korban')); ?>
    
    <div class="control-group">
        <?php echo CHtml::label('Nama Karyawan yang Mengetahui / Melihat', '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo CHtml::activeHiddenField($model, 'pegawai_mengetahuikejadian_id', array('class' => 'span4', 'readonly' => true));
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'pegawai_mengetahuikejadian_nama',
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
                            $("#YKMInsidenrsSelainpasienT_pegawai_mengetahuikejadian_id").val( ui.item.value );
                            return false;
                        }',
                ),
                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)",  'class' => 'span4', 'placeholder' => 'Pilih Nama Pegawai',
                ),
                 'tombolDialog'=>array('idDialog'=>'dialogPegawai','idTombol'=>'tombolDialogPenelitian'),
            ));?>
        </div>
    </div>
        
    <?php echo $form->textAreaRow($model, 'uraiankejadian', array('class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Uraian Kejadian')); ?>
    <?php echo $form->dropDownListRow($model,'jeniskejadian', LookupM::getItemsUrutan('jenisinsiden'),array('empty' => '-- Pilih --', 'class'=>'span4','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'setJenisForm(); return false;')); ?>

    <?php echo $form->textFieldRow($model, 'cederaakibatkerja', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Cedera Akibat Kerja')); ?>
    <?php echo $form->textFieldRow($model, 'penyakitakibatkerja', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Penyakit Akibat Kerja')); ?>

</div>
<div class="col-md-6">
    <?php echo $form->dropDownListRow($model, 'jeniscedera', LookupM::getItems('jeniscedera')
                    , array('empty'=>'-- Pilih --', 'class' => 'span4')); ?>
    <?php echo $form->textFieldRow($model, 'bagianbadan_cedera', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Bagian Badan Cedera')); ?>
    <?php echo $form->textAreaRow($model, 'penyakityangtimbul', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Penyakit yang Timbul')); ?>
    <?php echo $form->textAreaRow($model, 'tindakanyangdiambil', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Tindakan yang Diambil')); ?>
    <?php echo $form->textAreaRow($model, 'kesimpulanpenyebabinsiden', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Kesimpulan Penyebab Insiden')); ?>
    <?php echo $form->textAreaRow($model, 'rekomendasi', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Rekomendasi')); ?>
    
</div>