<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$data['judulLaporan'].'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }else{
        echo $this->renderPartial('application.views.headerReport.headerLaporan', array('judulLaporan'=>$data['judulLaporan']));      
    }
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

');
?>

<style>

    .num {
        text-align: right !important;
    }

    .tab_head td {
        vertical-align: top;
    }

</style>

<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0" class="tab_head">
                    
                <tr>
                    <td width="110">No. RM/Reg</td>
                    <td width="10">:</td>
                    <td>
                        <?php echo CHtml::encode($modPendaftaran->pasien->no_rekam_medik); ?> / 
                        <?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?>
                    </td>
                    <td width="110">Nama PJP</td>
                    <td width="10">:</td>
                    <td><?php
                            if(strlen($modPendaftaran->penanggungjawab_id) > 0)
                            {
                                echo CHtml::encode(!empty($modPendaftaran->penanggungJawab->nama_pj) ? $modPendaftaran->penanggungJawab->nama_pj : "" );
                            }else{
                                echo CHtml::encode($modPendaftaran->pasien->nama_pasien);
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); ?></td>
                    <td>:</td>
                    <td><?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?></td>
                    <td>Alamat PJP</td>
                    <td>:</td>
                    <td><?php
                            if(strlen($modPendaftaran->penanggungjawab_id) > 0)
                            {
                                echo CHtml::encode(!empty($modPendaftaran->penanggungJawab->nama_pj) ? $modPendaftaran->penanggungJawab->nama_pj : "" );
                            }else{
                                echo CHtml::encode($modPendaftaran->pasien->alamat_pasien);
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('jeniskelamin')); ?></td>
                    <td>:</td>
                    <td>
                        <?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?>/ &nbsp;
                        <?php echo CHtml::encode($modPendaftaran->umur); ?>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Unit Pelayanan</td>
                    <td>:</td>
                    <td><?php echo CHtml::encode($modPendaftaran->instalasi->instalasi_nama); ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Dokter Pemeriksa</td>
                    <td>:</td>
                    <td><?php echo CHtml::encode(isset($modPendaftaran->dokter->nama_pegawai) ? $modPendaftaran->dokter->nama_pegawai:null); ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Tgl. Perawatan</td>
                    <td>:</td>
                    <td></td>
                    <td>Perusahaan Penjamin</td>
                    <td>:</td>
                    <td><?php echo empty($modPendaftaran->penjamin) ? "-" : $modPendaftaran->penjamin->penjamin_nama; ?></td>
                </tr>
            </table>            
        </td>
    </tr>
    <tr>
        <td>
            <div align="center" style="border-bottom: 1px solid #000000;padding: 10px;margin-bottom: 15px;">
                RINCIAN BIAYA SEMENTARA
            </div>
            <?php
                $row = array();
                foreach($modRincian as $i=>$val)
                {
                    $ruangan_id = $val->ruangan_id;
                    $row[$ruangan_id]['nama'] = $val->ruangan_nama;
                    $row[$ruangan_id]['ruangan_id'] = $val->ruangan_id;
                    $row[$ruangan_id]['kategori'][$i]['nama_pegawai'] = $val->nama_pegawai;
                    $row[$ruangan_id]['kategori'][$i]['tindakanpelayanan_id'] = $val->tindakanpelayanan_id;
                    $row[$ruangan_id]['kategori'][$i]['daftartindakan_nama'] = $val->daftartindakan_nama;
                    $row[$ruangan_id]['kategori'][$i]['kelas'] = $val->kelaspelayanan_nama;
                    $row[$ruangan_id]['kategori'][$i]['harga'] = (isset($val->tarif_medis) ? ($val->tarif_satuan - $val->tarif_medis) : $val->tarif_satuan);
                    $row[$ruangan_id]['kategori'][$i]['qty'] = $val->qty_tindakan;
                    
                    $row[$ruangan_id]['kategori'][$i]['total'] = ($row[$ruangan_id]['kategori'][$i]['harga'] * $row[$ruangan_id]['kategori'][$i]['qty']);
                    $harga = TindakanpelayananT::model()->findAllByPk($val->tindakanpelayanan_id);
                    $row[$ruangan_id]['kategori'][$i]['harga_dokter'] = (isset($val->tarif_medis) ? $val->tarif_medis : 0);
                    $row[$ruangan_id]['kategori'][$i]['total_dokter'] = (isset($val->tarif_medis) ? ($val->qty_tindakan * $val->tarif_medis) : 0);
                }
            ?>
            <table width="100%" style='margin-left:auto; margin-right:auto;' class='table table-striped table-bordered table-condensed'>
                <thead>
                    <tr>
                        <th width="8%">&nbsp;</th>
                        <th width="30%">&nbsp;</th>
                        <th>Kelas</th>
                        <th>Harga (Rp)</th>
                        <th>Banyak</th>
                        <th>Total (Rp)</th>
                    </tr>
                </thead>
                <?php
                    $cols = '';
                    $total_biaya = 0;
                    foreach($row as $values)
                    {
                        $cols .= '<tr>';
                        $cols .= '<td colspan=6>'. $values['nama'] .'</td>';
                        $cols .= '</tr>';
                        $col = '';
                        $total = 0;
                        foreach($values['kategori'] as $val)
                        {
                            $col .= '<tr>';
                            $col .= '<td>&nbsp;</td>';
                            $col .= '<td>'. $val['daftartindakan_nama'] .'</td>';
                            $col .= '<td>'. $val['kelas'] .'</td>';
                            $col .= '<td class="num">'. MyFormatter::formatNumberForPrint($val['harga'], 2) .'</td>';
                            $col .= '<td class="num">'. $val['qty'] .'</td>';
                            $col .= '<td class="num">'. MyFormatter::formatNumberForPrint($val['total'], 2) .'</td>';
                            $col .= '</tr>';
                            if(strlen($val['nama_pegawai']) > 0)
                            {
                                $col .= '<tr>';
                                $col .= '<td>&nbsp;</td>';
                                $col .= '<td>'. $val['nama_pegawai'] .'</td>';
                                $col .= '<td>'. $val['kelas'] .'</td>';
                                $col .= '<td class="num">'. MyFormatter::formatNumberForPrint($val['harga_dokter'], 2) .'</td>';
                                $col .= '<td class="num">'. $val['qty'] .'</td>';
                                $col .= '<td class="num">'. MyFormatter::formatNumberForPrint($val['total_dokter'], 2) .'</td>';
                                $col .= '</tr>';                                
                            }
                            $total += $val['total'] + $val['total_dokter'];
                        }
                        $col .= '<tr">';
                        $col .= '<td colspan=5><b>Total Biaya</b></td>';
                        $col .= '<td class="num">'. $total .'</td>';
                        $col .= '</tr>';
                        $cols .= $col;
                        $total_biaya += $total;
                    }
                    echo($cols);
                ?>
                
            </table>
        </td>
    </tr>
</table>
<?php if (isset($caraPrint)) { ?>

<table width="100%" style="margin-top:20px;">
    <tr>
        <td width="50%" align="left" align="top">
            <table width="50%">
                <tr>
                    <td width="50%" align="center">
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?></div>
                        <div>Petugas</div>
                        <div style="margin-top:60px;"><?php echo $data['nama_pegawai']; ?></div>
                    </td>
                </tr>
            </table>
        </td>
        <td align="right" valign="top">
            <table width="50%">
                <tr>
                    <td width="50%">Total Biaya</td>
                    <td width="3%">:</td>
                    <td><?php echo $total_biaya; ?></td>
                </tr>
                <tr>
                    <td>Deposit</td>
                    <td>:</td>
                    <td><?php echo $data['uang_cicilan']; ?></td>
                </tr>
                <tr>
                    <td>Tanggungan Pasien</td>
                    <td>:</td>
                    <td>
                        <?php 
                            $kembalian = $total_biaya;
                            if($data['uang_cicilan'] > 0){
                                if($data['uang_cicilan'] < $total_biaya)
                                {
                                    $kembalian = $total_biaya - $data['uang_cicilan'];
                                }                                            
                            }
                            echo $kembalian;
                        ?>
                    </td>
                </tr>
            </table>                        
        </td>
    </tr>
</table>
<?php } else { 

//echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
//echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printRincianTagihanBelumBayar');
$pendaftaran_id = $modPendaftaran->pendaftaran_id;
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/&id=${pendaftaran_id}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);         
 } ?>
