<script type="text/javascript">
/**
* load tindakan yang sudah tersimpan berdasarkan:
* - pasienmasukpenunjang_id
*/ 
function setTindakanPelayanan(){
    $('#form-tindakanpemeriksaan').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetTindakanPelayanan'); ?>',
        data: {pasienmasukpenunjang_id:$("#pasienmasukpenunjang_id").val()},
        dataType: "json",
        success:function(data){
            $('#form-tindakanpemeriksaan table > tbody').html(data.rows);
            $('#form-tindakanpemeriksaan').removeClass("animation-loading");
            renameInputRow($("#form-tindakanpemeriksaan"));
            <?php if($modKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK){ ?>
                        setFormHasilPemeriksaan();
            <?php } else if($modKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI) {?>
                        setFormHasilPemeriksaanPA();
            <?php } ?>
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
 
/**
* load pemeriksaan anamnesa yang sudah tersimpan berdasarkan:
* - pasienmasukpenunjang_id
*/ 
function setRiwayatAnamnesa(){
    $('#riwayat-anamnesa').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('setRiwayatAnamnesa'); ?>',
        data: {pasienmasukpenunjang_id:$("#pasienmasukpenunjang_id").val()},
        dataType: "json",
        success:function(data){
            $('#riwayat-anamnesa .content').html(data.rows);
            $('#riwayat-anamnesa').removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
* load pemeriksaan anamnesa yang sudah tersimpan berdasarkan:
* - pasienmasukpenunjang_id
*/ 
function setRiwayatPemeriksaanFisik(){
    $('#riwayat-pemeriksaan-fisik').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('setRiwayatPemeriksaanFisik'); ?>',
        data: {pasienmasukpenunjang_id:$("#pasienmasukpenunjang_id").val()},
        dataType: "json",
        success:function(data){
            $('#riwayat-pemeriksaan-fisik .content').html(data.rows);
            $('#riwayat-pemeriksaan-fisik').removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
* load pemeriksaan anamnesa yang sudah tersimpan berdasarkan:
* - pasienmasukpenunjang_id
*/ 
function setRiwayatDiagnosa(){
    $('#riwayat-diagnosa').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('setRiwayatDiagnosa'); ?>',
        data: {pasienmasukpenunjang_id:$("#pasienmasukpenunjang_id").val()},
        dataType: "json",
        success:function(data){
            $('#riwayat-diagnosa .content').html(data.rows);
            $('#riwayat-diagnosa').removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
<?php if($modKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK){ ?>
/**
* load detail hasil pemeriksaan:
* - pasienmasukpenunjang_id
*/
function setFormHasilPemeriksaan(){
    $('#form-hasilpemeriksaanlab').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetFormHasilPemeriksaan'); ?>',
        data: {pasienmasukpenunjang_id:$("#pasienmasukpenunjang_id").val()},
        dataType: "json",
        success:function(data){
            $('#form-hasilpemeriksaanlab table > tbody').html(data.rows);
            $('#<?php echo CHtml::activeId($modHasilPemeriksaan, 'hasilpemeriksaanlab_id'); ?>').val(data.hasilPemeriksaan.hasilpemeriksaanlab_id);
            $('#<?php echo CHtml::activeId($modHasilPemeriksaan, 'nohasilperiksalab'); ?>').val(data.hasilPemeriksaan.nohasilperiksalab);
            $('#<?php echo CHtml::activeId($modHasilPemeriksaan, 'statusperiksahasil'); ?>').val(data.hasilPemeriksaan.statusperiksahasil);
            $('#<?php echo CHtml::activeId($modHasilPemeriksaan, 'tglhasilpemeriksaanlab'); ?>').val(data.hasilPemeriksaan.tglhasilpemeriksaanlab);
            $('#<?php echo CHtml::activeId($modHasilPemeriksaan, 'tglpengambilanhasil'); ?>').val(data.hasilPemeriksaan.tglpengambilanhasil);
            $('#form-hasilpemeriksaanlab').removeClass("animation-loading");
            renameInputRowDetailHasil($("#form-hasilpemeriksaanlab"));

            $("#form-hasilpemeriksaanlab tbody tr").each(function() {
                var obj = $(this).find(".autogrow");
                if ($(obj).val() != "") {
                    setHasilPemeriksaan(obj);
                }
            });


            // setKeterangan(); //RND-13559 RSPMC-482
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

<?php } ?>
<?php if($modKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI){ ?>
/**
* load detail hasil pemeriksaan:
* - pasienmasukpenunjang_id
*/
function setFormHasilPemeriksaanPA(){
    $('#form-hasilpemeriksaanpa').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetFormHasilPemeriksaanPA'); ?>',
        data: {pasienmasukpenunjang_id:$("#pasienmasukpenunjang_id").val()},
        dataType: "json",
        success:function(data){
            $('#form-hasilpemeriksaanpa').html(data.rows);
            $('#form-hasilpemeriksaanpa').removeClass("animation-loading");
            renameInputRowDetailHasil($("#form-hasilpemeriksaanpa"));

            $("#form-hasilpemeriksaanpa .redactor textarea").redactor({
                toolbar : 'smini'
            });
            $('#form-hasilpemeriksaanpa .tglperiksa').each(function() {
                var obj = this;
                $(obj).datetimepicker(
                    jQuery.extend(
                        {
                            showMonthAfterYear: false
                        },
                        jQuery.datepicker.regional['id'],
                        {
                            'dateFormat': 'dd M yy',
                            'maxDate': 'd',
                            'timeText': 'Waktu',
                            'hourText': 'Jam',
                            'minuteText': 'Menit',
                            'secondText': 'Detik',
                            'showSecond': true,
                            'timeOnlyTitle': 'Pilih Waktu',
                            'timeFormat': 'hh:mm:ss',
                            'changeYear': true,
                            'changeMonth': true,
                            'showAnim': 'fold',
                            'yearRange': '-80y:+20y'
                        }
                    )
                );

                console.log($(obj).parents(".input-append").find(".add-on"));

                $(obj).parent().find(".add-on").click(function() {
                    $(obj).focus();
                });
            });
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

<?php } ?>

/**
 * rename input row yang terakhir di tambahkan
 * @param {type} obj_table
 */
function renameInputRowDetailHasil(obj_table){
    var row = 0;
    $(obj_table).find(".item_pa #no_urut").each(function(){
        $(this).val(row+1);
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+old_name_arr[1]+"_"+row+"_"+old_name_arr[3]);
                $(this).attr("name",old_name_arr[0]+"["+old_name_arr[1]+"]["+row+"]["+old_name_arr[3]+"]");
            }
        });
        row++;
    });
    
}

/**
* 
* 
*/

function setKeterangan(){
   var keterangan = '';
    $('#form-hasilpemeriksaanlab tbody > tr input[name$="[nilairujukan_keterangan]"]').each(function(){
       keterangan += "<li>"+$(this).val()+"</li>";
    });
    
    keterangan = "<ol>"+keterangan+"</ol>";
    var catatan = $('#<?php echo CHtml::activeId($modHasilPemeriksaan,'catatanlabklinik');?>');
    $(catatan).val(keterangan);
    var frame = $(catatan).parent().find(".redactor_frame");
    var body = frame.contents().find("body #page");
        body.html(keterangan);
}
/**
 * print hasil pemeriksaan 
 */
function printHasil()
{
    var pasienmasukpenunjang_id = $("#pasienmasukpenunjang_id").val();
    if(pasienmasukpenunjang_id != ""){
        <?php if($modKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK){ ?>
                    window.open('<?php echo $this->createUrl('/laboratorium/pencatatanHasilPemeriksaan/print'); ?>&pasienmasukpenunjang_id='+pasienmasukpenunjang_id,'printwin','left=100,top=0,width=768,height=640');
        <?php }else if($modKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI){ ?>
                    window.open('<?php echo $this->createUrl('/laboratorium/pencatatanHasilPemeriksaan/printPA'); ?>&pasienmasukpenunjang_id='+pasienmasukpenunjang_id,'printwin','left=100,top=0,width=1024,height=640');
        <?php } ?>
    }else{
        myAlert("Silakan pilih data kunjungan pasien!");
    }
}

function sethasilperiksa(i, data) {
    var hasil=$('.sethasil'+i).val();
    var result = data.split(' - ');
    console.log(result);
    console.log(hasil);
    if(hasil < result[0] || hasil > result[1]){
        // $('#LBDetailHasilPemeriksaanLabT_'+i+'_statushasilpemeriksaan').val("KRITIS");
        $('.setHasilPeriksa'+i).html("<i class='icon-form-silang'></i>");
        $('LBDetailHasilPemeriksaanLabT_'+i+'_setHasilPemeriksa').val("KRITIS");
        console.log("KRITIS");
    }else{
        // $('#LBDetailHasilPemeriksaanLabT_'+i+'_statushasilpemeriksaan').val("NORMAL"); 
        $('.setHasilPeriksa'+i).html("<i class=\"icon-form-check\"></i>");
        $('#LBDetailHasilPemeriksaanLabT_'+i+'_setHasilPemeriksa').val("NORMAL");
    }
    
    // alert( result[0] );

}

/**
 * Set hasil pemeriksaan
 */
function setHasilPemeriksaan(obj){
    var hasilpemeriksaan = $(obj).val();
    var nilairujukan_min = $(obj).parents("tr").find('.nilairujukan_min').val();
    var nilairujukan_max = $(obj).parents("tr").find('.nilairujukan_max').val();
    
    if(hasilpemeriksaan != '' && (nilairujukan_min > 0 || nilairujukan_max > 0)){
        if(isNaN(hasilpemeriksaan)){
            $(obj).parents("tr").find('.statushasilpemeriksaan').val('');
        }else{
            if(parseFloat(nilairujukan_max) >= parseFloat(hasilpemeriksaan) && parseFloat(hasilpemeriksaan) >= parseFloat(nilairujukan_min)){
                $(obj).parents("tr").find('.statushasilpemeriksaan').val('NORMAL');
                $(obj).parents("tr").find('.setHasilPeriksa').html("<i class=\"icon-form-check\"></i>");
            }else{
                $(obj).parents("tr").find('.statushasilpemeriksaan').val('KRITIS');
                $(obj).parents("tr").find('.setHasilPeriksa').html("<i class='icon-form-silang'></i>");
            }
        }
    }else{
        $(obj).parents("tr").find('.statushasilpemeriksaan').val('');
    }
    
    var countstatus_kritis = 0;
    var countstatus_normal = 0;
    // var countstatus_tidak_normal = 0;
    var countstatus_kosong = 0;
    var length = 0;
    $('#table-pemeriksaanhasillab > tbody > tr .statushasilpemeriksaan').each(function(){
        var status = $(this).val();
        // alert("dodol");
        // if(status == ''){
        //     countstatus_kosong++;
        // }
        if(status == 'KRITIS'){
            countstatus_kritis++;
        }
        if(status == 'NORMAL'){
            countstatus_normal++;
        }
        // if(status === 'TIDAK NORMAL'){
        //     countstatus_tidak_normal++;
        // }
        length++;
    });
    
    if(countstatus_kosong == 0){
        // alert(countstatus_kritis);
        if(countstatus_kritis >= 1){
            // alert('kritis');
            $("#LBHasilPemeriksaanLabT_statushasilpemeriksaan").val('KRITIS');
        }else{
            $("#LBHasilPemeriksaanLabT_statushasilpemeriksaan").val('NORMAL');
        }
    }else{
        $("#LBHasilPemeriksaanLabT_statushasilpemeriksaan").val('');
    }
}

function setHasilPemeriksaanDropdown(){
    
    var countstatus_kritis = 0;
    var countstatus_normal = 0;
    var countstatus_tidak_normal = 0;
    var countstatus_kosong = 0;
    var length = 0;
    $('#table-pemeriksaanhasillab > tbody > tr .statushasilpemeriksaan').each(function(){
        var status = $(this).val();
        if(status === ''){
            countstatus_kosong++;
        }
        if(status === 'KRITIS'){
            countstatus_kritis++;
        }
        if(status === 'NORMAL'){
            countstatus_normal++;
        }
        if(status === 'TIDAK NORMAL'){
            countstatus_tidak_normal++;
        }
        length++;
    });
    
    if(countstatus_kosong == 0){
        if(countstatus_kritis >= 1){
            $("#LBHasilPemeriksaanLabT_statushasilpemeriksaan").val('KRITIS');
        }else if(countstatus_tidak_normal >= 1){
            $("#LBHasilPemeriksaanLabT_statushasilpemeriksaan").val('TIDAK NORMAL');
        }else{
            $("#LBHasilPemeriksaanLabT_statushasilpemeriksaan").val('NORMAL');
        }
    }else{
        $("#LBHasilPemeriksaanLabT_statushasilpemeriksaan").val('');
    }
}

var interval_data = null;

function tandaTanganElektronik() {
    var pasienmasukpenunjang_id = $("#data_pasienmasukpenunjang_id").val();
    $(".btn_ttd").addClass("animation-loading");
    $.post('<?php echo $this->createUrl('cekTandaTanganDigital'); ?>', {id: pasienmasukpenunjang_id}, function(data) {
        if (data.ok == 0) {
            myAlert(data.msg);
        } else {
            $("#ttde_nomobile").html(data.no_telp);
            $("#tdde_verifikasi").val("");
            $(".switch_kirimulang").hide();
            $(".kirimulang_timing").show();
            $(".kirimulang_tombol a").removeClass("animation-loading");

            counter_kirimulang = data.limit;

            if (data.counter_baru == 1) {
                mulaiCounting();
            }

            
            $("#dialogTTDE").dialog("open");
        }

        $(".btn_ttd").removeClass("animation-loading");

    }, 'json');
}

function verifikasiTTD() {
    var verifikasi = $("#tdde_verifikasi").val();
    var pasienmasukpenunjang_id = $("#data_pasienmasukpenunjang_id").val();

    $(".btn_verifikasi").prop("disabled", true).addClass('animation-loading');
    $.post('<?php echo $this->createUrl('verifikasiTandaTanganDigital'); ?>', {
        id: pasienmasukpenunjang_id,
        verifikasi: verifikasi
    }, function(data) {
        if (data.ok == 0) {
            myAlert(data.msg);
        } else {
            $("#tdde_verifikasi").val("");
            $("#dialogTTDE").dialog("close");
            myAlert(data.msg);

            location.reload();
        }

        $(".btn_verifikasi").prop("disabled", false).removeClass("animation-loading");

    }, 'json');
}

var counter_kirimulang = 0;


function intervalCounter() {

    counter_kirimulang--;
    $("#kirim_ulang_menit").html(Math.floor(counter_kirimulang/60));
    $("#kirim_ulang_detik").html((counter_kirimulang % 60).toString().padStart(2, '0'));


    if (counter_kirimulang <= 0) {

        $(".switch_kirimulang").hide();
        $(".kirimulang_tombol").show();

        clearInterval(interval_data);
    }


}

function mulaiCounting() {


    $(".switch_kirimulang").hide();
    $(".kirimulang_timing").show();

    

    if (interval_data != null) {
        clearInterval(interval_data);
    }
    interval_data = setInterval(intervalCounter, 1000);

}

function kirimUlangVerifikasi() {
    $(".kirimulang_tombol a").addClass("animation-loading");
    tandaTanganElektronik();
}

function getInfoTTD() {
    var pasienmasukpenunjang_id = $("#data_pasienmasukpenunjang_id").val();

    $.post('<?php echo $this->createURL('getInfoTTD'); ?>', {
        id: pasienmasukpenunjang_id,
    }, function(data) {
        $("#dialog_info_ttd").html(data);
        $("#dialogInfoTTDE").dialog("open");
    });
}


/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){

<?php if(!empty($modKunjungan->pasienmasukpenunjang_id)){ ?>
    setRiwayatAnamnesa();
    setRiwayatPemeriksaanFisik();
    setRiwayatDiagnosa();
<?php } ?>
});
</script>