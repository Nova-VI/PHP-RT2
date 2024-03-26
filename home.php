<?php
session_start();

if(isset($_SESSION['user']))
{
    echo $_SESSION['user'];
}
if(isset($_SESSION['user_type']))
{
    echo $_SESSION['user_type'];
}
