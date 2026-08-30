<div class="panel panel-success">
    <div class="panel-body" style="min-height: 220px; width: 450px">
        <?php
        $this->breadcrumbs = array(
            'Form Pendaftaran'
        );

        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'form-pendaftaran',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)',
            ),
        ));

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?=
        $this->renderPartial($this->path_view . 'set-pendaftaran/_2_pendaftaran', array(
            'model' => $model,
            'modPas' => $modPas,
            'form' => $form
        ));
        ?>

        <div class="form-actions">
            <?php
            echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger btn-simpan', 'type' => 'button', 'onclick' => 'cekFormDaftar(this);', 'data-url' => $this->createUrl('setPendaftaran', ['id' => $model->notriage_pasien_id, 'proses' => 'simpan'])));
            echo '&nbsp;';
            ?>

        </div>

        <?php
        $this->endWidget();
        ?>
    </div>
</div>
<?php
$sukses = !empty($sukses) ? $sukses : null;
?>
<script>
    let sukses = '<?= $sukses ?>';
    <?php if (!empty($sukses)) { ?>

        if (sukses == 'ya') {
            toastr.success("Data berhasil disimpan", "Perhatian!");
        } else if (sukses == 'tidak') {
            toastr.error("<?= $pesan ?>", "Perhatian!");
        }
    <?php } ?>

    jQuery('<?= Params::TOOLTIP_SELECTOR ?>').tooltip({
        "placement": "top"
    });

    var loadDataPasien = (obj) => {
        const id = $(obj).val();
        $.get("<?php echo $this->createUrl('loadPendaftaran'); ?>", {
                id: id
            },
            function(data) {
                $('.label-nama-pasien').html(data.nama_pasien);
                $('.label-alamat-pasien').html(data.alamat_pasien);
                $(".label-no-rm").html(data.no_rekam_medik)
                $('#NotriagePasienT_pasien_id').val(data.pasien_id);
                $('#NotriagePasienT_pendaftaran_id').val(id);
            },
            "json");
    }
</script>