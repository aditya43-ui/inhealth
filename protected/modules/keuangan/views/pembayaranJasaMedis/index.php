<?php
$this->breadcrumbs = array(
    'Transaksi Pembayaran Jasa Dokter',
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
<div id="input-pengeluaran" class="">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-gradient">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pembayaran Jasa Dokter</b>
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
                        Yii::app()->user->setFlash('success', "Data pembayaran jasa medis berhasil disimpan!");
                    }
                    ?>
                    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                                ?></p>-->
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="control-group">
                                <?php echo $form->labelEx($modPengUmum, 'Periode Jasa <span class="required">*</span>', array('class' => 'control-label')); ?>
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
                                <?php echo Chtml::label("Dokter", 'pegawai_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->hiddenField($modPengUmum, 'pegawai_id', array('readonly' => true)); ?>
                                    <?php
                                    $this->widget('MyJuiAutoComplete', array(
                                        'model' => $modPengUmum,
                                        'attribute' => 'pegawai_nama',
                                        'source' => 'js: function(request, response) {
						$.ajax({
							url: "' . $this->createUrl('AutocompleteDokterPegawai') . '",
							dataType: "json",
							data: {
								term: request.term,
							},
							success: function (data) {
								response(data);
							}
						})
					}',
                                        'options' => array(
                                            'showAnim' => 'fold',
                                            'minLength' => 3,
                                            'focus' => 'js:function( event, ui ) {
							$(this).val( ui.item.label);
							return false;
						}',
                                            'select' => 'js:function( event, ui ) {
							$("#' . Chtml::activeId($modPengUmum, 'pegawai_id') . '").val(ui.item.pegawai_id); 
							ambilDataGaji();
                                                        return false;
						}',
                                        ),
                                        'htmlOptions' => array(
                                            'placeholder' => 'Nama Dokter',
                                            'class' => 'span3 pegawai_nama  hurufs-only',
                                            'onkeyup' => "return $(this).focusNextInputField(event)",
                                            'onblur' => 'if(this.value === "") $("#' . CHtml::activeId($modPengUmum, 'pegawai_id') . '").val(""); '
                                        ),
                                        'tombolDialog' => array('idDialog' => 'dialogPegawaiDokter'),
                                    ));
                                    ?>
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
                                            'class' => 'span3 dtPicker2-5 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                        ),
                                    ));
                                    ?>

                                </div>
                            </div>
                            <?php echo $form->textFieldRow($modPengUmum, 'nopengeluaran', array('readonly' => true, 'class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                            <?php echo $form->dropDownListRow($modPengUmum, 'kelompoktransaksi', LookupM::getItems('kelompoktransaksi'), array('class' => 'span2 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        </div>
                        <div class="col-sm-6">
                            <?php echo $form->hiddenField($modPengUmum, 'jenispengeluaran_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <div class="control-group">
                                <?php echo $form->hiddenField($modPengUmum, 'volume', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->hiddenField($modPengUmum, 'volume', array('onblur' => 'hitungTotalHarga()', 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    <?php // echo $form->hiddenField($modPengUmum,'satuanvol', LookupM::getItems('satuanumum'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50));  
                                    ?>
                                </div>
                            </div>
                            <?php echo $form->hiddenField($modPengUmum, 'hargasatuan', array('onblur' => 'hitungTotalHarga()', 'class' => 'inputFormTabel currency reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($modPengUmum, 'totalharga', array('readonly' => true, 'class' => 'inputFormTabel currency', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->textAreaRow($modPengUmum, 'keterangankeluar', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <div class="control-group">
                                <?php echo CHtml::label('Jumlah Jasa', 'jmlgaji', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::TextField('jmlgaji', number_format($modPengUmum->jmlgaji), array('readonly' => true, 'class' => 'integer2 span2',)); ?>
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
                                                    'class' => 'span3 dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                                ),
                                            ));
                                            ?>

                                        </div>
                                    </div>
                                    <?php // echo $form->dropDownListRow($modBuktiKeluar,'tahun', Params::tahun(),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>4));  
                                    ?>
                                    <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                                    <?php echo $form->textFieldRow($modBuktiKeluar, 'nokaskeluar', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true)); ?>
                                    <?php echo $form->hiddenField($modBuktiKeluar, 'biayaadministrasi', array('onkeyup' => 'hitungJmlBayar();', 'class' => 'inputFormTabel currency span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    <?php echo $form->textFieldRow($modBuktiKeluar, 'jmlkaskeluar', array('readonly' => true, 'class' => 'span2 inputFormTabel integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    <?php echo $form->dropDownListRow($modBuktiKeluar, 'carabayarkeluar', LookupM::getItems('carabayarkeluar'), array('onchange' => 'formCarabayar(this.value)', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>

                                    <!--								</div>
								<div class="col-sm-6">-->

                                    <div id="divCaraBayarTransfer">
                                        <div class="control-group">
                                            <?php echo CHtml::label("Nama Bank Pengirim", 'bank_id', array('class' => 'control-label')); ?>
                                            <div class="controls">
                                                <?php
                                                $modBank = BankM::getItems($modBuktiKeluar->bank_id);
                                                echo $form->dropDownList($modBuktiKeluar, 'bank_id', CHtml::listData($modBank, 'bank_id', 'namabank'), array(
                                                    'class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => 'setNamaBank(this);',
                                                    'onkeyup' => "return $(this).focusNextInputField(event);"
                                                ));
                                                ?>
                                            </div>
                                        </div>
                                        <?php echo CHtml::activeHiddenField($modBuktiKeluar, 'melalubank', array('readonly' => true, 'class' => 'span3')); ?>
                                        <?php echo $form->textFieldRow($modBuktiKeluar, 'denganrekening', array(
                                            'class' => 'span3',
                                            'placeholder' => 'Dengan Rekening',
                                            'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100
                                        )); ?>
                                        <?php echo $form->textFieldRow($modBuktiKeluar, 'atasnamarekening', array(
                                            'class' => 'span3',
                                            'placeholder' => 'Atas Nama Rekening',
                                            'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100
                                        )); ?>
                                    </div>
                                    <div class="control-group">
                                        <?php echo CHtml::label("Nama Bank", 'namapenerima', array('class' => 'control-label namapenerima')) ?>
                                        <div class="controls">
                                            <?php echo $form->textField($modBuktiKeluar, 'namapenerima', array('placeholder' => 'Nama Bank', 'class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <?php echo CHtml::label("Alamat Bank", 'alamatpenerima', array('class' => 'control-label alamatpenerima')) ?>
                                        <div class="controls">
                                            <?php echo $form->textArea($modBuktiKeluar, 'alamatpenerima', array('placeholder' => 'Alamat Bank', 'class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <?php echo CHtml::label("Sebagai Pembayaran <span class='required'>*</span>", 'untukpembayaran', array('class' => 'control-label required')) ?>
                                        <div class="controls">
                                            <?php echo $form->textField($modBuktiKeluar, 'untukpembayaran', array('placeholder' => 'Sebagai Pembayaran', 'class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                        </div>
                                    </div>
                                    <?php // echo $form->textFieldRow($modBuktiKeluar, 'namapenerima', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
                                    ?>
                                    <?php // echo $form->textAreaRow($modBuktiKeluar, 'alamatpenerima', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);")); 
                                    ?>
                                    <?php // echo $form->textFieldRow($modBuktiKeluar, 'untukpembayaran', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
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
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'simpanPengeluaran(\'jurnal\');return false;', 'onKeypress' => 'return simpanPengeluaran(\'jurnal\');'));
                            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);'));
                            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
                        } else {
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);'));
                            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onClick' => 'print("PRINT")'));
                        }
                        //                $this->widget('bootstrap.widgets.BootButtonGroup', array(
                        //                    'type'=>'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
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
                        $content = $this->renderPartial('penggajian.views/tips/transaksi_penggajianpegawai', array(), true);
                        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

                        ?>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
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
    <?php //echo $form->dropDownListRow($modPengUmum,'satuanvol', LookupM::getItems('satuanumum'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
    ?>
    <?php //echo $form->textFieldRow($modPengUmum,'namapenandatangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100));  
    ?>
    <?php //echo $form->textFieldRow($modPengUmum,'nippenandatangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100));  
    ?>
    <?php //echo $form->textFieldRow($modPengUmum,'jabatanpenandatangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100));  
    ?>
    <?php //echo $form->dropDownListRow($modPengUmum,'penjamin_id', CHtml::listData($modPengUmum->getPenjaminItems(1), 'penjamin_id', 'penjamin_nama'), array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  
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
</div>
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
                if ($("#<?php echo CHtml::activeId($modPengUmum, 'isurainkeluarumum'); ?>").is(':checked')) {
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
        if ($('#<?php echo CHtml::activeId($modPengUmum, 'isuraintransaksi'); ?>').is(':checked')) {
            $('#tblInputUraian').find('input[name$="[hargasatuan]"]').each(function() {
                harga = harga + unformatNumber(this.value);
            });
            $('#tblInputUraian').find('input[name$="[totalharga]"]').each(function() {
                totharga = totharga + unformatNumber(this.value);
            });

            //if(harga != unformatNumber($('#GJPengeluaranumumT_hargasatuan').val())){
            //    alert('Harga tidak sesuai');return false;
            //}
            if (totharga != unformatNumber($('#<?php echo CHtml::activeId($modPengUmum, 'totalharga'); ?>').val())) {
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
        var biayaAdministrasi = unformatNumber($('#<?php echo CHtml::activeId($modBuktiKeluar, 'biayaadministrasi'); ?>').val());
        var vol = unformatNumber($('#<?php echo CHtml::activeId($modPengUmum, 'volume'); ?>').val());
        var harga = unformatNumber($('#<?php echo CHtml::activeId($modPengUmum, 'hargasatuan'); ?>').val());

        $('#<?php echo CHtml::activeId($modPengUmum, 'totalharga'); ?>').val(formatNumber(vol * harga));
        $('#<?php echo CHtml::activeId($modBuktiKeluar, 'jmlkaskeluar'); ?>').val(formatNumber(vol * harga + biayaAdministrasi));
    }

    function totalHarga() {
        var totalharga = 0;
        var val_pph21 = 0;
        $('#tblInputUraian tr').each(function() {
            totalharga += unformatNumber($(this).find('.totalharga').val());
            val_pph21 += unformatNumber($(this).find('.val_pph21').val());
        });

        $('#<?php echo CHtml::activeId($modBuktiKeluar, 'jmlkaskeluar'); ?>, #jmlgaji').val(formatNumber(totalharga));
        $('.saldodebit').val(formatNumber(totalharga));
        $('.saldokredit').val(formatNumber(totalharga));
        $('.saldodebitpph21').val(formatNumber(val_pph21));
        $('.saldokreditpph21').val(formatNumber(val_pph21));
    }

    function hitungJmlBayar() {

        var biayaAdministrasi = unformatNumber($('#<?php echo CHtml::activeId($modBuktiKeluar, 'biayaadministrasi'); ?>').val());
        var totBayar = 0;
        var totHarga = unformatNumber($('#total_uraian').val());

        totBayar = totHarga + biayaAdministrasi;

        $('#<?php echo CHtml::activeId($modBuktiKeluar, 'jmlkaskeluar'); ?>').val(formatNumber(totBayar));
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

        renameInput('KUUraiankeluarumumT', 'uraiantransaksi');
        renameInput('KUUraiankeluarumumT', 'pembayaranjasa_id');
        renameInput('KUUraiankeluarumumT', 'volume');
        renameInput('KUUraiankeluarumumT', 'satuanvol');
        renameInput('KUUraiankeluarumumT', 'hargasatuan');
        renameInput('KUUraiankeluarumumT', 'val_hargasatuan');
        renameInput('KUUraiankeluarumumT', 'totalharga');
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

            renameInput('KUUraiankeluarumumT', 'uraiantransaksi');
            renameInput('KUUraiankeluarumumT', 'pembayaranjasa_id');
            renameInput('KUUraiankeluarumumT', 'volume');
            renameInput('KUUraiankeluarumumT', 'satuanvol');
            renameInput('KUUraiankeluarumumT', 'hargasatuan');
            renameInput('KUUraiankeluarumumT', 'val_hargasatuan');
            renameInput('KUUraiankeluarumumT', 'totalharga');

        }
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
            $('#<?php echo CHtml::activeId($modBuktiKeluar, 'jmlkaskeluar'); ?>').val(formatNumber(total));
            $('#RekeningakuntansiV_0_saldokredit').val(formatNumber(total));
            // $('#RekeningakuntansiV_1_saldokredit').val(total);
        }
        // alert(total);
    }

    function formCarabayar(carabayar) {
        if (carabayar == 'TRANSFER') {
            $('#divCaraBayarTransfer').show();
        } else {
            $('#divCaraBayarTransfer').hide();
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id') ?>").val('');
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'melalubank') ?>").val('');
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening') ?>").val('');
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'atasnamarekening') ?>").val('');
            getDataRekening();
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
        var pegawai_id = $("#<?php echo CHtml::activeId($modPengUmum, 'pegawai_id'); ?>").val();

        $("#tblInputUraian > tbody").html("");
        $("#tblInputRekening > tbody").html("");

        $.post('<?php echo $this->createUrl('ambilDataGaji'); ?>', {
            periode: periode,
            pegawai_id: pegawai_id
        }, function(data) {
            if (data != null) {
                $("#tblInputUraian > tbody").append(data.replace());

                $("#tblInputUraian > tbody tr").each(function() {
                    maskMoneyInput($(this));
                });
                setNoUrut();
                totalHarga();
                getDataRekening();
            }

        }, 'json');

        $('#<?php echo CHtml::activeId($modBuktiKeluar, 'untukpembayaran'); ?>').val('Jasa Dokter ' + periode);
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
        var params = <?php echo Params::JENISPENGELUARAN_ID_PEMBAYARANJASA; ?>;
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
        var jmlKasKeluar = unformatNumber($('#<?php echo CHtml::activeId($modBuktiKeluar, 'jmlkaskeluar'); ?>').val());
        var carabayarkeluar = $("#<?php echo CHtml::activeId($modBuktiKeluar, 'carabayarkeluar'); ?>").val();

        var bankid = "";
        if ($("#<?php echo CHtml::activeId($modBuktiKeluar, 'carabayarkeluar'); ?>").val() === 'TRANSFER') {
            bankid = $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id'); ?>").val();
        }

        $("#tblInputRekening > tbody").html("");
        $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/GetDataRekeningByJnsPengeluaran'); ?>', {
                jmlkaskeluar: jmlKasKeluar,
                carabayarkeluar: carabayarkeluar,
                bankid: bankid
            },
            function(data) {
                if (data != null) {
                    $("#tblInputRekening > tbody").append(data.replace());
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
                    $("#<?php echo CHtml::activeId($modBuktiKeluar, 'melalubank') ?>").val(data.namabank);
                    $("#<?php echo CHtml::activeId($modBuktiKeluar, 'atasnamarekening') ?>").val(data.namabank);
                    getDataRekening();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    myAlert("Data Setoran Utang Pajak tidak ditemukan!");
                }
            });
        }
    }

    $("document").ready(function() {
        ambilDataGaji();
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
                                        $(\"#KUPengeluaranumumT_jenispengeluaran_id\").val(\"$data->jenispengeluaran_id\");
                                        $(\"#KUPengeluaranumumT_jenisKodeNama\").val(\"$data->jenispengeluaran_nama\");
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

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiDokter',
    'options' => array(
        'title' => 'Pencarian Dokter',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawaiDokter = new DokterpegawaiV('searchByDokter');

$modPegawaiDokter->unsetAttributes();
//$modPegawaiDokter->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['DokterpegawaiV'])) {
    $modPegawaiDokter->attributes = $_GET['DokterpegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaidokterdialog-grid',
    'dataProvider' => $modPegawaiDokter->searchByDokter(),
    'filter' => $modPegawaiDokter,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($modPengUmum, 'pegawai_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($modPengUmum, 'pegawai_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiDokter\").dialog(\"close\"); 
                                                  ambilDataGaji();
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => Chtml::activeTextField($modPegawaiDokter, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ), /*
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ), */
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => Chtml::activeTextField($modPegawaiDokter, 'nama_pegawai', array('class' => 'hurufs-only'))
        ), /*
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ), */
        /*  array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),*/
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            },
            'filter' => Chtml::activeDropDownList($modPegawaiDokter, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function(){setNumbersOnly(this);});'
        . '$(".hurufs-only").keyup(function(){setHurufsOnly(this);});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>