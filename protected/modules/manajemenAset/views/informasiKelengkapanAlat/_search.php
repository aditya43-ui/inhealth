<?php
/**
* - digunakan sebagai informasi sampel darah
* @author Aida Rahmawati <aidarahmawati@example.com>
**/
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
//    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'informasisampel-r-search',
    'type'=>'horizontal',
)); 
$format = new MyFormatter();
?>

<div class="row-fluid">
    <div class="col-sm-6">     
        
        <div class="control-group">
            <label class="control-label">Jenis Peralatan</label>
            <div class="controls">
                <?php
                    echo CHtml::activeHiddenField($model, 'barang_id',['class'=>'barang_id']);
                    $this->widget('MyJuiAutoComplete', array(
                        'model'=>$model,
                        'attribute'=>'invperalatan_namabrg',                                
                                'source'=>'js: function(request, response) {
                                    $.ajax({
                                        url: "'.Yii::app()->createUrl('/ActionAutoComplete/getBarang').'",
                                        dataType: "json",
                                        data: {
                                            term: request.term,                                     
                                            type: "'.ParamsConst::TYPE_BARANG_INVENTARIS.'"
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
                                        $(".barang_id").val(ui.item.barang_id);
                                        $(".invperalatan_namabrg").val(ui.item.barang_nama);                                        
                                        return false;
                                    }',
                                ),
                                'htmlOptions'=>array(
                                    'onblur' => 'if(this.value==""){$(".barang_id").val("")}',                                            
                                    'class'=>'span3 invperalatan_namabrg',
                                    'placeholder'=>'Ketik jenis peralatan',
                                    'onkeypress'=>"return $(this).focusNextInputField(event)"
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogBarang'),
                            )); 
                ?>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Kode Aset</label>
            <div class="controls">
                <?= CHtml::activeTextField($model, 'invperalatan_kode') ?>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Gedung</label>
            <div class="controls">
                <?php
                    echo CHtml::activeHiddenField($model, 'gedung_id',['class'=>'gedung_id']);
                    $this->widget('MyJuiAutoComplete', array(
                        'model'=>$model,
                        'attribute'=>'gedung_nama',                                
                                'source'=>'js: function(request, response) {
                                    $.ajax({
                                        url: "'.Yii::app()->createUrl('/ActionAutoComplete/getGedung').'",
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
                                        $(".gedung_id").val(ui.item.gedung_id);
                                        $(".gedung_nama").val(ui.item.gedung_nama);                                        
                                        return false;
                                    }',
                                ),
                                'htmlOptions'=>array(
                                    'onblur' => 'if(this.value==""){$(".gedung_id").val("")}',                                            
                                    'class'=>'span3 gedung_nama',
                                    'placeholder'=>'Ketik gedung',
                                    'onkeypress'=>"return $(this).focusNextInputField(event)"
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogGedung'),
                            )); 
                ?>
            </div>
        </div>
        	
                
</div>

<div class="col-sm-6">
    <div class="control-group">
            <label class="control-label">Ruangan Aset</label>
            <div class="controls">
                <?php
                    echo CHtml::activeHiddenField($model, 'ruangan_id',['class'=>'ruangan_id']);
                    $this->widget('MyJuiAutoComplete', array(
                        'model'=>$model,
                        'attribute'=>'ruangan_nama',                                
                                'source'=>'js: function(request, response) {
                                    $.ajax({
                                        url: "'.Yii::app()->createUrl('/ActionAutoComplete/getRuangan').'",
                                        dataType: "json",
                                        data: {
                                            term: request.term,   
                                            gedung_id:$(".gedung_id").val()
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
                                'tombolDialog'=>array('idDialog'=>'dialogRuangan','jsFunction'=>'$("#dialogRuangan").dialog("open");refreshGridRuangan()'),
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
                    'attribute'=>'lokasiaset_namalokasi',                                
                            'source'=>'js: function(request, response) {
                                $.ajax({
                                    url: "'.Yii::app()->createUrl('/ActionAutoComplete/getLokasiAset').'",
                                    dataType: "json",
                                    data: {
                                        term: request.term,                                                
                                        notpj:"ya",
                                        ruangan_id:$(".ruangan_id").val()
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
                                    $(".lokasiaset_namalokasi").val(ui.item.lokasiaset_namalokasi);                                        
                                    return false;
                                }',
                            ),
                            'htmlOptions'=>array(
                                'onblur' => 'if(this.value==""){$(".lokasi_id").val("")}',
                                'class'=>'span3 lokasiaset_namalokasi',
                                'placeholder'=>'Ketik Lokasi',
                                'onkeypress'=>"return $(this).focusNextInputField(event)"
                            ),
                            'tombolDialog'=>array('idDialog'=>'dialogLokasi','jsFunction'=>'$("#dialogLokasi").dialog("open");refreshGridLokasi()'),
                        )); 
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Jenis Kelengkapan</label>
        <div class="controls">
            <?= CHtml::activeDropDownList($model, 'jenis_kelengkapan', LookupM::getItemsUrutan('jeniskelengkapanalat'),['empty'=>'-- Pilih --']) ?>
        </div>
    </div>       
</div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
        $this->createUrl($this->id.'/indexPribadi'), 
        array('class'=>'btn btn-default',
            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-success', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-success', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) ;        
    ?>
    <?php
        $tips = array(
            '0' => 'tanggal',
            '1' => 'cari',
            '2' => 'ulang'
        );
        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>

<script>
    var refreshGridLokasi = () => {
        $.fn.yiiGridView.update('lokasiaset-m-grid', {
            data: {
                'LokasiasetM[ruangan_id]':$(".ruangan_id").val()
            }
	});
    }
    
    var refreshGridRuangan = () => {
        $.fn.yiiGridView.update('ruangan-m-grid', {
            data: {
                'RuanganM[gedung_id]':$(".gedung_id").val()
            }
	});
    }
</script>
