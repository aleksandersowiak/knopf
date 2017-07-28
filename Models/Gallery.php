<?php

class GalleryModel extends BaseModel
{
    public function getImages($where = '', $lang= DEFAULT_LANG)
    {
        if ($where == '') {
            $where = 'LIMIT 10';
        }
        $query = "SELECT g.id ,image, image_thumb, c.id as category_id, c.category_$lang as category, g.product_id, g.realization from `gallery` as g left join category as c on c.id = g.category_id " . $where;
        return $this->select($query);
    }

    public function getCategoryId($category_id, $lang)
    {
        $query = "select id as category_id from category where id= '" . $category_id . "'" ;

        $result = $this->select($query);
        return $result[0]['category_id'];
    }
}