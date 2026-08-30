<script type="text/javascript">
/**
* load permintaan ke penunjang:
* - pasienkirimkeunitlain_id
*/
// LNG-990 
//function setPermintaanKeMcu(){
//    $('#form-pemeriksaan-mcu').addClass("animation-loading");
//    var pendaftaran_id = '<?php // echo $modPendaftaran->pendaftaran_id;?>';
//    var pasienkirimkeunitlain_id = '<?php // echo $modKirimKeUnitLain->pasienkirimkeunitlain_id;?>';
//    $.ajax({
//        type:'POST',
//        url:'<?php // echo $this->createUrl('SetPermintaanKeMcu'); ?>',
//        data: {pendaftaran_id:pendaftaran_id,pasienkirimkeunitlain_id:pasienkirimkeunitlain_id},
//        dataType: "json",
//        success:function(data){
//            $('#form-pemeriksaan-mcu > tbody').html(data.rows);
//            $('#form-pemeriksaan-mcu').removeClass("animation-loading");
//            renameInputRow($("#form-pemeriksaan-mcu"));
//			formatNumberSemua();
//        },
//        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
//    });
//}
/**
* load detail hasil pemeriksaan:
* - pendaftaran_id
*/
function setFormHasilPemeriksaan(){
	var pendaftaran_id = '<?php echo $modPendaftaran->pendaftaran_id;?>';
    $('#form-hasilpemeriksaanlab').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetFormHasilPemeriksaan'); ?>',
        data: {pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
            $('#form-hasilpemeriksaanlab table > tbody').html(data.rows);
            $('#<?php echo CHtml::activeId($modHasilPemeriksaan, 'hasilpemeriksaanlab_id'); ?>').val(data.hasilPemeriksaan.hasilpemeriksaanlab_id);
            $('#<?php echo CHtml::activeId($modHasilPemeriksaan, 'nohasilperiksalab'); ?>').val(data.hasilPemeriksaan.nohasilperiksalab);
            $('#<?php echo CHtml::activeId($modHasilPemeriksaan, 'statusperiksahasil'); ?>').val(data.hasilPemeriksaan.statusperiksahasil);
            $('#<?php echo CHtml::activeId($modHasilPemeriksaan, 'tglhasilpemeriksaanlab'); ?>').val(data.hasilPemeriksaan.tglhasilpemeriksaanlab);
            $('#<?php echo CHtml::activeId($modHasilPemeriksaan, 'tglpengambilanhasil'); ?>').val(data.hasilPemeriksaan.tglpengambilanhasil);
            $('#form-hasilpemeriksaanlab').removeClass("animation-loading");
            renameInputRow($("#form-hasilpemeriksaanlab"));
            setKeterangan();
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function setKeterangan(){
   var keterangan = '';
    $('#form-hasilpemeriksaanlab tbody > tr input[name$="[nilairujukan_keterangan]"]').each(function(){
       keterangan += "<li>"+$(this).val()+"</li>";
    });
    
    keterangan = "<ol>"+keterangan+"</ol>";
    var catatan = $('#<?php echo CHtml::activeId($modHasilPemeriksaan,'catatanlabklinik');?>');
    if (catatan.val() == "") {
        $(catatan).val(keterangan);
        var frame = $(catatan).parent().find(".redactor_frame");
        var body = frame.contents().find("body #page");
        body.html(keterangan);
    }
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
 * print hasil pemeriksaan 
 */
function printHasil()
{
    var pendaftaran_id = <?php echo $_GET['pendaftaran_id']; ?>;
	window.open('<?php echo $this->createUrl('laboratorium/print'); ?>&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=0,width=768,height=640');
}
/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
    <?php if(!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)){ ?>
        setFormHasilPemeriksaan();
    <?php }else{ ?>
		$('#<?php echo CHtml::activeId($modHasilPemeriksaan, 'tglhasilpemeriksaanlab'); ?>').attr('disabled',true);
		$('#<?php echo CHtml::activeId($modHasilPemeriksaan, 'tglhasilpemeriksaanlab_date'); ?>').attr('disabled',true);
		$('#<?php echo CHtml::activeId($modHasilPemeriksaan, 'tglpengambilanhasil'); ?>').attr('disabled',true);
		$('#<?php echo CHtml::activeId($modHasilPemeriksaan, 'tglpengambilanhasil_date'); ?>').attr('disabled',true);
		$('.btn').attr('disabled',true);
		$('.btn').removeAttr("onclick");
		$('.btn').removeAttr("onkeypress");
	<?php } ?>
});
</script>