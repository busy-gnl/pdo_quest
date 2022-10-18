<?php
require_once '_connec.php';

$pdo = new \PDO(DSN, USER, PASS);
$errors = [];
$data = array_map('trim', $_POST);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($data['firstname']) || empty($data['firstname']))
        echo $errors[] = "Le prénom est obligatoire. <br>";
    if (!isset($data['lastname']) || empty($data['lastname']))
        echo $errors[] = "Le nom est obligatoire. <br>";
    else if (empty($errors))
        echo "Bienvenue dans la bande";
    else
        echo "<p>Il y a des erreurs</p>";
    echo "<ul>";
    foreach ($errors as $error)
        echo "<li> $error </li> </ul>";

    $query2 = "INSERT INTO friend (firstname, lastname) VALUES (:firstame, :lastname);";
    $statement2 = $pdo->prepare($query2);
    $statement2->bindValue(':firstname', $data['firstname'], PDO::PARAM_STR);
    $statement2->bindValue(':lastname', $data['lastname'], PDO::PARAM_STR);

    $statement2->execute();

    header('Location: pdo.php');
}

// A exécuter afin d'afficher vos lignes déjà insérées dans la table friends
$query = "SELECT * FROM friend";
$statement2 = $pdo->query($query);
$friendsArray = $statement2->fetchAll(PDO::FETCH_ASSOC);



?>

<h2>Friends</h2>

<table>

    <thead>
        <th>Prénom</th>
        <th>Nom</th>
    </thead>
    <tbody>
        <?php
        foreach ($friendsArray as $friend) {

            echo "<tr>";
            echo '<td>' . $friend['firstname'] . '</td> ';
            echo '<td>' . $friend['lastname'] . '</td> ';
            echo "<tr/>";
        }
        ?>
    </tbody>

</table>

<form action="" method="post">
    <label for="firstname">Firstname</label>
    <input type="text" name="firstname">

    <label for="lastname">Lastname</label>
    <input type="text" name="lastname">
    <button type="submit">Send</button>


</form>