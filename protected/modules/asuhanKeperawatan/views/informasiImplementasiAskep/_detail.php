<table style="width: 100%; border: none;">
    <tr>
        <td style="text-align:center;" align="center"><b>IMPLEMENTASI KEPERAWATAN</b></td>
    </tr>
</table>
<div class="white-container">
    <div class="row">
        <table style="width: 100%; border: none;">
            <tr>
                <td>
                    <p>No. Implementasi</p>
                </td>
                <td>
                    <p> : <?php echo isset($model->no_implementasi) ? $model->no_implementasi : "-"; ?></p>
                </td>
                <td>
                    <p>Tanggal Implementasi</p>
                </td>
                <td>
                    <p> : <?php echo isset($model->implementasiaskep_tgl) ? MyFormatter::FormatDateTimeForUser($model->implementasiaskep_tgl) : "-"; ?></p>
                </td>
                <td>
                    <p>Nama Perawat</p>
                </td>
                <td>
                    <p> : <?php echo isset($model->nama_pegawai) ? $model->nama_pegawai : "-"; ?></p>
                </td>
            </tr>
        </table>
    </div>
    <div class="row">
        <fieldset class="box">
            <legend class="rim">Data Rencana</legend>
            <table style="width: 100%; border: none;">
                <tr>
                    <td>
                        <p>No. Rencana</p>
                    </td>
                    <td>
                        <p> : <?php echo isset($modRencana->no_rencana) ? $modRencana->no_rencana : "-"; ?></p>
                    </td>
                    <td>
                        <p>Tanggal Rencana</p>
                    </td>
                    <td>
                        <p> : <?php echo isset($modRencana->rencanaaskep_tgl) ? MyFormatter::FormatDateTimeForUser($modRencana->rencanaaskep_tgl) : "-"; ?></p>
                    </td>
                    <td>
                        <p>Nama Perawat</p>
                    </td>
                    <td>
                        <p> : <?php echo isset($modRencana->nama_pegawai) ? $modRencana->nama_pegawai : "-"; ?></p>
                    </td>
                </tr>
            </table>
        </fieldset>
    </div>
    <div class="row">
        <fieldset class="box">
            <legend class="rim">Identitas Pasien</legend>
            <table style="width: 100%; border: none;">
                <tr>
                    <td>
                        <p>No. Pendaftaran</p>
                    </td>
                    <td>
                        <p> : <?php echo isset($modPasien->no_pendaftaran) ? $modPasien->no_pendaftaran : "-"; ?></p>
                    </td>
                    <td>
                        <p>Nama Pasien</p>
                    </td>
                    <td>
                        <p> : <?php echo isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : "-"; ?></p>
                    </td>
                    <td>
                        <p>Ruangan</p>
                    </td>
                    <td>
                        <p> : <?php echo isset($model->ruangan_nama) ? $model->ruangan_nama : "-" ?></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Tanggal Pendaftaran</p>
                    </td>
                    <td>
                        <p> : <?php echo isset($modPasien->tgl_pendaftaran) ? MyFormatter::formatDateTimeForUser($modPasien->tgl_pendaftaran) : "-"; ?></p>
                    </td>
                    <td>
                        <p>Umur</p>
                    </td>
                    <td>
                        <p> : <?php echo isset($modPasien->umur) ? $modPasien->umur : "-"; ?></p>
                    </td>
                    <td>
                        <p>Kelas</p>
                    </td>
                    <td>
                        <p> : <?php echo (isset($model->kelaspelayanan_nama) ? $model->kelaspelayanan_nama : $model->getKelasPelayanan($modPasien->pendaftaran_id)) ?></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>No Rekam Medik</p>
                    </td>
                    <td>
                        <p> : <?php echo isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : "-"; ?></p>
                    </td>
                    <td>
                        <p>Diagnosa Medik Masuk</p>
                    </td>
                    <td>
                        <p> : <?php echo (isset($modPasien->diagnosa_nama) ? $modPasien->diagnosa_nama : $model->getDiagnosaMedis($modPasien->pasien_id, $modPasien->pendaftaran_id)); ?></p>
                    </td>
                    <td>
                        <p>No Kamar / No. Bed</p>
                    </td>
                    <td>
                        <p> : <?php echo (isset($model->kamarruangan_nokamar) ? $model->kamarruangan_nokamar : $model->getNoKamar($modPasien->pendaftaran_id)) . ' / ' . (isset($model->kamarruangan_nobed) ? $model->kamarruangan_nobed : $model->getNoBed($modPasien->pendaftaran_id)); ?></p>
                    </td>
                </tr>
            </table>
        </fieldset>
    </div>

    <?php
    $impldet = ASImplementasiaskepdetT::model()->findAllBySql(
        'SELECT implementasiaskepdet_t.*,diagnosakep.*
					FROM implementasiaskepdet_t
					JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = implementasiaskepdet_t.diagnosakep_id
					WHERE implementasiaskepdet_t.implementasiaskep_id=' . $model->implementasiaskep_id
    );
    ?>
    <div class="row">
        <fieldset class="box">
            <legend class="rim">Implementasi Keperawatan</legend>
            <table width="100%" class="table table-striped table-condensed table-bordered">
                <thead>
                    <th>Diagnosa Keperawatan</th>
                    <th>Rencana Intervensi</th>
                    <th>Implementasi</th>
                    <th>Kolaborasi</th>
                </thead>
                <tbody>
                    <?php
                    if (count($impldet)) {
                        foreach ($impldet as $i => $modDetail) {

                    ?>
                            <tr>
                                <td>
                                    <?php echo $modDetail->diagnosakep_nama; ?>
                                    <?php
                                    echo "<br>";
                                    echo "<br>";
                                    echo '<b>Batasan Karakteristik</b>';
                                    echo "<br>";
                                    $bk_head = BataskarakteristikM::model()->findAllByAttributes(array('diagnosakep_id' => $modDetail->diagnosakep_id));
                                    if (count($bk_head)) {
                                        foreach ($bk_head as $i => $bk) {
                                            echo "<ul class='spasi1'>";
                                            echo '<li >' . $bk->bataskarakteristik_nama . '</li>';
                                            $bk_tail = BataskarakteristikdetM::model()->findAllByAttributes(array('bataskarakteristikdet_aktif' => true, 'bataskarakteristik_id' => $bk->bataskarakteristik_id));
                                            if (count($bk_tail)) {
                                                foreach ($bk_tail as $i => $bkd) {
                                                    echo '<li >' . $bkd->bataskarakteristikdet_indikator . '</li>';
                                                }
                                            } else {
                                                echo "<ul class='spasi1'>";
                                                echo '<li> Data tidak ditemukan. </li>';
                                                echo "</ul>";
                                            }
                                            echo "</ul>";
                                        }
                                    } else {
                                        echo "<ul class='spasi1'>";
                                        echo '<li> Data tidak ditemukan. </li>';
                                        echo "</ul>";
                                    }

                                    echo "<br>";

                                    echo '<b>Faktor Risiko</b>';
                                    echo "<br>";
                                    $bk_head = FaktorrisikoM::model()->findAllByAttributes(array('diagnosakep_id' => $modDetail->diagnosakep_id));
                                    if (count($bk_head)) {
                                        foreach ($bk_head as $i => $bk) {
                                            echo "<ul class='spasi1'>";
                                            echo '<li >' . $bk->faktorrisiko_nama . '</li>';
                                            $bk_tail = FaktorrisikodetM::model()->findAllByAttributes(array('faktorrisikodet_aktif' => true, 'faktorrisiko_id' => $bk->faktorrisiko_id));
                                            if (count($bk_tail)) {
                                                foreach ($bk_tail as $i => $bkd) {
                                                    echo '<li >' . $bkd->faktorrisikodet_indikator . '</li>';
                                                }
                                            } else {
                                                echo "<ul class='spasi1'>";
                                                echo '<li> Data tidak ditemukan. </li>';
                                                echo "</ul>";
                                            }
                                            echo "</ul>";
                                        }
                                    } else {
                                        echo "<ul class='spasi1'>";
                                        echo '<li> Data tidak ditemukan. </li>';
                                        echo "</ul>";
                                    }

                                    echo "<br>";

                                    echo '<b>Faktor Yang Berhubungan</b>';
                                    echo "<br>";
                                    $bk_head = FaktorhubM::model()->findAllByAttributes(array('diagnosakep_id' => $modDetail->diagnosakep_id));
                                    if (count($bk_head)) {
                                        foreach ($bk_head as $i => $bk) {
                                            echo "<ul class='spasi1'>";
                                            echo '<li >' . $bk->faktorhub_nama . '</li>';
                                            $bk_tail = FaktorhubdetM::model()->findAllByAttributes(array('faktorhubdet_aktif' => true, 'faktorhub_id' => $bk->faktorhub_id));
                                            if (count($bk_tail)) {
                                                foreach ($bk_tail as $i => $bkd) {
                                                    echo '<li >' . $bkd->faktorhubdet_indikator . '</li>';
                                                }
                                            } else {
                                                echo "<ul class='spasi1'>";
                                                echo '<li> Data tidak ditemukan. </li>';
                                                echo "</ul>";
                                            }
                                            echo "</ul>";
                                        }
                                    } else {
                                        echo "<ul class='spasi1'>";
                                        echo '<li> Data tidak ditemukan. </li>';
                                        echo "</ul>";
                                    }

                                    echo "<br>";

                                    echo '<b>Diagnosa Alternatif</b>';
                                    echo "<br>";
                                    $bk_head = AlternatifdxM::model()->findAllByAttributes(array('alternatifdx_aktif' => true, 'diagnosakep_id' => $modDetail->diagnosakep_id));
                                    if (count($bk_head)) {
                                        foreach ($bk_head as $i => $bk) {
                                            echo "<ul class='spasi1'>";
                                            echo '<li >' . $bk->alternatifdx_nama . '</li>';
                                            echo "</ul>";
                                        }
                                    } else {
                                        echo "<ul class='spasi1'>";
                                        echo '<li> Data tidak ditemukan. </li>';
                                        echo "</ul>";
                                    }
                                    ?>
                                </td>
                                <td><?php
                                    if (!empty($modDetail->diagnosakep_id)) {
                                        $tail = ASPilihrencanaaskepT::model()->findAllBySql('
									SELECT pilihrencanaaskep_t.*,intervensidet.*
									FROM pilihrencanaaskep_t
									JOIN intervensidet_m AS intervensidet ON intervensidet.intervensidet_id = pilihrencanaaskep_t.intervensidet_id
									WHERE rencanaaskepdet_id =' . $modDetail->rencanaaskepdet_id . ' AND pilihrencanaaskep_t.intervensidet_id IS NOT NULL');
                                        $modInv = IntervensiM::model()->findByAttributes(array('diagnosakep_id' => $modDetail->diagnosakep_id));
                                        $data['table_id'] = 'table-intervensi-' . $modDetail->intervensi_id;
                                        echo '<table class="items table table-striped table-bordered table-condensed intervensi" id="' . $data['table_id'] . '">
                                                                                    
            <thead>
                    <th>Intervensi</th>
                    <th>Indikator Intervensi</th>
            </thead>
			<tbody>';
                                        echo '<tr>';
                                        echo '<td>' . (isset($modDetail->intervensi_id) ? $modDetail->intervensi_nama : (isset($modInv) ? $modInv->intervensi_nama : "-")) . '</td>';
                                        echo '<td>';
                                        foreach ($tail as $i => $itv) {
                                            echo '<ul>';
                                            echo '<li>' . $itv['intervensidet_indikator'] . '</li>';
                                            echo '</ul>';
                                        }
                                        '</td>';
                                        echo '</tr>';
                                        echo '</tbody></table>';
                                    }
                                    ?></td>

                                <td>
                                    <?php
                                    $impl = ASPilihimplementasiaskepT::model()->findAllBySql('
									SELECT pilihimplementasiaskep_t.*,indikatorimplkepdet.*
									FROM pilihimplementasiaskep_t
									JOIN indikatorimplkepdet_m AS indikatorimplkepdet ON indikatorimplkepdet.indikatorimplkepdet_id = pilihimplementasiaskep_t.indikatorimplkepdet_id
									WHERE implementasiaskepdet_id =' . $modDetail->implementasiaskepdet_id . ' AND pilihimplementasiaskep_t.indikatorimplkepdet_id IS NOT NULL');
                                    if (count($impl)) {
                                        foreach ($impl as $i => $indikator) {
                                            echo "<ul class='spasi1'>";
                                            echo '<li style="padding: 0 0px 0px 10px;">' . $indikator->indikatorimplkepdet_indikator . '</li>';
                                            echo "</ul>";
                                        }
                                    } else {
                                        echo "<ul class='spasi1'>";
                                        echo '<li> Data tidak ditemukan. </li>';
                                        echo "</ul>";
                                    }
                                    ?>
                                </td>
                                <td><?php echo ($modDetail->implementasiaskepdet_iskolaborasi == 1) ? "Ya" : "Tidak"; ?>
                                    <?php
                                    echo "<br>";
                                    echo 'Ket: ';
                                    echo isset($modDetail->implementasiaskepdet_ketkolaborasi) ? $modDetail->implementasiaskepdet_ketkolaborasi : "-";
                                    echo "<br><br>";
                                    echo isset($modDetail->pegawai_id) ? $modDetail->pegawai->nama_pegawai : "-";
                                    ?></td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr>";
                        echo "<td colspan=6>Data tidak ditemukan.</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </fieldset>
    </div>

</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
    ?>
    <?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printDetail');
    $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

    $js = <<< JSCRIPT

function print(caraPrint)
{
    window.open("${urlPrint}/&implementasiaskep_id="+$model->implementasiaskep_id+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>
</div>