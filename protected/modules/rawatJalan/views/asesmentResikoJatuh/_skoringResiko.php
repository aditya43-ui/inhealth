<?php

$formSkoring = array(
    array(
        'label' => 'Riwayat Jatuh - Kejadian Jatuh dalam 3 Bulan Terakhir',
        'lookup' => 'resikojatuh_riwayatjatuh',
        'param_keterangan' => 'riwayatjatuh_keterangan',
        'param_skor' => 'riwayatjatuh_skor',
    ),
    array(
        'label' => 'Status Mental',
        'lookup' => 'resikojatuh_statusmental',
        'param_keterangan' => 'statusmental_keterangan',
        'param_skor' => 'statusmental_skor',
    ),
    array(
        'label' => 'Pengobatan',
        'lookup' => 'resikojatuh_pengobatan',
        'param_keterangan' => 'pengobatan_keterangan',
        'param_skor' => 'pengobatan_skor',
    ),
    array(
        'label' => 'Mobilitas - Gaya Berjalan',
        'lookup' => 'resikojatuh_mobilitasgayaberjalan',
        'param_keterangan' => 'mobgayaberjalan_keterangan',
        'param_skor' => 'mobgayaberjalan_skor',
    ),
    array(
        'label' => 'Mobilitas - Alat Bantu',
        'lookup' => 'resikojatuh_mobilitasalatbantu',
        'param_keterangan' => 'mobilitasalatbantu_keterangan',
        'param_skor' => 'mobilitasalatbantu_skor',
    ),
    array(
        'label' => 'Kondisi Penyakit',
        'lookup' => 'resikojatuh_kondisipenyakit',
        'param_keterangan' => 'kondisipenyakit_keterangan',
        'param_skor' => 'konsidipenyakit_skor',
    ),
);

$i = 1;

?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Skoring Resiko Jatuh
        </div>
    </div>


    <div class="panel-body">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tgl_skoring', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_skoring',
                    'value' => null,
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3 htpd required',
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'pegawaiskoring_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'pegawaiskoring_id', array(
                    'id' => 'pegawaiskoring_id',
                ));
                if ($this->init == '') {
                    echo $form->textField($model, 'pegawaiskoring_nama', array('readonly' => true));
                } else {
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'pegawaiskoring_nama',
                        'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('/ActionAutoComplete/pegawaiRuangan') . '",
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
                                 //$("#triase_id").val(ui.item.triase_id); 
                                 setPetugas(ui.item.namaLengkap,ui.item.pegawai_id);
                                 return false;
                             }',
                        ),
                        'htmlOptions' => array('class' => 'required', 'onblur' => 'if(this.value == ""){$("#pegawaiskoring_id").val("")}', 'id' => 'pegawaiskoring_nama'),
                        'tombolDialog' => array('idDialog' => 'dialogPegawaiSkoring'),
                    ));
                }
                ?>
            </div>
        </div>
        <table class="table table-bordered table-condensed" id="tab_skor">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Pengkajian</th>
                    <th>Penilaian</th>
                    <th>Skoring</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($formSkoring as $item) : ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $item['label']; ?></td>
                        <td>
                            <?php

                            $paramLookup = LookupM::model()->findAllByAttributes(array(
                                'lookup_type' => $item['lookup'],
                            ));

                            $resParam = CHtml::listData($paramLookup, 'lookup_name', 'lookup_name');
                            $dataOption = array();

                            foreach ($paramLookup as $paramItem) {
                                $dataOption[$paramItem->lookup_name] = array(
                                    'data-value' => $paramItem->lookup_value,
                                );
                            }

                            echo $form->dropDownList(
                                $model,
                                $item['param_keterangan'],
                                $resParam,
                                array(
                                    'empty' => '-- Pilih --',
                                    'class' => 'list_skor',
                                    'onchange' => 'hitungSkor(this);',
                                    'style' => 'width: 300px',
                                    'options' => $dataOption,
                                ),
                                $dataOption
                            );
                            ?>
                        </td>
                        <td>
                            <?php echo $form->textField(
                                $model,
                                $item['param_skor'],
                                array(
                                    'empty' => '-- Pilih --',
                                    'class' => 'txt_skor span1',
                                    'readonly' => 'true',
                                    'style' => 'text-align: right;',
                                )
                            );
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td>TOTAL SCORING</td>
                    <td></td>
                    <td><?php echo $form->textField($model, 'totalskor', array(
                            'readonly' => true,
                            'class' => 'span1',
                            'style' => 'text-align: right;',
                        )); ?></td>
                <tr>
            </tfoot>
        </table>
        <div>SKOR : 0 - 24 Tidak ada Resiko (TR), 25 - 44 Resiko Rendah (RR), >= 45 Resiko Tinggi</div>
    </div>
</div>


<?php
//=============================== Dialog DPJP =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogPegawaiSkoring',
        'options' => array(
            'title' => 'Petugas Skoring',
            'autoOpen' => false,
            'width' => 840,
            'height' => 460,
            'resizable' => true,
        ),
    )
);

$format = new MyFormatter();
$modDPJP = new PegawairuanganV('search');
$modDPJP->unsetAttributes();
$modDPJP->ruangan_id = Yii::app()->user->getState('ruangan_id');
$modDPJP->pegawai_aktif = true;

if (isset($_GET['PegawairuanganV'])) {
    $modDPJP->attributes = $_GET['PegawairuanganV'];
}


$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-dpjp-m-grid',
    'dataProvider' => $modDPJP->searchPetugasSkoring(),
    'filter' => $modDPJP,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::Link('<i class="icon-form-check"></i>', "#", array(
                    "class" => "btn-small",
                    "onclick" => " setPetugas('" . $data->namaLengkap . "'," . $data->pegawai_id . ");$('#dialogPegawaiSkoring').dialog('close'); return false; "
                ));
            },
        ),
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai'
        ),
        array(
            'name' => 'nama_pegawai',
            // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'type' => 'raw',
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            },
            'filter' => CHtml::activeDropDownList($modDPJP, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll(" jabatan_aktif = TRUE ORDER BY jabatan_nama ASC "), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//=============================== END DPJP =======================================
?>