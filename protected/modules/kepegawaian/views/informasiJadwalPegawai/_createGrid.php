<?php
if (!empty($caraPrint)) {
    $table = "table border";
} else {
    $table = "table table-striped table-bordered table-condensed";
}

?>

<style>
    .table>tbody>tr:hover {
        filter: none;
    }

    .table>tbody>tr>td:hover {
        background: #fff;
        filter: brightness(.85);
    }
</style>

<table class="<?php echo $table  ?>" border="1">
    <thead>
        <tr>
            <?php
            foreach (CustomFunction::getNamaHari() as $key => $value) {
                echo '<th>' . $value . '</th>';
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $jumlah = 1;
        for ($x = 1; $x <= ceil($jumlahHari / count(CustomFunction::getNamaHari())); $x++) {
            echo '<tr>';
            foreach (CustomFunction::getNamaHari() as $key => $value) {
                $tgl = Yii::app()->dateFormatter->formatDateTime(strtotime($tahun . '-' . $bulan . '-' . $jumlah), 'full', null);
                $tanggal = explode(',', $tgl);
                if ($jumlah > $jumlahHari) {
                    echo '<td class="disabled"></td>';
                } else {
                    if (strtolower(trim($value)) == strtolower(trim($tanggal[0]))) {
                        echo '<td><b>' . $tanggal[1] . "</b><hr>";
                        $gen = date("dmY", strtotime($tahun . '-' . $bulan . '-' . $jumlah));

                        if (isset($variable["$gen"])) {
                            foreach ($variable["$gen"]['det'] as $s) {
                                echo '<b><i>' . $s['shift_nama'] . ' (' . $s['shift_jamawal'] . ' - ' . $s['shift_jamakhir'] . ')</i></b><br>';
                                echo "<ul>";
                                foreach ($s['det'] as $j) {

                                    if (!empty($is_print)) {

                                        echo '<li>'
                                            . $j['nama_pegawai']
                                            . '</li>';

                                        continue;
                                    }

                                    if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_KEPEGAWAIAN) {
                                        $onclick = "$('#dialogUbahJadwal').dialog('open');";
                                        $onclickBatal = "batalJadwal(this, " . $j['penjadwalandetail_id'] . "); return false;";
                                    } else {

                                        /*
												$cekR = Params::getCekJabatanPJRuang(Yii::app()->user->getState('jabatan_id'),'ruangan');
												$stJ = false;
												
												
												if (empty($cekR)){
													$cekI = Params::getCekJabatanPJRuang(Yii::app()->user->getState('jabatan_id'),'instalasi');
													if (!empty($cekI)){
														$stJ = true;
													}
												}else{
													$stJ = true;
												}
                                                 * 
                                                 */

                                        if ($this->checkAccess()) {
                                            $onclick = "$('#dialogUbahJadwal').dialog('open');";
                                            $onclickBatal = "batalJadwal(this, " . $j['penjadwalandetail_id'] . "); return false;";
                                        } else {
                                            $onclick = "myAlert('Anda tidak diizinkan untuk mengakses fitur ini'); return false;";
                                            $onclickBatal = "myAlert('Anda tidak diizinkan untuk mengakses fitur ini'); return false;";
                                        }
                                    }

                                    echo '<li>'
                                        . CHtml::link("<u>" . $j['nama_pegawai'] . "</u>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahJadwal', array("penjadwalandetail_id" => $j['penjadwalandetail_id'])), array(
                                            "onclick" => $onclick,
                                            //echo '<li>'.CHtml::link("<u>".$j['nama_pegawai']."</u>",'javascript:;', array("penjadwalandetail_id"=>$j['penjadwalandetail_id']),array("onclick"=>"myAlert('Underconstruction')",
                                            "target" => "frameUbahJadwal",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk mengubah jadwal pegawai",
                                        ))
                                        . CHtml::link('<i class="glyphicon glyphicon-remove"></i>', "#", array(
                                            "onclick" => $onclick,
                                            //echo '<li>'.CHtml::link("<u>".$j['nama_pegawai']."</u>",'javascript:;', array("penjadwalandetail_id"=>$j['penjadwalandetail_id']),array("onclick"=>"myAlert('Underconstruction')",
                                            "onclick" => $onclickBatal,
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk membatalkan jadwal pegawai",
                                        ))

                                        . '</li>';
                                }
                                echo "</ul>";
                                echo "<br>";
                            }
                        } else {
                            echo 'Tidak ada jadwal';
                        }
                        //echo ;
                        echo '</td>';
                        $jumlah++;
                    } else {
                        echo '<td class="disabled"></td>';
                    }
                }
            }
            if ($x == ($jumlahHari / count(CustomFunction::getNamaHari()))) {
                if ($jumlah <= $jumlahHari) {
                    $x--;
                }
            }
            echo '</tr>';
        }
        ?>

    </tbody>
</table>