<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Softon\Sms\Facades\Sms;  

class ApproveMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Approved:Message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Approved Messages';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

  

    public function handle()
    {
        
     $data['name'] = "No";
     DB::table('categories')->insert($data);
     
     echo 'ji';
    }

}
