
@extends('backend.layouts.app')
@section('title','Expense-Head')
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@if(@$data['edit']) Edit @else Create @endif Expense-Head</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">@if(@$data['edit']) Edit @else Create @endif Expense-Head</li>
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
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                <!-- form start -->
                @if (@$data['edit'])
                    {{Form::open (['route' => ['expense-head.update', @$data['edit']->id] ,'class' => 'card', 'id' => 'portfolio-form', 'files' => 'true', 'method' => 'PUT'] )}}
                @else
                    {!! Form::open(['route' => 'expense-head.store', 'enctype' => 'multipart/form-data','method' => 'post', 'languages' => true, 'id' => 'portfolio-form']) !!}
                @endif
                  <div class="card-body">
                      <div class="row">
                          <div class="col-lg-6">
                            <div class="form-group">
                              {{Form::label('name','Name', ['class' => 'form-label required'])}}
                              {{Form::text('name',@$data['edit'] ? @$data['edit']->name :null, ['class' => 'form-control'])}}
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                              </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                                {{Form::label('status','Status', ['class' => 'form-label required'])}}
                                {{Form::select('status', [1 => 'Active',0 => 'Disable'], @$data['edit'] ? @$data['edit']->status: null,  ['class' => 'form-control select2'])}}

                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                              </div>
                          </div>
                      </div>


                  </div>
                  <div class="card-footer">
                    <a href="{{ url('dashboard/expense-head') }}" class="btn btn-default float-left">Back</a>
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                  </div>
                  {{Form::close()}}
              </div>

            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
  </div>

@endsection
@push('js')
@include('backend.partials.datatable')
@endpush

@section('scripts')
<script src="{{ asset('public/backend/js/_payment.js') }}"></script>
@endsection