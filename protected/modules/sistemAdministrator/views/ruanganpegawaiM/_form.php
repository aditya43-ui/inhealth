<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjkasuspenyakitdiagnosa-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#pegawai',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
)); ?>
<!--<p class="help-block">
    <?php
    // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.'); 
    ?>
    </p>-->
<?php
if (isset($modDetails)) {
    echo $form->errorSummary($modDetails);
} else {
    echo $form->errorSummary($model);
}
?>
<div class="row">
    <div class="col-sm-6">
        <?php
        $instalasi_id = Yii::app()->user->instalasi_id;
        $modInstalasi = InstalasiM::model()->findByPK($instalasi_id);
        echo CHtml::hiddenField('instalasi_id', $instalasi_id);
        echo $form->textFieldRow($model, 'instalasi_nama', array('value' => $modInstalasi->instalasi_nama, 'readonly' => true, 'class' => 'span3'));
        ?>
        <?php
        $ruanganid = Yii::app()->user->ruangan_id;
        $modruangan = RuanganM::model()->findByPK($ruanganid);
        echo CHtml::hiddenField('ruanganid', $ruanganid, array('readonly' => true));
        echo $form->textFieldRow($model, 'ruangan_nama', array('value' => $modruangan->ruangan_nama, 'readonly' => true, 'class' => 'span3',));
        ?>
    </div>
    <div class="col-sm-6">
        <?php echo CHtml::label('Nama Pegawai', '', array('class' => 'control-label required')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true)) ?>
            <?php $this->widget('MyJuiAutoComplete', array(
                'name' => 'pegawai',
                'source' => 'js: function(request, response) {
				$.ajax({
					url: "' . Yii::app()->createUrl('ActionAutoComplete/Pegawai') . '",
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
                    'focus' => 'js:function( event, ui ){
					$(this).val(ui.item.label);
					return false;
				}',
                    'select' => 'js:function( event, ui ) {
					$(\'#RuanganpegawaiM_pegawai_id\').val(ui.item.value);
					$(\'#pegawai\').val("");
					submitruanganpegawai();
					return false;
				}',
                ),
                'htmlOptions' => array(
                    'readonly' => false,
                    'placeholder' => 'Nama Pegawai',
                    'size' => 13,
                    'onkeypress' => "return $(this).focusNextInputField(event);",
                    'class' => 'hurufs-only'
                ),
                'tombolDialog' => array('idDialog' => 'dialogpegawai'),
            )); ?>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Ruangan Pegawai</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table id="tabelKasuspenyakitdiagnosa" class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <th>Nama Instalasi</th>
                    <th>Nama Ruangan</th>
                    <th>Nama Lain</th>
                    <th>Pegawai</th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count((array)$modDetails) > 0) {
                    foreach ($modDetails as $i => $row) {
                        $modinstalasi = InstalasiM::model()->findByPK($row->instalasi_id);
                        $modruangan = RuanganM::model()->findByPK($row->ruangan_id);
                        $modpegawai = PegawaiM::model()->findByPK($row->pegawai_id);
                        $tr = "<tr>";
                        $tr .= "<td>"
                            . $modinstalasi->instalasi_nama
                            . CHtml::hiddenField('ruangan_id[]', $row->ruangan_id, array('readonly' => true))
                            . CHtml::hiddenField('pegawai_id[]', $row->pegawai_id, array('readonly' => true))
                            . "</td>";
                        $tr .= "<td>" . $modruangan->ruangan_nama . "</td>";
                        $tr .= "<td>" . $modruangan->ruangan_namalainnya . "</td>";
                        $tr .= "<td>" . $modpegawai->NamaLengkap . "</td>";
                        $tr .= "<td style='width: 60px; text-align: center;'>" . CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick' => 'hapusBaris(this);')) . "</td>";
                        $tr .= "</tr>";
                        echo $tr;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'onclick' => 'return cekTabel();')
    );
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Ruangan Pegawai', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_view . '../tips/tipsaddedit3', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<!--============================== Widget Dialog Jenis Kasus Penyakit ===============================-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogpegawai',
    'options' => array(
        'title' => 'Pencarian Data Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => true,
    ),
));

$modPegawai = new SAPegawaiM();
$modPegawai->unsetAttributes();
if (isset($_GET['SAPegawaiM'])) {
    $modPegawai->attributes = $_GET['SAPegawaiM'];
    // nama_pegawai = field bayangan yang terdapat pada Modul Induk,  public $pegawai_nama;
    $modPegawai->nama_pegawai = isset($_GET['SAPegawaiM']['nama_pegawai']) ? $_GET['SAPegawaiM']['nama_pegawai'] : null;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-grid',
    'dataProvider' => $modPegawai->searchDialog(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                array(
                                        "class"=>"btn-small",
                                        "id" => "selectPegawai",
                                        "onClick" => "\$(\"#RuanganpegawaiM_pegawai_id\").val($data->pegawai_id);
                                                              \$(\"#pegawai\").val(\"$data->nama_pegawai\");
                                                              \$(\"#dialogpegawai\").dialog(\"close\")
                                                              submitruanganpegawai();"
                                ))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'type' => 'raw',
            'value' => '$data->NamaLengkap',
            //'filter'=>CHtml::activeTextField($model, 'pegawai_id', CHtml::listData(PegawaiM::getPegawaiItems(),'pegawai_id','nama_pegawai'),array('empty'=>'')),
            'filter' => CHtml::activeTextField($modPegawai, 'nama_pegawai', array('class' => 'hurufs-only')),
        ),
        array(
            'header' => 'No. Kartu PNS',
            'value' => '$data->no_kartupegawainegerisipil',
        ),
        array(
            'header' => 'Status',
            // 'class'=>'CCheckBoxColumn',     
            //'selectableRows'=>0,
            //'id'=>'rows',
            //'checked'=>'$data->pegawai_aktif',
            'value' => 'isset($data->pegawai_aktif)?"Aktif":"Tidak Aktif"'
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });'
        . ''
        . '}',

));
$this->endWidget();
?>
<!--======================== endWidget dialogkasuspenyakit =====================================-->
<?php
$urlGetRuanganpegawai = $this->createUrl('Ruanganpegawai');
?>

<?php
$jscript = <<< JS
function submitruanganpegawai()
{
    instalasi_id = $('#instalasi_id').val();
    ruanganid = $('#ruanganid').val();
    pegawai_id = $('#RuanganpegawaiM_pegawai_id').val();                                   
        
    if(pegawai_id==''){
        myAlert('Silakan pilih pegawai terlebih dahulu!');
    }else{
        if (cekList(pegawai_id) == true){
            $.post("${urlGetRuanganpegawai}", {instalasi_id:instalasi_id, ruanganid:ruanganid, pegawai_id:pegawai_id},
            function(data){
                $('#tabelKasuspenyakitdiagnosa').append(data.tr);
            }, "json");
        }
    }   
}
            
function cekTabel()
{
    if ($(".pegawai").length == 0){
        myAlert('Pegawai belum ditambahkan pada tabel pegawai');
        return false;    
    }
}
        
    function cekList(id){
        x = true;
        $('.pegawai').each(function(){
            if ($(this).val() == id){
                myAlert('Pegawai sudah ada di list');
    
                x = false;
            }
        });
        return x;
    }
    
JS;

Yii::app()->clientScript->registerScript('ruanganpegawai', $jscript, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
    function hapusBaris(obj) {
        $(obj).parents('tr').detach();
    }
</script>