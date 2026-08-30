<style>
    body {
        color: black;
    }
    
    .tab_detail {
        width:100%;
        margin-top: 20px;
        margin-bottom: 20px;
    }
    
    .tab_detail td, .tab_detail th {
        border: 1px solid black;
        padding: 2px;
    }
</style>

<?php 
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');

$caraPrint = null;
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$template = "{items}\n{pager}";
if (isset($caraPrint)){
    $template = "{items}";
}
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');   
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>"BUKTI PENGAJUAN JASA", 'colspan'=>''));
$format = new MyFormatter;
$perawat = null;
?>

<table style="width: 100%; border: none;">
    <tr>
        <td width="50%" valign="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <?php if (!empty($model->rujukandari_id) || !empty($model->pegawai_id)): ?>
                    <td style="vertical-align: top; width:200px">Nama</td>
                            <td>: <?php echo empty($model->rujukandari_id) ? $model->pegawai->NamaLengkap : $model->rujukandari->namaperujuk; ?></td>		
                    <?php else: ?>
                    <td style="vertical-align: top; width:200px">Nama</td><td>
                        <?php
                        $res = array();
                        $perawat = PembjasaperawatT::model()->findAllByAttributes(array(
                            'pembayaranjasa_id'=>$model->pembayaranjasa_id,
                        ));

                        foreach ($perawat as $item) {
                            $peg = PegawaiM::model()->findByPk($item->pegawai_id);
                            $res[] = $peg->nama_pegawai;
                        }

                        sort($res);

                        ?>
                        <ul>
                            <?php foreach ($res as $item): ?>
                            <li><?php echo $item; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </td>		
                    <?php endif; ?>
                </tr>
                <tr><td nowrap>Periode Pembayaran</td><td>: <?php echo MyFormatter::getMonthId(date('m', strtotime($model->periodejasa)))." ".date('Y', strtotime($model->periodejasa)); ?></td></tr>
                <tr>
                    <td nowrap>Kode Objek Pajak</td>
                    <td>: <?php echo $model->kode_objekpajak; ?></td>
                </tr>
            </table>
        </td>
        <td width="50%">
            <table width="50%">
                <tr hidden>		
                    <td>Total Tarif</td>
                    <td>: Rp <?php echo MyFormatter::formatNumberForPrint($model->totaltarif,2) ?></td>
                </tr>
                <tr>		
                    <td>Total Jasa</td>
                    <td>: Rp <?php echo MyFormatter::formatNumberForPrint($model->totaljasa,2) ?></td>
                </tr>
                <tr>		
                    <td>Total Adjusment Fee</td>
                    <td>: Rp <?php 
                        if(empty($model->totaladjsument)){
                            $model->totaladjsument = 0;
                        }
                        echo MyFormatter::formatNumberForPrint($model->totaladjsument,2) ?></td>
                </tr>
                <tr>		
                    <td>PPh 21</td>
                    <td>: Rp <?php echo MyFormatter::formatNumberForPrint($model->total_pajak,2) ?></td>
                </tr>
                <tr>		
                    <td>Take Home Pay</td>
                    <td>: Rp <?php echo MyFormatter::formatNumberForPrint($model->totalbayarjasa,2) ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>false,
	'dataProvider'=>$modDetail->searchPrint(),
        'template'=>$template,
        'itemsCssClass'=>'table border tab_detail',
	'columns'=>array(
		array(
                    'header'=>'No.',
                    'value'=>'$row+1',
                ),
                array(
                    'header'=>'No. Pembayaran/<br>No. RM',
                    'type'=>'raw',
                    'value'=>function($data) {
                        $bayar = PembayaranpelayananT::model()->findByAttributes(array(
                            'pendaftaran_id'=>$data->pendaftaran->pendaftaran_id
                        ));
                        
                        return MyFormatter::formatDateTimeForUser($bayar->tglpembayaran).'<br>'.$bayar->nopembayaran;
                    } //'$data->pendaftaran->no_pendaftaran ."/<br>". $data->pasien->no_rekam_medik',
                ),
                array(
                    'header'=>'Tgl. Pendaftaran/<br>No. Pendaftaran',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->pendaftaran->tgl_pendaftaran) ."/<br>". $data->pendaftaran->no_pendaftaran',
                ),
                array(
                    'header'=>'Jenis Penjamin / Penjamin',
                    'type'=>'raw',
                    'value'=>'$data->pendaftaran->carabayar->carabayar_nama ."/<br>". $data->pendaftaran->penjamin->penjamin_nama',
                ),
                array(
					'header'=>'Instalasi',
					'type'=>'raw',
					'value'=>function($data) use (&$modTindakan, &$modOA) {
                    
                        if (!empty($data->obatalkespasien_id)) {
                            $modOA = InformasipenjualanaresepV::model()->findByAttributes(array(
                                'obatalkespasien_id'=>$data->obatalkespasien_id,
                            ));
                            $instalasi = InstalasiM::model()->findByPk($modOA->instalasi_id);
                        } else {
                            $modTindakan = TindakanpelayananT::model()->findByPk($data->tindakanpelayanan_id);
                            $instalasi = InstalasiM::model()->findByPk($modTindakan->instalasi_id);
                        }
                        
                        return $instalasi->instalasi_nama;
					}
				),  
                array(
                    'header'=>'No. Rekam Medik',
                    'type'=>'raw',
                    'value'=>'$data->pasien->no_rekam_medik',
                ),
                array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'value'=>'$data->pasien->nama_pasien',
                ),
				array(
					'header'=>'Tgl. Tindakan',
					'type'=>'raw',
					'value'=>function($data) use (&$modTindakan, &$modOA) {
                        if (!empty($data->obatalkespasien_id)) {
                            return date('d M Y', strtotime($modOA->tglresep));
                        } else {
                            return date('d M Y', strtotime($modTindakan->tgl_tindakan));
                        }
					}
				),
				array(
					'header'=>'Uraian Tindakan',
					'type'=>'raw',
					'value'=>function($data) use (&$modTindakan, &$modOA) {
                        if (!empty($data->obatalkespasien_id)) {
                            return $modOA->jenispenjualan;
                        } else {
                            return $modTindakan->daftartindakan->daftartindakan_nama;
                        }
						
					}
				),
				array(
					'header'=>'Komponen',
					'type'=>'raw',
					'value'=>function($data) use (&$modTindakan, &$modOA) {
                        if (!empty($data->obatalkespasien_id)) {
                            return $modOA->obatalkes_nama;
                        } else {
                            $modKomponen = KomponentarifM::model()->findByPk($data->komponentarif_id);
                            return $modKomponen->komponentarif_nama;
                        }
						
					}
				),
//                array(
//                    'header'=>'Jumlah Tarif',
//                    'type'=>'raw',
//                    'value'=>'"<div style=\"text-align:right;\"> Rp ".MyFormatter::formatNumberForPrint($data->jumahtarif, 2)."</div>"',
//                ),
                array(
                    'header'=>'Jumlah Jasa',
                    'type'=>'raw',
                    'value'=>'"<div style=\"text-align:right;\"> Rp ".MyFormatter::formatNumberForPrint($data->jumlahjasa, 2)."</div>"',
                ),                    
//                array(
//                    'header'=>'Jumlah Pajak',
//                    'type'=>'raw',
//                    'value'=>'"<div style=\"text-align:right;\"> Rp ".MyFormatter::formatNumberForPrint($data->jumlahpajak, 2)."</div>"',
//                ),
//                array(
//                    'header'=>'Jumlah Pengajuan',
//                    'type'=>'raw',
//                    'value'=>'"<div style=\"text-align:right;\"> Rp ".MyFormatter::formatNumberForPrint($data->jumlahbayar, 2)."</div>"',
//                ),
        ),
    )); 
				
//if (count((array)$perawat)>0){
?>
<!--<table style="width: 100%; border: none;">
	<tr>
		<td></td>
		<td></td>
		<td width="20%" style="text-align:right;">Pembagi <?php // echo count((array)$perawat); ?></td>
		<td width="13%" style="text-align:right;">
			<?php   
			
//				if (count((array)$perawat)){
//					$pembagi = $model->totalbayarjasa/count((array)$perawat);
//				}else{
//					$pembagi = $model->totalbayarjasa;
//				}
//				
//				echo MyFormatter::formatNumberForPrint(round($pembagi));
			?>
		</td>
	</tr>
</table>-->
<?php 
//}
if(isset($_GET['caraPrint'])){?>
<table style="width: 100%; border: none;">
    <tr>
        <td style="width:30%; text-align:center; padding-bottom: 50px;" colspan="2">
        </td>
        <td style="width:40%; text-align:center; padding-bottom: 50px;" colspan="2">
        </td>
        <td style="width:40%; text-align:center; padding-bottom: 50px;" colspan="2">
            <?php echo ProfilrumahsakitM::model()->findByPk(Yii::app()->user->getState('profilrs_id'))->kabupaten->kabupaten_nama?>, <?php echo $format->formatDateTimeId(date('Y-m-d'))?>
            <br><br><br><br><br><br>
            <?php if (!empty($model->rujukandari_id) || !empty($model->pegawai_id)): ?>
            <span style="font-weight: bold;"><?php echo empty($model->rujukandari_id) ? $model->pegawai->NamaLengkap : $model->rujukandari->namaperujuk; ?></span>
            <?php endif; ?>
        </td>
    </tr>
</table>
    <?php }?>
<?php  
if(isset($frame)){
    echo CHtml::link(
        Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 
        "#", 
        array(
            'class'=>'btn btn-info',
            'onclick'=>"printDetail('PRINT'); return false",
        )
    ); ?>
    <script>
    function printDetail(caraPrint) 
    {
        window.open('<?php echo $this->createUrl('Print', array('id'=>$model->pembayaranjasa_id,'det'=>'det')); ?>'+'&caraPrint=' + caraPrint,'printwin','left=100,top=100,width=980,height=400,scrollbars=1');
    }
    </script>
<?php } ?>