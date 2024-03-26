<?php

namespace App\Jobs\Test;

use Throwable;
use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ConsumeApiServiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $urlToConsume;
    public function __construct($url)
    {
        $this->urlToConsume = $url;
    }
    public function handle()
    {
        try{    
            $response = Http::get($this->urlToConsume);
            foreach($response['entries'] as $key => $value){

                $obj = new Book();
                
                $titleCount = Book::select('title')
                ->where('title',$value['title'])->count();
                

                $bioCount = Book::select('bio')
                ->where('bio',isset($value['description']['value']) ? $value['description']['value'] : "key not found !")->count();
             

                $valueCount = Book::select('value')
                ->where('value',$value['created']['value'])->count();
               

                if($titleCount == 0 || $bioCount == 0 || $valueCount == 0){
                    $obj->title = $value['title'];
                    $obj->bio = isset($value['description']['value']) ? $value['description']['value'] : "key not found !";
                    $obj->value = $value['created']['value'];
                    $obj->save();

                }
              
            }
            
                echo "Data added !";
            
            Log::info('response',[$response]);
        }catch(Throwable $e){
            Log::info($e->getMessage(),[$e->getTraceAsString()]);
        }
        Log:info('Job Invoked');
    }
}

