<?php

function flash($message)
{
    $_SESSION['flash'] = $message;
}