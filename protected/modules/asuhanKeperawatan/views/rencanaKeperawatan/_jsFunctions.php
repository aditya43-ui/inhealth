<?php
/**
 * issue RSST-2549
 * digunakan untuk menampung fungsi - fungsi pada javascript
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 * 
 */
?>
<script type="text/javascript">

    function setTindakan(obj) {

        var item = [];
        var i = 0;
        $(obj).parents('tr').find('.intervensi').each(function () {
            $(this).find('.intervensinya:checked').each(function (i) {
                var nama = $(this).val();
                var arraycontains_item = (item.indexOf(nama) > -1);
                console.log(arraycontains_item);

                if (arraycontains_item == false) {
                    item[i] = nama;
                    i++;
                }
            });
        });

        
        var diagnosisaskepdet_id = $(obj).parents('tr').find('.diagnosisaskepdet_id').val();
        
        
        var intervensidet_id = item.join(',');
        $(obj).parents('tr').find('.tindakannya').each(function () {
            $(this).find("#table-tindakannya").addClass("animation-loading");
        });
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setTindakan'); ?>',
            data: {intervensidet_id: intervensidet_id, diagnosisaskepdet_id:diagnosisaskepdet_id},
            dataType: "json",
            success: function (data) {
                $(obj).parents('tr').find('.tindakannya').each(function () {
                    // $(this).find('#table-tindakannya').html("");
                    $(this).find('#table-tindakannya').append(data.tabel);
                    $(this).find("#table-tindakannya").removeClass("animation-loading");
                });
                renameInputImplementasi();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function cekDiagnosis(obj) {
        if (obj.diagnosisaskep_id != '') {
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('cekDiagnosis'); ?>',
                data: {
                    diagnosisaskep_id: obj.diagnosisaskep_id
                },
                dataType: "json",
                success: function (data) {
                    
//                    if (data.sudahdipilih == 'sudah') {
//                        myAlert("Diagnosis sudah dipilih!");
//                        return false;
//                    } else {
                        loadPasien(data.diagnosisaskep_id, obj);
//                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    function cekDiagnosis2(diagnosisaskep_id) {
        if (diagnosisaskep_id != '') {
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('cekDiagnosis'); ?>',
                data: {
                    diagnosisaskep_id: diagnosisaskep_id
                },
                dataType: "json",
                success: function (data) {

                    loadPasien2(data.diagnosisaskep_id);
                    
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    function cekRiwayatDiagnosis(obj) {
        var diagnosisaskep_id = $("#DiagnosisaskepT_diagnosisaskep_id").val();
        if (diagnosisaskep_id == '') {
            myAlert("Silakan Pilih Diagnosa Keperawatan!", "Perhatian!");
        } else {
            window.open("index.php?r=asuhanKeperawatan/InformasiDiagnosisKeperawatan/Detail&diagnosisaskep_id=" + diagnosisaskep_id, "", 'location=_new, width=900px, scrollbars=1');
        }
        return false;
    }

    function cekPengkajianId(pengkajianaskep_id) {
        if (pengkajianaskep_id !== undefined) {
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('cekPengkajianId'); ?>',
                data: {pengkajianaskep_id: pengkajianaskep_id},
                dataType: "json",
                success: function (data) {

                    if (data != null) {
                        myAlert("Pengkajian sudah dipilih!");
                        return false;
                    } else {

                        loadPasien(pengkajianaskep_id);
                        return true;
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    function cekPengkajian(obj) {
        var pengkajianaskep_id = $("#<?php echo CHtml::activeId($modPengkajian, 'pengkajianaskep_id') ?>").val();
        var iskeperawatan = $("#iskeperawatan").val();
        if (pengkajianaskep_id == '') {
            myAlert("Silakan Pilih Pengkajian!");
        } else {
            if (iskeperawatan == 1) {
                window.open("<?php echo Yii::app()->controller->createUrl("/asuhanKeperawatan/RencanaKeperawatan/DetailPengkajianKeb"); ?>/&pengkajianaskep_id=" + pengkajianaskep_id, "", 'location=_new, width=900px, scrollbars=1');
            }
            if (iskeperawatan == 0) {
                window.open("<?php echo Yii::app()->controller->createUrl("/asuhanKeperawatan/RencanaKeperawatan/DetailPengkajian"); ?>/&pengkajianaskep_id=" + pengkajianaskep_id, "", 'location=_new, width=900px, scrollbars=1');
            }
        }
        return false;
    }

    function loadPasien(diagnosisaskep_id, diagnosis)
    {
        if (typeof diagnosisaskep_id !== 'undefined') {
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('loadPasien'); ?>',
                data: {
                    diagnosisaskep_id: diagnosisaskep_id,
                },
                dataType: "json",
                success: function (data) {
                    $("#<?php echo CHtml::activeId($modDiagnosis, 'diagnosisaskep_id') ?>").val(diagnosis.diagnosisaskep_id);
                    $("#<?php echo CHtml::activeId($modDiagnosis, 'no_diagnosisaskep') ?>").val(diagnosis.no_diagnosisaskep);
                    $("#<?php echo CHtml::activeId($modDiagnosis, 'diagnosisaskep_tgl') ?>").val(diagnosis.diagnosisaskep_tgl);
                    $("#<?php echo CHtml::activeId($modDiagnosis, 'pegawai_id') ?>").val(diagnosis.pegawai_id);
                    $("#<?php echo CHtml::activeId($modDiagnosis, 'nama_pegawai') ?>").val(diagnosis.nama_lengkap);

                    $('#<?php echo CHtml::activeId($modPasien, 'no_pendaftaran') ?>').val(data.data.no_pendaftaran);
                    $('#<?php echo CHtml::activeId($modPasien, 'nama_pasien') ?>').val(data.data.nama_pasien);
                    $('#<?php echo CHtml::activeId($modPasien, 'ruangan_nama') ?>').val(data.data.ruangan_nama);
                    $('#<?php echo CHtml::activeId($modPasien, 'tgl_pendaftaran') ?>').val(data.data.tgl_pendaftaran);
                    $('#<?php echo CHtml::activeId($modPasien, 'umur') ?>').val(data.data.umur);
                    $('#<?php echo CHtml::activeId($modPasien, 'kelaspelayanan_nama') ?>').val(data.data.kelaspelayanan_nama);
                    $('#<?php echo CHtml::activeId($modPasien, 'no_rekam_medik') ?>').val(data.data.no_rekam_medik);
                    $('#<?php echo CHtml::activeId($modPasien, 'diagnosa_nama') ?>').val(data.diagnosa);
                    $('#<?php echo CHtml::activeId($modPasien, 'no_kamarbed') ?>').val(((data.data.kamarruangan_nokamar !== null) ? data.data.kamarruangan_nokamar : '-') + ' / ' + ((data.data.kamarruangan_nobed !== null) ? data.data.kamarruangan_nobed : '-'));
                    loadDiagnosisDet(diagnosis.diagnosisaskep_id);

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    function loadPasien2(diagnosisaskep_id)
    {
<?php if (!empty($_GET['rencanaaskep_id'])) { ?>
    <?php $cekDiagnosa = RencanaaskepT::model()->findByPk($_GET['rencanaaskep_id']); ?>
            var rencanaaskep_id = '<?php echo!empty($cekDiagnosa->rencanaaskep_id) ? $cekDiagnosa->rencanaaskep_id : null; ?>';
            var id_diagnosa = '<?php echo!empty($cekDiagnosa->diagnosisaskep->diagnosisaskep_id) ? $cekDiagnosa->diagnosisaskep->diagnosisaskep_id : null; ?>';
            var no_diagnosa = '<?php echo!empty($cekDiagnosa->diagnosisaskep->no_diagnosisaskep) ? $cekDiagnosa->diagnosisaskep->no_diagnosisaskep : null; ?>';
            var tgl_diagnosa = '<?php echo!empty($cekDiagnosa->diagnosisaskep->diagnosisaskep_tgl) ? $cekDiagnosa->diagnosisaskep->diagnosisaskep_tgl : null; ?>';
            var pegawai_diagnosa = '<?php echo!empty($cekDiagnosa->diagnosisaskep->pegawai_id) ? $cekDiagnosa->diagnosisaskep->pegawai_id : null; ?>';
            var pegawai_nama = '<?php echo!empty($cekDiagnosa->diagnosisaskep->pegawai->namaLengkap) ? $cekDiagnosa->diagnosisaskep->pegawai->namaLengkap : null; ?>';
<?php } else if (!empty($_GET['diagnosisaskep_id'])) { ?>
    <?php $cekDiagnosa = DiagnosisaskepT::model()->findByPk($_GET['diagnosisaskep_id']); ?>
            var rencanaaskep_id = '';
            var id_diagnosa = '<?php echo!empty($cekDiagnosa->diagnosisaskep_id) ? $cekDiagnosa->diagnosisaskep_id : null; ?>';
            var no_diagnosa = '<?php echo!empty($cekDiagnosa->no_diagnosisaskep) ? $cekDiagnosa->no_diagnosisaskep : null; ?>';
            var tgl_diagnosa = '<?php echo!empty($cekDiagnosa->diagnosisaskep_tgl) ? $cekDiagnosa->diagnosisaskep_tgl : null; ?>';
            var pegawai_diagnosa = '<?php echo!empty($cekDiagnosa->pegawai_id) ? $cekDiagnosa->pegawai_id : null; ?>';
            var pegawai_nama = '<?php echo!empty($cekDiagnosa->pegawai->namaLengkap) ? $cekDiagnosa->pegawai->namaLengkap : null; ?>';
<?php } ?>
        if (typeof diagnosisaskep_id !== 'undefined') {
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('loadPasien'); ?>',
                data: {
                    diagnosisaskep_id: diagnosisaskep_id,
                },
                dataType: "json",
                success: function (data) {
                    $("#<?php echo CHtml::activeId($modDiagnosis, 'diagnosisaskep_id') ?>").val(id_diagnosa);
                    $("#<?php echo CHtml::activeId($modDiagnosis, 'no_diagnosisaskep') ?>").val(no_diagnosa);
                    $("#<?php echo CHtml::activeId($modDiagnosis, 'diagnosisaskep_tgl') ?>").val(tgl_diagnosa);
                    $("#<?php echo CHtml::activeId($modDiagnosis, 'pegawai_id') ?>").val(pegawai_diagnosa);
                    $("#<?php echo CHtml::activeId($modDiagnosis, 'nama_pegawai') ?>").val(pegawai_nama);

                    $('#<?php echo CHtml::activeId($modPasien, 'no_pendaftaran') ?>').val(data.data.no_pendaftaran);
                    $('#<?php echo CHtml::activeId($modPasien, 'nama_pasien') ?>').val(data.data.nama_pasien);
                    $('#<?php echo CHtml::activeId($modPasien, 'ruangan_nama') ?>').val(data.data.ruangan_nama);
                    $('#<?php echo CHtml::activeId($modPasien, 'tgl_pendaftaran') ?>').val(data.data.tgl_pendaftaran);
                    $('#<?php echo CHtml::activeId($modPasien, 'umur') ?>').val(data.data.umur);
                    $('#<?php echo CHtml::activeId($modPasien, 'kelaspelayanan_nama') ?>').val(data.data.kelaspelayanan_nama);
                    $('#<?php echo CHtml::activeId($modPasien, 'no_rekam_medik') ?>').val(data.data.no_rekam_medik);
                    $('#<?php echo CHtml::activeId($modPasien, 'diagnosa_nama') ?>').val(data.diagnosa);
                    $('#<?php echo CHtml::activeId($modPasien, 'no_kamarbed') ?>').val(((data.data.kamarruangan_nokamar !== null) ? data.data.kamarruangan_nokamar : '-') + ' / ' + ((data.data.kamarruangan_nobed !== null) ? data.data.kamarruangan_nobed : '-'));

                    if (rencanaaskep_id != '') {
                        loadRencanaDet(rencanaaskep_id);
                    } else {
                        loadDiagnosisDet(id_diagnosa);
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    function loadDiagnosisDet(diagnosisaskep_id) {
        $("#table-rencana").addClass("animation-loading");
        $('#table-rencana > tbody').html("");
<?php if (!empty($_GET['rencanaaskep_id'])) : ?>
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('GetDiagnosisDet'); ?>',
                data: {diagnosisaskep_id: diagnosisaskep_id}, //
                dataType: "json",
                success: function (data) {
                    $('#table-rencana > tbody').append(data.form);

                    jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                    $(".integer").maskMoney(
                            {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                    );

                    $("#table-rencana").removeClass("animation-loading");
                    renameInputRow($("#table-rencana"));

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
<?php else : ?>
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('GetDiagnosisDet'); ?>',
                data: {diagnosisaskep_id: diagnosisaskep_id}, //
                dataType: "json",
                success: function (data) {
                    $('#table-rencana > tbody').append(data.form);

    <?php
    $attributes = $modDetail->attributeNames();
    foreach ($attributes as $i => $attribute) {
        echo "renameInput('ASRencanaaskepdetT','$attribute');";
    }
    ?>
                    renameInputDiagDetail('#table-rencana');
                    renameInputRow('#table-rencana');
                    renameInputTandaGejala('#table-rencana');
                    renameInput('ASRencanaaskepdetT', 'rencanaaskepdet_hari');
                    renameInput('ASRencanaaskepdetT', 'rencanaaskepdet_estimasiwaktu');
                    renameInput('ASRencanaaskepdetT', 'tujuan_id');
                    renameInput('ASRencanaaskepdetT', 'tujuan_nama');
                    renameInput('ASRencanaaskepdetT', 'tautansdki_slki_id');
                    renameInput('ASRencanaaskepdetT', 'tautansdki_slki_nama');
                    renameInput('ASRencanaaskepdetT', 'kriteriahasil_id');
                    renameInput('ASRencanaaskepdetT', 'kriteriahasil_nama');
                    renameInputRowKriteria('#table-rencana');
                    renameInputIntervensi('#table-rencana');

                    jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                    $(".integer").maskMoney(
                            {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                    );

                    $("#table-rencana").removeClass("animation-loading");
                    renameInputRow($("#table-rencana"));

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
<?php endif ?>
    }

    function loadDiagnosaMedis(pasien_id, pendaftaran_id)
    {
        if (pasien_id !== undefined) {
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('loadDiagnosaMedis'); ?>',
                data: {pasien_id: pasien_id, pendaftaran_id: pendaftaran_id},
                dataType: "json",
                success: function (data) {
                    $('#ASInfopengkajianaskepV_diagnosa_nama').val(data.diagnosa_nama);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    var trTindakan = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowRencanaDetail', array('modDetail' => $modDetail), true)); ?>);
    var trTindakanFirst = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowRencanaDetail', array('modDetail' => $modDetail), true)); ?>);
    function addRowTindakan(obj)
    {
        $(obj).parents('table').children('tbody').append(trTindakan.replace());
<?php
$attributes = $modDetail->attributeNames();
foreach ($attributes as $i => $attribute) {
    echo "renameInput('ASRencanaaskepdetT','$attribute');";
}
?>
        renameInput('ASRencanaaskepdetT', 'diagnosakep_nama');
        renameInput('ASRencanaaskepdetT', 'diagnosakep_id');
        renameInput('ASRencanaaskepdetT', 'tandagejala_id');
        renameInput('ASRencanaaskepdetT', 'istandagejala');
        renameInput('ASRencanaaskepdetT', 'rencanaaskepdet_hari');
        renameInput('ASRencanaaskepdetT', 'rencanaaskepdet_estimasiwaktu');
        renameInput('ASRencanaaskepdetT', 'tujuan_id');
        renameInput('ASRencanaaskepdetT', 'kriteriahasil_id');
        renameInput('ASRencanaaskepdetT', 'kriteriadet_id');
        renameInput('ASRencanaaskepdetT', 'kriteriahasil_id');
        renameInput('ASRencanaaskepdetT', 'kriteriahasil_nama');
        renameInput('ASRencanaaskepdetT', 'iskriteria');
        renameInput('ASRencanaaskepdetT', 'kriteriahasildet_id');
        renameInput('ASRencanaaskepdetT', 'rencanaaskep_ir');
        renameInput('ASRencanaaskepdetT', 'rencanaaskep_er');
        renameInput('ASRencanaaskepdetT', 'intervensi_id');
        renameInput('ASRencanaaskepdetT', 'intervensidet_id');
        renameInput('ASRencanaaskepdetT', 'intervensi_nama');
        renameInput('ASRencanaaskepdetT', 'isintervensi');
        renameInput('ASRencanaaskepdetT', 'iskolaborasi');
        renameInput('ASRencanaaskepdetT', 'rencanaaskepdet_ketkolaborasi');
        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
        jQuery('input[name$="[diagnosakep_nama]"]').autocomplete(
                {
                    'showAnim': 'fold',
                    'minLength': 3,
                    'focus': function (event, ui)
                    {
                        $(this).val(ui.item.label);
                        return false;
                    },
                    'select': function (event, ui)
                    {
                        setDiagnosa(this, ui.item);
                        return false;
                    },
                    'source': function (request, response)
                    {
                        $.ajax({
                            url: "<?php echo $this->createUrl('AutocompleteDiagnosa'); ?>",
                            dataType: "json",
                            data: {
                                term: request.term,
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }
                }
        );
    }

    function batalTindakan(obj)
    {
        myConfirm("Apakah Anda yakin akan membatalkan rencana?", "Perhatian!", function (r) {
            if (r) {
                $(obj).parents('tr').next('tr').detach();
                $(obj).parents('tr').detach();
<?php
foreach ($attributes as $i => $attribute) {
    echo "renameInput('ASRencanaaskepdetT','$attribute');";
}
?>
                renameInput('ASRencanaaskepdetT', 'diagnosakep_nama');
                renameInput('ASRencanaaskepdetT', 'diagnosakep_id');
                renameInput('ASRencanaaskepdetT', 'tandagejala_id');
                renameInput('ASRencanaaskepdetT', 'istandagejala');
                renameInput('ASRencanaaskepdetT', 'rencanaaskepdet_hari');
                renameInput('ASRencanaaskepdetT', 'rencanaaskepdet_estimasiwaktu');
                renameInput('ASRencanaaskepdetT', 'tujuan_id');
                renameInput('ASRencanaaskepdetT', 'kriteriahasil_id');
                renameInput('ASRencanaaskepdetT', 'kriteriadet_id');
                renameInput('ASRencanaaskepdetT', 'kriteriahasil_id');
                renameInput('ASRencanaaskepdetT', 'kriteriahasil_nama');
                renameInput('ASRencanaaskepdetT', 'iskriteria');
                renameInput('ASRencanaaskepdetT', 'kriteriahasildet_id');
                renameInput('ASRencanaaskepdetT', 'rencanaaskep_ir');
                renameInput('ASRencanaaskepdetT', 'rencanaaskep_er');
                renameInput('ASRencanaaskepdetT', 'intervensi_id');
                renameInput('ASRencanaaskepdetT', 'intervensidet_id');
                renameInput('ASRencanaaskepdetT', 'intervensi_nama');
                renameInput('ASRencanaaskepdetT', 'isintervensi');
                renameInput('ASRencanaaskepdetT', 'iskolaborasi');
                renameInput('ASRencanaaskepdetT', 'rencanaaskepdet_ketkolaborasi');
            }
        });
    }

    function deleteTindakan(obj, idTindakanpelayanan)
    {
        myConfirm("Apakah Anda yakin akan menghapus tindakan?", "Perhatian!", function (r) {
            if (r) {
                $.post('<?php echo $this->createUrl('ajaxDeleteTindakanPelayanan') ?>', {idTindakanpelayanan: idTindakanpelayanan}, function (data) {
                    if (data.success)
                    {
                        $(obj).parent().parent().detach();
                        myAlert('Data berhasil dihapus.');
                    } else {
                        myAlert('Data Gagal dihapus');
                    }
                }, 'json');
            }
        });
    }

    function renameListTindakan(modelName, attributeName)
    {
        var trLength = $('#table-rencana tr').length;
        var i = -1;
        $('#table-rencana tr').each(function () {
            if ($(this).has('input[name$="[diagnosakep_id]"]').length) {
                i++;
            }
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('textarea[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('textarea[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
        });
    }

    function renameInput(modelName, attributeName)
    {
        var trLength = $('#table-rencana tr').length;
        var i = -1;
        $('#table-rencana tr').each(function () {
            if ($(this).has('input[name$="[diagnosakep_id]"]').length) {
                i++;
            }
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('input[name$="[' + attributeName + '][]"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + '][]"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('textarea[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('textarea[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('input[id="row"]').attr('value', i);
            $(this).find('input[id="row"]').val(i);
//        jQuery('input[name$="[daftartindakanNama]"]').datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y'}));
        });
    }

    function renameInputImplementasi()
    {
        var row = 0;
        $('#table-rencana').find("tbody > .rencanaaskepdet").each(function () {
            $(this).find("#table-tindakannya").each(function () {
                $(this).find("tbody").each(function () {
                    var row2 = 0;
                    var row3 = 0;
    
                    $(this).find('.impls').each(function () { //element <input>
                        var old_name = $(this).attr("name").replace(/]/g, "");
                        var old_name_arr = old_name.split("[");
                        if (old_name_arr.length == 5) {
                            $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3] + "_" + old_name_arr[4]);
                            $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + old_name_arr[3] + "][" + old_name_arr[4] + "]");
                        }
                        row3++;
    
                    });
    
                    $(this).find('.impls_id').each(function () { //element <input>
                        var old_name = $(this).attr("name").replace(/]/g, "");
                        var old_name_arr = old_name.split("[");
                        if (old_name_arr.length == 5) {
                            $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3] + "_" + old_name_arr[4]);
                            $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + old_name_arr[3] + "][" + old_name_arr[4] + "]");
                        }
                        row3++;
    
                    });
                    
                    $(this).find('input[name$="[indikatorimplkepdet_id]"]').each(function () { //element <input>
                        var old_name = $(this).attr("name").replace(/]/g, "");
                        var old_name_arr = old_name.split("[");
                        if (old_name_arr.length == 5) {
                            $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3] + "_" + old_name_arr[4]);
                            $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + old_name_arr[3] + "][" + old_name_arr[4] + "]");
                        }
                        row3++;
                    });

                    $(this).find('.implsdet').each(function () { //element <input>
                        var old_name = $(this).attr("name").replace(/]/g, "");
                        var old_name_arr = old_name.split("[");
                        if (old_name_arr.length == 6) {
                            $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3] + "_" + row2 + "_" + old_name_arr[4]);
                            $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + old_name_arr[3] + "][" + row2 + "][" + old_name_arr[4] + "][indikatorimplkepdet_id]");
                        }
                        row2++;

                    });
                });
            });
            row++;
        });
    }

    function renameInputTandaGejala(obj_table)
    {
        var row = 0;
        $(obj_table).find("tbody > .rencanaaskepdet").each(function () {

            var row2 = 0;
            $(this).find('input[name$="[tandagejala_id]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input[name$="[tandagejala_id][]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
                if (old_name_arr.length == 4) {

                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row2 + "]");
                }
                row2++;
            });
            row++;
        });
    }

    function renameInputDiagDetail(obj_table)
    {
        var row = 0;
        console.log();
        $(obj_table).find("tbody > .rencanaaskepdet").each(function () {
            var row2 = 0;
            $(this).find('input[name$="[alternatifdx_id]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input[name$="[alternatifdx_id][]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
                if (old_name_arr.length == 4) {

                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row2 + "]");
                }
                row2++;
            });
            row++;
        });
    }

    function renameInputTandaGejalaSimpan(obj_table, modPilih)
    {
        var row = 0;
        $(obj_table).find("tbody > .rencanaaskepdet").each(function () {

            var row2 = 0;
            $(this).find('input[name$="[tandagejala_id]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input[name$="[tandagejala_id][]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
                if (old_name_arr.length == 4) {

                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row2 + "]");
                }
                for (i = 0; i < modPilih[row].length; i++) {
                    var tg_id = modPilih[row][i].tandagejala_id;
                    if (tg_id !== 'undefined') {
                        if ($(this).val() == tg_id) {
                            $(this).attr("checked", "checked");
                        }
                    }
                }
                row2++;
            });
            row++;
        });
    }

    function renameInputDiagDetailSimpan(obj_table, modPilih)
    {
        var row = 0;
        $(obj_table).find("tbody > .rencanaaskepdet").each(function () {

            var row2 = 0;
            $(this).find('input[name$="[alternatifdx_id]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input[name$="[alternatifdx_id][]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
                if (old_name_arr.length == 4) {

                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row2 + "]");
                }
                for (i = 0; i < modPilih[row].length; i++) {
                    var tg_id = modPilih[row][i].alternatifdx_id;
                    if (tg_id !== 'undefined') {
                        if ($(this).val() == tg_id) {
                            $(this).attr("checked", "checked");
                        }
                    }
                }
                row2++;
            });
            row++;
        });
    }

    function renameInputIntervensi(obj_table)
    {
        var row = 0;
        $(obj_table).find("tbody > .rencanaaskepdet").each(function () {
            var row2 = 0;
            $(this).find('input[name$="[intervensidet_id]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input[name$="[intervensidet_id][]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
                if (old_name_arr.length == 4) {

                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row2 + "]");
                }
                row2++;
            });
            row++;
        });
    }

    function renameInputIntervensiSimpan(obj_table, modPilih)
    {
        var row = 0;
        $(obj_table).find("tbody > .rencanaaskepdet").each(function () {
            var row2 = 0;
            $(this).find('input[name$="[intervensidet_id]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input[name$="[intervensidet_id][]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
                if (old_name_arr.length == 4) {

                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row2 + "]");
                }

                for (i = 0; i < modPilih[row].length; i++) {
                    var tg_id = modPilih[row][i].intervensidet_id;
                    if (tg_id !== 'undefined') {
                        if ($(this).val() == tg_id) {
                            $(this).attr("checked", "checked");
                        }
                    }
                }

                row2++;
            });
            row++;
        });
    }

    function renameInputImplementasiSimpan(obj_table, modPilih)
        {
            var row = 0;
            $('#table-rencana').find("tbody > .rencanaaskepdet").each(function () {
                $(this).find("#table-tindakannya").each(function () {
                    $(this).find("tbody").each(function () {
                        var row2 = 0;
                        var row3 = 0;

                        $(this).find('.impls').each(function () { //element <input>
                            var old_name = $(this).attr("name").replace(/]/g, "");
                            var old_name_arr = old_name.split("[");
                            if (old_name_arr.length == 5) {
                                $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3] + "_" + old_name_arr[4]);
                                $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + old_name_arr[3] + "][" + old_name_arr[4] + "]");
                            }
                            row3++;

                        });

                        $(this).find('.impls_id').each(function () { //element <input>
                            var old_name = $(this).attr("name").replace(/]/g, "");
                            var old_name_arr = old_name.split("[");
                            if (old_name_arr.length == 5) {
                                $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3] + "_" + old_name_arr[4]);
                                $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + old_name_arr[3] + "][" + old_name_arr[4] + "]");
                            }
                            row3++;

                        });

                        $(this).find('input[name$="[indikatorimplkepdet_id]"]').each(function () { //element <input>
                            var old_name = $(this).attr("name").replace(/]/g, "");
                            var old_name_arr = old_name.split("[");
                            if (old_name_arr.length == 5) {
                                $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3] + "_" + old_name_arr[4]);
                                $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + old_name_arr[3] + "][" + old_name_arr[4] + "]");
                            }
                            row3++;
                        });

                        $(this).find('.implsdet').each(function () { //element <input>
                            var old_name = $(this).attr("name").replace(/]/g, "");
                            var old_name_arr = old_name.split("[");
                            if (old_name_arr.length == 6) {
                                $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3] + "_" + row2 + "_" + old_name_arr[4]);
                                $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + old_name_arr[3] + "][" + row2 + "][" + old_name_arr[4] + "][indikatorimplkepdet_id]");
                            }
                            if (modPilih != "") {
                                for (i = 0; i < modPilih[row].length; i++) {
                                    var tg_id = modPilih[row][i].indikatorimplkepdet_id;
                                    if (tg_id !== 'undefined') {
                                        var x = tg_id.split(',');
                                        for (j = 0; j < x.length; j++) {
                                            console.log(x[j]);
                                            if ($(this).val() == x[j]) {
                                                $(this).attr("checked", "checked");
                                            }
                                        }
                                    }
                                }
                            }
                            
                            $(this).attr('readonly', 'readonly');
                            
                            row2++;
                        });
                    });
                });
                row++;
            });
        }

    function renameInputRow(obj_table) {

        //====button visibility
        //init
        $(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().show();
        $(obj_table).find('tr td.rowbutton .icon-minus-sign').parent().show();
        //set
        $(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().hide();
        $(obj_table).find('tr:last-child td.rowbutton .icon-plus-sign').parent().show();
        var rowCount = $(obj_table).find('tbody tr').length;
        if (rowCount == 1) {
            $(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().hide();
            $(obj_table).find('tr:first-child td.rowbutton .icon-plus-sign').parent().show();
            id = $(obj_table).find('tr:first-child input[name*="[datapenunjang_id]"]').val();
//			if (id != "") {
//				$(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().show();
//			}
        }
        //====end button visibility

    }

    function renameInputRowKriteriaSimpan(obj_table, modPilih) {
        var row = 0;
        $(obj_table).find("tbody > .rencanaaskepdet").each(function () {
            var row2 = 0;
            $(this).find('.kriteria').find("tbody > tr").each(function () {
                $(this).find('span').each(function () { //element <input>
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 3) {
                        $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]" + "[" + row2 + "]");
                    }
                });
                $(this).find('input[name$="[rencanaaskep_ir]"]').each(function () { //element <input>
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 3) {
                        $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
                        $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]" + "[" + row2 + "]");
                    }

                });
                $(this).find('input[name$="[rencanaaskep_er]"]').each(function () { //element <input>
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 3) {
                        $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
                        $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]" + "[" + row2 + "]");
                    }

                });
                $(this).find('input[name$="[kriteriahasildet_id]"]').each(function () { //element <input>
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 3) {
                        $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
                        $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]" + "[" + row2 + "]");
                    }

                    for (i = 0; i < modPilih[row].length; i++) {
                        var tg_id = modPilih[row][i].kriteriahasildet_id;
                        var ir = modPilih[row][i].rencanaaskep_ir;
                        var er = modPilih[row][i].rencanaaskep_er;
                        if (tg_id !== 'undefined') {
                            if ($(this).val() == tg_id) {
                                $(this).attr("checked", "checked");
                                $(this).parents('tr').find('input[name$="[' + row + '][rencanaaskep_ir][' + row2 + ']"]').val(ir);
                                $(this).parents('tr').find('input[name$="[' + row + '][rencanaaskep_er][' + row2 + ']"]').val(er);
                            }
                        }

                    }

                });
                row2++;
            });
            row++;
        });
        //====button visibility
        //init
        $(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().hide();
        $(obj_table).find('tr td.rowbutton .icon-minus-sign').parent().hide();
        //set
        $(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().hide();
        $(obj_table).find('tr:last-child td.rowbutton .icon-plus-sign').parent().hide();
        var rowCount = $(obj_table).find('tbody tr').length;
        if (rowCount == 1) {
            $(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().hide();
            $(obj_table).find('tr:first-child td.rowbutton .icon-plus-sign').parent().hide();
            id = $(obj_table).find('tr:first-child input[name*="[rencanaaskepdet_id]"]').val();
            if (id != "") {
                $(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().hide();
            }
        }
        //====end button visibility

    }

    function renameInputRowKriteria(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > .rencanaaskepdet").each(function () {
            var row2 = 0;
            $(this).find('.kriteria').find("tbody > tr").each(function () {
                $(this).find('span').each(function () { //element <input>
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 3) {
                        $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]" + "[" + row2 + "]");
                    }
                });
                $(this).find('input,select,textarea').each(function () { //element <input>
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 3) {
                        $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
                        $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]" + "[" + row2 + "]");
                    }
                });
                row2++;
            });
            row++;
        });
        //====button visibility
        //init
        $(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().show();
        $(obj_table).find('tr td.rowbutton .icon-minus-sign').parent().show();
        //set
        $(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().hide();
        $(obj_table).find('tr:last-child td.rowbutton .icon-plus-sign').parent().show();
        var rowCount = $(obj_table).find('tbody > tr').length;
        if (rowCount == 1) {
            $(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().hide();
            $(obj_table).find('tr:first-child td.rowbutton .icon-plus-sign').parent().show();
            id = $(obj_table).find('tr:first-child input[name*="[diagnosakep_id]"]').val();
            if (id != "") {
                $(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().show();
            }
        }
        //====end button visibility

    }

    function loadDetail(rencanaaskep_id) {
        $("#table-rencana").addClass("animation-loading");
        $('#table-rencana > tbody').html("");
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetPenunjang'); ?>',
            data: {rencanaaskep_id: rencanaaskep_id}, //
            dataType: "json",
            success: function (data) {
                $('#table-rencana > tbody').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                $(".integer").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
                $("#table-rencana").removeClass("animation-loading");
                renameInputRow($("#rencana-penunjang"));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    function setDialog(obj) {
        parent = $(obj).parents(".input-append").find("input").attr("id");
        dialog = "#dialogDiagnosa";
        $(dialog).attr("parent-dialog", parent);
        $(dialog).dialog("open");
    }

    function setDiagnosaAuto(diagnosakep_id) {

        var diagnosakep_id = diagnosakep_id;
        dialog = "#dialogDiagnosa";
        /*
         if(idDlg != null)
         {
         dialog = idDlg;
         }
         */
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);
        check = true;
        $('#table-rencana').find("tbody > .rencanaaskepdet").each(function () {
            var val = $(this).find('input[name$="[diagnosakep_id]"]').val(); //element <input>
            console.log(val);
            console.log(diagnosakep_id);
            if (val == diagnosakep_id) {
                check = false;
                myAlert('Diagnosa sudah dipilih!');
                return false;
            }
        });
        if (check) {
            $.get('<?php echo Yii::app()->createUrl('asuhanKeperawatan/RencanaKeperawatan/getDiagnosa'); ?>', {diagnosakep_id: diagnosakep_id}, function (data) {
                $(obj).val(data[0].diagnosakep_id);
                $(obj).val(data[0].diagnosakep_nama);
                setDiagnosa(obj, data[0]);
            }, "json");
            $(dialog).dialog("close");
        }
    }

    function setDiagnosa(obj, item)
    {
        $(obj).parents('tr').find('input[name$="[diagnosakep_id]"]').val(item.diagnosakep_id);
        $(obj).parents('tr').find('input[name$="[diagnosakep_nama]"]').val(item.diagnosakep_nama);
        setDiagnosaRow(obj, item.diagnosakep_id);
        setTandaGejala(obj, item.diagnosakep_id);
        setTujuan(obj, item.diagnosakep_id);
        setKriteriaHasil(obj, item.diagnosakep_id);
        setIntervensi(obj, item.diagnosakep_id);
    }

    function setDiagnosaRow(obj, diagnosakep_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetDiagnosaRow'); ?>',
            data: {diagnosakep_id: diagnosakep_id}, //
            dataType: "json",
            success: function (data) {
                console.log($(obj).parents('tr').find('.diagdetail'));
                $(obj).parents('tr').find('.diagdetail').html("");
                $(obj).parents('tr').find('.diagdetail').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                $(".integer").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
                $("#table-rencana").removeClass("animation-loading");
                renameInputDiagDetail('#table-rencana');
                renameInputRow('#table-rencana');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setTandaGejala(obj, diagnosakep_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetTandaGejala'); ?>',
            data: {diagnosakep_id: diagnosakep_id}, //
            dataType: "json",
            success: function (data) {
                $(obj).parents('tr').find('.tandagejala').html("");
                $(obj).parents('tr').find('.tandagejala').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                $(".integer").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
                $("#table-rencana").removeClass("animation-loading");
                renameInputTandaGejala('#table-rencana');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setTujuan(obj, diagnosakep_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetTujuan'); ?>',
            data: {diagnosakep_id: diagnosakep_id}, //
            dataType: "json",
            success: function (data) {
                $(obj).parents('tr').find('.tujuan').html("");
                $(obj).parents('tr').find('.tujuan').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                $(".integer").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
                $("#table-rencana").removeClass("animation-loading");
                renameInput('ASRencanaaskepdetT', 'rencanaaskepdet_hari');
                renameInput('ASRencanaaskepdetT', 'rencanaaskepdet_estimasiwaktu');
                renameInput('ASRencanaaskepdetT', 'tujuan_id');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setKriteriaHasil(obj, diagnosakep_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetKriteriaHasil'); ?>',
            data: {diagnosakep_id: diagnosakep_id}, //
            dataType: "json",
            success: function (data) {
                $(obj).parents('tr').find('.kriteriahasil').html("");
                $(obj).parents('tr').find('.kriteriahasil').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                $("#table-rencana").removeClass("animation-loading");
                renameInput('ASRencanaaskepdetT', 'kriteriahasil_id');
                renameInput('ASRencanaaskepdetT', 'kriteriahasil_nama');
                renameInputRowKriteria('#table-rencana');
                $(".integer").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setIntervensi(obj, diagnosakep_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetIntervensi'); ?>',
            data: {diagnosakep_id: diagnosakep_id}, //
            dataType: "json",
            success: function (data) {
                $(obj).parents('tr').find('.intervensi').html("");
                $(obj).parents('tr').find('.intervensi').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                $(".integer").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
                $("#table-rencana").removeClass("animation-loading");
                renameInputIntervensi('#table-rencana');
                renameInput('ASRencanaaskepdetT', 'intervensi_id');
                renameInput('ASRencanaaskepdetT', 'intervensi_nama');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function isKolaborasi() {
        var obj = $('#table-rencana > tbody > tr').find('input[name$="[iskolaborasi]"]');
        if ($(obj).is(':checked')) {
            $(obj).val(1);
        } else {
            $(obj).val(0);
        }
    }

    function isKeperawatan() {
        var obj = $("#iskeperawatan");
        if ($(obj).is(':checked')) {
            $(obj).val(1);
            $(".keperawatan").hide();
            $(".kebidanan").show();
        } else {
            $(obj).val(0);
            $(".keperawatan").show();
            $(".kebidanan").hide();
        }
    }

    function cekListKebidanan(obj) {
        if ($(obj).is(':checked')) {
            $(obj).val(1);
            $(".keperawatan").hide();
            $(".kebidanan").show();
        } else {
            $(obj).val(0);
            $(".keperawatan").show();
            $(".kebidanan").hide();
        }
    }

    function cekListKolaborasi(obj) {
        if ($(obj).is(':checked')) {
            $(obj).val(1);
            $(obj).parents('tr').find('textarea[name$="[rencanaaskepdet_ketkolaborasi]"]').removeAttr('readonly');
        } else {
            $(obj).val(0);
            $(obj).parents('tr').find('textarea[name$="[rencanaaskepdet_ketkolaborasi]"]').attr('readonly', true);
        }
    }

    function loadRencanaDet(rencanaaskep_id) {
        $("#table-rencana").addClass("animation-loading");
        $('#table-rencana > tbody').html("");
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetRencanaDet'); ?>',
            data: {rencanaaskep_id: rencanaaskep_id}, //
            dataType: "json",
            success: function (data) {
                $('#table-rencana > tbody').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                $(".integer").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
                $("#table-rencana").removeClass("animation-loading");
//				renameInputRow($("#table-rencana"));
                renameInputDiagDetailSimpan('#table-rencana', data.modPilih);
                renameInputTandaGejalaSimpan('#table-rencana', data.modPilih);
                renameInputRowKriteriaSimpan('#table-rencana', data.modPilih);
                renameInputIntervensiSimpan('#table-rencana', data.modPilih);
                renameInputImplementasiSimpan('#table-rencana', data.modPilih);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
        
    $(document).ready(function () {
        isKeperawatan();
        isKolaborasi();
        renameInputRow('#table-rencana');
//        cekDisabled($('#pembayaran-form'));
//        $('form').bind('click keyup select change', function (event) {
//            cekDisabled(this);
//        });
//        $(document).on('click keyup select change', '.ui-dialog-content', function () {
//            cekDisabled('form');
//        });
    });
</script>

<?php if (!empty($_GET['diagnosisaskep_id'])) { ?>
    <script>
        $(document).ready(function () {
            cekDiagnosis2('<?php echo $_GET['diagnosisaskep_id']; ?>');
        });
    </script>                  
<?php } ?>

<?php if (!empty($_GET['rencanaaskep_id'])) { ?>
    <?php $cekDiagnosa = RencanaaskepT::model()->findByPk($_GET['rencanaaskep_id']); ?>
    <script>
        $(document).ready(function () {
            var id_diagnosa = <?php echo!empty($cekDiagnosa->diagnosisaskep_id) ? $cekDiagnosa->diagnosisaskep_id : null; ?>;
            cekDiagnosis2(id_diagnosa);
        });
    </script>                  
<?php } ?>