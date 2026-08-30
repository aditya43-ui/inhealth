<div class="col-sm-6 ">
    <div class="control-group dataradio">
        <label class="control-label">Pembayaran Uang Muka</label>
        <div class="controls">
            <?php echo $form->radioButton($model,'isuangmuka',array('uncheckValue'=>'tidak', 'value' => true)); ?><label>Ya</label>
        </div>
        <div class="controls">
            <label>&nbsp;&nbsp;&nbsp;</label>
        </div>
        <div class="controls">
            <?php echo $form->radioButton($model,'isuangmuka',array('uncheckValue'=>'tidak', 'value' => false)); ?><label>Tidak</label>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Batas Akhir Waktu Penerbitan SPP</label>
        <div class="controls">
            <?php 
                echo $form->textField($model,'batas_spp', array('class' => 'span1 numbers-only'));        
            ?>
        </div>
        <div class="controls">
            <label>hari</label>
        </div>
    </div>
       
   <div class="control-group">
        <label class="control-label">Dokumen yang Disyaratkan, Untuk Mengajukan Tagihan Pembayaran </label>
        <div class="controls">            
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'dokumen_tagihan',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Sumber Pembiayaan</label>
        <div class="controls">            
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'sumber_pembiayan',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>                    
</div>

<div class="col-sm-6">      
    <?php 
        $readonly = true;
        if ($model->isuangmuka == true) {
            $readonly = false;
        }
    echo $form->textFieldRow($model,'jumlah_uangmuka',array('class' => 'integer-decimal span3', 'readonly' => $readonly)); ?>
    <?php echo $form->dropDownListRow($model,'pencairan_jaminan', LookupM::getItems('pencairanjaminan'),array('empty' => '-- Pilih --','class' => ' span3')); ?>
    <div class="control-group">
        <label class="control-label">Pembayaran Prestasi Pekerjaan</label>
        <div class="controls">            
            <div class="compose-message-editor">
                <?php 
                    echo $form->textArea($model,'pembayaran_pekerjaan',array('class' => 'wysihtml1 form-control', ))
                ?>                        
            </div>
        </div>
    </div>
</div>