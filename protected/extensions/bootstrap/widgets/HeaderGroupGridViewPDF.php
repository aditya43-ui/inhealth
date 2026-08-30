<?php

Yii::import('bootstrap.widgets.HeaderGroupGridViewNonRp');
/**
* @category      User Interface
* @package        extensions
* @author          Iqbal Laksana <iqballaksana01@gmail.com>
* @version        1.0
* @function      digunakan untuk menghilangkan <thead></thead> untuk mengatasi ketika export PDF data ada yang hilang
 */
class HeaderGroupGridViewPDF extends HeaderGroupGridViewNonRp {
	
        const MERGE_SIMPLE = 'simple';
        const MERGE_NESTED = 'nested';
        const MERGE_FIRSTROW = 'firstrow';

	public $mergeHeaders = array();
	private $_mergeindeks = array();
	private $_nonmergeindeks = array();
        public $mergeColumns = array();
        
        public $mergeType = self::MERGE_SIMPLE;
        public $mergeCellCss = 'text-align: center; vertical-align: middle';

        public $extraRowColumns = array();
        public $extraRowExpression;

        private $_changes;
        
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
				//echo "<thead>\n";
				$this->renderGroupHeaders();
				//echo "</thead>\n";
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
              //  echo "<thead>\n";
			$this->renderFilter();
			//echo "</thead>\n";
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
        
        
	
         public function renderTableBody()
        {
            if(!empty($this->mergeColumns) || !empty($this->extraRowColumns)) {
                $this->groupByColumns();
            }
            parent::renderTableBody();
        }

        /**
        * find and store changing of group columns
        * 
        * @param mixed $data
        */
        public function groupByColumns()
        {
            $data = $this->dataProvider->getData();
            if(count($data) == 0) return;

            if(!is_array($this->mergeColumns)) $this->mergeColumns = array($this->mergeColumns);
            if(!is_array($this->extraRowColumns)) $this->extraRowColumns = array($this->extraRowColumns);

            //store columns for group. Set object for existing columns in grid and string for attributes
            $groupColumns = array_unique(array_merge($this->mergeColumns, $this->extraRowColumns));
            foreach($groupColumns as $key => $colName) {
                foreach($this->columns as $column) {
                    if(property_exists($column, 'name') && $column->name == $colName) {
                        $groupColumns[$key] = $column;
                        break;
                    }
                }
            }


            //values for first row
            $lastStored = $this->getRowValues($groupColumns, $data[0], 0);
            foreach($lastStored as $colName => $value) {
                $lastStored[$colName] = array(
                'value' => $value,
                'count' => 1,
                'index' => 0,
                );
            }

            //iterate data 
            for($i = 1; $i < count($data); $i++) {
                //save row values in array
                $current = $this->getRowValues($groupColumns, $data[$i], $i);

                //define is change occured. Need this extra foreach for correctly proceed extraRows
                $changedColumns = array();
                foreach($current as $colName => $curValue) {  
                    if($curValue != $lastStored[$colName]['value']) {
                        $changedColumns[] = $colName;
                    }
                }

                /*
                 if this flag = true -> we will write change (to $this->_changes) for all grouping columns.
                 It's required when change of any column from extraRowColumns occurs
                */
                $saveChangeForAllColumns = (count(array_intersect($changedColumns, $this->extraRowColumns)) > 0);

                /*
                 this changeOccured related to foreach below. It is required only for mergeType == self::MERGE_NESTED, 
                 to write change for all nested columns when change of previous column occured
                */
                $changeOccured = false;
                foreach($current as $colName => $curValue) {
                    //value changed
                    $valueChanged = ($curValue != $lastStored[$colName]['value']);
                    //change already occured in this loop and mergeType set to MERGETYPE_NESTED
                    $saveChange = $valueChanged || ($changeOccured && $this->mergeType == self::MERGE_NESTED);

                    if($saveChangeForAllColumns || $saveChange) { 
                        $changeOccured = true;

                        //store in class var
                        $prevIndex = $lastStored[$colName]['index'];
                        $this->_changes[$prevIndex]['columns'][$colName] = $lastStored[$colName];
                        if(!isset($this->_changes[$prevIndex]['count'])) {
                            $this->_changes[$prevIndex]['count'] = $lastStored[$colName]['count'];
                        }

                        //update lastStored for particular column
                        $lastStored[$colName] = array(
                        'value' => $curValue,
                        'count' => 1,
                        'index' => $i,
                        );                    

                    } else {
                        $lastStored[$colName]['count']++;
                    } 
                }
            }

            //storing for last row
            foreach($lastStored as $colName => $v) {
                $prevIndex = $v['index'];
                $this->_changes[$prevIndex]['columns'][$colName] = $v;
                if(!isset($this->_changes[$prevIndex]['count'])) {
                    $this->_changes[$prevIndex]['count'] = $v['count'];
                }  
            }
        }

        public function renderTableRow($row)
        {
            $change = false;
            if($this->_changes && array_key_exists($row, $this->_changes)) {
                $change = $this->_changes[$row];
                //if change in extracolumns --> put extra row
                $columnsInExtra = array_intersect(array_keys($change['columns']), $this->extraRowColumns);
                if(count($columnsInExtra) > 0) {
                    $this->renderExtraRow($row, $change, $columnsInExtra);
                }
            }

            // original CGridView code
            if($this->rowCssClassExpression!==null) 
            {
                $data=$this->dataProvider->data[$row];
                echo '<tr class="'.$this->evaluateExpression($this->rowCssClassExpression,array('row'=>$row,'data'=>$data)).'">';
            }
            else if(is_array($this->rowCssClass) && ($n=count($this->rowCssClass))>0)
                    echo '<tr class="'.$this->rowCssClass[$row%$n].'">';
                else
                    echo '<tr>';


            if(!$this->_changes) { //standart CGridview's render
                foreach($this->columns as $column) {   
                    $column->renderDataCell($row);   
                }            
            } else {  //for grouping       

                foreach($this->columns as $column) {

                    $isGroupColumn = property_exists($column, 'name') && in_array($column->name, $this->mergeColumns);

                    if(!$isGroupColumn) {
                        $column->renderDataCell($row);     
                        continue;
                    }

                    $isChangedColumn = $change && array_key_exists($column->name, $change['columns']);

                    //for rowspan show only changes (with rowspan)
                    switch($this->mergeType) {
                        case self::MERGE_SIMPLE: 
                        case self::MERGE_NESTED: 
                            if($isChangedColumn) {
                                $options = $column->htmlOptions;
                                $column->htmlOptions['rowspan'] = $change['columns'][$column->name]['count'];
                                $column->htmlOptions['class'] = 'merge';
                                $style = isset($column->htmlOptions['style']) ? $column->htmlOptions['style'] : '';
                                $column->htmlOptions['style'] = $style.';'.$this->mergeCellCss;
                                $column->renderDataCell($row);
                                $column->htmlOptions = $options;
                            }
                            break;

                        case self::MERGE_FIRSTROW:
                            if($isChangedColumn) {
                                $column->renderDataCell($row);
                            } else {
                                echo '<td></td>'; 
                            }
                            break;
                    }

                }
            }

            echo "</tr>\n";
        }    

        /**
        * returns array of rendered column values (TD)
        * 
        * @param mixed $columns
        * @param mixed $rowIndex
        */
        private function getRowValues($columns, $data, $rowIndex)
        {
            foreach($columns as $column) {
                if($column instanceOf CGridColumn) {
                    $result[$column->name] = $this->getDataCellContent($column, $data, $rowIndex);
                } elseif(is_string($column)) {
                    if(is_array($data) && array_key_exists($column, $data)) {
                        $result[$column] = $data[$column];
                    } elseif($data instanceOf CModel && $data->hasAttribute($column)) {
                        $result[$column] = $data->getAttribute($column);
                    } else {
                        throw new CException('Column or attribute "'.$column.'" not found!');
                    }
                }
            }

            return $result;
        }

        /**
        * renders extra row
        * 
        * @param mixed $beforeRow
        * @param mixed $change
        */
        private function renderExtraRow($beforeRow, $change, $columnsInExtra)
        {
            $data = $this->dataProvider->data[$beforeRow]; 
            if($this->extraRowExpression) { //user defined expression, use it!
                $content = $this->evaluateExpression($this->extraRowExpression, array('data'=>$data, 'row'=>$beforeRow, 'values' => $change['columns']));
            } else {  //generte value
                $values = array();
                foreach($columnsInExtra as $c) {
                    $values[] = $change['columns'][$c]['value'];
                }
                $content = '<strong>'.implode(' :: ', $values).'</strong>';  
            }

            $colspan = count($this->columns);

            echo '<tr>';
            echo '<td class="extrarow" colspan="'.$colspan.'">'.$content.'</td>';
            echo '</tr>';
        }

        /**
        * need to rewrite this function as it is protected in CDataColumn: it is strange as all methods inside are public 
        * 
        * @param mixed $column
        * @param mixed $row
        * @param mixed $data
        */
        private function getDataCellContent($column, $data, $row)
        {
            if($column->value!==null)
                $value=$column->evaluateExpression($column->value, array('data'=>$data,'row'=>$row));
            else if($column->name!==null)
                    $value=CHtml::value($data,$column->name);

                return $value===null ? $column->grid->nullDisplay : $column->grid->getFormatter()->format($value, $column->type);
        }
}