@extends('backend.layouts.app')
@section('title','Withdraw List')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Withdraw List</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Withdraw List</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <table id="table" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>{{_translate('SL')}}</th>
                <th>{{_translate('Name')}}</th>
                <th>{{(__('Email'))}}</th>
                <th>{{_translate('Amount')}}</th>
                <th>{{_translate('Created Date')}}</th>
                <th>{{_translate('Status')}}</th>
                <th>{{_translate('Action')}}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data['withdraw'] as $item)
              <tr>
                <td>{{__(@$item->id) }}</td>
                <td>{{__(@$item->user->name) }}</td>
                <td>{{__(@$item->user->email) }}</td>
                <td>{{__(single_price(@$item->amount)) }}</td>
                <td>{{ main_date_format(@$item->created_date) }}</td>
                <td>
                  @if($item->status == 1)
                  {{_translate('Approved')}}
                  @elseif($item->status == 2)
                  {{_translate('Rejected')}}
                  @else
                  {{_translate('Pending')}}
                  @endif
                </td>
                <td>
                  <div class="flex-nowrap">
                    <div class="dropdown">
                      <button class="btn btn-white dropdown-toggle align-text-top" data-boundary="viewport"
                        data-toggle="dropdown">Actions</button>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{route('withdraw.show', $item->id)}}">
                          View
                        </a>
                        @can('Withdraw Approve')
                        @if($item->status == 0)
                        <button class="dropdown-item" onclick="Approve('{{$item->id}}',`dashboard/withdraw-approve/`);">
                          Approve
                        </button>
                        <button class="dropdown-item" onclick="Reject('{{$item->id}}',`dashboard/withdraw-reject/`);">
                          Reject
                        </button>
                        @endif
                        @if($item->status == 1)
                        <button class="dropdown-item" onclick="Reject('{{$item->id}}',`dashboard/withdraw-reject/`);">
                          Reject
                        </button>
                        @endif
                        @if($item->status == 2)
                        <button class="dropdown-item" onclick="Approve('{{$item->id}}',`dashboard/withdraw-approve/`);">
                          Approve
                        </button>
                        @endif

                        @endcan
                        <button class="dropdown-item"
                          onclick="__globalDelete('{{$item->id}}',`dashboard/withdraw-delete/`);">
                          Delete
                        </button>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              @endforeach


            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
@push('js')
@include('backend.partials.datatable')
@endpush

@section('script')
<script src="{{ asset('public/backend/js/_payment.js') }}"></script>
@endsection