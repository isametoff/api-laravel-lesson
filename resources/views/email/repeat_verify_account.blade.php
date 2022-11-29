<div class="row mb-0">
    <div class="col-md-6 offset-md-4">
        <h3>Click the Link To Repeat Verify Your Email</h3>
        Click on the link to get a new email link,
        <br>
        {{$userId}}
        <form method="POST" action="{{ route('account.repeatverify') }}">
            @csrf
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <input type="hidden" name="userId" value="{{ $userId }}" />
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
