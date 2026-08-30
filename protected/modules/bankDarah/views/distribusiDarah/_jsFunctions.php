<script>
    
var checked = {};    
    
function cekKantongDarah(nomor,obj){
    var x = true;
    var barcode = $("#no_kantongdarah").val();
    $('.nomorbarcode').each(function(){        
        if ($(this).val() == nomor){                
            x = false;
            $('#tab_kantong_darah').removeClass("animation-loading");                
        }else{

        }
    });

    if (x == false){
        toastr.error('Kantong telah ada di List', "Perhatian!");
        $(obj).val('');
    }else{
        if (barcode !== "") {
            pilihKantongDarah(nomor);
            $(obj).val('');
        }
    }
}
    
function pilihKantongDarah(id) {
    checked = {};
    checked[id] = true;
    tambahKantongDarah();
}    

function tambahKantongDarah() {
    $.post('<?php echo $this->createUrl('ajaxKantongDarah'); ?>', {checked: checked}, function(data) {
        var cnt = 1;
        $("#tab_kantong_darah").append(data.html);
        $("#tab_kantong_darah tr").each(function() {
            $(this).find(".html_no").html(cnt++);
        });
        if (data.data !== "") {
            toastr.error("Nomor Kantong Darah tidak ditemukan", "Perhatian!");
            $("#no_kantongdarah").focus();
        } else {
            loadCeklisKantongDarah();
            checked = {};
        }
        $("#petugasdistribusi_nama").blur();
    }, 'json');
}

function ceklisKantongDarah(obj) {
    checked[$(obj).data('id')] = $(obj).is(":checked")
}

function loadCeklisKantongDarah() {
    var cnt = 1;
    $("#kantong-darah-grid tbody .cek_kantong").each(function() {
        var cb = $(this);
        var id = $(this).data("id");
        
        
        cb.prop("disabled", false);
        cb.prop("checked", false);
        
        if (checked[id] == true) {
            $(this).prop("checked", true);
        }
        
        $("#tab_kantong_darah tr").each(function() {
            if ($(this).data('id') == id) {
                cb.prop("disabled", true);
                cb.prop("checked", true);
            }
        });
    });
}

function listIDTabel() {
    var table_id = [];
    $("#tab_kantong_darah tr").each(function() {
        table_id.push($(this).data("id"));
   });
   
   return table_id.join(".");
}

function hapusKantong(obj) {
    $(obj).parents("tr").remove();
    loadCeklisKantongDarah();
}

function hitungShift(){
    var tgl_distribusi = $('#DistribusidarahT_tgl_distribusi').val();
    $.ajax({
        type: 'POST',
        data: {tgl_distribusi: tgl_distribusi},
        url: '<?php echo $this->createUrl('cekShift'); ?>',
        dataType: "json",
        success: function (data) {
            $('#DistribusidarahT_shift_distribusi').val(data.shift);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });
}

$(document).ready(function() {
    setValidasiCekDisabled($("#form-distribusi-darah"), function() {
        if ($("#tab_kantong_darah > tr").length == 0) {
            return false;
        }
        return true;
    });
});
</script>
