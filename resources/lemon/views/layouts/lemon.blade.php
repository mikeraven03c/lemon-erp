<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  @include('supports.header')
    <body>
    {{-- <div id="q-app" v-cloak> --}}
        <div id="q-app" v-cloak>
            <q-layout view="hHh lpR fFf">
                @include('components.qheader')
                @yield('content')
            </q-layout>
        </div>
        @include('supports.scripts')
        @yield('scripts')
    </body>
</html>
