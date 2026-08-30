<table class="items table table-striped table-bordered table-condensed">
    <thead>
        <tr>
            <th>No. Pendaftaran / <br> Tgl Pendaftaran</th>
            <th>Tgl Pelayanan Pembedahan / <br> Tgl Permintaan Bedah</th>
            <th>Tindakan</th>
            <th>Detail</th>
            <th>Ubah</th>
            <th>Salin</th>
            <th>Hapus</th>
            <th>Cetak</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $riwayat = PelayananpembedahanT::model()->findAll();
            $pendaftaran_id = $_GET['pendaftaran_id'];
            foreach($riwayat as $rw){
        ?>
        <tr>
            <td><?php echo $rw->pendaftaran->no_pendaftaran . ' / <br>' . $rw->pendaftaran->tgl_pendaftaran ?></td>
            <td><?php echo (empty($rw->tanggal) ? '-' : $rw->tanggal) . '/ <br>' . (empty($rw->pasienkirimkeunitlain) ? '-' : $rw->pasienkirimkeunitlain->tgl_kirimpasien) ?></td>
            <td><?php echo empty($rw->pasienicd9cm) ? '-' : $rw->pasienicd9cm->diagnosatindakan->diagnosaicdix_nama ?></td>
            <td style="text-align: center; width: 60px;">
                <?php
                    echo CHtml::link('<i class="icon-form-lihat"></i>', Yii::app()->controller->createUrl('index', array('pendaftaran_id'=>$pendaftaran_id, 'pelayananpembedahan_id'=>$rw->pelayananpembedahan_id, 'jenis'=>'lihat', 'type'=>(!empty($_GET['type'])?$_GET['type']:""))), array(
                            "class" => "",
                            "rel" => "tooltip",
                            "title" => "Klik untuk melihat riwayat bedah",
                    ));
                ?>
            </td>
            <td style="text-align: center; width: 60px;">
                <?php
                    echo CHtml::link('<i class="icon-form-ubah"></i>', Yii::app()->controller->createUrl('index', array('pendaftaran_id'=>$pendaftaran_id, 'pelayananpembedahan_id'=>$rw->pelayananpembedahan_id, 'jenis'=>'ubah', 'type'=>(!empty($_GET['type'])?$_GET['type']:""))), array(
                        "class" => "",
                        "rel" => "tooltip",
                        "title" => "Klik untuk mengubah riwayat bedah",
                    ));
                ?>
            </td>
            <td style="text-align: center; width: 60px;">
                <?php
                    echo CHtml::link('<i class="icon-form-copy"></i>', Yii::app()->controller->createUrl('index', array('pendaftaran_id'=>$pendaftaran_id, 'pelayananpembedahan_id'=>$rw->pelayananpembedahan_id, 'jenis'=>'salin', 'type'=>(!empty($_GET['type'])?$_GET['type']:""))), array(
                        "class" => "",
                        "rel" => "tooltip",
                        "title" => "Klik untuk menyalin riwayat bedah",
                    ));
                ?>
            </td>
            <td style="text-align: center; width: 60px;">
                <a onclick="hapusRiwayat('<?php echo $rw->pelayananpembedahan_id; ?>', this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus riwayat bedah"><i class="icon-form-sampah"></i></a>
            </td>
            <td style="text-align: center; width: 60px;">
                <?php
                    echo CHtml::link('<i class="icon-form-print"></i>', 'javascript:void(0)', array(
                        'onclick' => "printRiwayatPelayanan(" . $pendaftaran_id . ", " . $rw->pelayananpembedahan_id . ", 'PRINT'); return false;", 'rel' => 'tooltip', 'title' => 'Klik untuk Mencetak riwayat bedah',
                    ));
                ?>
            </td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>
<script>

    function hapusRiwayat(pelayananpembedahan_id, obj) {
        tabel = obj;
        myConfirm('Apakah Anda akan menghapus riwayat bedah ini?', 'Perhatian!', function (r)
        {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('hapusRiwayatPelayanan'); ?>',
                    data: {pelayananpembedahan_id: pelayananpembedahan_id},
                    dataType: "json",
                    success: function (data) {
                        if (data.sukses) {
                            var delete_row = $(tabel).parents('tr');
                            delete_row.detach();
                        }
                        location.reload(true); 
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });
    }

    function printRiwayatPelayanan(pendaftaran_id, pelayananpembedahan_id, caraPrint) {
        window.open('<?php echo $this->createUrl('printRiwayatPelayanan'); ?>&pendaftaran_id='+pendaftaran_id+'&pelayananpembedahan_id='+pelayananpembedahan_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }

</script>