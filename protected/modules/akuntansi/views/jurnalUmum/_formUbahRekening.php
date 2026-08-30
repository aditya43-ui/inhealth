<style>

    body {
        color: black;
    }

    .border th, .border td{
        border:1px solid #000;
        padding:2px;
    }
    .table thead:first-child{
        border-top:1px solid #000;
    }

    thead th{
        background:none;
        color:#333;
    }

    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>
<?php
if(isset($_GET['sukses'])){
	Yii::app()->user->setFlash('success',"Data berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'ubahrekening-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);')
)); ?>
<table width="100%" class ="table table-striped table-bordered table-condensed" id="tblrekening">
    <thead class="border">
        <tr>
            <th rowspan="2" style="text-align: center">Kode Jurnal</th>
            <th rowspan="2" style="text-align: center; width: 300px">Kode / Nama Akun</th>
            <th rowspan="2" style="text-align: center">Uraian Jurnal</th>
            <th colspan="2" style="text-align: center">Saldo</th>
        </tr>
        <tr>
            <th style="text-align: center">Debit</th>
            <th style="text-align: center">Kredit</th>
        </tr>
    </thead>
      <tbody>
        <?php
          if(count((array)$modJurnalDet) > 0){

            foreach ($modJurnalDet as $i => $det) {
              if(!empty($det->rekening5_id)){
                $rekeningAkun = RekeningakuntansiV::model()->findByAttributes(array('rekeninglast_id'=>$det->rekening5_id));

                if(isset($rekeningAkun)){
                  $det->rekening_nama = $rekeningAkun->nmrekeninglast;
                  $det->rekening4_id = $rekeningAkun->rekening4_id;
                  $det->rekening3_id = $rekeningAkun->rekening3_id;
                  $det->rekening2_id = $rekeningAkun->rekening2_id;
                  $det->rekening1_id = $rekeningAkun->rekening1_id;
                  $det->rekening5_id = $rekeningAkun->rekeninglast_id;
                }
              }

              ?>
                <tr>
                  <td>
                    <?php echo $det->jurnalRekening->kodejurnal; ?>
                  </td>
                  <td>
                    <?php echo CHtml::activeHiddenField($det,'['.$i.']jurnalrekening_id'); ?>
                    <?php echo CHtml::activeHiddenField($det,'['.$i.']jurnaldetail_id'); ?>

                    <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $det,
                            'attribute' => '['.$i.']rekening_nama',
                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ){return false;}',
                                'select' => 'js:function( event, ui ) {
                                    tambahDataRekening(ui.item.rincianobyek_id);
                                    return false;
                                }'
                            ),
                            'htmlOptions' => array(
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'placeholder'=>'Kode/ Nama Akun',
                                'class'=>'span3 required',
                            ),
                            'tombolDialog' => array(
            					'idDialog' =>'dialogRek',
            					'jsFunction'=>'ubahRekening(this); return false;',
            				),
                        ));
                    ?>
                    <?php echo CHtml::activeHiddenField($det,'['.$i.']rekening1_id',array()); ?>
                    <?php echo CHtml::activeHiddenField($det,'['.$i.']rekening2_id',array()); ?>
                    <?php echo CHtml::activeHiddenField($det,'['.$i.']rekening3_id',array()); ?>
                    <?php echo CHtml::activeHiddenField($det,'['.$i.']rekening4_id',array()); ?>
                    <?php echo CHtml::activeHiddenField($det,'['.$i.']rekening5_id',array()); ?>
                  </td>
                  <td>
                    <?php echo $det->jurnalRekening->urianjurnal ?>
                  </td>
                  <td>
                    Rp <?php echo MyFormatter::formatNumberForPrint($det->saldodebit,2) ?>
                  </td>
                  <td>
                    Rp <?php echo MyFormatter::formatNumberForPrint($det->saldokredit,2) ?>
                  </td>
                </tr>
              <?php
            }
          }
         ?>
      </tbody>
</table>
<div class="form-actions">
  <?php
    $disabled = false;

    if(isset($_GET['sukses'])){
      $disabled = true;
    }
  ?>
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
		array('class' => 'btn btn-danger', 'type'=>'submit','id'=>'btn_simpan','disabled'=>$disabled)); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),
		Yii::app()->createUrl($this->module->id.'/JurnalUmum/ubahRekening',array('jurnalrekening_id'=>$_GET['jurnalrekening_id'])),
		array('class' => 'btn btn-default',
			'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
</div>
<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Rek Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRek',
    'options'=>array(
        'title'=>'Daftar Rekening',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>700,
        'resizable'=>false,
    ),
));

$modRekDebit = new RekeningakuntansiV('searchDialogAccount');
$modRekDebit->unsetAttributes();
// $modRekDebit->rekening5_nb = $account;
// $modRekDebit->rekening5_aktif = true;
if(isset($_GET['RekeningakuntansiV'])) {
    $modRekDebit->attributes = $_GET['RekeningakuntansiV'];
	// $modRekDebit->rekening5_nb = $account;
}

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'rekdebit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modRekDebit->searchDialogAccount(),
	'filter'=>$modRekDebit,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectRekDebit",
                                    "onClick" =>"
												pilihDialogRekening(".CJSON::encode($data->attributes).");
                                                $(\"#dialogRek\").dialog(\"close\");
                                                return false;
                            "))',
                ),
                array(
                    'header' => 'Kode Akun',
                    'name' => 'kdrekeninglast',
                    'value' => '$data->kdrekeninglast',
                ),
                array(
                    'header' => 'Level 1',
                    'name' => 'nmrekening1',
                    'value' => '$data->nmrekening1',
                ),
                array(
                    'header' => 'Level 2',
                    'name' => 'nmrekening2',
                    'value' => '$data->nmrekening2',
                ),
                array(
                    'header' => 'Level 3',
                    'name' => 'nmrekening3',
                    'value' => '$data->nmrekening3',
                ),
                array(
                    'header' => 'Level 4',
                    'name' => 'nmrekening4',
                    'value' => '$data->nmrekening4',
                ),
                array(
                    'header' => 'Level 5',
                    'name' => 'nmrekening5',
                    'value' => '$data->nmrekening5',
                ),
                array(
                    'header' => 'Level 6',
                    'name' => 'kdrekening6',
                    'value' => '$data->nmrekening6',
                ),
                array(
                    'header' => 'Level 7',
                    'name' => 'nmrekening7',
                    'value' => '$data->nmrekening7',
                ),
                array(
                    'header' => 'Level 8',
                    'name' => 'nmrekening8',
                    'value' => '$data->nmrekening8',
                ),
                array(
                    'header' => 'Level 9',
                    'name' => 'nmrekening9',
                    'value' => '$data->nmrekening9',
                ),
                array(
                    'header' => 'Level 10',
                    'name' => 'nmrekening10',
                    'value' => '$data->nmrekening10',
                ),
                array(
                    'header' => 'Saldo Normal',
                    'name' => 'rekeninglast_nb',
                    'value' => '($data->rekeninglast_nb == "D") ? "Debit" : "Kredit"',
                    'filter' =>  CHtml::activeDropDownList($modRekDebit, 'rekeninglast_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Debit dialog =============================
?>
<script type="text/javascript">
var cur_id;

function ubahRekening(obj) {
  cur_id = $(obj).parents("tr").index();
  $("#dialogRek").dialog("open");
}

function pilihDialogRekening(data) {
  var obj = $("#tblrekening > tbody > tr").eq(cur_id);

  $(obj).find('input[name$="[rekening1_id]"]').val(data.rekening1_id);
  $(obj).find('input[name$="[rekening2_id]"]').val(data.rekening2_id);
  $(obj).find('input[name$="[rekening3_id]"]').val(data.rekening3_id);
  $(obj).find('input[name$="[rekening4_id]"]').val(data.rekening4_id);
  $(obj).find('input[name$="[rekening5_id]"]').val(data.rekeninglast_id);

  $(obj).find('input[name$="[rekening_nama]"]').val(data.nmrekeninglast);
}
</script>
