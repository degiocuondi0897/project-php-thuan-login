<?php

function sendmail($email, $fullname, $subject, $content) {
    
    require 'plugins/phpMailer/plugins/phpMailer/PHPMailer.php';
    $mail = new PHPMailer;
    $mail->CharSet = "utf-8";
//$mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                       // server của gmail
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'honguyet0897.utc@gmail.com';             // Địa chỉ email người gửi
    $mail->Password = '31081997';                        // mật khẩu email người gửi
    $mail->SMTPSecure = 'tls';                            // Chuẩn bảo mật tls
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom('honguyet0897.utc@gmail.com', 'hồ nguyệt'); // Địa chỉ email được gửi từ email nào
    $mail->addAddress($email, $fullname);     // Người nhận
//    $mail->addAddress('devvuitinh@gmail.com');               // Người nhận
    $mail->addReplyTo('honguyet0897.utc@gmail.com', 'hồ nguyệt');    //Người nhận email phản hồi
    $mail->addCC('cc@example.com');                            //Đánh dấu người khác vào email
    $mail->addBCC('bcc@example.com');

//$mail->addAttachment('uploads/baitap.pdf');         // Thêm nội dung file muốn gửi
//    $mail->addAttachment('uploads/success.png'); // Thêm nội dung ảnh muốn gửi , bên phải là tên thay thế
    $mail->isHTML(true);                                  // = true : cho phép nội dung gửi có HTML

    $mail->Subject = $subject;     //Chủ đề email
    $mail->Body = $content; //Nội dung email
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }
}
?>
