<?php if($is_meninggal):?>
<br><div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Diagnosa Kematian (ICD 10)
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php 
            echo CHtml::htmlButton(
                '<i class="icon-plus icon-white"></i> Tambah Diagnosa ICD 10',
                array(
                    'onclick' => '$("#dialogDiagnosaKematian").dialog("open")',
                    'class' => 'btn btn-primary',
                    'rel' => "tooltip",
                    'title' => "Klik untuk menambahkan Diagnosa 10 Pasien",
                )
            );
        ?>
<!-- cara keluar meninggal dunia -->
        <div class="div-table-diagnosameninggal table-responsive">
            <table class="table table-striped table-condensed" id="table-diagnosameninggal">
                <thead>
                    <th>No</th>
                    <th>Kode Diagnosa</th>
                    <th>Nama Diagnosa</th>
                    <th>Nama Lain</th>
                    <th>Hapus</th>
                </thead>
                <tbody>
                    <?php if(!empty($riwayatMortalitas)) 
                        foreach ($riwayatMortalitas as $ii => $val) {
                            $this->renderPartial($this->path_view . '_rowDiagnosaKematian', [
                                'jumlahtr' => $ii,
                                'diagnosa_id' => $val->diagnosa_id,
                                'diagnosa_nama' => $val->diagnosa->diagnosa_nama,
                                'diagnosa_kode' => $val->diagnosa->diagnosa_kode,
                                'diagnosa_namalainnya' => $val->diagnosa->diagnosa_namalainnya,
                                'mortalitas_id' => $val->mortalitas_id
                            ]);
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif;?>
