<?php  ?>
<?php $this->widget('bootstrap.widgets.BootAlert');  ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'saruangan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model,$moddaftartindakan,$modRiwayatRuangan); ?>
<div class="control-group">
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
</div>    
        <?php //echo $form->textFieldRow($model,'ruangan_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
<label class="control-label" for="bidang">Daftar Tindakan</label>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('daftartindakan_id'); ?>
                        
                    <?php 
                            $this->widget('MyJuiAutoComplete', array(
                                            
                                            'name'=>'daftartindakan_nama',
                                            'source'=>'js: function(request, response) {
                                                           $.ajax({
                                                               url: "'.Yii::app()->createUrl('ActionAutoComplete/Tindakan').'",
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
                                                   'focus'=> 'js:function( event, ui ) {
                                                        $(this).val( ui.item.label);
                                                        return false;
                                                    }',
                                                   'select'=>'js:function( event, ui ) { 
                                                        $("#daftartindakan_id").val(ui.item.daftartindakan_id);
                                                        $("#daftartindakan_nama").val("");
                                                        submitdatatindakanruangan();
                                                        return false;
                                                    }',
                                            ),
                                            'htmlOptions'=>array(
                                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                                            ),
                                            'tombolDialog'=>array('idDialog'=>'dialogTindakan'),
                                        )); 
                         ?>
                        <?php 
                            // echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                            //                             array(
                            //                                     'onclick'=>'submitdatatindakanruangan();
                            //                                                       return false;',
                            //                                     'class'=>'btn btn-primary',
                            //                                     'onkeypress'=>"\$(\"#submitdatatindakanruangan\").val();
                            //                                                                 submitRuanganM();",
                            //                                     'rel'=>"tooltip",
                            //                                     'id'=>'tambahtindakanruangan',  
                            //                                     'title'=>"Klik Untuk Menambahkan Tindakan Ruangan",
                            //                                     )
                            //                             );
                                         ?>
                    </div>
        <table id="tabeltindakanruangan" class="table table-bordered table-striped table-condensed">
            <thead>
            <tr>
                <th>Instalasi</th>
                <th>Ruangan</th>
                <th>Tindakan Ruangan</th>
                <th>Batal</th>
            </tr>
            </thead>
            <tbody>
                <?php
                $ruangan_id = $_GET['id'];
                $modtindakanruangan = TindakanruanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id));
                foreach ($modtindakanruangan as $value)
                {
                    $hapus = Yii::app()->createUrl('rawatJalan/ruanganM/Delete',array('ruangan_id'=>"$value->ruangan_id",'daftartindakan_id'=>"$value->daftartindakan_id"));
                    $tr = '<tr>';
                    $tr .= '<td>'.$modInstalasi->instalasi_nama.'</td>';
                    $tr .= '<td>'.$value->ruangan->ruangan_nama.'</td>';
                    $tr .= '<td>'.$value->daftartindakan->daftartindakan_nama.'</td>';

                    $tr .= '<td>'.CHtml::link("<i class='icon-trash'></i>",$hapus).'</td>';
                    $tr .= '</tr>';
                    echo $tr;
                }
                    if (count($modDetails)>0) {
                        foreach ($modDetails as $i=>$row) {
                                $modruangan = RuanganM::model()->findByPK($row->ruangan_id);
                                $moddaftartindakan = DaftartindakanM::model()->findByPK($row->daftartindakan_id);
                                $tr = "<tr>";
                                $tr .= "<td>"
                                            .$modruangan->instalasi->instalasi_nama
                                            .CHtml::hiddenField('Tindakanruangan['.$i.'][ruangan_id]',$row->ruangan_id,array('readonly'=>true))
                                            .CHtml::hiddenField('Tindakanruangan['.$i.'][daftartindakan_id]',$row->daftartindakan_id,array('readonly'=>true))
                                            ."</td>";
                                $tr .= "<td>".$modruangan->ruangan_nama."</td>";
                                $tr .= "<td>".$moddaftartindakan->daftartindakan_nama."</td>";
                                $tr .= "<td>".CHtml::link("<i class='icon-remove'></i>", '#', array('onclick'=>'hapusBaris(this);'))."</td>";
                                $tr .= "</tr>";
                        echo $tr;
                        }
                    }
                ?>
            </tbody>
</table>
<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/ruanganM/admin'), 
                                    array('class'=>'btn btn-danger',
                                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                        <?php
                            $content = $this->renderPartial('../tips/tipsaddedit3',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
        </div>

<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari data Bidang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogTindakan',
    'options'=>array(
        'title'=>'Daftar Tindakan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modTindakanRad = new TariftindakanperdatotalV('search');
$modTindakanRad->unsetAttributes();
if(isset($_GET['TariftindakanperdatotalV']))
    $modTindakanRad->attributes = $_GET['TariftindakanperdatotalV'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sainstalasi-m-grid',
	'dataProvider'=>$modTindakanRad->search(),
	'filter'=>$modTindakanRad,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectTindakan",
                                    "onClick" => "
                                    $(\"#daftartindakan_id\").val(\'$data->daftartindakan_id\');
                                    $(\"#daftartindakan_nama\").val(\'\');
                                    submitdatatindakanruangan();
                                    $(\'#dialogTindakan\').dialog(\'close\');return false;"))'
                                    
                ),
            'kelompoktindakan_nama',
            'kategoritindakan_nama',
            'daftartindakan_kode',
            'daftartindakan_nama',
            'kelaspelayanan_nama',
            'harga_tariftindakan',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
<?php
$urlGetTindakanruangan = Yii::app()->createUrl('actionAjax/Tindakanruangan');
?>
        
<?php
$jscript = <<< JS
function submitdatatindakanruangan()
{
    daftartindakan_id = $('#daftartindakan_id').val();
    instalasi_id = $('#instalasi_id').val();
    ruanganid = $('#ruanganid').val();

    if(daftartindakan_id==''){
        myAlert('Silakan Pilih Tindakan Ruangan Terlebih Dahulu');
    }else{
        $.post("${urlGetTindakanruangan}", {instalasi_id:instalasi_id, ruanganid: ruanganid, daftartindakan_id:daftartindakan_id,},
        function(data){
        if (data.tr == null){
        myAlert('Daftar Tindakan Sudah Ada');}
            $('#tabeltindakanruangan tbody').append(data.tr);
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