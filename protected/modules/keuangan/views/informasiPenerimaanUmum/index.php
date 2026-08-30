<?php $linkHalaman = CustomFunction::getUrlByMenuID(1389); ?>
<?php
$this->breadcrumbs = array(
    'Daftar Penerimaan Kas',
);
Yii::app()->clientScript->registerScript('search', "
$('#penerimaan-t-search').submit(function()
{
    $.fn.yiiGridView.update('daftarpenerimaan-m-grid', {
        data: $(this).serialize()
    });
    return false;
});
$('#btn_resset').click(function()
{
    setTimeout(function(){
        $.fn.yiiGridView.update('daftarpenerimaan-m-grid', {
            data: $('#penerimaan-t-search').serialize()
        });    
    }, 1000);
});
");
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
$form = $this->beginWidget(
    'ext.bootstrap.widgets.BootActiveForm',
    array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'penerimaan-t-search',
        'type' => 'horizontal',
    )
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Penerimaan Umum</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Penerimaan Umum", 'tglPenerimaanKas', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($modPenerimaan->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($modPenerimaan->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d F Y', strtotime($modPenerimaan->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($modPenerimaan->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($modPenerimaan, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($modPenerimaan, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($modPenerimaan, 'nopenerimaan', array('placeholder' => 'No. Penerimaan', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->hiddenField($modPenerimaan, 'pegawai_id', array('readonly' => true)); ?>
                            <?php echo CHtml::label('Nama Pegawai', 'nama_pegawai', array('class' => 'control-label',)) ?>
                            <div class="controls">
                                <?php
                                $this->widget(
                                    'MyJuiAutoComplete',
                                    array(
                                        //'model'=>$model,
                                        //'attribute'=>'nama_pegawai',
                                        'name' => 'nama_pegawai',
                                        'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/ListKaryawan'),
                                        'options' => array(
                                            'class' => 'span3',
                                            'showAnim' => 'fold',
                                            'minLength' => 2,
                                            'select' => 'js:function( event, ui ){
                                                $("#KUPenerimaanUmumT_pegawai_id").val(ui.item.pegawai_id);
                                                $(this).val(ui.item.nama_pegawai);
                                                return false;
                                            }',
                                            'focus' => 'js:function( event, ui ) {
                                                $(this).val("");
                                                return false;
                                            }',
                                        ),
                                        'htmlOptions' => array(
                                            'placeholder' => 'Nama Pegawai',
                                            'class' => 'span3'
                                        ),
                                        'tombolDialog' => array(
                                            'idDialog' => 'dialogPegawai'
                                        ),
                                    )
                                );
                                ?>
                            </div>
                        </div>
                        <?php
                        echo CHtml::hiddenField('filter', 'shift_id', array('disabled' => 'disabled')) .
                            '<div class="control-group">
                        ' . CHtml::label('Shift', 'shift_id', array('class' => 'control-label')) . ' 
                        <div class="controls">
                            ' . $form->dropDownList($modPenerimaan, 'shift_id', Chtml::listData($modPenerimaan->ShiftItems, 'shift_id', 'shift_nama'), array(
                                'class' => 'form-control', 'multiple' => 'multiple'
                            )) . '
                        </div>
                        </div>';
                        ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Jenis Penerimaan', 'jenisPenerimaan', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php
                                //												echo  $form->dropDownList($modPenerimaan,'jenispenerimaan_id',CHtml::listData(JenispenerimaanM::model()->findAll("jenispenerimaan_aktif = TRUE ORDER BY jenispenerimaan_nama ASC"),
                                //												'jenispenerimaan_id','jenispenerimaan_nama'),array('class'=>'span2','style'=>"width:140px;",'empty'=>'-- Pilih --'));
                                ?>
                                <?php echo $form->textField($modPenerimaan, 'jenispenerimaan_nama', array('placeholder' => 'Jenis Penerimaan', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    ); ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        $this->createUrl($this->id . '/index'),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    ); ?>
                    <?php
                    $content = $this->renderPartial('keuangan.views/tips/informasi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penerimaan Umum</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                    'id' => 'daftarpenerimaan-m-grid',
                    'dataProvider' => $modPenerimaan->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
                        ),
                        array(
                            'header' => 'Tgl. Penerimaan',
                            'type' => 'raw',
                            'value' => '$data->tglpenerimaan',
                        ),
                        array(
                            'header' => 'No. Penerimaan',
                            'type' => 'raw',
                            'value' => '$data->nopenerimaan',
                        ),
                        array(
                            'header' => 'Kelompok <br> Transaksi',
                            'type' => 'raw',
                            'value' => '$data->kelompoktransaksi',
                        ),
                        // array(
                        //     'header' => 'Jenis Penjamin Keluar',
                        //     'type' => 'raw',
                        //     'value' => function ($data){
                        //         $modTandaBuktiBayar = TandabuktikeluarT::model()->findByPk($data->tandabuktikeluar_id);
                        //         echo $modTandaBuktiBayar->carabayarkeluar;
                        //     }
                        // ),
                        array(
                            'header' => 'Pegawai yang Mengeluarkan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data->pegawai_id)) {
                                    $modPegawai = PegawaiM::model()->findByAttributes(array('pegawai_id' => $data->pegawai_id));
                                    echo !empty($modPegawai->nama_pegawai) ? $modPegawai->nama_pegawai : '-';
                                } else {
                                    echo "-";
                                }
                            }
                        ),
                        array(
                            'header' => 'Shift',
                            'type' => 'raw',
                            'value' => function ($data) {
                                // $modPegawai = PegawaiM::model()->findByPk($data->create_loginpemakai_id);
                                if (!empty($data->shift_id)) {
                                    $modShift = ShiftM::model()->findByPk($data->shift_id);
                                    echo $modShift->shift_nama;
                                } else {
                                    echo "-";
                                }
                            }
                        ),
                        array(
                            'header' => 'Jenis Penerimaan',
                            'type' => 'raw',
                            'value' => '$data->jenispenerimaan->jenispenerimaan_nama',
                            'footerHtmlOptions' => array('colspan' => 6, 'style' => 'text-align:right;font-style:italic;'),
                            'footer' => 'Jumlah Total',
                        ),
                        'volume',
                        //            'satuanvol',
                        array(
                            'header' => 'Harga<br>(Rp)',
                            'name' => 'hargasatuan',
                            'value' => 'MyFormatter::formatNumberForPrint($data->hargasatuan)',
                            'htmlOptions' => array('style' => 'width:100px;text-align:right'),
                            'footerHtmlOptions' => array('style' => 'text-align:right;'),
                            'footer' => 'sum(hargasatuan)',
                        ),
                        array(
                            'header' => 'Total Harga<br>(Rp)',
                            'name' => 'totalharga',
                            'value' => 'MyFormatter::formatNumberForPrint($data->totalharga)',
                            'htmlOptions' => array('style' => 'width:100px;text-align:right'),
                            'footerHtmlOptions' => array('style' => 'text-align:right;'),
                            'footer' => 'sum(totalharga)',
                        ),
                        array(
                            'header' => 'Keterangan',
                            'type' => 'raw',
                            'value' => '$data->keterangan_penerimaan',
                            'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                            'footer' => '&nbsp;',
                        ),
                        array(
                            'header' => 'Lihat Detail',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("DetailPenerimaanUmum",array("penerimaanumum_id"=>$data->penerimaanumum_id,"frame"=>true)),
										array("class"=>"", 
											"target"=>"iframeDetPenerimaan",
											"onclick"=>"$(\"#dialogDetPenerimaan\").dialog(\"open\");",
											"rel"=>"tooltip",
											"title"=>"Klik untuk detail Penerimaan",
										))',
                            'htmlOptions' => array(
                                'style' => 'text-align: center;'
                            ),
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                            'footer' => '&nbsp;',
                        ),
                        array(
                            'header' => 'Retur/<br>Batal',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                            'footer' => '&nbsp;',
                            'value' => 'CHtml::link("<i class=\'icon-form-retur\'></i> ",Yii::app()->createUrl("keuangan/returPenerimaanKas/index",array("frame"=>1,"idPenerimaan"=>$data->penerimaanumum_id)) ,array("title"=>"Klik untuk Meretur Penerimaan Kas / Umum","target"=>"iframeRetur", "onclick"=>"$(\"#dialogRetur\").dialog(\"open\");", "rel"=>"tooltip"))',
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
// ===========================Dialog Retur=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRetur',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Retur Penerimaan Umum',
        'autoOpen' => false,
        'minWidth' => 1100,
        'height' => 500,
        'zIndex' => 1004,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="iframeRetur" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Retur================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetPenerimaan',
    'options' => array(
        'title' => 'Detail Penerimaan',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'height' => 320,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeDetPenerimaan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 450,
        'resizable' => false,
    ),
));

$modPeg = new PegawairuanganV('search');
$modPeg->unsetAttributes();
$modPeg->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PegawairuanganV'])) {
    $modPeg->attributes = $_GET['PegawairuanganV'];
    $modPeg->ruangan_id = Yii::app()->user->getState('ruangan_id');
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'cari-pegawai-m-grid',
    'dataProvider' => $modPeg->search(),
    'filter' => $modPeg,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"
                    $(\"#KUPenerimaanUmumT_pegawai_id\").val(\"$data->pegawai_id\");
                    $(\"#nama_pegawai\").val(\"$data->NamaLengkap\");
                    $(\"#dialogPegawai\").dialog(\"close\");
                    return false;"
                )
            )'
        ),
        'nama_pegawai',
        'jeniskelamin',
        'nomorindukpegawai'
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>

<script>
    $(document).ready(function() {

        var shift_id = jQuery('#<?php echo CHtml::activeId($modPenerimaan, 'shift_id') ?>');

        jQuery(shift_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();


    });
</script>