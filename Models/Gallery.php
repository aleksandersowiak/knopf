<?php

class GalleryModel extends BaseModel
{
    public function getImages($where = '', $lang= DEFAULT_LANG)
    {
        if ($where == '') {
            $where = 'LIMIT 10';
        }
        $data = $this->getLanguagesCase('category');
        $query = 'SELECT DISTINCT IF(ISNULL(category_'.$lang.'),
                    CASE idx
                        '.$data['list'].'
                    END
                    , category_'.$lang.') AS category,
                    g.id ,image, image_thumb, c.id as category_id,
                    IF(ISNULL(category_'.$lang.'), 1,0) AS empty_category,
                    g.product_id, g.realization
                    FROM gallery AS g
                    JOIN (
                    SELECT 1 AS idx
                    '.$data['listSelect'].') t
                    left join category as c on c.id = g.category_id
                    '.$where.'
                    HAVING category IS NOT NULL;
                    ';
        return $this->select($query);
    }

    public function getCategoryId($category_id, $lang)
    {
        $query = "select id as category_id from category where id= '" . $category_id . "'" ;

        $result = $this->select($query);
        return $result[0]['category_id'];
    }
}