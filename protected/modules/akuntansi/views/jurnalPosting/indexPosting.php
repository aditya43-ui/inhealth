<!--div class="white-container"-->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Posting Jurnal</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                Yii::app()->clientScript->registerScript('search', "
                    $('.search-button').click(function(){
                        $('.search-form').toggle();
                        return false;
                    });
                    $('#searchLaporan').submit(function(){
                        $('#Grafik').attr('src','').css('height','0px');
                        $.fn.yiiGridView.update('tableLaporan', {
                            data: $(this).serialize()
                        });
                        return false;
                    });
                    ");
                ?>
                <?php
                if (isset($_GET['sukses'])) {
                    Yii::app()->user->setFlash('success', "Data Jurnal Berhasil di Posting");
                }
                $this->widget('bootstrap.widgets.BootAlert');
                ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-search"></i> Pencarian
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="search-form">
                            <?php $this->renderPartial($this->path_view . '_search', array(
                                'model' => $model,
                            )); ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Jurnal Rekening</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                            'id' => 'jurnalposting-m-form',
                            'enableAjaxValidation' => false,
                            'type' => 'horizontal',
                            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
                        ));
                        $prov = $model->searchPostingJurnal();
                        $provTot = clone $prov;
                        $provTot->pagination = false;
                        $dat = array('d' => 0, 'k' => 0);

                        foreach ($provTot->data as $item) {
                            $dat['d'] += $item->saldodebit;
                            $dat['k'] += $item->saldokredit;
                        }

                        ?>
                        <!--div class="block-tabel well"-->
                        <div class="col-sm-12">
                            <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                                'id' => 'tableLaporan',
                                'dataProvider' => $prov,
                                'template' => "{summary}\n{items}",
                                'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                                'mergeHeaders' => array(
                                    array(
                                        'name' => 'Saldo',
                                        'start' => 7,
                                        'end' => 8,
                                    ),
                                ),
                                'columns' => array(
                                    array(
                                        'header' => 'Pilih' . CHtml::checkBox('is_pilihsemua', true, array('onclick' => 'pilihSemua(this)', 'title' => 'Klik untuk pilih / tidak <br>semua jurnal', 'rel' => 'tooltip')),
                                        'type' => 'raw',
                                        'value' => '
                                                CHtml::activeHiddenField($data, \'[\'.$data->jurnaldetail_id.\']jurnaldetail_id\').
                                                CHtml::checkBox(\'AKJurnalrekeningT[\'.$data->jurnaldetail_id.\'][cekList]\', \'\', array(\'onclick\'=>\'setUrutan(this)\', \'class\'=>\'cekList\'));
                                                ',
                                        'htmlOptions' => array('style' => 'width:30px;text-align:center'),
                                    ),
                                    array(
                                        'header' => 'Tgl. Jurnal/<br>No. Bukti Jurnal',
                                        'type' => 'raw',
                                        'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d H:i:s", strtotime($data->tglbuktijurnal)))."/<br> ".$data->nobuktijurnal',
                                    ),
                                    'kodejurnal',
                                    array(
                                        'header' => 'Tgl. Referensi/ <br> No. Referensi',
                                        'type' => 'raw',
                                        'value' => 'MyFormatter::formatDateTimeForUser(date("d-m-Y", strtotime($data->tglreferensi))) . "/<br> " . $data->noreferensi',
                                    ),
                                    array(
                                        'header' => 'Kode Akun',
                                        'value' => '$data->KodeRekening'
                                    ),
                                    array(
                                        'header' => 'Nama Akun',
                                        'value' => '$data->NamaRekening'
                                    ),
                                    array(
                                        'header' => 'Uraian Jurnal',
                                        'type' => 'raw',
                                        'value' => 'CHtml::activeHiddenField($data, \'[\'.$data->jurnaldetail_id.\']urianjurnal\'). (!empty($data->uraiantransaksi)?$data->uraiantransaksi:$data->urianjurnal)',
                                        'footerHtmlOptions' => array('colspan' => 7, 'style' => 'text-align:right;font-style:italic;'),
                                        'footer' => 'Saldo',
                                    ),
                                    array(
                                        'header' => 'Debit',
                                        'name' => 'saldodebit',
                                        'value' => 'MyFormatter::formatNumberForPrint($data->saldodebit,2)',
                                        'htmlOptions' => array('style' => 'width:100px;text-align:right'),
                                        'footerHtmlOptions' => array('style' => 'text-align:right;'),
                                        'footer' => "" . MyFormatter::formatNumberForPrint($dat['d'], 2),
                                    ),
                                    array(
                                        'header' => 'Kredit',
                                        'name' => 'saldokredit',
                                        'value' => 'MyFormatter::formatNumberForPrint($data->saldokredit,2)',
                                        'htmlOptions' => array('style' => 'width:100px;text-align:right'),
                                        'footerHtmlOptions' => array('style' => 'text-align:right;'),
                                        'footer' => "" . MyFormatter::formatNumberForPrint($dat['k'], 2),
                                    ),
                                ),
                                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                            )); ?>
                        </div>
                        <!--/div-->
                    </div>
                </div>
                <div class="form-actions">
                    <?php
                    echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Posting Jurnal', array('{icon}' => '<i class="entypo-check"></i>')),
                        array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
                    ); ?>
                    <?php
                    echo CHtml::link(
                        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        $this->createUrl($this->id . '/indexPosting'),
                        array(
                            'class' => 'btn btn-default',
                            'onclick' => 'return refreshForm(this);'
                        )
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/div-->
<script type="text/javascript">
    function setUrutan(obj) {
        var nilai = $(obj).val();
        if (nilai) {
            $(obj).val('');
        } else {
            $(obj).val(1);
        }
    }
    /**
     * pilih / tidak semua jurnal
     * @param {type} obj
     * @returns {undefined}
     */
    function pilihSemua(obj) {
        if ($(obj).is(":checked")) {
            $(".cekList").val(1);
            $(".cekList").attr("checked", true);
        } else {
            $(".cekList").val(0);
            $(".cekList").attr("checked", false);
        }
    }
</script>
<?php $this->endWidget(); ?>