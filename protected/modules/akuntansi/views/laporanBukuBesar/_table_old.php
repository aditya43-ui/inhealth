<style type="text/css">
	.table th{
		text-align: center;
	}
</style>
<?php
Yii::app()->clientScript->registerScript('cari cari', "
        $('#search-form').submit(function(){
			$('#tableLaporan').addClass('srbacLoading');
            $.fn.yiiGridView.update('tableLaporan', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
?>

<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
if (isset($caraPrint)) {
	$template = "{items}";
	$sort = false;
	if ($caraPrint == "EXCEL")
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
}else {
	
}

$a = 0;
foreach ($jmlrekening as $key => $jmls) {
	$a += $jmls['urutan'];
	$struktur[$key] = $a;
}
?>

<?php
if (isset($caraPrint)) {
	$nmRekening_temp = "";
	foreach ($model as $i => $data) {
		if ($data->rekeningjurnal5_nama) {
			$nmRekening = $data->rekeningjurnal5_nama;
		} else {
			if ($data->rekeningjurnal4_nama) {
				$nmRekening = $data->rekeningjurnal4_nama;
			} else {
				$nmRekening = $data->rekeningjurnal3_nama;
			}
		}

		if ($nmRekening_temp != $nmRekening) {
			if ($data->rekeningjurnal5_kode) {
				$kdRekening = $data->rekeningjurnal5_kode;
				$kdRekening_text = $data->rekeningjurnal1_kode . '-' . $data->rekeningjurnal2_kode . '-' . $data->rekeningjurnal3_kode . '-' . $data->rekeningjurnal4_kode . '-' . $data->rekeningjurnal5_kode;
			} else {
				if ($data->rekeningjurnal4_kode) {
					$kdRekening = $data->rekeningjurnal4_kode;
					$kdRekening_text = $data->rekeningjurnal1_kode . '-' . $data->rekeningjurnal2_kode . '-' . $data->rekeningjurnal3_kode . '-' . $data->rekeningjurnal4_kode;
				} else {
					$kdRekening = $data->rekeningjurnal3_kode;
					$kdRekening_text = $data->rekeningjurnal1_kode . '-' . $data->rekeningjurnal2_kode . '-' . $data->rekeningjurnal3_kode;
				}
			}
			echo "<table class='table table-striped table-condensed'>
                    <tr>
                        <td><b>Nama Rekening</storng></td>
                        <td><b>:</b></td>
                        <td>" . $nmRekening . "</td>
                    </tr>
                    <tr>
                        <td><b>Kode Rekening</b></td>
                        <td><b>:</b></td>
                        <td>" . $kdRekening_text . "</td>
                    </tr>";
			echo "</table>";

			echo "<table width='100%' border='1' class='table table-striped '>
					<tr style='font-weight:bold;'>
						<td rowspan='2'>Tgl. Posting</td>
						<td rowspan='2'>Uraian Transaksi</td>
						<td rowspan='2' style='text-align:center'>No. Ref</td>
						<td colspan='2' style='text-align:center'>Saldo</td>
						<td rowspan='2' style='text-align:center'>Saldo</td>
					</tr>
					<tr style='font-weight:bold;'>
						<td style='text-align:center'>Debit</td>
						<td style='text-align:center'>Kredit</td>
					</tr>";

			$criteria = new CDbCriteria;
			$term = $nmRekening;
			$termKode = $kdRekening;
			if (!empty($modelLaporan->periodeposting_id)) {
				$criteria->addCondition('periodeposting_id =' . $modelLaporan->periodeposting_id);
			}
			if (!empty($modelLaporan->ruangan_id)) {
				$criteria->addCondition('ruangan_id =' . $modelLaporan->ruangan_id);
			}
//			$criteria->group = 'rekeningjurnal1_id, rekeningjurnal2_id, rekeningjurnal3_id, rekeningjurnal4_id, rekeningjurnal5_id,rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id,nmrekening1, nmrekening2, nmrekening3, nmrekening4, nmrekening5, kdrekening1, kdrekening2,kdrekening3,kdrekening4,kdrekening5, nourut, no_referensi,rekeningjurnal5_saldonormal,tglbukubesar';
//			$criteria->select = $criteria->group.', sum(saldodebitjurnal) as saldodebitjurnal, sum(saldokreditjurnal) as saldokreditjurnal';
			$condition = "rekeningjurnal5_nama ILIKE '%" . $term . "%' OR rekeningjurnal4_nama ILIKE '%" . $term . "%' OR rekeningjurnal3_nama ILIKE '%" . $term . "%'";
			$conditionKode = "rekeningjurnal5_kode ILIKE '%" . $termKode . "%' OR rekeningjurnal4_kode ILIKE '%" . $termKode . "%' OR rekeningjurnal3_kode ILIKE '%" . $termKode . "%'";
			$criteria->addCondition($condition);
			$criteria->addCondition($conditionKode);
			$criteria->limit = -1;
			$criteria->order = 'rekeningjurnal1_id, rekeningjurnal2_id, rekeningjurnal3_id, rekeningjurnal4_id, rekeningjurnal5_id, tglbukubesar ASC, nourut ASC';

			$totDebit = 0;
			$totKredit = 0;
			$totSaldo = 0;
			$detail = AKLaporanbukubesarV::model()->findAll($criteria);
			foreach ($detail as $key => $details) {
				if ($details->saldodebitjurnal > 0 && $details->saldokreditjurnal > 0) {
					$saldo = $details->saldodebitjurnal - $details->saldokreditjurnal;
				} else if ($details->saldodebitjurnal > 0) {
					$saldo = $details->saldodebitjurnal - $details->saldokreditjurnal;
				} else if ($details->saldodebitjurnal <= 0 && $details->saldokreditjurnal > 0) {
					$saldo = $details->saldodebitjurnal - $details->saldokreditjurnal;
				}

				if ($details->rekeningjurnal5_saldonormal == 'D') {
					$saldo = $details->saldodebitjurnal - $details->saldokreditjurnal;
				} else {
					$saldo = $details->saldokreditjurnal;
				}

				$totDebit += $details->saldodebitjurnal;
				$totKredit += $details->saldokreditjurnal;

				if ($details->rekeningjurnal5_saldonormal == 'D') {
					$totSaldo = $totDebit - $totKredit;
				} elseif ($details->rekeningjurnal5_saldonormal == 'K') {
					$totSaldo = $totKredit - $totDebit;
				}

				echo "<tr>
						<td width='150px;'>" . MyFormatter::formatDateTimeId($details->tglbukubesar) . "</td>
						<td width='200px;'>" . $details->getNamaRekening() . "</td>
						<td width='40px;' style='text-align:center'>" . $details->no_referensi . "</td>
						<td width='150px;' style='text-align:right'>" . number_format($details->saldodebitjurnal) . "</td>
						<td width='150px;' style='text-align:right'>" . number_format($details->saldokreditjurnal) . "</td>
						<td width='150px;' style='text-align:right'>" . number_format($totSaldo) . "</td>
					</tr>";
			}

			echo "<tfoot>
						<tr>
							<td colspan=3 style='text-align:right'><b>Total : </b></td>
							<td width='150px;' style='text-align:right'>" . number_format($totDebit) . "</td>
							<td width='150px;' style='text-align:right'>" . number_format($totKredit) . "</td>
							<td width='150px;' style='text-align:right'>" . number_format($totSaldo) . "</td>
						</tr>
					</tfoot>";
			echo "</table><br><br>";
		}
		$nmRekening_temp = $nmRekening;
	}
	?>
<?php
} else {
	$nmRekening_temp = "";
	echo "<table class='table table-striped table-condensed'>
				<thead>
					<tr>
						<th rowspan='2'>Tgl. Posting</th>
						<th rowspan='2'>Uraian Transaksi</th>
						<th rowspan='2' style='text-align:center'>No. Ref</th>
						<th colspan='2' style='text-align:center'>Saldo</th>
						<th rowspan='2' style='text-align:center'>Saldo</th>
					</tr>
					<tr>
						<th style='text-align:center'>Debit</th>
						<th style='text-align:center'>Kredit</th>
					</tr>
				</thead>
				<tbody>";
	foreach ($model as $i => $data) {
		if ($data->rekeningjurnal5_nama) {
			$nmRekening = $data->rekeningjurnal5_nama;
		} else {
			if ($data->rekeningjurnal4_nama) {
				$nmRekening = $data->rekeningjurnal4_nama;
			} else {
				$nmRekening = $data->rekeningjurnal3_nama;
			}
		}

		if ($nmRekening_temp != $nmRekening) {
			if ($data->rekeningjurnal5_kode) {
				$kdRekening = $data->rekeningjurnal5_kode;
				$kdRekening_text = $data->rekeningjurnal1_kode . '-' . $data->rekeningjurnal2_kode . '-' . $data->rekeningjurnal3_kode . '-' . $data->rekeningjurnal4_kode . '-' . $data->rekeningjurnal5_kode;
			} else {
				if ($data->rekeningjurnal4_kode) {
					$kdRekening = $data->rekeningjurnal4_kode;
					$kdRekening_text = $data->rekeningjurnal1_kode . '-' . $data->rekeningjurnal2_kode . '-' . $data->rekeningjurnal3_kode . '-' . $data->rekeningjurnal4_kode;
				} else {
					$kdRekening = $data->rekeningjurnal3_kode;
					$kdRekening_text = $data->rekeningjurnal1_kode . '-' . $data->rekeningjurnal2_kode . '-' . $data->rekeningjurnal3_kode;
				}
			}

			echo "
				<tr>
                      <td colspan=6><b><i>" . $nmRekening . "</i></b></td>
                </tr>
					";

			$criteria = new CDbCriteria;
			$term = $nmRekening;
			$termKode = $kdRekening;
			if (!empty($modelLaporan->periodeposting_id)) {
				$criteria->addCondition('periodeposting_id =' . $modelLaporan->periodeposting_id);
			}
			if (!empty($modelLaporan->ruangan_id)) {
				$criteria->addCondition('ruangan_id =' . $modelLaporan->ruangan_id);
			}
//			$criteria->group = 'rekeningjurnal1_id, rekeningjurnal2_id, rekeningjurnal3_id, rekeningjurnal4_id, rekeningjurnal5_id,rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id,nmrekening1, nmrekening2, nmrekening3, nmrekening4, nmrekening5, kdrekening1, kdrekening2,kdrekening3,kdrekening4,kdrekening5, nourut, no_referensi,rekeningjurnal5_saldonormal,tglbukubesar';
//			$criteria->select = $criteria->group.', sum(saldodebitjurnal) as saldodebitjurnal, sum(saldokreditjurnal) as saldokreditjurnal';
			$condition = "rekeningjurnal5_nama ILIKE '%" . $term . "%' OR rekeningjurnal4_nama ILIKE '%" . $term . "%' OR rekeningjurnal3_nama ILIKE '%" . $term . "%'";
			$conditionKode = "rekeningjurnal5_kode ILIKE '%" . $termKode . "%' OR rekeningjurnal4_kode ILIKE '%" . $termKode . "%' OR rekeningjurnal3_kode ILIKE '%" . $termKode . "%'";
			$criteria->addCondition($condition);
			$criteria->addCondition($conditionKode);
			$criteria->limit = -1;
			$criteria->order = 'rekeningjurnal1_id, rekeningjurnal2_id, rekeningjurnal3_id, rekeningjurnal4_id, rekeningjurnal5_id, tglbukubesar ASC, nourut ASC';

			$totDebit = 0;
			$totKredit = 0;
			$totSaldo = 0;
			$detail = AKLaporanbukubesarV::model()->findAll($criteria);
			foreach ($detail as $key => $details) {
				if ($details->saldodebitjurnal > 0 && $details->saldokreditjurnal > 0) {
					$saldo = $details->saldodebitjurnal - $details->saldokreditjurnal;
				} else if ($details->saldodebitjurnal > 0) {
					$saldo = $details->saldodebitjurnal - $details->saldokreditjurnal;
				} else if ($details->saldodebitjurnal <= 0 && $details->saldokreditjurnal > 0) {
					$saldo = $details->saldodebitjurnal - $details->saldokreditjurnal;
				}

				if ($details->rekeningjurnal5_saldonormal == 'D') {
					$saldo = $details->saldodebitjurnal - $details->saldokreditjurnal;
				} else {
					$saldo = $details->saldokreditjurnal;
				}

				$totDebit += $details->saldodebitjurnal;
				$totKredit += $details->saldokreditjurnal;

				if ($details->rekeningjurnal5_saldonormal == 'D') {
					$totSaldo = $totDebit - $totKredit;
				} elseif ($details->rekeningjurnal5_saldonormal == 'K') {
					$totSaldo = $totKredit - $totDebit;
				}

				echo "<tr>
						<td width='150px;'>" . MyFormatter::formatDateTimeId($details->tglbukubesar) . "</td>
						<td width='200px;'>" . $details->getNamaRekening() . "</td>
						<td width='40px;' style='text-align:center'>" . $details->no_referensi . "</td>
						<td width='150px;' style='text-align:right'>" . number_format($details->saldodebitjurnal) . "</td>
						<td width='150px;' style='text-align:right'>" . number_format($details->saldokreditjurnal) . "</td>
						<td width='150px;' style='text-align:right'>" . number_format($totSaldo) . "</td>
					</tr>";
			}

			echo "
						<tr>
							<td colspan=3 style='text-align:right'><b>Total " . $nmRekening . "</b></td>
							<td width='150px;' style='text-align:right'>" . number_format($totDebit) . "</td>
							<td width='150px;' style='text-align:right'>" . number_format($totKredit) . "</td>
							<td width='150px;' style='text-align:right'>" . number_format($totSaldo) . "</td>
						</tr>
					";

			$nmRekening_temp = $nmRekening;
		}
	}
	echo "<tbody>
		  </table>";
}
?>
