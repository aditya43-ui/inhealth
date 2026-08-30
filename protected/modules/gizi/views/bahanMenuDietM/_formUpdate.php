<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bahanmenudiet-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#menudiet',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>
<div class="controls">
    <?php // echo $form->textFieldRow($model,'menudiet_id'); 
    ?>
    <?php // echo CHtml::ActiveHiddenField($model,'menudiet_id', '', array('readonly'=>true)) 
    ?>
    <?php /* $this->widget('MyJuiAutoComplete', array(
                                                               'name'=>'menudiet',
                                                               'value'=>$model->menudiet->menudiet_nama,
                                                                'source'=>'js: function(request, response) {
                                                                       $.ajax({
                                                                           url: "'.Yii::app()->createUrl('ActionAutoComplete/MenuDiet').'",
                                                                           dataType: "json",
                                                                           data: {
                                                                               term: request.term,
                                                                           },
                                                                           success: function (data) {
                                                                                   response(data);
                                                                           }
                                                                       })
                                                                    }',
                                                                'options'=>array(
                                                                           'showAnim'=>'fold',
                                                                           'minLength' => 2,
                                                                           'focus'=> 'js:function( event, ui )
                                                                               {
                                                                                $(this).val(ui.item.label);
                                                                                return false;
                                                                                }',
                                                                           'select'=>'js:function( event, ui ) {
                                                                               $("#BahanMenuDietM_menudiet_id").val(ui.item.menudiet_id);
                                                                                return false;
                                                                            }',
                                                                ),
                                                                'htmlOptions'=>array(
                                                                    'readonly'=>false,
                                                                    'placeholder'=>'Menu Diet',
                                                                    'size'=>13,
                                                                ),
                                                                'tombolDialog'=>array('idDialog'=>'dialogMenuDiet'),
                                                        )); */ ?>
</div>
<div class="controls">
    <?php // echo $form->textFieldRow($model,'bahanmakanan_id'); 
    ?>
    <?php // echo CHtml::ActiveHiddenField($model,'bahanmakanan_id', '', array('readonly'=>true)); 
    ?>
    <?php /* $this->widget('MyJuiAutoComplete', array(
                                                               'name'=>'bahanmakanan',
                                                               'value'=>$model->bahanmakanan->namabahanmakanan,
                                                                'source'=>'js: function(request, response) {
                                                                       $.ajax({
                                                                           url: "'.Yii::app()->createUrl('ActionAutoComplete/BahanMakanan').'",
                                                                           dataType: "json",
                                                                           data: {
                                                                               term: request.term,
                                                                           },
                                                                           success: function (data) {
                                                                                   response(data);
                                                                           }
                                                                       })
                                                                    }',
                                                                'options'=>array(
                                                                           'showAnim'=>'fold',
                                                                           'minLength' => 2,
                                                                           'focus'=> 'js:function( event, ui )
                                                                               {
                                                                                $(this).val(ui.item.label);
                                                                                return false;
                                                                                }',
                                                                           'select'=>'js:function( event, ui ) {
                                                                               $("#BahanMenuDietM_bahanmakanan_id").val(ui.item.bahanmakanan_id);
                                                                                return false;
                                                                            }',
                                                                ),
                                                                'htmlOptions'=>array(
                                                                    'readonly'=>false,
                                                                    'placeholder'=>'Bahan Makanan',
                                                                    'size'=>13,
                                                                ),
                                                                'tombolDialog'=>array('idDialog'=>'dialogBahanMakanan'),
                                                        )); */ ?>
</div>
<div class="controls">
    <?php /* echo $form->textField($model,'jmlbahan',array('class'=>'span1',)); */ ?>
    <?php /* echo CHtml::textField('satuan',$model->bahanmakanan->satuanbahan,array('readonly'=>true,'class'=>'span2'))  */ ?>
</div>

<div>
    <table id="tableBahanMenuDiet" class="table table-striped table-condensed">
        <thead>
            <tr>
                <th> &nbsp;</th>
                <th> Menu Diet </th>
                <th> Bahan Makanan </th>
                <th> Jumlah Bahan </th>
                <th> Satuan Bahan </th>
            </tr>
        </thead>
        <?php
        $bahanmenudiet = $_GET['id'];
        $mod = BahanMenuDietM::model()->findByPk($bahanmenudiet);
        $datas = BahanMenuDietM::model()->findAll("menudiet_id='$mod->menudiet_id' ORDER BY bahanmenudiet_id");
        $returnVal = "";
        $tr = "";
        foreach ($datas as $data) {
            $modMenuDiet = MenuDietM::model()->findByPK($data->menudiet_id);
            $modBahanMakanan = BahanmakananM::model()->findByPK($data->bahanmakanan_id);
            $tr .= '<tr>';
            $tr .= '<td>' . CHtml::checkBox('bahanmenudiet_id[]', true, array('class' => 'cekList', 'value' => $data->bahanmenudiet_id)) . '</td>';

            $tr .= CHtml::hiddenField("menudiet_id[$data->bahanmenudiet_id]", $data->menudiet_id);
            $tr .= '<td>' . $modMenuDiet->menudiet_nama . '</td>';

            $tr .= CHtml::hiddenField("bahanmakanan_id[$data->bahanmenudiet_id]", $data->bahanmakanan_id);
            $tr .= '<td>' . $modBahanMakanan->namabahanmakanan . '</td>';

            $tr .= '<td>' . CHtml::textField("jmlbahan[$data->bahanmenudiet_id]", $data->jmlbahan) . '</td>';
            $tr .= '<td>' . $modBahanMakanan->satuanbahan . '</td>';
            $tr .= '</tr>';
        }
        $returnVal .= $tr;
        echo $returnVal;
        ?>
    </table>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeyUp' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/bahanMenuDietM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Bahan Menu Diet', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('bahanMenuDietM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php
$urlGetBahanMenuDiet = Yii::app()->createUrl('actionAjax/GetBahanMenuDiet');
?>

<?php
$jscript = <<< JS
function submitBahanMenuDiet()
{
    menudiet_id = $('#BahanMenuDietM_menudiet_id').val();
    bahanmakanan_id = $('#BahanMenuDietM_bahanmakanan_id').val();
    jmlbahan = $('#BahanMenuDietM_jmlbahan').val();
    satuan = $('#satuan').val();
    if(menudiet_id==''){
        myAlert('Silakan pilih menu terlebih dahulu!');
    }else{
        $.post("${urlGetBahanMenuDiet}", { menudiet_id:menudiet_id, bahanmakanan_id:bahanmakanan_id, jmlbahan:jmlbahan, satuan:satuan},
        function(data){
            $('#tableBahanMenuDiet').append(data.return);
        }, "json");
    }   
}
JS;

Yii::app()->clientScript->registerScript('bahanmenudiet', $jscript, CClientScript::POS_HEAD);
?>