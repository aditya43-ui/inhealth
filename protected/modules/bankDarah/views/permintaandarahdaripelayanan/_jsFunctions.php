<script type="text/javascript">

    function cekPenyiapanDarah(pasienkirimkeunitlain_id) { 
        $.post('<?= $this->createUrl('cekPenyiapanDarah') ?>', {
            pasienkirimkeunitlain_id:pasienkirimkeunitlain_id
        }, function(data){
            if(data.status < 1) {
                window.parent.myAlert('Darah belum disiapkan');
                return false;
            } else {
                $('#dialogTerimaDarah').dialog('open');
                url = "<?= $this->createUrl('terimaDarah&pasienkirimkeunitlain_id=') ?>" + pasienkirimkeunitlain_id;
                $('#iframeTerimaDarah').attr('src', url);
            }
        }, 'json');
    }
    
    function openDialog(pasienkirimkeunitlain_id) { 
        $.post('<?= $this->createUrl('cekPenyiapanDarah') ?>', {
            pasienkirimkeunitlain_id:pasienkirimkeunitlain_id
        }, function(data){
            if(data.status < 1) {
                window.parent.myAlert('Darah belum disiapkan');
                return false;
            } else {
                $('#dialogReaksiTransfusi').dialog('open');
                url = "<?= $this->createUrl('reaksiTransfusi&pasienkirimkeunitlain_id=') ?>" + pasienkirimkeunitlain_id;
                $('#iframeReaksiTransfusi').attr('src', url);
            }
        }, 'json');
        
    }

    

    function showTanggal(obj) {
        transfusisebelumnya = $(obj).val();
        if(transfusisebelumnya == 'Ya') {
            $('.tgl_transfusisebelumnya').show()
        } else {
            $('.tgl_transfusisebelumnya').hide()
        }
        console.log(transfusisebelumnya)
    }
    function tambahDetail() {
        jeniskomponendarah_id = $('#jeniskomponendarah_id').val();
        gol_darah_detail = $('#gol_darah_detail').val();
        jumlahkantong_detail = $('#jumlahkantong_detail').val();
        indikasi_detail = $('#indikasi_detail').val();
        kadarhb = $('#kadarhb').val();
        plt = $('#plt').val();
        jenis_volume = $('#jenis_volume').val();
        diambil = $('#diambil').val();
        jenis_volume_diambil = $('#jenis_volume_diambil').val();
        dititip = $('#dititip').val();
        jenis_volume_dititip = $('#jenis_volume_dititip').val();
        jenispermintaan = '';
        pasienkirimkeunitlain_id = '<?php echo isset($_GET['pasienkirimkeunitlain_id']) ? $_GET['pasienkirimkeunitlain_id'] : ''?>';
        if($('#BDPermintaandarahT_jenispermintaan_0').prop('checked') == true) {
                jenispermintaan = $('#BDPermintaandarahT_jenispermintaan_0').val();         
        }
        if($('#BDPermintaandarahT_jenispermintaan_1').prop('checked') == true) {
            jenispermintaan = $('#BDPermintaandarahT_jenispermintaan_1').val();         
        }
        if($('#BDPermintaandarahT_jenispermintaan_2').prop('checked') == true) {
            jenispermintaan = $('#BDPermintaandarahT_jenispermintaan_2').val();         
        }

        <?php if(!empty($_GET['pendaftaran_id'])) { ?>
            pendaftaran_id = $('#BDPermintaandarahT_pendaftaran_id').val();
            pasien_id = $('#BDPermintaandarahT_pasien_id').val();
        <?php } else { ?>
            pendaftaran_id = $('#pendaftaran_id').val();
            pasien_id = $('#pasien_id').val();
        <?php } ?>
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('getPermintaanDarahDetail'); ?>',
            data: {
                jeniskomponendarah_id:jeniskomponendarah_id,
                gol_darah_detail:gol_darah_detail,
                jumlahkantong_detail:jumlahkantong_detail,
                indikasi_detail:indikasi_detail,
                pendaftaran_id:pendaftaran_id,
                pasien_id:pasien_id,
                kadarhb:kadarhb,
                plt:plt,
                jenis_volume:jenis_volume,
                diambil:diambil,
                dititip:dititip,
                jenispermintaan:jenispermintaan,
                pasienkirimkeunitlain_id:pasienkirimkeunitlain_id,
                jenis_volume_diambil:jenis_volume_diambil,
                jenis_volume_dititip:jenis_volume_dititip,
            },
            dataType: "json",
            success:function(data){
                console.log(data.sukses)
                console.log(data.sukses == '1')
                if(data.sukses === 1 ) {
                    $('#table-detailbarang > tbody').append(data.tr);
                    $('#table-detailbarang').removeClass("animation-loading");
                    renameInputRowBarang($("#table-detailbarang"));                        
                    
                    $("#<?php echo CHtml::activeId($modPermintaanDarah, 'no_formulir') ?>").keyup();                               
                } else {
                    myAlert('Gagal Tambah Ke Tabel');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { myAlert(errorThrown);}
        });
    }
    
    function inputDetail(obj){
     var jeniskomponendarah_id = $('#jeniskomponendarah_id').val();
     var  gol_darah_detail = $('#gol_darah_detail').val();
     var jumlahkantong_detail = $('#jumlahkantong_detail').val();
     var indikasi_detail = $('#indikasi_detail').val();
     var pendaftaran_id = $('#BDPermintaandarahT_pendaftaran_id').val();
    
     var tolak = 0;
   
     $('#table-detailbarang').find("tbody > tr").each(function(){
        var tipepaket = $(this).find('.jeniskomponendarah_id').val();
        if(tipepaket == jeniskomponendarah_id) {
            tolak +=1;
        }
     });


	if(jeniskomponendarah_id == '') {
        myAlert('Isi Form Jenis/Komponen Darah');
		return false;
    }else if(!jQuery.isNumeric(jumlahkantong_detail)) {
        myAlert('Isi Form Jumlah Kantong');
        return false;
    }else if(indikasi_detail == ''){
        myAlert('Isi Form Indikasi');
        return false;
    }else if(pendaftaran_id == '') {
        myAlert('Isi Data Pasien Terlebih Dahulu');
        return false;
    } else if(tolak > 0) {
        myAlert('Sudah Terdapat Pada Tabel');
        return false;
    }else {
        var status=0;   
        if($('#BDPermintaandarahT_jenispermintaan_0').prop('checked') == false) {
            status+=1;         
        }
        if($('#BDPermintaandarahT_jenispermintaan_1').prop('checked') == false) {
            status+=1;         
        }
        if($('#BDPermintaandarahT_jenispermintaan_2').prop('checked') == false) {
            status+=1;         
        }
        
        if(status!=2){
            myConfirm("Jenis Permintaan Belum Terisi,Lanjutkan Tambah?","Perhatian!",function(r){
                if(r){ 
                    $('#table-detailbarang').addClass("animation-loading");
                    tambahDetail();
                    
                }else{
                    return false;
                }
            });
            }else{
                $('#table-detailbarang').addClass("animation-loading");
                    tambahDetail();
            }
          
           
        }
		
	}        
    
      
    function renameInputRowBarang(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span').each(function(){ //element <input>
            if (typeof $(this).attr("name") !== 'undefined'){
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
                }
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
	if(!confirm('Apakah anda akan Membatalkan data ini ?')) {
	return false;
	}else{
	$(obj).parents('tr').remove();
	rename();
	}
    } 
    
    function hapus(obj, permintaandarahdet_id){
        myConfirm("Apakah anda yakin akan menghapus data ini dari database?", "Perhatian!",
        function (r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('Deletedet'); ?>&id=' + permintaandarahdet_id,
                    data: {id: permintaandarahdet_id}, //
                    dataType: "json",
                    success: function (data) {
                        if (data.sukses == 1) {
                            $(obj).parents('tr').detach();
                            renameInputRowBarang($("#table-detailbarang"));  
                        }
                        myAlert(data.pesan);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        myAlert("Data tidak dapat dihapus karena sudah digunakan di transaksi lainnya.");
                    }
                });
            }
        });
    } 
    
      function cekGejala(obj) {
       var status = $(obj).val();
        
        if(status == 'Tidak Tahu'){
           $('#BDPermintaandarahT_gejala_transfusi').val(status);
	    }else{
            
        }
        
    }

    function setAlamat(pasien_id) {

        $.post("<?php echo $this->createUrl('GetAlamat')?>", {id: pasien_id},
            function(data){
                $('#alamat_pasien').val(data.alamat);
            }, "json");
    }
    
     $(document).ready(function(){
        <?php if (!empty($_GET['detail'])) { ?>
            $("#permintaanDarah-t-form").find("input, select, textarea").attr("disabled", true);
            $("#permintaanDarah-t-form").find(".add-on").hide();
            $('#btn_simpan').addClass('hide');
        <?php } ?> 
        $(".tidak").find('input:checkbox').click(function() {
           var cek_lis = $(this).prop('checked');
            $(".tidak").find('input:checkbox').each(function() {
            $(this).prop("checked",false);
            $('#BDPermintaandarahT_gejala_transfusi').val('');
            });
            if (cek_lis == true){
                $(this).prop("checked",true);   
                var status = 'Tidak Tahu';
                $('#BDPermintaandarahT_gejala_transfusi').val(status);
            }
            });

            <?php if(isset($_GET['update'])):?>
                tambahDetail();
            <?php endif;?>
        });
    
</script>