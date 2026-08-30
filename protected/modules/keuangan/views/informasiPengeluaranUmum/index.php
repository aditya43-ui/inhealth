<?php
$this->breadcrumbs = array(
    'Daftar Pengeluaran Kas',
);
Yii::app()->clientScript->registerScript('search', "
    $('#pengeluaran-t-search').submit(function(){
        $.fn.yiiGridView.update('daftarpengeluaran-m-grid', {
			data: $(this).serialize()
        });
        return false;
    });
    $('#btn_reset').click(function(){
        setTimeout(function(){
            $.fn.yiiGridView.update('daftarpengeluaran-m-grid', {
                data: $('#pengeluaran-t-search').serialize()
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
        'id' => 'pengeluaran-t-search',
        'type' => 'horizontal',
    )
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pengeluaran Umum</b>
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
                            <?php echo CHtml::label("Tgl. Pengeluaran Umum", 'tglPengeluaranKas', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($modPengeluaran->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($modPengeluaran->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d F Y', strtotime($modPengeluaran->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($modPengeluaran->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($modPengeluaran, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($modPengeluaran, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($modPengeluaran, 'nopengeluaran', array('placeholder' => 'No. Pengeluaran', 'class' => 'span4 ', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                    <div class="col-sm-6">
                    <div class="control-group">
                            <?php echo $form->hiddenField($modPengeluaran, 'pegawai_id', array('readonly' => true)); ?>
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
                                                $("#KUPengeluaranUmumT_pegawai_id").val(ui.item.pegawai_id);
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
                            ' . $form->dropDownList($modPengeluaran, 'shift_id', Chtml::listData($modPengeluaran->ShiftItems, 'shift_id', 'shift_nama'), array(
                                'class' => 'form-control', 'multiple' => 'multiple'
                            )) . '
                        </div>
                    </div>';
                        ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Jenis Pengeluaran', 'jenisPengeluaran', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php
                                //											echo $form->dropDownList($modPengeluaran,'jenispengeluaran_id',CHtml::listData(JenispengeluaranM::model()->findAll(),
                                //											'jenispengeluaran_id','jenispengeluaran_nama'),array('class'=>'span2','style'=>'width:140px;','empty'=>'-- Pilih --'));
                                ?>
                                <?php echo $form->textField($modPengeluaran, 'jenispengeluaran_nama', array('placeholder' => 'Jenis Pengeluaran', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Pengeluaran Umum</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php

                $artab = array(
                    array(
                        'header' => 'No.',
                        'type' => 'raw',
                        'value' => '$row+1',
                        'htmlOptions' => array('style' => 'width:20px')
                    ),
                    'tglpengeluaran',
                    'nopengeluaran',
                    array(
                        'header' => 'Kelompok <br> Transaksi',
                        'type' => 'raw',
                        'value' => '$data->kelompoktransaksi',
                    ),
                    array(
                        'header' => 'Jenis Penjamin Keluar',
                        'type' => 'raw',
                        'value' => function ($data){
                            $modTandaBuktiBayar = TandabuktikeluarT::model()->findByPk($data->tandabuktikeluar_id);
                            echo $modTandaBuktiBayar->carabayarkeluar;
                        }
                    ),
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
                        'value' => function ($data){
                            // $modPegawai = PegawaiM::model()->findByPk($data->create_loginpemakai_id);
                            if (!empty($data->shift_id)){
                                $modShift = ShiftM::model()->findByPk($data->shift_id);
                                echo $modShift->shift_nama;
                            }else{
                                echo "-";
                            }
                            
                        }
                    ),
                    array(
                        'header' => 'Jenis Pengeluaran',
                        'type' => 'raw',
                        'value' => '$data->jenispengeluaran->jenispengeluaran_nama',
                        'footerHtmlOptions' => array('colspan' => 9, 'style' => 'text-align:right;font-style:italic;'),
                        'footer' => 'Jumlah Total',
                    ),
                    'volume',
                    array(
                        'header' => 'Harga <br>(Rp)',
                        'name' => 'hargasatuan',
                        'value' => 'MyFormatter::formatNumberForPrint($data->hargasatuan)',
                        'htmlOptions' => array('style' => 'width:100px;text-align:right'),
                        'footerHtmlOptions' => array('style' => 'text-align:right;'),
                        'footer' => 'sum(hargasatuan)',
                    ),
                    array(
                        'header' => 'Total Harga <br>(Rp)',
                        'name' => 'totalharga',
                        'value' => 'MyFormatter::formatNumberForPrint($data->totalharga)',
                        'htmlOptions' => array('style' => 'width:100px;text-align:right'),
                        'footerHtmlOptions' => array('style' => 'text-align:right;'),
                        'footer' => 'sum(totalharga)',
                    ),
                    array(
                        'header' => 'Keterangan',
                        'type' => 'raw',
                        'value' => '$data->keterangankeluar',
                        'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                        'footer' => '-',
                    ),
                    array(
                        'header' => 'Lihat Detail',
                        'type' => 'raw',
                        'value' => 'CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("DetailPengeluaranUmum",array("pengeluaranumum_id"=>$data->pengeluaranumum_id,"frame"=>true)),
                        array("class"=>"", 
                            "target"=>"iframeDetPengeluaran",
                            "onclick"=>"$(\"#dialogDetPengeluaran\").dialog(\"open\");",
                            "rel"=>"tooltip",
                            "title"=>"Klik untuk detail Pengeluaran",
                        ))',
                        'htmlOptions' => array(
                            'style' => 'text-align: center;'
                        ),
                        'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                        'footer' => '&nbsp',
                    ),
                );
                if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_AKUNTANSI ||  Yii::app()->user->getState('modul_id') == Params::MODUL_ID_BILLINGKASIR) {
                    array_push(
                        $artab,
                        array(
                            // 'header' => '<center>Batal</center>',
                            'header' => '<center>Realisasi</center>',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link('<i class="icon-form-silang"></i>', Yii::app()->createUrl('/keuangan/BatalKeluarUmumKU/Index', array('id' => $data->pengeluaranumum_id)), array(
                                    "rel" => "tooltip",
                                    "title" => "Klik untuk membatalkan Pengeluaran",
                                ));
                            },
                            'htmlOptions' => array(
                                'style' => 'width: 100px; text-align: center;',
                            ),
                            'footer' => '&nbsp',
                        ),
                    );
                } else {
                    array_push(
                        $artab,
                        array(
                            'header' => '<center>Batal</center>',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link('<i class="icon-form-silang"></i>', Yii::app()->createUrl('/keuangan/BatalKeluarUmumKU/Index', array('id' => $data->pengeluaranumum_id)), array(
                                    "rel" => "tooltip",
                                    "title" => "Klik untuk membatalkan Pengeluaran",
                                ));
                            },
                            'htmlOptions' => array(
                                'style' => 'width: 100px; text-align: center;',
                            ),
                            'footer' => '&nbsp',
                        ),
                    );
                }
                $this->widget(
                    'ext.bootstrap.widgets.HeaderGroupGridView',
                    array(
                        'id' => 'daftarpengeluaran-m-grid',
                        'dataProvider' => $modPengeluaran->searchInformasi(),
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'columns' => $artab,
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    )
                );
                ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetPengeluaran',
    'options' => array(
        'title' => 'Detail Pembayaran',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'height' => 300,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeDetPengeluaran" style="width: 100%; height: 98%;"></iframe>
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

        var shift_id = jQuery('#<?php echo CHtml::activeId($modPengeluaran, 'shift_id') ?>');

        jQuery(shift_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();


    });
</script>