<?php 
if (isset($caraPrint) && !isset($_GET['iframe'])){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judulKwitansi.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }     
    $this->renderPartial('application.views.headerReport.headerDefault',array('colspan'=>10));
}
?>

<style>
    th, td, div{
        font-family: Arial;
        font-size: 11pt;
    }
    .tandatangan{
        vertical-align: bottom;
        text-align: center;
    }
</style>
<table  width="84%"><tr><td>
<table style="width: 100%; border: none;">
    <tr>
        <td width="20%">No. Resep</td>
        <td width="30%">: <?php echo $model->penjualanresep->noresep;?>
        <td width="20%">Nama Pasien</td>
        <td width="30%">: <?php echo $model->pasien->no_rekam_medik; ?> - <?php echo $model->pasien->nama_pasien;?> </td>
    </tr>
    <tr>
        <td>Tgl. Resep</td>
        <td>: <?php echo $model->penjualanresep->tglresep;?></td>
        <td>Umur</td>
        <td>: <?php echo isset($model->pendaftaran->umur) ? $model->pendaftaran->umur: '-';?> 
    </tr>
    <tr>
        <td>No. Retur</td>
        <td>: <?php echo $model->noreturresep;?></td>
        <td>Alamat Pasien</td>
        <td>: <?php echo $model->pasien->alamat_pasien;?>
            <?php echo ", ".$model->pasien->kecamatan->kecamatan_nama;?>
        </td>
    </tr>
    <tr>
        <td>Tgl. Retur </td>
        <td>: <?php echo $model->tglretur?></td>
        <td>Jenis Penjamin / Penjamin</td>
        <td>: <?php echo isset($model->pendaftaran->carabayar->carabayar_nama)?$model->pendaftaran->carabayar->carabayar_nama:'-'; ?> / <?php echo isset($model->pendaftaran->penjamin->penjamin_nama)?$model->pendaftaran->penjamin->penjamin_nama:'-'; ?></td>
    </tr>
    <tr>
        <td>Ruangan Asal/Retur </td>
        <td>
            : <?php echo $model->penjualanresep->ruangan->ruangan_nama?>
            <?php 
            if($model->ruangan_id != $model->ruangan_id)
                echo "/".RuanganM::model()->findByPk($model->ruangan_id)->ruangan_nama; ?>
        </td>
    </tr>
</table>
<table style="width: 100%; border: none;">
    <thead style='border:1px solid;'>
        <th style='text-align: center;'>No.</th>
        <th style='text-align: center;'>Kode</th>
        <th style='text-align: center;'>Nama</th>
        <th style='text-align: center;'>Harga Retur</th>
        <!--<th style='text-align: center;'>Jumlah Jual</th>-->        
        <th style='text-align: center;'>Jumlah Retur</th>
        <!--<th style='text-align: center;'>Jumlah Setelah Retur</th>-->
        <th style='text-align: center;'>Kondisi Obat</th>        
        <th style='text-align: center;'>Sub Total</th>        
        <th style='text-align: center;'>Keterangan</th>        
    </thead>
    <tbody>
    <?php
    $no=1;
    $totalSubTotal = 0;
	$subtotal = 0;
    if (count((array)$modDetail) > 0){
        foreach($modDetail AS $i=>$data){
            $subtotal = $data->qty_retur * $data->hargasatuan;
            echo "<tr style='border:1px solid;''>
                <td>".$no."</td>
                <td>".$data->obatpasien->obatalkes->obatalkes_kode."</td>
                <td>".$data->obatpasien->obatalkes->obatalkes_nama."</td>
                <td style='text-align: center;'>".MyFormatter::formatNumberForPrint($data->hargasatuan)."</td>            
                <td style='text-align: center;'>".$data->qty_retur."</td>            
                <td>".$data->kondisibrg."</td>            
                <td style='text-align: center;'>".MyFormatter::formatNumberForPrint($subtotal)."</td>            
                <td style='text-align: center;'>".(!empty($data->oasudahbayar_id) ? "Sudah Lunas" : "Belum Lunas")."</td>            
             </tr>";  
        $no++;
        }
//        <td style='text-align: center;'>".($data->obatpasien->qty_oa+$data->qty_retur)."</td>
//        <td style='text-align: center;'>".$data->obatpasien->qty_oa."</td>
    }
    ?>
    <tr style='border:1px solid;'>
        <td colspan="6">Total : </td>
        <td style='text-align: center;'><?php echo MyFormatter::formatNumberForPrint($subtotal); ?></td>
    </tr>
    </tbody>
</table>

<table>
    <tr><td><?php echo Yii::app()->user->getState('kabupaten_nama').', '.date('d-M-Y'); ?></td></tr>
    <tr><td>Yang membuat,</td></tr>
    <tr><td>Petugas I</td><td></td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td><?php echo Yii::app()->user->getState('nama_pegawai'); ?></td><td></tr>
</table>
