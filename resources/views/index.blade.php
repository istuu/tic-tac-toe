<!doctype html>
<html lang="en" class="h-100">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta content="{{ csrf_token() }}=" name="csrf-token" />
        <title>Tic Tac Toe</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}">
        <style>
           
        </style>
    </head>
    <body class="d-flex flex-column h-100">
        <!-- Begin page content -->
        <main role="main" class="flex-shrink-0">
            <div class="container">
                <h1 class="mt-5">Tic Tac Toe</h1>
                <p class="lead">Classic game made with PHP Laravel, JQuery and Bootstrap! .</p>
                <div class="col-md-12" >
                    <form class="box-form">
                        {!! csrf_field() !!}
                        <div class="content-board">
                            @include('board')
                        </div>
                    </form>
                </div>
                <br/>
                <a class="btn btn-info btn-lg text-white" href="{{ url('') }}"> Restart</a>           
            </div>
        </main>
       
        <footer class="footer mt-auto py-3">
            <div class="container">
                <p class="text-muted">By Danang Istoe Nugroho.</p>
            </div>
        </footer>

        <div id="modalGameOver" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Game Over!</h3>
                    </div>
                    <div class="modal-body">
                        <h4 id="message"></h4>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-info btn-lg text-white" href="{{ url('') }}"> Restart</a>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="{{ asset('/js/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/app.js') }}"></script>
        <script>
            function actionBoxClick(box_number)
            {
                var box = $("#box"+box_number);
                box.children("span").text('X');
                box.children("input").val('X');

                ajaxBoxSubmit();
            }

            function ajaxBoxSubmit()
            {
                var form   = $(".box-form");
                $.ajax({
                    url: "{{ url('/ajax/submitBox/') }}",
                    cache: false,
                    method:'POST',
                    data: form.serialize(),
                    dataType: 'JSON',
                    success: function(data) {
                        $(".content-board").html(data['board']);

                        var status = data['status'];
                        if(status['gameOver'] == true)
                        {
                            if(status['tie'] == true)
                            {
                                $("#message").text("It's a tie!");
                            }
                            else
                            {
                                if(status['winner'] == 'AI')
                                {
                                    $("#message").text("Sorry, you lose!");
                                }
                                else
                                {
                                    $("#message").text("Congratulation, you win!");
                                }
                            }
                            
                            $('#modalGameOver').modal({backdrop: 'static', keyboard: false}) 
                        }
                    },
                });
            }
        </script>
    </body>
</html>