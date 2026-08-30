
<?php echo "<?php"; ?> 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
    $template = "{items}";
}
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');   
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>''));      

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
<?php
$count=0;
foreach($this->tableSchema->columns as $column)
{
	if(++$count==7)
		echo "\t\t/*\n";
        if($column->name != $this->tableSchema->primaryKey) {
            echo "\t\t'".$column->name."',\n";
        }
        else {
            echo "\t\t////'".$column->name."',\n";
            echo "\t\tarray(
                        'header'=>'ID',
                        'value'=>'\$data->".$this->tableSchema->primaryKey."',
                ),\n";
        }
}
if($count>=7)
	echo "\t\t*/\n";
?> 
        ),
    )); 
<?php echo "?>"; ?>
