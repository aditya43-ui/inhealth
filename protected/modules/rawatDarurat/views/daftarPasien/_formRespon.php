<?php 

$respon = RespontimeR::model()->findByAttributes(array(
    'pendaftaran_id'=>$data->pendaftaran_id,
));
?>
<?php if (!empty($respon)): ?>
<div style="width: 200px">
    <div>
        <strong>Jam Datang : </strong>
        <?php echo !empty($respon->tgldatang) ? date('H:i', strtotime($respon->tgldatang)) : "-"; ?>
    </div>
    <div>
        <strong>Jam Periksa : </strong>
        <?php echo !empty($respon->tglperiksa) ? date('H:i', strtotime($respon->tglperiksa)) : "-"; ?>
    </div>
    <br/>
    <div>
        <strong>Dokter Konsulen : </strong>
        <?php 
        if (!empty($respon->pegawai_id)) {
            $peg = PegawaiM::model()->findByPk($respon->pegawai_id);
            echo $peg->namaLengkap;
        } else {
            echo "-";
        }
        ?>
    </div>
    <br/>
    <div>
        <strong>Jam Konsul : </strong>
        <?php echo !empty($respon->tglkonsul) ? date('H:i', strtotime($respon->tglkonsul)) : "-"; ?>
    </div>
    <div>
        <strong>Jam Respon : </strong>
        <?php echo !empty($respon->tglrespon) ? date('H:i', strtotime($respon->tglrespon)) : "-"; ?>
    </div>
    <div>
        <strong>Jam Keluar : </strong>
        <?php echo !empty($respon->tglkeluar) ? date('H:i', strtotime($respon->tglkeluar)) : "-"; ?>
    </div>
    <hr/>
    <div>
        <strong>Respon Time I : </strong>
        <?php echo $respon->getResponTime(1, "menit"); ?>
    </div>
    <div>
        <strong>Respon Time II : </strong>
        <?php echo $respon->getResponTime(2, "menit"); ?>
    </div>
    <div>
        <strong>Respon Time III : </strong>
        <?php echo $respon->getResponTime(3, "menit"); ?>
    </div>
</div>
<?php endif; ?>