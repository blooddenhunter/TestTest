<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal">
        <a href="{{ route('home') }}">Test</a>
    </h5>
    <nav class="my-2 my-md-0 mr-md-3">

    </nav>
    @if (Auth::check())
        <a class="btn btn-outline-primary" href="{{ route('logout') }}">Logout</a>
    @else
        <a class="btn btn-outline-primary" href="{{ route('login') }}">Sign up</a>
    @endif
</div>