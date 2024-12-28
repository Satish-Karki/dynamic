<?php
strong><br>$feedback</p>";


    if ($smail->send()) {
        $_SESSION['message'] = 'Your feedback has been sent successfully.';
    } else {
        $_SESSION['message'] = 'Failed to send feedback. Please try again later.';
    }
} catch (Exception $e) {
    $_SESSION['message'] = 'Mailer Error: ' . $smail->ErrorInfo;
}