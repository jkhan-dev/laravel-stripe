@include('layout/header')
@includeWhen(Auth::user() != null,'layout/aside')
@includeWhen(Auth::user() != null,'layout/nav')
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible text-white fade show " role="alert">
        <ul style="list-style: none;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if (session('success') || session('failure'))
<div style="display: flex;justify-content: space-between;" class="alert text-white alert-{{(session()->has('success') ? 'success': 'danger')}}">
    <span>    
        <?=  session()->has('failure') ? session('failure') : session('success') ?>
    </span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
   
</button></div>
@endif

<div class="wrapper" style="min-height: 100vh !important;">
    @yield('content')
</div>
@include('layout/footer')
