<script type="text/javascript">
function peralatanBarang(){
	var peralatan = $('#jenis_peralatan').val();
	if(peralatan == "Peralatan"){
		$('#peralatan').show();
		$('#linen').hide();	
		resetDropdown();
	}else{
		$('#linen').show();
		$('#peralatan').hide();
		resetDropdown();
	}
}	

function resetDropdown(){
	 $("#barang_id").val("");
	 $("#linen_id").val("");
	 $("#namaPeralatan").val("");
	 $("#namalinen").val("");
}

function inputPeralatanLinen(){
	barang_id = $('#barang_id').val();
	linen_id = $('#linen_id').val();
	jumlah = $('#jml').val();
	if (!jQuery.isNumeric(barang_id)){
		myAlert('Silakan pilih peralatan dan linen yang akan diajukan!');
		return false;
	}else if (!jQuery.isNumeric(jumlah)){
		myAlert('Silakan tentukan jumlah yang akan diajukan!');
		return false;
	}
	else{
		$('#table-linen').addClass("animation-loading");
			$.ajax({
				type:'POST',
				url:'<?php echo $this->createUrl('loadFormLine'); ?>',
				data: {linen_id:linen_id, barang_id:barang_id, jumlah:jumlah,},
				dataType: "json",
				success:function(data){
					$('#table-linen > tbody').append(data.form);
					$('#table-linen').removeClass("animation-loading");
					$("#table-linen").find('input[name*="[ii]"][class*="integer"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
                    );
					cekRow();
					renameInputRowBarang($("#table-linen"));
					clear();
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
			$('#table-linen').removeClass("animation-loading");
	}        
}
/**
* rename input grid
*/ 
function renameInputRowBarang(obj_table){
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

function clear(){
	$('#formLinen').find('input, select').each(function(){
		$(this).val('');
	});
	$('#jumlah').val(1);
}

function batalLinen(obj){
    myConfirm('Apakah Anda akan membatalkan linen ini?','Perhatian!',
    function(r){
        if(r){
            $(obj).parents('tr').detach();
			renameInputRowBarang();
			cekRow();
        }
    });
}

function cekRow(){
	var jmlRow = $('#table-linen tbody tr').length;
	if(jmlRow === 0){
		$('#jenis_peralatan').attr('disabled',false);
	}else{
		$('#jenis_peralatan').attr('disabled',true);
	}
}
function print(caraPrint)
{
    var pesanperlinensteril_id = '<?php echo isset($_GET['pesanperlinensteril_id']) ? $_GET['pesanperlinensteril_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&pesanperlinensteril_id='+pesanperlinensteril_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function cekTabel(){

    if(requiredCheck($('#cspesanperalatansteril-t-form'))){
        var jmlRow = $('#table-linen tbody tr').length;
        if(jmlRow === 0){
            myAlert('Peralatan dan Linen belum dipilih');
            return false;
        }else{
            $("#cspesanperalatansteril-t-form").submit();
            return false;
        }
        return false;
    }
}
$( document ).ready(function(){
//  cekDisabled($('#cspesanperalatansteril-t-form')); 
    $('form').bind('click keyup select change', function(event) {
        cekDisabled(this);
    });
    $(document).on('click keyup select change',function(){
        cekDisabled('form');
    }); 
    cekDisabled('form');
});

</script>