<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>
    <style>
        table {
            margin-bottom: 0;
        }

        .form-actions {
            padding: 4px;
            margin-top: 5px;
        }

        .nav-tabs>li>a {
            display: block;
            cursor: pointer;
        }

        .nav-tabs>.active a:hover {
            cursor: pointer;
        }

        #jeniss label.checkbox {
            width: 100px;
            display: inline-block;
        }
    </style>
    <table style="width: 100%; border: none;">
        <tr>
            <td class="row">
                <div class="col-sm-6">
                    <fieldset class="box2">
                        <legend class="rim">Berdasarkan Kunjungan</legend>
                        <?php echo CHtml::hiddenField('type', ''); ?>
                        <?php //echo CHtml::hiddenField('src', ''); 
                        ?>
                        <div class='control-label'>Tanggal Kunjungan</div>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_awal',
                                'mode' => 'date',
                                'options' => array(
                                    'maxDate' => 'd',
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
                                    'class' => 'dtPicker2',
                                    'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                        </div>
                        <?php echo CHtml::label('Sampai dengan', 'Sampai dengan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_akhir',
                                'mode' => 'date',
                                'options' => array(
                                    'maxDate' => 'd',
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
                                    'class' => 'dtPicker2',
                                    'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                        </div>
                    </fieldset>
                </div>
                <div class="col-sm-6" id='searching'>
                    <fieldset class="box2">
                        <legend class="rim">Grafik Kunjungan</legend>
                        <?php echo '<table width=100%>
                                                        <tr>
                                                        <td>' .
                            $form->checkBoxList($model, 'kunjungan', LookupM::getItems('kunjungan'), array('value' => 'pengunjung', 'inline' => true, 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td></tr></table>';
                        ?>
                    </fieldset>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="row" id='searching'>
                    <fieldset class="span4">
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'big',
                            //                                    'parent'=>false,
                            //                                    'disabled'=>true,
                            //                                    'accordion'=>false, //default
                            'content' => array(
                                'content1' => array(
                                    'header' => 'Berdasarkan Jenis Pemeriksaan',
                                    'isi' => CHtml::hiddenField('idJenisPemeriksaan')
                                        . '<div class="input-append"><span class="add-on">' . $form->textField($model, 'jenispemeriksaanlab_nama', array(
                                            'id' => 'jenispemeriksaanlab', 'data-offset-top' => 200,
                                            'data-spy' => 'affix',
                                            'inline' => false,
                                            'sourceUrl' => $this->createUrl('AutocompleteJenisPemeriksaanLab'),
                                            'placeholder' => 'Jenis Pemeriksaan Lab'
                                        ))
                                        . '<a href="javascript:void(0);" id="tombolJenisPemeriksaanLab" 
                                                                    onclick="$(&quot;#dialogJenisPemeriksaanLab&quot;).dialog(&quot;open&quot;);return false;">
                                                        <i class="icon-list-alt"></i>
                                                        <i class="entypo-search">
                                                        </i>
                                                        </a>
                                                        </span>
                                                        </div>',
                                    'active' => true,
                                ),
                            ),
                            //                                    'htmlOptions'=>array('class'=>'aw',)
                        ));
                        ?>
                    </fieldset>
                    <fieldset class="span4">
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'big',
                            //                                    'parent'=>false,
                            //                                    'disabled'=>true,
                            //                                    'accordion'=>false, //default
                            'content' => array(
                                'content2' => array(
                                    'header' => 'Berdasarkan Jenis Penjamin',
                                    'isi' => '<table><tr>
                                                        <td>' . CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) . '<label>Jenis Penjamin</label></td>
                                                        <td>' . $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                                        'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'ajax' => array(
                                            'type' => 'POST',
                                            'url' => $this->createUrl('SetDropdownPenjaminPasien', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                                            'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data);}',
                                        ),
                                    )) . '</td>
                                                            </tr><tr>
                                                        <td><label>Penjamin</label></td><td>' .
                                        $form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)) . '</td></tr></table>',
                                    'active' => true,
                                ),
                            ),
                        ));
                        ?>
                    </fieldset>
                    <fieldset class="span4">
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'big',
                            //                                    'parent'=>false,
                            //                                    'disabled'=>true,
                            //                                    'accordion'=>false, //default
                            'content' => array(
                                'content3' => array(
                                    'header' => 'Berdasarkan Nama Pemeriksaan',
                                    'isi' => CHtml::hiddenField('idPemeriksaan')
                                        . '<div class="input-append"><span class="add-on">' . $form->textField($model, 'pemeriksaanlab_nama', array(
                                            'id' => 'pemeriksaanlab', 'data-offset-top' => 200,
                                            'data-spy' => 'affix',
                                            'inline' => false,
                                            'sourceUrl' => $this->createUrl('AutocompletePemeriksaanLab'),
                                            'placeholder' => 'Nama Pemeriksaan Lab'
                                        ))
                                        . '<a href="javascript:void(0);" id="tombolPemeriksaanLab" 
                                                                    onclick="$(&quot;#dialogPemeriksaanLab&quot;).dialog(&quot;open&quot;);return false;">
                                                        <i class="icon-list-alt"></i>
                                                        <i class="entypo-search">
                                                        </i>
                                                        </a>
                                                        </span>
                                                        </div>',
                                    'active' => true,
                                ),
                            ),
                            //                                    'htmlOptions'=>array('class'=>'aw',)
                        ));
                        ?>
                    </fieldset>
                </div>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        );
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        ));
        ?>
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); 
    ?>
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php
/**
 * Dialog untuk Jenis Pemeriksaan Lab
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogJenisPemeriksaanLab',
    'options' => array(
        'title' => 'Daftar Jenis Pemeriksaan Bank Darah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 450,
        'resizable' => true,
    ),
));

$modJenisPemeriksaan = new BDJenisPemeriksaanLabM();
$modJenisPemeriksaan->unsetAttributes();
if (isset($_GET['BDJenisPemeriksaanLabM'])) {
    $modJenisPemeriksaan->attributes = $_GET['BDJenisPemeriksaanLabM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'jenispemeriksaan-m-grid',
    'dataProvider' => $modJenisPemeriksaan->searchDialog(),
    'filter' => $modJenisPemeriksaan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                        "id" => "selectPegawai",
                                        "href"=>"",
                                        "onClick" => "
                                                      $(\"#idJenisPemeriksaan\").val(\"$data->jenispemeriksaanlab_id\");
                                                      $(\"#jenispemeriksaanlab\").val(\"$data->jenispemeriksaanlab_nama\");
                                                      $(\"#dialogJenisPemeriksaanLab\").dialog(\"close\");    
                                                      return false;
                                            "))',
        ),
        //                array(
        //                    'header'=>'ID',
        //                    'filter'=>false,
        //                    'value'=>'$data->jenispemeriksaanlab_id',
        //                ),
        array(
            'header' => 'Jenis Pemeriksaan',
            'name' => 'jenispemeriksaanlab_nama',
            'value' => '$data->jenispemeriksaanlab_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
/**
 * Dialog untuk Nama Pemeriksaan Lab
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPemeriksaanLab',
    'options' => array(
        'title' => 'Daftar Nama Pemeriksaan Bank Darah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 450,
        'resizable' => true,
    ),
));

$modPemeriksaan = new BDPemeriksaanlabM;
$modPemeriksaan->unsetAttributes();
if (isset($_GET['BDPemeriksaanlabM'])) {
    $modPemeriksaan->attributes = $_GET['BDPemeriksaanlabM'];
    $modPemeriksaan->jenispemeriksaanlab_nama = isset($_GET['BDPemeriksaanlabM']['jenispemeriksaanlab_nama']) ? $_GET['BDPemeriksaanlabM']['jenispemeriksaanlab_nama'] : null;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pemeriksaan-m-grid',
    'dataProvider' => $modPemeriksaan->searchDialog(),
    'filter' => $modPemeriksaan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                        "id" => "selectPegawai",
                                        "href"=>"",
                                        "onClick" => "
                                                      $(\"#idPemeriksaan\").val(\"$data->pemeriksaanlab_id\");
                                                      $(\"#pemeriksaanlab\").val(\"$data->pemeriksaanlab_nama\");
                                                      $(\"#dialogPemeriksaanLab\").dialog(\"close\");    
                                                      return false;
                                            "))',
        ),
        //                array(
        //                    'header'=>'ID',
        //                    'filter'=>false,
        //                    'value'=>'$data->pemeriksaanlab_id',
        //                ),
        array(
            'header' => 'Jenis Pemeriksaan',
            'name' => 'jenispemeriksaanlab_nama',
            'value' => '$data->jenispemeriksaan->jenispemeriksaanlab_nama',
        ),
        array(
            'header' => 'Kode Pemeriksaan',
            'name' => 'pemeriksaanlab_kode',
            'value' => '$data->pemeriksaanlab_kode',
        ),
        array(
            'header' => 'Nama Pemeriksaan',
            'name' => 'pemeriksaanlab_nama',
            'value' => '$data->pemeriksaanlab_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>