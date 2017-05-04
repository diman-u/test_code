<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Objectsmod extends Model
{   
	
	protected $_tableObjects = 'objects';
	protected $_tableBuildingSteps = 'bulding_steps';	
	protected $_tableFloors_plans = 'floors_plans';	
	protected $_tablePrices = 'prices';	
	protected $_tableDocs = 'docs';
	protected $_tableIpoteka = 'ipoteka';
	protected $_tablePertners = 'partners';
	protected $_tableSales = 'sales';
	protected $_tableAportmentOnFloor = 'aportment_on_floor';
	
	/*Список всех объектов*/
	public function get_list_objects()
    {
        $tprefix = Kohana::$config->load('database.default.table_prefix');
		$sql = "SELECT * FROM ". $tprefix.$this->_tableObjects;
 
        return DB::query(Database::SELECT, $sql)
                   ->execute();
    }
	
	/*Список текущего строительства*/
	public function get_list_objects_current()
    {
		$tprefix = Kohana::$config->load('database.default.table_prefix');
		$sql = "SELECT * FROM ". $tprefix.$this->_tableObjects.
			   " WHERE stady_id = ".Kohana::$config->load('site.stady_objects.current');
				   
		$sql.=   " ORDER BY date_create DESC";
 
        return DB::query(Database::SELECT, $sql)
                   ->execute();
	}//-----------------------------------------	