<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>
    <style>
        label.checkbox {
            width: 150px;
            display: inline-block;
        }
    </style>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-search"></i> Pencarian
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                    <?php $format = new MyFormatter(); ?>
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <?php //echo $form->hiddenField($model, 'filter', array('readonly'=>'TRUE'));
                    ?>
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
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo  CHtml::label('Jenis Jurnal', 'jenisjurnal_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'jenisjurnal_id', CHtml::listData(JenisjurnalM::model()->findAll(), 'jenisjurnal_id', 'jenisjurnal_nama'), array(
                                'class' => 'form-control', 'multiple' => 'multiple'
                            )); ?>
                        </div>
                    </div>

                </div>

                <div class="col-sm-6">
                    <div class='control-group'>
                        <?php echo CHtml::label('Kode/Nama Akun', 'kodeRekening', array('class' => 'control-label')) ?>
                        <?php echo $form->hiddenField($model, 'kdrekening5', array('readonly' => true)); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'kodenama_akun',
                                'sourceUrl' => Yii::app()->createUrl('/ActionAutoComplete/rekeningKodeNamaAkun5'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
											  $(this).val(ui.item.kodenamaakun);
										  return false;
									  }',
                                    'select' => 'js:function( event, ui ) {
											 $(this).val(ui.item.value);
											 $("#' . CHtml::activeId($model, 'kdrekening5') . '").val(ui.item.kdrekening5);
											 return false;
									  }'
                                ),
                                'htmlOptions' => array(
                                    //                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'placeholder' => 'Kode Akun',
                                    'class' => 'span3',
                                    'onblur' => 'cekKodeNamaAkun();'
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogRekDebit',),
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <?php
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                    array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'button', 'id' => 'btn_simpan', 'onclick' => 'cekPencarian();')
                ); ?>

                <?php
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/laporanJurnal'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                );

                echo $this->renderPartial('akuntansi.views.laporanAkuntansi/_tombolPrinout', true);
                ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
',  CClientScript::POS_READY);
?>

<?php $this->renderPartial('billingKasir.views.laporan._jsFunctions', array('model' => $model)); ?>

<?php
//========= Dialog buat cari data Rek Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRekDebit',
    'options' => array(
        'title' => 'Daftar Rekening',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$modRekDebit = new RekeningakuntansiV('searchDialogAccount');
$modRekDebit->unsetAttributes();

$account = "";
if (isset($_GET['RekeningakuntansiV'])) {
    $modRekDebit->attributes = $_GET['RekeningakuntansiV'];
}

//$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rekdebit-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modRekDebit->searchDialogAccount(),
    'filter' => $modRekDebit,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
				"id" => "selectRekDebit",
				"onClick" =>"
					$(\"#' . CHtml::activeId($model, 'kodenama_akun') . '\").val(\"$data->kdrekeninglast - $data->nmrekeninglast \");
					$(\"#' . CHtml::activeId($model, 'kdrekening5') . '\").val(\"$data->kdrekeninglast\");
					$(\"#dialogRekDebit\").dialog(\"close\");
					return false;
			"))',
        ),
        array(
            'header' => 'Kode Akun',
            'name' => 'kdrekeninglast',
            'value' => '$data->kdrekeninglast',
        ),
        array(
            'header' => 'Level 1',
            'name' => 'nmrekening1',
            'value' => '$data->nmrekening1',
        ),
        array(
            'header' => 'Level 2',
            'name' => 'nmrekening2',
            'value' => '$data->nmrekening2',
        ),
        array(
            'header' => 'Level 3',
            'name' => 'nmrekening3',
            'value' => '$data->nmrekening3',
        ),
        array(
            'header' => 'Level 4',
            'name' => 'nmrekening4',
            'value' => '$data->nmrekening4',
        ),
        array(
            'header' => 'Level 5',
            'name' => 'nmrekening5',
            'value' => '$data->nmrekening5',
        ),
        array(
            'header' => 'Level 6',
            'name' => 'kdrekening6',
            'value' => '$data->nmrekening6',
        ),
        array(
            'header' => 'Level 7',
            'name' => 'nmrekening7',
            'value' => '$data->nmrekening7',
        ),
        array(
            'header' => 'Level 8',
            'name' => 'nmrekening8',
            'value' => '$data->nmrekening8',
        ),
        array(
            'header' => 'Level 9',
            'name' => 'nmrekening9',
            'value' => '$data->nmrekening9',
        ),
        array(
            'header' => 'Level 10',
            'name' => 'nmrekening10',
            'value' => '$data->nmrekening10',
        ),
        array(
            'header' => 'Saldo Normal',
            'name' => 'rekeninglast_nb',
            'value' => '($data->rekeninglast_nb == "D") ? "Debit" : "Kredit"',
            'filter' =>  CHtml::activeDropDownList($modRekDebit, 'rekeninglast_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Rek Debit dialog =============================
?>

<script>
    function cekKodeNamaAkun() {
        var kodenama = $("#<?php echo Chtml::activeId($model, 'kodenama_akun'); ?>").val();

        if (kodenama != '') {
            return true;
        } else {
            $("#<?php echo Chtml::activeId($model, 'kdrekening5'); ?>").val('');
        }
    }

    function cekPencarian() {
        //var periode = $(".periodeposting_id").val();
        var tgl_awal = $("#<?php echo CHtml::activeId($model, 'tgl_awal') ?>").val();
        var tgl_akhir = $("#<?php echo CHtml::activeId($model, 'tgl_akhir') ?>").val();

        //if (periode.trim() == "") $("#searchLaporan").submit();

        //$.post('<?php echo Yii::app()->createUrl('/actionAjax/cekJurnalBelumPosting') ?>', {periode: periode}, function(data) {
        $.post('<?php echo Yii::app()->createUrl('/actionAjax/CekJurnalBelumPostingByTanggal') ?>', {
            tgl_awal: tgl_awal,
            tgl_akhir: tgl_akhir
        }, function(data) {
            if (data.ok == 1) $("#searchLaporan").submit();
            else {
                myConfirm("Masih ada jurnal yang belum diposting. Apakah Anda akan melanjutkan?", "Perhatian", function(r) {
                    if (r) {
                        $("#searchLaporan").submit();
                    }
                });
            }
        }, 'json');
    }
</script>
