<script type="text/javascript">
function tambahObat()
{
	unformatNumberSemua();
	var obatalkes_id = $('#obatalkes_id').val();
	var obatalkes_nama = $('#obatalkes_nama').val();
	var qtystoked = $('#qtystoked').val();
	var satuankecil_id = $('#satuankecil_id').val();
	var supplier_nama = $('#supplier_nama').val();
	var tglkadaluarsa = $('#tglkadaluarsa').val();
	var sumberdana = $("#<?php echo CHtml::activeId($model,'sumberdana_id');?>").val();
			
	if (obatalkes_id == ''){
		myAlert('Obat ED belum dipilih !');
	}else if(qtystoked == ''){
		myAlert('Jumlah belum ditentukan !');
	}else{
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('SetFormObatAlkesEd'); ?>',
			data: {obatalkes_id:obatalkes_id,obatalkes_nama:obatalkes_nama,qtystoked:qtystoked,supplier_nama:supplier_nama,satuankecil_id:satuankecil_id,tglkadaluarsa:tglkadaluarsa,sumberdana:sumberdana},
			dataType: "json",
			success:function(data){
				if(data.pesan !== ""){
					myAlert(data.pesan);
					return false;
				}
				$('#table-obatalkesED > tbody').append(data.form);
				$("#table-obatalkesED").find('input[name*="[ii]"][class*="integer"]').maskMoney(
					{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
				);	
				renameInputRow($("#table-obatalkesED"));       

				$('#obatalkes_id').val('');
				$('#obatalkes_nama').val('');
				$('#qtystoked').val('');
				$('#satuankecil_id').val('');
				$('#supplier_nama').val('');
				$('#tglkadaluarsa').val('');
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

function batalStoreEdDetail(obj){
     myConfirm('Apakah anda akan membatalkan obat alkes ED ini?','Perhatian!',
    function(r){
        if(r){
            $(obj).parents('tr').detach();
			renameInputRow($("#table-obatalkesED"));   
        }
    }); 
}

function cekObat(){
    if(requiredCheck($("form"))){
        var jumlah_obat = $('#table-obatalkesED tbody tr').length;
        if(jumlah_obat <= 0){
                myAlert('Isikan obat alkes terlebih dahulu.');
            return false;
        }else{
            $('#gfstoreed-t-form').submit();
            disableOnSubmit($("#btn_submit"));
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

function formatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}

$('#tombolDialogOa').click(function(){
    var sumberdana = $("#<?php echo CHtml::activeId($model,'sumberdana_id');?>").val();
    $.fn.yiiGridView.update('obatAlkesDialog-m-grid', {
        data: {
            "GFObatSupplierM[sumberdana_id]":sumberdana,
        }
    });
});

function print(caraPrint)
{
    var storeed_id = '<?php echo (isset($_GET['storeed_id']) ? $_GET['storeed_id'] : null); ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&storeed_id='+storeed_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
</script>