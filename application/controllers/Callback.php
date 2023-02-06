<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Callback extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $json = $this->input->raw_input_stream;

        $this->db->where('id', 1);  
        $query  =  $this->db->get('payment')->row_array();

        // Isi dengan private key anda
        $privateKey = $query['private_key'];
        $signa = $this->input->server('HTTP_X_CALLBACK_SIGNATURE');
        $event = $this->input->server('HTTP_X_CALLBACK_EVENT');
        
        $callbackSignature = isset($signa) ? $signa: '';
     
        // Generate signature untuk dicocokkan dengan X-Callback-Signature
        $signature = hash_hmac('sha256', $json, $privateKey);
        
        if ($callbackSignature !== $signature) {
            exit('Invalid signature');
        }

        if ('payment_status' !== $event) {
            echo 'Invalid callback event, no action was taken';
        }
        
        $data = json_decode($json);
        $uniqueRef = $data->merchant_ref;
        $status = strtoupper((string) $data->status);

        /*
        |--------------------------------------------------------------------------
        | Proses callback untuk closed payment
        |--------------------------------------------------------------------------
        */
        if (1 === (int) $data->is_closed_payment) {
          
            if ($status == 'PAID'){
                $stat = '1';
            } elseif ($status == 'EXPIRED'){
                $stat = '0';
            } elseif ($status == 'FAILED'){
                $stat = '0';
            } elseif ($status == 'UNPAID'){
                $stat = '2';
            }
            $data = [
                'inv' => $stat,
                'date_inv' => date('Y-m-d')
            ];
            $this->db->where('kode_inv', $uniqueRef);
            $this->db->update('ppdb', $data);
            
            if ($status == 'PAID'){
                
                $ppdb =  $this->db->get_where('ppdb', ['kode_inv' => $uniqueRef])->row_array();

                $find = array("https://","http://");
                $replace = "www.";
                $arr = site_url();
                $site = str_replace($find,$replace,$arr);
        
                $no = $ppdb['no_hp'];
                $pesan = 'Pembayaran PPDB anda telah berhasil.
        
Info website : 
' . $site . '

Terimakasih.';
                wa_api($no, $pesan);
                
                $staff =  $this->db->get_where('karyawan', ['kode_reff' => $ppdb['kode_reff']])->row_array();
                $jumlah = $staff['jumlah_reff'] + 1;
                $this->db->set('jumlah_reff', $jumlah);
                $this->db->where('id', $staff['id']);
                $this->db->update('karyawan');
            }

            echo json_encode(['success' => true]);
            exit;
        }

    }
}
