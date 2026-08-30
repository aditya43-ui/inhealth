<script type="text/javascript">
function cekValiditas(){
	if(requiredCheck($("form"))){
		var nip = $("#<?php echo CHtml::activeId($modPegawai,'nomorindukpegawai'); ?>").val();
		var noidentitas = $("#<?php echo CHtml::activeId($modPegawai,'noidentitas'); ?>").val();
        $.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('CekNIP'); ?>',
			data: { nip : nip, noidentitas : noidentitas },//
			dataType: "json",
			success:function(data){
				if(data.nip != null){
					myAlert('Nomor Induk Pegawai Sudah digunakan oleh pegawai lain');
				}else{
					if(data.noidentitas != null){
						myAlert('No Identitas Sudah digunakan oleh pegawai lain');
					}else{
						disableOnSubmit('#btn_submit');
						$("form").find('.float').each(function(){
							$(this).val(formatFloat($(this).val()));
						});
						$("form").find('.integer').each(function(){
							$(this).val(formatInteger($(this).val()));
						});
						setTimeout(function(){
							$('#pegawai-m-form').submit();
						}, 1500);
					}
				}
			},
			 error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});

    }
    return false;
}

function usia()
{
	var tgl_lahirpegawai = $("#<?php echo CHtml::activeId($modPegawai,'tgl_lahirpegawai'); ?>").val();
	setUmur(tgl_lahirpegawai);
}
/**
 * set nilai umur dari tanggal_lahir
 * @param {type} tanggal_lahir
 * @returns {undefined} */
function setUmur(tanggal_lahir)
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetUmur'); ?>',
       data: {tanggal_lahir : tanggal_lahir},//
       dataType: "json",
       success:function(data){
           $("#<?php echo CHtml::activeId($modPegawai,"umur_bekerja");?>").val(data.umur);
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
 * set nilai tanggal_lahir dari umur
 * @param {type} obj
 * @returns {undefined} */
function setTglLahir(obj)
{
    var str = obj.value;
    obj.value = str.replace(/_/gi, "0");
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetTanggalLahir'); ?>',
       data: {umur : obj.value},
       dataType: "json",
       success:function(data){
           $("#<?php echo CHtml::activeId($modPegawai,"tgl_lahirpegawai");?>").val(data.tanggal_lahir);
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/** bersihkan dropdown kecamatan */
function setClearDropdownKecamatan()
{
    $("#<?php echo CHtml::activeId($modPegawai,"kecamatan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}
/** bersihkan dropdown kelurahan */
function setClearDropdownKelurahan()
{
    $("#<?php echo CHtml::activeId($modPegawai,"kelurahan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}

function setClearDropdownKelompokPegawai()
{
    $("#<?php echo CHtml::activeId($modPegawai,"kelompokpegawai_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    cekValidasiNIP();
}

function cekValidasiNIP()
{
    var pen = <?php echo Params::PENDIDIKAN_S1; ?>;

    if ($("#KPPegawaiM_kategoripegawai").val() == "PNS") {
        $("label[for=KPPegawaiM_nomorindukpegawai]").addClass("required");
        $("#KPPegawaiM_nomorindukpegawai").addClass("required");
        if ($("#KPPegawaiM_pendidikan_id").val().trim() == pen )
        {
            $("label[for=KPPegawaiM_gelarbelakang_id]").addClass("required");
        }else{
            $("label[for=KPPegawaiM_gelarbelakang_id]").removeClass("required");
        }
    } else {
        $("label[for=KPPegawaiM_nomorindukpegawai]").removeClass("required");
        $("#KPPegawaiM_nomorindukpegawai").removeClass("required");
       if ($("#KPPegawaiM_pendidikan_id").val().trim() == pen )
        {
            $("label[for=KPPegawaiM_gelarbelakang_id]").addClass("required");
        }else{
           $("label[for=KPPegawaiM_gelarbelakang_id]").removeClass("required");
        }
    }
}

function getChangeTglTerima(){
    var tglterima = $('#<?php echo CHtml::activeId($modPegawai, 'tglditerima') ?>').val();
    $('#<?php echo CHtml::activeId($modPegawai,'tglmasaaktifpeg') ?>').val(tglterima);
}

$( document ).ready(function(){
cekValidasiNIP();
});
</script>
