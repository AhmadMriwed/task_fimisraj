<?php

namespace App\Services\Network;

use Exception;

class NetworkService{
   public function processWithCallback($callback)
{
    try {

        // قم بتنفيذ العملية أو استدعاء التابع الداخلي
        $result = $callback();

        // تحقق من نجاح العملية
        if ($result) {
            // إعادة نتيجة التابع في حالة النجاح
            return $result;
        } else {
            // رسالة خطأ في حالة الفشل
            throw new Exception('فشلت العملية');
        }
     } catch (Exception $e) {


            // تعامل مع الأخطاء هنا
            $statusCode = $e->getCode();
            $errorBody = $e->getMessage();


            return [
                'error' => true,
                'status_code' => $statusCode,
                'message'=>$errorBody,
            ];
        }

}
}
