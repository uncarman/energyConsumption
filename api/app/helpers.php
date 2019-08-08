<?php

function active_class($a) {
    return $a;
}

function if_route($a) {
    return $a;
}

/**
 * 打包 成功返回信息
 * @param $data
 * @param string $code
 * @param string $msg
 * @return \Illuminate\Http\JsonResponse
 */
function makeSuccessMsg($data = [], $code = "10000", $msg = 'success', $subCode = "", $subMsg = 'success')
{
    $responseDataObj = new \Illuminate\Http\JsonResponse([
        'code' => $code,
        'msg' => $msg,
        'sub_code' => $subCode,
        'sub_msg' => $subMsg,
        'result' => $data
    ], 200);
    return $responseDataObj->setEncodingOptions(JSON_UNESCAPED_UNICODE);
}
/**
 * 打包 失败返回信息
 * @param string $subCode
 * @param   $subMsg
 * @param string $msg
 * @param string $code
 * @return \Illuminate\Http\JsonResponse
 */
function makeFailedMsg($subMsg = "something.wrong", $subCode = "", $msg = 'something wrong', $code = "40004")
{
    $responseData = [
        'code' => $code,
        'msg' => $msg,
        'sub_code' => $subCode,
        'sub_msg' => $subMsg,
        'result' => new StdClass()//空对象
    ];
    $responseDataObj = new \Illuminate\Http\JsonResponse($responseData, 200);
    return $responseDataObj->setEncodingOptions(JSON_UNESCAPED_UNICODE);
}

?>