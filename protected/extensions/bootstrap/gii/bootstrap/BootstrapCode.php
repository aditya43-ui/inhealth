<?php
/**
 * BootCrudCode class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('gii.generators.crud.CrudCode');
class BootstrapCode extendS CrudCode
{
	public function generateActiveRow($modelClass, $column)
	{
		if ($column->type === 'boolean')
			return "\$form->checkBoxRow(\$model,'{$column->name}')";
		else if (stripos($column->dbType,'text') !== false)
			return "\$form->textAreaRow(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50, 'class'=>'span8'))";
		else
		{
			if (preg_match('/^(password|pass|passwd|passcode)$/i',$column->name))
				$inputField='passwordFieldRow';
			else
				$inputField='textFieldRow';

			if ($column->type!=='string' || $column->size===null)
				if($column->type === 'integer')
					return "\$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span3 numbers-only'))";
				else
					return "\$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span3'))";
			else
				return "\$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span3','maxlength'=>$column->size))";
		}
	}
        /**
         * bssGenerateActiveRowV10 versi 1.0
         * @param type $modelClass
         * @param type $column
         * @return type
         */
	public function bssGenerateActiveRowV10($modelClass, $column)
	{
		if ($column->type === 'boolean')
			return "\$form->checkBoxRow(\$model,'{$column->name}', array('onkeypress'=>\"return $(this).focusNextInputField(event);\"))";
		else if (stripos($column->dbType,'text') !== false)
			return "\$form->textAreaRow(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>\"return $(this).focusNextInputField(event);\"))";
		else
		{
			if (preg_match('/^(password|pass|passwd|passcode)$/i',$column->name))
				$inputField='passwordFieldRow';
			else
				$inputField='textFieldRow';

			if ($column->type!=='string' || $column->size===null)
				return "\$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span3', 'onkeypress'=>\"return $(this).focusNextInputField(event);\"))";
			else
				return "\$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span3', 'onkeypress'=>\"return $(this).focusNextInputField(event);\", 'maxlength'=>$column->size))";
		}
	}
        /**
         * bssGenerateActiveRowV11 versi 1.1
         * @param type $modelClass
         * @param type $column
         * @return type
         */
	public function bssGenerateActiveRowV11($modelClass, $column)
	{
		if ($column->type === 'boolean')
			return "\$form->checkBoxRow(\$model,'{$column->name}', array('onkeyup'=>\"return $(this).focusNextInputField(event);\"))";
		else if (stripos($column->dbType,'text') !== false)
			return "\$form->textAreaRow(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>\"return $(this).focusNextInputField(event);\"))";
		else
		{
			if (preg_match('/^(password|pass|passwd|passcode)$/i',$column->name))
				$inputField='passwordFieldRow';
			else
				$inputField='textFieldRow';

			if ($column->type!=='string' || $column->size===null){
				if($column->type === 'integer')
					return "\$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span3 integer', 'onkeyup'=>\"return $(this).focusNextInputField(event);\"))";
				else
					return "\$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span3', 'onkeyup'=>\"return $(this).focusNextInputField(event);\"))";
			}else{
				return "\$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span3', 'onkeyup'=>\"return $(this).focusNextInputField(event);\", 'maxlength'=>$column->size))";
			}
		}
	}
}
