<?php ?>
<tr class="rencanaaskepdet">
    <td class="diagnosa">
        <?php echo CHtml::activeHiddenField($modRencanaDet, '[0]diagnosakep_id', array('class' => 'inputFormTabel')) ?>
        <?php echo CHtml::activeHiddenField($modRencanaDet, '[0]rencanaaskepdet_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
        <?php echo CHtml::activeHiddenField($modRencanaDet, '[0]diagnosisaskepdet_id', array()); ?>
        <?php
        if (!empty($modRencanaDet->diagnosakep_id)) {
            $cekDiagnosa = DiagnosakepM::model()->findByPk($modRencanaDet->diagnosakep_id);
            if (!empty($cekDiagnosa)) {
                $modRencanaDet->diagnosakep_nama = $cekDiagnosa->diagnosakep_nama;
            }

            echo CHtml::activeTextField($modRencanaDet, '[0]diagnosakep_nama', array('disabled' => true));
            echo "<div class='diagdetail'>";
            echo "<br>";
            echo '<b>Penyebab</b>';
            echo "<br>";
            $bk_head = BataskarakteristikM::model()->findAllByAttributes(array('diagnosakep_id' => $modRencanaDet->diagnosakep_id));
            if (count($bk_head)) {
                foreach ($bk_head as $i => $bk) {
                    echo "<ul class='spasi1'>";
                    echo '<li ><b>' . $bk->bataskarakteristik_nama . '</b></li>';
                    echo "<ul class='spasi1'>";
                    $bk_tail = BataskarakteristikdetM::model()->findAllByAttributes(array('bataskarakteristikdet_aktif' => true, 'bataskarakteristik_id' => $bk->bataskarakteristik_id));
                    if (count($bk_tail)) {
                        foreach ($bk_tail as $i => $bkd) {
                            echo '<li >' . $bkd->bataskarakteristikdet_indikator . '</li>';
                        }
                    } else {
                        echo '<li> Data tidak ditemukan. </li>';
                    }
                    echo "</ul>";
                    echo "</ul>";
                }
            } else {
                echo "<ul class='spasi1'>";
                echo '<li> Data tidak ditemukan. </li>';
                echo "</ul>";
            }

            echo "<br>";
            echo '<b>Tanda dan Gejala</b>';
            $cekData = PilihdiagnosisaskepT::model()->findAllByAttributes(array('diagnosisaskepdet_id' => $modRencanaDet->diagnosisaskepdet_id));
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
                } else {
                    echo "<ul class='spasi1'>";
                    echo '<li> Data tidak ditemukan. </li>';
                    echo "</ul>";
                }
            } else {
                echo "<ul class='spasi1'>";
                echo '<li> Data tidak ditemukan. </li>';
                echo "</ul>";
            }
            echo '<br>';
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
                        $bk_head = FaktorrisikodetM::model()->findByAttributes(array('faktorrisikodet_id' => $value->faktorrisikodet_id, 'faktorrisikodet_aktif' => true));
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
                } else {
                    echo "<ul class='spasi1'>";
                    echo '<li> Data tidak ditemukan. </li>';
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
            $bk_head = FaktorhubM::model()->findAllByAttributes(array('diagnosakep_id' => $modRencanaDet->diagnosakep_id));
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
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modRencanaDet,
                'attribute' => '[0]diagnosakep_nama',
                //'name'=>'daftartindakan_nama',
                'source' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "' . $this->createUrl('AutocompleteDiagnosa') . '",
                                       dataType: "json",
                                       data: {
                                           term: request.term
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            return false;
                        }',
                    'select' => 'js:function( event, ui ) {
						setDiagnosaAuto(ui.item.diagnosakep_id);
                            return false;
                        }',
                ),
                'tombolDialog' => array("idDialog" => 'dialogDiagnosa', 'jsFunction' => "setDialog(this);"),
                'htmlOptions' => array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
            ));
        }
        ?>
    </td>
    <td class="tandagejala">
        <?php
        echo '<b>Luaran Utama</b>';
        echo "<ul class='spasi1'>";
        $luaranutama = '';
        $luaranutama_id = '';
        $utama_ada = 0;
        if (!empty($modRencanaDet->diagnosakep_id)) {
            $cekDet = TautansdkiSlkiM::model()->findAllByAttributes(array('diagnosakep_id' => $modRencanaDet->diagnosakep_id));
            foreach ($cekDet as $value) {
                if (!empty($value->tautansdki_slki_id)) {
                    $cekLuaran = TautansdkiSlkiDetM::model()->findAllByAttributes(array('tautansdki_slki_id' => $value->tautansdki_slki_id, 'tautansdki_slki_aktif' => true));
                    if (!empty($cekLuaran)) {
                        foreach ($cekLuaran as $val) {
                            if ($value->tingkatluarankeperawatan == 'Luaran Utama') {
                                echo '<li >' . $val->luarankeperawatan_nama . '</li>';
                                $luaranutama = $val->luarankeperawatan_nama;
                                $luaranutama_id = $val->luarankeperawatan_id;
                                $tautandet_id = $val->tautansdki_slki_det_id;
                                $utama_ada++;
                            }
                        }
                    }
                }
            }
            if ($utama_ada == 0) {
                echo '<li >Data tidak ditemukan</li>';
            }
            echo "</ul>";
        }
        echo "<br>";
        echo '<b>Luaran Tambahan</b>';
        echo "<ul class='spasi1'>";
        $tambahan_ada = 0;
        if (!empty($modRencanaDet->diagnosakep_id)) {
            $cekDet = TautansdkiSlkiM::model()->findAllByAttributes(array('diagnosakep_id' => $modRencanaDet->diagnosakep_id));
            foreach ($cekDet as $value) {
                if (!empty($value->tautansdki_slki_id)) {
                    $cekLuaran = TautansdkiSlkiDetM::model()->findAllByAttributes(array('tautansdki_slki_id' => $value->tautansdki_slki_id, 'tautansdki_slki_aktif' => true));
                    if (!empty($cekLuaran)) {
                        foreach ($cekLuaran as $val) {
                            if ($value->tingkatluarankeperawatan == 'Luaran Tambahan') {
                                echo '<li >' . $val->luarankeperawatan_nama . '</li>';
                                $tambahan_ada++;
                            }
                        }
                    }
                }
            }
            if ($tambahan_ada == 0) {
                echo '<li >Data tidak ditemukan</li>';
            }
            echo "</ul>";
        }
        ?>
    </td>
    <td class="tujuan" width="100px">
        <?php
        echo '<label>per</label> ' . CHtml::activeTextField($modRencanaDet, '[0]rencanaaskepdet_hari', array('class' => 'span1', 'readonly' => false)) . CHtml::activeDropDownList($modRencanaDet, '[0]rencanaaskepdet_estimasiwaktu', LookupM::getItemsUrutan('estimasiwaktu'), array('class' => 'span2', 'style' => 'width:100px', 'readonly' => false));
        echo CHtml::activeHiddenField($modRencanaDet, '[0]tujuan_id', array('value' => $modRencanaDet->tujuan_id, 'readonly' => false));
        ?>
    </td>
    <td class="kriteriahasil">
        <?php
        if (!empty($modRencanaDet->diagnosakep_id)) {
            $cektujuan = TujuanM::model()->findByAttributes(array('luarankeperawatan_id' => $luaranutama_id));
            $tujuan_id = !empty($cektujuan->tujuan_id) ? $cektujuan->tujuan_id : '';
            $tujuan_nama = !empty($cektujuan->tujuan_nama) ? $cektujuan->tujuan_nama : '';
            echo '<div class="control-group keperawatan">
                    <div class="controls">
                    <label>Luaran Utama &nbsp;</label>';
            echo CHtml::activeHiddenField($modRencanaDet, '[0]tautansdki_slki_det_id', array('value' => $tautandet_id));
            echo CHtml::activeTextField($modRencanaDet, '[0]tautansdki_slki_det_nama', array('value' => $luaranutama, 'class' => 'span3', 'readonly' => true));
            echo '</div></div>';
            echo '<div class="control-group keperawatan">
                    <div class="controls">
                    <label>Ekspektasi &nbsp;</label>';
            echo CHtml::activeHiddenField($modRencanaDet, '[0]tujuan_id', array('value' => $tujuan_id));
            echo CHtml::activeTextField($modRencanaDet, '[0]tujuan_nama', array('value' => $tujuan_nama, 'class' => 'span3', 'disabled' => true));
            echo '</div></div>';
            if ($luaranutama_id != '') {
                $head = KriteriahasilM::model()->findByAttributes(array('luarankeperawatan_id' => $luaranutama_id));
                if (!empty($head)) {
                    $tail = ASKriteriahasildetM::model()->findAllByAttributes(array('kriteriahasil_id' => $head->kriteriahasil_id));
                    $data['table_id'] = 'table-kriteria-' . $head->kriteriahasil_id;
                    echo '<table class="items table table-striped table-bordered table-condensed kriteria" id="' . $data['table_id'] . '">
                            <thead>
                                <tr>
                                    <th style="background-color:#f8f8f8; border: 1px solid #ededed !important;"></th>
                                    <th style="background-color:#f8f8f8; border: 1px solid #ededed !important;text-align: center">Kriteria Hasil</th>
                                    <th style="background-color:#f8f8f8; border: 1px solid #ededed !important;text-align: center">IR</th>
                                </tr>
                            </thead>
                            <tbody>';
                    sort($tail);
                    foreach ($tail as $i => $row) {
                        echo '<tr class="criteria">
                                <td style="background-color:#f8f8f8; border: 1px solid #ededed !important;">
                                    <span name="ASRencanaaskepdetT[0][kriteriahasildet_id]">
                                    ' . CHtml::activeCheckBox($modRencanaDet, '[0]kriteriahasildet_id', array('onkeyup' => "return $(this).focusNextInputField(event);", 'value' => $row['kriteriahasildet_id'], 'readonly' => false))
                        . '</span>
                                </td>
                                <td style="background-color:#f8f8f8; border: 1px solid #ededed !important;">
                                ' . $row['kriteriahasildet_indikator'] . '
                                </td>
                                <td style="background-color:#f8f8f8; border: 1px solid #ededed !important;">
                                ' . CHtml::activeDropDownList($modRencanaDet, '[0]rencanaaskep_ir', LookupM::getItemsUrutan('tingkatkriteriahasil'), array('class' => 'span2', 'empty'=>'-- Pilih --')) . '
                                </td>
                                </tr>';
                    }
                    echo '</tbody></table>';
                }
            }
        }
        ?>
    </td>
    <td class="intervensi">
        <?php
        if (!empty($modRencanaDet->diagnosakep_id)) {
            echo CHtml::activeHiddenField($modRencanaDet, '[0]intervensi_id', array('value' => $modRencanaDet->intervensi_id));
            echo CHtml::activeHiddenField($modRencanaDet, '[0]intervensi_nama', array('value' => $modRencanaDet->intervensi_nama, 'class' => 'span2', 'readonly' => false));

            $cekIntervensiUtama = IntervensiM::model()->findByAttributes(array('diagnosakep_id' => $modRencanaDet->diagnosakep_id, 'intervensi_nama' => 'Intervensi Utama'));
            if (!empty($cekIntervensiUtama)) {
                echo '<br><b>Intervensi Utama</b><br>';
                echo CHtml::activeCheckBoxList($modRencanaDet, '[0]intervensidet_id', CHtml::listData(IntervensidetM::model()->findAllByAttributes(
                                        array('intervensidet_aktif' => true, 'intervensi_id' => $cekIntervensiUtama->intervensi_id)), 'intervensidet_id', 'intervensidet_indikator'), (array('style' => 'float: left', 'readonly' => false, 'onkeyup' => "return $(this).focusNextInputField(event);", 'class' => 'intervensinya', 'onclick' => 'setTindakan(this)')));
            }
            $cekIntervensiPendukung = IntervensiM::model()->findByAttributes(array('diagnosakep_id' => $modRencanaDet->diagnosakep_id, 'intervensi_nama' => 'Intervensi Pendukung'));
            if (!empty($cekIntervensiPendukung)) {
                echo '<br><b>Intervensi Pendukung</b><br>';
                echo CHtml::activeCheckBoxList($modRencanaDet, '[0]intervensidet_id', CHtml::listData(IntervensidetM::model()->findAllByAttributes(
                                        array('intervensidet_aktif' => true, 'intervensi_id' => $cekIntervensiPendukung->intervensi_id)), 'intervensidet_id', 'intervensidet_indikator'), (array('style' => 'float: left', 'readonly' => false, 'onkeyup' => "return $(this).focusNextInputField(event);", 'class' => 'intervensinya', 'onclick' => 'setTindakan(this)')));
            }
        }
        ?>
    </td>
    <td class="tindakannya">
        <div id="table-tindakannya">
            <?php
            $pilihrencana = PilihrencanaaskepT::model()->findAllByAttributes(array('rencanaaskepdet_id' => $modRencanaDet->rencanaaskepdet_id));
            if (count($pilihrencana) > 0) {
                foreach ($pilihrencana as $value) {
                    if (!empty($value->intervensidet_id)) {
                        $cekLuaran = IntervensidetM::model()->findByPk($value->intervensidet_id);
                        if (!empty($cekLuaran)) {
                            $cekMaster = IntervensiM::model()->findByPk($cekLuaran->intervensi_id);
                            $impl = ImplementasikepM::model()->findByAttributes(array('jenisintervensi_id' => $cekLuaran->jenisintervensi_id));
                            if (!empty($impl)) {
                                echo CHtml::textField('', $cekLuaran->intervensidet_indikator, array('class' => 'span3', 'disabled' => true));
                                echo '<br>';

                                $no = 0;
                                echo '<table width="100%" style=" border: 2px solid #ededed !important;">
                                        <tr>
                                            <td width="25%" style="background-color:#fff; text-align: center; border: 2px solid #ededed !important;"><label>' . $impl->jenistindakan . '</label></td>
                                            <td style="background-color:#fff; text-align: left; border: 2px solid #ededed !important;">';
                                echo CHtml::activeHiddenField($modRencanaDet, '[0]intervensidet_id[' . $value->intervensidet_id . ']', array('value' => $value->intervensidet_id, 'class' => 'impls'));
                                echo CHtml::activeCheckBoxList($modRencanaDet, '[0]detail[' . $value->intervensidet_id . ']indikatorimplkepdet_id[]', CHtml::listData(IndikatorimplkepdetM::model()->findAllByAttributes(array('indikatorimplkepdet_aktif' => true, 'implementasikep_id' => $impl->implementasikep_id)), 'indikatorimplkepdet_id', 'indikatorimplkepdet_indikator'), (array('onkeyup' => "return $(this).focusNextInputField(event);", 'class' => 'implsdet', 'readonly' => false)));
                                echo '</td>
                                        </tr>
                                      </table>';
                                echo '<br>';
                                $no++;
                            }
                        }
                    }
                }
            }
            ?>
        </div>
    </td>
</tr>
