<tr class="rencanaaskepdet">
    <td class="diagnosa">
        <?php echo CHtml::activeHiddenField($modDetail, '[0]rencanaaskepdet_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[0]diagnosakep_id', array('class' => 'inputFormTabel', 'value')) ?>
        <?php
        if (!empty($modDetail->diagnosakep_id)) {
            $cekDiagnosa = DiagnosakepM::model()->findByPk($modDetail->diagnosakep_id);
            if (!empty($cekDiagnosa)) {
                $modDetail->diagnosakep_nama = $cekDiagnosa->diagnosakep_nama;
            }

            echo CHtml::activeTextField($modDetail, '[0]diagnosakep_nama', array('disabled' => true));
            echo "<div class='diagdetail'>";
            echo "<br>";
            echo '<b>Penyebab</b>';
            echo "<br>";
            $bk_head = BataskarakteristikM::model()->findAllByAttributes(array('diagnosakep_id' => $modDetail->diagnosakep_id));
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
            echo "<table style='width:100%'>";

            if (!empty($modDetail->diagnosisaskepdet_id)) {
                $cekPilih = PilihdiagnosisaskepT::model()->findAllByAttributes(array('diagnosisaskepdet_id' => $modDetail->diagnosisaskepdet_id));
            } else {
                $cekrencanadet = RencanaaskepdetT::model()->findByPk($modDetail->rencanaaskepdet_id);
                if (!empty($cekrencanadet)) {
                    $cekPilih = PilihdiagnosisaskepT::model()->findAllByAttributes(array('diagnosisaskepdet_id' => $cekrencanadet->diagnosisaskepdet_id));
                }
            }
            $tandagejala_id = array();
            foreach ($cekPilih as $value) {
                if (!empty($value->tandagejala_id)) {
                    $tandagejala_id[] = $value->tandagejala_id;
                }
            }

            if (!empty($tandagejala_id)) {
                $criteria = new CDbCriteria;
                $criteria->select = 'tandagejala.tandagejala_id, t.tandagejala_daftar_nama, det.kelompoktandagejaladaftar_id, jenistandagejala.jenistandagejala_nama, jenistandagejala.subjenistandagejala_nama';
                $criteria->join = 'JOIN kelompoktandagejaladaftar_m det ON det.tandagejala_daftar_id = t.tandagejala_daftar_id '
                    . 'JOIN jenistandagejala_m jenistandagejala ON jenistandagejala.jenistandagejala_id = det.jenistandagejala_id '
                    . 'JOIN tandagejala_m tandagejala ON tandagejala.kelompoktandagejaladaftar_id = det.kelompoktandagejaladaftar_id';
                if (is_array($tandagejala_id)) {
                    $criteria->addInCondition("tandagejala.tandagejala_id", $tandagejala_id);
                } else {
                    $criteria->addCondition("tandagejala.tandagejala_id = " . $tandagejala_id);
                }
                $criteria->addCondition('t.tandagejala_daftar_aktif is true');
                $criteria->order = 't.tandagejala_daftar_nama';

                $modTandaGejala = ASTandagejalaDaftarM::model()->findAll($criteria);

                $kanUtam = array();

                foreach ($modTandaGejala as $d) {
                    $kanUtam[$d->tandagejala_id]['tandagejala_id'] = $d->tandagejala_id;
                    $kanUtam[$d->tandagejala_id]['jenistandagejala_nama'] = $d->jenistandagejala_nama;
                    $kanUtam[$d->tandagejala_id]['subjenistandagejala_nama'] = $d->subjenistandagejala_nama;
                    $kanUtam[$d->tandagejala_id]['tandagejala_daftar_nama'] = $d->tandagejala_daftar_nama;
                }

                $no = 0;
                echo '<tr> 
                            <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;"><b>Diagnosa Keperawatan Aktual</b><br></td>
                        </tr>
                        <tr> 
                            <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;"><b>Tanda dan Gejala Mayor</b></td>
                        </tr>
                        <tr> 
                            <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;"><b>Objektif</b></td>
                        </tr> ';
                $no1 = 0;
                $tandagejala1 = array();
                foreach ($kanUtam as $det) {
                    $modPilihDiagnosa = new ASPilihdiagnosisaskepT();
                    $modPilihDiagnosa->tandagejala_id = !empty($det['tandagejala_id']) ? $det['tandagejala_id'] : null;
                    if (!empty($modPilihDiagnosa->tandagejala_id)) {
                        if ($det['jenistandagejala_nama'] == 'Mayor') {
                            if ($det['subjenistandagejala_nama'] == 'Objektif') {
                                $tandagejala1[] = $det['tandagejala_id'];
                                echo $this->renderPartial($this->path_view . '_detailTandagejala', array('no' => $no + 1, 'modTandaGejala' => $det, 'modDetail' => $modPilihDiagnosa, 'warna' => '#f8f8f8'), true);
                                $no1++;
                            }
                        }
                        $no++;
                    }
                }
                if ($no1 == 0) {
                    echo '<tr><td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;">- &nbsp;(Tidak Tersedia)</td></tr>';
                }
                echo '<tr> 
                            <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;"><br><b>Subjektif</b></td>
                        </tr>';
                $no2 = 0;
                $tandagejala2 = array();
                foreach ($kanUtam as $det) {
                    $modPilihDiagnosa = new ASPilihdiagnosisaskepT();
                    $modPilihDiagnosa->tandagejala_id = !empty($det['tandagejala_id']) ? $det['tandagejala_id'] : null;
                    if (!empty($modPilihDiagnosa->tandagejala_id)) {
                        if ($det['jenistandagejala_nama'] == 'Mayor') {
                            if ($det['subjenistandagejala_nama'] == 'Subjektif') {
                                $tandagejala2[] = $det['tandagejala_id'];
                                echo $this->renderPartial($this->path_view . '_detailTandagejala', array('no' => $no + 1, 'modTandaGejala' => $det, 'modDetail' => $modPilihDiagnosa, 'warna' => '#f8f8f8'), true);
                                $no2++;
                            }
                        }
                        $no++;
                    }
                }
                if ($no2 == 0) {
                    echo '<tr><td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;">- &nbsp;(Tidak Tersedia)</td></tr>';
                }
                echo '<tr> 
                            <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;"><br><b>Tanda dan Gejala Minor</b></td>
                        </tr>
                        <tr> 
                            <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;"><b>Objektif</b></td>
                        </tr> ';
                $no3 = 0;
                $tandagejala3 = array();
                foreach ($kanUtam as $det) {
                    $modPilihDiagnosa = new ASPilihdiagnosisaskepT();
                    $modPilihDiagnosa->tandagejala_id = !empty($det['tandagejala_id']) ? $det['tandagejala_id'] : null;
                    if (!empty($modPilihDiagnosa->tandagejala_id)) {
                        if ($det['jenistandagejala_nama'] == 'Minor') {
                            if ($det['subjenistandagejala_nama'] == 'Objektif') {
                                $tandagejala3[] = $det['tandagejala_id'];
                                echo $this->renderPartial($this->path_view . '_detailTandagejala', array('no' => $no + 1, 'modTandaGejala' => $det, 'modDetail' => $modPilihDiagnosa, 'warna' => '#f8f8f8'), true);
                                $no3++;
                            }
                        }
                        $no++;
                    }
                }
                if ($no3 == 0) {
                    echo '<tr><td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;">- &nbsp;(Tidak Tersedia)</td></tr>';
                }
                echo '<tr> 
                            <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;"><br><b>Subjektif</b></td>
                        </tr>';
                $no4 = 0;
                $tandagejala4 = array();
                foreach ($kanUtam as $det) {
                    $modPilihDiagnosa = new ASPilihdiagnosisaskepT();
                    $modPilihDiagnosa->tandagejala_id = !empty($det['tandagejala_id']) ? $det['tandagejala_id'] : null;
                    if (!empty($modPilihDiagnosa->tandagejala_id)) {
                        if ($det['jenistandagejala_nama'] == 'Minor') {
                            if ($det['subjenistandagejala_nama'] == 'Subjektif') {
                                $tandagejala4[] = $det['tandagejala_id'];
                                echo $this->renderPartial($this->path_view . '_detailTandagejala', array('no' => $no + 1, 'modTandaGejala' => $det, 'modDetail' => $modPilihDiagnosa, 'warna' => '#f8f8f8'), true);
                                $no4++;
                            }
                        }
                        $no++;
                    }
                }
                if ($no4 == 0) {
                    echo '<tr><td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;">- &nbsp;(Tidak Tersedia)</td></tr>';
                }
            }

            $faktorrisiko_id = array();
            foreach ($cekPilih as $value) {
                if (!empty($value->faktorrisiko_id)) {
                    $faktorrisiko_id[] = $value->faktorrisiko_id;
                }
            }

            if (!empty($faktorrisiko_id)) {
                $criteria = new CDbCriteria;
                $criteria->select = 'jenisfaktorrisiko.jenisfaktorrisiko_nama, det.faktorrisiko_daftar_id, t.faktorrisiko_daftar_nama, det.kelompokfaktorrisikodaftar_id, det.jenisfaktorrisiko_id, row_number() OVER (PARTITION BY jenisfaktorrisiko.jenisfaktorrisiko_urutan ORDER BY jenisfaktorrisiko.jenisfaktorrisiko_urutan) AS no';
                $criteria->join = 'JOIN kelompokfaktorrisikodaftar_m det ON det.faktorrisiko_daftar_id = t.faktorrisiko_daftar_id '
                    . 'JOIN jenisfaktorrisiko_m jenisfaktorrisiko ON jenisfaktorrisiko.jenisfaktorrisiko_id = det.jenisfaktorrisiko_id '
                    . 'JOIN faktorrisiko_m faktorrisiko ON faktorrisiko.kelompokfaktorrisikodaftar_id = det.kelompokfaktorrisikodaftar_id';
                $criteria->addCondition('t.faktorrisiko_daftar_aktif is true');
                $criteria->order = 'jenisfaktorrisiko.jenisfaktorrisiko_urutan';
                if (is_array($faktorrisiko_id)) {
                    $criteria->addInCondition("faktorrisiko.faktorrisiko_id", $faktorrisiko_id);
                } else {
                    $criteria->addCondition("faktorrisiko.faktorrisiko_id = " . $faktorrisiko_id);
                }
                $modFaktorRisiko = ASFaktorrisikoDaftarM::model()->findAll($criteria);

                $jenisResiko = JenisfaktorrisikoM::model()->findAllByAttributes(array('jenisfaktorrisiko_aktif' => true), array('order' => 'jenisfaktorrisiko_urutan ASC'));

                $kanUtam = array();

                foreach ($modFaktorRisiko as $d) {
                    $kanUtam[$d->kelompokfaktorrisikodaftar_id]['kelompokfaktorrisikodaftar_id'] = $d->kelompokfaktorrisikodaftar_id;
                    $kanUtam[$d->kelompokfaktorrisikodaftar_id]['faktorrisiko_daftar_nama'] = $d->faktorrisiko_daftar_nama;
                    $kanUtam[$d->kelompokfaktorrisikodaftar_id]['jenisfaktorrisiko_nama'] = $d->jenisfaktorrisiko_nama;
                    $kanUtam[$d->kelompokfaktorrisikodaftar_id]['jenisfaktorrisiko_id'] = $d->jenisfaktorrisiko_id;
                    $kanUtam[$d->kelompokfaktorrisikodaftar_id]['no'] = $d->no;
                }

                $no = 0;
                echo '<tr> 
                        <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;"><b>Diagnosa Keperawatan Risiko</b><br></td>
                      </tr>';

                foreach ($kanUtam as $det) {
                    foreach ($jenisResiko as $key => $value) {
                        if (!empty($det['jenisfaktorrisiko_id'])) {
                            if ($value->jenisfaktorrisiko_id == $det['jenisfaktorrisiko_id']) {
                                $no = !empty($det['no']) ? $det['no'] : 0;
                                if ($det['no'] == 1) {
                                    echo '<tr> 
                                            <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;"><b>' . $det['jenisfaktorrisiko_nama'] . '</b></td>
                                          </tr>';
                                }
                                $modPilihDiagnosa = new ASPilihdiagnosisaskepT();
                                $modPilihDiagnosa->kelompokfaktorrisikodaftar_id = $det['kelompokfaktorrisikodaftar_id'];
                                $kelompokfaktorrisikodaftar[] = $det['kelompokfaktorrisikodaftar_id'];
                                echo $this->renderPartial($this->path_view . '_detailFaktorRisiko', array('no' => $no + 1, 'modFaktorRisiko' => $det, 'modDetail' => $modPilihDiagnosa, 'warna' => '#f8f8f8'), true);

                                $no++;
                            }
                        }
                    }
                }
            }

            echo "</table>";
            echo "<br>";

            echo '<b>Kondisi Klinis Terkait</b>';
            echo "<br>";
            $diagnosakep = !empty($modDetail->diagnosakep_id) ? $modDetail->diagnosakep_id : null;
            if (!empty($diagnosakep)) {
                $diagnosa = ASDiagnosakepM::model()->findByPk($diagnosakep);
                echo "<div class='diagdetail'>";
                $bk_head = FaktorhubM::model()->findAllByAttributes(array('diagnosakep_id' => $diagnosakep));
                if (count($bk_head)) {
                    foreach ($bk_head as $i => $bk) {
                        echo "<ul class='spasi1'>";
                        echo '<li >' . $bk->faktorhub_nama . '</li>';
                        echo "<ul class='spasi1'>";
                        $bk_tail = FaktorhubdetM::model()->findAllByAttributes(array('faktorhubdet_aktif' => true, 'faktorhub_id' => $bk->faktorhub_id));
                        if (count($bk_tail)) {
                            foreach ($bk_tail as $i => $bkd) {
                                echo '<li >' . $bkd->faktorhubdet_indikator . '</li>';
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
            } else {
                echo "<ul class='spasi1'>";
                echo '<li> Data tidak ditemukan. </li>';
                echo "</ul>";
            }
            echo '</div>';
        } else {
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modDetail,
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
        if (!empty($modDetail->diagnosakep_id)) {
            $cekDet = TautansdkiSlkiM::model()->findAllByAttributes(array('diagnosakep_id' => $modDetail->diagnosakep_id));
            foreach ($cekDet as $value) {
                if (!empty($value->tautansdki_slki_id)) {
                    $cekLuaran = TautansdkiSlkiDetM::model()->findAllByAttributes(array('tautansdki_slki_id' => $value->tautansdki_slki_id, 'tautansdki_slki_aktif' => true));
                    if (!empty($cekLuaran)) {
                        foreach ($cekLuaran as $val) {
                            if ($value->tingkatluarankeperawatan == 'Luaran Utama') {
                                echo '<li >' . $val->luarankeperawatan_nama . '</li>';
                                $luaranutama = $val->luarankeperawatan_nama;
                                $luaranutama_id = $val->luarankeperawatan_id;
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
        if (!empty($modDetail->diagnosakep_id)) {
            $cekDet = TautansdkiSlkiM::model()->findAllByAttributes(array('diagnosakep_id' => $modDetail->diagnosakep_id));
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
    <td class="intervensi">
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
    <td class="tindakannya">
        <div id="table-tindakannya">
            <?php
            $pilihrencana = PilihrencanaaskepT::model()->findAllByAttributes(array('rencanaaskepdet_id' => $modDetail->rencanaaskepdet_id));
            if (count($pilihrencana) > 0) {
                foreach ($pilihrencana as $value) {
                    if (!empty($value->intervensidet_id)) {
                        $cekLuaran = IntervensidetM::model()->findByPk($value->intervensidet_id);
                        if (!empty($cekLuaran)) {
                            $cekMaster = IntervensiM::model()->findByPk($cekLuaran->intervensi_id);
                            $all = ImplementasikepM::model()->findAllByAttributes(array('jenisintervensi_id' => $cekLuaran->jenisintervensi_id));
                            if (!empty($all)) {
                                echo CHtml::textField('', $cekLuaran->intervensidet_indikator, array('class' => 'span3', 'disabled' => true));
                                echo '<br>';

                                $no = 0;
                                echo '<table width="100%" style=" border: 2px solid #ededed !important;">';
                                foreach ($all as $impl) {
                                    echo '<tr>
                                                <td width="25%" style="background-color:#fff; text-align: center; border: 2px solid #ededed !important;"><label>' . $impl->jenistindakan . '</label></td>
                                                <td style="background-color:#fff; text-align: left; border: 2px solid #ededed !important;">';
                                    echo CHtml::activeHiddenField($modDetail, '[0]diagnosa[' . $value->intervensidet_id . ']intervensidet_id[]', array('value' => $value->intervensidet_id, 'class' => 'impls'));
                                    echo CHtml::activeHiddenField($modDetail, '[0]diagnosa[' . $value->intervensidet_id . ']rencanaaskepdet_id[]', array('value' => $modDetail->rencanaaskepdet_id, 'class' => 'impls_id'));
                                    //                                    echo CHtml::activeCheckBoxList($modDetail, '[0]detail[' . $value->intervensidet_id . ']indikatorimplkepdet_id[]', CHtml::listData(IndikatorimplkepdetM::model()->findAllByAttributes(array('indikatorimplkepdet_aktif' => true, 'implementasikep_id' => $impl->implementasikep_id)), 'indikatorimplkepdet_id', 'indikatorimplkepdet_indikator'), (array('onkeyup' => "return $(this).focusNextInputField(event);", 'class' => 'implsdet')));
                                    $semua = IndikatorimplkepdetM::model()->findAllByAttributes(array('indikatorimplkepdet_aktif' => true, 'implementasikep_id' => $impl->implementasikep_id));
                                    foreach ($semua as $val2) {
                                        echo CHtml::activeCheckBox($modDetail, '[0][detail][' . $value->intervensidet_id . '][]indikatorimplkepdet_id', array('label' => $val2->indikatorimplkepdet_indikator, 'value' => $val2->indikatorimplkepdet_id, 'onkeyup' => "return $(this).focusNextInputField(event);", 'class' => 'implsdet')) . ' <label>' . $val2->indikatorimplkepdet_indikator . '</label><br>';
                                        $no++;
                                    }
                                    echo '</td>
                                            </tr>';
                                }
                                echo '</table>';
                                echo '<br>';
                            }
                        }
                    }
                }
            }
            ?>
        </div>
    </td>
</tr>