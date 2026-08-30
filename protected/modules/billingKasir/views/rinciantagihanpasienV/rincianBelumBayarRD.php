<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$data['judulLaporan'].'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan'=>$data['judulLaporan']));      
}
?>
<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:120px;
        color:black;
        padding-right:10px;
    }
    table{
        font-size:11px;
    }

    td .tengah{
       text-align: center;  
    }
');
?>

<?php
    $a = 0;
    $subsidiasuransi_tindakan = 0;
    $subsidirumahsakit_tindakan = 0;
    $iurbiaya_tindakan = 0;
    $format = new MyFormatter();
    foreach ($modRincian as $key => $dataPendaftar) {
        $no_rekam_medik     = $dataPendaftar->no_rekam_medik;
        $pendaftaran_id     = $dataPendaftar->pendaftaran_id;
        $no_pendaftaran     = $dataPendaftar->no_pendaftaran;
        $nama_pendaftaran   = $dataPendaftar->NamaPasienPendaftar;
        $jeniskelamin       = $dataPendaftar->jeniskelamin;
        $umur               = substr($dataPendaftar->umur,0,7);
        $alamat             = $dataPendaftar->AlamatPasienPendaftar;
        $instalasi_nama     = $dataPendaftar->instalasi_nama;
        $dokter_pemeriksa   = $dataPendaftar->DokterPemeriksa;
        $kelaspelayanan     = $dataPendaftar->kelaspelayanan_nama;
        $carabayarPenjamin  = $dataPendaftar->CarabayarPenjamin;
        $nama_pj            = $dataPendaftar->nama_pj;
        $alamat_pjp         = $dataPendaftar->alamat_pj;
        $kasus_penyakit     = $dataPendaftar->jeniskasuspenyakit_nama;
        $namaperujuk        = $dataPendaftar->namaperujuk;
        $tglrenkontrol      = $dataPendaftar->tglrenkontrol;
        $tgl_pendaftaran    = $dataPendaftar->tgl_pendaftaran;

        $tarif_satuan[$key] = $dataPendaftar->tarif_satuan;
        $qty_tindakan[$key] = $dataPendaftar->qty_tindakan;
        $kelastindakan_nama[$key]   = $dataPendaftar->kelastindakan_nama;
        $subtotal[$key]     = $tarif_satuan[$key]*$qty_tindakan[$key];
        $daftartindakan_nama[$key]  = $dataPendaftar->daftartindakan_nama;
        $ruangantindakan_nama[$key] = $dataPendaftar->ruangantindakan_nama;
        $tgl_tindakan[$key] = $dataPendaftar->tgl_tindakan;
        $dokter_tindakan[$key]      = $dataPendaftar->DokterTindakan;

        $subsidiasuransi_tindakan   += $dataPendaftar->subsidiasuransi_tindakan;
        $subsidirumahsakit_tindakan += $dataPendaftar->subsisidirumahsakit_tindakan;
        $iurbiaya_tindakan += $dataPendaftar->iurbiaya_tindakan;
        $a++;
    }

    $tgl_renkontrol = $format->formatDateTimeId($tglrenkontrol);
    $tgl_daftar = $format->formatDateTimeId($tgl_pendaftaran);
?>

<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
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
                    <td>
                        <label class='control-label'>
                            Nama Pasien :
                      </label>
                        <?php echo CHtml::encode($nama_pendaftaran); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Tgl. Pendaftaran:
                      </label>
                        <?php
                            echo CHtml::encode($tgl_daftar);   
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
                            Nama PJP :
                      </label>
                            <?php echo CHtml::encode($nama_pj); ?>
                    </td>
                </tr>
                <tr>
                    <td>   
                        <label class='control-label'>
                            Alamat Pasien:
                      </label>
                            <?php echo CHtml::encode($alamat); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Alamat PJP :
                      </label>
                        <?php
                            echo CHtml::encode($alamat_pjp);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>Unit Pelayanan :</label>
                        <?php echo CHtml::encode($instalasi_nama); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Kasus Penyakit :
                      </label>
                        <?php
                           echo CHtml::encode($kasus_penyakit);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>Dokter Pemeriksa :</label>
                        <?php echo CHtml::encode($dokter_pemeriksa); ?>                        
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Nama Perujuk :
                      </label>
                        <?php
                            echo CHtml::encode($namaperujuk);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>Kelas Pelayanan:</label>
                        <?php
                            echo CHtml::encode($kelaspelayanan);
                        ?>                      
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Tgl. Rencana Kontrol :
                      </label>
                        <?php
                            echo CHtml::encode($tgl_renkontrol);
                        ?>
                    </td>
                </tr>
            </table>            
        </td>
    </tr>
    <tr>
        <td>
            <div align="center" style="border-bottom: 1px solid #000000;padding: 10px;margin-bottom: 15px;">
                <?php echo strtoupper($data['judulLaporan']);?>
            </div>
            <?php
                $totalbiayaadminfarmasi = 0;
                $row = array();
            ?>
            <table width="100%" style='margin-left:auto; margin-right:auto;' class='table table-striped table-bordered table-condensed'>
                <thead>
                    <tr>
                        <th>Ruangan / Unit</th>
                        <th>Uraian</th>
                        <th>Kelas</th>
                        <th class="tengah">Harga (Rp)</th>
                        <th class="tengah">Banyak</th>
                        <th class="tengah">Total (Rp)</th>
                    </tr>
                </thead>
                <?php
                    $cols = '';
                    $total_biaya = 0;
                    $total = 0;
                    $sub_total = 0;
                    $tampilAdminFarmasi = true;
                    $tempAdminFarmasi = 0;
                    $subsidiAsuransi = $subsidiasuransi_tindakan;
                    $subsidiRumahSakit = $subsidirumahsakit_tindakan;
                    $iurBiaya = $iurbiaya_tindakan;                    
                    
                    foreach ($modRincian as $index => $data) {
                        $group_ruangan[] = (isset($ruangantindakan_nama[$index]) ? $ruangantindakan_nama[$index] : '');
                        $group = $index;
                        if($group_ruangan[$group]!=$ruangantindakan_nama[$index])
                        {
                            $group_ruangan[$index] = $ruangantindakan_nama[$index+1];
                            echo"
                            <tr>
                                <td colspan=6><b>".$ruangantindakan_nama[$index]."</b></td>
                            </tr>";

                        }else{
                            $group_ruangan[$index] = $group_ruangan[$group];
                        }
                        echo "
                        <tr>
                            <td>".$format->formatDateTimeId($tgl_tindakan[$index])."</td>
                            <td>".$daftartindakan_nama[$index]."<br>(".$dokter_tindakan[$index].")</td>
                            <td>".$kelastindakan_nama[$index]."</td>
                            <td><div class='pull-right'>".number_format($tarif_satuan[$index],0,',','.')."</div></td>
                            <td class='tengah'>".$qty_tindakan[$index]."</td>
                            <td><div class='pull-right'>".number_format($subtotal[$index],0,',','.')."</div></td>    
                        </tr>";
                        $index_subtotal = $index;
                        if($ruangantindakan_nama[$index]!=$ruangantindakan_nama[$index_subtotal])
                        {
                            $sub_total += $subtotal[$index];
                            echo"
                            <tr>
                                <td colspan=5>Grand Sub Total</td>
                                <td><div class='pull-right'>".number_format($sub_total,0,',','.')."</div></td>
                            </tr>
                            ";
                            $sub_total = 0;
                        }else{
                            $sub_total += $subtotal[$index];
                        }

                        $total += $subtotal[$index];
                    }
                ?>
                 <tfoot>
                    <tr>
                        <td colspan="5"><div class='pull-right'>Total Biaya</div></td>
                        <td style="text-align:right;"><?php echo number_format($total,0,',','.'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="5"><div class='pull-right'>Tanggungan Asuransi</div></td>
                        <td style="text-align:right;"><?php echo number_format($subsidiAsuransi,0,',','.'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="5"><div class='pull-right'>Tanggungan Rumah Sakit</div></td>
                        <td style="text-align:right;"><?php echo number_format($subsidiRumahSakit,0,',','.'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="5"><div class='pull-right'>Tanggungan Pasien</div></td>
                        <td style="text-align:right;"><?php echo number_format($iurBiaya,0,',','.');?></td>
                    </tr>
                </tfoot>
                
            </table>
        </td>
    </tr>
</table>
<?php if (isset($caraPrint)) { ?>

<table width="100%" style="margin-top:20px;">
    <tr>
        <td width="50%" align="left" align="top" colspan="2">
            <table width="50%">
                <tr>
                    <td width="50%" align="center">
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?></div>
                        <br>
                        <div>Petugas</div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div style="margin-top:60px;"><?php echo $data['nama_pegawai']; ?></div>
                    </td>
                </tr>
            </table>
        </td>
        <td></td>
        <td align="right" valign="top">
            <table width="50%">
                <tr>
                    <td width="50%">Total Biaya</td>
                    <td width="3%">:</td>
                    <td><?php echo $total; ?></td>
                </tr>
                <tr>
                    <td>Tanggungan Asuransi</td>
                    <td>:</td>
                    <td><?php echo $subsidiAsuransi; ?></td>
                </tr>
                <tr>
                    <td>Tanggungan Rumah Sakit</td>
                    <td>:</td>
                    <td><?php echo $subsidiRumahSakit; ?></td>
                </tr>
                <tr>
                    <td>Tanggungan Pasien</td>
                    <td>:</td>
                    <td>
                        <?php 
                            $kembalian = $total;
                            if($data['uang_cicilan'] > 0){
                                if($data['uang_cicilan'] < $total)
                                {
                                    $kembalian = $total - $data['uang_cicilan'];
                                }                                            
                            }
                            echo $iurBiaya;
                        ?>
                    </td>
                </tr>
            </table>                        
        </td>
    </tr>
</table>
<?php } else { 

        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')'));  
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
        $this->widget('UserTips',array('type'=>'admin'));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/RincianBelumBayarRDPrint');

$pendaftaran_id = $pendaftaran_id;
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/&id=${pendaftaran_id}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}

JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);         
 } ?>
