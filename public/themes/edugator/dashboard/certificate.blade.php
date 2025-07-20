<html>
    <head>
        <style type='text/css'>
            body, html {
                margin: 0;
                padding: 0;
            }
            body {
                color: black;
                display: table;
                font-family: Georgia, serif;
                font-size: 24px;
                text-align: center;
            }
            .container {
                border: 20px solid tan;
                width: 750px;
                height: 450px;
                display: table-cell;
                vertical-align: middle;
            }
            .logo {
                color: tan;
            }

            .marquee {
                color: tan;
                font-size: 48px;
                margin: 20px;
            }
            .courses {
                color: tan;
                font-size: 48px;
                margin: 20px;
            }
            .assignment {
                margin: 20px;
            }
            .person {
                border-bottom: 2px solid black;
                font-size: 32px;
                font-style: italic;
                margin: 20px auto;
                width: 400px;
            }
            .reason {
                margin: 20px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="logo">
                Fiqeeh
            </div>

            <div class="marquee">
                Certificate of Completion
            </div>
             <div class="courses">
                Courses
            </div>

            <div class="assignment">
                This certificate is presented to
            </div>

            <div class="person">
                {{$user->name}}
            </div>

            <div class="reason">
                Atas keberhasilan telah menyelesaikan materi<br>
                {{$course->title}}
            </div>
        </div>
    </body>
</html>