<?php

namespace App\Console\Commands;

use App\Constants;
use App\Mail\CronJobMail;
use App\Models\Cron_job;
use App\Models\Members;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Mail;

class SuggestPartner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
     protected $signature = 'suggestcron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email To Suggest Partner';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $max_cron_number = Members::max('cron_job_number');
        if($max_cron_number == 0){
            $members = Members::select('id','username','email','partner_gender','partner_min_age','partner_max_age','cron_job_number')
                                ->inRandomOrder()
                                ->take(10)
                                ->get();
        }
        else{
            $members = Members::select('id','username','email',
            'partner_gender','partner_min_age','partner_max_age','cron_job_number')
                                ->where('cron_job_number','<',$max_cron_number)
                                ->inRandomOrder()
                                ->take(10)
                                ->get();
        }
        foreach($members as $member){
            $id                 = $member->id;
            $partner_gender     = $member->partner_gender;
            $partner_min_age    = $member->partner_min_age;
            $partner_max_age    = $member->partner_max_age;
            $suggested_members = Cron_job::select('suggest_member_id')
                                        ->where('sender_member_id','=',$id)
                                        ->get();
            $suggest_member = Members::select('id','username',
                            DB::raw("TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) AS age"))
                            ->where('id','!=',$id)
                            ->where('date_of_birth', '<=' , now()->subYears($partner_min_age)->toDateString())
                            ->where('date_of_birth', '>=' , now()->subYears($partner_max_age)->toDateString());
            if($partner_gender != Constants::PARTNER_GENDER_BOTH){
                $suggest_member = $suggest_member->where('gender','=',$partner_gender);
            }
            if($suggested_members != null){
                foreach($suggested_members as $member){
                    $suggest_member = $suggest_member->where('id','!=',$member->suggest_member_id);
                }
            }
            $suggest_member = $suggest_member->inRandomOrder()
                                            ->take(1)
                                            ->first();
            $setting = Setting::select('company_name')
                                ->first();
            if($suggest_member != null){
                $insert                         = [];
                $insert['cron_job_number']      = $member->cron_job_number;
                $insert['sender_member_id']     = $member->id;
                $insert['suggest_member_id']    = $suggest_member->id;
                Cron_job::create($insert);
                $mailData = [
                    'username'      => $suggest_member->username,
                    'id'            => $suggest_member->id,
                    'age'           => $suggest_member->age,
                    'company_name'  => $setting->company_name
                ];
                Mail::to($member->email)->send(new CronJobMail($mailData));
            }
        }
        return Command::SUCCESS;
    }
}
