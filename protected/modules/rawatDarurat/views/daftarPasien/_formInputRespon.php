<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    //'action' => Yii::app()->createUrl($this->route),
    'method' => 'post',
    'id' => 'respon-time-form',
    'type' => 'horizontal',
    'htmlOptions' => array(),
)); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Respon Time I</div>
            </div>
            <div class="panel-body">
                <div class="control-group ">
                    <?php echo $form->labelEx($respon, 'tgldatang', array('class' => 'control-label','label'=>'Jam Kedatangan Pasien')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $respon,
                            'attribute' => 'tgldatang',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat'=>Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array(
                                'class'=>'span3 tgldatang',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'onchange' => 'hitungResponTime();',
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($respon, 'tglperiksa', array('class' => 'control-label','label'=>'Jam Di Layani / Di Periksa')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $respon,
                            'attribute' => 'tglperiksa',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat'=>Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array(
                                'class'=>'span3 tglperiksa',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'onchange' => 'hitungResponTime();',
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label">Respon Time I</label>
                    <div class="controls">
                        <?php echo CHtml::textField('respon1', "", array('readonly'=>true, 'class'=>'span1')); ?>
                        <label>menit</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Respon Time II</div>
            </div>
            <div class="panel-body">
                <div class="control-group ">
                    <?php echo $form->labelEx($respon, 'pegawai_id', array('class' => 'control-label','label'=>'Dokter Konsulen')) ?>
                    <div class="controls">
                        <?php
                        echo $form->hiddenField($respon, 'pegawai_id', array('class'=>'pegawai_id'));
                        $nama_pegawai = "";

                        $peg = PegawaiM::model()->findByPk($respon->pegawai_id);
                        if (!empty($peg)) {
                            $nama_pegawai = $peg->namaLengkap;
                        }

                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'nama_pegawai',
                            'value' => $nama_pegawai,
                            'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('getDokterRespon') . '",
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
                                    $(".pegawai_id").val(ui.item.value); 
                                    $(this).val( ui.item.label);
                                    return false;
                                }',
                                'select' => 'js:function( event, ui ) {
                                    $(".pegawai_id").val(ui.item.value); 
                                    $(this).val( ui.item.label);
                                    return false;
                                }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'span3 nama_pegawai',
                            ),
                            'tombolDialog' => array(
                                'idDialog' => 'dialogDokter',
                            ),
                        ));

                        ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($respon, 'tglkonsul', array('class' => 'control-label','label'=>'Jam Konsul')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $respon,
                            'attribute' => 'tglkonsul',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat'=>Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array(
                                'class'=>'span3 tglkonsul',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'onchange' => 'hitungResponTime();',
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($respon, 'tglrespon', array('class' => 'control-label','label'=>'Jam Respon')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $respon,
                            'attribute' => 'tglrespon',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat'=>Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array(
                                'class'=>'span3 tglrespon',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'onchange' => 'hitungResponTime();',
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label">Respon Time II</label>
                    <div class="controls">
                        <?php echo CHtml::textField('respon2', "", array('readonly'=>true, 'class'=>'span1')); ?>
                        <label>menit</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Respon Time III</div>
            </div>
            <div class="panel-body">
                <div class="control-group ">
                    <?php echo $form->labelEx($respon, 'tglkeluar', array('class' => 'control-label','label'=>'Jam Keluar Pasien')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $respon,
                            'attribute' => 'tglkeluar',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat'=>Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array(
                                'class'=>'span3 tglkeluar',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'onchange' => 'hitungResponTime();',
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label">Respon Time III</label>
                    <div class="controls">
                        <?php echo CHtml::textField('respon3', "", array('readonly'=>true, 'class'=>'span1')); ?>
                        <label>menit</label>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <strong>Catatan:</strong><br/>
        Mohon untuk pengisian jam respon time diinput secara realtime, dan berurutan sesuai urutan respon time-nya.
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>

</div>


<?php $this->endWidget(); ?>

<script>

function hitungResponTime() {
    var tgldatang = $(".tgldatang").val();
    var tglperiksa = $(".tglperiksa").val();
    var tglkonsul = $(".tglkonsul").val();
    var tglrespon = $(".tglrespon").val();
    var tglkeluar = $(".tglkeluar").val();

    // respon time 1
    if (tgldatang != "" && tglperiksa != "") {
        $("#respon1").val(Math.ceil((konversiWaktu(tglperiksa) - konversiWaktu(tgldatang)) / 60000));
    } else {
        $("#respon1").val("");
    }

    // respon time 2
    if (tglkonsul != "" && tglrespon != "") {
        $("#respon2").val(Math.ceil((konversiWaktu(tglrespon) - konversiWaktu(tglkonsul)) / 60000));
    } else {
        $("#respon2").val("");
    }

    // respon time 3
    if (tgldatang != "" && tglkeluar != "") {
        $("#respon3").val(Math.ceil((konversiWaktu(tglkeluar) - konversiWaktu(tgldatang)) / 60000));
    } else {
        $("#respon3").val("");
    }
}

function konversiWaktu(tanggal) {
    tanggal = tanggal.replace("Mei", "May");
    tanggal = tanggal.replace("Agus", "Aug");
    tanggal = tanggal.replace("Okt", "Oct");
    tanggal = tanggal.replace("Nop", "Nov");
    tanggal = tanggal.replace("Des", "Dec");

    date_tanggal = new Date(tanggal);
    return date_tanggal.getTime();

}

$(document).ready(function() {
    hitungResponTime();
});

</script>


<?php
    //=============================== Dialog DPJP =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogDokter',
            'options'=>array(
                'title'=>'Dokter' ,
                'autoOpen'=>false,
                'width' => 840,
				'height' => 420,
                'resizable' => true,
            ),
        )
    );
	
	$format = new MyFormatter();
	$modDPJP=new PegawaiV('search');
	$modDPJP->unsetAttributes();
	if(isset($_GET['PegawaiV'])){
		$modDPJP->attributes=$_GET['PegawaiV'];
	}
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'dialog-dpjp-m-grid',
		'dataProvider'=>$modDPJP->searchDokter(),
		'filter'=>$modDPJP,
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
                'value'=>function($data) {
                    return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
								"onclick" => "
                                $('.pegawai_id').val('".$data->pegawai_id."');  
                                $('.nama_pegawai').val('".$data->namaLengkap."');  
                                $('#dialogDokter').dialog('close');
                                return false; "));
                },
			),
			array(
                'name'=>'nama_pegawai',
                // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
                'value'=>'$data->namaLengkap',
            ),
		),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');
	//=============================== END DPJP =======================================
?>