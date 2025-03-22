@if (Auth::check() && Auth::user()->hasRole('admin'))
    <x-sidebar.admin-sidebar />
@else
    <x-sidebar.front-sidebar />
@endif
