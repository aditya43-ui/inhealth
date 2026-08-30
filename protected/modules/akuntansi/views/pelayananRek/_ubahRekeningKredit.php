<?php // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); 
?>
<?php // $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
//	'id'=>'jenispengeluaran-m-form',
//	'enableAjaxValidation'=>false,
//        'type'=>'horizontal',
//        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onSubmit'=>'verifikasi();'),
//        'focus'=>'#',
//)); 
?>

<!--<div class='divForForm'>
</div>
	<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<?php // echo $form->errorSummary($model); 
?>

<!--<table>
            <tr>
                <td>
                   <div class="control-group">
                         <?php // echo CHtml::label('Jenis Pelayanan','', array('class'=>'control-label')) 
                            ?>
                        <div class="controls">
                            <?php
                            //                                echo $form->textField($model,'jnspelayanan', array('readonly'=>true)); 
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                         <?php // echo CHtml::label('Ruangan','', array('class'=>'control-label')) 
                            ?>
                        <div class="controls">
                            <?php
                            //                                echo $form->hiddenField($model,'ruangan_id');
                            //                                echo $form->hiddenField($model,'pelayananrek_id');
                            //                                $ruanganm = RuanganM::model()->findByPk($model->ruangan_id);
                            //                                echo CHtml::textField('ruangan_nama', $ruanganm->ruangan_nama,array('readonly'=>true));
                            ?>
                        </div>
                    </div>
                    
                     <div class='control-group'>
                                  <?php // echo CHtml::label('Rekening Kredit','',array('class'=>'control-label')) 
                                    ?>
                             <div class="controls">
                                  <?php // echo CHtml::textField('kredit',$model->rekeningnama); 
                                    ?>
                                  <?php // echo CHtml::hiddenField('rekening5_id',$model->rekening5_id,array()); 
                                    ?>
                                  <?php // echo CHtml::hiddenField('rekening4_id',$model->rekening4_id,array()); 
                                    ?>
                                  <?php // echo CHtml::hiddenField('rekening3_id',$model->rekening3_id,array()); 
                                    ?>
                                  <?php // echo CHtml::hiddenField('rekening2_id',$model->rekening2_id,array()); 
                                    ?>
                                  <?php // echo CHtml::hiddenField('rekening1_id',$model->rekening1_id,array()); 
                                    ?>
                             </div>
                   </div>
                </td>
            </tr>
        </table>-->
<?php // $this->endWidget(); 
?>
<!--<h6>Checklist untuk <b>Ubah Rekening Debit</b></h6>
    <div style="width:100%;">
        <?php
        //            $modRekDebit = new RekeningakuntansiV('search');
        //            $modRekDebit->unsetAttributes();
        //            if(isset($_GET['RekeningakuntansiV'])) {
        //                $modRekDebit->attributes = $_GET['RekeningakuntansiV'];
        //            }
        //            $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
        //                    'id'=>'rekdebit-m-grid',
        //                    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
        //                    'dataProvider'=>$modRekDebit->search(),
        //                    'filter'=>$modRekDebit,
        //                    'template'=>"{summary}\n{items}\n{pager}",
        //                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        //                    'mergeHeaders'=>array(
        //                        array(
        //                            'name'=>'<p style="margin: 0; text-align: center;">Kode Rekening</p>',
        //                            'start'=>1, //indeks kolom 3
        //                            'end'=>5, //indeks kolom 4
        //                        ),
        //                    ),
        //                    'columns'=>array(
        //                            array(
        //                                'header'=>'No. Urut',
        //                                'name'=>'nourutrek',
        //                                'value'=>'$data->nourutrek',
        //                            ),
        //                            array(
        //                                'header'=>'Rek. 1',
        //                                'name'=>'kdstruktur',
        //                                'value'=>'$data->kdstruktur',
        //                            ),
        //                            array(
        //                                'header'=>'Rek. 2',
        //                                'name'=>'kdkelompok',
        //                                'value'=>'$data->kdkelompok',
        //                            ),
        //                            array(
        //                                'header'=>'Rek. 3',
        //                                'name'=>'kdjenis',
        //                                'value'=>'$data->kdjenis',
        //                            ),
        //                            array(
        //                                'header'=>'Rek. 4',
        //                                'name'=>'kdobyek',
        //                                'value'=>'$data->kdobyek',
        //                            ),
        //                            array(
        //                                'header'=>'Rek. 5',
        //                                'name'=>'kdrincianobyek',
        //                                'value'=>'$data->kdrincianobyek',
        //                            ),
        //                            array(
        //                                'header'=>'Nama Rekening',
        //                                'name'=>'nmrincianobyek',
        //                                'value'=>'$data->nmrincianobyek',
        //                            ),
        //                            array(
        //                                'header'=>'Nama Lain',
        //                                'name'=>'nmrincianobyeklain',
        //                                'value'=>'$data->nmrincianobyeklain',
        //                            ),
        //                            array(
        //                                'header'=>'Saldo Normal',
        //                                'name'=>'rincianobyek_nb',
        //                                'value'=>'($data->rincianobyek_nb == "D") ? "Debit" : "Kredit"',
        //                            ),
        //
        //                            array(
        //                                'header'=>'Pilih',
        //                                'type'=>'raw',
        //                                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
        //                                                "id" => "selectRekDebit",
        //                                                "onClick" =>"
        //                                                            $(\"#rekening5_id\").val(\"$data->rincianobyek_id\");
        //                                                            $(\"#rekening4_id\").val(\"$data->obyek_id\");
        //                                                            $(\"#rekening3_id\").val(\"$data->jenis_id\");
        //                                                            $(\"#rekening2_id\").val(\"$data->kelompok_id\");
        //                                                            $(\"#rekening1_id\").val(\"$data->struktur_id\");
        //                                                            $(\"#kredit\").val(\"$data->nmrincianobyek\");  
        //                                                            saveDebit();
        //                                                            return false;
        //                                        "))',
        //                            ),
        //                    ),
        //                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        //            ));
        ?>
    </div>
</div>
<script>
    function verifikasi(){
        myConfirm("<?php // echo Yii::t('mds','Yakin Anda akan Ubah Data Rekening?') 
                    ?>",'Perhatian!',function(r){
            if(r)
            {
                $('#dialogUbahRekeningDebitKredit').dialog('close');
            }
            else
            {   
                $('#submit').submit();
                return false;
            }
        });
    }
    
</script>-->
<?php
//$urlEditDebit = Yii::app()->createUrl('akuntansi/actionAjax/getRekeningEditDebitPelayananRek');//MAsukan Dengan memilih Rekening
//$jscript = <<< JS
//
//function saveDebit()
//{
//    rekening1_id = $('#rekening1_id').val();
//    rekening2_id = $('#rekening2_id').val();
//    rekening3_id = $('#rekening3_id').val();
//    rekening4_id = $('#rekening4_id').val();
//    rekening5_id = $('#rekening5_id').val();
//    pelayananrek_id = $('#PelayananrekM_pelayananrek_id').val();
//
////    myAlert(penjaminrek_id + penjamin_id+ saldonormal + rekening5_id + rekening4_id + rekening3_id + rekening2_id + rekening1_id);
//
//    $.post("${urlEditDebit}", {rekening1_id:rekening1_id, rekening2_id:rekening2_id, rekening3_id:rekening3_id, rekening4_id:rekening4_id, rekening5_id:rekening5_id, pelayananrek_id:pelayananrek_id},
//        function(data){
//            $('.divForForm').html(data.pesan);
//            setTimeout(function(){
//                $("#iframeEditRekeningDebitKredit").attr("src",$(this).attr("href"));
//                window.parent.$("#dialogUbahRekeningDebitKredit").dialog("close");
//                return true;
//            },500);
//    }, "json");
//}
//    
//JS;
//Yii::app()->clientScript->registerScript('masukanobat',$jscript, CClientScript::POS_HEAD);
//
?>

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
                <?php echo CHtml::label('Jenis Pelayanan', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->textField($model, 'jnspelayanan', array('readonly' => true));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php // echo CHtml::label('Ruangan','', array('class'=>'control-label')) 
                ?>
                <div class="controls">
                    <?php
                    echo $form->hiddenField($model, 'ruangan_id');
                    echo $form->hiddenField($model, 'pelayananrek_id');
                    $ruanganm = RuanganM::model()->findByPk($model->ruangan_id);
                    //                                echo CHtml::textField('ruangan_nama', $ruanganm->ruangan_nama,array('readonly'=>true));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Nama Pelayanan', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->hiddenField($model, 'daftartindakan_id');
                    $daftartindakanm = DaftartindakanM::model()->findByPk($model->daftartindakan_id);
                    echo CHtml::textField('daftartindakan_nama', $daftartindakanm->daftartindakan_nama, array('readonly' => true));
                    ?>
                </div>
            </div>

            <div class='control-group'>
                <?php echo CHtml::label('Rekening Kredit', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo CHtml::textField('kredit', isset($model->rekening5->nmrekening5) ? $model->rekening5->nmrekening5 : null, array()); ?>
                    <?php echo CHtml::hiddenField('rekening5_id', $model->rekening5_id, array()); ?>
                    <?php echo CHtml::hiddenField('rekening4_id', $model->rekening4_id, array()); ?>
                    <?php echo CHtml::hiddenField('rekening3_id', $model->rekening3_id, array()); ?>
                    <?php echo CHtml::hiddenField('rekening2_id', $model->rekening2_id, array()); ?>
                    <?php echo CHtml::hiddenField('rekening1_id', $model->rekening1_id, array()); ?>
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
    if (isset($_GET['RekeningakuntansiV'])) {
        $modRekKredit->attributes = $_GET['RekeningakuntansiV'];
    }
    $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
        'id' => 'pelayananrek-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
        'dataProvider' => $modRekKredit->search(),
        'filter' => $modRekKredit,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'mergeHeaders' => array(
            array(
                'name' => 'Kode Rekening',
                'start' => 1, //indeks kolom 3
                'end' => 5, //indeks kolom 4
            ),
        ),
        'columns' => array(
            array(
                'header' => 'No. Urut',
                'name' => 'nourutrek',
                'value' => '$data->nourutrek',
            ),
            array(
                'header' => 'Rek. 1',
                'name' => 'kdstruktur',
                'value' => '$data->kdstruktur',
            ),
            array(
                'header' => 'Rek. 2',
                'name' => 'kdkelompok',
                'value' => '$data->kdkelompok',
            ),
            array(
                'header' => 'Rek. 3',
                'name' => 'kdjenis',
                'value' => '$data->kdjenis',
            ),
            array(
                'header' => 'Rek. 4',
                'name' => 'kdobyek',
                'value' => '$data->kdobyek',
            ),
            array(
                'header' => 'Rek. 5',
                'name' => 'kdrincianobyek',
                'value' => '$data->kdrincianobyek',
            ),
            array(
                'header' => 'Nama Rekening',
                'name' => 'nmrincianobyek',
                'value' => '$data->nmrincianobyek',
            ),
            array(
                'header' => 'Nama Lain',
                'name' => 'nmrincianobyeklain',
                'value' => '$data->nmrincianobyeklain',
            ),
            array(
                'header' => 'Saldo Normal',
                'name' => 'rincianobyek_nb',
                'value' => '($data->rincianobyek_nb == "D") ? "Debit" : "Kredit"',
            ),

            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                                "id" => "selectRekDebit",
                                                "onClick" =>"
                                                            $(\"#rekening5_id\").val(\"$data->rincianobyek_id\");
                                                            $(\"#rekening4_id\").val(\"$data->obyek_id\");
                                                            $(\"#rekening3_id\").val(\"$data->jenis_id\");
                                                            $(\"#rekening2_id\").val(\"$data->kelompok_id\");
                                                            $(\"#rekening1_id\").val(\"$data->struktur_id\");
                                                            $(\"#debit\").val(\"$data->nmrincianobyek\");  
                                                            saveDebit();
                                                            return false;
                                        "))',
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
$urlEditDebit = $this->createUrl('GetRekeningEditDebitPelayananRek'); //MAsukan Dengan memilih Rekening
$mds = Yii::t('mds', 'Anda yakin akan ubah data rekening?');
$jscript = <<< JS

function saveDebit()
{
    rekening1_id = $('#rekening1_id').val();
    rekening2_id = $('#rekening2_id').val();
    rekening3_id = $('#rekening3_id').val();
    rekening4_id = $('#rekening4_id').val();
    rekening5_id = $('#rekening5_id').val();
    pelayananrek_id = $('#PelayananrekM_pelayananrek_id').val();

    myConfirm("${mds}",'Perhatian!',function(r){
        if(r)
        {
            $.post("${urlEditDebit}", {rekening1_id:rekening1_id, rekening2_id:rekening2_id, rekening3_id:rekening3_id, rekening4_id:rekening4_id, rekening5_id:rekening5_id, pelayananrek_id:pelayananrek_id},
                function(data){
                    $('.divForForm').html(data.pesan);
                    setTimeout(function(){
                        $("#iframeEditRekeningDebitKredit").attr("src",$(this).attr("href"));
                        window.parent.$("#dialogUbahRekeningDebitKredit").dialog("close");
                        return true;
                    },500);
            }, "json");
        }
    });
}
    
JS;
Yii::app()->clientScript->registerScript('EditDebit', $jscript, CClientScript::POS_HEAD);
?>