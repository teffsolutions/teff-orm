<?php 
namespace TeffOrm;

class QueryBuilder{

  protected $query;

  protected $base_table;

  protected $where;
  protected $left_join;

  public function __construct($base_table){
    $this->base_table=$base_table;

    return $this;
  }
  public function leftJoin( $target_table, $foreign_key, $local_key){
    $base_table=$this->base_table;

    $this->query.=" LEFT JOIN $target_table ON ".$this->base_table.".$local_key = $target_table.$foreign_key ";

    return $this;
  }

  public function join(){

  }

  public function query(){

  }
  
  public function where($condition){
    $this->where.=' '.$condition.' ';
    return $this;
  }

  public function get($select=['*']){
    global $db;
    // echo $this->query;

    $query="SELECT ".implode(',', $select)." FROM ".$this->base_table;

    $query.=$this->query;

    if (!empty($this->where)) $query.=$this->where;

    echo $query;
    // $query.='where '.$this->where;
    // $rs = sql_prep($query, $db, array());


  }

  public function hasMany($target_class, $foreign_key, $key_value){
    global $db;

    $target_table = (new $target_class)->getTable();

    $query="SELECT * FROM ".$target_table;
    $query.=" WHERE $foreign_key=$key_value";

    // echo $query;
    $_arr = array();
    $rs = sql_prep($query, $db, array($_id));
    while ($__row=sql_fetch_assoc($rs)) {
      $__obj = new $target_class();
      
      $__obj->setAttributes($__row);
      $_arr[]=$__obj;
    } // while
    return $_arr;
  }

  public function belongsToMany($local_primary_value, $target_class,$pivot_table, $pivot_local, $pivot_foreign){
    global $db;
    $target_table = (new $target_class)->getTable();

    $query="SELECT $target_table.* FROM $target_table";
    $query.=" JOIN $pivot_table ON $target_table.$pivot_foreign = $pivot_table.$pivot_foreign";
    $query.=" WHERE $pivot_table.$pivot_local=$local_primary_value";

    $_arr=array();

    $rs = sql_prep($query, $db, array());

    while ($__row=sql_fetch_assoc($rs)) {
      $__obj = new $target_class();
    
      $__obj->setAttributes($__row);
      $_arr[]=$__obj;
    } // while
    return $_arr;
  }

  public function belongsTo($target_class, $foreign_key, $key_value){

    global $db;

    $target_table = (new $target_class)->getTable();
    
    $query="SELECT * FROM ".$target_table;
    $query.=" WHERE $foreign_key=$key_value";

    $_arr = array();
    $rs = sql_prep($query, $db, array($_id));
    while ($__row=sql_fetch_assoc($rs)) {
      $__obj = new $target_class();
      
      $__obj->setAttributes($__row);
      $_arr[]=$__obj;
    } // while
    return $_arr;

  }

  public function hasOne(){

  }

  public function with(){

  }

}