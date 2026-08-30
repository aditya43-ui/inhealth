<?php
/**
 * digunakan untuk modul portal rs post berita
 * RSST-2443
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 *
 */
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'penilaianiki-aspekuraian-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('class' => 'form-groups-bordered', 'onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);', 'enctype' => 'multipart/form-data'),
        ));
?>
<div class="row-fluid">
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label("Nama Post <span style='color:red'>*</span>", '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'post_judul', array('placeholder' => 'Nama Post', 'rows' => 5, 'cols' => 30, 'class' => 'required span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => "namaLain(this)")); ?>

            </div>
        </div> 

        <div class="control-group">
            <?php echo CHtml::label("Nama Lainnya ", '', array('class' => 'control-label')); ?>
            <div class="controls">                            
                <?php echo $form->textArea($model, 'post_namalain', array('placeholder' => 'nama Lainnya', 'rows' => 5, 'cols' => 30, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>

        <div class="control-group" id="misi">
            <?php echo CHtml::label("Deskripsi <span style='color:red'>*</span>", '', array('class' => 'control-label')); ?>
            <div class="controls">                            
                <?php
                $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'post_desc', 'toolbar' => 'mini', 'height' => '300px'));
                ?>

            </div>
        </div>
    </div>




    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label("Kategori <span style='color:red'>*</span>", '', array('class' => 'control-label')); ?>
            <div class="controls"> 
                <?php echo Chtml::activeDropDownList($model, 'kategoripost_id', CHtml::listData(KategoripostM::model()->findAll("kategoripost_aktif=true"), 'kategoripost_id', 'kategoripost_nama'), array('style' => 'width:170px;', 'class' => 'required form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>

            </div>
        </div>

        <div class="col-md-12">
            <div class="row-fluid">

                <table class="table table-bordered table-condensed" id="tablePetunjuk">
                    <thead>
                    <th style="text-align: center"> Gambar </th>
                    <th style="text-align: center"> Aksi </th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $modelDetail = new PostgambarM;
                        foreach ($modDetail as $rowdetail) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo CHtml::hiddenField('id_count', ''); ?>
                                    <?php echo CHtml::activeHiddenField($modelDetail, '[' . $i . ']postgambar_id', array('class' => 'span3')); ?>	
                                    <?php echo CHtml::activeFileField($modelDetail, '[' . $i . ']pathgambar', array('value' => $rowdetail->pathgambar, 'class' => 'span3', 'onchange' => 'checkGambar(this);')); ?>
                                    <br>
                                    <?php
                                    $img = "";
                                    if (empty($rowdetail->pathgambar)) {
                                        $img = "";
                                    } else {
                                        if (file_exists(Params::pathBeritaGambar() . $rowdetail->pathgambar)) {
                                            $img = Params::urlBeritaGambar() . $rowdetail->pathgambar;
                                        } else {
                                            $img = Params::urlBeritaGambar() . "no_photo.jpeg";
                                        }
                                    }
                                    ?>
                                    <img class="gambar-prev" id="output_1" src="<?= $img ?>" height="200" width="200">
                                </td>

                                <td style="text-align: center;" class="rowbutton span3">
                                    <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => 'tambahLookup()')); ?>
                                    <?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-danger', 'onclick' => 'hapusBaris(this)')); ?>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        

        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')); ?>
            <div class="controls">                            
                <?php echo $form->checkBox($model, 'post_aktif') . ' Aktif'; ?>
            </div>
        </div>
    </div>


</div>
<br>
<?php $this->renderPartial('_jsFunction', array('model' => $model, 'modDetail' => $modelDetail, 'form' => $form)); ?>


<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button',
        'onKeypress' => 'return formSubmit(this,event)', 'onclick' => 'cekForm();',
        'id' => 'btn_simpan',
            //            'onclick'=>'do_upload()',
    ));
    ?> 
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/PostM/admin'), array('class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    ?>

    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Post Berita', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('Admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>

    <?php
    $content = $this->renderPartial('sistemAdministrator.views.tips.tips', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script>
    /**
     * digunakan untuk validasi
     * @returns {Boolean}
     */
    function cekForm() {
        if (requiredCheck($("#penilaianiki-aspekuraian-m-form"))) {
            $('#penilaianiki-aspekuraian-m-form').submit();
        }

        return false;
    }
    /**
     * digunakan untuk menulis pada fieldlain
     * @param {type} nama
     * @returns {undefined}
     */
    function namaLain(nama)
    {
        document.getElementById('PostM_post_namalain').value = nama.value.toUpperCase();

    }
    document.getElementById("PostM_post_gambar").onchange = function () {
        if (this.files[0].size > 3000000) {
            myAlert("maksimal ukuran 3Mb");
            $("#PostM_post_gambar").attr("src", "blank");
            $('#PostM_post_gambar').wrap('<form>').closest('form').get(0).reset();
            $('#PostM_post_gambar').unwrap();
            return false;
        }
        var file = this.files[0];
        var fileType = file["type"];
        var validImageTypes = ["image/gif", "image/jpeg", "image/png"];
        if ($.inArray(fileType, validImageTypes) < 0) {
            myAlert("File harus berupa file gambar");
            $("#PostM_post_gambar").attr("src", "blank");
            $('#PostM_post_gambar').wrap('<form>').closest('form').get(0).reset();
            $('#PostM_post_gambar').unwrap();
            return false;
        }
//        if (this.files[0].type.indexOf("png") == -1 || this.files[0].type.indexOf("png") == -1) {
//           
//        }
    };


</script>

<script type="text/javascript">
    function bacaGambar(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.preview_picture').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#PostM_post_gambar").change(function () {
        bacaGambar(this);
    });
</script>
