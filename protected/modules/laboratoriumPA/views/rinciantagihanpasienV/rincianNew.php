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
');
?>

<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0">
                    <td width="50%">
                        <label class='control-label'>
                            No. RM / No. Pend :
                        </label>
                            <?php echo CHtml::encode($modPendaftaran->pasien->no_rekam_medik); ?> / 
                            <?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?>
                    </td>
                    <Td width="5%"></td>
                    <td>
                        <label class='control-label'>
                            Nama PJP :
                        </label>
                        <?php
                            if(strlen($modPendaftaran->penanggungjawab_id) > 0)
                            {
                                echo CHtml::encode($modPendaftaran->penanggungJawab->nama_pj);
                            }else{
                                echo CHtml::encode($modPendaftaran->pasien->nama_pasien);
                            }
                        ?>
                    </td>
                </tr>
                <tr>

                <tr>
                    <td>
                        <label class='control-label'>
                            <?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); ?>:
                        </label>
                        <?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Alamat PJP :
                        </label>
                        <?php
                            if(strlen($modPendaftaran->penanggungjawab_id) > 0)
                            {
                                echo CHtml::encode($modPendaftaran->penanggungJawab->nama_pj);
                            }else{
                                echo CHtml::encode($modPendaftaran->pasien->alamat_pasien);
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>
                            <?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('jeniskelamin')); ?>:
                        </label>
                            <?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            <?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('alamat_pasien')); ?>:
                        </label>
                            <?php echo CHtml::encode($modPendaftaran->pasien->alamat_pasien); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>
                            <?php echo CHtml::encode($modPendaftaran->getAttributeLabel('umur')); ?>:
                        </label>
                            <?php echo CHtml::encode($modPendaftaran->umur); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Jenis Penjamin - Penjamin :
                        </label>
                        <?php
                            if(strlen($modPendaftaran->carabayar_id)  && strlen($modPendaftaran->penjamin_id) > 0)
                            {
                                echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama)." - ". CHtml::encode($modPendaftaran->penjamin->penjamin_nama);
                            }else{
                                echo '-'."/"."-";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>Unit Pelayanan :</label>
                            <?php echo CHtml::encode($modPendaftaran->instalasi->instalasi_nama); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Nama Rujukan :
                        </label>
                        <?php
                            if(strlen($modPendaftaran->rujukan->nama_perujuk)> 0)
                            {
                                echo CHtml::encode($modPendaftaran->rujukan->nama_perujuk);
                            }else{
                                echo '-';
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>Dokter Pemeriksa :</label>
                        <?php echo CHtml::encode(isset($modPendaftaran->dokter->nama_pegawai)?$modPendaftaran->dokter->nama_pegawai:''); ?>                        
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Rujukan Dari :
                        </label>
                        <?php
                            if(strlen($modPendaftaran->rujukan_id)> 0)
                            {
                                echo CHtml::encode($modPendaftaran->rujukan->asalrujukan->asalrujukan_nama);
                            }else{
                                echo '-';
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>Tgl. Perawatan / Tgl. Pemeriksaan :</label>
                        <?php
                            if(strlen($modPendaftaran->tgl_pendaftaran) > 0)
                            {
                                echo CHtml::encode($modPendaftaran->tgl_pendaftaran);
                            }else{
                                echo '-';
                            }
                        ?>                      
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            No. Rujukan :
                        </label>
                        <?php
                            if(strlen($modPendaftaran->rujukan_id)> 0)
                            {
                                echo CHtml::encode($modPendaftaran->rujukan->no_rujukan);
                            }else{
                                echo '-';
                            }
                        ?>
                    </td>
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
                        <th width="8%">Ruangan / Unit</th>
                        <th width="30%">Uraian</th>
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
                            $col .= '<td>'. $val['harga'] .'</td>';
                            $col .= '<td>'. $val['qty'] .'</td>';
                            $col .= '<td>'. $val['total'] .'</td>';
                            $col .= '</tr>';
                            if(strlen($val['nama_pegawai']) > 0)
                            {
                                $col .= '<tr>';
                                $col .= '<td>&nbsp;</td>';
                                $col .= '<td>'. $val['nama_pegawai'] .'</td>';
                                $col .= '<td>'. $val['kelas'] .'</td>';
                                $col .= '<td>'. $val['harga_dokter'] .'</td>';
                                $col .= '<td>'. $val['qty'] .'</td>';
                                $col .= '<td>'. $val['total_dokter'] .'</td>';
                                $col .= '</tr>';                                
                            }
                            $total += $val['total'] + $val['total_dokter'];
                        }
                        $col .= '<tr">';
                        $col .= '<td colspan=5><b>Total Biaya</b></td>';
                        $col .= '<td>'. $total .'</td>';
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

echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
        $this->widget('UserTips',array('type'=>'admin'));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
$pendaftaran_id = $modPendaftaran->pendaftaran_id;
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/&id=${pendaftaran_id}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);         
 } ?>
