<?php

class HomeModel extends BaseModel
{
    public function getSlide($lang = DEFAULT_LANG)
    {
        $description = $this->getLanguagesCase('description');
        $title = $this->getLanguagesCase('title');
        $query = 'SELECT * FROM (SELECT DISTINCT IF(ISNULL(description_' . $lang . '),
                            CASE idx
                                ' . $description['list'] . '
                            END
                            , description_' . $lang . ') AS description,

                            IF(ISNULL(title_' . $lang . '),
                            CASE idx
                                ' . $title['list'] . '
                            END
                            , title_' . $lang . ') AS title,
                            IF(ISNULL(title_' . $lang . '), 1,0) AS empty_title,
                            IF(ISNULL(description_' . $lang . '), 1,0) AS empty_description,
                            g.image,
                            c.id
                            FROM products AS c
                            JOIN (
                            SELECT 1 AS idx
                            ' . $title['listSelect'] . ') t
                            left join `gallery` as `g` on g.product_id = c.id
                            HAVING description IS NOT NULL AND title IS NOT NULL) AS ts GROUP BY `ts`.`id` order by `ts`.`id` asc LIMIT 5;';
        $result = $this->select($query);
        return $result;
    }

}