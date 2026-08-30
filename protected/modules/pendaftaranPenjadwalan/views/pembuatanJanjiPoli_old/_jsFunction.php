<?php
	$enableInputPasien = ($modPasien->isPasienLama) ? 1 : 0;
	$cekKartuPasien=Yii::app()->user->getState('printkartulsng');
	if(!empty($cekKartuPasien)){ //Jika Kunjungan Pasien diisi TRUE
		$statusKartuPasien=$cekKartuPasien;
	}else{ //JIka Print Kunjungan Diset FALSE
		$statusKartuPasien=0;
	}
?>
<script type="text/javascript">
$('#tab1-rekammedik').fadeIn(100);
$('#tab1-datapasien').hide();
$('#tab1-datapoli').hide();
function tab1(obj){
	var poli = obj.id;
	if(poli == 'rekammedik'){
		$('#rekammedik').attr('class', 'active');
		$('#datapasien').removeAttr('class');
		$('#datapoli').removeAttr('class');
		$('#tab1-datapasien').fadeOut(100);
		$('#tab1-datapoli').fadeOut(100);
		$('#tab1-rekammedik').fadeIn(100);
	}else if(poli == 'datapasien'){
		$('#datapasien').attr('class', 'active');
		$('#rekammedik').removeAttr('class');
		$('#datapoli').removeAttr('class');
		$('#tab1-rekammedik').fadeOut(100);
		$('#tab1-datapoli').fadeOut(100);
		$('#tab1-datapasien').fadeIn(100);
	}else{
		$('#datapoli').attr('class', 'active');
		$('#datapasien').removeAttr('class');
		$('#datapoli').removeAttr('class');
		$('#tab1-datapasien').fadeOut(100);
		$('#tab1-rekammedik').fadeOut(100);
		$('#tab1-datapoli').fadeIn(100);
	}

}
	  
function checkedRM(){
	$("#isPasienLama").attr('checked',true);
}

function printKarcis(){
	window.open('<?php echo $this->createUrl('printKarcis',array('buatjanjipoli_id'=>$model->buatjanjipoli_id)); ?>','printwin','left=100,top=100,width=480,height=640');
}

function getTglLahir(obj)
{   
    var str = obj.value;
    obj.value = str.replace(/_/gi, "0");
    $.post("<?php echo $this->createUrl('GetTglLahir'); ?>",{umur: obj.value},
        function(data){
           $('#PPPasienM_tanggal_lahir').val(data.tglLahir); 
    },"json");
}
	
function getUmur(obj)
{
    if(obj.value == '')
	obj.value = 0;
    $.post("<?php echo $this->createUrl('SetUmur'); ?>",{tanggal_lahir: obj.value},
        function(data){
           $('#PPPasienM_umur').val(data.umur);
    },"json");
}
	
if(<?php echo $enableInputPasien ?>) { 
    $('#no_rekam_medik').removeAttr('readonly', 'true');
    $('#tombolPasienDialog').removeClass('hide');
}
else {
    $('#no_rekam_medik').attr('readonly','true');  
    $('#tombolPasienDialog').addClass('hide');
}

function hariBaru()
{
	var tanggal = $('#PPBuatJanjiPoliT_tgljadwal').val();
	$.post("<?php echo $this->createUrl('GetHari'); ?>",{tanggal: tanggal},
	function(data){
	   $('#PPBuatJanjiPoliT_harijadwal').val(data.hari); 
	},"json");

}

function listDokterRuangan(idRuangan)
{
    $.post("<?php echo $this->createUrl('listDokterRuangan'); ?>", { idRuangan: idRuangan },
        function(data){
            $('#PPBuatJanjiPoliT_pegawai_id').html(data.listDokter);
    }, "json");
}

function loadUmur(tglLahir)
{
    $.post("<?php echo $this->createUrl('SetUmur'); ?>",{tanggal_lahir: tglLahir},
        function(data){
           $("#PPPasienM_umur").val(data.umur);
    },"json");
}
	
function setNip(pegawai_id)
{
    $.post("<?php echo $this->createUrl('SetNip'); ?>",{pegawai_id: pegawai_id},
        function(data){
//           $("#cari_nomorindukpegawai").val(data.nomorindukpegawai);
//	RND-9167
			 $("#<?php echo CHtml::activeId($modPegawai,'nomorindukpegawai');?>").val(data.nomorindukpegawai);
    },"json");
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

function loadDaerahPasien(idProp,idKab,idKec,pasien_id)
{
    $.post("<?php echo $this->createUrl('getListDaerahPasien'); ?>", { idProp: idProp, idKab: idKab, idKec: idKec, pasien_id: pasien_id },
        function(data){
            $('#PPPasienM_propinsi_id').html(data.listPropinsi);
            $('#PPPasienM_kabupaten_id').html(data.listKabupaten);
            $('#PPPasienM_kecamatan_id').html(data.listKecamatan);
            $('#PPPasienM_kelurahan_id').html(data.listKelurahan);
    }, "json");
}
    
function pilihNoRm(){
    if($('#isPasienLama').is(':checked')){
        $('#no_rekam_medik').removeAttr('readonly', 'true');
        $('#tombolPasienDialog').removeClass('hide');
    }else{
        $('#no_rekam_medik').val(''); 
        $('#no_rekam_medik').attr('readonly','true'); 
        $('#tombolPasienDialog').addClass('hide');
    }
} 

$(document).ready(function(){
  <?php
    if(isset($model->buatjanjipoli_id)){
  ?>
      var params = [];
      params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_RJ; ?>, judulnotifikasi:'Janji Poliklinik', isinotifikasi:'<?php echo $modPasien->nama_pasien ?>  dengan <?php echo $modPasien->no_rekam_medik ?> memiliki janji poliklinik pada <?php echo $model->tgljadwal ?> di <?php echo $model->ruangan->ruangan_nama ?>'}; // 16 
      insert_notifikasi(params);
  <?php
    }
  ?>
   
});
</script>