<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
/**
 * set form kunjungan
 * @param {type} pasien_id
 * @returns {undefined}
 */
function setKunjungan(pendaftaran_id){
    $("#form-datakunjungan > div").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataKunjungan'); ?>',
        data: {pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
                setKunjunganReset();
            }else{
                $("#pendaftaran_id").val(data.pendaftaran_id);
                $("#pasien_id").val(data.pasien_id);
                $("#jeniskasuspenyakit_id").val(data.jeniskasuspenyakit_id);
                $("#carabayar_id").val(data.carabayar_id);
                $("#penjamin_id").val(data.penjamin_id);
                $("#penanggungjawab_id").val(data.penanggungjawab_id);
                $("#instalasi_id").val(data.instalasi_id);
                $("#ruangan_id").val(data.ruangan_id);
                $("#kelaspelayanan_id").val(data.kelaspelayanan_id);
                $("#no_pendaftaran").val(data.no_pendaftaran);
                $("#no_pendaftaran").val(data.no_pendaftaran);
                $("#tgl_pendaftaran").val(data.tgl_pendaftaran);
                $("#instalasi_nama").val(data.instalasi_nama);
                $("#ruangan_nama").val(data.ruangan_nama);
                $("#jeniskasuspenyakit_nama").val(data.jeniskasuspenyakit_nama);
                $("#carabayar_nama").val(data.carabayar_nama);
                $("#penjamin_nama").val(data.penjamin_nama);
                $("#no_rekam_medik").val(data.no_rekam_medik);
                $("#namadepan").val(data.namadepan);
                $("#nama_pasien").val(data.nama_pasien);
                $("#nama_bin").val(data.nama_bin);
                $("#tanggal_lahir").val(data.tanggal_lahir);
                $("#umur").val(data.umur);
                $("#jeniskelamin").val(data.jeniskelamin);
                $("#nama_pj").val(data.nama_pj);
                $("#pengantar").val(data.pengantar);
                $("#kelaspelayanan_nama").val(data.kelaspelayanan_nama);
                $("#alamat_pasien").val(data.alamat_pasien);
                $("#pasienadmisi_id").val(data.pasienadmisi_id);
                $("#pasienmasukpenunjang_id").val(data.pasienmasukpenunjang_id);
                if(data.photopasien === null || data.photopasien === ""){ //set photo
                    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
                }else{
                    $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
                }
                
                setRiwayatObatAlkesPasien();

                $("#form-datakunjungan > legend > .judul").html('Data Kunjungan '+data.no_pendaftaran);
                $("#form-datakunjungan > legend > .tombol").attr('style','display:true;');
                $("#form-datakunjungan > .box").addClass("well").removeClass("box");
            }
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data kunjungan tidak ditemukan!"); 
            console.log(errorThrown);
            setKunjunganReset();
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
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
    $("#ruangan_id").val(<?php echo $modKunjungan->ruangan_id; ?>);
    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
    $("#form-datakunjungan > legend > .judul").html('Data Kunjungan');
    $("#form-datakunjungan > legend > .tombol").attr('style','display:none;');
    $("#form-datakunjungan > .well").addClass("box").removeClass("well");
        
    $('#tblpemakaianbahan').html(""); 
}

function setRiwayatObatAlkesPasien(){
    if($("#pendaftaran_id").val() != ''){
        $.fn.yiiGridView.update('riwayatbmhp-grid', {
            data: {
                "ObatalkespasienT[pendaftaran_id]":$("#pendaftaran_id").val(),
                "ObatalkespasienT[ruangan_id]":$("#ruangan_id").val(),
                "ObatalkespasienT[pasienadmisi_id]":"'"+$("#pasienadmisi_id").val()+"'"
                
            }
        });
    }
}

function hapusRiwayat(tipepaket_id,pendaftaran_id,pasienadmisi_id,ruangan_id)
{
    myConfirm("Apakah Anda akan menghapus pemakaian bahan pasien ini?","Perhatian!",function(r) {
        if(r){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('hapusRiwayatBMHP'); ?>',
                data: {tipepaket_id:tipepaket_id, pendaftaran_id:pendaftaran_id, pasienadmisi_id:pasienadmisi_id, ruangan_id:ruangan_id},
                dataType: "json",
                success:function(data){
                    if(data.sukses){
                        setRiwayatObatAlkesPasien();
                    }
                    myAlert(data.pesan);
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }
    });
}

function print()
{
    var pendaftaran_id = "<?php echo (!empty($_GET['pendaftaran_id'])? $_GET['pendaftaran_id']: "") ?>";
    var pasienadmisi_id = "<?php echo (!empty($_GET['pasienadmisi_id'])? $_GET['pasienadmisi_id']: "") ?>";
    window.open('<?php echo $this->createUrl('print'); ?>&pendaftaran_id='+pendaftaran_id+'&pasienadmisi_id='+pasienadmisi_id,'printwin','left=100,top=100,width=480,height=640');
}

function tambahPemakaianBahan(isdialog = undefined){
    if($('#pendaftaran_id').val() == ''){
            myAlert("Silahkan Pilih Data Kunjungan terlebih dahulu!");
            return false;
        }
    if(isdialog != undefined){
        var isnonpaket = $("#tipepaket_id :selected").data('isnonpaket');
        $('#dialogPemakaianBahan').dialog('close');
        if(isnonpaket == true){
            return false;
        }
    }

    $("#tblpemakaianbahan").addClass("animation-loading");
    var isbukanbebanpasien = 0;
    if($('#isbukanbebanpasien').prop('checked')==true){
        isbukanbebanpasien = 1;
    }
    var tipepaket_id = $('#tipepaket_id').val();
    var obatalkes_id = $('#obatalkes_id').val();
    var qtypakaibahan = $('#qtypakaibahan').val();
    var isadaoa = false;
    
    if($('#obatalkes_id').prop('disabled')==false && obatalkes_id != ''){
        isadaoa = true;
    }else if($('#obatalkes_id').prop('disabled') == true){
        isadaoa = true;
        var isadatipe = false;

        $("#tblpemakaianbahan").find('.trparent').each(function(){
            var idxParent = $(this).attr('idxparent');
            if(tipepaket_id == $(this).find($(this).find('input[name$="['+idxParent+'][tipepaket_id]"]')).val()){
                isadatipe = true;
            }
        });

        if(isadatipe == true){
            isadaoa = false;
        }
    }

    if(tipepaket_id != '' && isadaoa == true){
        $.ajax({
            type:'GET',
            url:'<?php echo $this->createUrl('setLoadBahanMedis'); ?>',
            data: {tipepaket_id:tipepaket_id, isbukanbebanpasien:isbukanbebanpasien, obatalkes_id:obatalkes_id, qtypakaibahan:qtypakaibahan},
            dataType: "json",
            success:function(data){
                $("#tblpemakaianbahan").append(data.html);
                generateRowBmhp($("#tblpemakaianbahan"));
                hitungTotalBmhp();
                if(data.pesan != ''){
                    myAlert(data.pesan);
                }
                searchPakaiBmhpReset();
                $("#tblpemakaianbahan").removeClass("animation-loading");
            },
            error: function (jqXHR, textStatus, errorThrown) { 
                myAlert("Data Pemakaian Bahan Pasien tidak ditemukan !"); 
                searchPakaiBmhpReset();
                $("#tblpemakaianbahan").removeClass("animation-loading");
            }
        });
    }else{
        myAlert("Data Pemakaian Bahan Pasien tidak ditemukan atau sudah ditambahkan!"); 
        searchPakaiBmhpReset();
        $("#tblpemakaianbahan").removeClass("animation-loading");
    }
}

function searchPakaiBmhpReset(){
    $('#isbukanbebanpasien').attr('checked',false);
    $('#tipepaket_id').val('');
    $('#obatalkes_id').val('');
    $('#obatalkes_nama').val('');
    $('#qtypakaibahan').val(formatThousandDecimal(1));
    $('#satuanpakaibahan').val('');
}

function changeTipePaketBahanMedis(){
    var isnonpaket = $("#tipepaket_id :selected").data('isnonpaket');

    if($('#tipepaket_id').val() != ''){
        if(isnonpaket != true){
            $('#obatalkes_id').attr('disabled',true);
            $('#qtypakaibahan').attr('disabled',true);
            $('#obatalkes_nama').attr('disabled',true);
            $('#obatalkes_nama').each(function() {
                $(this).parent().find(".add-on").hide();
            });
            $('#btntmbbahanmedis').attr('disabled',true);

            $('#obatalkes_id').val('');
            $('#obatalkes_nama').val('');
            $('#qtypakaibahan').val('1');
            tambahPemakaianBahan();   
        }else{
            $('#obatalkes_id').attr('disabled',false);
            $('#qtypakaibahan').attr('disabled',false);
            $('#obatalkes_nama').attr('disabled',false);
            $('#obatalkes_nama').each(function() {
                $(this).parent().find(".add-on").show();
            });
            $('#btntmbbahanmedis').attr('disabled',false);
        }
    }
}


function hitungTotalBmhp(){
    unformatNumberSemua();
    var totalAll = 0;
    
    $('#tblpemakaianbahan').find('.trparent').each(function(){
        var idxParent = $(this).attr('idxparent');
        
        $('#tblpemakaianbahan').find('.trparent').eq(idxParent).find('.tblchild_jnsoa').find('.trcld_jnsoa').each(function(){
            var idxchild = $(this).attr('idxchild');
            var harga = parseFloat($('#tblpemakaianbahan').find('.trparent').eq(idxParent).find('input[name$="['+idxParent+']['+idxchild+'][hargajual]"]').val());
            var qty = parseFloat($('#tblpemakaianbahan').find('.trparent').eq(idxParent).find('input[name$="['+idxParent+']['+idxchild+'][qty]"]').val());

            var subtotal = (qty * harga);
            if (subtotal > 0){
                subtotal = parseFloat(subtotal.toFixed(2));
            }

            $('#tblpemakaianbahan').find('.trparent').eq(idxParent).find('input[name$="['+idxParent+']['+idxchild+'][subtotal]"]').val(subtotal);
            totalAll += subtotal;

        });
    });
    
    $('#totalbahanmedis').val(totalAll);    
    formatNumberSemua();
}

function generateRowBmhp(obj){
    var nourut = 0;
    for(var i=0; i<$(obj).find('.nourut').length; i++){
        var tr = $(obj).find('.nourut').eq(i);
        tr.attr('id','Bmhp_'+i+'_nourut');
        tr.attr('name','Bmhp['+i+'][nourut]');
        nourut++;
        tr.val(nourut);
    }

    for(var i=0; i<$(obj).find('.tgl_pelayanan').length; i++){
        var tr = $(obj).find('.tgl_pelayanan').eq(i);
        tr.attr('id','Bmhp_'+i+'_tgl_pelayanan');
        tr.attr('name','Bmhp['+i+'][tgl_pelayanan]');
        tr.datetimepicker(
                            jQuery.extend(
                                {
                                    showMonthAfterYear:false
                                }, 
                                jQuery.datepicker.regional['id'],
                                {
                                'dateFormat':'dd M yy',
                                    'minDate':'d',
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
        
        tr.each(function() {
            var obj = $(this);
            $(this).parent().find(".add-on").click(function() {
                $(obj).focus();
            });
        });
    }

    for(var i=0; i<$(obj).find('.tipepaket_id').length; i++){
        var tr = $(obj).find('.tipepaket_id').eq(i);
        tr.attr('id','Bmhp_'+i+'_tipepaket_id');
        tr.attr('name','Bmhp['+i+'][tipepaket_id]');
    }

    for(var i=0; i<$(obj).find('.tipepaket_nama').length; i++){
        var tr = $(obj).find('.tipepaket_nama').eq(i);
        tr.attr('id','Bmhp_'+i+'_tipepaket_nama');
        tr.attr('name','Bmhp['+i+'][tipepaket_nama]');
    }

    for(var i=0; i<$(obj).find('.trparent').length; i++){
        var tr = $(obj).find('.trparent').eq(i);
        tr.attr('id','trparent'+i);
        tr.attr('idxparent',i);
        
        for(var j=0; j<tr.find('.tblchild_jnsoa').find('.trcld_jnsoa').length; j++){
            var trc = tr.find('.tblchild_jnsoa').find('.trcld_jnsoa').eq(j);
            trc.attr('id','trcld_jnsoa'+i+'_'+j);
            trc.attr('idx',i+'_'+j);
            trc.attr('idxchild',j);
            trc.find('td').removeClass('trcoltd');
            trc.find('td').removeClass('trcoltdwhite');

            if(j % 2 == 0){
                trc.find('td').addClass('trcoltdwhite');
            }else{
                trc.find('td').addClass('trcoltd');
            }
            
            var trc_chld = tr.find('.tblchild_jnsoa').find('.jenisobatalkes_nama').eq(j);
            trc_chld.attr('id','Bmhpchild_'+i+'_'+j+'_jenisobatalkes_nama');
            trc_chld.attr('name','Bmhpchild['+i+']['+j+'][jenisobatalkes_nama]');
        }

        for(var j=0; j<tr.find('.tblchild_namaoa').find('.trcld_namaoa').length; j++){
            var trc = tr.find('.tblchild_namaoa').find('.trcld_namaoa').eq(j);
            trc.attr('id','trcld_namaoa'+i+'_'+j);
            trc.attr('idx',i+'_'+j);
            trc.find('td').removeClass('trcoltd');
            trc.find('td').removeClass('trcoltdwhite');

            if(j % 2 == 0){
                trc.find('td').addClass('trcoltdwhite');
            }else{
                trc.find('td').addClass('trcoltd');
            }
            
            var trc_chld = tr.find('.tblchild_namaoa').find('.obatalkes_id').eq(j);
            trc_chld.attr('id','Bmhpchild_'+i+'_'+j+'_obatalkes_id');
            trc_chld.attr('name','Bmhpchild['+i+']['+j+'][obatalkes_id]');

            var trc_chldoa = tr.find('.tblchild_namaoa').find('.obatalkes_nama').eq(j);
            trc_chldoa.attr('id','Bmhpchild_'+i+'_'+j+'_obatalkes_nama');
            trc_chldoa.attr('name','Bmhpchild['+i+']['+j+'][obatalkes_nama]');
        }

        for(var j=0; j<tr.find('.tblchild_tglkadaluarsaoa').find('.trcld_tglkadaluarsaoa').length; j++){
            var trc = tr.find('.tblchild_tglkadaluarsaoa').find('.trcld_tglkadaluarsaoa').eq(j);
            trc.attr('id','trcld_tglkadaluarsaoa'+i+'_'+j);
            trc.attr('idx',i+'_'+j);
            trc.find('td').removeClass('trcoltd');
            trc.find('td').removeClass('trcoltdwhite');

            if(j % 2 == 0){
                trc.find('td').addClass('trcoltdwhite');
            }else{
                trc.find('td').addClass('trcoltd');
            }
            
            var trc_chld = tr.find('.tblchild_tglkadaluarsaoa').find('.tglkadaluarsa').eq(j);
            trc_chld.attr('id','Bmhpchild_'+i+'_'+j+'_tglkadaluarsa');
            trc_chld.attr('name','Bmhpchild['+i+']['+j+'][tglkadaluarsa]');
        }

        for(var j=0; j<tr.find('.tblchild_hargajualoa').find('.trcld_hargajualoa').length; j++){
            var trc = tr.find('.tblchild_hargajualoa').find('.trcld_hargajualoa').eq(j);
            trc.attr('id','trcld_hargajualoa'+i+'_'+j);
            trc.attr('idx',i+'_'+j);
            trc.find('td').removeClass('trcoltd');
            trc.find('td').removeClass('trcoltdwhite');

            if(j % 2 == 0){
                trc.find('td').addClass('trcoltdwhite');
            }else{
                trc.find('td').addClass('trcoltd');
            }
            
            var trc_chld = tr.find('.tblchild_hargajualoa').find('.hargajual').eq(j);
            trc_chld.attr('id','Bmhpchild_'+i+'_'+j+'_hargajual');
            trc_chld.attr('name','Bmhpchild['+i+']['+j+'][hargajual]');
        }

        for(var j=0; j<tr.find('.tblchild_jmloa').find('.trcld_jmloa').length; j++){
            var trc = tr.find('.tblchild_jmloa').find('.trcld_jmloa').eq(j);
            trc.attr('id','trcld_jmloa'+i+'_'+j);
            trc.attr('idx',i+'_'+j);
            trc.find('td').removeClass('trcoltd');
            trc.find('td').removeClass('trcoltdwhite');

            if(j % 2 == 0){
                trc.find('td').addClass('trcoltdwhite');
            }else{
                trc.find('td').addClass('trcoltd');
            }
            
            var trc_chld = tr.find('.tblchild_jmloa').find('.qty').eq(j);
            trc_chld.attr('id','Bmhpchild_'+i+'_'+j+'_qty');
            trc_chld.attr('name','Bmhpchild['+i+']['+j+'][qty]');
        }

        for(var j=0; j<tr.find('.tblchild_satuankecil').find('.trcld_jmloa').length; j++){
            var trc = tr.find('.tblchild_satuankecil').find('.trcld_jmloa').eq(j);
            trc.attr('id','trcld_satuankecil'+i+'_'+j);
            trc.attr('idx',i+'_'+j);
            trc.find('td').removeClass('trcoltd');
            trc.find('td').removeClass('trcoltdwhite');

            if(j % 2 == 0){
                trc.find('td').addClass('trcoltdwhite');
            }else{
                trc.find('td').addClass('trcoltd');
            }
            
            var trc_chld = tr.find('.tblchild_satuankecil').find('.satuankecil').eq(j);
            trc_chld.attr('id','Bmhpchild_'+i+'_'+j+'_satuankecil');
            trc_chld.attr('name','Bmhpchild['+i+']['+j+'][satuankecil]');
        }

        for(var j=0; j<tr.find('.tblchild_subtotaloa').find('.trcld_subtotaloa').length; j++){
            var trc = tr.find('.tblchild_subtotaloa').find('.trcld_subtotaloa').eq(j);
            trc.attr('id','trcld_subtotaloa'+i+'_'+j);
            trc.attr('idx',i+'_'+j);
            trc.find('td').removeClass('trcoltd');
            trc.find('td').removeClass('trcoltdwhite');

            if(j % 2 == 0){
                trc.find('td').addClass('trcoltdwhite');
            }else{
                trc.find('td').addClass('trcoltd');
            }
            
            var trc_chld = tr.find('.tblchild_subtotaloa').find('.subtotal').eq(j);
            trc_chld.attr('id','Bmhpchild_'+i+'_'+j+'_subtotal');
            trc_chld.attr('name','Bmhpchild['+i+']['+j+'][subtotal]');
        }
        
    }
}

function hapusBmhp(obj){
    $(obj).parents('.trparent').detach();
    generateRowBmhp($('#tblpemakaianbahan'));
    hitungTotalBmhp();
}

function setVerifikasi(){
    if(requiredCheck($("form"))){
        $("form").find('.integer-decimal, .float, .integer').each(function(){
              $(this).val(unformatNumber($(this).val()));
        });
        $("#pemakaianbahp-form").submit();
    }
    return false;
}

$(document).ready(function(){
    hitungTotalBmhp();
});
</script>