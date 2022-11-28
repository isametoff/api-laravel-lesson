<div class="row mb-0">
    <div class="col-md-6 offset-md-4">
        <h3>Click the Link To Verify Your Email</h3>
        Click on the link to get a new email link,
        @if ()

        <a type="submit" class="btn btn-primary" href="{{ url('/api/repeatverifyemail/') }}">
            'click here'
        </a>
        @else
        <a type="submit" class="btn btn-primary" href="{{ url('/api/repeatverifyemail/') }}">
            'click here'
        </a>
        @endif
    </div>
</div>
