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
            $nomor = 0;
        ?>
        <?php if(!empty($riwayat_kultur)) { ?>
        <?php foreach ($riwayat_kultur as $no => $riwayat) {?>
        <tr>
            <?php $nomor++;?>
            <td style="text-align: right;"><?= $nomor ?></td>
            <td><?= $penunjang->no_lab ?></td>
            <td><?= isset($riwayat->tindakanpelayanan->daftartindakan) ? $riwayat->tindakanpelayanan->daftartindakan->daftartindakan_nama : ' - ' ?>
            </td>
            <td>
                <center>
                    <div class="btn-group mr-2" role="group" aria-label="Pemeriksaan">
                        <?php echo CHtml::link('Kultur', $this->createUrl('pemeriksaanKultur', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'], 'pasienmasukpenunjang_id' => $_GET['pasienmasukpenunjang_id'], 'pemeriksaan' => 'kultur')), array('class' => 'btn btn-grey')); ?>
                    </div>
                </center>
            </td>
            <td class="link_col">
                <?php echo CHtml::link('<i class="icon-form-print"></i>', '#', array('onclick'=>'printKultur1(' . $riwayat->pemeriksaankultur_id . ');return false;')); ?>
            </td>
            <?php $updateLink = $this->createUrl('pemeriksaanKultur', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'] ?? null, 'pasienmasukpenunjang_id' => $riwayat->pasienmasukpenunjang_id, 'pemeriksaan'=>'kultur', 'pemeriksaankultur_id'=>$riwayat->pemeriksaankultur_id));?>
            <td class="link_col">
                <?php echo CHtml::link('<i class="icon-form-ubah"></i>', $updateLink, array('rel'=>'tooltip', 'title'=>'Klik untuk mengubah hasil pemeriksaan')); ?>
            </td>
            <?php $onclickHapus = "hapusRiwayatKultur(".$riwayat->pemeriksaankultur_id.", this); return false"; ?>
            <td class="link_col">
                <?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>$onclickHapus, 'rel'=>'tooltip', 'title'=>'Klik untuk hapus hasil pemeriksaan')); ?>
            </td>
        </tr>
        <?php } ?>
        <?php } ?>
        <?php if(!empty($riwayat_pewarnaan)) { ?>
        <?php foreach ($riwayat_pewarnaan as $no => $riwayat) {?>
        <tr>
            <?php $nomor++;?>
            <td style="text-align: right;"><?= $nomor ?></td>
            <td><?= $penunjang->no_lab ?></td>

            <td><?= isset($riwayat->tindakanpelayanan->daftartindakan) ? $riwayat->tindakanpelayanan->daftartindakan->daftartindakan_nama : ' - ' ?>
            </td>
            <td>
                <center>
                    <div class="btn-group mr-2" role="group" aria-label="Pemeriksaan">
                        <?php echo CHtml::link('Pewarnaan Langsung', $this->createUrl('pewarnaanLangsung', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'], 'pasienmasukpenunjang_id' => $_GET['pasienmasukpenunjang_id'], 'pemeriksaan' => 'pewarnaan')), array('class' => 'btn btn-blue')); ?>
                    </div>
                </center>
            </td>
            <td class="link_col">
                <?php echo CHtml::link('<i class="icon-form-print"></i>', '#', array('onclick'=>'printPewarnaan(' . $riwayat->pemeriksaanpewarnaan_id . ');return false;')); ?>
            </td>
            <?php $updateLink = $this->createUrl('pewarnaanLangsung', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'] ?? null, 'pasienmasukpenunjang_id' => $riwayat->pasienmasukpenunjang_id, 'pemeriksaan'=>'pewarnaan', 'pemeriksaanpewarnaan_id'=>$riwayat->pemeriksaanpewarnaan_id));?>
            <td class="link_col">
                <?php echo CHtml::link('<i class="icon-form-ubah"></i>', $updateLink, array('rel'=>'tooltip', 'title'=>'Klik untuk mengubah hasil pemeriksaan')); ?>
            </td>
            <?php $onclickHapus = "hapusRiwayatPewarnaan(".$riwayat->pemeriksaanpewarnaan_id.", this); return false"; ?>
            <td class="link_col">
                <?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>$onclickHapus, 'rel'=>'tooltip', 'title'=>'Klik untuk hapus hasil pemeriksaan')); ?>
            </td>

        </tr>
        <?php } ?>
        <?php } ?>
        <?php if(!empty($riwayat_cci)) { ?>
        <?php foreach ($riwayat_cci as $no => $riwayat) {?>
        <tr>
            <?php $nomor++;?>
            <td style="text-align: right;"><?= $nomor ?></td>
            <td><?= $penunjang->no_lab ?></td>
            <td><?= isset($riwayat->tindakanpelayanan->daftartindakan) ? $riwayat->tindakanpelayanan->daftartindakan->daftartindakan_nama : ' - ' ?>
            </td>
            <td>
                <center>
                    <div class="btn-group mr-2" role="group" aria-label="Pemeriksaan">
                        <?php echo CHtml::link('CCI', $this->createUrl('Cci', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'], 'pasienmasukpenunjang_id' => $_GET['pasienmasukpenunjang_id'], 'pemeriksaan' => 'cci')), array('class' => 'btn btn-green')); ?>
                    </div>
                </center>
            </td>
            <td class="link_col">
                <?php echo CHtml::link('<i class="icon-form-print"></i>', '#', array('onclick'=>'printCci(' . $riwayat->pemeriksaancci_id . ');return false;')); ?>
            </td>
            <?php $updateLink = $this->createUrl('Cci', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'] ?? null, 'pasienmasukpenunjang_id' => $riwayat->pasienmasukpenunjang_id, 'pemeriksaan'=>'cci', 'pemeriksaancci_id'=>$riwayat->pemeriksaancci_id));?>
            <td class="link_col">
                <?php echo CHtml::link('<i class="icon-form-ubah"></i>', $updateLink, array('rel'=>'tooltip', 'title'=>'Klik untuk mengubah hasil pemeriksaan')); ?>
            </td>
            <?php $onclickHapus = "hapusRiwayatCci(".$riwayat->pemeriksaancci_id.", this); return false"; ?>
            <td class="link_col">
                <?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>$onclickHapus, 'rel'=>'tooltip', 'title'=>'Klik untuk hapus hasil pemeriksaan')); ?>
            </td>

        </tr>
        <?php } ?>
        <?php } ?>
        <?php if(!empty($riwayat_pcr)) { ?>
        <?php foreach ($riwayat_pcr as $no => $riwayat) {?>
        <tr>
            <?php $nomor++;?>
            <td style="text-align: right;"><?= $nomor ?></td>
            <td><?= $penunjang->no_lab ?></td>
            <td><?= isset($riwayat->tindakanpelayanan->daftartindakan) ? $riwayat->tindakanpelayanan->daftartindakan->daftartindakan_nama : ' - ' ?>
            </td>
            <td>
                <center>
                    <div class="btn-group mr-2" role="group" aria-label="Pemeriksaan">
                        <?php echo CHtml::link('PCR Covid', $this->createUrl('PCrCovid', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'], 'pasienmasukpenunjang_id' => $_GET['pasienmasukpenunjang_id'], 'daftartindakan_id'=>$riwayat->tindakanpelayanan->daftartindakan_id, 'tindakanpelayanan_id'=>$riwayat->tindakanpelayanan_id, 'jenispemeriksaanlab_id' => $riwayat->tindakanpelayanan->jenispemeriksaanlab_id)), array('class' => 'btn btn-grey')); ?>
                    </div>
                </center>
            </td>
            <td class="link_col">
                <?php echo CHtml::link('<i class="icon-form-print"></i>', '#', array('onclick'=>'printRiwayatPCR(' . $riwayat->pemeriksaanpcr_id . ');return false;')); ?>
            </td>
            <?php $updateLink = $this->createUrl('pcrCovid', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'] ?? null, 'pasienmasukpenunjang_id' => $riwayat->pasienmasukpenunjang_id, 'daftartindakan_id'=>$riwayat->tindakanpelayanan->daftartindakan_id, 'tindakanpelayanan_id'=>$riwayat->tindakanpelayanan_id, 'pemeriksaanpcr_id'=>$riwayat->pemeriksaanpcr_id));?>
            <td class="link_col">
                <?php echo CHtml::link('<i class="icon-form-ubah"></i>', $updateLink, array('rel'=>'tooltip', 'title'=>'Klik untuk mengubah hasil pemeriksaan')); ?>
            </td>
            <?php $onclickHapus = "hapusRiwayatPCR(".$riwayat->pemeriksaanpcr_id.", this); return false";; ?>
            <td class="link_col">
                <?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>$onclickHapus, 'rel'=>'tooltip', 'title'=>'Klik untuk hapus hasil pemeriksaan')); ?>
            </td>

        </tr>
        <?php } ?>
        <?php } ?>
        <?php if(!empty($riwayat_viralload)) { ?>
        <?php foreach ($riwayat_viralload as $no => $riwayat) {?>
        <tr>
            <?php $nomor++;?>
            <td style="text-align: right;"><?= $nomor ?></td>
            <td><?= $penunjang->no_lab ?></td>
            <td><?= isset($riwayat->tindakanpelayanan->daftartindakan) ? $riwayat->tindakanpelayanan->daftartindakan->daftartindakan_nama : $riwayat->tindakanpelayanan->daftartindakan_id ?>
            </td>
            <td>
                <center>
                    <div class="btn-group mr-2" role="group" aria-label="Pemeriksaan">
                        <?php echo CHtml::link('Viral Load', $this->createUrl('viralLoad', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'], 'pasienmasukpenunjang_id' => $_GET['pasienmasukpenunjang_id'], 'pemeriksaan' => 'viralload')), array('class' => 'btn btn-red')); ?>
                    </div>
                </center>
            </td>
            <td class="link_col">
                <?php echo CHtml::link('<i class="icon-form-print"></i>', '#', array('onclick'=>'printViralLoad1(' . $riwayat->pemeriksaanviralload_id . ');return false;')); ?>
            </td>
            <?php $updateLink = $this->createUrl('viralLoad', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'] ?? null, 'pasienmasukpenunjang_id' => $riwayat->pasienmasukpenunjang_id, 'pemeriksaan'=>'pewarnaan', 'pemeriksaanviralload_id'=>$riwayat->pemeriksaanviralload_id));?>
            <td class="link_col">
                <?php echo CHtml::link('<i class="icon-form-ubah"></i>', $updateLink, array('rel'=>'tooltip', 'title'=>'Klik untuk mengubah hasil pemeriksaan')); ?>
            </td>
            <?php $onclickHapus = "hapusRiwayatViralLoad(".$riwayat->pemeriksaanviralload_id.", this); return false"; ?>
            <td class="link_col">
                <?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>$onclickHapus, 'rel'=>'tooltip', 'title'=>'Klik untuk hapus hasil pemeriksaan')); ?>
            </td>

        </tr>
        <?php } ?>
        <?php } ?>
        <?php if(!empty($riwayat_tbc)) { ?>
        <?php foreach ($riwayat_tbc as $no => $riwayat) {?>
        <tr>
            <?php $nomor++;?>
            <td style="text-align: right;"><?= $nomor ?></td>
            <td><?= $penunjang->no_lab ?></td>
            <td><?= isset($riwayat->tindakanpelayanan->daftartindakan) ? $riwayat->tindakanpelayanan->daftartindakan->daftartindakan_nama : ' - ' ?>
            </td>
            <td>
                <center>
                    <div class="btn-group mr-2" role="group" aria-label="Pemeriksaan">
                        <?php echo CHtml::link('Kultur', $this->createUrl('pemeriksaanKultur', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'], 'pasienmasukpenunjang_id' => $_GET['pasienmasukpenunjang_id'], 'pemeriksaan' => 'kultur')), array('class' => 'btn btn-grey')); ?>
                    </div>
                </center>
            </td>
            <td class="link_col">
                <?php echo CHtml::link('<i class="icon-form-print"></i>', '#', array('onclick'=>'printKultur1(' . $riwayat->pemeriksaankultur_id . ');return false;')); ?>
            </td>
            <?php $updateLink = $this->createUrl('pemeriksaanKultur', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'] ?? null, 'pasienmasukpenunjang_id' => $riwayat->pasienmasukpenunjang_id, 'pemeriksaan'=>'kultur', 'pemeriksaankultur_id'=>$riwayat->pemeriksaankultur_id));?>
            <td class="link_col">
                <?php echo CHtml::link('<i class="icon-form-ubah"></i>', $updateLink, array('rel'=>'tooltip', 'title'=>'Klik untuk mengubah hasil pemeriksaan')); ?>
            </td>
            <?php $onclickHapus = "hapusRiwayatKultur(".$riwayat->pemeriksaankultur_id.", this); return false"; ?>
            <td class="link_col">
                <?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>$onclickHapus, 'rel'=>'tooltip', 'title'=>'Klik untuk hapus hasil pemeriksaan')); ?>
            </td>

        </tr>
        <?php } ?>
        <?php } ?>

    </tbody>
</table>

<?php $urlCreate = $this->createUrl('hasilAnalis&penilaian_kelayakan_spesimen_id='.$_GET['penilaian_kelayakan_spesimen_id'] . '&pasienmasukpenunjang_id=' . $_GET['pasienmasukpenunjang_id']); ?>

<script>
function printKultur1(pemeriksaankultur_id) {
    window.open(
        '<?php echo $this->createUrl('printKultur', array()); ?>&pemeriksaankultur_id=' + pemeriksaankultur_id,
        'printwin', 'left=100,top=100,width=1280,height=720');
}

function hapusRiwayatKultur(id, obj) {
    myConfirm('Anda yakin untuk menghapus hasil pemeriksaan ini ?', 'Peringatan', function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl('hapusKultur'); ?>', {
                id: id
            }, function(data) {
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

function printPewarnaan(pemeriksaanpewarnaan_id) {
    window.open(
        '<?php echo $this->createUrl('printPewarnaan', array()); ?>&pemeriksaanpewarnaan_id=' +
        pemeriksaanpewarnaan_id,
        'printwin', 'left=100,top=100,width=1280,height=720');
}

function hapusRiwayatPewarnaan(id, obj) {
    myConfirm('Anda yakin untuk menghapus hasil pemeriksaan ini ?', 'Peringatan', function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl('hapusPewarnaan'); ?>', {
                id: id
            }, function(data) {
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

function printCci(pemeriksaancci_id) {
    window.open(
        '<?php echo $this->createUrl('printCci', array()); ?>&pemeriksaancci_id=' + pemeriksaancci_id,
        'printwin', 'left=100,top=100,width=1280,height=720');
}

function hapusRiwayatCci(id, obj) {
    myConfirm('Anda yakin untuk menghapus hasil pemeriksaan ini ?', 'Peringatan', function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl('hapusCci'); ?>', {
                id: id
            }, function(data) {
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

function printRiwayatPCR(id) {
    console.log(id, '<?php echo $this->createUrl('printPcr'); ?>&pemeriksaanpcr_id=' + id);
    window.open(
        '<?php echo $this->createUrl('printPcr'); ?>&pemeriksaanpcr_id=' + id,
        'printwin', 'left=100,top=100,width=640,height=480');
}

function hapusRiwayatPCR(id, obj) {
    myConfirm('Anda yakin untuk menghapus hasil pemeriksaan ini ?', 'Peringatan', function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl('hapusPcr'); ?>', {
                id: id
            }, function(data) {
                if (data.ok == 1) {
                    $(obj).parents("tr").remove();
                    myAlert(data.msg);
                } else {
                    myAlert(data.msg);
                }
            }, 'json');
        }
    });
}

function printViralLoad1(pemeriksaanviralload_id) {

    console.log('idne=' + pemeriksaanviralload_id);
    window.open(
        '<?php echo $this->createUrl('printViralLoad', array()); ?>&pemeriksaanviralload_id=' +
        pemeriksaanviralload_id,
        'printwin', 'left=100,top=100,width=1280,height=720');
}

function hapusRiwayatViralLoad(id, obj) {
    myConfirm('Anda yakin untuk menghapus hasil pemeriksaan ini ?', 'Peringatan', function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl('hapusViralLoad'); ?>', {
                id: id
            }, function(data) {
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
    $('.btn-orange').removeClass('btn-primary');
    $('.btn-red').removeClass('btn-primary');
});
</script>