<style>
    
    .sec-border {
        border: 1px solid black;
        padding: 3px;
        vertical-align: top;
    }
    
    .sec-judul {
        font-weight: bold;
    }
    
    .detail td {
        vertical-align: top;
    }
    
    .tab_border {
        width: 100%;
    }
    
    .tab_border td, .tab_border th {
        border: 1px solid black;
        padding: 3px;
    }
    
</style>

<?php 

if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');   
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>"", 'colspan'=>10), true);  
echo $this->renderPartial('bedahSentral.views.catatanAnestesi._printInfoPasien', array('model'=>$penunjang), true);  

?>

<h3 style="text-align: center;"><?php echo $judulLaporan; ?></h3>
<table style="width: 100%; border: none;">
    <tr>
        <td class="sec-border" width="50%">
            <ul>
                <li><?php echo $model->getAttributeLabel('statusfisik_asa') ?> : <?php echo $model->statusfisik_asa; ?></li>
                <li><?php echo $model->getAttributeLabel('beratbadan') ?> : <?php echo $model->beratbadan; ?> Kg</li>
                <li>Tekanan Darah : <?php echo $model->td_sitolik." / ".$model->td_diastolik; ?></li>
                <li><?php echo $model->getAttributeLabel('detaknadi') ?> : <?php echo $model->detaknadi; ?> x/menit</li>
                <li><?php echo $model->getAttributeLabel('suhutubuh') ?> : <?php echo $model->suhutubuh; ?> &deg;C</li>
                <li><?php echo $model->getAttributeLabel('hb_pasien') ?> : <?php echo $model->hb_pasien; ?> g/dl</li>
            </ul>
            
            <div class="sec-judul">Pramedikasi</div>
            <table class="tab_border">
                <thead>
                    <tr>
                        <th width="20">No.</th>
                        <th width="150">Obat</th>
                        <th width="20">Jumlah</th>
                        <th width="80">Jam</th>
                        <th>Hasil</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    $det = PremedikasiprainduksiT::model()->findAllByAttributes(array(
                        'asesmenprainduksi_id'=>$model->asesmenprainduksi_id,
                    ));
                    
                    foreach ($det as $idx => $item): ?>
                    
                    <tr>
                        <td><?php echo $idx + 1; ?></td>
                        <td><?php echo empty($item->obatalkes) ? "-" : $item->obatalkes->obatalkes_nama; ?></td>
                        <td><?php echo $item->premedikasi_jumlah; ?></td>
                        <td><?php echo $item->premedikasi_jam; ?></td>
                        <td><?php echo $item->premedikasi_hasil; ?></td>
                    </tr>
                    
                    <?php endforeach; ?>
                </tbody>
            </table>
        </td>
        <td class="sec-border" width="50%">
            <ul>
                <li>
                    <?php
                    $jenis = JenisAnastesiM::model()->findByPk($model->jenisanastesi_id);
                    $jenis_nama = "";

                    if (!empty($jenis)) {
                        $jenis_nama = $jenis->jenisanastesi_nama;
                    }
                    ?>
                    <?php echo $model->getAttributeLabel('jenisanastesi_id') ?> : <?php echo $jenis_nama; ?>
                </li>
                <li><?php echo $model->getAttributeLabel('teknikanastesi') ?> : <?php echo $model->teknikanastesi; ?></li>
                <li><?php echo $model->getAttributeLabel('resiko_anastesi') ?> : <?php echo $model->resiko_anastesi; ?></li>
                <li>
                    <?php
                    $listRencana = RencanaoperasiT::model()->findAllByAttributes(array(
                        'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id,
                    ));

                    $str_rencana = array();
                    foreach ($listRencana as $item) {
                        if (!empty($item->operasi)) {
                            $str_rencana[] = $item->operasi->operasi_nama;
                        }
                    } 
                    ?>
                    Rencana Operasi : <?php echo implode(",", $str_rencana); ?>
                </li>
                <li><?php echo $model->getAttributeLabel('spesimen_diambil') ?> : <?php echo $model->spesimen_diambil; ?></li>
                <li><?php echo $model->getAttributeLabel('posisi_pasien') ?> : <?php echo $model->posisi_pasien; ?></li>
                <li><?php echo $model->getAttributeLabel('hasil_asesmen') ?> : <?php echo $model->hasil_asesmen; ?></li>
                
            </ul>
        </td>
    </tr>
</table>