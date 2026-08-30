<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'jenispengeluaran-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onSubmit' => 'verifikasi();'),
    'focus' => '#',
)); ?>

<div class='divForForm'>
</div>
<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<?php echo $form->errorSummary($model); ?>
<table>
    <tr>
        <td>
            <div class='control-group'>
                <?php echo CHtml::label('Nama Bank', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modBank, 'namabank', array()); ?>
                </div>
            </div>
            <div class='control-group'>
                <?php echo CHtml::label('Rekening Kredit', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo CHtml::textField('kredit', $model->rekeningkredit->nmrekening5, array()); ?>
                    <?php echo CHtml::hiddenField('rekening5_id', $model->rekening5_id, array()); ?>
                    <?php // echo CHtml::hiddenField('rekening4_id',$model->rekening4_id,array()); 
                    ?>
                    <?php // echo CHtml::hiddenField('rekening3_id',$model->rekening3_id,array()); 
                    ?>
                    <?php // echo CHtml::hiddenField('rekening2_id',$model->rekening2_id,array()); 
                    ?>
                    <?php // echo CHtml::hiddenField('rekening1_id',$model->rekening1_id,array()); 
                    ?>
                    <?php echo CHtml::hiddenField('bank_id', $model->bank_id, array()); ?>
                    <?php echo CHtml::hiddenField('bankrek_id', $model->bankrek_id, array()); ?>
                    <?php // echo CHtml::hiddenField('saldonormal',$model->saldonormal,array()); 
                    ?>
                </div>
            </div>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>
<h6>Checklist untuk <b>Ubah Rekening Kredit</b></h6>
<div style="width:100%;">
    <?php
    $modRekKredit = new RekeningakuntansiV('search');
    $modRekKredit->unsetAttributes();
    //            $account = "K";
    $account = "";
    if (isset($_GET['RekeningakuntansiV'])) {
        $modRekKredit->attributes = $_GET['RekeningakuntansiV'];
    }

    $c2 = new CDbCriteria();
    $c3 = new CDbCriteria();
    $c4 = new CDbCriteria();

    $c2->compare('rekening1_id', $modRekKredit->rekening1_id);
    $c2->addCondition('rekening2_aktif = true');
    $c2->order = 'kdrekening2';

    $r2 = Rekening2M::model()->findAll($c2);

    $c3->compare('rekening2_id', $modRekKredit->rekening2_id);
    $c3->addCondition('rekening3_aktif = true');
    $c3->order = 'kdrekening3';

    $r3 = Rekening3M::model()->findAll($c3);

    $c4->compare('rekening3_id', $modRekKredit->rekening3_id);
    $c4->addCondition('rekening4_aktif = true');
    $c4->order = 'kdrekening4';

    $r4 = Rekening4M::model()->findAll($c4);

    //            $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'rekkredit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
        'dataProvider' => $modRekKredit->searchAccounts($account),
        'filter' => $modRekKredit,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        //        JIKA INI DI AKTIFKAN MAKA FILTER AKAN HILANG
        //                    'mergeHeaders'=>array(
        //                        array(
        //                            'name'=>'<p style="margin: 0; text-align: center;">Kode Rekening</p>',
        //                            'start'=>1, //indeks kolom 3
        //                            'end'=>5, //indeks kolom 4
        //                        ),
        //                    ),
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
							"id" => "selectRekKredit",
							"onClick" =>"
								$(\"#rekening5_id\").val(\"$data->rekening5_id\");
								
								$(\"#kredit\").val(\"$data->namaRekening\");  
								saveKredit();
								return false;
						"))',
            ),
            array(
                'header' => 'Kode Akun',
                'name' => 'kdrekening5',
                'value' => '$data->kdrekening5',
            ),
            array(
                'header' => 'Kelompok Akun',
                'type' => 'raw',
                'value' => function ($data) {
                    $rek1 = Rekening1M::model()->findByPk($data->rekening1_id);
                    $rek2 = KelrekeningM::model()->findByPk($rek1->kelrekening_id);
                    return $rek2->namakelrekening;
                },
                'filter' => CHtml::activeDropDownList($modRekKredit, 'kelrekening_id', CHtml::listData(
                    KelrekeningM::model()->findAll(array(
                        'condition' => 'kelrekening_aktif = true',
                        'order' => 'koderekeningkel',
                    )),
                    'kelrekening_id',
                    'namakelrekening'
                ), array('empty' => '-- Pilih --')),
            ),
            array(
                'header' => 'Komponen',
                'name' => 'rekening1_id',
                'value' => '$data->nmrekening1',
                'filter' =>  CHtml::activeDropDownList(
                    $modRekKredit,
                    'rekening1_id',
                    CHtml::listData(Rekening1M::model()->findAll(array(
                        'condition' => 'rekening1_aktif = true',
                        'order' => 'kdrekening1 asc',
                    )), 'rekening1_id', 'nmrekening1'),
                    array('empty' => '-- Pilih --')
                ),
            ),
            array(
                'header' => 'Unsur',
                'name' => 'rekening2_id',
                'value' => '$data->nmrekening2',
                'filter' =>  CHtml::activeDropDownList(
                    $modRekKredit,
                    'rekening2_id',
                    CHtml::listData($r2, 'rekening2_id', 'nmrekening2'),
                    array('empty' => '-- Pilih --')
                ),
            ),
            array(
                'header' => 'Kelompok Pos',
                'name' => 'rekening3_id',
                'value' => '$data->nmrekening3',
                'filter' =>  CHtml::activeDropDownList(
                    $modRekKredit,
                    'rekening3_id',
                    CHtml::listData($r3, 'rekening3_id', 'nmrekening3'),
                    array('empty' => '-- Pilih --')
                ),
            ),
            array(
                'header' => 'Pos',
                'name' => 'rekening4_id',
                'value' => '$data->nmrekening4',
                'filter' =>  CHtml::activeDropDownList(
                    $modRekKredit,
                    'rekening4_id',
                    CHtml::listData($r4, 'rekening4_id', 'nmrekening4'),
                    array('empty' => '-- Pilih --')
                ),
            ),
            array(
                'header' => 'Akun',
                'name' => 'nmrekening5',
                'value' => '$data->nmrekening5',
            ), /*
					array(
						'header'=>'Nama Lain',
						'name'=>'nmrekeninglain5',
						'value'=>'($data->nmrekeninglain5 == "" ? $data->nmrekeninglain4 : ($data->nmrekeninglain4 == "" ? $data->nmrekeninglain3 : ($data->nmrekeninglain3 == "" ? $data->nmrekeninglain2 : ($data->nmrekeninglain2 == "" ? $data->nmrekeninglain1 : ($data->nmrekeninglain1 == "" ? "-" : $data->nmrekeninglain5)))))',
					), */
            array(
                'header' => 'Saldo Normal',
                'value' => '($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
                'filter' =>  CHtml::activeDropDownList(
                    $modRekKredit,
                    'rekening5_nb',
                    array("D" => "Debit", "K" => "Kredit"),
                    array('empty' => "-- Pilih --")
                ),
            ),

        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
    ?>
</div>

<script>
    function verifikasi() {
        myConfirm("<?php echo Yii::t('mds', 'Yakin Anda akan Ubah Data Rekening?') ?>", 'Perhatian!', function(r) {
            if (r) {
                $('#dialogUbahRekeningDebitKredit').dialog('close');
            } else {
                $('#submit').submit();
                return false;
            }
        });
    }
</script>
<?php
$urlEditKredit = $this->createUrl('GetRekeningEditKreditBank'); //MAsukan Dengan memilih Rekening
$mds = Yii::t('mds', 'Anda yakin akan ubah data rekening kredit?');
$jscript = <<< JS

function saveKredit()
{
    
    rekening5_id = $('#rekening5_id').val();
    bank_id = $('#bank_id').val();
    bankrek_id = $('#bankrek_id').val();

    myConfirm("${mds}",'Perhatian!',function(r){
        if(r)
        {
            $.post("${urlEditKredit}", {rekening5_id:rekening5_id, bank_id:bank_id, bankrek_id:bankrek_id},
                function(data){
                    $('.divForForm').html(data.pesan);
                    setTimeout(function(){
                        $("#iframeEditRekeningDebitKredit").attr("src",$(this).attr("href"));window.parent.$("#dialogUbahRekeningDebitKredit").dialog("close");
                        return true;
                    },500);
            }, "json");
        }            
    });
}
    
JS;
Yii::app()->clientScript->registerScript('ubahKredit', $jscript, CClientScript::POS_HEAD);
?>