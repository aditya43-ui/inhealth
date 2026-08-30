<?php if($model->rencanaumumpengadaan_kategori == 'Swakelola'){?>
<div class="row-fluid">
    <div class="col-md-12">
        <div class="control-group">
            <?php echo $form->labelEx($model,'Pelaksanaan Pekerjaan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                  
                  $model->pelaksanaankontrak_tglawal = MyFormatter::formatDateTimeForUser($model->pelaksanaankontrak_tglawal);
                  $model->pelaksanaankontrak_tglakhir = MyFormatter::formatDateTimeForUser($model->pelaksanaankontrak_tglakhir);
                    $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'pelaksanaankontrak_tglawal',
                        'mode'=>'date',
                        'options'=> array(
                            'dateFormat'=>Params::DATE_FORMAT,
                            'showOn' => false,
                        ),
                        'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'required pemanfaatanbarang_tglawal','onchange'=>'ubahMindate_pelaksanaankontrak()','onkeyup'=>"return $(this).focusNextInputField(event)", 'readonly'=>true, 'style'=>'width:180px;'
                        ),
                    ));
                ?>
            </div>
            <div class="controls">
            <label> - </label>
            </div>
            <div class="controls">
                <?php
                    $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'pelaksanaankontrak_tglakhir',
                        'mode'=>'date',
                        'options'=> array(
                            'dateFormat'=>Params::DATE_FORMAT,
                            'showOn' => false,
                        ),
                        'htmlOptions'=>array('placeholder'=>'00/00/0000','onchange'=>'ubahMindate_pelaksanaankontrak()','class'=>'pelaksanaankontrak_tglakhir', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'readonly'=>false, 'style'=>'width:180px;'
                        ),
                    ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php }else{ ?>
<div class="row-fluid">
    <div class="col-md-12">
        <div class="control-group">
            <?php echo $form->labelEx($model,'Pemanfaatan Barang/Jasa', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                     $model->pemanfaatanbarang_tglawal = MyFormatter::formatDateTimeForUser($model->pemanfaatanbarang_tglawal);
                     $model->pemanfaatanbarang_tglakhir = MyFormatter::formatDateTimeForUser($model->pemanfaatanbarang_tglakhir);
                    
                    $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'pemanfaatanbarang_tglawal',
                        'mode'=>'date',
                        'options'=> array(
                            'dateFormat'=>Params::DATE_FORMAT,
                            'showOn' => false,
                        ),
                        'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'required pemanfaatanbarang_tglawal','onchange'=>'ubahMindate_pemanfaatanbarang()','onkeyup'=>"return $(this).focusNextInputField(event)", 'readonly'=>true, 'style'=>'width:180px;'
                        ),
                    ));
                ?>
            </div>
            <div class="controls">
            <label> - </label>
            </div>
            <div class="controls">
                <?php
                    $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'pemanfaatanbarang_tglakhir',
                        'mode'=>'date',
                        'options'=> array(
                            'dateFormat'=>Params::DATE_FORMAT,
                            'showOn' => false,
                        ),
                        'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'required pemanfaatanbarang_tglakhir','onchange'=>'ubahMindate_pemanfaatanbarang()','onkeyup'=>"return $(this).focusNextInputField(event)", 'readonly'=>true, 'style'=>'width:180px;'
                        ),
                    ));
                ?>
            </div>
        </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="control-group">
            <?php echo $form->labelEx($model,'Pelaksanaan Kontrak', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                    $model->pelaksanaankontrak_tglawal = MyFormatter::formatDateTimeForUser($model->pelaksanaankontrak_tglawal);
                    $model->pelaksanaankontrak_tglakhir = MyFormatter::formatDateTimeForUser($model->pelaksanaankontrak_tglakhir);
                   
                    $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'pelaksanaankontrak_tglawal',
                        'mode'=>'date',
                        'options'=> array(
                            'dateFormat'=>Params::DATE_FORMAT,
                            'showOn' => false,
                        ),
                         'htmlOptions'=>array('placeholder'=>'00/00/0000','onchange'=>'ubahMindate_pelaksanaankontrak()','class'=>'required pelaksanaankontrak_tglawal', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'readonly'=>true, 'style'=>'width:180px;'
                        ),
                    ));
                ?>
            </div>
            <div class="controls">
            <label> - </label>
            </div>
            <div class="controls">
                <?php
                    $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'pelaksanaankontrak_tglakhir',
                        'mode'=>'date',
                        'options'=> array(
                            'dateFormat'=>Params::DATE_FORMAT,
                            'showOn' => false,
                        ),
                        'htmlOptions'=>array('placeholder'=>'00/00/0000','onchange'=>'ubahMindate_pelaksanaankontrak()','class'=>'required pelaksanaankontrak_tglakhir', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'readonly'=>true, 'style'=>'width:180px;'
                        ),
                    ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="control-group">
            <?php echo $form->labelEx($model,'Pelaksanaan Pemilihan Penyedia', array('class' => 'control-label')); ?>
            <?php
            $model->pemilihanpenyedia_tglawal = MyFormatter::formatDateTimeForUser($model->pemilihanpenyedia_tglawal);
            $model->pemilihanpenyedia_tglakhir = MyFormatter::formatDateTimeForUser($model->pemilihanpenyedia_tglakhir);
            
            ?>
            <div class="controls">
                <?php
                    $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'pemilihanpenyedia_tglawal',
                        'mode'=>'date',
                        'options'=> array(
                            'dateFormat'=>Params::DATE_FORMAT,
                            'showOn' => false,
                        ),
                       'htmlOptions'=>array('placeholder'=>'00/00/0000','onchange'=>'ubahMindate_pemilihanpenyedia()','class'=>'required pemilihanpenyedia_tglakhir', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'readonly'=>true, 'style'=>'width:180px;'
                        ),
                    ));
                ?>
            </div>
            <div class="controls">
            <label> - </label>
            </div>
            <div class="controls">
                <?php
                    $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'pemilihanpenyedia_tglakhir',
                        'mode'=>'date',
                        'options'=> array(
                            'dateFormat'=>Params::DATE_FORMAT,
                            'showOn' => false,
                        ),
                        'htmlOptions'=>array('placeholder'=>'00/00/0000','onchange'=>'ubahMindate_pemilihanpenyedia()','class'=>'required pemilihanpenyedia_tglakhir', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'readonly'=>true, 'style'=>'width:180px;'
                        ),
                    ));
                ?>
            </div>
        </div>
    </div>
<?php } ?>

<!-- digunakan untuk cek jadwal lebih besar tanggal akhir
@author  Yusuf Putra Anugrah <yusufputra@.com>
-->
<script>
 function cekJadwal(tanggal_awal,tanggal_akhir){
       
        if(tanggal_awal.val()!="" || tanggal_akhir.val()!=""){ 
        var tanggal_awal_new = new Date(tanggal_awal.val());
        var tanggal_akhir_new = new Date(tanggal_akhir.val());
        if((tanggal_awal_new.getTime() > tanggal_akhir_new.getTime()) || (tanggal_awal_new.getTime() == tanggal_akhir_new.getTime())){
            tanggal_awal.val("");
            tanggal_akhir.val("");
            alert("Warning!!,Tanggal Akhir harus lebih besar dari Tanggal Awal");
            
        }
       
    }
  
 }
</script>