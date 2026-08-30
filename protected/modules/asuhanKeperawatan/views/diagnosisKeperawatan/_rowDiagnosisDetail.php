<tr class="diagnosisaskepdet" style="background-color:#f8f8f8;">
    <td style="background-color:#f8f8f8;">
        <?php echo CHtml::activeRadioButtonList($modDetail, '[0]pilih_data_tandagejala', array('tandagejala' => 'Diagnosa Keperawatan Aktual'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ', 'onclick' => 'setData(this);', 'class' => 'pilihdata_tandagejala')); ?>
        <?php echo CHtml::activeRadioButtonList($modDetail, '[0]pilih_data_faktorrisiko', array('faktorrisiko' => 'Diagnosa Keperawatan Risiko'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ', 'onclick' => 'setData2(this);', 'class' => 'pilihdata_faktorrisiko')); ?>
        <br><br>
        <label>
            <div class="tandagejala" style="display: none">
                <div class="tandagejaladetail">
                        <?php echo CHtml::css('#table-tandagejala thead tr th{vertical-align:middle;}'); ?>
                        <table style="width: 100%; border: 1px solid #ededed !important;" border="0">
                            <tbody>
                                <tr> 
                                    <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;"><b>Tanda dan Gejala Mayor</b></td>
                                </tr>
                                <tr> 
                                    <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;"><b>Subjektif</b></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;">
                                        <div class="tandagejalanya">
                                            <?php
                                            $this->widget('MyJuiAutoComplete', array(
                                                'model' => $modDetail,
                                                'attribute' => '[0]tandagejala_indikator_mayorsubjektif',
                                                'source' => 'js: function(request, response) {
                                                                       $.ajax({
                                                                           url: "' . $this->createUrl('AutocompleteMayorSubjektif') . '",
                                                                           dataType: "json",
                                                                           data: {
                                                                               term: request.term
                                                                           },
                                                                           success: function (data) {
                                                                                response(data);
                                                                           }
                                                                       })
                                                                    }',
                                                'options' => array(
                                                    'showAnim' => 'fold',
                                                    'minLength' => 3,
                                                    'focus' => 'js:function( event, ui ) {
                                                                    $(this).val( ui.item.label);
                                                                    return false;
                                                                }',
                                                    'select' => 'js:function( event, ui ) {
                                                                    setTandaGejalaMayorSubjektif(ui.item.value, this);
                                                                    return false;
                                                                }',
                                                ),
                                                'tombolDialog' => array("idDialog" => 'dialogTandaGejalaMayorSubjektif', 'jsFunction' => "setDialogMayorSubjektif(this);"),
                                                'htmlOptions' => array('class' => 'span3 tandagejala_indikator_mayorsubjektif', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Tanda Gejala'),
                                            ));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table id="table-tandagejala" style="width: 100%; border: 1px solid #ededed !important;" border="0" class="mayor-subjektif">
                            <tbody>
                                <tr> 
                                    <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;"></td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="width: 100%; border: 1px solid #ededed !important;" border="0">
                            <tbody>
                                <tr> 
                                    <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;"><b>Objektif</b></td>
                                </tr> 
                                <tr>
                                    <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;">
                                        <div class="tandagejalanya">
                                            <?php
                                            $this->widget('MyJuiAutoComplete', array(
                                                'model' => $modDetail,
                                                'attribute' => '[0]tandagejala_indikator_mayorobjektif',
                                                'source' => 'js: function(request, response) {
                                                                       $.ajax({
                                                                           url: "' . $this->createUrl('AutocompleteMayorObjektif') . '",
                                                                           dataType: "json",
                                                                           data: {
                                                                               term: request.term
                                                                           },
                                                                           success: function (data) {
                                                                                response(data);
                                                                           }
                                                                       })
                                                                    }',
                                                'options' => array(
                                                    'showAnim' => 'fold',
                                                    'minLength' => 3,
                                                    'focus' => 'js:function( event, ui ) {
                                                                    $(this).val( ui.item.label);
                                                                    return false;
                                                                }',
                                                    'select' => 'js:function( event, ui ) {
                                                                    setTandaGejalaMayorObjektif(ui.item.value, this);
                                                                    return false;
                                                                }',
                                                ),
                                                'tombolDialog' => array("idDialog" => 'dialogTandaGejalaMayorObjektif', 'jsFunction' => "setDialogMayorObjektif(this);"),
                                                'htmlOptions' => array('class' => 'span3 tandagejala_indikator_mayorobjektif', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Tanda Gejala'),
                                            ));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table id="table-tandagejala" style="width: 100%; border: 1px solid #ededed !important;" border="0" class="mayor-objektif">
                            <tbody>
                                <tr> 
                                    <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;"></td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="width: 100%; border: 1px solid #ededed !important;" border="0">
                            <tbody>
                                <tr> 
                                    <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;"><b>Tanda dan Gejala Minor</b></td>
                                </tr>
                                <tr> 
                                    <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;"><b>Subjektif</b></td>
                                </tr>
                                <tr>   
                                    <td style="text-align: left; background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;">
                                          <div class="tandagejalanya">
                                            <?php
                                            $this->widget('MyJuiAutoComplete', array(
                                                'model' => $modDetail,
                                                'attribute' => '[0]tandagejala_indikator_minorsubjektif',
                                                'source' => 'js: function(request, response) {
                                                                       $.ajax({
                                                                           url: "' . $this->createUrl('AutocompleteMinorSubjektif') . '",
                                                                           dataType: "json",
                                                                           data: {
                                                                               term: request.term
                                                                           },
                                                                           success: function (data) {
                                                                                response(data);
                                                                           }
                                                                       })
                                                                    }',
                                                'options' => array(
                                                    'showAnim' => 'fold',
                                                    'minLength' => 3,
                                                    'focus' => 'js:function( event, ui ) {
                                                                    $(this).val( ui.item.label);
                                                                    return false;
                                                                }',
                                                    'select' => 'js:function( event, ui ) {
                                                                    setTandaGejalaMinorSubjektif(ui.item.value, this);
                                                                    return false;
                                                                }',
                                                ),
                                                'tombolDialog' => array("idDialog" => 'dialogTandaGejalaMinorSubjektif', 'jsFunction' => "setDialogMinorSubjektif(this);"),
                                                'htmlOptions' => array('class' => 'span3 tandagejala_indikator_minorsubjektif', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Tanda Gejala'),
                                            ));
                                            ?>
                                        </div>
                                    </td>
                                </tr>     
                            </tbody>
                        </table>
                        <table id="table-tandagejala" style="width: 100%; border: 1px solid #ededed !important;" border="0" class="minor-subjektif">
                            <tbody>
                                <tr> 
                                    <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;"></td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="width: 100%; border: 1px solid #ededed !important;" border="0">
                            <tbody>         
                                <tr> 
                                    <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;"><b>Objektif</b></td>
                                </tr> 
                                <tr>
                                    <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;">
                                        <div class="tandagejalanya">
                                            <?php
                                            $this->widget('MyJuiAutoComplete', array(
                                                'model' => $modDetail,
                                                'attribute' => '[0]tandagejala_indikator_minorobjektif',
                                                'source' => 'js: function(request, response) {
                                                                       $.ajax({
                                                                           url: "' . $this->createUrl('AutocompleteMinorObjektif') . '",
                                                                           dataType: "json",
                                                                           data: {
                                                                               term: request.term
                                                                           },
                                                                           success: function (data) {
                                                                                response(data);
                                                                           }
                                                                       })
                                                                    }',
                                                'options' => array(
                                                    'showAnim' => 'fold',
                                                    'minLength' => 3,
                                                    'focus' => 'js:function( event, ui ) {
                                                                    $(this).val( ui.item.label);
                                                                    return false;
                                                                }',
                                                    'select' => 'js:function( event, ui ) {
                                                                    setTandaGejalaMinorObjektif(ui.item.value, this);
                                                                    return false;
                                                                }',
                                                ),
                                                'tombolDialog' => array("idDialog" => 'dialogTandaGejalaMinorObjektif', 'jsFunction' => "setDialogMinorObjektif(this);"),
                                                'htmlOptions' => array('class' => 'span3 tandagejala_indikator_minorobjektif', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Tanda Gejala'),
                                            ));
                                            ?>
                                        </div>
                                    </td>
                                </tr> 
                            </tbody>
                        </table>
                        <table id="table-tandagejala" style="width: 100%; border: 1px solid #ededed !important;" border="0" class="minor-objektif">
                            <tbody>
                                <tr> 
                                    <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;"></td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>

            <div class="faktorrisiko" style="display: none">
                <div class="faktorrisikodetail">
                    <?php echo CHtml::css('#table-faktorrisiko thead tr th{vertical-align:middle;}'); ?>
                    <table style="width: 100%; border: 1px solid #ededed !important;" border="0">
                        <tbody>
                            <tr>
                                <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;">
                                    <div class="faktorrisikonya">
                                        <?php
                                        $this->widget('MyJuiAutoComplete', array(
                                            'model' => $modDetail,
                                            'attribute' => '[0]faktorrisikodet_indikator',
                                            'source' => 'js: function(request, response) {
                                                                   $.ajax({
                                                                       url: "' . $this->createUrl('AutocompleteFaktorRisiko') . '",
                                                                       dataType: "json",
                                                                       data: {
                                                                           term: request.term
                                                                       },
                                                                       success: function (data) {
                                                                            response(data);
                                                                       }
                                                                   })
                                                                }',
                                            'options' => array(
                                                'showAnim' => 'fold',
                                                'minLength' => 3,
                                                'focus' => 'js:function( event, ui ) {
                                                                    $(this).val( ui.item.label);
                                                                    return false;
                                                                }',
                                                'select' => 'js:function( event, ui ) {
                                                                    tambahRisikoAuto(ui.item.value, this);
                                                                    return false;
                                                                }',
                                            ),
                                            'tombolDialog' => array("idDialog" => 'dialogFaktorRisiko', 'jsFunction' => "setDialog2(this);"),
                                            'htmlOptions' => array('class' => 'span3 faktorrisikodet_indikator', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Faktor Risiko'),
                                        ));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table id="table-faktorrisiko" style="width: 100%; border: 1px solid #ededed !important;" border="0" class="kel-risiko">
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
      </label>
    </td>
    <td class="diagnosakep">
        <label>
            <?php echo CHtml::activeHiddenField($modDetail, '[0]diagnosisaskep_id', array('readonly' => true, 'class' => 'inputFormTabel diagnosisaskep_id  required')) ?>
            <?php
            if (!empty($modDetail->diagnosakep_id)) {
                echo CHtml::activeTextField($modDetail, '[0]diagnosakep_nama', array('readonly' => true, 'class' => 'diagnosakep_nama'));
                echo "<div class='diagdetail'>";
                echo "<br>";
                echo "<br>";
                echo '<b>Penyebab</b>';
                echo "<br>";
                $bk_head = BataskarakteristikM::model()->findAllByAttributes(array('diagnosakep_id' => $modDetail->diagnosakep_id));
                if (count($bk_head)) {
                    foreach ($bk_head as $i => $bk) {
                        echo "<ul class='spasi1'>";
                        echo '<li >' . $bk->bataskarakteristik_nama . '</li>';
                        $bk_tail = BataskarakteristikdetM::model()->findAllByAttributes(array('bataskarakteristikdet_aktif' => true, 'bataskarakteristik_id' => $bk->bataskarakteristik_id));
                        if (count($bk_tail)) {
                            foreach ($bk_tail as $i => $bkd) {
                                echo '<li >' . $bkd->bataskarakteristikdet_indikator . '</li>';
                            }
                        } else {
                            echo "<ul class='spasi1'>";
                            echo '<li> Data tidak ditemukan. </li>';
                            echo "</ul>";
                        }
                        echo "</ul>";
                    }
                } else {
                    echo "<ul class='spasi1'>";
                    echo '<li> Data tidak ditemukan. </li>';
                    echo "</ul>";
                }

                echo "<br>";

                echo '<b>Kondisi Klinis Terkait</b>';
                echo "<br>";
                $bk_head = FaktorhubM::model()->findAllByAttributes(array('diagnosakep_id' => $modDetail->diagnosakep_id));
                if (count($bk_head)) {
                    foreach ($bk_head as $i => $bk) {
                        echo "<ul class='spasi1'>";
                        echo '<li >' . $bk->faktorhub_nama . '</li>';
                        $bk_tail = FaktorhubdetM::model()->findAllByAttributes(array('faktorhubdet_aktif' => true, 'faktorhub_id' => $bk->faktorhub_id));
                        if (count($bk_tail)) {
                            foreach ($bk_tail as $i => $bkd) {
                                echo '<li >' . $bkd->faktorhubdet_indikator . '</li>';
                            }
                        } else {
                            echo "<ul class='spasi1'>";
                            echo '<li> Data tidak ditemukan. </li>';
                            echo "</ul>";
                        }
                        echo "</ul>";
                    }
                } else {
                    echo "<ul class='spasi1'>";
                    echo '<li> Data tidak ditemukan. </li>';
                    echo "</ul>";
                }
                echo "<div>";
            } else {
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modDetail,
                    'attribute' => '[0]diagnosakep_nama',
                    //'name'=>'daftartindakan_nama',
                    'source' => 'js: function(request, response) {
                               $.ajax({
                                   url: "' . $this->createUrl('AutocompleteDiagnosa') . '",
                                   dataType: "json",
                                   data: {
                                       term: request.term
                                   },
                                   success: function (data) {
                                           response(data);
                                   }
                               })
                            }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                        $(this).val( ui.item.label);
                        return false;
                    }',
                        'select' => 'js:function( event, ui ) {
                        setDiagnosaAuto(ui.item.diagnosakep_id);
                        return false;
                    }',
                    ),
                    'tombolDialog' => array("idDialog" => 'dialogDiagnosa', 'jsFunction' => "setDialog3(this);"),
                    'htmlOptions' => array('onblur'=>'resetDiagnosa(obj)','class' => 'span3 diagnosakep_nama required', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                ));
            }
            ?>
            <div class="diagdetail">

            </div>
      </label>
    </td>
    <td style="text-align: center;" class="rowbutton">
        <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', 'javascript:void(0)', array('class' => 'btn btn-primary', 'onclick' => 'addRowTindakan(this)')); ?> <br> <br>
        <?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', 'javascript:void(0)', array('class' => 'btn btn-primary', 'onclick' => 'batalTindakan(this)')); ?>
    </td>
</tr>
