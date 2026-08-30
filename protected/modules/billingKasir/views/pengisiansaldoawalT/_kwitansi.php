<style>
img{
    height:90px!important;
    width:90px!important;
}
footer{
    display:none;
}
table{
    border:none;
}
</style>
<?php 
  
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDFNew',
        array(
            'judulLaporan'=>'Pengisian Saldo Awal',
            // 'periode'=>$data['periode']
        )
    );
?>


<div class="row">
<table class="table">
    <tr>
        <td style="width:50%;">
        <table>
            <tr>
                <td>Tanggal Pengisian Saldo</td>
                <td>:</td>
                <td><?= $model->tglpengisiansaldo?></td>
            </tr>
            <tr>
                <td>Cabang</td>
                <td>:</td>
                <td><?= $model->nama_rumahsakit?></td>
            </tr>
            <tr>
                <td>Ruangan</td>
                <td>:</td>
                <td><?= $model->ruangan_nama?></td>
            </tr>
            <tr>
                <td>Cabang</td>
                <td>:</td>
                <td><?= $model->shift ? $model->shift->shift_nama : '-'?></td>
            </tr>
        </table>
        </td>
        <td style="width:50%;">
        <table>
            <tr>
                <td>Pegawai</td>
                <td>:</td>
                <td><?= $model->pegawai ? $model->pegawai->nama_pegawai : '-'?></td>
            </tr>
            <tr>
                <td>Nilai Saldo Awal</td>
                <td>:</td>
                <td><?= 'Rp. '. number_format($model->nilaisaldoawal)?></td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td>:</td>
                <td><?= $model->keterangan?></td>
            </tr>
        </table>
        </td>
    </tr>
</table>
    <!-- <div class="col-sm-6">
        <table>
            <tr>
                <td>Tanggal Pengisian Saldo</td>
                <td>:</td>
                <td><?= $model->tglpengisiansaldo?></td>
            </tr>
            <tr>
                <td>Cabang</td>
                <td>:</td>
                <td><?= $model->nama_rumahsakit?></td>
            </tr>
            <tr>
                <td>Ruangan</td>
                <td>:</td>
                <td><?= $model->ruangan_nama?></td>
            </tr>
            <tr>
                <td>Cabang</td>
                <td>:</td>
                <td><?= $model->shift ? $model->shift->shift_nama : '-'?></td>
            </tr>
        </table>
    </div>
    <div class="col-sm-6">
        <table>
            <tr>
                <td>Tanggal Pengisian Saldo</td>
                <td>:</td>
                <td><?= $model->tglpengisiansaldo?></td>
            </tr>
            <tr>
                <td>Cabang</td>
                <td>:</td>
                <td><?= $model->nama_rumahsakit?></td>
            </tr>
            <tr>
                <td>Ruangan</td>
                <td>:</td>
                <td><?= $model->ruangan_nama?></td>
            </tr>
            <tr>
                <td>Cabang</td>
                <td>:</td>
                <td><?= $model->shift ? $model->shift->shift_nama : '-'?></td>
            </tr>
        </table>
    </div> -->
  
</div>