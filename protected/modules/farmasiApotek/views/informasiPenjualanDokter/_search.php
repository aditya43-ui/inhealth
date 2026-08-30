<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchInformasi',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
            ));
?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Penjualan", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modInfoPenjualan->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modInfoPenjualan->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($modInfoPenjualan->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($modInfoPenjualan->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($modInfoPenjualan, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($modInfoPenjualan, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('No. Resep', 'no_resep', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modInfoPenjualan, 'noresep', array('autofocus' => true, 'placeholder' => 'No. Resep', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Dokter', 'nama_dokter', array('class' => 'control-label')); ?>
                            <div class="controls">

                            <?php echo $form->hiddenField($modInfoPenjualan, 'pegawai_id', array('readonly' => true)) ?>
                            <?php $this->widget('MyJuiAutoComplete', array(
                                'name' => 'pasienpegawai_nama',
                                'value' => null,
                                'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . Yii::app()->createUrl('autoPasienPegawai') . '",
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
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ){
                                        $(this).val(ui.item.label);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        $(\'#FAInformasipenjualanresepV_pegawai_id\').val(ui.item.value);
                                        $(this).val(ui.item.label);
                                        return false;
                                    }',
                                ),
                                'htmlOptions' => array(
                                    //'readonly'=>$edit,
                                    'placeholder' => 'Nama Pegawai',
                                    'size' => 13,
                                    'class' => 'span3',
                                    'onkeypress' => "return $(this).focusNextInputField(event);",
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogDokter',
                            ),
                            )); ?>
                                
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Dokter Resep', 'nama_dokter', array('class' => 'control-label')); ?>
                            <div class="controls">

                            <?php $this->widget('MyJuiAutoComplete', array(
                                'name' => 'dokter_nama',
                                'value' => null,
                                'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . Yii::app()->createUrl('autoPasienPegawai') . '",
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
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ){
                                        $(this).val(ui.item.label);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        $(\'#FAInformasipenjualanresepV_pegawai_id\').val(ui.item.value);
                                        $(this).val(ui.item.label);
                                        return false;
                                    }',
                                ),
                                'htmlOptions' => array(
                                    //'readonly'=>$edit,
                                    'placeholder' => 'Nama Pegawai',
                                    'size' => 13,
                                    'class' => 'span3',
                                    'onkeypress' => "return $(this).focusNextInputField(event);",
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogDokter2',
                            ),
                            )); ?>

                            </div>
                        </div>
                    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/index'),
        array(
            'class' => 'btn btn-default',
            'title' => 'Ulang',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php
    $content = $this->renderPartial('../tips/informasi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>



<!--============================== Widget Dialog Dokter 1 ====================================-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Pencarian Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modDokterPegawai = new DokterV;
$modDokterPegawai->unsetAttributes();
$modDokterPegawai->pegawai_aktif = true;

if (isset($_GET['DokterV'])) {
    $modDokterPegawai->attributes = $_GET['DokterV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'adiagnosa-grid',
    'dataProvider' => $modDokterPegawai->searchAllDokter(),
    'filter' => $modDokterPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                array(
                                        "class"=>"btn-small",
                                        "id" => "selectKasuspenyakit",
                                        "onClick" => "\$(\"#FAInformasipenjualanresepV_pasienpegawai_id\").val($data->pegawai_id);
                                                              \$(\"#pasienpegawai_nama\").val(\"$data->namaLengkap\");
                                                              \$(\"#dialogDokter\").dialog(\"close\");"
                                ))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function ($data) {
                $jabatan = '-';

                if(!empty($data->jabatan_id)) {

                    $jb = JabatanM::model()->findByPk($data->jabatan_id);
                    $jabatan = $jb->jabatan_nama;

                }

                return $jabatan;
            },
            'filter' => CHtml::activeDropDownList($modDokterPegawai, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = TRUE ORDER BY jabatan_nama ASC'), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),

        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<!--============================== endWidget Dialog Dokter 1 ====================================-->



<!--============================== Widget Dialog Dokter 2 ====================================-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDokter2',
    'options' => array(
        'title' => 'Pencarian Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modDokterPegawai = new DokterV;
$modDokterPegawai->unsetAttributes();
$modDokterPegawai->pegawai_aktif = true;

if (isset($_GET['DokterV'])) {
    $modDokterPegawai->attributes = $_GET['DokterV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'adiagnosa2-grid',
    'dataProvider' => $modDokterPegawai->searchAllDokter(),
    'filter' => $modDokterPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                array(
                                        "class"=>"btn-small",
                                        "id" => "selectKasuspenyakit2",
                                        "onClick" => "\$(\"#FAInformasipenjualanresepV_pegawai_id\").val($data->pegawai_id);
                                                              \$(\"#dokter_nama\").val(\"$data->namaLengkap\");
                                                              \$(\"#dialogDokter2\").dialog(\"close\");"
                                ))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function ($data) {
                $jabatan = '-';

                if(!empty($data->jabatan_id)) {

                    $jb = JabatanM::model()->findByPk($data->jabatan_id);
                    $jabatan = $jb->jabatan_nama;

                }

                return $jabatan;
            },
            'filter' => CHtml::activeDropDownList($modDokterPegawai, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = TRUE ORDER BY jabatan_nama ASC'), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),

        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<!--============================== endWidget Dialog Dokter 2 ====================================-->

