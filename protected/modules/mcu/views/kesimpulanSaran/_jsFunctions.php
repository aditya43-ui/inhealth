<script>
    function ubahLaporan(obj) {
        var pilih = $(obj).val();
        if (pilih == 1) {
            $('.hasilpemeriksaan').show();
            $('.suratstudi').hide();
            $("#MCSuratstudiluarmcuT_jenis_surat").val("");
        } else if (pilih == 2) {
            $('.hasilpemeriksaan').hide();
            $('.suratstudi').show();
            $("#MCSuratstudiluarmcuT_jenis_surat").val("suratstudiluar");
        }
    }
    
    function ubahKeteranganDisease(obj){
        var ubah = $(obj).prop('checked');
        if(ubah == true){
           $("#MCSuratstudiluarmcuT_otherdisease_keterangan").removeAttr('readonly');
           $("#MCSuratstudiluarmcuT_otherdisease_keterangan").val("");
        }else{
           $("#MCSuratstudiluarmcuT_otherdisease_keterangan").attr('readonly',true); 
           $("#MCSuratstudiluarmcuT_otherdisease_keterangan").val(""); 
        }
    }
    
    function ubahBloodMalaria(obj){
        var ubah = $(obj).prop('checked');
        if(ubah == true){
           $("#MCSuratstudiluarmcuT_blood_malaria_species").removeAttr('readonly');
           $("#MCSuratstudiluarmcuT_blood_malaria_species").val("");
        }else{
           $("#MCSuratstudiluarmcuT_blood_malaria_species").attr('readonly',true); 
           $("#MCSuratstudiluarmcuT_blood_malaria_species").val(""); 
        }
    }
    
    function ubahStoolParasites(obj){
        var ubah = $(obj).prop('checked');
        if(ubah == true){
           $("#MCSuratstudiluarmcuT_stool_parasites_species").removeAttr('readonly');
           $("#MCSuratstudiluarmcuT_stool_parasites_species").val("");
        }else{
           $("#MCSuratstudiluarmcuT_stool_parasites_species").attr('readonly',true); 
           $("#MCSuratstudiluarmcuT_stool_parasites_species").val(""); 
        }
    }
    
    function ubahKeteranganPhisical(obj){
        var ubah = $(obj).prop('checked');
        if(ubah == true){
            $("#MCSuratstudiluarmcuT_otherphyscal_keterangan").removeAttr('readonly');
            $("#MCSuratstudiluarmcuT_otherphyscal_keterangan").val("");
        }else{
            $("#MCSuratstudiluarmcuT_otherphyscal_keterangan").attr('readonly',true);
            $("#MCSuratstudiluarmcuT_otherphyscal_keterangan").val("");
        }
    }
    
    $(document).ready(function () {
        var jenis_surat = $("#MCSuratstudiluarmcuT_jenis_surat").val();
        var cek_other1 = $("#MCSuratstudiluarmcuT_otherdisease_yes").prop('checked');
        if(cek_other1 == true){
           $("#MCSuratstudiluarmcuT_otherdisease_keterangan").removeAttr('readonly');
        }else{
           $("#MCSuratstudiluarmcuT_otherdisease_keterangan").attr('readonly',true); 
           $("#MCSuratstudiluarmcuT_otherdisease_keterangan").val(""); 
        }
        var cek_other2 = $("#MCSuratstudiluarmcuT_otherphyscal_yes").prop('checked');
        if(cek_other2 == true){
            $("#MCSuratstudiluarmcuT_otherphyscal_keterangan").removeAttr('readonly');
        }else{
            $("#MCSuratstudiluarmcuT_otherphyscal_keterangan").attr('readonly',true);
            $("#MCSuratstudiluarmcuT_otherphyscal_keterangan").val("");
        }
        var cek_other3 = $("#MCSuratstudiluarmcuT_blood_malaria_positive").prop('checked');
        if(cek_other3 == true){
           $("#MCSuratstudiluarmcuT_blood_malaria_species").removeAttr('readonly');
        }else{
           $("#MCSuratstudiluarmcuT_blood_malaria_species").attr('readonly',true); 
           $("#MCSuratstudiluarmcuT_blood_malaria_species").val(""); 
        }
        var cek_other4 = $("#MCSuratstudiluarmcuT_stool_parasites_positive").prop('checked');
         if(cek_other4 == true){
           $("#MCSuratstudiluarmcuT_stool_parasites_species").removeAttr('readonly');
        }else{
           $("#MCSuratstudiluarmcuT_stool_parasites_species").attr('readonly',true); 
           $("#MCSuratstudiluarmcuT_stool_parasites_species").val(""); 
        }
        
        if(jenis_surat == 'suratstudiluar'){
            $('.hasilpemeriksaan').hide();
            $('.suratstudi').show();
            $('#jenis_checkup').val(2);
        }else{
            $('.hasilpemeriksaan').show();
            $('.suratstudi').hide();
            $('#jenis_checkup').val(1);
        }
        $(".heart-disease, .hypertension, .lung-disease, .asthma, .liver-disease, .diabetes, .kidney-disease, \n\
           .leprosy, .sexually, .pshychiatric, .hepatitis, .drug-use, .epilepsi, .malaria, .tubercolosis, \n\
            .hiv , .dengue").find('input:checkbox').click(function () {
            var cek_lis = $(this).prop('checked');
            $(this).parents(".control-group").find('input:checkbox').each(function () {
                $(this).prop("checked", false);
            });
            if (cek_lis == true) {
                $(this).prop("checked", true);
            }
        });
        
        $(".skin, .eyes, .ears, .lung, .liver, .spleen, .thyroid ,.lymph ,.external-genitalia ,.hemia ,.mental").find('input:checkbox').click(function () {
            var cek_lis = $(this).prop('checked');
            $(this).parents(".control-group").find('input:checkbox').each(function () {
                $(this).prop("checked", false);
            });
            if (cek_lis == true) {
                $(this).prop("checked", true);
            }
        });
        
        $(".serological-hiv, .hepatitis-b, .blood-malaria, .chest-xray, .stool-parasites,\n\
            .haematology , .urinalysis ,.pregnancy ,.amphetamine ,.morphine ,.mariyuana").find('input:checkbox').click(function () {
            var cek_lis = $(this).prop('checked');
            $(this).parents(".control-group").find('input:checkbox').each(function () {
                $(this).prop("checked", false);
            });
            if (cek_lis == true) {
                $(this).prop("checked", true);
            }
        });
        
        $(".serological-sifilis, .vdrl-tpha").find("input:checkbox").click(function() {
            var cek_lis = $(this).prop('checked');
            $(this).parent().find('input:checkbox').each(function () {
                $(this).prop("checked", false);
            });
            if (cek_lis == true) {
                $(this).prop("checked", true);
            }
        });
    });
</script>
