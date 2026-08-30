<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.taggd.js'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/css/taggd.css'); ?>
<style>
    .hoveringIcon:hover {
        background-color: #FFA0A2;
        cursor: pointer;
        -webkit-border-radius: 1px;
        -moz-border-radius: 1px;
        -o-border-radius: 1px;
        -border-radius: 1px;
    }

    .taggd:hover {
        cursor: crosshair;
    }

    /*--------------------------*/

    #imgtag {
        position: relative;
        min-width: 300px;
        min-height: 300px;
        float: none;
        border: 3px solid #FFF;
        cursor: crosshair;
        text-align: left;
    }

    .tagview {
        border: 1px solid #F10303;
        width: 100px;
        height: 100px;
        position: absolute;
        /*display:none;*/
        opacity: 0;
        color: #FFFFFF;
        text-align: center;
    }

    .square {
        display: block;
        height: 79px;
    }

    .person {
        background: #282828;
        border-top: 1px solid #F10303;
    }

    #tagit {
        position: absolute;
        top: 0;
        left: 0;
        width: 200px;
        border: 1px solid #D7C7C7;
    }

    /*			#tagit .box
                        {
                                border: 1px solid #F10303;
                                width: 10px;
                                height: 10px;
                                float: left;
                        }*/
    #tagit .name {
        /*float: left;*/
        background-color: #FFF;
        width: 195px;
        /*height: 92px;*/
        /*padding: 5px;*/
        font-size: 10pt;
        margin: 0 auto;
        margin-bottom: 0 auto;
    }

    #tagit DIV.text {
        margin-bottom: 5px;
    }

    #tagit INPUT[type=text] {
        margin-bottom: 5px;
    }
</style>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sabagiantubuh-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#SABagiantubuhM_namabagtubuh',
));
?>
<br>
<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<br>
<?php echo $form->errorSummary($model); ?>
<div class="row">

    <div class="col-md-7 box2">
        <!--<div align="center" id="imgtag">
                                    <img id="myImgId" src="<?php // echo Params::urlPhotoAnatomiTubuh().$modGambarTubuh->UrlFileNameGambar;   
                                                            ?>" class="taggd"/> 
                            <div id="tagbox"></div>
                            </div>-->
        <table class="table noborder kolom-line">
            <tr class="kolom-line">

                <td class="kolom-line" style="line-height: 1.0 !important;">
                    <?php
                    $css = '';
                    if (count((array)$modGambarTubuh->AllDataGambarAnatomi) > 0) {
                        $gbrTubuh = $modGambarTubuh->AllDataGambarAnatomi;

                        foreach ($gbrTubuh as $tbh) {
                    ?>
                            <div align="center" id="imgtag">
                                <img id="myImgId" src="" class="taggd" style="width:377px;" />
                                <div id="canvasbox"></div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </td>
            </tr>
        </table>
    </div>

    <div class="col-sm-6">
        <?php
        $gambar_tubuh = GambartubuhM::model()->findAll('gambartubuh_aktif = true order by nama_gambar');
        $drop_data = CHtml::listData($gambar_tubuh, 'gambartubuh_id', 'nama_gambar');
        $option_data = array();

        foreach ($gambar_tubuh as $item) {
            $option_data[$item->gambartubuh_id] = array(
                'data-link' => Params::urlPhotoAnatomiTubuh() . $item->nama_file_gbr,
            );
        }

        echo $form->dropDownListRow($model, 'gambartubuh_id', $drop_data, array(
            'class' => 'span3', 'empty' => '-- Pilih --',
            'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200,
            'onchange' => 'pilihGambarTubuh(this);', 'options' => $option_data
        ));
        ?>
        <?php echo $form->textFieldRow($model, 'namabagtubuh', array('class' => 'span3', 'placeholder' => 'Bagian Tubuh Manusia', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'bagtubuh_namalain', array('class' => 'span3', 'placeholder' => 'Bagian Tubuh Manusia', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'kordinat_x', array('class' => 'span3 numbers-only', 'placeholder' => 'Koordinat axis X pada gambar tubuh', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'kordinat_y', array('class' => 'span3 numbers-only', 'placeholder' => 'Koordinat axis Y pada gambar tubuh', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'kordinat_x2', array('class' => 'span3 numbers-only', 'placeholder' => 'Koordinat axis X2 pada gambar tubuh', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'kordinat_y2', array('class' => 'span3 numbers-only', 'placeholder' => 'Koordinat axis Y2 pada gambar tubuh', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'bagiantubuh_urutan', array('placeholder' => 'Urutan', 'class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

        <div class="control-group">
            <?php echo CHtml::label("", 'bagiantubuh_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'bagiantubuh_aktif'); ?> <label> Aktif</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Bagian Tubuh', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'], 'tab' => 'frame')),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('sistemAdministrator.views.tips.tipsanatomi', array(), true);
    $this->widget('UserTips', array('type' => 'create', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script>
    var canvas_data;
    var canvas_context;
    var points = new Array();
    var rect = {
        x1: 0,
        y1: 0,
        x2: 0,
        y2: 0
    };
    var is_drag = false;

    function namaLain(nama) {
        document.getElementById('SABagiantubuhM_bagtubuh_namalain').value = nama.value.toUpperCase();
    }

    function pilihGambarTubuh(obj) {
        $("#myImgId").prop("src", $(obj).find(":selected").data('link')).one("load", function() {

            var point = new Array();

            $("#canvasbox").html('<canvas id="canvas_data" width="' + $("#myImgId").width() + '" height="' + $("#myImgId").height() + '" ' +
                'style="position:relative; bottom: ' + ($("#myImgId").height() + 3) + 'px;"' +
                '></canvas>');

            canvas_data = document.getElementById('canvas_data');
            canvas_context = canvas_data.getContext("2d");

            canvas_data.addEventListener('mousedown', canvasMouseDown, false);
            canvas_data.addEventListener('mouseup', canvasMouseUp, false);
            canvas_data.addEventListener('mousemove', canvasMouseMove, false);

            if ($("#SABagiantubuhM_kordinat_x").val() != "" && $("#SABagiantubuhM_kordinat_y").val() != "") {
                rect.x1 = parseFloat($("#SABagiantubuhM_kordinat_x").val()) + 3;
                rect.y1 = parseFloat($("#SABagiantubuhM_kordinat_y").val()) + 3;
                rect.x2 = parseFloat($("#SABagiantubuhM_kordinat_x2").val()) + 3;
                rect.y2 = parseFloat($("#SABagiantubuhM_kordinat_y2").val()) + 3;

                gambarKotak(rect);
            }
        });
    }

    function canvasMouseDown(e) {
        rect.x1 = e.pageX - $("#imgtag").offset().left;
        rect.y1 = e.pageY - $("#imgtag").offset().top;
        is_drag = true;
    }

    function canvasMouseUp(e) {
        if (is_drag) {

            var temp_x = 0;
            var temp_y = 0;

            if (rect.x1 > rect.x2) {
                temp_x = rect.x2;
                rect.x2 = rect.x1;
                rect.x1 = temp_x;
            }
            if (rect.y1 > rect.y2) {
                temp_y = point.y2;
                rect.y2 = rect.y1;
                rect.y1 = temp_y;
            }

            $("#SABagiantubuhM_kordinat_x").val(rect.x1 - 3);
            $("#SABagiantubuhM_kordinat_y").val(rect.y1 - 3);
            $("#SABagiantubuhM_kordinat_x2").val(rect.x2 - 3);
            $("#SABagiantubuhM_kordinat_y2").val(rect.y2 - 3);

            gambarKotak(rect);
        }

        is_drag = false;
    }

    function canvasMouseMove(e) {
        if (is_drag) {
            rect.x2 = e.pageX - $("#imgtag").offset().left;
            rect.y2 = e.pageY - $("#imgtag").offset().top;
            canvas_context.clearRect(0, 0, canvas_data.width, canvas_data.height);
            gambarKotak(rect);
        }
    }

    $(document).ready(function() {

        var counter = 0;
        var mouseX = 0;
        var mouseY = 0;

        var point = new Array();
        var subpoint = {
            x: 0,
            y: 0
        };

        if ($("#SABagiantubuhM_gambartubuh_id").val() != "") {
            console.log("ready");
            pilihGambarTubuh($("#SABagiantubuhM_gambartubuh_id"));
        }
    });

    function gambarKotak(point, cleanup) {
        var canvas_data = $("#canvas_data").get(0);
        var canvas_context = canvas_data.getContext("2d");
        var temp_x, temp_y;

        var x1 = point.x1;
        var y1 = point.y1;
        var x2 = point.x2;
        var y2 = point.y2;

        if (x1 > x2) {
            temp_x = x2;
            x2 = x1;
            x1 = temp_x;
        }
        if (y1 > y2) {
            temp_y = y2;
            y2 = y1;
            y1 = temp_y;
        }

        if (cleanup) {
            canvas_context.clearRect(0, 0, canvas_data.width, canvas_data.height);
        }
        canvas_context.strokeStyle = "#f00";
        canvas_context.strokeRect(x1 - 3, y1 - 3, x2 - x1, y2 - y1);
    }
</script>