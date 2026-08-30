<?php // echo $form->dropDownListRow($modTandabukti, 'dengankartu', LookupM::getItems('dengankartu'), array('required' => true,'onchange' => 'enableInputKartu()', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<!--<div class="white-container">-->
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::activeLabelEx($model, 'verifikasiaskep_tgl', array('class' => 'control-label inline')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'verifikasiaskep_tgl',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>

            </div>
        </div>
        <div class="control-group">
            <?php // echo CHtml::activeHiddenField($model, 'anamesa_id',array('readonly'=>true, 'class'=>'span1')); ?>
            <?php // echo CHtml::activeHiddenField($model, 'pemeriksaanfisik_id',array('readonly'=>true, 'class'=>'span1')); ?>
            <?php echo CHtml::activeLabel($model, 'verifikasiaskep_no', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($model, 'verifikasiaskep_no', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activelabelEx($model, 'verifikasiaskep_status', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo CHtml::activeDropDownList($model, 'verifikasiaskep_status', array('Telah Di Verifikasi' => 'Telah Di Verifikasi',
                    'Belum Di Verifikasi' => 'Belum Di Verifikasi',), array('class' => 'span3', 'empty' => '-- Pilih --'));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'instalasi_id', CHtml::listData($model->getInstalasiItems(), 'instalasi_id', 'instalasi_nama'), array(
                    'class' => 'span3',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'empty' => '-- Pilih --',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
                        'update' => '#' . CHtml::activeId($model, 'ruangan_id')
                    )
                        )
                );
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) ?>
            <div class="controls">

                <?php
                echo $form->dropDownList($model, 'ruangan_id', CHtml::listData($model->getRuanganItems($model->instalasi_id), 'ruangan_id', 'ruangan_nama'), array(
                    'class' => 'span3',
                    'empty' => '-- Pilih --',
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                        )
                );
                ?>
            </div>
        </div>	
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::activeLabelEx($model, 'petugasverifikasi_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $modul = ModulK::model()->findByAttributes(
                        array('modul_key' => $this->module->id)
                );
                $modul_id = (isset($modul['modul_id']) ? $modul['modul_id'] : '' );
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'ASVerifikasiaskepT[petugasverifikasi_nama]',
                    'value' => isset($model->petugasverifikasi_nama) ? $model->petugasverifikasi_nama : "",
                    'sourceUrl' => $this->createUrl('Pegawairiwayat'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                                                    $("#ASVerifikasiaskepT_petugasverifikasi_nama").val( ui.item.nama_pegawai );
                                                    return false;
                                                }',
                        'select' => 'js:function( event, ui ) {
                                                    $("#ASVerifikasiaskepT_petugasverifikasi_nama").val( ui.item.nama_pegawai );
                                                    return false;
                                                }',
                    ),
                    'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 '),
                    'tombolDialog' => array('idDialog' => 'dialogPegawaiVerifikasi', 'idTombol' => 'tombolVerifikasiDialog'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabelEx($model, 'mengetahui_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $modul = ModulK::model()->findByAttributes(
                        array('modul_key' => $this->module->id)
                );
                $modul_id = (isset($modul['modul_id']) ? $modul['modul_id'] : '' );
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'ASVerifikasiaskepT[mengetahui_nama]',
                    'value' => isset($model->mengetahui_nama) ? $model->mengetahui_nama : "",
                    'sourceUrl' => $this->createUrl('Pegawairiwayat'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                                                    $("#ASVerifikasiaskepT_mengetahui_nama").val( ui.item.nama_pegawai );
                                                    return false;
                                                }',
                        'select' => 'js:function( event, ui ) {
                                                    $("#ASVerifikasiaskepT_mengetahui_nama").val( ui.item.nama_pegawai );
                                                    return false;
                                                }',
                    ),
                    'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 '),
                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui', 'idTombol' => 'tombolMengetahuiDialog'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'verifikasiaskep_ket', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextArea($model, 'verifikasiaskep_ket', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
</div>
