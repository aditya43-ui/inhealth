<?php ?>
<tr class="rencanaaskepdet">
    <td class="diagnosa">
        <?php echo CHtml::activeHiddenField($modDetail, '[0]implementasiaskepdet_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[0]diagnosakep_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
        <?php
        if (!empty($modDetail->diagnosakep_id)) {
            echo CHtml::activeHiddenField($modDetail, '[0]isdiagnosa', array('value' => 1, 'onkeyup' => "return $(this).focusNextInputField(event);"));
            echo CHtml::activeTextField($modDetail, '[0]diagnosakep_nama', array('readonly' => true));
            echo "<div class='diagdetail'>";
            echo "<br>";
            echo '<b>Penyebab</b>';
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
            echo '<b>Tanda dan Gejala</b>';
            $cekData = PilihdiagnosisaskepT::model()->findAllByAttributes(array('diagnosisaskepdet_id' => $modDetail->diagnosisaskepdet_id));
            if (!empty($cekData)) {
                $cektandagejala = 0;
                foreach ($cekData as $hasil) {
                    if (!empty($hasil->tandagejaladet_id)) {
                        $cektandagejala++;
                    }
                }
                if ($cektandagejala > 0) {
                    echo "<br>";
                    echo "<ul class='spasi1'>";
                    echo '<li ><b>Tanda dan Gejala Mayor</b></li>';
                    echo "<ul class='spasi1'>";
                    $mayor = 0;
                    foreach ($cekData as $value) {
                        $bk_head = TandagejaladetM::model()->findByPk($value->tandagejaladet_id);
                        $bk_tail = TandagejalaM::model()->findByAttributes(array('tandagejala_aktif' => true, 'tandagejala_id' => $bk_head->tandagejala_id));
                        if ($bk_tail->kelompoktandagejala == 'Mayor') {
                            echo '<li >' . $bk_head->tandagejala_indikator . '</li>';
                            $mayor++;
                        }
                    }
                    if ($mayor == 0) {
                        echo '<li> Data tidak ditemukan. </li>';
                        echo "</ul>";
                    }
                    echo "</ul>";
                    echo '<li ><b>Tanda dan Gejala Minor</b></li>';
                    echo "<ul class='spasi1'>";
                    $minor = 0;
                    foreach ($cekData as $value) {
                        $bk_head = TandagejaladetM::model()->findByPk($value->tandagejaladet_id);
                        $bk_tail = TandagejalaM::model()->findByAttributes(array('tandagejala_aktif' => true, 'tandagejala_id' => $bk_head->tandagejala_id));
                        if ($bk_tail->kelompoktandagejala == 'Minor') {
                            echo '<li >' . $bk_head->tandagejala_indikator . '</li>';
                            $minor++;
                        }
                    }
                    if ($minor == 0) {
                        echo '<li> Data tidak ditemukan. </li>';
                        echo "</ul>";
                    }
                    echo "</ul>";
                    echo "</ul>";
                }
            } else {
                echo "<ul class='spasi1'>";
                echo '<li> Data tidak ditemukan. </li>';
                echo "</ul>";
            }

            echo '<b>Faktor Risiko</b>';
            if (!empty($cekData)) {
                $cekfaktorrisiko = 0;
                foreach ($cekData as $hasil) {
                    if (!empty($hasil->faktorrisikodet_id)) {
                        $cekfaktorrisiko++;
                    }
                }
                if ($cekfaktorrisiko > 0) {
                    echo "<br>";
                    echo "<ul class='spasi1'>";
                    $risiko = 0;
                    foreach ($cekData as $value) {
                        $bk_head = FaktorrisikodetM::model()->findByPk($value->faktorrisikodet_id);
                        $bk_tail = FaktorrisikoM::model()->findByAttributes(array('faktorrisiko_id' => $bk_head->faktorrisiko_id));
                        if (!empty($bk_tail)) {
                            echo '<li >' . $bk_head->faktorrisikodet_indikator . '</li>';
                            $risiko++;
                        }
                    }
                    if ($risiko == 0) {
                        echo '<li> Data tidak ditemukan. </li>';
                    }
                    echo "</ul>";
                }
            } else {
                echo "<ul class='spasi1'>";
                echo '<li> Data tidak ditemukan. </li>';
                echo "</ul>";
            }

            echo "<br>";

            echo '<b>Kondisi Klinis Terkait</b>';
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
            echo "</div>";
        } else {
            echo CHtml::activeHiddenField($modDetail, '[0]isdiagnosa', array('value' => 1, 'onkeyup' => "return $(this).focusNextInputField(event);"));
            echo CHtml::activeTextField($modDetail, '[0]diagnosakep_nama', array('readonly' => true));
        }
        ?>
    </td>
    <td class="intervensi">
        <?php
        echo '<b>Luaran Utama</b>';
        if(!empty($modDetail->rencanaaskepdet_id)){
            $cekDet = RencanaaskepdetT::model()->findByPk($modDetail->rencanaaskepdet_id);
            if (!empty($cekDet->tautansdki_slki_det_id)) {
                $cekLuaran = TautansdkiSlkiDetM::model()->findByPk($cekDet->tautansdki_slki_det_id);
                echo "<br>";
                echo "<ul class='spasi1'>";
                if (!empty($cekLuaran)) {
                    $cekMaster = TautansdkiSlkiM::model()->findByPk($cekLuaran->tautansdki_slki_id);
                    if ($cekMaster->tingkatluarankeperawatan == 'Luaran Utama') {
                        echo '<li >' . $cekLuaran->luarankeperawatan_nama . '</li>';
                    } else {
                        echo '<li> Data tidak ditemukan. </li>';
                    }
                } else {
                    echo '<li> Data tidak ditemukan. </li>';
                }
                echo "</ul>";
            }
        }
        echo "<br>";
        echo '<b>Luaran Tambahan</b>';
        if(!empty($modDetail->rencanaaskepdet_id)){
            $cekDet = RencanaaskepdetT::model()->findByPk($modDetail->rencanaaskepdet_id);
            if (!empty($cekDet->tautansdki_slki_det_id)) {
                echo "<br>";
                echo "<ul class='spasi1'>";
                if (!empty($cekLuaran)) {
                    $cekMaster = TautansdkiSlkiM::model()->findByPk($cekLuaran->tautansdki_slki_id);
                    $ceksemua = TautansdkiSlkiM::model()->findAllByAttributes(array('diagnosakep_id' => $cekMaster->diagnosakep_id));
                    if (!empty($ceksemua)) {
                        $tambahan = 0;
                        foreach ($ceksemua as $val) {
                            if ($val->tingkatluarankeperawatan == 'Luaran Tambahan') {
                                $cekDet = TautansdkiSlkiDetM::model()->findAllByAttributes(array('tautansdki_slki_id' => $val->tautansdki_slki_id));
                                foreach ($cekDet as $value) {
                                    echo '<li >' . $value->luarankeperawatan_nama . '</li>';
                                    $tambahan++;
                                }
                            }
                        }
                        if ($tambahan == 0) {
                            echo '<li> Data tidak ditemukan. </li>';
                        }
                    } else {
                        echo '<li> Data tidak ditemukan. </li>';
                    }
                } else {
                    echo '<li> Data tidak ditemukan. </li>';
                }
                echo "</ul>";
            }
        }
        ?>
    </td>
    <td class="implementasi">
        <?php
        $cekData = PilihrencanaaskepT::model()->findAllByAttributes(array('rencanaaskepdet_id' => $modDetail->rencanaaskepdet_id));
        if (!empty($cekData)) {
            $cekintervensi = 0;
            foreach ($cekData as $hasil) {
                if (!empty($hasil->intervensidet_id)) {
                    $cekintervensi++;
                }
            }
            echo '<b>Intervensi Utama</b>';
            echo "<br>";
            echo "<ul class='spasi1'>";
            $utama = 0;
            if ($cekintervensi > 0) {
                foreach ($cekData as $value) {
                    if (!empty($value->intervensidet_id)) {
                        $cekLuaran = IntervensidetM::model()->findByPk($value->intervensidet_id);
                        if (!empty($cekLuaran)) {
                            $cekMaster = IntervensiM::model()->findByPk($cekLuaran->intervensi_id);
                            if ($cekMaster->intervensi_nama == 'Intervensi Utama') {
                                echo '<li >' . $cekLuaran->intervensidet_indikator . '</li>';
                                $utama++;
                            }
                        }
                    }
                }
            }
            if ($utama == 0) {
                echo '<li> Data tidak ditemukan. </li>';
            }
            echo "</ul>";
            echo "<br>";
            echo '<b>Intervensi Pendukung</b>';
            echo "<br>";
            echo "<ul class='spasi1'>";
            $pendukung = 0;
            if ($cekintervensi > 0) {
                foreach ($cekData as $value) {
                    if (!empty($value->intervensidet_id)) {
                        $cekLuaran = IntervensidetM::model()->findByPk($value->intervensidet_id);
                        if (!empty($cekLuaran)) {
                            $cekMaster = IntervensiM::model()->findByPk($cekLuaran->intervensi_id);
                            if ($cekMaster->intervensi_nama == 'Intervensi Pendukung') {
                                echo '<li >' . $cekLuaran->intervensidet_indikator . '</li>';
                                $pendukung++;
                            }
                        }
                    }
                }
            }
            if ($pendukung == 0) {
                echo '<li> Data tidak ditemukan. </li>';
            }
            echo "</ul>";
        }
        ?>
    </td>
    <td>
        <?php
        if (!empty($cekData)) {
            $cekintervensi = 0;
            foreach ($cekData as $hasil) {
                if (!empty($hasil->intervensidet_id)) {
                    $cekintervensi++;
                }
            }
            if ($cekintervensi > 0) {
                $a = 0;
                foreach ($cekData as $value) {
                    if (!empty($value->intervensidet_id)) {
                        $cekLuaran = IntervensidetM::model()->findByPk($value->intervensidet_id);
                        if (!empty($cekLuaran)) {
                            $cekMaster = IntervensiM::model()->findByPk($cekLuaran->intervensi_id);
                            $impl = ImplementasikepM::model()->findByAttributes(array('jenisintervensi_id' => $cekLuaran->jenisintervensi_id));
                            echo CHtml::textField('', $cekLuaran->intervensidet_indikator, array('class' => 'span3', 'readonly' => true));
                            echo '<br>';
                            echo '<table width="100%" style=" border: 2px solid #ededed !important;">
                                    <tr>
                                        <td width="25%" style="background-color:#fff; text-align: center; border: 2px solid #ededed !important;"><label>' . $impl->jenistindakan . '</label></td>
                                        <td style="background-color:#fff; text-align: left; border: 2px solid #ededed !important;">'; 
                            echo CHtml::activeHiddenField($modDetail, '[0]implementasikep_id['.$a.']', array('value' => $impl->implementasikep_id, 'class'=>'impls'));
                            echo CHtml::activeCheckBoxList($modDetail, '[0]detail['.$a.']indikatorimplkepdet_id[]', CHtml::listData(IndikatorimplkepdetM::model()->findAllByAttributes(array('indikatorimplkepdet_aktif' => true, 'implementasikep_id' => $impl->implementasikep_id)), 'indikatorimplkepdet_id', 'indikatorimplkepdet_indikator'), (array('onkeyup' => "return $(this).focusNextInputField(event);", 'class'=>'implsdet')));
                            echo       '</td>
                                    </tr>
                                  </table>';
                            echo '<br>';
                            $a++;
                        }
                    }
                }
            }
        }
        ?>
    </td>
</tr>
