<?php

class ProductsModel extends BaseModel
{
    public function getProducts($where = '', $language = DEFAULT_LANG)
    {
        $where .= '(1=1)';
        $query = 'Select `p`.id, `p`.`title_' . $language . '` as title, `p`.`description_' . $language . '` as description, g.image_thumb as image_thumb from `products` as `p` left join `gallery` as `g` on g.product_id = p.id where ' . $where . ' GROUP BY `p`.`id` order by `p`.`id` asc';
        $result = $this->select($query);
        return $result;
    }

    public function getRealizationProduct($product_id)
    {
        $query = 'select image from `gallery` where `realization` = ' . $product_id;
        $result = $this->select($query);
        if (!empty($result)) return $result;
        return NULL;
    }

}