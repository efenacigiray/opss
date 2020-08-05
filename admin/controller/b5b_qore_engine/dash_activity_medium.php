<?php
class ControllerB5bQoreEngineDashActivityMedium extends Controller{
	private $error = array();

	public function index() {
		$this->load->language('extension/dashboard/activity');
		$this->load->language('b5b_qore_engine/dashboard/general');

		$data['user_token'] = $this->session->data['user_token'];

		$data['activities'] = array();

		$this->load->model('extension/dashboard/activity');

		$results = $this->model_extension_dashboard_activity->getActivities();

		foreach ($results as $result) {
			$comment = vsprintf($this->language->get('text_activity_' . $result['key']), json_decode($result['data'], true));

			$find = array(
				'customer_id=',
				'order_id=',
				'return_id='
			);

			$replace = array(
				$this->url->link('customer/customer/edit', 'user_token=' . $this->session->data['user_token'] . '&customer_id=', true),
				$this->url->link('sale/order/info', 'user_token=' . $this->session->data['user_token'] . '&order_id=', true),
				$this->url->link('sale/return/edit', 'user_token=' . $this->session->data['user_token'] . '&return_id=', true)
			);

			$data['activities'][] = array(
				'comment'    => str_replace($find, $replace, $comment),
				'date_added' => date($this->language->get('datetime_format'), strtotime($result['date_added']))
			);
		}

		return $this->load->view('dashboard/activity_medium', $data);
	}
}