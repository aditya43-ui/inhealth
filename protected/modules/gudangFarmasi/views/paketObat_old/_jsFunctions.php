<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">

function tambahObat()
{
    var ada = 0 ;
    var obatalkes_id = $('#obatalkes_id').val();
    if(obatalkes_id == ''){
        myAlert('Maaf Pilih Obat Alkes Terlebih Dahulu');
        return false;
    }else{
        $("#table-obat").find("tr").each(function () {
            var obatalkes_ada = $(this).find('.obatalkes_id').val();
            if (obatalkes_id == obatalkes_ada) {
                ada++;
            }
        });
        if(ada == 0){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('setObatAlkes'); ?>',
                data: {
                    obatalkes_id:obatalkes_id
                },//
                dataType: "json",
                success:function(data){
                    $("#table-obat").addClass('animation-loading');
                    $("#table-obat > tbody ").append(data.form);
                    renameInputRow($("#table-obat"));
                    resetObatAlkes();
                    $("#table-obat").find('input[class*="float2"]').unmaskMoney();
                    $("#table-obat").find('input[class*="float2"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":2}
                    ); 
                    $("#table-obat").removeClass('animation-loading');
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });  
        }else{
            resetObatAlkes();
            myAlert("Maaf Obat Sudah Ada Di Dalam Daftar");
            return false;
        }
    }
}

function resetObatAlkes(){
    $("#obatalkes_id").val("");
    $("#obatalkes_nama").val("");
}

/**
* rename input grid
*/ 
function renameInputRow(obj_table){
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

function hapusObat(obj){
    var id = $(obj).parents('tr').find('.paketobatdetail_id').val();

    myConfirm("Apakah anda akan menghapus obat ini?","Perhatian!",
    function(r){
        if(r){
            if (id != ''){
                $("#table-obat-hapus > tbody").append("<tr><td><input type='hidden' name='del_obat[]' value='"+id+"'></td></tr>");
            }
            $(obj).parents('tr').detach();
            renameInputRow($("#table-obat"));
        }
    }); 
}

function hapusObatDatabase(obj){
    var id = $(obj).parents("tr").find('.templateobatdet_id').val();
    var url = '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id)."/deletedetail"; ?>';
    myConfirm("Yakin Akan Menghapus Data ini dari database ?",'Perhatian!',function(r){
    if (r){
         $.post(url, {id: id},
             function(data){
                if(data.status == 'proses_form'){
                    myAlert('Data Berhasil dihapus dari database');
                    $(obj).parents('tr').detach();
                    renameInputRow($("#table-obat"));
                }else{
                    myAlert("Data Gagal Dihapus dari Database");
                    return false;
                }
        },"json");
        }
    });
}

function ubahKronis(obj){
    if($(obj).prop('checked')){
        $(obj).parents('tr').find('#jumlahkronis').show();
        $(obj).parents('tr').find('#jumlahnonkronis').hide();
    }else{
        $(obj).parents('tr').find('#jumlahkronis').hide();
        $(obj).parents('tr').find('#jumlahnonkronis').show();
    }
}

</script>