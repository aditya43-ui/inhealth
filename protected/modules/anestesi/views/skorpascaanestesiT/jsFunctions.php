<script type="text/javascript">
    function hitungTotal(text){
        if($("#SkoraldretteT_aldrette_sirkulasi_"+text).val() === ''){
            var sirkulasi = 0;
        }else{
            var sirkulasi = parseInt($("#SkoraldretteT_aldrette_sirkulasi_"+text).val());
        }
        if($("#SkoraldretteT_aldrette_kesadaran_"+text).val() === ''){
            var kesadaran = 0;
        }else{
            var kesadaran = parseInt($("#SkoraldretteT_aldrette_kesadaran_"+text).val());
        }
        if($("#SkoraldretteT_aldrette_oksigensi_"+text).val() === ''){
            var oksigensi = 0;
        }else{
            var oksigensi = parseInt($("#SkoraldretteT_aldrette_oksigensi_"+text).val());
        }
        if($("#SkoraldretteT_aldrette_pernafasan_"+text).val() === ''){
            var pernafasan = 0;
        }else{
            var pernafasan = parseInt($("#SkoraldretteT_aldrette_pernafasan_"+text).val());
        }
        if($("#SkoraldretteT_aldrette_aktifitas_"+text).val() === ''){
            var aktifitas = 0;
        }else{
            var aktifitas = parseInt($("#SkoraldretteT_aldrette_aktifitas_"+text).val());
        }
        var total = sirkulasi + kesadaran + oksigensi + pernafasan + aktifitas;
        $("#SkoraldretteT_aldrette_total_"+text).val(total);
    }
    
    function hitungTotalKeluar(){
        if($("#SkoraldretteT_aldrette_sirkulasi_keluar").val() === ''){
            var sirkulasi = 0;
        }else{
            var sirkulasi = parseInt($("#SkoraldretteT_aldrette_sirkulasi_keluar").val());
        }
        if($("#SkoraldretteT_aldrette_kesadaran_keluar").val() === ''){
            var kesadaran = 0;
        }else{
            var kesadaran = parseInt($("#SkoraldretteT_aldrette_kesadaran_keluar").val());
        }
        if($("#SkoraldretteT_aldrette_oksigensi_keluar").val() === ''){
            var oksigensi = 0;
        }else{
            var oksigensi = parseInt($("#SkoraldretteT_aldrette_oksigensi_keluar").val());
        }
        if($("#SkoraldretteT_aldrette_pernafasan_keluar").val() === ''){
            var pernafasan = 0;
        }else{
            var pernafasan = parseInt($("#SkoraldretteT_aldrette_pernafasan_keluar").val());
        }
        if($("#SkoraldretteT_aldrette_aktifitas_keluar").val() === ''){
            var aktifitas = 0;
        }else{
            var aktifitas = parseInt($("#SkoraldretteT_aldrette_aktifitas_keluar").val());
        }
        var total = sirkulasi + kesadaran + oksigensi + pernafasan + aktifitas;
        $("#SkoraldretteT_aldrette_total_keluar").val(total);
    }
    
    function setInit(){
        $("#SkoraldretteT_aldrette_total_0").val(0);
        $("#SkoraldretteT_aldrette_total_5").val(0);
        $("#SkoraldretteT_aldrette_total_15").val(0);
        $("#SkoraldretteT_aldrette_total_30").val(0);
        $("#SkoraldretteT_aldrette_total_45").val(0);
        $("#SkoraldretteT_aldrette_total_1").val(0);
        $("#SkoraldretteT_aldrette_total_2").val(0);
        $("#SkoraldretteT_aldrette_total_3").val(0);
        $("#SkoraldretteT_aldrette_total_4").val(0);
        $("#SkoraldretteT_aldrette_total_keluar").val(0);
    }
    
    $(document).ready(function(){
        setInit();
        $(".metode").find('input:checkbox').click(function () {
            var cek_lis = $(this).prop('checked');
            $(this).parents(".control-group").find('input:checkbox').each(function () {
                $(this).prop("checked", false);
            });
            if (cek_lis == true) {
                $(this).prop("checked", true);
            }
        }); 
        dropMulti('<?php echo CHtml::activeId($model, 'ruangan_id') ?>', {
            buttonWidth: '180px',
        });
        hitungTotalKeluar();
    });
</script>