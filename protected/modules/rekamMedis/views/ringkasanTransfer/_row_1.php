<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    Ringkasan Transfer Pasien Intra Rumah Sakit
                </div>
            </div>
            <div class="panel-body">
                <table class="items table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Tgl Transfer</th>
                            <th>Tgl Diterima</th>
                            <th>Diagnosa Utama</th>
                            <th>Dokter yang Merawat</th>
                            <th>Petugas Pendamping 1</th>
                            <th>Petugas Pendamping 2</th>
                            <th>Petugas Penerima</th>
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
                            $modelTransfer = TransferintrarsT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
                            if (!empty($modelTransfer)) { 
                        ?>
                            <?php
                                foreach($modelTransfer as $mp => $val){
                            ?>
                            <tr>
                                <td><?php echo MyFormatter::formatDateTimeForUser($val->tgl_transfer) ?></td>
                                <td><?php echo MyFormatter::formatDateTimeForUser($val->tgl_diterima) ?></td>
                                <td><?php echo empty($val->diagnosa) ? '-' : $val->diagnosa ?></td>
                                <td><?php echo empty($val->dokter) ? '-' : $val->dokter->namaLengkap ?></td>
                                <td><?php echo empty($val->pendamping1) ? '-' : $val->pendamping1->namaLengkap ?></td>
                                <td><?php echo empty($val->pendamping2) ? '-' : $val->pendamping2->namaLengkap ?></td>
                                <td><?php echo empty($val->petugaspenerima) ? '-' : $val->petugaspenerima->namaLengkap ?></td>
                                <td style="text-align: center; width: 60px;">
                                    <?php
                                        echo CHtml::link('<i class="icon-form-lihat"></i>', Yii::app()->controller->createUrl('index', array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'transferintrars_id'=>$val->transferintrars_id, 'jenis'=>'lihat', 'type'=>(!empty($_GET['type'])?$_GET['type']:""))), array(
                                                "class" => "",
                                                "rel" => "tooltip",
                                                "title" => "Klik untuk melihat Form-A Manajemen Pelayanan",
                                        ));
                                    ?>
                                </td>
                                <td style="text-align: center; width: 60px;">
                                    <?php
                                        echo CHtml::link('<i class="icon-form-ubah"></i>', Yii::app()->controller->createUrl('index', array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'transferintrars_id'=>$val->transferintrars_id, 'jenis'=>'ubah', 'type'=>(!empty($_GET['type'])?$_GET['type']:""))), array(
                                            "class" => "",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk mengubah Form-A Manajemen Pelayanan",
                                        ));
                                    ?>
                                </td>
                                <td style="text-align: center; width: 60px;">
                                    <a onclick="hapus('<?php echo $val->transferintrars_id; ?>', this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Form-A Manajemen Pelayanan"><i class="icon-form-sampah"></i></a>
                                </td>
                                <td style="text-align: center; width: 60px;">
                                    <?php
                                        echo CHtml::link('<i class="icon-form-copy"></i>', Yii::app()->controller->createUrl('index', array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'transferintrars_id'=>$val->transferintrars_id, 'jenis'=>'salin', 'type'=>(!empty($_GET['type'])?$_GET['type']:""))), array(
                                            "class" => "",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk menyalin Form-A Manajemen Pelayanan",
                                        ));
                                    ?>
                                </td>
                                <td style="text-align: center; width: 60px;">
                                    <?php
                                        echo CHtml::link('<i class="icon-form-print"></i>', 'javascript:void(0)', array(
                                            'onclick' => "print(" . $modPendaftaran->pendaftaran_id . ", " . $val->transferintrars_id . ", 'PRINT'); return false;", 'rel' => 'tooltip', 'title' => 'Klik untuk Mencetak Form-A Manajemen Pelayanan',
                                        ));
                                        ?>
                                </td>
                            </tr>
                            <?php
                                }
                            ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="12">Data tidak ditemukan</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>

    function hapus(transferintrars_id, obj) {
        tabel = obj;
        myConfirm('Apakah Anda akan menghapus data ini?', 'Perhatian!', function (r)
        {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('hapusRiwayat'); ?>',
                    data: {transferintrars_id: transferintrars_id},
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

    function print(pendaftaran_id, transferintrars_id, caraPrint) {
        window.open('<?php echo $this->createUrl('print'); ?>&pendaftaran_id='+pendaftaran_id+'&transferintrars_id='+transferintrars_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }

</script>