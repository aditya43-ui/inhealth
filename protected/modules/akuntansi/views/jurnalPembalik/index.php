<style>
    .integerFloat {
        text-align: right;
    }
</style>
<?php
$this->breadcrumbs = array(
    'Jurnal Pembalik',
);

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id;

$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="row" id="inputJurnalUmum">
    <div class='divForForm'>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    </div>
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Jurnal <b>Pembalik</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
                Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js');

                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'form-jurnal-pembalik',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array(
                        'onKeyPress' => 'return disableKeyPress(event)',
                        'onSubmit' => 'return requiredCheck(this);'
                    ),
                    'focus' => '#',
                ));
                $this->widget('bootstrap.widgets.BootAlert');
                ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Data <b>Jurnal</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $form->hiddenField($model, "jurnalrekening_id"); ?>
                        <div class="col-sm-6">
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'jenisjurnal_id', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->hiddenField($model, "jenisjurnal_id"); ?>
                                    <?php echo $form->textField($model, 'jenisjurnal_nama', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                                </div>
                            </div>
                            <?php // echo $form->dropDownListRow($model, 'jenisjurnal_id', JenisjurnalM::items(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'reqForm span3')); 
                            ?>
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'tglbuktijurnal', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    $model->tglbuktijurnal = MyFormatter::formatDateTimeForUser($model->tglbuktijurnal);
                                    $model->tglreferensi = MyFormatter::formatDateTimeForUser($model->tglreferensi);
                                    echo $form->textField($model, 'tglbuktijurnal', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true));
                                    //                                        $this->widget('MyDateTimePicker', array(
                                    //                                            'model' => $model,
                                    //                                            'attribute' => 'tglbuktijurnal',
                                    //                                            'mode' => 'datetime',
                                    //                                            'options' => array(
                                    //                                                'dateFormat' => Params::DATE_FORMAT,
                                    //                                                'maxDate' => 'd',
                                    //                                            ),
                                    //                                            'htmlOptions' => array(
                                    //                                                'class' => 'reqForm span4', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    //                                            ),
                                    //                                        ));
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'tglreferensi', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    echo $form->textField($model, 'tglreferensi', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true));
                                    //                                            $this->widget('MyDateTimePicker', array(
                                    //                                                'model' => $model,
                                    //                                                'attribute' => 'tglreferensi',
                                    //                                                'mode' => 'datetime',
                                    //                                                'options' => array(
                                    //                                                    'dateFormat' => Params::DATE_FORMAT,
                                    //                                                    'maxDate' => 'd',
                                    //                                                ),
                                    //                                                'htmlOptions' => array(
                                    //                                                    'class' => 'reqForm span4', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    //                                                ),
                                    //                                            ));
                                    ?>
                                </div>
                            </div>
                            <?php echo $form->textFieldRow($model, 'nobuktijurnal', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => true)); ?>
                            <?php echo $form->textFieldRow($model, 'kodejurnal', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => true)); ?>

                        </div>
                        <div class="col-sm-6">
                            <?php
                            if (!empty($model->rekperiod_id)) {
                                echo $form->hiddenField(
                                    $model,
                                    'rekperiod_id',
                                    array(
                                        'class' => 'span1',
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'readonly' => false
                                    )
                                );
                            }
                            //                    echo $form->dropDownListRow($model,'rekperiod_id', RekperiodM::items(),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'reqForm'));
                            ?>
                            <?php echo $form->textFieldRow($model, 'noreferensi', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => true)); ?>
                            <?php // echo $form->textFieldRow($model, 'nobku', array('class' => 'span3  numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => false)); 
                            ?>
                            <?php echo $form->textAreaRow($model, 'urianjurnal', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => false)); ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Detail <b>Jurnal</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <div class="col-sm-6">
                            <!--<div class="control-group">
                                        <label class="control-label">Pilih Rekening</label>
                                        <div class="controls">
                                        <?php
                                        //                                            echo CHtml::dropDownList('isJenisRekenig', "", LookupM::getItems('jenis_rekening'), array(
                                        //                                                'empty' => '-- Pilih --',
                                        //                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                        //                                                'onchange' => 'setSaldoNormal(this)',
                                        //                                                'class' => 'span2',
                                        //                                            ));
                                        ?>
                                        </div>
                                    </div>-->
                        </div>
                        <div class="col-sm-6">
                            <?php
                            //                                        $this->widget('MyJuiAutoComplete', array(
                            //                                            'model' => $model,
                            //                                            'attribute' => 'rekening_nama',
                            //                                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
                            //                                            'options' => array(
                            //                                                'showAnim' => 'fold',
                            //                                                'minLength' => 2,
                            //                                                'focus' => 'js:function( event, ui ){return false;}',
                            //                                                'select' => 'js:function( event, ui ){
                            //                                                    getDataRekening(ui.item.rekening1_id,ui.item.rekening2_id,ui.item.rekening3_id,ui.item.rekening4_id,ui.item.rekening5_id);
                            //                                                    return false;
                            //                                                }'
                            //                                            ),
                            //                                            'htmlOptions' => array(
                            //                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                            //                                                'placeholder' => 'Pilih rekening yang akan dijurnal',
                            //                                                'class' => 'span2',
                            //                                            ),
                            //                                            'tombolDialog' => array('idDialog' => 'dialogRincianRek',),
                            //                                        ));
                            ?>
                        </div>
                        <?php echo $this->renderPartial('__gridDetailJurnal', array('modelDetail' => $modelDetail, 'form' => $form)); ?>
                    </div>
                </div>
                <div class="form-actions">
                    <?php
                    $disabled = (isset($_GET['sukses']) ? true : false);
                    ?>
                    <?php echo CHtml::htmlButton(
                        isset($_GET['sukses']) ? Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')) :
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                        array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disabled)
                    ); ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        $this->createUrl($this->module->id . '/Index'),
                        array(
                            'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('Index') . '";} ); return false;'
                        )
                    ); ?>
                    <?php
                    //		if(isset($_GET['sukses'])){
                    //			echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')",'disabled'=>false));
                    //		}else{
                    //			echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>true));
                    //		}
                    ?>
                    <?php
                    //                        $this->widget('bootstrap.widgets.BootButtonGroup', array(
                    //                            'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    //                            'buttons' => array(
                    //                                array(
                    //                                    'label' => 'Jurnal',
                    //                                    'icon' => 'icon-download icon-white',
                    //                                    'url' => '#',
                    //                                    'htmlOptions' => array(
                    //                                        'onclick' => 'simpanJurnalUmum(\'jurnal\');return false;',
                    //                                        'id'=>'btn_submit_jurnal',
                    //                                        'class'=>'btn_group_submit',
                    //                                    )
                    //                                ),
                    //                                array(
                    //                                    'label' => '',
                    //                                    'items' => array(
                    //                                        array(
                    //                                            'label' => 'Posting',
                    //                                            'icon' => 'icon-download',
                    //                                            'url' => '#',
                    //                                            'itemOptions' => array(
                    //                                                'onclick' => 'simpanJurnalUmum(\'posting\');return false;',
                    //                                                'id'=>'btn_posting_jurnal',
                    //                                            )
                    //                                        ),
                    //                                    ),
                    //                                    'htmlOptions' => array(
                    //                                        'id'=>'btn_submit_detail',
                    //                                        'class'=>'btn_group_submit',
                    //                                    ),
                    //                                ),
                    //                            )
                    //                        ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/div-->
<?php $this->endWidget(); ?>

<?php
//$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
//	'id' => 'dialogRincianRek',
//	'options' => array(
//		'title' => 'Saldo Rekening',
//		'autoOpen' => false,
//		'modal' => true,
//		'width' => 700,
//		'height' => 450,
//		'resizable' => false,
//	),
//));
//
//$modRekDebit = new RekeningakuntansiV('searchAccounts');
//$modRekDebit->unsetAttributes();
//// $modRekDebit->rekening5_nb = $account;
//$modRekDebit->rekening5_aktif = true;
//if(isset($_GET['RekeningakuntansiV'])) {
//    $modRekDebit->attributes = $_GET['RekeningakuntansiV'];
//	// $modRekDebit->rekening5_nb = $account;
//}
//
//$c2 = new CDbCriteria();
//$c3 = new CDbCriteria();
//$c4 = new CDbCriteria();
//
//
//$c2->compare('rekening1_id', $modRekDebit->rekening1_id);
//$c2->addCondition('rekening2_aktif = true');
//$c2->order = 'kdrekening2';
//
//$r2 = Rekening2M::model()->findAll($c2);
//
//$c3->compare('rekening2_id', $modRekDebit->rekening2_id);
//$c3->addCondition('rekening3_aktif = true');
//$c3->order = 'kdrekening3';
//
//$r3 = Rekening3M::model()->findAll($c3);
//
//$c4->compare('rekening3_id', $modRekDebit->rekening3_id);
//$c4->addCondition('rekening4_aktif = true');
//$c4->order = 'kdrekening4';
//
//$r4 = Rekening4M::model()->findAll($c4);
//
//$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
//	'id' => 'list-rekening-m-grid',
//	'dataProvider' => $modRekDebit->searchAccounts(),
//	'filter' => $modRekDebit,
//	'template' => "{summary}\n{items}\n{pager}",
//	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
//	'columns' => array(
//		array(
//			'header' => 'Pilih',
//			'type' => 'raw',
//			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
//                    array(
//                        "class"=>"btn-small",
//                        "onClick" =>"
//                            getDataRekening(\'$data->rekening1_id\',\'$data->rekening2_id\',\'$data->rekening3_id\',\'$data->rekening4_id\',\'$data->rekening5_id\');
//							$(\'#dialogRincianRek\').dialog(\'close\');
//                            return false;
//							
//                        ")
//                    )
//                ',
//		),
//		array(
//				'header' => 'Kode Akun',
//				'name' => 'kdrekening5',
//				'value' => '$data->kdrekening5',
//		),
//		array(
//				'header'=>'Kelompok Akun',
//				'type'=>'raw',
//				'value'=>function($data) {
//					$rek1 = Rekening1M::model()->findByPk($data->rekening1_id);
//					$rek2 = KelrekeningM::model()->findByPk($rek1->kelrekening_id);
//					return $rek2->namakelrekening;
//				},
//				'filter'=>CHtml::activeDropDownList($modRekDebit, 'kelrekening_id', CHtml::listData(
//			   KelrekeningM::model()->findAll(array(
//				   'condition'=>'kelrekening_aktif = true',
//				   'order'=>'koderekeningkel',
//			   )), 'kelrekening_id', 'namakelrekening'
//				), array('empty'=>'-- Pilih --')),
//		),
//		array(
//				'header'=>'Komponen',
//				'name'=>'rekening1_id',
//				'value'=>'$data->nmrekening1',
//				'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening1_id', 
//				CHtml::listData(Rekening1M::model()->findAll(array(
//					'condition'=>'rekening1_aktif = true',
//					'order'=>'kdrekening1 asc',
//				)), 'rekening1_id', 'nmrekening1'), array('empty'=>'-- Pilih --')),
//		),
//		array(
//				'header'=>'Unsur',
//				'name'=>'rekening2_id',
//				'value'=>'$data->nmrekening2',
//				'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening2_id', 
//				CHtml::listData($r2, 'rekening2_id', 'nmrekening2'), array('empty'=>'-- Pilih --')),
//		),
//		array(
//				'header'=>'Kelompok Pos',
//				'name'=>'rekening3_id',
//				'value'=>'$data->nmrekening3',
//				'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening3_id', 
//				CHtml::listData($r3, 'rekening3_id', 'nmrekening3'), array('empty'=>'-- Pilih --')),
//		),
//		array(
//				'header'=>'Pos',
//				'name'=>'rekening4_id',
//				'value'=>'$data->nmrekening4',
//				'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening4_id', 
//				CHtml::listData($r4, 'rekening4_id', 'nmrekening4'), array('empty'=>'-- Pilih --')),
//		),
//		array(
//				'header' => 'Akun',
//				'name' => 'nmrekening5',
//				'value' => '$data->nmrekening5',
//		), /*
//		array(
//			'header'=>'Nama Lain',
//			'name'=>'nmrekeninglain5',
//			'value'=>'$data->nmrekeninglain5',
//		), */
//		array(
//				'header'=>'Saldo Normal',
//				'name'=>'rekening5_nb',
//				'value'=>'($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
//				'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening5_nb', array('D'=>'Debit', 'K'=>'Kredit'), array('empty'=>"-- Pilih --")),
//		),
//	),
//	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
//		)
//);
//$this->endWidget();
?>
<?php // echo $this->renderPartial('_jsFunctions', array('redirect' => $redirect)); 
?>
<script type="text/javascript">
    function formatNumberSemua() {
        $(".integer").each(function() {
            $(this).val(formatInteger($(this).val()));
        });
        $(".float").each(function() {
            $(this).val(formatFloat($(this).val()));
        });
    }
    $(document).ready(function() {
        formatNumberSemua();
    });
</script>