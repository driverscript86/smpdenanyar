<?php

function wa_api($no, $pesan)
{
    $ci = get_instance();
    $wa = $ci->db->get_where('wa_gateway', ['id' => '1'])->row_array();
    // $web =  $ci->db->get('website')->row_array();
    $data = [
        'api_key' => $wa['api_key'],
        'sender' => $wa['no_sender'],
        'number' => $no,
        'message' => $pesan
    ];
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => $wa['url'],
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => http_build_query($data),
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded'
      ),
    ));
    
    $response = curl_exec($curl);

    // var_dump($response);die;
    
    curl_close($curl);
}
