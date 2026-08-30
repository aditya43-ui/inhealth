<?php

/** 
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
$modPasien = PasienM::model()->findByPk($model->pasien_id);
$nama_pasien = $modPasien->nama_pasien
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'komponendarah-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'namakomponendrh')
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Nama Pasien <span class =required> * </span>', 'tglpembatalan', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo CHtml::TextField('nama_pasien', $nama_pasien, array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tgl. Pembatalan <span class =required> * </span>', 'tglpembatalan', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modelBatal,
                    'attribute' => 'tglpembatalan',
                    'mode' => 'datetime',
                    'options' => array(
                        'showOn' => false,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('class' => 'dtPicker3 span3 realtime', 'onkeyup' => "return $(this).focusNextInputField(event)",),
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Pegawai yang Membatalkan <span class='required'>*</span> ", 'koordinatormutu_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($modelBatal, 'pegawai_id', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modelBatal,
                    'attribute' => 'pegawai_nama',
                    'source' => 'js: function(request, response) {
                           $.ajax({
                               url: "' . $this->createUrl('autoCompletePegawai') . '",
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
                        'select' => 'js:function( event, ui ) {
                            $(this).val( ui.item.nama_pegawai );
                            $("#LuluskomponendarahT_koordinatormutu_id").val( ui.item.pegawai_id );
                            return false;
                }',
                    ),
                    'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'NIP / Nama Pegawai'),
                    'tombolDialog' => array('idDialog' => 'dialogKoordinatorMutu', 'idTombol' => 'tombolKoordinator'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Alasan Pembatalan <span class =required> * </span>', 'tglpembatalan', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo $form->textArea($modelBatal, 'alasanpembatalan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 300)); ?>
                <?php echo $form->hiddenField($modelBatal, 'permintaandarah_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 300)); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array(
                'class' => 'btn btn-danger submit',
                'title' => 'Simpan',
                'type' => 'button',
                'onclick' => 'setBatal();return false;',
                'onKeypress' => 'return formSubmit(this,event)'
            )); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('create'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            ); ?>
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari data Pemberi Tugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKoordinatorMutu',
    'options' => array(
        'title' => 'Pencarian Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modPegawai = new PegawairuanganV('search');
$modPegawai->unsetAttributes();
if (isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaipelaksana-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPemberiTugas",
                "onClick" => "$(\"#' . CHtml::activeId($modelBatal, 'pegawai_id') . '\").val(\"$data->pegawai_id\");
                              $(\"#' . CHtml::activeId($modelBatal, 'pegawai_nama') . '\").val(\"$data->namaLengkap\");
                              $(\"#dialogKoordinatorMutu\").dialog(\"close\");    
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
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
        array(
            'header' => 'Ruangan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPegawai, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll("ruangan_aktif = TRUE ORDER BY ruangan_nama ASC"), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --')),
            'value' => function ($data) {
                $j = RuanganM::model()->findByPk($data->ruangan_id);

                if (!empty($j)) {
                    return $j->ruangan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Pemberi Tugas dialog =============================
?>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function setBatal() {
        var id = $('#BatalmintadarahR_permintaandarah_id').val();
        var tanggal = $('#BatalmintadarahR_tglpembatalan').val();
        var pegawai = $('#BatalmintadarahR_pegawai_id').val();
        var alasan = $('#BatalmintadarahR_alasanpembatalan').val();
        if (tanggal != '' && alasan != '' && pegawai != '') {
            var data = $("#permintaandarah-r-grid").serialize();
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('ajaxUbahStatus'); ?>',
                data: {
                    id: id,
                    tanggal: tanggal,
                    alasan: alasan,
                    pegawai: pegawai
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == 'proses_form') {
                        window.parent.$('#dialogPembuatan').dialog('close');
                        window.parent.reloadTabel();
                    } else {
                        myAlert("Pembatalan Gagal Disimpan");
                    }
                },
                error: function(data) { // if error occured
                    myAlert("Pembatalan Gagal Disimpan");
                },
            });
        } else {
            myAlert("Isikan Data Terlebih Dahulu");
            return false;
        }
    }
</script>