<?php
class HomeModel extends BaseModel{
    public function getSlide() {
        $query = 'Select p.title, p.description, p.id , g.image from `products` as `p` left join `gallery` as `g` on `g`.`product_id` = `p`.`id` order by `id` asc LIMIT 5';
        $result = $this->select($query);
        return $result;
    }

}