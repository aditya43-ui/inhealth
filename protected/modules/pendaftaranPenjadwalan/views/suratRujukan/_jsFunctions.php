<script type="text/javascript">
    function cekInput(param) {
        var status = 0;
        var nosep = $("#nosep").val();
        if (!requiredCheck("#rujukan-t-form")) {
            //            requiredCheck("#rujukan-t-form");
        } else {
            status = 1;
        }


        var noSep = $('#nosep').val();
        var tglRujukan = $(".tgldirujuk").val();
        var tglRencana = $(".tglrencanakunjungan_bpjs").val();
        var ppkDirujuk = $("#<?php echo CHtml::activeId($model, 'ppkrujukan') ?>").val();
        var jnsPelayanan = $("#<?php echo CHtml::activeId($model, 'jenispelayanan_bpjs') ?>").val();
        var catatan = $("#<?php echo CHtml::activeId($model, 'catatandokterperujuk') ?>").val();
        var diagRujukan = $("#<?php echo CHtml::activeId($model, 'kodediagnosasementara_ruj') ?>").val();
        var tipeRujukan = $("#<?php echo CHtml::activeId($model, 'tiperujukan_bpjs') ?>").val();
        var poliRujukan = $("#<?php echo CHtml::activeId($model, 'dirujukkebagian') ?>").val();
        var user = $("#<?php echo CHtml::activeId($model, 'userinput_bpjs') ?>").val();
        var noRujukan = $("#<?php echo CHtml::activeId($model, 'nosuratrujukan') ?>").val();
        var ppkSudahAda = $("#ppk_terdaftar").val(); //terisi dari fungsi cekFaskesRujukan
        if (ppkSudahAda != '') {
            status == 1
        } else {
//            status == 0
//            myAlert("Ppk Rujukan belm terdaftar di Database. Silahkan hubungi admin SIMRS !");
//            return false;
        }

        if (status == 1) {
            $("#content-bpjs").addClass("animation-loading");
            var setting = {
                url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
                type: 'GET',
                dataType: 'html',
                data: 'param=' + param + '&noSep=' + noSep + '&tglRujukan=' + tglRujukan + '&tglRencana=' + tglRencana + '&ppkDirujuk=' + ppkDirujuk + '&jnsPelayanan=' + jnsPelayanan + '&catatan=' + catatan + '&diagRujukan=' + diagRujukan + '&tipeRujukan=' + tipeRujukan + '&poliRujukan=' + poliRujukan + '&user=' + user + '&noRujukan=' + noRujukan,
                beforeSend: function() {
                    $("#content-bpjs").addClass("animation-loading");
                },
                success: function(data) {
                    var obj = JSON.parse(data);
                    console.log('obj', obj);
                    if (obj.metaData.code != '200') {
                        myAlert(obj.metaData.message);
                        // $("#content-bpjs").removeClass("animation-loading");
                    } else {
                        if (obj.response != null) {
                            if (param == 1) { //insert
                                var rujukan = obj.response.rujukan;
                                $("#<?php echo CHtml::activeId($model, 'nosuratrujukan') ?>").val(rujukan.noRujukan);
                            } else { //update

                            }
                            $("#rujukan-t-form").submit();
                            // $("#rujukan-t-form").submit();
                        }
                    }
                    $("#content-bpjs").removeClass("animation-loading");
                },
                error: function(data) {
                    $("#content-bpjs").removeClass("animation-loading");
                }
            }
            if (typeof ajax_request !== 'undefined')
                ajax_request.abort();
            ajax_request = $.ajax(setting);
        }
    }

    function requiredCheck(obj) {
        var kosong = 0;
        $(obj).find('input,select,textarea').each(function() {
            if ($(this).parents(".control-group").find("label").hasClass('required') === true) {
                $(this).parents(".control-group").removeClass("error").removeClass("success");
            }
        });
        $(obj).find('input,select,textarea').each(function() {
            if ($(this).parents(".control-group").find("label").hasClass('required') === true || $(this).hasClass('required')) {
                if (($(this).val() === "") && !$(this).is(":disabled")) {
                    if ($(this).is(":hidden")) { //untuk element type:hidden 
                        var radio_checked = false;
                        $(this).parent().find(".radio").each(function () { //mengecek element radio button
                            if ($(this).find("input").is(":checked")) {
                                radio_checked = true;
                            }
                        });
                        if (radio_checked == false) {
                            $(this).parents(".control-group").addClass("error");
                            $(this).addClass("error");
                            kosong++;
                            console.log($(this));
                        } else {
                            $(this).parents(".control-group").removeClass("error");
                            $(this).removeClass("error");
                        }
                    } else {
                        $(this).parents(".control-group").addClass("error");
                        $(this).addClass("error");
                        console.log($(this));
                        kosong++;
                    }
                } else {
                    $(this).parents(".control-group").removeClass("error");
                    $(this).removeClass("error");
                }
            }
        });
        if (kosong > 0) {
            window.parent.myAlert("Silahkan isi yang bertanda bintang <span class='required'>*</span> !"); //("+kosong+" input)
            return false;
        } else {
            return true;
        }
    }

    function printRujukan() {
        window.open('<?php echo $this->createUrl('printRujukan', array('id' => $model->pasiendirujukkeluar_id)); ?>', 'printwin', 'left=100,top=100,width=860,height=480');
    }

    function cekFaskesRujukan(ppkDirujuk) {
        var setting1 = {
            url: "<?php echo $this->createUrl('cekFaskes'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'ppkDirujuk=' + ppkDirujuk,
            beforeSend: function() {
                $("#content-bpjs").addClass("animation-loading");
            },
            success: function(data) {
                var obj = JSON.parse(data);
                if (obj.id == 0) {
                    $("#ppk_terdaftar").val('');
                } else {
                    $("#ppk_terdaftar").val(obj.id);
                }
                $("#content-bpjs").removeClass("animation-loading");
            },
            error: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
                $("#ppk_terdaftar").val('');
            }
        }
        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting1);
    }

    cekFaskesRujukan($("#<?php echo CHtml::activeId($model, 'ppkrujukan') ?>").val());
    
    
    const checkPlanDate = () => {
        const sepdate = $("#tglsep").val();                
        const plandate = $(".tgldirujuk").val();
        const jnspelayanan = $("#jnspelayanan").val();
                
        if ( (sepdate != '') && (plandate != '') ){       
            const exsepdate = (sepdate).split(" ");
            const time_sep = exsepdate[1].split(':');
            const day_sep = exsepdate[0].split('/');        
            const sep = new Date(day_sep[2],day_sep[1],day_sep[0],time_sep[0],time_sep[1]);
            
            const explandate = (plandate+' 00:00:00').split(" ");
            const time_plan = explandate[1].split(':');
            const day_plan = explandate[0].split('/');        
            const plan = new Date(day_plan[2],day_plan[1],day_plan[0],time_plan[0],time_plan[1]);

            if (jnspelayanan == 2){
                if ( plan.getTime() >  sep.getTime() ) {
                    myAlert("Tanggal Rencana Rujukan, untuk Pelayanan Rawat Jalan Tidak Boleh Lebih dari Tanggal SEP","Perhatian!");    
                    $(".tgldirujuk").val("");
                }                        
            }else{
                if ( plan.getTime() <  sep.getTime() ) {
                    myAlert("Tanggal Rencana Rujukan Tidak Boleh Kurang dari Tanggal SEP","Perhatian!");    
                    $(".tgldirujuk").val("");
                }  
            }
        }
    }
    
    const addRujukanKeluar = () => {
        $.ajax({
            url: "<?php echo $this->createUrl('addRujukanKeluar'); ?>",
            type: 'POST',
            dataType: 'JSON',
            data: {
                kode: $(".ppkrujukan").val(),
                nama: $(".ppkrujukan_nama").val(),
            },           
            success: function(data) {                
                if (data.databaru == 'ya'){
                    if (data.sukses == 1){
                        toastr.success("Data rujukan keluar sukses ditambahkan","Perhatian!");
                    }else{
                        toastr.error(data.pesan,"Perhatian!");
                    }
                }
            },
            error: function(data) {
            }
        })               
    }
    
    const cekPoli = () => {
        
        const plandate = $(".tgldirujuk").val();
        const ppkrujukan = $(".ppkrujukan").val();
        
        if (plandate != '' && ppkrujukan != ''){
            $('#dialogPoli').dialog('open');
            cariDataPoli();
        }else{
            toastr.error("<b>Tgl. Rencana Rujukan</b> dan <b>Kode PPK Rujukan</b> tidak boleh kosong","Perhatian!");
        }
        
    
        
    }

    function cekInputPoli() {
        var jenis = $("#PasiendirujukkeluarT_tiperujukan_bpjs").val();

        if (jenis == 2) {
            $("#PasiendirujukkeluarT_dirujukkebagian").val("").parents(".control-group").hide();
            $("#PasiendirujukkeluarT_dirujukkebagian_nama").val();

            $("#PasiendirujukkeluarT_dirujukkebagian, #PasiendirujukkeluarT_dirujukkebagian_nama").prop("disabled", true);
        } else {
            $("#PasiendirujukkeluarT_dirujukkebagian").parents(".control-group").show();
            $("#PasiendirujukkeluarT_dirujukkebagian, #PasiendirujukkeluarT_dirujukkebagian_nama").prop("disabled", false);
        }
    }

    function setDialogPPK() {
        var jenis = $(".jenisfaskes:checked").val();

        $("#katakunci_faskes1").val("");
        $("#katakunci_faskes2").val(jenis);

        $('#dialogPpk').dialog('open');
    }

    function setInputRujukan(data) {
        $("#PasiendirujukkeluarT_ppkrujukan").val(data.kode);
        $("#PasiendirujukkeluarT_ppkrujukan_nama").val(data.nama);
        $('#ppk_terdaftar').val('');
        cekFaskesRujukan(data.kode);
        if (typeof addRujukanKeluar == 'function') {
            addRujukanKeluar(); 
        }
    }

    $(document).ready(function() {
        $(".jenisfaskes").on("click", function() {
            $("#PasiendirujukkeluarT_ppkrujukan").val("");
            $("#PasiendirujukkeluarT_ppkrujukan_nama").val("");
            $("#table-faskes tbody").empty();
        });
    });
</script>