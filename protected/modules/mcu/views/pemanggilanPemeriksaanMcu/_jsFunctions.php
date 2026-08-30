<script type="text/javascript">
/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */

/*
 * untuk print pemanggilan pemeriksaan pasien mcu
 */
function print(caraPrint)
{
    var no_pemanggilan = '<?php echo isset($_GET['no_pemanggilan']) ? $_GET['no_pemanggilan'] : null ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&no_pemanggilan='+no_pemanggilan+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

$( document ).ready(function(){
	 cekDisabled($('#pemanggilanmcu-t-form'));
});
</script>
    