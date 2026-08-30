<div class="panel panel-default" id="panel_pajakdokter">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pajak Progressif Dokter
        </div>
    </div>
    <div class="panel-body">
        <div class="control-group">
            <?php echo CHtml::label('Penghasilan Bruto', 'penghasilanbruto', array('title' => 'Total Nominal Tarif', "data-toggle" => "tooltip", "data-placement" => "top", 'class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPajakDokter, 'penghasilanbruto', array('class' => 'span2 integer2 pajak_bruto', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('PKP', 'pkp', array('title' => '50% * Penghasilan Bruto', "data-toggle" => "tooltip", "data-placement" => "top", 'class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPajakDokter, 'pkp', array('class' => 'span2 integer2 pajak_pkp', 'readonly' => true)); ?>
            </div>
        </div>
        <?php // echo $form->textFieldRow($modPajakDokter, 'ptkpperbulan', array('class'=>'span2 integer2 pajak_ptkp', 'readonly'=>true)); 
        ?>
        <?php // echo $form->textFieldRow($modPajakDokter, 'ptkpsetelahpkp', array('class'=>'span2 integer2 pajak_setelahptkp', 'readonly'=>true)); 
        ?>
        <?php echo $form->textFieldRow($modPajakDokter, 'pkpkumulatif', array('class' => 'span2 integer2 pajak_pkpkumulatif', 'readonly' => true)); ?>
        <div class="control-group">
            <?php echo CHtml::label('Pelapisan PPh', 'pelapisanpph', array('title' => '5% (0 sampai 50 juta) <br> 15% (>50juta - 250 juta) <br> 25% (>250juta - 500 juta) <br> 30% (>500 juta)', "data-toggle" => "tooltip", "data-placement" => "top", 'class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPajakDokter, 'pelapisanpph', array('class' => 'span2 integer2 pajak_pelapisan', 'readonly' => true)); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modPajakDokter, 'pajakprogressif', array('class' => 'span2 integer2 pajak_pajakprogresif', 'readonly' => true)); ?>
        <hr>
        <div class="control-group">
            <?php echo Chtml::label("Pegawai Mengetahui <span style='color:red;'>*</span>", 'mengetahui_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($modPajakDokter, 'mengetahui_id'); ?>
                <!--<div class="input-append" style='display:inline'>-->
                <?php echo $form->textField($modPajakDokter, 'mengetahui', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php
                //				$this->widget('MyJuiAutoComplete', array(
                //					'model'=>$modPajakDokter,
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
                //							$("#'.Chtml::activeId($modPajakDokter, 'mengetahui_id') . '").val(ui.item.pegawai_id); 
                //							return false;
                //						}',
                //					),
                //					'htmlOptions' => array(
                //						'class'=>'span3 required hurufs-only',
                //						'onkeypress' => "return $(this).focusNextInputField(event)",
                //						//'placeholder'=>'Nama Pegawai Mengetahui'
                //					),
                //					'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahuiPajak'),
                //				));
                ?>
                <?php echo $form->error($modPajakDokter, 'mengetahui_id'); ?>
            </div>
        </div>
        <!--<div class="control-group">-->
        <?php // echo Chtml::label("Pegawai Mengetahui (PT) <span style='color:red;'>*</span>", 'mengetahui_pt_id', array('class' => 'control-label')); 
        ?>
        <!--<div class="controls">-->
        <?php // echo $form->hiddenField($modPajakDokter, 'mengetahui_pt_id'); 
        ?>
        <!--<div class="input-append" style='display:inline'>-->
        <?php // echo $form->textField($modPajakDokter,'mengetahui_pt',array('readonly'=>true, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php
        //				$this->widget('MyJuiAutoComplete', array(
        //					'model'=>$modPajakDokter,
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
        //							$("#'.Chtml::activeId($modPajakDokter, 'mengetahui_pt_id') . '").val(ui.item.pegawai_id); 
        //							return false;
        //						}',
        //					),
        //					'htmlOptions' => array(
        //						'class'=>'span3 required hurufs-only',
        //						'onkeypress' => "return $(this).focusNextInputField(event)",
        //						//'placeholder'=>'Nama Pegawai Mengetahui (PT)'
        //					),
        //					'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui2Pajak'),
        //				));
        ?>
        <?php // echo $form->error($modPajakDokter, 'mengetahui_pt_id'); 
        ?>
        <!--</div>-->
        <!--</div>-->
        <div class="control-group">
            <?php echo Chtml::label("Pegawai Menyetujui <span style='color:red;'>*</span>", 'menyetujui_pt_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($modPajakDokter, 'menyetujui_id'); ?>
                <!--<div class="input-append" style='display:inline'>-->
                <?php echo $form->textField($modPajakDokter, 'menyetujui', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php
                //				$this->widget('MyJuiAutoComplete', array(
                //					'model'=>$modPajakDokter,
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
                //							$("#'.Chtml::activeId($modPajakDokter, 'menyetujui_id') . '").val(ui.item.pegawai_id); 
                //							return false;
                //						}',
                //					),
                //					'htmlOptions' => array(
                //						'class'=>'span3 required hurufs-only',
                //						'onkeypress' => "return $(this).focusNextInputField(event)",
                //						//'placeholder'=>'Nama Pegawai Menyetujui'
                //					),
                //					'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujuiPajak'),
                //				));
                ?>
                <?php echo $form->error($modPajakDokter, 'menyetujui_id'); ?>
            </div>
        </div>
    </div>
</div>


<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMengetahuiPajak',
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
    'id' => 'mengetahui-pajak-grid',
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
                                    $(\"#PajakdokterT_mengetahui_id\").val($data->pegawai_id);
                                    $(\"#PajakdokterT_mengetahui\").val(\"$data->nama_pegawai\");
                                    $(\'#dialogPegawaiMengetahuiPajak\').dialog(\'close\');
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
    'id' => 'dialogPegawaiMengetahui2Pajak',
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
    'id' => 'mengetahui-pt-pajak-grid',
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
                                    $(\"#PajakdokterT_mengetahui_pt_id\").val($data->pegawai_id);
                                    $(\"#PajakdokterT_mengetahui_pt\").val(\"$data->nama_pegawai\");
                                    $(\'#dialogPegawaiMengetahui2Pajak\').dialog(\'close\');
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
    'id' => 'dialogPegawaiMenyetujuiPajak',
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
    'id' => 'menyetujui-pajak-grid',
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
                                    $(\"#PajakdokterT_menyetujui_id\").val($data->pegawai_id);
                                    $(\"#PajakdokterT_menyetujui\").val(\"$data->nama_pegawai\");
                                    $(\'#dialogPegawaiMenyetujuiPajak\').dialog(\'close\');
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