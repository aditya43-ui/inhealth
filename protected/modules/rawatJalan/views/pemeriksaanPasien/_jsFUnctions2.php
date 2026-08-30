<?php
$gets = "";
if (isset($_GET)) {
    foreach ($_GET as $name => $get) {
        if ($name != "r")
            $gets .= "&" . $name . "=" . $get;
    }
}
?>
<?php $baseUrl = Yii::app()->createUrl("/"); ?>
<?php $riwayatPasien = Yii::app()->createUrl('rawatJalan/daftarPasien/getRiwayatPasienLama2&id=' . $modPasien->pasien_id); ?>
<script type='text/javascript'>
   
    function cekRM(){
        const id = $(".idrm").val();
        // alert('no rm', console.log(id)); 
        window.open(`http://192.168.0.23/smartplus/history/pasien/`+ id , 'location=_new, width=900px');
    }
    
    const approveFrame = (obj, frameObj) => {
        $(obj).parents("ul").find("li").each(function() {
            $(this).removeClass("active");
            $(this).attr("onclick", "setTab(this);");
        });
        $(obj).addClass("active");
        $(obj).removeAttr("onclick", "setTab(this);");
        var tab = $(obj).attr("tab");
        
        resetIframe(frameObj);                
        if(tab == 'smart'){
            cekRM();
            $(frameObj).removeAttr("src", "<?php echo $baseUrl; ?>?r=" + tab + "<?php echo $gets; ?>");
            $(frameObj).parent().removeClass("animation-loading");
        }else{
            $(frameObj).attr("src", "<?php echo $baseUrl; ?>?r=" + tab + "<?php echo $gets; ?>");
            $(frameObj).parent().addClass("animation-loading");
        }
        $(frameObj).load(function() {
            $(frameObj).parent().removeClass("animation-loading");
            resizeIframe(frameObj);
        });
    }
    
    const cekSimpanTabulasi = (frameObj, tabObj, dari = 'tab') => {   

        const form = $("#frame").contents().find('form');       
        const active = $("#tab-periksa").find("li.active").length;
        var kunjungan = $('#kunjungan').val();

        const tabw = ['Diagnosis Awal (A)', 'Anamnesis Keperawatan (S)', 'Anamnesis Medis', 'Periksa Fisik Awal (O)', 'Laboratorium (P)', 'Radiologi (P)', 'Reseptur (P)', 'Patologi Anatomi (P)'];
        
        if(kunjungan = 'KUNJUNGAN LAMA') {
            const tabw = ['Diagnosis Awal (A)', 'Periksa Fisik Awal (O)', 'Laboratorium (P)', 'Radiologi (P)', 'Reseptur (P)', 'Patologi Anatomi (P)'];
        }

        var sukses = $("#frame").contents().find('#sukses').val();

        console.log('active: ' + active);
        console.log('form: ' + form);
        console.log('sukses: ' + sukses);

        var judul = $(tabObj).find('a').html();
        console.log(judul);
        var judul_sblm = $('#judul_sblm').val();

        
        let status = true;
                
        if (active == 0){
            status = true;            
        }else{   
            const changed = form.attr("changed");
            if(changed == 'true') {            
                if (sukses !== 1 && tabw.includes(judul_sblm)){
                    myConfirm("Data tabulasi " + judul_sblm + " belum disimpan. Apakah Anda ingin pindah tabulasi?","Perhatian!", function(r){
                        if (r){          
                            status = true;
                            approveFrame(tabObj, frameObj);                        
                        }else{
                            status = false;
                        }
                    });   
                    $('#judul_sblm').val(judul); 
                    return false;
                }else{            
                    status = true;
                }
            } else {
                status = true;
            }
        }
        $('#judul_sblm').val(judul);                                         
        return status;
    }        

    function setTab(obj) {
        
        var frameObj = document.getElementById("frame");
        if (!cekSimpanTabulasi(frameObj, obj)){
            return false;
        }else{        
            approveFrame(obj, frameObj);
            return false;
        }
    }

    function setRiwayatPasien() {
        var frameObj = document.getElementById("riwayatPasien");
        var jsframe = $("#riwayatPasien");

        jsframe.attr("src", "<?php echo $riwayatPasien; ?>");
        jsframe.parent().addClass("animation-loading");
        jsframe.on('load', function() {
            resizeIframeJs(jsframe);
            jsframe.parent().removeClass("animation-loading");
        });

        //jsframe.parent().removeClass("animation-loading");        
        //$("#divRiwayatPasien").slideToggle(500);
        //});

        /*$(frameObj).attr("src","<?php //echo $riwayatPasien;
                                    ?>");
        $(frameObj).parent().addClass("animation-loading");
        $(frameObj).load(function(){
            resizeIframe(frameObj);
            $(frameObj).parent().removeClass("animation-loading");        
            $("#divRiwayatPasien").slideToggle(500);
        });*/
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
        var h3 = h2 + h1;

        obj.attr("style", 'width: 100%; height:' + h3 + 'px;');
    }


</script>
<?php
Yii::app()->clientScript->registerScript('onLoadJs', '
    setRiwayatPasien();
', CClientScript::POS_READY);
?>