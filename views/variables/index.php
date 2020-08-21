<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Walter Template Engine</title>
<style>
    * {
        font-family: Arial, Helvetica, sans-serif;
    }
    body {
        text-align: center;
    }
    #container {
        margin-top: 20%;
        display: flex;
        flex-direction: column;
    }
    #voltar {
        position: absolute;
        top: 10px;
        left: 10px;
    }

    small {
        margin-top: 30px;
    }
</style>
</head>
<body>

    <div id="container">
        <h3>Filme: $movie</h3>
        <h3>Nome: $name</h3>
        <a id="voltar" href="/">Voltar</a>

        <small><a href="http://github.com/moisesduartem/walterphp">http://github.com/moisesduartem/walterphp</a> | $year - $fullName</small>
    </div>

</body>
</html>