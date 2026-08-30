<div class="control-group">
    <?php echo CHtml::label("Kru Bedah", '', array('class' => 'control-label')); ?>
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
            <?php echo $form->dropDownList($modRencanaOperasi, 'dokterpelaksana1_id', CHtml::listData(PegawaiM::model()->findAll('kelompokpegawai_id = 1 and pegawai_aktif = true order by nama_pegawai'), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 krubedah_id required')); ?>
            <?php echo $form->error($modRencanaOperasi, 'dokterpelaksana1_id'); ?>
        </div>
    </div>

    <?php
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
            <?php echo $form->dropDownList($modRencanaOperasi, 'dokterpelaksana2_id', CHtml::listData(PegawaiM::model()->findAll('kelompokpegawai_id = 1 and pegawai_aktif = true order by nama_pegawai'), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 krubedah_id asistenOP')); ?>
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
        <?php echo CHtml::label('Dokter Resusitasi', 'dokterresusitasi_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modRencanaOperasi, 'dokterresusitasi_id', CHtml::listData(PegawaiM::model()->findAll('kelompokpegawai_id = 1 and pegawai_aktif = true order by nama_pegawai'), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 krubedah_id')); ?>
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
            <?php echo $form->dropDownList($modRencanaOperasi, 'dokteranastesi_id', CHtml::listData($modRencanaOperasi->getDokterItems3(Params::RUANGAN_ID_ANASTESI), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 krubedah_id')); ?>
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
            <?php echo $form->dropDownList($modRencanaOperasi, 'paramedis_id', CHtml::listData($modRencanaOperasi->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 krubedah_id')); ?>
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
            <?php echo $form->dropDownList($modRencanaOperasi, 'suster_id', CHtml::listData($modRencanaOperasi->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 krubedah_id')); ?>
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
            <?php echo $form->dropDownList($modRencanaOperasi, 'bidan_id', CHtml::listData($modRencanaOperasi->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 krubedah_id')); ?>
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
        <?php echo CHtml::label('Perawat Sirkuler', 'perawatsirkuler_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modRencanaOperasi, 'perawatsirkuler_id', CHtml::listData($modRencanaOperasi->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 krubedah_id')); ?>
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
<div class="control-group">
    <?php echo CHtml::label('Petugas Ruangan', 'petugasruangan_id', array('class' => 'control-label')) ?>
    <div class="controls">
    <?php echo $form->dropDownList($modKirimKeUnitLain, 'petugasruangan_id', CHtml::listData(PegawaiM::model()->findAll('kelompokpegawai_id in (2, 20) and pegawai_aktif is true order by nama_pegawai'), 'pegawai_id', 'NamaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Petugas OK', 'petugasok_id', array('class' => 'control-label')) ?>
    <div class="controls">
    <?php echo $form->dropDownList($modKirimKeUnitLain, 'petugasok_id', CHtml::listData(PegawairuanganV::model()->findAll('ruangan_id in (57, 59) and kelompokpegawai_id = 2 order by nama_pegawai'), 'pegawai_id', 'NamaLengkap'), array(
                            'empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));?>    </div>
</div>






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

<script>

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
/*  *
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * 
 * Mengambil data pegawai_v dari pencarian autocomplete.
 * Berdasarkan nama pegawai (jika ada).
 * 
 * @param type $term input pencarian autocomplete.
 * 
 */
function simpanKruPegawai() {
    var id = $("#kruBedahId").val();
    var lookup = $("#lookupKruBedah").val();

    if (lookup == '') {
        $("#lookupKruBedah").attr("style", "border:1px solid red;");
    } else {
        $("#lookupKruBedah").attr("style", "");
    }

    if (id == '') {
        $("#kruBedahNama").attr("style", "border:1px solid red;");
    } else {
        $("#kruBedahNama").attr("style", "");
    }



    if (id != '' && lookup != '') {
        var length = $("#urut-" + lookup.toLowerCase().replace(/\s/g, '-')).find(".pelaksanaoperasi").length;

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/bedahSentral/pendaftaranBedahSentralRujukanRS/AddKruBedah'); ?>',
            data: {
                id: id,
                lookup: lookup,
                length: length
            },
            dataType: "json",
            success: function(data) {
                if (data.sukses == 1) {
                    var cek = true;
                    $("#urut-" + lookup.toLowerCase().replace(/\s/g, '-')).find(".pelaksanaoperasi").each(
                        function() {
                            if ($(this).find(".krubedah_id").val() == data.id) {
                                alert("Maaf, pegawai ini sudah ditambahkan pada Kru Bedah " + data
                                .look);
                                cek = false;
                            }
                        });

                    if (cek == true) {
                        $("#urut-" + data.lookup).append(data.div);
                        renameInputRowPelaksanaOperasi();
                        $("#kruBedahId").val('');
                        $("#kruBedahNama").val('');
                        $("#lookupKruBedah").val('');
                        $('#dialogKruBedah').dialog('close');
                    } else {
                        return false;
                    }

                } else {
                    alert(data.pesan);
                    return false;
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    } else {
        alert(
            "Maaf, Kru Bedah dan Nama Pegawai harus diisi, untuk nama pegawai harus dipilih (dari hasil auto complete)");
        return false;
    }
}

function renameInputRowPelaksanaOperasi() {
    var row = 0;

    $(".pelaksanaoperasi").each(function() {



        if (($(this).hasClass('awal'))) {

        } else {
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        }
    });
}

function removeData(obj, st) {
    $(obj).parents('.pelaksanaoperasi').attr('style', 'border:1px solid red;');

    var conf = confirm("Apakah Anda ingin menghapus data ini ?");


    if (conf == true) {
        $(obj).parents('.pelaksanaoperasi').remove();
        renameInputRowPelaksanaOperasi();
        var row = 0;
        $("#urut-" + st.toLowerCase().replace(/\s/g, '-')).find(".pelaksanaoperasi").each(function() {
            if (($(this).hasClass('awal'))) {

            } else {
                if (row == 0) {
                    $(this).find('.gantilabel').html(st);
                }
            }
            row++;
        });

    } else {
        $(obj).parents('.pelaksanaoperasi').attr('style', '');
        return false;
    }

}

/**
 * - digunakan untuk mengupdate data pegawai kru bedah, yang sudah tersimpan dengan cara dibatalkan
 * @param {type} obj
 * @param {type} st
 * @returns {Boolean} */
function removeDataFromDb(obj, st) {

    var id = $(obj).attr('krubedah_id');
    $(obj).parents('.pelaksanaoperasi').attr('style', 'border:1px solid red;');

    var conf = confirm("Apakah Anda ingin membatalkan data ini ?");


    if (conf == true) {

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('BatalKruBedah'); ?>',
            data: {
                id: id,
                lookup: st
            },
            dataType: "json",
            success: function(data) {
                if (data.sukses == 1) {
                    $(obj).parents('.pelaksanaoperasi').remove();
                    renameInputRowPelaksanaOperasi();
                    var row = 0;
                    $("#urut-" + st.toLowerCase().replace(/\s/g, '-')).find(".pelaksanaoperasi").each(
                        function() {
                            if (($(this).hasClass('awal'))) {

                            } else {
                                if (row == 0) {
                                    $(this).find('.gantilabel').html(st);
                                }
                            }
                            row++;
                        });
                    alert(data.pesan);

                } else {
                    alert(data.pesan);
                    return false;
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    } else {
        $(obj).parents('.pelaksanaoperasi').attr('style', '');
        return false;
    }

}




$(document).ready(function() {
    var ppds = jQuery('#<?php echo CHtml::activeId($modRencanaOperasi, 'ppds_id') ?>');
    jQuery(ppds).multiselect({
        includeSelectAllOption: false,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '240px',
        enableCaseInsensitiveFiltering: true
    }).hide();

});

$(document).ready(function() {
    var dokterresusitasi_id = jQuery(
        '#<?php echo CHtml::activeId($modRencanaOperasi, 'dokterresusitasi_id') ?>');
    jQuery(dokterresusitasi_id).multiselect({
        includeSelectAllOption: false,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '182px',
        enableCaseInsensitiveFiltering: true
    }).hide();

});




$(document).ready(function() {
    var petugasok_id = jQuery('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'petugasok_id') ?>');
    jQuery(petugasok_id).multiselect({
        includeSelectAllOption: false,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '182px',
        enableCaseInsensitiveFiltering: true
    }).hide();

});


$(document).ready(function() {
    var suster_id = jQuery('#<?php echo CHtml::activeId($modRencanaOperasi, 'suster_id') ?>');
    jQuery(suster_id).multiselect({
        includeSelectAllOption: false,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '182px',
        enableCaseInsensitiveFiltering: true
    }).hide();

});





$(document).ready(function() {
    var petugasruangan_id = jQuery('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'petugasruangan_id') ?>');
    jQuery(petugasruangan_id).multiselect({
        includeSelectAllOption: false,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '182px',
        enableCaseInsensitiveFiltering: true
    }).hide();

});


$(document).ready(function() {
    var perawatsirkuler_id = jQuery('#<?php echo CHtml::activeId($modRencanaOperasi, 'perawatsirkuler_id') ?>');
    jQuery(perawatsirkuler_id).multiselect({
        includeSelectAllOption: false,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '182px',
        enableCaseInsensitiveFiltering: true
    }).hide();

});



$(document).ready(function() {
    var paramedis_id = jQuery('#<?php echo CHtml::activeId($modRencanaOperasi, 'paramedis_id') ?>');
    jQuery(paramedis_id).multiselect({
        includeSelectAllOption: false,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '182px',
        enableCaseInsensitiveFiltering: true
    }).hide();

});


$(document).ready(function() {
    var dokteranastesi_id = jQuery('#<?php echo CHtml::activeId($modRencanaOperasi, 'dokteranastesi_id') ?>');
    jQuery(dokteranastesi_id).multiselect({
        includeSelectAllOption: false,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '182px',
        enableCaseInsensitiveFiltering: true
    }).hide();

});

$(document).ready(function() {
    var dokterpelaksana2_id = jQuery(
        '#<?php echo CHtml::activeId($modRencanaOperasi, 'dokterpelaksana2_id') ?>');
    jQuery(dokterpelaksana2_id).multiselect({
        includeSelectAllOption: false,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '182px',
        enableCaseInsensitiveFiltering: true
    }).hide();

});

$(document).ready(function() {
    var dokterpelaksana1_id = jQuery(
        '#<?php echo CHtml::activeId($modRencanaOperasi, 'dokterpelaksana1_id') ?>');
    jQuery(dokterpelaksana1_id).multiselect({
        includeSelectAllOption: false,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '182px',
        enableCaseInsensitiveFiltering: true
    }).hide();

});



$(document).ready(function() {
    var bidan_id = jQuery('#<?php echo CHtml::activeId($modRencanaOperasi, 'bidan_id') ?>');
    jQuery(bidan_id).multiselect({
        includeSelectAllOption: false,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '182px',
        enableCaseInsensitiveFiltering: true
    }).hide();

});


function tambahLookup() {
    var p = prompt("Tambah Kru Bedah Baru ");

    if (p === null) {
        return false;
    } else if (p == '') {
        alert("Maaf, kru bedah belum diisi!");
        return false;
    } else {
        var yes = confirm("Apakah Anda yakin ingin menambahkan kru bedah baru ? ");

        if (yes) {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('AddLookupKruBedah'); ?>',
                data: {
                    krubedah: p
                },
                dataType: "json",
                success: function(data) {
                    if (data.sukses == 1) {
                        var lookup = data.look;
                        alert(data.pesan);
                        $("#lookupKruBedah").html(data.drop);
                        $(".lookupkrubedah:last").after("<span id='urut-" + lookup.toLowerCase().replace(
                            /\s/g, '-') + "' class='lookupkrubedah'></span>");
                    } else {
                        alert(data.pesan);
                        return false;
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            return false;
        }
    }
}
</script>