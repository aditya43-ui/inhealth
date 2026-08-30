<?php 
if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
          header('Cache-Control: max-age=0');     
    }
    
    $modPegawai = PegawaiM::model()->findByPk($model->pegawai_id);
    $tandabuktikueluarT = TandabuktikeluarT::model()->findByAttributes(array('tandabuktikeluar_id' => $model->tandabuktikeluar_id));

    $periode = $model->periodejasa;
    
    if (empty($model->periodejasa)) {
        $periode = $model->tglbayarjasa;
    } 
    $date = MyFormatter::getMonthId(date('m', strtotime($periode)))." ".date('Y', strtotime($periode));
 
    echo $this->renderPartial('application.views.headerReport.headerDefaultNonLogoPT',array('judulLaporan'=>"SLIP JASA DOKTER - ".strtoupper($date)));  
?>
<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:120px;
        color:black;
        padding-right:10px;
    }
     .border th, .border td{
        border:1px solid #000;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }
    
    thead th{
        background:none;
        color:#333;
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
	
	.row_total td {
		font-weight: bold;
		border-top: 1px solid black;
	}
	
	.tab_detail {
		border-top: 1px solid black;
	}
    
    .num {
        text-align: right;
    }
    
    .bagian_gaji {
        padding: 5px;
        float: left;
    }
    
    .bagian_gaji th, .bagian_gaji td {
        padding: 2px;
    }
    
    .footer tfoot td {
        font-weight: bold;
    }
    
    .det_header td {
        font-weight: bold;
    }
    .det_border_bottom td {
        border-bottom: 1px solid black;
    }
    .det_border_up td {
        border-top: 1px solid black;
    }
    
    .tab_details th, .tab_details td {
        padding: 2px;
    }
');
?>


<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table style="width: 100%; border: none;">
                <tr>
                    <td style="text-align:left;"><b>NIP</b></td><td>:</td>
                    <td width="50%"><?php echo CHtml::encode($modPegawai->nomorindukpegawai); ?></td>
                    <td style="text-align:right;" nowrap><b>No. Slip Jasa Dokter</b></td><td>:</td>
                    <td nowrap>
                        <?php
                            echo CHtml::encode($model->nobayarjasa);
                        ?>
                    </td>
                </tr>
				<tr>
					<td style="text-align:left;"><b> Nama </b> </td><td>:</td>
                    <td width="">
						<?php
                            echo CHtml::encode($modPegawai->namaLengkap);
                        ?>
					</td>
                    <td style="text-align:right; width:250px !important"><b> Periode Jasa Dokter </b></td><td>:</td>
                    <td>
                        <?php
                        if (!empty($model->periodejasa)) {
                            echo MyFormatter::formatMonthForUserGaji($model->periodejasa);
                        } else {
                            echo MyFormatter::formatMonthForUserGaji($model->tglbayarjasa);
                        }
                        ?>
                    </td>
				</tr>
                <tr>
                    <td style="text-align:left;"><b> Dep&nbsp;/&nbsp;Sect </b> </td><td>:</td>
                    <td width="">
                        <?php 
                            $modInstalasi = InstalasiM::model()->findByPk(Yii::app()->user->getState('instalasi_id'));
                            echo $modInstalasi->instalasi_nama;
                        ?>
                        &nbsp;/&nbsp;
                        <?php 
                            $modRuangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
                            echo $modRuangan->ruangan_nama;
                        ?>
					</td>
                    <td style="text-align:right;"><b>Kode Objek Pajak </b> </td>
                    <td>:</td>
                    <td><?php echo (!empty($model->kode_objekpajak)?$model->kode_objekpajak:"-"); ?></td>
                </tr>
            </table>            
        </td>
    </tr>
</table><br>

<?php 
//$detPenerimaan = array();
//$detPengeluaran = array();
//
//$kelompok_gaji = array(
//    'GAJI POKOK'=>array(),
//    'TUNJANGAN TETAP'=>array(),
//    'TUNJANGAN TIDAK TETAP'=>array(),
//    'TUNJANGAN PREMI'=>array(),
//);
//
//foreach ($modDetail as $item) {
//    $komponen = KomponengajiM::model()->findByPk($item->komponengaji_id);
//    if ($komponen->ispotongan) {
//        $detPengeluaran[] = array(
//            'komponen'=>$komponen,
//            'detail'=>$item,
//        );
//    } else {
//        $kelompok_gaji[$komponen->tipekomponengaji][] = array(
//            'komponen'=>$komponen,
//            'detail'=>$item,
//        );
//    }
//}
//
//foreach ($kelompok_gaji as $item) {
//    foreach ($item as $item2) {
//        $detPenerimaan[] = $item2;
//    }
//}
//
//
//
//
//$total_terima = 0;
//$total_keluar = 0;

?>


<table width="100%" class="tab_details">
    <tr class="det_header det_border_bottom">
        <td colspan="2">Penerimaan</td>
        <td colspan="2">Potongan</td>
    </tr>
    <?php
//    $row = count((array)$detPenerimaan);
//    if ($row < count((array)$detPengeluaran)) {
//        $row = count((array)$detPengeluaran);
//    }
//    
//    foreach ($detPenerimaan as $item): 
//        $total_terima += $item['detail']->jumlah;
//    endforeach;
//    
//    foreach ($detPengeluaran as $item): 
//        $total_keluar += $item['detail']->jumlah;
//    endforeach;
//    
//    for ($i = 0; $i < $row; $i++) :
//        
//        $label_terima = empty($detPenerimaan[$i]) ? '' : $detPenerimaan[$i]['komponen']->komponengaji_nama;
//        $nilai_terima = empty($detPenerimaan[$i]) ? '' : MyFormatter::formatNumberForPrint($detPenerimaan[$i]['detail']->jumlah);
//    
//        $label_potongan = empty($detPengeluaran[$i]) ? '' : $detPengeluaran[$i]['komponen']->komponengaji_nama;
//        $nilai_potongan = empty($detPengeluaran[$i]) ? '' : MyFormatter::formatNumberForPrint($detPengeluaran[$i]['detail']->jumlah);
        
    ?>
    <tr>
            <td>Jasa</td>
            <td width="100" class="num"><?php echo MyFormatter::formatNumberForPrint($model->totaljasa); ?></td>
            <td>Pajak</td>
            <td width="100" class="num"><?php echo MyFormatter::formatNumberForPrint($model->total_pajak); ?></td>
    </tr>
    <tr>
            <td>Adjustment</td>
            <td width="100" class="num"><?php echo MyFormatter::formatNumberForPrint($model->totaladjsument); ?></td>
            <td></td>
            <td width="100" class="num"></td>
    </tr>
    <?php  
//    endfor;
    ?>

    <tr class="det_header det_border_up det_border_bottom">
        <td>Total Penerimaan</td>
        <td width="100" class="num"><?php echo MyFormatter::formatNumberForPrint(($model->totaljasa + $model->totaladjsument)); ?></td>
        <td>Total Potongan</td>
        <td width="100" class="num"><?php echo MyFormatter::formatNumberForPrint($model->total_pajak); ?></td>
    </tr>
    
    <tr>
        <td colspan="4"><hr style="border-top: 1px solid black !important; margin: 0;"/></td>
    </tr>
    <tr class="det_header">
        <td>Take Home Pay</td>
        <td class="num" style="text-decoration: underline; border: 1px solid black;">
        <?php 
            echo MyFormatter::formatNumberForPrint($model->totalbayarjasa); 
        ?>
        </td>
        <td></td>
        <td width="100" class="num"></td>
    </tr>
    
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td><br><br></td>
    </tr>
</table>
<table>
    <tr>
        <td style="text-align:left;"><b>Di&nbsp;Transfer&nbsp;ke</b></td>
        <td></td>
        <td></td>
        <td width="100%" style="text-align:center;"><b>Catatan</b></td>
        <td></td>
    </tr>
    <tr>
        <td style="text-align:left;">Cabang&nbsp;Bank</td>
        <td>:</td>
        <td width="15%">
            <?php 
                echo CHtml::encode($modPegawai->cabang_bank);
            ?>
        </td>
        <td colspan=2 width="85%" style="text-align:center;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Slip Jasa Dokter ini dicetak secara komputerisasi <br> 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        sehingga tidak memerlukan tanda tangan</td>
        
    </tr>
    <tr>
        <td style="text-align:left;">No&nbsp;Rekening </td>
        <td>:</td>
        <td>
            <?php 
                echo CHtml::encode($modPegawai->no_rekening);
            ?>
        </td>
        <td width="100%"></td>
        <td></td>
    </tr>
    <tr>
        <td style="text-align:left;">Atas&nbsp;Nama </td>
        <td>:</td>
        <td>
            <?php 
                echo CHtml::encode($modPegawai->atasnama);
            ?>
        </td>
        <td width="100%"></td>
        <td></td>
    </tr>
</table>

<div style="clear: both;"></div>

<?php if(isset($tandabuktikueluarT)){ 
    $namaPenerima = "";
    $alamatPenerima = "";

    if($tandabuktikueluarT->carabayarkeluar == "TUNAI"){
        $namaPenerima = "Penerima";
        $alamatPenerima = "Penerima";
    }else if($tandabuktikueluarT->carabayarkeluar == "TRANSFER"){
        $namaPenerima = "Bank";
        $alamatPenerima = "Bank";
    }
    ?>
<br><br>
        <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
                <tr>
                    <td nowrap><b> Jenis Penjamin</b></td>
                    <td>
                        : <?php echo CHtml::encode($tandabuktikueluarT->carabayarkeluar); ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap><b> Nama <?php echo $namaPenerima; ?></b></td>
                    <td>
                        : <?php echo CHtml::encode($tandabuktikueluarT->namapenerima); ?>
                    </td>
                </tr>
                <tr>
                    <td width="150"><b> Alamat <?php echo $alamatPenerima; ?></b></td>
                    <td>
                        : <?php echo CHtml::encode($tandabuktikueluarT->alamatpenerima); ?>
                    </td>
                </tr>
        </table>
    
<?php } ?>
<?php /*
<table width="100%" style="margin-top:20px; display: none;">
    <tr>
        <td width="100%" align="left" align="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="35%" align="center">
                        <div>Mengetahui</div>
                        <div style="margin-top:60px;"><?php // echo $model->mengetahui; ?></div>
                    </td>
                    <td width="35%" align="center">
                        <div><?php // echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                        <div>Menyetujui</div>
                        <div style="margin-top:60px;"><?php // echo $model->menyetujui; ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<?php // die; ?>
 * 
 */ ?>
 