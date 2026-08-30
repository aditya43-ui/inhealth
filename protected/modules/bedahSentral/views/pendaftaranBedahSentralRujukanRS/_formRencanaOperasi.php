<div class="control-group">
    <?php echo CHtml::label('Tgl. Kirim Permintaan <span class="required">*</span>', 'Tanggal', array('class' => 'control-label required')); ?>
    <div class="controls">
        <?php
        $format = new MyFormatter;
        $modRencanaOperasi->tglkirimpasien = $format->formatDateTimeForUser($modRencanaOperasi->tglkirimpasien);

        $this->widget('MyDateTimePicker', array(
            'model' => $modRencanaOperasi,
            'attribute' => 'tglkirimpasien',
            'mode' => 'datetime',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,

            ),
            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span4 required', 'onkeypress' => "return $(this).focusNextInputField(event)"),
        )); ?>
        <?php echo $form->error($modRencanaOperasi, 'tglrencanaoperasi'); ?>
    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('Tgl. Rencana Operasi <span class="required">*</span>', 'Tanggal', array('class' => 'control-label required')); ?>
    <div class="controls">
        <?php
        $format = new MyFormatter;
        $modRencanaOperasi->tglrencanaoperasi = $format->formatDateTimeForUser($modRencanaOperasi->tglrencanaoperasi);

        $this->widget('MyDateTimePicker', array(
            'model' => $modRencanaOperasi,
            'attribute' => 'tglrencanaoperasi',
            'mode' => 'datetime',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,

            ),
            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span4 required', 'onkeypress' => "return $(this).focusNextInputField(event)"),
        )); ?>
        <?php echo $form->error($modRencanaOperasi, 'tglrencanaoperasi'); ?>
    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('Estimasi Lama Operasi', '', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $form->textField($modRencanaOperasi, 'estimasioperasi', array('placeholder' => '', 'class' => 'span4 float3', 'style' => 'text-align: right;', 'readonly' => false)) ?>&emsp;<label>Jam</label>
    </div>                    
</div>

<div class="control-group">
    <?php echo CHtml::label('Jam Mulai Operasi <span class="required">*</span>', '', array('class' => 'control-label required')); ?>
    <div class="controls">
        <?php
        $format = new MyFormatter;
        $modRencanaOperasi->tglrencanaoperasi = $format->formatDateTimeForUser($modRencanaOperasi->tglrencanaoperasi);

        $this->widget('MyDateTimePicker', array(
            'model' => $modRencanaOperasi,
            'attribute' => 'jam_mulai',
            'mode' => 'time',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,

            ),
            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span4', 'onkeypress' => "return $(this).focusNextInputField(event)"),
        )); ?>
        <?php echo $form->error($modRencanaOperasi, 'jam_mulai'); ?>
    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('Jam Selesai Operasi <span class="required">*</span>', '', array('class' => 'control-label required')); ?>
    <div class="controls">
        <?php
        $format = new MyFormatter;
        $modRencanaOperasi->tglrencanaoperasi = $format->formatDateTimeForUser($modRencanaOperasi->tglrencanaoperasi);

        $this->widget('MyDateTimePicker', array(
            'model' => $modRencanaOperasi,
            'attribute' => 'jam_selesai',
            'mode' => 'time',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,

            ),
            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span4', 'onkeypress' => "return $(this).focusNextInputField(event)"),
        )); ?>
        <?php echo $form->error($modRencanaOperasi, 'jam_selesai'); ?>
    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('Ruangan <span class="required">*</span>', '', array('class' => 'control-label required')); ?>
    <div class="controls">
        <?php echo $form->dropDownList(
        $modRencanaOperasi,
        'kamarruangan1_id',
        CHtml::listData(RuanganM::model()->findAll('instalasi_id = 7 and ruangan_aktif is true'), 'ruangan_id', 'ruangan_nama'),
        array(
            'empty' => '-- Pilih --',
            'onkeypress' => "return $(this).focusNextInputField(event)",
            'class' => 'span4',
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('SetDropdownKamarRuangan', array('encode' => false, 'namaModel' => get_class($modRencanaOperasi))),
                'update' => '.pilihkamar'),
        )
        );
         ?>
    </div>                    
</div>
<?php // echo $form->textFieldRow($modRencanaOperasi,'norencanaoperasi',array('readonly'=>true)) 
?>
<div class="control-group">
    <label for="" class="control-label">Kamar Ruangan <span class="required">*</span></label>
    <div class="controls">
        <?php 
            echo $form->dropDownList(
                $modRencanaOperasi,
                'kamarruangan_id',
                CHtml::listData($modRencanaOperasi->getKamarKosongItems(), 'kamarruangan_id', 'KamarDanTempatTidur'),
                array(
                    'empty' => '-- Pilih --',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'class' => 'span4 pilihkamar'
                )
            ); 
        ?>
    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label("Kru Bedah", '', array('class' => 'control-label required')); ?>
    <div class="controls">
        <?php
        echo CHtml::link("<i class='" . MyIcon::getIcons('tambah-baris') . "'></i>", "javascript:;", array(
            'class' => 'btn btn-primary',
            //'onclick' => "addKruBedahPeg();", 		
            'onclick' => "$('#dialogKruBedah').dialog('open');",
            'rel' => 'tooltip',
            'title' => 'Klik untuk menambah kru bedah yang lain '
        ));
        ?>
    </div>
</div>

<span id="urut-<?php echo str_replace(' ', '-', strtolower(Params::KRUBEDAH_OPERATOR)); ?>">
    <div class="control-group pelaksanaoperasi awal">
        <?php echo CHtml::label('DPJP Operator <span class="required">*</span>', 'dokter', array('class' => 'control-label required')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modRencanaOperasi, 'dokterpelaksana1_id', CHtml::listData($modRencanaOperasi->getDokterItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 krubedah_id required')); ?>
            <?php echo $form->error($modRencanaOperasi, 'dokterpelaksana1_id'); ?>

        </div>
    </div>

    <?php

    // echo '<pre>'; var_dump($modRencanaOperasi->attributes); die;
    if (!empty($modRencanaOperasi->rencanaoperasi_id)) {
        $look = $modRencanaOperasi->getKruBedahByLookup(Params::KRUBEDAH_OPERATOR, $modRencanaOperasi->rencanaoperasi_id);
        $i = 0;
        if (count((array)$look) > 0) {
            $length = 1;
            foreach ($look as $det) {
                $det->pegawai_nama = $det->pegawai->namaLengkap;
                echo $this->renderPartial($this->path_view . '_rowKruBedah', array('length' => $length, 'model' => $det, 'i' => $i), true);
                $i++;
                $length++;
            }
        }
    }
    ?>
</span>

<span id="urut-<?php echo str_replace(' ', '-', strtolower(Params::KRUBEDAH_ASISTEN_OPERATOR)); ?>">
    <div class="control-group pelaksanaoperasi awal">
        <?php echo CHtml::label('Asisten Operator', 'dokter', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modRencanaOperasi, 'dokterpelaksana2_id', CHtml::listData($modRencanaOperasi->getDokterItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 krubedah_id asistenOP')); ?>
            <?php echo CHtml::checkBox('ceklis_ppds', false, ['onclick' => 'setPPDS(this)', 'style' => 'margin-left:15px !important']) . ' <span class="control-label" style="font-size:11.5px">PPDS<span>' ?>
            <?php echo $form->error($modRencanaOperasi, 'dokterpelaksana2_id'); ?>
        </div>
    </div>

    <?php
    if (!empty($modRencanaOperasi->rencanaoperasi_id)) {
        $look = $modRencanaOperasi->getKruBedahByLookup(Params::KRUBEDAH_ASISTEN_OPERATOR, $modRencanaOperasi->rencanaoperasi_id);

        if (count((array)$look) > 0) {
            $length = 1;
            foreach ($look as $det) {
                $det->pegawai_nama = $det->pegawai->namaLengkap;
                echo $this->renderPartial($this->path_view . '_rowKruBedah', array('length' => $length, 'model' => $det, 'i' => $i), true);
                $i++;
                $length++;
            }
        }
    }
    ?>
</span>

<span id="urut-<?php echo str_replace(' ', '-', strtolower(Params::KRUBEDAH_DOKTER_RESUSITASI)); ?>">
    <div class="control-group pelaksanaoperasi awal">
        <?php echo CHtml::label('Dokter ResusitasI', 'dokterresusitasi_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modRencanaOperasi, 'dokterresusitasi_id', CHtml::listData($modRencanaOperasi->getDokterItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 krubedah_id')); ?>
        </div>
    </div>

    <?php
    if (!empty($modRencanaOperasi->rencanaoperasi_id)) {
        $look = $modRencanaOperasi->getKruBedahByLookup(Params::KRUBEDAH_DOKTER_RESUSITASI, $modRencanaOperasi->rencanaoperasi_id);

        if (count((array)$look) > 0) {
            $length = 1;
            foreach ($look as $det) {
                $det->pegawai_nama = $det->pegawai->namaLengkap;
                echo $this->renderPartial($this->path_view . '_rowKruBedah', array('length' => $length, 'model' => $det, 'i' => $i), true);
                $i++;
                $length++;
            }
        }
    }
    ?>
</span>

<span id="urut-<?php echo str_replace(' ', '-', strtolower(Params::KRUBEDAH_DOKTER_ANESTESI)); ?>">
    <div class="control-group pelaksanaoperasi awal">
        <?php echo CHtml::label('Dokter Anestesi', 'dokteranastesi_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modRencanaOperasi, 'dokteranastesi_id', CHtml::listData($modRencanaOperasi->getDokterItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 krubedah_id')); ?>
        </div>
    </div>

    <?php
    if (!empty($modRencanaOperasi->rencanaoperasi_id)) {
        $look = $modRencanaOperasi->getKruBedahByLookup(Params::KRUBEDAH_DOKTER_ANESTESI, $modRencanaOperasi->rencanaoperasi_id);

        if (count((array)$look) > 0) {
            $length = 1;
            foreach ($look as $det) {
                $det->pegawai_nama = $det->pegawai->namaLengkap;
                echo $this->renderPartial($this->path_view . '_rowKruBedah', array('length' => $length, 'model' => $det, 'i' => $i), true);
                $i++;
                $length++;
            }
        }
    }
    ?>
</span>

<span id="urut-<?php echo str_replace(' ', '-', strtolower(Params::KRUBEDAH_ASISTEN_ANESTESI)); ?>">
    <?php
    if (!empty($modRencanaOperasi->rencanaoperasi_id)) {
        $look = $modRencanaOperasi->getKruBedahByLookup(Params::KRUBEDAH_ASISTEN_ANESTESI, $modRencanaOperasi->rencanaoperasi_id);

        if (count((array)$look) > 0) {
            $length = 0;
            foreach ($look as $det) {
                $det->pegawai_nama = $det->pegawai->namaLengkap;
                echo $this->renderPartial($this->path_view . '_rowKruBedah', array('length' => $length, 'model' => $det, 'i' => $i), true);
                $i++;
                $length++;
            }
        }
    }
    ?>
</span>

<span id="urut-<?php echo str_replace(' ', '-', strtolower(Params::KRUBEDAH_PENATA_ANESTESI)); ?>">
    <div class="control-group pelaksanaoperasi awal">
        <?php echo CHtml::label('Penata / Perawat Anestesi', 'paramedis_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modRencanaOperasi, 'paramedis_id', CHtml::listData($modRencanaOperasi->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 krubedah_id')); ?>
        </div>
    </div>

    <?php
    if (!empty($modRencanaOperasi->rencanaoperasi_id)) {
        $look = $modRencanaOperasi->getKruBedahByLookup(Params::KRUBEDAH_PENATA_ANESTESI, $modRencanaOperasi->rencanaoperasi_id);

        if (count((array)$look) > 0) {
            $length = 1;
            foreach ($look as $det) {
                $det->pegawai_nama = $det->pegawai->namaLengkap;
                echo $this->renderPartial($this->path_view . '_rowKruBedah', array('length' => $length, 'model' => $det, 'i' => $i), true);
                $i++;
                $length++;
            }
        }
    }
    ?>
</span>

<span id="urut-<?php echo str_replace(' ', '-', strtolower(Params::KRUBEDAH_PETUGAS_RR)); ?>">
    <div class="control-group pelaksanaoperasi awal">
        <?php echo CHtml::label('Petugas RR', 'suster_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modRencanaOperasi, 'suster_id', CHtml::listData($modRencanaOperasi->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 krubedah_id')); ?>
        </div>
    </div>

    <?php
    if (!empty($modRencanaOperasi->rencanaoperasi_id)) {
        $look = $modRencanaOperasi->getKruBedahByLookup(Params::KRUBEDAH_PETUGAS_RR, $modRencanaOperasi->rencanaoperasi_id);

        if (count((array)$look) > 0) {
            $length = 1;
            foreach ($look as $det) {
                $det->pegawai_nama = $det->pegawai->namaLengkap;
                echo $this->renderPartial($this->path_view . '_rowKruBedah', array('length' => $length, 'model' => $det, 'i' => $i), true);
                $i++;
                $length++;
            }
        }
    }
    ?>
</span>

<span id="urut-<?php echo str_replace(' ', '-', strtolower(Params::KRUBEDAH_PERAWAT_INSTRUMENT)); ?>">
    <div class="control-group pelaksanaoperasi awal">
        <?php echo CHtml::label('Perawat Instrument', 'bidan_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modRencanaOperasi, 'bidan_id', CHtml::listData($modRencanaOperasi->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 krubedah_id')); ?>
        </div>
    </div>

    <?php
    if (!empty($modRencanaOperasi->rencanaoperasi_id)) {
        $look = $modRencanaOperasi->getKruBedahByLookup(Params::KRUBEDAH_PERAWAT_INSTRUMENT, $modRencanaOperasi->rencanaoperasi_id);

        if (count((array)$look) > 0) {
            $length = 1;
            foreach ($look as $det) {
                $det->pegawai_nama = $det->pegawai->namaLengkap;
                echo $this->renderPartial($this->path_view . '_rowKruBedah', array('length' => $length, 'model' => $det, 'i' => $i), true);
                $i++;
                $length++;
            }
        }
    }
    ?>
</span>

<span id="urut-<?php echo str_replace(' ', '-', strtolower(Params::KRUBEDAH_PERAWAT_SIRKULER)); ?>">
    <div class="control-group pelaksanaoperasi awal">
        <?php echo CHtml::label('Perawat Sirkuler', 'bidan_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modRencanaOperasi, 'perawatsirkuler_id', CHtml::listData($modRencanaOperasi->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 krubedah_id')); ?>
        </div>
    </div>

    <?php
    if (!empty($modRencanaOperasi->rencanaoperasi_id)) {
        $look = $modRencanaOperasi->getKruBedahByLookup(Params::KRUBEDAH_PERAWAT_SIRKULER, $modRencanaOperasi->rencanaoperasi_id);

        if (count((array)$look) > 0) {
            $length = 1;
            foreach ($look as $det) {
                $det->pegawai_nama = $det->pegawai->namaLengkap;
                echo $this->renderPartial($this->path_view . '_rowKruBedah', array('length' => $length, 'model' => $det, 'i' => $i), true);
                $i++;
                $length++;
            }
        }
    }
    ?>
</span>


<span id="urut-<?php echo str_replace(' ', '-', strtolower(Params::KRUBEDAH_PPDS)); ?>">
    <div class="control-group pelaksanaoperasi awal">
        <?php echo CHtml::label('PPDS', 'ppds_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modRencanaOperasi, 'ppds_id', CHtml::listData($modRencanaOperasi->getPPDS(), 'ppds_id', 'ppds_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 krubedah_id')); ?>
        </div>
    </div>

    <?php
    if (!empty($modRencanaOperasi->rencanaoperasi_id)) {
        $look = $modRencanaOperasi->getKruBedahByLookup(Params::KRUBEDAH_PPDS, $modRencanaOperasi->rencanaoperasi_id);
        if (count((array)$look) > 0) {
            $length = 1;
            foreach ($look as $det) {
                $det->pegawai_nama = $det->pegawai->namaLengkap;
                echo $this->renderPartial($this->path_view . '_rowKruBedah', array('length' => $length, 'model' => $det, 'i' => $i), true);
                $i++;
                $length++;
            }
        }
    }
    ?>
</span>


<span class="lookupkrubedah">
</span>
<?php
$cri = new CDbCriteria();
$cri->addNotInCondition("lookup_value", Params::getKruBedahLookup());
$cri->addCondition(" lookup_type = '" . Params::LOOKUPTYPE_KRU_BEDAH . "' AND lookup_aktif = TRUE ");
$cri->order = " lookup_urutan ASC ";
$lookKru = LookupM::model()->findAll($cri);

foreach ($lookKru as $l) {
?>
    <span id="urut-<?php echo str_replace(' ', '-', strtolower($l->lookup_value)); ?>" class="lookupkrubedah">
        <?php
        if (!empty($modRencanaOperasi->rencanaoperasi_id)) {
            $look = $modRencanaOperasi->getKruBedahByLookup($l->lookup_value, $modRencanaOperasi->rencanaoperasi_id);

            if (count((array)$look) > 0) {
                $length = 0;
                foreach ($look as $det) {
                    $det->pegawai_nama = $det->pegawai->namaLengkap;
                    echo $this->renderPartial($this->path_view . '_rowKruBedah', array('length' => $length, 'model' => $det, 'i' => $i), true);
                    $i++;
                    $length++;
                }
            }
        }
        ?>
    </span>
<?php
}
?>

<?php echo $form->dropDownListRow(
    $modRencanaOperasi,
    'statusoperasi',
    LookupM::getItems('statusoperasi'),
    array(
        'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4', 'disabled' => true
    )
); ?>
<?php echo $form->textAreaRow($modRencanaOperasi, 'keterangan_rencana', array('placeholder' => 'Keterangan Rencana', 'class' => 'span4')) ?>
<div class="control-group">
    <?php echo Chtml::label("Pegawai Mengetahui <span class='required'>*</span>", 'pegmengetahui_id', array('class' => 'control-label required')); ?>
    <div class="controls">
        <?php echo $form->hiddenField($modRencanaOperasi, 'pegmengetahui_id'); ?>
        <!--<div class="input-append" style='display:inline'>-->
        <?php
        $this->widget('MyJuiAutoComplete', array(
            'model' => $modRencanaOperasi,
            'attribute' => 'pegmengetahui_nama',
            'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('/ActionAutoComplete/PegawaiRuangan/') . '",
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
                'minLength' => 2,
                'select' => 'js:function( event, ui ) {                                                 
                                $("#' . CHtml::activeId($modRencanaOperasi, 'pegmengetahui_id') . '").val(ui.item.value);
                                $("#' . CHtml::activeId($modRencanaOperasi, 'pegmengetahui_nama') . '").val(ui.item.namaLengkap);                    
                                return false;
                            }',
            ),
            'tombolDialog' => array('idDialog' => 'dialogPegawaiYangMengetahui'),
            'htmlOptions' => array('placeholder' => 'Pegawai Mengetahui', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span4', 'style' => 'float:left;')
        ));
        ?>
        <?php echo $form->error($modRencanaOperasi, 'pegmengetahui_id'); ?>
    </div>
</div>
<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogKruBedah',
    'options' => array(
        'title' => 'Tambah Kru Bedah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 200,
        'resizable' => false,
        // 'position' => 'center',
    ),
));

//echo '<div class="divFormKruBedah"></div>';

echo $this->renderPartial($this->path_view . '_formTambahKruBedah', array(), true);

$this->endWidget('zii.widgets.jui.CJuiDialog');

?>

<?php
//===============Dialog buat pegawai
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPegawaiYangMengetahui',
    'options' => array(
        'title' => 'Pencarian Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 450,
        'resizable' => false,
    ),
));

$modPegawaiMengetahui = new BSPegawairuanganV('searchPegawaiMenyetujui');
$modPegawaiMengetahui->unsetAttributes();
if (isset($_GET['BSPegawairuanganV'])) {
    $modPegawaiMengetahui->attributes = $_GET['BSPegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaiYangMengetahui-m-grid',
    'dataProvider' => $modPegawaiMengetahui->searchPegawaiMenyetujui(),
    'filter' => $modPegawaiMengetahui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"$(\"#' . CHtml::activeId($modRencanaOperasi, 'pegmengetahui_id') . '\").val(\"$data->pegawai_id\");
                            $(\"#' . CHtml::activeId($modRencanaOperasi, 'pegmengetahui_nama') . '\").val(\"$data->gelardepan  $data->nama_pegawai\");
                            $(\"#dialogPegawaiYangMengetahui\").dialog(\"close\");
                            return false;"
                ))'
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => Chtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => Chtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function ($data) {
                $jabatan = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($jabatan)) {
                    echo $jabatan->jabatan_nama;
                } else {
                    echo "-";
                }
            },
            'filter' => Chtml::dropDownList('BSPegawairuanganV[jabatan_id]', $modPegawaiMengetahui->jabatan_id, Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function() {
            setNumbersOnly(this);
            });
       $(".hurufs-only").keyup(function() {
            setHurufsOnly(this);
            });'
        . ''
        . '}',
));

$this->endWidget();
?> 

<script>

    $(document).ready(function () {

        $(".float3").maskMoney(
            {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":1}
        );
    });

    function setPPDS(obj) {
        if($(obj).is(':checked')) {
            var type = 'PPDS';
        } else {
            var type = 'PEGAWAI';
        }
        $.post('<?= $this->createUrl('setPPDS') ?>', {
            type:type
        }, function(data){
            $('.asistenOP').html(data.option);
            $('.asistenOP').multiselect('rebuild');
        }, 'json');
    }
</script>