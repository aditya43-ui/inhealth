<?php
$urlCariPasien = $this->createUrl('pasien');
$urlCetakStruk = $this->createUrl('printStruk');
$btn = json_encode(CHtml::button('Lanjutkan',['class'=>'btn btn-success', 'onclick'=>'cariPasien();', 'id'=>'btn-cari-pasien']));
$btntab = json_encode($this->renderPartial('_tabMenu',[], true));
$js = <<< JS
    
    var r_id = '';
    var peg_id = '';   
    var pas_id = '';
    
   const printStruk = (id) => {
        window.open('${urlCetakStruk}&id='+id,'printwin','left=100,top=100,width=480,height=640');
    }
        
    const simpanDaftar  = (obj) => {
        
        let formbody = $(obj).parents(".form-actions");
        formbody.addClass("animation-loading-1");
        
        $.ajax({
            type: 'GET',
            url: '${urlCariPasien}',
            data: {
                r_id:r_id,
                peg_id:peg_id,
                pas_id:pas_id,
                cari:'simpan'
            },
            dataType: "json",
            success: function (data) {                                        
                if (data.sukses == '1'){
                    $("#panel-verifikasi").html(data.html);
                    Notiflix.Report.Success("Berhasil",data.pesan);
                }else{
                    Notiflix.Report.Failure("Gagal",data.pesan);
                }            
            
                setTimeout(function() {
                    $(".notiflix-report").fadeOut();
                }, 15000);
            },
            error: function (jqXHR, textStatus, errorThrown) {                                    
                $("#tab-verifikasi").trigger("click");
                formbody.removeClass("animation-loading-1");
            }
        });
    }
        
    const loadVerifikasi = (obj) => {
        const btnlanjut = $("#panel-jadwal").find(".lanjut-position").html();
        const formbody = $("#panel-jadwal").find(".btn-lanjut").parents(".lanjut-position");        
        
        formbody.addClass("animation-loading-1 h-load").html("");        
        
        $.ajax({
            type: 'GET',
            url: '${urlCariPasien}',
            data: {
                r_id:r_id,
                peg_id:peg_id,
                pas_id:pas_id,
                cari:'daftar'
            },
            dataType: "json",
            success: function (data) {                                        
                if (typeof data.pesan === 'undefined'){
                    $("#panel-verifikasi").html(data);                    

                    $("#tab-verifikasi").trigger("click");

                    $("#panel-jadwal").addClass("hide");
                    $("#panel-verifikasi").removeClass("hide");                    
                }
                formbody.removeClass("animation-loading-1 h-load").html(btnlanjut);
            },
            error: function (jqXHR, textStatus, errorThrown) {    
                formbody.removeClass("animation-loading-1 h-load").html(btnlanjut);                
                $("#tab-jadwal").trigger("click");
            }
        });
      
    }
        
    const pilihDokter = (id, obj) => {
        let formbody = $(obj).parents(".main-dokter");
        formbody.addClass("animation-loading-1");
                
        peg_id = id;
        
        $.ajax({
            type: 'GET',
            url: '${urlCariPasien}',
            data: {
                id:r_id,
                peg_id:id,
                cari:'jadwal'
            },
            dataType: "json",
            success: function (data) {                                        
                if (typeof data.pesan === 'undefined'){
                    $("#panel-jadwal").html(data);                    

                    $("#tab-jadwal").trigger("click");

                    $("#panel-dokter").addClass("hide");
                    $("#panel-jadwal").removeClass("hide");                    
                }else{
                    Notiflix.Report.Failure("Data Tidak Ditemukan",data.pesan);
                    $("#tab-dokter").trigger("click");
                }
                
                formbody.removeClass("animation-loading-1");
            },
            error: function (jqXHR, textStatus, errorThrown) {    
                formbody.removeClass("animation-loading-1");
                $("#tab-dokter").trigger("click");
            }
        });
    }
        
    const pilihPoli = (id, obj) => {
        
        $(obj).addClass("animation-loading-1");
        r_id = id;
            
        $.ajax({
            type: 'GET',
            url: '${urlCariPasien}',
            data: {
                id:r_id,
                cari:'dokter'
            },
            dataType: "json",
            success: function (data) {                                        
                if (typeof data.pesan === 'undefined'){
                    $("#panel-dokter").html(data);                    

                    $("#tab-dokter").trigger("click");

                    $("#panel-polik").addClass("hide");
                    $("#panel-dokter").removeClass("hide");                    
                }else{
                    Notiflix.Report.Failure("Data Tidak Ditemukan",data.pesan);
                    $("#tab-polik").trigger("click");
                }
                
                $(obj).removeClass("animation-loading-1");
            },
            error: function (jqXHR, textStatus, errorThrown) {    
                $(obj).removeClass("animation-loading-1");
                $("#tab-polik").trigger("click");
            }
        });
    }
       
    const bukaTabJadwal = () => {
        $("#panel-jadwal").removeClass("hide");
        $("#panel-verifikasi").addClass("hide");
    }
            
    const bukaTabDokter = () => {
        $("#panel-dokter").removeClass("hide");
        $("#panel-jadwal").addClass("hide");
    }
            
    const bukaTabPolik = () => {
        $("#panel-polik").removeClass("hide");
        $("#panel-dokter").addClass("hide");
    }
            
    const bukaTabPasien = () => {
        $("#panel-pasien").removeClass("hide");
        $("#panel-polik").addClass("hide");
    }
   
    const loadPolik = () => {
        const btnlanjut = $("#panel-pasien").find(".lanjut-position").html();
        const formbody = $("#panel-pasien").find(".btn-lanjut").parents(".lanjut-position");
        const cekPolik = $("#panel-polik").html();
        
        formbody.addClass("animation-loading-1 h-load").html("");
        $("#panel-pasien").removeClass("hide");
        
        if (cekPolik == ''){        
            $.ajax({
                type: 'GET',
                url: '${urlCariPasien}',
                data: {
                    cari:'polik'
                },
                dataType: "json",
                success: function (data) {                                        
                    if (typeof data.pesan === 'undefined'){
                        $("#panel-polik").html(data);                    

                        $("#tab-polik").trigger("click");

                        $("#panel-pasien").addClass("hide");
                        $("#panel-polik").removeClass("hide");                    
                    }else{
                        Notiflix.Report.Failure("Data Tidak Ditemukan",data.pesan);
                        $("#tab-pasien").trigger("click");
                    }
                    formbody.removeClass("animation-loading-1 h-load").html(btnlanjut);
                },
                error: function (jqXHR, textStatus, errorThrown) {    
                    formbody.removeClass("animation-loading-1 h-load").html(btnlanjut);                
                    $("#tab-pasien").trigger("click");
                }
            });
        }else{
            formbody.removeClass("animation-loading-1 h-load").html(btnlanjut);
            $("#panel-pasien").addClass("hide");
            $("#panel-polik").removeClass("hide");    
        }
    }    
    
    const cariPolik = (obj) => {
        let keyword = $(obj).val();
        let r = '';
        
        $(".btn-ruangan").addClass("hide");
        if (keyword != ''){
            $(".btn-ruangan").each(function(){
                r = $(this).attr("ruangan");
                if (r.includes(keyword) === true){
                    $(this).removeClass("hide");
                }
            });
        }else{
            $(".btn-ruangan").removeClass("hide");
        }
    }
        
    const cariPasien = (obj) => {
        let norm = $("#norm").val();
        let formbody = $("#btn-cari-pasien").parents(".form-actions");
        formbody.addClass("animation-loading-1 h-load").html("");
        
        $.ajax({
            type: 'GET',
            url: '${urlCariPasien}',
            data: {
                norm:norm,
                cari:'pasien'
            },
            dataType: "json",
            success: function (data) {                                        
                if (typeof data.pesan === 'undefined'){
                    $("#form-body").html(data.html);
                    $("#form-tab > div").html(${btntab});
                    
                    pas_id = data.pas_id;
                    
                    $("#tab-pasien").trigger("click");
                }else{
                    Notiflix.Report.Failure(data.pesan,"");
                    formbody.removeClass("animation-loading-1 h-load").html(${btn});
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {    
                formbody.removeClass("animation-loading-1 h-load").html(${btn});
            }
        });
    }
JS;

Yii::app()->clientScript->registerScript('daftar-mandiri-main', $js, CClientScript::POS_HEAD);
