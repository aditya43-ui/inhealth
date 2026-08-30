<!--<legend class="rim"><i class="entypo-search"></i> Pencarian</legend>-->
<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'penyebearanpenyakit-peta-search',
	'type'=>'horizontal',

)); ?>
<style>
	label.checkbox{
		margin-left: 50px;
		width: 50px;
		display:inline-block;
	}
</style>
<div class="row">
	<div class="span5">
	<fieldset class="box2">
		<legend class="rim">Berdasarkan Periode Waktu</legend>
		<div class="control-group">
			<?php echo CHtml::label('Periode ','Periode ', array('class'=>'control-label'));?>
			<div class="controls">
					<?php echo $form->dropDownList($model,'jns_periode', array('hari'=>'Hari','bulan'=>'Bulan','tahun'=>'Tahun'), 
							array(
							'onChange'=>'ubahJnsPeriode()',
							'onkeypress'=>"return $(this).focusNextInputField(event)",
							'style'=>'width:120px;',
							'style'=>'width:120px;float:left', 
							'onchange'=>'ubahJnsPeriode();')); 
					?>
			</div>
		</div>
		<div class="control-group">
			<div style="margin-left:2px;margin-top:10px;float:left;">
			<div class='control-group hari'>
				<?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
					$this->widget('MyDateTimePicker', array(
						'model' => $model,
						'attribute' => 'tgl_awal',
						'mode' => 'date',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							'maxDate'=>'d',
						),
						'htmlOptions' => array('readonly' => true, 'class' => "span2",'style'=>'width:90px;',
							'onkeypress' => "return $(this).focusNextInputField(event)"),
					));
					?>
				</div> 
			</div>
			<div class='control-group bulan'>
				<?php echo CHtml::label('Dari Bulan', 'dari_tanggal', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php 
						$this->widget('MyMonthPicker', array(
							'model' => $model,
							'attribute' => 'bln_awal', 
							'options'=>array(
								'dateFormat' => Params::MONTH_FORMAT,
							),
							'htmlOptions' => array('readonly' => true,'style'=>'width:90px;',
								'class' => "span2",
								'onkeypress' => "return $(this).focusNextInputField(event)"),
						));  
					?>
				</div> 
			</div>
			<div class='control-group tahun'>
				<?php echo CHtml::label('Dari Tahun', 'dari_tanggal', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php 
					echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null,null), array('class' => "span2",'style'=>'width:90px;','onkeypress' => "return $(this).focusNextInputField(event)")); 
					?>
				</div>
			</div>
			</div>
		</div>
		<div class="control-group">
			<div style="margin-left:2px;float:left;">
				<div class='control-group hari'>
					<?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php
						$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tgl_akhir',
							'mode' => 'date',
							'options' => array(
								'dateFormat' => Params::DATE_FORMAT,
								'maxDate'=>'d',
							),
							'htmlOptions' => array('readonly' => true,'class' => "span2",'style'=>'width:90px;',
								'onkeypress' => "return $(this).focusNextInputField(event)"),
						));
						?>
					</div> 
				</div>
				<div class='control-group bulan'>
					<?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php 
							$this->widget('MyMonthPicker', array(
								'model' => $model,
								'attribute' => 'bln_akhir', 
								'options'=>array(
									'dateFormat' => Params::MONTH_FORMAT,
								),
								'htmlOptions' => array('readonly' => true,'class' => "span2",'style'=>'width:90px;',
									'onkeypress' => "return $(this).focusNextInputField(event)"),
							));  
						?>
					</div> 
				</div>
				<div class='control-group tahun'>
					<?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php 
						echo $form->dropDownList($model, 'thn_akhir', CustomFunction::getTahun(null,null), array('class' => "span2",'style'=>'width:90px;','onkeypress' => "return $(this).focusNextInputField(event)")); 
						?>
					</div>
				</div>
			</div>
		
		</div>
	</fieldset>
	</div>
	<div class="span7">
		<fieldset class="box2" id="cb-typerumah">
			<legend class="rim">
				<?php echo CHtml::checkBox('checkTypeRumah',false, array('onkeypress'=>"return $(this).focusNextInputField(event)",
                            'class'=>'checkbox-column',"rel"=>"tooltip","title"=>"Check ini jika ingin melakukan pencarian berdasrkan jenis tempat tinggal")); ?>
				&nbsp; Berdasarkan Jenis Tempat Tinggal</legend>
			<div class='control-group'>
				<div class="controls">
					  <?php echo $form->checkBoxList($model, 'typerumah', SGPegawaiptbM::getTypeRumah(),array('disabled'=>true,'onlick')) ?>
				</div>
		   </div>
		</fieldset>
		<fieldset class="box2">
		<legend class="rim">Berdasarkan Diagnosa</legend>
			<table id="table_pencariandiagnosa" class="table table-condensed table-striped">
                <thead>
                    <th width="5%">No.</th>
                    <th>Kode Diagnosa</th>
                    <th>Nama Diagnosa</th>
                    <th width="10%"></th>
                </thead>
                <tbody>
					<?php echo $this->renderPartial("_rowDiagnosa",array('form'=>$form,'modDiagnosa'=>$modDiagnosa), true); ?>
                </tbody>
            </table>
		</fieldset>
	</div>
</div>
<br>
<div class="form-actions">
	<?php
			echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), 
					array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_cari',));
	?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),$this->createUrl($this->id.'/index'),array('class' => 'btn btn-default','onclick'=>'return refreshForm(this);')); ?>
</div>

<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'dialog_diagnosa',
        'options'=>array(
            'title'=>'Daftar Diagnosa Pasien Rumah Sakit',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>860,
            'height'=>580,
            'resizable'=>false,
        ),
    )
);
echo CHtml::hiddenField('diagnosa_untuk',0,array('readonly'=>true));
$modDiagnosa = new SGDiagnosaM('search');
$modDiagnosa->unsetAttributes();
if (isset($_GET['SGDiagnosaM'])){
    $modDiagnosa->attributes = $_GET['SGDiagnosaM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sadiagnosa-m-grid',
	'dataProvider'=>$modDiagnosa->searchDialog(),
	'filter'=>$modDiagnosa,
        'template'=>"{summary}\n{items}{pager}",
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
		////'diagnosa_id',
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",'
			. '"onClick" => "pilihDiagnosa(\"$data->diagnosa_id\",\"$data->diagnosa_kode\",\"$data->diagnosa_nama\");
				$(\"#dialog_diagnosa\").dialog(\"close\");
				return false;"))',
		),
		'diagnosa_kode',
		'diagnosa_nama',
		'diagnosa_namalainnya',
		'diagnosa_katakunci',
               
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script>
	
var row_diagnosa = new String(<?php echo CJSON::encode($this->renderPartial('_rowDiagnosa',array('form'=>$form,'modDiagnosa'=>$modDiagnosa,'is_adatombolhapus'=>true),true));?>);

function tambahDiagnosa(){
	var table = $('#table_pencariandiagnosa');
    $(table).children('tbody').append(row_diagnosa.replace());
	$(table).find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
    renameInputRow($(table));
}

function pilihDiagnosa(diagnosa_id,diagnosa_kode,diagnosa_nama){
    var diagnosa_untuk = $("#diagnosa_untuk").val();
    $("#"+diagnosa_untuk).parents('tr').find('input[name$="[diagnosa_id]"]').val(diagnosa_id);
    $("#"+diagnosa_untuk).parents('tr').find('input[name$="[diagnosa_kode]"]').val(diagnosa_kode);
    $("#"+diagnosa_untuk).parents('tr').find('input[name$="[diagnosa_nama]"]').val(diagnosa_nama);
}

function setDialogDiagnosa(obj){
    var diagnosa_untuk = $(obj).parent().parent().find('input').attr('id');
    $("#diagnosa_untuk").val(diagnosa_untuk);
    var ruangan_id = $(obj).parents('tr').find('select[name$="[ruangan_id]"]').val();
    var ruangan_nama = $(obj).parents('tr').find('select[name$="[ruangan_id]"] option:selected').text();
    var kelaspelayanan_id = $("#kelaspelayanan_id").val();
    var tipepaket_id = $("#tipepaket_id").val();
    var penjamin_id = $("#penjamin_id").val();
    $("#dialog_diagnosa > div").addClass("animation-loading");
    $("#dialog_diagnosa").dialog("open");
    $.fn.yiiGridView.update('sadiagnosa-m-grid', {
        data:{
        }
    });
}
function batalDiagnosa(obj){
	$(obj).parents('tr').detach();
	renameInputRow($('#table_pencariandiagnosa'));
}
	
function setPeriode(){
	var namaPeriode = $('#PeriodeName').val();
		$.post('<?php echo Yii::app()->createUrl('actionAjax/GantiPeriode'); ?>',{namaPeriode:namaPeriode},function(data){
			$('#SGPetapenyebaranpenyakitR_tgl_awal').val(data.periodeawal);
			$('#SGPetapenyebaranpenyakitR_tgl_akhir').val(data.periodeakhir);
		},'json');
}

function ubahJnsPeriode(){
	var obj = $("#<?php echo CHtml::activeId($model, 'jns_periode')?>");
	if(obj.val() == 'hari'){
		$('.hari').show();
		$('.bulan').hide();
		$('.tahun').hide();
	}else if(obj.val() == 'bulan'){
		$('.hari').hide();
		$('.bulan').show();
		$('.tahun').hide();
	}else if(obj.val() == 'tahun'){
		$('.hari').hide();
		$('.bulan').hide();
		$('.tahun').show();
	}
}

$('#btn_cari').click(function(){
	var icon = "<a href='javascript:void(0);' onclick='resettrpertama(this);return false;'><i class='icon-trash'></i></a>";
	$('#iconresettrpertama').html(icon);
});
function resettrpertama(obj){
	$(obj).parents('tr').find('input[name*="[diagnosa_id]"]').val('');
	$(obj).parents('tr').find('input[name*="[diagnosa_kode]"]').val('');
	$(obj).parents('tr').find('input[name*="[diagnosa_nama]"]').val('');
	$(obj).remove();
}

$('#checkTypeRumah').click(function(){
	if ($("#checkTypeRumah").is(":checked")) {
        $('#cb-typerumah input[name*="typerumah"]').each(function(){
           $(this).attr('disabled',false);
           $(this).attr('checked',true);
        })
    }else{
       $('#cb-typerumah input[name*="typerumah"]').each(function(){
           $(this).removeAttr('checked');
		    $(this).attr('disabled',true);
        })
    }
});

$(document).ready(function() {
	ubahJnsPeriode();
});
</script>
