<?php
$user_info = strval($_REQUEST["user_info"]);

$client_public_key = strval($_REQUEST["client_public_key"]);
$client_public_key = str_replace(" ","+",$client_public_key);

$con=mysqli_connect("localhost","vpn-admin","s3cret","vpn");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
};
#mysqli_select_db($con,"vpn");
$get_available_ip = "SELECT ID,INET_NTOA(`AVAILABLE_IP`) as IP FROM available_ips WHERE ASSIGNED = 0 ORDER BY RAND() LIMIT 1";
$result = $con->query($get_available_ip);

$result_array = $result->fetch_all(MYSQLI_ASSOC);
$IP_ID = $result_array[0]["ID"];
$AVAILABLE_IP = $result_array[0]["IP"];
$reg_user = "INSERT INTO profile_info (`USER_INFO`,`CLIENT_PUB_KEY`,`CLIENT_VIP`) VALUES ('".$user_info."','".$client_public_key."',INET_ATON('".$AVAILABLE_IP."'))";
if (! mysqli_query($con,$reg_user)){
echo json_encode(mysqli_error($con));
mysqli_close($con);
header("HTTP/1.1 400 Bad Request");
exit();
}
$update_ip_list = "UPDATE available_ips SET ASSIGNED = 1 WHERE ID = ".$IP_ID."";
if (! mysqli_query($con,$update_ip_list)){
echo json_encode(mysqli_error($con));
mysqli_close($con);
header("HTTP/1.1 400 Bad Request");
exit();
}

#$shell_cmd = "ls -lah";
$shell_cmd = "sudo wg set wg0 peer ".$client_public_key." allowed-ips ".$AVAILABLE_IP."/32";


$output = shell_exec($shell_cmd);
var_dump($AVAILABLE_IP);
var_dump($shell_cmd);
echo $output;
echo json_encode($result_array);
mysqli_close($con);
?>
