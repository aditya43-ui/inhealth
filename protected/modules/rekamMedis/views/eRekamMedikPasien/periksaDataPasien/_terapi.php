<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
        {
            header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
              header('Cache-Control: max-age=0');     
        }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));     
}
?>

<?php 
if (count((array)$checkers) == 0) echo "Terapi Obat tidak ditemukan.";
foreach ($checkers as $tgl=>$item) :
    $keterangan = $item['keterangan'];
	if ($item['tipe'] == 1){
		$r = ResepturT::model()->findByPk($item['id']);
		$ruang = $r->createruangan->ruangan_nama;
		if (!empty($r->pegawai_id)){
			$peg = $r->pegawai2->namaLengkap;
		}else{
			$peg = '';
		}
	}elseif($item['tipe'] == 2){
		$catatan = 'resep';
		$r = PenjualanresepT::model()->findByPk($item['id']);
		if (!empty($r->reseptur_id)){
			$catatan = 'reseptur';
			$r = ResepturT::model()->findByPk($r->reseptur_id);
		}
		$ruang = $r->createruangan->ruangan_nama;
		if (!empty($r->pegawai_id)){
			if ($catatan == 'resep'){
				$peg = $r->dokterpeg->namaLengkap;
			}else{
				$peg = $r->pegawai2->namaLengkap;
			}
		}else{
			$peg = '';
		}
	}
?>
	

<table style="width: 100%; border: none;">
	<tr>		
        <td nowrap>Dokter</td><td nowrap>: <?php echo $peg; ?></td>
		<td nowrap>&nbsp;</td>
        <td nowrap>No. Resep</td><td width="100%">: <?php echo $item['noresep']; ?></td>        
    </tr>
    <tr>
        <td nowrap>Apoteker</td><td nowrap>: <?php echo $item['user_apoteker']; ?></td>
        <td nowrap>&nbsp;</td>
        <td nowrap>Tgl. Resep</td><td nowrap>: <?php echo MyFormatter::formatDateTimeForUser($tgl); ?></td>
    </tr>
    <tr>
		<td nowrap>Ruangan</td><td width="100%">: <?php echo $ruang; ?></td>        
		<td nowrap>&nbsp;</td>        
    </tr>
</table>
<table class="items table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th width="10"> R</th>
            <th> Nama Obat </th>
            <!--<th> Etiket / Signa</th>-->
            <th width="50"> Jumlah </th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $oa = array();
        if ($item['tipe'] == 1) {
			$criRep = new CDbCriteria();
			$criRep->join = " JOIN obatalkes_m oa ON oa.obatalkes_id = t.obatalkes_id  ";
			$criRep->addCondition(" reseptur_id = '".$item['id']."' ");
			$criRep->order = " t.rke ASC ";
			
            //$dat = ResepturdetailT::model()->findAllByAttributes(array(
              //  'reseptur_id'=>$item['id'],
            //));
			$dat = ResepturdetailT::model()->findAll($criRep);
            foreach ($dat as $item) {
                array_push($oa, array(
					'r'=>$item->rke,
                    'jenis'=>empty($item->obatalkes->jenisobatalkes_id)?"-":$item->obatalkes->jenisobatalkes->jenisobatalkes_nama,
                    'nama'=>$item->obatalkes->obatalkes_nama,
                    'etiket'=>$item->etiket." / ".$item->signa_reseptur,
                    'qty'=>$item->qty_reseptur,
                    'satuan'=>!empty($item->satuankecil_id)?$item->satuankecil->satuankecil_nama:"",
                ));
            }
        } else if ($item['tipe'] == 2) {
			$criRep = new CDbCriteria();
			$criRep->join = " JOIN obatalkes_m oa ON oa.obatalkes_id = t.obatalkes_id  ";
			$criRep->addCondition(" penjualanresep_id = '".$item['id']."' ");
			$criRep->order = " t.rke ASC ";
            //$dat = ObatalkespasienT::model()->findAllByAttributes(array(
              //  'penjualanresep_id'=>$item['id'],
            //));
			$dat = ObatalkespasienT::model()->findAll($criRep);
            foreach ($dat as $item) {
                array_push($oa, array(
					'r'=>$item->rke,
                    'jenis'=>empty($item->obatalkes->jenisobatalkes_id)?"-":$item->obatalkes->jenisobatalkes->jenisobatalkes_nama,
                    'nama'=>$item->obatalkes->obatalkes_nama,
                    'etiket'=>$item->etiket." / ".$item->signa_oa,
                    'qty'=>$item->qty_oa,
                    'satuan'=>!empty($item->satuankecil_id)?$item->satuankecil->satuankecil_nama:"",
                ));
            }
        }
        ?>
        <?php foreach ($oa as $item): ?>
        <tr>
            <td><?php echo $item['r']; ?></td>
            <td><?php echo $item['nama']; ?></td>
            <!--<td><?php //echo $item['etiket']; ?></td>-->
            <td style="text-align: right;"><?php echo $item['qty']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div style="font-weight: bold;">Keterangan: </div>
<?php
echo empty($keterangan) ? "-" : $keterangan;
?>
<hr>
<?php endforeach; ?>

<?php /* if(empty($modTerapi[0]->reseptur_id)){ ?>
<table>
    <tr>
        <td> No. Reseptur </td><td>: - </td>
        <td> Tgl. Reseptur </td><td>: - </td>
    </tr>
</table>
<table class="items table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th> Jenis Obat</th>
            <th> Nama Obat </th>
            <th> Etiket / Signa</th>
            <th> Jumlah </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="4"> Data tidak ditemukan </td>
        </tr>
    </tbody>
</table>
<?php }else { ?>
<table>
    <tr>
        <td> No. Reseptur : <?php echo $modTerapi[0]->noresep; ?> </td>
    </tr>
    <tr>
        <td> Tgl. Reseptur : <?php echo $modTerapi[0]->tglreseptur; ?> </td>
    </tr>
</table>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array( 
    'id'=>'rjpenjualanresep-t-grid', 
    'dataProvider'=>$modDetailTerapi->searchDetailTerapi($modTerapi[0]->reseptur_id), 
    'filter'=>$modDetailTerapi, 
        'template'=>"{summary}\n{items}\n{pager}", 
        'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    'columns'=>array(
        array(
            'header'=>'Jenis Obat',
            'value'=>'(isset($data->obatalkes->jenisobatalkes->jenisobatalkes_nama) ? $data->obatalkes->jenisobatalkes->jenisobatalkes_nama : "")'
        ),
        array(
            'header'=>'Nama Obat',
            'type'=>'raw',
            'value'=>'$data->obatalkes->obatalkes_nama',
//            'value'=>'$this->grid->getOwner()->renderPartial(\'/riwayatPasien/_terapi_obatalkes_column\',array(\'data\'=>$data->getObatTerapi($data->reseptur_id)),true)',
        ),
        array(
            'header'=>'Etiket / Signa',
            'type'=>'raw',
            'value'=>'$data->signa_reseptur',
        ),
        array(
            'header'=>'Jumlah',
            'type'=>'raw',
            'value'=>'$data->qty_reseptur',
        ),
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 
<?php } */ ?>