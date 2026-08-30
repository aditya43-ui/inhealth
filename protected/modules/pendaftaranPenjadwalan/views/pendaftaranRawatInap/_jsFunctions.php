<script type="text/javascript">


var input_ruangan_admisi = $("<?php echo "#" . CHtml::activeId($modPasienAdmisi, 'ruangan_id'); ?>");

/**
 * set karcis admisi
 * override setKarcis() di pendaftaranPenjadwalan/views/pendaftaranRawatJalan/_jsFunctions.php
 * @returns {undefined}
 */
function setKarcis()
{
    var kelaspelayanan_id=$("#<?php echo CHtml::activeId($modPasienAdmisi,"kelaspelayanan_id");?>").val();
    var ruangan_id=$("#<?php echo CHtml::activeId($modPasienAdmisi,"ruangan_id");?>").val();
    var penjamin_id=$("#<?php echo CHtml::activeId($modPasienAdmisi,"penjamin_id");?>").val();
    var pasien_id=$("#<?php echo CHtml::activeId($modPasien,"pasien_id");?>").val();
    
    if(kelaspelayanan_id !== "" && ruangan_id !== "" && penjamin_id !== "") {
        $("#form-karcis").addClass("animation-loading");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetKarcis'); ?>',
            data: {kelaspelayanan_id:kelaspelayanan_id, ruangan_id : ruangan_id, penjamin_id:penjamin_id, pasien_id:pasien_id},//
            dataType: "json",
            success:function(data){
                $("#content-karcis-html").html(data.listKarcis);
                $("#form-karcis").removeClass("animation-loading");
            },
             error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        $("#content-karcis-html").html("");
    }
       
}

function printStiker() {
        window.open('<?php echo $this->createUrl('printStiker', array('pendaftaran_id' => $model->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=860,height=480');
    }
/**
 * set antrian ruangan
 * @param {type} obj
 * @returns {undefined} */
function setAntrianRuanganAdmisi(){
    var ruangan_id = $("#<?php echo CHtml::activeId($modPasienAdmisi, 'ruangan_id') ?>").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetAntrianRuangan'); ?>',
        data: {ruangan_id:ruangan_id},
        dataType: "json",
        success:function(data){
            if(data.maxantrianruangan != null){
                if(data.no_urutantri > data.maxantrianruangan){
                    myAlert("Pasien Sudah Mencapai Maksimal Antrian Poliklinik "+data.maxantrianruangan+" Pasien"); 
                }
                $('#max-antrian-ruangan').val(data.maxantrianruangan);
            }else{
                $('#max-antrian-ruangan').val(0);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
 * set antrian ruangan
 * @param {type} obj
 * @returns {undefined} */
function setAntrianDokterAdmisi(ruangan_id){
    var ruangan_id = $("#<?php echo CHtml::activeId($modPasienAdmisi, 'ruangan_id') ?>").val();
    var pegawai_id = $("#<?php echo CHtml::activeId($modPasienAdmisi, 'pegawai_id') ?>").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetAntrianDokter'); ?>',
        data: {ruangan_id:ruangan_id, pegawai_id:pegawai_id},
        dataType: "json",
        success:function(data){
             $('#max-antrian-dokter').val(data.maxantriandokter);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}



/**
 * set dropdown dokter ruangan
 * override setDropdownDokter() di pendaftaranPenjadwalan/views/pendaftaranRawatJalan/_jsFunctions.php
 * @param {type} ruangan_id
 * @param {type} pegawai_id
 * @returns {undefined}
 */
function setDropdownDokter(ruangan_id)
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetDropdownDokter'); ?>',
       data: {ruangan_id : ruangan_id},//
       dataType: "json",
       success:function(data){
           $("#<?php echo CHtml::activeId($modPasienAdmisi,"pegawai_id");?>").html(data.listDokter);
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function setRuanganRawatGabung(){
    var ruangan_id = $("#<?php echo CHtml::activeId($modPasienAdmisi, 'ruangan_id') ?>").val();    
    var checkbox = 'check';
	var umur = $("#PPPendaftaranT_umur").val();	
	var kelaspelayanan_id = $("#<?php echo CHtml::activeId($modPasienAdmisi, 'kelaspelayanan_id') ?>").val();    
	
	
	if (umur != ''){
		var split = umur.split(" ");
		
		if (split[0] == '00' && split[2] == '00' && parseInt(split[4]) <= 30){			
			
		}else{
			alert("Maaf, Umur Pasien Lebih dari 30 hari");
			$("#PPPasienAdmisiT_rawatgabung").prop("checked",false);			
		}
	}else{
		alert("Maaf, Umur Pasien ini belum ada");
		$("#PPPasienAdmisiT_rawatgabung").prop("checked",false);		
	}
	
	var rawatgabung = $("#<?php echo CHtml::activeId($modPasienAdmisi, 'rawatgabung') ?>").prop('checked');
	
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('SetDropdownKamarKosong'); ?>',
		data: {ruangan_id:ruangan_id, rawatgabung:rawatgabung, check:checkbox, kelaspelayanan_id:kelaspelayanan_id},
		dataType: "json",
		success:function(data){
			 $("#<?php echo CHtml::activeId($modPasienAdmisi,"kamarruangan_id");?>").html(data.listKamar);
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

function setRawatGabung(){
	var ruangan_id = $("#<?php echo CHtml::activeId($modPasienAdmisi, 'ruangan_id') ?>").val();    
    var checkbox = 'check';
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('SetDropdownKamarKosong'); ?>',
		data: {ruangan_id:ruangan_id, rawatgabung:false, check:checkbox},
		dataType: "json",
		success:function(data){
			 $("#<?php echo CHtml::activeId($modPasienAdmisi,"kamarruangan_id");?>").html(data.listKamar);
			 $("#PPPasienAdmisiT_rawatgabung").prop("checked",false);
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

function setKelasPelayananIbuBayi(){
    var ruangan_id = $("#<?php echo CHtml::activeId($modPasienAdmisi, 'ruangan_id') ?>").val();
    var rawatgabung = $("#<?php echo CHtml::activeId($modPasienAdmisi, 'rawatgabung') ?>").prop('checked');    
    var kamarruangan_id = $("#<?php echo CHtml::activeId($modPasienAdmisi, 'kamarruangan_id') ?>").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('/ActionAjax/GetKelasMasukKamar/'); ?>',
        data: {ruangan_id:ruangan_id, rawatgabung:rawatgabung, kamarruangan_id:kamarruangan_id},
        dataType: "json",
        success:function(data){
             $("#<?php echo CHtml::activeId($modPasienAdmisi,"kelaspelayanan_id");?>").val(data.kelaspelayanan_id);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * set dropdown dokter ruangan
 * override setDropDownKelasPelayanan() di pendaftaranPenjadwalan/views/pendaftaranRawatInap/_jsFunctions.php
 * @param {type} ruangan_id
 * @param {type} pegawai_id
 * @returns {undefined}
 */
function setDropDownKelasPelayanan(ruangan_id)
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetDropdownKelasPelayananRI'); ?>',
       data: {ruangan_id : ruangan_id},//
       dataType: "json",
       success:function(data){
           $("#<?php echo CHtml::activeId($modPasienAdmisi,"kelaspelayanan_id");?>").html(data.listKelas);
		   $("#<?php echo CHtml::activeId($modPasienAdmisi,"kamarruangan_id");?>").html("");
		   $("#<?php echo CHtml::activeId($modPasienAdmisi,"kamarruangan_id");?>").append("<option = ''>-- Pilih --</option>");
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function setAsuransiBadakAdmisi(){
	var pasien_id = $("#<?php echo CHtml::activeId($modPasien,'pasien_id') ?>").val();
	var penjamin_id = $("#<?php echo CHtml::activeId($modPasienAdmisi,'penjamin_id') ?>").val();
	var pegawai_id = $("#PPPasienM_pegawai_id").val();
		$("#form-asubadak").addClass("animation-loading");
		$("#form-asudepartemen").addClass("animation-loading");
		$("#form-asupekerja").addClass("animation-loading");
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('SetAsuransiBadak'); ?>',
			data: {pasien_id: pasien_id, penjamin_id: penjamin_id,pegawai_id:pegawai_id},
			dataType: "json",
			success:function(data){
				setAsuransiBadakReset();
				if(data != null){
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'nopeserta') ?>").val(data.nopeserta);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'asuransipasien_id') ?>").val(data.asuransipasien_id);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'namaperusahaan') ?>").val(data.namaperusahaan);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'hubkeluarga') ?>").val(data.hubkeluarga);
					
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'asuransipasien_id') ?>").val(data.asuransipasien_id);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'namaperusahaan') ?>").val(data.namaperusahaan);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'nomorpokokperusahaan') ?>").val(data.nomorpokokperusahaan);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'nopeserta') ?>").val(data.nopeserta);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);
					
					$("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'asuransipasien_id') ?>").val(data.asuransipasien_id);
					$("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'nopeserta') ?>").val(data.nopeserta);
					$("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
					$("#<?php echo CHtml::activeId($modPegawai,'alamat_pegawai') ?>").val(data.alamat_pegawai);
					$("#<?php echo CHtml::activeId($modPegawai,'notelp_pegawai') ?>").val(data.notelp_pegawai);
					$("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);
				}
				
				$("#form-asubadak").removeClass("animation-loading");
				$("#form-asudepartemen").removeClass("animation-loading");
				$("#form-asupekerja").removeClass("animation-loading");
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); }
		});
	
}

/**
 * checking validasi penjamin (This Function Dedicate For LNG Projects Only)
 * @returns {undefined}
 * LNG-3
 */
function cekValiditasPenjaminAdmisi(penjamin_id){
	var carabayar_id = $("#<?php echo CHtml::activeId($modPasienAdmisi,"carabayar_id");?>").val();
	var pegawai_id = $("#PPPasienM_pegawai_id").val();
	if(carabayar_id == <?= Params::CARABAYAR_ID_BADAK; ?>){
		
		if((penjamin_id == <?= Params::PENJAMIN_ID_PISA; ?> ) || (penjamin_id == <?= Params::PENJAMIN_ID_PROKESPEN; ?> )){
			var pasien_id = $("#<?php echo CHtml::activeId($modPasien,"pasien_id");?>").val();
			$.ajax({
				type:'POST',
				url:'<?php echo $this->createUrl('cekValiditasPenjamin'); ?>',
				data: {type:"badak", pasien_id: pasien_id, penjamin_id: penjamin_id,pegawai_id:pegawai_id},
				dataType: "json",
				success:function(data){
					if((data.status == 'Empty') || (data.status == 'Fail')){
						myAlert(data.pesan);
						$("#<?php echo CHtml::activeId($modPasienAdmisi,"penjamin_id");?>").html(data.html);
					}else{

						if(data.penj == <?= Params::PENJAMIN_ID_PISA; ?> ){
							if(data.status == 'Tidak Tetap'){
								myAlert(data.pesan);
								$("#PPPendaftaranT_penjamin_id").html(data.html);
							}
						}else{
							myAlert("Prokespen hanya menjamin Pensiunan dan Istri/Suami Pensiunan");
						}
					}
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
		}
		setDropdownStatushubungankeluarga(penjamin_id);
		
	}else if(carabayar_id == <?= Params::CARABAYAR_ID_DEP_BADAK; ?>){
	
		
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('cekValiditasPenjamin'); ?>',
			data: {type:"departemen", penjamin_id: penjamin_id},
			dataType: "json",
			success:function(data){
				$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,"namaperusahaan");?>").val(data.data.penjamin_nama);
				$(".judulasuransi").html("Asuransi "+data.data.penjamin_nama);
				
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
		
	}
	
}

function getRuanganPoliklinikPasien(){
	// Hanya digunakan di transaksi Pendaftaran Rawat Jalan
}
/**
 * print status rawat inap dan karcis
 */
function printStatusRI()
{
    window.open('<?php echo $this->createUrl('printStatusRI',array('pasienadmisi_id'=>$model->pasienadmisi_id,'pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=480,height=640');
    <?php if($modPasienAdmisi->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR){ ?>
                window.open('<?php echo $this->createUrl('printKarcisRI',array('pasienadmisi_id'=>$model->pasienadmisi_id)); ?>','','left=600,top=100,width=480,height=640');
    <?php } ?>
}
/**
 * override function yang di pendaftaranRawatJalan
 */
function autoPrint(){
    printStatusRI();
    printStiker();
}

/**
 * print status
 */
function printStatus()
{
    window.open('<?php echo $this->createUrl('printStatus',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=860,height=480');
}
/**
 * print karcis
 */
function printKarcis()
{
    window.open('<?php echo $this->createUrl('printKarcis',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=480,height=640');
}

function cekAsuransi(){
  var penjamin_id = $("#<?php echo CHtml::activeId($modPasienAdmisi,'penjamin_id') ?>").val();
  var pasien_id = $("#<?php echo CHtml::activeId($modPasien,'pasien_id') ?>").val();

  if(pasien_id==""){
    myAlert('Masukan terlebih dahulu data pasien!');
  }else if(penjamin_id==""){
    myAlert('Masukan terlebih dahulu penjamin!');
  }else{
    $.fn.yiiGridView.update('asuransi-m-grid', {
        data: {
            "<?php echo get_class($modAsuransiPasien); ?>[pasien_id]":pasien_id,
            "<?php echo get_class($modAsuransiPasien); ?>[penjamin_id]":penjamin_id,
        }
    });
    $("#dialogAsuransi").dialog('open');
  }
  return false;
}

/**
 * load otomatis asuransi pasien terakhir (untuk RI)
 * @returns {undefined}
 */
function setAsuransiPasienLama(pasien_id){
	var pegawai_id = $("#PPPasienM_pegawai_id").val();
	$.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetAsuransiPasienLama'); ?>',
        data: { pasien_id: pasien_id},
        dataType: "json",
        success:function(data){
			if(data != null){
				if(confirm("Apakah pasien ini akan menggunakan penjamin "+data.penjamin_nama+"?")){
//				myConfirm("Apakah pasien ini akan menggunakan penjamin "+data.penjamin_nama+"?","Konfirmasi!",function(r) {
//					if(r){
						
						var datacarabayar_id = data.carabayar_id;
						var datalistPenjamin = data.listPenjamin;
						var datapenjamin_id = data.penjamin_id;
						var datanopeserta = data.nopeserta;
						var dataasuransipasien_id = data.asuransipasien_id;
						var datanokartuasuransi = data.nokartuasuransi;
						var datanamapemilikasuransi = data.namapemilikasuransi;
						var datanomorpokokperusahaan = data.nomorpokokperusahaan;
						var datakelastanggunganasuransi_id = data.kelastanggunganasuransi_id;
						var datanamaperusahaan = data.namaperusahaan;
						var datastatus_konfirmasi = data.status_konfirmasi;
						var datatgl_konfirmasi = data.tgl_konfirmasi;
						
                        $("#<?php echo CHtml::activeId($modPasienAdmisi,"carabayar_id");?>").val(data.carabayar_id);
						$("#<?php echo CHtml::activeId($modPasienAdmisi,"penjamin_id");?>").html(data.listPenjamin);
						$("#<?php echo CHtml::activeId($modPasienAdmisi,"penjamin_id");?>").val(data.penjamin_id);						
						
						//$.ajax({
							//type:'POST',
							//url:'<?php echo $this->createUrl('CekCaraBayarBadak'); ?>',
							//data: {pasien_id: pasien_id,pegawai_id:pegawai_id},
							//dataType: "json",
							//success:function(data){
								//if(data.status === true){
									
									setFormAsuransi(datacarabayar_id);
									$("#<?php echo CHtml::activeId($modPasienAdmisi,"carabayar_id");?>").val(datacarabayar_id);
									$("#<?php echo CHtml::activeId($modPasienAdmisi,"penjamin_id");?>").html(datalistPenjamin);
									//$("#<?php //echo CHtml::activeId($modPasienAdmisi,"penjamin_id");?>").val(datapenjamin_id);
									
									setTimeout('$("#<?php echo CHtml::activeId($modPasienAdmisi,"penjamin_id");?>").val('+datapenjamin_id+');',1000);
									if(datacarabayar_id == <?php echo Params::CARABAYAR_ID_BPJS ?>){
										<?php if (Yii::app()->user->getState('isbridging') == true){ ?>											
											getAsuransiNoKartu(datanopeserta, data);																					
											//alert('asdad');
											//alert("asd");
										<?php }else{ ?>
													
											
													$("#<?php echo CHtml::activeId($modAsuransiPasien,'nopeserta') ?>").val(datanopeserta);
													$("#<?php echo CHtml::activeId($modAsuransiPasien,'asuransipasien_id') ?>").val(dataasuransipasien_id);
													$("#<?php echo CHtml::activeId($modAsuransiPasien,'nokartuasuransi') ?>").val(datanokartuasuransi);
													$("#<?php echo CHtml::activeId($modAsuransiPasien,'namapemilikasuransi') ?>").val(datanamapemilikasuransi);
													$("#<?php echo CHtml::activeId($modAsuransiPasien,'nomorpokokperusahaan') ?>").val(datanomorpokokperusahaan);
													$("#<?php echo CHtml::activeId($modAsuransiPasien,'kelastanggunganasuransi_id') ?>").val(datakelastanggunganasuransi_id);
													$("#<?php echo CHtml::activeId($modAsuransiPasien,'namaperusahaan') ?>").val(datanamaperusahaan);
													$("#<?php echo CHtml::activeId($modAsuransiPasien,'status_konfirmasi') ?>").val(datastatus_konfirmasi);
													$("#<?php echo CHtml::activeId($modAsuransiPasien,'tgl_konfirmasi') ?>").val(datatgl_konfirmasi);
													$("#<?php echo CHtml::activeId($modAsuransiPasien,'nominal_tanggungan') ?>").val(formatNumber(data.nominal_tanggungan));
										<?php } ?>
									}else{
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'nopeserta') ?>").val(datanopeserta);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'asuransipasien_id') ?>").val(dataasuransipasien_id);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'nokartuasuransi') ?>").val(datanokartuasuransi);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'namapemilikasuransi') ?>").val(datanamapemilikasuransi);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'nomorpokokperusahaan') ?>").val(datanomorpokokperusahaan);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'kelastanggunganasuransi_id') ?>").val(datakelastanggunganasuransi_id);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'namaperusahaan') ?>").val(datanamaperusahaan);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'status_konfirmasi') ?>").val(datastatus_konfirmasi);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'tgl_konfirmasi') ?>").val(datatgl_konfirmasi);
                                                                                $("#<?php echo CHtml::activeId($modAsuransiPasien,'nominal_tanggungan') ?>").val(formatNumber(data.nominal_tanggungan));
									}
									
								//}else{
								//	myAlert(data.pesan);
							//		$("#<?php echo CHtml::activeId($modPasienAdmisi,"penjamin_id");?>").val("");
							//		$("#<?php echo CHtml::activeId($modPasienAdmisi,"carabayar_id");?>").val("");
							//	}
						//	},
						//	error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
						//});
						
						
					} 
//				}); 
			}
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function setAsuransiBadak(){
	var pasien_id = $("#<?php echo CHtml::activeId($modPasien,'pasien_id') ?>").val();
	var penjamin_id = $("#<?php echo CHtml::activeId($modPasienAdmisi,'penjamin_id') ?>").val();
	var pegawai_id = $("#PPPasienM_pegawai_id").val();
		$("#form-asubadak").addClass("animation-loading");
		$("#form-asudepartemen").addClass("animation-loading");
		$("#form-asupekerja").addClass("animation-loading");
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('SetAsuransiBadak'); ?>',
			data: {pasien_id: pasien_id, penjamin_id: penjamin_id,pegawai_id:pegawai_id},
			dataType: "json",
			success:function(data){
				setAsuransiBadakReset();
				if(data != null){
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'nopeserta') ?>").val(data.nopeserta);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'asuransipasien_id') ?>").val(data.asuransipasien_id);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'namaperusahaan') ?>").val(data.namaperusahaan);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'hubkeluarga') ?>").val(data.hubkeluarga);
					
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'asuransipasien_id') ?>").val(data.asuransipasien_id);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'namaperusahaan') ?>").val(data.namaperusahaan);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'nomorpokokperusahaan') ?>").val(data.nomorpokokperusahaan);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'nopeserta') ?>").val(data.nopeserta);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);
					
					$("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'asuransipasien_id') ?>").val(data.asuransipasien_id);
					$("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'nopeserta') ?>").val(data.nopeserta);
					$("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
					$("#<?php echo CHtml::activeId($modPegawai,'alamat_pegawai') ?>").val(data.alamat_pegawai);
					$("#<?php echo CHtml::activeId($modPegawai,'notelp_pegawai') ?>").val(data.notelp_pegawai);
					$("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);
				}
				
				$("#form-asubadak").removeClass("animation-loading");
				$("#form-asudepartemen").removeClass("animation-loading");
				$("#form-asupekerja").removeClass("animation-loading");
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); }
		});
	
}

/**
 * print Label Gelang
 */
function printLabelGelang()
{       
    window.open('<?php echo $this->createUrl('PendaftaranRawatInap/printLabelGelang',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=480,height=640');
}

$(document).ready(function() {
    //$("#cari_loket_id").val(13).change();
	jQuery(input_ruangan_admisi).multiselect({
        includeSelectAllOption: true,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '182px',
        enableCaseInsensitiveFiltering: true,
        onChange: function(element, checked) {

			var v = $(element).val();

			setDropdownDokter(v);
			setDropDownKelasPelayanan(v);
			setKarcis();setAntrianRuanganAdmisi();
			setDropdownJeniskasuspenyakit(v);
			setEDBpjs(v);
        }
    }).hide();

		

});

var hidables = null;
function setEDBpjs(val) {
    if (val == 8) {
        hidables = $("#form-bpjs .hidables-content").detach();
    } else {
        if (hidables != null) hidables.appendTo("#form-bpjs .hidables");
    }
}

function showUmumBpjs(carabayar){       
   
    if (carabayar == '<?php echo Params::CARABAYAR_ID_MEMBAYAR ?>'){
        $("#isumumbpjs").attr('style','display:block;');
    }else{
        $("#isumumbpjs").attr('style','display:none;');
    }
}

function cekStKamarRI(obj){
	var kamarruangan = $(obj).find("option:selected").text();
	var rawatgabung = $("#PPPasienAdmisiT_rawatgabung").prop("checked");
	
	var split = kamarruangan.split(" --- ");
	
	if (rawatgabung != true){
		if (typeof split[1] !== "undefined"){
			alert(split[0]+' Masih Digunakan oleh '+split[1]);
			$(obj).val('');
			return false;
		}
	}
   
}

function resetRawatGabung(){	
	$("#PPPasienAdmisiT_rawatgabung").prop("checked",false);		
}

</script>

<?php

$listJenis = CHtml::listData(JenisvaksinM::model()->findAll('jenisvaksin_aktif = true order by jenisvaksin_nama asc'), 'jenisvaksin_id', 'jenisvaksin_nama');

$str_list_jenis = '<option value="">-- Pilih --</option>';
foreach ($listJenis as $val => $item) {
    $str_list_jenis.= '<option value="'.$val.'">'.$item.'</option>';;
}

?>

<script>
    
    var row_idx = 0;
    var item_jenis_vaksinasi = '<?php echo $str_list_jenis; ?>';
    var row_vaksinasi = <?php echo CJSON::encode(array(
        'html'=>$this->renderPartial("pendaftaranPenjadwalan.views.pendaftaranRawatJalan.vaksinasi._rowVaksinasi", array(), true),
    )); ?>;
        
        
    function getDataRiwayatVaksinasi(pasien_id) {
        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/loadRiwayatVaksinasi') ?>', {pasien_id: pasien_id}, function(data) {
            if (data.ok == 1) {
                
                var idx = 0;
                
                $("#tab_riwayat_vaksinasi").html(data.html);
                
                renameInputRiwayatVaksinasi();
                
                $("#tab_riwayat_vaksinasi tr").each(function() {
                    
                    var date_input = $(this).find(".vaksinasi_tanggal").attr("id", "vaksinasi_tanggal_" + row_idx);
                    
                    $(date_input).datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
                        jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate'  : 'd','timeText':'Waktu','hourText':'Jam',
                             'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
                    $(date_input).parents(".input-append").find(".add-on").on('click', function() { $(date_input).datepicker('show'); }); 
                    
                    //$(this).find(".jenisvaksin_id").html(item_jenis_vaksinasi);
                    $(this).find(".vaksinasi_ke").maskMoney({
                        "symbol": "",
                        "defaultZero": true,
                        "allowZero": true,
                        "decimal": ",",
                        "thousands": "",
                        "precision": 0
                    });

                    row_idx++;
                    
                });
                
                if ($("#tab_riwayat_vaksinasi tr").length > 0) {
                    tampilFormRiwayatVaksinasi();
                }
            } else {
                myAlert(data.msg);
            }
        }, 'json');
    }    
        
    function hapusRowRiwayatVaksinasi(obj) {
        $(obj).parents("tr").remove();
    }    
        
        
        
    function tambahRowRiwayat() {
        $("#tab_riwayat_vaksinasi").append(row_vaksinasi.html);
        renameInputRiwayatVaksinasi();
        
        var last = $("#tab_riwayat_vaksinasi tr:last-child");
        
        var date_input = $(last).find(".vaksinasi_tanggal").attr("id", "vaksinasi_tanggal_" + row_idx);
        
        
        $(date_input).datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
                    jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate'  : 'd','timeText':'Waktu','hourText':'Jam',
                         'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
        $(date_input).parents(".input-append").find(".add-on").on('click', function() { $(date_input).datepicker('show'); });             
        
        $(last).find(".jenisvaksin_id").html(item_jenis_vaksinasi);
        $(last).find(".vaksinasi_ke").maskMoney({
            "symbol": "",
            "defaultZero": true,
            "allowZero": true,
            "decimal": ",",
            "thousands": "",
            "precision": 0
        });
        
        row_idx++;
        
    }
    
    function renameInputRiwayatVaksinasi() {
        
        var name_val = "RiwayatvaksinasipasienT[detail]";
        var id_val = "RiwayatvaksinasipasienT_detail_";
        var idx = 0;
        
        $("#tab_riwayat_vaksinasi tr").each(function() {
            
            var name_res = name_val + '[' + idx + ']';
            // var id_res = id_val + idx + '_';
            
            $(this).find(".riwayatvaksinasipasien_id").attr("name", name_res + "[riwayatvaksinasipasien_id]");
            $(this).find(".vaksinasi_tanggal").attr("name", name_res + "[vaksinasi_tanggal]");
            $(this).find(".vaksinasi_ke").attr("name", name_res + "[vaksinasi_ke]");
            $(this).find(".jenisvaksin_id").attr("name", name_res + "[jenisvaksin_id]");
            $(this).find(".vaksin_id").attr("name", name_res + "[vaksin_id]");
            $(this).find(".daftarvaksin_id").attr("name", name_res + "[daftarvaksin_id]");
            $(this).find(".no_batch").attr("name", name_res + "[no_batch]");
            $(this).find(".vaksinasi_lokasimenerima").attr("name", name_res + "[vaksinasi_lokasimenerima]");
            
            idx++;
        });
    } 
    
    
    function setItemVaksin(obj) {
        var jenisvaksin_id = $(obj).val();
        var input_vaksin = $(obj).parents("tr").find(".vaksin_id");
        
        $(obj).parents("tr").find(".daftarvaksin_id").val("");
        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/ajaxListVaksin'); ?>', {jenisvaksin_id: jenisvaksin_id}, function(data) {
            $(input_vaksin).html(data.html);
        }, 'json');
    }
    
    function setItemDaftarVaksin(obj) {
        var vaksin_id = $(obj).val();
        var input_daftar_vaksin = $(obj).parents("tr").find(".daftarvaksin_id");
        
        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/ajaxListDaftarVaksin'); ?>', {vaksin_id: vaksin_id}, function(data) {
            $(input_daftar_vaksin).html(data.html);
        }, 'json');
    }
    
    function setLoadJenisVaksinasi() {
        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/ajaxListJenisVaksin'); ?>', {}, function(data) {
            
            $(".list_jenisvaksin").each(function() {
                var data_lama = $(this).val();
                $(this).html(data.html);
                $(this).val(data_lama);
            });
            
            item_jenis_vaksinasi = data.html;
        }, 'json');
    }
    
    function setLoadProgramVaksinasi(jenisvaksin_id) {
        $("#tab_riwayat_vaksinasi tr").each(function() {
            
            var input_vaksin = $(this).find(".vaksin_id");
            
            if ($(this).find(".jenisvaksin_id").val() == jenisvaksin_id) {
                $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/ajaxListVaksin'); ?>', {jenisvaksin_id, jenisvaksin_id}, function(data) {
                    var nilai_lama = $(input_vaksin).val();
                    $(input_vaksin).html(data.html).val(nilai_lama);
                }, 'json');
            }
        });
    }
    function setLoadDaftarVaksinasi(vaksin_id) {
        console.log("VAKSIN", vaksin_id);
        $("#tab_riwayat_vaksinasi tr").each(function() {
            
            var input_vaksin = $(this).find(".daftarvaksin_id");
            
            if ($(this).find(".vaksin_id").val() == vaksin_id) {
                $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/ajaxListDaftarVaksin'); ?>', {vaksin_id, vaksin_id}, function(data) {
                    var nilai_lama = $(input_vaksin).val();
                    $(input_vaksin).html(data.html).val(nilai_lama);
                }, 'json');
            }
        });
    }
    
    /** control accordion penanggung jawab pasien */
    $('#form-vaksinasi > div > .accordion-heading').click(function(){
    //    console.log("Detail PJ Pasien Di Klik!");
        var is_vaksinasi = $("#<?php echo CHtml::activeId($model, "is_vaksinasi"); ?>");
        if(is_vaksinasi.val() > 0){ //hide
            is_vaksinasi.val(0);
        }else{//show
            is_vaksinasi.val(1);
        }
    });
    
    function tampilFormRiwayatVaksinasi(){
        $('#form-vaksinasi > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-vaksinasi > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-vaksinasi').removeClass().addClass("accordion-body in collapse");
        $("#<?php echo CHtml::activeId($model, "is_vaksinasi"); ?>").val(1);
    }
    
    
    function cekValidasiRiwayatVaksinasi() {
        var is_kosong = 0;
        var is_vaksinasi = $("#<?php echo CHtml::activeId($model, "is_vaksinasi"); ?>").val();
        
        $("#tab_riwayat_vaksinasi .input_req").each(function() {
            $(this).removeClass("error");
            if ($(this).val() == "" || $(this).val() == null) {
                is_kosong = 1;
                $(this).addClass("error");
            }
        });
        
        if (is_kosong != 0 && is_vaksinasi == 1) {
            myAlert("Input pada Kolom * pada Tabel Riwayat Vaksinasi harus diisi");
            return false;
        }
        
        return true;
        
    }
</script>
    