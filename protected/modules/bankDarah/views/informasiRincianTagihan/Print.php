<?php
/**
* digunakan sebagai Informasi Rincian Tagihan
* @author Elham Budianto  <elhambudianto1@gmail.com>
**/
?>
<style type="text/css" media="print">
      @media print
      {
         @page {
           margin-top: 0;
           margin-bottom: 0;
         }
         body  {
           width: 2480 px;
           height : 3898 px;
           padding-top: 72px;
           padding-bottom: 72px ;
         }
         
      } 
</style>
<?php
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
?>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
?>
<table>
    <tr>
        <td colspan="3">
            <table>
                <tr>
                    <td>
                        <?php 
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table style="width:100%;font-size: 12px">
    <tr>
        <td>No Formulir Permintaan</td>
        <td>:</td>
        <td><?php echo $model->no_pendaftaran?></td>
        <td>No. Pendaftaran</td>
        <td>:</td>
        <td><?php echo $model->no_pendaftaran?></td>
    </tr>
    <tr>
        <td>No Rekam Medik</td>
        <td>:</td>
        <td><?php echo $model->no_rekam_medik?></td>
        <td>Tanggal Pendaftaran</td>
        <td>:</td>
        <td><?php echo $model->tgl_pendaftaran?></td>
    </tr>
    <tr>
        <td>Tanggal Penyerahan</td>
        <td>:</td>
        <td><?php echo $modelPenyerahan->tglpenyerahan?></td>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $model->nama_pasien?></td>
    </tr>
    <tr>
        <!--<td>No Permintaan</td>
        <td>:</td>
        <td><?php //echo $model->no_permintaandarah?></td>-->
        <td>No Penyerahan</td>
        <td>:</td>
        <td>-</td>
        <td>Ruang Rawat</td>
        <td>:</td>
        <td><?php echo $modelRuangan->ruangan_nama?></td>
    </tr>
    <tr>
        <td>Dokter Pelaksana</td>
        <td>:</td>
        <td><?php echo $modelPermintaan->dokter_nama?></td>
        <td>Instalasi</td>
        <td>:</td>
        <td><?php echo $modelInstalasi->instalasi_nama?></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td>Jenis Penjamin</td>
        <td>:</td>
        <td><?php echo $modelCaraBayar->carabayar_nama?></td>
    </tr>
</table>
    <div class="row">
        <table width="100%" class="table table-bordered table-condensed" border="1px" style="text-align:center; font-weight: bold" id="table-laporan">
            <thead>
                <tr>
                    <td style="text-align:center;">No</td>
                    <td style="text-align:center;">Jenis Darah</td>
                    <td style="text-align:center;">Golongan Darah /Rhesus</td>
                    <td style="text-align:center;">No Kantong</td>
                    <td style="text-align:center;">Qty</td>
                    <td style="text-align:center;">Tarif</td>
                    <td style="text-align:center;">Total</td>
                    <td style="text-align:center;">Status</td>
                </tr>
            </thead>
            <tbody>
                                    <?php
                                        $i = 1;
                                        foreach($modelDetail as $details){
                                            $uji = UjikompatibilitasT::model()->findByAttributes(array('permintaandarahdet_id'=>$details->permintaandarahdet_id));
                                            if(empty($uji)){
                                                $singkatan_komp = $details->singkatan_komp;
                                                $golongan_darah = '-';
                                                $rhesus = '-';
                                                $nomorbarcode = '-';
                                            }else{
                                                $stok = StokkantongdarahT::model()->findByPk($uji->stokkantongdarah_id);
                                                $komponen = KomponendarahM::model()->findByPk($stok->komponendarah_id);
                                                if(!empty($komponen)){
                                                    $singkatan_komp = $komponen->singkatan_komp;
                                                }else{
                                                    $singkatan_komp = '-';
                                                }
                                                if(!empty($stok->golongan_darah)){
                                                $golongan_darah = $stok->golongan_darah;
                                                }else{
                                                    $golongan_darah = '-';
                                                }
                                                if(!empty($stok->rhesus)){
                                                    $rhesus = $stok->rhesus;
                                                }else{
                                                    $rhesus = '-';
                                                }
                                                if(!empty($uji->nomorbarcode)){
                                                    $nomorbarcode = $uji->nomorbarcode;
                                                }else{
                                                    $nomorbarcode = '-';
                                                }
                                            }
                                    ?>
                                    <tr>
                                        <td style="text-align:center;"><?php echo $i++;?></td>
                                        <td style="text-align:center;"><?php
                                                echo $singkatan_komp;
                                            ?></td>
                                        <td style="text-align:center;"><?php 
                                            echo $golongan_darah.'/'.$rhesus;?></td>
                                        <td style="text-align:center;">
                                            <?php 
                                                echo $nomorbarcode;
                                            ?>
                                        </td>
                                        <td style="text-align:center;"><?php echo $details['jml_kantong'];?></td>
                                        <td style="text-align:center;"><?php echo 'Rp '.number_format($details['tarif_satuan'],2,',','.');?></td>
                                        <td style="text-align:center;"><?php echo 'Rp '.number_format($details['jml_kantong']*$details['tarif_satuan'],2,',','.');?></td>
                                        <td style="text-align:center;"><?php
                                            $tindakan = TindakanpelayananT::model()->findByPk($details['tindakanpelayanan_id']);
                                            if(!empty($tindakan)){
                                                if($tindakan->tindakansudahbayar_id !=NULL){
                                                    echo PARAMS::STATUSBAYAR_LUNAS;
                                                }else{
                                                    echo PARAMS::STATUSBAYAR_BELUM_LUNAS;
                                                }
                                            }else{
                                                echo PARAMS::STATUSBAYAR_BELUM_LUNAS;
                                            }
                                            ?></td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" style="text-align:center;">Total Tagihan</td>
                    <td style="text-align:center;"><?php echo 'Rp '.number_format($grand_total,2,',','.');?></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
<table style="margin-top: 10px;width:100%">
    <tr>
        <td width="50%" style="text-align: center"> &nbsp;</td>
        <td width="50%" style="text-align: center"> Surabaya,<?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d"));?></td>
    </tr>
    <tr>
        <td width="50%" style="text-align: center">Penerima<br><br><br><br><br><br><br></td>
        <td width="50%" style="text-align: center">Petugas<br><br><br><br><br><br><br></td>
    </tr>
    <tr>
        <td width="50%" style="text-align: center">(........................................)</td>
        <td width="50%" style="text-align: center">Christinayu Mandansari</td>
    </tr>
</table>