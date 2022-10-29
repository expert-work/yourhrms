@extends('backend.layouts.app')
@section('title','Withdraw')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Withdraw</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Withdraw</li>
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
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">{{ @$data['show']->title }}</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                  <div class="row">

                    <div class="col-12 col-sm-4">
                      <div class="info-box bg-light">
                        <div class="info-box-content">
                          <span class="info-box-text text-center text-muted">Status</span>
                          <span class="info-box-number text-center text-muted mb-0">
                            @if(@$data['show']->status == 1)
                            {{_translate('Approved')}}
                            @elseif(@$data['show']->status == 2)
                            {{_translate('Rejected')}}
                            @else
                            {{_translate('Pending')}}
                            @endif
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-12  order-1 text-center">
                      <br>
                      <div class="row">
                        <div class="col-lg-4">
                          <div class="text-muted">
                            <p class="text-sm">{{_translate('Name')}}
                              <b class="d-block">{{@$data['show']->user->name}}</b>
                            </p>
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <div class="text-muted">
                            <p class="text-sm">{{_translate('Email')}}
                              <b class="d-block">{{@$data['show']->user->email}}</b>
                            </p>
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <div class="text-muted">
                            <p class="text-sm">{{_translate('Role')}}
                              <b class="d-block">{{__(string_clean(@$data['show']->user->roles ->pluck('name'))) }}</b>
                            </p>
                          </div>
                        </div>
                      </div>



                    </div>
                    <div class="col-12 col-sm-4">
                      <div class="info-box bg-light">
                        <div class="info-box-content">
                          <span class="info-box-text text-center text-muted">Amount</span>
                          <span
                            class="info-box-number text-center text-muted mb-0">{{ single_price(@$data['show']->amount) }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-4">
                      <div class="info-box bg-light">
                        <div class="info-box-content">
                          <span class="info-box-text text-center text-muted">Created Date</span>
                          <span
                            class="info-box-number text-center text-muted mb-0">{{ main_date_format(@$data['show']->created_date) }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                  <div class="row">
                    <div class="col-12">
                      <h4>Note</h4>
                      <div class="post">
                        <p>
                          {!! @$data['show']->description !!}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <div class="text-center mt-5 mb-3">
              <a href="{{ url('dashboard/withdraw') }}" class="btn btn-sm btn-default">{{_translate('Back')}}</a>
            </div>
            <!-- /.card-body -->
          </div>

        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
</div>

@endsection
