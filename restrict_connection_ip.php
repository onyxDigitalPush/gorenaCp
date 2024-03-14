<?php
$dto = new AdminApiImpl();

$ips = $dto->selectIps();

$array_ips = array();

/** First, the function checks if the user navigates through a proxy. Then, validates the IP to rule out possible XSS */
if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
{
    $regex = "/([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})/";
    preg_match_all($regex, $_SERVER['HTTP_X_FORWARDED_FOR'], $ip_without_port);
    $array_ips_proxy = $ip_without_port[1];
    $client_ip = long2ip(ip2long($array_ips_proxy[0]));
}
else if (isset($_SERVER['HTTP_CLIENT_IP']))
{
    $client_ip = long2ip(ip2long($_SERVER['HTTP_CLIENT_IP']));
}
else
{
    $ip = $_SERVER["REMOTE_ADDR"];
    /** If the user does not navigate through a proxy, the function validates the IP with REMOTE_ADDR */
    $client_ip = long2ip(ip2long($ip));
}


foreach ($ips as $ip)
{
    array_push($array_ips, $ip["ip"]);
}

if (!in_array($client_ip, $array_ips))
{
    include 'restricted_connection.view.php';
    exit;
}
