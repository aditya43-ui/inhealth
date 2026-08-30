<?php
$modDet = new RIAsesmenedukasiDetT;
?>

<script>
    function setPasien(obj) {
        if ($("#RIAsesmenedukasiT_pasien_penerima_edukasi").is(":checked")) {
            var nama = $("#RIPasienM_nama_pasien").val();
            var umur = $("#RIPasienM_umurtahun").val();
            var agama = $("#RIPasienM_agama").val();
            var alamat = $("#RIPasienM_alamat_pasien").val();
            var suku = $("#RIPasienM_sukubangsa").val();
            var pendidikan = $("#RIPasienM_pendidikan").val();
            $("#RIAsesmenedukasiT_nama_lengkap").val(nama);
            $("#RIAsesmenedukasiT_umur").val(umur);
            $("#RIAsesmenedukasiT_agama").val(agama);
            $("#RIAsesmenedukasiT_alamat").val(alamat);
            $("#RIAsesmenedukasiT_sukubangsa").val(suku);
            $("#RIAsesmenedukasiT_tingkatpendidikan").val(pendidikan);
        } else {
            $("#RIAsesmenedukasiT_nama_lengkap").val('');
            ;
            $("#RIAsesmenedukasiT_umur").val('');
            $("#RIAsesmenedukasiT_agama").val('');
            $("#RIAsesmenedukasiT_alamat").val('');
            $("#RIAsesmenedukasiT_sukubangsa").val('');
            $("#RIAsesmenedukasiT_tingkatpendidikan").val('');
        }
    }

    function tambahHasil(label, kel_id, label_next) {
        var row = '<?php echo CJSON::encode($this->renderPartial($this->path_view . 'form/_rowTabel', array('modDet' => $modDet), true)); ?>';
        var countKel = 0;
        var penerimaedukasi = $('#<?php echo CHtml::activeId($model, 'nama_lengkap') ?>').val();
//        $('#table-hasilevaluasi > tbody > tr').each(function(){
//            if ($(this).find('.kel_id').val() == kel_id){
//                countKel++;
//            }
//        });
//        
//        if (label_next == ''){
//            label = label;
//        }else{
//            label = label+', '+$.trim(label_next);
//        }
//        
//        if (countKel>0){            
//            
//        }else{
        $('#table-hasilevaluasi > tbody').append(row);
        $('#table-hasilevaluasi > tbody > tr:last').find('.penerimaedukasi').val(penerimaedukasi);
        $('#table-hasilevaluasi > tbody > tr:last').find('.materi_edukasi').html(label);
        $('#table-hasilevaluasi > tbody > tr:last').find('.kel_id').val(label);
        $('#table-hasilevaluasi > tbody > tr:last').find('.materiedukasi').val(label);
//        }





        renameInputRow($("#table-hasilevaluasi"));
//        updateRow($("#table-hasilevaluasi"),label);
    }

    function cekLainnya() {

        $("#<?php echo CHtml::activeId($modDet, '[ii]metodeedukasi') ?>").val('Test');

    }



    function cekMedisLain() {

        var pen = $("#<?php echo CHtml::activeId($model, 'medis_lainnya') ?> ").prop("checked");

        if (pen == true) {
            $("#<?php echo CHtml::activeId($model, 'medis_lainnya_ket') ?>").removeAttr('readonly');
        } else {
            $("#<?php echo CHtml::activeId($model, 'medis_lainnya_ket') ?>").val('').attr('readonly', true);
        }
    }




    function generateNama(obj) {
        $("#table-hasilevaluasi").find("tbody > tr").each(function () {
            $(this).find('.penerimaedukasi').val($(obj).val());


        });
    }

    function updateRow(obj, kel_id, checked) {
        var penerimaedukasi = $('#<?php echo CHtml::activeId($model, 'nama_lengkap') ?>').val();
        var label = '';
        var countCek = 0;


//        $("#"+kel_id).find('input:checkbox').each(function(){
//            if($(this).prop("checked") == true){
//                var lbl = $(this).parents('.controls').find('label').html();                                                
//                
//                if ($(this).parents('.control-group').next().find('.controls > input:checkbox').html() == null){
//                    //var label_next = $(this).parents('.control-group').next().find('.controls > label').html();
//                   // if (label_next == null){
//                     //   label_next = '';
//                    //}
//                }else{
//                    var label_next = '';
//                }
//                
//                if (label == ''){
//                    label = lbl;
//                }else{
//                    label = label+', '+lbl;
//                }
//                
//                countCek++;
//            }
//        });

//        if (countCek>0){
//            $(obj).find("tbody > tr").each(function(){            
//                $(this).find('.penerimaedukasi').val(penerimaedukasi);                        
//
//                if ($(this).find('.kel_id').val() == kel_id){
//                    $(this).find('.materi_edukasi').html(label);                        
//                    $(this).find('.materiedukasi').val(label);                        
//                }
//            });
//        }else{
        myConfirm("Apakah Anda yakin akan menghapus data ini dari tabel hasil evaluasi dan verifikasi ?", "Perhatian", function (r) {
            if (r) {
                $(obj).find("tbody > tr").each(function () {
                    if ($(this).find('.kel_id').val() == kel_id) {
                        $(this).find('.kel_id').parents('tr').detach();
                    }
                });
            } else {
                checked.prop("checked", true);
            }
        });

//        }
    }

    function hapusHasil(label, kel_id) {
        //var row = '<?php echo CJSON::encode($this->renderPartial($this->path_view . 'form/_rowTabel', array('modDet' => $modDet), true)); ?>';
        $('#table-hasilevaluasi > tbody ').append(row);

        renameInputRow($("#table-hasilevaluasi"));
    }

    /**
     * rename input grid
     */
    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function () {
            $(this).find("#no_urut").val(row + 1);
            $(this).find('.add-on').each(function () { //element <input>
                var old_name = $(this).attr("id");
                if (typeof old_name !== 'undefined') {
                    var old_name_arr = old_name.split("_");



                    if (old_name_arr.length == 4) {
                        $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3]);

                    }
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
            $(this).find('input[name$="[tglpemeriksaan]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });
        $('#obatalkes_id').val('');
        $('#obatalkes_nama').val('');
        $('#qty_input').val(1);
    }

    function generatePicker() {

        $('.tglpemeriksaan').datepicker('destroy');

        jQuery('input[name$="[tglpemeriksaan]"]').datepicker(
                jQuery.extend(
                        {
                            showMonthAfterYear: false
                        },
                        jQuery.datepicker.regional['id'],
                        {

                            'minDate': 'd',
                            'timeText': 'Waktu',
                            'hourText': 'Jam',
                            'minuteText': 'Menit',
                            'secondText': 'Detik',
                            'showSecond': true,
                            'timeOnlyTitle': 'Pilih Waktu',
                            'timeFormat': 'hh:mm:ss',
                            'changeYear': true,
                            'changeMonth': true,
                            'showAnim': 'fold',
                            'yearRange': '-80y:+20y'
                        }
                )
                );//mask("99/99/9999 99:99:99")

        jQuery('input[name$="[jam_awal]"]').timepicker(
                jQuery.extend(
                        {
                            showMonthAfterYear: false
                        },
                        jQuery.datepicker.regional['id'],
                        {

                            'minDate': 'd',
                            'timeText': 'Waktu',
                            'hourText': 'Jam',
                            'minuteText': 'Menit',
                            'secondText': 'Detik',
                            'showSecond': true,
                            'timeOnlyTitle': 'Pilih Waktu',
                            'timeFormat': 'hh:mm:ss',
                            'changeYear': true,
                            'changeMonth': true,
                            'showAnim': 'fold',
                            'yearRange': '-80y:+20y'
                        }
                )
                );

        jQuery('input[name$="[jam_akhir]"]').timepicker(
                jQuery.extend(
                        {
                            showMonthAfterYear: false
                        },
                        jQuery.datepicker.regional['id'],
                        {

                            'minDate': 'd',
                            'timeText': 'Waktu',
                            'hourText': 'Jam',
                            'minuteText': 'Menit',
                            'secondText': 'Detik',
                            'showSecond': true,
                            'timeOnlyTitle': 'Pilih Waktu',
                            'timeFormat': 'hh:mm:ss',
                            'changeYear': true,
                            'changeMonth': true,
                            'showAnim': 'fold',
                            'yearRange': '-80y:+20y'
                        }
                )
                );

        $("#table-hasilevaluasi").find('input[name$="[pegawai_pemberiedukasi_nama]"]').each(function () {
            $(this).autocomplete(
                    {
                        'showAnim': 'fold',
                        'minLength': 3,
                        'focus': function (event, ui)
                        {
                            $(this).val("");
                            return false;
                        },
                        'select': function (event, ui)
                        {
                            $(this).val(ui.item.label);
                            $(this).parents('tr').find('input[name$="[pegawai_pemberiedukasi_id]"]').val(ui.item.pegawai_id);
                            $(this).parents('tr').find('input[name$="[pegawai_pemberiedukasi_nama]"]').val(ui.item.label);
                            return false;
                        },
                        'source': function (request, response)
                        {
                            $.ajax({
                                url: "<?php echo $this->createUrl('/ActionAutoComplete/DropPetugasRuanganAll'); ?>",
                                dataType: "json",
                                data: {
                                    nama_pegawai: request.term,
                                    ruangan_id:<?php echo Yii::app()->user->getState('ruangan_id') ?>,
                                },
                                success: function (data) {
                                    response(data);
                                }
                            })
                        },
                    }
            );
        });
    }

    function detailHapus(det_id, obj) {

        myConfirm("Apakah anda yakin akan menghapus data ini ?", "Pehatian", function (r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('hapusHasil'); ?>',
                    data: {det_id: det_id},
                    dataType: "json",
                    success: function (data) {
                        myAlert(data.pesan)
                        if (data.sukses == 1) {


                            $("#table-hasilevaluasi > tbody > tr").each(function () {
                                if ($(this).find('.kel_id').val() == data.kel_id) {
                                    $(this).detach();
                                }
                            });

                            $("#" + data.kel_id).find('input:checkbox').each(function () {
                                $(this).prop("checked", false);
                                $(this).removeAttr("disabled");
                            });

                            $("#rencanaEdukasi").find("input:checkbox").each(function () {
                                $(this).removeAttr("checked");
                            });

                            $(obj).parents('tr').remove();
                        }


                    }
                });
            } else {

            }
        });
    }

    function lepasDisabled() {
        $("#rencanaEdukasi").find("input:checkbox").each(function () {
            $(this).removeAttr("disabled");
        });
        //return false;
        $("#asesmenedukasi-form").submit();
    }

    function cekPendidikan() {
        var pen = $("#<?php echo CHtml::activeId($model, 'tingkatpendidikan') ?> option:selected").val().toLowerCase();

        if (pen == 'lain-lain') {
            $("#<?php echo CHtml::activeId($model, 'tingkatpendidikan_lainnya') ?>").removeAttr('readonly');
        } else {
            $("#<?php echo CHtml::activeId($model, 'tingkatpendidikan_lainnya') ?>").val('').attr('readonly', true);
        }
    }

    function cekBahasaDaerah() {
        var pen = $("#<?php echo CHtml::activeId($model, 'bahasa_daerah') ?> ").prop("checked");

        if (pen == true) {
            $("#<?php echo CHtml::activeId($model, 'bahasa_daerah_keterangan') ?>").removeAttr('readonly');
        } else {
            $("#<?php echo CHtml::activeId($model, 'bahasa_daerah_keterangan') ?>").val('').attr('readonly', true);
        }
    }

    function cekBahasaLain() {
        var pen = $("#<?php echo CHtml::activeId($model, 'bahasa_lainnya') ?> ").prop("checked");

        if (pen == true) {
            $("#<?php echo CHtml::activeId($model, 'bahasa_lainnya_ket') ?>").removeAttr('readonly');
        } else {
            $("#<?php echo CHtml::activeId($model, 'bahasa_lainnya_ket') ?>").val('').attr('readonly', true);
        }
    }

    function cekBicaraGangguan() {
        var pen = $("#<?php echo CHtml::activeId($model, 'bicara_gangguansejak') ?> ").prop("checked");

        if (pen == true) {
            $("#<?php echo CHtml::activeId($model, 'bicara_gangguansejak_ket') ?>").removeAttr('readonly');
        } else {
            $("#<?php echo CHtml::activeId($model, 'bicara_gangguansejak_ket') ?>").val('').attr('readonly', true);
        }
    }

    function cekKebutuhanLain() {
        var pen = $("#<?php echo CHtml::activeId($model, 'kebutuhanprivasi_ya_lainnya') ?> ").prop("checked");

        if (pen == true) {
            $("#<?php echo CHtml::activeId($model, 'kebutuhanprivasi_ya_lainnya_ket') ?>").removeAttr('readonly');
        } else {
            $("#<?php echo CHtml::activeId($model, 'kebutuhanprivasi_ya_lainnya_ket') ?>").val('').attr('readonly', true);
        }
    }

    function tambahBaris(obj) {

//alert('tes');
        var label = $(obj).parents('.parent-data').find('.lainnya').val();

        var kel_id = label; //$(this).parents('.parent-data').attr('id');

        if ($(obj).parents('.control-group').next().find('.controls > input:checkbox').html() == null) {
            var label_next = $(obj).parents('.control-group').next().find('.controls > label').html();
            if (label_next == null) {
                label_next = '';
            }

        } else {
            var label_next = '';
        }

        if ($(obj).parents('.control-group').find('.controls > input:checkbox').prop('checked')) {
            tambahHasil(label, kel_id, label_next);
//            alert("tambah");
        } else {
            //alert(label);
            if ($(this).parents('.controls').find('.controls > input:checkbox').prop('checked')) {
                updateRow($("#table-hasilevaluasi"), kel_id, $(obj).parents('.control-group').find('.controls > input:checkbox'));
            }
        }

//                alert(isLain);

        generatePicker();
        
        $(obj).parents('.controls').find('.lainnya').val("");


    }

    function changeJenisPPA(obj){
        var textvalue = $(obj).find('option:selected').text();
        var valuejenis = $(obj).val();

        if(valuejenis !== ''){
            $('#<?php echo CHtml::activeId($model, 'ppa_namajenis'); ?>').val(textvalue);
        }

        if(textvalue === "Ahli Gizi"){
            $('.soapahligizi').show();
            $('.soap').hide();
        }else{
            $('.soapahligizi').hide();
            $('.soap').show();
        }

        var ppa = $(obj).val();

        if(ppa == 1) {
            $('#PegawairuanganV_jabatan_id').val('29').change();
        } else if(ppa == 3) {
            $('#PegawairuanganV_jabatan_id').val('22').change();
        }

        console.log(ppa);
    }


    $(document).ready(function () {

        $(".lainnya").each(function () {

            $(this).parents('.controls').find('input[type=checkbox]').each(function () {

                if ($(this).is(" :checked")) {

                    $(this).parents(".controls").find(".lainnya").attr('readonly', false);

                } else {
                    $(this).parents(".controls").find(".lainnya").attr('readonly', true);

                }

            });

        });

        $("div#rencanaEdukasi").on('click', 'input:checkbox', function () {
            //alert($(this).parents('.controls').find('label').html());
            var label = $(this).parents('.controls').find('label').html();
            var isLain = false;
            if (label == 'Lainnya' || label == 'Lain-lain') {

                var label = $(this).parents('.parent-data').find('.lainnya').val();
                isLain = true;

                if ($(this).is(" :checked")) {

                    $(this).parents('.parent-data').find('.lainnya').attr('readonly', false);

                } else {

                    $(this).parents('.parent-data').find('.lainnya').attr('readonly', true);

                }

            }

            var kel_id = label; //$(this).parents('.parent-data').attr('id');



            if ($(this).parents('.control-group').next().find('.controls > input:checkbox').html() == null) {
                var label_next = $(this).parents('.control-group').next().find('.controls > label').html();
                if (label_next == null) {
                    label_next = '';
                }

            } else {
                var label_next = '';
            }

            if ($(this).parents('.control-group').find('.controls > input:checkbox').prop('checked')) {
                if (!isLain) {
                    tambahHasil(label, kel_id, label_next);
                }
            } else {
                updateRow($("#table-hasilevaluasi"), kel_id, $(this).parents('.control-group').find('.controls > input:checkbox'));
                if (isLain) {
                    $(this).parents('.parent-data').find('.lainnya').val("");
                }
            }

//                alert(isLain);

            generatePicker();

        });


        setValidasiCekDisabled($("#asesmenedukasi-form"), function () {
            return true;
        });

<?php if (!empty($getDet)) { ?>
            renameInputRow($("#table-hasilevaluasi"));
            //            generatePicker();
<?php } ?>

        cekPendidikan();
        cekBahasaDaerah();
        cekBahasaLain();
        cekBicaraGangguan();
        cekKebutuhanLain();
    });
</script>