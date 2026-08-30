<script type="text/javascript">

/**
* untuk print surat persetujuan tindakan medis
 */
function print(caraPrint)
{
    var suratpersetujuantm_id = '<?php echo isset($_GET['suratpersetujuantm_id']) ? $_GET['suratpersetujuantm_id'] : null; ?>';
    var pasienanastesi_id = '<?php echo isset($_GET['pasienanastesi_id']) ? $_GET['pasienanastesi_id'] : null; ?>';
    var pendaftaran_id = '<?php echo isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&pasienanastesi_id='+pasienanastesi_id+'&suratpersetujuantm_id='+suratpersetujuantm_id+'&pendaftaran_id='+pendaftaran_id+'&caraprint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function printRiwayat(suratpersetujuantm_id, pendaftaran_id, caraPrint)
{
    window.open('<?php echo $this->createUrl('print'); ?>&suratpersetujuantm_id='+suratpersetujuantm_id+'&pendaftaran_id='+pendaftaran_id+'&caraprint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function printInformasi(caraPrint)
{
    var suratpersetujuantm_id = '<?php echo $modSuratPersetujuan->suratpersetujuantm_id?>';
    var informasi = '<?php echo $informasi->pemberianinformasi_id; ?>';
    window.open('<?php echo $this->createUrl('printInformasi'); ?>&suratpersetujuantm_id='+suratpersetujuantm_id+'&caraprint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function printInformasiRiwayat(suratpersetujuantm_id, pendaftaran_id, caraPrint)
{
    window.open('<?php echo $this->createUrl('printInformasi'); ?>&suratpersetujuantm_id='+suratpersetujuantm_id+'&pendaftaran_id='+pendaftaran_id+'&caraprint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');

}


function gotoPanel(id) {
    if (id == "panel_persetujuan") {
        <?php if ($informasi->isNewRecord): ?>
        console.log("Komparasi",  arr_progress, informasi_cnt);
        if (arr_progress.length != informasi_cnt) {
            myAlert("Lengkapi ceklis informasi sebelum melihat halaman ini.");
            return false;
        } else if (!validasiPenerimaInformasi()) {
            myAlert("Lengkapi form pemberian informasi sebelum melihat halaman ini.");
            return false;
        }
        <?php endif; ?>
       
        setKeInputPersetujuanTindakan();
    }
    
    $(".panel_form").hide();
    $("#" + id).show();
    $("#tab_form li").removeClass("active");
    $("#tab_" + id).addClass("active");
}

function setKeInputPersetujuanTindakan() {
    $("#SuratpersetujuantmT_nama_menyetujui, #SuratpersetujuantmT_nama_yangmenyetujui").val($("#PemberianinformasiT_penerimainformasi_nama").val());
    $("#SuratpersetujuantmT_umur_menyetujui").val($("#PemberianinformasiT_penerimainformasi_umur").val());
    $("#SuratpersetujuantmT_jeniskelamin_menyetujui").val($(".jeniskelamin:checked").val());
    $("#SuratpersetujuantmT_alamat_menyetujui").val($("#PemberianinformasiT_penerimainformasi_alamat").val());
    $("#SuratpersetujuantmT_jenisidentitas_menyetujui").val($("#PemberianinformasiT_penerimainformasi_jenisidentitas").val());
    $("#SuratpersetujuantmT_noktp_menyetujui").val($("#PemberianinformasiT_penerimainformasi_noidentitas").val());
    $("#persetujuan_daftartindakan_nama").val($("#daftartindakanNama").val());
    $("#hubungankeluarga").val($("#PemberianinformasiT_penerimainformasi_hubungandgnpasien").val());
    $("#SuratpersetujuantmT_dokter_id").val($("#PemberianinformasiT_dokterpelaksanatindakan_id").val());
    //$(".surat_dokteranestesi_id").val($("#PemberianinformasiT_dokterpelaksanatindakan_id").val());
    
    var is_dokter = $("#PemberianinformasiT_jenissurat_id :selected").data('dokter');
    var is_transfusi = $("#PemberianinformasiT_jenissurat_id :selected").data('resikotransfusi');
    
    if (is_dokter) {
        $("#text_pernyataan_dokter").show();
    } else {
        $("#text_pernyataan_dokter").hide();
    }
    
    if (is_transfusi) {
        $("#text_pernyataan_resiko_n_transfusi").show();
    } else {
        $("#text_pernyataan_resiko_n_transfusi").hide();
    }
    
}


/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
<?php if(!empty($_GET['pasienanastesi_id'])){ ?>

<?php } ?> 
    
        gotoPanel("panel_informasi");
    
        $('form').bind('click keyup select change', function(event) {
                cekDisabled(this);
        });
        $(document).on('click keyup select change',function(){
                cekDisabled('form');
        }); 
        cekDisabled('form');
});
</script>