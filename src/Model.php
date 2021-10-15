<?php 
namespace SwimmingPool;

Class Model {

  protected $data;

  protected $table;
  protected $primaryKey;

  protected $db;

  public function __construct(){
    global $db;
    $this->db=$db;
  }

  protected function hasMany($foreign_table, $foreign_key, $local_key){
    $__called_class=get_called_class();
    $base_table = (new $__called_class())->getTable();

    $query = new Query($base_table);

    return $query->hasMany($foreign_table, $foreign_key, $this->data[$primaryKey]);

  }
  protected function belongsTo(){

  }

  public static function find($_id){
    global $db;
    
    $__called_class=get_called_class();

    $table = (new $__called_class())->getTable();
    $primary_key = (new $__called_class())->getPrimaryKeyName();

    $_id=$_id+0;

    $query="SELECT * FROM  $table  WHERE $primary_key=?";

    $rs = sql_prep($query, $db, array($_id));

    $obj = new $__called_class();

    // map data to object
    if ($row=sql_fetch_assoc($rs)) {
      foreach ($row as $key => $value) {
        $obj->{$key} = $value;
      }
    }

    return $obj;
  }

  public static function leftJoin($target_table, $foreign_key, $local_key){
    $__called_class=get_called_class();

    $base_table = (new $__called_class())->getTable();

    $query = new Query($base_table);

    return $query->leftJoin($target_table, $foreign_key, $local_key);
  }


  public static function get($params=null, $asarray=0){
    global $db;

    $__called_class=get_called_class();
    $table = (new $__called_class())->getTable();
    $primary_key = (new $__called_class())->getPrimaryKeyName();

    $query="SELECT * FROM $table WHERE 1=1";

    $_query_value=array();
    if ($params!==null && is_array($params)){
      foreach ($params as $key => $value) {
        $query .= ' AND '.$key.'=?';
        $_query_value[]=$value;
      }
    }
    $rs = sql_prep($query, $db, $_query_value);

    $__arr=array();

    while ($row=sql_fetch_assoc($rs)) {
      // var_dump($row);
      $_obj=new $__called_class();

      foreach ($row as $key => $value) {
        $_obj->{$key} = $value;
      }

      array_push($__arr,$_obj);
    }

    return $__arr;
  }

  /**
   * Get the table associated with the model.
   *
   * @return string
   */
  public function getTable()
  {
      return $this->table;
  }

  /**
   * Set the table associated with the model.
   *
   * @param  string  $table
   * @return $this
   */
  public function setTable($table)
  {
      $this->table = $table;

      return $this;
  }

  /**
   * Get the primary key for the model.
   *
   * @return string
   */
  public function getPrimaryKeyName()
  {
      return $this->primaryKey;
  }

  /**
   * Set the primary key for the model.
   *
   * @param  string  $key
   * @return $this
   */
  public function setPrimaryKeyName($key)
  {
      $this->primaryKey = $key;

      return $this;
  }

  public function __get($varName){

    if (!array_key_exists($varName,$this->data)){
      return NULL;
    }
    else return $this->data[$varName];

  }

  public function __set($varName,$value){
    $this->data[$varName] = $value;
  }

  public function toArray(){
    return $this->data;
  }

  public function __call($method, $parameters){
    // echo $method;
    echo get_class($this);
  }

}

