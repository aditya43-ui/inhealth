
<div class="control-group">    
    <div class="controls clear row-fluid">
        <div class="col-sm-2" style="width:125px;text-align: right;">
            <label>Keluhan</label>
        </div>
        <div class="col-sm-10" style="padding:0px;">
            <div class="kelompok">
                <div class="col-sm-1" style="width:1%;padding:0px;">
                    <?= CHtml::activeCheckBox($model, 'is_keluhan_nyeridada',['class'=>'open-ket-dis']) ?>
                </div>
                <div class="col-sm-3" style="width:20%"><label>Nyeri Dada</label></div>
                <div class="col-sm-1" style="text-align: right;"><label>Sejak</label></div>
                <div class="col-sm-2"><?= $form->textField($model,'keluhan_nyeridada_sejak',['class'=>'numbers-only form-control ket-dis']) ?></div>
                <div class="col-sm-1"><label>Tahun</label></div>
            </div>
            
            <div class="clear" style="padding:3px"></div>
                       
            <div class="kelompok">
                <div class="col-sm-1" style="width:1%;padding:0px;">
                    <?= CHtml::activeCheckBox($model, 'is_keluhan_sesak',['class'=>'open-ket-dis']) ?>
                </div>
                <div class="col-sm-3" style="width:20%"><label>Sesak</label></div>
                <div class="col-sm-1" style="text-align: right;"><label>Sejak</label></div>
                <div class="col-sm-2"><?= $form->textField($model,'keluhan_sesak_sejak',['class'=>'numbers-only form-control ket-dis']) ?></div>
                <div class="col-sm-1"><label>Tahun</label></div>
            </div>

            <div class="clear" style="padding:3px"></div>
            
            <div class="kelompok">
                <div class="col-sm-1" style="width:1%;padding:0px;">
                    <?= CHtml::activeCheckBox($model, 'is_keluhan_sakitperut',['class'=>'open-ket-dis']) ?>
                </div>
                <div class="col-sm-3" style="width:20%"><label>Sakit Perut</label></div>
                <div class="col-sm-1" style="text-align: right;"><label>Sejak</label></div>
                <div class="col-sm-2"><?= $form->textField($model,'keluhan_sakitperut_sejak',['class'=>'numbers-only form-control ket-dis']) ?></div>
                <div class="col-sm-1"><label>Tahun</label></div>
            </div>
            
            <div class="clear" style="padding:3px"></div>
                                    
            <div class="kelompok">
                <div class="col-sm-1" style="width:1%;padding:0px;">
                    <?= CHtml::activeCheckBox($model, 'is_keluhan_demam',['class'=>'open-ket-dis']) ?>
                </div>
                <div class="col-sm-3" style="width:20%"><label>Demam</label></div>
                <div class="col-sm-1" style="text-align: right;"><label>Sejak</label></div>
                <div class="col-sm-2"><?= $form->textField($model,'keluhan_demam_sejak',['class'=>'numbers-only form-control ket-dis']) ?></div>
                <div class="col-sm-1"><label>Tahun</label></div>
            </div>
            
            <div class="clear" style="padding:3px"></div>
                         
            <div class="kelompok">
                <div class="col-sm-1" style="width:1%;padding:0px;">
                    <?= CHtml::activeCheckBox($model, 'is_keluhan_bengkak',['class'=>'open-ket-dis']) ?>
                </div>
                <div class="col-sm-3" style="width:20%"><label>Bengkak</label></div>
                <div class="col-sm-1" style="text-align: right;"><label>Sejak</label></div>
                <div class="col-sm-2"><?= $form->textField($model,'keluhan_bengkak_sejak',['class'=>'numbers-only form-control ket-dis']) ?></div>
                <div class="col-sm-1"><label>Tahun</label></div>
            </div>
            
            <div class="clear" style="padding:3px"></div>
                     
            <div class="kelompok">
                <div class="col-sm-1" style="width:1%;padding:0px;">
                    <?= CHtml::activeCheckBox($model, 'is_keluhan_lainnya',['class'=>'open-ket-dis']) ?>
                </div>
                <div class="col-sm-1"><label>Lainnya</label></div>
                <div class="clear" style="padding:3px"></div>
                <div class="col-sm-2" style="padding:0px;width:21%"><?= $form->textField($model,'keterangan_keluhan_lainnya',['class'=>'form-control ket-dis']) ?></div>
                <div class="col-sm-1" style="text-align: right;"><label>Sejak</label></div>
                <div class="col-sm-2"><?= $form->textField($model,'keluhan_lainnya_sejak',['class'=>'numbers-only form-control ket-dis']) ?></div>
                <div class="col-sm-1"><label>Tahun</label></div>
            </div>
        </div>
    </div>
</div>
