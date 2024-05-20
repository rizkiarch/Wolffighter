<!DOCTYPE html>
<html>
@include('layouts.partials.head')
  <body>
    <div id="q-app">
        <q-layout>
            @yield('content')
        </q-layout>
    </div>
    @include('layouts.partials.script')
</body>
</html>
