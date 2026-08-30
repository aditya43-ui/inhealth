<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
function validasiDigit(){
var konfig_id=$("#<?php echo CHtml::activeId($model,"konfiganggaran_id");?>").val();
var konfiganggaran_id=$("#konfiganggaran_id").val();
$("#detailRencAnggPeng").addClass("animation-loading");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('CekDigit'); ?>',
            data: {konfig_id:konfig_id},//
            dataType: "json",
            success:function(data){
                $("#digit").html(data.digit);
				$('#konfiganggaran_id').val(konfig_id);  
                $("#detailRencAnggPeng").removeClass("animation-loading");
            },
             error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
}

function tambahRencana()
{
    var konfiganggaran_id = $('#<?php echo CHtml::activeId($model, "konfiganggaran_id"); ?>').val();
    var subkegiatanprogram_id = $('#subkegiatanprogram_id').val();
    var nilaipengeluaran = $('#<?php echo CHtml::activeId($model, "nilairencpengeluaran"); ?>').val();
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
					aktifPeriode();
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }
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
    
    $('#<?php echo CHtml::activeId($modDetail, "subkegiatanprogram_id"); ?>').val('');
    $('#<?php echo CHtml::activeId($model, "programkerja"); ?>').val('');
    $('#<?php echo CHtml::activeId($model, "nilairencpengeluaran"); ?>').val('');
    $('#<?php echo CHtml::activeId($model, "tglrencana"); ?>').val('<?php echo $model->tglrencana; ?>');	
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

function batalRencana(obj){
    myConfirm('Apakah Anda akan membatalkan rencana anggaran pengeluaran ini?','Perhatian!',
    function(r){
        if(r){
            $(obj).parents('tr').detach();
			hitungTotal();
			aktifPeriode();
        }
    });
}

function verifikasi(){
    if(requiredCheck($("agrencanaanggaranpeng-t-form"))){
            if($("#AGRencanggaranpengT_mengetahui_id").val() == "") {
                myAlert("Pegawai Mengetahui harus diisi");
                return false;
            }
            if($("#AGRencanggaranpengT_pegawaimenyetujui_nama").val() == "") {
                myAlert("Pegawai Menyetujui harus diisi");
                return false;
            }
        
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
            $('#agrencanaanggaranpeng-t-form').submit();
        }
        
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float2').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer2').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;
    
}
function aktifPeriode(){
	var jmlRencana = $('#table-rencanaanggaranpengeluaran tbody tr').length;
	if(jmlRencana <= 0){
        $("#<?php echo CHtml::activeId($model, "konfiganggaran_id"); ?>").attr("disabled",false);
	}else{
		$('#<?php echo CHtml::activeId($model, "konfiganggaran_id"); ?>').attr('disabled',true).attr('rel',"tooltip").attr('title',"Batalkan dahulu rencana anggaran pengeluaran");
	}
}
</script>
