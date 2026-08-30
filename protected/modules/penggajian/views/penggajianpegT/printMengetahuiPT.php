<style>
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
    
    .border {
        box-shadow:none;
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');   
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
?>

<table bgcolor='white' class='table' style = "box-shadow:none;">
    <tr bgcolor='white'>
        <td>
             <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('nomorindukpegawai')); ?></b>
        </td>
        <td>
            : <?php echo CHtml::encode($modelpegawai->nomorindukpegawai); ?>
        </td>
        <td>
            <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('nama_pegawai')); ?></b>            
        </td>
        <td>: <?php echo CHtml::encode($modelpegawai->nama_pegawai); ?></td>
        <td>
            <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('tempatlahir_pegawai')); ?></b>            
        </td>
        <td>: <?php echo CHtml::encode($modelpegawai->tempatlahir_pegawai); ?></td>
    </tr>
    <tr>
        <td>
             <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('tgl_lahirpegawai')); ?></b>
        </td>
        <td>
            : <?php echo !empty($modelpegawai->tgl_lahirpegawai)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($modelpegawai->tgl_lahirpegawai)))):"-" ?>
        </td>
        <td>
            <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('jeniskelamin')); ?></b>            
        </td>
        <td>: <?php echo CHtml::encode($modelpegawai->jeniskelamin); ?></td>
        <td>
            <b><?php echo CHtml::encode("Jabatan"); ?></b>            
        </td>
        <td>: <?php echo CHtml::encode($modelpegawai->jabatan_nama); ?></td>
        
    </tr>
    <tr>
        <td>
             <b><?php echo CHtml::encode("No Rekening"); ?></b>
        </td>
        <td>
            : <?php echo CHtml::encode($modelpegawai->norekening); ?> <?php echo CHtml::encode($modelpegawai->banknorekening); ?>
        </td>
         <td>
            <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('npwp')); ?></b>            
        </td>
        <td>: <?php echo CHtml::encode($modelpegawai->npwp); ?></td>
         <td>
            <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('notelp_pegawai')); ?></b>            
        </td>
        <td>: <?php echo CHtml::encode($modelpegawai->notelp_pegawai); ?> <?php echo CHtml::encode($modelpegawai->nomobile_pegawai); ?></td>
    </tr>
    <tr>
        <td>
            <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('agama')); ?></b>            
        </td>
        <td>: <?php echo CHtml::encode($modelpegawai->agama); ?></td>
        <td>
            <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('alamat_pegawai')); ?></b>            
        </td>
        <td>: <?php echo CHtml::encode($modelpegawai->alamat_pegawai); ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</table>

<div class="row">
    <div class="col-sm-6">
        <table bgcolor='white' class='table' style = "box-shadow:none;">
            <tr bgcolor='white'>
               <td>
                    <b><?php echo CHtml::encode($model->getAttributeLabel('tglpenggajian')); ?></b>
               </td>
               <td>
                   : <?php echo !empty($model->tglpenggajian)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($model->tglpenggajian)))):"-" ?>
               </td>
            </tr>
            <tr>
               <td>
                    <b><?php echo CHtml::encode($model->getAttributeLabel('nopenggajian')); ?></b>            
                </td>
                <td>: <?php echo CHtml::encode($model->nopenggajian); ?></td>
            </tr>
            <tr>
               <td>
                    <b><?php echo CHtml::encode($model->getAttributeLabel('keterangan')); ?></b>            
                </td>
                <td>: <?php echo CHtml::encode($model->keterangan); ?></td>
            </tr>
            <tr>
               <td>
                    <b><?php echo CHtml::encode($model->getAttributeLabel('totalpajak')); ?></b>            
                </td>
                <td>: <?php echo CHtml::encode($model->totalpajak); ?></td>
            </tr>
            <tr>
               <td>
                    <b><?php echo CHtml::encode($model->getAttributeLabel('penerimaanbersih')); ?></b>            
                </td>
                <td>: <?php echo CHtml::encode($model->penerimaanbersih); ?></td>
            </tr>
        </table>
    </div>
    <div class="col-sm-6">
        <table id="tableObatAlkes" class="table border" bgcolor='white'>
            <thead>
                <th>Deskripsi</th>
                <th>Gaji</th>
                <th>Potongan</th>
            </thead>
             <tbody>
                 <?php foreach ($kom as $item): 
                    $komdat = KomponengajiM::model()->findByPk($item->komponengaji_id);

                    ?>
                 <tr bgcolor='white'>
                    <td bgcolor='white'><?php echo $komdat->komponengaji_nama; ?></td>
                    <td bgcolor='white' style="text-align: right;"><?php if (!$komdat->ispotongan) echo MyFormatter::formatNumberForPrint($item->jumlah); ?></td>
                    <td bgcolor='white' style="text-align: right;"><?php if ($komdat->ispotongan) echo MyFormatter::formatNumberForPrint($item->jumlah); ?></td>
                 </tr> 
                  <?php endforeach; ?>
             </tbody>
             <tfoot>
                <tr>
                    <th style="text-align: right">
                            Total
                    </th>
                    <th>
                        <?php echo CHtml::encode($model->totalterima); ?>
                    </th>
                    <th>
                         <?php echo CHtml::encode($model->totalpotongan); ?>
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!--<table bgcolor='white' class='table' style = "box-shadow:none;">
    <tr bgcolor='white' >
        <td>
             <b><?php // echo CHtml::encode($model->getAttributeLabel('nopembelian')); ?></b>
        </td>
        <td>
            : <?php // echo CHtml::encode($model->nopembelian); ?>
        </td>
        <td>
            &nbsp;
        </td>    
        <td>
            <b><?php // echo CHtml::encode($model->getAttributeLabel('peg_pemesanan_id')); ?></b>            
        </td>
        <td>: <?php // echo CHtml::encode($model->pemesan->nama_pegawai); ?></td>
    </tr>
    <tr>
        <td>
             <b><?php // echo CHtml::encode($model->getAttributeLabel('tglpembelian')); ?></b>
        </td>
        <td>
            : <?php // echo !empty($model->tglpembelian)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($model->tglpembelian)))):"-" ?>
        </td>
        <td>
            &nbsp;
        </td> 
        <td>
             <b><?php // echo "Supplier" ?></b>            
        </td>
        <td>
            : <?php 
//                $nama = SupplierM::model()->findByAttributes(array('supplier_id'=>$model->supplier_id));
//                echo $nama->supplier_nama;
            ?>
        </td>
    </tr>
    <tr>
        <td>
             <b><?php // echo CHtml::encode($model->getAttributeLabel('tgldikirim')); ?></b>
        </td>
        <td>
            : <?php // echo !empty($model->tgldikirim)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($model->tgldikirim)))):"-"; ?>
        </td>
    </tr>
        
</table>

<table id="tableBarang" class="table border" bgcolor='white'>
    <thead>
        <th>No.Urut</th>
        <th>Golongan</th>
        <th>Bidang</th>
        <th>Kelompok</th>
        <th>Sub Kelompok</th>
        <th>Sub Sub Kelompok</th>
        <th>Barang</th>
        <th>Harga Beli</th>
        <th>Harga Satuan</th>
        <th>Jumlah Beli</th>
        <th>Satuan</th>
        <th>Ukuran<br>Bahan</th>
    </thead>
    <tbody>
    <?php
//    $no=1;
//        foreach($modDetailBeli AS $detail): ?>
        <?php // $modBarang = BarangM::model()->findByPk($detail->barang_id); ?>
            <tr bgcolor='white'>   
                <td bgcolor='white'><?php // echo $no; ?></td>
                <td bgcolor='white'><?php // echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->kelompok->bidang->golongan->golongan_nama:null;  ?></td>
                <td bgcolor='white'><?php // echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->kelompok->bidang->bidang_nama:null;  ?></td>
                <td bgcolor='white'><?php // echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->kelompok->kelompok_nama:null; ?></td>
                <td bgcolor='white'><?php // echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->subkelompok_nama:null; ?></td>
                <td bgcolor='white'><?php // echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subsubkelompok_nama:null; ?></td>
                <td bgcolor='white'><?php // echo $modBarang->barang_nama; ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php // echo "Rp".$format->formatNumberForPrint($detail->hargabeli); ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php // echo "Rp".$format->formatNumberForPrint($detail->hargasatuan); ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php // echo $format->formatNumberForPrint($detail->jmlbeli).' '.$detail->satuanbeli; ?></td>
                <td bgcolor='white'><?php //echo $detail->satuanbeli; ?></td>
                <td bgcolor='white'><?php // echo $modBarang->barang_ukuran; ?><br><?php // echo $modBarang->barang_bahan; ?></td>
            </tr>   
            <?php 
//        $no++;
        
//        endforeach;
     
    ?>
    </tbody>
</table>-->
<table style="width: 100%; border: none;">
	<tr>
		<th style="width:33%; text-align:center; padding-bottom: 50px;" colspan="2">
		<?php 
		if(isset($model->tgl_mengetahui)){ ?>
			Mengetahui (RS),
			<br><br><br><br><br><br>
			( <?php echo $model->mengetahui;?> )
		<?php } ?>			
		</th>
        <th style="text-align:center; padding-bottom: 50px;" colspan="2">
		<?php 
		if(isset($model->tgl_mengetahuipt)){ ?>
			Mengetahui (PT),
			<br><br><br><br><br><br>
			( <?php echo $model->mengetahuipt;?> )
		<?php } ?>			
		</th>
		<th style="width:33%; text-align:center; padding-bottom: 50px;" colspan="2">
			Menyetujui,
			<br><br><br><br><br><br>
			( <?php echo $model->menyetujui;?> )
		</th>
	</tr>
</table>