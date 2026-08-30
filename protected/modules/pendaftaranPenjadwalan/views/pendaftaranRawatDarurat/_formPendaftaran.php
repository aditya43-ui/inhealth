<?php echo $form->hiddenField($model, 'pendaftaran_id', array('readonly' => true, 'class' => 'span3')); ?>
<div class="col-sm-6">
    <div class="box2">
        <?php echo $form->textFieldRow($model, 'tgl_pendaftaran', array('readonly' => true, 'class' => 'span3 realtime', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php if (empty($model->jeniskasuspenyakit_id)) {
            $model->jeniskasuspenyakit_id = Params::JENIS_KASUSPENYAKIT_ID_RD;
        } ?>
        <?php echo $form->dropDownListRow($model, 'jeniskasuspenyakit_id', CHtml::listData($model->getJenisKasusPenyakitItems(Params::INSTALASI_ID_RD), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'empty' => '-- Pilih --')); ?>
        <div class='control-group'>
            <?php echo CHtml::label("Ruangan <span class='required'>*</span>", CHtml::activeId($model, 'ruangan_id'), array('class' => 'control-label required')) ?>
            <div class='controls'>
                <?php if (empty($model->ruangan_id)) {
                    $model->ruangan_id = Params::RUANGAN_ID_PERAWATAN_DARURAT;
                } ?>
                <?php echo $form->dropDownList(
                    $model,
                    'ruangan_id',
                    CHtml::listData($model->getRuanganItemsVK(Params::INSTALASI_ID_RD), 'ruangan_id', 'ruangan_nama'),
                    array(
                        'empty' => '-- Pilih --',
                        'onchange' => "setDropdownDokter(this.value);setKarcis();setAntrianRuangan()",
                        'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('SetDropdownKelasPelayanan', array('encode' => false, 'namaModel' => get_class($model))),
                            'update' => '#' . CHtml::activeId($model, 'kelaspelayanan_id')
                        ),
                    )
                ); ?>
                <div class="checkbox inline">
                    <i class="icon-home" style="margin:0" rel="tooltip" title="Ceklis jika Kunjungan Rumah"></i>
                    <?php echo $form->checkBox($model, 'kunjunganrumah', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    <?php // echo CHtml::activeLabel($model, 'kunjunganrumah'); 
                    ?>
                </div><?php echo CHtml::textField('max-antrian-ruangan', 0, array('rel' => 'tooltip', 'title' => 'Maksimum Antrian Ruangan', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:25px;',)); ?>
            </div>
        </div>

        <?php echo $form->dropDownListRow($model, 'kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems($model->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => "setKarcis()", 'class' => 'span3')); ?>
        <div class="control-group">
            <label for="PPPendaftaranT_pegawai_id" class="control-label required">
                Dokter <span class="required">*</span>
                <?php echo
                CHtml::link(
                    "<i class='icon-dokpoli'></i>",
                    'javascript:void(0)',
                    array(
                        "rel" => "tooltip",
                        "title" => "Klik untuk Melihat Jadwal Dokter",
                        "onclick" => "setRuanganJadwalDokter(); $('#jadwalDokter').dialog('open');return true;"
                    )
                );
                ?>
            </label>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'nama_pegawai',
                    'source' => 'js: function(request, response) {
                                                                            var ruangan_id = $("#' . CHtml::activeId($model, 'ruangan_id') . '").val();
                                                                       $.ajax({
                                                                               url: "' . $this->createUrl('AutocompleteDokter') . '",
                                                                               dataType: "json",
                                                                               data: {
                                                                                       nama_pegawai: request.term,
                                                                                       ruangan_id: ruangan_id,
                                                                               },
                                                                               success: function (data) {
                                                                                               response(data);
                                                                               }
                                                                       })
                                                                    }',
                    'options' => array(
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                                                     $(this).val( "");
                                                                     return false;
                                                             }',
                        'select' => 'js:function( event, ui ) {
                                                                    $(this).val(ui.item.value);
                                                                    $("#' . CHtml::activeId($model, 'pegawai_id') . '").val(ui.item.pegawai_id);
                                                                    $("#' . CHtml::activeId($model, 'nama_pegawai') . '").val(ui.item.nama_pegawai);
                                                                    setAntrianDokter();
                                                                    return false;
                                                            }',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogDokter', 'jsFunction' => 'cekDokter()'),
                    'htmlOptions' => array(
                        'class' => 'span3', 'placeholder' => 'Nama Dokter', 'rel' => 'tooltip', 'title' => 'Ketik Nama Dokter',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => "",
                    ),
                ));
                ?>
                <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                <?php // echo $form->dropDownList($model,'pegawai_id', CHtml::listData($model->getDokterItems($model->ruangan_id), 'pegawai_id', 'nama_pegawai') ,array('onchange'=>'setAntrianDokter();','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); --RND-6869 
                ?>
                <?php // echo CHtml::textField('max-antrian-dokter',0, array('rel'=>'tooltip','title'=>'Maksimum Antrian Dokter','readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:25px;','value'=>0)); 
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'carabayar_id', array('class' => 'control-label refreshable')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                    'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('SetDropdownPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                        //                                                        'update'=>'#'.CHtml::activeId($model, 'penjamin_id'),  //DIHIDE KARENA DIGANTIKAN DENGAN 'success'
                        'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data);setKarcis();setKelasTanggunganDrop();setPilihanPertama(this);}',
                    ),
                    'onchange' => 'setFormAsuransi(this.value); cekCaraBayarBadak(this.value);showUmumBpjs(this.value);',
                    'class' => 'span3',  'empty' => '-- Pilih --'
                )); ?>
            </div>
            <div class="controls cekBPJS hidden">
                <?php echo $form->checkBox($model, 'is_bpjs_manual', array('onclick' => 'bpjsManual();', 'uncheckedvalue' => 0, 'class' => 'permanent')) . "Non Bridging BPJS"; ?>
            </div>
        </div>

        <?php echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onchange' => 'setKarcis(); setAsuransiBadak(this.value); cekValiditasPenjamin(this.value);', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
        <div class="control-group">
            <label for="" class="control-label">Keadaan Masuk</label>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'keadaanmasuk', LookupM::getItems('keadaanmasuk'), array(
                    'empty' => '-- Pilih --',
                    'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3'
                )); ?>
            </div>
            <div class="controls">
                <?= $form->checkBox($model, 'is_kecelakaan', ['class' => '']) . 'Kecelakaan Lalu Lintas' ?>
            </div>
        </div>

        <?php echo $form->dropDownListRow($model, 'transportasi', LookupM::getItems('transportasi'), array(
            'empty' => '-- Pilih --',
            'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3'
        )); ?>
        <?php echo $form->textAreaRow($model, 'keterangan_pendaftaran', array('placeholder' => 'Catatan Khusus Pendaftaran', 'rows' => 2, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group" style="display:none;" id="isumumbpjs">
            <?php echo CHtml::label("", 'isumumbpjs', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'isumumkebpjs', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label><?php echo $model->getAttributeLabel('isumumkebpjs'); ?></label>
            </div>
        </div>
    </div>
</div>

<?php
//=============================== Dialog Jadwal Dokter =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'jadwalDokter',
        'options' => array(
            'title' => 'Jadwal Dokter Poliklinik',
            'autoOpen' => false,
            'width' => 840,
            'height' => 420,
            'resizable' => true,
        ),
    )
);

$format = new MyFormatter();
$modJadDok = new PPJadwaldokterM('search');
$modJadDok->unsetAttributes();
$modJadDok->jadwaldokter_hari = $format->getDayUser(date('w'));
if (!empty($modJadDok->jadwaldokter_buka)) {
    $modJadDok->jadwaldokter_buka = MyFormatter::formatDateTimeForUser($modJadDok->jadwaldokter_buka);
}

if (isset($_GET['PPJadwaldokterM'])) {
    $modJadDok->attributes = $_GET['PPJadwaldokterM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rdjadwaldokter-m-grid',
    'dataProvider' => $modJadDok->search(),
    'filter' => $modJadDok,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::Link("<i class=\"icon-form-check\"></i>", "javascript:void(0);", array(
                    "class" => "btn-small",
                    "onClick" => "
                    setDokterJadwal2(\"" . $data->pegawai_id . "\", \"" . (!empty($data->pegawai->nama_pegawai) ? $data->pegawai->nama_pegawai : "") . "\"); return false;
                    
                "
                ));
            },
        ),
        array(
            'name' => 'pegawai_id',
            'filter' =>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
            'value' => '(isset($data->pegawai->nama_pegawai) ? $data->pegawai->nama_pegawai : "")',
        ),
        array(
            'name' => 'jadwaldokter_hari',
            'value' => '$data->jadwaldokter_hari',
            'filter' => CHtml::activeDropDownList($modJadDok, 'jadwaldokter_hari', CustomFunction::getNamaHari(), array('class' => 'span2  ', 'onkeyup' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --'))
        ),
        array(
            'name' => 'jadwaldokter_buka',
            'filter' => CHtml::activeTimeField($modJadDok, 'jadwaldokter_buka')
        ),
        // array(
        //     'name' => 'jadwaldokter_buka',
        //     'filter' =>  $this->widget('MyDateTimePicker', array(
        //                     'model' => $modJadDok,
        //                     'attribute' => 'jadwaldokter_buka',
        //                     'mode' => 'time',
        //                     'options' => array(
        //                         //                                            'dateFormat'=>Params::DATE_FORMAT,
        //                         'showOn' => false,
        //                     ),
        //                     'htmlOptions' => array(
        //                         'readonly' => false, 'placeholder' => '00:00:00', 'class' => 'dtPicker2 timemask', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:120px;'
        //                 ),
        //             ),
        //             true , 'dtPicker2 timemask' 
        //             ),

        // ),

    ),
    'afterAjaxUpdate' => 'function(id, data){
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
        
          }',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//=============================== END Dialog Jadwal Dokter =======================================
?>
<script>
    function setDokterJadwal2(pegawai_id, nama_pegawai) {

        console.log("PEGAWAI JADWAL", pegawai_id, nama_pegawai);

        $("#<?php echo CHtml::activeId($model, "pegawai_id"); ?>").val(pegawai_id);
        $("#<?php echo CHtml::activeId($model, "nama_pegawai"); ?>").val(nama_pegawai);
        //setAntrianDokter();
        $('#jadwalDokter').dialog('close');
    }

    function setPilihanPertama(obj) {

        console.log('Pilihan penjamin:');

        var terpilih = '';

            console.log($('#PPPendaftaranT_penjamin_id').html());

            $('#PPPendaftaranT_penjamin_id').find('option').each(function (idx, val) {

                var pilihan = $(this).val();
            console.log("penjamin: " + idx + " - " + "valuene yoiku: " + pilihan);
            
            if(idx == 0 && pilihan !== '') {
                $('#PPPendaftaranT_penjamin_id').val(pilihan);
                terpilih = 'yes';
            } else if(idx == 1 && terpilih == '') {
                $('#PPPendaftaranT_penjamin_id').val(pilihan);
            }

        });
            
        
    }
</script>