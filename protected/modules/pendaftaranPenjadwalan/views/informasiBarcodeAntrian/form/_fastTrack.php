<?= CHtml::activeHiddenField($model, 'antrian_id',['class'=>'']); ?>
<div class="control-group">
    <label class="control-label">Penanggung Jawab <span style='color:red !important'>*</span></label>
    <div class="controls">
        <?= CHtml::activeTextField($model, 'nama_pj',['class'=>'required']); ?>
    </div>
</div>

<div class="control-group">
    <label class="control-label">No Rekam Medik</label>
    <div class="controls">
    <?php 
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'no_rekam_medik',                                
                                'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('/actionAutoComplete/pasienInformasi') . '",
                                        dataType: "json",
                                        data: {
                                            no_rekam_medik: request.term,
                                        },
                                        success: function (data) {
                                        console.log(data);
                                                response(data);
                                        }
                                    })
                                 }',
                                'options' => array(
                                    'minLength' => 3,
                                    'focus' => 'js:function( event, ui ) {
                                        $(this).val( "");
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {                                                                                                        
                                        setPasienLama(ui.item);
                                        return false;
                                    }',
                                ),
                                'tombolDialog' => [
                                    'idDialog' => 'setDialogPasien',
                                    'jsFunction' => '$("#setDialogPasien").dialog("open");refreshGridPasien();'
                                ],
                                'htmlOptions' => array(
                                    'placeholder' => 'No. Rekam Medik', 'rel' => 'tooltip', 'title' => 'No. RM untuk mencari pasien',
                                    'class' => 'span3 no_rm_fasttrack input-form-control', 
                                    'style'=>'height:2vw;float:left;'
                                ),
                            ));
                        ?>
    </div>
</div>

<div class="control-group">
    <label class="control-label">Nama Pasien</label>
    <div class="controls">
        <?= CHtml::activeTextField($model, 'nama_pasien',['class'=>'nama_pasien']); ?>
    </div>
</div>

<div class="control-group">
    <label class="control-label">Alasan Fast track <span style='color:red !important'>*</span></label>
    <div class="controls">
        <?= CHtml::activeTextArea($model,'alasan_fasttrack',['rows'=>3,'class'=>'alasan required']); ?>
    </div>
</div>

<div class="form-actions">
                <?= CHtml::htmlButton("Simpan",['class'=>'btn btn-info','onclick'=>'ubahFasttrack('.$model->antrian_id.',"simpan");']) ?>
            </div>
<!-- <div class="form-actions">     
    <?php // CHtml::htmlButton("Simpan",['class'=>'btn btn-info','onclick'=>'ubahPoliklinik('.$model->antrian_id.',"simpan");']) ?>    
</div> -->

<script>
      function setPasienLama(data){
        $("#<?= CHtml::activeId($model, 'no_rekam_medik') ?>").val(data.no_rekam_medik);
        $("#<?= CHtml::activeId($model, 'nama_pasien') ?>").val(data.nama_pasien);
        
        $("#setDialogPasien").dialog("close");
    }



    function refreshGridPasien(){
        $.fn.yiiGridView.update('kunjungan-m-grid',{
            data:{
                'PPPasienM[default]':''
            }
        })
    }

    var ubahPoliklinik = (id, setform = '') => {
        const ruanganId = $("#ruanganpoli_pilih").val();        
        let form = $("#form-jenis-kunjungan");
        let method = 'POST';
        if (setform == 'generate'){
            form = $(".skip");
            method = 'GET';
        }
  
        if (requiredCheck(form)){                    
            $.ajax({
                type: method,
                url: '<?= $this->createUrl('formUbahPoliklinik') ?>',
                data: {
                    formdata: form.find("input,textarea,select").serialize(),  
                    id
                }, 
                dataType: "json",
                success: function(data) {
                    if (setform != 'simpan'){
                        $("#form-jenis-kunjungan").html(data);
                        $("#setDialogPasien").dialog("open");
                    }else{
                        if (data.sukses){
                            myAlert("Data sukses disimpan","Perhatian!");
                            refreshGridPasien();
                            $("#setDialogPasien").dialog("close");
                        }else{
                            Notiflix.Report.Failure("Perhatian!","Data gagal disimpan",'OK');
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });            
        }
    }
    
    </script>