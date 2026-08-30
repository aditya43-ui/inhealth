<script type="text/javascript">
	/**
	 * set form kunjungan
	 * @param {type} pasien_id
	 * @returns {undefined}
	 */
	function setKunjungan(pasienkirimkeunitlain_id) {
		$("#form-datakunjungan > div").addClass("animation-loading");
		$.ajax({
			type: 'POST',
			url: '<?php echo $this->createUrl('GetDataKunjungan'); ?>',
			data: {pasienkirimkeunitlain_id: pasienkirimkeunitlain_id},
			dataType: "json",
			success: function (data) {
				$("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'pasienkirimkeunitlain_id') ?>").val(data.pasienkirimkeunitlain_id);
				$("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'jeniskasuspenyakit_id') ?>").val(data.jeniskasuspenyakit_id);
				$("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'kelaspelayanan_id') ?>").val(data.kelaspelayanan_id);
				$("#pegawai_id").val(data.pegawai_id);
				$("#pendaftaran_id").val(data.pendaftaran_id);
				$("#pasien_id").val(data.pasien_id);
				$("#jeniskasuspenyakit_id").val(data.jeniskasuspenyakit_id);
				$("#carabayar_id").val(data.carabayar_id);
				$("#penjamin_id").val(data.penjamin_id);
				$("#penanggungjawab_id").val(data.penanggungjawab_id);
				$("#instalasiasal_id").val(data.instalasiasal_id);
				$("#ruanganasal_id").val(data.ruanganasal_id);
				$("#kelaspelayanan_id").val(data.kelaspelayanan_id);
				$("#no_pendaftaran").val(data.no_pendaftaran);
				$("#nama_pegawai").val(data.namalengkapdokter);
				$("#catatandokterpengirim").val(data.catatandokterpengirim);
				$("#tglmasukpenunjang").val(data.tglmasukpenunjang);
				$("#tgl_pendaftaran").val(data.tgl_pendaftaran);
				$("#instalasiasal_nama").val(data.instalasiasal_nama);
				$("#ruanganasal_nama").val(data.ruanganasal_nama);
				$("#jeniskasuspenyakit_nama").val(data.jeniskasuspenyakit_nama);
				$("#carabayar_nama").val(data.carabayar_nama);
				$("#penjamin_nama").val(data.penjamin_nama);
				$("#no_rekam_medik").val(data.no_rekam_medik);
				$("#namadepan").val(data.namadepan);
				$("#nama_pasien").val(data.nama_pasien);
				$("#nama_bin").val(data.nama_bin);
				$("#tanggal_lahir").val(data.tanggal_lahir);
				$("#umur").val(data.umur);
				$("#jeniskelamin").val(data.jeniskelamin);
				$("#nama_pj").val(data.nama_pj);
				$("#pengantar").val(data.pengantar);
				$("#kelaspelayanan_nama").val(data.kelaspelayanan_nama);
				$("#alamat_pasien").val(data.alamat_pasien);
				if (data.photopasien === null || data.photopasien === "") { //set photo
					$('#photo-preview').attr('src', '<?php echo Params::urlPhotoPasienDirectory() . "no_photo.jpeg" ?>');
				} else {
					$('#photo-preview').attr('src', '<?php echo Params::urlPasienTumbsDirectory() . "kecil_" ?>' + data.photopasien);
				}

				setPermintaanKePenunjang();
				setTimeout(function () {
					setCheckedPemeriksaanDariPermintaan();
				}, 3000);//auto check permintaan

				$("#form-datakunjungan > legend > .judul").html('Data Rujukan ' + data.no_pendaftaran);
				$("#form-datakunjungan > legend > .tombol").attr('style', 'display:true;');
				$("#form-datakunjungan > .box").addClass("well").removeClass("box");

				$("#form-datakunjungan > div").removeClass("animation-loading");
				$("#no_pendaftaran").focus();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				myAlert("Data rujukan tidak ditemukan!");
				console.log(errorThrown);
				setKunjunganReset();
				$("#form-datakunjungan > div").removeClass("animation-loading");
				$("#no_pendaftaran").focus();
			}
		});

	}
	/**
	 * untuk mereset form kunjungan
	 * @returns {undefined} */
	function setKunjunganReset() {
		$("#form-datakunjungan input,textarea").each(function () {
			$(this).val("");
		});
		$("#ruangan_id").val(<?php echo $modKunjungan->ruangan_id; ?>);
		$('#photo-preview').attr('src', '<?php echo Params::urlPhotoPasienDirectory() . "no_photo.jpeg" ?>');
		$("#form-datakunjungan > legend > .judul").html('Data Rujukan');
		$("#form-datakunjungan > legend > .tombol").attr('style', 'display:none;');
		$("#form-datakunjungan > .well").addClass("box").removeClass("well");

		$('#form-permintaankepenunjang table > tbody').html("");
		$('#form-tindakanpemeriksaan table > tbody').html("");
		$('#content-pemeriksaan-lab .checklists').html("");
		$('#content-pemeriksaan-lab input').each(function () {
			$(this).val("");
		});
	}

	/**
	 * update (refresh) checklist pemeriksaan lab
	 * harus include /js/jquery.tiler.js
	 * @param {obj} form_checklist
	 */
	function updateChecklistPemeriksaanLab() {
		$('#content-pemeriksaan-lab .checklists').addClass("animation-loading");
		$.ajax({
			type: 'POST',
			url: '<?php echo $this->createUrl('/bankDarah/pendaftaranBankDarah/SetChecklistPemeriksaanLab'); ?>',
			data: {data: $("#form-caripemeriksaan :input").serialize()},
			dataType: "json",
			success: function (data) {
				$('#content-pemeriksaan-lab .checklists').html(data.content);
				$('.checkboxlist-tile').tile({widths: [190]});
				$('#content-pemeriksaan-lab .checklists').removeClass("animation-loading");
				setCheckedPemeriksaan($("#form-tindakanpemeriksaan"));
				setCheckedPemeriksaanDariPermintaan();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}

	/**
	 * Set checklist pemeriksaan lab
	 */
	function setChecklistPemeriksaanLab() {
		var penjamin_id = $("#penjamin_id").val();
		var ruangan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'ruangan_id') ?>").val();
		var kelaspelayanan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'kelaspelayanan_id') ?>").val();
		if (penjamin_id == "" && kelaspelayanan_id == "") {
			myAlert("Silakan pilih data rujukan!");
			setChecklistPemeriksaanLabReset();
		} else {
			$("#form-caripemeriksaan").find("input[name$='[ruangan_id]']").val(ruangan_id);
			$("#form-caripemeriksaan").find("input[name$='[penjamin_id]']").val(penjamin_id);
			$("#form-caripemeriksaan").find("input[name$='[kelaspelayanan_id]']").val(kelaspelayanan_id);
			updateChecklistPemeriksaanLab();
		}
	}

	/**
	 * hitung tarif tindakan RND-4168
	 */
	function hitungTotal(obj)
	{
//		unformatNumberSemua();
//		var qty = $(obj).val();
//		var harga = parseFloat($(obj).parents('tr').find('input[name$="[tarif_satuan]"]').val());
//		var subTotal = 0;
//
//		subTotal = parseFloat(harga * qty);
//		if ($.isNumeric(subTotal)) {
//			$(obj).parents('tr').find('input[name$="[tarif_tindakan]"]').val(subTotal);
//		}
//
//		formatNumberSemua();
		unformatNumberSemua();
		var qty = $(obj).val();
		var harga = parseFloat($(obj).parents('tr').find('input[name$="[tarif_satuan]"]').val());
		var cyto = parseFloat($(obj).parents('tr').find('input[name$="[tarif_cyto]"]').val());

		var subTotal=0;

		subTotal = parseFloat((harga+cyto)*qty);
		if ($.isNumeric(subTotal)){
			$(obj).parents('tr').find('input[name$="[tarif_tindakan]"]').val(subTotal);
		}

		formatNumberSemua();
	}

	/**
	 * reset pencarian & checklist pemeriksaan lab
	 */
	function setChecklistPemeriksaanLabReset() {
		$("#form-caripemeriksaan").find("input:not(:disabled):not([readonly])").each(function () {
			$(this).val("");
		});
		updateChecklistPemeriksaanLab();
	}
	/**
	 * Centang pemeriksaan lab dari checkboxlist
	 */
	function pilihPemeriksaanIni(obj) {
		var pemeriksaanlab_id = $(obj).val();
		var pemeriksaanlab_nama = $(obj).parent().find('input[name$="[pemeriksaanlab_nama]"]').val();
		var daftartindakan_id = $(obj).parent().find('input[name$="[daftartindakan_id]"]').val();
		var jenistarif_id = $(obj).parent().find('input[name$="[jenistarif_id]"]').val();
		var harga_tariftindakan = $(obj).parent().find('input[name$="[harga_tariftindakan]"]').val();
		var pendaftaran_id = $("#pendaftaran_id").val();
		var persencyto_tind = $(obj).parent().find('input[name$="[persencyto_tind]"]').val();
		var rowtindakan = [];
		rowtindakan = '<?php echo CJSON::encode($this->renderPartial($this->path_view_pendaftaran . '_rowTindakanPemeriksaan', array('i' => 0, 'modTindakan' => $modTindakan), true)); ?>';
		if ($(obj).is(':checked')) {
			$("#form-tindakanpemeriksaan").find('tbody').append(rowtindakan);
			$("#form-tindakanpemeriksaan").find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
			$("#form-tindakanpemeriksaan").find('input[name$="[ii][pemeriksaanlab_id]"]').val(pemeriksaanlab_id);
			$("#form-tindakanpemeriksaan").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
			$("#form-tindakanpemeriksaan").find('input[name$="[ii][jenistarif_id]"]').val(jenistarif_id);
			$("#form-tindakanpemeriksaan").find('span[name$="[ii][pemeriksaanlab_nama]"]').html(pemeriksaanlab_nama);
			$("#form-tindakanpemeriksaan").find('input[name$="[ii][satuantindakan]"]').val("<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
			$("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_satuan]"]').val(harga_tariftindakan);
			$("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_tindakan]"]').val(formatInteger(harga_tariftindakan));
			$("#form-tindakanpemeriksaan").find('input[name$="[ii][persencyto_tind]"]').val(formatInteger(persencyto_tind));
			is_cyto = $("#form-tindakanpemeriksaan").find('input[name$="[ii][cyto_tindakan]"]').val();
			if(is_cyto==1){
				$("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_cyto]"]').val(formatInteger(harga_tariftindakan+(harga_tariftindakan*(persencyto_tind/100))));
			}
//			$("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_cyto]"]').val(formatInteger(0));
			$("#form-tindakanpemeriksaan").find('a').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});

			inputBMHP(daftartindakan_id, pendaftaran_id);
		} else {
			var delete_row = $("#form-tindakanpemeriksaan").find('input[name$="[pemeriksaanlab_id]"][value="' + pemeriksaanlab_id + '"]').parents('tr');
			if (delete_row.find('input[name$="[tindakanpelayanan_id]"][value=""]').length > 0) {
				delete_row.detach();
			} else {
				myAlert("Pemeriksaan tidak bisa dibatalkan karena sudah ditagihkan / dibayarkan ke pasien!");
				$(obj).attr("checked", true);
			}
			
			batalOaPasienChecklist(daftartindakan_id);
		}
		renameInputRow($("#form-tindakanpemeriksaan"));
	}
	/**
	 * rename input row yang terakhir di tambahkan
	 * @param {type} obj_table
	 */
	function renameInputRow(obj_table) {
		var row = 0;
		$(obj_table).find("tbody > tr").each(function () {
			$(this).find("#no_urut").val(row + 1);
			$(this).find('span').each(function () { //element <span>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
				}
			});
			$(this).find('input,select,textarea').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 4) {
					$(this).attr("id", old_name_arr[0] + "_" + old_name_arr[1] + "_" + row + "_" + old_name_arr[3]);
					$(this).attr("name", old_name_arr[0] + "[" + old_name_arr[1] + "][" + row + "][" + old_name_arr[3] + "]");
				}
			});
			row++;
		});

	}
	/**
	 * set checked pemeriksaan yang sudah ada di daftar
	 */
	function setCheckedPemeriksaan(obj_table) {
		$("div.checklists").find('input[name$="[is_pilih]"]').removeAttr('checked');
		$(obj_table).find('input[name$="[pemeriksaanlab_id]"]').each(function () {
			var pemeriksaanlab_id = $(this).val();
			$("div.checklists").find('input[name$="[is_pilih]"][value=' + pemeriksaanlab_id + ']').attr('checked', true);
		});

	}
	/**
	 * set otomatis pilih pemeriksaan dari tabel permintaan ke penunjang 
	 */
	function setCheckedPemeriksaanDariPermintaan() {
		$('#form-tindakanpemeriksaan table > tbody').html("");
		setCheckedPemeriksaan($("#form-tindakanpemeriksaan"));
		$("#form-permintaankepenunjang").find('input[name$="[pemeriksaanlab_id]"]').each(function () {
			var pemeriksaanlab_id = $(this).val();
			var checkbox_pemeriksaan = $("div.checklists").find('input[name$="[is_pilih]"][value=' + pemeriksaanlab_id + ']');
			if (checkbox_pemeriksaan.val()) {
				checkbox_pemeriksaan.attr('checked', true);
				pilihPemeriksaanIni(checkbox_pemeriksaan);
				//memindahkan tindakanpelayanan_id RND-6827
				var tindakanpelayanan_id = $(this).parents('tr').find('input[name$="[tindakanpelayanan_id]"]').val();
				var rowpermintaan = $("#form-tindakanpemeriksaan").find('input[name$="[pemeriksaanlab_id]"][value=' + pemeriksaanlab_id + ']');
				if (tindakanpelayanan_id > 0) {
					rowpermintaan.parents('tr').find('input[name$="[tindakanpelayanan_id]"]').val(tindakanpelayanan_id);
                    /*Start - RND-14232*/
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo $this->createUrl('AmbilTindakanPelayanan'); ?>',
                        data: {tindakanpelayanan_id: tindakanpelayanan_id},
                        dataType: "json",
                        success: function (data) {
                            var tarif_satuan = unformatNumber(rowpermintaan.parents('tr').find('input[name$="[tarif_satuan]"]').val());
                            rowpermintaan.parents('tr').find('input[name$="[qty_tindakan]"]').val(data.qty_tindakan);
                            rowpermintaan.parents('tr').find('input[name$="[tarif_tindakan]"]').val(formatNumber(data.qty_tindakan*tarif_satuan));
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                    /*End*/
					
					checkbox_pemeriksaan.attr('disabled', true);
				}
			}
			//end memindahkan tindakanpelayanan_id
		});
	}
	/**
	 * bersihkan tabel tindakan pemeriksaan jika ada perubahan kelaspelayanan, ruangan 
	 **/
	function setTindakanPemeriksaanReset() {
		$("#form-tindakanpemeriksaan tbody").html("");
		setTimeout(function () {
			setCheckedPemeriksaanDariPermintaan();
		}, 3000);//auto check permintaan
	}
	/**
	 * load permintaan ke penunjang:
	 * - pasienkirimkeunitlain_id
	 */
	function setPermintaanKePenunjang() {
		$('#form-permintaankepenunjang').addClass("animation-loading");
		var penjamin_id = $("#penjamin_id").val();
		var pasienkirimkeunitlain_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'pasienkirimkeunitlain_id') ?>").val();
		$.ajax({
			type: 'POST',
			url: '<?php echo $this->createUrl('SetPermintaanKePenunjang'); ?>',
			data: {penjamin_id: penjamin_id, pasienkirimkeunitlain_id: pasienkirimkeunitlain_id},
			dataType: "json",
			success: function (data) {
				$('#form-permintaankepenunjang table > tbody').html(data.rows);
				$('#form-permintaankepenunjang').removeClass("animation-loading");
				renameInputRow($("#form-permintaankepenunjang"));
				setChecklistPemeriksaanLab();

			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}
	/**
	 * load pemeriksaan yang sudah tersimpan berdasarkan:
	 * - pasienmasukpenunjang_id
	 */
	function setTindakanPelayanan() {
		$('#form-tindakanpemeriksaan').addClass("animation-loading");
		$.ajax({
			type: 'POST',
			url: '<?php echo $this->createUrl('SetTindakanPelayanan'); ?>',
			data: {pasienmasukpenunjang_id: $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'pasienmasukpenunjang_id') ?>").val()},
			dataType: "json",
			success: function (data) {
				$('#form-tindakanpemeriksaan table > tbody').html(data.rows);
				$('#form-tindakanpemeriksaan').removeClass("animation-loading");
				renameInputRow($("#form-tindakanpemeriksaan"));
				setChecklistPemeriksaanLab();

			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}

	/**
	 * menambahkan form obatalkespasien ke tabel
	 * copy dari: bankDarah.views.pemakaianBmhp
	 * @type Arguments
	 */
	function tambahObatAlkesPasien(obj)
	{
		unformatNumberSemua();
		var pasienmasukpenunjang_id = $('#pasienmasukpenunjang_id').val();
		var penjamin_id = $("#penjamin_id").val();
		var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
		var satuankecil_id = $(obj).parents('fieldset').find('#satuankecil_id').val();
		var obatalkes_kode = $(obj).parents('fieldset').find('#obatalkes_kode').val();
		var obatalkes_nama = $(obj).parents('fieldset').find('#obatalkes_nama').val();
//		var jumlah = $(obj).parents('fieldset').find('#qty_input').val(); //RND-11723
		var jumlah = $(obj).parents('fieldset').find('#jmlkonversi').val();

		if ((obatalkes_id != '') && (pasienmasukpenunjang_id != '') && (jumlah > 0)) {
			$.ajax({
				type: 'POST',
				url: '<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
				data: {obatalkes_id: obatalkes_id, jumlah: jumlah, penjamin_id: penjamin_id, satuankecil_id: satuankecil_id}, //
				dataType: "json",
				success: function (data) {
					if (data.pesan !== "") {
						myAlert(data.pesan);
						var params = [];
						params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi: 'Stok Obat Alkes Habis', isinotifikasi: obatalkes_kode + ' ' + obatalkes_nama + '  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16 
						simpanNotifikasi(params);
						return false;
					}
					var tambahkandetail = true;
					var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']");
					if (obatalkesyangsama.val()) { //jika ada obat sudah ada di table
						myConfirm('Apakah Anda akan input ulang obat ini?', 'Perhatian!', function (r)
						{
							if (r) {
								$("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']").each(function () {
									$(this).parents('tr').detach();
								});
							}
							else {
								tambahkandetail = false;
							}
						});
					}
					if (tambahkandetail) {
						$('#table-obatalkespasien > tbody').append(data.form);
						$("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
								{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
						);
						renameInputRowObatAlkes($("#table-obatalkespasien"));
					}
					$(obj).parents('fieldset').find('#obatalkes_id').val('');
					$('#obatalkes_nama').val('');
					$('#qty_input').val(1);
					formatNumberSemua();
					renameInputRowObatAlkes($("#table-obatalkespasien"));
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});
		} else {
			if (pasienmasukpenunjang_id == '') {
				myAlert("Silakan isi data kunjungan terlebih dahulu!");
			} else if (obatalkes_id == '') {
				myAlert("Silakan pilih obat alkes terlebih dahulu!");
			} else if (jumlah == 0) {
				myAlert("Stok obat kosong!");
			}
		}
		setObatAlkesPasienReset();
	}

//function tambahObatAlkesPasien(){
//    unformatNumberSemua();
//    var pasienmasukpenunjang_id = $('#pasienmasukpenunjang_id').val();
//    var obatalkes_id = $('#obatalkes_id').val();
//    var obatalkes_nama = $('#obatalkes_nama').val();
//    var satuankecil_id = $('#satuankecil_id').val();
//    var satuankecil_nama = $('#satuankecil_nama').val();
//    var sumberdana_id = $('#sumberdana_id').val();
//    var qty = parseInt($('#qty_input').val());
//    var qty_stok = parseInt($('#qty_stok').val());
//    var hargajual = parseInt($('#hargajual').val());
//    var harganetto = parseInt($('#harganetto').val());
//
//    var rowtindakan = "";
//    rowtindakan = '<?php echo CJSON::encode($this->renderPartial('_rowObatAlkesPasien', array('modObatAlkesPasien' => $modObatAlkesPasien), true)); ?>';
//    if((obatalkes_id!='') && (pasienmasukpenunjang_id!='') && (qty_stok > 0) && (qty <= qty_stok)){
//        $("#table-obatalkespasien").find('tbody').append(rowtindakan);
//        $("#table-obatalkespasien").find('input[name$="[ii][obatalkes_id]"]').val(obatalkes_id);
//        $("#table-obatalkespasien").find('span[name$="[ii][obatalkes_nama]"]').html(obatalkes_nama);
//        $("#table-obatalkespasien").find('span[name$="[ii][satuankecil_nama]"]').html(satuankecil_nama);
//        $("#table-obatalkespasien").find('input[name$="[ii][qty_stok]"]').val(qty_stok);
//        $("#table-obatalkespasien").find('input[name$="[ii][qty_oa]"]').val(qty);
//        $("#table-obatalkespasien").find('input[name$="[ii][hargajual_oa]"]').val(hargajual);
//        $("#table-obatalkespasien").find('input[name$="[ii][harganetto_oa]"]').val(harganetto);
//        $("#table-obatalkespasien").find('input[name$="[ii][sumberdana_id]"]').val(sumberdana_id);
//        $("#table-obatalkespasien").find('input[name$="[ii][satuankecil_id]"]').val(satuankecil_id);
//        $("#table-obatalkespasien").find('input[name$="[ii][iurbiaya]"]').val(qty*hargajual);
//        $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
//            {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
//        );
//        $('#table-obatalkespasien').find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
//        renameInputRowObatAlkes($("#table-obatalkespasien"));
//        formatNumberSemua();
//    }else{
//        if(pasienmasukpenunjang_id == ''){
//            myAlert("Silakan isi data kunjungan terlebih dahulu!");
//        }else if(obatalkes_id == ''){
//            myAlert("Silakan pilih obat alkes terlebih dahulu!");
//        }else if(qty_stok == 0){
//            myAlert("Stok obat kosong!");
//        }else if(qty > qty_stok){
//            myAlert("Jumlah tidak boleh lebih besar dari stok tersedia "+qty_stok+".");
//        }
//    }
//    setObatAlkesPasienReset();
//}

	/**
	 * reset form obat
	 * copy dari: bankDarah.views.pemakaianBmhp
	 */
	function setObatAlkesPasienReset() {
		$('#form-tambahobatalkes :input').val("");
		$('#qty_input').val("1");
		$('#obatalkes_nama').focus();
	}
	/**
	 * load obatalkespasien_t yang sudah tersimpan berdasarkan:
	 * - pasienmasukpenunjang_id
	 * copy dari: bankDarah.views.pemakaianBmhp
	 */
	function setRiwayatObatAlkesPasien() {
		$('#riwayat-obatalkespasien-t').addClass("animation-loading");
		$.ajax({
			type: 'POST',
			url: '<?php echo $this->createUrl('/bankDarah/PemakaianBahan/setRiwayatObatAlkesPasien'); ?>',
			data: {pasienmasukpenunjang_id: $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'pasienmasukpenunjang_id') ?>").val()},
			dataType: "json",
			success: function (data) {
				$('#riwayat-obatalkespasien-t table > tbody').html(data.rows);
				$('#riwayat-obatalkespasien-t table > tbody').find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				$('#riwayat-obatalkespasien-t').removeClass("animation-loading");
				renameInputRowObatAlkes($("#riwayat-obatalkespasien-t"));
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}
	/**
	 * rename input grid
	 * copy dari: bankDarah.views.pemakaianBmhp
	 */
	function renameInputRowObatAlkes(obj_table) {
		var row = 0;
		$(obj_table).find("tbody > tr").each(function () {
			$(this).find("#no_urut").val(row + 1);
			$(this).find('span').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
				}
			});
			$(this).find('input,select,textarea').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
			});
			row++;
		});
	}
	/**
	 * membatalkan form input obat alkes pasien 
	 * copy dari: bankDarah.views.pemakaianBmhp
	 */
	function batalOaPasien(obj)
	{
		myConfirm('Apakah Anda akan membatalkan obat / alat kesehatan ini?', 'Perhatian!', function (r)
		{
			if (r) {
				$(obj).parents('tr').remove();
				renameInputRowObatAlkes($("#table-obatalkespasien"));
			}
		});
	}

	function batalOaPasienChecklist(daftartindakan_id)
	{

				$('#table-obatalkespasien').find("tbody > tr").each(function () {
					$(this).find('input[name$="[daftartindakan_id]"]').each(function () { //element <input>
						if ( $(this).val() == daftartindakan_id ){
							$(this).parents('tr').remove();
							renameInputRowObatAlkes($("#table-obatalkespasien"));
						} 
					});
				});

	}
	/**
	 * menghapus obat alkes pasien yang sudah tersimpan di ObatalkespasienT
	 * berdasarkan obatalkespasien_id
	 * copy dari: bankDarah.views.pemakaianBmhp
	 */
	function hapusOaPasien(obatalkespasien_id)
	{
		myConfirm('Apakah Anda akan menghapus obat / alat kesehatan ini?', 'Perhatian!', function (r)
		{
			if (r) {
				$.ajax({
					type: 'POST',
					url: '<?php echo $this->createUrl('/bankDarah/PemakaianBmhp/hapusObatAlkesPasien'); ?>',
					data: {obatalkespasien_id: obatalkespasien_id},
					dataType: "json",
					success: function (data) {
						if (data.sukses) {
							var delete_row = $("#riwayat-obatalkespasien-t").find('input[name$="[obatalkespasien_id]"][value="' + obatalkespasien_id + '"]').parents('tr');
							delete_row.detach();
							renameInputRowObatAlkes($("#riwayat-obatalkespasien-t"));
						}
						myAlert(data.pesan);
					},
					error: function (jqXHR, textStatus, errorThrown) {
						console.log(errorThrown);
					}
				});
				renameInputRowObatAlkes($("#riwayat-obatalkespasien-t"));
			}
		});
	}
	/**
	 * menghitung subtotal obat alkes per baris
	 * copy dari: bankDarah.views.pemakaianBmhp
	 */
	function hitungSubTotal(obj)
	{
		unformatNumberSemua();
		var subtotal = 0;
		var qty = parseInt($(obj).val());
		var qty_stok = parseInt($(obj).parents('tr').find('input[name$="[qty_stok]"]').val());
		var hargajual_oa = parseInt($(obj).parents('tr').find('input[name$="[hargajual_oa]"]').val());
		subtotal = qty * hargajual_oa;
		$(obj).parents('tr').find('input[name$="[iurbiaya]"]').val(formatInteger(subtotal));
		if (qty > qty_stok) {
			$(obj).val(qty_stok);
			myAlert("Jumlah tidak boleh lebih besar dari stok!");
		}
		formatNumberSemua();
	}

	/**
	 * print pemakaian bahan
	 * copy dari: bankDarah.views.pemakaianBmhp
	 */
	function printPemakaianOa(pasienmasukpenunjang_id)
	{
		window.open('<?php echo $this->createUrl('/bankDarah/PemakaianBahan/print'); ?>&pasienmasukpenunjang_id=' + pasienmasukpenunjang_id, 'printwin', 'left=100,top=100,width=480,height=640');
	}

	/**
	 * print status 
	 */
	function printStatus()
	{
		var pendaftaran_id = $("#pendaftaran_id").val();
		if (pendaftaran_id != "") {
			window.open('<?php echo $this->createUrl('pendaftaranBankDarah/printStatusLab'); ?>&pendaftaran_id=' + pendaftaran_id, 'printwin', 'left=100,top=100,width=480,height=640');
		} else {
			myAlert("Silakan pilih data rujukan pasien!");
		}
	}

	function inputBMHP(daftartindakan_id, pendaftaran_id)
	{

		var ketemu = false;
		var pendaftaran_id = pendaftaran_id;
//		$('#tblInputTindakan').find('input[name$="[daftartindakan_id]"]').each(function () {
//     DISABLE SEMENTARA KARENA ADA BMHP YG TDK BERDASARKAN TINDAKAN >> if($(this).val() == daftartindakan_id){
		ketemu = true;
		jQuery.ajax({'url': '<?php echo $this->createUrl(Yii::app()->controller->id . '/addFormPaketBmhp') ?>',
			'data': {daftartindakan_id: daftartindakan_id, pendaftaran_id: pendaftaran_id},
			'type': 'post',
			'dataType': 'json',
			'success': function (data) {
				if (data.pesan !== "") {
					myAlert(data.pesan);
					return false;
				}
				$('#table-obatalkespasien > tbody').append(data.form);
				$("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
						{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
				);
//				renameInputRowPemakaianBahan($("#table-paketbmhp"));

				$('#obatalkes_id').val('');
				$('#paketBMHP').val('');
				formatNumberSemua();
				renameInputRowPaketBmhp($("#table-obatalkespasien"));
				hitungTotalBMHP();
			},
			'cache': false});
//        } 
//		});
		if (!ketemu) {
			myAlert('Tidak ada tindakan yang dimaksud.');
		}
	}

	function hitungTotalBMHP()
	{
		var total = 0;
		$('#table-obatalkespasien').find('input[name$="[hargapemakaian]"]').each(function () {
			total = total + unformatNumber(this.value);
		});
		$('#totHargaBmhp').val(formatNumber(total));
	}

	/**
	 * rename input grid
	 */
	function renameInputRowPaketBmhp(obj_table) {
		var row = 0;
		$(obj_table).find("tbody > tr").each(function () {
			$(this).find("#no_urut").val(row + 1);
			$(this).find('span').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
				}
			});
			$(this).find('input,select,textarea').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
			});
			row++;
		});
	}

	function hapusBMHP(obj) {
		myConfirm("Apakan Anda ingin menghapus ini?", "Perhatian!", function (r) {
			if (r) {
				$(obj).parent().parent().remove();
				renameInputRowPaketBmhp();
				hitungTotalBMHP();
			}
		});
		return false;
	}
	
	
	// untuk menjumlahkan konversi dari qty input / jmlkemasan terkecil
	function totalKonversi(){
		unformatNumberSemua();
		var qty_input = parseFloat($('#qty_input').val());
		var jmlkemasan = parseFloat($('#jmlkemasan').val());
		var jmlkonversi = parseFloat($('#jmlkonversi').val());

		var jml = qty_input / jmlkemasan;
		if(!jQuery.isNumeric(jml)){
			jml = 0;
		}
		$('#jmlkonversi').val(jml);
	}

	function totalJumlah(){
		unformatNumberSemua();
		var qty_input = parseFloat($('#qty_input').val());
		var jmlkemasan = parseFloat($('#jmlkemasan').val());
		var jmlkonversi = parseFloat($('#jmlkonversi').val());

		var jumlah = jmlkonversi * jmlkemasan;
		if(!jQuery.isNumeric(jumlah)){
			jumlah = 0;
		}
		$('#qty_input').val(jumlah);
	}

	function setSatuanObat(obatalkes_id){
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('setSatuanObat'); ?>',
			data: {obatalkes_id:obatalkes_id},
			dataType: "json",
			success:function(data){
				if(data.pesan != ""){
					myAlert(data.pesan);
				}else{
					$('#satuankecil_nama').html(data.satuankecil);
					$('#satuanterkecil_nama').html(data.satuanterkecil);
				}
			},
			error: function (jqXHR, textStatus, errorThrown) { 
				myAlert("Data Obat tidak ditemukan!"); 
				console.log(errorThrown);
			}
		});
	}
	
	function hitungTarifCyto(obj)
	{
		var tarifTindakan = unformatNumber($(obj).parents('tr').find('input[name*="[tarif_satuan]"]').val());
		var persen = unformatNumber($(obj).parents('tr').find('input[name*="[persencyto_tind]"]').val()); 
		var tarifCyto = 0;
		var cyto = obj.value;
		if (cyto == 1)
		{
			tarifCyto = tarifTindakan * (persen/100);
			$(obj).parents('tr').find('input[name*="[tarif_cyto]"]').val(formatNumber(tarifCyto));
		}else{
			$(obj).parents('tr').find('input[name*="[tarif_cyto]"]').val(0);
		}

		var qty = $(obj).parents('tr').find('input[name$="[qty_tindakan]"]');

		hitungTotal(qty);
	}	

	/**
	 * javascript yang di running setelah halaman ready / load sempurna
	 * posisi script ini harus tetap dibawah
	 */
	$(document).ready(function () {
<?php if (!$modPasienMasukPenunjang->isNewRecord) { ?>
			setTindakanPelayanan();
			setRiwayatObatAlkesPasien();
			$("input, select, textarea").attr("readonly", true);
<?php } ?>
<?php if (isset($_GET['pasienkirimkeunitlain_id'])) { ?>
			setPermintaanKePenunjang();
			setTimeout(function () {
				setCheckedPemeriksaanDariPermintaan();
			}, 3000);//auto check permintaan
			$("#form-datakunjungan :input").attr("readonly", true);
			$("#form-datakunjungan .add-on").remove();
<?php } ?>
<?php if (isset($_GET['pendaftaran_id'])) { ?>
			setChecklistPemeriksaanLab();
			$("#form-datakunjungan :input").attr("readonly", true);
			$("#form-datakunjungan .add-on").remove();
<?php } ?>

		// Notifikasi Pasien
<?php
if (Yii::app()->user->getState('issmsgateway')) {
	if (isset($_GET['smspasien'])) {
		if ($_GET['smspasien'] == 0) {
			?>
					var params = [];
					params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi: 'GAGAL KIRIM SMS PASIEN', isinotifikasi: 'Pasien <?php echo $modPasienMasukPenunjang->pasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
					simpanNotifikasi(params);
			<?php
		}
	}
}
?>
	});
</script>