<script type="text/javascript">
/**
 * set form kunjungan
 * @param {type} intraanestesi_id, praanestesi_id, pasienanastesi_id
 * @returns {undefined}
 */
function setKunjungan(intraanestesi_id,praanestesi_id,pasienanastesi_id){
    $("#form-datakunjungan > div").addClass("animation-loading"); 
    <?php $modPascaAnestesi = new ATPascaanestesiT(); ?>
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataKunjungan'); ?>',
        data: {intraanestesi_id:intraanestesi_id,praanestesi_id:praanestesi_id,pasienanastesi_id:pasienanastesi_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
                setKunjunganReset();
            }else{
//                $("#<?php // echo CHtml::activeId($modKunjungan,'pasienanastesi_id'); ?>").val(data.pasienanastesi_id);
//                $("#<?php // echo CHtml::activeId($modKunjungan,'intraanestesi_id'); ?>").val(data.intraanestesi_id);
                $("#<?php echo CHtml::activeId($modPascaAnestesi,'intraanestesi_id'); ?>").val(data.intraanestesi_id); 
                $("#<?php echo CHtml::activeId($modPascaAnestesi,'pasienanastesi_id'); ?>").val(data.pasienanastesi_id);
                $("#<?php echo CHtml::activeId($modKunjungan,'pasien_id'); ?>").val(data.pasien_id);
                $("#<?php echo CHtml::activeId($modKunjungan,'praanestesi_id'); ?>").val(data.praanestesi_id);
                $("#<?php echo CHtml::activeId($modKunjungan,'nointraanestesi'); ?>").val(data.nointraanestesi);
                $("#<?php echo CHtml::activeId($modKunjungan,'tglintraanestesi'); ?>").val(data.tglintraanestesi);
                $("#<?php echo CHtml::activeId($modKunjungan,'umur'); ?>").val(data.umur);
                $("#<?php echo CHtml::activeId($modKunjungan,'jeniskasuspenyakit_id'); ?>").val(data.jeniskasuspenyakit_id);
                $("#<?php echo CHtml::activeId($modKunjungan,'jeniskasuspenyakit_nama'); ?>").val(data.jeniskasuspenyakit_nama);
                $("#<?php echo CHtml::activeId($modKunjungan,'pegawai_id'); ?>").val(data.pegawai_id);
                $("#<?php echo CHtml::activeId($modKunjungan,'nama_pegawai'); ?>").val(data.nama_pegawai);
                $("#<?php echo CHtml::activeId($modKunjungan,'no_rekam_medik'); ?>").val(data.no_rekam_medik);
                $("#<?php echo CHtml::activeId($modKunjungan,'nama_pasien'); ?>").val(data.nama_pasien);
                $("#<?php echo CHtml::activeId($modKunjungan,'jeniskelamin'); ?>").val(data.jeniskelamin);
                $("#<?php echo CHtml::activeId($modKunjungan,'pekerjaan_id'); ?>").val(data.pekerjaan_id);
                $("#<?php echo CHtml::activeId($modKunjungan,'pekerjaan_nama'); ?>").val(data.pekerjaan_nama);
                $("#<?php echo CHtml::activeId($modKunjungan,'kelaspelayanan_id'); ?>").val(data.kelaspelayanan_id);
                $("#<?php echo CHtml::activeId($modKunjungan,'kelaspelayanan_nama'); ?>").val(data.kelaspelayanan_nama);
                $("#<?php echo CHtml::activeId($modKunjungan,'alamat_pasien'); ?>").val(data.alamat_pasien);
				
                if(data.photopasien === null || data.photopasien === "" || data.photopasien === undefined){ //set photo
                    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
                }else{
                    $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
                }
				if(data.nointraanestesi == '' || data.nointraanestesi == null){
					var nointraanestesi = data.nointraanestesi;
				}else{
					var nointraanestesi = data.no_rekam_medik;
				}
//				loadDataPraAnestesi(praanestesi_id);	
				loadDataKondisiPasien(data.intraanestesi_id);
				SetRuanganPasien(data.ruanganpasca_id, data.kamarruangan_id);				
				
                $("#form-datakunjungan > legend > .judul").html('Data Pasien '+nointraanestesi);
                $("#form-datakunjungan > legend > .tombol").attr('style','display:true;');
                $("#form-datakunjungan > .box").addClass("well").removeClass("box");				
            }
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#<?php echo CHtml::activeId($modKunjungan,'nointraanestesi'); ?>").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data kunjungan tidak ditemukan !"); 
            console.log(errorThrown);
            setKunjunganReset();
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#<?php echo CHtml::activeId($modKunjungan,'nointraanestesi'); ?>").focus();
        }
    });

}
/**
 * untuk mereset form kunjungan
 * @returns {undefined} */
function setKunjunganReset(){
    $("#form-datakunjungan input,textarea").each(function(){
        $(this).val("");
    });
    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
    $("#form-datakunjungan > legend > .judul").html('Data Pasien');
    $("#form-datakunjungan > legend > .tombol").attr('style','display:none;');
    $("#form-datakunjungan > .well").addClass("box").removeClass("well");
}

/*
 * load data
 * @returns {undefined}
 */
function loadDataPraAnestesi(praanestesi_id){
	$("#form-datarencana > div").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataPraAnestesi'); ?>',
        data: {praanestesi_id:praanestesi_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
                setKunjunganReset();
            }else{
                $("#<?php echo CHtml::activeId($modPascaAnestesi,'pasienanastesi_id'); ?>").val(data.pasienanastesi_id);
                $("#<?php echo CHtml::activeId($modPascaAnestesi,'praanestesi_id'); ?>").val(data.praanestesi_id);
                $("#<?php echo CHtml::activeId($modPraAnestesi,'praanestesi_id'); ?>").val(data.praanestesi_id);
                $("#<?php echo CHtml::activeId($modPraAnestesi,'tglpraanestesi'); ?>").val(data.tglpraanestesi);
                $("#<?php echo CHtml::activeId($modPraAnestesi,'dokter_id'); ?>").val(data.dokter_id);
                $("#<?php echo CHtml::activeId($modPraAnestesi,'perawat1_id'); ?>").val(data.perawat1_id);
                $("#<?php echo CHtml::activeId($modPraAnestesi,'perawat2_id'); ?>").val(data.perawat2_id);
				
				SetRuanganPasien(data.ruanganpasca_id, data.kamarruangan_id);				
            }
            $("#form-datarencana > div").removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data Pra Anestesi tidak ditemukan !"); 
            console.log(errorThrown);
            $("#form-datarencana > div").removeClass("animation-loading");
        }
    });
}

/**
* set ruangan, kamar ruangan
* @param {type} ruangan_id
* @param {type} kamarruangan_id
* @returns {undefined}
*/
function SetRuanganPasien(ruanganpasca_id, kamarruangan_id) {
   $.ajax({
	   type: 'POST',
	   url: '<?php echo $this->createUrl('SetDropDownKamarRuangan'); ?>',
	   data: {ruanganpasca_id:ruanganpasca_id, kamarruangan_id:kamarruangan_id},
	   dataType: "json",
	   success: function (data) {
		   $("#<?php echo CHtml::activeId($modPascaAnestesi, "ruanganpasca_id"); ?>").html(data.listRuangan);
		   $("#<?php echo CHtml::activeId($modPascaAnestesi, "kamarruangan_id"); ?>").html(data.listKamarruangan);
	   },
	   error: function (jqXHR, textStatus, errorThrown) {
		   console.log(errorThrown);
	   }
   });
}
	
function loadDataKondisiPasien(intraanestesi_id){
	$("#table-pemantauan-kondisi-pasien > div").addClass("animation-loading");
	var form_index = $('#form_index').val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetDataKondisiPasienAnestesi'); ?>',
        data: {intraanestesi_id:intraanestesi_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
            }else{
                $('#table-pemantauan-kondisi-pasien > tbody').html(data.form);
				$("#table-pemantauan-kondisi-pasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
					{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
				);
				renameInputRowPemantauan($("#table-tindakan")); 
            }
            $("#table-pemantauan-kondisi-pasien > div").removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data Pemantauan Kondisi Pasien tidak ditemukan !"); 
            console.log(errorThrown);
            $("#table-pemantauan-kondisi-pasien > div").removeClass("animation-loading");
        }
    });
}

/**
 * javascript untuk tambah dan hapus baris pemantauan kondisi pasien
 */
// the subviews rendered with placeholders
var trTindakan = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowPemantauanKondisi',array('modKondisiPasienAnestesi'=>$modKondisiPasienAnestesi,'removeButton'=>true),true));?>);
var trTindakanFirst = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowPemantauanKondisi',array('modKondisiPasienAnestesi'=>$modKondisiPasienAnestesi,'removeButton'=>false),true));?>);

function addRowPemantauan(obj)
{
    var tanggal = $('#ATKondisipasienanestesiT_0_tglpemantauan').val();
    var jam_mulai = $('#ATKondisipasienanestesiT_0_jammulai').val();
    var jam_selesai = $('#ATKondisipasienanestesiT_0_jamselesai').val();
        if(tanggal < 1 || jam_mulai < 1 || jam_selesai < 1){
                myAlert('Silahkan isi terlebih dahulu baris pertama');
                
            return false;
        }else{
//            addRowPemantauan();

    $(obj).parents('table').children('tbody').append(trTindakan.replace());
	renameInputRowPemantauan($("#table-pemantauan-kondisi-pasien"));
    $('#table-pemantauan-kondisi-pasien tbody').each(function(){
        jQuery('input[name$="[tglpemantauan]"]').datepicker(
            jQuery.extend(
                {
                    showMonthAfterYear:false
                }, 
                jQuery.datepicker.regional['id'],
                {
                    'dateFormat':'dd M yy',
                    'showSecond':false,
                    'timeOnlyTitle':'Pilih Waktu',
                    'timeFormat':'hh:mm:ss',
                    'changeYear':true,
                    'changeMonth':true,
                    'showAnim':'fold',
                    'yearRange':'-80y:+20y',
                }
            )
        );

		jQuery('input[name$="[jammulai]"]').timepicker(
            jQuery.extend(
                {
                    showMonthAfterYear:false
                }, 
                jQuery.datepicker.regional['id'],
                {
                    'dateFormat':'dd M yy',
                    'timeText':'Waktu',
                    'hourText':'Jam',
                    'minuteText':'Menit',
                    'secondText':'Detik',
                    'showSecond':true,
                    'timeOnlyTitle':'Pilih Waktu',
                    'timeFormat':'hh:mm:ss',
                    'changeYear':true,
                    'changeMonth':true,
                    'showAnim':'fold',
                    'yearRange':'-80y:+20y'
                }
            )
        );

		jQuery('input[name$="[jamselesai]"]').timepicker(
            jQuery.extend(
                {
                    showMonthAfterYear:false
                }, 
                jQuery.datepicker.regional['id'],
                {
                    'dateFormat':'dd M yy',
                    'timeText':'Waktu',
                    'hourText':'Jam',
                    'minuteText':'Menit',
                    'secondText':'Detik',
                    'showSecond':true,
                    'timeOnlyTitle':'Pilih Waktu',
                    'timeFormat':'hh:mm:ss',
                    'changeYear':true,
                    'changeMonth':true,
                    'showAnim':'fold',
                    'yearRange':'-80y:+20y'
                }
            )
        );
    });  
            }
    return false;  
}

function batalPemantauan(obj)
{
    myConfirm("Apakah anda yakin akan membatalkan pemantauan kondisi ini?","Perhatian!",function(r) {
        if(r){
            $(obj).parents('tr').next('tr').detach();
            $(obj).parents('tr').detach();
			renameInputRowPemantauan($("#table-pemantauan-kondisi-pasien"));
        }
    });
}

function renameInputRowPemantauan(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
		$(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 4){
                $(this).attr("id",old_name_arr[0]+"_"+old_name_arr[1]+"_"+row+"_"+old_name_arr[3]);
                $(this).attr("name",old_name_arr[0]+"["+old_name_arr[1]+"]["+row+"]["+old_name_arr[3]+"]");
            }
        });
        row++;
    });
}

/**
* untuk print pasca anestesia
 */
function printHasil(caraPrint)
{
	var caraPrint = 'PRINT';
    var pascaanestesi_id = '<?php echo isset($modPascaAnestesi->pascaanestesi_id) ? $modPascaAnestesi->pascaanestesi_id : null; ?>';
    window.open('<?php echo $this->createUrl('printHasil'); ?>&pascaanestesi_id='+pascaanestesi_id+'&caraprint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
	<?php if(!empty($modPascaAnestesi->pascaanestesi_id)){ ?>
			var intraanestesi_id = '<?php echo isset($modPascaAnestesi->intraanestesi_id) ? $modPascaAnestesi->intraanestesi_id : null; ?>';
			var pasienanastesi_id = '<?php echo isset($modPascaAnestesi->pasienanastesi_id) ? $modPascaAnestesi->pasienanastesi_id : null; ?>';
			var praanestesi_id = '<?php echo isset($modPascaAnestesi->intraanestesi->praanestesi_id) ? $modPascaAnestesi->intraanestesi->praanestesi_id : null; ?>';
			setKunjungan(intraanestesi_id,praanestesi_id,pasienanastesi_id)
			
			$("#form-datakunjungan :input").removeAttr("readonly",true);
			$("#form-datakunjungan .add-on").remove();
			$("#form-datakunjungan .icon-remove").remove();        

			$("#form-datakunjungan :input").attr("readonly",true);
			$("#form-datakunjungan .dtPicker3").attr("readonly",true);
			$("#form-datakunjungan .add-on").remove();
			$("#form-datakunjungan .btn-mini").remove();
			$("#form-datakunjungan .btn-danger").remove();
	<?php } ?>
		
	<?php if(!empty($modKunjungan->pasienanastesi_id)){ ?>
			var intraanestesi_id = '<?php echo isset($modPascaAnestesi->intraanestesi_id) ? $modPascaAnestesi->intraanestesi_id : ''; ?>';
			var pasienanastesi_id = '<?php echo isset($modPascaAnestesi->pasienanastesi_id) ? $modPascaAnestesi->pasienanastesi_id : ''; ?>';
			var praanestesi_id = '<?php echo isset($modPraAnestesi->praanestesi_id) ? $modPraAnestesi->praanestesi_id : ''; ?>';
			setKunjungan(intraanestesi_id,praanestesi_id,pasienanastesi_id)
			
			$("#form-datakunjungan :input").removeAttr("readonly",true);
			$("#form-datakunjungan .add-on").remove();
			$("#form-datakunjungan .icon-remove").remove();        

			$("#form-datakunjungan :input").attr("readonly",true);
			$("#form-datakunjungan .dtPicker3").attr("readonly",true);
			$("#form-datakunjungan .add-on").remove();
			$("#form-datakunjungan .btn-mini").remove();
			$("#form-datakunjungan .btn-danger").remove();
	<?php } ?> 
            
            $('form').bind('click keyup select change', function(event) {
                cekDisabled(this);
            });
            $(document).on('click keyup select change',function(){
                cekDisabled('form');
            }); 
            cekDisabled('form');
});

//function validasiCek(){
//        var pemantauan = $('#ATKondisipasienanestesiT_0_menitke').val();
//        if(pemantauan = null){
//                myAlert('lalala');
//                
//            return false;
//        }else{
//            addRowPemantauan();
//        }
//    return false;    
//}
</script>