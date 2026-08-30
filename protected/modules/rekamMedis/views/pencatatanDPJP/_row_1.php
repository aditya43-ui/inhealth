<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    Riwayat Form Pencatatan Dokter Penanggung Jawab Pelayanan (DPJP)
                </div>
            </div>
            <div class="panel-body">
                <table class="items table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>No Pendaftaran</th>
                            <th>Tanggal</th>
                            <th>Nama Petugas</th>
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
                            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                            $modPencatatan = PencatatandpjpT::model()->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id));
                            if (!empty($modPencatatan)) { 
                        ?>
                            <?php
                                $pendaftaran_id = $_GET['pendaftaran_id'];
                                foreach($modPencatatan as $mp => $val){
                            ?>
                            <tr>
                                <td><?php echo $val->pendaftaran->no_pendaftaran ?></td>
                                <td><?php echo MyFormatter::formatDateTimeForUser($val->tanggal) ?></td>
                                <td><?php echo $val->pegawai->namaLengkap ?></td>
                                <td style="text-align: center; width: 60px;">
                                    <?php
                                        echo CHtml::link('<i class="icon-form-lihat"></i>', Yii::app()->controller->createUrl('index', array('pendaftaran_id'=>$pendaftaran_id, 'pencatatandpjp_id'=>$val->pencatatandpjp_id, 'jenis'=>'lihat', 'type'=>(!empty($_GET['type'])?$_GET['type']:""))), array(
                                                "class" => "",
                                                "rel" => "tooltip",
                                                "title" => "Klik untuk melihat Pencatatan DPJP",
                                        ));
                                    ?>
                                </td>
                                <td style="text-align: center; width: 60px;">
                                    <?php
                                        echo CHtml::link('<i class="icon-form-ubah"></i>', Yii::app()->controller->createUrl('index', array('pendaftaran_id'=>$pendaftaran_id, 'pencatatandpjp_id'=>$val->pencatatandpjp_id, 'jenis'=>'ubah', 'type'=>(!empty($_GET['type'])?$_GET['type']:""))), array(
                                            "class" => "",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk mengubah Pencatatan DPJP",
                                        ));
                                    ?>
                                </td>
                                <td style="text-align: center; width: 60px;">
                                    <a onclick="hapusDPJP('<?php echo $val->pencatatandpjp_id; ?>', this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Pencatatan DPJP"><i class="icon-form-sampah"></i></a>
                                </td>
                                <td style="text-align: center; width: 60px;">
                                    <?php
                                        echo CHtml::link('<i class="icon-form-copy"></i>', Yii::app()->controller->createUrl('index', array('pendaftaran_id'=>$pendaftaran_id, 'pencatatandpjp_id'=>$val->pencatatandpjp_id, 'jenis'=>'salin', 'type'=>(!empty($_GET['type'])?$_GET['type']:""))), array(
                                            "class" => "",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk menyalin Pencatatan DPJP",
                                        ));
                                    ?>
                                </td>
                                <td style="text-align: center; width: 60px;">
                                    <?php
                                        echo CHtml::link('<i class="icon-form-print"></i>', 'javascript:void(0)', array(
                                            'onclick' => "printPencatatanDPJP(" . $pendaftaran_id . ", " . $val->pencatatandpjp_id . ", 'PRINT'); return false;", 'rel' => 'tooltip', 'title' => 'Klik untuk Mencetak Pencatatan DPJP',
                                        ));
                                    ?>
                                </td>
                            </tr>
                            <?php
                                }
                            ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="8">Data tidak ditemukan</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>

    function hapusDPJP(pencatatandpjp_id, obj) {
        tabel = obj;
        myConfirm('Apakah Anda akan menghapus Pencatatan DPJP ini?', 'Perhatian!', function (r)
        {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('hapusRiwayatPencatatanDPJP'); ?>',
                    data: {pencatatandpjp_id: pencatatandpjp_id},
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

    function printPencatatanDPJP(pendaftaran_id, pencatatandpjp_id, caraPrint) {
        window.open('<?php echo $this->createUrl('printPencatatanDPJP'); ?>&pendaftaran_id='+pendaftaran_id+'&pencatatandpjp_id='+pencatatandpjp_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }

</script>