<script type="text/javascript">
var notif = '<?php Yii::t('mds','Do You want to cancel?'); ?>';
function inputBarang(){
	barang_id = $('#barang_id').val();
	jumlah = $('#jumlah').val();
	satuan = $('#satuan').val();
	ruangan = $('#ruangan_id').val();
	if (!jQuery.isNumeric(barang_id)){
		myAlert('Silakan isi barang yang akan dipesan!');
		return false;
	}
	else if (!jQuery.isNumeric(jumlah)){
		myAlert('Isi jumlah barang yang akan dipesan');
		return false;
	}
	else{
		
                cekList({barang_id:barang_id,jumlah:jumlah,ruangan:ruangan, dataResponse:function(){
                        $('#table-detailbarang').addClass("animation-loading");
                        $.ajax({
				type:'POST',
				url:'<?php echo $this->createUrl('getPemakaianBarang'); ?>',
				data: {barang_id:barang_id, jumlah:jumlah, satuan:satuan},
				dataType: "json",
				success:function(data){
					$('#table-detailbarang > tbody').append(data);
					$('#table-detailbarang').removeClass("animation-loading");
					$("#table-detailbarang").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
                    );
					renameInputRowBarang($("#table-detailbarang"));
					clear();
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
                }});
                
//		if (cekList(barang_id) == true){
//			$.ajax({
//				type:'POST',
//				url:'<?php // echo $this->createUrl('getPemakaianBarang'); ?>',
//				data: {barang_id:barang_id, jumlah:jumlah, satuan:satuan},
//				dataType: "json",
//				success:function(data){
//					$('#table-detailbarang > tbody').append(data);
//					$('#table-detailbarang').removeClass("animation-loading");
//					$("#table-detailbarang").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
//                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
//                    );
//					renameInputRowBarang($("#table-detailbarang"));
//					clear();
//				},
//				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
//			});
//		}else{
//			$('#table-detailbarang').removeClass("animation-loading");
//		}
	}        
}

function cekList(dataRes){
	x = true;
	$('.barang').each(function(){
		if ($(this).val() == dataRes.barang_id){
			myAlert('Barang telah ada d List');
			clear();
			x = false;
		}else{

		}
	});

	if(x==true){
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('getStokBarang'); ?>',
			data: {barang_id:dataRes.barang_id, qty:dataRes.jumlah, ruangan_id:dataRes.ruangan},
			dataType: "json",
			success:function(data){
				if(data.pesan == 'kosong'){
					x = false;
					myAlert("Stok Barang yang dipilih Kosong / Kurang!");
					$('.barang').each(function(){
						if ($(this).val() == dataRes.barang_id){
							$(this).parents('tr').remove();
						}
					});
				}else{
                                    dataRes.dataResponse();
                                }
//				clear();
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}
	return x;
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
	$('#formDetailBarang').find('input, select').each(function(){
		$(this).val('');
	});
	$('#jumlah').val(1);
}

function batal(obj){
	myConfirm('Apakah Anda yakin ingin membatalkan barang ini ?','Perhatian!', function(r){
            if (r){
                $(obj).parents('tr').remove();
                renameInputRowBarang($("#table-detailbarang"));
            }
        })	
	
}

function openDialog(obj){
	$('#dialogPegawai').attr('parentClick',obj);
	$('#dialogPegawai').dialog('open');   
}

function cekBarang(){	
	if(requiredCheck($("form"))){
		var jmlBarang = $('#table-detailbarang tbody tr').length;
		if(jmlBarang <= 0){
			myAlert('Detail barang harus diisi terlebih dahulu!');
			return false;
		}else{
			qty = false;        
			$(".qty").each(function(){
				if ($(this).val() > 0){
					qty = true
				}
			});
			if (qty == false){
				myAlert('<?php echo CHtml::encode($model->getAttributeLabel('qty')); ?> harus memiliki value yang lebih dari 0 ');
				return false;
			}		
			$('#gupemakaianbarang-t-form').submit();
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
 * class integer di unformat 
 * @returns {undefined}
 */
function unformatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
}
/**
 * class integer di format kembali
 * @returns {undefined}
 */
function formatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}

/**
* untuk print pemakaian barang
 */
function print(caraPrint)
{
    var pemakaianbarang_id = '<?php echo (!empty($model->pemakaianbarang_id)) ? $model->pemakaianbarang_id : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&pemakaianbarang_id='+pemakaianbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

$(document).ready(function(){
	<?php 
		if(isset($model->pemakaianbarang_id)){
	?>
		var params = [];
		params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGUMUM ?>, judulnotifikasi:'Pemakaian Barang', isinotifikasi:'Telah dipakai barang dengan <?php echo $model->nopemakaianbrg; ?> pada <?php echo $model->tglpemakaianbrg ?>'}; // 16 
		insert_notifikasi(params);
		
		$("#table-detailbarang :input").attr("readonly",true);
        $("#table-detailbarang .add-on").remove();
        $("#table-detailbarang .icon-form-silang").remove();
        
        $("#gupemakaianbarang-t-form :input").attr("readonly",true);
        $("#gupemakaianbarang-t-form .dtPicker3").attr("readonly",true);
        $("#gupemakaianbarang-t-form .add-on").remove();
        
        $("input, select, textarea").attr("disabled",true);
	<?php
		}
	?>
});
</script>