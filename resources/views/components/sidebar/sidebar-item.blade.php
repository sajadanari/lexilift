{{--
/**
 * Sidebar Item Component
 *
 * A versatile sidebar item component that can render either a single link item
 * or a dropdown menu with multiple submenu items.
 *
 * @component SidebarItem
 *
 * @property {string|null} icon - Material icon name for the main item
 * @property {boolean} active - Whether the item is currently active
 * @property {string|null} route - URL for single items
 * @property {boolean} dropdown - Whether this item contains a submenu
 * @property {array} submenuItems - Array of submenu items with structure:
 *     @type {object} submenuItem
 *         @property {string} icon - Material icon name
 *         @property {string} route - URL for the submenu item
 *         @property {string} name - Display text
 *         @property {boolean} active - Whether this submenu item is active
 *
 * @example
 * <x-sidebar.sidebar-item
 *     icon="home"
 *     :active="true"
 *     route="/dashboard">
 *     Dashboard
 * </x-sidebar.sidebar-item>
 *
 * @example
 * <x-sidebar.sidebar-item
 *     icon="settings"
 *     dropdown="true"
 *     :submenuItems="[
 *         ['icon' => 'person', 'route' => '/profile', 'name' => 'Profile'],
 *         ['icon' => 'logout', 'route' => '/logout', 'name' => 'Logout']
 *     ]">
 *     Settings
 * </x-sidebar.sidebar-item>
 */
--}}

@props([
    'icon' => null,
    'active' => false,
    'route' => null,
    'dropdown' => false,
    'submenuItems' => [],
])

@if (!$dropdown)
    {{-- Render a single sidebar item as a link --}}
    <li class="sidebar-item {{ $active ? 'active' : '' }}">
        <a href="{{ $route }}" class="sidebar-link">
            @if ($icon)
                <i class="material-icons-outlined">{{ $icon }}</i>
            @endif
            <span>{{ $slot }}</span>
        </a>
    </li>
@else
    {{-- Render a dropdown sidebar item with submenu items provided as an array --}}
    <li class="sidebar-item dropdown">
        {{-- Button that triggers the dropdown submenu --}}
        <button type="button" class="sidebar-link dropdown-btn" onClick="toggleSubMenu(this)">
            <i class="material-icons-outlined">{{ $icon }}</i>
            <span>{{ $slot }}</span>
            <i class="material-icons-outlined">keyboard_arrow_down</i>
        </button>
        {{-- Submenu items list rendered using a foreach loop --}}
        <ul class="sub-menu {{ collect($submenuItems)->contains('active', true) ? 'show' : '' }}">
            <div>
                @foreach ($submenuItems as $item)
                    <li class="submenu-item {{ isset($item['active']) && $item['active'] ? 'active' : '' }}">
                        <a href="{{ $item['route'] }}">
                            @if (isset($item['icon']))
                                <i class="material-icons-outlined">{{ $item['icon'] }}</i>
                            @endif
                            <span>{{ $item['name'] }}</span>
                        </a>
                    </li>
                @endforeach
            </div>
        </ul>
    </li>
@endif
