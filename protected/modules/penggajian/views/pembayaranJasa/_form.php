<div class="row" id="formPembayaran">
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->hiddenField($model, 'tandabuktikeluar_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->hiddenField($model, 'pajak_id', array('class' => 'span3')); ?>

    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglbayarjasa', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'tglbayarjasa', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'kode_objekpajak', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'kode_objekpajak', LookupM::getItems('kodeobjekpajak'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'nobayarjasa', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nobayarjasa', array('readonly' => true, 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'totaltarif', array('readonly' => true, 'class' => 'span2 inputFormTabel integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'totaljasa', array('readonly' => true, 'class' => 'span2 inputFormTabel integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'totaladjsument', array('onblur' => 'hitungTotal()', 'class' => 'span2 inputFormTabel integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'total_pajak', array('readonly' => true, 'class' => 'span2 inputFormTabel integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <span hidden>
            <?php echo $form->textFieldRow($model, 'total_terima', array('readonly' => true, 'class' => 'span2 inputFormTabel integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </span>
        <?php echo $form->textFieldRow($model, 'totalbayarjasa', array('readonly' => true, 'class' => 'span2 inputFormTabel integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php // echo $form->textFieldRow($model,'totalsisajasa',array('readonly'=>true, 'class'=>'span2 inputFormTabel integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <div class="control-group" hidden>
            <?php echo CHtml::label('Total Terima / Pegawai', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('total_terima_perawat', 0, array('hidden' => true, 'readonly' => true, 'class' => 'span2 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo Chtml::label("Pegawai Mengetahui <span style='color:red;'>*</span>", 'mengetahui_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'mengetahui_id'); ?>
                <!--<div class="input-append" style='display:inline'>-->
                <?php echo $form->textField($model, 'mengetahui', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php
                //				$this->widget('MyJuiAutoComplete', array(
                //					'model'=>$model,
                //					'attribute' => 'mengetahui',
                //					'source' => 'js: function(request, response) {
                //						$.ajax({
                //							url: "' . Yii::app()->createUrl('ActionAutoComplete/getPegawai') . '",
                //							dataType: "json",
                //							data: {
                //								term: request.term,
                //							},
                //							success: function (data) {
                //								response(data);
                //							}
                //						})
                //					}',
                //					'options' => array(
                //						'showAnim' => 'fold',
                //						'minLength' => 2,
                //						'focus' => 'js:function( event, ui ) {
                //							$(this).val( ui.item.label);
                //							return false;
                //						}',
                //						'select' => 'js:function( event, ui ) {
                //							$("#'.Chtml::activeId($model, 'mengetahui_id') . '").val(ui.item.pegawai_id); 
                //							return false;
                //						}',
                //					),
                //					'htmlOptions' => array(
                //						'class'=>'span3 required hurufs-only',
                //						'onkeypress' => "return $(this).focusNextInputField(event)",
                //						//'placeholder'=>'Nama Pegawai Mengetahui'
                //					),
                //					'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                //				));
                ?>
                <?php echo $form->error($model, 'mengetahui_id'); ?>
            </div>
        </div>
        <!--<div class="control-group">-->
        <?php // echo Chtml::label("Pegawai Mengetahui (PT) <span style='color:red;'>*</span>", 'mengetahui_pt_id', array('class' => 'control-label')); 
        ?>
        <!--<div class="controls">-->
        <?php // echo $form->hiddenField($model, 'mengetahui_pt_id'); 
        ?>
        <!--<div class="input-append" style='display:inline'>-->
        <?php // echo $form->textField($model,'mengetahui_pt',array('readonly'=>true, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php
        //				$this->widget('MyJuiAutoComplete', array(
        //					'model'=>$model,
        //					'attribute' => 'mengetahui_pt',
        //					'source' => 'js: function(request, response) {
        //						$.ajax({
        //							url: "' . Yii::app()->createUrl('ActionAutoComplete/getPegawai') . '",
        //							dataType: "json",
        //							data: {
        //								term: request.term,
        //							},
        //							success: function (data) {
        //								response(data);
        //							}
        //						})
        //					}',
        //					'options' => array(
        //						'showAnim' => 'fold',
        //						'minLength' => 2,
        //						'focus' => 'js:function( event, ui ) {
        //							$(this).val( ui.item.label);
        //							return false;
        //						}',
        //						'select' => 'js:function( event, ui ) {
        //							$("#'.Chtml::activeId($model, 'mengetahui_pt_id') . '").val(ui.item.pegawai_id); 
        //							return false;
        //						}',
        //					),
        //					'htmlOptions' => array(
        //						'class'=>'span3 required hurufs-only',
        //						'onkeypress' => "return $(this).focusNextInputField(event)",
        //						//'placeholder'=>'Nama Pegawai Mengetahui (PT)'
        //					),
        //					'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui2'),
        //				));
        ?>
        <?php // echo $form->error($model, 'mengetahui_pt_id'); 
        ?>
        <!--</div>-->
        <!--</div>-->
        <div class="control-group">
            <?php echo Chtml::label("Pegawai Menyetujui <span style='color:red;'>*</span>", 'menyetujui_pt_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'menyetujui_id'); ?>
                <!--<div class="input-append" style='display:inline'>-->
                <?php echo $form->textField($model, 'menyetujui', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php
                //				$this->widget('MyJuiAutoComplete', array(
                //					'model'=>$model,
                //					'attribute' => 'menyetujui',
                //					'source' => 'js: function(request, response) {
                //						$.ajax({
                //							url: "' . Yii::app()->createUrl('ActionAutoComplete/getPegawai') . '",
                //							dataType: "json",
                //							data: {
                //								term: request.term,
                //							},
                //							success: function (data) {
                //								response(data);
                //							}
                //						})
                //					}',
                //					'options' => array(
                //						'showAnim' => 'fold',
                //						'minLength' => 2,
                //						'focus' => 'js:function( event, ui ) {
                //							$(this).val( ui.item.label);
                //							return false;
                //						}',
                //						'select' => 'js:function( event, ui ) {
                //							$("#'.Chtml::activeId($model, 'menyetujui_id') . '").val(ui.item.pegawai_id); 
                //							return false;
                //						}',
                //					),
                //					'htmlOptions' => array(
                //						'class'=>'span3 required hurufs-only',
                //						'onkeypress' => "return $(this).focusNextInputField(event)",
                //						//'placeholder'=>'Nama Pegawai Menyetujui'
                //					),
                //					'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui'),
                //				));
                ?>
                <?php echo $form->error($model, 'menyetujui_id'); ?>
            </div>
        </div>

    </div>
    <div class="col-sm-6">
        <?php echo $this->renderPartial($this->path_view . "_formPajakDokter", array(
            'modPajakDokter' => $modPajakDokter,
            'form' => $form,
        ), true); ?>
        <div class="form_perawat" hidden>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-user"></i> Pegawai penerima Jasa <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                                                                                'class' => 'btn btn-tambah',
                                                                                'onclick' => 'dialogPerawat();',
                                                                            )); ?>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-condensed" id="tab_askep">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Pegawai</th>
                                <th style="width: 50px;">Hapus</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
//========= Dialog buat cari data dokter =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPerawat',
    'options' => array(
        'title' => 'Pencarian Data Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 540,
        'resizable' => false,
    ),
));
$pegawai = new PegawaiV();
$pegawai->jenisjasa = "askep";
$pegawai->pegawai_aktif = true;

$map = array(
    "askep" => array("kelompokpegawai_id" => Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN),
    "paramedis" => array("kelompokpegawai_id" => array(Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, Params::KELOMPOKPEGAWAI_ID_BIDAN)),
    "farmasi" => array("kelompokpegawai_id" => Params::KELOMPOKPEGAWAI_ID_TENAGA_NONKEPERAWATAN),
    "sopir" => array("jabatan_id" => array(Params::JABATAN_ID_DRIVER, Params::JABATAN_ID_SECURITY)),
    "laundry" => array("unitkerja_id" => Params::UNITKERJA_ID_LAUNDRY),
    "radio" => array("pegawai_id" => 78), // Syaiful Anwar
);

if (isset($_GET['PegawaiV'])) {
    $pegawai->attributes = $_GET['PegawaiV'];
}

$umap = $map[$pegawai->jenisjasa];
if (!empty($umap)) {
    $pegawai->attributes = $umap;
}

$prov = $pegawai->search();
if ($pegawai->jenisjasa == "sopir") {
    $prov = $pegawai->searchPegawaiJasaSopir();
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'perawat-t-grid',
    'dataProvider' => $prov,
    'filter' => $pegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                $res = $data->attributes;

                return CHtml::Link("<i class=\"icon-form-check\"></i>", "javascript:void(0);", array(
                    "class" => "btn-small",
                    "id" => "selectPendaftaran",
                    "onclick" => 'tambahPerawat(' . CJSON::encode($res) . '); return false'
                ));
            },
            'filter' => CHtml::activeHiddenField($pegawai, 'jenisjasa', array('id' => 'pegawai_kelompokpegawai_id')),
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->nomorindukpegawai
                    . CHtml::hiddenField("pegawai_id", $data->pegawai_id, array(
                        "class" => "perawat_id"
                    ));
            }
        ), /*
                    array(
                        'type' => 'raw',
                        'name' => 'kelompokpegawai_id',
                        'value' => function($data) {
                            $kel = KelompokpegawaiM::model()->findByPk($data->kelompokpegawai_id);
                            return $kel->kelompokpegawai_nama;
                        },
                        'filter' => CHtml::activeDropDownList($pegawai, 'kelompokpegawai_id', CHtml::listData(
                            KelompokpegawaiM::model()->findAllByAttributes(array('kelompokpegawai_id' => array(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK, Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN))),
                        'kelompokpegawai_id', 'kelompokpegawai_nama'), array('empty'=>'-- Pilih --')),
                    ),
                     * 
                     */
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap'
        ),
        array(
            'header' => 'Jabatan',
            // 'filter' => CHtml::activeDropDownList($pegawai, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll(" jabatan_aktif = TRUE ORDER BY jabatan_nama ASC "), 'jabatan_id', 'jabatan_nama'),array('empty' => '-- Pilih --')),
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); reloadItemPerawat(); }',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>



<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMengetahui',
    'options' => array(
        'title' => 'Petugas Mengetahui (RS)',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new GJPegawaiM('search');
$modPegawai->unsetAttributes();
//$modPegawai->ruangan_id = 0;
if (isset($_GET['GJPegawaiM']))
    $modPegawai->attributes = $_GET['GJPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'mengetahui-jasa-grid',
    'dataProvider' => $modPegawai->searchDialog(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahan",
                                    "onClick" => "
                                    $(\"#GJPembayaranjasaT_mengetahui_id\").val($data->pegawai_id);
                                    $(\"#GJPembayaranjasaT_mengetahui\").val(\"$data->nama_pegawai\");
                                    $(\'#dialogPegawaiMengetahui\').dialog(\'close\');
                                    return false;"))',
        ),
        ////'pegawai_id',
        array(
            'name' => 'nama_pegawai',
            'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class' => 'numbers-only'))
        ),
        array(
            'name' => 'nomorindukpegawai',
            'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            }
        ),
        // 'alamat_pegawai',
        // 'agama',
        //array(
        //    'name'=>'jeniskelamin',
        ////   'filter'=> CHtml::dropDownList('GUPegawaiM[jeniskelamin]',$modPegawai->jeniskelamin,LookupM::getItems('jeniskelamin'),array('empty'=>'-- Pilih --')),
        //  'value'=>'$data->jeniskelamin',
        //  ),        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMengetahui2',
    'options' => array(
        'title' => 'Petugas Mengetahui (PT)',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new GJPegawaiM('search');
$modPegawai->unsetAttributes();
//$modPegawai->ruangan_id = 0;
if (isset($_GET['GJPegawaiM']))
    $modPegawai->attributes = $_GET['GJPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'mengetahui-pt-jasa-grid',
    'dataProvider' => $modPegawai->searchDialog(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahan",
                                    "onClick" => "
                                    $(\"#GJPembayaranjasaT_mengetahui_pt_id\").val($data->pegawai_id);
                                    $(\"#GJPembayaranjasaT_mengetahui_pt\").val(\"$data->nama_pegawai\");
                                    $(\'#dialogPegawaiMengetahui2\').dialog(\'close\');
                                    return false;"))',
        ),
        ////'pegawai_id',
        array(
            'name' => 'nama_pegawai',
            'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class' => 'numbers-only'))
        ),
        array(
            'name' => 'nomorindukpegawai',
            'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            }
        ),
        // 'alamat_pegawai',
        // 'agama',
        //array(
        //    'name'=>'jeniskelamin',
        ////   'filter'=> CHtml::dropDownList('GUPegawaiM[jeniskelamin]',$modPegawai->jeniskelamin,LookupM::getItems('jeniskelamin'),array('empty'=>'-- Pilih --')),
        //  'value'=>'$data->jeniskelamin',
        //  ),        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMenyetujui',
    'options' => array(
        'title' => 'Petugas Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new GJPegawaiM('search');
$modPegawai->unsetAttributes();
//$modPegawai->ruangan_id = 0;
if (isset($_GET['GJPegawaiM']))
    $modPegawai->attributes = $_GET['GJPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'menyetujui-jasa-grid',
    'dataProvider' => $modPegawai->searchDialog(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahan",
                                    "onClick" => "
                                    $(\"#GJPembayaranjasaT_menyetujui_id\").val($data->pegawai_id);
                                    $(\"#GJPembayaranjasaT_menyetujui\").val(\"$data->nama_pegawai\");
                                    $(\'#dialogPegawaiMenyetujui\').dialog(\'close\');
                                    return false;"))',
        ),
        ////'pegawai_id',
        array(
            'name' => 'nama_pegawai',
            'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class' => 'numbers-only'))
        ),
        array(
            'name' => 'nomorindukpegawai',
            'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            }
        ),
        // 'alamat_pegawai',
        // 'agama',
        //array(
        //    'name'=>'jeniskelamin',
        ////   'filter'=> CHtml::dropDownList('GUPegawaiM[jeniskelamin]',$modPegawai->jeniskelamin,LookupM::getItems('jeniskelamin'),array('empty'=>'-- Pilih --')),
        //  'value'=>'$data->jeniskelamin',
        //  ),        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>