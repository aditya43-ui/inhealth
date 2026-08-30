<div class = "col-sm-6">
    <div class="control-group">
        <?php echo $form->labelEx($model,'tgl_permintaan',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker',array(
            'model'=>$model,
            'attribute'=>'tgl_permintaan',
            'mode'=>'datetime',
            'options'=> array(
                'maxDate' => 'd',
                'showOn' => false,
                'yearRange'=> "-150:+0",
                    'dateFormat' => Params::DATE_FORMAT,
                ),
            'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 span3 required', 'onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true
            ),
            )); 
            ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($model, 'no_permintaan', array('readonly'=>true,'class'=>'span3')); ?>
    <?php //echo $form->textFieldRow($model, 'no_permintaan_pmi', array('readonly'=>false,'class'=>'span3')); ?>
    <div class="control-group">
        <?php echo $form->labelEx($model,'petugas_id',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php
            echo $form->hiddenField($model, 'petugas_id', array('readonly' => true));
            echo $form->textField($model,'petugas_nama',array('readonly'=>true,'class'=>'span3'));
            /*$this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'petugas_nama',
                'value' => '',
                'source' => 'js: function(request, response) {
                    $.ajax({
                        url: "' . $this->createUrl('/actionAutoComplete/dropPetugasRuangan') . '",
                        dataType: "json",
                            data: {
                                term: request.term,
                                ruangan_id: ' . Yii::app()->user->getState('ruangan_id') . ',
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
                        return false;
                    }',
                    'select' => 'js:function( event, ui ) {
                        $("#'.CHtml::activeId($model, 'petugas_nama').'").val(ui.item.nama_pegawai);
                        $("#'.CHtml::activeId($model, 'petugas_id').'").val(ui.item.pegawai_id);
                        return false;
                    }',
                ),
                'htmlOptions' => array(
                    'readonly' => false,
                    'placeholder' => 'Nama Petugas',
                    'class' => 'span3',
                    'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'pegawai_id') . '").val(""); ',
                    'onkeypress' => "return $(this).focusNextInputField(event);",
                ),
                'tombolDialog' => array('idDialog' => 'dialogPetugas', 'idTombol' => 'tombolPengirim'),
            ));*/
            ?>
        </div>
    </div>
</div>
<div class = "col-sm-6">
    <?php echo $form->textFieldRow($model, 'ruangan_nama', array('readonly'=>true,'class'=>'span3')); ?>
    <?php echo $form->textFieldRow($model, 'instalasi_nama', array('readonly'=>true,'class'=>'span3')); ?>
    <?php echo $form->textAreaRow($model, 'keterangan_permintaan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPetugas',
    'options' => array(
        'title' => 'Pencarian Petugas',
        'autoOpen' => false,
        'width' => 530,
        'height' => 680,
        'resizable' => true,
    ),
        )
);

$format = new MyFormatter();
$pegPengirim = new PegawairuanganV('search');
if (isset($_GET['PegawairuanganV'])) {
    $pegPengirim->attributes = $_GET['PegawairuanganV'];
    $pegPengirim->unitkerja_id = $_GET['PegawairuanganV']['unitkerja_id'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-pengirim-m-grid',
    'dataProvider' => $pegPengirim->searchDialogPegRuangan(),
    'filter' => $pegPengirim,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::Link('<i class="icon-form-check"></i>', "#", array("class" => "btn-small",
                    "onclick" => "
                        $(\"#BDPermintaandarahpmiT_petugas_nama\").val(\"$data->nama_pegawai\");
                        $(\"#BDPermintaandarahpmiT_petugas_id\").val(\"$data->pegawai_id\");
                        $(\"#dialogPetugas\").dialog(\"close\");
                        return false;
                    "
                ));
            },
        ),
        array(
            'name' => 'nama_pegawai',
            // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            },
            'filter' => CHtml::activeDropDownList($pegPengirim, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll(" jabatan_aktif = TRUE "), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Unit Kerja',
            'name' => 'unitkerja_id',
            'value' => function($data) {
                $j = UnitkerjaM::model()->findByPk($data->unitkerja_id);

                if (!empty($j)) {
                    return $j->namaunitkerja;
                }
            },
            'filter' => CHtml::activeDropDownList($pegPengirim, 'unitkerja_id', CHtml::listData(UnitkerjaM::model()->findAll(" unitkerja_aktif = TRUE "), 'unitkerja_id', 'namaunitkerja'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>