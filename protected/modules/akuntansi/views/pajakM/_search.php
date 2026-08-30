<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'pajak-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Nama Pajak', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($model, 'pajak_nama', array('placeholder' => 'Nama Pajak', 'class' => 'span3'));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama Lain Pajak', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($model, 'pajak_namalain', array('placeholder' => 'Nama Lain Pajak', 'class' => 'span3'));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class='control-group'>
            <?php echo CHtml::label('Nama Rekening', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'rekening5_nama',
                    'source' => 'js: function(request, response) {
					$.ajax({
						url: "' . $this->createUrl('RekeningAkuntansi') . '",
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
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                                $(this).val( ui.item.value);
                                                return false;
                                        }',
                        'select' => 'js:function( event, ui ) { 
                                            $(this).val( ui.item.value);
                                            return false;
                                    }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Nama Rekening',
                        'class' => 'span3',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogRek'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Keterangan', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($model, 'keterangan', array('placeholder' => 'Keterangan', 'class' => 'span3'));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'jenisjurnal_aktif', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'pajak_aktif', array('checked' => 'checked')); ?>
                <label for="AKPajakM_pajak_aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
        array('class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
    array(
        'title' => 'Ulang',
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    )
); ?>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Rek Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRek',
    'options' => array(
        'title' => 'Daftar Akun Rekening',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 400,
        'resizable' => false,
    ),
));
$modRekDebit = new RekeningakuntansiV('search');
$modRekDebit->unsetAttributes();
$account = "";
if (isset($_GET['RekeningakuntansiV'])) {
    $modRekDebit->attributes = $_GET['RekeningakuntansiV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rekdebit-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modRekDebit->searchAccounts(),
    'filter' => $modRekDebit,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    //        JIKA INI DI AKTIFKAN MAKA FILTER AKAN HILANG
    //        'mergeHeaders'=>array(
    //            array(
    //                'name'=>'<p style="margin: 0; text-align: center;">Kode Rekening</p>',
    //                'start'=>1, //indeks kolom 3
    //                'end'=>5, //indeks kolom 4
    //            ),
    //        ),
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectRekDebit",
				"onClick" =>"
					$(\"#' . CHtml::activeId($model, 'rekening5_nama') . '\").val(\"$data->nmrekeninglast\");                                                
					$(\"#dialogRek\").dialog(\"close\");    
					return false;
			"))',
        ),
        array(
            'header' => 'Kode Akun',
            'name' => 'kdrekening5',
            'value' => '$data->kdrekeninglast',
            'filter' => Chtml::activeTextField($modRekDebit, 'kdrekeninglast', array('class' => 'numbers-only', 'maxlength' => 12))
        ),
        'kdrekening1',
        'kdrekening2',
        'kdrekening3',
        'kdrekening4',
        'kdrekening5',
        'kdrekening6',
        'kdrekening7',
        'kdrekening8',
        'kdrekening9',
        'kdrekening10',
        array(
            'header' => 'Akun',
            'name' => 'nmrekening5',
            'value' => '$data->nmrekeninglast',
            'filter' => Chtml::activeTextField($modRekDebit, 'nmrekeninglast', array('class' => 'custom-only'))
        ),
        array(
            'header' => 'Saldo Normal',
            'name' => 'rekeninglast_nb',
            'value' => '($data->rekeninglast_nb == "D") ? "Debit" : "Kredit"',
            'filter' =>  CHtml::activeDropDownList($modRekDebit, 'rekeninglast_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function() {
            setNumbersOnly(this);
            });
            $(".custom-only").keyup(function() {
            setCustomOnly(this);
            });'
        . '}',
));
$this->endWidget();
//========= end Rek Debit dialog =============================
?>