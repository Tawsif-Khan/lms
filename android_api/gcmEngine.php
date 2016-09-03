<?php
// Message to be sent

// Set POST variables

function send_message_for_permission($member_id,$borrow_id){
$url = 'https://android.googleapis.com/gcm/send';


$query = mysql_query("SELECT * FROM devices WHERE member_id=$member_id");

if($query){
while($row = mysql_fetch_array($query)){
	 $device_ids[] = $row['device_id'];
}
//$device_ids[] = 'APA91bHSOe8shlzzizKkhxAd6w7C6F65EYO6I1kAWJ1346DS1r1UXSa97ARIPHW6I5ZFq2N2JKKVrA7c1X3w0CL45qhX3GEuoLxMOjZqexLwb4eyLRkzwjwI9_BcT2w7ppg5H9TTMdBr';
$fields = array(
                'registration_ids'  => $device_ids,
                'data'              => array( "borrow_id" => $borrow_id),
                );

$headers = array( 
                    'Authorization: key=' . 'AIzaSyCXCAbYh2wGrTinGUQghx2qCKMGyoXSyOQ',
                    'Content-Type: application/json'
                );

// Open connection
$ch = curl_init();

// Set the url, number of POST vars, POST data
curl_setopt( $ch, CURLOPT_URL, $url );

curl_setopt( $ch, CURLOPT_POST, true );
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );

// Execute post
$result = curl_exec($ch);

// Close connection
curl_close($ch);
}
//echo $result;

//die();

}