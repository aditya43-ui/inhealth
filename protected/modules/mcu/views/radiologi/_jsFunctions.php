<script type="text/javascript">
/**
* load permintaan ke penunjang:
* - pasienkirimkeunitlain_id
*/ 
function setPermintaanKeMcu(){
    $('#form-pemeriksaan-mcu').addClass("animation-loading");
    var pendaftaran_id = '<?php echo $modPendaftaran->pendaftaran_id;?>';
    var pasienkirimkeunitlain_id = '<?php echo $modKirimKeUnitLain->pasienkirimkeunitlain_id;?>';
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetPermintaanKeMcu'); ?>',
        data: {pendaftaran_id:pendaftaran_id,pasienkirimkeunitlain_id:pasienkirimkeunitlain_id},
        dataType: "json",
        success:function(data){
            $('#form-pemeriksaan-mcu > tbody').html(data.rows);
            $('#form-pemeriksaan-mcu').removeClass("animation-loading");
            renameInputRow($("#form-pemeriksaan-mcu"));
			formatNumberSemua();
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
 * rename input row yang terakhir di tambahkan
 * @param {type} obj_table
 */
function renameInputRow(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span').each(function(){ //element <span>
//            var old_name = $(this).attr("name").replace(/]/g,"");
//            var old_name_arr = old_name.split("[");
//            if(old_name_arr.length == 3){
//                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
//            }
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

function printHasil(obj){
	var pendaftaran_id = <?php echo $modPendaftaran->pendaftaran_id ?>;
	var pemeriksaanrad_id = $(obj).parents('tr').find("input[name*='[pemeriksaanrad_id]']").val();
	window.open("index.php?r=/mcu/radiologi/printHasil&pendaftaran_id="+pendaftaran_id+"&pemeriksaanrad_id="+pemeriksaanrad_id+"&caraPrint=PRINT","",'location=_new, width=900px');
}

/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
    <?php if(isset($_GET['pendaftaran_id'])){ ?>
        setPermintaanKeMcu();
    <?php } ?>
});
</script>