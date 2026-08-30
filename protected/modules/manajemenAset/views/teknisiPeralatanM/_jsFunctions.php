<?php
/**
* - digunakan untuk Admin Teknisi Peralatan
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>


<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
				$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
				$url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
?>
<script type="text/javascript">
    
function tambahSertifikat(obj)
{
    //var no_sertifikat = $(obj).parents('#teknisi-m-form').find('#no_sertifikat_teknisi').val();
    var no_sertifikat = $("#no_sertifikat_teknisi").val();
    console.log(no_sertifikat);
    var nama_sertifikat = $(obj).parents('#teknisi-m-form').find('#nama_sertifikat').val();
    var sertifikat_ket = $(obj).parents('#teknisi-m-form').find('#sertifikat_ket').val();
    var berlaku = $('#berlaku_sd').val();
    
    if(no_sertifikat != '' && berlaku != '')
    {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormSertifikat'); ?>',
            //data: {no_sertifikat:no_sertifikat,},//
            data: $("#teknisi-m-form").serialize(),//
            dataType: "json",
            success:function(data){
                
                $('#table-sertifikat > tbody').append(data.form);
                //addDataKeGridObat(obj);
                renameInputRowObatAlkes($("#table-sertifikat"));                    
                
        },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silahkan Masukkan Sertifikat dan Tanggal Berlaku terlebih dahulu!");
    }   
}

function addDataKeGridObat(obj){
    var no_sertifikat = $(obj).parents('#teknisi-m-form').find('#SertifikatteknisiM_no_sertifikat_teknisi').val();
    var nama_sertifikat = $(obj).parents('#teknisi-m-form').find('#SertifikatteknisiM_nama_sertifikat').val();

    var input_no_sertifikat = $("#table-sertifikat").find('input[name*="[ii]"][value*="'+no_sertifikat+'"]').parents('tr').find('input[name*="[ii][no_sertifikat_teknisi]"]');
    input_no_sertifikat.val(no_sertifikat);
    var input_no_sertifikat = $("#table-sertifikat").find('input[name*="[ii]"][value*="'+no_sertifikat+'"]').parents('tr').find('input[name*="[ii][no_sertifikat_teknisi]"]');
    input_no_sertifikat.val(nama_sertifikat);
}

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
function batalSertifikatDetail(obj){
    $(obj).parents('tr').detach();
}

/**
 * class integer2 di unformat 
 * @returns {undefined}
 */
function unformatNumberSemua(){
    $(".integer2").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
}
/**
 * class integer2 di format kembali
 * @returns {undefined}
 */
function formatNumberSemua(){
    $(".integer2").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}

function clearInputan()
{
    $('#obatalkes_id').val('');
    $('#obatalkes_kode').val('');
    $('#ruanganapotek_id').val('');
    $('#namaObatNonRacik').val('');
	$('#therapiobat_id2').val('');
}

function deleteRecord(obj,id){
    var id = id;
    var url = '<?php echo $url."/deleteSertifikat"; ?>';
    $("#table-sertifikat").addClass("animation-loading");
    myConfirm('Yakin Akan Menghapus Data ini ?','Perhatian!',function(r){
        if (r){
             $.post(url, {id: id},
                 function(data){
                    if(data.status == 'proses_form'){
                            $(obj).parents("tr").remove();
                            $("#table-sertifikat").removeClass("animation-loading");
                        }else{
                            myAlert('Data Gagal di Hapus')
                        }
            },"json");
       }
    });
}

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    renameInputRowObatAlkes($("#table-sertifikat")); 
   });
</script>