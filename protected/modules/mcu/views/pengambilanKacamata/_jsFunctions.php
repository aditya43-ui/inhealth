<script type="text/javascript">
/**
 * set data pegawai
 * @param {type} pegawai_id
 * @returns {undefined}
 */
function setDataPegawai(pegawai_id){
    $("#form-pasien > div").addClass("animation-loading");
    setPegawaiBaru(); 
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataPegawai'); ?>',
        data: {pegawai_id:pegawai_id},
        dataType: "json",
        success:function(data){
			$("#cari_nomorindukpegawai").val(data.nomorindukpegawai);
			$("#<?php echo CHtml::activeId($model,'pegawai_id');?>").val(data.pegawai_id);
			$("#<?php echo CHtml::activeId($model,'nama_pegawai');?>").val(data.nama_pegawai);
			$("#<?php echo CHtml::activeId($model,'departement_peg');?>").val(data.departement_peg);
			$("#<?php echo CHtml::activeId($model,'namapasien_hub');?>").val(data.nama_pegawai);
			$("#<?php echo CHtml::activeId($model,'statushubungan');?>").val('Pekerja'); // Default Pekerja (Sesuaikan Lookup) karna autocomple yang tersedia adalah data pekerja
			setJumlahHarga();  // ngeset jmlharga
			
			$("#form-pasien > legend > .judul").html('Data Pasien');
			$("#form-pasien > legend > .tombol").attr('style','display:true;');
			$("#form-pasien > .box").addClass("well").removeClass("box");
            $("#form-pasien > div").removeClass("animation-loading");
			
			setTglGantiKacamata();
			
        },
        error: function (jqXHR, textStatus, errorThrown) { myAlert("Data Pasien tidak ditemukan!"); $("#form-pasien > div").removeClass("animation-loading");}
    });

}

/**
 * set form pegawai ke pegawai baru
 * @returns {undefined} */
function setPegawaiBaru(){
	$("#<?php echo CHtml::activeId($model,'pegawai_id');?>").val("");
	$("#<?php echo CHtml::activeId($model,'nama_pegawai');?>").val("");
	$("#<?php echo CHtml::activeId($model,'departement_peg');?>").val("");
	$("#<?php echo CHtml::activeId($model,'namapasien_hub');?>").val("");
	$("#<?php echo CHtml::activeId($model,'statushubungan');?>").val("");
	$("#<?php echo CHtml::activeId($model,'duedata_kacamata');?>").val("");
	$("#<?php echo CHtml::activeId($model,"duedata_kacamata_date");?>").attr("style","display:block;");
	$("#<?php echo CHtml::activeId($model,'tglgantikacamata');?>").val("");
	$("#<?php echo CHtml::activeId($model,'tglpenyerahan');?>").val("");
	$("#<?php echo CHtml::activeId($model,'jumlahharga_km');?>").val("");
    $("#form-pasien > legend > .judul").html('Data Pegawai ');
    $("#form-pasien > legend > .tombol").attr('style','display:none;');
    $("#form-pasien > .well").addClass("box").removeClass("well");
    $("#cari_nomorindukpegawai").val("");
}

/**
 * set nilai tgl due date dari tglpenyerahan 
 * @param {type} tglpenyerahan
 * @returns {undefined} */
function setTglGantiKacamata()
{
	$("#<?php echo CHtml::activeId($model,"duedata_kacamata");?>").addClass('animation-loading-1');
	$("#<?php echo CHtml::activeId($model,"tglgantikacamata");?>").addClass('animation-loading-1');
	var pegawai_id = $('#<?php echo CHtml::activeId($model,'pegawai_id'); ?>').val();
	var jnstransaksi_km = $('#<?php echo CHtml::activeId($model,'jnstransaksi_km'); ?>').val();
	var pegawai_id = $('#<?php echo CHtml::activeId($model,'pegawai_id'); ?>').val();
	var duedata_kacamata = $('#<?php echo CHtml::activeId($model,'duedata_kacamata'); ?>').val();
	var tglpenyerahan = $('#<?php echo CHtml::activeId($model,'tglpenyerahan'); ?>').val();
	var url = '';
	if(tglpenyerahan == ''){
		url = '<?php echo $this->createUrl('SetTglGantiKacamata'); ?>';
	}else{
		url = '<?php echo $this->createUrl('SetTglGantiKacamataDariTglSerah'); ?>';
	}
	
	if((pegawai_id != '') && (jnstransaksi_km != '')){
		$.ajax({
			type:'POST',
			url:url,
			data: {jnstransaksi_km:jnstransaksi_km,pegawai_id:pegawai_id,duedata_kacamata:duedata_kacamata,tglpenyerahan:tglpenyerahan},//
			dataType: "json",
			success:function(data){
				if(!data.is_pasienbaru){
					$("#<?php echo CHtml::activeId($model,"duedata_kacamata_date");?>").attr("style","display:none;");
					$("#<?php echo CHtml::activeId($model,"duedata_kacamata");?>").attr("readonly",true);
					$("#<?php echo CHtml::activeId($model,"duedata_kacamata");?>").val(data.duedate);
					$("#<?php echo CHtml::activeId($model,"tglgantikacamata");?>").val(data.tglganti);
				}else{
					$("#<?php echo CHtml::activeId($model,"duedata_kacamata_date");?>").attr("style","display:block;");
					$("#<?php echo CHtml::activeId($model,"duedata_kacamata");?>").attr("readonly",false);
					if(data.tglganti){
						$("#<?php echo CHtml::activeId($model,"tglgantikacamata");?>").val(data.tglganti);
					}else{
						$("#<?php echo CHtml::activeId($model,"tglgantikacamata");?>").val('');
					}
				} 
                                cekDisabled($('#gantikacamata-t-form'));
			$("#<?php echo CHtml::activeId($model,"duedata_kacamata");?>").removeClass('animation-loading-1');
			$("#<?php echo CHtml::activeId($model,"tglgantikacamata");?>").removeClass('animation-loading-1');
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}else{
		myAlert('Field Pergantian dan Data Pegawai diisi terlebih dahulu!');
		setPegawaiBaru();
		$("#<?php echo CHtml::activeId($model,"duedata_kacamata");?>").removeClass('animation-loading-1');
		$("#<?php echo CHtml::activeId($model,"tglgantikacamata");?>").removeClass('animation-loading-1');
	}
}

function setJumlahHarga(){
	var jmlharga = 0;
	var statushubungan = $("#<?php echo CHtml::activeId($model,"statushubungan");?>").val();
	if(statushubungan == 'Pekerja'){ // value 'Pekerja' diambil dari lookup_m
		jmlharga = 2000000;
	}else{
		jmlharga = 1800000;
	}
	$("#<?php echo CHtml::activeId($model,"jumlahharga_km");?>").val(formatInteger(jmlharga));
}

function print(){
    window.open('<?php echo $this->createUrl('print'); ?>&id=<?php echo $model->gantikacamata_id; ?>','printwin','left=100,top=100,width=1000,height=640');
}

$( document ).ready(function(){
	 cekDisabled($('#gantikacamata-t-form'));
});
</script>