<div x-data="{ open: false }" class="relative inline-block text-left">
    <div>
        <button @click="open = ! open" type="button"
            class="inline-flex items-center justify-center gap-x-1.5 rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
            id="menu-button" aria-expanded="true" aria-haspopup="true">
            Login
            <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                data-slot="icon">
                <path fill-rule="evenodd"
                    d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    <!-- Dropdown menu -->
    <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white/80 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
        role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" style="display: none;">
        <div class="py-1" role="none">
            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                id="menu-item-1">Teacher</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                id="menu-item-2">Student</a>
            @auth
                <form method="POST" action="#" role="none">
                    <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-gray-700" role="menuitem"
                        tabindex="-1" id="menu-item-3">Sign out</button>
                </form>
            @endauth
        </div>
    </div>
</div>
