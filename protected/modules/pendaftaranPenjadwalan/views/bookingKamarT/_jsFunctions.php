<?php
$cekKartuPasien=Yii::app()->user->getState('printkartulsng');?>
<script type="text/javascript">
	var statusKartuPasien = '<?php echo !empty($cekKartuPasien) ? $cekKartuPasien  : true; ?>';
	function enableInputNoPend(obj)
    {
        if(!obj.checked){
            $('#inputNoPendaftaran input').attr('disabled','true');
            $('#inputNoPendaftaran button').attr('disabled','true');
        }
        else {
            $('#inputNoPendaftaran input').removeAttr('disabled');
            $('#inputNoPendaftaran button').removeAttr('disabled');
            getRuanganberdasarkanRM(obj);
        }
    }
    
    function cekInputan(obj){
        if(requiredCheck($("form"))){
            $.ajax({
               type:'POST',
               url:'<?php echo $this->createUrl('verifikasi'); ?>',
               data: $("form").serialize(),
               dataType: "json",
               success:function(data){
                   if(data.status == true){
                        $(obj).attr('disabled',true);
                        $(obj).removeAttr('onclick');
                        $('#ppbooking-kamar-t-form').submit();
                    }
               },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); }
            });
            //untuk verifikasi hilangkan srbac loading
            $(".animation-loading").removeClass("animation-loading");
            $(".form-actions").find(".btn").removeAttr("disabled");
        }
        return false;
    }
	
	function pilihNoRm(){
		if($('#isPasienLama').is(':checked')){
			$('#no_rekam_medik').removeAttr('readonly', 'true');
			$('#tombolPasienDialog').removeClass('hide');
		}else{
			$('#no_rekam_medik').attr('readonly','true'); 
			$('#tombolPasienDialog').addClass('hide');
		}
	}
	
	function getStatus(obj){    
		idKamarruangan = (obj.value);
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('getStatusKamar'); ?>',
			data: {idKamarruangan : idKamarruangan},
			dataType: "json",
			success:function(data){
				$('div.divForForm').html(data.status);
				if(data.kamar=="IN USE"){
					$('#PPBookingKamarT_statusbooking').val("ANTRI");
					$('#PPBookingKamarT_statusbooking_dropdown').val("ANTRI");
				}else{
					$('#PPBookingKamarT_statusbooking').val("NON ANTRI");
					$('#PPBookingKamarT_statusbooking_dropdown').val("NON ANTRI");
				}
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}

	function getRuanganberdasarkanRM(no_rekam_medik)
	{
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('RuanganberdasarkanRM'); ?>',
			data: {no_rekam_medik : no_rekam_medik},
			dataType: "json",
			success:function(data){
				if(data.cek!=null)
				{
					$('#<?php echo CHtml::activeId($model,'pasien_id'); ?>').val(data.pasien_id);
				}
				$('#<?php echo CHtml::activeId($model,'pendaftaran_id'); ?>').val(data.pendaftaran_id);
				$('#dataPesan').html();
				$('#ruangan').val(data.ruangan_nopendaftaran);

				$('#<?php echo CHtml::activeId($model,'ruangan_id'); ?>').val(data.ruangan_id); 
				$('#<?php echo CHtml::activeId($model,'pasienadmisi_id'); ?>').val(data.pasienadmisi_id);    
				$('#dataPesan').html(data.data_pesan);
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}
	
	function print(bookingkamar_id)
	{
		if (bookingkamar_id=='') {
			myAlert("Kosong");
		}
		if(statusKartuPasien == 1){ //JIka di Konfig Systen diset TRUE untuk Print kunjungan
			 window.open('<?php echo $this->createUrl('lembarBookingKamar',array('bookingkamar_id'=>'')); ?>'+bookingkamar_id,'printwin','left=100,top=100,width=400,height=400');
		}             
	}
	
	function setNamaGelar()
	{
	//    ERROR LOGIC SEMENTARA MANUAL
	//    var statusperkawinan = $('#PPPasienM_statusperkawinan').val();
	//    var namadepan = $('#PPPasienM_namadepan');
	//    var umur = $("#<?php echo CHtml::activeId($model,'umur');?>").val().substr(0,2);
	//    umur = parseInt(umur);
	//    if(umur <= 5){
	//        var namadepan = $('#PPPasienM_nam	adepan').val('BY. Ny.');
	//        if(statusperkawinan.length > 0){
	//            $('#PPPasienM_statusperkawinan').val('');
	//            myAlert('Maaf status perkawinan belum cukup usia');
	//        }
	//    }else if(umur <= 15){
	//        var namadepan = $('#PPPasienM_namadepan').val('An.');
	//        if(statusperkawinan.length > 0){
	//            $('#PPPasienM_statusperkawinan').val('');
	//            myAlert('Maaf status perkawinan belum cukup usia');
	//        }
	//    }else{
	//        if($('#PPPasienM_jeniskelamin_0').is(':checked')){
	//            if(statusperkawinan !== 'JANDA'){
	//                var namadepan = $('#PPPasienM_namadepan').val('Tn.');
	//            }else{
	//                myAlert('Silakan pilih status pernikahan yang sesuai!');
	//                $('#PPPasienM_statusperkawinan').val('KAWIN');
	//                var namadepan = $('#PPPasienM_namadepan').val('Tn.');
	//            }
	//        }
	//        
	//        if($('#PPPasienM_jeniskelamin_1').is(':checked')){
	//            if(statusperkawinan !== 'DUDA'){
	//                if(statusperkawinan === 'KAWIN' || statusperkawinan == 'JANDA' || statusperkawinan == 'NIKAH SIRIH' || statusperkawinan == 'POLIGAMI'){
	//                    var namadepan = $('#PPPasienM_namadepan').val('Ny.');
	//                }else{
	//                    var namadepan = $('#PPPasienM_namadepan').val('Nn');
	//                }                
	//            }else{
	//                myAlert('Silakan pilih status pernikahan yang sesuai!');
	//                $('#PPPasienM_statusperkawinan').val('KAWIN');
	//                var namadepan = $('#PPPasienM_namadepan').val('Ny.');
	//            }
	//        }        
	//    }

	}

	function cekJenisKelamin(obj)
	{
		var is_true = true;
		var namadepan = $('#PPPasienM_namadepan').val();
		if(namadepan.length != 0)
		{
			if(obj.value == 'PEREMPUAN')
			{
				if(namadepan != 'Nn.' && namadepan != 'Ny.' && namadepan != 'BY. Ny.')
				{
					myAlert('Silakan pilih Jenis kelamin yang sesuai!');
					$('#PPPasienM_jeniskelamin_0').attr('checked',true);
					is_true = false;
				}
			}else{
				if(namadepan != 'Tn.' && namadepan != 'An.' && namadepan != 'BY. Ny.')
				{
					myAlert('Silakan pilih Jenis kelamin yang sesuai!');
					$('#PPPasienM_jeniskelamin_1').attr('checked',true);
					is_true = false;
				}
			}
		}else{
			$(obj).attr('checked',false);
			myAlert('Silakan pilih gelar kehormatan terlebih dahulu!');
		}
	}

	function setValueStatus(obj)
	{
		var gelar = obj.value;
		if(gelar === 'Tn.')
		{
			$('#PPPasienM_jeniskelamin_0').attr('checked',true);
			$('#PPPasienM_statusperkawinan').val('KAWIN');

		}else if(gelar === 'An.'){
			$('#PPPasienM_jeniskelamin_0').attr('checked',true);
			$('#PPPasienM_statusperkawinan').val('BELUM KAWIN');
		}else{
			if(gelar === 'Nn' || gelar === 'BY. Ny.')
			{
				$('#PPPasienM_statusperkawinan').val('BELUM KAWIN');
			}else{
				$('#PPPasienM_statusperkawinan').val('KAWIN');
			}
			$('#PPPasienM_jeniskelamin_1').attr('checked',true);
		}
	}

	function setStatusPerkawinan(obj)
	{
		var status = obj.value;
		var namaDepan = $('#PPPasienM_namadepan').val();

		if(status === 'BELUM KAWIN')
		{
			if(namaDepan !== 'An.' && namaDepan !== 'Nn' && namaDepan !== 'BY. Ny.')
			{
				myAlert('Silakan pilih status perkawinan yang sesuai!');
				$('#PPPasienM_statusperkawinan').val('KAWIN');
			}
		}else{
			if(status === 'KAWIN' || status === 'NIKAH SIRIH' || status === 'POLIGAMI')
			{
				if(namaDepan !== 'Tn.' && namaDepan !== 'Ny.')
				{
					myAlert('Silakan pilih status perkawinan yang sesuai!');
					$('#PPPasienM_statusperkawinan').val('BELUM KAWIN');
				}
			}
			else if(status === 'JANDA')
			{
				if(namaDepan !== 'Ny.')
				{
					myAlert('Silakan pilih status perkawinan yang sesuai!');
					if(namaDepan === 'Tn.')
					{
						$('#PPPasienM_statusperkawinan').val('KAWIN');
					}else{
						$('#PPPasienM_statusperkawinan').val('BELUM KAWIN');
					}
				}
			}
			else if(status === 'DUDA')
			{
				if(namaDepan !== 'Tn.')
				{
					myAlert('Silakan pilih status perkawinan yang sesuai!');
					if(namaDepan === 'Ny.')
					{
						$('#PPPasienM_statusperkawinan').val('KAWIN');
					}else{
						$('#PPPasienM_statusperkawinan').val('BELUM KAWIN');
					}
				}
			}
		}
	}

	function cekStatusPekerjaan(obj)
	{
		var namaDepan = $('#PPPasienM_namadepan').val();
		var namaPekerjaan = obj.value;
		var umur = $("#<?php echo CHtml::activeId($model,'umur');?>").val().substr(0,2);
		umur = parseInt(umur);

		if(namaDepan.length > 0)
		{
			if(umur < 15){
				if(namaPekerjaan !== '12'){
					if(namaPekerjaan !== ''){
						myAlert('Pasien masih di bawah umur,silakan cek kembali!');
					}
					$(obj).val('');
				}else{
					$(obj).val(namaPekerjaan);
				}
			}else{
				if(namaPekerjaan === '12'){
					if(namaDepan === 'Ny.'){
						$(obj).val('9');
					}else if(namaDepan === 'Nn' && namaPekerjaan === '9'){
						myAlert('Pasien belum menikah,silakan cek kembali!');
						$(obj).val('');
					}else{
						$(obj).val('');
					}
					myAlert('Silakan pilih pekerjaan yang tepat!');
				}else{
					if(namaPekerjaan === '9'){
						if(namaDepan !== 'Ny.'){
							myAlert('Pasien seorang laki-laki,silakan cek kembali!');
							$(obj).val('');                        
						}
					}
				}
			}
		}else{
			$(obj).val('');
			myAlert('Silakan pilih gelar kehormatan terlebih dahulu!');
		}

	}
	function addPropinsi()
	{
		<?php echo CHtml::ajax(array(
				'url'=>$this->createUrl('addPropinsi'),
				'data'=> "js:$(this).serialize()",
				'type'=>'post',
				'dataType'=>'json',
				'success'=>"function(data)
				{
					if (data.status == 'create_form')
					{
						$('#dialogAddPropinsi div.divForForm').html(data.div);
						$('#dialogAddPropinsi div.divForForm form').submit(addPropinsi);
					}
					else
					{
						$('#dialogAddPropinsi div.divForForm').html(data.div);
						$('#PPPasienM_propinsi_id').html(data.propinsi);
						setTimeout(\"$('#dialogAddPropinsi').dialog('close') \",1000);
					}

				} ",
		))?>;
		return false; 
	}

	function addKabupaten()
	{
		<?php echo CHtml::ajax(array(
				'url'=>$this->createUrl('addKabupaten'),
				'data'=> "js:$(this).serialize()",
				'type'=>'post',
				'dataType'=>'json',
				'success'=>"function(data)
				{
					if (data.status == 'create_form')
					{
						$('#dialogAddKabupaten div.divForFormKabupaten').html(data.div);
						$('#dialogAddKabupaten div.divForFormKabupaten form').submit(addKabupaten);
					}
					else
					{
						$('#dialogAddKabupaten div.divForFormKabupaten').html(data.div);
						$('#PPPasienM_kabupaten_id').html(data.kabupaten);
						setTimeout(\"$('#dialogAddKabupaten').dialog('close') \",1000);
					}

				} ",
		))?>;
		return false; 
	}

	function addKecamatan()
	{
		<?php echo CHtml::ajax(array(
				'url'=>$this->createUrl('addKecamatan'),
				'data'=> "js:$(this).serialize()",
				'type'=>'post',
				'dataType'=>'json',
				'success'=>"function(data)
				{
					if (data.status == 'create_form')
					{
						$('#dialogAddKecamatan div.divForFormKecamatan').html(data.div);
						$('#dialogAddKecamatan div.divForFormKecamatan form').submit(addKecamatan);
					}
					else
					{
						$('#dialogAddKecamatan div.divForFormKecamatan').html(data.div);
						$('#PPPasienM_kecamatan_id').html(data.kecamatan);
						setTimeout(\"$('#dialogAddKecamatan').dialog('close') \",1000);
					}

				} ",
		))?>;
		return false; 
	}

	function addKelurahan()
	{
		<?php echo CHtml::ajax(array(
				'url'=>$this->createUrl('addKelurahan'),
				'data'=> "js:$(this).serialize()",
				'type'=>'post',
				'dataType'=>'json',
				'success'=>"function(data)
				{
					if (data.status == 'create_form')
					{
						$('#dialogAddKelurahan div.divForFormKelurahan').html(data.div);
						$('#dialogAddKelurahan div.divForFormKelurahan form').submit(addKelurahan);
					}
					else
					{
						$('#dialogAddKelurahan div.divForFormKelurahan').html(data.div);
						$('#PPPasienM_kelurahan_id').html(data.kelurahan);
						setTimeout(\"$('#dialogAddKelurahan').dialog('close') \",1000);
					}

				} ",
		))?>;
		return false; 
	}
	/** bersihkan dropdown kecamatan */
	function setClearDropdownKecamatan()
	{
		$("#<?php echo CHtml::activeId($modPasien,"kecamatan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
	}
	/** bersihkan dropdown kelurahan */
	function setClearDropdownKelurahan()
	{
		$("#<?php echo CHtml::activeId($modPasien,"kelurahan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
	}

	function loadDaerahPasien(idProp,idKab,idKec,pasien_id)
	{
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('getListDaerahPasien'); ?>',
			data: {idProp: idProp, idKab: idKab, idKec: idKec, pasien_id: pasien_id},
			dataType: "json",
			success:function(data){
				$('#PPPasienM_propinsi_id').html(data.listPropinsi);
				$('#PPPasienM_kabupaten_id').html(data.listKabupaten);
				$('#PPPasienM_kecamatan_id').html(data.listKecamatan);
				$('#PPPasienM_kelurahan_id').html(data.listKelurahan);
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}

	function clearKecamatan()
	{
		$('#PPPasienM_kecamatan_id').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
	}

	function clearKelurahan()
	{
		$('#PPPasienM_kelurahan_id').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
	}
	
	function enableInputPasien(obj)
	{
		if(!obj.checked) {
			$('#fieldsetPasien input').removeAttr('disabled');
			$('#fieldsetPasien select').removeAttr('disabled');
			$('#fieldsetPasien textarea').removeAttr('disabled');
			$('#fieldsetPasien button').removeAttr('disabled');
			$('#fieldsetDetailPasien input').removeAttr('disabled');
			$('#fieldsetDetailPasien select').removeAttr('disabled');
			$('#controlNoRekamMedik button').attr('disabled','true');
			$('#noRekamMedik').attr('disabled','true');
			$('#detail_data_pasien').slideUp(500);
			$('#cex_detaildatapasien').removeAttr('checked','checked');
		}
		else {
			$('#fieldsetPasien input').attr('disabled','true');
			$('#fieldsetPasien select').attr('disabled','true');
			$('#fieldsetPasien textarea').attr('disabled','true');
			$('#fieldsetPasien button').attr('disabled','true');
			$('#fieldsetDetailPasien input').attr('disabled','true');
			$('#fieldsetDetailPasien select').attr('disabled','true');
			$('#controlNoRekamMedik button').removeAttr('disabled');
			$('#noRekamMedik').removeAttr('disabled');
			$('#detail_data_pasien').slideDown(500);
			$('#cex_detaildatapasien').attr('checked','checked');
		}
	}

	function getTglLahir(obj)
	{
		var str = obj.value;
		obj.value = str.replace(/_/gi, "0");
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('GetTglLahir'); ?>',
			data: {umur: obj.value},
			dataType: "json",
			success:function(data){
				$('#PPPasienM_tanggal_lahir').val(data.tglLahir);
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}

	function getUmur(obj)
	{
		if(obj.value == ''){
			obj.value = 0;
		}
		
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('setUmur'); ?>',
			data: {tanggal_lahir: obj.value},
			dataType: "json",
			success:function(data){
				$('#PPPendaftaranRj_umur').val(data.umur); 
				$('#PPPendaftaranMp_umur').val(data.umur); 
				$('#PPPendaftaranRd_umur').val(data.umur); 
				$("#<?php echo CHtml::activeId($model,'umur'); ?>").val(data.umur);
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}

	function loadUmur(tglLahir)
	{
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('setUmur'); ?>',
			data: {tglLahir: tglLahir},
			dataType: "json",
			success:function(data){
				$("#<?php echo CHtml::activeId($model,'umur'); ?>").val(data.umur);
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}

	function setJenisKelaminPasien(jenisKelamin)
	{
		$('input[name="PPPasienM[jeniskelamin]"]').each(function(){
				if(this.value == jenisKelamin)
					$(this).attr('checked',true);
			}
		);
	}

	function setRhesusPasien(rhesus)
	{
		$('input[name="PPPasienM[rhesus]"]').each(function(){
				if(this.value == rhesus)
					$(this).attr('checked',true);
			}
		);
	}

	$(document).ready(function(){
        // Notifikasi Pasien
        <?php 
            if(isset($_GET['smspasien'])){
                if($_GET['smspasien']==0){
        ?>
            var params = [];
            params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $model->pasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
            insert_notifikasi(params);
        <?php            
                }
            }
        ?>
				
		var enableInputPasien = '<?php isset($modPasien->isPasienLama) ? 1 : 0; ?>';
		if(enableInputPasien) { 
			$('#no_rekam_medik').removeAttr('readonly', 'true');
			$('#tombolPasienDialog').removeClass('hide');
		}else{
			$('#no_rekam_medik').attr('readonly','true');  
			$('#tombolPasienDialog').addClass('hide');
		}
		
		var enableInputPendaftaran = '<?php isset($model->isNoPendaftaran) ? 1 : 0; ?>';
		if(enableInputPendaftaran) {
			$('#inputNoPendaftaran input').attr('disabled','true');
			$('#inputNoPendaftaran button').attr('disabled','true');
		}else{
			$('#inputNoPendaftaran input').attr('disabled','true');
			$('#inputNoPendaftaran button').attr('disabled','true');
		}
    })
</script>