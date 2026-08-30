<?php echo $form->hiddenField($model, 'pendaftaran_id', array('readonly' => true, 'class' => 'span3')); ?>
<?php echo $form->hiddenField($model, 'buatjanjipoli_id', array('readonly' => true, 'class' => 'span3')); ?>
<!-- <div class="col-sm-6"> -->
    <div class="box2">
        <?php
        $is_realtime = "";
        if (!empty($model->buatjanjipoli_id)) {
            $janji = BuatjanjipoliT::model()->findByPk($model->buatjanjipoli_id);

            if (date('Y-m-d', strtotime($janji->tgljadwal)) != date('Y-m-d')) {
                $is_realtime = "";
            }
        }
        echo $form->textFieldRow($model, 'tgl_pendaftaran', array('readonly' => true, 'class' => 'span3 ' . $is_realtime . ' form-control', 'onkeyup' => "return $(this).focusNextInputField(event);"));
        ?>
        <?php
        echo CHtml::hiddenField('jam_awal') . CHtml::hiddenField('jam_tutup') .
            CHtml::hiddenField("nama_ruangan") . CHtml::hiddenField('jam_awal_a') . CHtml::hiddenField('jam_tutup_a');
        echo $form->dropDownListRow($model, 'jeniskasuspenyakit_id', CHtml::listData($model->getJenisKasusPenyakitItems($model->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 form-control2', 'empty' => '-- Pilih --'));
        ?>
        <div class='control-group'>
            <?php echo CHtml::label("Poliklinik <span class='required'>*</span>", CHtml::activeId($model, 'ruangan_id'), array('class' => 'control-label required')) ?>
            <div class='controls'>
                <?php
                $modRuangan = $model->getRuanganItems(Params::INSTALASI_ID_RJ);
                $ruanganList = CHtml::listData($modRuangan, 'ruangan_id', 'ruangan_nama');
                $ruanganOption = array();

                foreach ($modRuangan as $item) {
                    $nurseDat = NursestationruanganM::model()->findByAttributes(array(
                        'ruangan_id' => $item->ruangan_id,
                    ));

                    $ruanganOption[$item->ruangan_id] = array(
                        'data-nursestation_id' => $nurseDat->nursestation_id ?? "",
                        'data-nursestation_nama' => $nurseDat->nursestationrl->nursestation_nama ?? "",
                        'data-kode_bpjs' => $item->kode_bpjs,
                    );
                }
                echo $form->dropDownList($model, 'ruangan_id', $ruanganList, array(
                    'empty' => '-- Pilih --',
                    // 'onchange' => "setDropdownDokter(this.value);setDropdownJeniskasuspenyakit(this.value);setKarcis();setAntrianRuangan();getRuanganPoliklinikPasien();",
                    'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3',
                    //'ajax'=>array(
                    //      'type'=>'POST',
                    //      'url'=>$this->createUrl('SetDropdownKelasPelayanan',array('encode'=>false,'namaModel'=>get_class($model))),
                    //      'update'=>'#'.CHtml::activeId($model, 'kelaspelayanan_id')),
                    'options' => $ruanganOption
                ));
                ?>
                <div class="checkbox inline">
                    <label for="home"><i class="entypo-home" rel="tooltip" title="Ceklis jika Kunjungan Rumah"></i></label>
                    <?php echo $form->checkBox($model, 'kunjunganrumah', array('onkeyup' => "return $(this).focusNextInputField(event)", 'id' => 'home')); ?>
                    <?php // echo CHtml::activeLabel($model, 'kunjunganrumah'); 
                    ?>
                </div>
                <div style="margin-top:5px">
                    Kuota <?php echo CHtml::textField('max-antrian-ruangan', 0, array('class' => '', 'rel' => 'tooltip', 'title' => 'Maksimum Antrian Ruangan', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:40px;',)); ?>
                    Sisa <?php echo CHtml::textField('sisa-antrian-ruangan', 0, array('class' => '', 'rel' => 'tooltip', 'title' => 'Maksimum Antrian Ruangan', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:40px;',)); ?>
                </div>
            </div>

        </div>

        <span hidden>
            <?php
            if (empty($model->buatjanjipoli_id)) {
                echo $form->dropDownListRow($model, 'kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems($model->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => "setKarcis()", 'class' => 'span3 form-control2'));
            } else {
                echo $form->dropDownListRow($model, 'kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => "setKarcis()", 'class' => 'span3 form-control2'));
            }
            ?>
        </span>
        <div class="control-group">
            <label for="PPPendaftaranT_pegawai_id" class="control-label required">
                Dokter <span class="required">*</span>
                <?php
                echo
                CHtml::link("<i class='entypo-calendar'></i>", 'javascript:void(0)', array(
                    "rel" => "tooltip",
                    "title" => "Klik Untuk Melihat Jadwal Dokter",
                    "onclick" => "setRuanganJadwalDokter(); return true;"
                ));
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

                <?php // echo $form->dropDownList($model, 'pegawai_id', CHtml::listData($model->getDokterItems($model->ruangan_id), 'pegawai_id', 'namaLengkap'), array('onchange' => 'setAntrianDokter();', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 form-control2')); 
                ?>
                <div style="margin-top:5px">
                    Kuota <?php echo CHtml::textField('max-antrian-dokter', 0, array('class' => '', 'rel' => 'tooltip', 'title' => 'Maksimum Antrian Dokter', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:40px;', 'value' => 0)); ?>
                    Sisa <?php echo CHtml::textField('sisa-antrian-dokter', 0, array('class' => '', 'rel' => 'tooltip', 'title' => 'Maksimum Antrian Dokter', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:40px;', 'value' => 0)); ?>
                </div>
            </div>
        </div>
        <?php /*
        <div class="control-group" style="display:none;">
            <label class="control-label">Slot Pendaftaran<span class="required">*</span></label>
            <div class="controls">
                <div class="panel_jadwal">
                </div>
                <br />
                <?php echo CHtml::dropDownList('waktu_jadwal', '', array(), array(
                    'empty' => '-- Pilih --',
                    'class' => 'span3 slot_jadwal',
                    'onchange' => 'cekSlotTersedia();'
                )); ?>
                <?php echo $form->hiddenField($model, 'no_urutantri', array('class' => 'no_antrianjanji')); ?>
                <?php echo $form->hiddenField($model, 'no_luarjadwal', array('class' => 'no_luarjadwal')); ?>
                <div class="checkbox inline">
                    <label for="antrian">Slot Antrian</label>
                    <?php echo $form->checkBox($model, 'slotantrian', array('onkeyup' => "return $(this).focusNextInputField(event)", 'id' => 'antrian')); ?>
                    <?php // echo CHtml::activeLabel($model, 'kunjunganrumah'); 
                    ?>
                </div>
            </div>
        </div>
        */ ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'nursestation_id', array('class' => 'control-label refreshable')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'nursestation_id'); ?>
                <?php echo CHtml::textField('nursestation_nama', '-', array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'carabayar_id', array('class' => 'control-label refreshable')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                    'class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'style' => 'width:170px;',
                    'onchange' => 'setKarcis();bpjsManual();'
                ));
                ?>
                <?php echo $form->error($model, 'carabayar_id'); ?>
            </div>
            <div class="controls cekBPJSJalan hidden">
                <?php echo $form->checkBox($model, 'is_bpjs_manual', array('onclick' => 'bpjsManual();', 'uncheckValue' => null, 'class' => 'permanent')) . "Non Bridging BPJS"; ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'penjamin_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'penjamin_id', empty($model->carabayar_id) ? array() : CHtml::listData($modPasien->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array(
                    'class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'style' => 'width:170px;',
                    'onchange' => 'setKarcis();'
                ));
                ?>
                <?php echo $form->error($model, 'penjamin_id'); ?>
            </div>
        </div>
        <!-- <div class="control-group">
            <?php //echo $form->labelEx($model, 'carabayar_id', array('class' => 'control-label refreshable')) 
            ?>
            <div class="controls">
                <?php
                // echo $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                //     'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                //     'ajax' => array(
                //         'type' => 'POST',
                //         'url' => $this->createUrl('SetDropdownPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                //         //                                                        'update'=>'#'.CHtml::activeId($model, 'penjamin_id'),  //DIHIDE KARENA DIGANTIKAN DENGAN 'success'
                //         'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data); setKarcis(); cekPilihSatu($("#' . CHtml::activeId($model, "penjamin_id") . '")); setKelasTanggunganDrop();}',
                //     ),
                //     'onchange' => 'setFormAsuransi(this.value);',
                //     'class' => 'span3 form-control ',
                // ));
                ?>
            </div>
        </div> -->

        <?php
        // echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array(
        //     'empty' => '-- Pilih --',
        //     'onchange' => 'setKarcis(); setNamaAsuransiDariPenjamin(this); setAsuransiBadak(this.value); cekValiditasPenjamin(this.value); setFormAsuransiInhealth(this.value);',
        //     'onkeyup' => "return $(this).focusNextInputField(event)",
        //     'class' => 'span3 form-control'
        // ));
        ?>
        <?php
        echo $form->dropDownListRow($model, 'kategoriasalpasien', LookupM::getItems('kategoriasalpasien'), array('empty' => '-- Pilih --', 'class' => 'span3'));
        // kategoriasalpasien
        ?>
        <?php echo $form->textAreaRow($model, 'keterangan_pendaftaran', array('placeholder' => 'Catatan Khusus Pendaftaran', 'rows' => 2, 'cols' => 50, 'class' => 'span3 form-control autogrow', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textAreaRow($model, 'keluhan', array('placeholder' => 'Keluhan Pasien', 'rows' => 2, 'cols' => 50, 'class' => 'span3 form-control autogrow', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php // echo $form->textAreaRow($model, 'diagnosamasuk', array('placeholder' => 'Diagnosa Masuk', 'rows' => 2, 'cols' => 50, 'class' => 'span3 form-control autogrow', 'onkeyup' => "return $(this).focusNextInputField(event);")); 
        ?>
        <?php echo CHtml::label("Diagnosa Masuk", 'diagnosamasuk', array('class' => 'control-label')) ?>

        <?php echo $form->hiddenField($model, 'diagnosamasuk_id', array('readonly' => true)); ?>

        <?php
        $this->widget('MyJuiAutoComplete', array(
            'model' => $model,
            'attribute' => 'diagnosamasuk',
            'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('Diagnosa') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                                item: "diagnosa",
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
            'options' => array(
                'minLength' => 2,
                'focus' => 'js:function( event, ui ) {
                            $(this).val(ui.item.kode);
                            return false;
                        }',
                'select' => 'js:function( event, ui ) {
                            $(this).val(ui.item.diagnosamasuk);
                            $("#' . CHtml::activeId($model, 'diagnosamasuk') . '").val(ui.item.label);
                            $("#' . CHtml::activeId($model, 'diagnosamasuk_id') . '").val(ui.item.value);
                            console.log(ui.item);
                            return false;
                        }',
            ),
            'htmlOptions' => array(
                'placeholder' => 'Ketik Nama Diagnosa', 'rel' => 'tooltip', 'title' => 'Ketik diagnosa untuk mencari data diagnosa', 'class' => 'span3',
                'onkeyup' => "return $(this).focusNextInputField(event)",
            ),
        ));
        ?>

    </div>
<!-- </div> -->

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
//===
?>

<?php $this->renderPartial($this->path_view . '_dialogPencarianDokter', ['model' => $model]) ?>
<script>
    function setDokterJadwal2(pegawai_id, nama_pegawai) {

        console.log("PEGAWAI JADWAL", pegawai_id, nama_pegawai);

        $("#<?php echo CHtml::activeId($model, "pegawai_id"); ?>").val(pegawai_id);
        $("#<?php echo CHtml::activeId($model, "nama_pegawai"); ?>").val(nama_pegawai);
        //setAntrianDokter();
        $('#jadwalDokter').dialog('close');
    }
</script>