<!-- exemple de formulaire pour uploader un fichier -->

<form action="form-test.php" enctype="multipart/form-data" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="30000">
    <input type="file" name="picture">
    <button>Uploader</button>
</form>