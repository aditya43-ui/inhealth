<?php

Yii::import('bootstrap.widgets.BootGridView');

/**
* @category      User Interface
* @package        extensions
* @author          Iqbal Laksana <iqballaksana01@gmail.com>
* @version        1.0
* @function      digunakan untuk menghilangkan <thead></thead> untuk mengatasi ketika export PDF data ada yang hilang
 */
class BootGridViewPDFNonRp extends BootGridView
{
    public $mergeHeaders = array();
    private $_mergeindeks = array();
    private $_nonmergeindeks = array();
	public $multipleHeader = array();
    
    public function renderTableHeader()
    {
            if(!$this->hideHeader)
            {
                    //echo "<thead>\n";

                    if($this->filterPosition===self::FILTER_POS_HEADER)
                            $this->renderFilter();

                    echo "<tr>\n";
                    foreach($this->columns as $column)
                            $column->renderHeaderCell();
                    echo "</tr>\n";

                    if($this->filterPosition===self::FILTER_POS_BODY)
                            $this->renderFilter();

                    //echo "</thead>\n";
            }
            else if($this->filter!==null && ($this->filterPosition===self::FILTER_POS_HEADER || $this->filterPosition===self::FILTER_POS_BODY))
            {
            //	echo "<thead>\n";
                    $this->renderFilter();
                    //echo "</thead>\n";
            }
    }
    
    public function renderItems()
	{
		if($this->dataProvider->getItemCount()>0 || $this->showTableOnEmpty)
		{
			echo "<table class=\"{$this->itemsCssClass}\">\n";
			if(!empty($this->mergeHeaders)){
			//	echo "<thead>\n";
				$this->renderGroupHeaders();
				//echo "</thead>\n";
			}
			elseif (!empty($this->multipleHeader)){
					$this->multiRowHeader();
					//$this->renderTableHeader();
			}
			else {
				$this->renderTableHeader();
			}
			$this->renderTableBody();
			$this->renderTableFooter();
			echo "</table>";
		}
		else
			$this->renderEmptyText();
	}
	
	public function renderGroupHeaders()
	{
		$this->setMergeIndeks();
		$this->setNonMergeIndeks();
		echo "<tr>\n";
		
		ob_start();
		echo "<tr>\n";
		$i=0;
		foreach($this->columns as $column){
			if(in_array($i, $this->_mergeindeks)):
				$column->headerHtmlOptions['colspan']='1';
				$column->renderHeaderCell();
			endif;
			$i++;
		}
		echo "</tr>\n";
		$header_bottom = ob_get_clean();
		
		$i=0;
		foreach($this->columns as $column){			
			for($m=0;$m<count($this->mergeHeaders);$m++){
				if($i==$this->mergeHeaders[$m]["start"]):
					$column->headerHtmlOptions['colspan']=$this->mergeHeaders[$m]["end"]-$this->mergeHeaders[$m]["start"]+1;
					$column->header = $this->mergeHeaders[$m]["name"];
					$column->id = NULL;
					$column->renderHeaderCell();
				endif;
			}
			if(in_array($i, $this->_nonmergeindeks)){
				$column->headerHtmlOptions['rowspan']='2';
				$column->renderHeaderCell();
			}
			$i++;
		}
		echo "</tr>\n";
		
		echo $header_bottom;
	}
	
	protected function setMergeIndeks()
	{
		for($i=0;$i<count($this->mergeHeaders);$i++)
			for($j=$this->mergeHeaders[$i]["start"];$j<= $this->mergeHeaders[$i]["end"];$j++)
				$this->_mergeindeks[] = $j;
	}
	
	protected function setNonMergeIndeks()
	{
		foreach($this->columns as $key=>$val) $h[] = $key;
		$this->_nonmergeindeks = array_diff($h, $this->_mergeindeks);
	}
        
        public function renderTableFooter()
	{
		$hasFilter=$this->filter!==null && $this->filterPosition===self::FILTER_POS_FOOTER;
		$hasFooter=$this->getHasFooter();
                $data=$this->dataProvider->getData();
		$n=count($data)*200;
		if($hasFilter || $hasFooter)
		{
                    if($n > 0){
			echo "<tbody>\n";
			if($hasFooter)
			{
				echo "<tr>\n";
				foreach($this->columns as $column){
                                    if(($column->footer != null) || ($column->footer)){
                                        $jumlah = 0;
                                        $value = false;
                                        foreach ($data as $i=>$x){
                                            if ($column->footer == 'sum('.$column->name.')'){
                                                $jumlah += $x[$column->name];
                                                $value = true;
                                            }
                                        }
                                        if (($value == true)){
                                            $column->footer = number_format($jumlah,0,"",".");
                                        }
					$column->renderFooterCell();
                                    }
                                }
				echo "</tr>\n";
			}
			if($hasFilter)
				$this->renderFilter();
			echo "</tbody>\n";
                    }
		}
	}
	
	protected function multiRowHeader() {
        echo CHtml::openTag('thead') . "\n";
        foreach ($this->multipleHeader as $row) {
            $this->addHeaderRow($row);
        }
        echo CHtml::closeTag('thead') . "\n";
    }
     
    protected function addHeaderRow($row) {
        // add a single header row
        echo CHtml::openTag('tr') . "\n";
        // inherits header options from first column
        $options = $this->columns[0]->headerHtmlOptions;
        foreach ($row as $header) {
            $options['colspan'] = $header['colspan'];
            $cellOptions=($header['options'] + $options);
            echo CHtml::openTag('th', $cellOptions);
            echo $header['text'];
            echo CHtml::closeTag('th');
        }
        echo CHtml::closeTag('tr') . "\n";
    }
	
}
