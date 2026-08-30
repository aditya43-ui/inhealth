<script type="text/javascript">

/**
* untuk print surat persetujuan tindakan medis
 */
function print(caraprint){
    var persetujuananestesi_id = '<?php echo isset($model->persetujuananestesi_id) ? $model->persetujuananestesi_id : ''; ?>';
    var pasienanastesi_id = <?php echo $_GET['pasienanastesi_id'] ?>;
    window.open('<?php echo $this->createUrl('print'); ?>&pasienanastesi_id='+pasienanastesi_id+'&persetujuananestesi_id='+persetujuananestesi_id+'&caraprint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
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
    
    if(jenis == "sedasiberatsedang"){
        $(".regional").attr('disabled',true);
        $(".regional").removeAttr('checked');
        $(".umum").attr('disabled',true);
        $(".umum").removeAttr('checked');
        $(".kombinasi").attr('disabled',true);
        $(".kombinasi").removeAttr('checked');
    }else if(jenis == "umum"){
        $(".regional").attr('disabled',true);
        $(".regional").removeAttr('checked');
        $(".sedasiberatsedang").attr('disabled',true);
        $(".sedasiberatsedang").removeAttr('checked');
        $(".kombinasi").attr('disabled',true);
        $(".kombinasi").removeAttr('checked');
    }else if(jenis == "kombinasi"){
        $(".regional").attr('disabled',true);
        $(".regional").removeAttr('checked');
        $(".sedasiberatsedang").attr('disabled',true);
        $(".sedasiberatsedang").removeAttr('checked');
        $(".umum").attr('disabled',true);
        $(".umum").removeAttr('checked');
    }
}

/**
 * Untuk validasi radio anastesi regional
 */
function CekJenisRegional(obj){
    $(".regional").removeAttr('checked');
    $(obj).attr('checked',true);
}

/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
    var regional_sedasi = $('#jnsanestesi_regional_sedasi');
    var regional_tnpsedasi = $('#jnsanestesi_regional_tnpsedasi');
    var regional_sab = $('#jnsanestesi_regional_sab');
    var regional_epidural = $('#jnsanestesi_regional_epidural');
    var regional_blokperifer = $('#jnsanestesi_regional_blokperifer');
    var regional_kombinasi = $('#jnsanestesi_regional_kombinasi');
    
    if( regional_sedasi.is(" :checked") || regional_tnpsedasi.is(" :checked") || regional_sab.is(" :checked") || regional_epidural.is(" :checked") || regional_blokperifer.is(" :checked") || regional_kombinasi.is(" :checked")){
        $(".regional").attr('disabled',false);
    }else{
        $(".regional").attr('disabled',true);
    }
    
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