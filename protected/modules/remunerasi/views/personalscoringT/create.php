<?php $linkHalaman = CustomFunction::getUrlByMenuID(2433); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<div class="panel panel-gradient">
    <?php
    if (isset($_GET['sukses'])) {
        if ($_GET['sukses'] == 1) {
            // Yii::app()->user->setFlash("success","Pencatatan Personal Scoring berhasil disimpan!");
        }
    }
    ?>
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Personal <b>Scoring</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Personalscoring Ts' => array('index'),
            'Create',
        );
        ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'personalscoring-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#' . CHtml::activeId($modPegawai, 'nama_pegawai'),
        )); ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $form->errorSummary($model); ?>
        <fieldset class="box" id="form-datapegawai">
            <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                        ?></p>-->
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-user"></i> Data <b>Pegawai</b>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php $this->renderPartial('_formInfoPegawai', array('form' => $form, 'model' => $model, 'modPegawai' => $modPegawai)); ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-credit-card"></i> Data <b>Penilaian</b>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'tglscoring', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $model->tglscoring = (!empty($model->tglscoring) ? date("d/m/Y", strtotime($model->tglscoring)) : null);
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglscoring',
                                'mode' => 'date',
                                'options' => array(
                                    //                                            'dateFormat'=>Params::DATE_FORMAT,
                                    'showOn' => false,
                                    'maxDate' => 'd',
                                    'yearRange' => "-150:+0",
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                ),
                            )); ?>
                        </div>
                        <?php echo $form->labelEx($model, 'periodescoring', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $model->periodescoring = (!empty($model->periodescoring) ? date("d/m/Y", strtotime($model->periodescoring)) : null);
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'periodescoring',
                                'mode' => 'date',
                                'options' => array(
                                    //                                            'dateFormat'=>Params::DATE_FORMAT,
                                    'showOn' => false,
                                    'maxDate' => 'd',
                                    'yearRange' => "-150:+0",
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                ),
                            )); ?>
                        </div>
                        <?php echo $form->labelEx($model, 'sampaidengan', array('class' => 'control-label', 'style' => 'margin-right:25px;')); ?>
                        <div>
                            <?php
                            $model->sampaidengan = (!empty($model->sampaidengan) ? date("d/m/Y", strtotime($model->sampaidengan)) : null);
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'sampaidengan',
                                'mode' => 'date',
                                'options' => array(
                                    //                                            'dateFormat'=>Params::DATE_FORMAT,
                                    'showOn' => false,
                                    'maxDate' => 'd',
                                    'yearRange' => "-150:+0",
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                ),
                            )); ?>
                        </div>
                    </div>
                    <hr>
                    <?php
                    $prov = $modIndexing->search();
                    $prov->criteria->limit = -1;
                    $prov->pagination = false;
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'scoringdetail-t-grid',
                        'dataProvider' => $prov,
                        'itemsCssClass' => 'table table-striped table-condensed',
                        'columns' => array(
                            array(
                                'header' => 'No.',
                                'value' => '$row+1',
                            ),
                            array(
                                'header' => 'Kelompok',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    $n = isset($data->kelrem_id) ? $data->kelrem->kelrem_nama : "";
                                    $h = CHtml::hiddenField('kelrem_id', $data->kelrem_id, array('class' => 'span1', 'id' => 'kelrem_id', 'value' => $data->kelrem_id));
                                    $h .= CHtml::hiddenField('ScoringdetailT[indexing_id][]', $data->indexing_id, array('class' => 'span1', 'id' => 'indexing_id', 'value' => $data->indexing_id));
                                    $h .= CHtml::hiddenField('ScoringdetailT[kelrem_id][]', $data->kelrem_id, array('class' => 'span1', 'id' => 'kelrem_id', 'value' => $data->kelrem_id));
                                    $h .= CHtml::hiddenField('ScoringdetailT[indexing_nilai][]', $data->indexing_nilai, array('class' => 'span1', 'id' => 'indexing_nilai', 'value' => $data->indexing_nilai));
                                    $h .= CHtml::hiddenField('ScoringdetailT[offset][]', $data->indexing_offset, array('class' => 'span1 offset', 'id' => 'offset', 'value' => $data->indexing_offset));
                                    $h .= CHtml::hiddenField('ScoringdetailT[score_ordinal][]', '', array('class' => 'span1 ordinal', 'id' => 'offset'));
                                    return $n . $h;
                                },
                                'footer' => '<b>Total</b>:',
                            ),
                            array(
                                'header' => 'Objek',
                                'value' => '$data->indexing_nama',
                            ),
                            array(
                                'header' => 'Offset',
                                'type' => 'raw',
                                'value' => '$data->indexing_offset',
                                'htmlOptions' => array('style' => 'text-align: right;'),
                                'footerHtmlOptions' => array('style' => 'text-align: right;'),
                            ),
                            array(
                                'header' => 'Index',
                                'value' => 'MyFormatter::formatNumberForPrint($data->indexing_nilai, 2)',
                                'htmlOptions' => array('style' => 'text-align: right;'),
                                'footerHtmlOptions' => array('style' => 'text-align: right;'),
                            ),
                            array(
                                'header' => 'Bobot',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    $det = IndexingdefM::model()->findAllByAttributes(array(
                                        'indexing_id' => $data->indexing_id
                                    ));
                                    if (empty($det)) return CHtml::textField("ScoringdetailT[ratebobot_personal][]", 0, array("class" => "span1 bobot integer2", "id" => "ratebobot_personal", "onkeyup" => "scoring(this);", "style" => "text-align: right"));
                                    $str = "";
                                    $str .= '<select onchange="scoring(this)" class="span2" name="ScoringdetailT[ratebobot_personal][]" id="ScoringdetailT_ratebobot_personal">';
                                    $str .= '<option value="">-- Pilih --</option>';
                                    foreach ($det as $item) {
                                        $str .= '<option value="' . $item->bobot . '">' . $item->indexingdef_nama . '</option>';
                                    }
                                    $str .= '</select>';
                                    /*
						return CHtml::dropDownList("ScoringdetailT[ratebobot_personal][]", null, CHtml::listData($det, 'bobot', 'indexingdef_nama'), array(
							'onchange'=>'scoring(this)',
							'class'=>'span2',
							'empty'=>'-- Pilih --',
						));*/
                                    return $str;
                                },
                                //'footer'=>$modIndexing->getTotalbobot(),
                                'htmlOptions' => array('style' => 'text-align: right;'),
                                'footerHtmlOptions' => array('style' => 'text-align: right;'),
                            ),
                            array(
                                'header' => 'Score',
                                'type' => 'raw',
                                'value' => 'CHtml::textField("ScoringdetailT[score_personal][]"," ",array("class"=>"span1 score", "id"=>"score_personal", "readonly"=>true, "style"=>"text-align: right"))',
                                'footer' => $modIndexing->getTotalscore(),
                                'htmlOptions' => array('style' => 'text-align: right;'),
                                'footerHtmlOptions' => array('style' => 'text-align: right;'),
                            ),
                        ),
                    )); ?>
                </div>
            </div>
            <div class="form-actions">
                <?php
                $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
                $disableSave = false;
                $disableSave = (!empty($_GET['personalscoring_id'])) ? true : (($sukses > 0) ? true : false);
                ?>
                <?php $disablePrint = ($disableSave) ? false : true; ?>
                <?php echo CHtml::htmlButton(
                    $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array(
                        'title' => 'Simpan',
                        'class' => 'btn btn-danger', 'type' => 'submit',
                        'onKeypress' => 'return formSubmit(this,event)',
                        'id' => 'btn_simpan',
                        'name' => 'savescoringdetail',
                        'disabled' => $disableSave,
                        //                                                    'onclick'=>'do_upload()',
                    )
                );
                ?>
                <?php if (!isset($_GET['frame'])) {
                    echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        $this->createUrl($this->id . '/create'),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default',
                            'onclick' => 'return refreshForm(this);'
                        )
                    );
                } ?>
                <?php
                $content = $this->renderPartial('../tips/transaksi', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                ?>
            </div>
            <?php $this->endWidget(); ?>
    </div>
</div>
<?php
$js = <<< JS
    $(document).ready(function() {
        $("#scoringdetail-t-grid_c7").hide();
        $("#scoringdetail-t-grid_c8").hide();
        $("#scoringdetail-t-grid_c9").hide();
		$("#scoringdetail-t-grid_c10").hide();
        $(".hide").parents("td").hide();
        autoscoring();
        totalbobot();
        totalscore();
    });
    function scoring(obj) {
        var bobot = $(obj).val();
		var ordinal = $(obj).find("option:selected").html();
        nilaiindexing = $(obj).parents("tr").children("td").children("#indexing_nilai").val();
		offset = parseFloat($(obj).parents("tr").children("td").children("#offset").val());
        scorepersonal = offset + (nilaiindexing * bobot);
        $(obj).parents("tr").children("td").children("#score_personal").val(formatFloat(scorepersonal));
		$(obj).parents("tr").children("td").children(".ordinal").val(ordinal);
        totalbobot();
        totalscore();
    }
    function autoscoring() {
        $(".bobot").each(function() {
            bobot = $(this).val();
            nilaiindexing = $(this).parents("tr").children("td").children("#indexing_nilai").val();
            kelrem_id =  $(this).parents("tr").children("td").children("#kelrem_id").val();
			offset = parseFloat($(this).parents("tr").children("td").children("#offset").val());
            gajipokok = $("#gajipokok").val();
			if (nilaiindexing.trim() == "") nilaiindexing = 0;
            //if (kelrem_id == 1) {
            //    scorepersonal = gajipokok/nilaiindexing * bobot;
            //} else {
                scorepersonal = nilaiindexing * bobot;
            //}
            $(this).parents("tr").children("td").children("#score_personal").val(scorepersonal);
        });
    }
    function totalbobot() {
        var totalbobot = 0;
        $(".bobot").each(function() {
            totalbobot += parseFloat($(this).val());
        });
        $("#totalbobot").val(totalbobot);
    }
    function totalscore() {
        var totalscore = 0;
        $(".score").each(function() {
            totalscore += parseFloat(unformatNumber($(this).val()));
        });
        $("#totalscore").val(formatFloat(totalscore));
    }
        index = 1;
    function renameinput(obj) {
        $(obj).parents("tr").find('[name*="ScoringdetailT"]').each(function() {
            var input = $(this).attr('name');
            var data = input.split('ScoringdetailT[]');
            $(this).attr('name','ScoringdetailT['+index+']'+data[1]);
        });
        index++;
    };
JS;
Yii::app()->clientScript->registerScript('validasi', $js, CClientScript::POS_HEAD);
?>
<?php $this->renderPartial('_jsFunctions', array('model' => $model, 'modPegawai' => $modPegawai)); ?>