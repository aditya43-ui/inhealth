<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Retur Penjualan Obat</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'search-retur',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'method' => 'get',
            'htmlOptions' => array(),
        ));
        ?>
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
                            <?php echo CHtml::label("Tgl. Retur", 'tgl_rekam', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d F Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($model->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('No. Retur', 'noreturresep', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'noreturresep', array('placeholder' => 'No. Retur', 'class' => 'span4')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="control-group">
                                <?php echo CHtml::label('No. Resep', 'noresep', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'noresep', array('placeholder' => 'No. Resep', 'class' => 'span4')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label('Nama Pasien', 'nama_pasien', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo Chtml::label("NIK", 'no_identitas_pasien', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'no_identitas_pasien', array('class' => 'span4 custom-only', 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'NIK')); ?>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                    ); ?>
                    <?php if (!isset($_GET['frame'])) {
                        echo CHtml::link(
                            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                            $this->createUrl($this->id . '/index'),
                            array(
                                'title' => 'Ulang',
                                'class' => 'btn btn-default',
                                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                            )
                        );
                    } ?>
                    <?php
                    $content = $this->renderPartial('tips/informasi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
        
        <!-- dimatikan salah satu, karena form pecarian ada 2 -->
        <!-- <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Retur", 'tgl_rekam', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d F Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($model->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('No. Retur', 'noreturresep', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'noreturresep', array('placeholder' => 'No. Retur', 'class' => 'span4')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="control-group">
                                <?php echo CHtml::label('No. Resep', 'noresep', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'noresep', array('placeholder' => 'No. Resep', 'class' => 'span4')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label('Nama Pasien', 'nama_pasien', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                    ); ?>
                    <?php if (!isset($_GET['frame'])) {
                        echo CHtml::link(
                            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                            $this->createUrl($this->id . '/index'),
                            array(
                                'title' => 'Ulang',
                                'class' => 'btn btn-default',
                                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                            )
                        );
                    } ?>
                    <?php
                    $content = $this->renderPartial('tips/informasi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div> -->
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Retur Penjualan Obat</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('bootstrap.widgets.BootAlert');
                Yii::app()->clientScript->registerScript('cariPasien', "
								$('#search-retur').submit(function(){
										$.fn.yiiGridView.update('informasipenjualanresep-grid', {
												data: $(this).serialize()
										});
										return false;
								});
								");
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasipenjualanresep-grid',
                    'dataProvider' => $model->searchInformasiRetur(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Tgl. Retur/<br>No. Retur',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglretur)."/<br>".$data->noreturresep',
                        ),
                        /*
										array(
											'header'=>'No. Retur Resep',
											'type'=>'raw',
											'value'=>'isset($data->noreturresep) ? $data->noreturresep:"-" ',
										),*/
                        array(
                            'header' => 'Tgl. Resep/<br>No. Resep',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!isset($data->noresep) || empty($data->noresep))
                                    return "-";
                                return MyFormatter::formatDateTimeForUser($data->tglresep) . "/<br>" . $data->noresep;
                            }, //'isset($data->noresep) ? $data->noresep:"-" ',
                        ),
                        array(
                            'header' => 'Jenis Penjualan',
                            'type' => 'raw',
                            'value' => 'isset($data->jenispenjualan) ? $data->jenispenjualan:"-"',
                        ),
                        'no_rekam_medik',
                        array(
                            'header' => 'Nama Pasien',
                            'type' => 'raw',
                            'value' => 'isset($data->nama_pasien) ? $data->nama_pasien:"-"',
                        ),
                        array(
                            'header' => 'Total Retur Obat (Rp)',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatNumberForPrint($data->totalretur)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            ),
                        ),
                        array(
                            'header' => 'Mengetahui',
                            'type' => 'raw',
                            'value' => '$data->pegawaimengetahui_gelardepan." ".$data->pegawaimengetahui_nama." ".$data->pegawaimengetahui_gelarbelakang',
                        ),
                        array(
                            'header' => 'Petugas Farmasi',
                            'type' => 'raw',
                            'value' => '$data->pegawairetur_gelardepan." ".$data->pegawairetur_nama." ".$data->pegawairetur_gelarbelakang',
                        ),
                        array(
                            'header' => 'Rincian Retur Penjualan',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-rincianretur\"></i>",Yii::app()->controller->createUrl("informasiReturObatAlkes/detailRetur",array("id"=>$data->returresep_id,"iframe"=>1)),
													 array("class"=>"", 
															  "target"=>"iframeRincianReturObat",
															  "onclick"=>"$(\"#dialogRincianReturObat\").dialog(\"open\");",
															  "rel"=>"tooltip",
															  "title"=>"Klik untuk melihat Rincian Retur Obat",
														))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Pembayaran Retur Resep',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $retur = BKReturbayarpelayananT::model()->findByAttributes(array(
                                    'returresep_id' => $data->returresep_id,
                                ));
                                if (!empty($retur)) {
                                    return CHtml::Link(
                                        "<i class=\"icon-form-rincianretur\"></i>",
                                        Yii::app()->controller->createUrl("returObatAlkesPasien/printRetur", array("returbayarpelayanan_id" => $retur->returbayarpelayanan_id, "frame" => 1)),
                                        array(
                                            "class" => "",
                                            "target" => "iframeKwitansiReturObat",
                                            "onclick" => "$(\"#dialogKwitansiReturObat\").dialog(\"open\");",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk melihat Kuitansi Pembayaran Retur Resep",
                                        )
                                    );
                                }
                                return (empty($data->tandabuktikeluar_id) ? CHtml::Link(
                                    "<i class=\"icon-form-bayar\"></i>",
                                    Yii::app()->createAbsoluteUrl("billingKasir/returObatAlkesPasien/Index", array("returresep_id" => $data->returresep_id)),
                                    array(
                                        "class" => "",
                                        //															  "target"=>"iframeReturPembayaran",
                                        //															  "onclick"=>"$(\"#dialogReturPembayaran\").dialog(\"open\");",
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk membayar retur obat alkes",
                                    )
                                ) : "");
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php Yii::app()->clientScript->registerScript('', "
function printKasir(returresep_id,tandabuktibayar_id)
{
    if(idTandaBukti!=''){ 
             window.open('" . Yii::app()->createUrl('billingKasir/InformasiReturObatAlkes/bayarReturPenjualanObat') . "&returresep_id='+returresep_id+'&tandabuktibayar_id='+tandabuktibayar_id,'printwin','left=100,top=100,width=400,height=400,scrollbars=1');
    }     
}",  CClientScript::POS_HEAD);
?>
<?php
//================= Dialog Rincian Retur Penjualan Obat Alkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincianReturObat',
    'options' => array(
        'title' => 'Detail Rincian Retur Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1001,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="iframeRincianReturObat" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= End dialog Rincian Retur Penjualan Obat Alkes =============================
?>
<?php
//================= Dialog Kwitansi Retur Penjualan Obat Alkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogKwitansiReturObat',
    'options' => array(
        'title' => 'Detail Rincian Retur Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1001,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="iframeKwitansiReturObat" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= End dialog Rincian Retur Penjualan Obat Alkes =============================
?>
<?php
//================== Dialog Rincian Pembayaran Retur Obat =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogReturPembayaran',
    'options' => array(
        'title' => 'Pembayaran Retur Penjualan Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1001,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="iframeReturPembayaran" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= End Dialog Rincian Pembayaran Retur Obat =============================
?>