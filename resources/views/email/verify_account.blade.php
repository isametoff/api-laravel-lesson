<h3>Click the Link To Verify Your Email</h3>
To confirm your Email,

<form target="_blank" method="GET" action="{{ route('account.verify', [$email_token]) }}">
    @csrf
    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Submit') }}
            </button>
        </div>
    </div>
</form>