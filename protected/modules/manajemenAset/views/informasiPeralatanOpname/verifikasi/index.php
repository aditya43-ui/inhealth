<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'penerimaan-alat-t',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
//    'focus' => '#' . CHtml::activeId($model, 'lemaribankjaringan_nama'),
        ));
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><i class="entypo-credit-card"></i> Detail Aset</div>
    </div>
    <div class="panel-body">
        <?php
            $this->widget('bootstrap.widgets.BootAlert'); 
        ?>
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Nama Aset</label>
                <div class="controls">
                    <?= CHtml::activeHiddenField($model, 'invperalatan_id',['class'=>'inv_invperalatan_id','readonly'=>true]) ?>
                    <?= CHtml::activeTextField($model, 'invperalatan_namabrg',['readonly'=>true]) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Nomor Aset</label>
                <div class="controls">
                    <?= CHtml::activeTextField($model, 'invperalatan_kode',['readonly'=>true]) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Nomor Seri</label>
                <div class="controls">
                    <?= CHtml::activeTextField($model, 'peralatan_noseri',[]) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Pemilik Aset</label>
                <div class="controls">
                    <?= CHtml::activeDropDownList($model, 'pemilikbarang_id', CHtml::listData(PemilikbarangM::model()->findAll("pemilikbarang_aktif = TRUE ORDER BY pemilikbarang_nama ASC"), 'pemilikbarang_id', 'pemilikbarang_nama'),['empty'=>'-- Pilih --']) ?>            
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Asal Aset</label>
                <div class="controls">
                    <?= CHtml::activeDropDownList($model, 'asalaset_id', CHtml::listData(AsalasetM::model()->findAll("asalaset_aktif = TRUE ORDER BY asalaset_nama ASC"), 'asalaset_id', 'asalaset_nama'),['empty'=>'-- Pilih --']) ?>            
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Lokasi Aset</label>
                <div class="controls">
                    <?= CHtml::activeHiddenField($model, 'lokasi_id',['class'=>'lokasi_id']) ?>
                    <?= CHtml::activeHiddenField($model, 'ruangan_id',['class'=>'ruangan_id']) ?>                    
                    <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,                                        
                            'attribute' => 'lokasiaset_namalokasi',
                            'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('/actionAutoComplete/GetLokasiAset') . '",
                                    dataType: "json",
                                    data: {
                                        term: request.term,
                                        notpj:"ya"
                                    },
                                    success: function (data) {
                                            response(data);
                                    }
                                })
                            }',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);
                                        return false;
                                 }',
                                'select' => 'js:function( event, ui ) { 
                                        setLokasi(ui.item)
                                        return false;
                                }',
                            ),
                            'htmlOptions' => array(
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'placeholder' => "Ketik Lokasi Aset ",
                                'class' => 'span3 lokasiaset_namalokasi',
                                'onblur'=>'if(this.value==""){$(".lokasi_id").val("")}'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogLokasi','jsFunction'=>'$("#dialogLokasi").dialog("open");'),    
                        ));
                        ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Ruangan Aset</label>
                <div class="controls">
                    <?= CHtml::activeTextField($model, 'ruanganaset_nama',['class'=>'ruanganaset_nama','readonly'=>true]) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Tanggal Perolehan</label>
                <div class="controls">
                    <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tanggal_perolehan',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3 tanggal_perolehan'
                            ),
                        ));
                    ?>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Merk</label>
                <div class="controls">
                    <?= CHtml::activeTextField($model, 'invperalatan_merk',[]) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Ukuran</label>
                <div class="controls">
                    <?= CHtml::activeTextField($model, 'invperalatan_ukuran',[]) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Bahan</label>
                <div class="controls">
                    <?= CHtml::activeTextField($model, 'invperalatan_bahan',[]) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Tipe/Model</label>
                <div class="controls">
                    <?= CHtml::activeTextField($model, 'peralatan_model',[]) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Cara Perolehan</label>
                <div class="controls">
                    <?= CHtml::activeDropDownList($model, 'cara_perolehan', LookupM::getItemsUrutan('cara_perolehan'),['empty'=>'-- Pilih --']) ?>            
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Sumber Dana</label>
                <div class="controls">
                    <?= CHtml::activeDropDownList($model, 'sumberdana', CHtml::listData(SumberdanaM::model()->findAll("sumberdana_aktif = TRUE ORDER BY sumberdana_nama ASC"), 'sumberdana_nama', 'sumberdana_nama'),['empty'=>'-- Pilih --']) ?>            
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Kondisi <span class="required">*</span></label>
                <div class="controls">
                    <?= CHtml::activeHiddenField($modAset, 'kondisi_awal') ?>
                    <?= CHtml::activeDropDownList($model, 'invperalatan_keadaan', LookupM::getItemsUrutan('kondisi_barang'),['class'=>'required','empty'=>'-- Pilih --']) ?>            
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="form-actions">
            <?php
                if (!isset($_GET['sukses'])){
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Verifikasi', array('{icon}' => '<i class="entypo-check"></i>')), array('id'=>'btn_submit','class' => 'btn btn-info btn-simpan', 'type' => 'submit',));
                }else{
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Verifikasi', array('{icon}' => '<i class="entypo-check"></i>')), array('id'=>'btn_submit','class' => 'btn btn-info btn-simpan', 'type' => 'button','disabled'=>true));
                }
            ?>
        </div>
    </div>
</div>

<?php
$this->endWidget(); 



$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogLokasi',
    'options'=>array(
        'title'=>'Daftar Lokasi Aset',
        'autoOpen'=>false,
        'position'=>['top',20] ,
        'modal'=>true,
        'width'=>550,
        'height'=>600,
        'resizable'=>false,
    ),
));

echo  $this->renderPartial($this->path_view.'grid/_grid_lokasi',['model'=>$modAset], true);


$this->endWidget();
?>

<script>
    var setLokasi = (data) => {
        $(".lokasi_id").val(data.lokasi_id);
        $(".lokasiaset_namalokasi").val(data.lokasiaset_namalokasi);
        
        $(".ruanganaset_nama").val(data.ruangan_nama);
        $(".ruangan_id").val(data.ruangan_id);
        
        $("#dialogLokasi").dialog('close');
    }
</script>