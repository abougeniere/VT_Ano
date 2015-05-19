<!--
        Anonymistaion de la base VT
-->
<?php

//Composer autoload
require __DIR__ . '/vendor/autoload.php';

// APP VARS
require "env.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo APPNAME; ?></title>



    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<?php

/*
// Server connection
$link = mysql_connect(DATABASE_SERVER, USER, PASSWORD)
or die("Impossible de se connecter : " . mysql_error());

echo 'Connexion au serveur ' . DATABASE_SERVER . ' OK<hr>';


// Database connection
$db_selected = mysql_select_db(DATABASE, $link);
if (!$db_selected) {
    die ('Impossible de sélectionner la base de données ' . DATABASE .' : ' . mysql_error());
}
echo 'Connexion à la base ' . DATABASE . ' OK<hr>';

// source Table creation
$TABLE_COPY_NAME = TABLE . '_' . date("dmY_His");
$result =  mysql_query('CREATE TABLE ' . $TABLE_COPY_NAME .' LIKE ' . TABLE . ';');
if (!$result) {
    die('Requête invalide : ' . mysql_error());
}
echo 'Création de ' . $TABLE_COPY_NAME . ' OK<br>';


//INSERT INTO table_destination SELECT * FROM table_source ;
$result =  mysql_query('INSERT INTO ' . $TABLE_COPY_NAME . ' SELECT * FROM ' . TABLE . ';');
if (!$result) {
    die('Requête invalide : ' . mysql_error());
}
echo 'Copie des données vers ' . $TABLE_COPY_NAME . ' OK<br>';


*/
$faker = Faker\Factory::create('fr_FR'); // create a French faker


for ($i = 0; $i < 10; $i++) {
    $lastName = Clean($faker->lastName);
    $firstName = Clean($faker->firstName);
    //$firstName = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $faker->firstName);

    $query = 'UPDATE ' . TABLE . ' SET nom=' . $lastName . ', prenom=' . $firstName . ', ';

    // default email for every rows
    if (defined(DEFAULT_EMAIL) && DEFAULT_EMAIL != "")
        $query .= 'email=' . DEFAULT_EMAIL . ' ';
    else
        $query .= 'email=' . $firstName . '.' . $lastName . '@univ-evry.fr ';

    echo $query;
}



// remove é,à,..
function Clean($str)
{
    return (str_replace(
        array('à', 'â', 'ä', 'á', 'ã', 'å', 'î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø', 'ù', 'û', 'ü', 'ú', 'é', 'è', 'ê', 'ë', 'ç', 'ÿ', 'ñ',
              'À', 'Â', 'Ä', 'Á', 'Ã', 'Å', 'Î', 'Ï', 'Ì', 'Í', 'Ô', 'Ö', 'Ò', 'Ó', 'Õ', 'Ø', 'Ù', 'Û', 'Ü', 'Ú', 'É', 'È', 'Ê', 'Ë', 'Ç', 'Ÿ', 'Ñ'),
        array('a', 'a', 'a', 'a', 'a', 'a', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'e', 'e', 'e', 'e', 'c', 'y', 'n',
              'A', 'A', 'A', 'A', 'A', 'A', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'E', 'E', 'E', 'E', 'C', 'Y', 'N'),
        $str));
}

?>
</body>