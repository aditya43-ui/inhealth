
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
        <td>: <?php echo $detailRetur->returresep->noreturresep; ?></td>
        <td>NO PENDAFTARAN</td>
        <td>: <?php echo ($modPenjualanResep->pendaftaran_id == NULL) ? "-" : $modPenjualanResep->pendaftaran->no_pendaftaran; ?></td>
    </tr>
    <tr>
        <td>KELAS</td>
        <td>: <?php echo ($modPenjualanResep->pendaftaran_id == NULL) ? "-" : $modPenjualanResep->pendaftaran->kelaspelayanan->kelaspelayanan_nama; ?></td>
        <td>TGL PENDAFTARAN</td>
        <td>: <?php echo ($modPenjualanResep->pendaftaran_id == NULL) ? "-" : $modPenjualanResep->pendaftaran->tgl_pendaftaran; ?></td>
    </tr>
    <tr>
        <td>PASIEN</td>
        <td>: <?php echo ($modPenjualanResep->pendaftaran_id == NULL) ? "-" : $modPenjualanResep->pendaftaran->pasien->nama_pasien; ?></td>
        <td>TGL PEMBAYARAN</td>
        <td>: <?php echo $detailRetur->returresep->tglretur; ?></td>
    </tr>
    <tr>
        <td>DOKTER</td>
        <td>: <?php echo ($modPenjualanResep->pendaftaran_id == NULL) ? "-" : $modPenjualanResep->pendaftaran->dokter->nama_pegawai; ?></td>
        <td>KASUS PENYAKIT</td>
        <td>: <?php echo ($modPenjualanResep->pendaftaran_id == NULL) ? "-" : $modPenjualanResep->pendaftaran->jeniskasuspenyakit_nama; ?></td>
    </tr>
</table>

<table class="table table-condensed table-striped table-bordered" style='margin-top:5px;'>
                                        <thead>

                                            <tr>
                                                <th>No.</th><th>Uraian</th><th>Total Harga Jual</th><th>Administrasi Retur</th><th>Total Harga Retur</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
//                                            $total = 0;
//                                            $kelompoktindakan = '';
                                            $counter = 1;
                                            
                                            $totalSubTotal = 0;
//                                            $totalpersenhargajual = ($modPenjualanResep->jenispenjualan != "PENJUALAN BEBAS") ? Params::konfigFarmasi('totalpersenhargajual') :  Params::konfigFarmasi('persjualbebas');
//                                            $persenhargajual = Params::konfigFarmasi('persehargajual');
//                                            foreach($detailRetur as $i=>$value) {  
                                                $subTotal = $detailRetur->totaloaretur - $detailRetur->biayaadministrasi ;
                                                $totHarga = $subTotal;
                                                $totalSubTotal += $subTotal;
//                                                $obatpasien = ObatalkespasienT::model()->findByAttributes(array('obatalkespasien_id'=>$value->obatalkespasien_id));
//                                                $biayaLainLain += $obatpasiens->biayaadministrasi+$obatpasiens->biayakonseling+$obatpasiens->jasadokterresep+$obatpasiens->biayaservice;
//                                                $totBiayaAdministrasi = ceil($subTotal-(($subTotal/($totalpersenhargajual/100))/(($persenhargajual+100)/100))+$biayaLainLain);
                                                ?>
                                                
                                                    <tr>
                                                        <td><?php echo ($counter++); ?></td>
                                                        <td><?php echo "Obat Alkes"  ?><?php //echo '/'.$rincian->daftartindakan_nama ?></td>
                                                        <td style="text-align: right;"><?php echo number_format($detailRetur->totaloaretur,0,"",".") ; ?></td>
                                                        <td style="text-align: right;"><?php echo number_format($detailRetur->biayaadministrasi,0,"","."); ?></td>
                                                        <td style="text-align: right;"><?php echo number_format($subTotal,0,"","."); ?></td>
                                                    </tr>
                                                    <?php 
                                                    
//                                            }
                                            
//                                            $totBiayaAdministrasi = ceil($subTotal-(($subTotal/($totalpersenhargajual/100))/(($persenhargajual+100)/100))+$biayaLainLain);
                                            ?>
<!--<tr>
                                                <td style="text-align: right;" colspan="4">TOTAL</td>
                                                <td style="text-align: right;"><?php //echo $totalSubTotal; //echo number_format($pembayaran->totaliurbiaya); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right;" colspan="4">Administrasi</td>
                                                <td style="text-align: right;"><?php //echo $detailRetur->biayaadministrasi; ?></td>
                                            </tr>-->
                                            <tr>
                                                <td style="text-align: right;" colspan="4">Total Retur</td>
                                                <td style="text-align: right;"><?php echo number_format($totalSubTotal,0,"","."); ?></td>
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
<?php if (isset($caraPrint)) { ?>
<?php  }else{

        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
//      $this->widget('UserTips',array('type'=>'admin'));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printKwitansi');
$pendaftaran_id = $modPendaftaran->pendaftaran_id;
$idPasienadmisi = ((isset($modBayar->pasienadmisi_id)) ? $modBayar->pasienadmisi_id : null);
$idPembayaranPelayanan = $modBayar->pembayaranpelayanan_id;
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&pendaftaran_id=${pendaftaran_id}&idPasienadmisi=${idPasienadmisi}&idPembayaranPelayanan=${idPembayaranPelayanan}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);         
}?>
