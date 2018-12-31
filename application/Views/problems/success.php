<html>
<head>
        <title></title>
</head>
<body>
        <h1></h1>

        <h3>My Todo List</h3>

        <ul>
        <?php foreach ($query as $row):?>

                <li><?= $row ?></li>

        <?php endforeach;?>
        </ul>

</body>
</html>
