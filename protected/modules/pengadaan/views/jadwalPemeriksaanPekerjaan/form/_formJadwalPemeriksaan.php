<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label required">Nomor Penjadwalan <span class="required">*</span></label>
        <div class="controls">
            <?php echo CHtml::activeTextField($model, 'pengadaanjadwalpemeriksaan_nomor', array('readonly' => true)); ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label required">Tanggal Penjadwalan <span class="required">*</span></label>
        <div class="controls">
            <?php 
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'pengadaanjadwalpemeriksaan_tanggal',
                    'mode' => 'datetime',
                    'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                    ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label required">Nomor SPK <span class="required">*</span></label>
        <div class="controls">
            <?php
                echo CHtml::activeHiddenField($model, 'suratperjanjiankerja_id', array('readonly' => true, 'class' => 'span4 suratperjanjiankerja_id',));
                echo CHtml::activeHiddenField($model, 'supplier_id', array('readonly' => true, 'class' => 'span4 supplier_id',));
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'nosuratperjanjiankerja',
                    'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('AutoCompleteSPK') . '",
                                dataType: "json",
                                data: {
                                    term: request.term,                                    
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
                                setJadwal(ui.item);
                                return false;
                            }',
                    ),
                    'htmlOptions' => array(
                        'class' => 'class nospk',
                        'placeholder' => 'Ketik Nomor SPK',  
                        'onblur' => 'if(this.value == ""){clearSPK(this);}'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogSPK'),
                ));
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Nama Pekerjaan</label>
        <div class="controls">
            <?php echo CHtml::activeTextArea($model, 'nama_pekerjaan', array('readonly' => true, 'class'=>'nama_pekerjaan span4 autogrow')); ?>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label required">Tanggal Pemeriksaan <span class="required">*</span></label>
        <div class="controls">
            <?php 
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tanggal_pemeriksaan',
                    'mode' => 'datetime',
                    'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'minDate' => 'd',
                    ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label required">Pemeriksa <span class="required">*</span></label>
        <div class="controls">
            <table class="form-pegpemeriksa">
                <tbody>
                    <?php                     
                    if (!empty($loadDet)){
                        foreach($loadDet as $i => $det){
                            $det->pegpemeriksa_nama = $det->pegpemeriksa->namaLengkap;
                            echo $this->renderPartial($this->path_view.'form/_rowPemeriksa',array('model'=>$det,'i'=>0));
                        }
                    }else{
                        echo $this->renderPartial($this->path_view.'form/_rowPemeriksa',array('model'=>$modDet,'i'=>0));
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    
</div>