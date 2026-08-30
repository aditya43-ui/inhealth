<?php
/* RND-13881
 * $gets = "";
if (isset($_GET)) {
	foreach ($_GET AS $name => $get) {
		if ($name != "r")
			$gets .= "&" . $name . "=" . $get;
	}
}*/
?>
<?php $baseUrl = Yii::app()->createUrl("/"); ?>
<script type='text/javascript'>
	function cekKunjungan(pasienanastesi_id, pendaftaran_id, pasienmasukpenunjang_id) {
		if (pasienanastesi_id !== undefined) {
			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createUrl('cekKunjungan'); ?>',
				data: {pasienanastesi_id: pasienanastesi_id},
				dataType: "json",
				success: function (data) {

					if (data != null) {
						myAlert("Pasien sudah dipilih!");
						setKunjunganReset();
						return false;
					} else {
						setKunjungan(pasienanastesi_id, pendaftaran_id, pasienmasukpenunjang_id);
						return true;
					}

				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});
		}
	}

	/**
	 * set form kunjungan
	 * @param {type} pasienanastesi_id, pendaftaran_id, pasienmasukpenunjang_id
	 * @returns {undefined}
	 */
	function setKunjungan(pasienanastesi_id, pendaftaran_id, pasienmasukpenunjang_id) {
		$("#form-datakunjungan > div").addClass("animation-loading");
		$.ajax({
			type: 'POST',
			url: '<?php echo $this->createUrl('GetDataKunjungan'); ?>',
			data: {pasienanastesi_id: pasienanastesi_id, pendaftaran_id: pendaftaran_id, pasienmasukpenunjang_id: pasienmasukpenunjang_id},
			dataType: "json",
			success: function (data) {
				if (data.pesan != "") {
					myAlert(data.pesan);
					setKunjunganReset();
				} else {
					$("#<?php echo CHtml::activeId($modKunjungan, 'pasienanastesi_id'); ?>").val(data.pasienanastesi_id);
					$("#<?php echo CHtml::activeId($modKunjungan, 'pendaftaran_id'); ?>").val(data.pendaftaran_id);
					$("#<?php echo CHtml::activeId($modKunjungan, 'pasien_id'); ?>").val(data.pasien_id);
					$("#<?php echo CHtml::activeId($modKunjungan, 'pasienmasukpenunjang_id'); ?>").val(data.pasienmasukpenunjang_id);
					$("#<?php echo CHtml::activeId($modKunjungan, 'noanestesi'); ?>").val(data.noanestesi);
					$("#<?php echo CHtml::activeId($modKunjungan, 'tglanastesi'); ?>").val(data.tglanastesi);
					$("#<?php echo CHtml::activeId($modKunjungan, 'umur'); ?>").val(data.umur);
					$("#<?php echo CHtml::activeId($modKunjungan, 'jeniskasuspenyakit_id'); ?>").val(data.jeniskasuspenyakit_id);
					$("#<?php echo CHtml::activeId($modKunjungan, 'jeniskasuspenyakit_nama'); ?>").val(data.jeniskasuspenyakit_nama);
					$("#<?php echo CHtml::activeId($modKunjungan, 'pegawai_id'); ?>").val(data.nama_pegawai);
					$("#<?php echo CHtml::activeId($modKunjungan, 'no_rekam_medik'); ?>").val(data.no_rekam_medik);
					$("#<?php echo CHtml::activeId($modKunjungan, 'nama_pasien'); ?>").val(data.nama_pasien);
					$("#<?php echo CHtml::activeId($modKunjungan, 'jeniskelamin'); ?>").val(data.jeniskelamin);
					$("#<?php echo CHtml::activeId($modKunjungan, 'pekerjaan_id'); ?>").val(data.pekerjaan_id);
					$("#<?php echo CHtml::activeId($modKunjungan, 'pekerjaan_nama'); ?>").val(data.pekerjaan_nama);
					$("#<?php echo CHtml::activeId($modKunjungan, 'kelaspelayanan_id'); ?>").val(data.kelaspelayanan_id);
					$("#<?php echo CHtml::activeId($modKunjungan, 'kelaspelayanan_nama'); ?>").val(data.kelaspelayanan_nama);
					$("#<?php echo CHtml::activeId($modKunjungan, 'alamat_pasien'); ?>").val(data.alamat_pasien);

					if (data.photopasien === null || data.photopasien === "" || data.photopasien === undefined) { //set photo
						$('#photo-preview').attr('src', '<?php echo Params::urlPhotoPasienDirectory() . "no_photo.jpeg" ?>');
					} else {
						$('#photo-preview').attr('src', '<?php echo Params::urlPasienTumbsDirectory() . "kecil_" ?>' + data.photopasien);
					}
					$("#form-datakunjungan > legend > .judul").html('Data Pasien ' + data.no_masukpenunjang);
					$("#form-datakunjungan > legend > .tombol").attr('style', 'display:true;');
					$("#form-datakunjungan > .box").addClass("well").removeClass("box");

				}
				$("#form-datakunjungan > div").removeClass("animation-loading");
				$("#<?php echo CHtml::activeId($modKunjungan, 'noanestesi'); ?>").focus();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				myAlert("Data kunjungan tidak ditemukan !");
				console.log(errorThrown);
				setKunjunganReset();
				$("#form-datakunjungan > div").removeClass("animation-loading");
				$("#<?php echo CHtml::activeId($modKunjungan, 'noanestesi'); ?>").focus();
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
		$('#photo-preview').attr('src', '<?php echo Params::urlPhotoPasienDirectory() . "no_photo.jpeg" ?>');
		$("#form-datakunjungan > legend > .judul").html('Data Pasien');
		$("#form-datakunjungan > legend > .tombol").attr('style', 'display:none;');
		$("#form-datakunjungan > .well").addClass("box").removeClass("well");
	}

	function setTab(obj,value) {
		var pasienanastesi_id = $("#<?php echo CHtml::activeId($modKunjungan, 'pasienanastesi_id'); ?>").val();
		var praanestesi_id = '<?php echo isset($_GET['praanestesi_id']) ? $_GET['praanestesi_id'] : null; ?>';


            if(value == true) {
                $.ajax({
                    type:'POST',
                    url:'<?php echo $this->createUrl('getData'); ?>',
                    data:{pasienanastesi_id:pasienanastesi_id},
                    dataType:"json",
                    success:function(data) {
                        if(data.sukses == 0) {
                            myAlert(data.pesan);
                            $('#frame').attr('src',"");
                         }
              
                },
                 error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });          
            }
		if (pasienanastesi_id !== "") {
			$(obj).parents("ul").find("li").each(function () {
				$(this).removeClass("active");
				$(this).attr("onclick", "setTab(this);");
			});
			$(obj).addClass("active");
			$(obj).removeAttr("onclick", "setTab(this);");
			var tab = $(obj).attr("tab");
			var frameObj = document.getElementById("frame");
			resetIframe(frameObj);
			//    $(frameObj).attr("src","<?php //echo $baseUrl; ?>?r="+tab+"<?php //echo $gets; ?>");
			if (praanestesi_id != '') {
				$(frameObj).attr("src", "<?php echo $baseUrl; ?>?r=" + tab + "&pasienanastesi_id=" + pasienanastesi_id + "&praanestesi_id=" + praanestesi_id);
			} else {
				$(frameObj).attr("src", "<?php echo $baseUrl; ?>?r=" + tab + "&pasienanastesi_id=" + pasienanastesi_id);
			}
			$(frameObj).parent().addClass("animation-loading");
			$(frameObj).load(function () {
				$(frameObj).parent().removeClass("animation-loading");
				resizeIframe(frameObj);
			});
		} else {
			myAlert("Silahkan pilih data pasien anastesia !");
		}
		return false;
	}
	function resetIframe(obj) {
		obj.style.height = 128 + 'px';
	}
	function resizeIframe(obj) {
		obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
	}

	$(document).ready(function () {
<?php if (!empty($_GET['pasienanastesi_id'])) { ?>
			var pasienanastesi_id = '<?php echo isset($_GET['pasienanastesi_id']) ? $_GET['pasienanastesi_id'] : null; ?>';
			var pendaftaran_id = '<?php echo isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null; ?>';
			var pasienmasukpenunjang_id = '<?php echo isset($_GET['pasienmasukpenunjang_id']) ? $_GET['pasienmasukpenunjang_id'] : null; ?>';
			setKunjungan(pasienanastesi_id, pendaftaran_id, pasienmasukpenunjang_id)

<?php } ?>
	});
</script>