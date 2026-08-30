<?php
/**
* - digunakan untuk menampung semua script javascript, agar mudah di tracing
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
?>
<script>
    function printInformasi(caraPrint){		
            window.open('<?php echo $this->createUrl('printInformasi'); ?>/'+$('#kpinfohukumanpoinpeg-v-search').serialize()+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640,scrollbars=1');
    }
</script>