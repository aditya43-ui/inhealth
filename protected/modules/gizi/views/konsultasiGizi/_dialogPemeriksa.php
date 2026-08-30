<?php 
//========= Dialog buat cari data pemeriksa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPemeriksa',
    'options'=>array(
        'title'=>'Dokter Pemeriksa',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>500,
        'resizable'=>false,
    ),
));
?> 
<?php 
    $pegawai = new DokterpegawaiV('searchByDokter');
    if (isset($_GET['DokterpegawaiV'])){
        $pegawai->attributes = $_GET['DokterpegawaiV'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'dialogpemeriksaan-m-grid',
	'dataProvider'=>$pegawai->searchByDokter(),
	'filter'=>$pegawai,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-bordered table-condensed',
	'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                "id" => "selectObat",
                                "href"=>"",
                                "onClick"=>"setDokterBaru($data->pegawai_id, this);return false;",
                               // "onClick" => "setTindakanAuto($data->kelaspelayanan_id,$data->daftartindakan_id);return false;"
                               ))',
            ),
//            'pegawai_id',
            'gelardepan',
            array(
                'name'=>'nama_pegawai',
                'header'=>'Nama Dokter',
            ),
            'gelarbelakang_nama',
            'jeniskelamin',
            'agama',
//            'kelaspelayanan_id',
//            array(
//                'header'=>'Kategori',
//                'name'=>'kategoritindakan_nama',
//                'value'=>'$data["kategoritindakan_nama"]',
//            ),
////            array(
////                'header'=>'Kode',
////                'name'=>'daftartindakan_kode',
////                'value'=>'$data["daftartindakan_kode"]',
////            ),
//            array(
//                'header'=>'Nama Tindakan',
//                'name'=>'daftartindakan_nama',
//                'value'=>'$data["daftartindakan_nama"]',
//            ),
//            array(
//                'header'=>'Harga',
//                'value'=>'number_format($data["harga_tariftindakan"])',
//                'htmlOptions'=>array('style'=>'text-align:right'),
//            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); 
?>
    <table>
        <tr>
            <td>
                <?php echo CHtml::hiddenField('baris', '', array('id'=>'rowTindakan','readonly'=>true)) ?>
                <!--<div class="control-group">
                    <?php echo CHtml::activeLabel($modTindakan, 'dokterpemeriksa1_id'); ?>
                    <div class="controls">
                        <?php $this->widget('MyJuiAutoComplete',array(
                                    'name'=>'dokterpemeriksa1_id',
                                    'value'=>'',
                                    'sourceUrl'=> $this->createUrl('GetDokter'),
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 4,
                                       'focus'=> 'js:function( event, ui ) {
                                            $("#dokterpemeriksa1_id").val( ui.item.label);
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                            setDokterPemeriksa1(ui.item);
                                            return false;
                                        }',

                                    ),
                                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
                    </div>
                </div>-->
                <!--<div class="control-group">
                    <?php echo CHtml::activeLabel($modTindakan, 'dokterpemeriksa2_id'); ?>
                    <div class="controls">
                        <?php $this->widget('MyJuiAutoComplete',array(
                                    'name'=>'dokterpemeriksa2_id',
                                    'value'=>'',
                                    'sourceUrl'=> $this->createUrl('GetDokter'),
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 4,
                                       'focus'=> 'js:function( event, ui ) {
                                            $("#dokterpemeriksa2_id").val( ui.item.label);
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                            setDokterPemeriksa2(ui.item);
                                            return false;
                                        }',

                                    ),
                                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modTindakan, 'dokterpendamping_id'); ?>
                    <div class="controls">
                        <?php $this->widget('MyJuiAutoComplete',array(
                                    'name'=>'dokterpendamping_id',
                                    'value'=>'',
                                    'sourceUrl'=> $this->createUrl('GetDokter'),
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 4,
                                       'focus'=> 'js:function( event, ui ) {
                                            $("#dokterpendamping_id").val( ui.item.label);
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                            setDokterPendamping(ui.item);
                                            return false;
                                        }',

                                    ),
                                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modTindakan, 'dokteranastesi_id'); ?>
                    <div class="controls">
                        <?php $this->widget('MyJuiAutoComplete',array(
                                    'name'=>'dokteranastesi_id',
                                    'value'=>'',
                                    'sourceUrl'=> $this->createUrl('GetDokter'),
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 4,
                                       'focus'=> 'js:function( event, ui ) {
                                            $("#dokteranastesi_id").val( ui.item.label);
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                            setDokterAnastesi(ui.item);
                                            return false;
                                        }',

                                    ),
                                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
                    </div>
                </div>
            </td>
            
            <td>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modTindakan, 'dokterdelegasi_id'); ?>
                    <div class="controls">
                        <?php $this->widget('MyJuiAutoComplete',array(
                                    'name'=>'dokterdelegasi_id',
                                    'value'=>'',
                                    'sourceUrl'=> $this->createUrl('GetDokter'),
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 4,
                                       'focus'=> 'js:function( event, ui ) {
                                            $("#dokterdelegasi_id").val( ui.item.label);
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                            setDokterDelegasi(ui.item);
                                            return false;
                                        }',

                                    ),
                                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modTindakan, 'bidan_id'); ?>
                    <div class="controls">
                        <?php $this->widget('MyJuiAutoComplete',array(
                                    'name'=>'bidan_id',
                                    'value'=>'',
                                    'sourceUrl'=> $this->createUrl('GetBidan'),
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 4,
                                       'focus'=> 'js:function( event, ui ) {
                                            $("#bidan_id").val( ui.item.label);
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                            setBidan(ui.item);
                                            return false;
                                        }',

                                    ),
                                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modTindakan, 'suster_id'); ?>
                    <div class="controls">
                        <?php $this->widget('MyJuiAutoComplete',array(
                                    'name'=>'suster_id',
                                    'value'=>'',
                                    'sourceUrl'=> $this->createUrl('GetSuster'),
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 4,
                                       'focus'=> 'js:function( event, ui ) {
                                            $("#suster_id").val( ui.item.label);
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                            setSuster(ui.item);
                                            return false;
                                        }',

                                    ),
                                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modTindakan, 'perawat_id'); ?>
                    <div class="controls">
                        <?php $this->widget('MyJuiAutoComplete',array(
                                    'name'=>'perawat_id',
                                    'value'=>'',
                                    'sourceUrl'=> $this->createUrl('GetPerawat'),
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 4,
                                       'focus'=> 'js:function( event, ui ) {
                                            $("#perawat_id").val( ui.item.label);
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                            setPerawat(ui.item);
                                            return false;
                                        }',

                                    ),
                                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
                    </div>
                </div>-->
            </td>
        </tr>
        <!--<tr>
            <td colspan="2">
                <div class="">
                        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ok',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'onKeypress'=>'return formSubmit(this,event)',
                                                      'onclick'=>'$("#dialogPemeriksa").dialog("close");')); ?>
                </div>
            </td>
        </tr>-->
    </table>
<?php

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end pemeriksa dialog =============================
?>  

<script>
    function setDokterBaru(idPegawai,obj){
        $(obj).parents("tbody").find("tr").removeClass("yellow_background");
        $.get("<?php echo $this->createUrl('GetDokter'); ?>",{idPegawai:idPegawai},function(data){
            $(obj).parents("tr").addClass("yellow_background");
            setDokterPemeriksa1(data[0]);
            $("#dialogPemeriksa").dialog("close");
        },"json");
    }
</script>