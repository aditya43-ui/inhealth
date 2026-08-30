<!-- <div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">
            <div class="row-fluid">
                <div class="col-sm-4">
                    <?php
                    // echo CHtml::radioButton('bmhp', false, array('value' => 'tengkurap')); 
                    ?>
                    Pemakaian BMHP
                </div>
                <div class="col-sm-3">
                    <?php
                    // echo CHtml::radioButton('alat_medis', false, array('value' => 'telentang')); 
                    ?>
                    Alat Medis
                </div>
                <div class="col-sm-3">
                    <?php
                    // echo $form->textField(
                    //     $model,
                    //     'alat_medis',
                    //     array('class' => 'span3', 'rows' => 3, 'disabled' => true)
                    // );
                    ?>
                </div>
            </div>
        </div>
    </div>
</div> 
<div class="row-fluid">
    <dic class="col-md-12">
        <table class="items table table-striped table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Nama Tindakan</th>
                    <th>Nama Alkes / Alat Medis</th>
                    <th>Jumlah</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </dic>
</div>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">
            <div class="row-fluid">
                <div class="col-sm-3">
                    Paket BMHP
                </div>
                <div class="col-sm-3">
                    <?php
                    // echo $form->textField(
                    //     $model,
                    //     'alat_medis',
                    //     array('class' => 'span3', 'rows' => 3, 'disabled' => true)
                    // );
                    ?>
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="row-fluid">
    <div class="col-sm-12">
        <div class="control-group ">
            <?php echo CHtml::label('Tipe Paket', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $tipepaket_data = TipepaketM::model()->findAll(array(
                    'condition' => 'tipepaket_aktif = true and isbmhp = true and ruangan_id = ' . Yii::app()->user->getState('ruangan_id'), 'order' => 'tipepaket_nama asc',
                ));

                $list_tipepaket = CHtml::listData($tipepaket_data, 'tipepaket_id', 'tipepaket_nama');
                $option_tipepaket = array();

                foreach ($tipepaket_data as $item) {
                    $option_tipepaket[$item->tipepaket_id] = array(
                        'data-isnonpaket' => $item->isnonpaket,
                    );
                }
                echo CHtml::dropDownList('tipepaket_id', '', $list_tipepaket, array('class' => 'span3', 'empty' => 'Pilih', 'options' => $option_tipepaket, 'onchange' => 'changeTipePaketBahanMedis()')); ?>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label('Nama Bahan Medis', '', array('class' => 'control-label')); ?>
            <div class="controls clsnonpaket">
                <?php
                echo CHtml::hiddenField('obatalkes_id');
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'obatalkes_nama',
                    'source' => 'js: function(request, response) {
                    $.ajax({
                        url: "' . $this->createUrl('PemakaianBmhp/AutocompleteObatAlkes') . '",
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
                            $(this).val("");
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $(this).val(ui.item.value);
                            $("#obatalkes_id").val(ui.item.obatalkes_id);
                            tambahPemakaianBahan();
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPemakaianBahan'),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label('jumlah', '', array('class' => 'control-label')); ?>
            <div class="controls clsnonpaket">
                <?php echo CHtml::textField('qtypakaibahan', '1', array('class' => 'span1 integer')) ?>
                <?php echo CHtml::htmlButton(
                    '<i class="icon-plus icon-white"></i>',
                    array(
                        'onclick' => 'tambahPemakaianBahan();return false;',
                        'class' => 'btn btn-primary',
                        'onkeyup' => "tambahPemakaianBahan();",
                        'rel' => "tooltip",
                        'id' => 'btntmbbahanmedis',
                        'title' => "Klik untuk menambahkan Pemakaian Bahan Pasien"
                    )
                ); ?>
            </div>
        </div>
    </div>
</div>
<div style="overflow: auto;">
    <table class="table table-condensed table-bordered" style="width: 1170px !important; max-width: 1200px !important;">
        <thead>
            <th width="50px">No.</th>
            <th width="150px">Uraian Tindakan</th>
            <th width="150px">Tipe Paket</th>
            <th width="100px">Nama Obat / Alkes</th>
            <th width="200px">Jumlah</th>
            <th width="80px">Batal</th>
        </thead>
        <tbody id="tblpemakaianbahan">

        </tbody>
    </table>
</div>