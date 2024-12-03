<?php


// Test si on est dans une modification
$isUpdate = isset($_GET['action']) && $_GET['action'] === 'update' && isset($_GET['id']);

// Handlers Suppresion
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    echo 'Je supprime la tache ' . $id;
    $result = delete_task($id);
    if ($result === false) {
        echo 'La tâche n a pas été supprimer';
    }
}


// Handlers Modification et Ajout
if (isset($_POST['is_update'])) {
    if (isset($_POST['nom']) && isset($_POST['description']) && isset($_POST['echeance'])) {
        $id = $_GET['id'];

        update_task($id, $_POST['nom'], $_POST['description'], $_POST['echeance']);
    }
} else {
    if (isset($_POST['nom']) && isset($_POST['description']) && isset($_POST['echeance'])) {
        echo 'Ajout en cours';
        try {
            add_task($_POST['nom'], $_POST['description'], $_POST['echeance']);
            echo 'Tache ajouté';
        } catch (Exception $e) {
            echo 'Tache non ajouté';
        }
    }
}


// BDD
function create_bdd()
{

    $host = 'localhost';
    $dbname = 'td5_ex3';
    $user = 'root';
    $password = 'root';
    $pdo = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    return $pdo;
}

// ADD
function add_task($nom, $description, $echeance)
{

    $bdd = create_bdd();

    $nom = htmlspecialchars($nom);
    $description = htmlspecialchars($description);
    $echeance = htmlspecialchars($echeance);

    $echeance = DateTime::createFromFormat('Y-m-d', $echeance);
    $echeance = $echeance->getTimestamp();

    $sql = 'INSERT INTO task (nom,description,echeance) VALUES (?,?,?)';
    $req = $bdd->prepare($sql);
    $result = $req->execute(array($nom, $description, $echeance));
    return $result;
}

// Update
function update_task($id, $nom, $description, $echeance)
{

    $bdd = create_bdd();

    $nom = htmlspecialchars($nom);
    $description = htmlspecialchars($description);
    $echeance = htmlspecialchars($echeance);

    $echeance = DateTime::createFromFormat('Y-m-d', $echeance);
    $echeance = $echeance->getTimestamp();

    $sql = 'UPDATE `task` SET `nom` = ?, `description` = ?, `echeance` = ? WHERE `task`.`id` = ' . $id;
    $req = $bdd->prepare($sql);
    $result = $req->execute(array($nom, $description, $echeance));
    return $result;
}

// Get all
function get_tasks()
{

    $bdd = create_bdd();
    $tasks = array();


    $query = 'SELECT * FROM task';
    $req = $bdd->query($query);
    $tasks = $req->fetchAll(PDO::FETCH_ASSOC);

    return $tasks;
}

// Get single
function get_task($id)
{

    $bdd = create_bdd();


    $query = 'SELECT * FROM task WHERE id =' . $id;
    $req = $bdd->query($query);
    $task = $req->fetch(PDO::FETCH_ASSOC);

    return $task;
}

// Delete
function delete_task($id)
{
    $bdd = create_bdd();
    $id = (int) $id;
    $sql = 'DELETE FROM `task` WHERE `task`.`id` = ' . $id;
    $req = $bdd->prepare($sql);
    $result = $req->execute();
    return $result;
}

// Utils

function timestamp_to_date($timestamp)
{
    $date = date('Y-m-d', $timestamp);
    return $date;
}

// View

$tasks = get_tasks();


?>
<?php if (!$isUpdate): ?>
    <form method="post">
        <div>
            <input type="text" name="nom" placeholder="Nom" />
        </div>
        <div>
            <input type="text" name="description" placeholder="Description" />
        </div>
        <div>
            <input type="date" name="echeance" placeholder="Echeance" />
        </div>
        <div>
            <button type="submit">Ajouter</button>
        </div>
    </form>
<?php endif; ?>
<?php if ($isUpdate):
    $task = get_task($_GET['id']);
?>
    <form method="post">
        <div>
            <input type="text" name="nom" placeholder="Nom" value="<?php echo $task['nom']; ?>" />
        </div>
        <div>
            <input type="text" name="description" placeholder="Description" value="<?php echo $task['description']; ?>" />
        </div>
        <div>
            <input type="date" name="echeance" placeholder="Echeance" value="<?php echo timestamp_to_date($task['echeance']); ?>" />
        </div>
        <div>
            <input type="hidden" name="is_update" value="true" />
            <button type="submit">Modifier</button>
        </div>
    </form>
<?php endif; ?>

<table>
    <tr>
        <th>Nom</th>
        <th>Description</th>
        <th>Echeance</th>
        <th>Modification</th>
        <th>Supprimer</th>
    </tr>
    <?php foreach ($tasks as $task): ?>
        <tr>
            <td>
                <?php echo $task['nom']; ?>
            </td>
            <td>
                <?php echo $task['description']; ?>
            </td>
            <td>
                <?php echo timestamp_to_date($task['echeance']); ?>
            </td>
            <td>
                <a href="?id=<?php echo $task['id']; ?>&action=update">Modifier</a>
            </td>
            <td>
                <a href="?id=<?php echo $task['id']; ?>&action=delete">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>