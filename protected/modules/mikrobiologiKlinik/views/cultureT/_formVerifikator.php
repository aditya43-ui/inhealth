<div class="col-md-6">
    <div class="control-group hide">
        <?php echo CHtml::label('Tanggal', '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $modCulture,
                'attribute' => 'tanggal_culture',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array('class' => 'dtPicker3 span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            ));
            ?>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="control-group hide">
        <?php echo CHtml::label('Analis <span class="required">*</span>', '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo $form->hiddenField($modCulture, 'analis_id', array('readonly' => true, 'class' => ''));

            $this->widget('MyJuiAutoComplete', array(
                'model' => $modCulture,
                'attribute' => 'analis_nama',
                'source' => 'js: function(request, response) {
                                                    $.ajax({
                                                    url: "' . $this->createUrl('/ActionAutoComplete/dropPetugasRuangan') . '",
                                                    dataType: "json",
                                                    data: {
                                                            term: request.term,
                                                            ruangan_id: ' . Yii::app()->user->getState('ruangan_id') . '
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
                                                     $(this).val( ui.item.label);
                                                     return false;
                                             }',
                    'select' => 'js:function( event, ui ) {
                                                     $("#' . CHtml::ActiveId($modCulture, 'analis_id') . '").val(ui.item.value); 
                                                     return false;
                                             }',
                ),
                'htmlOptions' => array('class' => 'span4 ', 'placeholder' => 'Ketik Nama Analis'),
                'tombolDialog' => array('idDialog' => 'dialogPetugas'),
            ));
            ?>
        </div>
    </div>
    <div class="control-group hide">
        <?php echo CHtml::label('NIP', '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($modCulture, 'analis_nip', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->hiddenField($modCulture, 'verifikasiPPDS', array('class' => 'span3 verifikasiPPDS', 'readonly'=>true)) ?>
            <?php echo $form->hiddenField($modCulture, 'verifikasiDPJTM', array('class' => 'span3 verifikasiDPJTM', 'readonly'=>true)) ?>
        </div>
    </div>
</div>
<!--<div class="col-md-6">
    <div class="control-group">
        <?php // echo CHtml::label('Verifikator <span class="required">*</span>', '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
//            echo $form->hiddenField($modCulture, 'verifikator_id', array('readonly' => true, 'class' => 'required'));
//
//            $this->widget('MyJuiAutoComplete', array(
//                'model' => $modCulture,
//                'attribute' => 'verifikator_nama',
//                'source' => 'js: function(request, response) {
//                                                    $.ajax({
//                                                    url: "' . $this->createUrl('/ActionAutoComplete/dropPetugasRuangan') . '",
//                                                    dataType: "json",
//                                                    data: {
//                                                            term: request.term,
//                                                            ruangan_id: ' . Yii::app()->user->getState('ruangan_id') . '
//                                                    },
//                                                    success: function (data) {
//                                                            response(data);
//                                                    }
//                                            })
//                                    }',
//                'options' => array(
//                    'showAnim' => 'fold',
//                    'minLength' => 3,
//                    'focus' => 'js:function( event, ui ) {
//                                                     $(this).val( ui.item.label);
//                                                     return false;
//                                             }',
//                    'select' => 'js:function( event, ui ) {
//                                                     $("#' . CHtml::ActiveId($modCulture, 'verifikator_id') . '").val(ui.item.value); 
//                                                     return false;
//                                             }',
//                ),
//                'htmlOptions' => array('class' => 'span4 required', 'placeholder' => 'Ketik Nama Verifikator'),
//                'tombolDialog' => array('idDialog' => 'dialogVerifikator'),
//            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php // echo CHtml::label('NIP', '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php // echo $form->textField($modCulture, 'verifikator_nip', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>-->

<?php
//========= Dialog buat cari data Petugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPetugas',
    'options' => array(
        'title' => 'Pencarian Analis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modPegawai = new MKPegawairuanganV('search');
$modPegawai->unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['MKPegawairuanganV'])) {
    $modPegawai->attributes = $_GET['MKPegawairuanganV'];
    $modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaipelaksana-m-grid',
    'dataProvider' => $modPegawai->searchAnalisCulture(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPemberiTugas",
                "onClick" => "$(\"#' . CHtml::activeId($modCulture, 'analis_id') . '\").val(\"$data->pegawai_id\");
                              $(\"#' . CHtml::activeId($modCulture, 'analis_nama') . '\").val(\"$data->namaLengkap\");
                              $(\"#' . CHtml::activeId($modCulture, 'analis_nip') . '\").val(\"$data->nomorindukpegawai\");
                              $(\"#dialogPetugas\").dialog(\"close\");    
                              return false;
                    "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPegawai, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Petugas dialog =============================
?>
