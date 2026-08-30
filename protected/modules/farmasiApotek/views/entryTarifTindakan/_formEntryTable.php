<div class="row">
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-briefcase"></i> Entry <b>Table Tindakan </b>
            </div>
        </div>
        <div class="panel-body">
            <?php 
                    echo CHtml::hiddenField('daftartindakan_id', '');
            
            ?>
            <div class="control-group">
            
                <label for="" class="control-label">Kode Tarif</label>
                <div class="controls">
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'daftartindakan_kode',
                        'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('AutocompleteKunjungan') . '",
                                    dataType: "json",
                                    data: {
                                        no_pendaftaran: request.term,
                                        instalasi_id: $("#instalasi_id").val(),
                                    },
                                    success: function (data) {
                                            response(data);
                                    }
                                })
                                }',
                        'options' => array(
                            'minLength' => 4,
                            'focus' => 'js:function( event, ui ) {
                                $(this).val( "");
                                return false;
                            }',
                            'select' => 'js:function( event, ui ) {
                                // $(this).val( ui.item.value);
                                isiDataPasien(ui.item);
                                loadPembayaran(ui.item.pendaftaran_id);
                                return false;
                            }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogTindakan'),
                        'htmlOptions' => array(
                            'placeholder' => 'Kode Tarif', 'class' => 'all-caps span3', 'rel' => 'tooltip', 'title' => 'klik untuk mencari kode tarif',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                        ),
                    ));

                    ?>
                </div>
            </div>

            <div class="control-group">
                <label for="" class="control-label">Uraian Tarif</label>
                <div class="controls">
                    <?= CHtml::textField('daftartindakan_nama', '',['readonly' => true]) ?>
                </div>
            </div>
            <div class="control-group">
                <label for="" class="control-label">Jumlah Tarif</label>
                <div class="controls">
                    <?= CHtml::textField('jumlahtarif', '', []) ?>
                </div>
                <div class="controls">
                    <?php echo CHtml::htmlButton(
                        '<i class="icon-plus icon-white"></i>',
                        array(
                            'onclick' => 'tambahKodeTarif(this);return false;',
                            'class' => 'btn btn-primary',
                            'onkeypress' => "tambahKodeTarif(this);return false;",
                            'rel' => "tooltip",
                            'title' => "Klik untuk menambahkan ke tabel resep",
                        )
                    ); ?>
                </div>
            </div>
            
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-briefcase"></i> Tabel <b>Order Entry Tarif Tindakan </b>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <table class="table table-bordered" id="tabel-tarif">
                <thead>
                    <th>No</th>
                    <th>Kode Tarif</th>
                    <th>Uraian Tarif</th>
                    <th>Tarif</th>
                    <th>Batal</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <?php
        $disablePrint = true;
        $disableSave = false;
        if(isset($_GET['sukses'])) {
            $disableSave = true;
            $disablePrint = false;
        } 

        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit', 'disabled'=>$disableSave,'id'=>'btn_submit')); //formSubmit(this,event)
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'print(\'PRINT\')')).'&nbsp';
        echo  CHtml::link(
            Yii::t(
                'mds',
                '{icon} Print Ulang',
                array('{icon}' => '<i class="entypo-print"></i>')
            ),
            'javascript:;',
            array("title" => "Klik untuk mencetak ulang", "onclick" => 'printUlangTindakan();', "rel" => "tooltip", 'class' => 'btn btn-info')
        );
        echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl($this->id . '/index'),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href = "' .$this->createUrl($this->id . '/index') . '";}); return false;'
            )
        );

    ?>
</div>


<?php $this->renderPartial('_dialogTindakan', [

]) ?>