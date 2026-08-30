<script>
    function updateProgress(pasienkirimkeunitlain_id) {
        $.post('<?= $this->createUrl('updateProgres') ?>', {
            pasienkirimkeunitlain_id:pasienkirimkeunitlain_id
        }, function(data){
            if(data.sukses == 1) {
                $.fn.yiiGridView.update('permintaandarah-r-grid', {
                    data: $('#permintaandarah-r-search').serialize()
                });
            }
        }, 'json');
    }
    function printTagihan(pendaftaran_id, nopelayanan) {
         window.open('<?php echo $this->createUrl('/bankDarah/verifikasiPermintaanDarahPasien/printTindakan'); ?>&id=' + pendaftaran_id + '&nopelayanan=' + nopelayanan + '&caraPrint=PRINT', 'printwin', 'left=100,top=100,width=1000,height=640');
     }

     function cekStatus(pasienkirimkeunitlain_id, pendaftaran_id) {
        $.post('<?= $this->createUrl('cekStatus') ?>', {
            pasienkirimkeunitlain_id:pasienkirimkeunitlain_id
        }, function(data){
            if(data.sukses > 0) {
                myAlert('Lakukan pengujian golongan darah terlebih dahulu');
                return false;   
            } else {
                location.href = '<?= $this->createUrl('/bankDarah/penyiapanDarahNew/index&pendaftaran_id=') ?>' + pendaftaran_id + '&pasienkirimkeunitlain_id=' + pasienkirimkeunitlain_id
            }
        }, 'json');
     }
</script>