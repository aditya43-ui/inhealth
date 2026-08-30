<div class="row-fluid" id="formDetailBarang">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('No. Pengiriman', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modKirimSpesimen, 'no_kirimspesimen', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>

        <div class="control-group ">
            <label class='control-label'>Spesimen ID</label>
            <div class="controls">
                <?php echo CHtml::hiddenField('spesimen_id'); ?>

                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'no_spesimen',
                    'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('autocompleteSpesimen') . '",
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
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                                $(this).val("");
                                return false;
                            }',
                        'select' => 'js:function( event, ui ) {
                                $(this).val(ui.item.value);
                                cekSudahAda(ui.item.no_spesimen,this);
                                setSpesimen();
                                return false;
                            }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Ketik Nomor Spesimen',
                        'class' => 'span3 custom-only',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogSpesimen', 'jsFunction' => 'setCeklisSpesimen(); $("#dialogSpesimen").dialog("open");'),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Instalasi', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modKirimSpesimen, 'instalasikirim_nama', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Ruangan', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modKirimSpesimen, 'ruangankirim_nama', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
    </div>
</div>
<?php
/* ========= Dialog buat cari Spesimen ========================= */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogSpesimen',
    'options' => array(
        'title' => 'Daftar Spesimen',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 600,
        'resizable' => false,
    ),
));

$modSepesimen = new SpesimenT('searchDialog');
//$modSepesimen->unsetAttributes();
if (isset($_GET['SpesimenT'])) {
    $modSepesimen->attributes = $_GET['SpesimenT'];
    $modSepesimen->nama_pasien = $_GET['SpesimenT']['nama_pasien'];
    $modSepesimen->no_rekam_medik = $_GET['SpesimenT']['no_rekam_medik'];
    $modSepesimen->daftartindakan_nama = $_GET['SpesimenT']['daftartindakan_nama'];
    $modSepesimen->samplelab_nama = $_GET['SpesimenT']['samplelab_nama'];
    $modSepesimen->status = $_GET['SpesimenT']['status'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'spesimen-t-grid',
    'dataProvider' => $modSepesimen->searchDialog(),
    'filter' => $modSepesimen,
    'template' => "{summary}\n{items}{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => CHtml::checkBox('pilihSemua', false, array(
                'class' => 'check_all_produk', 'onchange' => 'setSemuaSpesimen(this);'
            )) . ' Pilih Semua',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::checkBox('check', false, array(
                            'no_spesimen' => $data["spesimen_id"],
                            'onchange' => 'setSpesimen(this);',
                            'class' => 'pilih',
                ));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'footer' => CHtml::htmlButton('OK', array('class' => 'btn btn-green', 'onclick' => 'inputSpesimen();'))
        ),
        array(
            'header' => 'Spesimen ID',
            'name' => 'no_spesimen',
            'value' => '$data["no_spesimen"]',
        ),
        array(
            'header' => 'Nama Pasien',
            'name' => 'nama_pasien',
            'value' => function($data){
                echo $data->nama_pasien;
            }
        ),
        array(
            'header' => 'No. Rekam Medik',
            'name' => 'no_rekam_medik',
            'value' => '$data->no_rekam_medik',
        ),
        array(
            'header' => 'Ruangan Asal',
            'name' => 'ruangan_nama',
            'value' => '$data->ruangan_nama',
        ),
        array(
                'header' => 'Waktu Pengambilan Spesimen',
                'name' => 'waktu_pengambilan_spesimen',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->waktu_pengambilan_spesimen)',
                'filter' => 
                        CHtml::activeTextField($modSepesimen, 'waktu_pengambilan_spesimen', array('class'=>'span3','readonly'=>true)),
        ),
        array(
            'header' => 'Jenis Spesimen',
            'name' => 'samplelab_nama',
            'value'=>function ($data) {
                $cekSample = SamplelabM::model()->findByPk($data->samplelab_id);
                if(!empty($cekSample)){
                    echo $cekSample->samplelab_nama;
                }else{
                    echo '-';
                }
            }
        ),
        array(
            'header' => 'Jenis Pemeriksaan',
            'name' => 'daftartindakan_nama',
            'value' => '$data->daftartindakan_nama',
        ),
        array(
            'header' => 'Status',
            'name' => 'status',
            'value' => '$data["status"]',
        ),
    ),
        'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                jQuery("#'.CHtml::activeId($modSepesimen, 'waktu_pengambilan_spesimen').'").daterangepicker({
                    "maxDate": "' . date('m/d/Y') . '",
                    "showDropdowns": true,
                });
            
            }',));
$this->endWidget();
?>

<script>
    $(document).ready(function(){
        $('input[name="SpesimenT[waktu_pengambilan_spesimen]"]').daterangepicker({
            "maxDate": "<?php echo date('m/d/Y') ?>",
            "showDropdowns": true,
        });
        $('input[name="SpesimenT[waktu_pengambilan_spesimen]"]').daterangepicker({
            "maxDate": "<?php echo date('m/d/Y') ?>",
            "showDropdowns": true,
        });
    });
</script>