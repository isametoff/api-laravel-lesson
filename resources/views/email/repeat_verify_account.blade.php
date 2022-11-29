<div class="row mb-0">
    <div class="col-md-6 offset-md-4">
        <h3>Click the Link To Repeat Verify Your Email</h3>
        Click on the link to get a new email link,
        <br>
        {{$userId}}
        <form method="GET" action="{{ route('account.repeatverify', [$userId]) }}">
            @csrf
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Submit') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
