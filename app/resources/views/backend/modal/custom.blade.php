<div class="lead-modal in custom-modal">
    <div class="modal-dialog">
        <div class="modal-content data">
            <div class="modal-header text-center" style="background: #001f3f">
                <h5 class="modal-title text-white">This is Title</h5>
                <button type="button" class="close text-white modal-toggle" onclick="modalClose(this)">
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

                        <p>
                            <strong>{{ _translate('Deal Amount') }}</strong> : 12000 Tk
                        </p>

                        <form method="POST">
                            @csrf
                            <input type="text" hidden name="balance" value="1200" />
                            <input type="text" hidden name="type" value="type" />
                            <div class="form-group">
                                {{ Form::label('payment_method', 'Payment Method', ['class' => 'form-label required']) }}
                                <select name="payment_method" class="form-control" required>
                                    <option value="Mama Mia">Mama Mia</option>
                                    <option value="Hell Yeah">Hell Yeah</option>
                                    <option value="Yooo Brooo">Yoo Broo</option>

                                </select>
                            </div>
                            <div class="form-group">
                                {{ Form::label('date', 'Payment Month', ['class' => 'form-label required']) }}
                                <input type="month" name="date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                {{ Form::label('amount', 'Pay', ['class' => 'form-label required']) }}
                                <input type="text" name="amount" class="form-control" required>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit"
                                    class="btn btn-primary pull-right"><b>{{ _translate('Submit') }}</b></button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
