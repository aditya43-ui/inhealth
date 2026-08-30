<?php
/** 
 * view ini digunakan untuk menampung fungsi - fungsi javascript
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
$det = new ATPraanestesiInduksidetT;
?>
<script type='text/javascript'>
     function tambahBaris(obj){
        var row = '<?php echo CJSON::encode($this->renderPartial($this->path_view.'form/_rowDet',array('model'=>$det, 'i'=>1,'multiple'=>'yes'),true));?>';
        var kelompok = $(obj).parents("tr").find('.kelompok').val();
        $(obj).parents('.parent').append(row);        
        
        $(obj).parents('.parent').find("tr:last > td > .kelompok").val(kelompok);        
        
        var lokasi_input = $("#<?php echo str_replace(' ','_',strtolower(Params::INDUKSI_DET_LOKASI_INPUT)); ?>");
        var tempat_cvc = $("#<?php echo str_replace(' ','_',strtolower(Params::INDUKSI_DET_TEMPAT_CVC)); ?>");
        var tempat_arteri = $("#<?php echo str_replace(' ','_',strtolower(Params::INDUKSI_DET_TEMPAT_ARTERI_LINE)); ?>");
        
        renameInput(lokasi_input,0);        
        renameInput(tempat_cvc,lokasi_input.find('tbody > tr').length);
        renameInput(tempat_arteri,lokasi_input.find('tbody > tr').length+tempat_cvc.find('tbody > tr').length);       
        
        
    }
    
    function hapusBaris(obj){
        var id = $(obj).parents("tr").find('.id').val();
        
        myConfirm("Apakah Anda yakin, ingin menghapus data ini ?","Perhatian !",function(r){
            if (r){
                $(obj).parents("tr").remove();
                
                if (id != ''){
                    $("#tabel-hapus > tbody").append("<tr><td><input type='text' value='"+id+"' name='hapus[]'></td></tr>")
                }
                
                var lokasi_input = $("#<?php echo str_replace(' ','_',strtolower(Params::INDUKSI_DET_LOKASI_INPUT)); ?>");
                var tempat_cvc = $("#<?php echo str_replace(' ','_',strtolower(Params::INDUKSI_DET_TEMPAT_CVC)); ?>");
                var tempat_arteri = $("#<?php echo str_replace(' ','_',strtolower(Params::INDUKSI_DET_TEMPAT_ARTERI_LINE)); ?>");
                
                renameInput(lokasi_input,0);        
                renameInput(tempat_cvc,lokasi_input.find('tbody > tr').length);
                renameInput(tempat_arteri,lokasi_input.find('tbody > tr').length+tempat_cvc.find('tbody > tr').length);       
            }
        });
    }
    
    function renameInput(obj_table,row){
        
        var row = row;
        var i = 0;
        $(obj_table).find("tbody > tr").each(function(){                        
            $(this).find('.no_urut').html(row+1);
            $(this).attr('data-row',row);
            
            if (i != 0){
                $(this).find('.labeldefault').html('');
            }   
            
            $(this).find('.add-on').each(function(){ //element <input>
                var old_name = $(this).attr("id");
                if (typeof old_name !== 'undefined'){
                    var old_name_arr = old_name.split("_");

                    if(old_name_arr.length == 4){
                        $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]+"_"+old_name_arr[3]);

                    }
                }
            });
            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                    $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                }
            });                        
            
            row++;
            i++;
        });

        row = 0;
        $(obj_table).find('tbody > tr').each(function(){
            if (row == 0){
                $(this).find('.tambah').attr('style','display:block;border-radius:100%;padding:0px;');
                $(this).find('.hapus').attr('style','display:none;border-radius:100%;padding:0px;');
            }else if(row >= 1){
                $(this).find('.tambah').attr('style','display:none;border-radius:100%;padding:0px;');
                $(this).find('.hapus').attr('style','display:block;border-radius:100%;padding:0px;');
            }
            row++;
        });
        
        $('.numbers-only').keyup(function() {
            setNumbersOnly(this);
        });
        
        
    }
    
    function cekForm(){
        if (requiredCheck($("#peminjamanbrg-t-form"))){
            $('#peminjamanbrg-t-form').submit();
        }

       return false;
    }
    
    function cekAirwaySAD(obj){
        var cek = $(obj).prop("checked");
        
        $("#airway").find("input:radio.child-radio").each(function(){
            $(this).prop('checked',false);
        });
        
        $(obj).parents("#airway").find(".lainlain").attr("readonly",true);
        $(obj).parents("#airway").find(".ukuran").attr("readonly",true);
        $(obj).parents("#airway").find(".cuff").attr("readonly",true);
            
        if (cek == true){            
            $(obj).prop("checked",true);
            
            $(obj).parents("#airway").find(".lainlain").val('');
            if ($(obj).hasClass('adaket')){                
                $(obj).parents("#airway").find(".lainlain").removeAttr("readonly");
            }
            
            $(obj).parents("#airway").find(".ukuran").removeAttr("readonly");
            $(obj).parents("#airway").find(".cuff").removeAttr("readonly");
        }
    }
            
    $(document).ready(function(){
        <?php if (isset($_GET['sukses'])){ ?>
                $("#peminjamanbrg-t-form").find('input,select,textarea').each(function(){
                    $(this).attr('disabled',true);
                });
                
                $(".add-on").hide();
                $(".rowbutton").attr("style","display:none;");
        <?php } ?>
            
        $("#induksi, #alat, #ett").find("input:checkbox").on("click",function(){
            if ($(this).hasClass('adaket')){                               
                if ($(this).prop("checked") == true){
                    $(this).parents(".control-group").find('.lainlain').removeAttr('readonly');
                }else{
                    $(this).parents(".control-group").find('.lainlain').val('');
                    $(this).parents(".control-group").find('.lainlain').attr('readonly',true);
                }                               
            }else{
                $(this).parents(".control-group").find('.lainlain').val('');
                $(this).parents(".control-group").find('.lainlain').attr('readonly', true);
            }
        });
        
        $("#airway").find("input:radio.parent-radio").on("click",function(){
            var cek = $(this).prop("checked");
            var kel_data = $(this).attr('kel-data');
            
            $(this).parents("#airway").find(".lainlain").val("");
            $(this).parents("#airway").find(".ukuran").val("");
            $(this).parents("#airway").find(".cuff").val("");
            $(this).parents("#airway").find(".lainlain").attr("readonly",true);
            $(this).parents("#airway").find(".ukuran").attr("readonly",true);
            $(this).parents("#airway").find(".cuff").attr("readonly",true);
            
            $(this).parents('#airway').find(".parent-radio").each(function(){
                $(this).prop("checked",false);
            });
            
            $(this).parents('#airway').find(".airway_intubasi").attr("disabled",true);
            
            $(this).parents('#airway').find(".airway_sad").attr("disabled",true);            
            
            if (kel_data == 'airway_sad'){
                $(this).parents('#airway').find(".airway_intubasi").prop("checked",false);                                
                $(this).parents('#airway').find(".airway_sad").removeAttr("disabled");                
            }else if(kel_data == 'airway_intubasi'){
                $(this).parents('#airway').find(".airway_intubasi").removeAttr("disabled");                
                $(this).parents('#airway').find(".airway_sad").prop("checked",false);                
            }else{
                $(this).parents('#airway').find(".airway_sad").prop("checked",false);                
                $(this).parents('#airway').find(".airway_intubasi").prop("checked",false);  
            }
                                                                       
            if (cek == true){
                $(this).prop("checked",true);
            }
        });
        
        $("#alat").find(".parent-radio").on("click",function(){
            var cek = $(this).parents("#alat").find(".parent-radio:checked").length;
            
            if (cek > 0){
                $(this).parents("#alat").find(".alat").removeAttr("disabled");
            }else{
                $(this).parents("#alat").find("input:text").attr("readonly",true);
                $(this).parents("#alat").find("input:text").val('');
                $(this).parents("#alat").find(".alat").prop("checked",false);
                $(this).parents("#alat").find(".alat").attr("disabled",true);
            }
        });
        
        $("#alat").find(".alat").on("click",function(){
            var cek = $(this).parents("#alat").find(".alat:checked").length;
            
            if (cek > 0){                
                $(this).parents("#alat").find(".ukuran").removeAttr("readonly");
            }else{
                $(this).parents("#alat").find(".ukuran").attr("readonly",true);
            }
        });
        
        $("#ett").find(".parent-check").on("click",function(){
            var cek = $(this).parents("#ett").find(".parent-check:checked").length;
            
            if (cek > 0){
                $(this).parents("#ett").find(".ett").removeAttr("disabled");
                $(this).parents("#ett").find(".ett").removeAttr("readonly");
            }else{
                $(this).parents("#ett").find("input:text.ett").attr("readonly",true);
                $(this).parents("#ett").find("input:text.ett").val('');                
                $(this).parents("#ett").find("input:checkbox.ett").attr("disabled",true);
                $(this).parents("#ett").find("input:checkbox.ett").prop("checked",false);                
            }
        });
        
        
        $("#ett").find(".fixasi").on("click",function(){
            var cek = $(this).parents("#ett").find(".fixasi:checked").length;
            
            if (cek > 0){                
                $(this).parents("#ett").find(".fixasi-ket").removeAttr("readonly");
            }else{
                $(this).parents("#ett").find('.fixasi-ket').val('');
                $(this).parents("#ett").find(".fixasi-ket").attr("readonly",true);
            }
        });
        
        var lokasi_input = $("#<?php echo str_replace(' ','_',strtolower(Params::INDUKSI_DET_LOKASI_INPUT)); ?>");
        var tempat_cvc = $("#<?php echo str_replace(' ','_',strtolower(Params::INDUKSI_DET_TEMPAT_CVC)); ?>");
        var tempat_arteri = $("#<?php echo str_replace(' ','_',strtolower(Params::INDUKSI_DET_TEMPAT_ARTERI_LINE)); ?>");
        
        renameInput(lokasi_input,0);        
        renameInput(tempat_cvc,lokasi_input.find('tbody > tr').length);
        renameInput(tempat_arteri,lokasi_input.find('tbody > tr').length+tempat_cvc.find('tbody > tr').length);       
        cekPerubahan();
    });
    
    function cekPerubahan(){
        //Teknik Induksi
        var master_o2 = $('#ATPraanestesiInduksiT_teknikinduksi_master_o2');
        if (master_o2.is(" :checked")) {
            $(".master_o2").removeAttr("readonly");
        } else {
            $(".master_o2").attr('readonly',true);
        }
        var nasal_o2 = $('#ATPraanestesiInduksiT_teknikinduksi_nasal_o2');
        if (nasal_o2.is(" :checked")) {
            $(".nasal_o2").removeAttr("readonly");
        } else {
            $(".nasal_o2").attr('readonly',true);
        }
        
        //ETT
        var ett_ukuran = $('#ATPraanestesiInduksiT_ett_ukuran').val();
        if(ett_ukuran !== ''){
            $("#ATPraanestesiInduksiT_ett_ukuran").removeAttr("readonly");
        }else{
            $("#ATPraanestesiInduksiT_ett_ukuran").attr('readonly',true);
        }
        
        var ett_cuff = $('#ATPraanestesiInduksiT_ett_cuff').val();
        if(ett_cuff !== ''){
            $("#ATPraanestesiInduksiT_ett_cuff").removeAttr("readonly");
        }else{
            $("#ATPraanestesiInduksiT_ett_cuff").attr('readonly',true);
        }
        
        var ett_upaya = $('#ATPraanestesiInduksiT_ett_upaya').val();
        if(ett_upaya !== ''){
            $("#ATPraanestesiInduksiT_ett_upaya").removeAttr("readonly");
        }else{
            $("#ATPraanestesiInduksiT_ett_upaya").attr('readonly',true);
        }
        
        var ett_oral = $('#ATPraanestesiInduksiT_ett_oral');
        if (ett_oral.is(" :checked")) {
            $("#ATPraanestesiInduksiT_ett_oral").removeAttr("disabled");
        } else {
            $("#ATPraanestesiInduksiT_ett_oral").attr('disabled',true);
        }
        
        var ett_nasal= $('#ATPraanestesiInduksiT_ett_nasal');
        if (ett_nasal.is(" :checked")) {
            $("#ATPraanestesiInduksiT_ett_nasal").removeAttr("disabled");
        } else {
            $("#ATPraanestesiInduksiT_ett_nasal").attr('disabled',true);
        }
        
        var fixasi = $('#ATPraanestesiInduksiT_ett_fixasi');
        if (fixasi.is(" :checked")) {
            $(".fixasi-ket").removeAttr("readonly");
        } else {
            $(".fixasi-ket").attr('readonly',true);
        }
        
        var lainnya = $('#ATPraanestesiInduksiT_posisi_induksi_lainnya_keterangan').val();
        if(lainnya !== ''){
            $("#ATPraanestesiInduksiT_posisi_induksi_lainnya_keterangan").removeAttr("readonly");
        } else {
            $("#ATPraanestesiInduksiT_posisi_induksi_lainnya_keterangan").attr('readonly',true);
        }
        
        //Jenis Alat
        var jenis_alat_blade = $('#ATPraanestesiInduksiT_jenis_alat_blade');
        if (jenis_alat_blade.is(" :checked")) {
            $("#ATPraanestesiInduksiT_jenis_alat_blade").removeAttr("disabled");
        } else {
            $("#ATPraanestesiInduksiT_jenis_alat_blade").attr('disabled',true);
        }
        
        var jenis_alat_miler = $('#ATPraanestesiInduksiT_jenis_alat_miler');
        if (jenis_alat_miler.is(" :checked")) {
            $("#ATPraanestesiInduksiT_jenis_alat_miler").removeAttr("disabled");
        } else {
            $("#ATPraanestesiInduksiT_jenis_alat_miler").attr('disabled',true);
        }
        
        var jenis_alat_mcoy = $('#ATPraanestesiInduksiT_jenis_alat_mcoy');
        if (jenis_alat_mcoy.is(" :checked")) {
            $("#ATPraanestesiInduksiT_jenis_alat_mcoy").removeAttr("disabled");
        } else {
            $("#ATPraanestesiInduksiT_jenis_alat_mcoy").attr('disabled',true);
        }
        
        var jenis_alat_lainnya = $('#ATPraanestesiInduksiT_jenis_alat_lainnya');
        if (jenis_alat_lainnya.is(" :checked")) {
            $("#ATPraanestesiInduksiT_jenis_alat_lainnya").removeAttr("disabled");
        } else {
            $("#ATPraanestesiInduksiT_jenis_alat_lainnya").attr('disabled',true);
        }
        
        var jenis_alat_lainnya_ket = $('#ATPraanestesiInduksiT_jenis_alat_lainnya_keterangan').val();
        if(jenis_alat_lainnya_ket !== ''){
            $("#ATPraanestesiInduksiT_jenis_alat_lainnya_keterangan").removeAttr("readonly");
        } else {
            $("#ATPraanestesiInduksiT_jenis_alat_lainnya_keterangan").attr('readonly',true);
        }
        
        var alat_ukuran = $('#ATPraanestesiInduksiT_alat_ukuran').val();
        if(alat_ukuran !== ''){
            $("#ATPraanestesiInduksiT_alat_ukuran").removeAttr("readonly");
        } else {
            $("#ATPraanestesiInduksiT_alat_ukuran").attr('readonly',true);
        }
        
        //SAD
        var sad_lainnya_keterangan = $('#ATPraanestesiInduksiT_airway_sad_lainnya_keterangan').val();
        if(sad_lainnya_keterangan !== ''){
            $("#ATPraanestesiInduksiT_airway_sad_lainnya_keterangan").removeAttr("readonly");
        } else {
            $("#ATPraanestesiInduksiT_airway_sad_lainnya_keterangan").attr('readonly',true);
        }
        
        var airway_cuff = $('#ATPraanestesiInduksiT_airway_cuff').val();
        if(airway_cuff !== ''){
            $("#ATPraanestesiInduksiT_airway_cuff").removeAttr("readonly");
        } else {
            $("#ATPraanestesiInduksiT_airway_cuff").attr('readonly',true);
        }
        
        var airway_ukuran = $('#ATPraanestesiInduksiT_airway_ukuran').val();
        if(airway_ukuran !== ''){
            $("#ATPraanestesiInduksiT_airway_ukuran").removeAttr("readonly");
        } else {
            $("#ATPraanestesiInduksiT_airway_ukuran").attr('readonly',true);
        }
        
        var airway_sad_lainnya = $('#ATPraanestesiInduksiT_airway_sad_lainnya');
        if (airway_sad_lainnya.is(" :checked")) {
            $("#ATPraanestesiInduksiT_airway_sad_lainnya").removeAttr("disabled");
        } else {
            $("#ATPraanestesiInduksiT_airway_sad_lainnya").attr('disabled',true);
        }
        
        var airway_sad_igel = $('#ATPraanestesiInduksiT_airway_sad_igel');
        if (airway_sad_igel.is(" :checked")) {
            $("#ATPraanestesiInduksiT_airway_sad_igel").removeAttr("disabled");
        } else {
            $("#ATPraanestesiInduksiT_airway_sad_igel").attr('disabled',true);
        }
        
        var airway_sad_lma = $('#ATPraanestesiInduksiT_airway_sad_lma');
        if (airway_sad_lma.is(" :checked")) {
            $("#ATPraanestesiInduksiT_airway_sad_lma").removeAttr("disabled");
        } else {
            $("#ATPraanestesiInduksiT_airway_sad_lma").attr('disabled',true);
        }
        
        //Intubasi
        var airway_intubasi_sleep = $('#ATPraanestesiInduksiT_airway_intubasi_sleep');
        if (airway_intubasi_sleep.is(" :checked")) {
            $("#ATPraanestesiInduksiT_airway_intubasi_sleep").removeAttr("disabled");
        } else {
            $("#ATPraanestesiInduksiT_airway_intubasi_sleep").attr('disabled',true);
        }
        
        var airway_intubasi_apnae = $('#ATPraanestesiInduksiT_airway_intubasi_apnae');
        if (airway_intubasi_apnae.is(" :checked")) {
            $("#ATPraanestesiInduksiT_airway_intubasi_apnae").removeAttr("disabled");
        } else {
            $("#ATPraanestesiInduksiT_airway_intubasi_apnae").attr('disabled',true);
        }
        
        var airway_intubasi_oral = $('#ATPraanestesiInduksiT_airway_intubasi_oral');
        if (airway_intubasi_oral.is(" :checked")) {
            $("#ATPraanestesiInduksiT_airway_intubasi_oral").removeAttr("disabled");
        } else {
            $("#ATPraanestesiInduksiT_airway_intubasi_oral").attr('disabled',true);
        }
        
        var airway_intubasi_direct = $('#ATPraanestesiInduksiT_airway_intubasi_direct');
        if (airway_intubasi_direct.is(" :checked")) {
            $("#ATPraanestesiInduksiT_airway_intubasi_direct").removeAttr("disabled");
        } else {
            $("#ATPraanestesiInduksiT_airway_intubasi_direct").attr('disabled',true);
        }
        
        var airway_intubasi_rsi = $('#ATPraanestesiInduksiT_airway_intubasi_rsi');
        if (airway_intubasi_rsi.is(" :checked")) {
            $("#ATPraanestesiInduksiT_airway_intubasi_rsi").removeAttr("disabled");
        } else {
            $("#ATPraanestesiInduksiT_airway_intubasi_rsi").attr('disabled',true);
        }
        
        var airway_intubasi_awake = $('#ATPraanestesiInduksiT_airway_intubasi_awake');
        if (airway_intubasi_awake.is(" :checked")) {
            $("#ATPraanestesiInduksiT_airway_intubasi_awake").removeAttr("disabled");
        } else {
            $("#ATPraanestesiInduksiT_airway_intubasi_awake").attr('disabled',true);
        }
        
        var airway_intubasi_non_apnae = $('#ATPraanestesiInduksiT_airway_intubasi_non_apnae');
        if (airway_intubasi_non_apnae.is(" :checked")) {
            $("#ATPraanestesiInduksiT_airway_intubasi_non_apnae").removeAttr("disabled");
        } else {
            $("#ATPraanestesiInduksiT_airway_intubasi_non_apnae").attr('disabled',true);
        }
        
        var airway_intubasi_nasal = $('#ATPraanestesiInduksiT_airway_intubasi_nasal');
        if (airway_intubasi_nasal.is(" :checked")) {
            $("#ATPraanestesiInduksiT_airway_intubasi_nasal").removeAttr("disabled");
        } else {
            $("#ATPraanestesiInduksiT_airway_intubasi_nasal").attr('disabled',true);
        }
        
        var airway_intubasi_blind = $('#ATPraanestesiInduksiT_airway_intubasi_blind');
        if (airway_intubasi_blind.is(" :checked")) {
            $("#ATPraanestesiInduksiT_airway_intubasi_blind").removeAttr("disabled");
        } else {
            $("#ATPraanestesiInduksiT_airway_intubasi_blind").attr('disabled',true);
        }
        
        var airway_intubasi_croidpres = $('#ATPraanestesiInduksiT_airway_intubasi_croidpres');
        if (airway_intubasi_croidpres.is(" :checked")) {
            $("#ATPraanestesiInduksiT_airway_intubasi_croidpres").removeAttr("disabled");
        } else {
            $("#ATPraanestesiInduksiT_airway_intubasi_croidpres").attr('disabled',true);
        }
    }
</script>
