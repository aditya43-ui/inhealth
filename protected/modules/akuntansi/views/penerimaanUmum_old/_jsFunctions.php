<script type="text/javascript">

	var trUraian = new String(<?php echo CJSON::encode($this->renderPartial('_rowUraian', array('form' => $form, 'modUraian' => $modUraian, 'removeButton' => true), true)); ?>);
//var trUraian=new String(<?php //echo CJSON::encode($this->renderPartial('_rowUraian',array('form'=>$form,'modUraian'=>array(0=>$modUraian[0]),'removeButton'=>true),true)); ?>);
	$('.currency').each(function () {
		this.value = formatNumber(this.value)
	});

	function removeDataRekening(obj)
	{
		$(obj).parent().parent('tr').detach();
	}

	function getDataRekening(params)
	{
		$("#tblInputRekening > tbody").find('tr').detach();
		$.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/GetDataRekeningByJnsPenerimaan'); ?>', {jenispenerimaan_id: params},
		function (data) {
			if (data != null) {
				$("#tblInputRekening > tbody").append(data.replace());
				renameRowRekening();
			}
		}, "json");
	}

	function renameRowRekening()
	{
		var idx = 0;
		$("#tblInputRekening > tbody").find('tr').each(
				function ()
				{
					unMaskMoneyInput(this);
					maskMoneyInput(this);
					$(this).find('input').each(
							function ()
							{
								/*
								 if($(this).find('class^="currency"'))
								 {
								 this.value = formatNumber(this.value)
								 }
								 */

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

	function simpanPenerimaan(params)
	{
		jenis_simpan = params;
		var kosong = "";
		var dataKosong = $("#input-penerimaan-kas").find(".reqForm[value=" + kosong + "]");
		if (dataKosong.length > 0) {
			myAlert('Bagian dengan tanda * harus diisi ');
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

			$('.currency').each(
					function () {
						this.value = unformatNumber(this.value)
					}
			);

			$.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/SimpanPenerimaan'); ?>', {jenis_simpan: jenis_simpan, data: $('#akpenerimaan-umum-t-form').serialize()},
			function (data) {
				if (data.status == 'ok')
				{
					if (data.action == 'insert')
					{
						myAlert("Simpan data berhasil");
						$("#tblInputUraian").find('tr[class$="child"]').detach();
						$("#reseter").click();
						url = '<?php echo $this->createUrl("Print&id='+data.pesan.id+'"); ?>';
						$('#url').val(url);
						$("#input-penerimaan-kas").find("input[name$='[nopenerimaan]']").val(data.pesan.nopenerimaan);
						$("#tblInputRekening > tbody").find('tr').detach();
					} else {
						myAlert("Update data berhasil");
					}
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
		if ($('#AKPenerimaanUmumT_isuraintransaksi').is(':checked')) {
			$('#tblInputUraian').find('input[name$="[hargasatuan]"]').each(function () {
				harga = harga + unformatNumber(this.value);
			});
			$('#tblInputUraian').find('input[name$="[totalharga]"]').each(function () {
				totharga = totharga + unformatNumber(this.value);
			});

			//if(harga != unformatNumber($('#AKPenerimaanUmumT_hargasatuan').val())){
			//    myAlert('Harga tidak sesuai');return false;
			//}
			if (totharga != unformatNumber($('#AKPenerimaanUmumT_totalharga').val())) {
				myAlert('Harga Uraian tidak sesuai');
				return false;
			}
		}
		$('.currency').each(function () {
			this.value = unformatNumber(this.value)
		});

		return true;
	}

	function hitungTotalUraian(obj)
	{
		var volume = unformatNumber($(obj).parents('tr').find('input[name$="[volume]"]').val());
		var hargasatuan = unformatNumber($(obj).parents('tr').find('input[name$="[hargasatuan]"]').val());
		$(obj).parents('tr').find('input[name$="[totalharga]"]').val(formatNumber(volume * hargasatuan));
		totalTagihan();
	}

	function hitungTotalHarga()
	{
		var biayaAdministrasi = unformatNumber($('#AKTandabuktibayarT_biayaadministrasi').val());
		var biayaMaterai = unformatNumber($('#AKTandabuktibayarT_biayamaterai').val());
		var vol = unformatNumber($('#AKPenerimaanUmumT_volume').val());
		var harga = unformatNumber($('#AKPenerimaanUmumT_hargasatuan').val());

		$('#AKPenerimaanUmumT_totalharga').val(formatNumber(vol * harga));
		$('#AKTandabuktibayarT_jmlpembayaran').val(formatNumber((vol * harga) + biayaAdministrasi + biayaMaterai));
		$('#totTagihan').val($('#AKPenerimaanUmumT_totalharga').val());
		$('#RekeningakuntansiV_0_saldodebit').val(formatNumber((vol * harga) + biayaAdministrasi + biayaMaterai));
		$('#RekeningakuntansiV_1_saldokredit').val(formatNumber((vol * harga) + biayaAdministrasi + biayaMaterai));
	}

	function bukaUraian(obj)
	{
		if ($(obj).is(':checked')) {
			$('#div_tblInputUraian').slideDown();
		} else {
			$('#div_tblInputUraian').slideUp();
		}
	}

	function addRowUraian(obj)
	{
		$(obj).parents('table').children('tbody').append(trUraian.replace());

		renameInput('AKUraianpenumumT', 'uraiantransaksi');
		renameInput('AKUraianpenumumT', 'volume');
		renameInput('AKUraianpenumumT', 'satuanvol');
		renameInput('AKUraianpenumumT', 'hargasatuan');
		renameInput('AKUraianpenumumT', 'totalharga');
		jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
		maskMoneyInput($('#tblInputUraian > tbody > tr:last'));
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
		$("#AKTandabuktibayarT_jmlpembayaran").val(formatNumber(total));
	}

	function perhitunganUang()
	{
		var biayaadministrasi = unformatNumber($("#AKTandabuktibayarT_biayaadministrasi").val());
		var biayamaterai = unformatNumber($("#AKTandabuktibayarT_biayamaterai").val());
		var uangditerima = unformatNumber($("#AKTandabuktibayarT_uangditerima").val());
		$("#AKTandabuktibayarT_jmlpembayaran").val(biayaadministrasi + biayamaterai + uangditerima);
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

				renameInput('AKUraianpenumumT', 'uraiantransaksi');
				renameInput('AKUraianpenumumT', 'volume');
				renameInput('AKUraianpenumumT', 'satuanvol');
				renameInput('AKUraianpenumumT', 'hargasatuan');
				renameInput('AKUraianpenumumT', 'totalharga');
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
		if ($('#pakeKartu').is(':checked'))
			$('#divDenganKartu').show();
		else
			$('#divDenganKartu').hide();
		if ($('#AKTandabuktibayarT_dengankartu').val() != '') {
			//myAlert('isi');
			$('#AKTandabuktibayarT_bankkartu').removeAttr('readonly');
			$('#AKTandabuktibayarT_nokartu').removeAttr('readonly');
			$('#AKTandabuktibayarT_nostrukkartu').removeAttr('readonly');
		} else {
			//myAlert('kosong');
			$('#AKTandabuktibayarT_bankkartu').attr('readonly', 'readonly');
			$('#AKTandabuktibayarT_nokartu').attr('readonly', 'readonly');
			$('#AKTandabuktibayarT_nostrukkartu').attr('readonly', 'readonly');

			$('#AKTandabuktibayarT_bankkartu').val('');
			$('#AKTandabuktibayarT_nokartu').val('');
			$('#AKTandabuktibayarT_nostrukkartu').val('');
		}
	}

	function ubahCaraPembayaran(obj)
	{
		if (obj.value == 'CICILAN') {
			$('#AKTandabuktibayarT_jmlpembayaran').removeAttr('readonly');
		} else {
			$('#AKTandabuktibayarT_jmlpembayaran').attr('readonly', true);
			hitungJmlBayar();
		}

		if (obj.value == 'TUNAI') {
			hitungJmlBayar();
		}
	}

	function hitungJmlBayar()
	{
		var biayaAdministrasi = unformatNumber($('#AKTandabuktibayarT_biayaadministrasi').val());
		var biayaMaterai = unformatNumber($('#AKTandabuktibayarT_biayamaterai').val());
		var totTagihan = unformatNumber($('#totTagihan').val());
		var jmlPembulatan = unformatNumber($('#AKTandabuktibayarT_jmlpembulatan').val());
		totBayar = totTagihan + jmlPembulatan + biayaAdministrasi + biayaMaterai;
		$('#AKTandabuktibayarT_jmlpembayaran').val(formatNumber(totBayar));
		hitungKembalian();
	}

	function hitungKembalian()
	{
		var jmlBayar = unformatNumber($('#AKTandabuktibayarT_jmlpembayaran').val());
		var uangDiterima = unformatNumber($('#AKTandabuktibayarT_uangditerima').val());
		var uangKembalian = uangDiterima - jmlBayar;
		if (uangKembalian < 0)
		{
			uangKembalian = 0;
		}
		$('#AKTandabuktibayarT_uangkembalian').val(formatNumber(uangKembalian));

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
		$(tr).find('input.currency:text').unmaskMoney();
	}

	function maskMoneyInput(tr)
	{
		$(tr).find('input.currency:text').maskMoney(
				{
					"symbol": "Rp ",
					"defaultZero": true,
					"allowZero": true,
					"decimal": ".",
					"thousands": ",",
					"precision": 0
				}
		);
	}
</script>