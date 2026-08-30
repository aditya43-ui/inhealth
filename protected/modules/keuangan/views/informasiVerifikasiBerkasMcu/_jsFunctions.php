<script type="text/javascript">
/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */

/*
 * untuk print verifikasi berkas mcu
 */
function print(caraPrint)
{
    var noverifikasiberkasmcu = '<?php echo isset($_GET['noverifikasiberkasmcu']) ? $_GET['noverifikasiberkasmcu'] : null ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&noverifikasiberkasmcu='+noverifikasiberkasmcu+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

$( document ).ready(function(){
	
});
</script>
    