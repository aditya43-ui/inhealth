<style>

    .main_panel {
        text-align: center;
        border: 1px solid black;
    }

    .msg {
        margin-bottom: 10px;
    }

    .print_info_msg {
        padding-top: 50px;
    }

    .print_info {
        border: 1px solid black;
        height: 200px;
        width: 400px;
        margin-left: calc(50vw - 200px);
    }


    .msg_next {
        text-align: center;
        margin-top: calc(50vh - 10px);
    }

    .icon_large {
        font-size: 50px;
    }

</style>
<?php 
$pendaftaran = PendaftaranT::model()->countByAttributes(array(
    'pasien_id'=>$model->pasien_id,
), array(
    'condition'=>'pasienbatalperiksa_id is null',
));

$is_lama = $pendaftaran > 1;

?>
<div class="main_panel">
    <div class="msg">
        Data Pasien <?php echo $modPasien->namadepan.$modPasien->nama_pasien; ?> berhasil didaftarkan<br/>
        Silahkan Tinggu Sampai Kartu Pasien, Struk Kunjungan, dan Hak & Kewajiban Selesai Dicetak
    </div>

    <div class="print_info">
        <div class="print_info_msg">

        </div>
    </div>

    <div class="msg">
        Jika proses cetak gagal silahkan klik tombol dibawah ini atau hubungi bagian pendaftaran !
    </div>

    <div class="row-fluid" style="text-align: center;">
        <?php echo CHtml::htmlButton('<i class="entypo-print"></i> Cetak Surat Kunjungan', array(
            'class'=>'btn btn-info', 'onclick'=>'printStruk();'
        )); ?>
        <?php if (!$is_lama): ?>
        <?php echo CHtml::htmlButton('<i class="entypo-print"></i> Cetak Kartu Pasien', array(
            'class'=>'btn btn-info', 'onclick'=>'printKartu();'
        )); ?>
        <?php echo CHtml::htmlButton('<i class="entypo-print"></i> Cetak Hak dan Kewajiban', array(
            'class'=>'btn btn-info', 'onclick'=>'printHakKewajiban();'
        )); ?>
        <?php endif; ?>
        <?php 
        
        $sep = SepT::model()->findByPk($model->sep_id);
        
        echo CHtml::htmlButton('<i class="entypo-print"></i> Cetak SEP', array(
            'class'=>'btn btn-info', 'onclick'=>'printSep();', 'disabled'=>empty($sep),
        )); ?>
    </div>
    <div class="row-fluid"> <!-- Button dummy -->
        <?php echo CHtml::htmlButton('Lanjut', array(
            'class'=>'btn btn-success', 'onclick'=>'lanjut()', 'disabled'=>false
        )); ?>
    </div>
    

</div>

<div class="main_next" style="display: none;">
    <div class="msg_next">
        TERIMA KASIH SUDAH MENGGUNAKAN ANJUNGAN PASIEN MANDIRI !<br/>
        SEMOGA LEKAS SEMBUH !
    </div>
</div>



<script>

    var is_print = true;


    function printStruk() {
        $(".print_info_msg").html("Cetak Struk Kunjungan Sedang Diproses...<br/><i class='entypo-print icon_large'></i>");
        $("#frame_struk").prop('src', '<?php echo $this->createUrl('printStruk', array('id'=>$model->pendaftaran_id)); ?>');
    }

    function printKartu() {
        $(".print_info_msg").html("Cetak Kartu Pasien Sedang Diproses...<br/><i class='entypo-print icon_large'></i>");
        $("#frame_kartu").prop('src', '<?php echo $this->createUrl('printKartu', array('id'=>$modPasien->pasien_id)); ?>');
    }

    function printHakKewajiban() {
        $(".print_info_msg").html("Cetak Hak dan Kewajiban Sedang Diproses...<br/><i class='entypo-print icon_large'></i>");
        $("#frame_hak").prop('src', '<?php echo $this->createUrl('printHak', array('id'=>$modPasien->pasien_id)); ?>');
    }

    function printSep(){
        <?php if (!empty($sep)) { ?>
        $(".print_info_msg").html("Cetak SEP Sedang Diproses...<br/><i class='entypo-print icon_large'></i>");
        $("#frame_sep").prop('src', '<?php echo $this->createUrl('printSep', array('sep_id'=>$sep->sep_id,'pendaftaran_id'=>$model->pendaftaran_id)); ?>');
        // window.open('<?php // echo $this->createUrl('printSep',array('sep_id'=>$sep->sep_id,'pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin_sep','left=100,top=100,width=860,height=480');
        // $("#frame_hak").prop('src', '<?php echo $this->createUrl('printHak', array('id'=>$modPasien->pasien_id)); ?>');
        <?php } ?>
    }

    function lanjut() {
        $(".main_panel").hide();
        $(".main_next").show();
        setTimeout(function() {
            window.location.replace('<?php echo $this->createUrl('pilihAnjungan'); ?>');
        }, 3000);
    }

    $(document).ready(function() {

        $(".main-content").append('<iframe id="frame_struk" src="" hidden></iframe>');
        printStruk();

        <?php if (!$is_lama): ?>
            
        $(".main-content").append('<iframe id="frame_kartu" src="" hidden></iframe>');
        $(".main-content").append('<iframe id="frame_hak" src="" hidden></iframe>');


        printKartu();
        printHakKewajiban();

        <?php endif; ?>


        <?php if (!empty($sep)) { ?> 
            $(".main-content").append('<iframe id="frame_sep" src="" hidden></iframe>');
            printSep();
        <?php } ?>
    });
</script>