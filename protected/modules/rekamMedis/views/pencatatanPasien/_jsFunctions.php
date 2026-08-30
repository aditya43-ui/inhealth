<?php $konfig = KonfigsystemK::model()->find(); ?>

<script type="text/javascript">
/**
 * set pasien lama
 * @param {type} pasien_id
 * @returns {undefined}
 */
var otoval = 1; // untuk hitung rekam medik

function validasiInput() {
    if (requiredCheck($("form"))) {
        if ($("#no_rekam_medik_baru").val().trim() == "") {
            myAlert("No. Rekam Medik harus diisi");
        }
        //return $("#pasien-m-form").submit();
    } else {
        //console.log("kick2");
        return false;
    }
}

function cekRMPasien(obj) {
    var no_rm = $(obj).val();
    
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('cekRMPasien'); ?>',
        data: { no_rm, no_rm },
        dataType: "json",
        success:function(data){
            if (data.ada == 1) {
                myAlert("Nomor Rekam Medik yang Anda Input sudah dipakai atas nama : " + 
                        data.pasien.namadepan + data.pasien.nama_pasien);
                $(obj).val("");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * set input radio button jenis kelamin 
 * @param {type} jk
 * @returns {undefined}
 */
function setJenisKelaminPasien(jk){
    $('input[name$="[jeniskelamin]"][type="radio"]').each(function(){
        if($(this).val() == $.trim(jk)){
            $(this).attr('checked',true);
        }
    });
}
/**
 * set input radio button rhesus
 * @param {type} rh
 * @returns {undefined}
 */
function setRhesusPasien(rh){
    $('input[name*="[rhesus]"]').each(function(){
        if(this.value == $.trim(rh))
            $(this).attr('checked',true);
    });
}
/**
 * set propinsi, kabupaten, kecamatan, dan kelurahan
 * @param {type} propinsi_id
 * @param {type} kabupaten_id
 * @param {type} kecamatan_id
 * @param {type} kalurahan_id
 * @returns {undefined}
 */
function setDaerahPasien(propinsi_id,kabupaten_id,kecamatan_id,kelurahan_id){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetDropdownDaerahPasien'); ?>',
        data: { propinsi_id: propinsi_id, kabupaten_id: kabupaten_id, kecamatan_id: kecamatan_id, kelurahan_id: kelurahan_id },
        dataType: "json",
        success:function(data){
            $("#<?php echo CHtml::activeId($modPasien,"propinsi_id");?>").html(data.listPropinsi);
            $("#<?php echo CHtml::activeId($modPasien,"kabupaten_id");?>").html(data.listKabupaten);
            $("#<?php echo CHtml::activeId($modPasien,"kecamatan_id");?>").html(data.listKecamatan);
            $("#<?php echo CHtml::activeId($modPasien,"kelurahan_id");?>").html(data.listKelurahan);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
 * set nama depan berdasarkan umur, jenis kelamin dan status perkawinan
 *
 * @returns {undefined} */
function setNamaDepan(){
    
    var statusperkawinan = $('#PPPasienM_statusperkawinan').val();
    var namadepan = $('#PPPasienM_namadepan');
    var umur = $("#<?php echo CHtml::activeId($model,'umur');?>").val().substr(0,2);
    umur = parseInt(umur);
    
    console.log(umur);

    if(umur <= 5){
        var namadepan = $('#PPPasienM_namadepan').val('By. ');
        if(statusperkawinan.length > 0 && statusperkawinan != "DIBAWAH UMUR"){
            $('#PPPasienM_statusperkawinan').val('');
            alert('Maaf status perkawinan belum cukup usia');
        }
    }else if(umur <= 14){ //
        var namadepan = $('#PPPasienM_namadepan').val('An. ');
        if(statusperkawinan.length > 0 && statusperkawinan != "DIBAWAH UMUR"){
            $('#PPPasienM_statusperkawinan').val('');
            alert('Maaf status perkawinan belum cukup usia');
        }
    }else{;
        if($('#PPPasienM_jeniskelamin_0').is(':checked')){
            if(statusperkawinan !== 'JANDA'){
                var namadepan = $('#PPPasienM_namadepan').val('Tn. ');
            }else{
                alert('Pilih status pernikahan yang sesuai!');
                $('#PPPasienM_statusperkawinan').val('KAWIN');
                var namadepan = $('#PPPasienM_namadepan').val('Tn. ')
            }

        }

        if($('#PPPasienM_jeniskelamin_1').is(':checked')){
        $('#PPPasienM_namadepan').val('Nn. ');
            if(statusperkawinan !== 'DUDA'){
             var namadepan = $('#PPPasienM_namadepan').val('Nn. ');
                if(statusperkawinan === 'KAWIN' || statusperkawinan == 'JANDA' || statusperkawinan == 'NIKAH SIRIH' || statusperkawinan == 'POLIGAMI'){
                    var namadepan = $('#PPPasienM_namadepan').val('Ny. ');
                }else{
                    var namadepan = $('#PPPasienM_namadepan').val('Nn. ');
                }
            }else{
                alert('Pilih status pernikahan yang sesuai!');
                $('#PPPasienM_statusperkawinan').val('KAWIN');
                var namadepan = $('#PPPasienM_namadepan').val('Ny. ');
            }
        }

        if (statusperkawinan == "DIBAWAH UMUR"){
            alert('Pilih status pernikahan yang sesuai!');
            $('#PPPasienM_statusperkawinan').val('BELUM KAWIN');
        }
    }
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
           $("#<?php echo CHtml::activeId($modPasien,"tanggal_lahir");?>").val(data.tanggal_lahir);
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
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
           $("#<?php echo CHtml::activeId($model,"umur");?>").val(data.umur);
           setNamaDepan();
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
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
/**
 * set dropdown dokter ruangan
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
           $("#<?php echo CHtml::activeId($model,"pegawai_id");?>").html(data.listDokter);
           cekPilihSatu($("#<?php echo CHtml::activeId($model,"pegawai_id");?>"));
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
 * set dropdown jeniskasuspenyakit_id
 * @param {type} ruangan_id
 * @returns {undefined} */
function setDropdownJeniskasuspenyakit(ruangan_id)
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetDropdownJeniskasuspenyakit'); ?>',
       data: {ruangan_id : ruangan_id},//
       dataType: "json",
       success:function(data){
           $("#<?php echo CHtml::activeId($model,"jeniskasuspenyakit_id");?>").html(data.listKasuspenyakit);
           cekPilihSatu($("#<?php echo CHtml::activeId($model,"jeniskasuspenyakit_id");?>"));
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
 * menambah data propinsi
 * @returns {Boolean} */
function addPropinsi()
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('/sistemAdministrator/PropinsiM/addPropinsi'); ?>',
       data: $(this).serialize(),
       dataType: "json",
       success:function(data){
            if (data.status == 'create_form')
            {
                $('#dialog-addpropinsi div.dialog-content').html(data.div);
                $('#dialog-addpropinsi div.dialog-content form').submit(addPropinsi);
            }
            else
            {
                $('#dialog-addpropinsi div.dialog-content').html(data.div);
                $('#PPPasienM_propinsi_id').html(data.propinsi);
                setTimeout("$('#dialog-addpropinsi').dialog('close')",1000);
            }
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    return false; 
}
/**
 * menambah data Kabupaten 
 * @returns {Boolean} */
function addKabupaten()
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('/sistemAdministrator/KabupatenM/addKabupaten'); ?>',
       data: $(this).serialize(),
       dataType: "json",
       success:function(data){
            if (data.status == 'create_form')
            {
                $('#dialog-addkabupaten div.dialog-content').html(data.div);
                $('#dialog-addkabupaten div.dialog-content form').submit(addKabupaten);
            }
            else
            {
                $('#dialog-addkabupaten div.dialog-content').html(data.div);
                $('#PPPasienM_kabupaten_id').html(data.kabupaten);
                setTimeout("$('#dialog-addkabupaten').dialog('close')",1000);
            }
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    
    return false; 
}
/**
 * Menambah data Kecamatan
 * @returns {Boolean} */
function addKecamatan()
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('/sistemAdministrator/KecamatanM/addKecamatan'); ?>',
       data: $(this).serialize(),
       dataType: "json",
       success:function(data){
            if (data.status == 'create_form')
            {
                $('#dialogAddKecamatan div.dialog-content').html(data.div);
                $('#dialogAddKecamatan div.dialog-content form').submit(addKecamatan);
            }
            else
            {
                $('#dialogAddKecamatan div.dialog-content').html(data.div);
                $('#PPPasienM_kecamatan_id').html(data.kecamatan);
                setTimeout("$('#dialogAddKecamatan').dialog('close')",1000);
            }
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    
    return false; 
}

function addKelurahan()
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('/sistemAdministrator/KelurahanM/addKelurahan'); ?>',
       data: $(this).serialize(),
       dataType: "json",
       success:function(data){
            if (data.status == 'create_form')
            {
                $('#dialog-addkelurahan div.dialog-content').html(data.div);
                $('#dialog-addkelurahan div.dialog-content form').submit(addKelurahan);
            }
            else
            {
                $('#dialog-addkelurahan div.dialog-content').html(data.div);
                $('#PPPasienM_kelurahan_id').html(data.kelurahan);
                setTimeout("$('#dialog-addkelurahan').dialog('close')",1000);
            }
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    
    return false; 
}

/**
* tombol batal pada dialogbox
* @param {type} dialog_id
* @returns {undefined} 
*/
function batalDialog(dialog_id){
   if(confirm("Apakah Anda yakin akan membatalkan ini ?")) 
       $('#'+dialog_id).dialog("close");
}
/**
 * print kartu pasien
 */
function printKartuPasien(id)
{       
    window.open('<?php echo $this->createUrl('/pendaftaranPenjadwalan/PendaftaranRawatJalan/printKartuPasien'); ?>&pasien_id='+id,'printwin','left=100,top=100,width=480,height=640');
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
            if(namaPekerjaan !== '13' && namaPekerjaan != '10'){
                if(namaPekerjaan !== ''){
                    alert('Pasien masih di bawah umur,silakan cek kembali!');
                }
                $(obj).val('');
            }else{
                $(obj).val(namaPekerjaan);
            }
        }else{
            if(namaPekerjaan === '12'){
                if(namaDepan === 'Ny. '){
                    $(obj).val('9');
                }else if(namaDepan === 'Nn. ' && namaPekerjaan === '9'){
                    alert('Pasien belum menikah,silakan cek kembali!');
                    $(obj).val('');
                }else{
                    $(obj).val('');
                }
                alert('Pilih pekerjaan yang tepat');
            }else{
                if(namaPekerjaan === '9'){
                    if(namaDepan !== 'Ny. '){
                      if ($("#PPPasienM_jeniskelamin_0").is(":checked")) alert ("Silakan Cek Kembali Jenis Kelamin Yang Dipilih!");
                      else alert('Silakan Cek Kembali Status Perkawinan Anda!');
                      $(obj).val('');
                    }
                }
            }
        }
/*
        if(namaPekerjaan === '12' && umur < 17)
        {
            if(namaDepan !== 'BY. Ny.' && namaDepan !== 'An.' && namaDepan !== 'Nn')
            {
                alert('Pilih pekerjaan yang sesuai!');
                $(obj).val('');
            }
        }else{
            if(namaDepan === 'BY. Ny.')
            {
                alert('Pilih pekerjaan yang sesuai!');
                $(obj).val('');
            }else{
                if(namaPekerjaan === '11' || namaPekerjaan === '10')
                {
                    if(namaDepan !== 'An.' && namaDepan !== 'Nn'){
                        alert('Pilih pekerjaan yang sesuai!');
                        $(obj).val('');
                    }
                }else{
                    if(namaPekerjaan !== '13' && namaPekerjaan !== '14')
                    {
                        if(namaPekerjaan === '9' && namaDepan !== 'Ny.')
                        {
                            alert('Pilih pekerjaan yang sesuai!');
                            $(obj).val('');
                        }else{
                            if((namaDepan === 'An.' || namaDepan === 'Nn') && umur < 25){
                                alert('Pilih pekerjaan yang sesuai!');
                                $(obj).val('');
                            }
                        }
                    }
                }
            }
        }
*/
    }else{
        $(obj).val('');
        alert('Pilih gelar kehormatan terlebih dahulu!');
    }

}

function cekPilihSatu(obj) {
    // console.log($(obj).find('option').length);
    
    if ($(obj).find('option').length == 2) {
        $(obj).val($(obj).find('option').eq(1).val());
        $(obj).change();
    }
}

/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function() {
    setUmur($("#<?php echo CHtml::activeId($modPasien, 'tanggal_lahir') ;?>").val());
});

</script>
    