<script>
    /**
     * Link Print Label 
     */
    function printLabel()
    {
        var permintaan_id = <?php echo empty($permintaan->permintaandarah_id) ? "null" : $permintaan->permintaandarah_id; ?>;
        if (permintaan_id != null) {
            window.open('<?php echo $this->createUrl('print'); ?>&id=' + permintaan_id, 'printwin', 'left=100,top=100,width=800,height=500');
        }
    }
    
    $(document).ready(function() {
        setValidasiCekDisabled($("#penyerahandarah-form"), function() {
            
            if ($("#PenyerahandarahT_pendaftaran_id").val() == "") {
                return false;
            }
            
            var ok = true;
            
            var ok_req = true;
            $(".req").each(function() {
                if ($(this).val() == "") ok = false;
            });
            
            var tr = $("#tab_penyerahan").find('input:checkbox:checked').length;            
            if (tr < 1){
                return false;
            }
            
            return ok;
        });
        
        $("#tab_penyerahan").find('input:checkbox').on('click',function(){            
            $("#PenyerahandarahT_peg_transporter").blur();                        
        })
    });
    
    function cekForm(){
        if (requiredCheck($("#penyerahandarah-form"))){
            $("#tab_penyerahan > tr").find('input:checkbox').each(function(){
                if ($(this).prop("checked") == false){
                    $(this).parents("tr").remove();
                }
            });
            $('#penyerahandarah-form').submit();
        }

        return false;
    }
    
    function setPermintaan(data) {
        $("#PenyerahandarahT_no_permintaandarah").val(data.no_permintaandarah);
        $("#PenyerahandarahT_permintaandarah_id").val(data.permintaandarah_id);
        $("#PenyerahandarahT_pendaftaran_id").val(data.pendaftaran_id);
        
        $("#form_permintaan #tgl_pendaftaran").val(data.pendaftaran.tgl_pendaftaran);
        $("#form_permintaan #no_pendaftaran").val(data.pendaftaran.no_pendaftaran);
        $("#form_permintaan #ruangan").val(data.ruangan_nama);
        $("#form_permintaan #kelaspelayanan").val(data.kelaspelayanan_nama);
        $("#form_permintaan #diagnosis").val(data.diagnosa_nama);
        $("#form_permintaan #penjamin").val(data.penjamin_nama);
        $("#form_permintaan #alamatpasien").val(data.pasien.alamat_pasien);
        
        $("#form_permintaan #no_rekam_medik").val(data.pasien.no_rekam_medik);
        $("#form_permintaan #nama_pasien").val(data.pasien.nama_pasien);
        $("#form_permintaan #tanggal_lahir").val(data.pasien.tanggal_lahir);
        $("#form_permintaan #umur").val(data.pendaftaran.umur);
        $("#form_permintaan #jeniskelamin").val(data.pasien.jeniskelamin);
        $("#form_permintaan #golongandarah").val(data.pasien.golongandarah + " / " + data.pasien.rhesus);
        $("#form_permintaan #doktermenangani").val(data.nama_pegawai);
        
        
        loadPenyiapan(data.permintaandarah_id);
    }
    
    function loadPenyiapan(permintaandarah_id) {
        $("#tab_penyerahan").empty();
        $.post('<?php echo $this->createUrl('loadPenyiapan'); ?>', {
            id: permintaandarah_id
        }, function(data) {
            $("#panel_penyiapan").html(data.html_penyiapan);
            $("#tab_penyerahan").html(data.html);
            
            setDateTimePickerPenyerahan();
            setAutoCompletePetugas();
            
            $("#alamatpasien").blur();
            
        }, "json");
    }
    
    function setDateTimePickerPenyerahan() {
        jQuery(".tgl_tab_verifikasi").datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
                    jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','minDate'  : 'd','timeText':'Waktu','hourText':'Jam',
                         'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
                     
                     
        $(".tgl_tab_verifikasi").parents(".input-append").find(".add-on").click(function() {
            $(this).parents(".input-append").find(".tgl_tab_verifikasi").focus();
        });
    }
    
    function setAutoCompletePetugas() {
        jQuery(".peg_vetifikator_nama").autocomplete(
            {
                'showAnim':'fold',
                'minLength':3,
                'focus':function( event, ui ){
                    $(this).val("");
                    return false;
                },
                'select':function( event, ui ){
                    toastr.info(ui.item.nama_pegawai);
                    $(this).val(ui.item.nama_pegawai);
                    $(this).parents("td").find(".peg_vetifikator_id").val(ui.item.pegawai_id);
                    $("#alamatpasien").blur();
                    return false;
                },
                'source':function(request, response) {
                    $.ajax({
                        url: "<?php echo $this->createUrl('AutocompletePetugasVerifikator'); ?>",
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                }
            }
        );
        
        jQuery(".peg_ygmenyerahkan_nama").autocomplete(
            {
                'showAnim':'fold',
                'minLength':3,
                'focus':function( event, ui ){
                    $(this).val("");
                    return false;
                },
                'select':function( event, ui ){
                    $(this).val(ui.item.nama_pegawai);
                    $(this).parents("td").find(".peg_ygmenyerahkan_id").val(ui.item.pegawai_id);
                    $("#alamatpasien").blur();
                    return false;
                },
                'source':function(request, response) {
                    $.ajax({
                        url: "<?php echo $this->createUrl('AutocompletePetugasMenyerahkan'); ?>",
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                }
            }
        );
        
        jQuery(".peg_transporter_nama").autocomplete(
            {
                'showAnim':'fold',
                'minLength':3,
                'focus':function( event, ui ){
                    $(this).val("");
                    return false;
                },
                'select':function( event, ui ){
                    $(this).val(ui.item.nama_pegawai);
                    $(this).parents("td").find(".peg_transporter_id").val(ui.item.pegawai_id);
                    $("#alamatpasien").blur();
                    return false;
                },
                'source':function(request, response) {
                    $.ajax({
                        url: "<?php echo $this->createUrl('AutocompletePetugasTransporter'); ?>",
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                }
            }
        );
    }
    
</script>