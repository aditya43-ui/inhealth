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

/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
<?php if(!empty($_GET['pasienanastesi_id'])){ ?>

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