<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    
    $format = new MyFormatter();
    ?>
   
    <div class="row-fluid">
        <div class="col-sm-6">
            <?= CHtml::hiddenField('type','bar'); ?>
                
            
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
		<div class="control-group">
                <label class="control-label">Ruangan</label>
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
        </div>
        
        <div class="col-sm-6">
            
            
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
        </div>
    </div>
	   
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan')); ?>
		<?php
			echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
			'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
		?>
    </div>
</div>  

<?php
$this->endWidget();
?>


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