<?php 
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'permintaanDarah-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));

        $this->widget('bootstrap.widgets.BootAlert');
?>
<div class="col-sm-12">
    
    <div class="control-group">
        <?php echo CHtml::label("Reaksi Transfusi", '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
                echo $form->radioButtonList($modPenyiapanDarah, 'reaksi_transfusi', ['1' => 'Ya', '0' => 'Tidak'], ['onclick' => 'setKategori(this)']);
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Kategori Gejala", '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
                echo $form->dropDownList($modPenyiapanDarah, 'kategori_gejalatransfusi',LookupM::getItemsUrutan('kategori_gejala_transfusi'), ['onchange' => 'setGejalaTransfusi(this)', 'empty' => ' -- Pilih --']);
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Gejala reaksi transfusi", '', array('class' => 'control-label')) ?>
        <div class="controls kategori-1" hidden>
            <?= CHtml::activeCheckBoxList($modPenyiapanDarah, 'gejala_reaksitransfusi1', ['Cemas' => 'Cemas']) ?>
        </div>
        <div class="controls kategori-2" hidden>
            <?= CHtml::activeCheckBoxList($modPenyiapanDarah, 'gejala_reaksitransfusi2', ['Cemas' => 'Cemas', 'Gatal' => 'Gatal', 'Palpatasi' => 'Palpatasi', 'Sesak Napas Ringan' => 'Sesak Napas Ringan', 'Sakit Kepala' => 'Sakit Kepala']) ?>
        </div>
        <div class="controls kategori-3" hidden>
            <?= CHtml::activeCheckBoxList($modPenyiapanDarah, 'gejala_reaksitransfusi3', ['Cemas' => 'Cemas', 'Nyeri Dada' => 'Nyeri Dada', 'Nyeri Didaerah Pemasangan Jarum Transfusi' => 'Nyeri Didaerah Pemasangan Jarum Transfusi', 'Gangguan Pernapasan' => 'Gangguan Pernapasan', 'Nyeri Punggung atau Nyeri Daerah Pangkal Paha' => 'Nyeri Punggung atau Nyeri Daerah Pangkal Paha', 'Sakit Kepala' => 'Sakit Kepala', 'Sesak' => 'Sesak']) ?>
        </div>
    </div>
</div>
<div class="form-action">
    <?php 
        if(!isset($_GET['lihat'])) {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-danger submit', 'type' => 'submit', 'disabled' => (isset($_GET['sukses'])) ? true : false, 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);'));
            echo "&nbsp;";
        }
    ?>
</div>
<?php $this->endWidget(); ?>

<script>
    $(function(){
        var dropdown  = jQuery('.searchDropdown');
     
        jQuery(dropdown).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '282px',
                enableCaseInsensitiveFiltering: true
        }).hide();

        var kategori = $('#PenyiapandarahT_kategori_gejalatransfusi').val();

        if(kategori == 'Kategori I') {
            $('.kategori-1').show();
        }
        if(kategori == 'Kategori II') {
            $('.kategori-2').show();
        }
        if(kategori == 'Kategori III') {
            $('.kategori-3').show();
        }

        setKategori($('#kategori'), '<?= $modPenyiapanDarah->reaksi_transfusi ?>');

    });
    function setGejalaTransfusi(obj) {
        var kategori = $(obj).val();

        if(kategori == 'Kategori I') {
            $('.kategori-1').show();
            $('.kategori-2').hide();
            $('.kategori-3').hide();

        }
        if(kategori == 'Kategori II') {
            $('.kategori-1').hide();
            $('.kategori-2').show();
            $('.kategori-3').hide();

        }
        if(kategori == 'Kategori III') {
            $('.kategori-1').hide();
            $('.kategori-2').hide();
            $('.kategori-3').show();
        }

        if(kategori == '') {
            $('.kategori-1').hide();
            $('.kategori-2').hide();
            $('.kategori-3').hide();
        }
    }

    function setKategori(obj, reaksitransfusi){
        if($(obj).val() == 0 || reaksitransfusi == 0) {
            $('#PenyiapandarahT_kategori_gejalatransfusi').val(null);
            setGejalaTransfusi($('#PenyiapandarahT_kategori_gejalatransfusi'));
            $('#PenyiapandarahT_kategori_gejalatransfusi').prop('disabled', true);
        } else {
            $('#PenyiapandarahT_kategori_gejalatransfusi').prop('disabled', false);
        }
    }
</script>