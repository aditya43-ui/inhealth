<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/js/orgchart/jquery.orgchart.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/orgchart/jquery-1.11.1.min.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/orgchart/jquery.orgchart.js'); ?>
<style type="text/css">
	#orgChart{
		width: auto;
		height: auto;
	}

	#orgChartContainer{
		width: 100%;
		height: 500px;
		overflow: auto;
		background: #eeeeee;
	}
	.node{
		width: 240px !important;
		height: auto !important;
	}
        div.orgChart div.node{
            border: 1px solid #333;
        }
        div.orgChart h2{
            font-size:14px;
        }
</style>
	

<style>
   
                .border th, .border td{
                    border:1px solid #000;
                }
                .table thead:first-child{
                    border-top:1px solid #000;        
                }

                thead th{
                    background:none;
                    color:#333;
                }

                .border {
                    box-shadow:none;
                    border-spacing: 0;
                    padding: 0;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>

<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
               
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan'=>""));
                 ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
   <div id="orgChart"></div>
		</div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
   
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
   
</div>   

<script type="text/javascript">
<?php
echo "var data = [";
if(count((array)$modOrgAsal) > 0){	
	foreach($modOrgAsal AS $i => $asl){
		//$icon_edit = '<a href="'.$this->createUrl('update',array('id'=>$org->organigram_id,'from'=>'organigram')).'" onclick="ubahData(this); return false;" rel="tooltip" class="update" title="Ubah"><i class="icon-form-ubah"></i></a>';
		$icon_edit = "<a href='".$this->createUrl('update',array('id'=>$asl['organigram_id'],'from'=>'organigram'))."' onclick='ubahData(this); return false;' rel='tooltip' class='update' title='Ubah'><i class='icon-form-ubah'></i></a>";
		if(isset($_GET['caraPrint'])){
			$icon_edit = "";
		}
		/*echo "{id: ".$org->organigram_id.', name: "'
				.(isset($org->pegawai->jabatan->jabatan_nama) ? $org->pegawai->jabatan->jabatan_nama : $org->organigram_unitkerja)
			.$icon_edit
			."<br>".(!empty($org->pegawai_id) ? $org->pegawai->NamaLengkap : "-").'", parent: '.(empty($org->organigramasal_id) ? "0" : $org->organigramasal_id)."},\n";*/
		echo "{id: ".$asl['organigram_id'].', '
			. 'name:"'.$icon_edit.'<b>'.$asl['organigram_unitkerja']."</b><br>".$asl['nama_pegawai'].'",'
			. 'parent: '.(empty($asl['organigramasal_id']) ? "0" : $asl['organigramasal_id'])."},\n";
	}
	
}

if(count((array)$modOrg) > 0){	
	foreach($modOrg AS $i => $det){
		//$icon_edit = '<a href="'.$this->createUrl('update',array('id'=>$org->organigram_id,'from'=>'organigram')).'" onclick="ubahData(this); return false;" rel="tooltip" class="update" title="Ubah"><i class="icon-form-ubah"></i></a>';
		$org_id = null;
		$nama = '<b>'.$det['organigram_unitkerja']."</b><br><ol style='text-align:left';>";
		
		foreach($det['det'] as $j => $org){
			$org_id = $org['organigram_id'];
			$icon_edit = "<a href='".$this->createUrl('update',array('id'=>$org['organigram_id'],'from'=>'organigram'))."' onclick='ubahData(this); return false;' rel='tooltip' class='update' title='Ubah'><i class='icon-form-ubah'></i></a>";
			if(isset($_GET['caraPrint'])){
				$icon_edit = "";
			}
			/*echo "{id: ".$org->organigram_id.', name: "'
					.(isset($org->pegawai->jabatan->jabatan_nama) ? $org->pegawai->jabatan->jabatan_nama : $org->organigram_unitkerja)
				.$icon_edit
				."<br>".(!empty($org->pegawai_id) ? $org->pegawai->NamaLengkap : "-").'", parent: '.(empty($org->organigramasal_id) ? "0" : $org->organigramasal_id)."},\n";*/
			$nama .= "<li style='padding-bottom:10px;'> ".$org['nama_pegawai']."</li>";
		}
		$nama .= '</ol>';
		
		echo "{id: ".$org_id.', '
			. 'name:"'.$nama.'",'
			. 'parent: '.(empty($det['organigramasal_id']) ? "0" : $det['organigramasal_id'])."},\n";
	}
	
}
echo " ];";
?>
	
$(function(){
	org_chart = $('#orgChart').orgChart({
		data: data,
		showControls: false,
		allowEdit: false,
		onAddNode: function(node){ 
			org_chart.newNode(node.data.id); 
		},
		onDeleteNode: function(node){
			org_chart.deleteNode(node.data.id); 
		},
		onClickNode: function(node){
		}

	});
});
/**
 * ubah data organigram
 * @param {type} obj
 * @returns {Boolean}
 */
function ubahData(obj){
	parent.window.location.href = obj.href;
	return false;
}

function printOrganigram(){
	window.open("<?php echo $this->createUrl('organigram'); ?>&caraPrint=PRINT","",'location=_new, width=900px');
}
</script>

<div class="form-actions">
	<?php 
	if(!isset($_GET['caraPrint'])){
		echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printOrganigram()')); 
	}
	?>
</div>