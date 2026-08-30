<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Retur Refund Tindakan</b>
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
                            <?php echo CHtml::label('Nama Pasien', 'nama_pasien', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="control-group">
                                <?php echo Chtml::label("No RM", 'no_rekam_medik', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'no_rekam_medik', array('class' => 'span4 custom-only', 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'no rm')); ?>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Refund Tindakan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table>
                    <th></th>
                </table>
                <?php
                $this->widget('bootstrap.widgets.BootAlert');
                Yii::app()->clientScript->registerScript('cariPasien', "
								$('#search-retur').submit(function(){
										$.fn.yiiGridView.update('informasirefund-grid', {
												data: $(this).serialize()
										});
										return false;
								});
								");
                $artab = array(
                    array(
                        'header' => 'Tgl. Retur',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatDateTimeForUser($data->tglpembebasan)',
                    ),
                    array(
                        'header' => 'Nama Pasien',
                        'type' => 'raw',
                        'value' => 'isset($data->nama_pasien) ? $data->nama_pasien:"-"',
                    ),
                    array(
                        'header' => 'No RM',
                        'type' => 'raw',
                        'value' => 'isset($data->no_rekam_medik) ? $data->no_rekam_medik:"-"',
                    ),
                    array(
                        'header' => 'Jumlah Retur (Rp)',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatNumberForPrint($data->jmlpembebasan)',
                        'htmlOptions' => array(
                            'style' => 'text-align: right;',
                        ),
                    ),
                );

                if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_BILLINGKASIR) {
                    array_push(
                        $artab,
                        // array(
                        //     'header' => 'Pembayaran Retur',
                        //     'type' => 'raw',
                        //     'value' => function ($data) {
                        //         $retur = BKReturbayarpelayananT::model()->findByAttributes(array(
                        //             'pembebasantarif_id' => $data->pembebasantarif_id,
                        //         ));
                        //         if (!empty($retur)) {
                        //             return CHtml::Link(
                        //                 "<i class=\"icon-form-rincianretur\"></i>",
                        //                 Yii::app()->controller->createUrl("returTagihanPasien/returTagihan", array("tandabuktibayar_id" => $retur->returbayarpelayanan_id, "frame" => 1)),
                        //                 array(
                        //                     "class" => "",
                        //                     "target" => "iframeKwitansiReturObat",
                        //                     "onclick" => "$(\"#dialogKwitansiReturObat\").dialog(\"open\");",
                        //                     "rel" => "tooltip",
                        //                     "title" => "Klik untuk melihat Kuitansi Pembayaran Retur Tagihan Pasien",
                        //                 )
                        //             );
                        //         }
                        //         return (empty($data->returbayarpelayanan_id) ? CHtml::Link(
                        //             "<i class=\"icon-form-bayar\"></i>",
                        //             Yii::app()->createAbsoluteUrl("billingKasir/returTagihanPasien/Index", array("pembebasantarif_id" => $data->pembebasantarif_id)),
                        //             array(
                        //                 "class" => "",
                        //                 //															  "target"=>"iframeReturPembayaran",
                        //                 //															  "onclick"=>"$(\"#dialogReturPembayaran\").dialog(\"open\");",
                        //                 "rel" => "tooltip",
                        //                 "title" => "Klik untuk membayar Retur Tagihan Pasien",
                        //             )
                        //         ) : "");
                        //     },
                        //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        // ),
                        // array(
                        //     'header'=> 'Hapus',
                        //     'value' => function($data){
                        //         echo CHtml::link("<i class='" . MyIcon::getIcons('batal') . "'></i>","#", array("submit"=>array('delete', 'id'=>$data->pembebasantarif_id), 'confirm' => 'Are you sure?'));
                        //     },
                        // ),
                        array(
    
                            'class' => 'CButtonColumn',
                            'template' => '{delete}',
                            'header' => 'Batal',
                            'buttons' => array(
    
                                'delete' => array(
                                    'url' => 'Yii::app()->createUrl("/billingKasir/informasiRefund/delete", array("id" => $data->pembebasantarif_id))',
    
                                ),
    
                            )
    
                        ),
                    );
                } 
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasirefund-grid',
                    'dataProvider' => $model->searchInformasiRetur(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => $artab,
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