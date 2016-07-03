<?php
//MySql数据操作类
include_once ($_SERVER["DOCUMENT_ROOT"].'/library/httprequesthelper.php');
class MsSqlHelper extends HttpRequestHelper
{
    private $host=db_host;
    private $db_username=db_username;
    private $db_password=db_password;
    private $database=db_database;
    private $iswhere=false; // 是否已存在条件语句
    private $bindvalues=array(); //绑定值
    public $tablename; // 表名
    public $sql=''; // Sql语句
    public $autoid=0; // 自动编号
    public $result=null; // 查询结果
    public function __construct($tablename=NULL)
    {
        $this->tablename=db_prefix.$tablename;
    }
    public function request()
    {
        parent::request();
        if(isset($this['curpage']))
        {
            $this->curpage=$this['curpage'];
        }
        if($this->curpage<=1)
        {
            $this->curpage=1;
        }
        if(isset($this['pagesize']))
        {
            $this->pagesize=$this['pagesize'];
        }
        return $this;
    }
    public function keymyid($myid=NULL)
    {
        $this->keyvalue("myid",empty($myid)?$this->getCookie("myid"):$myid);
    }
    private $column=array();
    public function columnvalue($field,$value)
    {
        $this->column[$field]=true;
        $this->keyvalue($field,$value);
        return $this;
    }
// 增加数据
    public function append()
    {
        $this->bindvalues=array();
        $values=array();
        $keys=array();
        foreach($this->fields as $value)
        {
            if($this->$value=='')
            {
                continue;
            }
            if(isset($this->column[$value]))
            {
                array_push($values,$this->$value);
            }else
            {
                array_push($values,'?');
                array_push($this->bindvalues,$this->$value);
            }
            array_push($keys,$value);
        }
        $keys=implode(',',$keys);
        $values=implode(',',$values);
        $this->sql="insert into $this->tablename($keys) values($values)";
        return $this;
    }
// 修改数据
    public function update()
    {
        $this->iswhere=false;
        $this->bindvalues=array();
        $kv=array();
        foreach($this->fields as $value)
        {
            if($value)
            {
                if($this->$value==''||isset($this->column[$value]))
                {
                    array_push($kv,$this->$value==''?"$value=NULL":"$value=".$this->$value);
                }else
                {
                    array_push($kv,"$value=?");
                    array_push($this->bindvalues,$this->$value);
                }
            }
        }
        $kv=implode(',',$kv);
        $this->sql="update $this->tablename set $kv";
        return $this;
    }
// 删除数据
    public function delete()
    {
        $this->bindvalues=array();
        $this->iswhere=false;
        $this->sql="delete from $this->tablename ";
        return $this;
    }
// 提交sql语句
    public function submit($sql=null)
    {
        if(!$sql)
        {
            $sql=$this->sql;
        }
        $len=count($this->bindvalues);
        if($len)
        {
            $bindvalues=array_merge(array(str_pad('s',count($this->bindvalues),'s')),$this->bindvalues);
            foreach($bindvalues as $k=> $v)
            {
                $array[]=&$bindvalues[$k];
            }
        }

        $conn=sqlsrv_connect($this->host,array("UID"=>$this->db_username,"PWD"=>$this->db_password,"Database"=>$this->database));
        try
        {
            $stmt=sqlsrv_query($conn,$sql,$this->bindvalues);
            if($stmt==FALSE)
            {
                throw new Exception(sqlsrv_error(sqlsrv_errors(),true));
            }
            $this->autoid=sqlsrv_insert_id($conn);
        }catch(Exception $ex)
        {
            echo '错误信息：'.$ex->getMessage().'<br />SQL语句：'.$sql.'<br />'.$this->toJson();
        }
        sqlsrv_close($conn);
    }
//数据查询
    public function query($sql=null)
    {
        if($sql==null)
        {
            $sql=$this->sql;
        }
        $len=count($this->bindvalues);
        if($len)
        {
            $bindvalues=array_merge(array(str_pad('s',$len,'s')),$this->bindvalues);
            foreach($bindvalues as $k=> $v)
            {
                $array[]=&$bindvalues[$k];
            }
        }
        try
        {
            $conn=sqlsrv_connect($this->host,array("UID"=>$this->db_username,"PWD"=>$this->db_password,"Database"=>$this->database));
            $stmt=sqlsrv_prepare($conn,$sql);
            if(sqlsrv_errno($conn))
            {
                throw new Exception(sqlsrv_error($conn));
            }
            if($len)
            {
                call_user_func_array(array($stmt,'bind_param'),$array);
            }
            $stmt->execute();
            if(sqlsrv_errno($conn))
            {
                throw new Exception(sqlsrv_error($conn));
            }
            $this->result=$stmt->get_result();
            $this->totalresult=sqlsrv_num_rows($this->result);
            $this->for_in_idx=$this->totalresult&&$this->for_in_reverse?$this->totalresult-1:0;
            $stmt->free_result();
        }catch(Exception $ex)
        {
            echo '错误信息：'.$ex->getMessage().'<br />SQL语句：'.$sql.'<br />'.$this->toJson();
        }
        sqlsrv_close($conn);
        return $this;
    }
    public function select($fields='*')
    {
        $this->bindvalues=array();
        if(is_array($fields))
        {
            $fields=implode(',',$fields);
        }
        $this->iswhere=false;
        $this->sql="select $fields from $this->tablename";
        return $this;
    }
    public function isexist($sql=NULL)
    {
        return $this->query($sql)->totalresult>0;
    }
    // 查询条件
    public function where($where,$params=array(),$guanxi=' and ')
    {
        $this->bindvalues=array_merge($this->bindvalues,$params);
        $this->sql.=(preg_match('/ from '.$this->tablename.' where/',$this->sql)==1?$guanxi:' where ').$where;
        return $this;
    }
    public function orderby($orderby)
    {
        $this->sql.=' order by '.$orderby;
        return $this;
    }
    public function groupby($groupdy)
    {
        $this->sql.=' group by '.$groupdy;
        return $this;
    }
// 反序获取表数据
    private $for_in_reverse=FALSE;
// 行索引
    public $for_in_idx=0;
//获取每一行的数据，
    public function for_in_rows($idx=0)
    {
        if($idx)
        {
            $this->for_in_idx=$idx;
        }
        if($this->for_in_idx>=$this->totalresult||$this->for_in_idx<0)
        {
            $this->for_in_idx=0;
            return false;
        }
        sqlsrv_data_seek($this->result,$this->for_in_idx);
        $arr=sqlsrv_fetch_assoc($this->result);
        foreach($arr as $key=> $value)
        {
            $this->$key=$value;
        }
        $this->for_in_reverse?$this->for_in_idx--:$this->for_in_idx++;
        return $arr;
    }
// 分页相关
    public $pagesize=10;
    public $curpage=1;
    public $totalresult=0; // 每一页的记录数
    public $totalrows=0; // 总行数
    public $totalpage=0; // 总页数
    public function get_total_rows()
    {
        $this->query(preg_replace('/select .+?from/','select count(*) as totalrows from',$this->sql,1));
        $this->for_in_rows();
        $this->totalrows=$this["totalrows"];
        $this->totalpage=ceil($this->totalrows/$this->pagesize);
        return $this;
    }
    public function get_page_desc($sortkey)
    {
        return $this->get_page_custom($sortkey.' desc ');
    }
    public function get_page_asc($sortkey)
    {
        return $this->get_page_custom($sortkey.' asc ');
    }
    public function get_page_custom($orderby)
    {
        $this->get_total_rows();
        $start=($this->curpage-1)*$this->pagesize;
        if($start<0)
        {
            $start=0;
        }
        $this->sql.=' order by '.$orderby.' limit '.$start.",".$this->pagesize;
        $this->query();
        return $this;
    }
    public function get_first_rows($sql=NULL)
    {
        $arr=$this->query($sql)->for_in_rows();
        $this->for_in_idx=0;
        return $arr;
    }
    public function toArray($key=0)
    {
        $items=array();
        if($this->result)
        {
            sqlsrv_data_seek($this->result,0);
            while($row=sqlsrv_fetch_row($this->result))
            {
                array_push($items,'"'.$row[$key].'"'.':'.str_replace(':null',':""',array_splice($row,$key,1)?json_encode($row,JSON_UNESCAPED_UNICODE):"[]"));
            }
        }
        return '{'.implode(',',$items).'}';
    }
    public function toKeyValue()
    {
        $items=array();
        if($this->result)
        {
            sqlsrv_data_seek($this->result,0);
            while($row=sqlsrv_fetch_assoc($this->result))
            {
                array_push($items,str_replace(':null',':""',json_encode($row,JSON_UNESCAPED_UNICODE)));
            }
        }
        return '['.implode(',',$items).']';
    }
    public function getTables()
    {
        $this->bindvalues=array();
        return $this->query('show table status');
    }
    public function getSchema()
    {
        $this->bindvalues=array();
        return $this->query('show full fields from '.$this->tablename);
    }
}
class Pagination
{
    private $html="";
    public $list;
    public $querystring;
    public $temphtml;
    public $loop_step=5;
    public function __construct($list)
    {
        $this->list=$list;
        $this->temphtml='<a href="?curpage={curpage}&'.$this->querystring.'" {curpageclass}>{curpage}</a>';
    }
    public function pageinfo()
    {
        $this->html .= '共'.$this->list->totalrows.'条 每页'.$this->list->pagesize.'条 第'.$this->list->curpage.'/'.$this->list->totalpage.'页';
        return $this;
    }
    public function firstpage()
    {
        if($this->list->curpage>1)
        {
            $this->html .= '<a href="?curpage=1'.$this->querystring.'">首页</a><a href="?curpage='.($this->list->curpage-1).$this->querystring.'">上一页</a>';
        }
        return $this;
    }
    public function loop_page($curpageclass='selected')
    {
        $s=$this->list->curpage/$this->loop_step;
        if($this->list->curpage%$this->loop_step==0)
        {
            $s -= 1;
        }
        if($s<=0)
        {
            $s=0;
        }
        $s=$s*$this->loop_step+1;
        $e=$s+4;
        if($e>$this->list->totalpage)
        {
            $e=$this->list->totalpage;
        }
        for($i=$s; $i<=$e; $i++)
        {
            $this->html.=str_replace('{curpageclass}',$this->list->curpage==$i?"class='"+$curpageclass+"'":"",str_replace('{querystring}',$this->querystring,str_replace('{curpage}',$i,$this->temphtml)));
        }
        return $this;
    }
    public function lastpage()
    {
        if($this->list->curpage<$this->list->totalpage)
        {
            $this->html.= '<a href="?curpage='.($this->list->curpage+1).$this->querystring.'">下一页</a><a href="?curpage='.$this->list->totalpage.$this->querystring.'">末页</a>';
        }
        return $this;
    }
    public function display()
    {
        echo '<span class="pagination">'.$this->html.'</span>';
    }
}
?>