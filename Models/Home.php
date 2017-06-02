<?php
class HomeModel extends BaseModel{
    public function getSlide($lang = DEFAULT_LANG) {
        $query = 'Select p.title_'.$lang.', p.description_'.$lang.', p.id , g.image from `products` as `p` left join `gallery` as `g` on `g`.`product_id` = `p`.`id` order by `id` asc LIMIT 5';
        $result = $this->select($query);
        return $result;
    }

}