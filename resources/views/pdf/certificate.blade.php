<html>

<head>
    <meta http-equiv="Content-Type" content="charset=utf-8" />
    <meta charset="UTF-8">

    <style type="text/css">
        #cert-body {
            height: 100%;
            width: 100%;
        }

        .details {
            position: absolute;
            text-align: center;
            z-index: 2;
            top: 30%;
            left: 50%;
            transform: translateX(-50%)
        }

        .details h1 {
            font-size: 60px;
            font-weight: 500;
            color: #bf9135;
            white-space: nowrap
        }

        .details h4 {
            font-size: 24px;
            margin-top: 190px;
            color: #4f5356;
        }
    </style>
</head>

<body>
    <div id="cert-body">
        <img src="/storage/{{$path}}" alt=""
            style="position: absolute; z-index: 1;inset:0;margin:auto;height:100%;width:100%">
        <div class="details">
            <h1>{{ $full_name }}</h1>
            <h4>{{ $date }}</h4>
        </div>
    </div>
</body>

</html>
