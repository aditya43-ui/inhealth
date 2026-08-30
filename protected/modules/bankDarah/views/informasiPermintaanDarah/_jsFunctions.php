<script>
 function tambahKantong() {
     stokkantongdarah_id = $('#stokkantongdarah_id').val();
    
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('getKantong'); ?>',
        data: {stokkantongdarah_id:stokkantongdarah_id},
        dataType: "json",
        success:function(data){
            $('#table-detailbarang > tbody').append(data);
            $('#table-detailbarang').removeClass("animation-loading");
            renameInputRowBarang($("#table-detailbarang"));
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    }
    
    function inputKantong(){
     stokkantongdarah_id = $('#stokkantongdarah_id').val();
	if (!jQuery.isNumeric(stokkantongdarah_id)){
		myAlert('Isi Kantong yang akan dipesan');
		return false;
	}
	else{
		$('#table-detailbarang').addClass("animation-loading");
		cekList(stokkantongdarah_id);
	}        
    }
    
    function cekList(id){
	x = true;
	$('.kantongdarah').each(function(){
		if ($(this).val() == id){
			myAlert('Kantong telah ada d List');
			x = false;
                        $('#table-detailbarang').removeClass("animation-loading");    
		}else{

		}
	});

	if(x==true){
                    tambahKantong();
	return x;
        }
    }   
    function renameInputRowBarang(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
            }
        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
        });
        row++;
    });
    }
    
    function batal(obj){
	if(!confirm('Apakah Anda akan membatalkan data ini ?')) {
	return false;
	}else{
	$(obj).parents('tr').remove();
	rename();
	}
    }    
    
    function getDataPermintaan(permintaandarah_id) {
        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('getDataPermintaan'); ?>',
            data:{permintaandarah_id:permintaandarah_id},
            dataType:"json",
            success:function(data) {
                $('#tgl_pendaftaran').val(data.tgl_pendaftaran);
                $('#no_pendaftaran').val(data.no_pendaftaran);
                $('#umur').val(data.umur);
                $('#alamat_pasien').val(data.alamat_pasien);
                $('#nama-pasien').val(data.nama_pasien);
                $('#tgl_lahir').val(data.tanggal_lahir);
                $('#no_rekam_medik').val(data.no_rekam_medik);
                $('#jenis_kelamin').val(data.jeniskelamin);
                $('#gol_darah').val(data.gol_darah);
                $('#BDUjidarahpasienT_pasien_id').val(data.pasien_id);
                $('#BDUjidarahpasienT_pendaftaran_id').val(data.pendaftaran_id);
                $('#BDUjidarahpasienT_permintaandarah_id').val(data.permintaandarah_id);
                $('#ruangan_nama').val(data.ruangan_nama);
                $('#kelas_pelayanan').val(data.kelaspelayanan_nama);
                $('#penjamin').val(data.penjamin_nama);
                $('#Dokter').val(data.nama_pegawai);
                $('#tgl_pengujian').val(data.tgl_pengujian); 
                $('#anti_a').val(data.anti_a);
                $('#anti_b').val(data.anti_b);
                $('#anti_d').val(data.anti_d);
                $('#kesimpulan').val(data.kesimpulan);

            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}

        })
    }

    function setRuangan(obj) {
        var instalasi_id = $(obj).val();

        $.post('<?=  $this->createUrl('setRuangan') ?>', 
        {
            instalasi_id:instalasi_id
        }, function(data) {
            $('#BDPasienKirimKeUnitLainT_ruangan_id').html('');
            $('#BDPasienKirimKeUnitLainT_ruangan_id').html(data.list);
        }, 'json');
    }
</script>
