<?php
global $post, $prepareResponse, $ses_id, $success;
$fileContent = file_get_contents('php://input');

if ($fileContent) {
    $message         = new ResponseMessage($post->Code, $post->Title, $post->Message);
    $response_object = new Response($prepareResponse, $message, $ses_id);
    returnJsonHttpResponse($success, $response_object);
}
