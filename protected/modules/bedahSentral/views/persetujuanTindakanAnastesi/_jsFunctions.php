<script type="text/javascript">

/**
* untuk print surat persetujuan tindakan medis
 */
function print(caraPrint)
{
    var pasienmasukpenunjang_id = '<?php echo isset($_GET['pasienmasukpenunjang_id']) ? $_GET['pasienmasukpenunjang_id'] : null; ?>';
    var persetujuananestesi_id = '<?php echo $model->persetujuananestesi_id?>';
    window.open('<?php echo $this->createUrl('print'); ?>&pasienmasukpenunjang_id='+pasienmasukpenunjang_id+'&persetujuananestesi_id='+persetujuananestesi_id+'&caraprint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function printRiwayat(persetujuananestesi_id, caraPrint)
{
    window.open('<?php echo $this->createUrl('print'); ?>&persetujuananestesi_id='+persetujuananestesi_id+'&caraprint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function printInformasi(caraPrint)
{
    var pasienmasukpenunjang_id = '<?php echo isset($_GET['pasienmasukpenunjang_id']) ? $_GET['pasienmasukpenunjang_id'] : null; ?>';
    var persetujuananestesi_id = '<?php echo $model->persetujuananestesi_id?>';
    var informasi = '<?php echo $informasi->pemberianinformasi_id; ?>';
    window.open('<?php echo $this->createUrl('printInformasi'); ?>&persetujuananestesi_id='+persetujuananestesi_id+'&caraprint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function printInformasiRiwayat(persetujuananestesi_id, caraPrint)
{
    var informasi = '<?php echo $informasi->pemberianinformasi_id; ?>';
    window.open('<?php echo $this->createUrl('printInformasi'); ?>&persetujuananestesi_id='+persetujuananestesi_id+'&caraprint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

/**
 * Untuk validasi radio jenis anestesi
 */
function CekJenisAnestesi(obj,jenis){
    $(".jnsanestesi").removeAttr('checked');
    $(obj).attr('checked',true);
    if(jenis == "regional"){
        $(".regional").removeAttr('disabled');
        $(".regional").removeAttr('checked');
    }else{
        $(".regional").attr('disabled',true);
        $(".regional").removeAttr('checked');
    }
}

/**
 * Untuk validasi radio anastesi regional
 */
function CekJenisRegional(obj){
    $(".regional").removeAttr('checked');
    $(obj).attr('checked',true);
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
    $("#PersetujuananestesiT_namapenanggungjawab").val($("#PemberianinformasiT_penerimainformasi_nama").val());
    $("#PersetujuananestesiT_umurpenanggungjawab").val($("#PemberianinformasiT_penerimainformasi_umur").val());
    $("#PersetujuananestesiT_jeniskelamin_penanggungjawab").val($(".jeniskelamin:checked").val());
    $("#PersetujuananestesiT_alamat_penanggungjawab").val($("#PemberianinformasiT_penerimainformasi_alamat").val());
    $("#PersetujuananestesiT_jenisidentitas_penanggungjawab").val($("#PemberianinformasiT_penerimainformasi_jenisidentitas").val());
    $("#PersetujuananestesiT_noidentitas_penanggungjawab").val($("#PemberianinformasiT_penerimainformasi_noidentitas").val());
    $("#surat_jenis_anastesi").val($(".jenisanastesi:checked").val());
    $("#hubungankeluarga").val($("#PemberianinformasiT_penerimainformasi_hubungandgnpasien").val());
    $("#dokter_anestesi").val($("#PemberianinformasiT_dokterpelaksanatindakan_id :selected").data('nama'));
    $(".surat_dokteranestesi_id").val($("#PemberianinformasiT_dokterpelaksanatindakan_id").val());
    $("#PersetujuananestesiT_doktermenyetujui_id").val($("#PemberianinformasiT_dokterpelaksanatindakan_id").val());
    $('#nama_pembuatpernyataan').val($('#PemberianinformasiT_penerimainformasi_nama').val());
}

/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
    $(".regional").attr('disabled',true);
    
    $("#nama_pembuatpernyataan").val($("#PersetujuananestesiT_namapenanggungjawab").val());
    $("#identitas_pembuatpernyataan").val($("#PersetujuananestesiT_noidentitas_penanggungjawab").val());
    
    gotoPanel("panel_informasi");
    
<?php if(!empty($_GET['persetujuananestesi_id'])){ ?>

<?php } ?> 
    
        $('form').bind('click keyup select change', function(event) {
                cekDisabled(this);
        });
        $(document).on('click keyup select change',function(){
                cekDisabled('form');
        }); 
        cekDisabled('form');
});
</script>