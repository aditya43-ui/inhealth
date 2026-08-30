
<?php 
$format = new MyFormatter();
?>
<div class="panel-body">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("No Identitas <span class=\"required\">*</span>", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($modPendonor, 'jenisidentitas', LookupM::getItemsUrutan('jenisidentitas'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 form-control req jenisidentitas', 'onchange' => 'cekLength(this); valNIK(this);'));
                ?>   
                <br><br>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modPendonor,
                    'attribute' => 'no_identitas',
                    'source' => 'js: function(request, response) {
                        var jenisidentitas = $("#'.CHtml::activeId($modPendonor,"jenisidentitas").'").val();
                        $.ajax({
                            url: "' . $this->createUrl('AutocompleteNomorIdentitas') . '",
                            dataType: "json",
                            data: {
                                no_identitas: request.term,
                                jenisidentitas: jenisidentitas,
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
                    'options' => array(
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val(ui.item.value);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            cekData("pasien",ui.item.pasien_id);
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'No. Identitas',
                        'rel' => 'tooltip',
                        'title' => 'Ketik No. Identitas',
                        'onkeyup' => "setNumbersOnly(this);return $(this).focusNextInputField(event);",
                        'onblur' => "valNIK(this);",
                        'class' => 'form-control span3 alphanumeric-only req all-caps',
                    ),
                ));
                ?>
            </div>
        </div>                  
        <div class="control-group">
            <?php echo CHtml::label('Nama Lengkap <span class="required">*</span>', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modPendonor,
                    'attribute' => 'nama_lengkap',
                    'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('AutocompleteNamaLengkap') . '",
                                dataType: "json",
                                data: {
                                nama_lengkap: request.term,
                            },
                            success: function (data) {
                                    response(data);
                            }
                        })
                    }',
                    'options' => array(
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val(ui.item.value);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            //$(this).val(ui.item.value);
                            cekData("pegawai",ui.item.pendonor_id);
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Nama Lengkap',
                        'rel' => 'tooltip',
                        'title' => 'Ketik Nama Lengkap',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'class' => 'req form-control span3 hurufs-only all-caps',
                        'onblur' => "$('#BDPendonorM_donasi_ke').blur()",
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Tempat Lahir <span class="required">*</span>', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modPendonor,
                    'attribute' => 'tempat_lahir',
                    'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('AutocompleteTempatLahir') . '",
                                dataType: "json",
                                data: {
                                tempat_lahir: request.term,
                            },
                            success: function (data) {
                                    response(data);
                            }
                        })
                    }',
                    'options' => array(
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val(ui.item.value);
                            $(this).val().toUpperCase();
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $(this).val(ui.item.value);
                            $(this).val().toUpperCase();
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Kota/Kabupaten Kelahiran',
                        'rel' => 'tooltip',
                        'title' => 'Ketik tempat lahir pasien',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'class' => 'req form-control span3 all-caps hurufs-only',
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tanggal Lahir <span class="required">*</span>', '', array('class' => 'control-label')) ?>
            <?php $modPendonor->tgllahir = $format->formatDateTimeForUser($modPendonor->tgllahir); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modPendonor,
                    'attribute' => 'tgllahir',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => '-17y',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker2 datemask req', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    ),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($modPendonor, 'gol_darah', LookupM::getItemsUrutan('golongandarah'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'empty' => '-- Pilih --')); ?>
        <?php echo $form->radioButtonListInlineRow($modPendonor, 'rhesus', array("Positif" => "Positif", "Negatif" => "Negatif"), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
    </div>
   
</div>

<div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title"><span class='judul'>Seleksi Donor Darah</span></div>
    </div>
    <div class="panel-body">
        <fieldset  id="form-seleksi">
            <div class="row-fluid">
                <?php $this->renderPartial('seleksiDonor/_formSeleksi', array('form'=>$form,
                    'modSeleksi'=>$modSeleksi,
                    )); 
                ?>
            </div>
        </fieldset>
    </div>
</div>
<br>
