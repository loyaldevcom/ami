<?php
require_once('includes/header.php');
?>

<div class="center">
    <h1>Administration</h1><br><br><br>
    <?php
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'add_article') {
            require_once("includes/database.php");
            if (isset($_POST['submit'])) {

                extract($_POST);

                // print_r($_FILES['fichier']);

                $content_dir = 'images/';

                $tmp_file = $_FILES['fichier']['tmp_name'];

                if (!is_uploaded_file($tmp_file)) {
                    exit('Vous avez oubliez votre image !');
                }

                $type_file = $_FILES['fichier']['type'];

                if (!strstr($type_file,'jpeg') && !strstr($type_file,'png')) {
                    exit("ce fichier n'est pas une image");
                }

                $name_file = time().'.jpg';
                
                if (!move_uploaded_file($tmp_file,$content_dir.$name_file)) {
                    exit('impossible de uploader le fichier');

                }

                $save_article = $db->prepare('INSERT INTO all_articles(titre,contenu,images_name,price) VALUES(?,?,?,?)');

                $save_article->execute(array($titre,$contenu,$name_file,$price));
                echo "Opération réussie";

            }
            ?>
            <h4>Ajouter un article</h4>
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="text" name="titre" placeholder="Titre de l'article" required="" class="form form-control">
                <input type="text" name="price" placeholder="Prix de l'article" required="" class="form form-control">
                <textarea name="contenu" placeholder="Description de l'article" class="form form-control"></textarea><br>
                <input type="file" name="fichier"><br><br>
                <input type="submit" name="submit" class="btn btn-light">
            </form>

            <?php
            
        }
    }

    ?>

</div>

<?php
require_once('includes/footer.php');
?>