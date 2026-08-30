<?php
/**
 * mencari data
 * issue RSST-2430
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 * 
 */
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'orientasi-r-search',
        'type' => 'horizontal',
    ));
    $format = new MyFormatter();
    ?>
           
        <div class="col-sm-6">
           
            <div class="control-group">
                <label class="control-label">Periode Bulan</label>
                <div class="controls">
                    <?php
                        $this->widget('MyMonthPicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_awal',                            
                            'options' => array(
                                'dateFormat' => Params::MONTH_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'class' => 'span2', 
                                'readonly'=>true,
                                'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                    ?>
                </div>
                <div class="controls">
                    <label>Hingga Bulan :</label>
                </div>
                <div class="controls">
                    <?php
                        $this->widget('MyMonthPicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_akhir',                            
                            'options' => array(
                                'dateFormat' => Params::MONTH_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'class' => 'span2', 
                                'readonly'=>true,
                                'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                    ?>
                </div>
            </div>
            
        </div>

       <div class="col-sm-6">            
            
            <div class="control-group">
                <label class="control-label">Perawat</label>
                <div class="controls">
                    <?php 
                        echo CHtml::activeHiddenField($model, 'pegawai_id',array('class' => 'span3'));
                        $this->widget('MyJuiAutoComplete', array(
                                'model'=>$model,
                                'attribute' => 'nama_pegawai',
                                'source' => 'js: function(request, response) {
                                    $.ajax({
                                            url: "' . $this->createUrl('/actionAutoComplete/dropPetugasRuangan') . '",
                                            dataType: "json",
                                            data: {
                                                term: request.term,     
                                                kelompokpegawai_id: '.json_encode(array(Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, Params::KELOMPOKPEGAWAI_ID_BIDAN)).'
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
                                        $(this).val(ui.item.nama_pegawai);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        setPegawai(ui.item);
                                        return false;
                                    }',
                                ),
                                'tombolDialog'=>array("idDialog"=>'dialogPetugas',),
                                'htmlOptions'=>array(    
                                    'onblur'=>'if(this.value==""){$("#'.CHtml::activeId($model, 'pegawai_id').'").val("");}',
                                    'class'=>'required','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Perawat '),
                            ));
                    
                    ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">SMF</label>
                <div class="controls">
                    <?php 
                        echo CHtml::activeHiddenField($model, 'smf_id',array('class' => 'span3'));
                        $this->widget('MyJuiAutoComplete', array(
                                'model'=>$model,
                                'attribute' => 'smf_nama',
                                'source' => 'js: function(request, response) {
                                    $.ajax({
                                            url: "' . $this->createUrl('/actionAutoComplete/GetUnitKerja') . '",
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
                                        $(this).val(ui.item.namaunitkerja);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        setSMF(ui.item);
                                        return false;
                                    }',
                                ),
                                'tombolDialog'=>array("idDialog"=>'dialogUnitKerja',),
                                'htmlOptions'=>array(    
                                    'onblur'=>'if(this.value==""){$("#'.CHtml::activeId($model, 'smf_id').'").val("");}',
                                    'class'=>'required','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Unit Kerja '),
                            ));
                    
                    ?>
                </div>
            </div>
        </div>
<div class="clear"></div>
        <div class="form-actions">
            <?php
                echo CHtml::link("Cari <i class='".MyIcon::getIcons('cari')."'></i>",'javascript:;',array('class' => 'btn btn-primary','onclick' => 'cariData();'));
            ?>  
        </div>
    
<?php $this->endWidget(); ?>
