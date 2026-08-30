<style>
    #table-lembarkerja th, td{
        text-align: center;
    }
</style>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i>Tabel Lembar Kerja Pemeriksaan Golongan Darah
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered table-condensed" width="100" id="table-lembarkerja">
            <thead>
                <tr>
                    <th colspan="12">LEMBAR KERJA PEMERIKSAAN GOLONGAN DARAH</th>
                </tr>
                <tr>
                    <th rowspan="3">Nomor Kantong</th>
                </tr>
                <tr>
                    <th colspan="2">Anti</th>
                    <th colspan="3">TES SEL 10%</th>
                    <th rowspan="2">AC</th>
                    <th rowspan="2">ANTI <br> D/ RH</th>
                    <th rowspan="2">Bv.A 6%</th>
                    <th rowspan="2">Kesimpulan</th>
                    <th rowspan="2">Tanggal Keluar</th>
                    <th rowspan="2">Aksi</th>
                </tr>
                <tr>
                    <th>A</th>
                    <th>B</th>

                    <th>A</th>
                    <th>B</th>
                    <th>O</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(count($modRiwayatGolDar) > 0) {
                        foreach($modRiwayatGolDar as $i => $data) {
                            $this->renderPartial($this->path_view . 'form/_rowLembarKerjaDenganData', ['modPemeriksaanGolDar' => $data, 'i' => $i]);

                        }
                    } else {
                        $this->renderPartial($this->path_view . 'form/_rowLembarKerja', ['modPemeriksaanGolDar' => $modPemeriksaanGolDar]);
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<input type="hidden" id="no_row">

<?php 
    $this->renderPartial($this->path_view . 'form/_dialogKantong');
?>