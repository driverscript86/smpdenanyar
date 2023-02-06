<?php
defined('BASEPATH') or exit('No direct script access allowed');
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
class Babi extends CI_Controller
{
    // public function __construct()
    // {
    //     parent::__construct();
    // }

    // public function index()
    // {
    //     $data['menu'] = 'about';
    //     $data['web'] =  $this->db->get('website')->row_array();
    //     $data['home'] =  $this->db->get('home')->row_array();
    //     $data['about'] =  $this->db->get('about')->row_array();

    //     $this->load->view('frontend/header', $data);
    //     $this->load->view('frontend/about', $data);
    //     $this->load->view('frontend/footer', $data);
    // }

    public function kirim()
    {
        $this->load->view('kirim');
    }

    public function kirim_proses()
    {
        if (isset($_POST['submit'])) {
            // Instantiation and passing `true` enables exceptions
            $mail = new PHPMailer(true);

            $no_invoice         = $this->input->post('no_invoice');
            $nama_pengirim      = $this->input->post('nama_pengirim');
            $email              = $this->input->post('email');

            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'mail.smpdenanyar.online';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'superadmin@smpdenanyar.online';                     // SMTP username
            $mail->Password   = 'cepotmania08';                               // SMTP password
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('superadmin@smpdenanyar.online');
            $mail->addAddress($email, $nama_pengirim);     // Add a recipient

            $mail->addReplyTo('superadmin@smpdenanyar.online');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            // Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Konfirmasi Pembayaran dari Localhost dengan Jembot';
            $mail->Body    = '<h1>Halo, Admin.</h1> <p>Ada pesanan baru dengan nomor invoice ' . $no_invoice . '</p> ';

            if ($mail->send()) {
                echo 'Konfirmasi pembayaran telah berhasil';
            } else {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Tekan dulu tombolnya bos";
        }
    }
}
