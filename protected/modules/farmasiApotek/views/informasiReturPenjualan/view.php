
<?php 
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$data['judulLaporan'].'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }     
}
?>
<?php $this->renderPartial('application.views.headerReport.headerDefault',array('colspan'=>10)); ?>

<table class="table table-condensed">
    <tr>
        <td>NOTA</td>
        <td>: <?php echo $modBayar->nopembayaran; ?></td>
        <td>NO PENDAFTARAN</td>
        <td>: <?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
    <tr>
        <td>KELAS</td>
        <td>: <?php echo $modPendaftaran->kelaspelayanan->kelaspelayanan_nama; ?></td>
        <td>TGL PENDAFTARAN</td>
        <td>: <?php echo $modPendaftaran->tgl_pendaftaran; ?></td>
    </tr>
    <tr>
        <td>PASIEN</td>
        <td>: <?php echo $modPendaftaran->pasien->nama_pasien; ?></td>
        <td>TGL PEMBAYARAN</td>
        <td>: <?php echo $modBayar->tglpembayaran; ?></td>
    </tr>
    <tr>
        <td>DOKTER</td>
        <td>: <?php echo $modPendaftaran->dokter->nama_pegawai; ?></td>
        <td>KASUS PENYAKIT</td>
        <td>: <?php echo $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama; ?></td>
    </tr>
</table>

<table class="table table-condensed table-striped table-bordered" style='margin-top:5px;'>
                                        <thead>

                                            <tr>
                                                <th>No.</th><th>Uraian</th><th>Harga</th><th>QTY</th><th>Keringanan</th><th>JUMLAH</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $total = 0;
                                            $kelompoktindakan = '';
                                            $counter = 1;
                                            
                                            $totalSubTotal = 0;
                                            $totalpersenhargajual = ($modPenjualanResep->jenispenjualan != "PENJUALAN BEBAS") ? Params::konfigFarmasi('totalpersenhargajual') :  Params::konfigFarmasi('persjualbebas');
                                            $persenhargajual = Params::konfigFarmasi('persehargajual');
                                            foreach($details as $i=>$value) {  
                                                $subTotal = $value['harga'] - $value['diskon'];
                                                $totalSubTotal += $subTotal;
                                                
                                                ?>
                                                
                                                    <tr>
                                                        <td><?php echo ($counter++); ?></td>
                                                        <td><?php echo $value['uraian'];   ?><?php //echo '/'.$rincian->daftartindakan_nama ?></td>
                                                        <td style="text-align: right;"><?php echo number_format($value['harga'] ); ?></td>
                                                        <td style="text-align: right;"><?php echo number_format(1); ?></td>
                                                        <td style="text-align: right;"><?php echo number_format($value['diskon']); ?></td>
                                                        <td style="text-align: right;"><?php echo number_format($subTotal); ?></td>
                                                    </tr>
                                                    <?php 
                                                    
                                            }
                                            
                                            $totBiayaAdministrasi = ceil($subTotal-(($subTotal/($totalpersenhargajual/100))/(($persenhargajual+100)/100)));
                                            ?>
                                            <tr>
                                                <td style="text-align: right;" colspan="5">TOTAL</td>
                                                <td style="text-align: right;"><?php echo number_format($totalSubTotal); //echo number_format($pembayaran->totaliurbiaya); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right;" colspan="5">Administrasi</td>
                                                <td style="text-align: right;"><?php echo number_format($totBiayaAdministrasi); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right;" colspan="5">Total Retur</td>
                                                <td style="text-align: right;"><?php echo number_format($modRetur->totalretur); ?></td>
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

<?php 
echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-danger', 'disabled'=>false,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 

$urlPrint=  Yii::app()->createAbsoluteUrl('farmasiApotek/infoPenjualanResep/PrintReturPenjualan&id='.$modRetur->returresep_id);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}

JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
?>
