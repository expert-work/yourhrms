@extends('backend.layouts.app')
@section('title','Expense Head')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Expense Head</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Expense Head</li>
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
                <th>{{_translate('Date')}}</th>
                <th>{{_translate('Action')}}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data['expense_head'] as $key => $item)
              <tr>
                <td>{{__(@$key+1) }}</td>
                <td>{{__(Str::limit(@$item->name, 25, '...')) }}</td>
                <td>{{ main_date_format(@$item->created_at) }}</td>
                <td>
                  <div class="flex-nowrap">
                    <div class="dropdown">
                      <button class="btn btn-white dropdown-toggle align-text-top" data-boundary="viewport"
                        data-toggle="dropdown">Actions</button>
                      <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" onclick="ViewNotice('{{$item->id}}',`/dashboard/expense-head/`)">
                          View
                        </button>
                        <a class="dropdown-item" href="{{route('expense-head.edit', $item->id)}}">
                          Edit
                        </a>
                        <button class="dropdown-item"
                          onclick="__globalDelete('{{$item->id}}',`dashboard/expense-heads/delete/`);">
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

@section('scripts')
<script src="{{ asset('public/backend/js/_payment.js') }}"></script>
@endsection
