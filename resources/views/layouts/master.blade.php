<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    
    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    @include('css.masterCSS')
</head>
<body id="app-layout">
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container" style="width:900px; margin:0 auto;">
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/') }}">All contacts</a></li>
					<li><a href="{{ url('/favorite') }}">My favorites</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
					<li><a href="{{ url('/create') }}"><img src="/../images/addNew.png" title="Add new contact" style="width:25px; height:25px;" /></a></li>
                </ul>
            </div>
        </div>
    </nav>

	<div class="container" style="width:900px; margin:0 auto;">
        @include('partials.success')
        @include('partials.errors')
        
        <div id="wrap">
            <form action="" autocomplete="on">
                <input id="contact_search" name="contact_search" class="form-control" type="text" placeholder="Who are you looking for?">
                <input id="search_submit" value="Rechercher" type="submit">
            </form>
        </div>
        <br />
        <br />
        
        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th style="width:70%">full name</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @yield('content')
            </tbody>
        </table>
	</div>
    <!-- Delete modal -->
    @include('partials.deleteModal')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $("#contact_search").keyup(function() {
                var searchName = $(this).val().toLowerCase();

                $('tbody tr').each(function(){
                    var lineName = $(this).text().toLowerCase();
                    if(lineName.indexOf(searchName) === -1){
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });
            
            $('.remove-contact').click(function() {
                var full_name = $(this).attr('data-full_name');
                var contact_id = $(this).attr('data-contact_id');
                var url = $(this).attr('data-url');
                
                $('.remove-contact-model').attr('action', url);
                $('body').find('.delete_full_name').text(full_name);
                $('body').find('.remove-contact-model').append('{{ csrf_field() }}');
                $('body').find('.remove-contact-model').append('<input name="_method" type="hidden" value="DELETE">');
                $('body').find('.remove-contact-model').append('<input name="contact_id" type="hidden" value="'+ contact_id +'">');
            });

            $('.remove-data-from-delete-form').click(function() {
                $('body').find('.remove-contact-model').find( "input" ).remove();
            });                

            $(".favorite").click(function() {
                var contact_id = $(this).attr('data-contact_id');
                var favorite = 'no';
                if( $(this).attr('data-favorite') == 'no') {
                    favorite = 'yes';
                }

                $.ajax({
                    method: "POST",
                    url: "/changeFavorite",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        contact_id: contact_id,
                        favorite: favorite
                    }
                }).done(function(){
                    window.location.reload();
                });
            });       
        });
    </script>
</body>
</html>
