<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Tambah Form CPIS</div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Hari/Tanggal Pemantauan</label>
                <div class="controls">
                    <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tanggalpengkajian',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true),
                        ));
                    ?>
                </div>
            </div>
            
            <div class="contol-group">
                <label class="control-label">Nama Perawat</label>
                <div class="controls">
                    <?php
                        echo $form->hiddenField($model, 'petugaspengkaji_id', ['class'=>'petugaspengkaji_id']);
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'petugaspengkaji_nama',                            
                            'sourceUrl' => $this->createUrl('/actionAutoComplete/getPegawai'),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {                                   
                                    $(this).val(ui.item.namaLengkap);
                                    return false;
                                }',
                                'select' => 'js:function( event, ui ) {
                                    setPetugas(ui.item);
                                    return false;
                                }'
                            ),
                            'htmlOptions' => array(
                                'readonly' => false,
                                'placeholder' => 'Nama Perawat',                                
                                'class' => 'petugaspengkaji_nama span3',
                                'onkeypress' => "return $(this).focusNextInputField(event);",
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPetugas','jsFunction' => '$("#dialogPetugas").dialog("open");refreshGridPetugas();'), 
                        ));
                    ?>
                </div>
            </div>
        </div>
        
        <div class="col-sm-6">
            <?= $form->hiddenField($model,'total_skor',['class'=>'total_skor']) ?>
        </div>
        
        <div class="clear"></div>
        
        <div class="col-sm-12">
            <?= $this->renderPartial('form/_2_2_tabel', ['model'=>$model, 'modDet'=>$modDet, 'form'=>$form], true) ?>
        </div>
    </div>
</div>