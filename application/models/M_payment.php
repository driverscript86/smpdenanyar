<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_payment extends CI_Model{

	public function __construct()
    {
        parent::__construct();
    }

	public function get_chanel()
	{
		$this->db->where('id', 1);
		$query  =  $this->db->get('payment')->row_array();

        // $payload = ['code' => $group];
		$apiKey = $query['api_key'];

		if ($query['mode'] == 'Sandbox') {
			$san = '-sandbox';
		}else{
			$san = '';
		}

		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_FRESH_CONNECT  => true,
		CURLOPT_URL            => 'https://tripay.co.id/api'.$san.'/merchant/payment-channel',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HEADER         => false,
		CURLOPT_HTTPHEADER     => ['Authorization: Bearer '.$apiKey],
		CURLOPT_FAILONERROR    => false,
		CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
		));

		$response = curl_exec($curl);
		$error = curl_error($curl);

		curl_close($curl);

		$response = json_decode($response, true);
		return $response['data'] ? $response['data'] : $error;
	}

	public function req_payment($id_user, $kode, $jumlah, $metode)
	{
		$this->db->where('id', 1);
		$query  =  $this->db->get('payment')->row_array();
		if ($query['mode'] == 'Sandbox') {
			$san = '-sandbox';
		}else{
			$san = '';
		}
		
		$this->db->where('id', $id_user);
		$user  =  $this->db->get('ppdb')->row_array();
		$ppdb  =  $this->db->get_where('data_pembayaran', ['jenis' => 'PPDB'])->result_array();

		$apiKey       = $query['api_key'];
		$privateKey   = $query['private_key'];
		$merchantCode = $query['kode_merchant'];
		$merchantRef  = $kode;
		$amount       = $jumlah;


		foreach ($ppdb as $p) {
			$pemb[] = array(
				'name'        => $p['nama'],
				'price'       => $p['jumlah'],
				'quantity'    => 1,
			);
		}
		for ($i = 0; $i < count($metode); $i++) {
		$data = [
			'method'         => $metode[$i],
			'merchant_ref'   => $merchantRef,
			'amount'         => $amount,
			'customer_name'  => $user['nama'],
			'customer_email' => $user['email'],
			'customer_phone' => $user['no_hp'],
			
			'order_items'  => $pemb,
			'return_url'   => base_url('ppdb/dashboard'),
			'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
			'signature'    => hash_hmac('sha256', $merchantCode.$merchantRef.$amount, $privateKey)
		];
		}
		$curl = curl_init();
		
		curl_setopt_array($curl, [
			CURLOPT_FRESH_CONNECT  => true,
			CURLOPT_URL            => 'https://tripay.co.id/api'.$san.'/transaction/create',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER         => false,
			CURLOPT_HTTPHEADER     => ['Authorization: Bearer '.$apiKey],
			CURLOPT_FAILONERROR    => false,
			CURLOPT_POST           => true,
			CURLOPT_POSTFIELDS     => http_build_query($data),
			CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
		]);
		
		$response = curl_exec($curl);
		$error = curl_error($curl);
		
		curl_close($curl);
		
		$response = json_decode($response, true);
		return $response['data'] ? $response['data'] : $error;
	}
}
