<?php
//字典类，继承数组
class Dictionary implements ArrayAccess
{
    public $fields=array(); // 表字段
    public function __set($field,$value=null)
    {
        $this->$field=$value;
        array_push($this->fields,$field);
    }
    public function __get($field)
    {
        return isset($this->$field)?$this->$field:null;
    }
    // 判断字段是否存在
    public function __isset($field)
    {
        return isset($this->$field);
    }
    public function __call($name,$param)
    {
        if(isset($this->$name))
        {
            return $this->$name($param);
        }
    }
    // 删除字段
    public function __unset($field)
    {
        if(isset($this->$field))
        {
            unset($this->fields[array_search($field,$this->fields)]);
            unset($this->$field);
        }
    }
    // 以数组的方式判断是否存在属性
    public function offsetExists($field)
    {
        return isset($this->$field);
    }
    //
    public function offsetGet($field)
    {
        return $this->$field;
    }
    public function offsetSet($field,$value)
    {
        $this->$field=$value;
    }
    public function offsetUnset($field)
    {
        $this->remove(array($field));
    }
    // 拷贝词典中指定的$field与值，默认拷贝所有的字段及值
    public function copydict($dict,$fields='*')
    {
        if($fields=='*')
        {
            foreach($dict->fields as $value)
            {
                $this->keyvalue($value,$dict->$value);
            }
        }else
        {
            $fields=explode(',',$fields);
            foreach($fields as $field)
            {
                $this->$field=$dict[$field];
            }
        }
        return $this;
    }
    //增加时间戳
    public function timestamp($field='shijian')
    {
        $this->keyvalue($field,time());
        return $this;
    }
    //向字典中增加KEY/VALUE对
    public function keyvalue($key,$value=NULL)
    {
        if(is_array($key))
        {
            foreach($key as $k=> $v)
            {
                $this->$k=$v;
            }
        }
        else
        {
            $this->$key=$value;
        }
        return $this;
    }
    public function clear($fields='*')
    {
        if($fields=='*')
        {
            foreach($this->fields as $value)
            {
                unset($this->$value);
                unset($this->fields[array_search($value,$this->fields)]);
            }
        }else
        {
            $fields=explode(',',$fields);
            foreach($fields as $key=> $value)
            {
                unset($this->$value);
                unset($this->fields[array_search($value,$this->fields)]);
            }
        }
        return $this;
    }
    // 移除指定的Key及值,默认移除所有的字段
    public function remove($fields=array())
    {
        if(empty($fields))
        {
            foreach($this->fields as $value)
            {
                unset($this->fields[array_search($value,$this->fields)]);
            }
        }else
        {
            foreach($fields as $value)
            {
                $tmp=array_search($value,$this->fields);
                if($tmp!==FALSE)
                {
                    unset($this->fields[$tmp]);
                }
            }
        }
        return $this;
    }
    public function toJson()
    {
        $tmp=array();
        foreach($this->fields as $value)
        {
            array_push($tmp,'"'.$value.'":"'.$this->$value.'"');
        }
        return "{".implode(',',$tmp)."}";
    }
    //显示字典中的所有KEY/VALUE
    public function display()
    {
        foreach($this->fields as $key=> $value)
        {
            echo $value.'='.$this[$value].'<br />';
        }
    }
    public function join($str='&')
    {
        $arr=array();
        foreach($this->fields as $key)
        {
            array_push($arr,$key.'='.$this->$key);
        }
        return implode($str,$arr);
    }
    public function sort()
    {
        sort($this->fields);
        return $this;
    }
    public function md5sign($secretkey='',$split='&')
    {
        $arr=array();
        foreach($this->fields as $key)
        {
            array_push($arr,$key.'='.$this->$key);
        }
        return md5(implode($split,$arr).$secretkey);
    }
}
?>
