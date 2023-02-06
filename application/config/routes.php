<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = false;

$route['acara/(:any)'] = 'acara';
$route['kategori_acara/(:any)'] = 'kategori_acara';
$route['kategori_acara/(:any)/(:any)'] = 'kategori_acara';

$route['gallery/(:any)'] = 'gallery';
$route['kategori_gallery/(:any)'] = 'kategori_gallery';
$route['kategori_gallery/(:any)/(:any)'] = 'kategori_gallery';

$route['bendahara'] = 'admin/index_bendahara';
$route['marketing'] = 'admin/data_referral';
$route['marketing/setting'] = 'admin/setting';
$route['manage/jenis_pembayaran'] = 'set_pembayaran';
$route['manage/jenis_pembayaran/view_bulan'] = 'set_pembayaran/view_bulan';
$route['manage/jenis_pembayaran/add'] = 'set_pembayaran/add';
$route['manage/jenis_pembayaran/view_bulan/(:num)'] = 'set_pembayaran/view_bulan/$1';
$route['manage/jenis_pembayaran/view_bebas/(:num)'] = 'set_pembayaran/view_bebas/$1';

$route['manage/jenis_pembayaran/add_payment_bulan/(:num)'] = 'set_pembayaran/add_payment_bulan/$1';
$route['manage/jenis_pembayaran/add_payment_bulan_pend/(:num)'] = 'set_pembayaran/add_payment_bulan_pend/$1';
$route['manage/jenis_pembayaran/add_payment_bulan_majors/(:num)'] = 'set_pembayaran/add_payment_bulan_majors/$1';
$route['manage/jenis_pembayaran/add_payment_bulan_student/(:num)'] = 'set_pembayaran/add_payment_bulan_student/$1';

$route['manage/jenis_pembayaran/add_payment_bebas/(:num)'] = 'set_pembayaran/add_payment_bebas/$1';
$route['manage/jenis_pembayaran/edit_payment_bebas/(:num)/(:num)/(:num)'] = 'set_pembayaran/edit_payment_bebas/$1/$2/$3';
$route['manage/jenis_pembayaran/add_payment_bebas_pend/(:num)'] = 'set_pembayaran/add_payment_bebas_pend/$1';
$route['manage/jenis_pembayaran/add_payment_bebas_majors/(:num)'] = 'set_pembayaran/add_payment_bebas_majors/$1';
$route['manage/jenis_pembayaran/add_payment_bebas_student/(:num)'] = 'set_pembayaran/add_payment_bebas_student/$1';

$route['manage/jenis_pembayaran/edit_payment_bulan/(:num)/(:num)'] = 'set_pembayaran/edit_payment_bulan/$1/$2';
$route['manage/pembayaran_ppdb'] = 'manage/data_pembayaran';