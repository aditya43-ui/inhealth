<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchInfoKunjungan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
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

        #ruangan label {
            width: 120px;
            display: inline-block;
        }

        .nav-tabs>li>a {
            display: block;
            cursor: pointer;
        }
    </style>
    <div class="row">
        <div class="col-sm-6">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <div class="control-group">
                <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
                <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
            <div id='searching'>
                <fieldset>
                    <div class="control-group">
                        <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $insDrop = new CDbCriteria();
                            $insDrop->addCondition(" instalasi_aktif = TRUE ");
                            $insDrop->addInCondition(" instalasi_id ", Params::getArrayInstalasiPelayanan());
                            $insDrop->order = " instalasi_nama ASC ";

                            echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll($insDrop), 'instalasi_id', 'instalasi_nama'), array(
                                'class' => 'form-control', 'multiple' => 'multiple'
                            )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList(
                                $model,
                                'ruangan_id',
                                array(),
                                array('class' => 'form-control', 'multiple' => 'multiple')
                            ); ?>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>

        <div class="col-sm-6">
            <div id='searching'>

                <fieldset>
                    <?php echo CHtml::hiddenField('namadokter'); ?>
                    <?php echo CHtml::label('Pegawai', 'dokter_nama', array('class' => 'control-label')) ?>
                    <div class="input-append">
                        <span class="add-on">
                            <?php echo $form->textField($model, 'dokter_nama', array(
                                'id' => 'dokternama', 'data-offset-top' => 200, 'inline' => false,
                                'onkeypress' => "return $(this).focusNextInputField(event)", 'sourceUrl' => $this->createUrl('getDokter'), 'placeholder' => 'Nama Dokter'
                            )); ?>
                            <a href="javascript:void(0);" id="tombolDokterDialog" onclick="$(&quot;#dialogDokter&quot;).dialog(&quot;open&quot;);return false;">
                                <i class="icon-list"></i>
                                <i class="entypo-search">
                                </i>
                            </a>
                        </span>
                    </div>
                    <?php

                    echo CHtml::hiddenField('idSupplier'); ?>

                </fieldset>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        );
        ?>
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'konfirmasi()', 'onKeypress' => 'return formSubmit(this,event)')
        );
        ?>
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); 
    ?>
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
//$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
?>

<?php //Yii::app()->clientScript->registerScript('onclickButton','
//  var tampilGrafik = "<div class=\"tampilGrafik\" style=\"display:inline-block\"> <i class=\"icon-arrow-right icon-white\"></i> Grafik</div>";
//  $(".accordion-heading a.accordion-toggle").click(function(){
//            $(this).parents(".accordion").find("div.tampilGrafik").remove();
//            $(this).parents(".accordion-group").has(".accordion-body.in").length ? "" : $(this).append(tampilGrafik);
//            
//            
//  });
//',  CClientScript::POS_READY);
?>

<?php
/**
 * Dialog untuk nama Supplier
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Daftar Dokter',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modDokter = new PPDokterV;
if (isset($_GET['PPDokterV'])) {
    $modDokter->attributes = $_GET['PPDokterV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $modDokter->searchDialogPegawai(),
    'filter' => $modDokter,
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
                                                      $(\"#idDokter\").val(\"$data->pegawai_id\");
                                                      $(\"#dokternama\").val(\"$data->nama_pegawai\");
                                                      $(\"#dialogDokter\").dialog(\"close\");    
                                                      return false;
                                            "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'filter' => Chtml::activeTextField($modDokter, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Dokter',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => Chtml::activeTextField($modDokter, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'pegawai_id',
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            },
            'filter' => Chtml::activeDropDownList($modDokter, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });'
        . '}',
));

$this->endWidget();
?>

<script>
    $(document).ready(function() {
        jQuery('#dokternama').autocomplete({
            'showAnim': 'fold',
            'minLength': 2,
            'focus': function(event, ui) {
                $("#idSupplier").val(ui.item.pegawai_id);
                $("#dokternama").val(ui.item.nama_pegawai);
                $("#PPLaporankunjunganbydokterV_dokter_nama").val(ui.item.nama_pegawai);
                return false;
            },
            'select': function(event, ui) {
                $("#idSupplier").val(ui.item.pegawai_id);
                $("#namadokter").val(ui.item.pegawai_id);
                return false;
            },
            'source': '<?php echo (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_REKAM_MEDIS) ? $this->createUrl('/rekamMedis/Laporan/getDokter') : $this->createUrl('/pendaftaranPenjadwalan/Laporan/getDokter'); ?>'
        });
    });
</script>