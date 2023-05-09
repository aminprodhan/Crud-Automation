<?php

namespace Aminpciu\CrudAutomation\app\Jobs;;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InitialDataImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data=[];protected $table=null;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data,$table)
    {
        //
        $this->data=$data;
        $this->table=$table;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(Schema::hasTable($this->table)) {
            $results = DB::select('SELECT count(*) as count FROM '.$this->table);
            $count = $results[0]->count;
            if(empty($count))
                DB::table($this->table)->insert($this->data);
        }
    }
}
