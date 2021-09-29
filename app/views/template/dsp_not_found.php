<?php //include '../global.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style type="text/css">
        body{
            background: #fff;
            font-family: monospace;
            color: #70869d;
            text-align: center;
        }
        .outer {
            display: table;
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
        }

        .middle {
            display: table-cell;
            vertical-align: middle;
        }
        div.denied{
            /*margin: 0;*/
            margin-left: auto;
            margin-right: auto;
            width: 400px;
        }
        .denied h2{
            font-size: 72px;
            margin: 0;
            line-height: 1.2;
            margin-bottom: 20px;
        }
        .denied	h5{
            font-size: 24px;
            margin: 0;
            line-height: 1;
        }
        .btn-back{
            padding: 10px 15px;
            text-decoration: none;
            background: #2a4057;
            color: #fff;
            border-radius: 5px;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 16px;
        }
        .text{
            margin-bottom: 50px;
        }
    </style>
</head>
<body>
<div class="outer">
    <div class="middle">
        <div class="denied">
            <div class="text">
                <h2>404</h2>
                <h5>Page Not Found</h5>
            </div>
            <a class="btn-back" href="<?= (isset($_public) ) ? $var['http'] : $var['app_url'] . '/'?>"><?= (isset($_public) ) ? 'Back to home' : 'Dashboard'  ?></a>
        </div>
    </div>
</div>
</body>
</html>