<?php
//========= end pendaftaran dialog =============================

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

$urlPasien = Yii::app()->createUrl('/' . $module . '/' . $controller . '/daftarPasien');
$urlGenSidik = Yii::app()->createUrl('/' . $module . '/' . $controller . '/genFormSidikJari');
?>
<script>        
   //verifikasi sidik jari
    function setVerifikasiFP(){
        //$("#content-riwayatpasien > .accordion-inner").addClass("animation-loading");
        $(".rb_rm").eq(1).click();

        $("#verifikasiFP").prop("disabled", true );    
        $("#verifikasiFP").hide();
        $("#pendaftaranFP").hide();
        $("#pendaftaranFP").prop("disabled", true );  
        $("#pesanVerifikasi").html("Silakan, untuk membuka aplikasi verifikasi sidik jari pasien dan lakukan scan");
        $("#loading").html("<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>");    
        $("#loading").addClass("animation-loading");
        $("#batalVerifFP2").show();
        $("#batalVerifFP2").prop("disabled", false );  
        

        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/FingerPasien/VerifikasiFP'); ?>',
            data: {},
            dataType: "json",
            success:function(data){           
                if(data.pesan =='gagal'){
                    $("#verifikasiFP").show();
                    $("#verifikasiFP").prop("disabled", false );  
                    $("#pendaftaranFP").show();
                    $("#pendaftaranFP").prop("disabled", false );  
                    $("#loading").removeClass("animation-loading");
                    $("#loading").html("");
                    $("#pesanVerifikasi").html("");
                    $("#batalVerifFP2").hide();
                    $("#batalVerifFP2").prop("disabled", true );  
                    myAlert("Silakan, periksa konfigurasi ip client pada aplikasi sidik jari");                
                    return false;//konfigurasi ip java                
                }else if(data.pesan =='sukses'){                //
                    <?php if ($modul_akses == 'ekios'){ ?>
                                
                        loadPasienByCari(data.pasien_id); 
                    <?php } else if ($modul_akses == 'pendaftaran') { ?>                    
                        setPasienLama(data.pasien_id, data.no_rekam_medik, null);
                    <?php }else{ ?>                    
                        loadPasien(data.pasien_id); 
                    <?php } ?>
                      
                    $("#verifikasiFP").show();
                    $("#verifikasiFP").prop("disabled", false );  
                    $("#pendaftaranFP").show();
                    $("#pendaftaranFP").prop("disabled", false );  
                    $("#loading").removeClass("animation-loading");
                    $("#loading").html("");
                    $("#pesanVerifikasi").html("");//"Nofingerprint = <b>"+data.nofingerprint+"</b>"
                    $("#batalVerifFP2").hide();
                    $("#batalVerifFP2").prop("disabled", true );  
                    return false;
                }else if(data.pesan =='clientclose'){
                    $("#verifikasiFP").show();
                    $("#verifikasiFP").prop("disabled", false );  
                    $("#pendaftaranFP").show();
                    $("#pendaftaranFP").prop("disabled", false );  
                    $("#loading").removeClass("animation-loading");
                    $("#loading").html("");
                    $("#pesanVerifikasi").html("");
                    $("#batalVerifFP2").hide();
                    $("#batalVerifFP2").prop("disabled", true );  
                    myAlert("Maaf, aplikasi verifikasi ditutup sebelum melakukan scan sidik jari");   
                    return false;
                }else{
                    if (data.sukses == '0'){
                        $("#verifikasiFP").show();
                        $("#verifikasiFP").prop("disabled", false );  
                        $("#pendaftaranFP").show();
                        $("#pendaftaranFP").prop("disabled", false );  
                        $("#loading").removeClass("animation-loading");
                        $("#loading").html("");
                        $("#pesanVerifikasi").html("");
                        $("#batalVerifFP2").hide();
                        $("#batalVerifFP2").prop("disabled", true );  
                        myAlert(data.pesan);
                        return false;
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);

        }
        });

    }

    //pendaftaran sidik jari
    function setPendaftaranFP(){
        //$("#content-riwayatpasien > .accordion-inner").addClass("animation-loading");
       // $(".rb_rm").eq(1).click();

        $("#verifikasiFP").prop("disabled", true );    
        $("#verifikasiFP").hide();
        $("#pendaftaranFP").prop("disabled", true );    
        $("#pendaftaranFP").hide();
        $("#pesanVerifikasi").html("Menunggu respon aplikasi enroll java ..... ");
        $("#loading").html("<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>");
        $("#loading").addClass("animation-loading");

        <?php if ($modul_akses == 'ekios'){ ?>
                    var no_rm = $("#<?php echo CHtml::activeId($modPasien, 'no_rekam_medik') ?>").val();    
        <?php }else{ ?>                    
            var no_rm = $("#cari_no_rekam_medik").val();

            if (no_rm == ''){
                 $(".rb_rm").eq(1).click();
            }
        <?php } ?>

        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/FingerPasien/PendaftaranFP'); ?>',
            data: {no_rekam_medik:no_rm},
            dataType: "json",
            success:function(data){           
                if(data.pesan =='gagal-norm'){
                    $("#verifikasiFP").show();
                    $("#verifikasiFP").prop("disabled", false );  
                    $("#pendaftaranFP").show();
                    $("#pendaftaranFP").prop("disabled", false );  
                    $("#loading").removeClass("animation-loading");
                    $("#loading").html("");
                    $("#pesanVerifikasi").html("");
                    myAlert("Maaf, No Rekam Medik belum diisi");                
                    return false;//nomor rekam medik belum diisi          
                }else if(data.pesan =='sukses'){                //                
                    $("#verifikasiFP").show();
                    $("#verifikasiFP").prop("disabled", false );  
                    $("#pendaftaranFP").show();
                    $("#pendaftaranFP").prop("disabled", false );  
                    $("#loading").removeClass("animation-loading");
                    $("#loading").html("");
                    $("#pesanVerifikasi").html(data.nama_pasien+" mendapatkan nofingerprint = "+data.nofingerprint);//"Nofingerprint = <b>"+data.nofingerprint+"</b>"
                    return false;
                }else if(data.pesan =='kirim'){    
                    $("#verifikasiFP").show();
                    $("#verifikasiFP").prop("disabled", false );  
                    $("#pendaftaranFP").show();
                    $("#pendaftaranFP").prop("disabled", false );  
                    $("#loading").removeClass("animation-loading");
                    $("#loading").html("");
                    $("#pesanVerifikasi").html("No Rekam medik, berhasil dikirim ke aplikasi pendaftaran sidik jari.<br> Silakan pasien melakukan scan sidik jari sebanyak 4 kali    ");                //No Rekam medik, berhasil dikirim ke aplikasi pendaftaran sidik jari. <br> Silakan pasien melakukan scan sidik jari sebanyak 4 kali                
                    return false;
                }else if(data.pesan =='gagal'){    
                    $("#verifikasiFP").show();
                    $("#verifikasiFP").prop("disabled", false );  
                    $("#pendaftaranFP").show();
                    $("#pendaftaranFP").prop("disabled", false );  
                    $("#loading").removeClass("animation-loading");
                    $("#loading").html("");
                    $("#pesanVerifikasi").html("Tidak ditemukan request dari aplikasi enroll Java ");                //No Rekam medik, berhasil dikirim ke aplikasi pendaftaran sidik jari. <br> Silakan pasien melakukan scan sidik jari sebanyak 4 kali                
                    return false;
                }else{
                    if (data.sukses == '0'){
                        $("#verifikasiFP").show();
                        $("#verifikasiFP").prop("disabled", false );  
                        $("#pendaftaranFP").show();
                        $("#pendaftaranFP").prop("disabled", false );  
                        $("#loading").removeClass("animation-loading");
                        $("#loading").html("");
                        $("#pesanVerifikasi").html("");
                        myAlert(data.pesan);
                        return false;
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);

        }
        });

    }

    //pendaftaran sidik jari
    function setRegisFP(no_rm){

        $("#regisFP").prop("disabled", true );    
        $("#regisFP").hide();
        $("#pesanRegis").html("Menunggu Proses Pendaftaran ..... Silakan Buka Aplikasi Pendaftaran Sidik Jari");
        $("#regisLoading").addClass("animation-loading");

        var no_rm = no_rm;

        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/FingerPasien/PendaftaranFP'); ?>',
            data: {no_rekam_medik:no_rm},
            dataType: "json",
            success:function(data){           
                if(data.pesan =='gagal-norm'){               
                    $("#regisFP").show();
                    $("#regisFP").prop("disabled", false );  
                    $("#regisLoading").removeClass("animation-loading");
                    $("#pesanRegis").html("");
                    myAlert("Maaf, Nomor Rekam Medik belum diisi");                
                    return false;//nomor rekam medik belum diisi          
                }else if(data.pesan =='sukses'){                //                
                    $("#regisFP").show();
                    $("#regisFP").prop("disabled", false );   
                    $("#regisLoading").removeClass("animation-loading");
                    $("#pesanRegis").html(data.nama_pasien+" mendapatkan nofingerprint = "+data.nofingerprint);//"Nofingerprint = <b>"+data.nofingerprint+"</b>"
                    return false;
                }else if(data.pesan =='kirim'){    
                    $("#regisFP").show();
                    $("#regisFP").prop("disabled", false );  
                    $("#regisLoading").removeClass("animation-loading");
                    $("#pesanRegis").html("No Rekam medik, berhasil dikirim ke aplikasi pendaftaran sidik jari.<br> Silakan pasien melakukan scan sidik jari sebanyak 4 kali    ");                //No Rekam medik, berhasil dikirim ke aplikasi pendaftaran sidik jari. <br> Silakan pasien melakukan scan sidik jari sebanyak 4 kali                
                    return false;
                }else{
                    if (data.sukses == '0'){
                        $("#regisFP").show();
                        $("#regisFP").prop("disabled", false );  
                        $("#regisLoading").removeClass("animation-loading");
                        $("#pesanRegis").html("");
                        myAlert(data.pesan);
                        return false;
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);

        }
        });
    }    
    
    function batalVerifikasiFP(){
        $("#loading").html("<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>");
        $("#loading").addClass("animation-loading");
        var port = '<?php echo Yii::app()->user->getState('finger_pasien_hostserver') ?>';
                
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/FingerPasien/BatalVerifFP'); ?>',
            data: {port:port},
            dataType: "json",
            success:function(data){                           
                $("#verifikasiFP").prop("disabled", false );    
                $("#verifikasiFP").show();
                $("#pendaftaranFP").prop("disabled", false );    
                $("#pendaftaranFP").show();
                $("#batalVerifFP").hide();
                $("#batalVerifFP").prop("disabled", true );  
                $("#pesanVerifikasi").html("");
                $("#loading").html("");
                $("#loading").removeClass("animation-loading");
                return false;               
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    
    function verifData(obj){
        
    }
    
    function cekCari(obj){
        var val = $(obj).attr('value');
        
        if (val == 'sidik'){
            $("#cari_manual").attr("style","display:none;");
            $("#cari_sidik").attr("style","display:block;");            
        }else if(val == 'form'){
            $("#cari_manual").attr("style","display:block;");
            $("#cari_sidik").attr("style","display:none;");
        }
        
    }
	
    $(document).ready(function(){
        $("#batalVerifFP").hide();
    })
</script>