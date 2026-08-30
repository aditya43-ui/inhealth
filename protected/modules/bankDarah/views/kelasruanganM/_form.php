

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'rjkasuspenyakitdiagnosa-m-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#kelaspelayanan',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

                <?php if (isset($modDetails)){
                    echo $form->errorSummary($modDetails);
                } else {
                    echo $form->errorSummary($model);
                } ?>
                    <?php
                        $instalasi_id = Yii::app()->user->instalasi_id;
                        $modInstalasi = InstalasiM::model()->findByPK($instalasi_id);
                        echo CHtml::hiddenField('instalasi_id',$instalasi_id);
                        echo $form->textFieldRow($model,'instalasi_nama',array('value'=>$modInstalasi->instalasi_nama,'readonly'=>true,'class'=>'span2'));
                    ?>
                    <?php
                        $ruanganid = Yii::app()->user->ruangan_id;
                        $modruangan = RuanganM::model()->findByPK($ruanganid);
                        echo CHtml::hiddenField('ruanganid',$ruanganid,array('readonly'=>true));
                        echo $form->textFieldRow($model,'ruangan_nama',array('value'=>$modruangan->ruangan_nama,'readonly'=>true,'class'=>'span2',));
                    ?>
                <div>
                        <?php echo CHtml::label('Kelas Pelayanan','',array('class'=>'control-label required')); ?>
                        <div class="controls">
                                        <?php echo $form->hiddenField($model,'kelaspelayanan_id', array('readonly'=>true)) ?>
                                        <?php $this->widget('MyJuiAutoComplete', array(
                                                               'name'=>'kelaspelayanan', 
                                                                'source'=>'js: function(request, response) {
                                                                       $.ajax({
                                                                           url: "'.Yii::app()->createUrl('ActionAutoComplete/Kelaspelayanan').'",
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
                                                                           'minLength' => 3,
                                                                           'focus'=> 'js:function( event, ui )
                                                                               {
                                                                                $(this).val(ui.item.label);
                                                                                return false;
                                                                                }',
                                                                           'select'=>'js:function( event, ui ) {
                                                                               $(\'#KelasruanganM_kelaspelayanan_id\').val(ui.item.value);
                                                                               $(\'#kelaspelayanan\').val("");
                                                                               submitdatakelasruangan();
                                                                                return false;
                                                                            }',
                                                                ),
                                                                'htmlOptions'=>array(
                                                                    'readonly'=>false,
                                                                    'placeholder'=>'Kelas Pelayanan',
                                                                    'size'=>13,
                                                                    'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                ),
                                                                'tombolDialog'=>array('idDialog'=>'dialogkelaspelayanan'),
                                                        )); ?>
                        </div>
        <table id="tabelkelasruangan" class="table table-bordered table-striped table-condensed">
            <thead>
            <tr>
                <th>Nama Instalasi</th>
                <th>Ruangan</th>
                <th>Nama Kelas Pelayanan</th>
                <th>Nama Lain</th>
                <th>Batal</th>
            </tr>
            </thead>
            <tbody>
                <?php
                    if (count((array)$modDetails)>0) {
                        foreach ($modDetails as $i=>$row) {
                                $modruangan = RuanganM::model()->findByPK($row->ruangan_id);
                                $modKelaspelayanan = KelaspelayananM::model()->findByPK($row->kelaspelayanan_id);
                                $tr = "<tr>";
                                $tr .= "<td>"
                                            .$modruangan->instalasi->instalasi_nama
                                            .CHtml::hiddenField('ruangan_id['.$i.']',$row->ruangan_id,array('readonly'=>true))
                                            .CHtml::hiddenField('kelaspelayanan_id[]',$row->kelaspelayanan_id,array('readonly'=>true))
                                            ."</td>";
                                $tr .= "<td>".$modruangan->ruangan_nama."</td>";
                                $tr .= "<td>".$modKelaspelayanan->kelaspelayanan_nama."</td>";
                                $tr .= "<td>".$modKelaspelayanan->kelaspelayanan_namalainnya."</td>";
                                $tr .= "<td>".CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick'=>'remove(this);'))."</td>";
                                $tr .= "</tr>";
                        echo $tr;
                        }
                    }
                ?>
                </tbody>
        </table>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                    array('class' => 'btn btn-danger', 'type'=>'submit', 'id'=>'btn_simpan','onKeyUp'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                    $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), 
                                    array('class' => 'btn btn-default',
                                    'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
                        <?php
                            echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelas Ruangan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
                            $content = $this->renderPartial('bankDarah.views.tips.tipsaddedit3',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
	</div>

<?php $this->endWidget(); ?>
<!--============================== Widget Dialog dialogkelaspelayanan ===============================-->
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'dialogkelaspelayanan',
        'options'=>array(
            'title'=>'Pencarian Kelas Pelayanan',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>900,
            'height'=>600,
            'resizable'=>false,
        ),
    ));
    
    $modkelaspelayanan = new BDKelaspelayananM;
    $modkelaspelayanan->unsetAttributes();
    if (isset($_GET['BDKelaspelayananM'])) {
        $modkelaspelayanan->attributes = $_GET['BDKelaspelayananM'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'jeniskasuspenyakit-grid',
        'dataProvider'=>$modkelaspelayanan->searchDialog(),
        'filter'=>$modkelaspelayanan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                array(
                                        "class"=>"btn-small",
                                        "id" => "selectKelasruangan",
                                        "onClick" => "\$(\"#KelasruanganM_kelaspelayanan_id\").val($data->kelaspelayanan_id);
                                                              \$(\"#kelaspelayanan\").val(\"\");
                                                              \$(\"#dialogkelaspelayanan\").dialog(\"close\");
                                                              submitdatakelasruangan($data->kelaspelayanan_id);"
                                ))',
            ),
            'kelaspelayanan_nama',
            'kelaspelayanan_namalainnya',
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
$this->endWidget();
?>
<!--======================== endWidget dialogkelaspelayanan =====================================-->
<?php
$urlGetKelasruangan = $this->createUrl('Kelasruangan');
?>
        
<?php
$jscript = <<< JS
function submitdatakelasruangan(kelaspelayanan_id)
{
    instalasi_id = $('#instalasi_id').val();
    ruanganid = $('#ruanganid').val();

    if(kelaspelayanan_id==''){
        myAlert('Silakan pilih jenis kelas pelayanan terlebih dahulu!');
    }else{
        $.post("${urlGetKelasruangan}", {instalasi_id:instalasi_id, ruanganid: ruanganid, kelaspelayanan_id:kelaspelayanan_id,},
        function(data){
            $('#tabelkelasruangan tbody').append(data.tr);
        }, "json");
    }   
}

JS;

Yii::app()->clientScript->registerScript('Jeniskasuspenyakitruangan',$jscript, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
  function hapusBaris(obj)
    {
      $(obj).parent().parent('tr').detach();
    }
</script>