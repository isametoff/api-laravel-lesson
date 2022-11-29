<h3>Click the Link To Verify Your Email</h3>
To confirm your Email,

<form target="_blank" method="POST" action="{{ route('account.verify')}}">
    @csrf
    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <input type="hidden" name="email_token" value="{{ $email_token }}" />
            <button type="submit" class="btn btn-primary">
                {{ __('Submit') }}
            </button>
        </div>
    </div>
</form>