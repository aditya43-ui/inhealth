<div class="row">
    <div class="col-md-6">
        <div class="control-group">
            <?php echo $form->labelEx($modAsesTriase, 'caramasuk', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php
                    echo $form->radioButtonList($modAsesTriase, 'caramasuk', array('Jalan' => 'Jalan', 'Kursi Roda' => 'Kursi Roda', 'Brankard' => 'Brankard', 'Digendong' => 'Digendong'), array('class' => 'required'));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modAsesTriase, 'transportasi <span class="required">*</span>', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                    echo $form->radioButtonList($modAsesTriase, 'transportasi', array('Ambulan' => 'Ambulan', 'Mobil' => 'Mobil', 'Lainnya' => 'Lainnya'), array('onClick' => 'CekTransport()', 'class' => 'required'));
                ?>
                <?php echo $form->textField($modAsesTriase, 'transport_lain', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="control-group">
            <?php echo $form->labelEx($modAsesTriase, 'dikirim oleh <span class="required">*</span>', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                    echo $form->radioButtonList($modAsesTriase, 'dikirimoleh', array('Sendiri' => 'Sendiri', 'RS/PKM/BP' => 'RS/PKM/BP', 'Dokter/Bidan' => 'Dokter/Bidan', 'Lainnya' => 'Lainnya'), array('onClick' => 'CekKirim()', 'class' => 'required'));
                ?>
                <?php echo $form->textField($modAsesTriase, 'dikirim_lain', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modAsesTriase, 'jeniskasus', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php
                    echo $form->radioButtonList($modAsesTriase, 'jeniskasus', array('Trauma' => 'Trauma', 'Non Trauma' => 'Non Trauma', 'Pediatri/Obsgyn' => 'Pediatri/Obsgyn'), array('class' => 'required'));
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        CekTransport();
        CekKirim();
    });

    function CekTransport() {
        cek = $("input[type='radio'][name='RDAsesmentriagewpssT[transportasi]']:checked").val();
        if (cek === 'Lainnya') {
            $('#RDAsesmentriagewpssT_transport_lain').attr('readonly', false);
        } else {
            $('#RDAsesmentriagewpssT_transport_lain').val('');
            $('#RDAsesmentriagewpssT_transport_lain').attr('readonly', true);
        }
    }

    function CekKirim() {
        cek = $("input[type='radio'][name='RDAsesmentriagewpssT[dikirimoleh]']:checked").val();
        if (cek === 'Lainnya') {
            $('#RDAsesmentriagewpssT_dikirim_lain').attr('readonly', false);
        } else {
            $('#RDAsesmentriagewpssT_dikirim_lain').val('');
            $('#RDAsesmentriagewpssT_dikirim_lain').attr('readonly', true);
        }
    }
</script>