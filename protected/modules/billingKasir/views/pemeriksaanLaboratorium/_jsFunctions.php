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
 * di copy dari laboratorium/view/PendaftaranLaboratorium/_jsFunctions.
 */
function updateChecklistPemeriksaanLab(){
    $('#content-pemeriksaan-lab .checklists').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('/billingKasir/pemeriksaanLaboratorium/SetChecklistPemeriksaanLab'); ?>',
        data: {data:$("#form-caripemeriksaan :input").serialize()},
        dataType: "json",
        success:function(data){
            $('#content-pemeriksaan-lab .checklists').html(data.content);
            $('.checkboxlist-tile').tile({widths : [ 190 ]});
            $('#content-pemeriksaan-lab .checklists').removeClass("animation-loading");
            setCheckedPemeriksaan($("#form-tindakanpemeriksaan"));
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * Set checklist pemeriksaan lab
 * di copy dari laboratorium/view/PendaftaranLaboratorium/_jsFunctions.
 */
function setChecklistPemeriksaanLab(){
    var penjamin_id = $("#penjamin_id").val();
    var ruangan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang,'ruangan_id') ?>").val();
    var kelaspelayanan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang,'kelaspelayanan_id') ?>").val();
    if(penjamin_id == "" && kelaspelayanan_id==""){
        myAlert("Silakan pilih data rujukan!");
        setChecklistPemeriksaanLabReset();
    }else{
        $("#form-caripemeriksaan").find("input[name$='[ruangan_id]']").val(ruangan_id);
        $("#form-caripemeriksaan").find("input[name$='[penjamin_id]']").val(penjamin_id);
        $("#form-caripemeriksaan").find("input[name$='[kelaspelayanan_id]']").val(kelaspelayanan_id);
        updateChecklistPemeriksaanLab();
    }
}
/**
 * reset pencarian & checklist pemeriksaan lab
 * di copy dari laboratorium/view/PendaftaranLaboratorium/_jsFunctions.
 */
function setChecklistPemeriksaanLabReset(){
    $("#form-caripemeriksaan").find("input:not(:disabled):not([readonly])").each(function(){
        $(this).val("");
    });
    updateChecklistPemeriksaanLab();
}
/**
 * Centang pemeriksaan lab dari checkboxlist
 * di copy dari laboratorium/view/PendaftaranLaboratorium/_jsFunctions.
 */
function pilihPemeriksaanIni(obj){
    var pemeriksaanlab_id = $(obj).val();
    var pemeriksaanlab_nama = $(obj).parent().find('input[name$="[pemeriksaanlab_nama]"]').val();
    var daftartindakan_id = $(obj).parent().find('input[name$="[daftartindakan_id]"]').val();
    var jenistarif_id = $(obj).parent().find('input[name$="[jenistarif_id]"]').val();
    var harga_tariftindakan = $(obj).parent().find('input[name$="[harga_tariftindakan]"]').val();
    var rowtindakan = [];
    rowtindakan = '<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowTindakanPemeriksaan',array('i'=>0,'modTindakan'=>$modTindakan),true));?>';
    if($(obj).is(':checked')){
        $("#form-tindakanpemeriksaan").find('tbody').append(rowtindakan);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][pemeriksaanlab_id]"]').val(pemeriksaanlab_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][jenistarif_id]"]').val(jenistarif_id);$("#form-tindakanpemeriksaan").find('span[name$="[ii][pemeriksaanlab_nama]"]').html(pemeriksaanlab_nama);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][satuantindakan]"]').val("<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_satuan]"]').val(harga_tariftindakan);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_tindakan]"]').val(formatInteger(harga_tariftindakan));
        $("#form-tindakanpemeriksaan").find('a').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
    }else{
        var delete_row = $("#form-tindakanpemeriksaan").find('input[name$="[pemeriksaanlab_id]"][value="'+pemeriksaanlab_id+'"]').parents('tr');
        delete_row.detach();
    }
    renameInputRow($("#form-tindakanpemeriksaan"));
}
/**
 * rename input row yang terakhir di tambahkan
 * @param {type} obj_table
 * di copy dari laboratorium/view/PendaftaranLaboratorium/_jsFunctions.
 */
function renameInputRow(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span').each(function(){ //element <span>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
            }
        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 4){
                $(this).attr("id",old_name_arr[0]+"_"+old_name_arr[1]+"_"+row+"_"+old_name_arr[3]);
                $(this).attr("name",old_name_arr[0]+"["+old_name_arr[1]+"]["+row+"]["+old_name_arr[3]+"]");
            }
        });
        row++;
    });
    
}
/**
 * set checked pemeriksaan yang sudah ada di daftar
 * di copy dari laboratorium/view/PendaftaranLaboratorium/_jsFunctions.
 */
function setCheckedPemeriksaan(obj_table){
    $("div.checklists").find('input[name$="[is_pilih]"]').removeAttr('checked');
    $(obj_table).find('input[name$="[pemeriksaanlab_id]"]').each(function(){
        var pemeriksaanlab_id = $(this).val();
        $("div.checklists").find('input[name$="[is_pilih]"][value='+pemeriksaanlab_id+']').attr('checked',true);
    });
    
}

/**
 * bersihkan tabel tindakan pemeriksaan jika ada perubahan kelaspelayanan, ruangan 
 * di copy dari laboratorium/view/PendaftaranLaboratorium/_jsFunctions.
 **/
function setTindakanPemeriksaanReset(){
    $("#form-tindakanpemeriksaan tbody").html("");
    setTimeout(function(){setCheckedPemeriksaanDariPermintaan();}, 3000);//auto check permintaan
}

/**
 * print status 
 * di copy dari laboratorium/view/PendaftaranLaboratorium/_jsFunctions.
 */
function printStatus()
{
    var pendaftaran_id = $("#pendaftaran_id").val();
    if(pendaftaran_id != ""){
        window.open('<?php echo Yii::app()->createUrl('laboratorium/pendaftaranLaboratorium/printStatusLab'); ?>&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=100,width=480,height=640');
    }else{
        myAlert("Silakan pilih data rujukan pasien!");
    }
}

function refreshHalaman(){
    myConfirm("Apakah Anda ingin mengulang ini?",
    "Perhatian!",
    function(r){
        if(r){
            window.location = window.location.href;
        }else{

        }
    }); 
}

/**
 * hapus tindakan dari database
 */
function hapusTindakan(obj,daftartindakan_id){
    myConfirm("Apakah Anda akan menghapus tindakan dan pemakaian bahan ini?",
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

function formSubmit(){
    if(requiredCheck($("form"))){
        var jumlah_obat = $('#tabelpemeriksaanlab tbody tr').length;
        if(jumlah_obat <= 0){
                myAlert('Silakan pilih pemeriksaan terlebih dahulu!');
            return false;
        }else{
            $('#pemeriksaanlaboratorium-form').submit();
        }
        
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;
    
}

function clearTabelPemeriksaan(){
	$('#tabelpemeriksaanlab tbody tr').detach();
}

</script>