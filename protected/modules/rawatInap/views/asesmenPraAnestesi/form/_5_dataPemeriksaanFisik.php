
<div class='col-sm-12'>
    <div class="control-group kelompok form-ceklis">
        <label class="control-label">Kepala Leher</label>
        <div class="controls">
            <?= $form->radioButton($model, 'is_kelainan_kepalaleher',['value'=>0,'uncheckValue'=>null,'id'=>'is_kelainan_kepalaleher_tidak']) ?> <label for="is_kelainan_kepalaleher_tidak">Tidak ada kelainan</label>
        </div>
        <div class="controls">
            <?= $form->radioButton($model, 'is_kelainan_kepalaleher',['class'=>'open-ket-dis','value'=>1,'uncheckValue'=>null,'id'=>'is_kelainan_kepalaleher_ada']) ?> <label for="is_kelainan_kepalaleher_ada">Ada kelainan</label>
        </div>
        <div class="controls">
            <?= $form->textField($model,'kepalaleher_keterangan',['class'=>'ket-dis']) ?>
        </div>
    </div>    
    
    <div class="control-group kelompok form-ceklis">
        <label class="control-label">Mulut dan Gigi</label>
        <div class="controls">
            <?= $form->radioButton($model, 'is_kelainan_mulutdangigi',['value'=>0,'uncheckValue'=>null,'id'=>'is_kelainan_mulutdangigi_tidak']) ?> <label for="is_kelainan_mulutdangigi_tidak">Tidak ada kelainan</label>
        </div>
        <div class="controls">
            <?= $form->radioButton($model, 'is_kelainan_mulutdangigi',['class'=>'open-ket-dis','value'=>1,'uncheckValue'=>null,'id'=>'is_kelainan_mulutdangigi_ada']) ?> <label for="is_kelainan_mulutdangigi_ada">Ada kelainan</label>
        </div>
        <div class="controls">
            <?= $form->textField($model,'mulutdangigi_keterangan',['class'=>'ket-dis']) ?>
        </div>
    </div>   
    
    <div class="control-group kelompok form-ceklis">
        <label class="control-label">Thorax</label>
        <div class="controls">
            <?= $form->radioButton($model, 'is_kelainan_thorax',['value'=>0,'uncheckValue'=>null,'id'=>'is_kelainan_thorax_tidak']) ?> <label for="is_kelainan_thorax_tidak">Tidak ada kelainan</label>
        </div>
        <div class="controls">
            <?= $form->radioButton($model, 'is_kelainan_thorax',['class'=>'open-ket-dis','value'=>1,'uncheckValue'=>null,'id'=>'is_kelainan_thorax_ada']) ?> <label for="is_kelainan_thorax_ada">Ada kelainan</label>
        </div>
        <div class="controls">
            <?= $form->textField($model,'thorax_keterangan',['class'=>'ket-dis']) ?>
        </div>
    </div>
    
    <div class="control-group kelompok form-ceklis">
        <label class="control-label">Abdomen</label>
        <div class="controls">
            <?= $form->radioButton($model, 'is_kelainan_abdomen',['value'=>0,'uncheckValue'=>null,'id'=>'is_kelainan_abdomen_tidak']) ?> <label for="is_kelainan_abdomen_tidak">Tidak ada kelainan</label>
        </div>
        <div class="controls">
            <?= $form->radioButton($model, 'is_kelainan_abdomen',['class'=>'open-ket-dis','value'=>1,'uncheckValue'=>null,'id'=>'is_kelainan_abdomen_ada']) ?> <label for="is_kelainan_abdomen_ada">Ada kelainan</label>
        </div>
        <div class="controls">
            <?= $form->textField($model,'abdomen_keterangan',['class'=>'ket-dis']) ?>
        </div>
    </div>
    
    <div class="control-group kelompok form-ceklis">
        <label class="control-label">Kardiovaskuler</label>
        <div class="controls">
            <?= $form->radioButton($model, 'is_kelainan_kardiovaskuler',['value'=>0,'uncheckValue'=>null,'id'=>'is_kelainan_kardiovaskuler_tidak']) ?> <label for="is_kelainan_kardiovaskuler_tidak">Tidak ada kelainan</label>
        </div>
        <div class="controls">
            <?= $form->radioButton($model, 'is_kelainan_kardiovaskuler',['class'=>'open-ket-dis','value'=>1,'uncheckValue'=>null,'id'=>'is_kelainan_kardiovaskuler_ada']) ?> <label for="is_kelainan_kardiovaskuler_ada">Ada kelainan</label>
        </div>
        <div class="controls">
            <?= $form->textField($model,'kardiovaskuler_keterangan',['class'=>'ket-dis']) ?>
        </div>
    </div>
    
    <div class="control-group kelompok form-ceklis">
        <label class="control-label">Genito Urinaria</label>
        <div class="controls">
            <?= $form->radioButton($model, 'is_kelainan_genito',['value'=>0,'uncheckValue'=>null,'id'=>'is_kelainan_genito_tidak']) ?> <label for="is_kelainan_genito_tidak">Tidak ada kelainan</label>
        </div>
        <div class="controls">
            <?= $form->radioButton($model, 'is_kelainan_genito',['class'=>'open-ket-dis','value'=>1,'uncheckValue'=>null,'id'=>'is_kelainan_genito_ada']) ?> <label for="is_kelainan_genito_ada">Ada kelainan</label>
        </div>
        <div class="controls">
            <?= $form->textField($model,'genito_keterangan',['class'=>'ket-dis']) ?>
        </div>
    </div>
    
    <div class="control-group kelompok form-ceklis">
        <label class="control-label">Muskuloskeletal</label>
        <div class="controls">
            <?= $form->radioButton($model, 'is_kelainan_muskuloskeletal',['value'=>0,'uncheckValue'=>null,'id'=>'is_kelainan_muskuloskeletal_tidak']) ?> <label for="is_kelainan_muskuloskeletal_tidak">Tidak ada kelainan</label>
        </div>
        <div class="controls">
            <?= $form->radioButton($model, 'is_kelainan_muskuloskeletal',['class'=>'open-ket-dis','value'=>1,'uncheckValue'=>null,'id'=>'is_kelainan_muskuloskeletal_ya']) ?> <label for="is_kelainan_muskuloskeletal_ya">Ada kelainan</label>
        </div>
        <div class="controls">
            <?= $form->textField($model,'muskuloskeletal_keterangan',['class'=>'ket-dis']) ?>
        </div>
    </div>
    
    <div class="control-group kelompok form-ceklis">
        <label class="control-label">Alat Reproduksi</label>
        <div class="controls">
            <?= $form->radioButton($model, 'is_kelainan_reproduksi',['value'=>0,'uncheckValue'=>null,'id'=>'is_kelainan_reproduksi_tidak']) ?> <label for="is_kelainan_reproduksi_tidak">Tidak ada kelainan</label>
        </div>
        <div class="controls">
            <?= $form->radioButton($model, 'is_kelainan_reproduksi',['class'=>'open-ket-dis','value'=>1,'uncheckValue'=>null,'id'=>'is_kelainan_reproduksi_ya']) ?> <label for="is_kelainan_reproduksi_ya">Ada kelainan</label>
        </div>
        <div class="controls">
            <?= $form->textField($model,'reproduksi_keterangan',['class'=>'ket-dis']) ?>
        </div>
    </div>     
</div>

<div class='clear'></div>