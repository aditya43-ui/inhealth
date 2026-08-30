<style type="text/css">
    .text-center{
        text-align: center !important;
    }
    .font-bold{
        font-weight: bold;
        color: black;
    }
</style>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'skrinning-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    ));
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php echo CHtml::activeHiddenField($model, 'pasien_id') ?>
<div class="row-fluid">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"  style="width:100%"><div style="width:95%">Form Skrinning Pasien Oleh Case Manager</div></div>
            </div>
            <div class="panel-body">

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Skrinning</div>
                    </div>
                    <div class="panel-body">
                        <table class="items table table-bordered table-striped table-condensed" width="100%" id="tblSkrining">
                            <thead>
                                <tr>
                                    <th width="50px">No</th>
                                    <th>Skrinning</th>
                                    <th width="250px">Skor 1</th>
                                    <th width="250px">Skor 2</th>
                                    <th width="250px">Skor 3</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $skriningDet = array();
                                $skriningDet[0] = array('nama_skrining' => 'Dikelola lebih dari 1 Dokter', 'skor_1_val' => 1, 'skor_1_label' => '1 Dokter', 'skor_2_val' => 2, 'skor_2_label' => '2 Dokter', 'skor_3_val' => 3, 'skor_3_label' => '> 2 Dokter');
                                $skriningDet[1] = array('nama_skrining' => 'Harus dilakukan tindakan resiko', 'skor_1_val' => 1, 'skor_1_label' => 'ringan', 'skor_2_val' => 2, 'skor_2_label' => 'sedang', 'skor_3_val' => 3, 'skor_3_label' => 'berat');
                                $skriningDet[2] = array('nama_skrining' => 'Penyakit kronis, kasus kompleks/ rumit dll', 'skor_1_val' => 1, 'skor_1_label' => 'Sederhana/ Simple', 'skor_2_val' => 2, 'skor_2_label' => 'Kompleks', 'skor_3_val' => 3, 'skor_3_label' => 'Sangat Kompleks');
                                $skriningDet[3] = array('nama_skrining' => 'LOS > 3 Hari', 'skor_1_val' => 1, 'skor_1_label' => '< 5 hari', 'skor_2_val' => 2, 'skor_2_label' => '5 - 7 hari', 'skor_3_val' => 3, 'skor_3_label' => '> 7 hari');
                                $skriningDet[4] = array('nama_skrining' => 'Potensial Komplain', 'skor_1_val' => 1, 'skor_1_label' => 'Kecil', 'skor_2_val' => 2, 'skor_2_label' => 'Sedang', 'skor_3_val' => 3, 'skor_3_label' => 'Tinggi');
                                $skriningDet[5] = array('nama_skrining' => 'Potensial Biaya Tinggi', 'skor_1_val' => 1, 'skor_1_label' => '< 5 Juta', 'skor_2_val' => 2, 'skor_2_label' => '5 - 10 Juta', 'skor_3_val' => 3, 'skor_3_label' => '> 10 Juta');
                                $skriningDet[6] = array('nama_skrining' => 'Masalah Pembiayaan Kompleks', 'skor_1_val' => 1, 'skor_1_label' => 'Tidak ada - Kecil', 'skor_2_val' => 2, 'skor_2_label' => 'Kecil - Sedang', 'skor_3_val' => 3, 'skor_3_label' => 'Sedang - Besar');
                                $skriningDet[7] = array('nama_skrining' => 'Pontensial cacat organ', 'skor_1_val' => 1, 'skor_1_label' => 'Kecil', 'skor_2_val' => 2, 'skor_2_label' => 'Sedang', 'skor_3_val' => 3, 'skor_3_label' => 'Besar');
                                $skriningDet[8] = array('nama_skrining' => 'Kasus yang diidentifikasi rencana pemulangan kritis atau yang membutuhkan kontinuitas pelayanan', 'skor_1_val' => 1, 'skor_1_label' => '', 'skor_2_val' => 2, 'skor_2_label' => '', 'skor_3_val' => 3, 'skor_3_label' => '');

                                if (count($skriningDet) > 0) {
                                    $indexDet = 1;
                                    foreach ($skriningDet as $i => $skrDet) {
                                        
                                        $modSkriningDet = null;
                                        
                                        if (!$model->isNewRecord) {
                                            $modSkriningDet = SkriningpasiendetT::model()->findByAttributes(array(
                                                'skriningpasien_id' => $model->skriningpasien_id,
                                                'nama_skrining' => $skrDet['nama_skrining'],
                                            ));
                                        }
                                        
                                        if (empty($modSkriningDet)) {
                                            $modSkriningDet = new SkriningpasiendetT();
                                            $modSkriningDet->nama_skrining = $skrDet['nama_skrining'];
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $indexDet . '.'; ?> </td>
                                            <td>
                                                <?php
                                                echo $modSkriningDet->nama_skrining;
                                                ?>
                                                <?php echo CHtml::activeHiddenField($modSkriningDet, '[' . $i . ']nama_skrining') ?>
                                                <?php echo CHtml::activeHiddenField($modSkriningDet, '[' . $i . ']nilai_skrining', array('class' => 'nilai_skrining')) ?>
                                                <?php echo CHtml::activeHiddenField($modSkriningDet, '[' . $i . ']nilai_skor', array('class' => 'nilai_skor')) ?>
                                            </td>
                                            <td class="skriningskor">
                                                <?php echo CHtml::activeRadioButton($modSkriningDet, '[' . $i . ']isSkrinning', array('checked'=>$modSkriningDet->nilai_skor == $skrDet['skor_1_val'], 'class' => 'isSkrinning', 'value' => $skrDet['skor_1_val'], 'uncheckValue' => null, 'onkeypress' => "return $(this).focusNextInputField(event);", 'onChange' => 'changeSkor(this,' . $i . ')', 'labelradio' => $skrDet['skor_1_label'])); ?>
                                                <?php if (!empty($skrDet['skor_1_label'])) { ?>
                                                    <label><?php echo $skrDet['skor_1_label']; ?></label>
                                                    <?php
                                                } else {
                                                    $modSkriningDet->skrinning_lainnya = ($modSkriningDet->nilai_skor == $skrDet['skor_1_val']) ? $modSkriningDet->nilai_skrining : null;
                                                    echo CHtml::activeTextField($modSkriningDet, '[' . $i . ']skrinning_lainnya', array('class' => 'skrinning_lainnya span3', 'onkeyup' => 'getTextSkriningLainnya(this,' . $i . ')'));
                                                }
                                                ?>

                                            </td>
                                            <td class="skriningskor">
                                                <?php echo CHtml::activeRadioButton($modSkriningDet, '[' . $i . ']isSkrinning', array('checked'=>$modSkriningDet->nilai_skor == $skrDet['skor_2_val'], 'class' => 'isSkrinning', 'value' => $skrDet['skor_2_val'], 'uncheckValue' => null, 'onkeypress' => "return $(this).focusNextInputField(event);", 'onChange' => 'changeSkor(this,' . $i . ')', 'labelradio' => $skrDet['skor_2_label'])); ?>
                                                <?php if (!empty($skrDet['skor_2_label'])) { ?>
                                                    <label><?php echo $skrDet['skor_2_label']; ?></label>
                                                    <?php
                                                } else {
                                                    $modSkriningDet->skrinning_lainnya = ($modSkriningDet->nilai_skor == $skrDet['skor_2_val']) ? $modSkriningDet->nilai_skrining : null;
                                                    echo CHtml::activeTextField($modSkriningDet, '[' . $i . ']skrinning_lainnya', array('class' => 'skrinning_lainnya span3', 'onkeyup' => 'getTextSkriningLainnya(this,' . $i . ')'));
                                                }
                                                ?>
                                            </td>
                                            <td class="skriningskor">
                                                <?php echo CHtml::activeRadioButton($modSkriningDet, '[' . $i . ']isSkrinning', array('checked'=>$modSkriningDet->nilai_skor == $skrDet['skor_3_val'], 'class' => 'isSkrinning', 'value' => $skrDet['skor_3_val'], 'uncheckValue' => null, 'onkeypress' => "return $(this).focusNextInputField(event);", 'onChange' => 'changeSkor(this,' . $i . ')', 'labelradio' => $skrDet['skor_3_label'])); ?>
                                                <?php if (!empty($skrDet['skor_3_label'])) { ?>
                                                    <label><?php echo $skrDet['skor_3_label']; ?></label>
                                                    <?php
                                                } else {
                                                    $modSkriningDet->skrinning_lainnya = ($modSkriningDet->nilai_skor == $skrDet['skor_3_val']) ? $modSkriningDet->nilai_skrining : null;
                                                    echo CHtml::activeTextField($modSkriningDet, '[' . $i . ']skrinning_lainnya', array('class' => 'skrinning_lainnya span3', 'onkeyup' => 'getTextSkriningLainnya(this,' . $i . ')'));
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $indexDet++;
                                    }
                                }
                                ?>


                            </tbody>
                        </table>
                        <br />
                        <p> Note: Jika total skor > 10, maka perlu koordinasi Case Manager<p>
                        <tabel>
                            <tr>
                                <td>Jumlah Skor:</td>
                                <td>
                                    <?php echo Chtml::activeTextField($model, 'jumlahskor', array('readonly' => true, 'class' => 'span2')) ?>
                                </td>
                            </tr>
                            </table>
                            
                            <table width="100%">
                                <tr>
                                    <td>
                                        <div id="formPeriksaLab row">
                                            <?php
                                            if (count($modJenisSkrining) > 0) {
                                                $jenisPeriksa = '';
                                                $indexData = 0;
                                                $indexMast = 0;
                                                $dataText = 0;

                                                foreach ($modJenisSkrining as $i => $masterJnsSkrining) {
                                                    $indexData += 4;
                                                    $modDataSkriningM = DataskriningM::model()->findAllByAttributes(array('status_dataskrining' => true, 'jenisskrining_id' => $masterJnsSkrining->jenisskrining_id), array('order' => 'urutan_skrining ASC'));
                                                    ?>
                                                    <div class="col-sm-4">
                                                        <div class="boxtindakan">
                                                            <div class="panel panel-success">
                                                                <div class="panel-heading">
                                                                    <div class="panel-title"><h6><?php echo $masterJnsSkrining->nama_jenisskrining; ?></h6></div>
                                                                </div>
                                                                <div class="panel-body">
                                                                    <?php
                                                                    if (count($modDataSkriningM) > 0) {
                                                                        foreach ($modDataSkriningM as $masterDataSkrining) {
                                                                            $precEvaluasi = new PerencanaanevaluasiT();
                                                                            $precEvaluasi->jenisskrining_id = $masterJnsSkrining->jenisskrining_id;
                                                                            $precEvaluasi->dataskrining_id = $masterDataSkrining->dataskrining_id;
                                                                            echo CHtml::activeHiddenField($precEvaluasi, '[' . $indexMast . ']jenisskrining_id');
                                                                            echo CHtml::activeHiddenField($precEvaluasi, '[' . $indexMast . ']dataskrining_id');
                                                                            echo '<label class="checkbox inline">' . CHtml::activeCheckBox($precEvaluasi, '[' . $indexMast . ']ischeckboxSkrining', array('value' => $masterDataSkrining->dataskrining_id));

                                                                            if (strtolower($masterDataSkrining->nama_skrining) == 'lainnya') {
                                                                                echo CHtml::activeTextarea($precEvaluasi, '[' . $indexMast . ']nama_lainnya', array('class' => 'span3'));
                                                                            } else {
                                                                                echo "<span>" . $masterDataSkrining->nama_skrining . "</span></label><br/>";
                                                                            }
                                                                            $indexMast++;
                                                                        }
                                                                    }
                                                                    ?>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <?php
                                                    if ($indexData == 12) {
                                                        $indexData = 0;
                                                        echo '<div class="clear"></div>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                    </div>
                </div>
                <br />
                <div class="row-fluid">
                    <div class = "col-sm-12">
                        <div class="control-group ">
                            <?php echo CHtml::label("Petugas Pengisi <font style='color:red;'>*</font>", 'petugaspengisi_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'petugaspengisi_id', array('class' => 'required')); ?>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $model,
                                    'attribute' => 'petugaspengisi_nama',
                                    'source' => 'js: function(request, response) {
                                                     $.ajax({
                                                         url: "' . $this->createUrl('AutocompletePegawai') . '",
                                                         dataType: "json",
                                                         data: {
                                                             term: request.term,
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
                                          $("#' . Chtml::activeId($model, 'petugaspengisi_id') . '").val(ui.item.pegawai_id);
                                          return false;
                                      }',
                                    ),
                                    'htmlOptions' => array(
                                        'placeholder' => 'Ketikan Petugas Pengisi',
                                        'class' => 'col-sm-8 pegawaimengetahui_nama required hurufs-only',
                                        'onkeyup' => "return $(this).focusNextInputField(event)",
                                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'petugaspengisi_id') . '").val(""); '
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row-fluid">
                    <div class="form-actions">
                        <?php
                        if (isset($_GET['sukses'])) {
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'disabled' => true));
                        } else {
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan'));
                        }
                        echo "&nbsp;";

                        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                            $this->createUrl($this->id . '/index/&pendaftaran_id=' . $_GET['pendaftaran_id']),
                            array('class' => 'btn btn-danger',
                                'onclick' => 'return refreshForm(this);'));
                        echo "&nbsp;";

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawaiMengetahui',
    'options' => array(
        'title' => 'Pencarian Petugas Pengisi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPegawaiMengetahui = new PegawairuanganV('searchPegawaiRuangan');
$modPegawaiMengetahui->unsetAttributes();
$modPegawaiMengetahui->ruangan_id = Yii::app()->user->getState("ruangan_id");
if (isset($_GET['PegawairuanganV'])) {
    $modPegawaiMengetahui->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengetahui-grid',
    'dataProvider' => $modPegawaiMengetahui->searchPegawaiRuangan(),
    'filter' => $modPegawaiMengetahui,
//        'template'=>"{items}\n{pager}",
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($model, 'petugaspengisi_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'petugaspengisi_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\");
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai', array('class' => 'numbers-only')),
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai', array('class' => 'hurufs-only')),
            'name' => 'nama_pegawai',
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
        ),
        array(
            'header' => 'Jabatan',
            'filter' => CHtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'name' => 'jabatan_id',
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . '$(".numbers-only").keyup(function(){'
    . 'setNumbersOnly(this);'
    . '});'
    . '$(".hurufs-only").keyup(function(){'
    . 'setHurufsOnly(this);'
    . '});'
    . '}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>
