<script setup>
import {ref} from 'vue';
import {Head, Link, router} from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import Menubar from "primevue/menubar";
import Button from "primevue/button";

defineProps({
    title: String,
});

const items = ref([
    {
        label: 'Dashboard',
        icon: 'pi pi-fw pi-home',
        url: '/dashboard'
    },
    {
        label: 'Abenteuer',
        icon: 'pi pi-fw pi-list',
        url: '/abenteuer'
    }
])

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title"/>

        <Banner/>

        <div class="min-h-screen">
            <nav class="border-b border-surface-100">
                <!-- Primary Navigation Menu -->
                <div class="my-4 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16 gap-10">
                        <div class="flex items-center w-full gap-10">
                            <div class="w-full bg-surface-100 dark:bg-surface-900 rounded-md">
                                <Menubar :model="items">

                                    <!-- Logo -->
                                    <template #start>
                                        <ApplicationMark class="block h-9 w-auto px-4 mr-4"/>
                                    </template>

                                    <!-- Navigation Links -->
                                    <template #item="{ item, props, hasSubmenu }">
                                        <Link
                                            class="flex px-2 py-2"
                                            v-bind="props"
                                            :href="item.url">
                                            <span :class="item.icon"/>
                                            <Button
                                                text
                                                severity="secondary"
                                                :label="item.label"/>
                                            <span v-if="hasSubmenu"
                                                  class="pi pi-fw pi-angle-down ml-2"/>
                                        </Link>
                                    </template>
                                    <template #end>

                                        <!-- Settings Dropdown -->
                                        <div class="hidden sm:flex sm:items-center px-4">
                                            <div class="relative">
                                                <Dropdown align="right"
                                                          width="48">
                                                    <template #trigger>
                                                        <button v-if="$page.props.jetstream.managesProfilePhotos"
                                                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                                            <img class="h-8 w-8 rounded-full object-cover"
                                                                 :src="$page.props.auth.user.profile_photo_url"
                                                                 :alt="$page.props.auth.user.name">
                                                        </button>

                                                        <span v-else
                                                              class="inline-flex rounded-md">
                                                        <button type="button"
                                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                            {{ $page.props.auth.user.name }}

                                                            <svg class="ms-2 -me-0.5 h-4 w-4"
                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                 fill="none"
                                                                 viewBox="0 0 24 24"
                                                                 stroke-width="1.5"
                                                                 stroke="currentColor">
                                                                <path stroke-linecap="round"
                                                                      stroke-linejoin="round"
                                                                      d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                                            </svg>
                                                        </button>
                                                        </span>
                                                    </template>

                                                    <template #content>
                                                        <!-- Account Management -->
                                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                                            Manage Account
                                                        </div>

                                                        <DropdownLink :href="route('profile.show')">
                                                            Profile
                                                        </DropdownLink>

                                                        <DropdownLink v-if="$page.props.jetstream.hasApiFeatures"
                                                                      :href="route('api-tokens.index')">
                                                            API Tokens
                                                        </DropdownLink>

                                                        <div class="border-t border-gray-200"/>

                                                        <!-- Authentication -->
                                                        <form @submit.prevent="logout">
                                                            <DropdownLink as="button">
                                                                Log Out
                                                            </DropdownLink>
                                                        </form>
                                                    </template>
                                                </Dropdown>
                                            </div>
                                        </div>

                                        <!-- Hamburger -->
                                        <div class="-me-2 flex items-center sm:hidden px-4">
                                            <!--                                            <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"-->
                                            <!--                                                    @click="showingNavigationDropdown = ! showingNavigationDropdown">-->
                                            <!--                                                <img class="h-10 w-10 rounded-full object-cover"-->
                                            <!--                                                     :src="$page.props.auth.user.profile_photo_url"-->
                                            <!--                                                     :alt="$page.props.auth.user.name">-->
                                            <!--                                            </button>-->
                                            <button v-if="$page.props.jetstream.managesProfilePhotos"
                                                    class="inline-flex items-center justify-center border-2 text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out rounded-full focus:border-gray-300"
                                                    @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                                <img class="h-8 w-8 rounded-full object-cover"
                                                     :src="$page.props.auth.user.profile_photo_url"
                                                     :alt="$page.props.auth.user.name">
                                            </button>
                                        </div>
                                    </template>
                                </Menubar>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}"
                     class="sm:hidden">

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div v-if="$page.props.jetstream.managesProfilePhotos"
                                 class="shrink-0 me-3">
                                <img class="h-10 w-10 rounded-full object-cover"
                                     :src="$page.props.auth.user.profile_photo_url"
                                     :alt="$page.props.auth.user.name">
                            </div>

                            <div>
                                <div class="font-medium text-base text-gray-800">
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show')"
                                               :active="route().current('profile.show')">
                                Profile
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures"
                                               :href="route('api-tokens.index')"
                                               :active="route().current('api-tokens.index')">
                                API Tokens
                            </ResponsiveNavLink>

                            <!-- Authentication -->
                            <form method="POST"
                                  @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    Log Out
                                </ResponsiveNavLink>
                            </form>

                            <!-- Team Management -->
                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                <div class="border-t border-gray-200"/>

                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Manage Team
                                </div>

                                <!-- Team Settings -->
                                <ResponsiveNavLink :href="route('teams.show', $page.props.auth.user.current_team)"
                                                   :active="route().current('teams.show')">
                                    Team Settings
                                </ResponsiveNavLink>

                                <ResponsiveNavLink v-if="$page.props.jetstream.canCreateTeams"
                                                   :href="route('teams.create')"
                                                   :active="route().current('teams.create')">
                                    Create New Team
                                </ResponsiveNavLink>

                                <!-- Team Switcher -->
                                <template v-if="$page.props.auth.user.all_teams.length > 1">
                                    <div class="border-t border-gray-200"/>

                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Switch Teams
                                    </div>

                                    <template v-for="team in $page.props.auth.user.all_teams"
                                              :key="team.id">
                                        <form @submit.prevent="switchToTeam(team)">
                                            <ResponsiveNavLink as="button">
                                                <div class="flex items-center">
                                                    <svg v-if="team.id == $page.props.auth.user.current_team_id"
                                                         class="me-2 h-5 w-5 text-green-400"
                                                         xmlns="http://www.w3.org/2000/svg"
                                                         fill="none"
                                                         viewBox="0 0 24 24"
                                                         stroke-width="1.5"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round"
                                                              stroke-linejoin="round"
                                                              d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <div>{{ team.name }}</div>
                                                </div>
                                            </ResponsiveNavLink>
                                        </form>
                                    </template>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header"
                    class="bg-surface-100 dark:bg-surface-900 shadow">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <slot name="header"/>
                </div>
            </header>
            <!-- Page Content -->
            <main>
                <slot/>
            </main>
        </div>
    </div>
</template>
