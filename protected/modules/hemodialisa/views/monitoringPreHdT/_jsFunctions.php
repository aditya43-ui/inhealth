<?php
$drop = LookupM::getItemsUrutan('pemeriksaan_lab');
$tanggal_lahir = new DateTime($modPasien->tanggal_lahir);
$tanggal_daftar = new DateTime($modPendaftaran->tgl_pendaftaran);
$y = $tanggal_daftar->diff($tanggal_lahir)->y;
if ($y < 3) {
    $skala = 'flacc';
} else {
    $skala = 'wbf';
}
?>
<script type="text/javascript">
    const konjungtivaLain = (st = '') => {
        const cek = $("#konjungtiva_lainlain").prop("checked");
        
        $("#konjungtiva_keterangan").attr("readonly", true);
        if (cek){
            if (st != 'awal'){
                $("#konjungtiva_keterangan").val('');
            }
            $("#konjungtiva_keterangan").attr("readonly", false);
        }
    }
    
    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function () {
            $(this).find("#no_urut").val(row + 1);
            $(this).find('span').each(function () { //element <input>
                var old_name = $(this).attr("id").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });

    }
    
    var gen_tgl_hasil_eks = () => {
        $('#tabel-hasil-eks').find('.tanggal').datetimepicker(jQuery.extend({
            showMonthAfterYear: false},
                jQuery.datepicker.regional['id'],
                {'dateFormat': '<?= Params::DATE_FORMAT ?>',
                    'changeMonth': true,
                    'changeYear': true,
                    'maxDate': 'd',
                    'timeText': 'Waktu',
                    'hourText': 'Jam',
                    'minuteText': 'Menit',
                    'secondText': 'Detik',
                    'showSecond': true,
                    'timeFormat': 'hh:mm:ss'
                }));
    }
    
    var addPeriksaLuar = (obj) => {
        var tr = new String(<?= CJSON::encode($this->renderPartial('rawatInap.views.asesmenAwalMedisAnak.form/row/_row_eks', ['model' => $modLabEks, 'drop' => $drop], true)); ?>)

        $("#tabel-hasil-eks > tbody").append(tr.replace());
        renameInputRow($("#tabel-hasil-eks"));
        gen_tgl_hasil_eks();
    }
    
    var lihat_detail = (id) => {
        window.open('<?php echo $this->createUrl('printPK'); ?>&pasienmasukpenunjang_id=' + id, 'printwin', 'left=100,top=0,width=768,height=640');
    }
    
    var salah_satu = (obj) => {
        var cek = $(obj).prop('checked');
        $(obj).parents('.control-group').find('input:radio').prop('checked', false);
        
        $(obj).prop('checked', cek);
    }
    /**
     * Fungsi salin dari riwayat
     * @param {type} id
     * @returns {undefined}
     */
    function salinRiwayat(id) {
        $.ajax({
            url: '<?php echo $this->createUrl('/hemodialisa/monitoringPreHdT/GetDataFromRiwayat'); ?>',
            data: {id: id},
            type: 'post',
            dataType: 'json',
            success: function (data) {
                if (data.status == true) {
                    $("#MonitoringPreHdT_diagnosa_nama").val(data.diagnosa_nama);
                    $("#MonitoringPreHdT_diagnosa_id").val(data.diagnosa_id);
                    $("#MonitoringPreHdT_nomor_mesin").val(data.nomor_mesin);
                    $("#MonitoringPreHdT_gol_darah").val(data.gol_darah);
                    $("#MonitoringPreHdT_hemodialisis_ke").val(data.hemodialisis_ke);
                    $("#MonitoringPreHdT_dialiser").val(data.dialiser);
                    $("#MonitoringPreHdT_kendala_komunikasi_tidakada").attr('checked', data.kendala_komunikasi_tidakada);
                    $("#MonitoringPreHdT_kendala_komunikasi_ada").attr('checked', data.kendala_komunikasi_ada);
                    $("#MonitoringPreHdT_kendala_komunikasi_keterangan").val(data.kendala_komunikasi_keterangan);
                    $("#MonitoringPreHdT_asesmentnyeri_id").val(data.asesmentnyeri_id);

                    if ($('#MonitoringPreHdT_kendala_komunikasi_ada').is(" :checked")) {
                        $("#MonitoringPreHdT_kendala_komunikasi_keterangan").attr('readonly', false);
                    } else {
                        $("#MonitoringPreHdT_kendala_komunikasi_keterangan").attr('readonly', true);
                    }

                    $("#MonitoringPreHdT_alergi_obat_tidak").attr('checked', data.alergi_obat_tidak);
                    $("#MonitoringPreHdT_alergi_obat_ya").attr('checked', data.alergi_obat_ya);
                    $("#MonitoringPreHdT_alergi_obat_keterangan").val(data.alergi_obat_keterangan);

                    if ($('#MonitoringPreHdT_alergi_obat_ya').is(" :checked")) {
                        $("#MonitoringPreHdT_alergi_obat_keterangan").attr('readonly', false);
                    } else {
                        $("#MonitoringPreHdT_alergi_obat_keterangan").attr('readonly', true);
                    }

                    $("#MonitoringPreHdT_hbsag_tidak").attr('checked', data.hbsag_tidak);
                    $("#MonitoringPreHdT_hbsag_ya").attr('checked', data.hbsag_ya);
                    $("#MonitoringPreHdT_hbsag_keterangan").val(data.hbsag_keterangan);

                    if ($('#MonitoringPreHdT_hbsag_ya').is(" :checked")) {
                        $("#MonitoringPreHdT_hbsag_keterangan").attr('readonly', false);
                    } else {
                        $("#MonitoringPreHdT_hbsag_keterangan").attr('readonly', true);
                    }

                    $("#MonitoringPreHdT_hcv_tidak").attr('checked', data.hcv_tidak);
                    $("#MonitoringPreHdT_hcv_ya").attr('checked', data.hcv_ya);
                    $("#MonitoringPreHdT_hcv_keterangan").val(data.hcv_keterangan);

                    if ($('#MonitoringPreHdT_hcv_ya').is(" :checked")) {
                        $("#MonitoringPreHdT_hcv_keterangan").attr('readonly', false);
                    } else {
                        $("#MonitoringPreHdT_hcv_keterangan").attr('readonly', true);
                    }

                    $("#MonitoringPreHdT_hiv_tidak").attr('checked', data.hiv_tidak);
                    $("#MonitoringPreHdT_hiv_ya").attr('checked', data.hiv_ya);
                    $("#MonitoringPreHdT_hiv_keterangan").val(data.hiv_keterangan);

                    if ($('#MonitoringPreHdT_hiv_ya').is(" :checked")) {
                        $("#MonitoringPreHdT_hiv_keterangan").attr('readonly', false);
                    } else {
                        $("#MonitoringPreHdT_hiv_keterangan").attr('readonly', true);
                    }

                    $("#MonitoringPreHdT_kondisi_saat_ini_tenang").attr('checked', data.kondisi_saat_ini_tenang);
                    $("#MonitoringPreHdT_kondisi_saat_ini_gelisah").attr('checked', data.kondisi_saat_ini_gelisah);
                    $("#MonitoringPreHdT_kondisi_saat_ini_takut_tindakan").attr('checked', data.kondisi_saat_ini_takut_tindakan);
                    $("#MonitoringPreHdT_kondisi_saat_ini_marah").attr('checked', data.kondisi_saat_ini_marah);
                    $("#MonitoringPreHdT_kondisi_saat_ini_tersinggung").attr('checked', data.kondisi_saat_ini_tersinggung);

                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#<?php echo CHtml::activeId($model, 'skornyeri'); ?>').val('');
                $('#<?php echo CHtml::activeId($model, 'keterangan_skriningnyeri'); ?>').val('');
                $('#<?php echo CHtml::activeId($model, 'asesmentnyeri_id'); ?>').val('');
                $("#<?php echo CHtml::activeId($model, 'skriningnyeri_nyeri') ?>").removeAttr('checked');
                $("#<?php echo CHtml::activeId($model, 'skriningnyeri_tidaknyeri') ?>").removeAttr('checked');
            },
            cache: false,
        });
    }


    /**
     * Load data asesmen nyeri
     * @type Arguments
     */
    function calldialogAsesmenNyeri() {
        $('#dialogAsesmennyeri').dialog('open');
        $('#frameAsesmenNyeri').attr('src', '<?php echo $this->createUrl('/hemodialisa/AsesmenNyeriHD/Index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'skala' => $skala)); ?>');
    }

    /**
     * Get data asesmen nyeri
     * @param {type} ket
     * @returns {undefined}
     */
    function getDataAsesmenNyeri(ket) {
        var pendaftaran_id = <?php echo $modPendaftaran->pendaftaran_id ?>;

        $.ajax({
            url: '<?php echo $this->createUrl('/rawatInap/AsesmenAwalKeperawatan/GetDataAsesmenNyeri'); ?>',
            data: {pendaftaran_id: pendaftaran_id},
            type: 'post',
            dataType: 'json',
            success: function (data) {
                if (data.status == true && data.score_skalanyeri > 0) {
                    $("#<?php echo CHtml::activeId($model, 'skornyeri') ?>").val(data.score_skalanyeri);
                    $('#<?php echo CHtml::activeId($model, 'keterangan_skriningnyeri'); ?>').val(data.keteranganskala_nyeri);
                    $("#<?php echo CHtml::activeId($model, 'asesmentnyeri_id') ?>").val(data.asesmentnyeri);
                    $("#<?php echo CHtml::activeId($model, 'keluhan_utama_nyeri') ?>").attr('checked', true);
                    $("#nyeri").show();
                } else {
                    $('#<?php echo CHtml::activeId($model, 'skornyeri'); ?>').val('');
                    $('#<?php echo CHtml::activeId($model, 'keterangan_skriningnyeri'); ?>').val('');
                    $("#<?php echo CHtml::activeId($model, 'keluhan_utama_nyeri') ?>").removeAttr('checked');
                    $("#nyeri").hide();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#<?php echo CHtml::activeId($model, 'skornyeri'); ?>').val('');
                $('#<?php echo CHtml::activeId($model, 'keterangan_skriningnyeri'); ?>').val('');
                $('#<?php echo CHtml::activeId($model, 'asesmentnyeri_id'); ?>').val('');
                $("#<?php echo CHtml::activeId($model, 'keluhan_utama_nyeri') ?>").removeAttr('checked');
                $("#nyeri").hide();
            },
            cache: false,
        });
    }
    
    var selisihBb = () => {
        let bb_pre = parseFloat(unformatNumber($(".berat_badan_pre_hd").val()));
        let bb_post = parseFloat(unformatNumber($(".berat_badan_post_hd").val()));
        
        if (bb_pre == '')
            bb_pre = 0;        
        
        if (bb_post == '')
            bb_post = 0;
        
        let selisih = Math.abs(bb_pre - bb_post);
        $(".selisih").val(formatFloat(selisih))
    }
    
    function hitungBMI(){
        var beratBadan = parseFloat($("#MonitoringPreHdT_berat_badan_pre_hd").val());
        var tinggiBadan = parseFloat($("#MonitoringPreHdT_tinggi_badan").val());
        if(tinggiBadan != 0 || tinggiBadan > 0){
            var tinggiBadanMeter = tinggiBadan/100;
            var luasbadanfix = Math.round(beratBadan/(tinggiBadan*tinggiBadan));
            var hasil = Math.round(beratBadan/(tinggiBadanMeter*tinggiBadanMeter));
        }else{
            var tinggiBadanMeter = 0;
            var hasil = 0;
            var luasbadanfix=0
        }
//        $("#RIAsesmenAwalMedisT_luasbadan").val(luasbadanfix);
        $("#MonitoringPreHdT_imt").val(hasil);
        if (jQuery.isNumeric(hasil)){
            $.post('<?php echo Yii::app()->createUrl('rawatJalan/pemeriksaanFisik/getBMIText'); ?>', {bmi:hasil}, function(data){
                $('#RIAsesmenAwalMedisT_bodymassindex_nama').val(data.text);
                $('#RIAsesmenAwalMedisT_bodymassindex_id').val(data.id);
            },'json');
        }
    }

    $(document).ready(function () {
        $(".form-cek-lis").find('input:checkbox').each(function(){
            set_dis(this,'disabled');
        });
    
        <?php if (!empty($_GET['detail'])) { ?>
            $("#asesmen-awal-medis-form").find("input, select, textarea").attr("disabled", true);
            $("#asesmen-awal-medis-form").find(".add-on").hide();
            $('#btn_simpan').addClass('hide');
        <?php } ?>

        <?php if (empty($_GET['id'])) { ?>
            $("#<?php echo CHtml::activeId($model, 'kendala_komunikasi_tidakada'); ?>").attr("checked", true);
            $("#<?php echo CHtml::activeId($model, 'alergi_obat_tidak'); ?>").attr("checked", true);
            <?php
            if (!empty($modPendaftaran)) {
                if ($modPendaftaran->status_hd == 'HBsAg') {
                    ?>
                        $("#MonitoringPreHdT_hbsag_keterangan").attr('readonly', false);
                    <?php
                }
                if ($modPendaftaran->status_hd == 'HIV') {
                    ?>
                        $("#MonitoringPreHdT_hiv_keterangan").attr('readonly', false);
                    <?php
                }
                if ($modPendaftaran->status_hd == 'HCV') {
                    ?>
                        $("#MonitoringPreHdT_hcv_keterangan").attr('readonly', false);
                    <?php
                }
            }
            ?>
            $("#<?php echo CHtml::activeId($model, 'kepala_normal'); ?>").attr("checked", true);
            $("#<?php echo CHtml::activeId($model, 'leher_normal'); ?>").attr("checked", true);
            $("#<?php echo CHtml::activeId($model, 'jantung_normal'); ?>").attr("checked", true);
            $("#<?php echo CHtml::activeId($model, 'paru_normal'); ?>").attr("checked", true);
            $("#<?php echo CHtml::activeId($model, 'abdomen_normal'); ?>").attr("checked", true);
            $("#<?php echo CHtml::activeId($model, 'kulit_normal'); ?>").attr("checked", true);
            $("#<?php echo CHtml::activeId($model, 'anggota_tubuh_normal'); ?>").attr("checked", true);
            $("#<?php echo CHtml::activeId($model, 'lab_internal'); ?>").attr("checked", true);
        <?php } ?>
        getDataAsesmenNyeri();
        
        konjungtivaLain('awal');
    });

    
    
    $(".form-cek-lis").find('input:checkbox').click(function(){        
        var cek = $(this).prop('checked');
        set_dis(this);
                
        if (!cek && $(this).hasClass('parent')){
            var id = $(this).parents('.control-group').find('.det_id').val();            
            if (id != ''){
                $("#akses-vaskular-hapus > tbody").append('<tr><td><input type="hidden" name="akses_hapus[]" value="'+id+'"></td></tr>');
            }
        }
    });

    var hapus_akses = (obj) => {
        $(obj).parents('.kelompok').find('.det_id').each(function(){
            var id = $(this).val();
            
            if (id != ''){                
                $("#akses-vaskular-hapus > tbody").append('<tr><td><input type="hidden" name="akses_hapus[]" value="'+id+'"></td></tr>');
            }
        });
    }
    
    
</script>
