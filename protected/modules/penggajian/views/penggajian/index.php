<?php $linkHalaman = CustomFunction::getUrlByMenuID(2753); ?>
<?php
$this->breadcrumbs = array(
    'Transaksi Pembayaran Gaji Pegawai',
);
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.currency',
    'currency' => 'PHP',
    'config' => array(
        'symbol' => 'Rp ',
        'defaultZero' => true,
        'allowZero' => true,
        'precision' => 0,
    )
));
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pembayaran Gaji Pegawai</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'akpengeluaran-umum-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)',
                'onsubmit' => 'return cekInput(); requiredCheck(this);'
            ),
            'focus' => '#',
        ));
        ?>
        <?php
        //echo $form->errorSummary(array($modPengUmum,$modBuktiKeluar)); 
        if (isset($_GET['sukses'])) {
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($modPengUmum, 'periode gaji <span class="required">*</span>', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        // var_dump($model->attributes); die;
                        $this->widget('MyMonthPicker', array(
                            'model' => $modPengUmum,
                            'attribute' => 'periodegaji',
                            'options' => array(
                                'dateFormat' => Params::MONTH_FORMAT,
                                'yearRange' => "-100y:+0y",
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'class' => "span2 periode_gaji",
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'onchange' => 'ambilDataGaji();'
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Kategori Pegawai Asal <span class="required">*</span></label>
                    <div class="controls">
                        <?php echo CHtml::dropDownList('form_kategori', null, LookupM::getItems('kategoriasalpegawai'), array('empty' => '-- Pilih --', 'readonly' => false, 'class' => 'span4', 'onchange' => 'ambilDataGaji()')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php $modPengUmum->tglpengeluaran = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPengUmum->tglpengeluaran, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                    <?php echo $form->labelEx($modPengUmum, 'tglpengeluaran', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modPengUmum,
                            'attribute' => 'tglpengeluaran',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'class' => 'span4 dtPicker2-5 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($modPengUmum, 'nopengeluaran', array('readonly' => true, 'class' => 'span4 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->dropDownListRow($modPengUmum, 'kelompoktransaksi', LookupM::getItems('kelompoktransaksi'), array('class' => 'span4 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->hiddenField($modPengUmum, 'jenispengeluaran_id', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <div class="control-group">
                    <?php echo $form->hiddenField($modPengUmum, 'volume', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($modPengUmum, 'volume', array('onblur' => 'hitungTotalHarga()', 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php // echo $form->hiddenField($modPengUmum,'satuanvol', LookupM::getItems('satuanumum'),array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50));  
                        ?>
                    </div>
                </div>
                <?php echo $form->hiddenField($modPengUmum, 'hargasatuan', array('onblur' => 'hitungTotalHarga()', 'class' => 'inputFormTabel currency reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->hiddenField($modPengUmum, 'totalharga', array('readonly' => true, 'class' => 'inputFormTabel currency', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($modPengUmum, 'keterangankeluar', array('rows' => 3, 'placeholder' => 'Keterangan Pengeluaran/Nomor Cek/Bilyet Giro', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Jumlah Gaji', 'jmlgaji', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::TextField('jmlgaji', number_format($modPengUmum->jmlgaji), array('readonly' => true, 'class' => 'integer2 span4',)); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><span hidden><?php echo $form->checkBox($modPengUmum, 'isurainkeluarumum', array('checked' => true, 'onchange' => 'bukaUraian(this)', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </span>
                    <i class="glyphicon glyphicon-file"></i> Uraian
                </div>
            </div>
            <div class="panel-body">
                <div id="div_tblInputUraian">
                    <table id="tblInputUraian" class="table table-bordered table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Uraian <span class="required">*</span></th>
                                <th>Volume</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Total</th>
                                <th><?php // echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowUraian(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah uraian')); 
                                    ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $this->renderPartial($this->path_view . '_rowUraian', array('form' => $form, 'modUraian' => $modUraian, 'removeButton' => true)); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div style="overflow-x: auto;max-width: 100%">
                            <?php
                            $this->renderPartial(
                                $this->path_view . '_rowListRekening',
                                array(
                                    'form' => $form,
                                    'modUraian' => $modUraian,
                                )
                            );
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                            <?php echo $form->labelEx($modBuktiKeluar, 'tglkaskeluar', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modBuktiKeluar,
                                    'attribute' => 'tglkaskeluar',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'class' => 'span4 dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <?php // echo $form->dropDownListRow($modBuktiKeluar,'tahun', Params::tahun(),array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>4));  
                        ?>
                        <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                        <?php echo $form->textFieldRow($modBuktiKeluar, 'nokaskeluar', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true)); ?>
                        <?php echo $form->hiddenField($modBuktiKeluar, 'biayaadministrasi', array('onkeyup' => 'hitungJmlBayar();', 'class' => 'inputFormTabel currency span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($modBuktiKeluar, 'jmlkaskeluar', array('readonly' => true, 'class' => 'span4 inputFormTabel integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->dropDownListRow($modBuktiKeluar, 'carabayarkeluar', LookupM::getItems('carabayarkeluar'), array('onchange' => 'formCarabayar(this.value); ambilRekeningGaji();', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        <!--								</div>
								<div class="col-sm-6">-->
                        <div id="divCaraBayarTransfer">
                            <div class="control-group">
                                <?php echo CHtml::label("Nama Bank Pengirim", 'bank_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php
                                    $modBank = BankM::getItems($modBuktiKeluar->bank_id);
                                    echo $form->dropDownList($modBuktiKeluar, 'bank_id', CHtml::listData($modBank, 'bank_id', 'namabank'), array(
                                        'class' => 'span4', 'empty' => '-- Pilih --', 'onchange' => 'setNamaBank(this);',
                                        'onkeyup' => "return $(this).focusNextInputField(event);"
                                    ));
                                    ?>
                                </div>
                            </div>
                            <?php // echo CHtml::activeHiddenField($modBuktiKeluar, 'melalubank',array('readonly'=>true, 'class'=>'span4')); 
                            ?>
                            <?php echo $form->textFieldRow($modBuktiKeluar, 'denganrekening', array(
                                'class' => 'span4',
                                'placeholder' => 'Dengan Rekening',
                                'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100
                            )); ?>
                            <?php echo $form->textFieldRow($modBuktiKeluar, 'atasnamarekening', array(
                                'class' => 'span4',
                                'placeholder' => 'Atas Nama Rekening',
                                'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100
                            )); ?>
                            <div class="control-group">
                                <?php echo CHtml::activeLabel($modBuktiKeluar, 'nobukti_transfer', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($modBuktiKeluar, 'nobukti_transfer', array('placeholder' => 'No. Bukti Transfer', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::activeLabel($modBuktiKeluar, 'norekpenerima', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($modBuktiKeluar, 'norekpenerima', array('placeholder' => 'No Rekening Penerima', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::activeLabel($modBuktiKeluar, 'melalubank', array('class' => 'control-label', 'label' => 'Nama Bank Penerima')); ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList($modBuktiKeluar, 'melalubank', LookupM::getItems('bank'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group namapenerimaInput">
                            <?php echo CHtml::label('Nama <span class="labelpenerima">Bank</span> <span class="required">*</span>', 'namapenerima', array('class' => 'control-label namapenerima required')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modBuktiKeluar, 'namapenerima', array('class' => 'span4 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Alamat <span class="labelpenerima">Bank</span> <span class="required">*</span>', 'alamatpenerima', array('class' => 'control-label alamatpenerima required')) ?>
                            <div class="controls">
                                <?php echo $form->textArea($modBuktiKeluar, 'alamatpenerima', array('placeholder' => 'Alamat Bank Penerima', 'class' => 'span4 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <?php // echo $form->textFieldRow($modBuktiKeluar, 'namapenerima', array('class' => 'span4 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
                        ?>
                        <?php // echo $form->textAreaRow($modBuktiKeluar, 'alamatpenerima', array('class' => 'span4 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);")); 
                        ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Sebagai Pembayaran <span class="required">*</span>', 'namapenerima', array('class' => 'control-label namapenerima required')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modBuktiKeluar, 'untukpembayaran', array('class' => 'span4 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            </div>
                        </div>
                        <?php // echo $form->textFieldRow($modBuktiKeluar, 'untukpembayaran', array('class' => 'span4 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <!--<div style="float:left;margin-right:6px;">-->
            <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
            $urlSave = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/index');
            if (!isset($_GET['sukses'])) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'simpanPengeluaran(\'jurnal\');return false;', 'onKeypress' => 'return simpanPengeluaran(\'jurnal\');')
                );
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);')
                );
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;')
                );
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);')
                );
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onClick' => 'print("PRINT")'));
            }
            //                $this->widget('bootstrap.widgets.BootButtonGroup', array(
            //                    'type'=>'primary',
            //                    'buttons'=>array(
            //                        array(
            //                            'label'=>'Simpan',
            //                            'icon'=>'entypo-check',
            //                            'url'=>"#",
            //                            'htmlOptions'=>
            //                                array(
            //                                    'onclick'=>'simpanPengeluaran(\'jurnal\');return false;',
            //                                )
            //                       ),
            //                        array(
            //                            'label'=>'',
            //                            'items'=>array(
            //                                array(
            //                                    'label'=>'Posting',
            //                                    'icon'=>'icon-ok',
            //                                    'url'=>"#",
            //                                    'itemOptions' => array(
            //                                        'onclick'=>'simpanPengeluaran(\'posting\');return false;'
            //                                    )
            //                                ),
            //                            )
            //                        ),
            //                    ),
            //                ));
            //                echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), array('style'=>'display:none','id' => 'reseter', 'class' => 'btn btn-default', 'type'=>'reset'));
            ?>
            <!--</div>-->
            <?php
            //			echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
            //                Yii::app()->createUrl($this->module->id.'/pembayaranJasa/create'), 
            //                array('class' => 'btn btn-default',
            //                      'onclick'=>'return refreshForm(this);'));
            ?>
            <?php // echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"printKasir($('#FAPendaftaranT_pendaftaran_id').val());return false",'disabled'=>false)); 
            ?>
            <?php
            $tips = array(
                '0' => 'simpan',
                '1' => 'ulang',
                '2' => 'print',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php //echo $form->labelEx($modPengUmum,'jenispengeluaran_id', array('class'=>'control-label')) 
?>
<?php
//                            $this->widget('MyJuiAutoComplete', array(
//                                    'model'=>$modPengUmum,
//                                    'attribute'=>'jenisKodeNama',
//                                    'source'=>'js: function(request, response) {
//                                                   $.ajax({
//                                                       url: "'.Yii::app()->createUrl('billingKasir/ActionAutoComplete/jenisPengeluaran').'",
//                                                       dataType: "json",
//                                                       data: {
//                                                           term: request.term,
//                                                       },
//                                                       success: function (data) {
//                                                               response(data);
//                                                       }
//                                                   })
//                                                }',
//                                     'options'=>array(
//                                           'showAnim'=>'fold',
//                                           'minLength' => 2,
//                                           'focus'=> 'js:function( event, ui ) {
//                                               $(this).val(ui.item.value);
//                                                return false;
//                                            }',
//                                           'select'=>'js:function( event, ui ) {
//                                                $("#GJPengeluaranumumT_jenispengeluaran_id").val(ui.item.jenispengeluaran_id);
//                                                getDataRekeningPengeluaran(ui.item.jenispenerimaan_id);
//                                                return false;
//                                            }',
//                                    ),
//                                    'htmlOptions'=>array('placeholder'=>'Nama Jenis Pengeluaran','class'=>'reqForm', 'readonly'=>true),
//                                    // 'tombolDialog' => array('idDialog' => 'dialogJenisPengeluaran',),
//                            )); 
?>
<?php //echo $form->textFieldRow($modPengUmum,'volume',array('onblur'=>'hitungTotalHarga()','class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
?>
<?php //echo $form->dropDownListRow($modPengUmum,'satuanvol', LookupM::getItems('satuanumum'),array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
?>
<?php //echo $form->textFieldRow($modPengUmum,'namapenandatangan',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100));  
?>
<?php //echo $form->textFieldRow($modPengUmum,'nippenandatangan',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100));  
?>
<?php //echo $form->textFieldRow($modPengUmum,'jabatanpenandatangan',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100));  
?>
<?php //echo $form->dropDownListRow($modPengUmum,'penjamin_id', CHtml::listData($modPengUmum->getPenjaminItems(1), 'penjamin_id', 'penjamin_nama'), array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  
?>
<?php
$urlPrint = $this->createUrl('Print&tandabuktikeluar_id=' . $modBuktiKeluar->tandabuktikeluar_id);
$js = <<< JSCRIPT
function print(caraPrint){
	window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=890px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
<script type="text/javascript">
    var trUraian = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowUraian', array('form' => $form, 'modUraian' => array(0 => $modUraian[0]), 'removeButton' => true), true)); ?>);
    $('.currency').each(function() {
        this.value = formatNumber(this.value)
    });

    function setNoUrut() {
        var cnt = 1;
        $("#tblInputUraian .nourut").each(function() {
            $(this).html(cnt++);
        });
    }

    function simpanPengeluaran(params) {
        if (requiredCheck($("form"))) {
            // var periode = $('#GJPengeluaranumumT_periodegaji').val();
            var namauraian_val = true;
            var uraiantransaksi = '';
            // if (periode == null || periode == '') {
            //	myAlert('Periode Gaji Belum Dipilih!');
            //	$('#GJPengeluaranumumT_periodegaji').focus();
            // } else {
            jenis_simpan = params;
            //    var kosong = "" ;
            //    var dataKosong = $("#input-pengeluaran").find(".reqForm[value="+ kosong +"]");
            //    if(dataKosong.length > 0){
            //        alert('Bagian dengan tanda * harus diisi ');
            //    }else{
            var detail = 0;
            $('#tblInputUraian tbody tr').each(
                function() {
                    detail++;
                }
            );
            if (detail > 0) {
                $('#tblInputUraian tbody tr').each(function() {
                    $(this).find("input[name$='[uraiantransaksi]']").val();
                    uraiantransaksi = $(this).find("input[name$='[uraiantransaksi]']").val();
                    if (uraiantransaksi != '') {
                        namauraian_val = true;
                    } else {
                        namauraian_val = false
                    }
                });
                if ($("#GJPengeluaranumumT_isurainkeluarumum").is(':checked')) {
                    if (namauraian_val) {
                        $('.currency').each(
                            function() {
                                this.value = unformatNumber(this.value)
                            }
                        );
                        $('#akpengeluaran-umum-t-form').submit();
                    } else {
                        myAlert('Nama Uraian tidak boleh Kosong');
                    }
                } else {
                    $('.currency').each(
                        function() {
                            this.value = unformatNumber(this.value)
                        }
                    );
                    $('#akpengeluaran-umum-t-form').submit();
                }
                /*MENGGUNAKAN METHOD POST PHP
                 $.post('<?php // echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/SimpanPengeluaran'); 
                            ?>', {jenis_simpan:jenis_simpan, data:$('#akpengeluaran-umum-t-form').serialize()},
                 function(data){
                 if(data.status == 'ok')
                 {
                 if(data.action == 'insert')
                 {
                 alert("Simpan data berhasil");
                 $("#tblInputUraian").find('tr[class$="child"]').detach();
                 $("#reseter").click();
                 $("#input-pengeluaran").find("input[name$='[nopengeluaran]']").val(data.pesan.nopengeluaran);
                 $("#input-pengeluaran").find("input[name$='[nokaskeluar]']").val(data.pesan.nokaskeluar);
                 $("#tblInputRekening > tbody").find('tr').detach();
                 }else{
                 alert("Update data berhasil");
                 }
                 }
                 }, "json");
                 */
            } else {
                alert('Detail uraian masih kosong');
            }
            // }
        }
        //    }
    }

    function cekInput() {
        var harga = 0;
        var totharga = 0;
        if ($('#GJPengeluaranumumT_isuraintransaksi').is(':checked')) {
            $('#tblInputUraian').find('input[name$="[hargasatuan]"]').each(function() {
                harga = harga + unformatNumber(this.value);
            });
            $('#tblInputUraian').find('input[name$="[totalharga]"]').each(function() {
                totharga = totharga + unformatNumber(this.value);
            });
            //if(harga != unformatNumber($('#GJPengeluaranumumT_hargasatuan').val())){
            //    alert('Harga tidak sesuai');return false;
            //}
            if (totharga != unformatNumber($('#GJPengeluaranumumT_totalharga').val())) {
                alert('Harga Uraian tidak sesuai');
                return false;
            }
        }
        $('.currency').each(function() {
            this.value = unformatNumber(this.value)
        });
        return true;
    }

    function hitungTotalUraian(obj) {
        var volume = unformatNumber($(obj).parents('tr').find('.volume').val());
        var hargasatuan = unformatNumber($(obj).parents('tr').find('.hargasatuan').val());
        var val_hargasatuan = $(obj).parents('tr').find('.val_hargasatuan').val();
        if (hargasatuan > val_hargasatuan) {
            hargasatuan = val_hargasatuan;
            $(obj).parents('tr').find('.hargasatuan').val(formatNumber(hargasatuan));
        }
        $(obj).parents('tr').find('.totalharga').val(formatNumber(volume * hargasatuan));
    }

    function hitungTotalHarga() {
        var biayaAdministrasi = unformatNumber($('#GJTandabuktikeluarT_biayaadministrasi').val());
        var vol = unformatNumber($('#GJPengeluaranumumT_volume').val());
        var harga = unformatNumber($('#GJPengeluaranumumT_hargasatuan').val());
        $('#GJPengeluaranumumT_totalharga').val(formatNumber(vol * harga));
        $('#GJTandabuktikeluarT_jmlkaskeluar').val(formatNumber(vol * harga + biayaAdministrasi));
    }

    function totalHarga() {
        var totalharga = 0;
        var val_pph21 = 0;
        $('#tblInputUraian tr').each(function() {
            totalharga += unformatNumber($(this).find('.totalharga').val());
            val_pph21 += unformatNumber($(this).find('.val_pph21').val());
        });
        $('#GJTandabuktikeluarT_jmlkaskeluar, #jmlgaji').val(formatNumber(totalharga));
        $('.saldodebit').val(formatNumber(totalharga));
        $('.saldokredit').val(formatNumber(totalharga));
        $('.saldodebitpph21').val(formatNumber(val_pph21));
        $('.saldokreditpph21').val(formatNumber(val_pph21));
    }

    function hitungJmlBayar() {
        var biayaAdministrasi = unformatNumber($('#GJTandabuktikeluarT_biayaadministrasi').val());
        var totBayar = 0;
        var totHarga = unformatNumber($('#total_uraian').val());
        totBayar = totHarga + biayaAdministrasi;
        $('#GJTandabuktikeluarT_jmlkaskeluar').val(formatNumber(totBayar));
    }

    function bukaUraian(obj) {
        if ($(obj).is(':checked')) {
            $('#div_tblInputUraian').slideDown();
        } else {
            $('#div_tblInputUraian').slideUp();
        }
    }

    function bukaUraianTips(obj) {
        if ($(obj).is(':checked')) {
            $('#div_tips').slideDown();
        } else {
            $('#div_tips').slideUp();
        }
    }
    /*
     function bukaUraian(obj)
     {
     if($(obj).is(':checked')){
     $('#tblInputUraian').children('tbody').slideDown();
     } else {
     $('#tblInputUraian').children('tbody').slideUp();
     }
     }
     */
    function addRowUraian(obj) {
        $(obj).parents('table').children('tbody').append(trUraian.replace());
        renameInput('GJUraiankeluarumumT', 'uraiantransaksi');
        renameInput('GJUraiankeluarumumT', 'penggajianpeg_id');
        renameInput('GJUraiankeluarumumT', 'volume');
        renameInput('GJUraiankeluarumumT', 'satuanvol');
        renameInput('GJUraiankeluarumumT', 'hargasatuan');
        renameInput('GJUraiankeluarumumT', 'val_hargasatuan');
        renameInput('GJUraiankeluarumumT', 'totalharga');
        renameInput('GJUraiankeluarumumT', 'thr_thrbersih');
        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({
            "placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"
        });
        maskMoneyInput($('#tblInputUraian > tbody > tr:last'));
        setNoUrut();
    }

    function renameRowRekening() {
        var idx = 0;
        $("#tblInputRekening > tbody").find('tr').each(
            function() {
                unMaskMoneyInput(this);
                maskMoneyInput(this);
                $(this).find('input').each(
                    function() {
                        /*
                         if($(this).find('class^="currency"'))
                         {
                         this.value = formatNumber(this.value)
                         }
                         */
                        var name_field = $(this).attr('name');
                        var id_field = $(this).attr('id');
                        $(this).attr('name', name_field.replace('99', idx));
                        $(this).attr('id', id_field.replace('99', idx));
                    }
                );
                idx++;
            }
        );
    }

    function batalUraian(obj) {
        if (confirm('Apakah Anda yakin akan membatalkan Uraian?')) {
            // $(obj).parents('tr').next('tr').detach();
            $(obj).parents('tr').detach();
            renameInput('GJUraiankeluarumumT', 'uraiantransaksi');
            renameInput('GJUraiankeluarumumT', 'penggajianpeg_id');
            renameInput('GJUraiankeluarumumT', 'volume');
            renameInput('GJUraiankeluarumumT', 'satuanvol');
            renameInput('GJUraiankeluarumumT', 'hargasatuan');
            renameInput('GJUraiankeluarumumT', 'val_hargasatuan');
            renameInput('GJUraiankeluarumumT', 'totalharga');
            setNoUrut();
            hitungSaldoRekeningJurnal();
        }
    }

    function hitungSaldoRekeningJurnal() {
        var bersih = 0;
        var thr = 0;
        $("#tblInputUraian tbody tr").each(function() {
            bersih += parseFloat($(this).find(".val_hargasatuan").val());
            thr += parseFloat($(this).find(".thr_thrbersih").val());
        });
        $('#tblInputRekening .saldodebit').val(0);
        $('#tblInputRekening .saldokredit').val(0);
        $('#tblInputRekening tr[data-id="0"] .saldodebit').val(formatNumber(bersih - thr));
        $('#tblInputRekening tr[data-id="1"] .saldokredit').val(formatNumber(thr));
        $('#tblInputRekening tr[data-id="2"] .saldokredit').val(formatNumber(bersih));
    }

    function renameInput(modelName, attributeName) {
        var trLength = $('#tblInputUraian tr').length;
        var i = -1;
        var total = 0;
        var j = 0;
        $('#tblInputUraian tr').each(function() {
            if ($(this).has('input[name$="[uraiantransaksi]"]').length) {
                i++;
            }
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            if (attributeName == 'totalharga') {
                var totalharga = unformatNumber($('#' + modelName + '_' + i + '_totalharga').val());
                if (totalharga == 'undefined' || totalharga == null || totalharga == '') {
                    totalharga = 0;
                }
                if (i != j) {
                    total += parseFloat(totalharga);
                }
                j = i;
            }
        });
        if (attributeName == 'totalharga') {
            $('#total_uraian').val(formatNumber(total));
            $('#GJTandabuktikeluarT_jmlkaskeluar').val(formatNumber(total));
            // $('#RekeningakuntansiV_0_saldokredit').val(formatNumber(total));
            // $('#RekeningakuntansiV_1_saldokredit').val(total);
        }
        // alert(total);
    }

    function formCarabayar(carabayar) {
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'namapenerima') ?>").val('');
        if (carabayar == 'TRANSFER') {
            $('.labelpenerima').html('Bank Penerima');
            $('.namapenerimaInput').hide();
            $('.namapenerima').removeClass('required');
            $('#divCaraBayarTransfer').show();
        } else {
            $('.namapenerima').addClass('required');
            $('.namapenerimaInput').show();
            $('.labelpenerima').html('Penerima');
            $('#divCaraBayarTransfer').hide();
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id') ?>").val('');
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'melalubank') ?>").val('');
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening') ?>").val('');
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'atasnamarekening') ?>").val('');
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'nobukti_transfer') ?>").val('');
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'norekpenerima') ?>").val('');
        }
    }

    function unMaskMoneyInput(tr) {
        $(tr).find('input.currency:text').unmaskMoney();
    }

    function maskMoneyInput(tr) {
        $(tr).find('.integer2').maskMoney({
            "defaultZero": true,
            "allowZero": true,
            "decimal": ",",
            "thousands": ".",
            "precision": 0
        });
    }

    function ambilDataGaji() {
        var periode = $(".periode_gaji").val();
        var kategori = $("#form_kategori").val();
        if (periode != '' && kategori != '') {
            $.post('<?php echo $this->createUrl('ambilDataGaji'); ?>', {
                periode: periode,
                kategori: kategori
            }, function(data) {
                $("#tblInputUraian > tbody").empty();
                if (data != null) {
                    $("#tblInputUraian > tbody").append(data.replace());
                    $("#tblInputUraian > tbody tr").each(function() {
                        maskMoneyInput($(this));
                    });
                    setNoUrut();
                } else {
                    $('#GJTandabuktikeluarT_jmlkaskeluar, #jmlgaji').val(0);
                    $('.saldodebit').val(0);
                    $('.saldokredit').val(0);
                    $('.saldodebitpph21').val(0);
                    $('.saldokreditpph21').val(0);
                }
                // $('#tabledetailpinjaman').find('tbody').empty();
                totalHarga();
                ambilRekeningGaji();
                $('#GJTandabuktikeluarT_untukpembayaran').val('Pembayaran Gaji ' + kategori + " Periode " + periode);
            }, 'json');
        } else {
            myAlert("Periode Gaji dan Kategori Pegawai Asal Harus Terisi!!!");
        }
        // tampilRekening();
    }

    function ambilRekeningGaji() {
        $("#tblInputRekening tbody").empty();
        var periode = $(".periode_gaji").val();
        var kategori = $("#form_kategori").val();
        var carabayarkeluar = $("#<?php echo CHtml::activeId($modBuktiKeluar, 'carabayarkeluar'); ?>").val();
        var bankid = "";
        if ($("#<?php echo CHtml::activeId($modBuktiKeluar, 'carabayarkeluar'); ?>").val() === 'TRANSFER') {
            bankid = $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id'); ?>").val();
        }
        $.post('<?php echo $this->createUrl('ambilRekeningGaji'); ?>', {
            periode: periode,
            kategori: kategori,
            carabayarkeluar: carabayarkeluar,
            bankid: bankid
        }, function(data) {
            $("#tblInputRekening tbody").append(data);
        }, 'json');
    }

    function tampilRekening() {
        var periode = $(".periode_tahun").val() + "-" + $('.periode_bulan').val();
        $.post('<?php echo $this->createUrl('tampilRekening'); ?>', {
            periode: periode
        }, function(data) {
            $("#tblInputRekening > tbody").empty();
            $("#tblInputRekening > tbody").append(data.replace());
            // maskMoneyAll();
        }, 'json');
    }

    function getDataRekeningManual() {
        var params = <?php echo Params::DEFAULT_BAYARGAJIPEGAWAI_ID; ?>;
        //		$("#tblInputRekening > tbody").find('tr').detach();
        $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/GetDataRekeningManual'); ?>', {
                jenispengeluaran_id: params
            },
            function(data) {
                if (data != null) {
                    //				$("#tblInputRekening > tbody").append(data.replace());
                    $("#tblInputRekening > tbody").append(data);
                    renameRowRekening();
                    //				hitungTotalHarga();
                    totalHarga();
                }
            }, "json");
    }

    function getDataRekening() {
        var params = <?php echo Params::DEFAULT_BAYARGAJIPEGAWAI_ID; ?>;
        $("#tblInputRekening > tbody").find('tr').detach();
        $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/GetDataRekeningByJnsPengeluaran'); ?>', {
                jenispengeluaran_id: params
            },
            function(data) {
                if (data != null) {
                    $("#tblInputRekening > tbody").append(data.replace());
                    getDataRekeningManual();
                    renameRowRekening();
                    //				hitungTotalHarga();
                    totalHarga();
                }
            }, "json");
    }

    function setNamaBank(obj) {
        var bank = $(obj).val();
        if (bank !== '') {
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('GetMasterBank'); ?>',
                data: {
                    bank_id: bank
                },
                dataType: "json",
                success: function(data) {
                    $("#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening') ?>").val(data.norekening);
                    //                $("#<?php // echo CHtml::activeId($modBuktiKeluar, 'melalubank') 
                                            ?>").val(data.namabank);
                    $("#<?php echo CHtml::activeId($modBuktiKeluar, 'atasnamarekening') ?>").val(data.namabank);
                    ambilRekeningGaji();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    myAlert("Data Setoran Utang Pajak tidak ditemukan!");
                }
            });
        } else {
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening') ?>").val('');
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'atasnamarekening') ?>").val('');
        }
    }
    $("document").ready(function() {
        $("#tblInputUraian > tbody").empty();
        //        ambilDataGaji();
        //        getDataRekening();
        formCarabayar($('#<?php echo CHtml::activeId($modBuktiKeluar, 'carabayarkeluar'); ?>').val());
    });
</script>
<?php
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogJenisPengeluaran',
    'options' => array(
        'title' => 'Daftar Jenis Pengeluaran',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 400,
        'resizable' => false,
    ),
));
$modJenisPengeluaran = new JenispengeluaranM('search');
$modJenisPengeluaran->unsetAttributes();
if (isset($_GET['JenispengeluaranM'])) {
    $modJenisPengeluaran->attributes = $_GET['JenispengeluaranM'];
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'jenispengeluaran-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modJenisPengeluaran->searchJnsPengeluaranInRek(),
    'filter' => $modJenisPengeluaran,
    'template' => "{pager}{summary}\n{items}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
        ),
        array(
            'header' => 'Jenis Pengeluaran',
            'name' => 'jenispengeluaran_nama',
            'value' => '$data->jenispengeluaran_nama',
        ),
        array(
            'header' => 'Nama Lain',
            'name' => 'jenispengeluaran_namalain',
            'value' => '$data->jenispengeluaran_namalain',
        ),
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectRekDebit",
                                    "onClick" =>"
                                        getDataRekeningPengeluaranGaji($data->jenispengeluaran_id);
                                        $(\"#GJPengeluaranumumT_jenispengeluaran_id\").val(\"$data->jenispengeluaran_id\");
                                        $(\"#GJPengeluaranumumT_jenisKodeNama\").val(\"$data->jenispengeluaran_nama\");
                                        $(\"#dialogJenisPengeluaran\").dialog(\"close\");    
                                        return false;
                            "))',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Rek Kredit dialog =============================
?>