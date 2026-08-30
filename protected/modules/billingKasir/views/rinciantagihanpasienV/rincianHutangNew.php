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
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
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
?>

<table class="tab-header"  width="100%">
    <tr>
        <td width="20%">No. Pendaftaran</td>
        <td width="2%">: </td>
        <td width="36%"><?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?></td>
        <td width="20%">Tgl. Jatuh Tempo</td>
        <td width="2%">: </td>
        <td width="20%" nowrap><?php echo MyFormatter::formatDateTimeForUser($modPembayaran->tgljatuhtempo); ?></td>
    </tr>
    <tr>
        <td nowrap>No. Rekam Medik</td>
        <td>: </td>
        <td><?php echo CHtml::encode($modPendaftaran->pasien->no_rekam_medik); ?></td>
        <td>Penanggung Jawab</td>
        <td>: </td>
        <td nowrap><?php echo $modPembayaran->penanggungjawabhutang; ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>: </td>
        <td><?php echo CHtml::encode($modPendaftaran->pasien->namadepan.$modPendaftaran->pasien->nama_pasien); ?></td>
        <td>No. KTP</td>
        <td>: </td>
        <td nowrap><?php echo $modPembayaran->noktp_hutang; ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>: </td>
        <td><?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?></td>
        <td>No. Telp/Mobile</td>
        <td>: </td>
        <td nowrap><?php echo $modPembayaran->notelp_hutang; ?></td>
    </tr>
    <tr>
        <td>Umur</td>
        <td>: </td>
        <td><?php echo CHtml::encode($modPendaftaran->umur); ?></td>
        <td nowrap>Jaminan yang ditinggal</td>
        <td>: </td>
        <td nowrap><?php echo $modPembayaran->jaminanygditinggal; ?></td>
    </tr>
    <tr>
        <td>Alamat Pasien</td>
        <td>: </td>
        <td><?php echo CHtml::encode($modPendaftaran->pasien->alamat_pasien); ?></td>
        <td>Keterangan</td>
        <td>: </td>
        <td nowrap><?php echo $modPembayaran->keteranganberhutang; ?></td>
    </tr>
</table>

<?php /*
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0">
                    <td width="50%">
                        <label class='control-label'>
                            No. Rekam Medis/<br>No. Pendaftaran :
                      </label>
                            <?php echo CHtml::encode($modPendaftaran->pasien->no_rekam_medik); ?> / 
                            <?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?>
                    </td>
                    <Td width="5%"></td>
                    <td>
                        <label class='control-label'>
                            Tanggal Surat Jaminan :
                      </label>
                        <?php if ((isset($modSuratketjaminan->tglskj) ? $modSuratketjaminan->tglskj:0)  >0){
                            echo CHtml::encode($modSuratketjaminan->tglskj);
                        }else{
                            echo "-";
                        }
                        ?>                        
                    </td>
                </tr>
                <!--<tr>-->

                <tr>
                    <td>
                        <label class='control-label'>
                            <?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); ?>:
                      </label>
                        <?php echo CHtml::encode($modPendaftaran->pasien->namadepan); ?>
                        <?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Jenis Identitas / No. :
                      </label>
                        <?php
							$pj = PenanggungjawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
                            if(!empty($pj))
                            {
                                echo CHtml::encode($pj->jenisidentitas);
                            }else{
                                echo '-'."/"."-";
                            }
                        ?> / 
                        <?php
                            if(!empty($pj))
                            {
                                echo CHtml::encode($pj->no_identitas);
                            }else{
                                echo CHtml::encode($modPendaftaran->pasien->nama_pasien);
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
                            Nama Penjamin :
                      </label>
                            <?php echo CHtml::encode(isset($modPendaftaran->penanggungJawab->nama_pj) ? $modPendaftaran->penanggungJawab->nama_pj :'-'); ?>
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
                            Hubungan :
                      </label>
                        <?php echo CHtml::encode(isset($modPendaftaran->penanggungJawab->hubungankeluarga) ? $modPendaftaran->penanggungJawab->hubungankeluarga : '-'); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>Alamat Pasien :</label>
                            <?php echo CHtml::encode($modPendaftaran->pasien->alamat_pasien); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Alamat :
                      </label>
                        <?php
                            if(strlen(isset($modPendaftaran->penanggungJawab->alamat_pj) ? $modPendaftaran->penanggungJawab->alamat_pj:NULL) >0)
                            {
                                echo CHtml::encode($modPendaftaran->penanggungJawab->alamat_pj);
                            }else{
                                echo '-';
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'> RT / RW :</label>
                        <?php echo CHtml::encode($modPendaftaran->pasien->rt); ?> / <?php echo CHtml::encode($modPendaftaran->pasien->rw); ?>                       
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            No. Telepon :
                      </label>
                        <?php
                            if(strlen(isset($modPendaftaran->penanggungJawab->no_teleponpj) ? $modPendaftaran->penanggungJawab->no_teleponpj:null)> 0)
                            {
                                echo CHtml::encode($modPendaftaran->penanggungJawab->no_teleponpj);
                            }else{
                                echo '-';
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>No. Telpn / No. Mobil :</label>
                        <?php
                            if(strlen($modPendaftaran->pasien->no_telepon_pasien) > 0)
                            {
                                echo CHtml::encode($modPendaftaran->pasien->no_telepon_pasien);
                            }else{
                                echo '-';
                            }
                        ?> / 
                        <?php
                            if(strlen($modPendaftaran->pasien->no_mobile_pasien) > 0)
                            {
                                echo CHtml::encode($modPendaftaran->pasien->no_mobile_pasien);
                            }else{
                                echo '-';
                            }
                        ?>                        

                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            No. Handphone :
                      </label>
                        <?php
                            if(strlen(isset($modPendaftaran->penanggungJawab->no_mobilepj) ? $modPendaftaran->penanggungJawab->no_mobilepj:null)> 0)
                            {
                                echo CHtml::encode($modPendaftaran->penanggungJawab->no_mobilepj);
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
 * 
 */ ?>
                    <div  class="judulcontent" align="center" style="border-bottom: 1px solid #000000;padding: 10px;margin-bottom: 15px;">
                <?php echo strtoupper($data['judulLaporan']);?>
            </div>    
            <?php //echo "<pre>"; print_r(count((array)$modRincian)); exit();?>
             <table width="100%" style='margin-left:auto; margin-right:auto;' class='tab-detail'>
                <thead>
                    <tr>
                        <th>No. Pembayaran</th>
                        <th>No. Bukti Kas Masuk</th>
                        <th>Tanggal Bayar</th>
                        <th>Bayar Ke</th>
                        <th>Total Tagihan</th>
                        <th>Bayar Angsuran</th>
                        <th>Administrasi</th>
                        <th>Meterai</th>
                        <th>Sisa Tagihan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $col="";
                        foreach ($modRincian as $i => $val) {
                            $col.= '<tr>';
                            $col.='<td>'.$val['nopembayaran'].'</td>';
                            $col.='<td>'.$val['nobuktibayar'].'</td>';
                            $col.='<td>'.MyFormatter::formatDateTimeForUser($val['tglbuktibayar']).'</td>';
                            $col.='<td style="text-align: right;">'.$val['bayarke'].'</td>';
                            $col.='<td style="text-align: right;">'.MyFormatter::formatNumberForPrint($val['totaliurbiaya']).'</td>';
                            $col.='<td style="text-align: right;">'.MyFormatter::formatNumberForPrint($val['jmlbayarangsuran']).'</td>';
                            $col.='<td style="text-align: right;">'.MyFormatter::formatNumberForPrint($val['biayaadministrasi']).'</td>';
                            $col.='<td style="text-align: right;">'.MyFormatter::formatNumberForPrint($val['biayamaterai']).'</td>';
                            $col.='<td style="text-align: right;">'.MyFormatter::formatNumberForPrint($val['sisaangsuran']).'</td>';
                            $col.= '</tr>';
                        } 
                        echo $col; 
                    ?>
                </tbody>                
            </table>

<?php /*
        </td>
    </tr>
</table>
 * 
 */ 
?>

<?php if (isset($caraPrint)) { ?>

<table width="100%" style="margin-top:20px;">
    <tr>
        <td width="50%" align="left" align="top">
<!--<table width="50%">
                <tr>
                    <td width="50%" align="center">
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?></div>
                        <div>Petugas</div>
                        <div style="margin-top:60px;"><?php echo $data['nama_pegawai']; ?></div>
                    </td>
                </tr>
            </table>-->
        </td>
        <?php /*
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
         * 
         */ ?>
        
        <td></td>
    </tr>
</table>

<?php } else { 

//        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
        // echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'printPDF(\'PDF\')')); 
        //$content = $this->renderPartial('../tips/informasiRincianHutang',array(),true);
        //$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
//        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
        if(!empty($modRincian[0]->tindakansudahbayar_id)){//sudah bayar / lunas
            $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/rincianHutang');
        }else{
            $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/rincianHutang');
        }
$pendaftaran_id = $modPendaftaran->pendaftaran_id;
$pembayaranpelayanan_id = $modPembayaran->pembayaranpelayanan_id;
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/&id=${pendaftaran_id}&idpembayaran=${pembayaranpelayanan_id}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
function printPDF(caraPrint)
{
    window.open("${urlPrint}&id=${pendaftaran_id}&idpembayaran=${pembayaranpelayanan_id}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);         
 } ?>
<br>
<br>
<table style="width: 100%; border: none;">
    <tr>
        <td colspan="2">
            demikian surat pernyataan ini dibuat dengan sebenarnya dan akan bersedia membayar biaya perawatan
        </td>
    </tr>
    <tr>
        <td class="tandatangan"><br>Yang Membuat Pernyataan</td>
        <td class="tandatangan"><br>Kasir</td>
    </tr>
    <tr>
        <td class="tandatangan" style="height: 50px;">.........................</td>
        <td class="tandatangan"><?php echo Yii::app()->user->getState('nama_pegawai'); ?>
    </td></tr>
    <tr>
        <td colspan="2" class="tandatangan">
            mengetahui
        </td>
    </tr>
    <tr>
        <td colspan="2" class="tandatangan" style="height: 50px;"> 
            .........................
        </td>
    </tr>
</table>
</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>