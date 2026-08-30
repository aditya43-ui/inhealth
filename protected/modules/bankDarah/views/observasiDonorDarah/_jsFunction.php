<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - digunakan sebagai menampung semua js yang ada pada form asesmen awal kebidanan, untuk masing - masing tabulasi emenggunakan file _jsFunctions masing - masing
* RSST-1498
*/
?>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$baseUrl = Yii::app()->createUrl("/");

if ($modSeleksi->is_gagalseleksi == true){
    $tabObs = 'window.parent.myAlert("Observasi donor darah tidak dapat dilakukan, karena pendonor tidak lulus seleksi")';
}elseif ($modSeleksi->is_gagalseleksi == false){
    $tabObs = 'setTab(this);';
}
?>
<script>        
    function setTab(obj,value){
        var id = $(obj).attr("daftardonasi_id");
        if (typeof id === 'undefined'){
            myAlert('Daftar Pendonor belum dipilih ');
            return false;
        }
        var tabulasi = $(obj).attr("tabulasi");
        
        if(value == true) {
            var id = $(obj).attr("daftardonasi_id");
                $.ajax({
                    type:'POST',
                    url:'<?php echo $this->createUrl('getData'); ?>',
                    data:{id:id,tabulasi:tabulasi},
                    dataType:"json",
                    success:function(data) {
                        if(data.sukses == 0) {
                            toastr.error(data.pesan, "Perhatian!");
                            $('#frame').attr('src',"");
                        }
                        $("#<?php echo CHtml::activeId($modDaftarDonasi, 'observasipendonor_id') ?>").val(data.observasipendonor_id);
              
         },
         error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
         });          
        }
  
        $(obj).parents("ul").find("li").each(function(){
        //    var tabulasi = $(this).attr('tabulasi');
            
//            if (tabulasi == 'observasiDonorDarah'){
//                $(this).removeClass("active");
//                $(this).attr("onclick",'<?php echo $tabObs ?>');
//            }else if(tabulasi == 'kantongdarah'){
//                $(this).removeClass("active");
//                $(this).attr("onclick","setTab(this,true);");
//            }else if(tabulasi == 'observasiNyeri'){
//                $(this).removeClass("active");
//                $(this).attr("onclick","setTab(this,false);");
//            }else{
                $(this).removeClass("active");
                $(this).attr("onclick","setTab(this,true);");
            //}
        });
        $(obj).addClass("active");
        $(obj).removeAttr("onclick","setTab(this);");
        var tab = $(obj).attr("tab");
        var frameObj = document.getElementById("frame");
        var observasipendonor_id = $("#<?php echo CHtml::activeId($modDaftarDonasi, 'observasipendonor_id') ?>").val();                        
        
        resetIframe(frameObj);
        $(frameObj).attr("src","<?php echo $baseUrl;?>?r="+tab+"&daftardonasi_id="+id);
        //$(frameObj).parent().addClass("animation-loading");
        $("#frame-detail").addClass("animation-loading");
        $(frameObj).load(function(){
            $("#frame-detail").removeClass("animation-loading");
            resizeIframe(frameObj);
        });
        return false;
    }
    
    function resetIframe(obj) {
        obj.style.height = 128 + 'px';
    }

    function resizeIframe(obj) {            
        obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
    }

    function resizeIframeJs(obj) {  
        var h1 = obj.height();
        var h2 = 100;
        var h3 = h2+h1;

        obj.attr("style",'height:'+h3+'px');
    }
    
    function setDaftarDonasi(data, dialog){        
        
        if (dialog == 'dialog'){
            var daftar = data.daftar;
            var pendonor = data.pendonor;   
            var seleksi = data.seleksi;
            var kantong = data.kantong;
        }else{
            var daftar = data;
            var pendonor = data;
            var seleksi = data;
            var kantong = data;
        }
                
        if (seleksi.cek == 'tidakada'){
            window.parent.myAlert("Observasi donor darah tidak dapat dilakukan, karena pendonor tidak lulus seleksi");
            return false;
        }
        
        
        $("#<?php echo CHtml::activeId($modDaftarDonasi, 'daftardonasi_id') ?>").val(daftar.daftardonasi_id);
        $("#<?php echo CHtml::activeId($modDaftarDonasi, 'no_formulir') ?>").val(daftar.no_formulir);
        $("#<?php echo CHtml::activeId($modDaftarDonasi, 'ruangrekrutmen_nama') ?>").val(daftar.ruangrekrutmen_nama);
        
        
        $("#<?php echo CHtml::activeId($modPendonor, 'no_identitas') ?>").val(pendonor.no_identitas);
        $("#<?php echo CHtml::activeId($modPendonor, 'pendonor_id') ?>").val(pendonor.pendonor_id);
        $("#<?php echo CHtml::activeId($modPendonor, 'gol_darah') ?>").val(pendonor.gol_darah);
        $("#<?php echo CHtml::activeId($modPendonor, 'rhesus') ?>").val(pendonor.rhesus);
        $("#<?php echo CHtml::activeId($modPendonor, 'nomobile_pendonor') ?>").val(pendonor.nomobile_pendonor);
        $("#<?php echo CHtml::activeId($modPendonor, 'beratbadan_kg') ?>").val(pendonor.beratbadan_kg);
        $("#<?php echo CHtml::activeId($modPendonor, 'tinggibadan_cm') ?>").val(pendonor.tinggibadan_cm);
        $("#<?php echo CHtml::activeId($modPendonor, 'jenis_kelamin') ?>").val(pendonor.jenis_kelamin);
        $("#<?php echo CHtml::activeId($modPendonor, 'umur') ?>").val(pendonor.umur);
        $("#<?php echo CHtml::activeId($modPendonor, 'tgllahir') ?>").val(pendonor.tgllahir);                
        $("#<?php echo CHtml::activeId($modPendonor, 'no_pendonor') ?>").val(pendonor.no_pendonor);                
        $("#<?php echo CHtml::activeId($modPendonor, 'nama_lengkap') ?>").val(pendonor.nama_lengkap); 
        $("#<?php echo CHtml::activeId($modPendonor, 'waktu_observasi') ?>").val(pendonor.waktu_observasi); 
        $("#<?php echo CHtml::activeId($modPendonor, 'agama') ?>").val(pendonor.agama); 
        $("#<?php echo CHtml::activeId($modPendonor, 'statusperkawinan') ?>").val(pendonor.statusperkawinan); 
        
        $("#<?php echo CHtml::activeId($modSeleksi, 'td_systolic') ?>").val(seleksi.td_systolic); 
        $("#<?php echo CHtml::activeId($modSeleksi, 'td_diastoliic') ?>").val(seleksi.td_diastoliic); 
        $("#<?php echo CHtml::activeId($modSeleksi, 'kadar_hb') ?>").val(seleksi.kadar_hb); 
        $("#<?php echo CHtml::activeId($modSeleksi, 'suhu_tubuh') ?>").val(seleksi.suhu_tubuh); 
        $("#<?php echo CHtml::activeId($modSeleksi, 'detaknadi') ?>").val(seleksi.detaknadi); 
        $("#<?php echo CHtml::activeId($modSeleksi, 'dokter_nama') ?>").val(seleksi.dokter_nama); 
        $("#<?php echo CHtml::activeId($modSeleksi, 'petugas_nama') ?>").val(seleksi.petugas_nama);         
        $("#<?php echo CHtml::activeId($modSeleksi, 'catatan_dokter') ?>").val(seleksi.catatan_dokter); 
        
        $("#KantongdarahT_jeniskantong_nama").val(kantong.nama_jenis);
        $("#KantongdarahT_nomorbarcode_utama").val(kantong.nomorbarcode_utama);
        $("#KantongdarahT_nomorbarcode_sample").val(kantong.nomorbarcode_sample);
        
        $(".tabmenu-li").each(function(){
            $(this).attr('daftardonasi_id',daftar.daftardonasi_id);
        })
    }
</script>
