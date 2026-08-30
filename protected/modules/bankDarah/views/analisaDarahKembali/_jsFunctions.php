<script>
    
$(".cek_analisa").click(function() {
    cekAnalisa();
});

function cekAnalisa() {
    $("#BDReturdarahT_kesimpulan").val("Layak");
    $(".cek_analisa:checked").each(function() {
        if ($(this).val() == 1) {
            $("#BDReturdarahT_kesimpulan").val("Tidak Layak");
        } 
    });
}

function setReturDarah(data) {
    
    data.asal_darah = data.asal_darah.replace("&deg;", String.fromCharCode(176) + "C");
    
    $(".returdarah_id").val(data.returdarah_id);
    $(".no_kantongdarah").val(data.no_kantongdarah);
    $("#BDReturdarahT_nama_pasien").val(data.nama_pasien);
    $("#BDReturdarahT_no_rekam_medik").val(data.no_rekam_medik);
    $("#BDReturdarahT_ruangan_nama").val(data.ruangan_nama);
    $("#BDReturdarahT_jenis_komponen_darah").val(data.jenis_komponen_darah);
    $("#BDReturdarahT_golongan_darah").val(data.golongan_darah);
    
    $("#BDReturdarahT_tgl_retur_darah").val(data.tgl_retur_darah);
    $("#BDReturdarahT_no_retur_darah").val(data.no_retur_darah);
    $("#BDReturdarahT_asal_darah").val(data.asal_darah);
    $("#BDReturdarahT_keterangan").val(data.keterangan);
    $("#BDReturdarahT_petugas_penerima_nama").val(data.petugas_penerima_nama);
    
    $("#petugas_analisa_nama").blur();
}


$(document).ready(function() {
    setValidasiCekDisabled($("#analisa-darah-kembali-form"), function() {
        if ($("#BDReturdarahT_returdarah_id").val().trim() == "") {
            return false;
        }
        
        return true;
    });
});
</script>