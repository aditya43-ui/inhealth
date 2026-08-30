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
					$('#<?php echo CHtml::activeId($model,"statusDetail"); ?>').val("baru");  
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
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }
}

function hapusRencana(obj,renanggaranpenerimaandet_id){
	if (renanggaranpenerimaandet_id === 0){ //jika data baru ditambahkan, params rencanggaranpengdet_id = kosong
		myConfirm('Apakah Anda akan membatalkan rencana anggaran ini?','Perhatian!',
		function(r){
			if(r){
				$(obj).parents('tr').detach();			
				hitungTotal();
			}
		});
	}else {
		$("#table-rencanaanggaranpenerimaan").addClass("animation-loading");
		myConfirm('Apakah Anda akan membatalkan rencana anggaran ini?','Perhatian!',
		function(r){
			if(r){
					$.ajax({
						type:'POST',
						url:'<?php echo $this->createUrl('HapusRencana'); ?>',
						data: {renanggaranpenerimaandet_id:renanggaranpenerimaandet_id},
						dataType: "json",
						success:function(data){
									$(obj).parents('tr').detach();			
									hitungTotal();
									$("#table-rencanaanggaranpenerimaan").removeClass("animation-loading");
						},
						error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
					});
				}
				$("#table-rencanaanggaranpenerimaan").removeClass("animation-loading");
			});
	}
}

function hitungTotal(){
    unformatNumberSemua();
    var total = 0;
	var jmlRencana = $('#table-rencanaanggaranpenerimaan tbody tr').length;
    $('#table-rencanaanggaranpenerimaan tbody tr').each(function(){
        var nilaianggaran  = parseInt($(this).find('input[name$="[nilaipenerimaan]"]').val());
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
    if(requiredCheck($("ubahanggaran-form"))){
        var jmlRencana = $('#table-rencanaanggaranpenerimaan tbody tr').length;
		if(jmlRencana <= 0){
			myAlert('Silakan isikan rencana anggaran penerimaan terlebih dahulu!');
            return false;
        }else{
            $('#ubahanggaran-form').submit();
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
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    var digitnilai = $('#<?php echo CHtml::activeId($model, "digitnilai"); ?>').val();
    var total_renanggaranpen = $('#<?php echo CHtml::activeId($model, "total_renanggaranpen"); ?>').val();
    $('#digit').html(digitnilai);
    $('#digitlabel').html(digitnilai);	
    $('#<?php echo CHtml::activeId($model,"totalapprove"); ?>').val(total_renanggaranpen);  
	hitungTotal();
});
</script>
