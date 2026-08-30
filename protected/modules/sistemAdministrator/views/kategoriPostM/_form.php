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
            <?php echo CHtml::label("Kategori Post Berita <span style='color:red'>*</span>", '', array('class' => 'control-label')); ?>
            <div class="controls">
                
                <?php echo $form->textField($model,'kategoripost_nama',array('placeholder'=>'Kategori','class'=>'required span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>25)); ?>
            </div>
        </div> 

        <div class="control-group">
            <?php echo CHtml::label("Nama Lainnya ", '', array('class' => 'control-label')); ?>
            <div class="controls">                            
                
                 <?php echo $form->textField($model,'kategoripost_namalain',array('placeholder'=>'Nama Lainnya','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>25)); ?>    
            </div>
        </div>
    </div>
    <div class="col-md-6">
        
        <div class="control-group">
            <?php
            if ((!$model->isNewRecord) && (!empty($model->kategoripost_gambar))) {
                echo "<div class='control-group' id='gambar_hide'>
                        <div class='controls'>";
                echo "<img src='" . Params::urlKategoriBeritaGambar() . $model->kategoripost_gambar . "' class='preview_picture' width='300px' height='300px' align='right'>";
                echo "</div></div>";
                // jika gambar telah dihapus dengan jquery
                echo "<div class='control-group' id='gambar_show' hidden>
                            <div class='controls'>";
                echo "Gambar belum diset";
                echo "</div></div>";
            } else if ((!$model->isNewRecord) && (empty($model->kategoripost_gambar))) {
                echo "<div class='control-group'>
                        <div class='controls'>";
                echo "Gambar belum diset";
                echo "</div></div>";
            }
            ?>

            <?php echo CHtml::label("Kategori Post Gambar ", '', array('class' => 'control-label')); ?>
            <div class="controls">
                
                
                <?php 
                if (($model->isNewRecord) && (empty($model->kategoripost_gambar))) {
                    echo CHtml::activeFileField($model,'kategoripost_gambar',array('class'=>'')) ;
                    echo '<b style="color:red">Catatan Image:</b>Minimal Ukuran Image 420 px x 154px';
                }else{
                    echo CHtml::activeFileField($model,'kategoripost_gambar',array('class'=>'')) ;
                    echo '<b style="color:red">Catatan Image:</b>Minimal Ukuran Image 420 px x 154px';
                }     
                 ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')); ?>
            <div class="controls">                            
                <?php echo $form->checkBox($model, 'kategoripost_aktif') . ' Aktif'; ?>
            </div>
        </div>
    </div>

</div>
<br>


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

    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kategori Berita', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('Admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>

    <?php
    $content = $this->renderPartial('sistemAdministrator.views.tips.tips', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script>
    /**
     * digunakan untuk menulis pada field lain 
     * @param {type} nama
     * @returns {undefined}
     */
    function namaLain(nama)
    {
        document.getElementById('KategoripostM_kategoripost_namalain').value = nama.value.toUpperCase();

    }
    /**
     * digunakan untuk cek validasi pada form
     * @returns {Boolean}
     */
    function cekForm() {
        if (requiredCheck($("#penilaianiki-aspekuraian-m-form"))) {
            $('#penilaianiki-aspekuraian-m-form').submit();
        }

        return false;
    }
    document.getElementById("KategoripostM_kategoripost_gambar").onchange = function () {
        if(this.files[0].size>3000000){
            myAlert("maksimal ukuran 3Mb");
            $("#KategoripostM_kategoripost_gambar").attr("src","blank");
            $('#KategoripostM_kategoripost_gambar').wrap('<form>').closest('form').get(0).reset();
            $('#KategoripostM_kategoripost_gambar').unwrap();     
            return false;
        }
        if(this.files[0].type.indexOf("png")==-1){
            myAlert("File harus png");
            $("#KategoripostM_kategoripost_gambar").attr("src","blank");
            $('#KategoripostM_kategoripost_gambar').wrap('<form>').closest('form').get(0).reset();
            $('#KategoripostM_kategoripost_gambar').unwrap();         
            return false;
        }
    };
    
</script>

