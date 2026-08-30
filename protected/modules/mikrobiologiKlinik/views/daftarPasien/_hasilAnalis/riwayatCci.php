<style>
.btn-grey {
    background-color: grey;
    color: white;
    font-weight: bold;
}

.btn-blue {
    background-color: blue;
    color: white;
    font-weight: bold;
}


.btn-green {
    background-color: green;
    color: white;
    font-weight: bold;
}


.btn-orange {
    background-color: orange;
    color: white;
    font-weight: bold;
}

.btn-red {
    background-color: red;
    color: white;
    font-weight: bold;
}

.btn-blue-rev {
    background-color: white;
    border-color: blue;
    color: blue;
    font-weight: bold;
}

.btn-group .btn-blue-rev:hover {
    background-color: blue;
    border-color: white;
    color: white;
    font-weight: bold;
}
</style>

<table class="table table-striped table-bordered table-condensed" style="width: 100%;">
    <thead>
        <tr>
            <td style="width: 5%;">No</td>
            <td style="width: 10%;">No. Lab</td>
            <td style="width: 25%;">Jenis Pemeriksaan</td>
            <td style="">Pemeriksaan</td>
            <td style="">Lihat Detail</td>
            <td style="">Ubah</td>
            <td style="">Hapus</td>

        </tr>
    </thead>
    <tbody>
        <?php
        // var_dump($model->pasienmasukpenunjang_id); die;
            $penunjang = PasienmasukpenunjangT::model()->findByPk($_GET['pasienmasukpenunjang_id']);
            $tindakan = TindakanpelayananT::model()->findAll("pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id");
        ?>
        <?php foreach ($riwayat as $no => $riwayat) {?>
        <tr>
            <td style="text-align: right;"><?= $no+1 ?></td>
            <td><?= $penunjang->no_lab ?></td>
            <td>
                <center>
                    <div class="btn-group mr-2" role="group" aria-label="Pemeriksaan">
                        <?php echo CHtml::link('CCI', $this->createUrl('Cci', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'], 'pasienmasukpenunjang_id' => $_GET['pasienmasukpenunjang_id'], 'pemeriksaan' => 'cci')), array('class' => 'btn btn-green')); ?>
                    </div>
                </center>
            </td>
            <td><?= isset($riwayat->tindakanpelayanan->daftartindakan) ? $riwayat->tindakanpelayanan->daftartindakan->daftartindakan_nama : ' - ' ?></td>
            <td class="link_col"><?php echo CHtml::link('<i class="icon-form-print"></i>', '#', array('onclick'=>'printCci(' . $riwayat->pemeriksaancci_id . ');return false;')); ?></td>
                <?php $updateLink = $this->createUrl('Cci', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'] ?? null, 'pasienmasukpenunjang_id' => $riwayat->pasienmasukpenunjang_id, 'pemeriksaan'=>'cci', 'pemeriksaancci_id'=>$riwayat->pemeriksaancci_id));?>
            <td class="link_col"><?php echo CHtml::link('<i class="icon-form-ubah"></i>', $updateLink, array('rel'=>'tooltip', 'title'=>'Klik untuk mengubah hasil pemeriksaan')); ?></td>
                <?php $onclickHapus = "hapusRiwayatCci(".$riwayat->pemeriksaancci_id.", this); return false"; ?>
            <td class="link_col"><?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>$onclickHapus, 'rel'=>'tooltip', 'title'=>'Klik untuk hapus hasil pemeriksaan')); ?></td>

        </tr>
        <?php } ?>
    </tbody>
</table>

<?php $urlCreate = $this->createUrl('hasilAnalis&penilaian_kelayakan_spesimen_id='.$_GET['penilaian_kelayakan_spesimen_id'] . '&pasienmasukpenunjang_id=' . $_GET['penilaian_kelayakan_spesimen_id']); ?>

<script>
    
    function printCci(pemeriksaancci_id) {
        window.open(
            '<?php echo $this->createUrl('printCci', array()); ?>&pemeriksaancci_id='+pemeriksaancci_id,
            'printwin', 'left=100,top=100,width=1280,height=720');
    }

    function hapusRiwayatCci(id, obj) {
        myConfirm('Anda yakin untuk menghapus hasil pemeriksaan ini ?', 'Peringatan', function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('hapusCci'); ?>', {id: id}, function(data) {
                    if (data.ok == 1) {
                        $(obj).parents("tr").remove();
                        myAlert(data.msg);
                        setTimeout(() => {
                            window.location.replace("<?php echo $urlCreate ?>");
                        }, 1000);
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
    
    $(document).ready(function() {
        $('.btn-grey').removeClass('btn-primary');
        $('.btn-blue').removeClass('btn-primary');
        $('.btn-green').removeClass('btn-primary');
    });
</script>