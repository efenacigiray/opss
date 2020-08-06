<?php
class ControllerB5bQoreEngineDashUsersOnlineMini extends Controller{
	private $error = array();

	public function index() {
		$this->load->language('extension/dashboard/online');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_view'] = $this->language->get('text_view');

		$data['user_token'] = $this->session->data['user_token'];

		// Total Orders
		$this->load->model('report/online');

		// Customers Online
		$online_total = $this->model_report_online->getTotalOnline();

		if ($online_total >= 1000000000000) {
			$data['total'] = round($online_total / 1000000000000, 2) . 'T';
		} elseif ($online_total >= 1000000000) {
			$data['total'] = round($online_total / 1000000000, 2) . 'B';
		} elseif ($online_total >= 1000000) {
			$data['total'] = round($online_total / 1000000, 2) . 'M';
		}  elseif ($online_total >= 10000) {
			$data['total'] = round($online_total / 1000, 2) . 'K';
		}  elseif ($online_total >= 1000) {
			$data['total'] = number_format($online_total);
		} else {
			$data['total'] = $online_total;
		}

		$data['online'] = $this->url->link('report/online', 'user_token=' . $this->session->data['user_token'], true);

		return $this->load->view('dashboard/users_online_mini', $data);
	}
}
