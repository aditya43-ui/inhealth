<script type="text/javascript">

	var trUraian = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view. '_rowUraian', array('form' => $form, 'modUraian' => $modUraian, 'removeButton' => true), true)); ?>);
//var trUraian=new String(<?php //echo CJSON::encode($this->renderPartial('_rowUraian',array('form'=>$form,'modUraian'=>array(0=>$modUraian[0]),'removeButton'=>true),true)); ?>);
	

	function removeDataRekening(obj)
	{
		$(obj).parent().parent('tr').detach();
	}

function getDataRekeningCarapembayar()
	{
            var params = $("#KUTandabuktibayarT_carapembayaran").val();
            var bankid = "";
            if ($('#pakeKartu').is(':checked')){
                bankid = $("#KUTandabuktibayarT_bank_id").val();
            }
            
		$("#tblInputRekening > tbody").find('.trdebitcarabayar').detach();
		$.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/GetDataRekeningByCaraPembayaran'); ?>', {carapembayaran: params, bankid:bankid},
		function (data) {
			if (data != null) {
				$("#tblInputRekening > tbody").append(data.replace());
                                renameRowRekening();
                                getDataRekeningColumn();
				hitungTotalHarga();
			}
		}, "json");
	}
        
function getDataRekening(params)
	{
		$("#tblInputRekening > tbody").find('.trrekjnspenerimaan').detach();
		$.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/GetDataRekeningByJnsPenerimaan'); ?>', {jenispenerimaan_id: params},
		function (data) {
			if (data != null) {
				$("#tblInputRekening > tbody").append(data.replace());
				renameRowRekening();
			}
		}, "json");
	}
        
        function getDataRekeningColumn()
        {
            $("#tblInputRekening > tbody").find('.trdebitrekeningcolumn').detach();
            var pph3 = parseFloat($("#KUPenerimaanUmumT_persenpph_23").val());
            var pph = parseFloat($("#KUPenerimaanUmumT_persenpph_22").val());
            var pph1 = parseFloat($("#KUPenerimaanUmumT_persenpph_21").val());
            var ppn = parseInt($("#KUPenerimaanUmumT_persenppn").val());
            var adm = parseInt($("#KUTandabuktibayarT_biayaadministrasi").val());
            var materai = parseInt($("#KUTandabuktibayarT_biayamaterai").val());

            $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/GetDataRekeningByRekeningColumn');?>',
            {jmlpph:pph,jmlpph1:pph1,jmlpph3:pph3, jmlppn:ppn, biayaadministrasi:adm, biayamaterai:materai},
                function(data){
                    if(data != null){
                            $("#tblInputRekening > tbody").find('.trdebitcarabayar').after(data.replace());
                            renameRowRekening();
                            hitungTotalHarga();
//                            formatNumberSemua();
                    }
            }, "json");    
        }
        
        function changeRekColumnDataLoad(value){
//            unformatNumberSemua();
            var nilai = $(value).val();

            if(parseFloat(nilai) > 0){
                getDataRekeningColumn();
            }else{
				$("#tblInputRekening > tbody").find('tr').each(function(){
					if($(this).find('.columnbiayaadm').hasClass('columnbiayaadm') == true){
						$(this).find('.columnbiayaadm').parent('tr').remove();
					}
					if($(this).find('.columnbiayamaterai').hasClass('columnbiayamaterai') == true){
						$(this).find('.columnbiayamaterai').parent('tr').remove();
					}
					if($(this).find('.columnpph23').hasClass('columnpph23') == true){
						$(this).find('.columnpph23').parent('tr').remove();
					}
					if($(this).find('.columnppn').hasClass('columnppn') == true){
						$(this).find('.columnppn').parent('tr').remove();
					}
					if($(this).find('.columnpph22').hasClass('columnpph22') == true){
						$(this).find('.columnpph22').parent('tr').remove();
					}
					if($(this).find('.columnpph21').hasClass('columnpph21') == true){
						$(this).find('.columnpph21').parent('tr').remove();
					}
				});
				
			}
//            formatNumberSemua();
        }
        
        function renameRowRekening()
	{
		var idx = 0;
		$("#tblInputRekening > tbody").find('tr').each(
				function ()
				{
					unMaskMoneyInput(this);
					maskMoneyInput(this);
                                        $(this).find('input[name$="[rekening1_id]"]').attr('name', 'RekeningakuntansiV['+idx+'][rekening1_id]');
                                         $(this).find('input[name$="[rekening1_id]"]').attr('id', 'RekeningakuntansiV_'+idx+'_rekening1_id');
                                         $(this).find('input[name$="[rekening2_id]"]').attr('name', 'RekeningakuntansiV['+idx+'][rekening2_id]');
                                         $(this).find('input[name$="[rekening2_id]"]').attr('id', 'RekeningakuntansiV_'+idx+'_rekening2_id');
                                         $(this).find('input[name$="[rekening3_id]"]').attr('name', 'RekeningakuntansiV['+idx+'][rekening3_id]');
                                         $(this).find('input[name$="[rekening3_id]"]').attr('id', 'RekeningakuntansiV_'+idx+'_rekening3_id');
                                         $(this).find('input[name$="[rekening4_id]"]').attr('name', 'RekeningakuntansiV['+idx+'][rekening4_id]');
                                         $(this).find('input[name$="[rekening4_id]"]').attr('id', 'RekeningakuntansiV_'+idx+'_rekening4_id');
                                         $(this).find('input[name$="[rekening5_id]"]').attr('name', 'RekeningakuntansiV['+idx+'][rekening5_id]');
                                         $(this).find('input[name$="[rekening5_id]"]').attr('id', 'RekeningakuntansiV_'+idx+'_rekening5_id');
                                         $(this).find('input[name$="[nama_rekening]"]').attr('name', 'RekeningakuntansiV['+idx+'][nama_rekening]');
                                         $(this).find('input[name$="[nama_rekening]"]').attr('id', 'RekeningakuntansiV_'+idx+'_nama_rekening');
                                         $(this).find('input[name$="[saldodebit]"]').attr('name', 'RekeningakuntansiV['+idx+'][saldodebit]');
                                         $(this).find('input[name$="[saldodebit]"]').attr('id', 'RekeningakuntansiV_'+idx+'_saldodebit');
                                         $(this).find('input[name$="[saldokredit]"]').attr('name', 'RekeningakuntansiV['+idx+'][saldokredit]');
                                         $(this).find('input[name$="[saldokredit]"]').attr('id', 'RekeningakuntansiV_'+idx+'_saldokredit');
					idx++;
				}
		);
	}

//	function getDataRekening(params)
//	{
//		$("#tblInputRekening > tbody").find('tr').detach();
//		$.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/GetDataRekeningByJnsPenerimaan'); ?>', {jenispenerimaan_id: params},
//		function (data) {
//			if (data != null) {
//				$("#tblInputRekening > tbody").append(data.replace());
//				renameRowRekening();
//				hitungTotalHarga();
//			}
//		}, "json");
//	}

//	function renameRowRekening()
//	{
//		var idx = 0;
//		$("#tblInputRekening > tbody").find('tr').each(
//				function ()
//				{
//					unMaskMoneyInput(this);
//					maskMoneyInput(this);
//					$(this).find('input').each(
//							function ()
//							{
//								var name_field = $(this).attr('name');
//								var id_field = $(this).attr('id');
//								$(this).attr('name', name_field.replace('99', idx));
//								$(this).attr('id', id_field.replace('99', idx));
//
//							}
//					);
//					idx++;
//				}
//		);
//	}

    var is_submit = false;

	function simpanPenerimaan(params)
	{
        if (is_submit) return false;
        if (!cekInput()) return false;
        
        
        
        
        var total_harga = parseFloat(unformatNumber($('#KUTandabuktibayarT_jmlpembayaran').val()));
        var total_debit = 0;
        var total_kredit = 0;
        
        $("#tblInputRekening .saldodebit").each(function() {
            total_debit += parseFloat(unformatNumber($(this).val()));
        });
        $("#tblInputRekening .saldokredit").each(function() {
            total_kredit += parseFloat(unformatNumber($(this).val()));
        });
        
        console.log("Lister", total_debit, total_kredit, total_harga);
        
        if (total_debit != total_kredit) {
            myAlert("Total Debit dan Kredit tidak sama.");
            return false;
        }
        
//        if (total_debit != total_harga) {
//            myAlert("Total nilai rekening tidak sesuai dengan Total Harga di Form.");
//            return false;
//        }
        
        
        // console.log("OK");
        // return false;

        
        
        
		jenis_simpan = params;
		var kosong = "";
		// var dataKosong = $("#input-penerimaan-kas").find(".reqForm[value=" + kosong + "]");
		if(!requiredCheck($("#akpenerimaan-umum-t-form"))){
            // if(requiredCheck($("#akpenerimaan-umum-t-form"))){
                myAlert('Bagian dengan tanda * harus diisi ');
				return false;
            // }
		} else {

			var detail = 0;
			$('#tblInputUraian tbody tr').each(
					function () {
						var total_hgr = $(this).find('input[name$="[totalharga]"]');
						if (total_hgr.length > 0) {
							detail++;
						}
					}
			);
			if ($('#pakeAsuransi').prop('checked')) {
				if (detail == 0) {
					myAlert('Detail uraian masih kosong');
					return false;
				}
			}

			$('.integer2, float2').each(//currency
					function () {
						this.value = unformatNumber(this.value)
					}
			);
    
            is_submit = true;

			$.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/SimpanPenerimaan'); ?>', {jenis_simpan: jenis_simpan, data: $('#akpenerimaan-umum-t-form').serialize()},
			function (data) {
				if (data.status == 'ok')
				{
					if (data.action == 'insert')
					{
						myAlert("Simpan data berhasil");
						$("#tblInputUraian").find('tr[class$="child"]').detach();
                                                // location.reload();
						$("#reseter").click();
						url = '<?php echo $this->createUrl("Print&id='+data.pesan.id+'"); ?>';
						$('#url').val(url);
						$('#btn_print').prop('disabled', false);
						$("#input-penerimaan-kas").find("input[name$='[nopenerimaan]']").val(data.pesan.nopenerimaan);
						$("#tblInputRekening > tbody").find('tr').detach();
					} else {
						myAlert("Update data berhasil");
					}
                    
                    is_submit = false;
				} else {
					myAlert("Data gagal disimpan");
				}
			}, "json");

		}
		return false;
	}

	function cekInput()
	{
		var harga = 0;
		var totharga = 0;
        var is_kosong = false;
        
        
        
        
        
		if ($('#pakeAsuransi').is(':checked')) {
            $("#tblInputUraian .uraiantransaksi").each(function() {
                
                // console.log($(this).val().trim() == '');
                
                if ($(this).val().trim() == '') is_kosong = true;
            });

            if (is_kosong) {
                myAlert("Uraian transaksi harus diisi!");
                return false;
            }
            
			$('#tblInputUraian').find('input[name$="[hargasatuan]"]').each(function () {
				harga = harga + unformatNumber(this.value);
			});
			$('#tblInputUraian').find('.totalharga').each(function () {
				totharga += parseFloat(unformatNumber(this.value));
			});

			//if(harga != unformatNumber($('#KUPenerimaanUmumT_hargasatuan').val())){
			//    myAlert('Harga tidak sesuai');return false;
			//}
            
            
            if (totharga != parseFloat(unformatNumber($('#KUPenerimaanUmumT_totalharga').val()))) {
                myAlert('Total Uraian tidak sesuai dengan Total Harga di Form.');
                return false;
            }
		}
        
        
        
        
        // return false;
         
		

		return true;
	}

	function hitungTotalUraian(obj)
	{
		var volume = unformatNumber($(obj).parents('tr').find('input[name$="[volume]"]').val());
		var hargasatuan = unformatNumber($(obj).parents('tr').find('input[name$="[hargasatuan]"]').val());
		$(obj).parents('tr').find('input[name$="[totalharga]"]').val(formatNumber(volume * hargasatuan));
		totalTagihan();
        hitungTotalHarga();
	}

    function hitungTotalHarga()
    {
        unformatNumberSemua();
		var biayaAdministrasi = parseInt($('#KUTandabuktibayarT_biayaadministrasi').val());
		var biayaMaterai = parseInt($('#KUTandabuktibayarT_biayamaterai').val());
		var vol = parseInt($('#KUPenerimaanUmumT_volume').val());
		var harga = parseFloat($('#KUPenerimaanUmumT_hargasatuan').val());
                
        var pph22 = parseFloat($('#KUPenerimaanUmumT_persenpph_22').val());
        var pph23 = parseFloat($('#KUPenerimaanUmumT_persenpph_23').val());
        var pph21 = parseFloat($('#KUPenerimaanUmumT_persenpph_21').val());
        var ppn = parseFloat($('#KUPenerimaanUmumT_persenppn').val());

        var jmlNetto = (vol * harga);
        var jmlpph21 = ((pph21 * jmlNetto)/100);
        var jmlpph22 = ((pph22 * jmlNetto)/100);
        var jmlpph23 = ((pph23 * jmlNetto)/100);
        var jmlppn = ((ppn * jmlNetto)/100);
        var totalharga = ((jmlNetto + jmlpph21 + jmlpph22 + jmlpph23)-(jmlppn + biayaAdministrasi + biayaMaterai));
        

//        var subtotal = vol * harga;

        //var pph22_total = (pph22/100) * subtotal;
//        var pph23_total = (pph23/100) * subtotal;
//
//        var totalharga = (vol * harga) + pph23_total;
//        var ppn_total = (ppn/100) * totalharga;
		
        
        $('#KUPenerimaanUmumT_totalharga').val(jmlNetto);
        $('#KUPenerimaanUmumT_jmlpph_21').val(jmlpph21);
        $('#KUPenerimaanUmumT_jmlpph_22').val(jmlpph22);
        $('#KUPenerimaanUmumT_jmlpph_23').val(jmlpph23);
        $('#KUPenerimaanUmumT_ppn').val(jmlppn);
        $('#totTagihan').val(formatNumber(totalharga));
        $('#KUTandabuktibayarT_jmlpembayaran, #KUTandabuktibayarT_uangditerima').val(totalharga);
        
        $('#tblInputRekening').find('.trdebitcarabayar').find('.saldodebit').val(jmlNetto);
        $('#tblInputRekening').find('.trrekjnspenerimaan').find('.saldokredit').val(totalharga);
        $('#tblInputRekening').find('.trdebitrekeningcolumn').find('.columnppn').val(jmlppn);
        $('#tblInputRekening').find('.trdebitrekeningcolumn').find('.columnpph23').val(jmlpph23);
        $('#tblInputRekening').find('.trdebitrekeningcolumn').find('.columnpph21').val(jmlpph21);
        $('#tblInputRekening').find('.trdebitrekeningcolumn').find('.columnpph22').val(jmlpph22);
        $('#tblInputRekening').find('.trdebitrekeningcolumn').find('.columnbiayaadm').val(biayaAdministrasi);
        $('#tblInputRekening').find('.trdebitrekeningcolumn').find('.columnbiayamaterai').val(biayaMaterai);
        
        
//        $(".jmlpph_23 .input_pph").parents("tr").hide().find("input").prop("disabled", true);
//        $(".penerimaan_biayaadministrasi .input_pph").parents("tr").hide().find("input").prop("disabled", true);
//        $(".penerimaan_biayamaterai .input_pph").parents("tr").hide().find("input").prop("disabled", true);

//        if (pph22_total > 0) {
//            $(".jmlpph_22 .input_pph").parents("tr").show().find("input").prop("disabled", false);
//        }
//        if (pph23_total > 0) {
//            $(".jmlpph_23 .input_pph").parents("tr").show().find("input").prop("disabled", false);
//        }
//        if (biayaAdministrasi > 0) {
//            $(".penerimaan_biayaadministrasi .input_pph").parents("tr").show().find("input").prop("disabled", false);
//        }
//        if (biayaMaterai > 0) {
//            $(".penerimaan_biayamaterai .input_pph").parents("tr").show().find("input").prop("disabled", false);
//        }
        
        
//		$('#KUTandabuktibayarT_jmlpembayaran, #KUTandabuktibayarT_uangditerima').val(formatNumber(totalharga + biayaAdministrasi + biayaMaterai));
		
//		$('.saldodebit').val(formatNumber(totalharga - pph23_total + biayaAdministrasi + biayaMaterai));
//		$('.saldokredit').not(".input_pph").val(formatNumber((vol * harga) + pph23_total - ppn_total));
////        $('#KUPenerimaanUmumT_jmlpph_22, .jmlpph_22 .input_pph').val(formatNumber(pph22_total));
//        $('#KUPenerimaanUmumT_jmlpph_23, .jmlpph_23 .input_pph').val(formatNumber(pph23_total));
//        $('#KUPenerimaanUmumT_ppn, .ppn .input_pph').val(formatNumber(ppn_total));
//        $('.penerimaan_biayaadministrasi .input_pph').val(formatNumber(biayaAdministrasi));
//        $('.penerimaan_biayamaterai .input_pph').val(formatNumber(biayaMaterai));
        
        
       
         formatNumberSemua();       
        hitungKembalian();
               
    }

	function bukaUraian(obj)
	{
		if ($(obj).is(':checked')) {
			$('#div_tblInputUraian').slideDown();
            totalTagihan();
		} else {
			$('#div_tblInputUraian').slideUp();
            hitungTotalHarga();
		}
	}

	function addRowUraian(obj)
	{
		$(obj).parents('table').children('tbody').append(trUraian.replace());

		renameInput('KUUraianpenumumT', 'uraiantransaksi');
		renameInput('KUUraianpenumumT', 'volume');
		renameInput('KUUraianpenumumT', 'satuanvol');
		renameInput('KUUraianpenumumT', 'hargasatuan');
		renameInput('KUUraianpenumumT', 'totalharga');
        
        
        
		jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
        
        $('#tblInputUraian tbody tr:last-child .integer_x').maskMoney(
				{
					"symbol": "",
					"defaultZero": true,
					"allowZero": true,
					"decimal": ",",
					"thousands": "",
					"precision": 0
				}
		);
        maskMoneyInput($('#tblInputUraian > tbody > tr:last'));
        
        refreshLinkUraian();
	}
    
    function refreshLinkUraian() {
        var i = 0;
        $("#tblInputUraian tbody .removeUraianNew").each(function() {
            if (i++ != 0) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

	function totalTagihan()
	{
		var total = 0;
		$("#tblInputUraian").find('input[name$="[totalharga]"]').each(
				function () {
					total += unformatNumber($(this).val());
				}
		);
		$("#totTagihan").val(formatNumber(total));
		$("#KUTandabuktibayarT_jmlpembayaran").val(formatNumber(total));
	}

	function perhitunganUang()
	{
		var biayaadministrasi = unformatNumber($("#KUTandabuktibayarT_biayaadministrasi").val());
		var biayamaterai = unformatNumber($("#KUTandabuktibayarT_biayamaterai").val());
		var uangditerima = unformatNumber($("#KUTandabuktibayarT_uangditerima").val());
		$("#KUTandabuktibayarT_jmlpembayaran").val(biayaadministrasi + biayamaterai + uangditerima);
	}

	function totaltagihankeseluruhan(obj)
	{
		var totaltagihan = 0;
		var totalharga = 0;
		var totalbaris = 0;
		$(obj).each(function ()
		{
			totalbaris = $(obj).parents("tr").children(".totalharga").val();
			totalharga = unformatNumber(totalbaris);
			totaltagihan += totalharga;
		});
//    $('#totTagihan').hide();
		$('#totTagihan').val(totaltagihan);
	}

	function batalUraian(obj)
	{
		myConfirm("Apakah Anda yakin akan membatalkan Uraian?", 'Perhatian!', function (r) {
			if (r) {
				$(obj).parents('tr').next('tr').detach();
				$(obj).parents('tr').detach();

				renameInput('KUUraianpenumumT', 'uraiantransaksi');
				renameInput('KUUraianpenumumT', 'volume');
				renameInput('KUUraianpenumumT', 'satuanvol');
				renameInput('KUUraianpenumumT', 'hargasatuan');
				renameInput('KUUraianpenumumT', 'totalharga');
			}
		});
	}

	function renameInput(modelName, attributeName)
	{
		var trLength = $('#tblInputUraian tr').length;
		var i = -1;
		$('#tblInputUraian tr').each(function () {
			if ($(this).has('input[name$="[uraiantransaksi]"]').length) {
				i++;
			}
			$(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
			$(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
			$(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
			$(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
		});
	}

	function enableInputKartu()
	{
		if ($('#pakeKartu').is(':checked')){
			$('#divDenganKartu').show();
                    }else{
			$('#divDenganKartu').hide();
                         $('#BKTandabuktibayarT_dengankartu').val('');
        $('#KUTandabuktibayarT_bankkartu').val('');
        $('#KUTandabuktibayarT_nokartu').val('');
        $('#KUTandabuktibayarT_nostrukkartu').val('');
        $('#KUTandabuktibayarT_bank_id').val('');
        $('#KUTandabuktibayarT_bank_nominal').val('');
		getDataRekeningCarapembayar();
                    }
		if ($('#KUTandabuktibayarT_dengankartu').val() != '') {
//			myAlert('isi');
			 $('#KUTandabuktibayarT_bankkartu').attr('disabled',false);
        $('#KUTandabuktibayarT_nokartu').attr('disabled',false);
        $('#KUTandabuktibayarT_nostrukkartu').attr('disabled',false);
        $('#KUTandabuktibayarT_bank_id').attr('disabled',false);
        $('#KUTandabuktibayarT_bank_id').attr('disabled',false);
        $('#KUTandabuktibayarT_bank_nominal').attr('disabled',false);
        $('#KUTandabuktibayarT_nokartu').attr('disabled',false);
        $('#KUTandabuktibayarT_nostrukkartu').attr('disabled',false);
		} else {
//			myAlert('kosong');
			$('#KUTandabuktibayarT_bankkartu').attr('disabled',true);
                        $('#KUTandabuktibayarT_nokartu').attr('disabled',true);
                        $('#KUTandabuktibayarT_nostrukkartu').attr('disabled',true);
                        $('#KUTandabuktibayarT_bank_id').attr('disabled',true);
                        $('#KUTandabuktibayarT_bank_id').attr('disabled',true);
                        $('#KUTandabuktibayarT_bank_nominal').attr('disabled',true);
                        $('#KUTandabuktibayarT_nokartu').attr('disabled',true);
                        $('#KUTandabuktibayarT_nostrukkartu').attr('disabled',true);

                        $('#KUTandabuktibayarT_bankkartu').val('');
                        $('#KUTandabuktibayarT_nokartu').val('');
                        $('#KUTandabuktibayarT_nostrukkartu').val('');
                        $('#KUTandabuktibayarT_bank_id').val('');
                        $('#KUTandabuktibayarT_bank_nominal').val('');
		}
	}

	function ubahCaraPembayaran(obj)
	{
		if (obj.value == 'CICILAN') {
			$('#KUTandabuktibayarT_jmlpembayaran').removeAttr('readonly');
		} else {
			$('#KUTandabuktibayarT_jmlpembayaran').attr('readonly', true);
			hitungJmlBayar();
		}

		if (obj.value == 'TUNAI') {
			hitungJmlBayar();
		}
	}

	function hitungJmlBayar()
	{
        /*
		var biayaAdministrasi = unformatNumber($('#KUTandabuktibayarT_biayaadministrasi').val());
		var biayaMaterai = unformatNumber($('#KUTandabuktibayarT_biayamaterai').val());
		var totTagihan = unformatNumber($('#totTagihan').val());
		var jmlPembulatan = unformatNumber($('#KUTandabuktibayarT_jmlpembulatan').val());
		var totBayar = totTagihan + jmlPembulatan + biayaAdministrasi + biayaMaterai;
		$('#KUTandabuktibayarT_jmlpembayaran').val(formatNumber(totBayar));
        */
        hitungTotalHarga();
		hitungKembalian();
	}

	function hitungKembalian()
	{
		var jmlBayar = unformatNumber($('#KUTandabuktibayarT_jmlpembayaran').val());
		var uangDiterima = unformatNumber($('#KUTandabuktibayarT_uangditerima').val());
		var uangKembalian = uangDiterima - jmlBayar;
		if (uangKembalian < 0)
		{
			uangKembalian = 0;
		}
		$('#KUTandabuktibayarT_uangkembalian').val(formatNumber(uangKembalian));

	}

	function print(caraPrint)
	{
		if ($('#url').val() == '') {
			myAlert('Lakukan transaksi terlebih dahulu dengan benar!');
			return false;
		}
		window.open($('#url').val() + "&caraPrint=" + caraPrint, "", 'location=_new, width=900px');
	}

	function unMaskMoneyInput(tr)
	{
//		$(tr).find('input.integer2:text').unmaskMoney();
	}

	function maskMoneyInput(tr)
	{
//		$(tr).find('input.integer2:text').maskMoney(
//				{
//					"symbol": "Rp",
//					"defaultZero": true,
//					"allowZero": true,
//					"decimal": ",",
//					"thousands": ".",
//					"precision": 0
//				}
//		);
	}
    
  function getSebagaiBayar(value){
      var textData = (value +" - <?php echo MyFormatter::getMonthId(date('m')) ." ".date('Y'); ?>");
      
      $('#<?php echo CHtml::activeId($modTandaBukti,'sebagaipembayaran_bkm'); ?>').val(textData);
  }  
    
//function formatNumber(number)
//{
//    return accounting.formatNumber(number, 0, '.', ',');
//}

//    $('.integer2').each(function () {//currency
//		this.value = formatNumber(this.value)
//	});

    $(document).ready(function() {
        <?php
        if(@$_GET['id']){
        ?>
             var id = <?php echo $modPenUmum->jenispenerimaan_id; ?>;    
             hitungTotalHarga(); 
             getDataRekening(id);
        <?php
        }
        ?>
        $('#tblInputUraian tbody .integer_x').maskMoney(
				{
					"symbol": "",
					"defaultZero": true,
					"allowZero": true,
					"decimal": ",",
					"thousands": "",
					"precision": 0
				}
		);
        getDataRekeningCarapembayar();
    });
</script>
