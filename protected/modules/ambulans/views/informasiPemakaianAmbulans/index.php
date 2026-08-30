<?php
$this->breadcrumbs = array(
    'Informasi Pemakaian Ambulans'
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Informasi <b>Pemakaian Ambulans</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
        $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('pemakaianambulans-t-grid', {
                data: $(this).serialize()
            });
            return false;
        });
        ");
        ?>
        <?php $this->renderPartial('_searchPemakaian', array('model' => $model, 'format' => $format)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemakaian Ambulans</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'pemakaianambulans-t-grid',
                    'dataProvider' => $model->searchPemakaian(),
                    //'filter'=>$modPemakaian,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
                    'columns' => array(
                        array(
                            'name' => 'tglpemakaianambulans',
                            'header' => 'Tanggal Pemakaian',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return MyFormatter::formatDateTimeForUser($data->tglpemakaianambulans);
                            }
                        ),
                        'no_rekam_medik',
                        'pemakai_nama',
                        'nama_pasien',
                        'tempattujuan',
                        'alamattujuan',
                        array(
                            'header' => 'No. Handphone/<br>Telepon',
                            'value' => '$data->nomobile." / ".$data->notelepon',
                        ),
                        array(
                            'header' => $model->getAttributeLabel('supir_id'),
                            'value' => '$data->supir_nama',
                        ),
                        array(
                            'header' => 'Paramedis',
                            'value' => '(isset($data->paramedis1_nama) ? $data->paramedis1_nama : "")." / ".(isset($data->paramedis2_nama) ? $data->paramedis2_nama : "")',
                        ),
                        array(
                            'header' => 'KM Awal - KM Akhir',
                            'value' => 'MyFormatter::formatNumberForPrint($data->kmawal)." - ".MyFormatter::formatNumberForPrint($data->kmakhir)',
                            'filter' => false,
                        ),
                        array(
                            'name' => 'jumlahkm',
                            'header' => 'Jumlah KM',
                            'value' => 'MyFormatter::formatNumberForPrint($data->jumlahkm)',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ), /*
                array(
                    'name'=>'tarifperkm',
                    'value'=>'MyFormatter::formatNumberForPrint($data->tarifperkm)',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                    'htmlOptions'=>array('style'=>'text-align: right;'),
                ), */
                        array(
                            'name' => 'totaltarifambulans',
                            'header' => 'Total Tarif Ambulans (Rp)',
                            'value' => 'MyFormatter::formatNumberForPrint($data->totaltarifambulans)',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'name' => 'tglkembaliambulans',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data->tglkembaliambulans)) {
                                    return MyFormatter::formatDateTimeForUser($data->tglkembaliambulans);
                                }
                                $str = CHtml::link('<i class="glyphicon glyphicon-home"></i>', '#', array(
                                    'onclick' => "tibaAmbulans(" . CJSON::encode($data->attributes) . "); return false;",
                                    'rel' => 'tooltip',
                                    'title' => 'Klik jika kendaraan sudah kembali atau berada di rumah sakit.',
                                ));
                                return $str;
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Lihat Detail',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => 'CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("' . Yii::app()->controller->id . '/view",array("pemakaianambulans_id"=>$data->pemakaianambulans_id)),
                                           array("target"=>"iframepemakaian", "onclick"=>"$(\"#detail-pemakaian\").dialog(\"open\");",
                                                 "class"=>"btn-small"))',
                        ),
                        array(
                            'header' => 'Batal Pakai',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data->tglkembaliambulans)) {
                                    return 'SUDAH DIPAKAI';
                                }
                                return CHtml::Link(
                                    "<i class=\"icon-form-silang\"></i>",
                                    "javascript:void(0)",
                                    array(
                                        "onclick" => "batalPakai('" . $data->pemakaianambulans_id . "','" . $data->pesanambulans_t . "')",
                                        "class" => "btn-small"
                                    )
                                );
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        )
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function batalPakai(pemakaian_id, pemesanan_id) {
        myConfirm("Anda yakin akan membatalkan pemakaian ambulans?", "Perhatian!", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('batalPakai'); ?>', {
                    pemakaian_id: pemakaian_id,
                    pemesanan_id: pemesanan_id
                }, function(data) {
                    if (data.status == 'berhasil') {
                        $.fn.yiiGridView.update('pemakaianambulans-t-grid', {
                            data: $(this).serialize()
                        });
                        myAlert(data.msg);
                        return false;
                    } else {
                        myAlert(data.msg)
                    }
                }, 'json');
            }
        });
    }

    function tibaAmbulans(data) {
        $("#dialog-kembali #AMInformasipemakaianambulansV_pemakaianambulans_id").val(data.pemakaianambulans_id);
        $("#dialog-kembali #AMInformasipemakaianambulansV_no_rekam_medik").val(data.no_rekam_medik);
        $("#dialog-kembali #AMInformasipemakaianambulansV_nama_pasien").val(data.nama_pasien);
        $("#dialog-kembali #AMInformasipemakaianambulansV_pemakai_nama").val(data.pemakai_nama);
        $("#dialog-kembali #AMInformasipemakaianambulansV_tempattujuan").val(data.tempattujuan);
        $("#dialog-kembali #AMInformasipemakaianambulansV_alamattujuan").val(data.alamattujuan);
        $("#dialog-kembali #AMInformasipemakaianambulansV_kmawal").val(data.kmawal);
        $("#dialog-kembali #AMInformasipemakaianambulansV_tglkembaliambulans").val("");
        $("#dialog-kembali").dialog("open");
    }

    function submitUpdateTanggalKembali() {
        var km_awal = parseFloat($("#dialog-kembali #AMInformasipemakaianambulansV_kmawal").val());
        var km_akhir = $("#dialog-kembali #AMInformasipemakaianambulansV_kmakhir").val();
        var tgl_kembali = $("#AMInformasipemakaianambulansV_tglkembaliambulans").val();
        if (tgl_kembali == "") {
            myAlert("Tanggal Kembali harus diisi");
            return false;
        }
        if (km_akhir == "") {
            myAlert("KM Akhir harus diisi");
            return false;
        }
        if (km_akhir < km_awal) {
            myAlert("KM Akhir tidak boleh kurang dari KM Awal");
            return false;
        }
        $("#btn-update-tanggal").prop("disabled", true);
        $.post('<?php echo $this->createUrl('updateTglKembali'); ?>', $("#form-kembali").serialize(), function(data) {
            if (data.ok == 1) {
                $("#dialog-kembali #AMInformasipemakaianambulansV_kmakhir").val("");
                $("#dialog-kembali").dialog("close");
                myAlert("Tanggal kembali berhasil disimpan.");
                $.fn.yiiGridView.update("pemakaianambulans-t-grid");
            } else {
                myAlert("Tanggal kembali gagal disimpan.");
            }
            $("#btn-update-tanggal").prop("disabled", false);
        }, 'json');
    }
</script>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'detail-pemakaian',
    'options' => array(
        'title' => 'Detail Pemakaian Ambulans',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'height' => 350,
        'resizable' => false,
    ),
)); ?>
<iframe src="" name="iframepemakaian" style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog-kembali',
    'options' => array(
        'title' => 'Tanggal Kembali Ambulans',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 400,
        'height' => 400,
        'resizable' => false,
    ),
)); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'form-kembali',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'nopolisi'),
)); ?>
<?php
$model = new AMInformasipemakaianambulansV;
$model->unsetAttributes();
echo $form->hiddenField($model, 'pemakaianambulans_id', array('readonly' => true));
echo $form->textFieldRow($model, 'no_rekam_medik', array('readonly' => true));
echo $form->textFieldRow($model, 'nama_pasien', array('readonly' => true));
echo $form->textFieldRow($model, 'pemakai_nama', array('readonly' => true));
echo $form->textFieldRow($model, 'tempattujuan', array('readonly' => true));
echo $form->textFieldRow($model, 'alamattujuan', array('readonly' => true));
echo $form->textFieldRow($model, 'kmawal', array('readonly' => true, 'class' => 'span2', 'style' => 'text-align: right;')); //
echo $form->textFieldRow($model, 'kmakhir', array('readonly' => false, 'class' => 'span2 numbers-only', 'style' => 'text-align: right;'));
?>
<div class="control-group">
    <?php echo CHtml::activeLabel($model, 'Tanggal Kembali', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php $this->widget('MyDateTimePicker', array(
            'model' => $model,
            'attribute' => 'tglkembaliambulans',
            'mode' => 'datetime',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
            ),
            'htmlOptions' => array('readonly' => false, 'class' => 'span3'),
        ));
        ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton('<i class="entypo-check"></i> Simpan', array(
        'class' => 'btn btn-danger',
        'type' => 'button',
        'onclick' => 'submitUpdateTanggalKembali();',
        'id' => 'btn-update-tanggal'
    )); ?>
    <?php echo CHtml::htmlButton('<i class="entypo-cancel"></i> Batal', array(
        'class' => 'btn btn-default',
        'type' => 'button',
        'onclick' => 'resetTanggalKembali();',
    )); ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>