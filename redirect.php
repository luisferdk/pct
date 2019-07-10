<?php
    if(isset($_POST['category']) && $_POST['category']!==null)
        header('Location: /excursions/'.$_POST['category']);
    else if(isset($_POST['tour']) && $_POST['tour']!==null)
        header('Location: /'.$_POST['tour']);
    else
        header('Location: /excursions/all-tours/');
?>