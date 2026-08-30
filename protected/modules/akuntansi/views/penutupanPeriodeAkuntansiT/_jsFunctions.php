<script type="text/javascript">
	
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>    
    
       
    
function cekPosting() {
    var rekperiod_id = $('#rekperiod_id').val();
    
    
    
    
    $.post('<?php echo Yii::app()->createUrl('actionAjax/cekJurnalBelumPostingAkun'); ?>', {
        periode: rekperiod_id,
    }, function(data) {
        if (data.ok == 1) loadTabelRekening();
        else {
            myConfirm("Masih ada jurnal yang belum diposting. Apakah Anda akan melanjutkan?", "Perhatian", function(r) {
                if (r) {
                    loadTabelRekening();
                }
            });
        }
    }, 'json');
}   


function cekPeriodeLama() {
    var rekperiod_id = $('#rekperiod_id').val();
    
    $.post('<?php echo Yii::app()->createUrl('actionAjax/cekPeriodeBelumClosing'); ?>', {
        periode: rekperiod_id,
    }, function(data) {
        if (data.ok == 1) cekPosting();
        else {
            myAlert("Periode sebelumnya belum di-close.");
        }
    }, 'json');
}
    
    
function loadTabelRekening(){
$('#table-rekening > tbody > tr').detach(); // set clear
$("#totalDebit").val(""); // set clear
$("#totalKredit").val(""); // set clear

var rekperiod_id = $('#rekperiod_id').val();
$("#table-rekening").addClass("animation-loading");
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('LoadTabelRekening'); ?>',
		data: {rekperiod_id:rekperiod_id},//
		dataType: "json",
		success:function(data){
			if(data.pesan == ""){
				alert("Rekening Periode atau periode posting tidak ada pada buku besar");
				return false;
			}else{
                $("#table-rekening").append(data.form);
                $("#table-rekening").removeClass("animation-loading");
                totalDebitKredit();

                if (data.periode_kosong == 0) {
                    $("#is_rekeningbaru").val(0);
                    $(".panel-periode").hide();
                } else {
                    $("#is_rekeningbaru").val(1);
                    $(".panel-periode").show();
                    $("#AKRekperiodM_perideawal").val(data.tglawal_periode);
                    $("#AKRekperiodM_sampaidgn").val(data.tglakhir_periode);
                    $("#AKRekperiodM_deskripsi").val(data.deskripsi_periode);
                    
                }
			}
		},
		 error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

function totalDebitKredit(){
		var totalDebit = 0;
		var totalKredit = 0;
	$('#table-rekening  tbody  tr').each(function(){
		var debit = $(this).find('.debit').val();
		var kredit = $(this).find('.kredit').val();
        totalDebit += parseFloat(debit);
        totalKredit +=  parseFloat(kredit);
	});

    $("#totalDebit").val(formatThousandDecimal(totalDebit));
    $("#totalKredit").val(formatThousandDecimal(totalKredit));
    
    formatNumberSemua();
}

function verifikasi(){
    // cek balance
    if ($("#totalDebit").val() != $("#totalKredit").val()) {
        myConfirm("Total Saldo Debit dengan Kredit tidak sama. Apakah anda akan melanjutkan?", "Perhatian", function(r) {
            if (r) {
                verifikasiInputPeriode();
            }
        });
        // myAlert("Total Saldo Debit dengan Kredit tidak sama. Apakah anda akan melanjutkan?", "Perhatian");
        // return false;
    } else {
        verifikasiInputPeriode();
    }

}

function verifikasiInputPeriode() {
    var jmlRekening = $('#table-rekening tbody tr').length;
    var is_rekeningbaru = $("#is_rekeningbaru").val();
	var deskripsi = $('#<?php echo CHtml::activeId($modRekPeriod, "deskripsi"); ?>').val();

 
	if(jmlRekening <= 0){
		myAlert('Isikan periode rekening terlebih dahulu.');
		return false;
	}else if(is_rekeningbaru === "1"){
		if (deskripsi == ""){
			alert('Isikan deskripsi terlebih dahulu');
			return false;
		}else{
			$('#perioderekening-t-form').submit();
		}
	}else{
			$('#perioderekening-t-form').submit();
	}
}

</script>