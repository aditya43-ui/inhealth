<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">

function tambahRencana()
{
    var konfiganggaran_id = $('#<?php echo CHtml::activeId($model, "konfiganggaran_id"); ?>').val();
    var subkegiatanprogram_id = $('#subkegiatanprogram_id').val();
    var nilaipengeluaran = $('#nilairencpengeluaran').val();
    var tglrencana = $('#<?php echo CHtml::activeId($model, "tglrencana"); ?>').val();
	var nilairencpengeluaran = unformatNumber(nilaipengeluaran);
		if (konfiganggaran_id == ''){
			myAlert('Periode Anggaran belum dipilih!');
		}else if(subkegiatanprogram_id == ''){
			myAlert('Program Kerja belum dipilih!');
		}else if (nilairencpengeluaran == ''){
			myAlert('Nilai Pengeluaran belum diinputkan!');	
		}else{
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadFormTambahRencana'); ?>',
                data: {subkegiatanprogram_id:subkegiatanprogram_id,nilairencpengeluaran:nilairencpengeluaran,tglrencana:tglrencana},
                dataType: "json",
                success:function(data){
                    $('#table-rencanaanggaranpengeluaran > tbody').append(data.form);
                    $("#table-rencanaanggaranpengeluaran").find('input[name$="[ii][subkegiatanprogram_id]"]').val(subkegiatanprogram_id);
                    $("#table-rencanaanggaranpengeluaran").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
                    );
                    renameInputRowRencanaAnggaran($("#table-rencanaanggaranpengeluaran"));                    
                    hitungTotal();
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }
}

function verifikasi(){
    if(requiredCheck($("ubahanggaran-form"))){
		var konfiganggaran_id = $('#<?php echo CHtml::activeId($model, "konfiganggaran_id"); ?>').val();
		var unitkerja_id = $('#<?php echo CHtml::activeId($model, "unitkerja_id"); ?>').val();	
        var jmlRencana = $('#table-rencanaanggaranpengeluaran tbody tr').length;
		if (unitkerja_id == ''){
                myAlert('Ruangan belum terdaftar diunit kerja, harap konfirmasi ke bag. Keuangan!');
		}else if (konfiganggaran_id == ''){
			myAlert('Periode Anggaran belum dipilih!');
		}else if(jmlRencana <= 0){
                myAlert('Silakan isikan rencana anggaran pengeluaran terlebih dahulu!');
            return false;
        }else{
            $('#ubahanggaran-form').submit();
        }
        
		$("#table-rencanaanggaranpengeluaran").addClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer2').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;
    
}

function verifikasiRevisi(){
    if(requiredCheck($("revisi-form"))){
		var ygmerevisi_id = $('#<?php echo CHtml::activeId($model, "ygmerevisi_id"); ?>').val();	
        var jmlRencana = $('#table-rencanaanggaranpengeluaran tbody tr').length;
		if (ygmerevisi_id == '') {
			myAlert('Pegawai yang merevisi belum dipilih!');
			return false;
		}else if(jmlRencana <= 0){
			myAlert('Data Anggaran Pengeluaran Tidak Ada!');
            return false;
        }else{
            $('#revisi-form').submit();
        }
        
		$("#table-rencanaanggaranpengeluaran").addClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer2').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;
    
}

function verifikasiApprove(){
    if(requiredCheck($("approval-form"))){
		var uncheck = 0;  
		$('#table-rencanaanggaranpengeluaran tbody tr').each(function(){
			if($(this).find('input[name$="[approve]"]').is(':checked')){
				uncheck++;
			}
		});
		if (uncheck === 0){ // jika tidak ada yg di approve
                myAlert('Rencana anggaran belum diapprove!');
				return false;
		}else{
			$('#approval-form').submit();
        }
        
		$("#table-rencanaanggaranpengeluaran").addClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer2').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;
    
}

function verifikasiUbahApprove(){
    if(requiredCheck($("approval-form"))){
		$("#table-rencanaanggaranpengeluaran").addClass("animation-loading");
		var uncheck = 0;  
		$('#table-rencanaanggaranpengeluaran tbody tr').each(function(){
			if($(this).find('input[name$="[approve]"]').is(':checked')){
				uncheck++;
			}
		});
		if (uncheck === 0){ // jika tidak ada yg di approve
//				belum digunakan
//                myAlert('Rencana anggaran belum diapprove!');
				$('#approval-form').submit();
		}else{
			myConfirm('Tanggal Approve Akan Terupdate Tanggal Sekarang!','Perhatian!',
				function(r){
					if(r){
						$('#approval-form').submit();
					}
					$("#table-rencanaanggaranpengeluaran").removeClass("animation-loading");
				});
        }
        
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer2').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;
    
}

/**
* rename input grid
*/ 
function renameInputRowRencanaAnggaran(obj_table){
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
    
    $('#subkegiatanprogram_id').val('');
    $('#<?php echo CHtml::activeId($model, "programkerja"); ?>').val('');
    $('#nilairencpengeluaran').val('');
    $('#<?php echo CHtml::activeId($model, "tglrencana"); ?>').val('<?php echo $model->tglrencana; ?>');	
}

function hitungTotalRevisi(){
    unformatNumberSemua();
    var total = 0;
    $('#table-rencanaanggaranpengeluaran tbody tr').each(function(){
        var nilaiygdisetujui  = parseInt($(this).find('input[name$="[nilaiygdisetujui]"]').val());
		if(nilaiygdisetujui <= 0){
            nilaiygdisetujui = 0;
        }
        total += nilaiygdisetujui;
		
    });
    $('#<?php echo CHtml::activeId($model,"total_nilairencpeng"); ?>').val(total);  
    formatNumberSemua();
}

function hitungTotal(){
    unformatNumberSemua();
    var total = 0;
    $('#table-rencanaanggaranpengeluaran tbody tr').each(function(){
        var nilairencpengeluaran  = parseInt($(this).find('input[name$="[nilairencpengeluaran]"]').val());
		if(nilairencpengeluaran <= 0){
            nilairencpengeluaran = 0;
        }
        total += nilairencpengeluaran;
		
    });
    $('#<?php echo CHtml::activeId($model,"total_nilairencpeng"); ?>').val(total);  
    formatNumberSemua();
}

function batalRencana(obj,rencanggaranpengdet_id){
	if (rencanggaranpengdet_id === 0){ //jika data baru ditambahkan, params rencanggaranpengdet_id = kosong
		myConfirm('Apakah Anda akan membatalkan rencana anggaran ini?','Perhatian!',
		function(r){
			if(r){
				$(obj).parents('tr').detach();			
				hitungTotal();
			}
		});
	}else {
		$("#table-rencanaanggaranpengeluaran").addClass("animation-loading");
		myConfirm('Apakah Anda akan membatalkan rencana anggaran ini?','Perhatian!',
		function(r){
			if(r){
					$.ajax({
						type:'POST',
						url:'<?php echo $this->createUrl('BatalRencana'); ?>',
						data: {rencanggaranpengdet_id:rencanggaranpengdet_id},
						dataType: "json",
						success:function(data){
									$(obj).parents('tr').detach();			
									hitungTotal();
									$("#table-rencanaanggaranpengeluaran").removeClass("animation-loading");
						},
						error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
					});
				}
				$("#table-rencanaanggaranpengeluaran").removeClass("animation-loading");
			});
	}
}

function batalApprove(obj,rencanggaranpengdet_id,apprrencanggaran_id){
	$("#table-rencanaanggaranpengeluaran").addClass("animation-loading");
	myConfirm('Apakah Anda akan membatalkan rencana anggaran ini?','Perhatian!',
	function(r){
		if(r){
			$.ajax({
				type:'POST',
				url:'<?php echo $this->createUrl('BatalApprove'); ?>',
				data: {rencanggaranpengdet_id:rencanggaranpengdet_id,apprrencanggaran_id:apprrencanggaran_id},
				dataType: "json",
				success:function(data){
					if (data.pesan == "sukses"){
							$(obj).parents('tr').detach();		
							hitungTotalRevisi();	
							$("#table-rencanaanggaranpengeluaran").removeClass("animation-loading");
					}
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
		}
			$("#table-rencanaanggaranpengeluaran").removeClass("animation-loading");
	});
}

function batalRevisi(obj,rencanggaranpengdet_id,apprrencanggaran_id){
	$("#table-rencanaanggaranpengeluaran").addClass("animation-loading");
	myConfirm('Apakah Anda akan membatalkan rencana anggaran ini?','Perhatian!',
	function(r){
		if(r){
			$.ajax({
				type:'POST',
				url:'<?php echo $this->createUrl('BatalRevisi'); ?>',
				data: {rencanggaranpengdet_id:rencanggaranpengdet_id,apprrencanggaran_id:apprrencanggaran_id},
				dataType: "json",
				success:function(data){
					if (data.pesan == "sukses"){
							$(obj).parents('tr').detach();		
							hitungTotalRevisi();	
							$("#table-rencanaanggaranpengeluaran").removeClass("animation-loading");
					}
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
		}
			$("#table-rencanaanggaranpengeluaran").removeClass("animation-loading");
	});
}

function ceklistUbah(obj,checkApprove,rencanggaranpengdet_id,apprrencanggaran_id){
var apprrencanggaran_id = $(obj).parents('tr').find('input[name$="[apprrencanggaran_id]"]').val();
	if(apprrencanggaran_id != ""){
		myConfirm('Apakah Anda yakin akan menghapus yang sudah diapprove di database?', 'Perhatian!', function(r)
		{
			if(r){
				hapusRencanaDetail(obj,rencanggaranpengdet_id,apprrencanggaran_id);
			}else{
				$(obj).attr("checked",true);
			}
		});
	}
}

/**
* hapus tindakanpelayanan_t berdasarkan daftartindakan_id
*/ 
function hapusRencanaDetail(obj,rencanggaranpengdet_id,apprrencanggaran_id){
$("#table-rencanaanggaranpengeluaran").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('HapusRencanaDetail'); ?>',
        data: {rencanggaranpengdet_id:rencanggaranpengdet_id, apprrencanggaran_id:apprrencanggaran_id},
        dataType: "json",
        success:function(data){
            myAlert(data.pesan);
            if(data.sukses){
                $(obj).parents('tr').find('input[name$="[apprrencanggaran_id]"]').val('');
				$(obj).attr("checked",false);
				renameInputRowRencanaAnggaran($("#table-rencanaanggaranpengeluaran"));  
				$("#table-rencanaanggaranpengeluaran").removeClass("animation-loading");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);return false;}
    });
}
/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    var digitnilai = $('#<?php echo CHtml::activeId($model, "digitnilai"); ?>').val();
    $('#digit').html(digitnilai);
});
</script>
