<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Rawat Inap</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Informasi Rawat Inap',
        );
        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
        });
        $('#search').submit(function(){
            $.fn.yiiGridView.update('ininformasiTarif-grid', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body form-search">
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'action' => Yii::app()->createUrl($this->route),
                    'method' => 'get',
                    'id' => 'search',
                    'type' => 'horizontal',
                ));
                ?>
                <?php //echo $form->textFieldRow($modRawatInap,'no_pendaftaran',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); 
                ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Pendaftaran", 'tgl_rekam', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modRawatInap->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modRawatInap->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d M Y', strtotime($modRawatInap->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($modRawatInap->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($modRawatInap, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($modRawatInap, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($modRawatInap, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                        <?php echo $form->textFieldRow($modRawatInap, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'autofocus' => TRUE)); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($modRawatInap, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                        <div class="control-group">
                            <?php $modRawatInap->tgl_awall = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modRawatInap->tgl_awall, 'yyyy-MM-dd'), 'medium', null); ?>
                            <?php echo CHtml::label(CHtml::activeCheckBox($modRawatInap, 'ceklis') . "<label for='INRawatInap_ceklis'>Tanggal Lahir</label>", 'tanggal_lahir', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modRawatInap,
                                    'attribute' => 'tgl_awall',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php $modRawatInap->tgl_akhirl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modRawatInap->tgl_akhirl, 'yyyy-MM-dd'), 'medium', null); ?>
                            <?php echo CHtml::label('Sampai Dengan', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modRawatInap,
                                    'attribute' => 'tgl_akhirl',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
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
                    $content = $this->renderPartial('informasi.views.tips.informasi', array(), true);
                    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                    ?>
                    <?php
                    // echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
                    ?>
                </div>
                </fieldset>
                <?php $this->endWidget(); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Rawat Inap</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'ininformasiTarif-grid',
                    'dataProvider' => $modRawatInap->searchRI(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Tgl. Admisi/<br>Masuk Kamar',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglAdmisiMasukKamar)'
                        ),
                        array(
                            'name' => 'caramasuk_nama',
                            'type' => 'raw',
                            'value' => '$data->caramasuk_nama',
                        ),
                        array(
                            'header' => 'No. RM/<br>No. Pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->noRmNoPend',
                        ),
                        array(
                            'header' => 'Nama Pasien/<br>Alias',
                            'value' => '$data->namaPasienNamaBin'
                        ),
                        array(
                            'header' => 'Tanggal Lahir',
                            'name' => 'tanggal_lahir',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
                        ),
                        array(
                            'name' => 'jeniskelamin',
                            'value' => '$data->jeniskelamin',
                        ),
                        array(
                            'name' => 'umur',
                            'type' => 'raw',
                            'value' => 'CHtml::hiddenField("RIInfokunjunganriV[$data->pendaftaran_id][pendaftaran_id]", $data->pendaftaran_id, array("id"=>"pendaftaran_id","onkeypress"=>"return $(this).focusNextInputField(event)","class"=>"span3")).$data->umur',
                        ),
                        array(
                            'header' => 'Alamat',
                            'type' => 'raw',
                            'value' => '$data->alamat_pasien',
                        ),
                        array(
                            'name' => 'Dokter',
                            'type' => 'raw',
                            'value' => '$data->nama_pegawai',
                        ),
                        array(
                            'header' => 'Jenis Penjamin/<br>Penjamin',
                            'value' => '$data->caraBayarPenjamin',
                        ),
                        array(
                            'name' => 'kelaspelayanan_nama',
                            'type' => 'raw',
                            'value' => '$data->kelaspelayanan_nama',
                        ),
                        array(
                            'name' => 'jeniskasuspenyakit_nama',
                            'type' => 'raw',
                            'value' => '$data->jeniskasuspenyakit_nama',
                        ),
                        array(
                            'header' => 'Ruangan',
                            'type' => 'raw',
                            'value' => '$data->ruangan_nama',
                        ),
                        array(
                            'header' => 'No. Kamar/<br>No. Bed',
                            'name' => 'kamarruangan_nokamar',
                            'type' => 'raw',
                            'value' => '"Kamar: ". $data->kamarruangan_nokamar."<br>"."Bed: ".$data->kamarruangan_nobed',
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
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