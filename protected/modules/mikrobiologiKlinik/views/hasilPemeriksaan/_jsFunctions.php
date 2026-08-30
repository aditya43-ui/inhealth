<script type="text/javascript">

    /**
     * memanggil antrian ke radiologi
     * @param {type} pasienkirimkeunitlain_id
     * @returns {undefined} */
    function panggilAntrian(pasienkirimkeunitlain_id, jml_panggil) {
        if (jml_panggil >= 3) {
            myAlert("Antrian sudah dipanggil sebanyak 3 kali");
            return false;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('Panggil'); ?>',
                data: {pasienkirimkeunitlain_id: pasienkirimkeunitlain_id},
                dataType: "json",
                success: function (data) {
                    if (data.status !== "") {
                        myAlert(data.pesan);
                    }else{
                        myAlert(data.pesan);
                        <?php if (Yii::app()->user->getState('is_nodejsaktif')) { ?>
                            socket.emit('send', {conversationID: 'antrian', panggil: 91, antrian_id: pasienkirimkeunitlain_id});
                        <?php } ?>
                    }
                    $.fn.yiiGridView.update('pasienpenunjangrujukan-m-grid');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    function printPewarnaan(id) {
    window.open(
        '<?php echo $this->createUrl('/mikrobiologiKlinik/daftarPasien/printPewarnaan', array()); ?>&pemeriksaanpewarnaan_id='+id,
        'printwin', 'left=100,top=100,width=960,height=720');
}

function printKultur(id) {
    window.open(
        '<?php echo $this->createUrl('/mikrobiologiKlinik/daftarPasien/printKultur', array()); ?>&pemeriksaankultur_id='+id,
        'printwin', 'left=100,top=100,width=640,height=480');
}

function printPcr(id) {
        console.log(id, '<?php echo $this->createUrl('printPcr'); ?>&pemeriksaanpcr_id=' + id);
        window.open(
            '<?php echo $this->createUrl('/mikrobiologiKlinik/daftarPasien/printPcr'); ?>&pemeriksaanpcr_id=' + id,
            'printwin', 'left=100,top=100,width=640,height=480');
    }



</script>