<script type="text/javascript">
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
                    $("#<?php echo CHtml::activeId($modKunjungan, 'noanestesi'); ?>").blur();
                } else {
                    $("#<?php echo CHtml::activeId($modKunjungan, 'pasienanastesi_id'); ?>").val(data.pasienanastesi_id);
                    $("#<?php echo CHtml::activeId($modPraAnastesi, 'pasienanastesi_id'); ?>").val(data.pasienanastesi_id);
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

                    $("#<?php echo CHtml::activeId($modIntraAnastesi, 'jam_ab_profilakasis'); ?>").val(data.jam_ab_profilakasis);
                    $("#<?php echo CHtml::activeId($modIntraAnastesi, 'jam_insisi'); ?>").val(data.jam_insisi);
                    $("#<?php echo CHtml::activeId($modIntraAnastesi, 'intraanastesi_id'); ?>").val(data.intraanastesi_id);
                    
                    if (data.jam_masuk_ok != ''){
                        $("#<?php echo CHtml::activeId($modIntraAnastesi, 'jam_masuk_ok'); ?>").val(data.jam_masuk_ok);
                    }
                    if (data.tanggal != ''){
                        $("#<?php echo CHtml::activeId($modIntraAnastesi, 'tanggal'); ?>").val(data.tanggal);
                    }
                 

                    if (data.photopasien === null || data.photopasien === "" || data.photopasien === undefined) { //set photo
                        $('#photo-preview').attr('src', '<?php echo Params::urlPhotoPasienDirectory() . "no_photo.jpeg" ?>');
                    } else {
                        $('#photo-preview').attr('src', '<?php echo Params::urlPasienTumbsDirectory() . "kecil_" ?>' + data.photopasien);
                    }
                    if (data.noanestesi == '' || data.noanestesi == null) {
                        var noanestesi = data.no_masukpenunjang;
                    } else {
                        var noanestesi = data.noanestesi;
                    }
//                    loadDataPraAnestesi(data.pasienanastesi_id);
                    
                    loadObatIntra();                                        
                    $("#<?php echo CHtml::activeId($modKunjungan, 'noanestesi'); ?>").blur();
                    generateExt();
                    cekGasKet();
                    $("#form-datakunjungan > legend > .judul").html('Data Pasien ' + noanestesi);
                    $("#form-datakunjungan > legend > .tombol").attr('style', 'display:true;');
                    $("#form-datakunjungan > .box").addClass("well").removeClass("box");                    
                    
                }
                $("#form-datakunjungan > div").removeClass("animation-loading");
                //$("#<?php //echo CHtml::activeId($modKunjungan, 'noanestesi'); ?>").focus();
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

    /**
     * rename input grid
     */
    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function () {
            $(this).find('span').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            
            var btnAdd = $(this).find('.btnadd');
            var btnDel = $(this).find('.btnhapus');
            
            if (typeof btnAdd != 'undefined'){
                if (row == 0){
                    btnAdd.removeClass('hide');
                    btnDel.addClass('hide');
                }else{
                    btnDel.removeClass('hide');
                    btnAdd.addClass('hide');
                }
            }
            row++;
        });
        
        $('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
    }

    function tambahGasInhalasi() {
        var row = '<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowGasInhalasi', array('modObatCairanAnastesi' => $modObatCairanAnastesi, 'form' => $form, 'i'=>0), true)); ?>'
        $('#table-gasflow > tbody').append(row);
        renameInputRow($("#table-gasflow"));
    }

    function batalGasInhalasi(obj) {
        var id = $(obj).parents("tr").find(".id").val();
        myConfirm("Apakah Anda yakin ingin menghapus data ini ?","Perhatian!",function(r){
            if (r){
                if (id != ''){
                    $("#table-gasflow-hapus > tbody").append("<tr><td><input type='hidden' name='hapusglasflow[]' value='"+id+"'></td></tr>");
                }
                $(obj).parents(".tr-gasflow").detach();
                renameInputRow($("#table-gasflow"));
            }
        });        

    }
    
    function tambahObat() {
        var row = '<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowObat', array('modObatCairanAnastesi' => $modObatCairanAnastesi, 'form' => $form, 'i'=>0), true)); ?>'
        $('#table-obat > tbody').append(row);
        renameInputRow($("#table-obat"));
    }

    function batalObat(obj) {
        var id = $(obj).parents("tr").find(".id").val();
        myConfirm("Apakah Anda yakin ingin menghapus data ini ?","Perhatian!",function(r){
            if (r){
                if (id != ''){
                    $("#table-obat-hapus > tbody").append("<tr><td><input type='hidden' name='hapusobat[]' value='"+id+"'></td></tr>");
                }
                $(obj).parents("tr").detach();
                renameInputRow($("#table-obat"));
            }
        });          
    }
    
    function tambahKristaloid() {
        var row = '<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowKristaloid', array('modObatCairanAnastesi' => $modObatCairanAnastesi, 'form' => $form, 'i'=>0), true)); ?>'
        $('#table-kristaloid > tbody').append(row);
        renameInputRow($("#table-kristaloid"));
    }

    function batalKristaloid(obj) {
        var id = $(obj).parents("tr").find(".id").val();
        myConfirm("Apakah Anda yakin ingin menghapus data ini ?","Perhatian!",function(r){
            if (r){
                if (id != ''){
                    $("#table-kristaloid-hapus > tbody").append("<tr><td><input type='hidden' name='hapuskristaloid[]' value='"+id+"'></td></tr>");
                }
                $(obj).parents("tr").detach();
                renameInputRow($("#table-kristaloid"));
            }
        });         
    }
    
    function tambahKolloid() {
        var row = '<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowKolloid', array('modObatCairanAnastesi' => $modObatCairanAnastesi, 'form' => $form, 'i'=>0), true)); ?>'
        $('#table-kolloid > tbody').append(row);
        renameInputRow($("#table-kolloid"));
    }

    function batalKolloid(obj) {
        var id = $(obj).parents("tr").find(".id").val();
        myConfirm("Apakah Anda yakin ingin menghapus data ini ?","Perhatian!",function(r){
            if (r){
                if (id != ''){
                    $("#table-kolloid-hapus > tbody").append("<tr><td><input type='hidden' name='hapuskolloid[]' value='"+id+"'></td></tr>");
                }
                $(obj).parents("tr").detach();
                renameInputRow($("#table-kolloid"));
            }
        });          
    }
    
    function tambahDarah() {
        var row = '<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowDarah', array('modObatCairanAnastesi' => $modObatCairanAnastesi, 'form' => $form, 'i'=>0), true)); ?>'
        $('#table-darah > tbody').append(row);
        renameInputRow($("#table-darah"));
        generateExt();
    }

    function batalDarah(obj) {
        var id = $(obj).parents("tr").find(".id").val();
        myConfirm("Apakah Anda yakin ingin menghapus data ini ?","Perhatian!",function(r){
            if (r){
                if (id != ''){
                    $("#table-darah-hapus > tbody").append("<tr><td><input type='hidden' name='hapusdarah[]' value='"+id+"'></td></tr>");
                }
                $(obj).parents("tr").detach();
                renameInputRow($("#table-darah"));
            }
        });          
    }
    
    function tambahLainnya() {
        var row = '<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowLainnya', array('modObatCairanAnastesi' => $modObatCairanAnastesi, 'form' => $form, 'i'=>0), true)); ?>'
        $('#table-lainnya > tbody').append(row);
        renameInputRow($("#table-lainnya"));
    }

    function batalLainnya(obj) {
        var id = $(obj).parents("tr").find(".id").val();
        myConfirm("Apakah Anda yakin ingin menghapus data ini ?","Perhatian!",function(r){
            if (r){
                if (id != ''){
                    $("#table-lainnya-hapus > tbody").append("<tr><td><input type='hidden' name='hapuslainnya[]' value='"+id+"'></td></tr>");
                }
                $(obj).parents("tr").detach();
                renameInputRow($("#table-lainnya"));
            }
        });          
    }
    
    function changeN20(){
        var check = $("#ATIntraanastesiT_gasflow_n2o").prop("checked");
        var text = $("#ATIntraanastesiT_gasflow_n2o_keterangan").val();        
        
        if(check == true){
            $("#ATIntraanastesiT_gasflow_n2o_keterangan").removeAttr('readonly',false);
        }else{
            $("#ATIntraanastesiT_gasflow_n2o_keterangan").attr('readonly',true);
            $("#ATIntraanastesiT_gasflow_n2o_keterangan").val("");
        }
    }
    
    function changeO2(){
        var check = $("#ATIntraanastesiT_gasflow_o2").prop("checked");
        if(check == true){
            $("#ATIntraanastesiT_gasflow_o2_keterangan").removeAttr('readonly',false);
        }else{
            $("#ATIntraanastesiT_gasflow_o2_keterangan").attr('readonly',true);
            $("#ATIntraanastesiT_gasflow_o2_keterangan").val("");
        }
    }
    
    function changeAir(){
        var check = $("#ATIntraanastesiT_gasflow_air").prop("checked");
        if(check == true){
            $("#ATIntraanastesiT_gasflow_air_keterangan").removeAttr('readonly',false);
        }else{
            $("#ATIntraanastesiT_gasflow_air_keterangan").attr('readonly',true);
            $("#ATIntraanastesiT_gasflow_air_keterangan").val("");
        }
    }
    
    function cekGasInhalasi(obj){
        
        var cekDet = $("#table-gasflow > tbody > tr").length;
        
        if ($(obj).prop("checked") == true){
            hideShowBtnGas('show');
            $(".gasinhalasi").removeAttr('disabled');
        }else{
            if (cekDet > 0){
                myConfirm("Apakah Anda yakin ingin menghapus detail gas inhalasi ?","Perhatian!",function(r){
                    if (r){
                        hideShowBtnGas('hide');
                        $(".gasinhalasi").attr('disabled', true);
                    }else{
                        $(obj).prop("checked",true);
                    }
                });
            }else{
                hideShowBtnGas('hide');
            }
            
        }
    }
    
    function hideShowBtnGas(ket){
        var row = 0;
        $("#table-gasflow").find("tbody > tr").each(function () {
            if(row > 0){
                if(ket=='hide'){
                    $(this).find('.btnTambahGasInhalasi').hide();
                }
            }else{
                if(ket=='show'){
                    $(this).find('.btnTambahGasInhalasi').show();
                }else{
                    $(this).find('.btnTambahGasInhalasi').hide();
                }
            }
            row++;
        });
    }
    
    function hapusSemuaDetGas(){
        $("#table-gasflow > tbody > tr").each(function(){
            var id = $(this).find('.id').val();
            if (id != ''){
                $("#table-gasflow-hapus > tbody").append("<tr><td><input type='hidden' name='hapusglasflow[]' value='"+id+"'></td></tr>");
            }
            $(this).detach();
        });
    }
    
    function loadObatIntra(){
        var pasienanastesi_id = $("#<?php echo CHtml::activeId($modKunjungan,'pasienanastesi_id') ?>").val();
    
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('loadObatIntra'); ?>',            
            data: {pasienanastesi_id:pasienanastesi_id},    
            dataType: "json",
            success:function(data){
                if (data.sukses == 1){
                    
                    $("#form-awal").html(data.formAwal);
                    
                    $('#table-gasflow > tbody').html(data.detGasInhalasi);
                    $('#table-obat > tbody').html(data.detObat);
                    $('#table-kristaloid > tbody').html(data.detKristaloid);
                    $('#table-kolloid > tbody').html(data.detKolloid);
                    $('#table-lainnya > tbody').html(data.detLainnya);
                    $('#table-darah > tbody').html(data.detDarah);
                    $('#form-cairan-keluar').html(data.detCairanKeluar);
                    
                    renameInputRow($("#table-gasflow"));
                    renameInputRow($("#table-obat"));
                    renameInputRow($("#table-kristaloid"));
                    renameInputRow($("#table-kolloid"));
                    renameInputRow($("#table-lainnya"));                    
                    renameInputRow($("#table-darah"));                                        
                    
                    generateExt();                                                                                                    
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    
    function generateExt(){
        $('.numbers-only').keyup(function() {
            setNumbersOnly(this);
        });
    }
    
    function cekGasKet(){                
        setTimeout(function(){                    
            $("#form-gas-flow").find('input:checkbox').each(function(){            
                if ($(this).hasClass('adatext')){

                    if ($(this).parents(".control-group").find('.txtlain').val() != ''){
                        $(this).parents(".control-group").find('.txtlain').removeAttr('readonly');
                    }
                } 
            });
            
            var cekLength = 0;
        
            $("#table-gasflow > tbody > tr").each(function(){
                if ($(this).find('.nama').val() != ''){
                    cekLength++
                }
            });

            if (cekLength > 0){
                $('#<?php echo CHtml::activeId($modIntraAnastesi, 'gasflow_gasinhalasi') ?>').prop("checked",true);
            }else{
                $(".gasinhalasi").attr('disabled', true);
                $('.btnTambahGasInhalasi').hide();
            }
        },200);
        
        
    }
    
    /**
     * javascript yang di running setelah halaman ready / load sempurna
     * posisi script ini harus tetap dibawah
     */
    $(document).ready(function () {

//        $('form').bind('click keyup select change', function (event) {
//            cekDisabled(this);
//        });
//        $(document).on('click keyup select change', function () {
//            cekDisabled('form');
//        });
//        cekDisabled('form');
            setValidasiCekDisabled($("#intraanestesi-t-form"), function() {
                
                return true;
         });
                
        loadObatIntra();                                        
        cekGasKet();                
                
    });
</script>