<style>
    body {
        color: black;
    }
    
    .tab_detail {
        width: 100%;
    }
    
    .tab_detail th {
        font-weight: bold;
        text-align: center;
    }
    
    .tab_detail th, .tab_detail td {
        border: 1px solid black;
        padding: 3px;
    }
    
    .tab_detail tfoot td {
        font-weight: bold;
    }
    
    .num {
        text-align: right;
    }
</style>

<?php
$mod = PengeluaranumumT::model()->findByPk($id);
$modBuktiKeluar = TandabuktikeluarT::model()->findByPk($mod->tandabuktikeluar_id);

$modDetail = UraiankeluarumumT::model()->findAllByAttributes(array(
    'pengeluaranumum_id'=>$id,
), array(
	'join'=>'join penggajianpeg_t pp on pp.penggajianpeg_id = t.penggajianpeg_id',
    'order'=>'pp.nopenggajian asc',
));

// var_dump($prop->criteria); die;

$periode = null;

foreach ($modDetail as $item) {
	$peg = PenggajianpegT::model()->findByPk($item->penggajianpeg_id);
	
    if (empty($periode)) $periode = empty($peg->periodegaji) ? $peg->tglpenggajian : $peg->periodegaji;
}

$bulan = (int)date('m', strtotime($periode));
$tahun = date('Y', strtotime($periode));
/*
if ($bulan == 1) {
    $bulan = 12;
    $tahun--;
} else {
    $bulan--;
}
 * 
 */


?>

<table style="width: 100%; border: none;">
    <tr>
        <td width="150" nowrap>Telah Bayar Kepada</td>
        <td width="100%">:&nbsp;<?php echo $modBuktiKeluar->namapenerima; ?></td>
        <td nowrap>Periode Gaji</td>
        <td nowrap>: &nbsp;<?php echo Params::getBulan3()[$bulan]." ".$tahun; ?></td>
    </tr>
    <tr>
        <td nowrap>Dalam Jumlah Angka </td>
        <td>: &nbsp;<?php echo MyFormatter::formatNumberForPrint($modBuktiKeluar->jmlkaskeluar);?></td>
        <td>No. BKK</td>
        <td width="25%" nowrap>: &nbsp;<?php echo $modBuktiKeluar->nokaskeluar; ?></td>
    </tr>
    <tr>
        <td>Dalam Jumlah Huruf</td>
        <td>:<i>&nbsp;<?php echo MyFormatter::formatNumberTerbilang($modBuktiKeluar->jmlkaskeluar); ?> Rupiah</i></td>
        <td nowrap>Tanggal BKK</td>
        <td nowrap>: &nbsp;<?php echo MyFormatter::formatDateTimeForUser($modBuktiKeluar->tglkaskeluar); ?></td>
    </tr>
</table>
<br><br>
<?php // die; ?>

<table class="tab_detail">
    <thead>
        <tr>
            <th>No. </th>
            <th>No. Penggajian</th>
            <th>NIP</th>
            <th>Nama Pegawai</th>
            <th width="120">Penerimaan</th>
            <th width="120">Potongan/Pengurangan</th>
            <th width="120">Penerimaan Bersih</th>
			<th width="120">Dibayar</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $total = 0;
		$totalBayar = 0;
        $cnt = 1;
        foreach ($modDetail as $det): 
			
			$data = PenggajianpegT::model()->findByPk($det->penggajianpeg_id);
			$peg = PegawaiM::model()->findByPk($data->pegawai_id);
			
            $total += $data->penerimaanbersih;
			$totalBayar += $det->totalharga;
                        $totalpotonganPengurangan = $data->totalpotongan+$data->pengurangan;
            ?>
        <tr>
            <td><?php echo $cnt++; ?></td>
            <td><?php echo $data->nopenggajian; ?></td>
            <td><?php echo $peg->nomorindukpegawai; ?></td>
            <td><?php echo $peg->nama_pegawai; ?></td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($data->totalterima); ?></td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($totalpotonganPengurangan); ?></td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($data->penerimaanbersih); ?></td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($det->totalharga); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" class="num">Grand Total</td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($total); ?></td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($totalBayar); ?></td>
        </tr>
    </tfoot>
</table>

<?php
/*
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'kupembgajipeg-t-grid',
	'dataProvider'=>$prop,
    'enablePagination'=>false,
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'name'=>'nopenggajian',
                    'value'=>'$data->nopenggajian',
                    'footer'=>'Total Gaji Bersih',
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align: right; font-weight: bold;',
                        'colspan'=>5,
                    )
                ),
        /*
                array(
                    'name'=>'periodegaji',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->periodegaji)',
                ),
         * 
         *//*
		array(
                    'name'=>'pegawai_nip',
                    'value'=>'$data->pegawai_nip',
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    )
                ),
		array(
                    'name'=>'pegawai_nama',
                    'value'=>'$data->pegawai_nama',
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    )
                ),
		array(
                    'name'=>'totalterima',
                    'value'=>'MyFormatter::formatNumberForPrint($data->totalterima)',
                    'htmlOptions'=>array(
                        'style'=>'text-align: right',
                    ),
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    )
                ),
		array(
            'header'=>'Potongan',
                    'name'=>'totalpotongan',
                    'value'=>'MyFormatter::formatNumberForPrint($data->totalpotongan)',
                    'htmlOptions'=>array(
                        'style'=>'text-align: right',
                    ),
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    )
                ),
		array(
                    'name'=>'penerimaanbersih',
                    'value'=>'MyFormatter::formatNumberForPrint($data->penerimaanbersih)',
                    'htmlOptions'=>array(
                        'style'=>'text-align: right',
                    ),
                    'footer'=> MyFormatter::formatNumberForPrint($gtotal),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align: right; font-weight: bold;',
                    )
                ),
        
		
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); */ ?>