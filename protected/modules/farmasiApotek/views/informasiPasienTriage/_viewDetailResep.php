<?php
if(isset($_GET['caraPrint'])){
	echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10)); 
}

$dok = array();
foreach ($modDetailResep as $data){
    // $dt = InformasipembayarantagihannontunaiV::model()->findAllByAttributes(['closingkasir_id' => $item->closingkasir_id]);

    if(!empty($data->resepturdetail_id)){
        $idx_line = "0_".$data->resepturdetail_id;
        $tesidxline[] = $idx_line;
    }
    if (empty($dok[$data->racikan->racikan_nama])) {
        $dok[$data->racikan->racikan_nama] = array(
            'nama'=>$data->racikan->racikan_nama,
            'content'=>array(),
        );
    }
    if (empty($dok[$data->racikan->racikan_nama]['content'][$idx_line])) {
        $dok[$data->racikan->racikan_nama]['content'][$idx_line] = array(
            'resepturdetail_id'=>$data->resepturdetail_id,
            'obatalkes_id'=>$data->obatalkes->obatalkes_nama." (".$data->obatlain_nama.") ",
            'satuankecil_id'=>$data->satuankecil->satuankecil_nama,
            'r'=>$data->r,
            'rke' => $data->rke,
            'permintaan_reseptur'=>$data->permintaan_reseptur,
            'satuankekuatan'=>$data->satuankekuatan,
            'qty_reseptur'=> $data->qty_reseptur,
        );
    }
}
// echo '<pre>';
// var_dump($dok);die;
?>
<table width="100%" style="margin-left:auto; margin-right:auto;">
    <tr>
        <td>No. Rekam Medik</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->no_rekam_medik); ?></td>
        <td>No. Pendaftaran</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->namadepan.$modPendaftaran->pasien->nama_pasien); ?></td>
        <td nowrap>Tgl. Pendaftaran</td><td>:</td><td><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran)); ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?></td>
        <td>No. Reseptur</td><td>:</td><td><?php echo CHtml::encode($modReseptur->noresep); ?></td>
    </tr>
    <tr>
        <td>Umur</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->umur); ?></td>
        <td>Tgl. Reseptur</td><td>:</td><td><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modReseptur->tglreseptur)); ?></td>
    </tr>
    <tr>
        <td nowrap>Jenis Penjamin / Penjamin</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama); ?> / <?php echo CHtml::encode($modPendaftaran->penjamin->penjamin_nama); ?></td>
        <td>Dokter</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pegawai->namaLengkap); ?></td>
    </tr>
       
</table>
<br/>
<table id="tblDaftarResep" class="table table-bordered table-condensed" border="2">
    <thead>
        <tr>
            <th>Resep</th>
            <th>Nama Obat</th>
            <!--th>Satuan</th-->
            <th <?php echo Params::HIDDEN_HARGA; ?>>Estimasi Harga Satuan</th>
            <th>Dosis Racikan</th>
            <th>Jumlah Obat</th>
            <th <?php echo Params::HIDDEN_HARGA; ?>>Sub Total</th>
<!--            <th>&nbsp;</th>-->
        </tr>
    </thead>
    <?php
        foreach($dok as $item) :
        ?>
        <tr>
            <th style="text-align:left" colspan="8"><?php echo $item['nama'];?></th>
        </tr>
        
        <?php
            foreach ($item['content'] as $item2) :
                // $cnt++;
            ?>
        <tr>
            <!-- <td width="4%"><?php  //echo $cnt;?></td> -->
            <td>R/ <?php echo $item2['rke'];?></td>
            <td><?php  echo $item2['obatalkes_id'];//echo !empty($rekap[$i]->nama_pasien) ? $rekap[$i]->nama_pasien : "-";?></td>
            <td><?php echo $item2['permintaan_reseptur']." ".$item2['satuankekuatan'];?></td>
            <td><?php  echo $item2['qty_reseptur']." ".$item2['satuankecil_id'];?></td>
        </tr>
        <?php endforeach;?>
        <?php endforeach;?>
    
    <?php //echo print_r($modReseptur); 
//    exit(); ?>
    <?php foreach ($modDetailResep as $detail) { ?>
    
    <!-- <tr>
        <td>R/ <?php //echo $detail->rke ?></td>
        <td><?php //echo $detail->obatalkes->obatalkes_nama."(".$detail->obatalkes_nama.")" ?></td>
        <!--td><?php // echo $detail->satuankecil->satuankecil_nama ?></td-->
        <!-- <td style="text-align: right" <?php //echo Params::HIDDEN_HARGA; ?>><?php //echo MyFormatter::formatNumberForPrint($detail->hargasatuan_reseptur) ?></td> -->
        <!-- <td style="text-align: right"><?php //echo $detail->permintaan_reseptur." ".$detail->satuankekuatan ?></td> -->
        <!-- <td style="text-align: right"><?php //echo $detail->qty_reseptur." ".$detail->satuankecil->satuankecil_nama ?></td> -->
        <!-- <td style="text-align: right" <?php //echo Params::HIDDEN_HARGA; ?>><?php //echo MyFormatter::formatNumberForPrint($detail->qty_reseptur * $detail->hargasatuan_reseptur) ?></td> -->
    <!-- </tr> -->
	<?php $idReseptur = $detail->reseptur_id;  ?>
    <?php } ?>
</table>
<br/>
<?php
if(isset($_GET['caraPrint'])){ ?>
	<table align="RIGHT">
		<tr>
			<td>
	<div align="CENTER">
		 Dokter Pemeriksa
		<br/><br/><br/><br/>
	   ( <?php echo CHtml::encode($modPendaftaran->pegawai->nama_pegawai); ?> )
	</div>
			</td>

		</tr>
	</table>
	<table align="LEFT">
		<tr>
			<td>
	<div align="CENTER">
		 Catatan Dokter : <?php echo (isset($riwayat->catatandokterpengirim) ? CHtml::encode($riwayat->catatandokterpengirim) : ""); ?>

	</div>
			</td>

		</tr>
	</table>
<?php }else{ ?>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print Detail',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print("PRINT","'.$idReseptur.'")'))."&nbsp&nbsp"; ?>
	</div>
<?php } ?>


