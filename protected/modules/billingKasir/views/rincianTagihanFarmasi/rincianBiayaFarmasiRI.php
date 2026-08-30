<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:50%;
        color:black;
        padding-right:10px;
        font-size:8pt;
    }
    body{
        font-size:8pt;
		color:#333;
    }
    td .uang{
        text-align:right;
    }
    .tab-det thead th{/*, .tab-det tbody td */
        background-color: white !important;
        border-top: 1px solid black !important;
		border-bottom: 1px solid black !important;
        color: black !important;
    }
    
    .num {
        text-align: right;
    }
	.border{
		border-top: 1px solid black !important;
		border-bottom: 1px solid black !important;
	}
');
?>
<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$data['judulHalaman'].'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }else if($caraPrint == 'PRINT'){
        echo CHtml::css('.control-label{
                float:left; 
                text-align: right; 
                width:50%;
                color:black;
                padding-right:10px;
                font-size:10px;
            }
            td, th{
                font-size:10px;
            }
            
        ');
    }
//    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan'=>$data['judulLaporan']));      
    
}
?>
<?php
    $a = 0;
    $no_rekam_medik = null;
    $no_pendaftaran = null;
    $carabayarPenjamin = null;
    $nama_pasien = null;
    $alamat = null;
    $umur = null;
    $jeniskelamin = null;
    $nama_pj = null;
    $ruangan_nama = null;
    $alamat_pj = null;
    $DokterPemeriksa = null;
    $ruanganasal_nama = null; 
    $subsidiasuransi = 0;
    $subsidirs = 0;
    $subsidipemerintah = 0;
    $pendaftaran_id = null;
    $pendaftaran_id = null;

    foreach ($modRincian as $key => $dataPendaftar) {
        $no_rekam_medik     = $dataPendaftar->no_rekam_medik;
        $no_pendaftaran     = $dataPendaftar->no_pendaftaran;
        $pendaftaran_id     = $dataPendaftar->pendaftaran_id;
        $nama_pasien        = $dataPendaftar->namapasienpendaftar;
        $jeniskelamin       = $dataPendaftar->jeniskelamin;
        $DokterPemeriksa    = $dataPendaftar->DokterPemeriksa;
        $carabayarPenjamin  = $dataPendaftar->CarabayarPenjamin;
        $alamat             = $dataPendaftar->alamat_pasien; //AlamatPasienPendaftar;
        $ruanganasal_nama   = $dataPendaftar->ruanganasal_nama;
        $ruangan_nama       = $dataPendaftar->ruangan_nama;
        $umur               = substr($dataPendaftar->umur,0,7);
        $nama_pj            = $DokterPemeriksa;
        $alamat_pj          = $dataPendaftar->alamat_pj;

        $tglresep[$key]     = $dataPendaftar->tglresep;
        $noresep[$key]      = $dataPendaftar->noresep;

        $jenis_obat[$key]   = $dataPendaftar->jenisobatalkes_nama;
        $obatnama[$key]     = $dataPendaftar->obatalkes_nama;
        $qty_obat[$key]     = $dataPendaftar->qty_oa;
        $hargasatuan_obat[$key]  = $dataPendaftar->hargasatuan_oa;
        $discount_obat[$key]     = $dataPendaftar->discount;
        $harga_obat[$key]        = $dataPendaftar->qty_oa * $dataPendaftar->hargasatuan_oa - $dataPendaftar->discount;
        // $biaya_obat[$key]        = $dataPendaftar->biayaservice + $dataPendaftar->biayakemasan + $dataPendaftar->biayaadministrasi;
        $biaya_obat[$key]   = 0;
        $subtotal[$key]     = $harga_obat[$key] + $biaya_obat[$key];
        
        $subsidiasuransi   += $dataPendaftar->subsidiasuransi;
        $subsidirs         += $dataPendaftar->subsidirs;
        $subsidipemerintah += $dataPendaftar->subsidipemerintah;

        $a++;
    }
?>
<br><br><br><br>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr><td><p style="margin: 0; text-align: center;"><b><u><h4><?php echo $data['judulHalaman']; ?></h4></u></b></p></td></tr>
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="50%">
                        <label class='control-label'>
                            No. RM / No. Pend :
                      </label>
                            <?php echo CHtml::encode($no_rekam_medik); ?> / 
                            <?php echo CHtml::encode($no_pendaftaran); ?>
                    </td>
                    <Td width="5%"></td>
                    <td>
                        <label class='control-label'>
                            Jenis Penjamin / Penjamin :
                      </label>
                        <?php
                            echo CHtml::encode($carabayarPenjamin);
                        ?>
                    </td>
                </tr>
                <tr>

                <tr>
                    <td>
                        <label class='control-label'>
                            Nama Pasien :
                      </label>
                        <?php echo CHtml::encode($nama_pasien); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Alamat Pasien :
                      </label>
                        <?php
                            echo CHtml::encode($alamat);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>
                            Umur / Jenis Kelamin :
                      </label>
                            <?php echo CHtml::encode($umur).' / '.CHtml::encode($jeniskelamin); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Dokter Penanggung Jawab :
                      </label>
                        <?php
                            echo CHtml::encode($nama_pj);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>
                            Unit Pelayanan :
                      </label>
                            <?php echo CHtml::encode($ruangan_nama); ?>
                    </td>
                    <td></td>
                    <td>   
                        <label class='control-label'>
                            Asal Unit Layanan :
                      </label>
                        <?php
                            echo CHtml::encode($ruanganasal_nama);
                        ?>
                    </td>
                    <?php /*
                    <td>   
                        <label class='control-label'>
                            Alamat PJP :
                      </label>
                        <?php
                            echo CHtml::encode($alamat_pj);
                        ?>
                    </td>
                     * 
                     */ ?>
                </tr>
                <tr>
                    <?php /*
                    <td>
                        <label class='control-label'>Resep Oleh Dokter :</label>
                            <?php echo CHtml::encode($DokterPemeriksa); ?>
                    </td>
                     * 
                     */ ?>
                </tr>                
            </table>            
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" style='margin-left:auto; margin-right:auto;' class='tab-det'> 
                <thead class="">
                    <tr>
                        <th>No.</th>
                        <th>Jenis Obat</th>
                        <th>Tanggal</th>
                        <th>No. Resep</th>
                        <th>Nama Items</th>
                        <th>Jumlah</th>
                        <th class='uang'>Satuan</th>
                        <th class='uang'>Keringanan</th>
                        <th class='uang'>Harga</th>
                        <th class='uang'>Biaya Servis</th>
                        <th class='uang'>Sub Total</th>
                    </tr>
                </thead>

				<tbody class="border">
    <?php
        $totalSeluruh = 0;
        $totalObat = 0;
        $totalAlkes = 0;
        $totalAdmin = 0;
        $kelompokObat = 0;
        $kelompokAlkes = 0;
        
        $data_obat = array();
        $data_alkes = array();
        
        $totalSeluruh += ($totalObat + $totalAlkes);
        $format = new MyFormatter();
        $total_tagihan = 0;
        
        for ($i=0; $i < $a ; $i++) {
            $no = $i+1;
            //$tanggal = $format->formatDateTimeId($tglresep[$i]);
			$tanggal = date('d/m/Y',  strtotime($tglresep[$i]));
            echo "
            <tr>
                <td>".$no."</td>
                <td>".$jenis_obat[$i]."</td>
                <td>".$tanggal."</td>
                <td>".$noresep[$i]."</td>
                <td>".$obatnama[$i]."</td>
                <td>".$qty_obat[$i]."</td>
                <td class='uang'>".MyFormatter::formatNumberForPrint($hargasatuan_obat[$i])."</td>
                <td class='uang'>".MyFormatter::formatNumberForPrint($discount_obat[$i])."</td>
                <td class='uang'>".MyFormatter::formatNumberForPrint($harga_obat[$i])."</td>
                <td class='uang'>".MyFormatter::formatNumberForPrint($biaya_obat[$i])."</td>
                <td class='uang'>".MyFormatter::formatNumberForPrint($subtotal[$i])."</td>

            </tr>";

            $total_tagihan += $subtotal[$i];
        }

        
    ?>
        
    </tbody>
	<tfoot class="border">
            <tr>
                <td colspan="10" class="uang"><b>Total Tagihan :</b></td>
                <td class="uang"><b><?php echo MyFormatter::formatNumberForPrint($total_tagihan); ?></b></td>
            </tr>
            <tr>
                <td colspan="10" class="uang"><b>Tanggungan Asuransi :</b></td>
                <td class="uang"><b><?php echo MyFormatter::formatNumberForPrint($subsidiasuransi); ?></b></td>
            </tr>
            <tr>
                <td colspan="10" class="uang"><b>Tanggungan Rumah Sakit :</b></td>
                <td class="uang"><b><?php echo MyFormatter::formatNumberForPrint($subsidirs); ?></b></td>
            </tr>
            <tr>
                <td colspan="10" class="uang"><b>Tanggungan Pemerintah :</b></td>
                <td class="uang"><b><?php echo MyFormatter::formatNumberForPrint($subsidipemerintah); ?></b></td>
            </tr>
            <tr>
                <td colspan="10" class="uang"><b>Tanggungan Pasien :</b></td>
                <td class="uang"><b><?php echo MyFormatter::formatNumberForPrint($total_tagihan - ($subsidiasuransi + $subsidirs + $subsidipemerintah)); ?></b></td>
            </tr>
        </tfoot>
        </table>
        </td>
    </tr>
</table>
<?php if ($caraPrint == 'PRINT') { ?>

<?php }
else { 

        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')'));  
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
//        $this->widget('UserTips',array('type'=>'admin'));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/rincianTagihanFarmasi/rincianBiayaFarmasiRI');
//$pendaftaran_id = $pendaftaran_id;
        $pendaftaran_id = isset($_GET['id'])?$_GET['id']:null;      
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/&id=${pendaftaran_id}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);         
 } ?>
