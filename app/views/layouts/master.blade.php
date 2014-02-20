<html>
    <body>
        @section('sidebar')
        	{{ stylesheet_link_tag() }}
        	{{ javascript_include_tag() }}
            This is the master sidebar.
        @show

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>