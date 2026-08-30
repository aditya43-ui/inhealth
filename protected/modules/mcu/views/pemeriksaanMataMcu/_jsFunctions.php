<script type="text/javascript">
/**
 * rename input row yang terakhir di tambahkan
 * @param {type} obj_table
 */
function renameInputRowPemeriksaan(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
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
* untuk print hasil treadmill
 */
function print(caraPrint)
{
    var periksakacamata_id = '<?php echo isset($modPeriksaKacamata->periksakacamata_id) ? $modPeriksaKacamata->periksakacamata_id : null ?>';
	var pendaftaran_id = '<?php echo isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&periksakacamata_id='+periksakacamata_id+'&pendaftaran_id='+pendaftaran_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function cekInput(){
    if(requiredCheck($("form"))){
        var jumlah_data = $('#form-pemeriksaanmata-mcu tbody tr').length;
        if(jumlah_data <= 0){
                myAlert('Silakan isikan data pemeriksaan terlebih dahulu!');
            return false;
        }else{
            $('#periksamata-mcu-form').submit();
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
/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
    <?php if(isset($_GET['pendaftaran_id'])){ ?>
	renameInputRowPemeriksaan($("#form-pemeriksaanmata-mcu"));  
    <?php } ?>
});
</script>