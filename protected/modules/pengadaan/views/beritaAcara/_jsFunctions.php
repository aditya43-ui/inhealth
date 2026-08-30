<?php
$baseUrl = Yii::app()->createUrl("/");
$gets = '';

$konfig = KonfigsystemK::model()->find();
?>
<script type='text/javascript'>
     var set_tabulasi = () => {
        let simplikasi = '<?= ($konfig->is_simplifikasipengadaan)?'ya':'tidak' ?>';
        
        if (simplikasi == 'ya'){
            $("#pembelian-langsung").addClass('hide').removeAttr('style');
            $("#kemajuan-hasil").addClass('hide').removeAttr('style');            
            $("#nota-dinas").addClass('hide').removeAttr('style');
            $("#uji-coba").addClass('hide').removeAttr('style');
            $("#pemeriksaan").addClass('hide').removeAttr('style');
            $("#hasil-periksa").addClass('hide').removeAttr('style');
            $("#nota-dinas-kpa").addClass('hide').removeAttr('style');            
            $("#penyerahan").addClass('hide').removeAttr('style');            
            $("#surat-denda").addClass('hide').removeAttr('style');
        }
        
    }
    
    function setDataSPK(data){
        if( $("#suratperjanjiankerja_id").val() != data.suratperjanjiankerja_id ){
            setTabReset();
            var frameObj = document.getElementById("frame");
            resetIframe(frameObj);
        }
        
        $("#suratperjanjiankerja_id").val(data.suratperjanjiankerja_id);
        $("#nosuratperjanjiankerja").val(data.nosuratperjanjiankerja);
        $("#tglsuratperjanjian").val(data.tglsuratperjanjian);
        $("#namapekerjaan").val(data.namapekerjaan);
        $("#nilaikontrak").val(data.nilaikontrak);
        $("#supplier_id").val(data.supplier_nama);
        $("#namapembuatkomitmen").val(data.direktursupplier);
        $("#alamat").val(data.alamat);
        $("#termin").val(data.termin);
        $('.integer-decimal').each(function(){
            $(this).val(formatThousandDecimal(parseFloat($(this).val())));
        });
    }
    
    function setTab(obj) {
        var suratperjanjiankerja_id = $("#suratperjanjiankerja_id").val();
        if (suratperjanjiankerja_id !== "") {
            $(obj).parents("ul").find("li").each(function () {
                $(this).removeClass("active");
                $(this).attr("onclick", "setTab(this);");
            });
            $(obj).addClass("active");
            $(obj).removeAttr("onclick", "setTab(this);");
            var tab = $(obj).attr("tab");
            var frameObj = document.getElementById("frame");
            resetIframe(frameObj);
            $(frameObj).attr("src", "<?php echo $baseUrl; ?>?r=" + tab + "&suratperjanjiankerja_id=" + suratperjanjiankerja_id);
            $(frameObj).parent().addClass("animation-loading");
            $(frameObj).load(function () {
                $(frameObj).parent().removeClass("animation-loading");
                resizeIframe(frameObj);
            });
        } else {
            myAlert("Silahkan pilih data Surat Perjanjian Kerja !");
        }
        return false;

    }

    function setTabReset() {
        $(".nav-tabs > .active").attr("onclick", "setTab(this);");
        $(".nav-tabs > .active").removeClass("active");
        
        $("#frame").attr("src", "");
    }

    function resetIframe(obj) {
        obj.style.height = 128 + 'px';
    }


    function resizeIframe(obj) {
        obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
    }
    
    set_tabulasi();
</script>
<?php
Yii::app()->clientScript->registerScript('onLoadJs', '
    resizeIframe(document.getElementById("frame"));  
    $("#frame").attr("src","");
', CClientScript::POS_READY);
?>