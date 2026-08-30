<?php
/**
 * Fungsi JS untuk form transaksi Mutasi Aset
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * 
 */
?>

<script>

var refreshLokasi = (jenis) => {
    
    var lokasi_aset_pj = '';
    if (jenis == 'asal'){
        lokasi_aset_pj = true;
    }

    $.fn.yiiGridView.update('lokasi-grid', {
        data: {
            'LokasiasetM[lokasi_aset_pj]': lokasi_aset_pj
        }
    });
} 

var refreshAset = () => {
    var lokasiasal_id = $(".lokasiasal_id").val();
    var def = 'kosong';

    if (lokasiasal_id != ''){
        def = '';
    }

    $.fn.yiiGridView.update('daftarperalatan-grid', {
        data: {
            'MAInvperalatanT[lokasi_id]': lokasiasal_id,
            'MAInvperalatanT[default]': def
        }
    });
} 

var setJenis = (jenis) => {
    $("#jenis").val(jenis);
    
    refreshLokasi(jenis);
}

var row = <?php echo CJSON::encode(array('html'=>$this->renderPartial('ajaxLoadAset', array(), true))); ?>;

$("#instalasiasal_id, #MutasiasetT_ruanganasal_id").change(function() {
    $("#MutasiasetT_pegmenyerahkan_id, #MutasiasetT_pegmenyerahkan_nama").val("");
    $("#a_instalasi_id").val($("#instalasiasal_id").val());
    $("#a_ruangan_id").val($("#MutasiasetT_ruanganasal_id").val());
    $("#barang_ruangan_id").val($("#MutasiasetT_ruanganasal_id").val());
    $("#tableDetailBarang tbody").empty();
    tambahRowBarang();
    $.fn.yiiGridView.update("pegawaiserah-grid", {data: $("#dialogPegawaiMenyerahkan :input").serialize()});
    $("#peralatankecuali_id").val("");
    updateDialogPeralatan();
    $('#MutasiasetT_pegmenyerahkan_nama').blur();
    
    
});
$("#instalasitujuan_id, #MutasiasetT_ruangantujuan_id").change(function() {
    $("#MutasiasetT_pegpenerima_nama, #MutasiasetT_pegpenerima_id").val("");
    $("#b_instalasi_id").val($("#instalasitujuan_id").val());
    $("#b_ruangan_id").val($("#MutasiasetT_ruangantujuan_id").val());
    $.fn.yiiGridView.update("pegawaiterima-grid", {data: $("#dialogPegawaiTerima :input").serialize()});
    $('#MutasiasetT_pegmenyerahkan_nama').blur();
});


function tambahRowBarang(obj) {
    var last = "";
    
    if (obj != null) {
        $(obj).parents("tr").after(row.html);
        renameInputRow($("#tableDetailBarang"))
        last = $("#tableDetailBarang tbody tr").eq($(obj).parents("tr").index() + 1);
        console.log($(obj).parents("tr").index());
    } else {
        $("#tableDetailBarang tbody").append(row.html);
        renameInputRow($("#tableDetailBarang"));
        last = $("#tableDetailBarang tbody tr:last-child");
    }
    
    
    jQuery(last).find('.invperalatan_nama').autocomplete(
        {
            'showAnim':'fold',
            'minLength':3,
            'focus':function(event, ui )
            {
                $(this).val( ui.item.label);
            },
            'select':function( event, ui )
            {
                $(this).parents("tr").find(".invperalatan_id").val(ui.item.invbarang_id);
                $(this).val(ui.item.invperalatan_namabrg);
                setBarang($(this), ui.item);
                return false;
            },
            'source':function(request, response)
            {
                $.ajax({
                    url: "<?php echo $this->createUrl('ajaxGetPeralatan'); ?>",
                    dataType: "json",
                    data: {
                        term: request.term,
                        lokasi_id: $(".lokasiasal_id").val(),
                        peralatankecuali_id: $("#peralatankecuali_id").val()
                    },
                    success: function (data) {
                        response(data);
                    }
                })
            }
        }
    );
}

function renameInput() {
    var cnt = 0;
    $("#tableDetailBarang tbody tr").each(function() {
        $(this).find(".invperalatan_id").prop("name", "MutasiasetperalatanT[" + cnt + "][invperalatan_id]");
        $(this).find(".invperalatan_nama").prop("name", "MutasiasetperalatanT[" + cnt + "][invperalatan_nama]");
        $(this).find(".mutasi_keadaan").prop("name", "MutasiasetperalatanT[" + cnt + "][mutasi_keadaan]");
        $(this).find(".ket_mutasi").prop("name", "MutasiasetperalatanT[" + cnt + "][ket_mutasi]");
        $(this).data('row', cnt);
        cnt++;
    });
}

var renameInputRow = (obj_table) => {
    var row = 0;
    var count = $(obj_table).find("tbody > tr").length;

    $(obj_table).find("tbody > tr").each(function(){                
        $(this).find(".nomor").html(row+1);
        $(this).attr("row-data",row);
        $(this).find('input,select,textarea').each(function(){ //element <input>
            if (typeof $(this).attr("name") !== 'undefined'){
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");

                if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                    $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                }
            }
        });

        $(this).find('.btn-tambah').removeClass('hide');
        $(this).find('.btn-hapus').removeClass('hide');
        if (row == 0) {
            if (count == 1){                
                $(this).find('.btn-hapus').addClass('hide');                    
            }else{
                $(this).find('.btn-tambah').addClass('hide');
            }
        }else{                
            if (count != (row+1)){
                $(this).find('.btn-tambah').addClass('hide');  
            }
        }

        row++;
    });

}


$(document).ready(function() {
    setValidasiCekDisabled($("#mutasiaset-t-form"));
    renameInputRow($("#tableDetailBarang"));
});
    
    
var row_no = 0;
function setDialog(obj) {
    row_no = $(obj).parents("tr").attr('row-data');
    
    $("#dialogPeralatan").dialog("open");
}

function setPeralatan(data) {
    console.log(data);
    $("#tableDetailBarang tbody tr").each(function() {        
        
        if ($(this).attr('row-data') == row_no) {
            $(this).find(".invperalatan_nama").val(data.invperalatan_namabrg);
            setBarang($(this).find(".mutasi_keadaan"), data);
            
            $("#MutasiasetT_pegmenyerahkan_nama").blur();
        }
    });
}

function setBarang(obj, data) {
    $(obj).parents("tr").find(".no_aset").html(data.invperalatan_kode);
    $(obj).parents("tr").find(".merk").html(data.invperalatan_merk + " / " + data.invperalatan_ukuran + " / " + data.invperalatan_bahan);
    $(obj).parents("tr").find(".thn_beli").html(data.invperalatan_thnpembelian);
    $(obj).parents("tr").find(".mutasi_keadaan").val(data.invperalatan_keadaan);
    $(obj).parents("tr").find(".invperalatan_id").val(data.invperalatan_id);
    
    updateDialogPeralatan();
}

function updateDialogPeralatan() {
    var id = [];
    $("#tableDetailBarang .invperalatan_id").each(function() {
        if ($(this).val() != "") {
            id.push($(this).val());
        }
    });
    
    $("#peralatankecuali_id").val(id.join("."));
    
    $.fn.yiiGridView.update("daftarperalatan-grid", {data: $("#dialogPeralatan :input").serialize()});
}

function batalRowBarang(obj) {
    $(obj).parents("tr").remove();
    renameInputRow($("#tableDetailBarang"));
    updateDialogPeralatan();
}




</script>