<style>
    .border th, .border td{
        border:1px solid #000;
        padding:2px;
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
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>"", 'colspan'=>10));
?>
<br>
<br>
<table width="74%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td  width="20%">No. Rencana</td>
            <td>:</td>
            <td><?php echo $model->renkebbarang_no; ?></td>
            
            <td  width="20%">Sumber Dana</td>
            <td>:</td>
            <td><?php echo (!empty($model->sumberdana_id)?$model->sumberdana->sumberdana_nama:""); ?></td>
        </tr>
         <tr>
            <td  width="20%">Tanggal Rencana</td>
            <td>:</td>
            <td><?php echo MyFormatter::formatDateTimeForUser($model->renkebbarang_tgl); ?></td>
        </tr>
    </table>

<table class = "table" style = "box-shadow:none;" id="table-rencanaanggaranpenerimaan">
	<thead>
            <tr>
                <th class = "border">No.</th>
                <th class = "border">Nama Barang</th>
                <th class = "border">Satuan</th>
                <th class = "border">Stok Akhir</th>
                <th class = "border">Minimal Stok</th>
                <th class = "border">Maksimal Stok</th>
                <th class = "border">Jumlah Kebutuhan</th>
                <th class = "border">Harga Satuan (Rp)</th>
                <th class = "border">PPN (%)</th>
                <th class = "border">PPN (Rp)</th>
                <th class = "border">Sub Total (Rp)</th>
            </tr>
	</thead>
	<tbody>
            <?php 
            $total = 0;
            foreach($modDetails as $i => $modDetail){
                $total += $modDetail->hpp;
            ?>
            <tr>
                <td class = "border"><?php echo $i+1; echo ". "; ?></td>
                <td class = "border"><?php echo (!empty($modDetail->barang_id)) ? $modDetail->barang->barang_nama : ""; ?></td>
                <td class = "border"><?php echo $modDetail->satuanbarangdet; ?></td>
                <td class = "border" style="text-align:right;"><?php echo number_format($modDetail->stokakhir_barangdet,2,",","."); ?></td>
                <td class = "border" style="text-align:right;"><?php echo $modDetail->minstok_barangdet; ?></td>
                <td class = "border" style="text-align:right;"><?php echo $modDetail->makstok_barangdet; ?></td>
                <td class = "border" style="text-align:right;"><?php echo number_format($modDetail->jmlpermintaanbarangdet,2,",","."); ?></td>
                <td class = "border" style="text-align:right;"><?php echo (Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($modDetail->harga_barangdet,2,",","."):"Hidden"; ?></td>
                <td class = "border" style="text-align:right;"><?php echo $modDetail->persen_ppn; ?></td>
                <td class = "border" style="text-align:right;"><?php echo (Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($modDetail->ppn,2,",","."):"Hidden"; ?></td>
                <td class = "border" style="text-align:right;"><?php echo (Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($modDetail->hpp,2,",","."):"Hidden"; ?></td>
            </tr>
            <?php } ?>
	</tbody>
        <tfoot>
            <tr>
                <td class = "border" colspan="10" style="text-align:right;"><b>Total</b></td>
                <td class = "border" style="text-align:right;"><b>
                        <?php echo (Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($total,2,",","."):"Hidden"; ?>
                        </b>
                </td>
            </tr>
        </tfoot>
</table><br>
<table width="100%">
	<tr>
            <th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">&nbsp;</th>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">
		<?php 
		if(isset($model->tglmenyetujui)){ ?>
			Menyetujui,
			<br><br><br><br><br><br>
			( <?php echo isset($model->pegmenyetujui_id)?$model->pegawaimenyetujui->namaLengkap:"";?> )
		<?php } ?>			
		</th>
<!--		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">
			Mengetahui,
			<br><br><br><br><br><br>
			( <?php // echo isset($model->pegmengetahui_id)?$model->pegawaimengetahui->namaLengkap:"";;?> )
		</th>-->
	</tr>
</table>