<?php

include 'autoloader.php';
$dto = new AdminApiImpl();
$empleatsArray = EmpleatsOnyx();

$domini = $_SERVER["HTTP_HOST"];
$rsdom = $dto->getDb()->executarConsulta('select idempresa from empresa where website like "' . $domini . '"');



if (!empty($rsdom))
{
    foreach ($rsdom as $dom)
    {
        $_SESSION["idempresa"] = $dom["idempresa"];
    }
}


if ($empleatsArray['success'] == 1)
{
    
    $dto->importEmpleatsOnyx($empleatsArray);
}

function EmpleatsOnyx()
{

    $token = loginOnyx();
    $url = 'http://api.onyxerp.com/index.php/read';

    $data = '{
	"fields":
	[
		{
			"alias":"",
			"apply":"",
			"name":"*",
			"type":"",
			"value":""
		}
	],
	"conditions":
	[

	],
	"table":"Empleado",
	"joins":
	[

	],
	"grouping":
	[

	],
	"order":
	{
		"bAsc":false,
		"field":""
	},
	"skip":0,
	"take":null,
	"unions":
	[

	],
	"distinct":false,
	"having":
	{
		"Expresion":""
	}
}
        ';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json',
            'ctoken: QXppZ3FET1BMUHVRK2VWWVk3clA3TVRXT01DV1FxWERyeFQ2ckRWdjVJcjdFOGlhbjFKTXpPa05VVFJUNWRMUw==',
            'token:' . $token . ' ',
        )
        //'Content-Length: ' . strlen($datastr))
    );

    $server_output = curl_exec($ch);
    $empleats = json_decode($server_output, true);

    //    echo ("<pre>");
    //    print_r($empleats);
    //    echo ("</pre>");
    return $empleats;
}

function loginOnyx()
{
    $url = 'http://api.onyxerp.com/index.php/login';
    $data = '{
	"username":"FICHAJES",
	"password":"FICHAJES",
	"customerId":281
        }
        ';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json',
            'ctoken: QXppZ3FET1BMUHVRK2VWWVk3clA3TVRXT01DV1FxWERyeFQ2ckRWdjVJcjdFOGlhbjFKTXpPa05VVFJUNWRMUw==',
            'token:'
        )
        //'Content-Length: ' . strlen($datastr))
    );

    $server_output = curl_exec($ch);
    $json = json_decode($server_output, true);
    /* echo '<pre>';
    print_r($json);
    echo '</pre>';
    exit; */
    return $json['token'];
}
