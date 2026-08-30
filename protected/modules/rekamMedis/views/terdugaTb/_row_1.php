<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    Riwayat Terduga TB
                </div>
            </div>
            <div class="panel-body">
                <table class="items table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Tgl. Terduga TB</th>
                            <th>Kesimpulan</th>
                            <th>Detail</th>
                            <th>Ubah</th>
                            <th>Hapus</th>
                            <th>Salin</th>
                            <th>Cetak</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $riwayat = TerdugatbT::model()->findAll();
                            $pendaftaran_id = $_GET['pendaftaran_id'];
                            foreach($riwayat as $rw){
                        ?>
                        <tr>
                            <td><?php echo $rw->tglterdugatb ?></td>
                            <td><?php echo $rw->kesimpulan ?></td>
                            <td style="text-align: center; width: 60px;">
                                <?php
                                    echo CHtml::link('<i class="icon-form-lihat"></i>', Yii::app()->controller->createUrl('view', array('pendaftaran_id'=>$pendaftaran_id, 'terdugatb_id'=>$rw->terdugatb_id, 'jenis'=>'lihat', 'type'=>(!empty($_GET['type'])?$_GET['type']:""))), array(
                                            "class" => "",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk melihat Terduga TB",
                                    ));
                                ?>
                            </td>
                            <td style="text-align: center; width: 60px;">
                                <?php
                                    echo CHtml::link('<i class="icon-form-ubah"></i>', Yii::app()->controller->createUrl('index', array('pendaftaran_id'=>$pendaftaran_id, 'terdugatb_id'=>$rw->terdugatb_id, 'jenis'=>'ubah', 'type'=>(!empty($_GET['type'])?$_GET['type']:""))), array(
                                        "class" => "",
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk mengubah Terduga TB",
                                    ));
                                ?>
                            </td>
                            <td style="text-align: center; width: 60px;">
                                <a onclick="hapusTB('<?php echo $rw->terdugatb_id; ?>', this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Terduga TB"><i class="icon-form-sampah"></i></a>
                            </td>
                            <td style="text-align: center; width: 60px;">
                                <?php
                                    echo CHtml::link('<i class="icon-form-copy"></i>', Yii::app()->controller->createUrl('index', array('pendaftaran_id'=>$pendaftaran_id, 'terdugatb_id'=>$rw->terdugatb_id, 'jenis'=>'salin', 'type'=>(!empty($_GET['type'])?$_GET['type']:""))), array(
                                        "class" => "",
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk menyalin Terduga TB",
                                    ));
                                ?>
                            </td>
                            <td style="text-align: center; width: 60px;">
                                <?php
                                    echo CHtml::link('<i class="icon-form-print"></i>', 'javascript:void(0)', array(
                                        'onclick' => "printTerdugaTB(" . $pendaftaran_id . ", " . $rw->terdugatb_id . ", 'PRINT'); return false;", 'rel' => 'tooltip', 'title' => 'Klik untuk Mencetak Terduga TB',
                                    ));
                                ?>
                            </td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>

    function hapusTB(terdugatb_id, obj) {
        tabel = obj;
        myConfirm('Apakah Anda akan menghapus Terduga TB ini?', 'Perhatian!', function (r)
        {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('hapusRiwayatTerdugaTB'); ?>',
                    data: {terdugatb_id: terdugatb_id},
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

    function printTerdugaTB(pendaftaran_id, terdugatb_id, caraPrint) {
        window.open('<?php echo $this->createUrl('printTerdugaTB'); ?>&pendaftaran_id='+pendaftaran_id+'&terdugatb_id='+terdugatb_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }

</script>