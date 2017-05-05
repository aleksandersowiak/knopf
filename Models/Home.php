<?php
class HomeModel extends BaseModel{
	public function Index() {
		return array("Value 1", "Value 2", "Value 3");
	}
    public function getSlide() {
        $query = 'Select * from `products` order by `id` asc LIMIT 5';
        $result = $this->select($query);
        return $result;
    }
}