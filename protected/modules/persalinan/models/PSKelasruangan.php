<?php

/**
 * This is the model class for table "tabularlist_m".
 *
 * The followings are the available columns in table 'tabularlist_m':
 * @property integer $tabularlist_id
 * @property string $tabularlist_chapter
 * @property string $tabularlist_block
 * @property string $tabularlist_title
 * @property string $tabularlist_revisi
 * @property string $tabularlist_versi
 * @property boolean $tabularlist_aktif
 */
class PSKelasruangan extends KelasruanganM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TabularlistM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}