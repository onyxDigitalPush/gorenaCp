<?php



$url = 'http://201.236.202.52:8081/perceval/index.php';

$data = '
{
    "fields": [
        {
            "alias": "",
            "apply": "",
            "name": "*",
            "type": "",
            "value": ""
        }
    ],
    "conditions": [],
    "table": "Empleado",
    "joins": [],
    "grouping": [],
    "order": {
        "bAsc": false,
        "field": ""
    },
    "skip": 0,
    "take": null,
    "unions": [],
    "distinct": false,
    "having": {
        "Expresion": ""
    }
}
';

$additional_headers = array(
    'ctoken: eU8rYURtSEZlZ0c5Y083WGtSVElIVkJZdzFkRTFZZUEzT0tNbVo3eWFTMlRGQk8ybjlvbXQydmh0aUFMV3hOWA==',
    'token: 3ab43b1059cea2578fdbb07fb72d5586ebf6f2644c2e701b013275bba5dbce12',
);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $additional_headers);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($datastr))
);

$server_output = curl_exec($ch);

echo $server_output;
?>








