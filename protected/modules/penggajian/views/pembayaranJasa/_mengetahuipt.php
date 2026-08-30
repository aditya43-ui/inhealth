<style>
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
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>'BUKTI PENGAJUAN JASA', 'deskripsi'=>'', 'colspan'=>10));

//echo "<h5 style='color:#333;text-align:right'>".$modProfilRs->kecamatan->kecamatan_nama.", ".  MyFormatter::formatDateTimeForUser(date('Y-m-d'))."</h5>";
 
$sukses = null;
if(isset($_GET['sukses'])){
	$sukses = $_GET['sukses'];
}
if($sukses > 0){
	Yii::app()->user->setFlash('success',"Status Mengetahui berhasil disimpan!");
}

$this->widget('bootstrap.widgets.BootAlert'); 
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
$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>false,
	'dataProvider'=>$modDetail->searchPrint(),
        'template'=>"{items}\n{pager}",
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
<div class="row">
    <div class="col-sm-4" style="text-align:center;">
		<div class="control-group" style="margin-bottom: 57.5px;margin-top: 10px;">
			Pegawai RS, <br>Mengetahui
		</div>
		<div class="control-group">
			( <?php echo isset($model->tgl_mengetahui)?$model->mengetahuis->NamaLengkap:"";?> )
		</div>
	</div>
    <div class="col-sm-4" style="text-align:center;">
			<?php 
			if(isset($_GET['sukses'])){
				echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
				echo "Pegawai PT,<br> Mengetahui";
			}else{
				echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>";
				echo CHtml::link(Yii::t('mds',' Mengetahui'), 
				$this->createUrl($this->id.'/index'), 
				array('class' => 'btn btn-danger',
					'onclick'=>'myConfirm("Apakah Anda yakin?","Perhatian!",
					function(r) {if(r) window.location = "'.$this->createUrl('MengetahuiPT',array('pembayaranjasa_id'=>$model->pembayaranjasa_id,'approve'=>true)).'";} ); return false;'));  
			}
			?>
		</div>	
		<div class="control-group">
			( <?php echo $model->mengetahuipt->NamaLengkap;?> )
		</div>	
	</div>
    
	<div class="col-sm-4" style="text-align:center;">
		<div class="control-group" style="margin-bottom: 57.5px;margin-top: 10px;">
			Pegawai, <br>Menyetujui
		</div>
		<div class="control-group">
			( <?php echo isset($model->tgl_menyetujui)?$model->menyetujuis->NamaLengkap:"";?> )
		</div>
	</div>
</div>

<?php 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    $urlPrint= $this->createUrl('printMengetahuiPT',array('pembayaranjasa_id'=>$model->pembayaranjasa_id));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
    ?>