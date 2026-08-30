<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data Pasien</div>
    </div>
    <div class="panel-body">
        <!--<div class="row-fluid">-->
        <div class="span12">
            <div class="row-fluid">


                <div class="form-horizontal">
                    <div class="col-md-6">
                        <div class="control-group">
                            <label class="control-label">No.Pendaftaran</label>
                            <div class="controls">
                                <?php echo CHtml::hiddenField('pendaftaran_id', '', array('readonly' => true, 'style' => 'width:110px;')); ?>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
//                                    'name'=>$model,
                                    'name' => 'no_pendaftaran',
                                    'source' => 'js: function(request, response) {
                                            $.ajax({
                                                    url: "' . $this->createUrl('AutoCompleteDokter') . '",
                                                    dataType: "json",
                                                    data: {
                                                            term: request.term,
                                                            pendaftaran_id: $("#pendaftaran_id").val(),
                                                    },
                                                    success: function (data) {
                                                            response(data);
                                                    }
                                            })
                                    }',
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 3,
                                        'focus' => 'js:function( event, ui ) {
                                                    $(this).val( ui.item.label);
                                                    return false;
                                             }',
                                        'select' => 'js:function( event, ui ) {
                                                    $("#pendaftaran_id").val(ui.item.pendaftaran_id); 
                                                    $("#no_pendaftaran").val(ui.item.no_pendaftaran);
                                                    return false;
                                            }',
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPendaftaran'),
                                    'htmlOptions' => array('class' => 'span3'),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Tgl.Pendaftaran</label>
                            <div class="controls">
                                <?= CHtml::textField('tgl_pendaftaran', '', array('class' => 'span3', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Umur</label>
                            <div class="controls">
                                <?= CHtml::textField('umur', '', array('class' => 'span3', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Sub Spasial</label>
                            <div class="controls">
                                <?= CHtml::textField('sub_spasial', '', array('class' => 'span3', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Dokter Pemeriksa</label>
                            <div class="controls">
                                <?= CHtml::textField('dokter_pemeriksa', '', array('class' => 'span3', 'readonly' => true)); ?>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="control-group">
                            <label class="control-label">No. Rekam Medik</label>
                            <div class="controls">
                                <?= CHtml::textField('no_rm', '', array('class' => 'span3', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Nama Pasien</label>
                            <div class="controls">
                                <?= CHtml::textField('nama_pasien', '', array('class' => 'span3', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Jenis Kelamin</label>
                            <div class="controls">
                                <?= CHtml::textField('jk', '', array('class' => 'span3', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Jenis Penjamin</label>
                            <div class="controls">
                                <?= CHtml::textField('cara_bayar', '', array('class' => 'span3', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Penjamin</label>
                            <div class="controls">
                                <?= CHtml::textField('penjamin', '', array('class' => 'span3', 'readonly' => true)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--</div>-->
    </div>
</div>