<div class="modal  fade lead-modal in" id="lead-modal" role="dialog" aria-labelledby="myLargeModalLabel"
    style="display: block;">
    <div class="modal-dialog">
        <div class="modal-content data">
            <div class="modal-header text-center" style="background: #001f3f">
                <h5 class="modal-title text-white">{{ @$data['title'] }} </h5>
                <button type="button" class="close text-white" onclick="modalClose(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" />
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="row p-5">
                    <div class="col-md-12">
                        <form action="{{ $data['url'] }}" method="POST">
                            @csrf
                            <div class="form-group">
                                {{ Form::label('Amount', 'Amount', ['class' => 'form-label required']) }}
                                <input type="number" class="form-control" min="0" step=any name="amount"
                                    id="Amount" autocomplete="off" value="{{ $data['advance']->due_amount }}" />
                            </div>
                            <div class="form-group">
                                <label class="cus-label">{{ _trans('common.Category') }}</label>
                                <select name="category" class="form-control select2">
                                    @foreach ($data['category'] as $account)
                                        <option
                                            {{ @$data['edit'] ? (@$data['edit']->income_expense_category_id == $account->id ? 'selected' : '') : '' }}
                                            value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                <label class="cus-label">{{ _trans('common.Account') }}</label>
                                <select name="account" class="form-control select2">
                                    @foreach ($data['accounts'] as $account)
                                        <option
                                            {{ @$data['edit'] ? (@$data['edit']->account_id == $account->id ? 'selected' : '') : '' }}
                                            value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                <label class="cus-label">{{ _trans('account.Payment Method') }}</label>
                                <select name="payment_method" class="form-control select2" required>
                                    @foreach ($data['payment_method'] as $payment_method)
                                        <option value="{{ $payment_method->id }}">{{ $payment_method->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="cus-label">{{ _trans('common.Note') }}</label>
                                <textarea type="text" name="description" rows="5" class="form-control"
                                    placeholder="{{ _trans('common.Enter payment note') }}" required>{{ old('description') }}</textarea>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit"
                                    class="btn btn-primary pull-right"><b>{{ _trans('Submit') }}</b></button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('select').select2({
        placeholder: 'Choose one',
    })
</script>
