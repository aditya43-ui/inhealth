<?php 
    $suratperjanjiankerja_id = $_GET['suratperjanjiankerja_id'];
    $urlGetRiwayat = $this->createUrl('GetRiwayat');

?>
<script type='text/javascript'>
    function cekForm(){                                          
        if (requiredCheck($("#notadinasppk-t-form"))){
            
            $('#notadinasppk-t-form').submit();
        }
       return false;
    }
    
    function print() {
        window.open('<?php echo $this->createUrl('print', array('id' => $model->notadinasppk_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }
    function cekRiwayat(obj) {
        var suratperjanjiankerja_id = <?php echo $suratperjanjiankerja_id ?>;
        if (suratperjanjiankerja_id !== "") {
            $.post("<?php echo $urlGetRiwayat ?>", {suratperjanjiankerja_id: suratperjanjiankerja_id, },
                    function (data) {
                        $("#tableRiwayat").children("tbody").append(data.tr);
                    }, "json");
        } else {
            myAlert("Silahkan pilih data Surat Perjanjian Kerja !");
        }
        return false;

    }

    $(document).ready(function () {
        cekRiwayat();

    });
   
</script>
