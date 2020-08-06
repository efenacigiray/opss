<?php
class ModelMassDiscountMassDiscount extends Model {

public function updateDiscount($user_group = null, $percent, $product_options, $cats_id = 0, $start_date = null, $expire_date = null, $manufacturers_id = 0) {
  
 if($user_group && $percent < 0 && $start_date && $expire_date) {   //bindirim  
   $query = $this->db->query("SELECT P.product_id, P.price FROM " . DB_PREFIX . "product P ".
                 (($cats_id)? " LEFT JOIN " . DB_PREFIX . "product_to_category PC ON P.product_id = PC.product_id ":"").
                 (($manufacturers_id)? " LEFT JOIN " . DB_PREFIX . "manufacturer M ON M.manufacturer_id = P.manufacturer_id ":"").
                 " WHERE ".
                 (($cats_id)? " PC.category_id in(".$cats_id.")":"").
                 (($cats_id && $manufacturers_id)? " AND ":"").                      
                 (($manufacturers_id)?" M.manufacturer_id in(".$manufacturers_id.")":""));
      
		foreach ($query->rows as $result) {
			
			$bindirim = $result['price'] * ($percent / 100);
			$new_price = $result['price'] + $bindirim;

			$this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . $new_price . "' WHERE product_id = '" . (int)$result['product_id'] . "'");
//options
	if($product_options == 1) {
		$query_options = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$result['product_id'] . "'");			
			if ($query_options->num_rows) {
				foreach ($query_options->rows as $result_option) {	
					$bindirim_price = $result_option['price'] * ($percent / 100);
					$new_price_option = $result_option['price'] + $bindirim_price;


		
				$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET `price` = '" . $new_price_option . "',
				`price_prefix` = '+' 
				WHERE `product_option_value_id` = '" . $result_option['product_option_value_id'] . "'");
				}
			}
	}			
//son	
		$query_special = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$result['product_id'] . "'");			
			if ($query_special->num_rows) {
				foreach ($query_special->rows as $result_special) {	
					$bindirim_ozel = $result_special['price'] * ($percent / 100);
					$new_price_ozel = $result_special['price'] + $bindirim_ozel;


		
				$this->db->query("UPDATE " . DB_PREFIX . "product_special SET `customer_group_id` = '" . $user_group . "',
				`priority` = '1',
				`price` = '".$new_price_ozel."',
				`date_start` = '".$start_date."',
				`date_end` = '".$expire_date."' WHERE `product_id` = '" . $result['product_id'] . "'");
				}
			}			
		}
	
    }  
	
if($user_group && $percent > 0 && $start_date && $expire_date) { //indirim

	$query = $this->db->query("SELECT P.product_id, P.price FROM " . DB_PREFIX . "product P ".
		 (($cats_id)? " LEFT JOIN " . DB_PREFIX . "product_to_category PC ON P.product_id = PC.product_id ":"").
		 (($manufacturers_id)? " LEFT JOIN " . DB_PREFIX . "manufacturer M ON M.manufacturer_id = P.manufacturer_id ":"").
		 " WHERE ".
		 (($cats_id)? " PC.category_id in(".$cats_id.")":"").
		 (($cats_id && $manufacturers_id)? " AND ":"").                      
		 (($manufacturers_id)?" M.manufacturer_id in(".$manufacturers_id.")":""));

		foreach ($query->rows as $result) {

			$new_price = $result['price'] * (1 + ($percent/100)); 
		 
			$this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . $new_price . "' WHERE product_id = '" . (int)$result['product_id'] . "'");

//options
	if($product_options == 1) {
		$query_options = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$result['product_id'] . "'");			
			if ($query_options->num_rows) {
				foreach ($query_options->rows as $result_option) {	
				
				$new_price_option = $result_option['price'] * (1 + ($percent/100)); 
		
				$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET `price` = '" . $new_price_option . "',
				`price_prefix` = '+' 
				WHERE `product_option_value_id` = '" . $result_option['product_option_value_id'] . "'");
				}
			}
	}		
//son	
			
			$query_special = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$result['product_id'] . "'");	
			
			if ($query_special->num_rows) {		 
				foreach ($query_special->rows as $result_special) {

					 $new_price_ozel = $result_special['price'] * (1 + ($percent/100)); 
					 		
						$this->db->query("UPDATE " . DB_PREFIX . "product_special SET `customer_group_id` = '" . $user_group . "',
								`priority` = '1',
								`price` = '".$new_price_ozel."',
								`date_start` = '".$start_date."',
								`date_end` = '".$expire_date."' WHERE `product_id` = '" . $result['product_id'] . "'");
				}				
			}			
		}
	}
}
}
?>