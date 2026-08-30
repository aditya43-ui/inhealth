<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    Riwayat Penandaan Area Operasi
                </div>
            </div>
            <div class="panel-body">
                <table class="items table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>No Pendaftaran</th>
                            <th>Dokter Operator</th>
                            <th>Tgl Rencana Operasi</th>
                            <th>Tindakan Operasi</th>
                            <th>Detail</th>
                            <th>Ubah</th>
                            <th>Hapus</th>
                            <th>Salin</th>
                            <th>Cetak</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $modPendaftaran = PendaftaranT::model()->findByPk($_GET['pendaftaran_id']);
                            $modArea = AreaoperasiT::model()->findAllByAttributes(array('pasien_id' => $modPendaftaran->pasien_id));
                            if (!empty($modArea)) { 
                        ?>
                            <?php
                                foreach($modArea as $mp => $val){
                            ?>
                            <tr>
                                <td><?php echo !empty($val->tgl_penandaanarea) ? MyFormatter::formatDateTimeForUser($val->tgl_penandaanarea) : '-' ?></td>
                                <td><?php echo !empty($val->pendaftaran) ? $val->pendaftaran->no_pendaftaran : '-' ?></td>
                                <td><?php echo !empty($val->pegawai) ? $val->pegawai->namaLengkap : '-' ?></td>
                                <td><?php echo !empty($val->tgl_penandaanarea) ? MyFormatter::formatDateTimeForUser($val->tgl_penandaanarea) : '-' ?></td>
                                <td><?php echo !empty($val->proseduroperasi) ? $val->proseduroperasi : '-' ?></td>
                                <td style="text-align: center; width: 60px;">
                                    <?php
                                        echo CHtml::link('<i class="icon-form-lihat"></i>', Yii::app()->controller->createUrl('index', array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'areaoperasi_id'=>$val->areaoperasi_id, 'jenis'=>'lihat', 'type'=>(!empty($_GET['type'])?$_GET['type']:""))), array(
                                                "class" => "",
                                                "rel" => "tooltip",
                                                "title" => "Klik untuk melihat Penandaan Area Operasi",
                                        ));
                                    ?>
                                </td>
                                <td style="text-align: center; width: 60px;">
                                    <?php
                                        echo CHtml::link('<i class="icon-form-ubah"></i>', Yii::app()->controller->createUrl('index', array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'areaoperasi_id'=>$val->areaoperasi_id, 'jenis'=>'ubah', 'type'=>(!empty($_GET['type'])?$_GET['type']:""))), array(
                                            "class" => "",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk mengubah Penandaan Area Operasi",
                                        ));
                                    ?>
                                </td>
                                <td style="text-align: center; width: 60px;">
                                    <a onclick="hapus('<?php echo $val->areaoperasi_id; ?>', this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Penandaan Area Operasi"><i class="icon-form-sampah"></i></a>
                                </td>
                                <td style="text-align: center; width: 60px;">
                                    <?php
                                        echo CHtml::link('<i class="icon-form-copy"></i>', Yii::app()->controller->createUrl('index', array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'areaoperasi_id'=>$val->areaoperasi_id, 'jenis'=>'salin', 'type'=>(!empty($_GET['type'])?$_GET['type']:""))), array(
                                            "class" => "",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk menyalin Penandaan Area Operasi",
                                        ));
                                    ?>
                                </td>
                                <td style="text-align: center; width: 60px;">
                                    <?php
                                        echo CHtml::link('<i class="icon-form-print"></i>', 'javascript:void(0)', array(
                                            'onclick' => "print(" . $modPendaftaran->pendaftaran_id . ", " . $val->areaoperasi_id . ", 'PRINT'); return false;", 'rel' => 'tooltip', 'title' => 'Klik untuk Mencetak Penandaan Area Operasi',
                                        ));
                                    ?>
                                </td>
                            </tr>
                            <?php
                                }
                            ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="10">Data tidak ditemukan</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>

    function hapus(areaoperasi_id, obj) {
        tabel = obj;
        myConfirm('Apakah Anda akan menghapus data ini?', 'Perhatian!', function (r)
        {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('hapusRiwayat'); ?>',
                    data: {areaoperasi_id: areaoperasi_id},
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

    function print(pendaftaran_id, areaoperasi_id, caraPrint) {
        window.open('<?php echo $this->createUrl('print'); ?>&pendaftaran_id='+pendaftaran_id+'&areaoperasi_id='+areaoperasi_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }

</script>