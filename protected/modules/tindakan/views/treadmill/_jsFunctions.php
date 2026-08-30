<script type="text/javascript">
function tambahTreadmill()
{
    var duration = $('#<?php echo CHtml::activeId($modTreadmill,'duration_treadmill'); ?>').val();
    var td_systolic = $('#<?php echo CHtml::activeId($modTreadmill,'td_systolic'); ?>').val();
    var td_diastolic = $('#<?php echo CHtml::activeId($modTreadmill,'td_diastolic'); ?>').val();
    var heart_rate = $('#<?php echo CHtml::activeId($modTreadmill,'heart_rate'); ?>').val();
    
    if(duration != '')
    {        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormTreadmill'); ?>',
            data: {duration:duration, td_systolic:td_systolic, td_diastolic:td_diastolic, heart_rate:heart_rate},//
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    return false;
                }
                
				$('#form-treadmilldetail-mcu > tbody').append(data.form);						
				$("#form-treadmilldetail-mcu").find('input[name*="[ii]"][class*="integer"]').maskMoney(
					{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
				);
				renameInputRowTreadmill($("#form-treadmilldetail-mcu"));                    
                
                $('#<?php echo CHtml::activeId($modTreadmill,'duration_treadmill'); ?>').val('');
				$('#<?php echo CHtml::activeId($modTreadmill,'td_systolic'); ?>').val('');
				$('#<?php echo CHtml::activeId($modTreadmill,'td_diastolic'); ?>').val('');
				$('#<?php echo CHtml::activeId($modTreadmill,'heart_rate'); ?>').val('');
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silakan isi data treadmill terlebih dahulu!");
    }
    $('#<?php echo CHtml::activeId($modTreadmill,'duration_treadmill'); ?>').focus();   
}
/**
 * rename input row yang terakhir di tambahkan
 * @param {type} obj_table
 */
function renameInputRowTreadmill(obj_table){
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

function batal(obj){
var asd = $(obj).parents('tr');
    myConfirm('Apakah Anda akan membatalkan ini?','Perhatian!',
    function(r){
        if(r){
			$(asd).addClass("animation-loading-1");
			setTimeout(function(){
				$(asd).detach();
				renameInputRowTreadmill($("#form-treadmilldetail-mcu"));
				$(asd).removeClass("animation-loading-1");
			},300);
        }
    }); 
}

/**
* untuk print hasil treadmill
 */
function print(caraPrint,treadmill_id=null,pendaftaran_id=null)
{
	<?php if(isset($_GET['id'])){ ?>
		var treadmill_id = '<?php echo isset($modTreadmill->treadmill_id) ? $modTreadmill->treadmill_id : null ?>';
		var pendaftaran_id = '<?php echo isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null; ?>';
	<?php } ?>
    window.open('<?php echo $this->createUrl('print'); ?>&treadmill_id='+treadmill_id+'&pendaftaran_id='+pendaftaran_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

/**
* untuk print hasil treadmill
 */
function printGrafik(caraPrint)
{
    var treadmill_id = '<?php echo isset($modTreadmill->treadmill_id) ? $modTreadmill->treadmill_id : null ?>';
	var pendaftaran_id = '<?php echo isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('Grafik'); ?>&treadmill_id='+treadmill_id+'&pendaftaran_id='+pendaftaran_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function cekInput(){
    if(requiredCheck($("form"))){
        var jumlah_data = $('#form-treadmilldetail-mcu tbody tr').length;
        if(jumlah_data <= 0){
                myAlert('Silakan isikan data treadmill terlebih dahulu!');
            return false;
        }else{
            $('#treadmill-mcu-form').submit();
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

function setTreadmillDetail(treadmill_id){
	
}
/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
    <?php if(isset($_GET['id'])){ ?>
		setPasien(<?php echo $modTreadmill->pasien_id; ?>,<?php echo $modTreadmill->pendaftaran_id; ?>);
		$('#form-input').remove();
    <?php } ?>
});
</script>