<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
function validasiDigit(){
var konfig_id=$("#<?php echo CHtml::activeId($model,"konfiganggaran_id");?>").val();
var konfiganggaran_id=$("#konfiganggaran_id").val();
$("#detailRencAnggPen").addClass("animation-loading");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('CekDigit'); ?>',
            data: {konfig_id:konfig_id},//
            dataType: "json",
            success:function(data){
                $("#digit").html(data.digit);
                $("#digitlabel").html(data.digit);
				$('#konfiganggaran_id').val(konfig_id);  
                $("#detailRencAnggPen").removeClass("animation-loading");
            },
             error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
}
function tambahRencana()
{
    var konfiganggaran_id = $('#<?php echo CHtml::activeId($model, "konfiganggaran_id"); ?>').val();
    var sumberanggaran_id = $('#<?php echo CHtml::activeId($model, "sumberanggaran_id"); ?>').val();
    var nilaipenerimaananggaran = unformatNumber($('#<?php echo CHtml::activeId($model, "nilaipenerimaananggaran"); ?>').val());
    var berapaxpenerimaan = unformatNumber($('#<?php echo CHtml::activeId($model, "berapaxpenerimaan"); ?>').val());
		
		if (konfiganggaran_id == ''){
			myAlert('Periode Anggaran belum dipilih!');
		}else if(sumberanggaran_id == ''){
			myAlert('Sumber Anggaran belum dipilih!');
		}else if (nilaipenerimaananggaran == '' || nilaipenerimaananggaran == 0){
			myAlert('Nilai Penerimaan belum ditentukan!');
		}else if(berapaxpenerimaan == '' || berapaxpenerimaan == 0){
			myAlert('Jumlah Termin belum ditentukan!');
		}else{
			$('#table-rencanaanggaranpenerimaan > tbody > tr').detach();
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadFormTambahRencana'); ?>',
                data: {nilaipenerimaananggaran:nilaipenerimaananggaran,berapaxpenerimaan:berapaxpenerimaan},
                dataType: "json",
                success:function(data){
					$('#<?php echo CHtml::activeId($model,"total_renanggaranpen");?>').val(formatNumber(nilaipenerimaananggaran));  
                    $('#table-rencanaanggaranpenerimaan > tbody').html(data.form);
					jQuery('input[name$="[tglrenanggaranpen]"]').datepicker(
						jQuery.extend(
							{showMonthAfterYear:true},
							jQuery.datepicker.regional['id'],
							{
								'dateFormat':'dd M yy',
//								'maxDate':'d',
//								'timeText':'Waktu',
//								'hourText':'Jam',
//								'minuteText':'Menit',
//								'secondText':'Detik',
//								'showSecond':true,
//								'timeOnlyTitle':'Pilih Waktu',
//								'timeFormat':'hh:mm:ss',
								'changeYear':true,
								'changeMonth':true,
								'showAnim':'fold',
								'yearRange':'-0y:+10y'
							}
						)
					);
					$('input[name$="[tglrenanggaranpen]"]').each(function() {
						var obj = $(this);
						$(this).parent().find(".add-on").click(function() {
							$(obj).focus();
						});
					});
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }
}

function batalRencana(obj){
    myConfirm('Apakah Anda akan membatalkan rencana anggaran pengeluaran ini?','Perhatian!',
    function(r){
        if(r){
            $(obj).parents('tr').detach();
			hitungTotal();
        }
    });
}

function hitungTotal(){
    unformatNumberSemua();
    var total = 0;
	var jmlRencana = $('#table-rencanaanggaranpenerimaan tbody tr').length;
    $('#table-rencanaanggaranpenerimaan tbody tr').each(function(){
        var nilaianggaran  = parseInt($(this).find('input[name$="[hasil]"]').val());
		if(nilaianggaran <= 0){
            nilaianggaran = 0;
        }
        total += nilaianggaran;
		
    });
    $('#<?php echo CHtml::activeId($model,"total_renanggaranpen"); ?>').val(formatNumber(total));  
    $('#<?php echo CHtml::activeId($model,"nilaipenerimaananggaran"); ?>').val(total); 
    $('#<?php echo CHtml::activeId($model,"berapaxpenerimaan"); ?>').val(jmlRencana);    
    formatNumberSemua();
}

function verifikasi(){
    if(requiredCheck($("rencanaanggaranpenerimaan-t-form"))){
        if($("#AGRenanggpenerimaanT_renpen_mengetahui_id").val() == "") {
            myAlert("Pegawai Mengetahui harus diisi");
            return false;
        }
        if($("#AGRenanggpenerimaanT_renpen_menyetujui_id").val() == "") {
            myAlert("Pegawai Menyetujui harus diisi");
            return false;
        }
        
        var jmlRencana = $('#table-rencanaanggaranpenerimaan tbody tr').length;
		if(jmlRencana <= 0){
			myAlert('Silakan isikan rencana anggaran penerimaan terlebih dahulu!');
            return false;
        }else{
            $('#rencanaanggaranpenerimaan-t-form').submit();
        }
        
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.floar2').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer2').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;
    
}
</script>
