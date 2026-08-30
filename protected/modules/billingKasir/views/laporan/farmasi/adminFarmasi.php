<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Farmasi</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php
                Yii::app()->clientScript->registerScript('search', "
                        $('#searchLaporan').submit(function(){
                            $.fn.yiiGridView.update('tableLaporanTrans', {
                                data: $(this).serialize()
                            });
                            $.fn.yiiGridView.update('tableLaporanReg', {
                                data: $(this).serialize()
                            });
                            $.fn.yiiGridView.update('tableLaporanKelompok', {
                                data: $(this).serialize()
                            });
                            return false;
                        });
                        ");
                ?>
                <fieldset class="box search-form">
                    <div class="search-form">
                        <?php
                        $this->renderPartial(
                            'billingKasir.views.laporan.farmasi/_search',
                            array(
                                'model' => $model, 'format' => $format
                            )
                        );
                        ?>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Farmasi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('bootstrap.widgets.BootMenu', array(
                    'type' => 'tabs',
                    'stacked' => false,
                    'htmlOptions' => array('id' => 'tabmenu'),
                    'items' => array(
                        array('label' => 'Transaksi Farmasi', 'url' => 'javascript:tab(0);', 'itemOptions' => array("index" => 0), 'active' => true),
                        array('label' => 'Rekap / Kelompok', 'url' => 'javascript:tab(1);', 'itemOptions' => array("index" => 1)),
                        array('label' => 'Farmasi Per-Registrasi', 'url' => 'javascript:tab(2);', 'itemOptions' => array("index" => 2)),
                    ),
                ))
                ?>
                <div class="block-tabel">
                    <div id="div_reportTranasksi">
                        <fieldset>
                            <?php
                            $this->renderPartial(
                                'billingKasir.views.laporan.farmasi/_tableTransaksi',
                                array(
                                    'model' => $model, 'format' => $format,
                                )
                            );
                            ?>
                        </fieldset>
                    </div>
                    <div id="div_rekap">
                        <fieldset>
                            <?php
                            $this->renderPartial(
                                'billingKasir.views.laporan.farmasi/_tableKelompok',
                                array(
                                    'model' => $model, 'format' => $format,
                                )
                            );
                            ?>
                        </fieldset>
                    </div>
                    <div id="div_per_registrasi">
                        <fieldset>
                            <?php
                            $this->renderPartial(
                                'billingKasir.views.laporan.farmasi/_tablePerRegistrasi',
                                array(
                                    'model' => $model, 'format' => $format,
                                )
                            );
                            ?>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>

        <?php

        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/LaporanFarmasi');
        $urlPrintLap =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanKeseluruhan');

        $js = <<< JSCRIPT
                $(document).ready(function() {
                    $("#tabmenu").children("li").children("a").click(function() {
                        $("#tabmenu").children("li").attr('class','');
                        $(this).parents("li").attr('class','active');
                        $(".icon-pencil").remove();
                        // $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
                    });
                    $("#carabayar").hide();
                   $("#BKObatalkesPasienT_nama_pasien").attr("disabled",true);
                   // $("#BKObatalkesPasienT_carabayar_id").attr("disabled",true);
                    $("#div_reportTranasksi").show();
                    $("#div_rekap").hide();
                    $("#div_per_registrasi").hide();
                    $("#BKObatalkesPasienT_filter_tab").val("trans");
                });

                function tab(index){
                    $(this).hide();
                    $(".btn-group").hide();

                    if (index==0){
                        $(".btn-group").show();
                        $("#BKObatalkesPasienT_filter_tab").val("trans");
                       $("#BKObatalkesPasienT_nama_pasien").attr("disabled",true);
                        //$("#BKObatalkesPasienT_carabayar_id").attr("disabled",true);
                        $("#div_reportTranasksi").show();
                        $("#div_rekap").hide();
                        $("#carabayar").hide();
                        $("#div_per_registrasi").hide();
                    }else if(index==1){
                        $(".btn-group").show();
                        $("#BKObatalkesPasienT_filter_tab").val("rekap");
                        $("#BKObatalkesPasienT_nama_pasien").attr("disabled",false);
                        //$("#BKObatalkesPasienT_carabayar_id").attr("disabled",true);
                        $("#div_reportTranasksi").hide();
                        $("#div_rekap").show();
                        $("#carabayar").show();
                        $("#div_per_registrasi").hide();
                    }else if(index==2){
                        $(".btn-group").show();
                        $("#BKObatalkesPasienT_filter_tab").val("per_reg");
                        $("#BKObatalkesPasienT_nama_pasien").attr("disabled",false);
                        //$("#BKObatalkesPasienT_carabayar_id").attr("disabled",false);
                        $("#div_reportTranasksi").hide();
                        $("#div_rekap").hide();
                        $("#carabayar").show();
                        $("#div_per_registrasi").show();
                    }
                }
                function print(caraPrint)
                {
                    window.open("${urlPrint}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
                }

                function onReset(){
                    setTimeout(
                        function(){
                            $.fn.yiiGridView.update('tableLaporanTrans', {
                                data: $("#searchLaporan").serialize()
                            });
                            $.fn.yiiGridView.update('tableLaporanReg', {
                                data: $("#searchLaporan").serialize()
                            });
                            $.fn.yiiGridView.update('tableLaporanKelompok', {
                                data: $("#searchLaporan").serialize()
                            });        
                        }, 1000
                    );
                }

                function printLap(caraPrint)
                {
                    window.open("${urlPrintLap}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
                }

JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'url' => $urlPrint, 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'url' => $urlPrint, 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'url' => $urlPrint, 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('../tips/tips_laporan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <!--/div-->
    </div>
</div>