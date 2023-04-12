<?php

namespace Aminpciu\CrudAutomation;

use Illuminate\Support\Facades\Http;

class Inspire {
    public function justDoIt() {
        $response = Http::get('https://inspiration.goprogram.ai/');
        return $response['quote'] . ' —' . $response['author'];
    }
    public function tt(){
        // echo "/vendor/" > .gitignore
        // git init
        // git checkout -b master
        // git add .
        // git commit -m "Initial commit"
        // git tag 1.0.0
    }
}
