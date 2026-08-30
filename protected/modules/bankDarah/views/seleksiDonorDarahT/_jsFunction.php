<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$baseUrl = Yii::app()->createUrl("/");

?>
<script>        
    function setTab(obj,value){
        var id = $(obj).attr("daftardonasi_id");        
        if (typeof id === 'undefined'){
            myAlert('Daftar Pendonor belum dipilih ');
            return false;
        }
        
       if(value == 'cektandavital' || value == 'cekkantong') {
            var id = $(obj).attr("daftardonasi_id");
                $.ajax({
                    type:'POST',
                    url:'<?php echo $this->createUrl('getData'); ?>',
                    data:{id:id,value:value},
                    dataType:"json",
                    success:function(data) {
                        if(data.sukses == 0) {
                            myAlert(data.pesan);
                            $('#frame').attr('src',"");
                            setTabAktif($(obj));
                         }else{
                             loadFrame($(obj));
                         }
              
         },
         error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
         });          
        }else{
            loadFrame($(obj));
        }
          
        return false;
    }
    
    function loadFrame(obj){
        var pendonor_id = $(obj).attr("pendonor_id");
        var id = $(obj).attr("daftardonasi_id");
        
        setTabAktif($(obj));
        
        var tab = $(obj).attr("tab");
        var frameObj = document.getElementById("frame");
        
        
        resetIframe(frameObj);
        $(frameObj).attr("src","<?php echo $baseUrl;?>?r="+tab+"&pendonor_id="+pendonor_id+"&daftardonasi_id="+id);
        //$(frameObj).parent().addClass("animation-loading");
        $("#frame-detail").addClass("animation-loading");
        $(frameObj).load(function(){
            $("#frame-detail").removeClass("animation-loading");
            resizeIframe(frameObj);
        });
    }
    
    function setTabAktif(obj){
        $(obj).parents("ul").find("li").each(function(){
            var tabulasi = $(this).attr('tabulasi');
            
            if (tabulasi == 'observasiDonorDarah'){
                $(this).removeClass("active");
                $(this).attr("onclick",'setTab(this,value="");');
            }else if(tabulasi == 'TandaVital'){
                $(this).removeClass("active");
                $(this).attr("onclick","setTab(this,value='cektandavital');");
            }else if(tabulasi == 'kantongdarah'){
                $(this).removeClass("active");
                $(this).attr("onclick","setTab(this,value='cekkantong');");
            }else{
                $(this).removeClass("active");
                $(this).attr("onclick","setTab(this,value='cekseleksi');");
            }
        });        
        $(obj).addClass("active");
        $(obj).removeAttr("onclick","setTab(this);");
    }
    
    function resetIframe(obj) {
        obj.style.height = 800 + 'px';
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
</script>
