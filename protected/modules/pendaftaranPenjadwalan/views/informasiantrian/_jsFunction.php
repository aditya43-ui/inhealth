<?php 
$linkRJ = $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan'); 
$linkPJ = $this->createUrl('/pendaftaranPenjadwalan/pendaftaranPenunjang'); 
$linkRI = $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatInap'); 
?>

<script>

var urlRJ = '<?php echo $linkRJ; ?>';
var urlPJ = '<?php echo $linkPJ; ?>';
var urlRI = '<?php echo $linkRI; ?>';

function panggilAntrian(id) {
    $.ajax({
        type:'POST',
        url:'<?php echo Yii::app()->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/panggil'); ?>&antrian_id='+id+'&ket=',
        data: {},
        dataType: "json",
        success:function(data){
            if(data.pesan !== ""){
                myAlert(data.pesan);
            } else {
                myAlert("Antrian berhasil dipanggil.");
            }
            
            $.fn.yiiGridView.update('ppinformasiantrianpasien-grid');
            
            <?php if(Yii::app()->user->getState('is_nodejsaktif')){ ?>
                socket.emit('send',{conversationID:'antrian',panggil:1,antrian_id:id});
            <?php } ?>
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function daftarPasien(obj, id) {
    var antrian_id = id;
    var val = $(obj).val();
    
    if (val == 1) {
        window.location.replace(urlRJ + "&idAntrian=" + antrian_id);
    } else if (val == 2) {
        window.location.replace(urlPJ + "&idAntrian=" + antrian_id);
    } else if (val == 3) {
        window.location.replace(urlRI + "&idAntrian=" + antrian_id);
    }
}
</script>