<script type="text/javascript">	
function tambahObatED()
{
	unformatNumberSemua();
    var supplier_id = $('#<?php echo CHtml::activeId($model, "supplier_id"); ?>').val();	
	var storeeddetail_id = $('#storeeddetail_id').val();
	var satuankecil_id = $('#satuankecil_id').val();
	var obatalkes_id = $('#obatalkes_id').val();
	var tglkadaluarsa = $('#tglkadaluarsa_renpeng').val();
	var obatalkes_nama = $('#obatalkes_nama').val();
	var jumlah = $('#jumlah').val();
			
	if (supplier_id == ''){
		myAlert('Supplier belum dipilih!');
	}else if (obatalkes_id == ''){
		myAlert('Obat ED belum dipilih!');
	}else if(jumlah == ''){
		myAlert('Jumlah belum ditentukan!');
	}else{
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('loadTabelObatAlkesED'); ?>',
			data: {obatalkes_id:obatalkes_id,obatalkes_nama:obatalkes_nama,jumlah:jumlah,supplier_id:supplier_id,storeeddetail_id:storeeddetail_id,satuankecil_id:satuankecil_id,tglkadaluarsa:tglkadaluarsa},
			dataType: "json",
			success:function(data){
//				if(data.pesan !== ""){
//					myAlert(data.pesan);
//					return false;
//				}
				$('#table-obatalkesED > tbody').append(data.form);
				$("#table-obatalkesED").find('input[name*="[ii]"][class*="integer"]').maskMoney(
					{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
				);	
				renameInputRow($("#table-obatalkesED"));       

				$('#storeeddetail_id').val('');
				$('#satuankecil_id').val('');
				$('#tglkadaluarsa_renpeng').val('');
				$('#obatalkes_id').val('');
				$('#obatalkes_nama').val('');
				$('#jumlah').val('');
				formatNumberSemua();
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}
	formatNumberSemua();
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

function batalObatAlkesED(obj){
    myConfirm('Apakah Anda akan membatalkan obat alkes ED ini?','Perhatian!',
    function(r){
        if(r){
            $(obj).parents('tr').detach();
			renameInputRow($("#table-obatalkesED"));   
        }
    });
}

function verifikasi(){
    if(requiredCheck($("renpengOAED-t-form"))){
        var jmlObatOAED = $('#table-obatalkesED tbody tr').length;
		if(jmlObatOAED <= 0){
			myAlert('Silakan isikan obat alkes ED terlebih dahulu!');
            return false;
        }else{
            $('#renpengOAED-t-form').submit();
        }
        
        $(".animation-loading").removeClass("animation-loading");
    }
    return false;    
}

function print(caraPrint)
{
    var renpengembalianed_id = '<?php echo (isset($_GET['renpengembalianed_id']) ? $_GET['renpengembalianed_id'] : null); ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&renpengembalianed_id='+renpengembalianed_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

</script>