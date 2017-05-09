<?php
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model
{
	protected $insertFields = array('cat_name','parent_id');
	protected $updateFields = array('id','cat_name','parent_id');
	protected $_validate = array(
		array('cat_name', 'require', '分类名称不能为空！', 1, 'regex', 3),
	);
	
	// 找一个分类所有子分类的ID
    public function getChildren($catId)
    {
        $data = $this->select();  // 取出所有的分类数据
        return $this->_getChildren($data,$catId,true);  // 递归从所有的分类中挑出子分类
    }

    /**递归从数据中找子分类
     * @param $data
     * @param $catId
     */
    private function _getChildren($data,$catId,$isClear = false){
        static $_ret =array(); //  定义变量存储子分类
        if($isClear)
            $_ret=array();
        // 循环所有的分类找子分类
        foreach($data as $k => $v){
            if ($v['parent_id' == $catId]){
                $_ret[] = $v['id'];
                // 继续查找$v的子分类
                $this->_getChildren($data,$v['id']);
            }
        }
        return $_ret;
    }

//    获取树形目录
    public function getTree()
    {
        $data = $this->select();
        return $this->_getTree($data);
    }

    private function _getTree($data,$parent_id=0,$level=0){
        static $_ret = array();
        foreach($data as $k=>$v){
            if ($v['parent_id']==$parent_id){
                $v['level']= $level;
                $_ret[]=$v;
                // 找子分类
                $this->_getTree($data,$v['id'],$level+1);
            }
        }
        return $_ret;
    }

    protected function _before_delete($options){
        // 找出所有的子分类
        $children=$this->getChildren($options['where']['id']);
        if ($children){
            $children = implode(',',$children); // 转换为字符串
            $model = \Think\Model();
            //  调用父级模型避免死循环，如果使用$this调用delete方法又会重新调用这个_before_delete()方法导致死循环
            $model->table('__CATEGORY__')->delete($children);
        }
        /****把所有子分类加入到$options，通过tp一次性全部删除***/
        // 如果需要使用以下方法，前面$options必须使用引用传递，加&
//        $children[] = $options['where']['id'];
//        $options['where']['id']=array(
//            0=>'IN',
//            1=>implode(',',$children),
//        );
    }
    /**
     * 获取导航条上的数据
     */
    public function getNavData()
    {
        $cateData = S('cateData');
        if(!$cateData){
            // 取出所有的分类数据
            $navAll = $this->select();
            $ret = array();

            // 循环所有的分类找出顶级分类
            foreach ($navAll as $k => $v){
                if ($v['parent_id']==0){  // 顶级分类
                    // 循环所有的分类找出这个顶级分类的子分类
                    foreach ($navAll as $k1 => $v1){
                        if ($v1['parent_id']==$v['id']){
                            // 循环所有的分类找出这个二级分类的子分类
                            foreach ($navAll as $k2 => $v2){
                                if ($v2['parent_id']==$v1['id']) {
                                    $v1['children'][] = $v2;
                                }
                            }
                            // 增加一个children 字段存储子分类
                            $v['children'][] = $v1;
                        }
                    }
                    $ret[]=$v;
                }
            }
            S('cateData',$ret,86400);  //  生成缓存数据
            return $ret;
        }else{
            return $cateData;
        }

    }
}