<?php

class ProductsModel extends BaseModel
{
    public function getProducts($where = '', $lang = DEFAULT_LANG)
    {
        $where .= ' (1=1) ';
        $description = $this->getLanguagesCase('description');
        $title = $this->getLanguagesCase('title');

        $query = 'select * from (SELECT DISTINCT IF(ISNULL(description_'.$lang.'),
                            CASE idx
                                '.$description['list'].'
                            END
                            , description_'.$lang.') AS description,
                            IF(ISNULL(title_'.$lang.'),
                            CASE idx
                                '.$title['list'].'
                            END
                            , title_'.$lang.') AS title,
                            g.image_thumb as image_thumb,
                            p.id, g.type,
                            IF(ISNULL(description_'.$lang.'), 1,0) AS empty_description,
                            IF(ISNULL(title_'.$lang.'), 1,0) AS empty_title
                            FROM products AS p
                            JOIN (
                            SELECT 1 AS idx
                            '.$title['listSelect'].') t
                            left join `gallery` as `g` on g.product_id = p.id
                            WHERE '. $where .'
                            HAVING description IS NOT NULL AND title IS NOT NULL AND type = 1 ) AS ts GROUP BY `ts`.`id` order by `ts`.`id` asc;';
        $result = $this->select($query);
        return $result;
    }

    public function getRealizationProduct($product_id)
    {
        $query = 'select id, image, image_thumb, type from `gallery` where `realization` = ' . $product_id;
        $result = $this->select($query);
        if (!empty($result)) return $result;
        return NULL;
    }

}