<?php
function json_response($code = 200, $message = null)
{
  // clear the old headers
  header_remove();
  // set the actual code
  http_response_code($code);
  // set the header to make sure cache is forced
  header('Cache-Control: no-transform,public,max-age=300,s-maxage=900');
  // treat this as json
  header('Content-Type: application/json');
  $status = [
    200 => '200 OK',
    400 => '400 Bad Request',
    422 => 'Unprocessable Entity',
    500 => '500 Internal Server Error',
  ];
  // ok, validation error, or failure
  header('Status: ' . $status[$code]);
  // return the encoded json
  return json_encode([
    'status' => $code < 300, // success or not?
    'message' => utf8ize($message),
  ]);
}

function utf8ize( $mixed ) {
  if (is_array($mixed)) {
    foreach ($mixed as $key => $value) {
      $mixed[$key] = utf8ize($value);
    }
  } elseif (is_string($mixed)) {
    return mb_convert_encoding($mixed, "UTF-8", "UTF-8");
  }
  return $mixed;
}
