<div class="row-fluid">
     <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Indentifikasi Penyakit Berbahaya</strong></div>
        </div>
         <div class="panel-body">
             <div class="col-md-6">
                 <div class="control-group">
                    <div class="control-label">
                        <?php  echo $form->checkBox($modAsesmenawalkeperawatanT,'identifikasipenyakit_ismenular',array('onchange'=>'changeIndetifikasiPenyakitMenular_dws(this);')); ?>
                        <label>Penyakit Menular</label>
                    </div>
                    <div class='controls'>
                        <?php echo $form->textArea($modAsesmenawalkeperawatanT,'identifikasipenyakit_menularketerangan',array('cols'=>1,'rows'=>2,'readonly'=>true, 'class'=>'span3')); ?>
                    </div>
                </div>
             </div>
             <div class="col-md-6">
                 <div class="control-group">
                    <div class="control-label">
                        <?php  echo $form->checkBox($modAsesmenawalkeperawatanT,'identifikasipenyakit_ispenyakitjiwa',array('onchange'=>'changeIndetifikasiPenyakitJiwa_dws(this);')); ?>
                        <label>Penyakit Jiwa</label>
                    </div>
                    <div class='controls'>
                        &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->checkbox($modAsesmenawalkeperawatanT,'identifikasipenyakitjiwa_iscenderungbunuhdiri',array('class'=>'idenpenyakitjiwa','disabled'=>true)); ?>     <label>Kecenderungan Bunuh Diri</label>
                    </div>
                </div>
                 <div class="control-group">
                     <label class="control-label"></label>
                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->checkbox($modAsesmenawalkeperawatanT,'identifikasipenyakitjiwa_isberlakuagresif',array('class'=>'idenpenyakitjiwa','disabled'=>true)); ?>     <label>Berlaku Agresif</label>
                    </div>
                </div>
                <div class="control-group">
                     <label class="control-label"></label>
                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->checkbox($modAsesmenawalkeperawatanT,'identifikasipenyakitjiwa_islainnya',array('class'=>'idenpenyakitjiwa','disabled'=>true,'onchange'=>'setIdenPenyakitJiwaLainnya_dws(this);')); ?>     <label>Lainnya</label>
                        <?php echo $form->textField($modAsesmenawalkeperawatanT, 'identifikasipenyakitjiwa_keteranganlainnya', array('class' => 'span3','readonly'=>true)); ?>
                    </div>
                </div>
             </div>
         </div>
     </div>
</div>
