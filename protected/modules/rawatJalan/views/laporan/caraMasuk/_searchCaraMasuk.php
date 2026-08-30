<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>
    <style>
        label.checkbox {
            width: 150px;
            display: inline-block;
        }
    </style>
    <div class="row">
        <div class="col-sm-6">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <div class="control-group">
                <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
                <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
            <?php //$format = new MyFormatter(); 
            ?>
        </div>
        <div class="col-sm-6">
            <div id='searching'>
                <?php
                echo '<div class="control-group"><label class="control-label">Filter</label><div class="controls">'
                    . $form->radioButtonList(
                        $model,
                        'is_rujukan',
                        array(
                            'non_rujukan' => 'Berdasarkan Non Rujukan',
                            'rujukan' => 'Berdasarkan Rujukan'
                        ),
                        array(
                            'onClick' => "lihatRujukan(this);",
                            'inline' => true,
                            'onkeypress' => "return $(this).focusNextInputField(event)"
                        )
                    ) . '</div></div>';

                // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                //     'id' => 'kunjungan',
                //     'slide' => true,
                //     'content' => array(
                //         'content2' => array(
                //             'header' => 'Berdasarkan Cara Masuk',
                //             'isi' =>
                //             '<table>
                //                         <tr>                                                               
                //                             <td>' . $form->radioButtonList(
                //                 $model,
                //                 'is_rujukan',
                //                 array(
                //                     'non_rujukan' => 'Berdasarkan Non Rujukan',
                //                     'rujukan' => 'Berdasarkan Rujukan'
                //                 ),
                //                 array(
                //                     'onClick' => "lihatRujukan(this);",
                //                     'inline' => true,
                //                     'onkeypress' => "return $(this).focusNextInputField(event)"
                //                 )
                //             ) .
                //                 '</td>
                //                         </tr>
                //                     </table>',
                //             'active' => true,
                //         ),
                //     ),
                // ));
                ?>
                <div id="list_rujukan" style="display:none;">
                    <?php
                    echo $form->checkBoxList(
                        $model,
                        'asalrujukan_id',
                        CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'), 'asalrujukan_id', 'asalrujukan_nama')
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array(
                'title' => 'Cari',
                'class' => 'btn btn-danger',
                'type' => 'submit',
                'id' => 'btn_simpan'
            )
        );
        ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        ); ?>
    </div>
</div>

<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
',  CClientScript::POS_READY);
?>
<script type="text/javascript">
    function lihatRujukan(obj) {
        $("#list_rujukan").hide();
        $("#list_rujukan").find('input[type="checkbox"]').each(
            function() {
                $(this).attr('checked', false);
            }
        );
        if ($(obj).val() == 'rujukan') {
            $("#list_rujukan").show();
            $("#list_rujukan").find('input[type="checkbox"]').each(
                function() {
                    $(this).attr('checked', true);
                }
            );
        }
    }
</script>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>