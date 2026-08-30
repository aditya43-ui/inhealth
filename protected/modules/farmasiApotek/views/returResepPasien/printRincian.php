<div style="width:100%;">
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
</div>
<style>
    th, td, div{
        font-family: Arial;
        font-size: 11pt;
    }
    .tandatangan{
        vertical-align: bottom;
        text-align: center;
    }
    
    .tab_detail td, .tab_detail th {
        border: 1px solid black;
        padding: 3px;
    }
</style>
<table  width="100%"><tr><td>
<table style="width: 100%; border: none;">
    <tr>
        <td>No. Retur</td>
        <td>: <?php echo $model->noreturresep;?></td>
        <td width="20%">Nama Pasien</td>
        <td width="30%">: <?php echo $model->pasien->no_rekam_medik; ?> - <?php echo $model->pasien->nama_pasien;?> </td>
    </tr>
    <tr>
        <td>Tgl. Retur </td>
        <td>: <?php echo substr($model->tglretur,0,11); ?></td>
        <td>Umur</td>
        <td>: <?php echo isset($modRincians[0]->obatpasien->pendaftaran->umur)?$modRincians[0]->obatpasien->pendaftaran->umur:'-';?> 
    </tr>
    <tr>
        <td>Ruangan Retur </td>
        <td>: <?php echo $model->ruangan->ruangan_nama?></td>
        <td>Alamat Pasien</td>
        <td>: <?php echo $model->pasien->alamat_pasien;?>
            <?php echo ", ".$model->pasien->kecamatan->kecamatan_nama;?>
        </td>
    </tr>
</table><br>
<table width="100%" class="tab_detail">
    <thead style='border:1px solid;'>
        <th style='text-align: center;'>No.</th>
        <th style='text-align: center;'>Kode</th>
        <th style='text-align: center;'>Nama</th>
        <th style='text-align: center;'>Harga Retur</th>
        <th style='text-align: center;'>Jumlah Retur</th>
        <th style='text-align: center;'>Kondisi Obat</th>        
        <th style='text-align: center;'>Sub Total</th>          
    </thead>
    <?php
    $no=1;
    $totalSubTotal = 0;
    if(count((array)$modRincians) > 0){
            foreach($modRincians AS $i =>$rincian){
				$subtotal = $rincian->qty_retur * $rincian->hargasatuan;
				if($i == 0){
					$tampilheader = true;
				}else{
					if($rincian->obatpasien->penjualanresep_id !== $modRincians[$i-1]->obatpasien->penjualanresep_id){
						$tampilheader = true;
					}else{
						$tampilheader = false;
					}
				}
				if($tampilheader){
					echo '<tr>'
						.'<td colspan="7"><b>'.$rincian->obatpasien->penjualanresep->ruangan->ruangan_nama.' - '.$rincian->obatpasien->penjualanresep->noresep.' - '.substr($rincian->obatpasien->penjualanresep->tglresep,0,11).' - '.$rincian->obatpasien->penjualanresep->carabayar->carabayar_nama.' - '.$rincian->obatpasien->penjualanresep->penjamin->penjamin_nama.'</b></td>'
						.'</tr>';
				}
				echo "<tr style='border:1px solid;''>
					<td style='text-align:right;'>".$no."</td>
					<td>".$rincian->obatpasien->obatalkes->obatalkes_kode."</td>
					<td>".$rincian->obatpasien->obatalkes->obatalkes_nama."</td>
					<td style='text-align: right;'>".MyFormatter::formatUang($rincian->hargasatuan,"",0)."</td>            
					<td style='text-align: right;'>".($rincian->qty_retur)."</td>            
					<td>".$rincian->kondisibrg."</td>            
					<td style='text-align: right;'>".MyFormatter::formatUang($subtotal,"",0)."</td>            
				 </tr>";  
				$no++;
			}
    }
    ?>
</table>
<table style="width:100%;">
    <tr>
        <td style="border: 1px solid;">Alasan Retur :<br>
        <?php echo $model->alasanretur; ?>
        </td>
        <td style="border: 1px solid;">Keterangan Retur :<br>
        <?php echo $model->keteranganretur; ?>
        </td>
    </tr>
</table>
<?php if(isset($_GET['frame'])){
		echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printRincian();return false",'disabled'=>FALSE  ));
}else{ ?>
		<table style="width:100%;">
			<tr>
				<td class="tandatangan">Penerima</td>
				<td class="tandatangan">Mengetahui,</td>
				<td class="tandatangan">Hormat Kami,</td>
			</tr>
			<tr>
				<td class="tandatangan" style="height: 50px;">.........................</td>
				<td class="tandatangan">
					<?php 
					echo (isset($modMengetahuiRetur->gelardepan) ? $modMengetahuiRetur->gelardepan : "")." ".(isset($modMengetahuiRetur->nama_pegawai) ? $modMengetahuiRetur->nama_pegawai : "")."., ".(isset($modMengetahuiRetur->gelarbelakang->gelarbelakang_nama) ? $modMengetahuiRetur->gelarbelakang->gelarbelakang_nama : ""); ?>
				</td>
				<td class="tandatangan">
					<?php 
					echo (isset($modPegawaiRetur->gelardepan) ? $modPegawaiRetur->gelardepan:"")." ".(isset($modPegawaiRetur->nama_pegawai) ? $modPegawaiRetur->nama_pegawai : "")."., ".(isset($modPegawaiRetur->gelarbelakang->gelarbelakang_nama) ? $modPegawaiRetur->gelarbelakang->gelarbelakang_nama : ""); ?>
				</td>
			</tr>
		</table><br>
		<div style="font-size: 9pt;">Print Date: <?php echo Yii::app()->user->getState('nama_pegawai'); ?>
			<?php echo date('d M Y H:i:s'); ?></div>
		</td></tr></table>
<?php } ?>
<script type="text/javascript">
/**
 * print rincian retur obat alkes
 * @returns {undefined} */ 
function printRincian()
{
    window.open("<?php echo $this->createUrl('returResepPasien/printRincian',array('returresep_id'=>$model->returresep_id)) ?>","",'location=_new, width=1024px');
}
</script>
</div>		
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