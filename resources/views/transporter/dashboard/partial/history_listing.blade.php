<?php
$user = $thread->user_qot->user ? $thread->user_qot->user : null;
$auth_user = Auth::user();
?>
<style>
.transportor-chat-header {
    font-size: 14px;
    line-height: 18px;
    font-weight: 300;
    color:#000000;
    gap: 10px;
}
.chat-note {
    font-size: 10px;
    line-height: 13px;
    font-weight: 500;
    color:#444444;
    padding: 15px;
    display: none;
}
.chat_outgoing_txt.chat_out_txt_bx {margin-bottom: 5px;}
@media screen and (max-width: 575px) {
        #messages .navbar {
            box-shadow: none;
        }

        .chat-note {
            display: block
        }
    }
</style>
@if (isset($user) && !empty($user))
    <div class="chat_conversation_header">
        <a href="javascript:;" class="chat_back_arrow">
            <svg width="7" height="10" viewBox="0 0 7 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M6.03125 8.53906C6.03125 8.92448 5.97135 9.11719 5.85156 9.11719C5.78906 9.11719 5.70052 9.06771 5.58594 8.96875L0.695312 5.17969C0.570312 5.08594 0.507812 4.96615 0.507812 4.82031C0.507812 4.6901 0.570312 4.57031 0.695312 4.46094L5.58594 0.671875C5.70052 0.572917 5.78906 0.523438 5.85156 0.523438C5.97135 0.523438 6.03125 0.716146 6.03125 1.10156C6.02604 1.19531 5.97135 1.28125 5.86719 1.35938L1.46875 4.82031L5.86719 8.28125C5.96094 8.35938 6.01562 8.44531 6.03125 8.53906Z"
                    fill="black" />
            </svg>
        </a>
        <div class="conversation_user transportor-chat-header d-flex  align-items-center text-left">
            <div style="border-radius:5px; overflow: hidden; flex: 1 0 80px;">
                @if ($quote->image == NULL)
                <img src="{{ asset('uploads/no_car_image.png') }}" alt="" width="80" height="50"
                style="max-width: 100%;" />
                @else
                
                    <img src="{{ $quote->image }}" alt="" width="80" height="50"
                    style="max-width: 100%;" />
                 @endif  
            </div>
            <div>
                <h3>
                    @if ($quote->vehicle_make)
                        {{ $quote->vehicle_make }} {{ $quote->vehicle_model }}
                  
                    @endif
                </h3>
                <ul>
                    <li>
                        <svg width="10" height="16" viewBox="0 0 16 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.00002 0.16C7.5361 0.15999 7.16001 0.536063 7.16 0.999982C7.15999 1.4639 7.53606 1.83999 7.99998 1.84L8.00002 0.16ZM10.6782 1.5264L10.9964 0.748992L10.9961 0.748881L10.6782 1.5264ZM13.8198 4.08L13.1238 4.5503L13.1243 4.55106L13.8198 4.08ZM15 7.916H15.84L15.84 7.91465L15 7.916ZM12.949 12.8062L12.271 12.3103C12.2608 12.3243 12.251 12.3386 12.2417 12.3531L12.949 12.8062ZM10.9162 15.98L10.2088 15.5269L10.2059 15.5316L10.9162 15.98ZM8 20.6L7.2901 21.049C7.44414 21.2926 7.71225 21.4401 8.0004 21.44C8.28855 21.4399 8.55652 21.292 8.71033 21.0484L8 20.6ZM5.0838 15.9898L5.79371 15.5407L5.79151 15.5373L5.0838 15.9898ZM3.051 12.8104L3.75871 12.3579C3.74942 12.3434 3.73969 12.3291 3.72952 12.3152L3.051 12.8104ZM1 7.9202L0.16 7.91937V7.9202H1ZM2.1802 4.08L2.87569 4.55106L2.87573 4.551L2.1802 4.08ZM5.3218 1.5306L5.63951 2.3082L5.64092 2.30762L5.3218 1.5306ZM8.00124 1.84C8.46516 1.83932 8.84068 1.46268 8.84 0.998763C8.83932 0.534845 8.46268 0.159318 7.99876 0.160001L8.00124 1.84ZM8 9.38182C7.53608 9.38182 7.16 9.7579 7.16 10.2218C7.16 10.6857 7.53608 11.0618 8 11.0618V9.38182ZM8 4.77022C7.53608 4.77022 7.16 5.1463 7.16 5.61022C7.16 6.07414 7.53608 6.45022 8 6.45022V4.77022ZM8.02068 11.07C8.48445 11.0585 8.85116 10.6733 8.83973 10.2095C8.82829 9.74574 8.44306 9.37903 7.97928 9.39046L8.02068 11.07ZM5.95582 9.09437L6.67981 8.66841L5.95582 9.09437ZM5.95582 6.75585L5.23184 6.32989L5.95582 6.75585ZM7.97928 6.45975C8.44306 6.47119 8.82829 6.10449 8.83973 5.64071C8.85116 5.17693 8.48446 4.7917 8.02068 4.78026L7.97928 6.45975ZM7.99998 1.84C8.8094 1.84002 9.61108 1.99759 10.3603 2.30392L10.9961 0.748881C10.0451 0.360035 9.02746 0.160022 8.00002 0.16L7.99998 1.84ZM10.36 2.30381C11.4829 2.76336 12.4445 3.54504 13.1238 4.5503L14.5158 3.6097C13.6508 2.32959 12.4262 1.3342 10.9964 0.748992L10.36 2.30381ZM13.1243 4.55106C13.7974 5.54482 14.1581 6.7171 14.16 7.91735L15.84 7.91465C15.8375 6.37945 15.3762 4.88002 14.5153 3.60894L13.1243 4.55106ZM14.16 7.916C14.16 8.72866 14.0336 9.33192 13.7568 9.95594C13.4676 10.608 13.0038 11.3082 12.271 12.3103L13.627 13.3021C14.3614 12.298 14.9231 11.4701 15.2926 10.6371C15.6745 9.77608 15.84 8.93734 15.84 7.916H14.16ZM12.2417 12.3531L10.2089 15.5269L11.6235 16.4331L13.6563 13.2593L12.2417 12.3531ZM10.2059 15.5316L7.28967 20.1516L8.71033 21.0484L11.6265 16.4284L10.2059 15.5316ZM8.7099 20.151L5.7937 15.5408L4.3739 16.4388L7.2901 21.049L8.7099 20.151ZM5.79151 15.5373L3.75871 12.3579L2.34329 13.2629L4.37609 16.4423L5.79151 15.5373ZM3.72952 12.3152C2.99627 11.3105 2.5324 10.6102 2.24307 9.95836C1.96633 9.33489 1.84 8.73275 1.84 7.9202H0.16C0.16 8.94165 0.325572 9.7794 0.707534 10.6399C1.0769 11.4721 1.63853 12.2999 2.37248 13.3056L3.72952 12.3152ZM1.84 7.92103C1.84119 6.71953 2.20189 5.54586 2.87569 4.55106L1.48471 3.60894C0.622887 4.88135 0.161527 6.38255 0.16 7.91937L1.84 7.92103ZM2.87573 4.551C3.55555 3.54711 4.51715 2.76676 5.63951 2.3082L5.00409 0.752999C3.57488 1.33694 2.35036 2.33063 1.48467 3.609L2.87573 4.551ZM5.64092 2.30762C6.38988 2.00002 7.19157 1.84119 8.00124 1.84L7.99876 0.160001C6.97101 0.161514 5.95338 0.363125 5.00268 0.75358L5.64092 2.30762ZM8 11.0618C9.12389 11.0618 10.1624 10.4622 10.7243 9.48892L9.26942 8.64892C9.00758 9.10244 8.52368 9.38182 8 9.38182V11.0618ZM10.7243 9.48892C11.2863 8.5156 11.2863 7.31643 10.7243 6.34312L9.26942 7.18312C9.53126 7.63664 9.53126 8.1954 9.26942 8.64892L10.7243 9.48892ZM10.7243 6.34312C10.1624 5.3698 9.12389 4.77022 8 4.77022V6.45022C8.52368 6.45022 9.00758 6.7296 9.26942 7.18312L10.7243 6.34312ZM7.97928 9.39046C7.44715 9.40358 6.94973 9.12719 6.67981 8.66841L5.23184 9.52033C5.81113 10.5049 6.87865 11.0981 8.02068 11.07L7.97928 9.39046ZM6.67981 8.66841C6.40989 8.20964 6.40989 7.64058 6.67981 7.18181L5.23184 6.32989C4.65254 7.31448 4.65254 8.53574 5.23184 9.52033L6.67981 8.66841ZM6.67981 7.18181C6.94973 6.72303 7.44715 6.44664 7.97928 6.45975L8.02068 4.78026C6.87865 4.75212 5.81113 5.34529 5.23184 6.32989L6.67981 7.18181Z"
                                fill="#52D017"></path>
                        </svg>
                        <span class="ml-1">{{$quote->pickup_postcode ? hidePostcode(get_last_two_parts($quote->pickup_postcode)): '-' }}</span>
                    </li>
                    <li>
                        <svg width="10" height="16" viewBox="0 0 16 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.00002 0.16C7.5361 0.15999 7.16001 0.536063 7.16 0.999982C7.15999 1.4639 7.53606 1.83999 7.99998 1.84L8.00002 0.16ZM10.6782 1.5264L10.9964 0.748992L10.9961 0.748881L10.6782 1.5264ZM13.8198 4.08L13.1238 4.5503L13.1243 4.55106L13.8198 4.08ZM15 7.916H15.84L15.84 7.91465L15 7.916ZM12.949 12.8062L12.271 12.3103C12.2608 12.3243 12.251 12.3386 12.2417 12.3531L12.949 12.8062ZM10.9162 15.98L10.2088 15.5269L10.2059 15.5316L10.9162 15.98ZM8 20.6L7.2901 21.049C7.44414 21.2926 7.71225 21.4401 8.0004 21.44C8.28855 21.4399 8.55652 21.292 8.71033 21.0484L8 20.6ZM5.0838 15.9898L5.79371 15.5407L5.79151 15.5373L5.0838 15.9898ZM3.051 12.8104L3.75871 12.3579C3.74942 12.3434 3.73969 12.3291 3.72952 12.3152L3.051 12.8104ZM1 7.9202L0.16 7.91937V7.9202H1ZM2.1802 4.08L2.87569 4.55106L2.87573 4.551L2.1802 4.08ZM5.3218 1.5306L5.63951 2.3082L5.64092 2.30762L5.3218 1.5306ZM8.00124 1.84C8.46516 1.83932 8.84068 1.46268 8.84 0.998763C8.83932 0.534845 8.46268 0.159318 7.99876 0.160001L8.00124 1.84ZM8 9.38182C7.53608 9.38182 7.16 9.7579 7.16 10.2218C7.16 10.6857 7.53608 11.0618 8 11.0618V9.38182ZM8 4.77022C7.53608 4.77022 7.16 5.1463 7.16 5.61022C7.16 6.07414 7.53608 6.45022 8 6.45022V4.77022ZM8.02068 11.07C8.48445 11.0585 8.85116 10.6733 8.83973 10.2095C8.82829 9.74574 8.44306 9.37903 7.97928 9.39046L8.02068 11.07ZM5.95582 9.09437L6.67981 8.66841L5.95582 9.09437ZM5.95582 6.75585L5.23184 6.32989L5.95582 6.75585ZM7.97928 6.45975C8.44306 6.47119 8.82829 6.10449 8.83973 5.64071C8.85116 5.17693 8.48446 4.7917 8.02068 4.78026L7.97928 6.45975ZM7.99998 1.84C8.8094 1.84002 9.61108 1.99759 10.3603 2.30392L10.9961 0.748881C10.0451 0.360035 9.02746 0.160022 8.00002 0.16L7.99998 1.84ZM10.36 2.30381C11.4829 2.76336 12.4445 3.54504 13.1238 4.5503L14.5158 3.6097C13.6508 2.32959 12.4262 1.3342 10.9964 0.748992L10.36 2.30381ZM13.1243 4.55106C13.7974 5.54482 14.1581 6.7171 14.16 7.91735L15.84 7.91465C15.8375 6.37945 15.3762 4.88002 14.5153 3.60894L13.1243 4.55106ZM14.16 7.916C14.16 8.72866 14.0336 9.33192 13.7568 9.95594C13.4676 10.608 13.0038 11.3082 12.271 12.3103L13.627 13.3021C14.3614 12.298 14.9231 11.4701 15.2926 10.6371C15.6745 9.77608 15.84 8.93734 15.84 7.916H14.16ZM12.2417 12.3531L10.2089 15.5269L11.6235 16.4331L13.6563 13.2593L12.2417 12.3531ZM10.2059 15.5316L7.28967 20.1516L8.71033 21.0484L11.6265 16.4284L10.2059 15.5316ZM8.7099 20.151L5.7937 15.5408L4.3739 16.4388L7.2901 21.049L8.7099 20.151ZM5.79151 15.5373L3.75871 12.3579L2.34329 13.2629L4.37609 16.4423L5.79151 15.5373ZM3.72952 12.3152C2.99627 11.3105 2.5324 10.6102 2.24307 9.95836C1.96633 9.33489 1.84 8.73275 1.84 7.9202H0.16C0.16 8.94165 0.325572 9.7794 0.707534 10.6399C1.0769 11.4721 1.63853 12.2999 2.37248 13.3056L3.72952 12.3152ZM1.84 7.92103C1.84119 6.71953 2.20189 5.54586 2.87569 4.55106L1.48471 3.60894C0.622887 4.88135 0.161527 6.38255 0.16 7.91937L1.84 7.92103ZM2.87573 4.551C3.55555 3.54711 4.51715 2.76676 5.63951 2.3082L5.00409 0.752999C3.57488 1.33694 2.35036 2.33063 1.48467 3.609L2.87573 4.551ZM5.64092 2.30762C6.38988 2.00002 7.19157 1.84119 8.00124 1.84L7.99876 0.160001C6.97101 0.161514 5.95338 0.363125 5.00268 0.75358L5.64092 2.30762ZM8 11.0618C9.12389 11.0618 10.1624 10.4622 10.7243 9.48892L9.26942 8.64892C9.00758 9.10244 8.52368 9.38182 8 9.38182V11.0618ZM10.7243 9.48892C11.2863 8.5156 11.2863 7.31643 10.7243 6.34312L9.26942 7.18312C9.53126 7.63664 9.53126 8.1954 9.26942 8.64892L10.7243 9.48892ZM10.7243 6.34312C10.1624 5.3698 9.12389 4.77022 8 4.77022V6.45022C8.52368 6.45022 9.00758 6.7296 9.26942 7.18312L10.7243 6.34312ZM7.97928 9.39046C7.44715 9.40358 6.94973 9.12719 6.67981 8.66841L5.23184 9.52033C5.81113 10.5049 6.87865 11.0981 8.02068 11.07L7.97928 9.39046ZM6.67981 8.66841C6.40989 8.20964 6.40989 7.64058 6.67981 7.18181L5.23184 6.32989C4.65254 7.31448 4.65254 8.53574 5.23184 9.52033L6.67981 8.66841ZM6.67981 7.18181C6.94973 6.72303 7.44715 6.44664 7.97928 6.45975L8.02068 4.78026C6.87865 4.75212 5.81113 5.34529 5.23184 6.32989L6.67981 7.18181Z"
                                fill="#ed1c24"></path>
                        </svg>
                        <span class="ml-1">{{$quote->drop_postcode ? hidePostcode(get_last_two_parts($quote->drop_postcode)) : '-' }}</span>
                    </li>
                </ul>
                {{-- <p>
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="5" cy="5" r="5" fill="#52D017"/>
                    </svg>
                    Online
                </p> --}}
            </div>
        </div>
    </div>
    {{-- old code --}}
    {{-- <div class="chat_conversation_body scrollbar chat_div" id="style-1">
        @if (isset($messages) && $messages->count() > 0)
            @foreach ($messages as $date => $message_date)
                @foreach ($message_date as $message)
                    <?php
                    $sender_user = $message->sender;
                    ?>
                    @if ($thread->friend_id != $message->sender_id)
                        <!-- incoming -->
                        <div class="chat_messages_incoming">
                            <div class="chat_conversation_bx">
                                <div class="chat_txt_bx">
                                    <h4>{{ $user->username }}</h4>
                                    <div class="chat_incoming_txt">
                                        <p>{{ $message->message }}</p>
                                        <!-- <span class="chat_time">{{ carbon\carbon::parse($message->created_at)->diffForHumans() }}</span> -->
                                        <span class="chat_time">
                                            @if (carbon\carbon::parse($message->created_at)->diffInHours() < 24)
                                                {{ carbon\carbon::parse($message->created_at)->format('h:i A') }}
                                            @else
                                                {{ carbon\carbon::parse($message->created_at)->diffForHumans() }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- outgoing -->
                        <div class="chat_messages_outgoing">
                            <div class="chat_conversation_bx">
                                <div class="chat_out_txt_bx">
                                    <h4>You Hello</h4>
                                    <div class="chat_outgoing_txt">
                                        <!-- <p>{{ $message->message }}</p> -->
                                        <p>{!! nl2br(e($message->message)) !!}</p>
                                        <!-- <span class="chat_time">{{ carbon\carbon::parse($message->created_at)->diffForHumans() }}</span> -->
                                        <span class="chat_time">
                                            @if (carbon\carbon::parse($message->created_at)->diffInHours() < 24)
                                                {{ carbon\carbon::parse($message->created_at)->format('h:i A') }}
                                            @else
                                                {{ carbon\carbon::parse($message->created_at)->diffForHumans() }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endforeach
        @endif
    </div> --}}
    {{-- new code working fine --}}
    <div class="chat_conversation_body scrollbar chat_div" id="style-1">
        @if (isset($messages) && $messages->count() > 0)
            @php
                $previousSender = null; // Variable to keep track of the last message sender
            @endphp
            @foreach ($messages as $date => $message_date)
                @foreach ($message_date as $message)
                    @php
                        $sender_user = $message->sender;
                    @endphp

                    @if ($thread->friend_id != $message->sender_id)
                        <!-- incoming messages -->

                        <div class="chat_messages_incoming mb-0">
                            <div class="chat_conversation_bx">
                                <div class="chat_txt_bx">
                                    @if ($previousSender !== $message->sender_id)
                                        <h4>{{ $user->username }}</h4>
                                        <!-- Display only once for consecutive messages -->
                                    @endif
                                    <div class="chat_incoming_txt">
                                        <p>{{ $message->message }}</p>
                                        <span class="chat_time">
                                            @if (carbon\carbon::parse($message->created_at)->diffInHours() < 24)
                                                {{ carbon\carbon::parse($message->created_at)->format('h:i A') }}
                                            @else
                                                {{ carbon\carbon::parse($message->created_at)->diffForHumans() }}
                                            @endif
                                        </span>
                                    </div>
                                    {{-- @if ($loop->last || $message_date[$loop->index + 1]->sender_id !== $message->sender_id) --}}
                                </div>
                            </div>
                        </div>
                        {{-- @endif --}}
                    @else
                        <!-- outgoing messages -->

                        <div class="chat_messages_outgoing mb-0">
                            <div class="chat_conversation_bx">
                                <div class="chat_out_txt_bx">
                                    @if ($previousSender !== $message->sender_id)
                                        <h4>You</h4> <!-- Display only once for consecutive messages -->
                                    @endif
                                    <div class="chat_outgoing_txt">
                                        <p>{!! nl2br(e($message->message)) !!}</p>
                                        <span class="chat_time">
                                            @if (carbon\carbon::parse($message->created_at)->diffInHours() < 24)
                                                {{ carbon\carbon::parse($message->created_at)->format('h:i A') }}
                                            @else
                                                {{ carbon\carbon::parse($message->created_at)->diffForHumans() }}
                                            @endif
                                        </span>
                                    </div>
                                    {{-- @if ($loop->last || $message_date[$loop->index + 1]->sender_id !== $message->sender_id) --}}
                                </div>
                            </div>
                        </div>
                        {{-- @endif --}}
                    @endif
                    @php
                        $previousSender = $message->sender_id; // Update the previous sender tracker
                    @endphp
                @endforeach
            @endforeach
            <input type="hidden" id="last_message_sender" value="{{ $previousSender }}">
        @endif
    </div>


    <div class="chat_conversation_footer">
        <p class="font-weight-light d-flex flex-wrap align-items-center text-left d-sm-none position-relative" style="font-size:12px; padding-left:40px; line-height:13px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none" class="position-absolute" style="left:20px; top:0;">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.95833 8.70834V10.2917C3.95833 12.915 6.08498 15.0417 8.70833 15.0417H10.2917C12.915 15.0417 15.0417 12.915 15.0417 10.2917V8.70834C15.0417 6.08499 12.915 3.95834 10.2917 3.95834H8.70833C6.08498 3.95834 3.95833 6.08499 3.95833 8.70834Z" stroke="#444444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M8.75 12.6667C8.75 13.0809 9.08579 13.4167 9.5 13.4167C9.91421 13.4167 10.25 13.0809 10.25 12.6667H8.75ZM9.5 8.70834H10.25C10.25 8.29413 9.91421 7.95834 9.5 7.95834V8.70834ZM8.70833 7.95834C8.29412 7.95834 7.95833 8.29413 7.95833 8.70834C7.95833 9.12256 8.29412 9.45834 8.70833 9.45834V7.95834ZM9.5 13.4167C9.91421 13.4167 10.25 13.0809 10.25 12.6667C10.25 12.2525 9.91421 11.9167 9.5 11.9167V13.4167ZM8.70833 11.9167C8.29412 11.9167 7.95833 12.2525 7.95833 12.6667C7.95833 13.0809 8.29412 13.4167 8.70833 13.4167V11.9167ZM9.5 11.9167C9.08579 11.9167 8.75 12.2525 8.75 12.6667C8.75 13.0809 9.08579 13.4167 9.5 13.4167V11.9167ZM10.2917 13.4167C10.7059 13.4167 11.0417 13.0809 11.0417 12.6667C11.0417 12.2525 10.7059 11.9167 10.2917 11.9167V13.4167ZM10.25 6.33334C10.25 5.91913 9.91421 5.58334 9.5 5.58334C9.08579 5.58334 8.75 5.91913 8.75 6.33334H10.25ZM8.75 7.12501C8.75 7.53922 9.08579 7.87501 9.5 7.87501C9.91421 7.87501 10.25 7.53922 10.25 7.12501H8.75ZM10.25 12.6667V8.70834H8.75V12.6667H10.25ZM9.5 7.95834H8.70833V9.45834H9.5V7.95834ZM9.5 11.9167H8.70833V13.4167H9.5V11.9167ZM9.5 13.4167H10.2917V11.9167H9.5V13.4167ZM8.75 6.33334V7.12501H10.25V6.33334H8.75Z" fill="#444444"/>
            </svg>
             You will receive the user contact details after they accept your quote.
        </p>
        <form id="chat__form" action="{{ route('transporter.message.store', $thread->user_quote_id) }}" method="post"
            enctype='multipart/form-data'>
            @csrf
            <div class="form-group">
                <div class="msg-send_flex">
                    <!-- <a href="javascript:;" class="option_btn">
                        <svg width="4" height="22" viewBox="0 0 4 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="2" cy="2" r="2" fill="#9A9A9A"/>
                            <circle cx="2" cy="11" r="2" fill="#9A9A9A"/>
                            <circle cx="2" cy="20" r="2" fill="#9A9A9A"/>
                        </svg>
                    </a> -->
                    <textarea type="text" class="form-control textarea" id="message" placeholder="Write your message..."></textarea>
                    <a href="javascript:;" class="wd-send-btn" onclick="sendMessage();" id="send_message">
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12.8821 24.3168H12.8128C12.4662 24.2822 12.189 24.0742 12.085 23.7624L9.48604 15.9307L1.27317 13.3317C0.961288 13.2277 0.718714 12.9505 0.68406 12.604C0.649407 12.2574 0.822674 11.9455 1.13456 11.8069L23.1049 0.821773C23.4167 0.648506 23.7979 0.717814 24.0751 0.960388C24.3177 1.20296 24.387 1.58415 24.2484 1.93068L13.6098 23.8317C13.4712 24.1436 13.194 24.3168 12.8821 24.3168ZM3.73357 12.3267L10.387 14.4406C10.6296 14.5099 10.8375 14.7178 10.9068 14.9604L13.0207 21.2673L21.6841 3.35148L3.73357 12.3267Z"
                                fill="#52D017" />
                        </svg>
                    </a>
                </div>
            </div>
            <input type="hidden" value="{{ $transaction }}" id="transactionValid">
        </form>
        <p class="chat-note text-left font-weight-normal position-relative" style="font-size:12px; padding-left:40px;">
            <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg" class="position-absolute" style="left:20px; top:12px;">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5631 12.2653L10.9587 4.78559C10.655 4.27279 10.1032 3.95831 9.50721 3.95831C8.91121 3.95831 8.35943 4.27279 8.05569 4.78559L3.45057 12.2653C3.10235 12.8105 3.07241 13.5003 3.37208 14.0737C3.67176 14.647 4.25525 15.0163 4.90169 15.0416H14.1119C14.7584 15.0163 15.3419 14.647 15.6416 14.0737C15.9412 13.5003 15.9113 12.8105 15.5631 12.2653Z" stroke="#5B5B5B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9.50682 10.2916V6.33329" stroke="#5B5B5B" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M9.50682 12.6666V11.875" stroke="#5B5B5B" stroke-width="1.5" stroke-linecap="round"/>
            </svg>              
            Do not share any contact details here. We will provide you with the users contact details after they have accepted your quote.            {{-- Note: Users are required to accept your quote online via this platform and then we will exchange your
            contact details so that you can finalise the delivery. --}}
        </p>
    </div>
@endif
<div class="chat_messages_outgoing d-none mb-0" id="send_message_main">
    <div class="chat_conversation_bx message-data">
        <div class="chat_out_txt_bx">
            <h4>You</h4>
            <div class="chat_outgoing_txt message other-message">
                <span class="chat_time message-data-time"></span>
            </div>
        </div>
    </div>
</div>



<script>
    var send_message = false;

    function uploadImageA(thisobj) {
        send_message = true;
        $("#file_type").val("image");
        $("#image-upload1").prop("accept", "image/*");
        $("#image-upload1").click();
    }

    function uploadVideo(thisobj) {
        send_message = true;
        $("#file_type").val("video");
        $("#image-upload1").prop("accept", "video/mp4,video/x-m4v,video/*");
        $("#image-upload1").click();
    }

    function uploadAudio(thisobj) {
        send_message = true;
        $("#file_type").val("audio");
        $("#image-upload1").prop("accept", "audio/mp3");
        $("#image-upload1").click();
    }

    function sendMessage() {
        $('#chat__form').submit();
    }

    function isEmptyOrSpaces(str) {
        return str === null || str.match(/^ *$/) !== null;
    }
    $(function() {
        $('#image-upload1').change(function() {
            //if(videoPreview == true){
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $("#image_previe_main").addClass("d-none");
                    $("#audio_preview").addClass("d-none");
                    $("#video_preview").addClass("d-none");
                    if ($("#file_type").val() == "image") {
                        $("#image_previe_main").removeClass("d-none");
                        $("#image_previe_main").html('<div><img id="imgPreview" src="' + event
                            .target.result +
                            '" width="100" height="100"></img></div><div><a onclick="removeImageFile(this);" href="javascript:;">remove</a></div>'
                        );
                    }
                    if ($("#file_type").val() == "audio") {
                        $("#audio_preview").removeClass("d-none");
                        $("#audio_preview").html('<audio controls><source src="' + event.target
                            .result +
                            '" type="audio/mpeg"></audio><div><a onclick="removeAudioFile(this);" href="javascript:;">remove</a></div></div>'
                        );
                    }
                    if ($("#file_type").val() == "video") {
                        $("#video_preview").removeClass("d-none");
                        $("#video_preview").html('<video width="250" controls><source src="' + event
                            .target.result +
                            '" type="video/mp4"></video><div><a onclick="removeFile(this);" href="javascript:;">remove</a></div></div>'
                        );
                    }


                }
                reader.readAsDataURL(file);
            }
            //}
        });
        // old code
        // $('#chat__form').on('submit', function(e) {
        //     e.preventDefault();
        //     var chat_id = $('#trans_current_chat_id').val();
        //     var file_name = $("#image-upload1").val();
        //     var message = $('.textarea').val();
        //     var contains_email = /\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\b/i.test(message);
        //     var contains_digit = /\d/.test(message);
        //     if (!message.trim()) {
        //         toastr.error("Message cannot be empty.");
        //         return;
        //     }
        //     if (contains_email || contains_digit) {
        //         toastr.error("Do not share contact information or you will be banned.")
        //         return;
        //     }
        //     var send_message = false;
        //     if (file_name != "") {
        //         send_message = true;
        //     }
        //     if (!isEmptyOrSpaces(message)) {
        //         send_message = true;
        //     }
        //     if (send_message == true) {
        //         $("#send_message").prop("disabled", "true");
        //         //$("#send_message").text("Please Wait...");

        //         var file_type = $('#file_type').val();
        //         $('.textarea').val('');

        //         $.ajaxSetup({
        //             headers: {
        //                 'X-CSRF-TOKEN': $('input[name="_token"]').val()
        //             }
        //         });
        //         var timezone = moment.tz.guess();
        //         var data = new FormData(this);
        //         data.append('message', message);
        //         data.append('file_type', file_type);
        //         data.append('current_chat_id', chat_id)
        //         data.append('timezone', timezone);

        //         $.ajax({
        //             url: $(this).attr('action'),
        //             method: "POST",
        //             data: data,
        //             //data:{message_text:message},
        //             dataType: 'json',
        //             contentType: false,
        //             cache: false,
        //             processData: false,
        //         }).done(function(response) {
        //             $("#image-upload1").val("");
        //             $("#image_previe_main").addClass("d-none");
        //             $("#audio_preview").addClass("d-none");
        //             $("#video_preview").addClass("d-none");

        //             $("#send_message").prop("disabled", false);
        //             // $("#send_message").text("Send");
        //             if (response.status == "success") {
        //                 var data = response.data;
        //                 var message_clone = $("#send_message_main").clone();
        //                 message_clone.removeClass("d-none");
        //                 message_clone.find(".message-data-time").html(data.create_message);
        //                 if (data.type == "file") {
        //                     if (data.file_type == "audio") {
        //                         message_clone.find('.message').html(
        //                             '<div><audio controls><source src="' + data.file +
        //                             '" type="audio/mpeg"></audio></div></div>')
        //                     } else if (data.file_type == "video") {
        //                         message_clone.find('.message').html(
        //                             '<div><video width="250" controls><source src="' + data
        //                             .file + '" type="video/mp4"></video></div></div>')
        //                     } else {
        //                         message_clone.find('.message').html(
        //                             '<div><img width="200px;" src="' + data.file +
        //                             '" alt="avatar"><div></div></div>')
        //                     }
        //                 } else {
        //                     var createdAt = data.created_at;
        //                     var parsedCreatedAt = new Date(createdAt);
        //                     var formattedCreatedAt = moment(parsedCreatedAt).fromNow();
        //                     // Convert newline characters to <br> tags for the message
        //                     var formattedMessage = data.message.replace(/\r\n|\n/g, '<br>');
        //                     message_clone.find('.message').html('<p>' + formattedMessage +
        //                         '</p><span class="chat_time">' + formattedCreatedAt +
        //                         '</span>')
        //                 }
        //                 $('.chat_div').append(message_clone);
        //             }
        //             scrollToBottom();
        //             $(".kt-avatar__cancel").click();
        //         }).fail(function(xhr) {
        //             if (xhr.status === 422) {
        //                 var errors = xhr.responseJSON.errors;
        //                 if (errors.message) {
        //                     toastr.error(
        //                         "Do not share contact information or you will be banned.");
        //                 }
        //             }
        //             $("#send_message").prop("disabled",
        //             false); // Re-enable the button in case of error
        //         });
        //     }

        // });

        //new code
        // console.log("///", $('#last_message_sender').val());
        $('#chat__form').on('submit', function(e) {
            e.preventDefault();

            var chat_id = $('#trans_current_chat_id').val();
            var file_name = $("#image-upload1").val();
            var message = $('.textarea').val();
            var contains_email = /\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\b/i.test(message);
            var contains_digit = /\d/.test(message);

            // Validation checks
            if (!message.trim()) {
                toastr.error("Message cannot be empty.");
                return;
            }
            var check = $("#transactionValid").val();
            if (check === "false") {
                if (contains_email || contains_digit) {
                    toastr.error("Do not share contact information or you will be banned.");
                    return;
                }
            }

            var send_message = false;
            if (file_name !== "") {
                send_message = true;
            }
            if (message.trim() !== "") {
                send_message = true;
            }

            // Proceed only if message or file is set to send
            if (send_message) {
                $("#send_message").prop("disabled", true);

                var file_type = $('#file_type').val();
                var lastMessageSender = $('#last_message_sender').val(); // Store the last sender
                // console.log("///", $('.chat_conversation_body .chat_messages_outgoing').last().data(
                    // 'sender-id'));
                $('.textarea').val(''); // Clear the textarea after fetching message

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });

                var timezone = moment.tz.guess();
                var data = new FormData(this);
                data.append('message', message);
                data.append('file_type', file_type);
                data.append('current_chat_id', chat_id);
                data.append('check', check);
                data.append('timezone', timezone);

                $.ajax({
                    url: $(this).attr('action'),
                    method: "POST",
                    data: data,
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                }).done(function(response) {
                    $("#image-upload1").val("");
                    $("#image_previe_main, #audio_preview, #video_preview").addClass("d-none");
                    $("#send_message").prop("disabled", false);

                    if (response.status === "success") {
                        var data = response.data;
                        console.log(data);
                        var message_clone = $("#send_message_main").clone();
                        message_clone.removeClass("d-none");

                      

                        // Check if the sender is the same as the last message sender
                        if (lastMessageSender == data.sender_id) {
                            message_clone.find("h4")
                        .remove(); // Remove the sender's name if the sender is the same

                        } else {

                            message_clone.find("h4").text(
                            'You'); // Add sender name if it's a different sender
                            lastMessageSender = data.sender_id; // Update the last sender
                            $("#last_message_sender").val(data.sender_id);
                        }

                        message_clone.find(".message-data-time").text(data.create_message);

                        if (data.type === "file") {
                            if (data.file_type === "audio") {
                                message_clone.find('.message').html(
                                    '<div><audio controls><source src="' + data.file +
                                    '" type="audio/mpeg"></audio></div>'
                                );
                            } else if (data.file_type === "video") {
                                message_clone.find('.message').html(
                                    '<div><video width="250" controls><source src="' + data
                                    .file + '" type="video/mp4"></video></div>'
                                );
                            } else {
                                message_clone.find('.message').html(
                                    '<div><img width="200px;" src="' + data.file +
                                    '" alt="avatar"></div>'
                                );
                            }
                        } else {
                            var createdAt = data.created_at;
                            var parsedCreatedAt = new Date(createdAt);
                            var formattedCreatedAt = moment(parsedCreatedAt).fromNow();
                            var formattedMessage = data.message.replace(/\r\n|\n/g, '<br>');
                            message_clone.find('.message').html('<p>' + formattedMessage +
                                '</p><span class="chat_time">' + formattedCreatedAt +
                                '</span>');
                        }

                        $('.chat_div').append(message_clone);
                        scrollToBottom();
                        $(".kt-avatar__cancel").click();
                    }
                }).fail(function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        if (errors.message) {
                            toastr.error(
                                "Do not share contact information or you will be banned.");
                        }
                    }
                    $("#send_message").prop("disabled",
                    false); // Re-enable the button in case of error
                });
            }
        });

    });

    function removeFile() {
        send_message = false;
        $("#image-upload1").val("");
        $("#video_preview").addClass("d-none");
    }

    function removeAudioFile() {
        send_message = false;
        $("#image-upload1").val("");
        $("#audio_preview").addClass("d-none");
    }

    function removeImageFile() {
        send_message = false;
        $("#image-upload1").val("");
        $("#image_previe_main").addClass("d-none");
    }

    $('#message').on('keydown paste input', function(event) {
        var check = $("#transactionValid").val();
        if (check === "false") {
            if (event.type === 'keydown' && event.key >= '0' && event.key <= '9') {
                event.preventDefault();
            }
            if (event.type === 'paste') {
                let pastedData = event.originalEvent.clipboardData.getData('text');
                if (/\d/.test(pastedData)) {
                    event.preventDefault();
                }
            }
            if (event.type === 'input') {
                let newValue = $(this).val().replace(/[0-9]/g, '');
                $(this).val(newValue);
            }
        }
    });
    $(document).ready(function() {
        $('body').addClass('message-color');
    })
</script>
