<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'absensippds-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
        )); 
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
}
$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="row-fluid">
     <div class="control-group">
        <?php echo CHtml::label("Tanggal Pengembalian <i style='color: red'> * </i>", "", array(
                    'class'=>'control-label'
                )); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'pengembalian_tanggal',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)",'style'=>'width:180px;'
                ),
            ));
            ?>
        </div>
    </div>
     <div class="control-group">        
        <?php echo CHtml::label("Pegawai Mengembalikan <span class='required'>*<span>",'',array('class' => 'control-label')); ?>
        <div class="controls">            
            <?php 
                echo $form->hiddenField($model,'pegpengembali_id',array('readonly'=>true,));
                $model->pegpeminjam_nama = $model->pegpeminjam->namaLengkap;
                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$model,
                    'attribute' => 'pegpeminjam_nama',
                    'value' => $model->pegpeminjam_nama,
                    'source' => 'js: function(request, response) {
                        $.ajax({
                                url: "' . $this->createUrl('/actionAutoComplete/dropPetugasSemua') . '",
                                dataType: "json",
                                data: {
                                    term: request.term,                                                                                 
                                },
                                success: function (data) {
                                    response(data);
                                }
                        })
                     }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val(ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            setPeminjam(ui.item);
                            return false;
                        }',
                    ),
                    'htmlOptions'=>array(                    
                        'onblur' => 'if(this.value==""){$("#'.CHtml::activeId($model, 'pegpengembali_id').'").val("")}',
                        'class'=>'required','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Ketik Nama Pengembali'),
                ));
            ?>
        </div>
    </div>
    <div class="control-group">        
        <?php echo CHtml::label("Keterangan <span class='required'>*<span>",'',array('class' => 'control-label')); ?>
        <div class="controls">
            <?php 
              echo CHtml::activeTextArea($model, 'pengembalian_catatan',array('class' => 'autogrow required'));
            ?>
        </div>
    </div>
</div>
<div class="row-fluid">
     <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary submit', 
            'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);'));
            echo "&nbsp;";
        if (!isset($_GET['frame'])) {
            echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                $this->createUrl($this->id . '/index'), 
                array('class'=>'btn btn-danger',
                'onclick'=>'return refreshForm(this);'));
    }
    ?> 
</div>

<?php $this->endWidget(); ?>

<?php 
        $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogPegawai',
            'options'=>array(
                'title'=>'Pencarian Peminjam' ,
                'autoOpen'=>false,
                'width' => 760,
                'height' => 600,
                'resizable' => true,
            ),
        )
    );
        	        
    $format = new MyFormatter();
    $modPeg=new PegawaiV('search');
    
    if(isset($_GET['PegawaiV'])){
            $modPeg->attributes=$_GET['PegawaiV'];            
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'dialog-pengirim-m-grid',
            'dataProvider'=>$modPeg->searchAllPegawai(),
            'filter'=>$modPeg,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>function($data) use ($model) {
                                    
                            $res = $data->attributes;
                            $res['namaLengkap'] = $data->namaLengkap;
                            $res['jabatan_nama'] = $data->jabatan_nama;
                            
                            $dt = CJSON::encode($res);
        
                            return CHtml::Link("<i class='icon-form-check'></i>","javascript:;",array("class"=>"btn-small", 
                                        "id" => "selectBahan",
                                        "onClick" => 'setPeminjam('.$dt.');'));
                        },
                    ),
                    array(
                        'name'=>'nomorindukpegawai',
                        'value'=>'$data->nomorindukpegawai',
                    ),
                    array(
                        'name'=>'nama_pegawai',
                        'value'=>'$data->namaLengkap',
                    ),                    
                    array(
                        'header' => 'Jabatan',
                        'name'=>'jabatan_id',
                        'value'=>'$data->jabatan_nama',
                        'filter' => CHtml::activeDropDownList($modPeg, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"),'jabatan_id','jabatan_nama'),array('empty' => '-- Pilih --'))
                    ),
                    array(
                        'header' => 'Unit Kerja',
                        'name'=>'unitkerja_id',
                        'value'=>'$data->namaunitkerja',
                        'filter' => CHtml::activeDropDownList($modPeg, 'unitkerja_id', CHtml::listData(UnitkerjaM::model()->findAll("unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC"),'unitkerja_id','namaunitkerja'),array('empty' => '-- Pilih --'))
                    ),
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog'); 

?>

<script type="text/javascript">
    
    function setPeminjam(data){
        $("#<?php echo CHtml::activeId($model, 'pegpengembali_id') ?>").val(data.pegawai_id);
        $("#<?php echo CHtml::activeId($model, 'pegpeminjam_nama') ?>").val(data.namaLengkap);
        $("#<?php echo CHtml::activeId($model, 'jabatan_nama') ?>").val(data.jabatan_nama);
        $("#<?php echo CHtml::activeId($model, 'nip') ?>").val(data.nomorindukpegawai);
        $("#<?php echo CHtml::activeId($model, 'namaunitkerja') ?>").val(data.namaunitkerja);
        
        $("#dialogPegawai").dialog("close");
    }
    
    function cekForm(){
        if (requiredCheck($("#peminjamanbrg-t-form"))){
            $('#peminjamanbrg-t-form').submit();
        }

       return false;
    }
    function setDialog(jenis,obj){        
        var no = $(obj).parents("tr").data('row');                
        $("#no_row").val(parseInt(no));                
        
        if (jenis == 'peminjam'){
            $("#dialogPegawai").dialog("open");
        }else if (jenis == 'ruangan'){
            $("#dialogRuangan").dialog("open");
        }else if (jenis == 'aset'){
            
            var selected = [];		            
            
            $("#id-detail > tbody > tr").each(function(){
                if ($(this).find('.aset_id').val() != ''){
                    selected.push($(this).find('.aset_id').val());                    
                }
            });                        
            
            $.fn.yiiGridView.update('aset-m-grid2', {
                data: {
                    "InvperalatanT[invperalatan_id]":selected,
                    "InvperalatanT[custom]":'not_invperalatan_id',
                }
            });
            
            $("#dialogAset").dialog("open");
            
            
        }        
    } 
</script>