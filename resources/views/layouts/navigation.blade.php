<nav x-data="{ open: false }"
     class="bg-white/70 backdrop-blur border-b border-blue-100">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between h-16">

            <!-- LEFT SIDE -->
            <div class="flex items-center gap-8">

                <!-- LINKS -->
                <div class="hidden sm:flex gap-6 text-sm text-gray-600">

                    <x-nav-link :href="route('dashboard')"
                                :active="request()->routeIs('dashboard')"
                                class="hover:text-blue-600 transition">
                        Dashboard
                    </x-nav-link>

                </div>

            </div>

            <!-- RIGHT SIDE -->
            <div class="hidden sm:flex sm:items-center sm:gap-4">

                <!-- USER DROPDOWN -->
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 px-4 py-2 rounded-lg bg-white/60 border border-blue-100 hover:bg-white transition">

                            <div class="text-sm text-gray-700 font-medium">
                                {{ Auth::user()->nom }}
                            </div>

                            <svg class="w-4 h-4 text-gray-500"
                                 xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd" />
                            </svg>

                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <!-- LOGOUT -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault();
                                             this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>

                    </x-slot>

                </x-dropdown>
            </div>

            <!-- MOBILE -->
            <div class="sm:hidden flex items-center">

                <button @click="open = ! open"
                        class="p-2 rounded-md text-gray-500 hover:bg-blue-50">

                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open}" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open}" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>

                </button>

            </div>

        </div>
    </div>

    <!-- MOBILE MENU -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-blue-100">

        <div class="px-4 py-2 space-y-1">

            <x-responsive-nav-link :href="route('dashboard')"
                                   :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>

        </div>

        <div class="border-t border-blue-100 px-4 py-3">

            <div class="text-sm font-medium text-gray-700">
                {{ Auth::user()->nom }}
            </div>

            <div class="text-sm text-gray-500">
                {{ Auth::user()->email }}
            </div>

            <div class="mt-3 space-y-1">

                <x-responsive-nav-link :href="route('profile.edit')">
                    Profile
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault();
                                           this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>

                </form>

            </div>
        </div>

    </div>

</nav>