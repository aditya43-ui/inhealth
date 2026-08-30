<?php
$this->breadcrumbs = array(
    'Informasi Pasien Rawat Inap' => Yii::app()->request->getUrlReferrer(),
    'Pemeriksaan Pasien',
);

?>

<div class="panel panel-gradient" id="awal">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Asuhan Gizi
        </div>
    </div>
    <div class="panel-body">


        <table style="width: 50%;">
            <tr>
                <td>
                    <?php echo CHtml::label('Ruangan <span class="required">*</span>', '', array('class' => 'control-label')); ?>&emsp;&emsp;&emsp;
                </td>
                <td>
                    <div class="control-group">
                        <div class="controls">
                            <?= CHtml::dropDownList("instalasi",'',CHtml::listData(
                                InstalasiM::model()->findAllByAttributes(array(
                                    'instalasi_id'=>Params::grupInstalasiRIID()
                                ),array (
                                    'order'=>'instalasi_nama'
                                )
                            ), 'instalasi_id', 'instalasi_nama'),array('empty'=>'-- Pilih --', 'class'=>'span3','onchange' => 'updateItemRuangan()')) ?>
                            <?= CHtml::dropDownList("ruangan",'',array(),array('empty'=>'-- Pilih --', 'class'=>'span3', 'onchange' => 'updateDialogPasien()')) ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo CHtml::label('Nama Pasien <span class="required">*</span>', '', array('class' => 'control-label')); ?>&emsp;&emsp;&emsp;
                </td>
                <td>
                    <div class="control-group">
                        <div class="controls">
                            <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'nama_pasien',
                    'source' => 'js: function(request, response) {
                                                                       $.ajax({
                                                                           url: "' . $this->createUrl('/ActionAutoComplete/pasienAll') . '",
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
                        'focus' => 'js:function( event, ui )
                                                                               {
                                                                                $(this).val(ui.item.label);
                                                                                return false;
                                                                                }',
                        'select' => 'js:function( event, ui ) {
                                                                               $("#tipedietid").val(ui.item.tipediet_id);
                                                                               $("#tipediet_nama").val(ui.item.tipediet_nama);
                                                                                return false;
                                                                            }',
                    ),
                    'htmlOptions' => array(
                        'readonly' => false,
                        'placeholder' => '',
                        'size' => 13,
                        'onkeypress' => "return $(this).focusNextInputField(event);",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPasien'),
                ));
                ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        
        $modul = Yii::app()->controller->module->id;
        
        echo '<div id="data-pasien">';
        $this->renderPartial($this->path_view . '_dataPasienKosong', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modAdmisi' => $modAdmisi));
        echo '</div>';

        $this->renderPartial($this->path_view . '_tabMenu', array());
        $this->renderPartial($this->path_view . '_jsFunctions', array("modPasien" => $modPasien)); ?>
        <div>
            <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; "></iframe>
        </div>
    </div>
</div>

<?php
$this->renderPartial($this->path_view . '_dialogPasien');

?>
<script>

function updateItemRuangan() {
    var instalasi_id = $("#instalasi").val();

    $.post('<?php echo $this->createUrl('getRuanganInstalasi'); ?>',{
        instalasi_id: instalasi_id
    }, function(data) {
        $("#ruangan").html(data);
    });
}


function setPasienByPendaftaran(pendaftaran_id) {

    $.post('<?php echo Yii::app()->createUrl('gizi/asuhanGiziPasien/getPasienByPendaftaran'); ?>', {
            pendaftaran_id: pendaftaran_id,
                }, function(data) {
                    $('#data-pasien').html(data.datapasien);
                    var gets = '';
                    if(data.pendaftaran_id !== '') {
                        gets += '&pendaftaran_id=' + data.pendaftaran_id;
                    }

                    if(data.pasienadmisi_id !== '') {
                        gets += '&pasienadmisi_id=' + data.pasienadmisi_id;
                    }

                    $('.tabulasi_asuhan').each(function() {
                        var tab = $(this).attr('base-tab');
                        $(this).attr('tab', tab + gets);
                    });

                }, 'json');

                $('#dialogPasien').dialog('close');
}

function updateDialogPasien() {
        var instalasi_id = $("#instalasi").val();
        var ruangan_id = $("#ruangan").val();

        $(".dialog_ruangan_id").val(ruangan_id);

        $.fn.yiiGridView.update("pasien-grid", {
            data: $("#pasien-grid :input").serialize()
        });
    }

</script>