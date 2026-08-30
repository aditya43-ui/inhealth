
<script type="text/javascript">
      function setCheckbox(obj){
          
          var nilai = $(obj).val();
          var id = $(obj).attr('id');
          var myArray = id.split("_");
          console.log(myArray);
          if(myArray[3] == 0){
            $("#permintaanPenunjang_is_tanggungan_1").prop('checked',false);
            $("#permintaanPenunjang_is_tanggungan_0").prop('checked',true);
          }else{
            $("#permintaanPenunjang_is_tanggungan_1").prop('checked',true);
            $("#permintaanPenunjang_is_tanggungan_0").prop('checked',false);
          }
        //   if(nilai == 1){
        //     $().
        //   }else{

        //   }
    }
    $('#tab1-klinik').fadeIn(100);
    $('#tab1-anatomi').hide();

    function tab1(obj) {
        var lab = obj.id;
        if (lab == 'klinik') {
            $('#ruangan_id').val('<?php echo Params::RUANGAN_ID_LAB_KLINIK; ?>');
            $('#klinik').attr('class', 'active');
            $('#anatomi').removeAttr('class');
            $('#tab1-anatomi').fadeOut(100);
            $('#tab1-klinik').fadeIn(100);
            $('#RIPasienKirimKeUnitLainT_catatandokterpengirim').focus();
        } else {
            //$('#ruangan_id').val('<?php //echo Params::RUANGAN_ID_LAB_ANATOMI; 
                                    ?>');
            //$('#ruangan_id').val('<?php echo Params::RUANGAN_ID_LAB_KLINIK; ?>');
            $('#klinik').removeAttr('class');
            $('#anatomi').attr('class', 'active');
            $('#tab1-klinik').fadeOut(100);
            $('#tab1-anatomi').fadeIn(100);
            $('#RIPasienKirimKeUnitLainT_catatandokterpengirim').focus();
        }

    }

    $('#formPeriksaLab').tile({
        widths: [300]
    });

    function inputperiksa(obj, ruangan_id) {
        if ($(obj).is(':checked')) {
            var pemeriksaanlab_id = obj.value;
            var kelaspelayanan_id = $('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'kelaspelayanan_id') ?>').val();
            var pendaftaran_id = <?php echo $modPendaftaran->pendaftaran_id; ?>;
            jQuery.ajax({
                'url': '<?php echo $this->createUrl('loadFormPemeriksaanLab') ?>',
                'data': {
                    pemeriksaanlab_id: pemeriksaanlab_id,
                    kelaspelayanan_id: kelaspelayanan_id,
                    pendaftaran_id: pendaftaran_id,
                    ruangan_id: ruangan_id
                },
                'type': 'POST',
                'dataType': 'json',
                'success': function(data) {
                    if ($.trim(data.form) == '') {
                        $(obj).removeAttr('checked');
                        window.parent.myAlert('Pemeriksaan belum memiliki tarif');
                        //                            checkIni(obj);
                    }
                    $('#tblFormPemeriksaanLab #trPeriksaLabKosong').detach();
                    $('#tblFormPemeriksaanLab > tbody').append(data.form);
                    $("#tblFormPemeriksaanLab > tbody > tr:last .integer").maskMoney({
                        "symbol": "",
                        "defaultZero": true,
                        "allowZero": true,
                        "decimal": ".",
                        "thousands": ",",
                        "precision": 0
                    });
                    $('.integer').each(function() {
                        this.value = formatNumber(this.value)
                    });
                    hitungTotal();
                },
                'cache': false
            });
        } else {
            myConfirm("Apakah Anda akan membatalkan pemeriksaan ini?", "Perhatian!", function(r) {
                if (r) {
                    batalPeriksa(obj.value);
                    hitungTotal();
                } else {
                    $(obj).attr('checked', 'checked');
                }
            });
        }
    }

    function batalPeriksa(pemeriksaanlab_id) {
        $('#tblFormPemeriksaanLab #periksalab_' + pemeriksaanlab_id).detach();
        //if($('#tblFormPemeriksaanLab tr').length == 1)
        //    $('#tblFormPemeriksaanLab').append('<tr id="trPeriksaLabKosong"><td colspan="4"></td></tr>');
    }

    function batalKirim(pasienkirimkeunitlain_id, pendaftaran_id) {
        myConfirm("Apakah Anda akan membatalkan kirim pasien ke Laboratorium?", "Perhatian!", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('ajaxBatalKirim') ?>', {
                    pasienkirimkeunitlain_id: pasienkirimkeunitlain_id,
                    pendaftaran_id: pendaftaran_id
                }, function(data) {
                    $('#tblListPemeriksaanLab').html(data.result);
                    myAlert(data.pesan);
                }, 'json');
            }
        });
    }

    function hitungTotal() {
        var total = 0;
        $('.tarif_satuan').each(
            function() {
                qty = $(this).parents('tr').find('.gty').val();
                total += unformatNumber(this.value) * qty;
            }
        );

        $('#periksaTotal').val(formatNumber(total));
    }

    function cekInput() {
        if (requiredCheck($("#rjpasien-laboratorium-t-form"))) {
            //var deposit = $('#deposit').val();
            var periksaTotal = unformatNumber($('#periksaTotal').val());
            var tr = $("#tblFormPemeriksaanLab > tbody > tr").length;

            var pendaftaran_id = '<?php echo $modPendaftaran->pendaftaran_id; ?>';
            var pemeriksaanlab_id = [];

            $('#tblFormPemeriksaanLab tbody tr').each(function() {
                var id = $(this).find('.pemeriksaanlab_id').val();

                pemeriksaanlab_id.push(id);
            });

            if (tr > 0) {

                $.post('<?php echo $this->createUrl('/rawatJalan/laboratorium/cekTindakan') ?>', {
                    pemeriksaanlab_id: pemeriksaanlab_id,
                    pendaftaran_id: pendaftaran_id
                }, function(data) {
                    if (data.sukses >= 1) {
                        Notiflix.Confirm.Init({
                            plainText: false,
                            messageMaxLength: 1100,
                            titleMaxLength: 1000,
                        });
                        Notiflix.Confirm.Show(
                            'Peringatan',
                            data.pesan,
                            'Iya',
                            'Tidak',
                            function okCb() {
                                $('#rjpasien-laboratorium-t-form').submit();
                                disableOnSubmit($("#btn_submit"));
                            },
                            function cancelCb() {}, {
                                width: '320px',
                                borderRadius: '8px',
                            },
                            );
                        } else {
                            $('#rjpasien-laboratorium-t-form').submit();
                            disableOnSubmit($("#btn_submit"));
                    }
                }, 'json');
            } else {
                alert("Tindakan Laboratorium belum dipilih");
                return false;
            }
        }
        return false;
    }


    function updateChecklistFormLab(){
    var form_index = $('#form_index').val();
    var cek = [];


    $(".daftar-pemeriksaan").find('input:checked').each(
            function() {

                cek.push($(this).attr('value'));
                $(this).attr('checked', true);
            }
        );


        var cekc = [];

$('#tblFormPemeriksaanLab tbody tr').each(function () {

    var id = $(this).attr('id');
    cekc.push(parseInt(id.replace('periksalab_', '')));
    // cek.push('');

});

    $('.daftar-pemeriksaan').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('/rawatInap/laboratoriumTRI/SetChecklistFormLab'); ?>',
        data: {data:$("#form-caripemeriksaan :input").serialize()},
        dataType: "json",
        success:function(data){
            $('.daftar-pemeriksaan').html(data.content);
            $('.checkboxlist-tile').tile({widths : [ 1900 ]});
            setTimeout(function(){
                $('#formPeriksaLab').tile({
                    widths: [300]
                });
                $('.daftar-pemeriksaan').removeClass("animation-loading");
            }, 200);
            
            
            setCheckedPemeriksaan($("#form-tindakanpemeriksaan-"+form_index),$('.daftar-pemeriksaan'));
            
            if($('#klinik').hasClass('active')) {
                
            $('#anatomi').removeAttr('class');
            $('#tab1-anatomi').fadeOut(100);
            $('#tab1-klinik').fadeIn(100);

            }

            if($('#anatomi').hasClass('active')) {
                
                $('#klinik').removeAttr('class');
                $('#tab1-klinik').fadeOut(100);
                $('#tab1-anatomi').fadeIn(100);
    
                }

// console.log(cek.includes("284"), cek);

            // $(".daftar-pemeriksaan").find('input[type="checkbox"]').each(
            
            //      function() {
            //       if(cek.includes($(this).attr('value')) == true) {

            //         $(this).attr('checked', true);

            //       }
            //        }
                 
            //     );


                $.each(cekc, function (key, val) {

                    $('#formPeriksaLab').find('input[type="checkbox"][value="' + val + '"]').prop("checked", "checked");   
                    // cekc.push(val); 

                });

        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
    /**
 * update (refresh) checklist pemeriksaan lab
 * harus include /js/jquery.tiler.js
 * @param {obj} form_checklist
 */

 function setCheckedPemeriksaan(obj_table,obj_dialog){
    var form_index = $('#form_index').val();
    $(obj_table).find('input[name$="[pemeriksaanlab_id]"]').each(function(){
        var pemeriksaanlab_id = $(this).val();
        $(obj_dialog).find('input[name$="[is_pilih]"][value='+pemeriksaanlab_id+']').attr('checked',true);
    });

}

function updateChecklistPemeriksaanLab(){
    var form_index = $('#form_index').val();
    var cek = [];


    $(".daftar-pemeriksaan").find('input:checked').each(
            function() {

                cek.push($(this).attr('value'));
                $(this).attr('checked', true);
            }
        );


        var cekc = [];

$('#tblFormPemeriksaanLab tbody tr').each(function () {

    var id = $(this).attr('id');
    cekc.push(parseInt(id.replace('periksalab_', '')));
    // cek.push('');

});


    
    $('.daftar-pemeriksaan').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('/rawatInap/laboratoriumTRI/SetChecklistPemeriksaanLab'); ?>',
        data: {data:$("#form-caripemeriksaan :input").serialize()},
        dataType: "json",
        success:function(data){
            $('.daftar-pemeriksaan').html(data.content);
            $('.checkboxlist-tile').tile({widths : [ 1900 ]});
            setTimeout(function(){
                $('#formPeriksaLab').tile({
                    widths: [300]
                });
                $('.daftar-pemeriksaan').removeClass("animation-loading");
            }, 200);
            
            
            setCheckedPemeriksaan($("#form-tindakanpemeriksaan-"+form_index),$('.daftar-pemeriksaan'));
            
            if($('#klinik').hasClass('active')) {
                
            $('#anatomi').removeAttr('class');
            $('#tab1-anatomi').fadeOut(100);
            $('#tab1-klinik').fadeIn(100);

            }

            if($('#anatomi').hasClass('active')) {
                
                $('#klinik').removeAttr('class');
                $('#tab1-klinik').fadeOut(100);
                $('#tab1-anatomi').fadeIn(100);
    
                }

// console.log(cek.includes("284"), cek);

            // $(".daftar-pemeriksaan").find('input[type="checkbox"]').each(
            
            //      function() {
            //       if(cek.includes($(this).attr('value')) == true) {

            //         $(this).attr('checked', true);

            //       }
            //        }
                 
            //     );


                $.each(cekc, function (key, val) {

                    $('#formPeriksaLab').find('input[type="checkbox"][value="' + val + '"]').prop("checked", "checked");   
                    // cekc.push(val); 

                });

        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}


// function updateChecklistPemeriksaanLab2(){
//     var form_index = $('#form_index').val();

function setCheckedPemeriksaanDariClick(obj_dialog) {
        var form_index = $('#form_index').val();
        if (pemeriksaanlab_baru.length > 0) {
            pemeriksaanlab_baru.forEach(element => {
                var pemeriksaanlab_id = element;
                console.log('element', pemeriksaanlab_id)
                $(obj_dialog).find('input[name$="[is_pilih]"][value=' + pemeriksaanlab_id + ']').prop('checked', true);
            });
        }
    }

    function setCheckedPemeriksaan(obj_table, obj_dialog) {
        var form_index = $('#form_index').val();
        $(obj_table).find('input[name$="[pemeriksaanlab_id]"]').each(function() {
            var pemeriksaanlab_id = $(this).val();
            $(obj_dialog).find('input[name$="[is_pilih]"][value=' + pemeriksaanlab_id + ']').attr('checked', true);
        });

    }

    function updateChecklistPemeriksaanLab(){
        var form_index = $('#form_index').val();

        var cek = [];

        $('input:checked').each(function () {

            cek.push($(this).attr("value"));
        });
        $('#daftar-pemeriksaan').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('/rawatInap/laboratoriumTRI/SetChecklistPemeriksaanLab'); ?>',
        data: {data:$("#form-caripemeriksaan :input").serialize()},
        dataType: "json",
        success:function(data){
            $('#daftar-pemeriksaan').html(data.content);
            $('#formPeriksaLab').tile({
               widths: [190]
              });

            if($('#klinik').hasClass("active")) {
                $('#anatomi').removeAttr('class');
                $('#tab1-anatomi').fadeOut(100);
                $('#tab1-klinik').fadeIn(100);  

            }
            if($('#anatomi').hasClass("active")) {

            $('#klinik').removeAttr('class');
                $('#tab1-klinik').fadeOut(100);
                $('#tab1-anatomi').fadeIn(100);  
            }

            $.each(cek, function (idx, val) {
                $('input[type="checkbox"][value="' + val + '"]').prop("checked", "checked");
            });
             
            $('#daftar-pemeriksaan').removeClass("animation-loading");

        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function setChecklistPemeriksaanLabReset(){
    $("#form-caripemeriksaan").find('input, select').val('');
    updateChecklistPemeriksaanLab();
}

    $(document).ready(function() {
        $('#ruangan_id').val('<?php echo Params::RUANGAN_ID_LAB_KLINIK; ?>'); // untuk menandakan antara TAB lab klinik dengan anatomi
       
        // Notifikasi Pasien
        <?php
        if (isset($_GET['smspasien'])) {
            if ($_GET['smspasien'] == 0) {
        ?>
                var params = [];
                params = {
                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                    modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                    judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                    isinotifikasi: 'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'
                }; // 16 
                insert_notifikasi(params);
        <?php
            }
        }
        ?>

        <?php
        if (isset($modKirimKeUnitLain->pasienkirimkeunitlain_id)) {
        ?>
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Params::MODUL_ID_LAB ?>,
                judulnotifikasi: 'Pasien Rujukan',
                isinotifikasi: '<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>
    });

function updateChecklistFormLab(){
    var form_index = $('#form_index').val();
    var cek = [];

    $('input:checked').each(function () {

        cek.push($(this).attr("value"));
    });
    $('#daftar-pemeriksaan').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('/rawatInap/laboratoriumTRI/SetChecklistFormLab'); ?>',
        data: {data:$("#form-caripemeriksaan :input").serialize()},
        dataType: "json",
        success:function(data){
            $('#daftar-pemeriksaan').html(data.content);
            // $('.checkboxlist-tile').tile({widths : [ 190 ]});
            $('#formPeriksaLab').tile({
               widths: [300]
              });

if($('#klinik').hasClass("active")) {

    $('#anatomi').removeAttr('class');
            $('#tab1-anatomi').fadeOut(100);
            $('#tab1-klinik').fadeIn(100);  

}
if($('#anatomi').hasClass("active")) {

$('#klinik').removeAttr('class');
        $('#tab1-klinik').fadeOut(100);
        $('#tab1-anatomi').fadeIn(100);  

}

$.each(cek, function (idx, val) {

    $('input[type="checkbox"][value="' + val + '"]').prop("checked", "checked");
    // alert(idx);

});
             
            $('#daftar-pemeriksaan').removeClass("animation-loading");
           // setCheckedPemeriksaan($("#form-tindakanpemeriksaan-"+form_index),$('.daftar-pemeriksaan'));

        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}




    $(document).ready(function() {
        var $panels = $('.boxtindakan');
        $('.inline span').show();
        $('#cari_modul').on('keyup', function () {
            var val = this.value.toLowerCase();

            $panels.show().filter(function () {

                var i = 0;
                $(this).find('span').each(function () {

                    if ($(this).text().toLowerCase().includes(val)) {

                        $(this).closest('.inline').find('input[type="checkbox"]').show();
                        $(this).show();
                        // $(this).closest('.inline').show();
                        $(this).closest('.inline').attr('style', 'visibility: visible;');

                        i++;

                    } else {
                        $(this).closest('.inline').find('input[type="checkbox"]').hide();
                        $(this).hide();
                        $(this).closest('.inline').attr('style', 'visibility: hidden;');

                    }

                });

                return i === 0;
            }).hide();
        });

        $('#ruangan_id').val('<?php echo Params::RUANGAN_ID_LAB_KLINIK; ?>'); // untuk menandakan antara TAB lab klinik dengan anatomi
        // Notifikasi Pasien
        <?php
        if (isset($_GET['smspasien'])) {
            if ($_GET['smspasien'] == 0) {
        ?>
                var params = [];
                params = {
                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                    modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                    judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                    isinotifikasi: 'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'
                }; // 16 
                insert_notifikasi(params);
        <?php
            }
        }
        ?>

        <?php
        if (isset($modKirimKeUnitLain->pasienkirimkeunitlain_id)) {
        ?>
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Params::MODUL_ID_LAB ?>,
                judulnotifikasi: 'Pasien Rujukan',
                isinotifikasi: '<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>
    });
    $("#formPilihData").submit(function (event) {
        event.preventDefault();
        $("#cari_modul").focus();
        return false;
    });
</script>