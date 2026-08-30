<style>
    .tr_isadmin {
        background-color: #FAFAD2 !important;
        color: #111010;
    }

    .tr_isadmin:hover {
        background-color: #FAFAD2 !important;
        color: #111010;
    }
</style>

<?php $linkHalaman = CustomFunction::getUrlByMenuID(1168); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pasien Rawat Jalan',
);
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('#formCari').submit(function(){
        $.fn.yiiGridView.update('informasibpjslog-v', {
                data: $(this).serialize()
        });
        return false;
});
");
?>
<?php
$ruangan_id = Yii::app()->user->getState('ruangan_id');
$link = explode("/", $_GET['r']);
if ($link[0] == 'rekamMedis') {
    $anamnesa_link = 'pemeriksaanFisikAnamnesaRK';
} else {
    $anamnesa_link = 'pemeriksaanFisikAnamnesaRJ';
}
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Informasi <b>Riwayat BPJS Log </b>
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
                <?php
                $form = $this->beginWidget(
                    'ext.bootstrap.widgets.BootActiveForm',
                    array(
                        'action' => Yii::app()->createUrl($this->route),
                        'method' => 'get',
                        'type' => 'horizontal',
                        'id' => 'formCari',
                        'focus' => '#' . CHtml::activeId($model, 'no_pendaftaran'),
                        'htmlOptions' => array(
                            'enctype' => 'multipart/form-data',
                            'onKeyPress' => 'return disableKeyPress(event)',
                            'class' => 'search-form'
                        ),
                    )
                );
                ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Log BPJS", 'tgl_log', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d F Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($model->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'No. Pendaftaran ')); ?>
                        <?php echo $form->textFieldRow($model, 'json_request_respose', array('class' => 'span4 ', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'JSON Request')); ?>
                        <?php //echo $form->textFieldRow($model, 'json_request_respose', array('class' => 'span4 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'Nama Pasien')); 
                        ?>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array(
                            'class' => 'btn btn-danger',
                            'type' => 'submit',
                            'title' => 'Cari'
                        )
                    ); ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        $this->createUrl($this->id . '/index'),
                        array(
                            'class' => 'btn btn-default',
                            'title' => 'Ulang',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
                        )
                    ); ?>
                    <?php
                    $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasiPasienRJ', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
                </div>

            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Informasi Riwayat BPJS Log</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget(
                    'ext.bootstrap.widgets.BootGridView',
                    array(
                        'id' => 'informasibpjslog-v',
                        'dataProvider' => $model->searchLog(),
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-condensed',
                        'replaceUrl' => true,
                        'columns' => array(
                            array(
                                'header' => 'Tanggal Log',
                                'value' => function ($data) {
                                    echo MyFormatter::formatDateTimeForUser($data->tgl_log);
                                },
                            ),
                            array(
                                'header' => 'No. Pendaftaran',
                                'value' => function ($data) {
                                    echo $data->no_pendaftaran;
                                }
                            ),
                            array(
                                'header' => 'Tanggal Pendaftaran',
                                'value' => function ($data) {
                                    echo MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran);
                                }
                            ),
                            array(
                                'header' => 'Username Log',
                                'value' => function ($data) {
                                    echo $data->nama_pemakai;
                                }
                            ),
                            array(
                                'header' => 'Nama Pegawai Log',
                                'value' => function ($data) {
                                    echo $data->nama_pegawai;
                                }
                            ),
                            array(
                                'header' => 'API',
                                'value' => function ($data) {
                                    echo $data->api;
                                }
                            ),
                            array(
                                'header' => 'Request',
                                'value' => function ($data) {
                                    echo $data->json_request_respose;
                                }
                            ),
                            array(
                                'header' => 'Response Code',
                                'value' => function ($data) {
                                    echo $data->code;
                                }
                            ),
                            array(
                                'header' => 'Response Message',
                                'value' => function ($data) {
                                    echo $data->pesan;
                                }
                            ),
                            array(
                                'header' => 'Ip Address  Log',
                                'value' => function ($data) {
                                    echo $data->ip_address;
                                }
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){
                                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                                disableLink();
                            }',
                    )
                );
                ?>
            </div>
        </div>
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

    <script type="text/javascript">
        // here is the magic

        function print(caraprint) {
            var tgl_awal = $('#InformasibpjslogV_tgl_awal').val()
            var tgl_akhir = $('#InformasibpjslogV_tgl_akhir').val()
            var no_pendaftaran = $('#InformasibpjslogV_no_pendaftaran').val()
            var json = $('#InformasibpjslogV_json_request_respose').val()

            window.open("<?php echo $this->createUrl('printRiwayatBpjs'); ?>" + "&tgl_awal=" + tgl_awal + "&tgl_akhir=" + tgl_akhir + "&no_pendaftaran=" + no_pendaftaran + "&json=" + json + "&caraprint=" + caraprint, "", width='900px', scrollbars='yes')

            console.log(tgl_akhir + tgl_awal + no_pendaftaran + json)
        }

        
    </script>
</div>
</div>