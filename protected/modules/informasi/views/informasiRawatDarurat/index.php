<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Rawat Darurat</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body search-from">
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'action' => Yii::app()->createUrl($this->route),
                    'method' => 'get',
                    'id' => 'searchCari',
                    'type' => 'horizontal',
                )); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Pendaftaran", 'tgl_rekam', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($modRawatDarurat->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($modRawatDarurat->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d F Y', strtotime($modRawatDarurat->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($modRawatDarurat->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($modRawatDarurat, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($modRawatDarurat, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($modRawatDarurat, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                        <?php echo $form->textFieldRow($modRawatDarurat, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'autofocus' => TRUE)); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($modRawatDarurat, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                        <div class="control-group">
                            <?php $modRawatDarurat->tgl_awall = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modRawatDarurat->tgl_awall, 'yyyy-MM-dd'), 'medium', null); ?>
                            <?php echo CHtml::label(CHtml::activeCheckBox($modRawatDarurat, 'ceklis') . " Tanggal Lahir", 'INRawatDarurat_ceklis', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modRawatDarurat,
                                    'attribute' => 'tgl_awall',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php $modRawatDarurat->tgl_akhirl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modRawatDarurat->tgl_akhirl, 'yyyy-MM-dd'), 'medium', null); ?>
                            <?php echo CHtml::label('Sampai Dengan', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modRawatDarurat,
                                    'attribute' => 'tgl_akhirl',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    );
                    ?>
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
                    );
                    ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasi', array(), true);
                    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                    ?>
                </div>
                <?php
                // echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
                ?>
                <!--</fieldset>-->
                <?php $this->endWidget(); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Rawat Darurat</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->breadcrumbs = array(
                    'Informasi Rawat Darurat',
                );
                Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
        });
        $('#searchCari').submit(function(){
            $.fn.yiiGridView.update('ininformasiTarif-grid', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
                ?>
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'ininformasiTarif-grid',
                    'dataProvider' => $modRawatDarurat->searchRD(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '$row+1',
                        ),
                        array(
                            'name' => 'tgl_pendaftaran',
                            'type' => 'raw',
                            'value' => 'date("d/m/Y H:i:s",strtotime($data->tgl_pendaftaran))'
                        ),
                        array(
                            'name' => 'no_pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->no_pendaftaran',
                        ),
                        array(
                            'name' => 'no_rekam_medik',
                            'type' => 'raw',
                            'value' => '$data->no_rekam_medik',
                        ),
                        array(
                            'header' => 'Nama Pasien / Alias',
                            'value' => '$data->namaNamaBin'
                        ),
                        array(
                            'header' => 'Tanggal Lahir',
                            'name' => 'tanggal_lahir',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
                        ),
                        array(
                            'name' => 'alamat_pasien',
                            'type' => 'raw',
                            'value' => '$data->alamat_pasien',
                        ),
                        array(
                            'header' => 'Jenis Penjamin / Penjamin',
                            'value' => '$data->caraBayarPenjamin',
                        ),
                        array(
                            'name' => 'Dokter',
                            'type' => 'raw',
                            'value' => '$data->nama_pegawai',
                        ),
                        array(
                            'name' => 'Transportasi',
                            'type' => 'raw',
                            'value' => '(!empty($data->transportasi))? $data->transportasi : "-"',
                        ),
                        array(
                            'name' => 'Cara Masuk',
                            'type' => 'raw',
                            'value' => '(!empty($data->caramasuk_nama))? $data->caramasuk_nama : "-"',
                        ),
                        array(
                            'name' => 'Rujukan',
                            'type' => 'raw',
                            'value' => '(!empty($data->asalrujukan_nama))? $data->asalrujukan_nama : "-"',
                        ),
                        array(
                            'header' => 'Kasus Penyakit/<br>Kelas Pelayanan',
                            'type' => 'raw',
                            'value' => '"$data->jeniskasuspenyakit_nama"."<br>"."$data->kelaspelayanan_nama"',
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
        <!--<fieldset class="box">
                    <legend class="rim">Pencarian</legend>-->
    </div>
</div>
<?php
$urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/PrintTarif');
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint+"&d"+$('#search').serialize(),"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
<?php
// ===========================Dialog Details Tarif=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailsTarif',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Komponen Tarif',
        'autoOpen' => false,
        'width' => 350,
        'height' => 350,
        'resizable' => false,
        'scroll' => false
    ),
));
?>
<iframe src="" name="iframe" style="width:100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Tarif================================
?>