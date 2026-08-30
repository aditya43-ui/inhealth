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

</script>