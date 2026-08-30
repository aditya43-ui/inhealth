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
//            setKeterangan(); //RND-13559
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
            $('#form-hasilpemeriksaanpa table > tbody').html(data.rows);
            $('#form-hasilpemeriksaanpa').removeClass("animation-loading");
            renameInputRowDetailHasil($("#form-hasilpemeriksaanpa"));
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
    $(obj_table).find("tbody > tr #no_urut").each(function(){
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
                    window.open('<?php echo $this->createUrl('/bankDarah/pencatatanHasilPemeriksaan/print'); ?>&pasienmasukpenunjang_id='+pasienmasukpenunjang_id,'printwin','left=100,top=0,width=768,height=640');
        <?php }else if($modKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI){ ?>
                    window.open('<?php echo $this->createUrl('/bankDarah/pencatatanHasilPemeriksaan/printPA'); ?>&pasienmasukpenunjang_id='+pasienmasukpenunjang_id,'printwin','left=100,top=0,width=1024,height=640');
        <?php } ?>
    }else{
		alert("d");
        myAlert("Silakan pilih data kunjungan pasien!");
    }
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