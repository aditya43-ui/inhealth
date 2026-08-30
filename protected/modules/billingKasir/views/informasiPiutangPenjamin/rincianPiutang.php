<style>
    .tandatangan{
        vertical-align: bottom;
        text-align: center;
        width: 50%;
    }
    body {
        color: black;
    }
    
    .tab-header td {
        padding: 2px;
    }
    
    .tab-detail th {
        font-weight: bold;
    }
    
    .tab-detail td, .tab-detail th {
        padding: 2px;
        border: 1px solid black;
    }
</style>

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
<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial($this->path_view.'_headerPrint', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
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

$noPengajuan = "";
$tglJatuhtempo = "";

if(isset($modPembayaranKlaim)){
    $modPengajuan = PengajuanklaimpiutangT::model()->findByAttributes(array('pembayarklaim_id'=>$modPembayaranKlaim->pembayarklaim_id));
 
    if(isset($modPengajuan)){
        $noPengajuan = $modPengajuan->nopengajuanklaimanklaim;
        $tglJatuhtempo = (!empty($modPengajuan->tgljatuhtempo)?MyFormatter::formatDateTimeForUser($modPengajuan->tgljatuhtempo):"");
    }
}
?>

                    
<table class="tab-header"  width="100%">
    <tr>
        <td width="20%">No. Pendaftaran</td>
        <td width="2%">: </td>
        <td width="36%"><?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?></td>
        <td width="20%">Alamat</td>
        <td width="2%">: </td>
        <td width="20%" nowrap><?php echo CHtml::encode($modPasien->alamat_pasien); ?></td>
    </tr>
    <tr>
        <td nowrap>No. Rekam Medik</td>
        <td>: </td>
        <td><?php echo CHtml::encode($modPasien->no_rekam_medik); ?></td>
        <td>Jenis Penjamin</td>
        <td>: </td>
        <td nowrap><?php echo $model->carabayar->carabayar_nama; ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>: </td>
        <td><?php echo CHtml::encode($modPasien->namadepan.$modPasien->nama_pasien); ?></td>
        <td>Penjamin</td>
        <td>: </td>
        <td nowrap><?php echo $model->penjamin->penjamin_nama; ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>: </td>
        <td><?php echo CHtml::encode($modPasien->jeniskelamin); ?></td>
        <td>No. Pengajuan Klaim</td>
        <td>: </td>
        <td nowrap><?php echo $noPengajuan; ?></td>
    </tr>
    <tr>
        <td>Umur</td>
        <td>: </td>
        <td><?php echo CHtml::encode($modPendaftaran->umur); ?></td>
        <td nowrap>Tanggal Jatuh Tempo</td>
        <td>: </td>
        <td nowrap><?php echo $tglJatuhtempo; ?></td>
    </tr>
</table>

    <div  class="judulcontent" align="center" style="border-bottom: 1px solid #000000;padding: 10px;margin-bottom: 15px;">
        Rincian Piutang Penjamin
    </div>    
            <?php //echo "<pre>"; print_r(count((array)$modRincian)); exit();?>
             <table width="100%" style='margin-left:auto; margin-right:auto;' class='tab-detail'>
                <thead>
                    <tr>
                        <th>No. Pembayaran</th>
                        <th>No. Bukti Kas Masuk</th>
                        <th>Tanggal Pembayaran</th>
                        <th>Total Tagihan</th>
                        <th>Total Piutang</th>
                        <th>Piutang yang sudah dibayarkan</th>
                        <th>Sisa Piutang</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $col="";
                        foreach ($modDetails as $i => $val) {
                            $col.= '<tr>';
                            $col.='<td>'.$val['nopembayaran'].'</td>';
                            $col.='<td>'.$val['nobuktibayar'].'</td>';
                            $col.='<td>'.MyFormatter::formatDateTimeForUser($val['tglpembayaran']).'</td>';
                            $col.='<td style="text-align: right;">'.MyFormatter::formatNumberForPrint($val['totalbiayapelayanan']).'</td>';
                            $col.='<td style="text-align: right;">'.MyFormatter::formatNumberForPrint($val['totalpiutang']).'</td>';
                            $col.='<td style="text-align: right;">'.MyFormatter::formatNumberForPrint(($val['totalbayar_tunai'] + $val['totalbayar_nontunai'])).'</td>';
                            $col.='<td style="text-align: right;">'.MyFormatter::formatNumberForPrint(($val['totalpiutang'] - $val['totalbayar_tunai'] - $val['totalbayar_nontunai'])).'</td>';
                            $col.= '</tr>';
                        } 
                        echo $col; 
                    ?>
                </tbody>                
            </table>
                    <br><br>
<?php if (isset($caraPrint)) { ?>

<?php } else { 

        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printRincianPiutang');
$pembayaranpelayanan_id = $model->pembayaranpelayanan_id;
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&id=${pembayaranpelayanan_id}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);         
 } ?>
<br><br>
<div class="footer">
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>