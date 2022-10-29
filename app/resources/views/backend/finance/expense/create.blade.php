@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ @$data['title'] }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.dashboard') }}">{{ _translate('Dashboard') }}</a></li>
                            @if (@$data['list_url'])
                                <li class="breadcrumb-item"><a
                                        href="{{ @$data['list_url'] }}">{{ _trans('common.List') }}</a>
                                </li>
                            @endif
                            <li class="breadcrumb-item active">{{ @$data['title'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">

                            <div class="card-body">


                                <form action="{{ $data['url'] }}" enctype="multipart/form-data" method="post"
                                    id="attendanceForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('common.Category') }}</label>
                                                <select name="category" class="form-control select2">
                                                    @foreach ($data['category'] as $account)
                                                        <option
                                                            {{ @$data['edit'] ? (@$data['edit']->income_expense_category_id == $account->id ? 'selected' : '') : '' }}
                                                            value="{{ $account->id }}">{{ $account->name }}</option>
                                                    @endforeach

                                                </select>
                                                @if ($errors->has('category'))
                                                    <div class="error">{{ $errors->first('category') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('common.Date') }}</label>
                                                <input type="date" name="date" class="form-control"
                                                    value="{{ @$data['edit'] ? $data['edit']->date : date('Y-m-d') }}"
                                                    required placeholder="2000.00">
                                                @if ($errors->has('date'))
                                                    <div class="error">{{ $errors->first('date') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('account.Amount') }}</label>
                                                <input type="number" name="amount" class="form-control"
                                                    value="{{ @$data['edit'] ? $data['edit']->amount : old('amount') }}"
                                                    required placeholder="500">
                                                @if ($errors->has('amount'))
                                                    <div class="error">{{ $errors->first('amount') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="">{{ _trans('account.Reference') }}</label>
                                                <input type="text" name="ref" class="form-control"
                                                    value="{{ @$data['edit'] ? $data['edit']->ref : old('ref') }}"
                                                    placeholder="{{ _trans('account.Enter Reference') }}">
                                                @if ($errors->has('ref'))
                                                    <div class="error">{{ $errors->first('ref') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="{{ $data['edit'] ?? 'cus-label' }}">{{ _trans('account.Attachment') }}</label>
                                                <input type="file" name="attachment" class="form-control" {{$data['edit'] ?? 'required' }}>
                                                @if ($errors->has('attachment'))
                                                    <div class="error">{{ $errors->first('attachment') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="cus-label">{{ _trans('common.Description') }}</label>
                                                <textarea type="text" name="description" rows="5" class="form-control" placeholder="{{ _trans('common.Enter Description') }}"
                                                    required>{{ @$data['edit'] ? $data['edit']->remarks : old('description') }}</textarea>
                                                @if ($errors->has('description'))
                                                    <div class="error">{{ $errors->first('description') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @if (@$data['url'])
                                        <div class="row  mt-20">
                                            <div class="col-md-12">
                                                <div class="text-right">
                                                    <button class="btn btn-primary">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif


                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <input type="hidden" id="get_user_url" value="{{ route('user.getUser') }}">
@endsection
