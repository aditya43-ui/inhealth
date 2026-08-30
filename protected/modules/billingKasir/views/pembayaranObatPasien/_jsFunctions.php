<script type="text/javascript">
    
    function setRincianTindakan(){
        setRincianObatalkes();
    }
    /**
     * menghitung total semua = total obat alkes
     * @returns {undefined}
     */
    function hitungTotalSemua(){
        unformatNumberSemua();

        var tot_hargajual_oa = parseInt($("#form-rincianobatalkes #tot_hargajual_oa").val());
        var tot_tarifcyto = parseInt($("#form-rincianobatalkes #tot_tarifcyto").val());
        var tot_discount = parseInt($("#form-rincianobatalkes #tot_discount").val());
        var tot_biayalain = parseInt($("#form-rincianobatalkes #tot_biayalain").val());
        var tot_subsidiasuransi = parseInt($("#form-rincianobatalkes #tot_subsidiasuransi").val());
        var tot_subsidirs = parseInt($("#form-rincianobatalkes #tot_subsidirs").val());
        var tot_iurbiaya = parseInt($("#form-rincianobatalkes #tot_iurbiaya").val());
        var total_oa = parseInt($("#form-rincianobatalkes #total_oa").val());

        $("#form-rinciansemua #tot_tarif_semua").val(tot_hargajual_oa);
        $("#form-rinciansemua #tot_tarifcyto_semua").val(tot_tarifcyto);
        $("#form-rinciansemua #tot_discount_semua").val(tot_discount);
        $("#form-rinciansemua #tot_subsidiasuransi_semua").val(tot_subsidiasuransi);
        $("#form-rinciansemua #tot_subsidirumahsakit_semua").val(tot_subsidirs);
        $("#form-rinciansemua #tot_iurbiaya_semua").val(tot_iurbiaya);
        $("#form-rinciansemua #total_semua").val(total_oa);

        $("#<?php echo CHtml::activeId($model,'totalbiayapelayanan');?>").val(tot_hargajual_oa);
        $("#<?php echo CHtml::activeId($model,'totalbiayatindakan');?>").val(0);
        $("#<?php echo CHtml::activeId($model,'totalbiayaoa');?>").val(tot_hargajual_oa);
        $("#<?php echo CHtml::activeId($model,'totaldiscount');?>").val(tot_discount);
        $("#<?php echo CHtml::activeId($model,'totalsubsidiasuransi');?>").val(tot_subsidiasuransi);
        $("#<?php echo CHtml::activeId($model,'totalsubsidirs');?>").val(tot_subsidirs);
        $("#<?php echo CHtml::activeId($model,'totaliurbiaya');?>").val(tot_iurbiaya);
        $("#<?php echo CHtml::activeId($model,'totalpembebasan');?>").val(0);

        formatNumberSemua();
        hitungJmlpembulatan();
        hitungJmlpembayaran();
        hitungUangKembalian();

    }
    /**
     * set default / otomatis data pembayar
     * @returns {undefined}
     */
    function setDataPembayar(){
        var darinama_bkm = $("#no_pendaftaran").val()+"-"+$("#no_rekam_medik").val()+"-"+$("#namadepan").val()+" "+$("#nama_pasien").val();
        var alamat_bkm = $("#alamat_pasien").val();
        var sebagaipembayaran_bkm = "BIAYA PELAYANAN OBAT / ALAT KESEHATAN";
        $("#<?php echo CHtml::activeId($modTandabukti, 'darinama_bkm') ?>").val(darinama_bkm);
        $("#<?php echo CHtml::activeId($modTandabukti, 'alamat_bkm') ?>").val(alamat_bkm);
        $("#<?php echo CHtml::activeId($modTandabukti, 'sebagaipembayaran_bkm') ?>").val(sebagaipembayaran_bkm);
    }
    
    /**
     * print rincian obat alkes belum bayar
     * @returns {undefined} */ 
    function printRincianOABelumBayar()
    {
        var instalasi_id = $("#instalasi_id").val();
        var pendaftaran_id = $("#pendaftaran_id").val();
        var pasienadmisi_id = $("#pasienadmisi_id").val();
        if(instalasi_id && pendaftaran_id){
            window.open("<?php echo $this->createUrl('printRincianOABelumBayar') ?>&instalasi_id="+instalasi_id+"&pendaftaran_id="+pendaftaran_id+"&pasienadmisi_id="+pasienadmisi_id,"",'location=_new, width=1024px');
        }else{
            myAlert("Silakan cari data kunjungan terlabih dahulu!");
        }
    }
    
    /**
    * set form kunjungan
    * @param {type} pasien_id
    * @returns {undefined}
    */
    function setKunjungan(pendaftaran_id, no_pendaftaran, no_rekam_medik, pasienadmisi_id , instalasi_id){
        $("#form-datakunjungan > div").addClass("animation-loading");
        
        if (instalasi_id == null) {
            instalasi_id = $("#instalasi_id").val();
        } else {
            $("#instalasi_id").val(instalasi_id);
        }
        carapembayaran = "";
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('GetDataKunjungan'); ?>',
            data: {instalasi_id:instalasi_id, pendaftaran_id:pendaftaran_id, no_pendaftaran:no_pendaftaran, no_rekam_medik:no_rekam_medik, pasienadmisi_id:pasienadmisi_id},
            dataType: "json",
            success:function(data){
                if (data.notif.ok == 0) {
                    myAlert(data.notif.msg);
                    $("#form-datakunjungan > div").removeClass("animation-loading");
                    return false;
                } else if (data.notif.ok == 9) {
                    myConfirm(data.notif.msg, "Peringatan!", function(r) {
                        if (r) {
                            loadTagihanPasien(data);
                            setRincianObatalkes();
                        }
                    });
                    $("#form-datakunjungan > div").removeClass("animation-loading");
                    return false;
                }

                $("#tot_inacbg").val(0);
                loadTagihanPasien(data);
                setRincianObatalkes();

            },
            error: function (jqXHR, textStatus, errorThrown) { 
                myAlert("Data kunjungan tidak ditemukan!"); 
                console.log(errorThrown);
                setKunjunganReset();
                $("#form-datakunjungan > div").removeClass("animation-loading");
                $("#instalasi_id").focus();
            }
        });

    }

    function simpanPembayaranPelFarmasi() {
        if ($("#instalasi_id").val() == <?php echo Params::INSTALASI_ID_RJ; ?> && $("#tindakan_kosong").val() == 0) {
            myConfirm('Anda yakin untuk mengubah status periksa menjadi "<?php echo Params::STATUSPERIKSA_SUDAH_PULANG ?>" ?', "Perhatian", function(r) {
                if (r) {
                    $("#is_ubah_status").val(1);
                } else {
                    $("#is_ubah_status").val(0);
                }

                // return false;

                $(".integer2, .float2, .integer-decimal").each(function(){
                    $(this).val(unformatNumber($(this).val()));
                });
                $("#bkpembayaranpelayanan-t-form").submit();
            });
        } else {
            $(".integer2, .float2, .integer-decimal").each(function(){
                $(this).val(unformatNumber($(this).val()));
            });
            $("#bkpembayaranpelayanan-t-form").submit();
        }
    }
</script>