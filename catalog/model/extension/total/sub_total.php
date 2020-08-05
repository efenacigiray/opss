<?php
class ModelExtensionTotalSubTotal extends Model {
	public function getTotal($total) {
		$this->load->language('extension/total/sub_total');
        $store_id = isset($total['store_id']) ? $total['store_id'] : 0;
		$sub_total = $this->cart->getSubTotal($store_id);

		if (!empty($this->session->data['vouchers'])) {
			foreach ($this->session->data['vouchers'] as $voucher) {
				$sub_total += $voucher['amount'];
			}
		}

		$total['totals'][] = array(
			'code'       => 'sub_total',
			'title'      => $this->language->get('text_sub_total'),
			'value'      => $sub_total,
			'sort_order' => $this->config->get('sub_total_sort_order')
		);

		$total['total'] += $sub_total;
	}
}
