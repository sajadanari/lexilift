{{--
/**
 * Main Sidebar Navigation Component
 *
 * Primary navigation sidebar that contains the application logo and
 * main navigation items. Supports both single items and dropdown menus.
 *
 * @component FrontSidebar
 *
 * @example
 * <x-sidebar.front-sidebar />
 */
--}}

<nav id="sidebar">
    <ul>

        <li>
            <span class="logo">
                LexiLift
            </span>
            <button id="toggle-btn" onClick="toggleSidebar()">
                <i class="material-icons-outlined">keyboard_double_arrow_left</i>
            </button>
        </li>

        @guest
            <x-sidebar.sidebar-item icon="login" :active="request()->routeIs('login')" route="{{ route('login') }}">
                Login
            </x-sidebar.sidebar-item>
        @endguest

        @auth
            <x-sidebar.sidebar-item icon="person" :active="request()->routeIs('dashboard')" route="{{ route('dashboard') }}">
                {{ Auth::user()->name }}
            </x-sidebar.sidebar-item>

            {{-- Show Role --}}
            @if (config('app.env') === 'local')
                <x-sidebar.sidebar-item route="#">
                    Role: {{ implode(', ', Auth::user()->roles->pluck('local_name')->toArray()) }}
                </x-sidebar.sidebar-item>
            @endif
        @endauth

        <x-sidebar.sidebar-item icon="home" :active="request()->routeIs('home')" route="{{ route('home') }}">
            Home
        </x-sidebar.sidebar-item>

        <x-sidebar.sidebar-item icon="title" route="mywords" :active="request()->routeIs('mywords')">
            My Words
        </x-sidebar.sidebar-item>

        <x-sidebar.sidebar-item icon="visibility" route="review" :active="request()->routeIs('review')">
            Review
        </x-sidebar.sidebar-item>

        <x-sidebar.sidebar-item icon="settings" dropdown="true" :submenuItems="[
            ['icon' => 'person', 'route' => '/', 'name' => 'Profile'],
            ['icon' => 'account_box', 'route' => '/', 'name' => 'Account'],
        ]">
            Settings
        </x-sidebar.sidebar-item>

        <x-sidebar.sidebar-item icon="help" dropdown="true" :submenuItems="[['icon' => 'person', 'route' => '/', 'name' => 'Profile']]">
            Help
        </x-sidebar.sidebar-item>

        @auth
            <x-sidebar.sidebar-item
                icon="logout"
                route="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </x-sidebar.sidebar-item>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        @endauth

    </ul>
</nav>
