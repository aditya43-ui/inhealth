<div class="form-inputan-penunjang" norow="<?php echo $i; ?>">
<?php echo $form->hiddenField($modPasienMasukPenunjang, '['.$i.']pendaftaran_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, '['.$i.']pasienmasukpenunjang_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php // echo $form->hiddenField($modPasienMasukPenunjang, '['.$i.']ruangan_id', array('readonly'=>true,'class'=>'span3')); ?>
<div class='control-group'>
    <?php echo CHtml::label("Ruangan <span class='required'>*</span>", CHtml::activeId($model,'ruangan_id'),array('class'=>'control-label required'))?>                                   
    <div class='controls'>
        <?php 
        echo $form->dropDownList($modPasienMasukPenunjang,'['.$i.']ruangan_id', CHtml::listData($model->getRuanganLab(), 'ruangan_id', 'ruangan_nama') ,
            array('empty'=>'-- Pilih --',                
                'onchange'=>"setDropdownKelasPelayanan1(this.value);setDropdownDokter1(this.value);",
                'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3 rpenunjang_id',
                'ajax'=>array(
                'type'=>'POST',
                'url'=>$this->createUrl('SetDropdownJenisPenyakit',array('encode'=>false,'namaModel'=>get_class($modPasienMasukPenunjang))),
                'update'=>'#LBPasienmasukpenunjangT_1_jeniskasuspenyakit_id',
                ))
            );
        ?>
    </div>
</div>
<?php echo $form->dropDownListRow($modPasienMasukPenunjang,'['.$i.']jeniskasuspenyakit_id', CHtml::listData($model->getJenisKasusPenyakitItems($modPasienMasukPenunjang->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
<?php echo $form->dropDownListRow($modPasienMasukPenunjang,'['.$i.']kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems($modPasienMasukPenunjang->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>"setKarcis(".$i.");", 'class'=>'span3')); ?>
<div class="control-group">
    <?php echo CHtml::label('PPDS','',array('class'=>'control-label')); ?>
    <div class="controls">
        <?php //echo $form->dropDownList($modPasienMasukPenunjang,'['.$i.']ppds_id', !empty($modPasienMasukPenunjang->ruangan_id)? CHtml::listData($model->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'nama_pegawai') : array() ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); 
        
            echo $form->hiddenField($modPasienMasukPenunjang, '['.$i.']ppds_id', array('readonly' => true, 'class' => 'span4 ppds_id'));

            $this->widget('MyJuiAutoComplete', array(
                'model' => $modPasienMasukPenunjang,
                'attribute' => '['.$i.']ppds_nama',
                'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('/ActionAutoComplete/DropPegDanPPDS') . '",
                            dataType: "json",
                            data: {
                                term: request.term,   
                                ppds:true
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
                            return false;
                        }',
                    'select' => 'js:function( event, ui ) {
                            setPegawai(ui.item,"ppds");
                            return false;
                        }',
                ),
                'htmlOptions' => array(
                    'class' => 'span3  ppds_nama',
                    'placeholder' => 'Ketik Nama PPDS',
                    'onblur' => 'if(this.value==""){$("#LBPasienmasukpenunjangT_'.$i.'_ppds_id").val("");}'
                ),
                'tombolDialog' => array('idDialog' => 'dialogPPDS','jsFunction'=>'setDialog("ppds","dialogPPDS",this);'),
            ));
        
        ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($modPasienMasukPenunjang,'['.$i.']pegawai_id',array('class'=>'control-label')); ?>
    <div class="controls">
        <?php //echo $form->dropDownList($modPasienMasukPenunjang,'['.$i.']pegawai_id', !empty($modPasienMasukPenunjang->ruangan_id)? CHtml::listData($model->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'nama_pegawai') : array() ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); 
            echo $form->hiddenField($modPasienMasukPenunjang, '['.$i.']pegawai_id', array('readonly' => true, 'class' => 'span4 required pegawai_id'));

            $this->widget('MyJuiAutoComplete', array(
                'model' => $modPasienMasukPenunjang,
                'attribute' => '['.$i.']pegawai_nama',
                'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('/ActionAutoComplete/DropPetugasRuangan') . '",
                            dataType: "json",
                            data: {
                                term: request.term,   
                                ruangan_id:'.Yii::app()->user->getState('ruangan_id').',
                                kelompokpegawai_id:'.Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP.'
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
                            return false;
                        }',
                    'select' => 'js:function( event, ui ) {
                            setPegawai(ui.item,"dpjtm",this);
                            return false;
                        }',
                ),
                'htmlOptions' => array(
                    'class' => 'span3 required pegawai_nama',
                    'placeholder' => 'Ketik Nama DPJTM',
                    'onblur' => 'if(this.value==""){$("#LBPasienmasukpenunjangT_'.$i.'_pegawai_id").val("");}'
                ),
                'tombolDialog' => array('idDialog' => 'dialogPetugas','jsFunction'=>'setDialog("dpjtm","dialogPetugas",this);'),
            ));
        
        ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Analis','ppjp_id',array('class'=>'control-label')); ?>
    <div class="controls">
        <?php //echo $form->dropDownList($modPasienMasukPenunjang,'['.$i.']perawat_id', !empty($modPasienMasukPenunjang->ruangan_id)? CHtml::listData(LBPegawaiM::model()->getTenagaLaboratoriums($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'nama_pegawai') : array() ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); 
            echo $form->hiddenField($modPasienMasukPenunjang, '['.$i.']ppjp_id', array('readonly' => true, 'class' => 'span4 ppjp_id'));

            $this->widget('MyJuiAutoComplete', array(
                'model' => $modPasienMasukPenunjang,
                'attribute' => '['.$i.']ppjp_nama',
                'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('/ActionAutoComplete/DropPetugasRuangan') . '",
                            dataType: "json",
                            data: {
                                term: request.term,   
                                ruangan_id:'.Yii::app()->user->getState('ruangan_id').',
                                notkelompokpegawai_id:'.Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP.'
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
                            return false;
                        }',
                    'select' => 'js:function( event, ui ) {
                            setPegawai(ui.item,"analis",this);
                            return false;
                        }',
                ),
                'htmlOptions' => array(
                    'class' => 'span3 ppjp_nama',
                    'placeholder' => 'Ketik Nama Analis',
                    'onblur' => 'if(this.value==""){$("#LBPasienmasukpenunjangT_'.$i.'_ppjp_id").val("");}'
                ),
                'tombolDialog' => array('idDialog' => 'dialogPetugas','jsFunction'=>'setDialog("analis","dialogPetugas",this);'),
            ));
        
        ?>
    </div>
</div>
<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Pilih Pemeriksaan',array('{icon}'=>'<i class="icon-edit icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', "onclick"=>"setChecklistPemeriksaanLab($('#form-pemeriksaan-".$i."'),".$i."); ")); ?>
<div id="form-tindakanpemeriksaan-<?php echo $i;?>" style="overflow-x: scroll;">
    <table class="table table-condensed table-striped">
        <thead>
            <th>No.</th>
            <th>Nama Pemeriksaan</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Tarif</th>
            <th>Total Tarif</th>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
</div>

<script>
    function setDropdownDokter1(ruangan_id)
    {
        $.ajax({
           type:'POST',
           url:'<?php echo $this->createUrl('SetDropdownDokter'); ?>',
           data: {ruangan_id : ruangan_id},//
           dataType: "json",
           success:function(data){
               $("#LBPasienmasukpenunjangT_1_pegawai_id").html(data.listDokter);
               $("#LBPasienmasukpenunjangT_1_ppds_id").html(data.listDokter);
               $("#LBPasienmasukpenunjangT_1_perawat_id").html(data.listPerawat);
           },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    
    function setDropdownKelasPelayanan1(ruangan_id)
    {
        $.ajax({
           type:'POST',
           url:'<?php echo $this->createUrl('SetDropdownKelasPelayanan'); ?>',
           data: {ruangan_id : ruangan_id},//
           dataType: "json",
           success:function(data){
//               $("#<?php // echo CHtml::activeId($modPasienMasukPenunjang,"['.$i.']kelaspelayanan_id");?>").html(data.listKelasPelayaan);
                $("#LBPasienmasukpenunjangT_1_kelaspelayanan_id").html(data.listKelasPelayaan);
           },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }

</script>
