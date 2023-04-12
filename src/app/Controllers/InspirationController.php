<?php

namespace Aminpciu\CrudAutomation\app\Controllers;

use Illuminate\Http\Request;
use Aminpciu\CrudAutomation\Inspire;

class InspirationController
{
    public function __invoke(Inspire $inspire) {
        $quote = $inspire->justDoIt();

        return view('lca-amin-pciu::index', compact('quote'));
    }
}
