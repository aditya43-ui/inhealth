<div class="control-group">
    <?php echo CHtml::label('Tgl. Pemeriksaan', 'tgl_pemeriksaan', array('class'=>'control-label')); ?>
    <div class="controls">
            <?php   
                $this->widget('MyDateTimePicker',array(
                                'model' => $modPasienMasukPenunjang,
                                'attribute'=>'tglmasukpenunjang',
                                'mode'=>'datetime',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions'=>array('readonly'=>true,'class'=>'span3'),
                )); 
            ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Dokter Pemeriksa <span class="required">*</span>', 'tgl_pemeriksaan', array('class'=>'control-label required')); ?>
    <div class="controls">
        <?php 
            echo $form->hiddenField($modPasienMasukPenunjang, 'pegawai_id');
             $this->widget('MyJuiAutoComplete', array(
                'model' => $modPasienMasukPenunjang,
                'attribute' => 'pegawai_nama',
                'source' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "' . $this->createUrl('AutocompletePetugas') . '",
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
                                $(this).val(ui.item.value);
                                $("#dpjp_nama").val(ui.item.nama_pegawai);
                                $("#' . CHtml::activeId($modPasienMasukPenunjang, 'pegawai_id') . '").val(ui.item.pegawai_id);
                                $("#' . CHtml::activeId($modPasienMasukPenunjang, 'pegawai_nama') . '").val(ui.item.nama_pegawai);
                                return false;
                            }',
                ),
                'htmlOptions' => array(
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    'class' => 'span3 required'
                ),
                'tombolDialog' => array('idDialog' => 'dialogPegawai'),
            ));
        ?>
    </div>
</div>

<?php
//========= Dialog pegawai dpjp =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Daftar Dokter Penanggung Jawab Pelayanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => false,
    ),
));


$modPegawai = new PegawairuanganV('searchDialogPegRuangan');
$ruangan_id = Params::RUANGAN_ID_BANK_DARAH;
// var_dump($ruangan_id);
$modPegawai->ruangan_id = $ruangan_id;
$modPegawai->kelompokpegawai_id = 1;
$modPegawai->unsetAttributes();
if (isset($_GET['PegawairuanganV']))
    $modPegawai->attributes = $_GET['PegawairuanganV'];
$modPegawai->kelompokpegawai_id = 1;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'petugasdpjp-m-grid',
    'dataProvider' => $modPegawai->searchDialogPegRuangan(),
    'filter' => $modPegawai,
    'template' => "{items}\n{pager}",
    //    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'pegawai_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectBahan",
					"onClick" => "
						$(\'#' . Chtml::activeId($modPasienMasukPenunjang, 'pegawai_id') . '\').val(\'$data->pegawai_id\');
						$(\'#' . Chtml::activeId($modPasienMasukPenunjang, 'pegawai_nama') . '\').val(\'$data->NamaLengkap\');
						
						$(\'#dpjp_nama\').val(\'$data->NamaLengkap\');
						$(\'#dialogPegawai\').dialog(\'close\');
						return false;"))',
        ),
        array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPegawai, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawai, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '$data->jabatan_nama',
            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Nomor Handphone',
            'value' => '$data->nomobile_pegawai',
        )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
