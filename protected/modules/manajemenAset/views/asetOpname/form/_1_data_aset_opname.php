<div class="col-sm-6">    
    <div class="control-group">
        <?= $form->labelEx($model,'pegawai_id',['class'=>'control-label']) ?>
        <div class="controls">
            <?= $form->hiddenField($model,'pegawai_id',['class'=>'span3 pegawai_id', 'readonly'=>true]) ?>
            <?= $form->textField($model,'pegawai_nama',['class'=>'span3 pegawai_nama', 'readonly'=>true]) ?>
        </div>
    </div>
    
    <?= $form->dropDownListRow($model,'periodeasetopname_id', CHtml::listData(PeriodeasetopnameK::model()->findAll(" periodeasetopname_aktif = true ORDER BY tanggal_awal ASC "), 'periodeasetopname_id', 'periodeasetopname_nama'),['class'=>'span3 periodeasetopname_id','empty'=>'-- Pilih --']) ?>
    
    <?= $form->textFieldRow($model, 'asetopname_tanggal', ['class'=>'span3', 'readonly'=> true]) ?>
    
    <div class="control-group">
        <div class="controls">
            <?php
                 echo CHtml::htmlButton(Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary btn-cari', 'type' => 'button','onclick'=>'loadInv();'));
            ?>
        </div>
        <div class="controls">
            <?php
                 echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-danger btn-cari-reset', 'type' => 'button','onclick'=>'resetInv();'));
            ?>
        </div>
    </div>
</div>

<div class="col-sm-6">
    
    <div class="control-group">
        <label class="control-label">Lokasi Aset</label>
        <div class="controls">
            <?php
                $cri = new CDbCriteria();
                $cri->select = " t.lokasi_id, lok.lokasiaset_namalokasi ";
                $cri->join = " JOIN lokasiaset_m lok ON lok.lokasi_id = t.lokasi_id ";
                $cri->addCondition(" pegawai_id = ".Yii::app()->user->getState('pegawai_id')." AND penanggungjawabaset_aktif = TRUE ");
                $cri->order = " lok.lokasiaset_namalokasi ASC ";
                $lokasi = PenanggungjawabasetM::model()->findAll($cri);
            ?>
            <?= $form->dropDownList($model,'lokasi_id', CHtml::listData($lokasi, 'lokasi_id', 'lokasiaset_namalokasi'),['class'=>'span3 lokasi_id','onchange'=>'resetAset()']) ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Kode Lokasi</label>
        <div class="controls">
            <?= $form->textField($model,'kode_internal',['readonly'=>true,'class'=>'kode_internal span3']) ?>
        </div>
    </div>
    
    <div class="control-group ">
        <?php echo $form->labelEx($model, 'invperalatan_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'invperalatan_id',['class'=>'invperalatan_id']); ?>
            <?php
//						$model->daftartindakan_nama = !empty($model->daftartindakan_id) ? $model->daftartindakan->daftartindakan_nama : " ";
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,                                        
                'attribute' => 'invperalatan_kode',
                'source' => 'js: function(request, response) {
                    $.ajax({
                        url: "' . $this->createUrl('/actionAutoComplete/dropInventarisasiAset') . '",
                        dataType: "json",
                        data: {
                            term: request.term,
                            term_for_to:"invperalatan_kode",
                            load_belum_aset_opname:true
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
                            setMesin(ui.item)
                            return false;
                    }',
                ),
                'htmlOptions' => array(
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'placeholder' => "Ketik Nomor Aset",
                    'class' => 'span3 invperalatan_kode',
                    'onblur'=>'if(this.value==""){$("#' . CHtml::activeId($model, 'invperalatan_id') . '").val("")}'
                ),
                'tombolDialog' => array('idDialog' => 'dialogMesin', 'jsFunction'=>'setDialog("dialogMesin");refreshInv();'),

            ));
            ?>
        </div>
    </div>    
    
</div>