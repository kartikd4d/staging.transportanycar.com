<?php

namespace App\Http\Controllers\Transporter;

use App\Feedback;
use App\Http\Controllers\WebController;
use App\Message;
use App\QuoteByTransporter;
use App\Thread;
use App\User;
use App\UserQuote;
use App\TransactionHistory;
use App\Notification;
use Carbon\Carbon;
use App\Services\EmailService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use App\SaveSearch;
use App\CompanyDetail;
use App\Services\SmsService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Artisan;

class DashboardController extends WebController
{
    public $chat_obj;
    public $user_obj;
    public $thread_obj;
    protected $emailService;
    public $sendSMS;
    public function __construct(EmailService $emailService)
    {
        $this->thread_obj = new Thread();
        $this->chat_obj = new Message();
        $this->user_obj = new User();
        $this->emailService = $emailService;
        $this->sendSMS = new SmsService;
    }

    public function dashboard(Request $request)
    {
        $user_data = Auth::guard('transporter')->user();
        $this_month = Carbon::now()->month;
        $last_month = Carbon::now()->subMonth()->month;
        $this_year = Carbon::now()->year;
        // save last visit time of transporter
        $user_data->last_visited_at = now();
        $user_data->save();

        $my_quotes = QuoteByTransporter::where('user_id', $user_data->id)->get();
        $quotes = UserQuote::whereIn('id', $my_quotes->pluck('user_quote_id'))->get();
        $params['bids_count'] = $my_quotes->count();
        $params['won_count'] = $my_quotes->where('status', 'accept')->count();
        $params['jobs_completed_count'] = $quotes->where('status', 'completed')->count();
        $params['total_earning_count'] = $my_quotes->where('status', 'accept')->whereIn('user_quote_id', $quotes->where('status', 'completed')->pluck('id')->toArray())->sum('transporter_payment');
        $params['user'] = $user_data;
        //Total Earnings
        $accept_quote = QuoteByTransporter::where('status', 'accept')->where('user_id', $user_data->id)->get();
        $total_ids = $accept_quote->pluck('user_quote_id')->toArray();
        $total_distance = UserQuote::whereIn('id', $total_ids)
            ->sum('distance');
        $total_distance = $total_distance >= 1000 ? round($total_distance / 1000, 1) . 'K' : round($total_distance, 1);
        $total_duration = UserQuote::whereIn('id', $total_ids)
            ->sum('duration');
        $hours = intdiv($total_duration, 60);
        $minutes = $total_duration % 60;
        $total_duration = $hours . ' hrs ' . $minutes . ' mins';
        $this_month_user_quote_ids = $accept_quote->pluck('user_quote_id')->toArray();
        if (!empty($this_month_user_quote_ids)) {
            $this_month_user_quote = UserQuote::whereIn('id', $this_month_user_quote_ids)
                ->where('status', 'completed')
                ->whereMonth('created_at', $this_month)
                ->whereYear('created_at', $this_year)
                ->get();
            if ($this_month_user_quote->isNotEmpty()) {
                $user_quote_ids = $this_month_user_quote->pluck('id')->toArray();
                $this_month_earnings = QuoteByTransporter::whereIn('user_quote_id', $user_quote_ids)->where('user_id', $user_data->id)
                    ->sum('transporter_payment');
            } else {
                $this_month_earnings = 0;
            }
        } else {
            $this_month_earnings = 0;
        }
        $last_month_user_quote_ids = $accept_quote->pluck('user_quote_id')->toArray();
        if (!empty($last_month_user_quote_ids)) {
            $last_month_user_quote = UserQuote::whereIn('id', $last_month_user_quote_ids)
                ->where('status', 'completed')
                ->whereMonth('created_at', $last_month)
                ->whereYear('created_at', $this_year)
                ->get();
            if ($last_month_user_quote->isNotEmpty()) {
                $user_quote_ids_last_month = $last_month_user_quote->pluck('id')->toArray();
                $last_month_earnings = QuoteByTransporter::whereIn('user_quote_id', $user_quote_ids_last_month)->where('user_id', $user_data->id)
                    ->sum('transporter_payment');
            } else {
                $last_month_earnings = 0;
            }
        } else {
            $last_month_earnings = 0;
        }
        $start_of_last_week = Carbon::now()->subWeek()->startOfWeek();
        $end_of_last_week = Carbon::now()->subWeek()->endOfWeek();
        $previous_week_user_quote = UserQuote::whereIn('id', $accept_quote->pluck('user_quote_id'))
            ->where('status', 'completed')
            ->whereBetween('created_at', [$start_of_last_week, $end_of_last_week])
            ->get();
        if ($previous_week_user_quote->isNotEmpty()) {
            $user_quote_ids_last_week = $previous_week_user_quote->pluck('id')->toArray();
            $previous_week_earnings = QuoteByTransporter::whereIn('user_quote_id', $user_quote_ids_last_week)->where('user_id', $user_data->id)
                ->sum('transporter_payment');
        } else {
            $previous_week_earnings = 0;
        }
        $increase_from_previous_week = $previous_week_earnings / 100;
        $params['this_month_earnings'] = $this_month_earnings;
        $params['total_distance'] = $total_distance;
        $params['total_duration'] = $total_duration;
        $params['last_month_earnings'] = $last_month_earnings;
        $params['increase_from_previous_week'] = $increase_from_previous_week;
        return view('transporter.dashboard.index', $params);
    }

    // public function TotalEarning()
    // {
    //     $user = Auth::guard('transporter')->user();

    //     $accept_quote = QuoteByTransporter::where('status', 'accept')->where('user_id', $user->id)->get();
    //     $user_quote = UserQuote::whereIn('id', $accept_quote->pluck('user_quote_id'))->where('status', 'completed')->get();
    //     $earnings = QuoteByTransporter::whereIn('user_quote_id', $user_quote->pluck('id'))->where('user_id',$user->id)->select(DB::raw('date(created_at) as orderdate'), DB::raw('sum(transporter_payment) as grand_total1'))->groupBy('orderdate')->get();
    //     $maindata = [];
    //     if (count($earnings) > 0) {
    //         foreach ($earnings as $earning) {
    //             $detail = [];
    //             $detail[] = strtotime("+1 day", strtotime($earning->orderdate)) * 1000;
    //             $detail[] = $earning->grand_total1;
    //             $maindata[] = $detail;
    //         }
    //     }
    //     return $maindata;
    // }

    public function TotalEarning()
    {
        $user = Auth::guard('transporter')->user();

        $accept_quote = QuoteByTransporter::where('status', 'accept')
            ->where('user_id', $user->id)
            ->get();

        $user_quote = UserQuote::whereIn('id', $accept_quote->pluck('user_quote_id'))
            ->where('status', 'completed')
            ->get();

        $earnings = QuoteByTransporter::whereIn('user_quote_id', $user_quote->pluck('id'))
            ->where('user_id', $user->id)
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('SUM(transporter_payment) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Initialize an array for months with zero values
        $months = [
            'Jan' => 0,
            'Feb' => 0,
            'Mar' => 0,
            'Apr' => 0,
            'May' => 0,
            'Jun' => 0,
            'Jul' => 0,
            'Aug' => 0,
            'Sep' => 0,
            'Oct' => 0,
            'Nov' => 0,
            'Dec' => 0
        ];

        // Populate months with actual data
        foreach ($earnings as $earning) {
            $monthName = date('M', strtotime($earning->month . '-01'));
            if (isset($months[$monthName])) {
                $months[$monthName] = (float) $earning->total;
            }
        }

        // Convert to the desired format
        $maindata = [];
        foreach ($months as $month => $total) {
            $maindata[] = [$month, $total];
        }

        return $maindata;
    }

    public function TotalAnalytics()
    {
        $user = Auth::guard('transporter')->user();
        $accept_quote = QuoteByTransporter::where('status', 'accept')->where('user_id', $user->id)->get();
        $user_quote = UserQuote::whereIn('id', $accept_quote->pluck('user_quote_id'))->where('status', 'completed')->get();
        $cancel_quote = QuoteByTransporter::where('status', 'rejected')->where('user_id', $user->id)->get();
        $earnings = 1;
        $bids_placed = QuoteByTransporter::where('user_id', $user->id)->count();
        $maindata = [
            'cancelled' => $cancel_quote->count(),
            'jobs_won' => $accept_quote->count(),
            'bids_placed' => $bids_placed
        ];

        return $maindata;
    }

    public function profile()
    {
        $user = \Auth::guard('transporter', '')->user();
        // save last visit time of transporter
        $user->last_visited_at = now();
        $user->save();
        $my_quotes = QuoteByTransporter::where('user_id', $user->id)->get();
        $quotes = UserQuote::whereIn('id', $my_quotes->pluck('user_quote_id'))->get();
        $jobs_completed_count = $my_quotes->where('status', 'accept')->count();
        $total_earning_count = $my_quotes->where('status', 'accept')->whereIn('user_quote_id', $quotes->where('status', 'completed')->pluck('id')->toArray())->sum('transporter_payment');
        // dd($user);
        // die;
        // dd(($user->email_verify_status === "0"));
        $companyDetail = $user->companyDetail; // Access the related company details
        // return $companyDetail;
        return view('transporter.dashboard.profile', ['user' => $user, 'jobs_completed_count' => $jobs_completed_count, 'total_earning_count' => $total_earning_count, 'companyDetail' => $companyDetail]);
    }

    public function messages()
    {
        $user = Auth::guard('transporter')->user();
        $user_id = $user->id;

        $c_insatnce = $this->thread_obj->with(['message_latest'])->select("threads.*", 'u.name as user_name', 'u.profile_image')->TotalUnreadMessageCount(0)
            ->leftJoin("users as u", 'u.id', '=', 'threads.user_id')
            ->where("is_active", "y")
            ->where(function ($query) use ($user_id) {
                $query->where('threads.user_id', $user_id)
                    ->orWhere('threads.friend_id', $user_id);
            })
            ->orderBy('last_msg_update_time', 'DESC');
        $chats = $c_insatnce->get();

        //dd($chats);
        //dd($chats->TotalUnreadMessageCount);
        // $chats = $this->chat_obj->select('messages.*','f.name','f.id as user_id','f.profile_image')
        //     //->select(DB::raw("select count(cm.from_user) from chat_messages as cm where cm.from_user_id = chat_messages.from_user_id group by  as unread_message"))
        //     ->leftJoin('users as f','f.id','=','chat_messages.from_user_id')
        //     ->where('to_user_id', '=', $user_id)
        //     ->OrderBy('total_unread','DESC')
        //     ->groupBy('from_user_id')
        //     ->get();

        $latest_chat = $chats->first();
        return view('transporter.dashboard.messages')->with(compact('chats', 'latest_chat'));
    }

    public function feedback()
    {
        $user_data = Auth::guard('transporter')->user();

        $quoteBytransporter = QuoteByTransporter::where('user_id', $user_data->id)->get();
        $userQuote = UserQuote::whereIn('id', $quoteBytransporter->pluck('user_quote_id'))->get();

        $total_distance = UserQuote::whereIn('id', $quoteBytransporter->where('status', 'accept')->pluck('user_quote_id')->toArray())
            ->sum('distance');

        $totalDistance = $total_distance >= 1000
            ? round($total_distance / 1000, 1) . 'K'
            : round($total_distance, 1);

        $my_quotes = $quoteBytransporter->pluck('id');
        $quotes = TransactionHistory::whereIn('quote_by_transporter_id', $my_quotes)->get();

        $totalDistanceFormatted = is_numeric($totalDistance) ? number_format($totalDistance, 1) : $totalDistance; // Ensure valid formatting

        $completedCount = $userQuote->where('status', 'completed')->count();

        $total_earning = $quoteBytransporter
            ->where('status', 'accept')
            ->whereIn('user_quote_id', $userQuote->where('status', 'completed')->pluck('id')->toArray())
            ->sum('transporter_payment');

        $rating_average = Feedback::whereIn('quote_by_transporter_id', $my_quotes)
            ->whereNotNull('rating')
            ->avg('rating');

        $percentage = 0;
        if ($rating_average !== null) {
            $percentage = ($rating_average / 5) * 100;
        }

        $company_details = CompanyDetail::where('user_id', $user_data->id)->first();

        $params['user'] = $user_data;
        $params['feedback'] = Feedback::whereIn('quote_by_transporter_id', $my_quotes)
            ->with('quote_by_transporter.quote')
            ->get();
        $params['completed_job'] = number_format($completedCount); // Format here
        $params['distance'] = $totalDistanceFormatted;
        $params['total_earning'] = $total_earning;
        $params['company_detail'] = $company_details;
        $params['rating_percentage'] = $percentage;
        $params['rating_average'] = $rating_average;

        $customRequest = new Request([
            'type' => 'feedback',
        ]);

        // Call notificationStatus with the custom request
        $this->notificationStatus($customRequest);

        return view('transporter.dashboard.feedback', $params);
    }


    public function feedback_listing(Request $request)
    {
        $user_data = Auth::guard('transporter')->user();
        $my_quotes = QuoteByTransporter::where('user_id', $user_data->id)->pluck('id');
        $all_feedbacks = Feedback::whereIn('quote_by_transporter_id', $my_quotes)->where('transporter_id',$user_data->id)->get();
        $feedbacks = Feedback::whereIn('quote_by_transporter_id', $my_quotes)->paginate(10);
        $total_feedbacks = $all_feedbacks->count();

        $total_feedbacks = $feedbacks->count();


        $ratings = collect([5, 4, 3, 2, 1])->mapWithKeys(function ($rating) use ($all_feedbacks, $total_feedbacks) {
            $count = $all_feedbacks->where('rating', $rating)->count();
            $percentage = $total_feedbacks > 0 ? ($count / $total_feedbacks) * 100 : 0;
            return ['star_' . $rating => $percentage];
        });

        $average_rating = $total_feedbacks > 0 ? round($all_feedbacks->avg('rating'), 1) : 0;


        $params['html'] = view('transporter.dashboard.partial.feedback_listing', compact('feedbacks', 'ratings', 'average_rating'))->render();
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Job find successfully', 'data' => $params]);
        }
    }

    public function currentJobs($id = null)
    {
        if ($id) {
            try {
                $quote = QuoteByTransporter::with([
                    'getTransporters',
                    'quote.user',
                    'quote.quotationDetail'
                ])->where('id', $id)->first();
                $friend_id = $quote->quote->user_id ?? 0;
                if (!$quote) {
                    return view('transporter.dashboard.current_jobs');
                }
                $user_job = $quote->quote;
                $transporter = $quote->getTransporters;
                $user = $user_job->user ?? null;
                $quotation_detail = $user_job->quotationDetail ?? null;
                $lastVisitedAt = $user->last_visited_at->timezone('Europe/London');
                $last_visited_at = $this->formatLastVisitedAt($lastVisitedAt);
                if ($quotation_detail && $quotation_detail->created_at) {
                    $formattedDilveryDate = Carbon::createFromFormat('Y-m-d H:i:s', $quotation_detail->created_at)
                        ->setTimezone('Europe/London')
                        ->format('F d, H:i');
                } else {
                    $formattedDilveryDate = null;
                }
                return view('transporter.dashboard.current_jobs_detail', compact('quote', 'user_job', 'transporter', 'user', 'quotation_detail', 'last_visited_at', 'formattedDilveryDate', 'friend_id'));
            } catch (\Exception $e) {
                \Log::error('Error fetching quote details: ' . $e->getMessage());
                return view('transporter.dashboard.current_jobs');
            }
        } else {
            return view('transporter.dashboard.current_jobs');
        }
    }

    private function formatLastVisitedAt(Carbon $lastVisitedAt)
    {
        $now = Carbon::now('Europe/London');

        if ($lastVisitedAt->isToday()) {
            return 'Last seen Today ' . $lastVisitedAt->format('H:i');
        } elseif ($lastVisitedAt->isYesterday()) {
            return 'Last seen Yesterday ' . $lastVisitedAt->format('H:i');
        } else {
            return 'Last seen ' . $lastVisitedAt->format('d M Y H:i');
        }
    }

    public function newJobs()
    {
        $user_data = \Auth::guard('transporter')->user();
        $user_quote = QuoteByTransporter::where('user_id', $user_data->id)->pluck('user_quote_id');
        $quotes = UserQuote::with('user')->whereNotIn('id', $user_quote)->where('status', 'pending')->latest()->get();
        return view('transporter.dashboard.new_jobs', ['quotes' => $quotes]);
    }

    public function newJobsNew()
    {
        $user_data = \Auth::guard('transporter')->user();
        $user_data->last_visited_on_find_job_page = Carbon::now('Europe/London');
        $user_data->save();
        $user_quote = QuoteByTransporter::where('user_id', $user_data->id)->pluck('user_quote_id');
        $quotes = UserQuote::with([
            'user',
            'watchlist',
            'quoteByTransporter' => function ($query) use ($user_data) {
                $query->where('user_id', $user_data->id); // Assuming 'transporter_id' is the field
            }
        ])
            ->where(function ($query) {
                $query->where('status', 'pending')
                    ->orWhere('status', 'approved');
            })
            ->whereDate('created_at', '>=', now()->subDays(10))
            ->addSelect([
                'transporter_quotes_count' => QuoteByTransporter::selectRaw('COUNT(*)')
                    ->whereColumn('user_quote_id', 'user_quotes.id'),
                'lowest_bid' => QuoteByTransporter::selectRaw('MIN(CAST(transporter_payment AS UNSIGNED))')
                    ->whereColumn('user_quote_id', 'user_quotes.id')
            ])
            ->latest()
            ->paginate(50);
        $document_status = $user_data->is_status;
        return view('transporter.dashboard.new_jobs_new', ['quotes' => $quotes, 'documentStatus' => $document_status]);
    }
    // end d4d developer - k


    // d4d developer - k
    public function submitOffer(Request $request)
    {
        $user_data = \Auth::guard('transporter')->user();
        //dump($user_data);
        // Validate the request
        $validator = \Validator::make($request->all(), [
            'amount' => [
                'required',
            ],

            'quote_id' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $offer = $request->input('amount');
        if (!$offer || !is_numeric($offer)) {
            return response()->json(['success' => false]);
        }

        $quoteDetails = calculateCustomerQuote((float) $offer);
        // $quote = QuoteByTransporter::create([
        //     'user_id' => $user_data->id,
        //     'user_quote_id' => $request->quote_id,
        //     'price' => $quoteDetails['customer_quote'],
        //     'deposit' => $quoteDetails['deposit'],
        //     'transporter_payment' => $quoteDetails['transporter_payment'],
        //     'message' => $request->message,
        // ]);

        $quote = QuoteByTransporter::where('user_quote_id', $request->quote_id)
            ->where('user_id', $user_data->id)
            ->first();

        if ($quote) {
            // Update the existing offer
            $quote->update([
                'price' => $quoteDetails['customer_quote'],
                'deposit' => $quoteDetails['deposit'],
                'status'=>'pending',
                'transporter_payment' => $quoteDetails['transporter_payment'],
                'message' => $request->message,
            ]);
        } else {
            // Create a new offer if it doesn't exist
            $quote = QuoteByTransporter::create([
                'user_id' => $user_data->id,
                'user_quote_id' => $request->quote_id,
                'price' => $quoteDetails['customer_quote'],
                'deposit' => $quoteDetails['deposit'],
                'transporter_payment' => $quoteDetails['transporter_payment'],
                'message' => $request->message,
            ]);
        }

        $friend_id = $quote->quote->user_id ?? 0;
        $quoteId = $request['quote_id'];
        $isChatExist = Thread::where(function ($q) use ($friend_id) {
            $q->where('user_id', '=', $friend_id)
                ->orWhere('friend_id', '=', $friend_id);
        })->where(function ($q) use ($user_data) {
            $q->where('user_id', '=', $user_data->id)
                ->orWhere('friend_id', '=', $user_data->id);
        })->where('user_quote_id', '=', $quoteId)
            ->first();
        if (empty($isChatExist)) {
            $thread = Thread::create([
                'user_id' => $friend_id,
                'friend_id' => $user_data->id,
                'user_quote_id' => $request->quote_id,
                'last_msg_update_time' => date('Y-m-d H:i:s'),
            ]);
            if ($thread && isset($thread->id)) {
                $message = Message::create([
                    'threads_id' => $thread->id,
                    'sender_id' => $user_data->id,
                    'receiver_id' => $friend_id,
                    'message' => $request->message ?? null,
                    'type' => "message",
                ]);
            } else {
                echo "Failed to create thread.";
            }
        }
        // dd($quote);
        // return;
        try {
            if ($quote->quote->user->job_email_preference) {
                $maildata['email'] = $quote->quote->user->email;
                $thread_id = isset($thread->id) ? $thread->id : 0;
                // $user_name =$user_data->username;
                //$maildata['email'] = 'info@transportanycar.com';
                $mailSubject = 'Transport Quote for £' . $quoteDetails['customer_quote'] . ' to Deliver Your ' . $quote->quote->vehicle_make . ' ' . $quote->quote->vehicle_model;
                if (!empty($quote->quote->vehicle_make_1) && !empty($quote->quote->vehicle_model_1)) {
                    $mailSubject .= ' / ' . $quote->quote->vehicle_make_1 . ' ' . $quote->quote->vehicle_model_1;
                }
                $htmlContent = view('mail.General.user-new-offer-received', ['data' => $quote, 'thread_id' => $thread_id, 'user_name' => $user_data->username])->render();
                $this->emailService->sendEmail($maildata['email'], $htmlContent, $mailSubject);

                // Call create_notification to notify the user
                create_notification(
                    $quote->quote->user->id,
                    $user_data->id,
                    $quote->quote->id,
                    'You have a new quote!',
                    $user_data->username . ' has sent you a quote for £' . $quoteDetails['customer_quote'],  // Message of the notification
                    'quote',
                );
            } else {
                Log::info('User with email ' . $quote->quote->user->email . ' has opted out of receiving emails. Quotation email not sent.');
            }
            if ($quote->quote->user->mobile && $quote->quote->user->user_sms_alert > 0) {
                $smS = "Transport Any Car: New quote for £" . $quoteDetails['customer_quote'] . " to deliver your " . $quote->quote->vehicle_make . " " . $quote->quote->vehicle_model . ".\n\n" . request()->getSchemeAndHttpHost() . "/quotes/" . $quote->quote->id . "\n\n" . request()->getSchemeAndHttpHost() . "/manage_notification";
                $this->sendSMS->sendSms($quote->quote->user->mobile, $smS);
            }
        } catch (\Exception $ex) {
            Log::error('Error sending email: ' . $ex->getMessage());
        }
        // Run the outbid notification command
        // if (App::environment('production')) {
        //     $command = '/usr/local/bin/php /home/pfltvaho/public_html/artisan send:outbid-notifications ' . $request->quote_id . ' ' . $quoteDetails['transporter_payment'] . ' ' . $user_data->id;
        // } elseif ((App::environment('staging'))) {
        //     $command = '/usr/local/bin/php /home/pfltvaho/staging.transportanycar.com/artisan send:outbid-notifications ' . $request->quote_id . ' ' . $quoteDetails['transporter_payment'] . ' ' . $user_data->id;
        // } else {
        //     $command = '/usr/bin/php /var/www/laravel/car-app/artisan send:outbid-notifications ' . $request->quote_id . ' ' . $quoteDetails['transporter_payment'] . ' ' . $user_data->id;
        // }
        // exec($command, $output, $returnVar);

        // if ($returnVar !== 0) {
        //     // Handle the error based on the return code
        //     Log::error('Error running send:outbid-notifications command. Return code: ' . $returnVar);
        // }
        Artisan::call('send:outbid-notifications', [
            'quote_id' => $request->quote_id,
            'transporter_payment' => $quoteDetails['transporter_payment'],
            'transporter_id' => $user_data->id,
            ]);
        return response()->json(['success' => true]);
    }
    // end d4d developer - k

    public function updateProfileImage(Request $request)
    {
        $user_data = Auth::guard('transporter')->user();
        $thumb_upload = upload_base_64_img($request->image, get_constants('upload_paths.user_profile_image'));
        if ($thumb_upload) {
            un_link_file($user_data->profile_image);
            $user_data->profile_image = $thumb_upload;
            $user_data->save();
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Profile image upload successfully']);
            }
        }
        return response()->json(['success' => false, 'message' => 'something went wrong please try again']);
    }

    public function updateProfileDocs(Request $request)
    {
        $user_data = Auth::guard('transporter')->user();
        if ($request->hasFile('driver_license')) {
            $driver_license = upload_file('driver_license', 'user_profile_image');
            $user_data->driver_license = $driver_license ?? null;
        }
        if ($request->hasFile('goods_in_transit_insurance')) {
            $goods_in_transit_insurance = upload_file('goods_in_transit_insurance', 'user_profile_image');
            $user_data->goods_in_transit_insurance = $goods_in_transit_insurance ?? null;
        }
        if ($request->hasFile('driver_license') || $request->hasFile('goods_in_transit_insurance')) {
            $user_data->is_status = 'pending';
        }
        $user_data->save();

        return response()->json(['success' => true, 'message' => 'Uploaded successfully']);
    }

    public function updateEmailPreference(Request $request)
    {

        // dd($request->all());
        // return;
        $user = Auth::guard('transporter')->user();
        if ($user) {
            if ($request->email_type == 'job_alert') {
                $status = $user->update(['job_email_preference' => $request->value]);

                if ($status) {
                    return response()->json(['status' => true, 'message' => 'Preference updated successfully.']);
                } else {
                    return response()->json(['status' => false, 'message' => 'Failed to update preference.']);
                }
            } elseif ($request->email_type == 'summary_of_leads') {
                $status = $user->update(['summary_of_leads' => $request->value]);
                if ($status) {
                    return response()->json(['status' => true, 'message' => 'Preference updated successfully.']);
                } else {
                    return response()->json(['status' => false, 'message' => 'Failed to update preference.']);
                }
            } elseif ($request->email_type == 'outbid_email_unsubscribe') {
                $status = $user->update(['outbid_email_unsubscribe' => $request->value]);
                if ($status) {
                    return response()->json(['status' => true, 'message' => 'Preference updated successfully.']);
                } else {
                    return response()->json(['status' => false, 'message' => 'Failed to update preference.']);
                }
            } elseif ($request->email_type == 'saved_search_alerts') {
                $status = $user->update(['job_email_preference' => $request->value]);
                if ($status) {
                    return response()->json(['status' => true, 'message' => 'Preference updated successfully.']);
                } else {
                    return response()->json(['status' => false, 'message' => 'Failed to update preference.']);
                }
            } elseif ($request->email_type == 'new_job_alert') {
                $status = $user->update(['new_job_alert' => $request->value]);
                if ($status) {
                    return response()->json(['status' => true, 'message' => 'Preference updated successfully.']);
                } else {
                    return response()->json(['status' => false, 'message' => 'Failed to update preference.']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Invalid email type.']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'User not authenticated.']);
        }
    }

    public function profilePost(Request $request)
    {
        $user_data = Auth::guard('transporter')->user();
        $user_data->email = $request->email;
        $user_data->name = $request->company_name;
        $user_data->business_description = $request->business_description;
        $user_data->insurance_cover = $request->insurance_cover;
        $user_data->address = $request->address;
        $user_data->country_code = $request->country_code;
        $user_data->mobile = $request->mobile;
        if ($request->hasFile('driver_license')) {
            $driver_license = upload_file('driver_license', 'user_profile_image');
            $user_data->driver_license = $driver_license ?? null;
        }
        if ($request->hasFile('motor_trade_insurance')) {
            $motor_trade_insurance = upload_file('motor_trade_insurance', 'user_profile_image');
            $user_data->motor_trade_insurance = $motor_trade_insurance ?? null;
        }
        if ($request->hasFile('goods_in_transit_insurance')) {
            $goods_in_transit_insurance = upload_file('goods_in_transit_insurance', 'user_profile_image');
            $user_data->goods_in_transit_insurance = $goods_in_transit_insurance ?? null;
        }
        if ($request->hasFile('motor_trade_insurance') || $request->hasFile('driver_license') || $request->hasFile('goods_in_transit_insurance')) {
            $user_data->is_status = 'pending';
        }
        if ($request->has('payment_methods')) {
            $user_data->payment_methods = implode(',', $request->payment_methods);
        } else {
            $user_data->payment_methods = null;
        }
        if (!empty($request->npassword) && isset($request->npassword)) {
            $user_data->password = $request->npassword;
        }
        $user_data->save();
        // Validate the incoming request data
        $validatedData = $request->validate([
            'git_insurance_cover' => 'string',
            'years_established' => 'string',
            'no_of_tow_trucks' => 'string',
            'no_of_drivers' => 'string',
        ]);

        // Use updateOrCreate to create a new record or update an existing one
        CompanyDetail::updateOrCreate(
            ['user_id' => auth()->id()], // The condition to find an existing record
            [
                'git_insurance_cover' => $validatedData['git_insurance_cover'] ?? '',
                'years_established' => $validatedData['years_established'] ?? '',
                'no_of_tow_trucks' => $validatedData['no_of_tow_trucks'] ?? '',
                'no_of_drivers' => $validatedData['no_of_drivers'] ?? '',
            ]
        );

        success_session('Profile updated successfully');
        return redirect()->back();
    }

    public function help_and_support(Request $request)
    {
        try {
            $maildata['email'] = 'support@transportanycar.com';
            $mailSubject = 'Help & Support Transporter';
            $htmlContent = view('mail.General.help_and_support', ['data' => $request])->render();
            $this->emailService->sendEmail($maildata['email'], $htmlContent, $mailSubject);
            return response()->json(['success' => true, 'message' => 'Message sent. we will contact ASAP.']);
        } catch (\Exception $ex) {
            Log::error('Error sending email: ' . $ex->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong!.. try again!.']);
        }
    }

    // d4d developer - k
    public function find_job(Request $request)
    {
        // return $request->all();
        if (empty($request->search_pick_up_area)) {
            return response()->json(['success' => false, 'message' => 'Currently no jobs to show']);
        }

        $pickUpResponse = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'address' => $request->input('search_pick_up_area'),
            'key' => config('constants.google_map_key'),
        ]);
        $pickUpData = $pickUpResponse->json();
        if ($pickUpData['status'] === 'OK') {
            $pick_up_latitude = $pickUpData['results'][0]['geometry']['location']['lat'];
            $pick_up_longitude = $pickUpData['results'][0]['geometry']['location']['lng'];
        } else {
            return response()->json(['success' => false, 'message' => 'Currently no jobs to show']);
        }
        $drop_off_latitude = null;
        $drop_off_longitude = null;
        if ($request->search_drop_off_area && $request->search_drop_off_area != 'Anywhere') {
            $dropOffResponse = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address' => $request->input('search_drop_off_area'),
                'key' => config('constants.google_map_key'),
            ]);
            $dropOffData = $dropOffResponse->json();
            if ($dropOffData['status'] === 'OK') {
                $drop_off_latitude = $dropOffData['results'][0]['geometry']['location']['lat'];
                $drop_off_longitude = $dropOffData['results'][0]['geometry']['location']['lng'];
            } else {
                return response()->json(['success' => false, 'message' => 'Currently no jobs to show']);
            }
        }

        $maxDistance = config('constants.max_range_km');
        $user_data = Auth::guard('transporter')->user();
        $my_quotes = QuoteByTransporter::where('user_id', $user_data->id)->get();

        // Get IDs of user quotes that have been quoted by the transporter
        $my_quote_ids = $my_quotes->pluck('user_quote_id');

        $subQuery = UserQuote::query()
            ->join('users', 'users.id', '=', 'user_quotes.user_id')
            ->leftJoin('quote_by_transpoters', function ($join) {
                $join->on('quote_by_transpoters.user_quote_id', '=', 'user_quotes.id')
                    ->whereRaw('quote_by_transpoters.user_id = ?', [auth()->id()]); // Use DB::raw with a where condition
            })
            // ->whereNotIn('user_quotes.id', $my_quote_ids)
            ->where(function ($query) {
                $query->where('user_quotes.status', 'pending')
                    ->orWhere('user_quotes.status', 'approved');
            })
            ->whereDate('user_quotes.created_at', '>=', now()->subDays(10));
        if ($drop_off_latitude) {
            // return "yessssssssss";
            $subQuery->select(
                'quote_by_transpoters.user_id as tranporterId',
                'user_quotes.*',
                'users.profile_image',
                'users.username as name',
                'users.address',
                'users.town',
                'users.county',
                \DB::raw("( 6371 * acos( cos( radians($pick_up_latitude) ) * cos( radians( pickup_lat ) ) * cos( radians( pickup_lng ) - radians($pick_up_longitude) ) + sin( radians($pick_up_latitude) ) * sin( radians( pickup_lat ) ) ) ) AS distance_pickup"),
                \DB::raw("( 6371 * acos( cos( radians($drop_off_latitude) ) * cos( radians( drop_lat ) ) * cos( radians( drop_lng ) - radians($drop_off_longitude) ) + sin( radians($drop_off_latitude) ) * sin( radians( drop_lat ) ) ) ) AS distance_drop_off"),
                \DB::raw("COUNT(quote_by_transpoters.id) as quotes_count"), // Count the number of quotes by transporters
                // \DB::raw("MIN(quote_by_transpoters.transporter_payment) as lowest_bid"), // Get the lowest bid
                DB::raw("(CASE 
                WHEN (SELECT user_id FROM watchlists WHERE user_quote_id = user_quotes.id AND user_id = $user_data->id LIMIT 1) IS NOT NULL THEN 1 ELSE 0 END) AS watchlist_id")
            )
                ->having('distance_pickup', '<=', $maxDistance)
                ->having('distance_drop_off', '<=', $maxDistance);
        } else {
            $subQuery->select(
                'quote_by_transpoters.user_id as tranporterId',
                'user_quotes.*',
                'users.profile_image',
                'users.username as name',
                'users.address',
                'users.town',
                'users.county',
                \DB::raw("( 6371 * acos( cos( radians($pick_up_latitude) ) * cos( radians( pickup_lat ) ) * cos( radians( pickup_lng ) - radians($pick_up_longitude) ) + sin( radians($pick_up_latitude) ) * sin( radians( pickup_lat ) ) ) ) AS distance_pickup"),
                \DB::raw("COUNT(quote_by_transpoters.id) as quotes_count"), // Count the number of quotes by transporters
                // \DB::raw("MIN(quote_by_transpoters.transporter_payment) as lowest_bid"), // Get the lowest bid
                DB::raw("(CASE 
                WHEN (SELECT user_id FROM watchlists WHERE user_quote_id = user_quotes.id AND user_id = $user_data->id LIMIT 1) IS NOT NULL THEN 1 ELSE 0 END) AS watchlist_id")
            )
                ->having('distance_pickup', '<=', $maxDistance);
        }

        // Group by user_quote_id to get the count and minimum bid for each
        $subQuery
            ->addSelect([
                'transporter_quotes_count' => QuoteByTransporter::selectRaw('COUNT(*)')
                    ->whereColumn('user_quote_id', 'user_quotes.id'),
                'lowest_bid' => QuoteByTransporter::selectRaw('MIN(CAST(transporter_payment AS UNSIGNED))')
                    ->whereColumn('user_quote_id', 'user_quotes.id')
            ])
            ->groupBy('user_quotes.id')
            ->latest();

        // Wrap the subquery with the main query for pagination
        $quotes = \DB::table(\DB::raw("({$subQuery->toSql()}) as sub"))
            ->mergeBindings($subQuery->getQuery())
            ->paginate(20);

        if ($request->ajax()) {
            // Convert dates to DateTime objects if necessary
            foreach ($quotes as $quote) {
                $quote->created_at = \Carbon\Carbon::parse($quote->created_at);
                $quote->updated_at = \Carbon\Carbon::parse($quote->updated_at);
            }

            $pickup = $request->input('search_pick_up_area');
            $dropoff = $request->input('search_drop_off_area') ?? 'Anywhere';
            // return $quotes;
            $html = view('transporter.dashboard.partial.search_job_result', compact('quotes', 'pickup', 'dropoff'))->render();;

            return response()->json(['success' => true, 'message' => 'Job find successfully', 'data' => $html, 'quotes' => $quotes]);
        }
    }
    //end d4d developer - k

    public function my_job(Request $request)
    {
        $is_dashboard = $request->is_dashboard ?? 0;
        $search = $request->search ?? null;
        $type = $request->type;
        $user_data = Auth::guard('transporter')->user();
        $my_quotes = QuoteByTransporter::query();
        $my_quotes = $my_quotes->where('user_id', $user_data->id);
        if ($type == 'won') {
            $my_quotes = $my_quotes->where('status', 'accept');
        } elseif ($type == 'bidding') {
            $my_quotes = $my_quotes->where('status', 'pending');
        } elseif ($type == 'cancel') {
            $my_quotes = $my_quotes->where('status', 'rejected');
        }
        $my_quotes = $my_quotes->get();
        $subQuery = \DB::table('quote_by_transpoters')
            ->select('user_quote_id', \DB::raw('COUNT(*) as quotes_count'), \DB::raw('MIN(transporter_payment) as lowest_bid'))
            ->groupBy('user_quote_id');
        $quotes = UserQuote::query();
        $quotes = UserQuote::query()
            ->join('quote_by_transpoters', 'user_quotes.id', '=', 'quote_by_transpoters.user_quote_id')
            ->joinSub($subQuery, 'sub', function ($join) {
                $join->on('user_quotes.id', '=', 'sub.user_quote_id');
            })
            ->join('threads', function ($join) use ($user_data) {
                $join->on('user_quotes.id', '=', 'threads.user_quote_id')
                    ->where('threads.friend_id', '=', $user_data->id);
            })
            ->whereIn('user_quotes.id', $my_quotes->pluck('user_quote_id'))
            ->where('quote_by_transpoters.user_id', $user_data->id)
            ->whereDate('user_quotes.created_at', '>=', now()->subDays(10))
            ->groupBy('user_quotes.id') // Use groupBy to avoid duplicates
            ->select('user_quotes.*', 'quote_by_transpoters.id as quote_by_transporter_id', 'quote_by_transpoters.transporter_payment as transporter_payment', 'sub.quotes_count', 'sub.lowest_bid', 'threads.id as thread_id', 'quote_by_transpoters.updated_at as qbt_updated_at', 'quote_by_transpoters.status as qbt_status');

        // Order by created_at descending for bidding to show newest first
        // dd($quotes->get());
        if ($type == 'bidding' || $type == 'all') {
            $quotes = $quotes->where('user_quotes.status', '!=', 'cancelled')
                ->orderBy('quote_by_transpoters.created_at', 'desc');
        }
        if ($search) {
            $quotes = $quotes->where(function ($query) use ($search) {
                $query->where('pickup_postcode', 'like', '%' . $search . '%')->orWhere('drop_postcode', 'like', '%' . $search . '%');
            });
        }
        $quotes = $quotes->paginate(50);
        // return  $quotes;
        //dd($quotes);
        $params['html'] = view('transporter.dashboard.partial.current_my_job', compact('quotes', 'type', 'is_dashboard'))->render();
        $params['type'] = $type;
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Job find successfully', 'data' => $params]);
        }
    }



    public function editQuoteAmount(Request $request)
    {
        $offer = $request->input('amount');
        if (!$offer || !is_numeric($offer)) {
            return response()->json(['status' => false, 'message' => 'Invalid amount']);
        }
        $user_data = Auth::guard('transporter')->user();
        $quote = UserQuote::find($request->quote_id);
        $customer_user = $quote->user;
        if ($quote) {
            $quoteDetails = calculateCustomerQuote((float) $offer);
            $quoteByTransporter = QuoteByTransporter::firstOrNew(['user_quote_id' => $quote->id, 'user_id' => $user_data->id]);
            // Store the old price before updating
            $oldPrice = $quoteByTransporter->price;
            $subjectoldPrice = number_format($oldPrice, 0, '.', ',');
            // Update the record with new quote details
            $quoteByTransporter->price = $quoteDetails['customer_quote'];
            $quoteByTransporter->status = 'pending';
            $quoteByTransporter->deposit = $quoteDetails['deposit'];
            $quoteByTransporter->transporter_payment = $quoteDetails['transporter_payment'];
            $quoteByTransporter->outbid_notified = 0;
            $quoteByTransporter->save();

            try {
                if ($quote->user->job_email_preference) {
                    // return "yesss";
                    $price_reduced = $quoteDetails['customer_quote'] < $oldPrice; // Flag to indicate if the price 
                    $mailSubject = ($price_reduced ? 'Transport Quote Reduced' : 'Transport Quote Increased') . ' from £' . $subjectoldPrice . ' to £' . $quoteDetails['customer_quote'] . ' to Deliver Your ' . $quoteByTransporter->quote->vehicle_make . ' ' . $quoteByTransporter->quote->vehicle_model;
                    if (!empty($quoteByTransporter->quote->vehicle_make_1) && !empty($quoteByTransporter->quote->vehicle_model_1)) {
                        $mailSubject .= ' / ' . $quoteByTransporter->quote->vehicle_make_1 . ' ' . $quoteByTransporter->quote->vehicle_model_1;
                    }
                    $maildata['email'] = $quote->user->email;
                    //$maildata['email'] ='subham.k@ptiwebtech.com';
                    $maildata['old_price'] = $oldPrice;
                    $maildata['new_price'] = $quoteDetails['customer_quote'];
                    $maildata['quote_id'] = $quote->id;
                    $user_data = Auth::guard('transporter')->user();
                    $maildata['transport_name'] = $user_data->username;
                    $maildata['price_reduced'] = $price_reduced;
                    $htmlContent = view('mail.General.reduced-quote-recieced', ['data' => $maildata])->render();
                    $this->emailService->sendEmail($maildata['email'], $htmlContent, $mailSubject);

                    create_notification(
                        $quote->user->id,
                        $user_data->id,
                        $request->quote_id,
                        'You have a new quote!',
                        $user_data->username . ' has sent you a quote for £' . $quoteDetails['customer_quote'],  // Message of the notification
                        'quote',
                    );
                } else {
                    Log::info('User with email ' . $quote->user->email . ' has opted out of receiving emails. Edit quotation email not sent.');
                }
                if ($customer_user->mobile && $customer_user->user_sms_alert > 0 && ($quoteDetails['customer_quote'] < $oldPrice)) {
                    $smS = "Transport Any Car:  Quote reduced from £$oldPrice to £" . $quoteDetails['customer_quote'] . " to deliver your $quote->vehicle_make $quote->vehicle_model. \n\n" . request()->getSchemeAndHttpHost() . "/quotes/$quote->id  \n" . " " . request()->getSchemeAndHttpHost() . "/manage_notification";
                    $this->sendSMS->sendSms($customer_user->mobile, $smS);
                }
            } catch (\Exception $ex) {
                Log::error('Error sending email: ' . $ex->getMessage());
            }
            // if (App::environment('production')) {
            //     $command = '/usr/local/bin/php /home/pfltvaho/public_html/artisan send:outbid-notifications ' . $request->quote_id . ' ' . $quoteDetails['transporter_payment'] . ' ' . $user_data->id;
            // } elseif ((App::environment('staging'))) {
            //     $command = '/usr/local/bin/php /home/pfltvaho/staging.transportanycar.com/artisan send:outbid-notifications ' . $request->quote_id . ' ' . $quoteDetails['transporter_payment'] . ' ' . $user_data->id;
            // } else {
            //     $command = '/usr/bin/php /var/www/laravel/car-app/artisan send:outbid-notifications ' . $request->quote_id . ' ' . $quoteDetails['transporter_payment'] . ' ' . $user_data->id;
            // }
            // exec($command, $output, $returnVar);

            // if ($returnVar !== 0) {
            //     // Handle the error based on the return code
            //     Log::error('Error running send:outbid-notifications command. Return code: ' . $returnVar);
            // }

            Artisan::call('send:outbid-notifications', [
                'quote_id' => $request->quote_id,
                'transporter_payment' => $quoteDetails['transporter_payment'],
                'transporter_id' => $user_data->id,
                ]);
            return response()->json(['status' => true, 'message' => 'Quote amount updated successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Quote not found']);
        }
    }

    public function quoteChangeStatus(Request $request)
    {
        $user_data = Auth::guard('transporter')->user();
        $quote = QuoteByTransporter::where(['user_quote_id' => $request->quote_id, 'user_id' => $user_data->id])->first();
        if ($request->ajax()) {
            $quote->update(['status' => $request->status]);
            return response()->json(['success' => true, 'message' => 'Quote ' . $request->status . ' successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'something went wrong!.. Please try again']);
        }
    }

    public function notificationStatus(Request $request)
    {
        $user_data = Auth::guard('transporter')->user();
        if ($request->type == 'message') {
            Notification::where([
                'user_id' => $user_data->id,
                'reference_id' => $request->quote_id,
                'type' => 'message',
            ])->update(['seen' => 0]);
        } elseif ($request->type == 'feedback') {
            Notification::where([
                'user_id' => $user_data->id,
                'type' => 'feedback'
            ])->update(['seen' => 0]);
        } elseif ($request->type == 'won_job') {
            Notification::where([
                'user_id' => $user_data->id,
                'user_quote_id' => $request->quote_id,
                'type' => 'won_job'
            ])->update(['seen' => 0]);
        } elseif ($request->type == 'outbid') {
            Notification::where([
                'user_id' => $user_data->id,
                'user_quote_id' => $request->quote_id,
                'type' => 'outbid'
            ])->update(['seen' => 0]);
        }
        return response()->json(['success' => true,]);
    }
    public function howItWorks(Request $request)
    {

        return view('transporter.howItWorks.index');
    }

    public function logout()
    {
        $name = getDashboardRouteName();
        Auth::guard('transporter')->logout();
        return redirect()->route($name);
    }
    //d4dDeveloper-r 07/10/2024
    public function saveSearch(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'pick_area' => [
                    'required',
                    Rule::unique('save_searches')->where(function ($query) use ($request) {
                        $query->where('drop_area', $request->drop_area)
                            ->where('user_id', Auth::id());
                    }),
                ],
                'drop_area' => 'required',
            ], [
                'pick_area.unique' => 'The combination of pick area and drop area already exists for your account.',
            ]);

            if ($validator->fails()) {
                return response(["success" => false, "message" => "The combination of pick area and drop area already exists for your account.", "data" => $validator->errors()]);
            }
            $pickupCoordinates = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address' => $request->pick_area,
                'key' => config('constants.google_map_key'),
            ])->json();

            // Extract pickup coordinates
            $pickupLat = $pickupCoordinates['results'][0]['geometry']['location']['lat'] ?? null;
            $pickupLng = $pickupCoordinates['results'][0]['geometry']['location']['lng'] ?? null;

            if (!$pickupLat || !$pickupLng) {
                return response()->json(['success' => false, 'message' => 'Failed to fetch pickup coordinates.']);
            }

            // If drop_area is "anywhere" or null, skip Google Maps API and set default coordinates
            if (strtolower($request->drop_area) === 'anywhere' || $request->drop_area === null) {
                $dropLat = null;  // You can set this to any default value like 0 if needed
                $dropLng = null;  // You can set this to any default value like 0 if needed
            } else {
                // Fetch coordinates for drop area using Google Maps API
                $dropCoordinates = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                    'address' => $request->drop_area,
                    'key' => config('constants.google_map_key'),
                ])->json();

                // Extract drop coordinates
                $dropLat = $dropCoordinates['results'][0]['geometry']['location']['lat'] ?? null;
                $dropLng = $dropCoordinates['results'][0]['geometry']['location']['lng'] ?? null;

                // Validate if coordinates were fetched successfully for drop
                if (!$dropLat || !$dropLng) {
                    return response()->json(['success' => false, 'message' => 'Failed to fetch drop coordinates.']);
                }
            }

            $saveSearch = SaveSearch::Create(
                [
                    "user_id" => auth()->user()->id,
                    "search_name" => $request->search_name,
                    "pick_area" => $request->pick_area,
                    "drop_area" => $request->drop_area ?? "Anywhere",
                    "pick_lat" => $pickupLat,    // Use coordinates from Google API
                    "pick_lng" => $pickupLng,    // Use coordinates from Google API
                    "drop_lat" => $dropLat,      // Use coordinates from Google API or default
                    "drop_lng" => $dropLng,      // Use coordinates from Google API or default
                    "email_notification" => $request->emailNtf, // Convert to integer (1 or 0)
                ]
            );

            return response(["success" => true, "message" => "Search saved successfully!", "data" => []]);
        } catch (\Exception $ex) {
            return response(["success" => false, "message" => $ex->getMessage(), "data" => []]);
        }
    }
    // public function saveSearchView()
    // {
    //     $data = SaveSearch::where('user_id', auth()->user()->id)->paginate(50);
    //     $data->getCollection()->transform(function ($search) {
    //         $quote = UserQuote::where('pickup_postcode', "Like", "%" . $search->pick_area . "%");
    //         if ($search->drop_area != "Anywhere" && $search->drop_area != null) {
    //             $quote->where('drop_postcode', "like", "%" . $search->drop_area . "%");
    //         }
    //         $search->quote_count = $quote->count();
    //         return $search;
    //     });
    //     // return $data;
    //     return view('transporter.savedSearch.index', ['savedSearches' => $data]);
    // }

    public function saveSearchView(Request $request)
    {
        try {
            // Retrieve paginated saved search data
            $data = SaveSearch::where('user_id', auth()->user()->id)->paginate(50);
            // Transform each search item to include a correct quote count
            $data->getCollection()->transform(function ($search) {
                // Define coordinates and distance range
                $maxDistance = config('constants.max_range_km');
                $user_data = Auth::guard('transporter')->user();
                $my_quote_ids = QuoteByTransporter::where('user_id', $user_data->id)->pluck('user_quote_id');

                // Fetch pickup coordinates
                $pickUpResponse = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                    'address' => $search->pick_area,
                    'key' => config('constants.google_map_key'),
                ]);
                $pickUpData = $pickUpResponse->json();
                if ($pickUpData['status'] !== 'OK') {
                    $search->quote_count = 0; // Return zero if coordinates not found
                    return $search;
                }
                $pick_up_latitude = $pickUpData['results'][0]['geometry']['location']['lat'];
                $pick_up_longitude = $pickUpData['results'][0]['geometry']['location']['lng'];

                // Fetch drop-off coordinates if specified
                $drop_off_latitude = null;
                $drop_off_longitude = null;
                if (!empty($search->drop_area) && $search->drop_area !== 'Anywhere') {
                    $dropOffResponse = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                        'address' => $search->drop_area,
                        'key' => config('constants.google_map_key'),
                    ]);
                    $dropOffData = $dropOffResponse->json();
                    if ($dropOffData['status'] === 'OK') {
                        $drop_off_latitude = $dropOffData['results'][0]['geometry']['location']['lat'];
                        $drop_off_longitude = $dropOffData['results'][0]['geometry']['location']['lng'];
                    }
                }

                // Build the query to count quotes based on multiple criteria
                $quoteQuery = UserQuote::query()
                    // ->join('users', 'users.id', '=', 'user_quotes.user_id')
                    // ->leftJoin('quote_by_transpoters', function ($join) {
                    //     $join->on('quote_by_transpoters.user_quote_id', '=', 'user_quotes.id')
                    //         ->where('quote_by_transpoters.user_id', auth()->id());
                    // })
                    // ->whereNotIn('user_quotes.id', $my_quote_ids)
                    ->where(function ($query) {
                        $query->where('user_quotes.status', 'pending')
                            ->orWhere('user_quotes.status', 'approved');
                    })
                    ->whereDate('user_quotes.created_at', '>=', now()->subDays(10));

                // Apply distance calculations
                if ($drop_off_latitude) {
                    $quoteQuery->select(
                        \DB::raw("(6371 * acos(cos(radians($pick_up_latitude)) * cos(radians(pickup_lat)) * cos(radians(pickup_lng) - radians($pick_up_longitude)) + sin(radians($pick_up_latitude)) * sin(radians(pickup_lat)))) AS distance_pickup"),
                        \DB::raw("(6371 * acos(cos(radians($drop_off_latitude)) * cos(radians(drop_lat)) * cos(radians(drop_lng) - radians($drop_off_longitude)) + sin(radians($drop_off_latitude)) * sin(radians(drop_lat)))) AS distance_drop_off")
                    )
                        ->having('distance_pickup', '<=', $maxDistance)
                        ->having('distance_drop_off', '<=', $maxDistance);
                } else {
                    $quoteQuery->select(
                        \DB::raw("(6371 * acos(cos(radians($pick_up_latitude)) * cos(radians(pickup_lat)) * cos(radians(pickup_lng) - radians($pick_up_longitude)) + sin(radians($pick_up_latitude)) * sin(radians(pickup_lat)))) AS distance_pickup")
                    )
                        ->having('distance_pickup', '<=', $maxDistance);
                }

                // Calculate and set the count for this search
                $search->quote_count = $quoteQuery->count();

                return $search;
            });

            return view('transporter.savedSearch.index', ['savedSearches' => $data]);
        } catch (\Exception $ex) {
            return response(["success" => false, "message" => $ex->getMessage(), "data" => []]);
        }
    }



    public function saveSearchDlt(Request $request)
    {
        try {
            if ($request->id) {
                $data = SaveSearch::find($request->id);
                $data->delete();
                return redirect()->back()->with('saveSearchSuccess', 'Item deleted successfully');
            }
            return redirect()->back();
        } catch (\Exception $ex) {
            return response(["success" => false, "message" => $ex->getMessage(), "data" => []]);
        }
    }
    public function savesearchredirect(Request $request)
    {
        try {
            return view('transporter.savedSearch.result', ["pick_area" => $request->pick_area, "drop_area" => $request->drop_area]);
            // return $request->all();
        } catch (\Exception $ex) {
            return response(["success" => false, "message" => $ex->getMessage(), "data" => []]);
        }
    }

    public function savedFindJob(Request $request)
    {
        try {
            $saveSearch = SaveSearch::find($request->id);
            $pickup = $saveSearch->pick_area;
            $dropoff = $saveSearch->drop_area;
            return response()->json([
                'success' => true,
                'redirect_url' => route('transporter.savedFindJobResults', [
                    'pickup' => $pickup,
                    'dropoff' => $dropoff
                ])
            ]);
        } catch (\Exception $ex) {
            return response(["success" => false, "message" => $ex->getMessage(), "data" => []]);
        }
    }
    public function savedFindJobResults(Request $request)
    {
        try {
            if (empty($request->pickup)) {
                return response()->json(['success' => false, 'message' => 'Currently no jobs to show']);
            }

            $pickUpResponse = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address' => $request->pickup,
                'key' => config('constants.google_map_key'),
            ]);
            $pickUpData = $pickUpResponse->json();
            if ($pickUpData['status'] === 'OK') {
                $pick_up_latitude = $pickUpData['results'][0]['geometry']['location']['lat'];
                $pick_up_longitude = $pickUpData['results'][0]['geometry']['location']['lng'];
            } else {
                return response()->json(['success' => false, 'message' => 'Currently no jobs to show']);
            }
            $drop_off_latitude = null;
            $drop_off_longitude = null;
            if ($request->dropoff && $request->dropoff != 'Anywhere') {
                $dropOffResponse = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                    'address' => $request->dropoff,
                    'key' => config('constants.google_map_key'),
                ]);
                $dropOffData = $dropOffResponse->json();
                if ($dropOffData['status'] === 'OK') {
                    $drop_off_latitude = $dropOffData['results'][0]['geometry']['location']['lat'];
                    $drop_off_longitude = $dropOffData['results'][0]['geometry']['location']['lng'];
                } else {
                    return response()->json(['success' => false, 'message' => 'Currently no jobs to show']);
                }
            }

            $maxDistance = config('constants.max_range_km');
            $user_data = Auth::guard('transporter')->user();
            $my_quotes = QuoteByTransporter::where('user_id', $user_data->id)->get();

            $my_quote_ids = $my_quotes->pluck('user_quote_id');

            $subQuery = UserQuote::query()
                ->join('users', 'users.id', '=', 'user_quotes.user_id')
                ->leftJoin('quote_by_transpoters', function ($join) {
                    $join->on('quote_by_transpoters.user_quote_id', '=', 'user_quotes.id')
                        ->whereRaw('quote_by_transpoters.user_id = ?', [auth()->id()]); // Use DB::raw with a where condition
                })
                // ->whereNotIn('user_quotes.id', $my_quote_ids)
                ->where(function ($query) {
                    $query->where('user_quotes.status', 'pending')
                        ->orWhere('user_quotes.status', 'approved');
                })
                ->whereDate('user_quotes.created_at', '>=', now()->subDays(10));
            if ($drop_off_latitude) {
                $subQuery->select(
                    'quote_by_transpoters.user_id as tranporterId',
                    'user_quotes.*',
                    'users.profile_image',
                    'users.username as name',
                    'users.address',
                    'users.town',
                    'users.county',
                    \DB::raw("( 6371 * acos( cos( radians($pick_up_latitude) ) * cos( radians( pickup_lat ) ) * cos( radians( pickup_lng ) - radians($pick_up_longitude) ) + sin( radians($pick_up_latitude) ) * sin( radians( pickup_lat ) ) ) ) AS distance_pickup"),
                    \DB::raw("( 6371 * acos( cos( radians($drop_off_latitude) ) * cos( radians( drop_lat ) ) * cos( radians( drop_lng ) - radians($drop_off_longitude) ) + sin( radians($drop_off_latitude) ) * sin( radians( drop_lat ) ) ) ) AS distance_drop_off"),
                    \DB::raw("COUNT(quote_by_transpoters.id) as quotes_count"), // Count the number of quotes by transporters
                    // \DB::raw("MIN(quote_by_transpoters.transporter_payment) as lowest_bid"), // Get the lowest bid
                    DB::raw("(CASE 
                WHEN (SELECT user_id FROM watchlists WHERE user_quote_id = user_quotes.id AND user_id = $user_data->id LIMIT 1) IS NOT NULL THEN 1 ELSE 0 END) AS watchlist_id")
                )
                    ->having('distance_pickup', '<=', $maxDistance)
                    ->having('distance_drop_off', '<=', $maxDistance);
            } else {
                $subQuery->select(
                    'quote_by_transpoters.user_id as tranporterId',
                    'user_quotes.*',
                    'users.profile_image',
                    'users.username as name',
                    'users.address',
                    'users.town',
                    'users.county',
                    \DB::raw("( 6371 * acos( cos( radians($pick_up_latitude) ) * cos( radians( pickup_lat ) ) * cos( radians( pickup_lng ) - radians($pick_up_longitude) ) + sin( radians($pick_up_latitude) ) * sin( radians( pickup_lat ) ) ) ) AS distance_pickup"),
                    \DB::raw("COUNT(quote_by_transpoters.id) as quotes_count"), // Count the number of quotes by transporters
                    // \DB::raw("MIN(quote_by_transpoters.transporter_payment) as lowest_bid"), // Get the lowest bid
                    DB::raw("(CASE 
                WHEN (SELECT user_id FROM watchlists WHERE user_quote_id = user_quotes.id AND user_id = $user_data->id LIMIT 1) IS NOT NULL THEN 1 ELSE 0 END) AS watchlist_id")
                )
                    ->having('distance_pickup', '<=', $maxDistance);
            }

            // $subQuery->groupBy('user_quotes.id')
            //     ->latest();
            $subQuery
                ->addSelect([
                    'transporter_quotes_count' => QuoteByTransporter::selectRaw('COUNT(*)')
                        ->whereColumn('user_quote_id', 'user_quotes.id'),
                    'lowest_bid' => QuoteByTransporter::selectRaw('MIN(CAST(transporter_payment AS UNSIGNED))')
                        ->whereColumn('user_quote_id', 'user_quotes.id')
                ])
                ->groupBy('user_quotes.id')
                ->latest();

            $quotes = \DB::table(\DB::raw("({$subQuery->toSql()}) as sub"))
                ->mergeBindings($subQuery->getQuery())
                ->paginate(20);

            // return $quotes;


            $pickup = $request->pickup;
            $dropoff = $request->dropoff;
            return view('transporter.savedSearch.search_result', [
                'quotes' => $quotes,
                'pickup' => $pickup,
                'dropoff' => $dropoff
            ]);
        } catch (\Exception $ex) {
            return response(["success" => false, "message" => $ex->getMessage(), "data" => []]);
        }
    }
    public function manageNotification(Request $request)
    {
        try {
            $user = Auth::guard('transporter')->user();
            return view('transporter.dashboard.notifications.manageNotification', [
                'data' => $user,
            ]);
        } catch (\Exception $ex) {
            return response(["success" => false, "message" => $ex->getMessage(), "data" => []]);
        }
    }
    public function updateManageNotification(Request $request)
    {
        try {
            $request->validate([
                'summary_of_leads' => 'nullable|boolean',
                'outbid_email_unsubscribe' => 'nullable|boolean',
                'saved_search_alerts' => 'nullable|boolean',
                'new_job_alert' => 'nullable|boolean',
            ]);

            // Update user preferences
            try {
                $user = Auth::user();
                $user->summary_of_leads = $request->input('summary_of_leads', 0);
                $user->outbid_email_unsubscribe = $request->input('outbid_email_unsubscribe', 0);
                $user->job_email_preference = $request->input('saved_search_alerts', 0);
                $user->new_job_alert = $request->input('new_job_alert', 0);

                $user->save();

                return response()->json(['success' => true, 'message' => 'Preferences updated successfully.']);
            } catch (\Exception $e) {
                // Log the error for debugging
                Log::error('Error updating preferences: ' . $e->getMessage());
                return response()->json(['success' => false, 'message' => 'Could not update preferences.'], 500);
            }
        } catch (\Exception $ex) {
            return response(["success" => false, "message" => $ex->getMessage(), "data" => []]);
        }
    }
    public function jobInformation(Request $request, $id)
    {
        try {
            // return $id;+
            // return url()->previous();
            $user_data = \Auth::guard('transporter')->user();
            $quote = UserQuote::with([
                'watchlist',
                'quoteByTransporter' => function ($query) use ($user_data) {
                    $query->where('user_id', $user_data->id); // Assuming 'transporter_id' is the field
                }
            ])->where(function ($query) {
                $query->where('status', 'pending')
                    ->orWhere('status', 'approved');
            })
                ->whereDate('created_at', '>=', now()->subDays(10))
                ->addSelect([
                    'transporter_quotes_count' => QuoteByTransporter::selectRaw('COUNT(*)')
                        ->whereColumn('user_quote_id', 'user_quotes.id'),
                    'lowest_bid' => QuoteByTransporter::selectRaw('MIN(CAST(transporter_payment AS UNSIGNED))')
                        ->whereColumn('user_quote_id', 'user_quotes.id')
                ])
                ->find($id);
           
            $quotes = QuoteByTransporter::where('user_quote_id', $id)
                ->orderByRaw('(user_id = ?) DESC', [auth()->id()]) // Place matching user_id records at the top
                ->orderByRaw('CAST(price AS UNSIGNED) ASC') // Then sort the rest by price
                ->get();
            // return $quotes;
            

            $quotes = $quotes->map(function ($quote) {
                $my_quotes = QuoteByTransporter::where('user_id', $quote->user_id)->pluck('id');
                $rating_average = Feedback::whereIn('quote_by_transporter_id', $my_quotes)
                    ->whereNotNull('rating')
                    ->avg('rating');
                $percentage = $rating_average !== null ? ($rating_average / 5) * 100 : 0;
                $quote->rating_average = $rating_average;
                $quote->percentage = $percentage;
                return $quote;
            });
            // return $quotes;


            // Update quotes with thread_id if the thread exists
            $threads = Thread:: with(['messages' => function ($query) {
                $query->orderBy('created_at', 'asc');  // Order messages by 'created_at' in descending order
            }])
            ->where(['user_id' => $quote->user_id, 'user_quote_id' => $id])
            ->get();
           
            $quotes->map(function ($quote) use ($threads) {
                $matchingThread = $threads->firstWhere('friend_id', $quote->user_id);
                if ($matchingThread) {
                    $quote->messages = $matchingThread->messages;
                    $quote->count_messages = count($matchingThread->messages);
                } else {
                    $quote->messages = null;
                }

                return $quote;
            });
            $scroll = $request->has('scroll') ? $request->query('scroll') : null;

        return view('transporter.dashboard.job_infromation', [
            'quote' => $quote,
            'quotebytransporters' => $quotes,
            'scroll' => $scroll // Pass scroll parameter to view
            
        ]);
           
        } catch (\Exception $ex) {
            return response(["success" => false, "message" => $ex->getMessage(), "data" => []]);
        }
    }
}
