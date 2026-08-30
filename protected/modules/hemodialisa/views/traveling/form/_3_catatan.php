<div class="panel panel-success">    
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label"><u>Dialiser</u><br><i>Dializer</i></label>
                <div class="controls">
                    <?= $form->textField($model, 'dialiser', []) ?>                
                </div>
            </div>                        
        </div>
        
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label"><u>Jenis Dialisat</u><br><i>Dialysate Type</i></label>
                <div class="controls">
                    <?= $form->checkBox($model, 'bicarbonate', ['id'=>'bicarbonate']) ?> <label for="bicarbonate">Bicarbonate</label>
                </div>
                <div class="controls">
                    <?= $form->checkBox($model, 'asetat', ['id'=>'asetat']) ?> <label for="asetat">Asetat</label>
                </div>
            </div>
        </div>
        
        <div class="clear"></div>
        
        <div class="col-sm-12">
            <div class="control-group">
                <label class="control-label"><u>Frekuensi Dialisis</u><br><i>Frequency Dialysis</i></label>
                <div class='controls'>
                    <?= $form->checkBox($model, 'minggu_1x', ['id'=>'minggu_1x']) ?>
                </div>
                <div class="controls">
                     <label for="minggu_1x"><u>1x/minggu</u><br/><i>1x/week</i></label>
                </div>
                <div class='controls'>
                    <?= $form->checkBox($model, 'minggu_2x', ['id'=>'minggu_2x']) ?>
                </div>
                <div class="controls">
                     <label for="minggu_2x"><u>2x/minggu</u><br/><i>2x/week</i></label>
                </div>
                <div class='controls'>
                   <?= $form->checkBox($model, 'minggu_3x', ['id'=>'minggu_3x']) ?>
                </div>
                <div class="controls">
                     <label for="minggu_3x"><u>3x/minggu</u><br/><i>3x/week</i></label>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label"><u>Kecepatan Aliran Dialisat</u><br><i>Quick Dialysat (QD)</i></label>
                <div class="controls">
                    <?= $form->checkBox($model, 'menit_300ml', ['id'=>'menit_300ml']) ?> <label for="menit_300ml">300ml/mnt</label>
                </div>
                <div class="controls">
                    <?= $form->checkBox($model, 'menit_400ml', ['id'=>'menit_400ml']) ?> <label for="menit_400ml">400ml/mnt</label>
                </div>
                <div class="controls">
                    <?= $form->checkBox($model, 'menit_500ml', ['id'=>'menit_500ml']) ?> <label for="menit_500ml">500ml/mnt</label>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label"><u>Kecepatan Aliran Darah</u><br><i>Quick Blood (QB)</i></label>
                <div class="controls">
                    <?= $form->checkBox($model, 'kecepatanmenit_150ml', ['id'=>'kecepatanmenit_150ml']) ?> <label for="kecepatanmenit_150ml"><150ml/mnt</label>
                </div>
                <div class="controls">
                    <?= $form->checkBox($model, 'kecepatanmenit_249ml', ['id'=>'kecepatanmenit_249ml']) ?> <label for="kecepatanmenit_249ml">200-249ml/mnt</label>
                </div>
                <div class="controls">
                    <?= $form->checkBox($model, 'kecepatanmenit_250ml', ['id'=>'kecepatanmenit_250ml']) ?> <label for="kecepatanmenit_250ml">>250ml/mnt</label>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label"><u>Lama Hemodialisa</u><br><i>Duration Dialysis</i></label>
                <div class="controls">
                    <?= $form->checkBox($model, 'tigajam', ['id'=>'tigajam']) ?> 
                </div>
                <div class='controls'>
                    <label for="tigajam"><u>3 jam</u><br /><i>3 hours</i></label>
                </div>
                <div class="controls">
                    <?= $form->checkBox($model, 'empatjam', ['id'=>'empatjam']) ?>
                </div>
                <div class='controls'>
                     <label for="empatjam"><u>4 jam</u><br /><i>4 hours</i></label>
                </div>
                <div class="controls">
                    <?= $form->checkBox($model, 'limajam', ['id'=>'limajam']) ?> 
                </div>
                <div class='controls'>
                    <label for="limajam"><u>5 jam</u><br /><i>5 hours</i></label>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label"><u>Akses Vaskuler</u><br><i>Vasuler Access</i></label>
                <div class="controls">
                    <?= $form->checkBox($model, 'femoral', ['id'=>'femoral']) ?> <label for="femoral">Femoral</label>
                </div>
                <div class="controls">
                    <?= $form->checkBox($model, 'av_fistula', ['id'=>'av_fistula']) ?> <label for="av_fistula">AV Fistula</label>
                </div>                
            </div>
            
            <div class="control-group">
                <label class="control-label">Catheter Lumen</label>
                <div class="controls">
                    <?= $form->checkBox($model, 'catlumen_lugular', ['id'=>'catlumen_lugular']) ?> <label for="catlumen_lugular">Lugural</label>
                </div>
                <div class="controls">
                    <?= $form->checkBox($model, 'catlumen_subclavia', ['id'=>'catlumen_subclavia']) ?> <label for="catlumen_subclavia">Subclavia</label>
                </div>
                <div class="controls">
                    <?= $form->checkBox($model, 'catlumen_femoral', ['id'=>'catlumen_femoral']) ?> <label for="catlumen_femoral">Femoral</label>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label"><u>Heparisasi</u><br /><i>Herparinization</i></label>
                <div class="controls">
                    <?= $form->textField($model, 'heparinisasi', ['class'=>'numbers-only span2']) ?>
                </div>                
                <label class="control-label" style="padding-left: 10px;"><u>Bolus</u><br /><i>bolus</i></label>
            </div>
            
            <div class="control-group">
                <label class="control-label"><u>Dosis</u><br /><i>Doze</i></label>
                <div class="controls">
                    <?= $form->textField($model, 'dosis', ['class'=>'numbers-only span2']) ?>
                </div>                
                <div class='controls'>
                    <?= $form->checkBox($model, 'unit_perjam', ['id'=>'unit_perjam']) ?>
                </div>
                <div class="controls">
                     <label for='unit_perjam'><u>Unit/jam</u><br /><i>Unit hours</i></label>
                </div>
                <div class='controls'>
                    <?= $form->checkBox($model, 'tanpa_heparin', ['id'=>'tanpa_heparin']) ?>
                </div>
                <div class="controls">
                     <label for='tanpa_heparin'><u>Tanpa Heparin</u><br /><i>Free Heparin</i></label>
                </div>
                <div class='controls'>
                    <?= $form->checkBox($model, 'lmwh', ['id'=>'lmwh']) ?>
                </div>
                <div class="controls">
                     <label for='lmwh'><u>LMWH</u></label>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label"><u>Tekanan Darah</u><br /><i>Blood Pressure</i></label>
                <div class="controls">
                    <?= $form->textField($model, 'tensi_sistolik', ['class'=>'numbers-only span2']) ?>
                </div>                
                <label class="control-label" style="padding-left: 10px;"><i>Systolic</i></label>
                <div class="controls">
                    <?= $form->textField($model, 'tensi_diastolik', ['class'=>'numbers-only span2']) ?>
                </div>                
                <label class="control-label" style="padding-left: 10px;"><i>Diastolic</i></label>
            </div>
            
            <div class="control-group">
                <label class="control-label"><u>Hasil Laboratorium Terakhir</u><br /><i>Recent Laboratory Data</i></label>
                <div class="controls">
                    <?= $form->textArea($model, 'hasil_lab', []) ?>
                </div>                                
            </div>
            
            <div class="control-group">
                <label class="control-label"><u>BB Kering</u><br /><i>Dry Weight</i></label>
                <div class="controls">
                    <?= $form->textField($model, 'bb_kering', ['class'=>'numbers-only span2']) ?>
                </div>                
                <label class="control-label" style="padding-left: 10px;">kg</label>
                <label class="control-label" style="padding-left: 10px;"><u>Kenaikan Berat Badan</u><br /><i>Average Weight Gain</i></label>
                <div class="controls">
                    <?= $form->textField($model, 'kenaikan_bb', ['class'=>'numbers-only span2']) ?>
                </div>                
                <label class="control-label" style="padding-left: 10px;">kg</label>
            </div>
            
            <div class="control-group">
                <label class="control-label"><u>Masalah yang sering terjadi</u><br /><i>Problem During Dialysis and Comment</i></label>
                <div class="controls">
                    <?= $form->textArea($model, 'masalah_seringterjadi', []) ?>
                </div>                                
            </div>
            
            <div class="control-group">
                <label class="control-label"><u>Obat-obatan</u><br /><i>Medication</i></label>
                <div class="controls">
                    <?= $form->textArea($model, 'obat', []) ?>
                </div>                                
            </div>
        </div>
               
    </div>
</div>