<script type="text/javascript">
/**
* rename input grid
*/ 
function renameInputRowObatAlkes(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
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
 * menghapus detail obat alkes pasien berdasarkan obatalkes_id
 * @param {type} caraPrint
 * @returns {undefined} */
function batalObatAlkesPasienDetail(obj){
    myConfirm('Apakah Anda akan membatalkan penjualan obat alkes ini?','Perhatian!',
    function(r){
        if(r){
            var obatalkes_id = $(obj).parents('tr').find('input[name$="[obatalkes_id]"]').val();
            $(obj).parents('tbody').find('input[name$="[obatalkes_id]"][value="'+obatalkes_id+'"]').each(function(){
                $(this).parents('tr').detach();
            });
            hitungTotal();
        }
    }); 
}

function hitungSubTotal(obj){
    unformatNumberSemua();
    harga = parseInt($(obj).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
    qty = parseInt($(obj).parents('tr').find('input[name$="[qty_oa]"]').val());
    diskon = parseInt($(obj).parents('tr').find('input[name$="[discount]"]').val());
    
    subtotal = $(obj).parents('tr').find('input[name$="[subtotal]"]');
    totalsubtotal = ((harga*qty) - ((harga*qty) * (diskon/100)));
    if(totalsubtotal <= 0){
        totalsubtotal = 0;
    }
    subtotal.val(totalsubtotal);
    
    hitungTotal();
    formatNumberSemua();
}

function hitungTotal(){
    unformatNumberSemua();
    totalharganetto = 0;
    totalhargajual = 0;
    $('#table-obatalkespasien > tbody > tr').each(function(){
        totalharganetto += parseFloat( $(this).find('input[name*="[harganetto_oa]"]').val() * $(this).find('input[name*="[qty_oa]"]').val() );
        totalhargajual += parseFloat($(this).find('input[name*="[hargajual_oa]"]').val());
        
    });
    
    formatNumberSemua();
}

/**
 * class integer di unformat 
 * @returns {undefined}
 */
function unformatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
}
/**
 * class integer di format kembali
 * @returns {undefined}
 */
function formatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    renameInputRowObatAlkes($("#table-obatalkespasien")); 
    var pasien_id = '<?php echo isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null; ?>';
    if(pasien_id != ''){
        $("#table-obatalkespasien .icon-trash").remove();
    }
    hitungTotal();
});
</script>