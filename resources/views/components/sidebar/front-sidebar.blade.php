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
            <x-sidebar.sidebar-item icon="login" :active="request()->routeIs('auth.login')" route="{{ route('auth.login') }}">
                Login
            </x-sidebar.sidebar-item>
        @endguest

        <x-sidebar.sidebar-item icon="home" :active="request()->routeIs('home')" route="{{ route('home') }}">
            Home
        </x-sidebar.sidebar-item>

        <x-sidebar.sidebar-item icon="title" route="mywords" :active="request()->routeIs('mywords')">
            My Words
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

    </ul>
</nav>
