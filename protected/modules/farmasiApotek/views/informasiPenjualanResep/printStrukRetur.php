<?php // $this->renderPartial('application.views.headerReport.headerDefault',array('colspan'=>10)); ?>
<!--<div style="height: 3cm;"></div>-->
<style>
    
    body {
        color: black;
    }
    
    th, td, div{
        font-family: Arial;
        font-size: 10pt;
        padding: 2px;
    }
    .tandatangan{
        vertical-align: bottom;
        text-align: center;
    }
    
    .tab_detail {
        margin-top: 10px;
    }
    
    .tab_detail th {
        font-weight: bold;
    }
    
    .tab_detail td, .tab_detail th {
        border: 1px solid black;
    }
</style>

<?php echo $this->renderPartial('application.views.headerReport.headerPrint'); ?>

<table  width="100%"><tr><td>
<table style="width: 100%; border: none;">
    <tr>
        <td>No. Penjualan</td>
        <td width="100%">: <?php echo $modPenjualan->noresep;?>
        <td>Nama Pasien</td>
        <td nowrap>: <?php echo $modPenjualan->pasien->no_rekam_medik; ?> - <?php echo $modPenjualan->pasien->nama_pasien;?> </td>
    </tr>
    <tr>
        <td>Tgl. Penjualan</td>
        <td>: <?php echo MyFormatter::formatDateTimeForUser($modPenjualan->tglpenjualan);?></td>
        <td>Umur</td>
        <td nowrap>: <?php echo isset($modPenjualan->pendaftaran->umur)?$modPenjualan->pendaftaran->umur:'-';?> 
    </tr>
    <tr>
        <td>No. Retur</td>
        <td>: <?php echo $modRetur->noreturresep;?></td>
        <td>Alamat Pasien</td>
        <td nowrap>: <?php echo $modPenjualan->pasien->alamat_pasien;?>
            <?php // echo ", ".$modPenjualan->pendaftaran->pasien->kelurahan->kelurahan_nama;?>
            <?php echo ", ".$modPenjualan->pasien->kecamatan->kecamatan_nama;?>
            <?php // echo ", ".$modPenjualan->pendaftaran->pasien->kabupaten->kabupaten_nama;?>
        </td>
    </tr>
    <tr>
        <td>Tgl. Retur </td>
        <td>: <?php echo $modRetur->tglretur?></td>
        <td nowrap>Jenis Penjamin / Penjamin</td>
        <td nowrap>: <?php echo isset($modPenjualan->pendaftaran->carabayar->carabayar_nama)?$modPenjualan->pendaftaran->carabayar->carabayar_nama:'-'; ?> / <?php echo isset($modPenjualan->pendaftaran->penjamin->penjamin_nama)?$modPenjualan->pendaftaran->penjamin->penjamin_nama:'-'; ?></td>
    </tr>
    <tr>
        <td nowrap>Ruangan Asal/Retur </td>
        <td>
            : <?php echo $modPenjualan->ruangan->ruangan_nama?>
            <?php 
            if($modPenjualan->ruangan_id != $modRetur->ruangan_id)
                echo "/".RuanganM::model()->findByPk($modRetur->ruangan_id)->ruangan_nama; ?>
        </td>
        
    </tr>
</table>
<table width="100%" class="tab_detail">
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
        <th style='text-align: center;'>Status Pengembalian<br>Uang Retur</th>
    </thead>
    <?php
    $no=1;
    $totalSubTotal = 0;
    if (count((array)$modReturDetail) > 0){
        foreach($modReturDetail AS $tampilData):
        $subtotal = $tampilData->qty_retur * $tampilData->hargasatuan;
//            $modObat = ObatalkesM::findByPk($tampilData->obatpasien->obatalkes_id);
        echo "<tr style='border:1px solid;''>
            <td>".$no."</td>
            <td>".$tampilData->obatpasien->obatalkes->obatalkes_kode."</td>
            <td>".$tampilData->obatpasien->obatalkes->obatalkes_nama."</td>
            <td style='text-align: center;'>".MyFormatter::formatNumberForPrint($tampilData->hargasatuan)."</td>            
            <td style='text-align: center;'>".$tampilData->qty_retur."</td>            
            <td>".$tampilData->kondisibrg."</td>            
            <td style='text-align: center;'>".MyFormatter::formatNumberForPrint($subtotal)."</td>".            
            "<td style='text-align: center;'>".(!empty($tampilData->oasudahbayar_id) ? "Lunas" : "Belum")."</td>".          
        "</tr>";  
        $no++;
        endforeach;
//        <td style='text-align: center;'>".($tampilData->obatpasien->qty_oa+$tampilData->qty_retur)."</td>
//        <td style='text-align: center;'>".$tampilData->obatpasien->qty_oa."</td>
    }
    ?>
</table>
<table style="width:100%;">
    <tr>
        <td style="border: 1px solid;">Alasan Retur :<br>
        <?php echo $modRetur->alasanretur; ?>
        </td>
        <td style="border: 1px solid;">Keterangan Retur :<br>
        <?php echo $modRetur->keteranganretur; ?>
        </td>
    </tr>
</table>
            

<?php if (isset($_GET['caraPrint'])): ?>
            
<table style="width:100%;">
    <tr>
        <td class="tandatangan">Penerima</td>
        <td class="tandatangan">Mengetahui,</td>
        <td class="tandatangan">Hormat Kami,</td>
    </tr>
    <tr>
        <td class="tandatangan" style="height: 50px;">.........................</td>
        <td class="tandatangan">
            <?php 
            echo (isset($modMengetahuiRetur->gelardepan) ? $modMengetahuiRetur->gelardepan : "")." ".(isset($modMengetahuiRetur->nama_pegawai) ? $modMengetahuiRetur->nama_pegawai : "")."., ".(isset($modMengetahuiRetur->gelarbelakang->gelarbelakang_nama) ? $modMengetahuiRetur->gelarbelakang->gelarbelakang_nama : ""); ?>
        </td>
        <td class="tandatangan">
            <?php 
            echo (isset($modPegawaiRetur->gelardepan) ? $modPegawaiRetur->gelardepan:"")." ".(isset($modPegawaiRetur->nama_pegawai) ? $modPegawaiRetur->nama_pegawai : "")."., ".(isset($modPegawaiRetur->gelarbelakang->gelarbelakang_nama) ? $modPegawaiRetur->gelarbelakang->gelarbelakang_nama : ""); ?>
        </td>
    </tr>
</table>
<div style="font-size: 9pt;">Print Date: <?php echo Yii::app()->user->getState('nama_pegawai'); ?>
    <?php echo date('d M Y H:i:s'); ?></div>
</td></tr></table>

<?php else: 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'disabled'=>false,'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    $urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/informasiPenjualanResep/printStrukRetur&returresep_id='.$modRetur->returresep_id.'&penjualanresep_id='.$modPenjualan->penjualanresep_id);
?>

<script>
function print(caraPrint)
{
    window.open("<?php echo $urlPrint; ?>&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
</script>

<?php endif; ?>