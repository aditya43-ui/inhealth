<?php
$this->breadcrumbs = array(
    'Transaksi Surat Keterangan'
);
?>

<div class="panel panel-gradient">
            <div class="panel-body">
                <!--fieldset class="box"-->
                <?php
                echo CHtml::hiddenField('RKPendaftaranT[pendaftaran_id]', $modPendaftaran->pendaftaran_id, array('readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                echo CHtml::hiddenField('RKPendaftaranT[pasienadmisi_id]', $modPendaftaran->pasienadmisi_id, array('readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                echo CHtml::hiddenField('RKPendaftaranT[caramasuk_id]', $modPendaftaran->caramasuk_id, array('readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                echo CHtml::hiddenField('RKPendaftaranT[jeniskelamin]', $modPendaftaran->jeniskelamin, array('readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                echo CHtml::hiddenField('RKPendaftaranT[instalasi_id]', $modPendaftaran->instalasi_id, array('readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                $this->renderPartial($this->path_view . '_tabMenu', array('modPendaftaran' => $modPendaftaran));
                $this->renderPartial($this->path_view . '_jsFunctions', array("modPasien" => $modPasien));
                ?>
                <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; "></iframe>
                <!--</fieldset>-->
            </div>
        </div>
    </div>
</div>