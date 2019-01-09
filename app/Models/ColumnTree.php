<?php
/**
 * Created by PhpStorm.
 * User: purelightme
 * Date: 2018/11/28
 * Time: 13:40
 */

namespace App\Models;


use Illuminate\Support\Facades\DB;

trait ColumnTree
{
    public function buildTree(...$columns)
    {
        return $this->customBuildNestedArray($columns);
    }


    protected function customBuildNestedArray($columns, array $nodes = [], $parentId = 0)
    {
        $branch = [];

        if (empty($nodes)) {
            $nodes = $this->customAllNodes($columns);
        }

        foreach ($nodes as $node) {
            if ($node['parent_id'] == $parentId) {
                $children = $this->customBuildNestedArray($columns, $nodes, $node[$this->getKeyName()]);

                if ($children) {
                    $node['children'] = $children;
                }

                $branch[] = $node;
            }
        }

        return $branch;
    }

    public function customAllNodes($columns)
    {
        $orderColumn = DB::getQueryGrammar()->wrap($this->orderColumn);
        $byOrder = $orderColumn . ' = 0,' . $orderColumn;

        $self = new static();

        if ($this->queryCallback instanceof \Closure) {
            $self = call_user_func($this->queryCallback, $self);
        }

        return $self->orderByRaw($byOrder)->select($columns)->get()->toArray();
    }

    /**
     * 获取层级分类数组
     * @param $thirdId
     * @return array
     */
    public static function getStageIdsById($id)
    {
        if (empty($GLOBALS['res'])){
            $GLOBALS['res'] = [];
            array_unshift($GLOBALS['res'],$id);
        }
        $record = self::findOrFail($id);
        if (!$record->parent)
            return $GLOBALS['res'];
        array_unshift($GLOBALS['res'],$record->parent->id);
        return self::getStageIdsById($record->parent->id);
    }

    /**
     * 获取层级分类数组
     * @param $thirdId
     * @return array
     */
    public static function getStageIdsByName($name)
    {
        $record = self::whereName($name)->first();
        if (empty($GLOBALS['city'])){
            $GLOBALS['city'] = [];
            array_unshift($GLOBALS['city'],$record->id);
        }
        if (!$record->parent)
            return $GLOBALS['city'];
        array_unshift($GLOBALS['city'],$record->parent->id);
        return self::getStageIdsByName($record->parent->name);
    }

}