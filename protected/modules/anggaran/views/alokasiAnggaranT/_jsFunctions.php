<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
function validasiDigit(){
var konfig_id=$("#<?php echo CHtml::activeId($model,"konfiganggaran_id");?>").val();
var konfiganggaran_id=$("#konfiganggaran_id").val();
$("#form-alokasianggaran").addClass("animation-loading");
	if(konfig_id != ''){
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('CekDigit'); ?>',
			data: {konfig_id:konfig_id},//
			dataType: "json",
			success:function(data){
				$("#digit").html(data.digit);
				$("#digitlabel").html(data.digit);
				$('#konfiganggaran_id').val(konfig_id);  
				$("#form-alokasianggaran").removeClass("animation-loading");
			},
			 error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}else{
		$("#digit").html('');
		$("#digitlabel").html('');
		$('#konfiganggaran_id').val('');
		$("#form-alokasianggaran").removeClass("animation-loading");
	}
}
function tambahAlokasi()
{
	unformatNumberSemua();
    var konfiganggaran_id = $('#<?php echo CHtml::activeId($model, "konfiganggaran_id"); ?>').val();
    var sumberanggaran_id = $('#<?php echo CHtml::activeId($model, "sumberanggaran_id"); ?>').val();
    var realisasianggpenerimaan_id = $('#<?php echo CHtml::activeId($model, "realisasianggpenerimaan_id"); ?>').val();
	var apprrencanggaran_id = $('#apprrencanggaran_id').val();
	var programkerja_id = $('#programkerja_id').val();
	var subprogramkerja_id = $('#subprogramkerja_id').val();
	var kegiatanprogram_id = $('#kegiatanprogram_id').val();
	var subkegiatanprogram_id = $('#kegiatanprogram_id').val();
	var nilaipengeluaran = unformatNumber($('#nilaipengeluaran').val());
    var nilaiygdialokasikan = unformatNumber($('#<?php echo CHtml::activeId($model, "nilaiygdialokasikan"); ?>').val());
		
	if(nilaipengeluaran < nilaiygdialokasikan){
		myAlert('Maaf Nilai yang dialokasikan tidak boleh lebih dari Nilai Pengeluaran');
		return false;
	}
	if (konfiganggaran_id == ''){
		myAlert('Periode Anggaran belum dipilih!');
	}else if(sumberanggaran_id == ''){
		myAlert('Sumber Anggaran belum dipilih!');
	}else if (nilaiygdialokasikan == '' || nilaiygdialokasikan == 0){
		myAlert('Nilai Alokasi belum ditentukan!');
	}else{
		if (cekAlokasiAnggaran(subkegiatanprogram_id,nilaipengeluaran,nilaiygdialokasikan) == true){    
			$.ajax({
				type:'POST',
				url:'<?php echo $this->createUrl('loadFormTambahAlokasiAnggaran'); ?>',
				data: {apprrencanggaran_id:apprrencanggaran_id,sumberanggaran_id:sumberanggaran_id,realisasianggpenerimaan_id:realisasianggpenerimaan_id,programkerja_id:programkerja_id,subprogramkerja_id:subprogramkerja_id,kegiatanprogram_id:kegiatanprogram_id,nilaiygdialokasikan:nilaiygdialokasikan,nilaipengeluaran:nilaipengeluaran},
				dataType: "json",
				success:function(data){
					if(data.pesan !== ""){
						myAlert(data.pesan);
						return false;
					}
					$('#table-alokasianggaran > tbody').append(data.form);
					$("#table-alokasianggaran").find('input[name$="[ii][subkegiatanprogram_id]"]').val(subkegiatanprogram_id);
					$("#table-alokasianggaran").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
						{"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
					);	
					renameInputRowAlokasiAnggaran($("#table-alokasianggaran"));                    
					hitungTotal();

					$('#programkerja_id').val('');
					$('#subprogramkerja_id').val('');
					$('#kegiatanprogram_id').val('');
					$('#kegiatanprogram_id').val('');
					$('#nilaipengeluaran').val('');
					$('#<?php echo CHtml::activeId($model, "nilaipengeluaran"); ?>').val('');
					$('#<?php echo CHtml::activeId($model, "nilaiygdialokasikan"); ?>').val('');
					$('#<?php echo CHtml::activeId($model, "subkegiatanprogram_nama"); ?>').val('');
					formatNumberSemua();
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
		}
	}
	formatNumberSemua();
}

/**
* rename input grid
*/ 
function renameInputRowAlokasiAnggaran(obj_table){
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

function batalAlokasi(obj){
    myConfirm('Apakah Anda akan membatalkan alokasi anggaran ini?','Perhatian!',
    function(r){
        if(r){
            $(obj).parents('tr').detach();
			hitungTotal();
        }
    });
}

function hitungTotal(){
    unformatNumberSemua();
    var total_nilairencana = 0;
    var total_nilaialokasi = 0;
	var sisaanggaran = 0;
    var nilaipenerimaan = $('#nilaipenerimaan').val();
    var nilaisisaanggaran = $('#sisaanggaran').val();
    $('#table-alokasianggaran tbody tr').each(function(){
        var nilairencana  = parseInt($(this).find('input[name$="[nilairencana]"]').val());
        var nilaialokasi  = parseInt($(this).find('input[name$="[nilaiygdialokasikan]"]').val());
		if(nilairencana <= 0){
            nilairencana = 0;
        }
		if(nilaialokasi <= 0){
            nilaialokasi = 0;
        }
        total_nilairencana += nilairencana;
        total_nilaialokasi += nilaialokasi;
		
    });
	if(nilaisisaanggaran == nilaipenerimaan){
		sisaanggaran = nilaipenerimaan - total_nilaialokasi;
	}else if(nilaisisaanggaran < nilaipenerimaan){
		sisaanggaran = nilaisisaanggaran - total_nilaialokasi;
	}else{
		sisaanggaran = nilaisisaanggaran - total_nilaialokasi;
	}
	
	if(sisaanggaran <= 0){
		sisaanggaran = 0;
	}
	
    $('#<?php echo CHtml::activeId($model,"total_nilairencana"); ?>').val(total_nilairencana);  
    $('#<?php echo CHtml::activeId($model,"total_nilaialokasi"); ?>').val(total_nilaialokasi);  
    $('#<?php echo CHtml::activeId($model,"sisaanggaran"); ?>').val(sisaanggaran);  
    formatNumberSemua();
}

function verifikasi(){
    if(requiredCheck($("alokasianggaran-t-form"))){
        var jmlAlokasi = $('#table-alokasianggaran tbody tr').length;
		if(jmlAlokasi <= 0){
			myAlert('Silakan isikan alokasi anggaran terlebih dahulu!');
            return false;
        }else{
            $('#alokasianggaran-t-form').submit();
        }
        
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer2').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;    
}

function cekAlokasiAnggaran(id,nilaidisetujui,nilaidialokasi){
	unformatNumberSemua();
	var nilaidisetujui = unformatNumber(nilaidisetujui);
	var nilaidialokasi = unformatNumber(nilaidialokasi);
	var total_nilairencana = 0;
	var total_nilaialokasi = 0;
	x = true;
	$('#table-alokasianggaran tbody tr').each(function(){
		var nilairencana  = parseInt($(this).find('input[name$="[nilairencana]"]').val());
        var nilaialokasi  = parseInt($(this).find('input[name$="[nilaiygdialokasikan]"]').val());
        var subkegiatanprogram_id  = $(this).find('input[name$="[subkegiatanprogram_id]"]').val();
		if(subkegiatanprogram_id == id){
			total_nilairencana += nilairencana;
			total_nilaialokasi += nilaialokasi;
		}
		if (subkegiatanprogram_id == id && nilairencana == nilaidisetujui && nilairencana == total_nilaialokasi){
			myAlert('Program Kerja sudah dialokasikan!');
			x = false;
			
			$('#<?php echo CHtml::activeId($model, "nilaiygdialokasikan"); ?>').val('');
			$('#<?php echo CHtml::activeId($model, "subkegiatanprogram_nama"); ?>').val('');
		}
	});
	return x;
}
	
/**
 * class integer2 di unformat 
 * @returns {undefined}
 */
function unformatNumberSemua(){
    $(".integer2").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
}
/**
 * class integer2 di format kembali
 * @returns {undefined}
 */
function formatNumberSemua(){
    $(".integer2").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}

/**
* untuk print alokasi anggaran
 */
function print(caraPrint)
{
    var alokasianggaran_id = '<?php echo isset($model->alokasianggaran_id) ? $model->alokasianggaran_id : null ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&alokasianggaran_id='+alokasianggaran_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

$(document).ready(function(){
	var alokasianggaran_id = '<?php echo isset($_GET['alokasianggaran_id']) ? $_GET['alokasianggaran_id'] : null; ?>';
	if(alokasianggaran_id != ''){
		hitungTotal();
	}
});
</script>
