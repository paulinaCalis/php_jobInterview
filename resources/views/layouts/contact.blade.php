<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    @include('css.contactCSS')
</head>
<body id="app-layout">
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container" style="width:900px; margin:0 auto;">
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
   
            </div>
        </div>
    </nav>

	<div class="container" style="width:900px; margin:0 auto;">
        @include('partials.success')
        @include('partials.errors')

		@yield('content')
	</div>
    <!-- Delete modal -->
    @include('partials.deleteModal')

	<!-- JavaScripts -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

    <script type="text/javaScript">
        $(document).ready(function() {
            $("#table_phones").on("click", "td[headers='delete_number']", function() {
                var index = $(this).parent().index();

                document.getElementById("table_phones").deleteRow(index);
            });

            $("#btn_add_number").click(function() {
                var new_number = '<tr id="[]">'+
                                    '<td>'+
                                        '<input id="phone_id" type="hidden" name="phone_id[]" />' +
                                        '<input type="text" required name="number[]" id="number" class="form-control" placeholder="enter number">'+
                                    '</td>' +
                                    '<td><input type="text" required name="description[]" id="description" class="form-control" placeholder="description number"></td>' +
                                    '<td headers="delete_number"><span name="delete_number[]"><img src="/../images/remove.png" style="width:25px; height:25px;" /></span></td>' +
                                '</tr>';

                $("#table_phones").append(new_number);
            });
            
            //delete contact through modal delete
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
        });
    </script>
</body>
</html>