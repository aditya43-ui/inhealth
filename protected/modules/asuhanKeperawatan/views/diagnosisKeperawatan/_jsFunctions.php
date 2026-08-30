<script type="text/javascript">
    function resetDiagnosa(obj){
        let el = $(obj).parents('tr');
        el.find('.diagnosisaskep_id').val('')
        el.find('.diagdetail').html('')
    }
    /**
     * Set data ketika memilih tanda gejala
     * @param {type} obj
     * @returns {undefined}
     */
    function setData(obj){
        var tandagejala = $(obj).parents('tr').find('.pilihdata_tandagejala');
        if (tandagejala.is(" :checked")) {
            $(obj).parents('tr').find('.pilihdata_faktorrisiko').prop('checked',false);
            $(obj).parents('tr').find('.pilihdata_tandagejala').prop('checked',true);
            $(obj).parents('tr').find('.tandagejala').show();
            $(obj).parents('tr').find('.faktorrisiko').hide();
            $(obj).parents('tr').find('.kel-risiko > tbody').html(""); 
            $(obj).parents('tr').find('.diagdetail').html("");
            $(obj).parents('tr').find('.diagnosakep_nama').val("");
            $(obj).parents('tr').find('.diagnosisaskep_id').val("");
        }
        
         $.fn.yiiGridView.update('diagnosakep-m-grid', {
            data: {
                "ASDiagnosakepM[default]":'kosong',		
            }
        });
    }
    
    /**
     * Set data ketika memilih faktor risiko
     * @param {type} obj
     * @returns {undefined}
     */
    function setData2(obj){
        var faktorrisiko = $(obj).parents('tr').find('.pilihdata_faktorrisiko');
        if (faktorrisiko.is(" :checked")) {
            $(obj).parents('tr').find('.pilihdata_faktorrisiko').prop('checked',true);
            $(obj).parents('tr').find('.pilihdata_tandagejala').prop('checked',false);
            $(obj).parents('tr').find('.tandagejala').hide();
            $(obj).parents('tr').find('.faktorrisiko').show();
            $(obj).parents('tr').find('.minor-subjektif > tbody').html(""); 
            $(obj).parents('tr').find('.minor-objektif > tbody').html(""); 
            $(obj).parents('tr').find('.mayor-subjektif > tbody').html(""); 
            $(obj).parents('tr').find('.mayor-objektif > tbody').html(""); 
            $(obj).parents('tr').find('.diagdetail').html("");
            $(obj).parents('tr').find('.diagnosakep_nama').val("");
            $(obj).parents('tr').find('.diagnosisaskep_id').val("");
        }
    }
    
//  Tanda Gejala
    var is_checked1 = {};
    var is_checked2 = {};
    var is_checked3 = {};
    var is_checked4 = {};

    /**
     * Cek jika tidak ada data yang dipilih
     * @param {type} obj
     * @returns {Boolean}
     */
    function isEmpty(obj) {
        for (var key in obj) {
            if (obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }
    
    /**
     * Set tanda gejala (mayor objektif)
     * @param {type} obj
     * @returns {undefined}
     */
    function setTandaGejalanya1(obj) {
        var tandagejala = $(obj).attr('kelompoktandagejaladaftar_id');
        
        if ($(obj).prop("checked") == true) {
            is_checked1[tandagejala] = tandagejala;
        } else {
            is_checked1[tandagejala] = 0;
        }
    }
    
    /**
     * Set tanda gejala (mayor subjektif)
     * @param {type} obj
     * @returns {undefined}
     */
    function setTandaGejalanya2(obj) {
        var tandagejala = $(obj).attr('kelompoktandagejaladaftar_id');
        
        if ($(obj).prop("checked") == true) {
            is_checked2[tandagejala] = tandagejala;
        } else {
            is_checked2[tandagejala] = 0;
        }
    }
    
    /**
     * Set tanda gejala (minor objektif)
     * @param {type} obj
     * @returns {undefined}
     */
    function setTandaGejalanya3(obj) {
        var tandagejala = $(obj).attr('kelompoktandagejaladaftar_id');
        
        if ($(obj).prop("checked") == true) {
            is_checked3[tandagejala] = tandagejala;
        } else {
            is_checked3[tandagejala] = 0;
        }
    }
    
    /**
     * Set tanda gejala (minor subjektif)
     * @param {type} obj
     * @returns {undefined}
     */
    function setTandaGejalanya4(obj) {
        var tandagejala = $(obj).attr('kelompoktandagejaladaftar_id');
        
        if ($(obj).prop("checked") == true) {
            is_checked4[tandagejala] = tandagejala;
        } else {
            is_checked4[tandagejala] = 0;
        }
    }

    /**
     * Set ceklis semua checkbox
     * @param {type} obj
     * @returns {undefined}
     */
    function setSemuaCeklis(obj) {
        if ($(obj).prop("checked") == true) {
            $("input:checkbox.pilih").each(function () {
                $(this).prop("checked", true).change();
            });
        } else {
            $("input:checkbox.pilih").each(function () {
                $(this).prop("checked", false).change();
            });
        }

    }

    /**
     * Input tanda gejala 4
     * @returns {Boolean}   
     */
    function inputTandaGejalaMinorSubjektif() {
        var tandadangejala = is_checked4;
        if (isEmpty(tandadangejala)) {
            myAlert('Tanda dan Gejala belum dipilih');
            return false;
        } else {
            cekListGejalaMinorSubjektif(tandadangejala);
        }
    }

    /**
     * Set ceklis ke dalam tabel
     * @type Arguments
     */
    function cekListGejalaMinorSubjektif(id) {
        x = true;

        if (x == true) {
            tambahGejalaMinorSubjektif(is_checked4);
            $("#dialogTandaGejalaMinorSubjektif").dialog("close");
            return x;
        }
        return false;
    }

    /**
     * Fungsi append data yang terceklis ke dalam baris
     * @type Arguments
     */
    function tambahGejalaMinorSubjektif(kelompoktandagejaladaftar_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetTandaGejalaMinorSubjektif'); ?>',
            data: {kelompoktandagejaladaftar_id: kelompoktandagejaladaftar_id},
            dataType: "json",
            success: function (data) {
                parent = $(dialog).attr("parent-dialog");
                obj = $("#" + parent);
                
                $(obj).parents('tr').find('.tandagejaladetail').each(function () {
                    $(this).find('.minor-subjektif > tbody > tr').remove(); 
                    $(this).find('.minor-subjektif > tbody').append(data.tabel);
                    $(this).find('.minor-subjektif').removeClass("animation-loading");
                });
                $(obj).parents('tr').find('.tandagejala_indikator_minorsubjektif').val('');
                setDiagnosaKeperawatan(obj);
                renameInputRows();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /**
     * Input tanda gejala 1
     * @returns {Boolean}   
     */
    function inputTandaGejalaMayorObjektif() {
        var tandadangejala = is_checked1;
        if (isEmpty(tandadangejala)) {
            myAlert('Tanda dan Gejala belum dipilih');
            return false;
        } else {
            cekListGejalaMayorObjektif(tandadangejala);
        }
    }

    /**
     * Set ceklis ke dalam tabel
     * @type Arguments
     */
    function cekListGejalaMayorObjektif(id) {
        x = true;

        if (x == true) {
            tambahGejalaMayorObjektif(is_checked1);
            $("#dialogTandaGejalaMayorObjektif").dialog("close");
            return x;
        }
        return false;
    }

    /**
     * Fungsi append data yang terceklis ke dalam baris
     * @type Arguments
     */
    function tambahGejalaMayorObjektif(kelompoktandagejaladaftar_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetTandaGejalaMayorObjektif'); ?>',
            data: {kelompoktandagejaladaftar_id: kelompoktandagejaladaftar_id},
            dataType: "json",
            success: function (data) {
                parent = $(dialog).attr("parent-dialog");
                obj = $("#" + parent);
                
                $(obj).parents('tr').find('.tandagejaladetail').each(function () {
                    $(this).find('.mayor-objektif > tbody > tr').remove(); 
                    $(this).find('.mayor-objektif > tbody').append(data.tabel);
                    $(this).find('.mayor-objektif').removeClass("animation-loading");
                });
                $(obj).parents('tr').find('.tandagejala_indikator_mayorobjektif').val('');
                setDiagnosaKeperawatan(obj);
                renameInputRows();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /**
     * Input tanda gejala 2
     * @returns {Boolean}   
     */
    function inputTandaGejalaMayorSubjektif() {
        var tandadangejala = is_checked2;
        if (isEmpty(tandadangejala)) {
            myAlert('Tanda dan Gejala belum dipilih');
            return false;
        } else {
            cekListGejalaMayorSubjektif(tandadangejala);
        }
    }

    /**
     * Set ceklis ke dalam tabel
     * @type Arguments
     */
    function cekListGejalaMayorSubjektif(id) {
        x = true;

        if (x == true) {
            tambahGejalaMayorSubjektif(is_checked2);
            $("#dialogTandaGejalaMayorSubjektif").dialog("close");
            return x;
        }
        return false;
    }

    /**
     * Fungsi append data yang terceklis ke dalam baris
     * @type Arguments
     */
    function tambahGejalaMayorSubjektif(kelompoktandagejaladaftar_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetTandaGejalaMayorSubjektif'); ?>',
            data: {kelompoktandagejaladaftar_id: kelompoktandagejaladaftar_id},
            dataType: "json",
            success: function (data) {
                parent = $(dialog).attr("parent-dialog");
                obj = $("#" + parent);
                
                $(obj).parents('tr').find('.tandagejaladetail').each(function () {
                    $(this).find('.mayor-subjektif > tbody > tr').remove(); 
                    $(this).find('.mayor-subjektif > tbody').append(data.tabel);
                    $(this).find('.mayor-subjektif').removeClass("animation-loading");
                });
                $(obj).parents('tr').find('.tandagejala_indikator_mayorsubjektif').val('');
                setDiagnosaKeperawatan(obj);
                renameInputRows();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /**
     * Input tanda gejala 3
     * @returns {Boolean}   
     */
    function inputTandaGejalaMinorObjektif() {
        var tandadangejala = is_checked3;
        if (isEmpty(tandadangejala)) {
            myAlert('Tanda dan Gejala belum dipilih');
            return false;
        } else {
            cekListGejalaMinorObjektif(tandadangejala);
        }
    }

    /**
     * Set ceklis ke dalam tabel
     * @type Arguments
     */
    function cekListGejalaMinorObjektif(id) {
        x = true;

        if (x == true) {
            tambahGejalaMinorObjektif(is_checked3);
            $("#dialogTandaGejalaMinorObjektif").dialog("close");
            return x;
        }
        return false;
    }

    /**
     * Fungsi append data yang terceklis ke dalam baris
     * @type Arguments
     */
    function tambahGejalaMinorObjektif(kelompoktandagejaladaftar_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetTandaGejalaMinorObjektif'); ?>',
            data: {kelompoktandagejaladaftar_id: kelompoktandagejaladaftar_id},
            dataType: "json",
            success: function (data) {
                parent = $(dialog).attr("parent-dialog");
                obj = $("#" + parent);
                
                $(obj).parents('tr').find('.tandagejaladetail').each(function () {
                    $(this).find('.minor-objektif > tbody > tr').remove(); 
                    $(this).find('.minor-objektif > tbody').append(data.tabel);
                    $(this).find('.minor-objektif').removeClass("animation-loading");
                });
                $(obj).parents('tr').find('.tandagejala_indikator_minorobjektif').val('');
                setDiagnosaKeperawatan(obj);
                renameInputRows();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

//  Faktor Risiko
    var is_checked5 = {};
    
    /**
     * Set unceklis di baris berikutnya
     * @param {type} obj
     * @returns {undefined}     
     **/
    function setFaktorRisikonya(obj) {
        var faktorrisiko = $(obj).attr('kelompokfaktorrisikodaftar_id');
        
        if ($(obj).prop("checked") == true) {
            is_checked5[faktorrisiko] = faktorrisiko;
        } else {
            is_checked5[faktorrisiko] = 0;
        }
    }
    
    /**
     * input faktor risiko
     * @returns {Boolean}     
     **/
    function inputFaktorRisiko() {
        var faktordanrisiko = is_checked5;
        if (isEmpty(faktordanrisiko)) {
            myAlert('Faktor Risiko belum dipilih');
            return false;
        } else {
            cekListRisiko(faktordanrisiko);
        }
    }
    
    /**
     * Set ceklis ke dalam tabel
     * @type Arguments   
     **/
    function cekListRisiko(id) {
        x = true;

        if (x == true) {
            tambahRisiko(is_checked5);
            $("#dialogFaktorRisiko").dialog("close");
            return x;
        }
        return false;
    }

    /**
     * Fungsi append data yang terceklis ke dalam baris
     * @type Arguments
     */
    function tambahRisiko(kelompokfaktorrisikodaftar_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetFaktorRisikonya'); ?>',
            data: {kelompokfaktorrisikodaftar_id: kelompokfaktorrisikodaftar_id},
            dataType: "json",
            success: function (data) {
                parent = $(dialog).attr("parent-dialog");
                obj = $("#" + parent);
                
                $(obj).parents('tr').find('.faktorrisikodetail').each(function () {
                    $(this).find('.kel-risiko > tbody > tr').remove(); 
                    $(this).find('.kel-risiko > tbody').append(data.tabel);
                    $(this).find('.kel-risiko').removeClass("animation-loading");
                });
                $(obj).parents('tr').find('.faktorrisikodet_indikator').val('');
                setDiagnosaKeperawatan(obj);
                renameInputRows();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
//  Diagnosa Keperawatan
    /**
     * Cek data pengjakian yang dipilih sudah pernah di transaksikan atau belum
     * @param {type} pengkajianaskep_id
     * @returns {undefined}     
     **/
    function cekPengkajianId(pengkajianaskep_id) {
        if (pengkajianaskep_id !== undefined) {
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('cekPengkajianId'); ?>',
                data: {pengkajianaskep_id: pengkajianaskep_id},
                dataType: "json",
                success: function (data) {

//                    if (data != null) {
//                        myAlert("Pengkajian sudah dipilih!");
//                        return false;
//                    } else {

                        loadPasien(pengkajianaskep_id);
                        return true;
//                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    /**
     * Lihat detail
     * @param {type} obj
     * @returns {Boolean}     */
    function cekPengkajian(obj) {
        var pengkajianaskep_id = $("#<?php echo CHtml::activeId($modPengkajian, 'pengkajianaskep_id') ?>").val();
        var iskeperawatan = $("#iskeperawatan").val();
        if (pengkajianaskep_id == '') {
            myAlert("Silakan Pilih Pengkajian!");
        } else {
            if (iskeperawatan == 1) {
                window.open("<?php echo Yii::app()->controller->createUrl("/asuhanKeperawatan/DiagnosisKeperawatan/DetailPengkajianKeb"); ?>/&pengkajianaskep_id=" + pengkajianaskep_id, "", 'location=_new, width=900px, scrollbars=1');
            }
            if (iskeperawatan == 0) {
                window.open("<?php echo Yii::app()->controller->createUrl("/asuhanKeperawatan/DiagnosisKeperawatan/DetailPengkajian"); ?>/&pengkajianaskep_id=" + pengkajianaskep_id, "", 'location=_new, width=900px, scrollbars=1');
            }
        }
        return false;
    }

    /**
     * Load data pasien
     * @param {type} pengkajianaskep_id
     * @returns {undefined} 
     **/
    function loadPasien(pengkajianaskep_id)
    {
        var iskeperawatan = $('#iskeperawatan').val();
        if (pengkajianaskep_id !== undefined) {
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('loadPasien'); ?>',
                data: {pengkajianaskep_id: pengkajianaskep_id, iskeperawatan: iskeperawatan},
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    if (data !== '') {
                        console.log("fsfsfs:" + data);
                        $("#<?php echo CHtml::activeId($modPengkajian, 'pengkajianaskep_id') ?>").val(data.data.pengkajianaskep_id);
                        if (data.iskeperawatan == 1) {
                            $("#<?php echo CHtml::activeId($modPengkajian, 'no_pengkajian') ?>").val(data.data.no_pengkajian);
                        } else {
                            $("#<?php echo CHtml::activeId($modPengkajian, 'no_pengkajian_keb') ?>").val(data.data.no_pengkajian);
                        }
                        $("#<?php echo CHtml::activeId($modPengkajian, 'pengkajianaskep_tgl') ?>").val(data.data.pengkajianaskep_tgl);
                        $("#<?php echo CHtml::activeId($modPengkajian, 'pegawai_id') ?>").val(data.data.pegawai_id);
                        $("#<?php echo CHtml::activeId($modPengkajian, 'nama_pegawai') ?>").val(data.data.nama_pegawai);

                        $('#<?php echo CHtml::activeId($modPasien, 'no_pendaftaran') ?>').val(data.data.no_pendaftaran);
                        $('#<?php echo CHtml::activeId($modPasien, 'nama_pasien') ?>').val(data.data.nama_pasien);
                        $('#<?php echo CHtml::activeId($modPasien, 'ruangan_nama') ?>').val(data.data.ruangan_nama);
                        $('#<?php echo CHtml::activeId($modPasien, 'tgl_pendaftaran') ?>').val(data.data.tgl_pendaftaran);
                        $('#<?php echo CHtml::activeId($modPasien, 'umur') ?>').val(data.data.umur);
                        $('#<?php echo CHtml::activeId($modPasien, 'kelaspelayanan_nama') ?>').val(data.data.kelaspelayanan_nama);
                        $('#<?php echo CHtml::activeId($modPasien, 'no_rekam_medik') ?>').val(data.data.no_rekam_medik);
                        $('#<?php echo CHtml::activeId($modPasien, 'diagnosa_nama') ?>').val(data.diagnosa);
                        $('#<?php echo CHtml::activeId($modPasien, 'no_kamarbed') ?>').val(((data.data.kamarruangan_nokamar !== null) ? data.data.kamarruangan_nokamar : '-') + ' / ' + ((data.data.kamarruangan_nobed !== null) ? data.data.kamarruangan_nobed : '-'));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    /**
     * Load diagnosa medis
     * @param {type} pasien_id
     * @param {type} pendaftaran_id
     * @returns {undefined} 
     **/
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

    var trTindakan = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowDiagnosisDetail', array('modDetail' => $modDetail), true)); ?>);
    var trTindakanFirst = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowDiagnosisDetail', array('modDetail' => $modDetail), true)); ?>);
    
    /**
     * Tambah baris data
     * @param {type} obj
     * @returns {undefined}
     */
    function addRowTindakan(obj)
    {
        $(obj).parents('table').children('tbody').append(trTindakan.replace());
<?php
$attributes = $modDetail->attributeNames();
foreach ($attributes as $i => $attribute) {
    echo "renameInput('ASDiagnosisaskepdetT','$attribute');";
}
?>
        renameInput('ASDiagnosisaskepdetT', 'diagnosakep_nama');
        renameInput('ASDiagnosisaskepdetT', 'diagnosakep_id');
        renameInput('ASDiagnosisaskepdetT', 'faktorrisikodet_indikator');
        renameInput('ASDiagnosisaskepdetT', 'tandagejala_indikator');
        renameInput('ASDiagnosisaskepdetT', 'tandagejala_indikator_mayorobjektif');
        renameInput('ASDiagnosisaskepdetT', 'tandagejala_indikator_mayorsubjektif');
        renameInput('ASDiagnosisaskepdetT', 'tandagejala_indikator_minorobjektif');
        renameInput('ASDiagnosisaskepdetT', 'tandagejala_indikator_minorsubjektif');
        renameInput('ASDiagnosisaskepdetT', 'pilih_data_tandagejala');
        renameInput('ASDiagnosisaskepdetT', 'pilih_data_faktorrisiko');
        renameInput('ASPilihdiagnosisaskepT', 'faktorrisiko_id');
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

    /**
     * Fungsi batal tindakan
     * @param {type} obj
     * @returns {undefined}     
     **/
    function batalTindakan(obj)
    {
        myConfirm("Apakah Anda yakin akan membatalkan diagnosa?", "Perhatian!", function (r) {
            if (r) {
                $(obj).parents('tr').detach();
<?php
foreach ($attributes as $i => $attribute) {
    echo "renameInput('ASDiagnosisaskepdetT','$attribute');";
}
?>
                renameInput('ASDiagnosisaskepdetT', 'diagnosakep_nama');
                renameInput('ASDiagnosisaskepdetT', 'diagnosakep_id');
                renameInput('ASDiagnosisaskepdetT', 'faktorrisikodet_indikator');
                renameInput('ASDiagnosisaskepdetT', 'tandagejala_indikator');
                renameInput('ASDiagnosisaskepdetT', 'tandagejala_indikator_mayorobjektif');
                renameInput('ASDiagnosisaskepdetT', 'tandagejala_indikator_mayorsubjektif');
                renameInput('ASDiagnosisaskepdetT', 'tandagejala_indikator_minorobjektif');
                renameInput('ASDiagnosisaskepdetT', 'tandagejala_indikator_minorsubjektif');
                renameInput('ASDiagnosisaskepdetT', 'pilih_data_tandagejala');
                renameInput('ASDiagnosisaskepdetT', 'pilih_data_faktorrisiko');
                renameInput('ASPilihdiagnosisaskepT', 'faktorrisiko_id');
            }
        });
    }

    /**
     * hapus tindakan
     * @param {type} obj
     * @param {type} idTindakanpelayanan
     * @returns {undefined}     
     **/
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
        var trLength = $('#table-diagnosis tr').length;
        var i = -1;
        $('#table-diagnosis tr').each(function () {
            if ($(this).has('input[name$="[diagnosisaskep_id]"]').length) {
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
        var trLength = $('#table-diagnosis tr').length;
        var i = -1;
        $('#table-diagnosis tr').each(function () {
            if ($(this).has('input[name$="[diagnosisaskep_id]"]').length) {
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
    
    /**
     * Rename input perbaris
     * @returns {undefined}     
     **/
    function renameInputRows()
    {
        var trLength = $('#table-diagnosis tr').length;
        var i = -1;
        var j = -1;
        $('#table-diagnosis tr').each(function () {
            if ($(this).has('input[name$="[diagnosisaskep_id]"]').length) {
                i++;
                j++;
            }
            
            var row = 0;
            $(this).find("#table-faktorrisiko > tbody > tr").each(function () {
                $(this).find('.kelompokfaktorrisikodaftar_idnya').each(function () { //element <input>
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");

                    if (old_name_arr.length == 3) {
                        $(this).attr("id", old_name_arr[0] + "_" + i + "_" + old_name_arr[2]);
                        $(this).attr("name", old_name_arr[0] + "[" + i + "][" + old_name_arr[2] + "]");
                    }
                    if (old_name_arr.length == 4) {

                        $(this).attr("id", old_name_arr[0] + "_" + i + "_" + old_name_arr[2] + "_" + row);
                        $(this).attr("name", old_name_arr[0] + "[" + i + "][" + old_name_arr[2] + "][" + row + "]");
                    }
                });
                
                $(this).find(".kel-risiko > tbody > tr").each(function () {
                    $(this).find('.kelompokfaktorrisikodaftar_idnya').each(function () { //element <input>
                        var old_name = $(this).attr("name").replace(/]/g, "");
                        var old_name_arr = old_name.split("[");

                        if (old_name_arr.length == 3) {
                            $(this).attr("id", old_name_arr[0] + "_" + j + "_" + old_name_arr[2]);
                            $(this).attr("name", old_name_arr[0] + "[" + j + "][" + old_name_arr[2] + "]");
                        }
                        if (old_name_arr.length == 4) {
                            $(this).attr("id", old_name_arr[0] + "_" + j + "_" + old_name_arr[2] + "_" + row);
                            $(this).attr("name", old_name_arr[0] + "[" + j + "][" + old_name_arr[2] + "][" + row + "]");
                        }
                    });
                });
                row++;
            });
               
            var row2 = 0;
            $(this).find("#table-tandagejala > tbody > tr").each(function () {
                $(this).find('.kelompoktandagejaladaftar_idnya').each(function () { //element <input>
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");

                    if (old_name_arr.length == 3) {
                        $(this).attr("id", old_name_arr[0] + "_" + j + "_" + old_name_arr[2]);
                        $(this).attr("name", old_name_arr[0] + "[" + j + "][" + old_name_arr[2] + "]");
                    }
                    if (old_name_arr.length == 4) {

                        $(this).attr("id", old_name_arr[0] + "_" + j + "_" + old_name_arr[2] + "_" + row2);
                        $(this).attr("name", old_name_arr[0] + "[" + j + "][" + old_name_arr[2] + "][" + row2 + "]");
                    }
                });
                
                $(this).find(".mayor-objektif > tbody > tr").each(function () {
                    $(this).find('.kelompoktandagejaladaftar_idnya').each(function () { //element <input>
                        var old_name = $(this).attr("name").replace(/]/g, "");
                        var old_name_arr = old_name.split("[");

                        if (old_name_arr.length == 3) {
                            $(this).attr("id", old_name_arr[0] + "_" + j + "_" + old_name_arr[2]);
                            $(this).attr("name", old_name_arr[0] + "[" + j + "][" + old_name_arr[2] + "]");
                        }
                        if (old_name_arr.length == 4) {
                            $(this).attr("id", old_name_arr[0] + "_" + j + "_" + old_name_arr[2] + "_" + row2);
                            $(this).attr("name", old_name_arr[0] + "[" + j + "][" + old_name_arr[2] + "][" + row2 + "]");
                        }
                    });
                });
                
                $(this).find(".minor-objektif > tbody > tr").each(function () {
                    $(this).find('.kelompoktandagejaladaftar_idnya').each(function () { //element <input>
                        var old_name = $(this).attr("name").replace(/]/g, "");
                        var old_name_arr = old_name.split("[");

                        if (old_name_arr.length == 3) {
                            $(this).attr("id", old_name_arr[0] + "_" + j + "_" + old_name_arr[2]);
                            $(this).attr("name", old_name_arr[0] + "[" + j + "][" + old_name_arr[2] + "]");
                        }
                        if (old_name_arr.length == 4) {
                            $(this).attr("id", old_name_arr[0] + "_" + j + "_" + old_name_arr[2] + "_" + row2);
                            $(this).attr("name", old_name_arr[0] + "[" + j + "][" + old_name_arr[2] + "][" + row2 + "]");
                        }
                    });
                });

                $(this).find(".mayor-subjektif > tbody > tr").each(function () {
                    $(this).find('.kelompoktandagejaladaftar_idnya').each(function () { //element <input>
                        var old_name = $(this).attr("name").replace(/]/g, "");
                        var old_name_arr = old_name.split("[");

                        if (old_name_arr.length == 3) {
                            $(this).attr("id", old_name_arr[0] + "_" + j + "_" + old_name_arr[2]);
                            $(this).attr("name", old_name_arr[0] + "[" + j + "][" + old_name_arr[2] + "]");
                        }
                        if (old_name_arr.length == 4) {
                            $(this).attr("id", old_name_arr[0] + "_" + j + "_" + old_name_arr[2] + "_" + row2);
                            $(this).attr("name", old_name_arr[0] + "[" + j + "][" + old_name_arr[2] + "][" + row2 + "]");
                        }
                    });
                });
                
                $(this).find(".minor-subjektif > tbody > tr").each(function () {
                    $(this).find('.kelompoktandagejaladaftar_idnya').each(function () { //element <input>
                        var old_name = $(this).attr("name").replace(/]/g, "");
                        var old_name_arr = old_name.split("[");

                        if (old_name_arr.length == 3) {
                            $(this).attr("id", old_name_arr[0] + "_" + j + "_" + old_name_arr[2]);
                            $(this).attr("name", old_name_arr[0] + "[" + j + "][" + old_name_arr[2] + "]");
                        }
                        if (old_name_arr.length == 4) {
                            $(this).attr("id", old_name_arr[0] + "_" + j + "_" + old_name_arr[2] + "_" + row2);
                            $(this).attr("name", old_name_arr[0] + "[" + j + "][" + old_name_arr[2] + "][" + row2 + "]");
                        }
                    });
                });

                row2++;
            });
        });
    }

    function renameInputTandaGejala(obj_table)
    {
        var row = 0;
        $(obj_table).find("tbody > .diagnosisaskepdet").each(function () {

            var row2 = 0;
            $(this).find('input[name$="[kelompoktandagejaladaftar_id]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input[name$="[kelompoktandagejaladaftar_id][]"]').each(function () { //element <input>
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
        $(obj_table).find("tbody > .diagnosisaskepdet").each(function () {
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
        $(obj_table).find("tbody > .diagnosisaskepdet").each(function () {

            var row2 = 0;
            $(this).find('input[name$="[kelompoktandagejaladaftar_id]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input[name$="[kelompoktandagejaladaftar_id][]"]').each(function () { //element <input>
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
                    var tg_id = modPilih[row][i].kelompoktandagejaladaftar_id;
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
        $(obj_table).find("tbody > .diagnosisaskepdet").each(function () {

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
        $(obj_table).find("tbody > .diagnosisaskepdet").each(function () {
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
        $(obj_table).find("tbody > .diagnosisaskepdet").each(function () {
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
        $(obj_table).find("tbody > .diagnosisaskepdet").each(function () {
            var row2 = 0;
            $(this).find('.kriteria').find("tbody > tr").each(function () {
                $(this).find('span').each(function () { //element <input>
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 3) {
                        $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]" + "[" + row2 + "]");
                    }
                });
                $(this).find('input[name$="[diagnosisaskep_ir]"]').each(function () { //element <input>
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 3) {
                        $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
                        $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]" + "[" + row2 + "]");
                    }

                });
                $(this).find('input[name$="[diagnosisaskep_er]"]').each(function () { //element <input>
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
                        var ir = modPilih[row][i].diagnosisaskep_ir;
                        var er = modPilih[row][i].diagnosisaskep_er;
                        if (tg_id !== 'undefined') {
                            if ($(this).val() == tg_id) {
                                $(this).attr("checked", "checked");
                                $(this).parents('tr').find('input[name$="[' + row + '][diagnosisaskep_ir][' + row2 + ']"]').val(ir);
                                $(this).parents('tr').find('input[name$="[' + row + '][diagnosisaskep_er][' + row2 + ']"]').val(er);
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
            id = $(obj_table).find('tr:first-child input[name*="[diagnosisaskepdet_id]"]').val();
            if (id != "") {
                $(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().hide();
            }
        }
        //====end button visibility

    }

    function renameInputRowKriteria(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > .diagnosisaskepdet").each(function () {
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
            id = $(obj_table).find('tr:first-child input[name*="[diagnosisaskep_id]"]').val();
            if (id != "") {
                $(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().show();
            }
        }
        //====end button visibility

    }

    /**
     * Load detail diagnosa
     * @param {type} diagnosisaskep_id
     * @returns {undefined}     
     **/
    function loadDetail(diagnosisaskep_id) {
        $("#table-diagnosis").addClass("animation-loading");
        $('#table-diagnosis > tbody').html("");
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetPenunjang'); ?>',
            data: {diagnosisaskep_id: diagnosisaskep_id}, //
            dataType: "json",
            success: function (data) {
                $('#table-diagnosis > tbody').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                $(".integer").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
                $("#table-diagnosis").removeClass("animation-loading");
                renameInputRow($("#diagnosis-penunjang"));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    /**
     * Digunakan untuk set unceklis pop up ketika load data di baris baru
     * @param {type} obj
     * @returns {undefined}     
     **/
    function setDialogMayorObjektif(obj) {
        parent = $(obj).parents(".input-append").find("input").attr("id");
        dialog = "#dialogTandaGejalaMayorObjektif";
        
        $("input:checkbox.pilih").each(function () {
            var nomor = $(this);
            nomor.prop("checked", false);
            nomor.removeAttr("disabled");
            $(obj).parents('tr').find('.tandagejaladetail').each(function () {
                $(this).find(".mayor-objektif > tbody ").each(function () {
                    $(this).find('.kelompoktandagejaladaftar_idnya').each(function () {
                        if (nomor.attr('kelompoktandagejaladaftar_id') == $(this).val()) {
                            nomor.prop("checked", true);
//                            nomor.attr("disabled", true);
                        }
                    });

                    var tandagejala = nomor.attr('kelompoktandagejaladaftar_id');

                    if (nomor.prop("checked") == true) {
                        is_checked1[tandagejala] = tandagejala;
                    } else {
                        is_checked1[tandagejala] = 0;
                    }
                });
            });
        });
        
        $(dialog).attr("parent-dialog", parent);
        $(dialog).dialog("open");
    }
    
    /**
     * Digunakan untuk set unceklis pop up ketika load data di baris baru
     * @param {type} obj
     * @returns {undefined}     
     **/
    function setDialogMayorSubjektif(obj) {
        parent = $(obj).parents(".input-append").find("input").attr("id");
        dialog = "#dialogTandaGejalaMayorSubjektif";
        
        $("input:checkbox.pilih").each(function () {
            var nomor = $(this);
            nomor.prop("checked", false);
            nomor.removeAttr("disabled");
            $(obj).parents('tr').find('.tandagejaladetail').each(function () {
                $(this).find(".mayor-subjektif > tbody ").each(function () {
                    $(this).find('.kelompoktandagejaladaftar_idnya').each(function () {
                        if (nomor.attr('kelompoktandagejaladaftar_id') == $(this).val()) {
                            nomor.prop("checked", true);
//                            nomor.attr("disabled", true);
                        }
                    });

                    var tandagejala = nomor.attr('kelompoktandagejaladaftar_id');

                    if (nomor.prop("checked") == true) {
                        is_checked2[tandagejala] = tandagejala;
                    } else {
                        is_checked2[tandagejala] = 0;
                    }
                });
            });
        });
        
        $(dialog).attr("parent-dialog", parent);
        $(dialog).dialog("open");
    }
    
    /**
     * Digunakan untuk set unceklis pop up ketika load data di baris baru
     * @param {type} obj
     * @returns {undefined}     
     **/
    function setDialogMinorObjektif(obj) {
        parent = $(obj).parents(".input-append").find("input").attr("id");
        dialog = "#dialogTandaGejalaMinorObjektif";
        
        $("input:checkbox.pilih").each(function () {
            var nomor = $(this);
            nomor.prop("checked", false);
            nomor.removeAttr("disabled");
            $(obj).parents('tr').find('.tandagejaladetail').each(function () {
                $(this).find(".minor-objektif > tbody ").each(function () {
                    $(this).find('.kelompoktandagejaladaftar_idnya').each(function () {
                        if (nomor.attr('kelompoktandagejaladaftar_id') == $(this).val()) {
                            nomor.prop("checked", true);
//                            nomor.attr("disabled", true);
                        }
                    });

                    var tandagejala = nomor.attr('kelompoktandagejaladaftar_id');

                    if (nomor.prop("checked") == true) {
                        is_checked3[tandagejala] = tandagejala;
                    } else {
                        is_checked3[tandagejala] = 0;
                    }
                });
            });
        });
        
        $(dialog).attr("parent-dialog", parent);
        $(dialog).dialog("open");
    }
    
    /**
     * Digunakan untuk set unceklis pop up ketika load data di baris baru
     * @param {type} obj
     * @returns {undefined}     
     **/
    function setDialogMinorSubjektif(obj) {
        parent = $(obj).parents(".input-append").find("input").attr("id");
        dialog = "#dialogTandaGejalaMinorSubjektif";
        
        $("input:checkbox.pilih").each(function () {
            var nomor = $(this);
            nomor.prop("checked", false);
            nomor.removeAttr("disabled");
            $(obj).parents('tr').find('.tandagejaladetail').each(function () {
                $(this).find(".minor-subjektif > tbody ").each(function () {
                    $(this).find('.kelompoktandagejaladaftar_idnya').each(function () {
                        if (nomor.attr('kelompoktandagejaladaftar_id') == $(this).val()) {
                            nomor.prop("checked", true);
//                            nomor.attr("disabled", true);
                        }
                    });
                    
                    var tandagejala = nomor.attr('kelompoktandagejaladaftar_id');

                    if (nomor.prop("checked") == true) {
                        is_checked4[tandagejala] = tandagejala;
                    } else {
                        is_checked4[tandagejala] = 0;
                    }
                });
            });
        });
        
        $(dialog).attr("parent-dialog", parent);
        $(dialog).dialog("open");
    }
    
    /**
     * Digunakan untuk set unceklis pop up ketika load data di baris baru
     * @param {type} obj
     * @returns {undefined}     
     **/
    function setDialog2(obj) {
        parent = $(obj).parents(".input-append").find("input").attr("id");
        dialog = "#dialogFaktorRisiko";
        
        $("input:checkbox.pilih").each(function () {
            var nomor = $(this);
            nomor.prop("checked", false);
            nomor.removeAttr("disabled");
            $(obj).parents('tr').find('.faktorrisikodetail').each(function () {
                $(this).find(".kel-risiko > tbody ").each(function () {
                    $(this).find('.kelompokfaktorrisikodaftar_idnya').each(function () {
                        if (nomor.attr('kelompokfaktorrisikodaftar_id') == $(this).val()) {
                            nomor.prop("checked", true);
//                            nomor.attr("disabled", true);
                        }
                    });
                    
                    var faktorrisiko = nomor.attr('kelompokfaktorrisikodaftar_id');
                    
                    if (nomor.prop("checked") == true) {
                        is_checked5[faktorrisiko] = faktorrisiko;
                    } else {
                        is_checked5[faktorrisiko] = 0;
                    }
                });
            });
        });
        
        $(dialog).attr("parent-dialog", parent);
        $(dialog).dialog("open");
    }
        
    /**
     * Digunakan untuk set unceklis pop up ketika load data di baris baru
     * @param {type} obj
     * @returns {undefined}     
     **/
    function setDialog3(obj) {
        parent = $(obj).parents(".input-append").find("input").attr("id");
        dialog = "#dialogDiagnosa";
                
        $(dialog).attr("parent-dialog", parent);
        $(dialog).dialog("open");
    }

    /**
     * Set diagnosa by autocomplete
     * @param {type} diagnosakep_id
     * @returns {undefined}      
     **/
    function setDiagnosaAuto(diagnosakep_id) {

        var diagnosakep_id = diagnosakep_id;
        dialog = "#dialogDiagnosa";
        
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);
        check = true;
        $('#table-diagnosis').find("tbody > .diagnosisaskepdet").each(function () {
            var val = $(this).find('input[name$="[diagnosisaskep_id]"]').val(); //element <input>
            console.log(val);
            console.log(diagnosakep_id);
            if (val == diagnosakep_id) {
                check = false;
                myAlert('Diagnosa sudah dipilih!');
                return false;
            }
        });
        if (check) {
            $.get('<?php echo Yii::app()->createUrl('asuhanKeperawatan/DiagnosisKeperawatan/getDiagnosa'); ?>', {diagnosakep_id: diagnosakep_id}, function (data) {
                $(obj).val(data[0].diagnosakep_id);
                $(obj).val(data[0].diagnosakep_nama);
                setDiagnosa(obj, data[0]);
            }, "json");
            $(dialog).dialog("close");
        }
    }

    /**
     * Pilih Diagnosa
     * @param {type} obj
     * @param {type} item
     * @returns {undefined} 
     **/
    function setDiagnosa(obj, item)
    {
        $(obj).parents('tr').find('input[name$="[diagnosisaskep_id]"]').val(item.diagnosakep_id);
        $(obj).parents('tr').find('input[name$="[diagnosakep_nama]"]').val(item.diagnosakep_nama);
        $(obj).parents('tr').find('.tandagejala_indikator_minorsubjektif').val('');
        $(obj).parents('tr').find('.tandagejala_indikator_minorobjektif').val('');
        $(obj).parents('tr').find('.tandagejala_indikator_mayorsubjektif').val('');
        $(obj).parents('tr').find('.tandagejala_indikator_mayorobjektif').val('');
        $(obj).parents('tr').find('.faktorrisikodet_indikator').val('');
        setDiagnosaRow(obj, item.diagnosakep_id);
        
        
        
    }

    /**
     * Set diagnosa ketika memilih tanda gejala/faktor risiko
     * @param {type} obj
     * @param {type} diagnosakep_id
     * @returns {undefined}     */
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
                $("#table-diagnosis").removeClass("animation-loading");
                renameInputDiagDetail('#table-diagnosis');
                renameInputRow('#table-diagnosis');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /**
     * Set Mayor Objektif by dialog
     * @param {type} kelompoktandagejaladaftar_id
     * @param {type} obj
     * @returns {undefined}     
     **/
    function setTandaGejalaMayorObjektif(kelompoktandagejaladaftar_id, obj) {
        
        var kelompok = [kelompoktandagejaladaftar_id];
        $(obj).parents('tr').find('.tandagejaladetail').each(function () {
            $(this).find(".mayor-objektif > tbody ").each(function () {
                $(this).find('.kelompoktandagejaladaftar_idnya').each(function () {
                    var ini = $(this).val();
                    kelompok.push(ini);
                });
            });
        });
        
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetTandaGejalaMayorObjektif'); ?>',
            data: {kelompoktandagejaladaftar_id: kelompok},
            dataType: "json",
            success: function (data) {
                $(obj).parents('tr').find('.tandagejaladetail').each(function () {
                    $(this).find('.mayor-objektif > tbody > tr').remove(); 
                    $(this).find('.mayor-objektif > tbody').append(data.tabel);
                    $(this).find('.mayor-objektif').removeClass("animation-loading");
                });
                $(obj).parents('tr').find('.tandagejala_indikator_mayorobjektif').val('');
                setDiagnosaKeperawatan(obj);
                renameInputRows();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    /**
     * Set Mayor Subjektif by dialog
     * @param {type} kelompoktandagejaladaftar_id
     * @param {type} obj
     * @returns {undefined}     
     **/
    function setTandaGejalaMayorSubjektif(kelompoktandagejaladaftar_id, obj) {
        
        var kelompok = [kelompoktandagejaladaftar_id];
        $(obj).parents('tr').find('.tandagejaladetail').each(function () {
            $(this).find(".mayor-subjektif > tbody ").each(function () {
                $(this).find('.kelompoktandagejaladaftar_idnya').each(function () {
                    var ini = $(this).val();
                    kelompok.push(ini);
                });
            });
        });
        
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetTandaGejalaMayorSubjektif'); ?>',
            data: {kelompoktandagejaladaftar_id: kelompok},
            dataType: "json",
            success: function (data) {                
                $(obj).parents('tr').find('.tandagejaladetail').each(function () {
                    $(this).find('.mayor-subjektif > tbody > tr').remove(); 
                    $(this).find('.mayor-subjektif > tbody').append(data.tabel);
                    $(this).find('.mayor-subjektif').removeClass("animation-loading");
                });
                $(obj).parents('tr').find('.tandagejala_indikator_mayorsubjektif').val('');
                setDiagnosaKeperawatan(obj);
                renameInputRows();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    /**
     * Set Minor Objektif by dialog
     * @param {type} kelompoktandagejaladaftar_id
     * @param {type} obj
     * @returns {undefined}     
     **/
    function setTandaGejalaMinorObjektif(kelompoktandagejaladaftar_id, obj) {
        
        var kelompok = [kelompoktandagejaladaftar_id];
        $(obj).parents('tr').find('.tandagejaladetail').each(function () {
            $(this).find(".minor-objektif > tbody ").each(function () {
                $(this).find('.kelompoktandagejaladaftar_idnya').each(function () {
                    var ini = $(this).val();
                    kelompok.push(ini);
                });
            });
        });
        
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetTandaGejalaMinorObjektif'); ?>',
            data: {kelompoktandagejaladaftar_id: kelompok},
            dataType: "json",
            success: function (data) {                
                $(obj).parents('tr').find('.tandagejaladetail').each(function () {
                    $(this).find('.minor-objektif > tbody > tr').remove(); 
                    $(this).find('.minor-objektif > tbody').append(data.tabel);
                    $(this).find('.minor-objektif').removeClass("animation-loading");
                });
                $(obj).parents('tr').find('.tandagejala_indikator_minorobjektif').val('');
                setDiagnosaKeperawatan(obj);
                renameInputRows();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    /**
     * Set Minor Subjektif by dialog
     * @param {type} kelompoktandagejaladaftar_id
     * @param {type} obj
     * @returns {undefined}     
     **/
    function setTandaGejalaMinorSubjektif(kelompoktandagejaladaftar_id, obj) {
    
        var kelompok = [kelompoktandagejaladaftar_id];
        $(obj).parents('tr').find('.tandagejaladetail').each(function () {
            $(this).find(".minor-subjektif > tbody ").each(function () {
                $(this).find('.kelompoktandagejaladaftar_idnya').each(function () {
                    var ini = $(this).val();
                    kelompok.push(ini);
                });
            });
        });
        
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetTandaGejalaMinorSubjektif'); ?>',
            data: {kelompoktandagejaladaftar_id: kelompok},
            dataType: "json",
            success: function (data) {
                $(obj).parents('tr').find('.tandagejaladetail').each(function () {
                    $(this).find('.minor-subjektif > tbody > tr').remove(); 
                    $(this).find('.minor-subjektif > tbody').append(data.tabel);
                    $(this).find('.minor-subjektif').removeClass("animation-loading");
                });
                $(obj).parents('tr').find('.tandagejala_indikator_minorsubjektif').val('');
                setDiagnosaKeperawatan(obj);
                renameInputRows();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    function setTandaGejala(obj, kelompoktandagejaladaftar_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetTandaGejalanya'); ?>',
            data: {kelompoktandagejaladaftar_id: kelompoktandagejaladaftar_id}, //
            dataType: "json",
            success: function (data) {
                $(obj).parents('tr').find('.tandagejala').html("");
                $(obj).parents('tr').find('.tandagejala').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                $(".integer").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
                $("#table-diagnosis").removeClass("animation-loading");
                renameInputTandaGejala('#table-diagnosis');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setTujuan(obj, diagnosisaskep_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetTujuan'); ?>',
            data: {diagnosisaskep_id: diagnosisaskep_id}, //
            dataType: "json",
            success: function (data) {
                $(obj).parents('tr').find('.tujuan').html("");
                $(obj).parents('tr').find('.tujuan').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                $(".integer").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
                $("#table-diagnosis").removeClass("animation-loading");
                renameInput('ASDiagnosisaskepdetT', 'diagnosisaskepdet_hari');
                renameInput('ASDiagnosisaskepdetT', 'diagnosisaskepdet_estimasiwaktu');
                renameInput('ASDiagnosisaskepdetT', 'tujuan_id');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setKriteriaHasil(obj, diagnosisaskep_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetKriteriaHasil'); ?>',
            data: {diagnosisaskep_id: diagnosisaskep_id}, //
            dataType: "json",
            success: function (data) {
                $(obj).parents('tr').find('.kriteriahasil').html("");
                $(obj).parents('tr').find('.kriteriahasil').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                $("#table-diagnosis").removeClass("animation-loading");
                renameInput('ASDiagnosisaskepdetT', 'kriteriahasil_id');
                renameInput('ASDiagnosisaskepdetT', 'kriteriahasil_nama');
                renameInputRowKriteria('#table-diagnosis');
                $(".integer").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setIntervensi(obj, diagnosisaskep_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetIntervensi'); ?>',
            data: {diagnosisaskep_id: diagnosisaskep_id}, //
            dataType: "json",
            success: function (data) {
                $(obj).parents('tr').find('.intervensi').html("");
                $(obj).parents('tr').find('.intervensi').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                $(".integer").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
                $("#table-diagnosis").removeClass("animation-loading");
                renameInputIntervensi('#table-diagnosis');
                renameInput('ASDiagnosisaskepdetT', 'intervensi_id');
                renameInput('ASDiagnosisaskepdetT', 'intervensi_nama');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function isKolaborasi() {
        var obj = $('#table-diagnosis > tbody > tr').find('input[name$="[iskolaborasi]"]');
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

    /**
     * ceklis apakah memilih keperawatan/kebidanan
     * @param {type} obj
     * @returns {undefined}     
     **/
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
        
    /**
     * Fungsi append data yang terceklis ke dalam baris
     * @type Arguments
     */
    function tambahRisikoAuto(kelompokfaktorrisikodaftar_id, obj) {
    
        var kelompok = [kelompokfaktorrisikodaftar_id];
        $(obj).parents('tr').find('.faktorrisikodetail').each(function () {
            $(this).find(".kel-risiko > tbody ").each(function () {
                $(this).find('.kelompokfaktorrisikodaftar_idnya').each(function () {
                    var ini = $(this).val();
                    kelompok.push(ini);
                });
            });
        });
        
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetFaktorRisikonya'); ?>',
            data: {kelompokfaktorrisikodaftar_id: kelompok},
            dataType: "json",
            success: function (data) {
                                
                $(obj).parents('tr').find('.faktorrisikodetail').each(function () {
                    $(this).find('.kel-risiko > tbody > tr').remove(); 
                    $(this).find('.kel-risiko > tbody').append(data.tabel);
                    $(this).find('.kel-risiko').removeClass("animation-loading");
                });
                $(obj).parents('tr').find('.faktorrisikodet_indikator').val('');
                setDiagnosaKeperawatan(obj);
                renameInputRows();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    /**
     * Fungsi ceklis setelah pencarian / pindah pagination
     * @returns {undefined}     
     **/
    function cekListFaktorRisiko() {
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);
        
        $("input:checkbox.pilih").each(function () {
            var nomor = $(this);
            nomor.prop("checked", false);
            nomor.removeAttr("disabled");
            $(obj).parents('tr').find('.faktorrisikodetail').each(function () {
                $(this).find(".kel-risiko > tbody ").each(function () {
                    $(this).find('.kelompokfaktorrisikodaftar_idnya').each(function () {
                        console.log('id'+nomor.attr('kelompokfaktorrisikodaftar_id'));
                        console.log('ini'+$(this).val());
                        if (nomor.attr('kelompokfaktorrisikodaftar_id') == $(this).val()) {
                            nomor.prop("checked", true);
                        }
                    });
                    
                    var faktorrisiko = nomor.attr('kelompokfaktorrisikodaftar_id');
                    
                    if (nomor.prop("checked") == true) {
                        is_checked5[faktorrisiko] = faktorrisiko;
                    } else {
                        is_checked5[faktorrisiko] = 0;
                    }
                });
            });
        });
    }
    
    /**
     * Fungsi ceklis setelah pencarian / pindah pagination
     * @returns {undefined}     
     **/
    function cekListMinorSubjektif(){
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);
        $("input:checkbox.pilih").each(function () {
            var nomor = $(this);
            nomor.prop("checked", false);
            nomor.removeAttr("disabled");
            $(obj).parents('tr').find('.tandagejaladetail').each(function () {
                $(this).find(".minor-subjektif > tbody ").each(function () {
                    $(this).find('.kelompoktandagejaladaftar_idnya').each(function () {
                        if (nomor.attr('kelompoktandagejaladaftar_id') == $(this).val()) {
                            nomor.prop("checked", true);
                        }
                    });
                    
                    var tandagejala = nomor.attr('kelompoktandagejaladaftar_id');

                    if (nomor.prop("checked") == true) {
                        is_checked4[tandagejala] = tandagejala;
                    } else {
                        is_checked4[tandagejala] = 0;
                    }
                });
            });
        });
    }
    
    /**
     * Fungsi ceklis setelah pencarian / pindah pagination
     * @returns {undefined}     
     **/
    function cekListMinorObjektif(){
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);
        
        $("input:checkbox.pilih").each(function () {
            var nomor = $(this);
            nomor.prop("checked", false);
            nomor.removeAttr("disabled");
            $(obj).parents('tr').find('.tandagejaladetail').each(function () {
                $(this).find(".minor-objektif > tbody ").each(function () {
                    $(this).find('.kelompoktandagejaladaftar_idnya').each(function () {
                        if (nomor.attr('kelompoktandagejaladaftar_id') == $(this).val()) {
                            nomor.prop("checked", true);
                        }
                    });

                    var tandagejala = nomor.attr('kelompoktandagejaladaftar_id');

                    if (nomor.prop("checked") == true) {
                        is_checked3[tandagejala] = tandagejala;
                    } else {
                        is_checked3[tandagejala] = 0;
                    }
                });
            });
        });
    }
      
    /**
     * Fungsi ceklis setelah pencarian / pindah pagination
     * @returns {undefined}     
     **/
    function cekListMayorSubjektif(){
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);
        
        $("input:checkbox.pilih").each(function () {
            var nomor = $(this);
            nomor.prop("checked", false);
            nomor.removeAttr("disabled");
            $(obj).parents('tr').find('.tandagejaladetail').each(function () {
                $(this).find(".mayor-subjektif > tbody ").each(function () {
                    $(this).find('.kelompoktandagejaladaftar_idnya').each(function () {
                        if (nomor.attr('kelompoktandagejaladaftar_id') == $(this).val()) {
                            nomor.prop("checked", true);
                        }
                    });

                    var tandagejala = nomor.attr('kelompoktandagejaladaftar_id');

                    if (nomor.prop("checked") == true) {
                        is_checked2[tandagejala] = tandagejala;
                    } else {
                        is_checked2[tandagejala] = 0;
                    }
                });
            });
        });
    }
    
    /**
     * Fungsi ceklis setelah pencarian / pindah pagination
     * @returns {undefined}     
     **/
    function cekListMayorObjektif(){
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);
        $("input:checkbox.pilih").each(function () {
            var nomor = $(this);
            nomor.prop("checked", false);
            nomor.removeAttr("disabled");
            $(obj).parents('tr').find('.tandagejaladetail').each(function () {
                $(this).find(".mayor-objektif > tbody ").each(function () {
                    $(this).find('.kelompoktandagejaladaftar_idnya').each(function () {
                        if (nomor.attr('kelompoktandagejaladaftar_id') == $(this).val()) {
                            nomor.prop("checked", true);
                        }
                    });

                    var tandagejala = nomor.attr('kelompoktandagejaladaftar_id');

                    if (nomor.prop("checked") == true) {
                        is_checked1[tandagejala] = tandagejala;
                    } else {
                        is_checked1[tandagejala] = 0;
                    }
                });
            });
        });
    }  
    
    id = {};
    id2 = {};
    
    /**
     * Digunakan untuk set unceklis pop up ketika load data di baris baru
     * @param {type} obj
     * @returns {undefined}     
     **/
    function setDiagnosaKeperawatan(obj) {
                
        var tandagejala = $(obj).parents('tr').find('.pilihdata_tandagejala');
        if (tandagejala.is(" :checked")) {
            var a = 0;
            var ida = [];
            var val1 = [];
            var i1 = 0;
            $(obj).parents('tr').find('.tandagejaladetail').each(function () {
                $(this).find("#table-tandagejala > tbody > tr").each(function () {
                    var kelompoktandagejaladaftar_id = $(this).find('.kelompoktandagejaladaftar_idnya').val();
                    if(typeof kelompoktandagejaladaftar_id !== 'undefined'){
                        id[a++] = kelompoktandagejaladaftar_id;
                        ida.push(kelompoktandagejaladaftar_id);
                        console.log(id);
                        
                        var arraycontains_item = (val1.indexOf(kelompoktandagejaladaftar_id) > -1);
                        console.log(arraycontains_item);   

                        if (arraycontains_item == false){
                            val1[i1] = kelompoktandagejaladaftar_id;
                            i1++;
                        }  
                    }
                }); 
            });
            console.log(id);
            var id1 = val1.join(',');
            console.log(id1);
            if(typeof id !== 'undefined'){
                $.fn.yiiGridView.update('diagnosakep-m-grid', {
                    data: {
                        "ASDiagnosakepM[default]":'',
                        "ASDiagnosakepM[kelompokfaktorrisikodaftar_id]":'',
                        "ASDiagnosakepM[kelompoktandagejaladaftar_id]":id,
                        "ASDiagnosakepM[kelompokfaktorrisikodaftar_idnya]":'',
                        "ASDiagnosakepM[kelompoktandagejaladaftar_idnya]":id1,			
                    }
                });
            }else{
                $.fn.yiiGridView.update('diagnosakep-m-grid', {
                    data: {
                        "ASDiagnosakepM[default]":'kosong',
                        "ASDiagnosakepM[kelompokfaktorrisikodaftar_id]":'',
                        "ASDiagnosakepM[kelompoktandagejaladaftar_id]":id,
                        "ASDiagnosakepM[kelompokfaktorrisikodaftar_idnya]":'',
                        "ASDiagnosakepM[kelompoktandagejaladaftar_idnya]":id1,			
                    }
                });
            }
            
                
        }
        
        var faktorrisiko = $(obj).parents('tr').find('.pilihdata_faktorrisiko');
        if (faktorrisiko.is(" :checked")) {
            var b = 0;
            var idb = [];
            var val2 = [];
            var i2 = 0;
            $(obj).parents('tr').find('.faktorrisikodetail').each(function () {
                $(this).find("#table-faktorrisiko > tbody > tr").each(function () {
                    var kelompokfaktorrisikodaftar_id = $(this).find('.kelompokfaktorrisikodaftar_idnya').val();
                    if(typeof kelompokfaktorrisikodaftar_id !== 'undefined'){
                        id2[b++] = kelompokfaktorrisikodaftar_id;
                        idb.push(kelompokfaktorrisikodaftar_id);
                        console.log(id2);
                        
                        var arraycontains_item = (val2.indexOf(kelompokfaktorrisikodaftar_id) > -1);
                        console.log(arraycontains_item);   

                        if (arraycontains_item == false){
                            val2[i2] = kelompokfaktorrisikodaftar_id;
                            i2++;
                        }  
                    }
                });
            });

            var idke2 = val2.join(',');
            console.log(idke2);
            if(id2 != ''){
                $.fn.yiiGridView.update('diagnosakep-m-grid', {
                    data: {
                        "ASDiagnosakepM[default]":'',
                        "ASDiagnosakepM[kelompokfaktorrisikodaftar_id]":id2,
                        "ASDiagnosakepM[kelompoktandagejaladaftar_id]":'',	
                        "ASDiagnosakepM[kelompokfaktorrisikodaftar_idnya]":idke2,
                        "ASDiagnosakepM[kelompoktandagejaladaftar_idnya]":'',			
                    }
                });
            }else{
                $.fn.yiiGridView.update('diagnosakep-m-grid', {
                    data: {
                        "ASDiagnosakepM[default]":'kosong',
                        "ASDiagnosakepM[kelompokfaktorrisikodaftar_id]":'',
                        "ASDiagnosakepM[kelompoktandagejaladaftar_id]":id2,
                        "ASDiagnosakepM[kelompokfaktorrisikodaftar_idnya]":'',
                        "ASDiagnosakepM[kelompoktandagejaladaftar_idnya]":idke2,			
                    }
                });
            }
        }
                
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetDiagnosaKeperawatan'); ?>',
            data: {
                kelompoktandagejaladaftar_id: ida, kelompokfaktorrisikodaftar_id: idb, 
            },
            dataType: "json",
            success: function (data) {
                if(data.form != ""){
                    var diagnosakep_id = data.diagnosakep_id;

                    var check = true;
                    $('#table-diagnosis').find("tbody > .diagnosisaskepdet").each(function () {
                        var val = $(this).find('input[name$="[diagnosisaskep_id]"]').val(); 
                        console.log(val);
                        console.log(diagnosakep_id);
                        if (val == diagnosakep_id) {
                            check = false;
                            myAlert('Diagnosa sudah dipilih!');
                            return false;
                        }
                    });
                    if (check) {
                        $.get('<?php echo Yii::app()->createUrl('asuhanKeperawatan/DiagnosisKeperawatan/getDiagnosa'); ?>', {diagnosakep_id: diagnosakep_id}, function (data) {
                            $(obj).val(data[0].diagnosakep_id);
                            $(obj).val(data[0].diagnosakep_nama);
                            setDiagnosa(obj, data[0]);
                        }, "json");
                    }
                }else{
                    $(obj).parents('tr').find('.diagdetail').html("");
                    $(obj).parents('tr').find('.diagnosakep_nama').val("");
                    $(obj).parents('tr').find('.diagnosisaskep_id').val("");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        
    }
    
    $(document).ready(function () {
        <?php if (isset($_GET['pengkajianaskep_id'])){ ?>
                cekPengkajianId(<?= $_GET['pengkajianaskep_id'] ?>)
        <?php } ?>
        isKeperawatan();
        isKolaborasi();
        renameInputRow('#table-diagnosis');
<?php if (!empty($model->diagnosisaskep_id)) { ?>
            var iskeperawatan = <?php echo json_encode($modPengkajian->iskeperawatan); ?>;
            loadDiagnosaMedis('<?php echo $modPasien->pasien_id; ?>', '<?php echo $modPasien->pendaftaran_id; ?>');
            if (iskeperawatan == true) {
                $('#iskeperawatan').attr("unchecked", "unchecked");
                $('#iskeperawatan').attr("disabled", "disabled");
                $('#iskeperawatan').val(0);
                $(".keperawatan").show();
                $(".kebidanan").hide();
            }
            if (iskeperawatan == false) {
                $('#iskeperawatan').attr("checked", "checked");
                $('#iskeperawatan').attr("disabled", "disabled");
                $('#iskeperawatan').val(1);
                $(".keperawatan").hide();
                $(".kebidanan").show();
            }
<?php } ?>

        cekDisabled($('#pembayaran-form'));
        $('form').bind('click keyup select change', function (event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', '.ui-dialog-content', function () {
            cekDisabled('form');
        });
    });
</script>