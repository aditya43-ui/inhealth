<?php
/**
* - digunakan untuk menampung semua script javascript, agar mudah di tracing
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
?>
<script>    
    
    function getDataRekening(params)
    {
        $("#tblInputRekening > tbody").find('tr').detach();
        $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/GetDataRekeningByJnsPengeluaran');?>', {jenispengeluaran_id:params},
            function(data){
                if(data != null){
                    $("#tblInputRekening > tbody").append(data.replace());
                    renameRowRekening();
//                    hitungTotalHarga();
                    hitungTot();
                }
        }, "json");    
    }
    
    
	function cekSubmit(obj){
		var tr = $("#table-lookup").find('tbody tr');
		var vItem = true;
		var vHargaSatuan = true;
		var vQty = true;
		var vCek = 0;

		if (tr.length == 0){
			myAlert("Maaf, Data pada Tabel Detail belum diisi");
			return false;
		}else{
			var tr = $("#table-lookup").find("tbody > tr");
			
			tr.each(function(){
				if ($(this).find(".pilih").prop("checked") == true){
					vCek = vCek + 1;
				}else{
					vCek = vCek + 0;
				}
			});			
			if (vCek > 0){
                if (!cekJurnalRekening()) return false;
                
				return requiredCheck($("#batalrawatinap-t-form"));
			}else{
				myAlert("Maaf, Data pada Tabel Detail belum dipilih");
				return false;
			}
			
			return false;
		}		
		
	}
    
    function cekJurnalRekening() {
        var total_keluar = parseFloat(unformatNumber($("#KUTandabuktikeluarT_jmlkaskeluar").val()));
        var saldodebit = 0;
        var saldokredit = 0;
        
        $(".saldodebit").each(function() {
            saldodebit += parseFloat(unformatNumber($(this).val()));
        });
        $(".saldokredit").each(function() {
            saldokredit += parseFloat(unformatNumber($(this).val()));
        }); 
        
        if (saldodebit == 0 && saldokredit == 0) return true;
        
        if (saldodebit - saldokredit != 0) {
            myAlert("Maaf, saldo rekening debit dan kredit tidak sama.");
			return false;
        }
        
        if (saldodebit != total_keluar) {
            myAlert("Maaf, saldo rekening dengan total kas keluar tidak sama.");
            return false;
        }
        
        return true;
        
    }

	function hitungTot(){
		var total = 0;            
		unformatNumberSemua();
		$('#table-lookup tbody > tr').each(function(){						  
			var harga  = $(this).find('input[name$="[pengajuanpettydet_hargasatuan]"]').val();
			var qty  = $(this).find('input[name$="[pengajuanpettydet_qty]"]').val();
			var pilih  = $(this).find('.pilih').prop('checked');
			var subtotal = 0;
			
			if (pilih == true){
				if ($.isNumeric(harga) && $.isNumeric(qty)){
					total += parseInt(harga) * parseInt(qty);
					subtotal = parseInt(harga) * parseInt(qty);
				}
			}

			$(this).find('input[name$="[pengajuanpettydet_subtotal]"]').val(subtotal);
		}); 	
		$("#<?php echo CHtml::activeId($model, 'pengajuanpetty_total') ?>").val(total);            
		$("#<?php echo CHtml::activeId($modBukti, 'jmlkaskeluar') ?>").val(total); 
                
		$('.saldodebit').val(total);
		$('.saldokredit').val(total);
                
                formatNumberSemua();
	}     
	
	function reset(){
		$("#<?php echo CHtml::activeId($modBukti, 'nobukti_transfer') ?>").val('');
		$("#<?php echo CHtml::activeId($modBukti, 'melalubank') ?>").val('');
		$("#<?php echo CHtml::activeId($modBukti, 'denganrekening') ?>").val('');
		$("#<?php echo CHtml::activeId($modBukti, 'atasnamarekening') ?>").val('');
	}
	
	function caraBayarPilih(carabayar)
	{
		//myAlert(carabayar);
		if(carabayar == 'TRANSFER'){
			$('#divCaraBayarTransfer').removeClass('hide');
			$("#<?php echo CHtml::activeId($modBukti, 'nobukti_transfer') ?>").addClass('required');
			$("#<?php echo CHtml::activeId($modBukti, 'melalubank') ?>").addClass('required');
			$("#<?php echo CHtml::activeId($modBukti, 'denganrekening') ?>").addClass('required');
			$("#<?php echo CHtml::activeId($modBukti, 'atasnamarekening') ?>").addClass('required');
		} else {
			$('#divCaraBayarTransfer').addClass('hide');
			$("#<?php echo CHtml::activeId($modBukti, 'nobukti_transfer') ?>").removeClass('required error');
			$("#<?php echo CHtml::activeId($modBukti, 'melalubank') ?>").removeClass('required error');
			$("#<?php echo CHtml::activeId($modBukti, 'denganrekening') ?>").removeClass('required error');
			$("#<?php echo CHtml::activeId($modBukti, 'atasnamarekening') ?>").removeClass('required error');			
			reset();
		}
	}
	
	function pilihSemua(obj){
		var cek = $("#pilihsemua").prop("checked");
		var tr = $("#table-lookup").find("tbody > tr");
		
		if (cek == true){
			tr.each(function(){
				$(this).find(".pilih").prop("checked",true);
			});
		}else{
			tr.each(function(){
				$(this).find(".pilih").prop("checked",false);
			});
		}
		
		hitungTot();
	}
    
    function renameRowRekening()
    {
        var idx = 0;
        $("#tblInputRekening > tbody").find('tr').each(
            function()
            {
                unMaskMoneyInput(this);
                maskMoneyInput(this);
                $(this).find('input').each(
                    function()
                    {   
                        var name_field = $(this).attr('name');
                        var id_field = $(this).attr('id');
                        $(this).attr('name', name_field.replace('99', idx));
                        $(this).attr('id', id_field.replace('99', idx));

                    }
                );
                idx++;
            }
        );
    }
    
    function removeDataRekening(obj)
    {
        $(obj).parent().parent('tr').detach();
    }
    
    function unMaskMoneyInput(tr)
    {
        $(tr).find('.integer2:text').unmaskMoney();
    }

    function maskMoneyInput(tr)
    {
        $(tr).find('.integer2:text').maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0});
    }

</script>