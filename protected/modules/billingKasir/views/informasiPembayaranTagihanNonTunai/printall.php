<?php
// echo "<pre>";
// var_dump($model);die;
?>
<style>
     .tabel-rincian th, .tabel-rincian td  {
  border: 1px solid;
}
</style>
<div style="margin-top:20px">
    <table width="100%" class="header">
        <tr>
            <td>
                <div>
                    <?php echo CHtml::image(Yii::app()->getBaseUrl('webroot') . "/images/dokter/logo_rssacpt.png", 'RSSACPT', array(
                                'style' => 'width: 200px; margin-top: -20px;')); ?>
                </div>
            </td>
            <td>
                RINCIAN PEMBAYARAN NON TUNAI
            </td>
        </tr>
    </table>
</div>
<?php 
    $grp = array();
    foreach ($model as $item){
        if (empty($grp[$item->jnspembayar_nama])) {
            $grp[$item->jnspembayar_nama] = array(
                'nama' => $item->jnspembayar_nama,
                'content' => array(),
            );
        }
        array_push($grp[$item->jnspembayar_nama]['content'], array(
            'nopembayaran'=>$item->nopembayaran,
            'instalasi_nama'=>$item->instalasi_nama,
            'nama_pasien' =>$item->nama_pasien,
            'no_rekam_medik' =>$item->no_rekam_medik,
            'nokartu'=>$item->nokartu,
            'jumlahpembayaran' =>$item->jumlahpembayaran,
        
        ));
        
    }
    // echo"<pre>";
    //     var_dump($grp);
    // die;
?>
<table width="100%" style="border: 1px solid;" class="tabel-rincian">
    <thead>
        <th style='text-align: center;'>No.</th>
        <th style='text-align: center;'>No INV</th>
        <th style='text-align: center;'>Nama Pasien</th>
        <th style='text-align: center;'>No. RM</th>
        <th style='text-align: center;'>No.Reg</th>
        <th style='text-align: center;'>No. Kartu</th>
        <th style='text-align: center;' hidden>Dokter</th>
        <th style='text-align: center;'>Jumlah</th>
    </thead>
    <tbody>
        <?php 
        foreach ($grp as $item):
            $subtotals = 0;
        ?>
        <tr>
            <td colspan="7">
                <b><?php echo $item['nama']?></b>
            </td>
        </tr>
        <?php
        $i = 0;
        foreach ($item['content'] as $item2) :
            $i++;
            // var_dump($item);die;

        ?>
            <tr>
                <td>
                    <?php echo $i ?>
                </td>
                <td>
                    <?php echo $item2['nopembayaran'] ?>
                </td>
                <td>
                    <?php echo $item2['instalasi_nama'] ?>
                </td>
                <td>
                    <?php echo $item2['nama_pasien'] ?>
                </td>
                <td>
                    <?php echo $item2['no_rekam_medik'] ?>
                </td>
                <td>
                    <?php echo !empty($item2['nokartu']) ? $item2['nokartu'] : '-'; ?>
                </td>
                <td>
                    <?php echo MyFormatter::formatNumberForPrint($item2['jumlahpembayaran']) ?>
                </td>

            </tr>
            <?php
                $subtotals = $subtotals + $item2['jumlahpembayaran'];
            ?>
            <?php endforeach; ?>
            <tr>
                <td colspan="6" style="text-align: right;"><b>Subtotal:  &nbsp;<b></td>
                <td style="text-align: left;"><?php echo MyFormatter::formatNumberForPrint($subtotals); ?></td>
            </tr>
        <?php
        endforeach; ?>
    </tbody>
</table>