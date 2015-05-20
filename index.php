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

//
// Server connection
//
$link = mysql_connect(DATABASE_SERVER, USER, PASSWORD)
or die("Impossible de se connecter : " . mysql_error());

echo 'Connexion au serveur ' . DATABASE_SERVER . ' OK<hr>';


// Database connection
$db_selected = mysql_select_db(DATABASE, $link);
if (!$db_selected) {
    die ('Impossible de sélectionner la base de données ' . DATABASE . ' : ' . mysql_error());
}
echo 'Connexion à la base ' . DATABASE . ' OK<hr>';

// source Table creation
$TABLE_COPY_NAME = TABLE . '_ANONYM';

// Check table
if(mysql_num_rows(mysql_query("SHOW TABLES LIKE '". $TABLE_COPY_NAME ."'"))==0) {


    $result = mysql_query('CREATE TABLE ' . $TABLE_COPY_NAME . ' LIKE ' . TABLE . ';');
    if (!$result) {
        die('Requête invalide : ' . mysql_error());
    }
    echo 'Création de ' . $TABLE_COPY_NAME . ' OK<br>';


// Duplicate datas
    $result = mysql_query('INSERT INTO ' . $TABLE_COPY_NAME . ' SELECT * FROM ' . TABLE . ';');
    if (!$result) {
        die('Requête invalide : ' . mysql_error());
    }
    echo 'Copie des données vers ' . $TABLE_COPY_NAME . ' OK<br>';

}
else
    echo 'La table ' . $TABLE_COPY_NAME . ' existe déjà : OK<br>';



//
// Anonymizer
//
echo "Anonymisation .";
$faker = Faker\Factory::create('fr_FR'); // create a French faker

$indexRow = 'codeUtilisateur';

$tableResult = mysql_query('SELECT ' . $indexRow . ' FROM ' . $TABLE_COPY_NAME . ';');
if (!$tableResult) {
    die('Requête invalide : ' . mysql_error());
}


while ($row = mysql_fetch_array($tableResult, MYSQL_ASSOC)) {

    $lastName = cleanString($faker->lastName);
    $firstName = cleanString($faker->firstName);

    $query = 'UPDATE ' . $TABLE_COPY_NAME . ' SET nom="' . $lastName . '", prenom="' . $firstName . '", ';

    // default email for every row
    if (DEFAULT_EMAIL != "")
        $query .= 'email="' . DEFAULT_EMAIL . '" ';
    else
        $query .= 'email="' . $firstName . '.' . $lastName . '@univ-evry.fr" ';


    $query .= 'WHERE ' . $indexRow . ' = ' . $row[$indexRow];


    echo ".";

    // Query exec
    $result = mysql_query($query);
    if (!$result) {
        die('Requête invalide : ' . mysql_error());
    }
}
echo " OK";

// remove é,à,..
function cleanString($str)
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