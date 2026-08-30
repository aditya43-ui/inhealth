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
    .border{
        border:1px solid;
    }
    .num {
        text-align: right;
    }
');
?>
<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$data['judulLaporan'].'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }else if($caraPrint == 'PRINT'){
        echo CHtml::css('.control-label{
                float:left; 
                text-align: right; 
                width:50%;
                color:black;
                padding-right:10px;
                font-size:11pt;
            }
            td, th{
                font-size:11pt;
            }
            
        ');
    }
//    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan'=>$data['judulLaporan']));      
    
}
?>
<?php
    $a = 0;
    $subsidiasuransi = 0;
    $subsidirs = 0;
    $subsidipemerintah = 0;
    foreach ($modRincian as $key => $dataPendaftar) {
        $no_rekam_medik     = $dataPendaftar->no_rekam_medik;
        $no_pendaftaran     = $dataPendaftar->no_pendaftaran;
        $pendaftaran_id     = $dataPendaftar->pendaftaran_id;
        $nama_pasien        = $dataPendaftar->namadepan.$dataPendaftar->nama_pasien;
        $jeniskelamin       = $dataPendaftar->jeniskelamin;
        $dokter_pemeriksa   = $dataPendaftar->DokterPemeriksa;
        $carabayarPenjamin  = $dataPendaftar->CarabayarPenjamin;
        $alamat             = $dataPendaftar->alamat_pasien; //AlamatPasienPendaftar;
        $ruanganasal_nama   = $dataPendaftar->ruanganasal_nama;
        $ruangan_nama       = $dataPendaftar->ruangan_nama;
        $umur               = substr($dataPendaftar->umur,0,7);
        $nama_pj            = $dataPendaftar->nama_pj;
        $alamat_pj          = $dataPendaftar->alamat_pj;

        $tglresep[$key]     = $dataPendaftar->tglresep;
        $noresep[$key]      = $dataPendaftar->noresep;

        $jenis_obat[$key]   = $dataPendaftar->jenisobatalkes_nama;
        $obatnama[$key]     = $dataPendaftar->obatalkes_nama;
        $qty_obat[$key]     = $dataPendaftar->qty_oa;
        $hargasatuan_obat[$key]  = $dataPendaftar->hargasatuan_oa;
        $discount_obat[$key]     = $dataPendaftar->discount;
        $harga_obat[$key]        = $dataPendaftar->qty_oa * $dataPendaftar->hargasatuan_oa - $dataPendaftar->discount;
        $biaya_obat[$key]        = $dataPendaftar->biayaservice + $dataPendaftar->biayakemasan + $dataPendaftar->biayaadministrasi;
        $subtotal[$key]     = $harga_obat[$key] + $biaya_obat[$key];
        
        $subsidiasuransi   += $dataPendaftar->subsidiasuransi;
        $subsidirs         += $dataPendaftar->subsidirs;
        $subsidipemerintah += $dataPendaftar->subsidipemerintah;

        $a++;
    }
?>
<br><br><br><br>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr><td><p style="margin: 0; text-align: center;"><b><u><?php echo $data['judulHalaman']; ?></u></b></p></td></tr>
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="50%">
                        <label class='control-label'>
                            No. RM / No. Pend :
                      </label>
                            <?php echo CHtml::encode((isset($no_rekam_medik) ? $no_rekam_medik : $modPasien->no_rekam_medik)); ?> / 
                            <?php echo CHtml::encode((isset($no_pendaftaran) ? $no_pendaftaran : $modPendaftaran->no_pendaftaran)); ?>
                    </td>
                    <Td width="5%"></td>
                    <td>
                        <label class='control-label'>
                            Jenis Penjamin / Penjamin :
                      </label>
                        <?php
                            echo CHtml::encode((isset($carabayarPenjamin) ? $carabayarPenjamin : $modPendaftaran->carabayar->carabayar_nama." / ".$modPendaftaran->penjamin->penjamin_nama));
                        ?>
                    </td>
                </tr>
                <tr>

                <tr>
                    <td>
                        <label class='control-label'>
                            Nama Pasien :
                      </label>
                        <?php echo CHtml::encode((isset($nama_pendaftaran) ? $nama_pendaftaran : $modPasien->namadepan.$modPasien->nama_pasien)); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Alamat Pasien :
                      </label>
                        <?php echo CHtml::encode((isset($alamat) ? $alamat : $modPasien->alamat_pasien )); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>
                            Umur / Jenis Kelamin :
                      </label>
                            <?php echo CHtml::encode((isset($umur) ? $umur : $modPendaftaran->umur)).' / '.CHtml::encode((isset($jeniskelamin) ? $jeniskelamin : $modPasien->jeniskelamin)); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Nama PJP :
                      </label>
                       <?php echo CHtml::encode((isset($nama_pj) ? $nama_pj : isset($modPendaftaran->penanggungjawab->nama_pj)?$modPendaftaran->penanggungjawab->nama_pj:' - ')); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>
                            Unit Pelayanan :
                      </label>
                            <?php echo CHtml::encode(isset($ruangan_nama) ? $ruangan_nama : $modPendaftaran->ruangan->ruangan_nama); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Alamat PJP :
                      </label>
                        <?php echo CHtml::encode((isset($alamat_pjp) ? $alamat_pjp : isset($modPendaftaran->penanggungjawab->alamat_pj)?$modPendaftaran->penanggungjawab->alamat_pj:' - '));?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>Dokter Pemeriksa:</label>
                            <?php echo CHtml::encode($modPendaftaran->pegawai->namaLengkap); ?>                        
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Asal Unit Layanan :
                      </label>
                        <?php
                            echo CHtml::encode(isset($ruanganasal_nama) ? $ruanganasal_nama : $modPendaftaran->ruangan->ruangan_nama);
                        ?>
                    </td>
                </tr>                
            </table>            
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" style='margin-left:auto; margin-right:auto;' class='tab-det'> <!--class='table table-striped table-bordered table-condensed'-->
                <thead class="">
                    <tr>
                        <th>No.</th>
                        <th>Jenis Obat</th>
                        <th>Tanggal</th>
                        <th>No. Resep</th>
                        <th>Nama Items</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Keringanan</th>
                        <th>Harga</th>
                        <th>Biaya Servis</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
    <?php
        $totalSeluruh = 0;
        $totalObat = 0;
        $totalAlkes = 0;
        $totalAdmin = 0;
        $kelompokObat = 0;
        $kelompokAlkes = 0;
        
        $subsidiasuransi = 0;
        $subsidirs = 0;
        
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
                <td class='num'>".$qty_obat[$i]."</td>
                <td class='num'>".number_format($hargasatuan_obat[$i],0,',','.')."</td>
                <td class='num'>".number_format($discount_obat[$i],0,',','.')."</td>
                <td class='num'>".number_format($harga_obat[$i],0,',','.')."</td>
                <td class='num'>".number_format($biaya_obat[$i],0,',','.')."</td>
                <td class='num'>".number_format($subtotal[$i],0,',','.')."</td>

            </tr>";

            $total_tagihan += $subtotal[$i];
        }

        
    ?>
   
		<tfoot style="border-bottom: 1px solid #333;border-top: 1px solid #333;">
            <tr>
                <td colspan="10" class="uang"><b>Total Tagihan :</b></td>
                <td class="uang"><b><?php echo number_format($total_tagihan,0,',','.'); ?></b></td>
            </tr>
            <tr>
                <td colspan="10" class="uang"><b>Tanggungan Asuransi :</b></td>
                <td class="uang"><b><?php echo number_format($subsidiasuransi,0,',','.'); ?></b></td>
            </tr>
            <tr>
                <td colspan="10" class="uang"><b>Tanggungan Rumah Sakit :</b></td>
                <td class="uang"><b><?php echo number_format($subsidirs,0,',','.'); ?></b></td>
            </tr>
            <tr>
                <td colspan="10" class="uang"><b>Tanggungan Pemerintah :</b></td>
                <td class="uang"><b><?php echo number_format($subsidipemerintah,0,',','.'); ?></b></td>
            </tr>
            <tr>
                <td colspan="10" class="uang"><b>Tanggungan Pasien :</b></td>
                <td class="uang"><b><?php echo number_format(($total_tagihan - ($subsidiasuransi + $subsidirs + $subsidipemerintah)),0,',','.'); ?></b></td>
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
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/rincianTagihanFarmasi/rincianBiayaFarmasiRD');
$pendaftaran_id = (isset($pendaftaran_id) ? $pendaftaran_id : $modPendaftaran->pendaftaran_id);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/&id=${pendaftaran_id}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);         
 } ?>
