<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;

use App\Events\SessionAboutToEnd;
class SessionExpirey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'session:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Session Expiry Check';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        while(true){
            if($this->sessionIsAboutToExpire()){
                Event::dispatch(new SessionAboutToEnd());
            }
            sleep(1);
        }
    }

    public function sessionIsAboutToExpire(){
        $sessionLifeTime  = config('session.lifetime');
        $beforeTimeout    = 2 ;
        // $email            = session()->get('admin')['email'];

        if(( time() - session('_token_lifespan', 0) > ($sessionLifeTime - $beforeTimeout) )){
            // \App\Models\LoginUsers::where('email' , $email)->delete();
            return redirect(Route('Auth.login'))->with('error','session expired') ;
            Log::info('Command is running...');
        }
        else
        {
            return false ;
        }
    }
}
