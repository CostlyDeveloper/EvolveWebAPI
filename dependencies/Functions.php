<?php

function RequiredProps($request, $arrayOfRequiredProps)
{
	$counterA = 0;
	$counterB = 0;

	foreach ($arrayOfRequiredProps as $RequiredProp) {
        $counterA += property_exists($request, $RequiredProp) ? 1 : 0;
		$counterB += 1;
	}

	if ($counterA === $counterB) {
		return true;
	} else {
		return false;
	}

}

/****/

function returnJsonHttpResponse($success, $data)
{
    // remove any string that could create an invalid JSON
    // such as PHP Notice, Warning, logs...
    ob_clean();

    // this will clean up any previously added headers, to start clean
   /* if (!headers_sent()) {
        foreach (headers_list() as $header)
            header_remove($header);
    }*/

    // Set the content type to JSON and charset
    // (charset can be set to something else)
    header("Content-type:   application/json; charset=utf-8");

    // Set your HTTP response code, 2xx = SUCCESS,
    // anything else will be error, refer to HTTP documentation
    if ($success) {
        http_response_code(200);
    } else {
        http_response_code(500);
    }

    // encode your PHP Object or Array into a JSON string.
    // stdClass or array

    echo json_encode($data);

    // making sure nothing is added
    exit();
}
