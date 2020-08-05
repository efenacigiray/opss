<?php
class rev_db_class{
    public static $wpdb;
    public $sdsdb;
    public $mysqli;
    public $prefix;
    public function __construct() {
        $this->prefix = DB_PREFIX;
        $this->sdsdb = new DB(DB_DRIVER,DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
        $registry = new Registry();
        $registry->set('db', $this->sdsdb);
    }
    public function _real_escape( $string ) {
            return $this->sdsdb->escape($string);
    }
    public function _escape( $data ) {
        if ( is_array( $data ) ) {

                foreach ( $data as $k => $v ) {

                        if (is_array($v))

                                $data[$k] = $this->sdsdb->escape($v);

                        else

                                $data[$k] = $this->_real_escape( $v );

                }

        } else {

                $data = $this->_real_escape( $data );

        }



        return $data;

    }

    

    public function query($sql){
    
        $query = $this->sdsdb->query($sql);
        if($query)
           return true;

        return FALSE;

    }

    public function update($table, $data, $where = '', $limit = 0, $null_values = false, $use_cache = true, $add_prefix = false){

        $wherestr = '';
        $c = 0;      

        $sql = "UPDATE {$table} SET ";
        
        if(!empty($data))
            foreach ($data as $k=>$d){
                if($c > 0)
                $sql .= ', ';
                
                if(is_string($d))
                    $sql .= "$k=\"".addslashes($d)."\"";
                else {
                    $sql .= "$k=$d";
                }
                
                $c++;
            }
        
        $sql .= " ";
            
        $c = 0;    
            
        if(!empty($where) && is_array($where)){
            $sql .= "WHERE ";
            
            foreach($where as $k => $val){
                if($c > 0)
                    $wherestr .= " AND ";
                
                $wherestr .= "{$k}=";                
                if(is_string($val))
                    $wherestr .= '"'.$this->_escape($val).'"';                    
                else
                    $wherestr .= $val;
                
                $c++;
            }
            $sql .= $wherestr;
            
        }
        
        if($this->sdsdb->query($sql))
            return true;
        
        return false;

    }
    

    public function insert($table, $data, $null_values = false, $use_cache = true, $type = 1, $add_prefix = false){

        $c = 0;      

        $cols = '';
        $vals = '';
        
        $sql = "INSERT INTO {$table}";
        
        if(!empty($data)){            
            $cols .= '(';
            $vals .= ' VALUES(';
            foreach ($data as $k=>$d){
                if($c > 0){
                    $cols .= ', ';
                    $vals .= ', ';
                }
                $cols .= $k;
                
                if(is_string($d))
                    //$vals .= "\"".addslashes($d)."\"";
                    $vals .= "'".addslashes($d)."'";
                else {
                    $vals .= $d;
                }
                
                $c++;
            }
            $cols .= ')';
            $vals .= ')';
        }
        
        $sql .= "{$cols} {$vals}";
        
        if($this->sdsdb->query($sql))
            return $this->Insert_ID();
        
        return false;

    }
    
    public function Insert_ID(){
        return $this->sdsdb->getLastId();
    }
    

    public function get_var($sql, $assoc = OBJECT){
        $sql .= ' LIMIT 1';
        $query = $this->sdsdb->query($sql);

        if(!empty($query->row)) return array_shift($query->row);

        return false;

    }

    public function get_row($sql, $assoc = OBJECT){
        $sql .= ' LIMIT 1';
        $query = $this->sdsdb->query($sql);
        if($query->row)
            return $query->row;
        return false;
    }

    public function get_results($sql, $assoc = OBJECT){        
        $query = $this->sdsdb->query($sql);        
        if(!empty($query->rows)) 
            return $query->rows;
        return false;
    }


    public static function rev_db_instance(){
        if(self::$wpdb === null)
            return new rev_db_class();
        return self::$wpdb;
    }

    

}



