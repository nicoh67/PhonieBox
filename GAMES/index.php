<html>
<head>
    <style>
    body {
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
    }
    #container {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: stretch;
    }
    #folders {
        display: flex;
        width: 100%;
        border-bottom: 1px solid #000;
    }
    #folders a {
        padding: 10px 20px;
        text-decoration: none;
        background: #F8F8F8;
    }
    #folders a.active {
    }
    iframe {
        box-sizing: border-box;
        width: 100%;
        height: 100%;
        display: block;
        border: 0;
    }
    </style>

</head>
<body>

<div id=container>
    <div id=folders>
    <?php
    $folders = glob("./*", GLOB_ONLYDIR);
    foreach($folders as $folder) {
        $fold = basename($folder);
        echo "<a target=\"explorer\" href=\"explorer.php?folder=$fold\">$fold</a>";
    }
    ?>
    </div>
    <iframe name="explorer"></iframe>
</div>

</body>
</html>