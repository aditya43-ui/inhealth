<?php
/**
 * issue RSST-2549
 * mengenerate data detail rencana askep
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 * 
 */
?>
<tr class="rencanaaskepdet">
    <td class="diagnosa">
        <?php echo CHtml::activeHiddenField($modDet, '[0]diagnosakep_id', array('class' => 'inputFormTabel', 'value'=>$modDetail->hasildiagnosa_id)) ?>
        <?php echo CHtml::activeHiddenField($modDet, '[0]diagnosisaskepdet_id', array('value' => $modDetail->diagnosisaskepdet_id, 'class'=>'diagnosisaskepdet_id')); ?>
        <?php
        if (!empty($modDetail->hasildiagnosa_id)) {
            $cekDiagnosa = DiagnosakepM::model()->findByPk($modDetail->hasildiagnosa_id);
            if (!empty($cekDiagnosa)) {
                $modDetail->diagnosakep_nama = $cekDiagnosa->diagnosakep_nama;
            }

            echo CHtml::activeTextField($modDet, '[0]diagnosakep_nama', array('readonly' => true, 'value'=>$cekDiagnosa->diagnosakep_nama));
            echo "<div class='diagdetail'>";
            echo "<br>";
            echo '<b>Penyebab</b>';
            echo "<br>";
            $bk_head = BataskarakteristikM::model()->findAllByAttributes(array('diagnosakep_id' => $modDetail->hasildiagnosa_id));
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
            
            $cekPilih = PilihdiagnosisaskepT::model()->findAllByAttributes(array('diagnosisaskepdet_id' => $modDetail->diagnosisaskepdet_id));
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
                                if($det['no'] == 1){
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
            $diagnosakep = !empty($modDetail->hasildiagnosa_id) ? $modDetail->hasildiagnosa_id : null;
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
                'model' => $modDet,
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
        $tautandet_id = '';
        $utama_ada = 0;
        if (!empty($modDetail->hasildiagnosa_id)) {
            $cekDet = TautansdkiSlkiM::model()->findAllByAttributes(array('diagnosakep_id' => $modDetail->hasildiagnosa_id));
            foreach ($cekDet as $value) {
                if (!empty($value->tautansdki_slki_id)) {
                    $cekLuaran = TautansdkiSlkiDetM::model()->findAllByAttributes(array('tautansdki_slki_id' => $value->tautansdki_slki_id, 'tautansdki_slki_aktif' => true));
                    if (!empty($cekLuaran)) {
                        foreach ($cekLuaran as $val) {
                            if ($value->tingkatluarankeperawatan == 'Luaran Utama') {
                                echo '<li >' . $val->luarankeperawatan_nama . '</li>';
                                $luaranutama = !empty($val->luarankeperawatan_nama) ? $val->luarankeperawatan_nama : '';
                                $luaranutama_id = !empty($val->luarankeperawatan_id) ? $val->luarankeperawatan_id : '';
                                $tautandet_id = !empty($val->tautansdki_slki_det_id) ? $val->tautansdki_slki_det_id : '';
                                $utama_ada++;
                            }
                        }
                    }
                }
            }
            if($utama_ada == 0){
                echo '<li >Data tidak ditemukan</li>';
            }
            echo "</ul>";
        }
        echo "<br>";
        echo '<b>Luaran Tambahan</b>';
        echo "<ul class='spasi1'>";
        $tambahan_ada = 0;
        if (!empty($modDetail->hasildiagnosa_id)) {
            $cekDet = TautansdkiSlkiM::model()->findAllByAttributes(array('diagnosakep_id' => $modDetail->hasildiagnosa_id));
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
            if($tambahan_ada == 0){
                echo '<li >Data tidak ditemukan</li>';
            }
            echo "</ul>";
        }
        ?>
    </td>
    <td class="tujuan" width="100px">
        <?php
        echo '<label>per</label> ' . CHtml::activeTextField($modDet, '[0]rencanaaskepdet_hari', array('class' => 'span1','value'=>0)) . CHtml::activeDropDownList($modDet, '[0]rencanaaskepdet_estimasiwaktu', LookupM::getItemsUrutan('estimasiwaktu'), array('class' => 'span2', 'style' => 'width:100px','value'=>"Menit")) . $modDetail->tujuan_nama;
        ?>
    </td>
    <td class="kriteriahasil">
        <?php
        if (!empty($modDetail->hasildiagnosa_id)) {
            if($luaranutama_id != ''){
                $cektujuan = TujuanM::model()->findByAttributes(array('luarankeperawatan_id'=>$luaranutama_id));
                $tujuan_id = !empty($cektujuan->tujuan_id) ? $cektujuan->tujuan_id : '';
                $tujuan_nama = !empty($cektujuan->tujuan_nama) ? $cektujuan->tujuan_nama : '';
            }else{
                $tujuan_id = '';
                $tujuan_nama = '';
            }
            echo '<div class="control-group keperawatan">
                    <div class="controls">
                    <label>Luaran Utama &nbsp;</label>';
            echo CHtml::activeHiddenField($modDet, '[0]tautansdki_slki_det_id', array('value' => $tautandet_id));
            echo CHtml::activeTextField($modDet, '[0]tautansdki_slki_det_nama', array('value' => $luaranutama, 'class' => 'span3', 'readonly' => true));
            echo '</div></div>';
            echo '<div class="control-group keperawatan">
                    <div class="controls">
                    <label>Ekspektasi &nbsp;</label>';
            echo CHtml::activeHiddenField($modDet, '[0]tujuan_id', array('value' => $tujuan_id));
            echo CHtml::activeTextField($modDet, '[0]tujuan_nama', array('value' => $tujuan_nama, 'class' => 'span3', 'readonly' => true));
            echo '</div></div>';
            if($luaranutama_id != ''){
                $head = KriteriahasilM::model()->findAllByAttributes(array('luarankeperawatan_id'=>$luaranutama_id));
                if(!empty($head)){
                        echo '<table class="items table table-striped table-bordered table-condensed kriteria" id="table-kriteria-1">
                                <thead>
                                    <tr>
                                        <th style="background-color:#f8f8f8; border: 1px solid #ededed !important;"></th>
                                        <th style="background-color:#f8f8f8; border: 1px solid #ededed !important;text-align: center">Kriteria Hasil</th>
                                        <th style="background-color:#f8f8f8; border: 1px solid #ededed !important;text-align: center">IR</th>
                                    </tr>
                                </thead>
                                <tbody>';
                    foreach ($head as $val){
                        $tail = ASKriteriahasildetM::model()->findAllByAttributes(array('kriteriahasil_id' => $val->kriteriahasil_id));
                        $data['table_id'] = 'table-kriteria-' . $val->kriteriahasil_id;
                        sort($tail);
                        foreach ($tail as $i => $row) {
                            echo '<tr class="criteria">
                                    <td style="background-color:#f8f8f8; border: 1px solid #ededed !important;">
                                        <span name="ASRencanaaskepdetT[0][kriteriahasildet_id]">
                                        ' . CHtml::activeCheckBox($modDet, '[0]kriteriahasildet_id', array('onkeyup' => "return $(this).focusNextInputField(event);", 'value' => $row['kriteriahasildet_id']))
                                        . '</span>
                                    </td>
                                    <td style="background-color:#f8f8f8; border: 1px solid #ededed !important;">
                                    ' . $row['kriteriahasildet_indikator'] . '
                                    </td>
                                    <td style="background-color:#f8f8f8; border: 1px solid #ededed !important;">
                                    ' . CHtml::activeDropDownList($modDet, '[0]rencanaaskep_ir', LookupM::getItemsUrutan('tingkatkriteriahasil'), array('class' => 'span2 rencanaaskep_ir', 'empty'=>'-- Pilih --')) . '
                                    </td>
                                    </tr>';
                        }
                        
                    }
                    echo '</tbody></table>';
                }
            }
        }
        ?>
    </td>
    <td class="intervensi">
        <?php
        if (!empty($modDetail->hasildiagnosa_id)) {
            
            $cekIntervensiUtama = IntervensiM::model()->findByAttributes(array('diagnosakep_id'=>$modDetail->hasildiagnosa_id, 'intervensi_nama' => 'Intervensi Utama'));
            $countUtama = 0;
            if(!empty($cekIntervensiUtama)){
                echo '<b>Intervensi Utama</b><br>';
                $intUtama = IntervensidetM::model()->findAllByAttributes(
                    array('intervensidet_aktif' => true, 'intervensi_id' => $cekIntervensiUtama->intervensi_id));
                echo CHtml::activeHiddenField($modDet, '[0]intervensi_id', array('value' => $cekIntervensiUtama->intervensi_id));
                echo CHtml::activeCheckBoxList($modDet, '[0]intervensidet_id', CHtml::listData($intUtama, 'intervensidet_id', 'intervensidet_indikator'), (array('style' => 'float: left', 'onkeyup' => "return $(this).focusNextInputField(event);", 'class'=>'intervensinya', 'onclick'=>'setTindakan(this)')));
                $countUtama = count($intUtama);
            }
            $cekIntervensiPendukung = IntervensiM::model()->findByAttributes(array('diagnosakep_id'=>$modDetail->hasildiagnosa_id, 'intervensi_nama' => 'Intervensi Pendukung'));
            if (!empty($cekIntervensiPendukung)) {
                echo '<br><b>Intervensi&nbsp;Pendukung</b><br>';
                $intDet = IntervensidetM::model()->findAllByAttributes(array('intervensidet_aktif' => true, 'intervensi_id' => $cekIntervensiPendukung->intervensi_id));
                $ii = $countUtama;
                foreach($intDet as $det){
                    echo CHtml::activeCheckBox($modDet, '[0]intervensidet_id['.$ii.']', array('value'=>$det->intervensidet_id,'style' => 'float: left', 'onkeyup' => "return $(this).focusNextInputField(event);", 'class' => 'intervensinya', 'onclick' => 'setTindakan(this)')).'<label>'.$det->intervensidet_indikator.'</label><br>';
                    $ii++;
                }
//                echo CHtml::activeCheckBoxList($modDetail, '[0]intervensidet_id', CHtml::listData(IntervensidetM::model()->findAllByAttributes(
//                                        array('intervensidet_aktif' => true, 'intervensi_id' => $cekIntervensiPendukung->intervensi_id)), 'intervensidet_id', 'intervensidet_indikator'), (array('style' => 'float: left', 'disabled' => true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'class' => 'intervensinya', 'onclick' => 'setTindakan(this)')));
            }
        }
        ?>
    </td>
    <td class="tindakannya">
        <div id="table-tindakannya">
            
        </div>
    </td>
</tr>
