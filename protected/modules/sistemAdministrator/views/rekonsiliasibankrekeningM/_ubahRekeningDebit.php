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
            <div class="control-group">
                <?php echo CHtml::label('Jenis Penjamin', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList(
                        $modPengeluaran,
                        'jenisrekonsiliasibank_id',
                        CHtml::listData($modPengeluaran->getJenisRekonItems(), 'jenisrekonsiliasibank_id', 'jenisrekonsiliasibank_nama'),
                        array(
                            'empty' => '-- Pilih --', 'disabled' => true, 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien', array('encode' => false, 'namaModel' => 'AKPenjaminpasienM')),
                                'update' => '#' . CHtml::activeId($modPengeluaran, 'jenisrekonsiliasibank_id') . ''  //selector to update
                            ),
                        )
                    );
                    ?>
                </div>
            </div>
            <div class='control-group'>
                <?php echo CHtml::label('Rekening Debit', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo CHtml::textField('debit', $model->rekeningdebit->nmrekening5, array()); ?>
                    <?php echo CHtml::hiddenField('rekening5_id', $model->rekening5_id, array()); ?>
                    <?php echo CHtml::hiddenField('jenisrekonsiliasibank_id', $model->jenisrekonsiliasibank_id, array()); ?>
                    <?php echo CHtml::hiddenField('rekonsiliasibankrekening_id', $model->rekonsiliasibankrekening_id, array()); ?>
                </div>
            </div>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>
<h6>Checklist untuk <b>Ubah Rekening Debit</b></h6>
<div style="width:100%;">
    <?php
    $account = "D";

    $modRekDebit = new RekeningakuntansiV('search');
    $modRekDebit->unsetAttributes();
    $modRekDebit->rekening5_nb = $account;
    //            $account = "D";
    if (isset($_GET['RekeningakuntansiV'])) {
        $modRekDebit->attributes = $_GET['RekeningakuntansiV'];
        $modRekDebit->rekening5_nb = $account;
    }

    $c2 = new CDbCriteria();
    $c3 = new CDbCriteria();
    $c4 = new CDbCriteria();

    $c2->compare('rekening1_id', $modRekDebit->rekening1_id);
    $c2->addCondition('rekening2_aktif = true');
    $c2->order = 'kdrekening2';

    $r2 = Rekening2M::model()->findAll($c2);

    $c3->compare('rekening2_id', $modRekDebit->rekening2_id);
    $c3->addCondition('rekening3_aktif = true');
    $c3->order = 'kdrekening3';

    $r3 = Rekening3M::model()->findAll($c3);

    $c4->compare('rekening3_id', $modRekDebit->rekening3_id);
    $c4->addCondition('rekening4_aktif = true');
    $c4->order = 'kdrekening4';

    $r4 = Rekening4M::model()->findAll($c4);

    //            $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'rekdebit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
        'dataProvider' => $modRekDebit->searchAccounts($account),
        'filter' => $modRekDebit,
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
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("style"=>"text-align:left;", 
							"id" => "selectRekDebit",
							"onClick" =>"
								$(\"#rekening5_id\").val(\"$data->rekening5_id\");
								$(\"#rekening4_id\").val(\"$data->rekening4_id\");
								$(\"#rekening3_id\").val(\"$data->rekening3_id\");
								$(\"#rekening2_id\").val(\"$data->rekening2_id\");
								$(\"#rekening1_id\").val(\"$data->rekening1_id\");
								$(\"#debit\").val(\"$data->namaRekening\");  
								saveDebit();
								return false;
						"))',
            ),
            array(
                'header' => 'No. Urut',
                'name' => 'nourutrek',
                'value' => '$data->nourutrek',
            ),
            array(
                'header' => 'Kelompok Akun',
                'name' => 'rekening1_id',
                'value' => '$data->nmrekening1',
                'filter' =>  CHtml::activeDropDownList(
                    $modRekDebit,
                    'rekening1_id',
                    CHtml::listData(Rekening1M::model()->findAll(array(
                        'condition' => 'rekening1_aktif = true',
                        'order' => 'kdrekening1 asc',
                    )), 'rekening1_id', 'nmrekening1'),
                    array('empty' => '-- Pilih --')
                ),
            ),
            array(
                'header' => 'Golongan Akun',
                'name' => 'rekening2_id',
                'value' => '$data->nmrekening2',
                'filter' =>  CHtml::activeDropDownList(
                    $modRekDebit,
                    'rekening2_id',
                    CHtml::listData($r2, 'rekening2_id', 'nmrekening2'),
                    array('empty' => '-- Pilih --')
                ),
            ),
            array(
                'header' => 'Sub Golongan Akun',
                'name' => 'rekening3_id',
                'value' => '$data->nmrekening3',
                'filter' =>  CHtml::activeDropDownList(
                    $modRekDebit,
                    'rekening3_id',
                    CHtml::listData($r3, 'rekening3_id', 'nmrekening3'),
                    array('empty' => '-- Pilih --')
                ),
            ),
            array(
                'header' => 'Jenis Akun',
                'name' => 'rekening4_id',
                'value' => '$data->nmrekening4',
                'filter' =>  CHtml::activeDropDownList(
                    $modRekDebit,
                    'rekening4_id',
                    CHtml::listData($r4, 'rekening4_id', 'nmrekening4'),
                    array('empty' => '-- Pilih --')
                ),
            ),
            array(
                'header' => 'Kode Akun',
                'name' => 'kdrekening5',
                'value' => '$data->kdrekening5',
            ),
            array(
                'header' => 'Nama Akun',
                'type' => 'raw',
                'name' => 'nmrekening5',
                'value' => '($data->nmrekening5 == "" ?  "-" : $data->nmrekening5)',
            ), /*
					array(
						'header'=>'Nama Lain',
						'name'=>'nmrekeninglain5',
						'value'=>'($data->nmrekeninglain5 == "" ? "-" : $data->nmrekeninglain5)',
					), */
            array(
                'header' => 'Saldo Normal',
                'name' => 'rekening5_nb',
                'value' => '($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
                'filter' =>  CHtml::activeDropDownList(
                    $modRekDebit,
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
$urlEditDebit = Yii::app()->createUrl('sistemAdministrator/rekonsiliasibankrekeningM/getRekeningEditDebitRekonBank'); //MAsukan Dengan memilih Rekening
$mds = Yii::t('mds', 'Anda yakin akan ubah data rekening kredit?');
$urlRefresh = Yii::app()->createUrl('sistemAdministrator/rekonsiliasibankrekeningM/admin');
$jscript = <<< JS

function saveDebit()
{
    rekening1_id = $('#rekening1_id').val();
    rekening2_id = $('#rekening2_id').val();
    rekening3_id = $('#rekening3_id').val();
    rekening4_id = $('#rekening4_id').val();
    rekening5_id = $('#rekening5_id').val();
    rekening5_nb = $('#rekening5_nb').val();
    jenisrekonsiliasibank_id = $('#jenisrekonsiliasibank_id').val();
    rekonsiliasibankrekening_id = $('#rekonsiliasibankrekening_id').val();

    myConfirm("${mds}",'Perhatian!',function(r){
        if(r)
        {
            $.post("${urlEditDebit}", {rekening1_id:rekening1_id, rekening2_id:rekening2_id, rekening3_id:rekening3_id, rekening4_id:rekening4_id, rekening5_id:rekening5_id, jenisrekonsiliasibank_id:jenisrekonsiliasibank_id, rekening5_nb:rekening5_nb,rekonsiliasibankrekening_id:rekonsiliasibankrekening_id},
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
Yii::app()->clientScript->registerScript('rekonBank', $jscript, CClientScript::POS_HEAD);
?>