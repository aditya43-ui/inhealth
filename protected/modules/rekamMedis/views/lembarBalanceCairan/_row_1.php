<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    Riwayat Lembar Keseimbangan Cairan (Balance Cairan)
                </div>
            </div>
            <div class="panel-body">
                <table class="items table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Petugas Pengisi</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Infus</th>
                            <th>Transfusi</th>
                            <th>Oral</th>
                            <th>Urine</th>
                            <th>BAB</th>
                            <th>Drain</th>
                            <th>Muntah</th>
                            <th>Lain-Lain</th>
                            <th>Keterangan</th>
                            <th>Ubah</th>
                            <th>Hapus</th>
                            <th>Salin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $modPendaftaran = PendaftaranT::model()->findByPk($_GET['pendaftaran_id']);
                            $modBalance = BalancecairanT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
                            $no = 1;
                            if (!empty($modBalance)) { 
                        ?>
                            <?php
                                foreach($modBalance as $mp => $val){
                            ?>
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo empty($val->pegawai) ? '-' : $val->pegawai->namaLengkap ?></td>
                                <td><?php echo empty($val->tanggal) ? '-' : date('d M Y', strtotime($val->tanggal)) ?></td>
                                <td><?php echo empty($val->jam) ? '-' : $val->jam ?></td>
                                <td><?php echo empty($val->cairanmasuk_infus) ? '-' : $val->cairanmasuk_infus ?></td>
                                <td><?php echo empty($val->cairanmasuk_transfusi) ? '-' : $val->cairanmasuk_transfusi ?></td>
                                <td><?php echo empty($val->cairanmasuk_oral) ? '-' : $val->cairanmasuk_oral ?></td>
                                <td><?php echo empty($val->cairankeluar_urine) ? '-' : $val->cairankeluar_urine ?></td>
                                <td><?php echo empty($val->cairankeluar_bab) ? '-' : $val->cairankeluar_bab ?></td>
                                <td><?php echo empty($val->cairankeluar_drain) ? '-' : $val->cairankeluar_drain ?></td>
                                <td><?php echo empty($val->cairankeluar_muntah) ? '-' : $val->cairankeluar_muntah ?></td>
                                <td><?php echo empty($val->cairankeluar_lainnya) ? '-' : $val->cairankeluar_lainnya ?></td>
                                <td><?php echo empty($val->keterangan) ? '-' : $val->keterangan ?></td>
                                <td style="text-align: center; width: 60px;">
                                    <?php
                                        echo CHtml::link('<i class="icon-form-ubah"></i>', Yii::app()->controller->createUrl('index', array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'balancecairan_id'=>$val->balancecairan_id, 'jenis'=>'ubah', 'type'=>(!empty($_GET['type'])?$_GET['type']:""))), array(
                                            "class" => "",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk mengubah Pasien Keluar ICU",
                                        ));
                                    ?>
                                </td>
                                <td style="text-align: center; width: 60px;">
                                    <a onclick="hapus('<?php echo $val->balancecairan_id; ?>', this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Pasien Keluar ICU"><i class="icon-form-sampah"></i></a>
                                </td>
                                <td style="text-align: center; width: 60px;">
                                    <?php
                                        echo CHtml::link('<i class="icon-form-copy"></i>', Yii::app()->controller->createUrl('index', array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'balancecairan_id'=>$val->balancecairan_id, 'jenis'=>'salin', 'type'=>(!empty($_GET['type'])?$_GET['type']:""))), array(
                                            "class" => "",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk menyalin Pasien Keluar ICU",
                                        ));
                                    ?>
                                </td>
                                <!-- <td style="text-align: center; width: 60px;">
                                    <?php
                                        // echo CHtml::link('<i class="icon-form-print"></i>', 'javascript:void(0)', array(
                                        //     'onclick' => "print(" . $modPendaftaran->pendaftaran_id . ", " . $val->balancecairan_id . ", 'PRINT'); return false;", 'rel' => 'tooltip', 'title' => 'Klik untuk Mencetak Pasien Keluar ICU',
                                        // ));
                                    ?>
                                </td> -->
                            </tr>
                            <?php
                                $no++;
                                }
                            ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="16">Data tidak ditemukan</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>

    function hapus(balancecairan_id, obj) {
        tabel = obj;
        myConfirm('Apakah Anda akan menghapus data ini?', 'Perhatian!', function (r)
        {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('hapusRiwayat'); ?>',
                    data: {balancecairan_id: balancecairan_id},
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

    function print(pendaftaran_id, balancecairan_id, caraPrint) {
        window.open('<?php echo $this->createUrl('print'); ?>&pendaftaran_id='+pendaftaran_id+'&balancecairan_id='+balancecairan_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }

</script>