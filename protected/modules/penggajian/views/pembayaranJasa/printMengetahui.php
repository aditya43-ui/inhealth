<style>
	table{
		 border-collapse: collapse;
	}
	
    body {
        color: black;
    }
    
    .border th, .border td{
        border:1px solid #000;
        padding: 2px;
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
</style>
<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$template = "{items}\n{pager}";

if (isset($_GET['caraPrint'])){
    $template = "{items}";
	if ($_GET['caraPrint'] == 'EXCEL'){
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="pengajuanjasa-'.date("Y/m/d").'.xlsx"');
		header('Cache-Control: max-age=0'); 
$table = 'ext.bootstrap.widgets.BootExcelGridView';                
	
	}
}
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());

echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>'BUKTI PENGAJUAN JASA', 'deskripsi'=>'', 'colspan'=>10));

$format = new MyFormatter;
$perawat = null;
?>

<table style="width: 100%; border: none;">
    <tr><td colspan="5">&nbsp;</td>
	</tr>
    <tr>
        <?php if (!empty($model->rujukandari_id) || !empty($model->pegawai_id)): ?>
        <td style="vertical-align: top;">Nama</td>
		<td>: <?php echo empty($model->rujukandari_id) ? $model->pegawai->NamaLengkap : $model->rujukandari->namaperujuk; ?></td>		
        <?php else: ?>
        <td style="vertical-align: top;">Nama</td><td>
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
            <ol>
                <?php foreach ($res as $item): ?>
                <li><?php echo $item; ?></li>
                <?php endforeach; ?>
            </ol>
        </td>		
        <?php endif; ?>
    </tr>
    <tr><td nowrap>Periode Pembayaran</td><td style="width: 100%">: <?php echo $format->formatDateTimeId($model->periodejasa)." s.d ".$format->formatDateTimeId($model->sampaidgn); ?></td></tr>
	<tr>		
		<td>Total Pengajuan</td>
		<td>: <?php echo MyFormatter::formatNumberForPrint($model->totalbayarjasa) ?></td>
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
                    'header'=>'Tanggal',
                    'type'=>'raw',
                    'value'=>function($data) {
                        $bayar = PembayaranpelayananT::model()->findByAttributes(array(
                            'pendaftaran_id'=>$data->pendaftaran->pendaftaran_id
                        ));
                        
                        return MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($bayar->tglpembayaran)));
                    } //'$data->pendaftaran->no_pendaftaran ."/<br>". $data->pasien->no_rekam_medik',
                ),                                         
                array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'value'=>'$data->pasien->nama_pasien',
                ),				
				array(
					'header'=>'Keterangan',
					'type'=>'raw',
					'value'=>function($data){
						if (!empty($data->obatalkespasien_id)) {
							$modOA = InformasipenjualanaresepV::model()->findByAttributes(array(
								'obatalkespasien_id'=>$data->obatalkespasien_id,
							));
							return $modOA->jenispenjualan;
						} else {
							$modTindakan = TindakanpelayananT::model()->findByPk($data->tindakanpelayanan_id);
							return $modTindakan->daftartindakan->daftartindakan_nama;
						}						                       
						
					},
					'footer' => 'Total',
					'footerHtmlOptions' => array('colspan'=>4,'style'=>'text-align:right;')
				),				               
                array(
                    'header'=>'Jumlah',
                    'type'=>'raw',
					'name'=>'jumlahbayar',
                    'value'=>'"<div style=\"text-align:right;\">".MyFormatter::formatNumberForPrint($data->jumlahbayar)."</div>"',
					'footer'=>'sum(jumlahbayar)',
					'footerHtmlOptions' => array('style'=>'text-align:right;')
                ),               
        ),
    )); 
					
if (count((array)$perawat)>0){
?>
<table style="width: 100%; border: none;">
	<tr>
		<td></td>
		<td></td>
		<td width="20%" style="text-align:right;">Pembagi <?php echo count((array)$perawat); ?></td>
		<td width="13%" style="text-align:right;">
			<?php   
			
				if (count((array)$perawat)){
					$pembagi = $model->totalbayarjasa/count((array)$perawat);
				}else{
					$pembagi = $model->totalbayarjasa;
				}
				
				echo MyFormatter::formatNumberForPrint(round($pembagi));
			?>
		</td>
	</tr>
</table>
<?php 
}
?>

    <table style="width: 100%; border: none;">
            <tr>
            <th style="width:30%; text-align:center; padding-bottom: 50px;" colspan="2">
                    Direktur RS, <br>Mengetahui
                    <br><br><br><br><br><br>
                    ( <?php echo $model->mengetahuis->NamaLengkap;?> )
            </th>
		<th style="width:40%; text-align:center; padding-bottom: 50px;" colspan="2">
		<?php 
//		if(isset($model->tgl_mengetahuipt)){ ?>
			<!--Pegawai PT, <br>Mengetahui-->
			<!--<br><br><br><br><br><br>-->
			<!--( <?php // echo $model->mengetahuipt->NamaLengkap;?> )-->
		<?php // } ?>			
		</th>
		<th style="width:40%; text-align:center; padding-bottom: 50px;" colspan="2">
		<?php 
		if(isset($model->tgl_menyetujui)){ ?>
			Direktur PT, <br>Menyetujui
			<br><br><br><br><br><br>
			( <?php echo $model->menyetujuis->NamaLengkap;?> )
		<?php } ?>			
		</th>
	</tr>
    </table>
