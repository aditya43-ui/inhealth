<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Antrian Farmasi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Transaksi Antrian Farmasi',
        );
        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
        	$('.search-form').toggle();
        	return false;
        });
        $('#search').submit(function(){
        	$.fn.yiiGridView.update('ininformasiAntrianFarmasi-grid', {
        		data: $(this).serialize()
        	});
        	return false;
        });
    ");
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian</i>
                </div>
            </div>
            <div class="panel-body search-from">
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'action' => Yii::app()->createUrl($this->route),
                    'method' => 'get',
                    'id' => 'search',
                    'type' => 'horizontal',
                    'focus' => '#INInformasipenjualanresepV_racikanantrian_id',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
                ));
                ?>
                <?php echo $form->errorSummary($modAntrianFarmasi); ?>
                <div class="col-sm-12">
                    <div class="control-group">
                        <?php echo CHtml::label('Racikan', 'racikanantrian_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modAntrianFarmasi, 'racikanantrian_id', CHtml::listData($modAntrianFarmasi->getRacikan(), 'racikan_id', 'racikan_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4'));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <?php
                    echo $form->textFieldRow($modAntrianFarmasi, 'noantrian', array('placeholder' => 'No. Antrian', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50));
                    ?>
                </div>
                <div class="col-sm-6">
                    <?php
                    echo $form->textFieldRow($modAntrianFarmasi, 'noresep', array('placeholder' => 'No. Resep', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 80));
                    ?>
                </div>
                <!--<div class="form-group">
                                    <div class="col-sm-6">-->
                <div class="clear"></div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                    );
                    ?>
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
                    );
                    ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasiAntrianPendaftaran', array(), true);
                    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                    ?>
                </div>
                <!--</div>
                                </div>-->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Antrian Farmasi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
                    'id' => 'ininformasiAntrianFarmasi-grid',
                    'dataProvider' => $modAntrianFarmasi->searchAntrianFarmasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'mergeColumns' => array('noantrian'),
                    'columns' => array(
                        array(
                            'header' => 'Tanggal Ambil Antrian',
                            'value' => '$data->tglambilantrian',
                        ),
                        array(
                            'header' => 'No. Antrian',
                            'value' => '$data->noantrian',
                        ),
                        array(
                            'header' => 'Racikan Antrian',
                            'value' => '$data->racikanantrian_nama',
                        ),
                        array(
                            'header' => 'Racikan Antrian (Singkatan)',
                            'value' => '$data->racikanantrian_singkatan',
                        ),
                        array(
                            'header' => 'Status Pasien',
                            'value' => '(empty($data->pendaftaran_id)? "Antri" : "Sudah Mendaftar / ".$data->no_pendaftaran)',
                        ),
                        array(
                            'header' => 'Karcis',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\"icon-print\"></i>", "onclick=printKarcis(\'$data->antrianfarmasi_id\')", array("rel"=>"tooltip","title"=>"Klik untuk mengeprint karcis"))." ".CHtml::link("Print", "javascript:printKarcis(\'$data->antrianfarmasi_id\');", array("rel"=>"tooltip","title"=>"Klik untuk mengeprint karcis"))',
                            'htmlOptions' => array('style' => 'text-align: center;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script>
    function printKarcis(antrianfarmasi_id) {
        window.open('<?php echo $this->createUrl('printKarcis'); ?>' + '&antrianfarmasi_id=' + antrianfarmasi_id, 'printwin', 'left=100,top=100,width=860,height=480');
    }
</script>