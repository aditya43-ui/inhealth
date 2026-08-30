<div class="panel panel-darkk">
    <span class="group-title">
        Sosial dan Ekonomi
    </span>
    <div class="panel-body">        
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Hubungan pasien dengan anggota keluarga</label>

                <div class="controls">
                    <?php echo $form->checkBox($model,'sosial_hubkeluarga_baik',array('onclick'=>'
                        if($(this).is(":checked")){
                            $("#'.CHtml::activeId($model, 'sosial_hubkeluarga_tidakbaik').'").removeAttr("checked");
                        }
                    ')); ?> <label>Baik</label>
                </div>                        
                <div class="controls">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
                </div>                        
                <div class="controls">
                    <?php echo $form->checkBox($model,'sosial_hubkeluarga_tidakbaik',array('onclick'=>'
                        if($(this).is(":checked")){
                            $("#'.CHtml::activeId($model, 'sosial_hubkeluarga_baik').'").removeAttr("checked");
                        }
                    ')); ?> <label>Tidak Baik</label>
                </div>                        
            </div>
            
            <div class="control-group">
                <label class="control-label">Tempat Tinggal</label>

                <div class="controls">
                    <?php echo $form->checkBox($model,'sosial_tempattinggal_rumahpribadi',array()); ?> <label>Rumah Pribadi</label>
                </div>                        
                <div class="controls">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>                        
                <div class="controls">
                    <?php echo $form->checkBox($model,'sosial_tempattinggal_rumahkeluarga',array()); ?> <label>Rumah Keluarga</label>
                </div>                        
            </div>
            <div class="control-group">
                <label class="control-label"></label>

                <div class="controls">
                    <?php echo $form->checkBox($model,'sosial_tempattinggal_kontrak',array()); ?> <label>Kontrak</label>
                </div>                        
                <div class="controls">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    &nbsp;&nbsp;&nbsp;
                </div>                        
                <div class="controls">
                    <?php echo $form->checkBox($model,'sosial_tempattinggal_pantijompo',array()); ?> <label>Panti Jompo</label>
                </div>                        
            </div>
            
            <div class="control-group">
                <label class="control-label"></label>

                <div class="controls">
                    <?php echo $form->checkBox($model,'sosial_tempattinggal_lainnya',array()); ?> <label>Lain - Lain</label>
                </div>                        
                <div class="controls">
                    <?php echo $form->textField($model,'sosial_tempattinggal_keteranganlain',array('placeholder' => 'Lainnya',
                        'onblur'=>"
                            if($(this).val()!=''){
                                $(".CHtml::activeId($model, 'sosial_tempattinggal_lainnya').").attr('checked',true);
                            }else{
                                $(".CHtml::activeId($model, 'sosial_tempattinggal_lainnya').").removeAttr('checked');
                            }
                        "
                    )); ?>
                </div>                                        
            </div>
        </div>
        
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Penanggung Jawab Perawatan di Rumah</label>
                <div class="controls">
                    <?php echo $form->textField($model,'sosial_penanggungjawab',array('class'=>'span3')) ?>
                </div>
            </div>
        </div>
        
        
    </div>
</div>