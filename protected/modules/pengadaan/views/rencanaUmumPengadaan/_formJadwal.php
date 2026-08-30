<table width="100%">
    <body>
        <tr class="penyedia">
            <td>
                <?php echo $form->labelEx($model,'Pemanfaatan Barang/Jasa <span class="required">*</span>',array('class'=>'')); ?>
            </td>
            <td>
                <?php
                    $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'pemanfaatanbarang_tglawal',
                        'mode'=>'date',
                        'options'=> array(
                            'dateFormat'=>Params::DATE_FORMAT,
                            'showOn' => false,
                        ),
                        'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'required pemanfaatanbarang_tglawal','onchange'=>'ubahMindate_pemanfaatanbarang()' ,'onkeyup'=>"return $(this).focusNextInputField(event)", 'readonly'=>true, 'style'=>'width:180px;'
                        ),
                    ));
                ?>
            </td>
            <td>
                <?php echo $form->labelEx($model,'Sampai Dengan <span class="required">*</span>',array('class'=>'')); ?>
            </td>
            <td>
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
            </td>
        </tr>
        
        <tr>
            <td>
                <?php echo $form->labelEx($model,'Pelaksanaan Pekerjaan <span class="required">*</span>',array('class'=>'')); ?>
            </td>
            <td>
                <?php
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
            </td>
            <td>
                <?php echo $form->labelEx($model,'Sampai Dengan <span class="required">*</span>',array('class'=>'')); ?>
            </td>
            <td>
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
            </td>
        </tr>
        
        <tr class="penyedia">
            <td>
                <?php echo $form->labelEx($model,'Pelaksanaan Pemilihan Penyedia <span class="required">*</span>',array('class'=>'')); ?>
            </td>
            <td>
                <?php
                    $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'pemilihanpenyedia_tglawal',
                        'mode'=>'date',
                        'options'=> array(
                            'dateFormat'=>Params::DATE_FORMAT,
                            'showOn' => false,
                        ),
                        'htmlOptions'=>array('placeholder'=>'00/00/0000','onchange'=>'ubahMindate_pemilihanpenyedia()','class'=>'required pemilihanpenyedia_tglawal', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'readonly'=>true, 'style'=>'width:180px;'
                        ),
                    ));
                ?>
            </td>
            <td>
                <?php echo $form->labelEx($model,'Sampai Dengan <span class="required">*</span>',array('class'=>'')); ?>
            </td>
            <td>
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
            </td>
        </tr>
    </body>
</table>
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
            myAlert("Tanggal akhir harus lebih dari tanggal awal");
            
        }
    }
  
 }
</script>