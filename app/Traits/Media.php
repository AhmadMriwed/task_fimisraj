<?php

namespace App\Traits;

use App\Models\Media\Files;
use App\Utils\Helper;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Scalar\String_;

trait Media {

    // upload file

   public $public_path="";

    public function upload_file_by_name($request,$request_file_name,$directory):String{
        $file=$request->file($request_file_name);

        $fileName  = time() . '_' . $file->getClientOriginalName();
        $path       = $directory.'/'.$fileName;
        Storage::disk('public')->put($path, file_get_contents($file));
       
        //  $path = $file->store('public/'.$directory);
        //  $path = substr($path, strlen('public/'));

        // return 'storage/'.$path;
        return $path;

    }
    public function upload_file($file,$directory){

        $fileName  = time() . '_' . $file->getClientOriginalName();
        $path       = $directory.'/'.$fileName;
        Storage::disk('public')->put($path, file_get_contents($file));
		
        // $path = $file->store('public/'.$directory);
        // $path = substr($path, strlen('public/'));

        // return 'storage/'.$path;
        return $path;
    }



    // upload multiple images

    public function upload_mulitple_files($request,$request_files_name,$directory){

        $paths = [];

        if($request->hasfile($request_files_name))
        {

           foreach($request->file($request_files_name) as $key => $file)
           {

        
            $fileName  = time() . '_' . $file->getClientOriginalName();
            $path       = $directory.'/'.$fileName;
            Storage::disk('public')->put($path, file_get_contents($file));

            $size = Storage::disk('public')->size($path);
          
            //    $path = $file->store('public/'.$directory);

            //    $path = substr($path, strlen('public/'));

                $paths [] =  $path;
                //'storage/'.$path;
           }
        }

        return $paths;
    }

    public  function upload_mulitple_files_with_details($request,$request_files_name,$directory)
    {
        if($request->file($request_files_name)==null)
         return [];

        $files=[];
        foreach($request->file($request_files_name) as $key => $file){
        $path = $this->upload_file($file,$directory);
        $attributes = array(
           'name'=>$file->getClientOriginalName(),
           'path'=>// asset 
            ($path),
           'size'=> Storage::disk('public')->size($path),
           'type'=>Helper::getFileType($file),
           'sub_type'=>$file->guessExtension(),
        );
        $files[]=new Files($attributes);
   }
   return $files;
    }

    public  function upload_file_with_details($file,$directory)
    {
        if($file==null)
         return null;
        $path = $this->upload_file($file,$directory);
        $attributes = array(
           'name'=>$file->getClientOriginalName(),
           'path'=>// asset 
            ($path),
           'size'=> Storage::disk('public')->size($path),
           'type'=>Helper::getFileType($file),
           'sub_type'=>$file->guessExtension(),
        );
        $fileDetails=new Files($attributes);
   return $fileDetails;
    }


    // delete image file

    public function delete_file($path){

        //$file = substr($path, strlen('storage/'));
        $file = substr($path, strlen(''));

        Storage::delete('public/'.$file);

    }


}
