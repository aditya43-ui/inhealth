<div class="row" style="margin-top: 20px; margin-bottom: 20px;">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading" style="display: flex;">
                <div class="panel-title">
                    <i></i> Penandaan Area Operasi
                </div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div class="control-group ">
                            <label class="control-label">Tanggal</label>
                            <div class="controls">
                                <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modAreaOperasi,
                                        'attribute' => 'tgl_penandaanarea',
                                        'value' => null,
                                        'mode' => 'datetime',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            // 'minDate' => 'd',
                                        ),
                                        'htmlOptions' => array(
                                            'readonly' => true,
                                            'onkeypress' => "return $(this).focusNextInputField(event)",
                                            'class' => 'span4 htpd required',
                                        ),
                                    ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class="control-label">Dokter Operator</label>
                            <div class="controls">
                                <?php echo $form->hiddenField($modAreaOperasi, 'pegawai_id', array('readonly' => true, 'class' => 'span4', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?>
                                <?php echo $form->textField($modAreaOperasi, 'pegawai_nama', array('readonly' => true, 'class' => 'span4', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <?php
                        $this->renderPartial($this->path_view . '_penanda_lokasi', array(
                            'form' => $form,
                            // 'model' => $model,
                            // 'temp_file' => $temp_file,
                            'id' => $gambartubuh_id,
                            'modAreaOperasi' => $modAreaOperasi,
                            'modGambarTubuh' => $modGambarTubuh,
                            'modBagianTubuh' => $modBagianTubuh,
                            'modAreaDetOp' => $modAreaDetOp,
                            'modPasien' => $modPasien,
                            'jenis' => $jenis,
                        ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    
</script>