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
	function setTab(obj, value) {
            var id = $("#<?php echo CHtml::activeId($modKunjungan, 'pendaftaran_id'); ?>").val();
            var kirim_id = $("#<?php echo CHtml::activeId($modKunjungan, 'pasienkirimkeunitlain_id'); ?>").val();
            var pasienanastesi_id = $("#<?php echo CHtml::activeId($modKunjungan, 'pasienanastesi_id'); ?>").val();
            var tabulasi = $(obj).attr('tabulasi');
            if (typeof id === 'undefined'){
                myAlert('Data Pasien belum dipilih ');
                return false;
            }
            $('#frame').attr('src', "");
            if(value == true) {
                var id = $("#<?php echo CHtml::activeId($modKunjungan, 'pendaftaran_id'); ?>").val();
                var kirim_id = $("#<?php echo CHtml::activeId($modKunjungan, 'pasienkirimkeunitlain_id'); ?>").val();
                $.ajax({
                    type:'POST',
                    url:'<?php echo $this->createUrl('cekKunjungan'); ?>',
                        data: {id: id,kirim_id:kirim_id, tabulasi:tabulasi,pasienanastesi_id:pasienanastesi_id},
                        dataType: "json",
                        success: function (data) {
                            if (data.sukses == 0) {
                                myAlert(data.pesan);
                                $('#frame').attr('src', "");
                            }else{
                                //if (tabulasi == 'persetujuan'){
                                    $("#<?php echo CHtml::activeId($modKunjungan, 'pasienanastesi_id'); ?>").val(data.pasienanastesi_id);                                    
                                //}
                                setFrame($(obj));
                            }
                            
                            
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                }else{
                    setFrame($(obj));
                }
                
                $(obj).parents("ul").find("li").each(function() {
                        $(this).removeClass("active");
                        $(this).attr("onclick", "setTab(this,value = true);");
                });            
                
            return false;
        }
        
        function setFrame(obj){
            var id = $("#<?php echo CHtml::activeId($modKunjungan, 'pendaftaran_id'); ?>").val();
            var kirim_id = $("#<?php echo CHtml::activeId($modKunjungan, 'pasienkirimkeunitlain_id'); ?>").val();
        
            $(obj).addClass("active");
            $(obj).removeAttr("onclick","setTab(this);");
            var tab = $(obj).attr("tab");
            var tabulasi = $(obj).attr("tabulasi");
            var pasienanastesi_id = $("#<?php echo CHtml::activeId($modKunjungan, 'pasienanastesi_id'); ?>").val();
            var frameObj = document.getElementById("frame");
       
            resetIframe(frameObj);
            $(frameObj).attr("src","<?php echo $baseUrl;?>?r="+tab+"&pendaftaran_id="+id+"&pasienkirimkeunitlain_id="+kirim_id+"&pasienanastesi_id="+pasienanastesi_id);
            
            $("#frame-detail").addClass("animation-loading");
            $(frameObj).load(function(){
                $("#frame-detail").removeClass("animation-loading");
                resizeIframe(frameObj,tabulasi);
            });
        }

	/**
	 * set form kunjungan
	 * @param {type} pasienanastesi_id, pendaftaran_id, pasienmasukpenunjang_id
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
				if (data.pesan != "") {
					myAlert(data.pesan);
					setKunjunganReset();
				} else {
					$("#<?php echo CHtml::activeId($modKunjungan, 'no_rekam_medik'); ?>").val(data.no_rekam_medik);
					$("#<?php echo CHtml::activeId($modKunjungan, 'tgl_pendaftaran'); ?>").val(data.tgl_pendaftaran);
					$("#<?php echo CHtml::activeId($modKunjungan, 'pendaftaran_id'); ?>").val(data.pendaftaran_id);
                                        $("#<?php echo CHtml::activeId($modKunjungan, 'pasienkirimkeunitlain_id'); ?>").val(data.pasienkirimkeunitlain_id);
					$("#<?php echo CHtml::activeId($modKunjungan, 'pasien_id'); ?>").val(data.pasien_id);
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
					$("#form-datakunjungan > legend > .judul").html('Data Pasien ' + data.no_rekam_medik);
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
				$("#<?php echo CHtml::activeId($modKunjungan, 'no_rekam_medik'); ?>").focus();
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

	function resetIframe(obj) {
		obj.style.height = 128 + 'px';
	}
	function resizeIframe(obj,tabulasi) {            
                if (tabulasi == 'rencana'){                    
                    obj.style.height = ((obj.contentWindow.document.body.scrollHeight))+'px';
                }else{
                    obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
                }
	}

        function setTabReset() {
            $(".nav-tabs > .active").attr("onclick", "setTab(this);");
            $(".nav-tabs > .active").removeClass("active");
        
            $("#frame").attr("src", "");
        }

	$(document).ready(function () {
        <?php if (!empty($_GET['pasienkirimkeunitlain_id'])) { ?>
			var pasienkirimkeunitlain_id = '<?php echo isset($_GET['pasienkirimkeunitlain_id']) ? $_GET['pasienkirimkeunitlain_id'] : null; ?>';
			setKunjungan(pasienkirimkeunitlain_id)

<?php } ?>
	});
</script>