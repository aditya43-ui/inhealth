<script type="text/javascript">
/**
* untuk print penjualan dokter
 */
function print(caraPrint)
{
    // var paketobat_id = '<?php //echo isset($model->paketobat_id) ? $model->paketobat_id : null ?>';

    window.open('<?php echo $this->createUrl('print'); ?>&paketobat_id='+paketobat_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function cekObat(){

    if(requiredCheck($("form"))){

        var is_cukup = true;

        $("#table-obatalkespasien tbody tr").each(function() {

            $(this).removeClass("yellow");

            var qty = parseFloat(unformatNumber($(this).find(".qty_jual").val()));
            var stok = parseFloat(unformatNumber($(this).find(".qty_stok").val()));

            // console.log(qty, stok);

            if (qty > stok) {
                $(this).addClass("yellow");
                is_cukup = false;
            }

        });

        if (!is_cukup) {
            myAlert("Stok tidak mencukupi.");
            return false;
        }

        // return false;


        var jumlah_obat = $('#table-obatalkespasien tbody tr').length;
        if(jumlah_obat <= 0){
                myAlert('Isikan obat alkes terlebih dahulu.');
            return false;
        }else{
            $(".integer-decimal, .float, .integer2").each(function(){
                 $(this).val(unformatNumber($(this).val()));
            });
            $('#penjualanresep-form').submit();
        }

        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat(parseFloat($(this).val())));
        });
        $("form").find('.integer2').each(function(){
            $(this).val(formatNumber(parseFloat($(this).val())));
        });
        $("form").find('.integer-decimal').each(function(){
            $(this).val(formatThousandDecimal(parseFloat($(this).val())));
        });
    }
    return false;

}

/**
 * refresh dialog kunjungan
 * @returns {undefined}
 */
function refreshDialogInfoDokter(){
    $.fn.yiiGridView.update('datakunjungan-grid', {
        data: {
        }
    });
}

function hapusObat(obj) {
        var id = $(obj).parents('tr').find('.paketobatdetail_id').val();
        myConfirm("Apakah anda akan menghapus obat ini?", "Perhatian!",
            function(r) {
                if (r) {
                    if (id != "") {
                        // $("#table-obatalkespasien-hapus > tbody").append("<tr><td><input type='hidden' name='del_obat[]' value='" + id + "'></td></tr>");
                        $.ajax({
                            type:'POST',
                            url:'<?php echo $this->createUrl('Hapus'); ?>',
                            data: {
                                paketobatdetail_id : id
                            },
                            dataType: "json",
                            success:function(data){
                                console.log('sukses')
                            },
                            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                        });
                    }
                    $(obj).parents('tr').detach();
                    renameInputRow($("#table-obatalkespasien"));
                }
            });
    }

function hapusObatDatabase(obj) {
    var id = $(obj).parents("tr").find('.templateobatdet_id').val();
    var url = '<?php echo Yii::app()->createAbsoluteUrl(
                    Yii::app()->controller->module->id . '/' . Yii::app()->controller->id
                ) . '/deletedetail'; ?>';
    myConfirm("Yakin Akan Menghapus Data ini dari database ?", 'Perhatian!', function(r) {
        if (r) {
            $.post(url, {
                    id: id
                },
                function(data) {
                    if (data.status == 'proses_form') {
                        myAlert('Data Berhasil dihapus dari database');
                        $(obj).parents('tr').detach();
                        renameInputRow($("#table-obat"));
                    } else {
                        myAlert("Data Gagal Dihapus dari Database");
                        return false;
                    }
                }, "json");
        }
    });
}

function renameInputRow(obj_table) {
    var row = 0;
    $(obj_table).find("tbody > tr").each(function() {
        $(this).find("#no_urut").val(row + 1);
        $(this).find('input,select,textarea').each(function() { //element <input>
            var old_name = $(this).attr("name").replace(/]/g, "");
            var old_name_arr = old_name.split("[");
            if (old_name_arr.length == 3) {
                $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
            }
        });
        row++;
    });
}

function tooltips(obj){
    var permintaan = $(obj).parents('#table-obatalkespasien').find('#kekuatanObat').val();
    $('[data-toggle="tooltip"]').tooltip();
}

/**
 * set form info pasien
 * @returns {undefined}
 */
/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){

});
</script>