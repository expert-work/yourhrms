@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')

    <div class="content-wrapper dashboard-wrapper mt-30">

        <!-- Main content -->
        <section class="content p-0">
            <div class="container-fluid table-filter-container border-radius-5 p-imp-30 table-responsive">

                <div class="row align-items-center mb-15">
                    <div class="col-sm-6">
                        <h5 class="fm-poppins m-0 text-dark">{{ @$data['title'] }}</h5>
                    </div>

                    <div class="col-sm-6">
                    </div>
                </div>
                <table class="table mb-0">
                    <thead>
                        <tr class="border-bottom">
                            <th>Message</th>
                            <th>Published at</th>
                            <th>{{ _trans('common.Action') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse (auth()->user()->unreadNotifications as $notification)
                        @php
                            $sender = App\Models\User::find($notification->data['sender_id']);
                        @endphp
                        <tr class="border-bottom" data-notification_row_id="{{$notification->id}}">
                            <td width="50%">
                                <a href="#" data-notification_id="{{$notification->id}}" class="d-flex justify-content-center align-items-center text-decoration-none text-secondary unread_notification_from_all">
                                    <i class="notification-icon fa fa-dropbox"> </i>
                                    {{-- {{ uploaded_asset($sender->avatar_id) }} --}}
                                    <div class="notification-content">
                                        <span class="notification-title font-weight-bold">{{@$notification->data['title']}}</span>
                                        <div class="muted">{!! @$notification->data['body']!!}</div>
                                    </div>
                                </a>

                            </td>
                            <td width="25%">
                                <div class="notification-time text-left">{{@$notification->created_at->diffForHumans()}}</div>
                            </td>
                            <td width="25%">
                                @if($notification->data['actionURL']['web']!=null) 
                                    <a  target="_blank" href="{{@$notification->data['actionURL']['web']}}" class="text-decoration-none">
                                        {{$notification->data['actionText']}}
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <div class="text-center">
                                        <h5 class="text-secondary">No Notification Found</h5>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        {{-- <tr class="border-bottom">
                                <td>
                                    <a href="/" class="d-flex justify-content-center align-items-center text-decoration-none text-secondary">
                                        <i class="notification-icon fa fa-dropbox"></i>
                                        <div class="notification-content">
                                            <span class="notification-title font-weight-bold">late incoming</span>
                                            <div class="muted truncate">today late 15 mins</div>
                                        </div>
                                    </a>

                                </td>
                                <td>
                                    <div class="notification-time text-left">12 min ago</div>
                                </td>
                                <td>
                                    <a href="/" class="text-decoration-none">
                                        <i class="notification-icon fa fa-pencil"></i>
                                    </a>
                                </td>
                        </tr> --}}

                        {{-- <tr class="border-bottom">
                                <td>
                                    <a href="/" class="d-flex justify-content-center align-items-center text-decoration-none text-secondary">
                                        <i class="notification-icon fa fa-dropbox"></i>
                                        <div class="notification-content">
                                            <span class="notification-title">late incoming</span>
                                            <div class="muted truncate">today late 15 mins</div>
                                        </div>
                                    </a>

                                </td>
                                <td>
                                    <div class="notification-time text-left">12 min ago</div>
                                </td>
                                <td>
                                    <a href="/" class="text-decoration-none">
                                        <i class="notification-icon fa fa-pencil"></i>
                                    </a>
                                </td>
                        </tr> --}}

                    </tbody>

                </table>
            </div>
        </section>
    </div>
    <input type="hidden" id="readNotification" value="{{ route('notification.readNotification') }}">
@endsection

@section('script')
    <script src="https://kit.fontawesome.com/d5b31bd2d2.js" crossorigin="anonymous"></script>
@endsection
