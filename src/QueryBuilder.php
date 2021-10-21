<?php 
namespace SwimmingPool;

class QueryBuilder{

  protected $query;

  protected $base_table;

  protected $where;

  public function __construct($base_table){
    $this->base_table=$base_table;

    return $this;
  }
  public function leftJoin( $target_table, $foreign_key, $local_key){
    $base_table=$this->base_table;

    $this->query.=" LEFT JOIN $target_table ON ".$this->base_table.".$local_key = $target_table.$foreign_key ";

    return $this;
  }
  public function hasMany($target_table, $foreign_key, $key_value){
    global $db;
    $query="SELECT ".implode(',', $select)." FROM ".$this->target_table;
    $query.=" WHERE $foreign_key=$key_value";


    echo $query;
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

}