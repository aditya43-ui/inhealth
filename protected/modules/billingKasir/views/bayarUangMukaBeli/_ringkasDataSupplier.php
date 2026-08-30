<fieldset class="box">
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-users"></i> Data <b>Supplier</b>
            </div>
        </div>
        <div class="panel-body">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="10%"><?php echo CHtml::activeLabel($modSupplier, 'supplier_nama', array('class' => 'control-label')); ?></td>
                    <td>
                        <?php echo CHtml::activeHiddenField($modSupplier, 'supplier_id', array('readonly' => true)); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modSupplier,
                            'attribute' => 'supplier_nama',
                            'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . Yii::app()->createUrl('billingKasir/BayarUangMukaBeli/daftarSupplier') . '",
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
                                                $(this).val(""); //SUPAYA TERLIHAT DATA SUDAH TERPILIH ATAU BELUM
                                                return false;
                                            }',
                                'select' => 'js:function( event, ui ) {
                                                isiDataSupplier(ui.item);
                                                return false;
                                            }',
                            ),
                        ));
                        ?>
                    </td>

                    <td width="10%"><?php echo CHtml::activeLabel($modSupplier, 'supplier_kode', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activetextField($modSupplier, 'supplier_kode', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modSupplier, 'supplier_alamat', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modSupplier, 'supplier_alamat', array('readonly' => true)); ?></td>

                    <td><?php echo CHtml::activeLabel($modSupplier, 'supplier_telp', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modSupplier, 'supplier_telp', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modSupplier, 'supplier_website', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modSupplier, 'supplier_website', array('readonly' => true)); ?></td>

                    <!--<td><?php //echo CHtml::activeLabel($modSupplier, 'supplier_npwp',array('class'=>'control-label')); 
                            ?></td>
            <td><?php //echo CHtml::activeTextField($modSupplier,'supplier_npwp', array('readonly'=>true)); 
                ?></td>-->

                    <td><?php echo CHtml::activeLabel($modSupplier, 'supplier_fax', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modSupplier, 'supplier_fax', array('readonly' => true)); ?></td>
                </tr>
                <tr>

                    <td><?php echo CHtml::activeLabel($modSupplier, 'supplier_email', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modSupplier, 'supplier_email', array('readonly' => true)); ?></td>
                </tr>
            </table>
        </div>
    </div>
</fieldset>

<script type="text/javascript">
    function isiDataSupplier(data) {
        $('#<?php echo CHtml::activeId($modSupplier, 'supplier_kode'); ?>').val(data.supplier_kode);
        $('#<?php echo CHtml::activeId($modSupplier, 'supplier_alamat'); ?>').val(data.supplier_alamat);
        $('#<?php echo CHtml::activeId($modSupplier, 'supplier_telp'); ?>').val(data.supplier_telp);
        $('#<?php echo CHtml::activeId($modSupplier, 'supplier_npwp'); ?>').val(data.supplier_npwp);
        $('#<?php echo CHtml::activeId($modSupplier, 'supplier_fax'); ?>').val(data.supplier_fax);
        $('#<?php echo CHtml::activeId($modSupplier, 'supplier_website'); ?>').val(data.supplier_website);
        $('#<?php echo CHtml::activeId($modSupplier, 'supplier_email'); ?>').val(data.supplier_email);
        $('#<?php echo CHtml::activeId($modSupplier, 'supplier_id'); ?>').val(data.supplier_id);
        $('#<?php echo CHtml::activeId($modSupplier, 'supplier_nama'); ?>').val(data.value);

        $('#BKTandabuktikeluarT_namapenerima').val(data.supplier_nama);
        $('#BKTandabuktikeluarT_alamatpenerima').val(data.supplier_alamat);

        $('.currency').each(function() {
            this.value = formatNumber(this.value)
        })
    }
</script>