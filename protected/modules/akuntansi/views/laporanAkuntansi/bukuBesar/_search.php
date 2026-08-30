<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
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

label.checkbox{
        width:150px;
        display:inline-block;
}
</style>

<div class="panel panel-success">
	<div class="panel-heading" >
		<div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
	</div>
	<div class="panel-body">
		<div class="col-sm-6">
            <div class="control-group">
                    
                    <?php echo CHtml::label("Periode Laporan",'tgl_rekam', array('class' => 'control-label')) ?>
                    <div class="controls">
                            <div class="daterange daterange-inline add-ranges input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                            </div>
                    </div>
            </div>
		</div>
		<div class="col-sm-6">
			<div class='control-group'>
                  <?php echo CHtml::label('Kode Rekening / Nama Rekening','kodeRekening', array('class'=>'control-label')) ?>
                
                 <div class="controls">
                     <?php echo $form->hiddenField($model, 'rekening5_id'); ?>
                        <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'kodeRekening',
                                'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningKodeAkuntansi'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
                                        if(ui.item.kdrincianobyek ){
                                            $(this).val(ui.item.kdrincianobyek);
                                        }else{
                                            if(ui.item.kdobyek){
                                                $(this).val(ui.item.kdobyek);
                                            }else if(ui.item.kdjenis){
                                                $(this).val(ui.item.kdjenis)
                                            }
                                        }
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                           $(this).val(ui.item.value);                                            
                                           return false;
                                    }'
                                ),
                                'htmlOptions' => array(
//                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'placeholder'=>'Ketikan Kode Rekening / Nama Rekening',
                                    'class'=>'span3',
                                    'style'=>'width:150px;',
                                ),
								'tombolDialog' => array('idDialog' => 'dialogRekDebit',),
                            ));
                        ?>
                 </div>
            </div>
            <div class='control-group'>
                  <?php echo CHtml::label('No Referensi','', array('class'=>'control-label')) ?>
                
                 <div class="controls">
                     <?php echo $form->textField($model, 'noreferensi',array('class'=>'span3')) ?>
                 </div>
            </div>
        </div>
           
		 <div class="form-actions">
            <?php
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), 
                array('class' => 'btn btn-primary', 'type' => 'button', 'id' => 'btn_simpan', 'onclick'=>'cekPencarian();'));?>
            
            <?php
                echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                    array('class'=>'btn btn-danger','onclick'=>'konfirmasi()','onKeypress'=>'return formSubmit(this,event)'));
                
                echo $this->renderPartial('akuntansi.views.laporanAkuntansi/_tombolPrinoutNonGrafik',true);
            ?> 
                
        </div>
	</div>
   
</div>  

<?php
    $this->endWidget();
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
',  CClientScript::POS_READY);
?>



<?php 
//========= Dialog buat cari data Rek Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRekDebit',
    'options'=>array(
        'title'=>'Daftar Rekening',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modRekDebit = new Rekeningakuntansi5V('searchDialogAccount');
$modRekDebit->unsetAttributes();

if (isset($_GET['Rekeningakuntansi5V'])) {
    $modRekDebit->attributes = $_GET['Rekeningakuntansi5V'];
    $modRekDebit->rekening5_id = (!empty($_GET['Rekeningakuntansi5V']['rekening5_id']) ? $_GET['Rekeningakuntansi5V']['rekening5_id']: null);
    $modRekDebit->rekening6_id = (!empty($_GET['Rekeningakuntansi5V']['rekening6_id']) ? $_GET['Rekeningakuntansi5V']['rekening6_id']: null);
    $modRekDebit->rekening7_id = (!empty($_GET['Rekeningakuntansi5V']['rekening7_id']) ? $_GET['Rekeningakuntansi5V']['rekening7_id']: null);
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rekdebit-m-grid',
    'dataProvider' => $modRekDebit->searchDialogAccount(),
    'filter' => $modRekDebit,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript::void(0)",array("class"=>"btn-small",
				"id" => "selectRekDebit",
				"onClick" =>" 
                    $(\"#'.CHtml::activeId($model,'rekening5_id').'\").val(\"$data->rekeninglast_id\");
                    $(\"#'.CHtml::activeId($model,'kodeRekening').'\").val(\"".$data->koderekeninglast." - ".$data->namarekeninglast."\");
					$(\"#dialogRekDebit\").dialog(\"close\"); 
					return false;
			"))',
        ),
        array(
            'header' => 'Kode Akun',
            'type' => 'raw',
            'value' => '$data->koderekeninglast',
            'filter' => Chtml::activeTextField($modRekDebit, 'koderekeninglast', array('class' => '', 'maxlength' => 12))
        ),
        array(
            'header' => 'Kelompok Akun',
            'type' => 'raw',
            'value' => function ($data) {
                $kel = KelrekeningM::model()->findByPk($data->kelompokrekeninglast_id);
                return $kel ? $kel->namakelrekening : "-";
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'kelompokrekeninglast_id', CHtml::listData(
                KelrekeningM::model()->findAll(array(
                    'condition' => 'kelrekening_aktif = true',
                    'order' => 'koderekeningkel',
                )),
                'kelrekening_id',
                'namakelrekening'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 1',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening1;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening1_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening1_id is not null',
                    'order' => 'namarekening1 ASC',
                )),
                'rekening1_id',
                'namarekening1'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 2',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening2;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening2_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening2_id is not null',
                    'order' => 'namarekening2 ASC',
                )),
                'rekening2_id',
                'namarekening2'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 3',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening3;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening3_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening3_id is not null',
                    'order' => 'namarekening3 ASC',
                )),
                'rekening3_id',
                'namarekening3'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 4',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening4;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening4_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening4_id is not null',
                    'order' => 'namarekening4 ASC',
                )),
                'rekening4_id',
                'namarekening4'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 5',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening5;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening5_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening5_id is not null',
                    'order' => 'namarekening5 ASC',
                )),
                'rekening5_id',
                'namarekening5'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 6) ? true: false)
        ),
        array(
            'header' => 'Rekening Level 6',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening6;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening6_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening6_id is not null',
                    'order' => 'namarekening6 ASC',
                )),
                'rekening6_id',
                'namarekening6'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 7) ? true: false)
        ),
        array(
            'header' => 'Rekening Level 7',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening7;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening7_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening7_id is not null',
                    'order' => 'namarekening7 ASC',
                )),
                'rekening7_id',
                'namarekening7'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 8) ? true: false)
        ),
        array(
            'header' => 'Nama Rekening Terakhir',
            'type' => 'raw',
            'value' => '$data->namarekeninglast',
            'filter' => Chtml::activeTextField($modRekDebit, 'namarekeninglast', array('class' => ''))
        ),
        array(
            'header' => 'Saldo Normal',
            'type' => 'raw',
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



<script>

function cekPencarian() {
    //var periode = $(".periodeposting_id").val();
	var tgl_awal = $("#<?php echo CHtml::activeId($model, 'tgl_awal') ?>") .val();
	var tgl_akhir = $("#<?php echo CHtml::activeId($model, 'tgl_akhir') ?>") .val();
    
    //if (periode.trim() == "") $("#searchLaporan").submit();
    
    //$.post('<?php echo Yii::app()->createUrl('/actionAjax/cekJurnalBelumPosting')?>', {periode: periode}, function(data) {
	$.post('<?php echo Yii::app()->createUrl('/actionAjax/CekJurnalBelumPostingByTanggal')?>', {tgl_awal: tgl_awal,tgl_akhir:tgl_akhir}, function(data) {
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