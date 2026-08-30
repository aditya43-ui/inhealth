<style>
    
    .sec-border {
        border: 1px solid black;
        padding: 3px;
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

<?php

$pegawai_pemasang = "-";
$peg = PegawaiM::model()->findByPk($model->kanulaiv_pegawaipemasang);

if (!empty($peg)) {
    $pegawai_pemasang = $peg->namaLengkap;
}

?>

<table style="width: 100%; border: none;">
    <tr>
        <td class="sec-border">
            <div class="sec-judul">Daftar Tilik Keselamatan Pasien</div>
            <table width="100%" class="detail">
                <tr>
                    <td width="50%">
                        <ul>
                            <li><?php echo $model->getAttributeLabel('isizinoperasi') ?> : <?php echo $model->isizinoperasi; ?></li>
                            <li><?php echo $model->getAttributeLabel('issuplaisilinderoksigen') ?> : <?php echo $model->issuplaisilinderoksigen; ?></li>
                            <li><?php echo $model->getAttributeLabel('isekgterpasang') ?> : <?php echo $model->isekgterpasang; ?></li>
                            <li><?php echo $model->getAttributeLabel('iskateterurine') ?> : <?php echo $model->iskateterurine; ?></li>
                            <li><?php echo $model->getAttributeLabel('isperhiasandilepas') ?> : <?php echo $model->isperhiasandilepas; ?></li>
                            <li><?php echo $model->getAttributeLabel('isrambutditutup') ?> : <?php echo $model->isrambutditutup; ?></li>
                            <li><?php echo $model->getAttributeLabel('isgigipalsu_dilepas') ?> : <?php echo $model->isgigipalsu_dilepas; ?></li>
                            <li><?php echo $model->getAttributeLabel('kanulaiv_ukuran') ?> : <?php echo $model->kanulaiv_ukuran; ?></li>
                            <li><?php echo $model->getAttributeLabel('kanulaiv_lokasi') ?> : <?php echo $model->kanulaiv_lokasi; ?></li>
                            <li><?php echo $model->getAttributeLabel('kanulaiv_pegawaipemasang') ?> : <?php echo $pegawai_pemasang; ?></li>
                        </ul>
                    </td>
                    <td>
                        <table class="tab_border">
                            <thead>
                                <tr>
                                    <th>Jenis Cairan</th>
                                    <th>Volume</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($det as $item): ?>
                                <tr>
                                    <td><?php echo $item->cairan_jenis; ?></td>
                                    <td style="text-align: right;"><?php echo $item->cairan_volume; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    <tr/>
    <tr>
        <td class="sec-border">
            <div class="sec-judul">Cek Mesin Anesthesia</div>
            <table width="100%" class="detail">
                <tr>
                    <td width="50%">
                        <ul>
                            <li><?php echo $model->getAttributeLabel('mesinanestesi_supplailistrik') ?> : <?php echo $model->mesinanestesi_supplailistrik; ?></li>
                            <li><?php echo $model->getAttributeLabel('mesinanestesi_breathyngsystem') ?> : <?php echo $model->mesinanestesi_breathyngsystem; ?></li>
                        </ul>
                    </td>
                    <td>
                        <ul>
                            <li><?php echo $model->getAttributeLabel('mesinanestesi_co2absorbent') ?> : <?php echo $model->mesinanestesi_co2absorbent; ?></li>
                            <li><?php echo $model->getAttributeLabel('mesinanestesi_ventilator') ?> : <?php echo $model->mesinanestesi_ventilator; ?></li>
                        </ul>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="sec-border">
            <div class="sec-judul">Status Akhir Mesin</div>
            <table width="100%" class="detail">
                <tr>
                    <td width="50%">
                        <ul>
                            <li><?php echo $model->getAttributeLabel('mesinstatusakhir_vaporizeroff') ?> : <?php echo $model->mesinstatusakhir_vaporizeroff; ?></li>
                            <li><?php echo $model->getAttributeLabel('mesinstatusakhir_aplvalveopen') ?> : <?php echo $model->mesinstatusakhir_aplvalveopen; ?></li>
                            <li><?php echo $model->getAttributeLabel('mesinstatusakhir_bagmode') ?> : <?php echo $model->mesinstatusakhir_bagmode; ?></li>
                            <li><?php echo $model->getAttributeLabel('mesinstatusakhir_flowmeter') ?> : <?php echo $model->mesinstatusakhir_flowmeter; ?></li>
                            <li><?php echo $model->getAttributeLabel('mesinstatusakhir_suctionunit') ?> : <?php echo $model->mesinstatusakhir_suctionunit; ?></li>
                            <li><?php echo $model->getAttributeLabel('mesinstatusakhir_laringoskop') ?> : <?php echo $model->mesinstatusakhir_laringoskop; ?></li>
                        </ul>
                    </td>
                    <td>
                        <ul>
                            <li><?php echo $model->getAttributeLabel('mesinstatusakhir_ettlmaigel') ?> : <?php echo $model->mesinstatusakhir_ettlmaigel; ?></li>
                            <li><?php echo $model->getAttributeLabel('mesinstatusakhir_orophairway') ?> : <?php echo $model->mesinstatusakhir_orophairway; ?></li>
                            <li><?php echo $model->getAttributeLabel('mesinstatusakhir_plester') ?> : <?php echo $model->mesinstatusakhir_plester; ?></li>
                            <li><?php echo $model->getAttributeLabel('mesinstatusakhir_introducer') ?> : <?php echo $model->mesinstatusakhir_introducer; ?></li>
                            <li><?php echo $model->getAttributeLabel('persiapanobat') ?> : <?php echo $model->persiapanobat; ?></li>
                            <li><?php echo $model->getAttributeLabel('cekmonitor') ?> : <?php echo $model->cekmonitor; ?></li>
                        </ul>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>