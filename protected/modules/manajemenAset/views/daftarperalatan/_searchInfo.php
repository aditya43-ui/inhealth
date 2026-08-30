<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'guinvperalatan-t-search',
    'type'=>'horizontal',
    'focus'=>'#'.CHtml::activeId($model,'invperalatan_kode'),
)); ?>

    <div class="col-sm-6"> 
        <div class="control-group ">
            <?php echo CHtml::label("Nomor Aset",'',array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model,'invperalatan_kode',array('placeholder'=>'Ketik Nomor Aset','class'=>'span3','maxlength'=>20)); ?>        
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label("Jenis Peralatan",'',array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model,'invperalatan_namabrg',array('placeholder'=>'Ketik Nama Barang','class'=>'span3','maxlength'=>20)); ?>        
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Ruangan</label>
            <div class="controls">
                <?php
                    echo CHtml::activeHiddenField($model, 'create_ruangan',['class'=>'ruangan_id']);
                    $this->widget('MyJuiAutoComplete', array(
                        'model'=>$model,
                        'attribute'=>'ruangan_nama',                                
                                'source'=>'js: function(request, response) {
                                    $.ajax({
                                        url: "'.Yii::app()->createUrl('/ActionAutoComplete/getRuangan').'",
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
                                        $(".ruangan_id").val(ui.item.ruangan_id);
                                        $(".ruangan_nama").val(ui.item.ruangan_nama);                                        
                                        return false;
                                    }',
                                ),
                                'htmlOptions'=>array(
                                    'onblur' => 'if(this.value==""){$(".ruangan_id").val("")}',
                                    'class'=>'span3 ruangan_nama',
                                    'placeholder'=>'Ketik Ruangan',
                                    'onkeypress'=>"return $(this).focusNextInputField(event)"
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogRuangan','jsFunction'=>'$("#dialogRuangan").dialog("open");'),
                            )); 
                ?>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Lokasi Aset</label>
            <div class="controls">
                <?php
                    echo CHtml::activeHiddenField($model, 'lokasi_id',['class'=>'lokasi_id']);
                    $this->widget('MyJuiAutoComplete', array(
                        'model'=>$model,
                        'attribute'=>'lokasi_nama',                                
                                'source'=>'js: function(request, response) {
                                    $.ajax({
                                        url: "'.Yii::app()->createUrl('/ActionAutoComplete/getLokasiAset').'",
                                        dataType: "json",
                                        data: {
                                            term: request.term,
                                            notpj:"ya",
                                            ruangan_id: $(".ruangan_id").val()
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
                                        $(".lokasi_id").val(ui.item.lokasi_id);
                                        $(".lokasi_nama").val(ui.item.lokasiaset_namalokasi);                                        
                                        return false;
                                    }',
                                ),
                                'htmlOptions'=>array(
                                    'onblur' => 'if(this.value==""){$(".lokasi_id").val("")}',
                                    'id'=>'lokasi_nama',
                                    'class'=>'span3 lokasi_nama',
                                    'placeholder'=>'Ketik Lokasi',
                                    'onkeypress'=>"return $(this).focusNextInputField(event)"
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogLokasiAset','jsFunction'=>'$("#dialogLokasiAset").dialog("open");refreshGridLokasi()'),
                            )); 
                ?>
            </div>
        </div>
    </div>    
    
    <div class="col-sm-6"> 
        
        <div class="control-group">
            <label class="control-label">Kondisi</label>
            <div class="controls">
                <?= $form->dropDownList($model,'invperalatan_keadaan', LookupM::getItemsUrutan('kondisi_barang'),['empty'=>'-- Pilih --']) ?>
            </div>
        </div>
    </div>
<div class="clear"></div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('Daftarperalatan/Index'), array('class'=>'btn btn-default')); ?>

</div>

<?php $this->endWidget(); ?>


<?php
//========= Dialog buat cari data Lokasi Aset =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogLokasiAset',
    'options' => array(
        'title' => 'Lokasi Aset',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modLokasiAset = new MALokasiasetM('search');
$modLokasiAset->lokasiaset_aktif = true;
if (isset($_GET['MALokasiasetM'])) {
    $modLokasiAset->attributes = $_GET['MALokasiasetM'];
    $modLokasiAset->jenis_lokasi = isset($_GET['MALokasiasetM']['jenis_lokasi'])?$_GET['MALokasiasetM']['jenis_lokasi']:null;    
    $modLokasiAset->lokasiaset_aktif = true;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'lokasiaset-m-grid',
    'dataProvider' => $modLokasiAset->search(),
    'filter' => $modLokasiAset,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'filter' => CHtml::activeHiddenField($modLokasiAset, 'ruangan_id'),
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>",
                        "#",
                        array(
                            "class"=>"btn-small", 
                            "id" => "selectBidang",
                            "onClick" => "
                            $(\".lokasi_id\").val(\'$data->lokasi_id\');
                            $(\".lokasi_nama\").val(\'$data->lokasiaset_namalokasi\');                            
                            $(\'#dialogLokasiAset\').dialog(\'close\');return false;"))'
        ),
        'ruangan_nama',
        'lokasiaset_kode',
        array(
            'header'=>'Nama Lokasi',
            'name'=>'lokasiaset_namalokasi',
        ),
        array(
            'name'=>'jenis_lokasi',
            'filter'=>CHtml::activeDropDownList($modLokasiAset, 'jenis_lokasi', LookupM::getItems('jenis_lokasiaset'), array(
                'empty'=>'-- Pilih --'
            )),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();


$this->renderPartial('grid/_ruangan',[])
?>

<script>
    var refreshGridLokasi = () => {
        var ruangan_id = $(".ruangan_id").val();

        $.fn.yiiGridView.update('lokasiaset-m-grid', {
            data: {
                'MALokasiasetM[ruangan_id]': ruangan_id,
            }
        });
    }
</script>