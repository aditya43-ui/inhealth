<script>
    function setRuangan(obj) {
        var instalasi_id = $(obj).val();

        $.post('<?= $this->createUrl('setRuangan') ?>', {
        instalasi_id:instalasi_id
        }, function(data){
            $('.ruanganasal').html(data.option);
        }, 'json');
    }

    function openDialog(pasienkirimkeunitlain_id) { 
        $.post('<?= $this->createUrl('/bankDarah/PermintaanDarahDariPelayanan/cekPenyiapanDarah') ?>', {
            pasienkirimkeunitlain_id:pasienkirimkeunitlain_id
        }, function(data){
            if(data.status < 1) {
                window.parent.myAlert('Darah belum disiapkan');
                return false;
            } else {
                $('#dialogReaksiTransfusi').dialog('open');
                url = "<?= $this->createUrl('/bankDarah/PermintaanDarahDariPelayanan/reaksiTransfusi&pasienkirimkeunitlain_id=') ?>" + pasienkirimkeunitlain_id + '&lihat=1';
                $('#iframeReaksiTransfusi').attr('src', url);
            }
        }, 'json');
        
    }
</script>