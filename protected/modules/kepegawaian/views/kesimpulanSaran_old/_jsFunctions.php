<script type="text/javascript">
function setNol(obj){
    if($(obj).is(":checked")){
        obj.value = 1;
    }else{
        obj.value = 0;
    }
}

function checkAll(){
    $("#tabel-sterilisasi > tbody > tr").find('input[type="checkbox"]').each(
    function(){
        if($("#check_semua").is(":checked")){
            $(this).attr('checked','checked');
        }else{
            $(this).removeAttr('checked');
        }
    });
}

function validasiCek(){
    if(requiredCheck($("form"))){
       
            $('#penyimpanansteril-t-form').submit();
 
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
* untuk print perawatan linen
 */
function print(caraPrint)
{
    var kesimpulanpenilaian_id = '<?php echo @$_GET['kesimpulanpenilaian_id']; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&kesimpulanpenilaian_id='+kesimpulanpenilaian_id+'&caraprint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function searchPenerimaan(){
	$('#form-penerimaan').addClass('animation-loading');	
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('pencarian'); ?>',
		data: {data:$('#pencarian-form').serialize()},//
		dataType: "json",
		success:function(data){
			if(data.pesan !== ""){
				myAlert(data.pesan);
				$('#form-penerimaan').removeClass('animation-loading');
				return false;
			}
			$('#tabel-kesimpulan > tbody').html(data.form);
			
			$('#form-penerimaan').removeClass('animation-loading');
			hitungHasil();
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

function hitungHasil(){
	var total = 0;
	var rata2 = 0;
    $('#tabel-kesimpulan tbody tr').each(function(){
        var jumlahpenilaian  = parseInt($(this).find('input[name$="[jumlahpenilaian]"]').val());
        total += jumlahpenilaian;
		rata2 = total/jumlahpenilaian;
    });
    $('#<?php echo CHtml::activeId($modKesimpulan,"totalpenilaian"); ?>').val(total);
    $('#<?php echo CHtml::activeId($modKesimpulan,"ratapenilaian"); ?>').val(rata2);	
}

</script>