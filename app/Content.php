<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;


class Content extends Model 
{

    /**
    * add new category
    */
    static public function addCategory($data)
    {
        return DB::table('categorys')->insert($data);
    }

    /**
    * get parent category
    */
    static public function getParentCategory()
    {
        return DB::table('categorys')->whereNull('parent')->get();
    }

    /**
    * get all category
    */
    static public function getAllCategory()
    {
        $data = DB::table('categorys')
        ->orderBy('id', 'desc')
        ->get();
        $newdata = array();
        foreach($data as $k => $v)
        {
            if($v->parent != NULL)
            {
                $v->parent = self::getCategoryById($v->parent)->name;
                $newdata[] = $v;
            }else
            {
                $newdata[] = $v;
            }
        }
        return $newdata;
    }

    /**
    * get category by id
    */
    static public function getCategoryById($id)
    {
        return DB::table('categorys')->where('id', $id)->first();
    }

    /**
    * delete category by id
    */
    static public function deleteCategoryById($id)
    {
        DB::table('categorys')->where('id', $id)->delete();
        return TRUE;
    }

    /**
    * delete category by parent id
    */
    static public function deleteCategoryByParentId($id)
    {
        DB::table('categorys')->where('parent', $id)->delete();
        return TRUE;
    }

    /**
    * edit category by id
    */

    static public function editCategoryByID($data, $id)
    {
        return DB::table('categorys')->where('id', $id)->update($data);
    }
}
