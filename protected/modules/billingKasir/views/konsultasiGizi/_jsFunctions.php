<script type="text/javascript">
/**
 * set dropdown dokter ruangan
 * @param {type} ruangan_id
 * @param {type} pegawai_id
 * @returns {undefined}
 */
function setDropdownDokter(ruangan_id)
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetDropdownDokter'); ?>',
       data: {ruangan_id : ruangan_id},//
       dataType: "json",
       success:function(data){
           $("#<?php echo CHtml::activeId($modPasienMasukPenunjang,"pegawai_id");?>").html(data.listDokter);
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
 * set dropdown jeniskasuspenyakit_id
 * @param {type} ruangan_id
 * @returns {undefined} */
function setDropdownJeniskasuspenyakit(ruangan_id)
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetDropdownJeniskasuspenyakit'); ?>',
       data: {ruangan_id : ruangan_id},//
       dataType: "json",
       success:function(data){
           $("#<?php echo CHtml::activeId($modPasienMasukPenunjang,"jeniskasuspenyakit_id");?>").html(data.listKasuspenyakit);
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}    
/**
 * update (refresh) checklist pemeriksaan lab
 * harus include /js/jquery.tiler.js
 * @param {obj} form_checklist
 * di copy dari radiologi/pendaftaranRadiologiRujukanRS
 */
function updateChecklistPemeriksaanKonsultasiGizi(){
    $('#content-pemeriksaan-lab .checklists').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetChecklistPemeriksaanKonsultasiGizi'); ?>',
        data: {data:$("#form-caripemeriksaan :input").serialize()},
        dataType: "json",
        success:function(data){
            $('#content-pemeriksaan-lab .checklists').html(data.content);
            $('.checkboxlist-tile').tile({widths : [ 256 ]});
            $('#content-pemeriksaan-lab .checklists').removeClass("animation-loading");
            setCheckedPemeriksaan($("#form-tindakanpemeriksaan"));
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * menambahkan verifikasi tambahan untuk pemilihan tindakan
 * @returns {undefined}
 */
function setVerifikasi(){
    if(requiredCheck($("form"))){
        var pilihtindakan = $("#ispilihtindakan").val();
        if (pilihtindakan != 1){
            myAlert("Silakan pilih tindakan terlebih dahulu!");
            return false;
        } else {
            $("#konsultasigizi-form").submit();
        }    
    }
}

/**
 * Set checklist pemeriksaan lab
 * di copy dari radiologi/pendaftaranRadiologiRujukanRS
 */
function setChecklistPemeriksaanRad(){
    var penjamin_id = $("#penjamin_id").val();
    var ruangan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang,'ruangan_id') ?>").val();
    var kelaspelayanan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang,'kelaspelayanan_id') ?>").val();
    if(penjamin_id == "" && kelaspelayanan_id==""){
        myAlert("Silakan pilih data rujukan!");
        setChecklistPemeriksaanKonsultasiGiziReset();
    }else{
        $("#form-caripemeriksaan").find("input[name$='[ruangan_id]']").val(ruangan_id);
        $("#form-caripemeriksaan").find("input[name$='[penjamin_id]']").val(penjamin_id);
        $("#form-caripemeriksaan").find("input[name$='[kelaspelayanan_id]']").val(kelaspelayanan_id);
        updateChecklistPemeriksaanKonsultasiGizi();
    }
}
/**
 * reset pencarian & checklist pemeriksaan lab
 * di copy dari radiologi/pendaftaranRadiologiRujukanRS
 */
function setChecklistPemeriksaanKonsultasiGiziReset(){
    $("#form-caripemeriksaan").find("input:not(:disabled):not([readonly])").each(function(){
        $(this).val("");
    });
    updateChecklistPemeriksaanKonsultasiGizi();
}
/**
 * Centang pemeriksaan lab dari checkboxlist
 * di copy dari radiologi/pendaftaranRadiologiRujukanRS
 */
function pilihPemeriksaanIni(obj){
    var daftartindakan_nama = $(obj).parent().find('input[name$="[daftartindakan_nama]"]').val();
    var daftartindakan_id = $(obj).parent().find('input[name$="[daftartindakan_id]"]').val();
    var jenistarif_id = $(obj).parent().find('input[name$="[jenistarif_id]"]').val();
    var harga_tariftindakan = $(obj).parent().find('input[name$="[harga_tariftindakan]"]').val();
    var rowtindakan = [];
    rowtindakan = '<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowTindakanPemeriksaan',array('i'=>0,'modTindakan'=>$modTindakan),true));?>';
    if($(obj).is(':checked')){
        $("#form-tindakanpemeriksaan").find('tbody').append(rowtindakan);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][jenistarif_id]"]').val(jenistarif_id);$("#form-tindakanpemeriksaan").find('span[name$="[ii][daftartindakan_nama]"]').html(daftartindakan_nama);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][satuantindakan]"]').val("<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_satuan]"]').val(harga_tariftindakan);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_tindakan]"]').val(formatInteger(harga_tariftindakan));
        $("#form-tindakanpemeriksaan").find('a').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
        $("#ispilihtindakan").val(1);
    }else{
        var delete_row = $("#form-tindakanpemeriksaan").find('input[name$="[daftartindakan_id]"][value="'+daftartindakan_id+'"]').parents('tr');
        $("#ispilihtindakan").val("");
        delete_row.detach();
    }
    renameInputRow($("#form-tindakanpemeriksaan"));
}
/**
 * rename input row yang terakhir di tambahkan
 * @param {type} obj_table
 * di copy dari radiologi/pendaftaranRadiologiRujukanRS
 */
function renameInputRow(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span[name*="[ii]"]').each(function(){ //element <span>
            var new_name = $(this).attr("name").replace("ii",(row));
            $(this).attr("name",new_name);
        });
        $(this).find('span[name$="[daftartindakan_nama]"]').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 2){
                $(this).attr("name","["+row+"]["+old_name_arr[1]+"]");
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
    });
    
}
/**
 * set checked pemeriksaan yang sudah ada di daftar
 * di copy dari radiologi/pendaftaranRadiologiRujukanRS
 */
function setCheckedPemeriksaan(obj_table){
    $("div.checklists").find('input[name$="[is_pilih]"]').removeAttr('checked');
    $(obj_table).find('input[name$="[daftartindakan_id]"]').each(function(){
        var daftartindakan_id = $(this).val();
        $("div.checklists").find('input[name$="[is_pilih]"][value='+daftartindakan_id+']').attr('checked',true);
    });
    
}
/**
 * print status 
 */
function printStatus()
{
    var pendaftaran_id = $("#pendaftaran_id").val();
    if(pendaftaran_id != ""){
        window.open('<?php echo Yii::app()->createUrl('gizi/pendaftaranKonsultasiGizi/printStatus'); ?>&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=100,width=480,height=640');
    }else{
        myAlert("Silakan pilih data rujukan pasien!");
    }
}

function refreshHalaman(){
    myConfirm("Apakah Anda ingin mengulang ini?",
    "Perhatian!",
    function(r){
        if(r) window.location = window.location.href;
    }); 
}

/**
 * hapus tindakan dari database
 */
function hapusTindakan(obj,daftartindakan_id){
    myConfirm("Apakah Anda akan menghapus tindakan konsultasi gizi ini?",
    "Perhatian!",
    function(r){
        if(r){
          var tindakanpelayanan_id = daftartindakan_id
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('HapusTindakanPelayanan'); ?>',
                data: {tindakanpelayanan_id:tindakanpelayanan_id},
                dataType: "json",
                success:function(data){
                    if(data.sukses){
                        $(obj).parents('tr').detach();
                    }
                    myAlert(data.pesan);
                },
                error: function (jqXHR, textStatus, errorThrown) { 
                    console.log(errorThrown);
                }
            });
        }
    }); 

}

</script>