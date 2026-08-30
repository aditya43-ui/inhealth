<?php if (isset($judulLaporan)){
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));      
}
?>
<table bgcolor='white' class='table table-striped table-bordered table-condensed'>
    <tr bgcolor='white'>
        <td bgcolor='white'>
             <b><?php echo CHtml::encode($modBeli->getAttributeLabel('nopembelian')); ?>:</b>
            <?php echo CHtml::encode($modBeli->nopembelian); ?>
            <br>
             <b><?php echo CHtml::encode($modBeli->getAttributeLabel('tglpembelian')); ?>:</b>
            <?php echo CHtml::encode($modBeli->tglpembelian); ?>
             <br>
             
        </td>
        <td bgcolor='white'>
             <b><?php echo CHtml::encode($modBeli->getAttributeLabel('peg_pemesanan_id')); ?>:</b>
            <?php echo CHtml::encode($modBeli->pemesan->nama_pegawai); ?>
            <br>
             <b><?php echo CHtml::encode($modBeli->getAttributeLabel('create_time')); ?>:</b>
            <?php echo CHtml::encode($modBeli->create_time); ?>
            <br>
        </td>
    </tr>   
</table>

<table id="tableObatAlkes" class="table table-striped table-bordered table-condensed" bgcolor='white'>
    <thead>
        <th>No.Urut</th>
        <th>Golongan</th>
        <th>Kelompok</th>
        <th>Sub Kelompok</th>
        <th>Bidang</th>
        <th>Barang</th>
        <th>Harga Beli</th>
        <th>Harga Satuan</th>
        <th>Jumlah Beli</th>
        <th>Satuan</th>
        <th>Ukuran<br>Bahan</th>
    </thead>
    <tbody>
    <?php
    $no=1;
        foreach($modDetailBeli AS $detail): ?>
        <?php $modBarang = BarangM::model()->findByPk($detail->barang_id); ?>
            <tr bgcolor='white'>   
                <td bgcolor='white'><?php echo $no; ?></td>
                <td bgcolor='white'><?php echo !empty($modBarang->bidang_id)?$modBarang->bidang->subkelompok->kelompok->golongan->golongan_nama:null;  ?></td>
                <td bgcolor='white'><?php echo !empty($modBarang->bidang_id)? $modBarang->bidang->subkelompok->kelompok->kelompok_nama:null; ?></td>
                <td bgcolor='white'><?php echo !empty($modBarang->bidang_id)?$modBarang->bidang->subkelompok->subkelompok_nama:null; ?></td>
                <td bgcolor='white'><?php echo !empty($modBarang->bidang_id)?$modBarang->bidang->bidang_nama:null; ?></td>
                <td bgcolor='white'><?php echo $modBarang->barang_nama; ?></td>
                <td bgcolor='white'><?php echo $detail->hargabeli; ?></td>
                <td bgcolor='white'><?php echo $detail->hargasatuan; ?></td>
                <td bgcolor='white'><?php echo $detail->jmlbeli; ?></td>
                <td bgcolor='white'><?php echo $detail->satuanbeli; ?></td>
                <td bgcolor='white'><?php echo $modBarang->barang_ukuran; ?><br><?php echo $modBarang->barang_bahan; ?></td>
            </tr>   
            <?php 
        $no++;
        
        endforeach;
     
    ?>
    </tbody>
</table>
<table width="100%" style="margin-top:20px;">
	<tr>
		<td width="100%" align="left" align="top">
			<table style="width: 100%; border: none;">
				<tr>
					<td width="35%" align="center">
						<div>Mengetahui</div>
						<div style="margin-top:60px;"><?php echo isset($modBeli->peg_mengetahui_id) ? $modBeli->mengetahui->NamaLengkap : "" ?></div>
					</td>
					<td width="35%" align="center">
					</td>
					<td width="35%" align="center">
						<div>Menyetujui</div>
						<div style="margin-top:60px;"><?php echo isset($modBeli->peg_menyetujui_id) ? $modBeli->menyetujui->NamaLengkap : "" ?></div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>